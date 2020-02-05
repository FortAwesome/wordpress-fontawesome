<?php
namespace FortAwesome;

use \WP_REST_Controller, \WP_REST_Response, \WP_Error, \Error, \Exception;

/**
 * Module for this plugin's Conflict Detection controller
 *
 * @noinspection PhpIncludeInspection
 */

// phpcs:ignore Generic.Commenting.DocComment.MissingShort
/**
 * @ignore
 */

if ( ! class_exists( 'FontAwesome_Conflict_Detection_Controller' ) ) :

	/**
	 * Controller class for REST endpoint
	 */
	class FontAwesome_Conflict_Detection_Controller extends WP_REST_Controller {

		// phpcs:ignore Generic.Commenting.DocComment.MissingShort
		/**
		 * @ignore
		 */
		private $plugin_slug = null;

		// phpcs:ignore Generic.Commenting.DocComment.MissingShort
		/**
		 * @ignore
		 */
		protected $namespace = null;

		// phpcs:ignore Generic.Commenting.DocComment.MissingShort
		/**
		 * @ignore
		 */
		protected $valid_attrs = ['type', 'technology', 'href', 'src', 'innerText', 'tagName'];

		// phpcs:ignore Generic.Commenting.DocComment.MissingShort
		/**
		 * @ignore
		 */
		public function __construct( $plugin_slug, $namespace ) {
			$this->plugin_slug = $plugin_slug;
			$this->namespace   = $namespace;
		}

		// phpcs:ignore Generic.Commenting.DocComment.MissingShort
		/**
		 * @ignore
		 */
		public function register_routes() {
			$route_base = 'conflict-detection';

			register_rest_route(
				$this->namespace,
				'/' . $route_base . '/until',
				array(
					array(
						'methods'             => 'PUT',
						'callback'            => array( $this, 'detect_conflicts_until' ),
						'permission_callback' => function() {
							return current_user_can( 'manage_options' ); },
						'args'                => array(),
					),
				)
			);

			register_rest_route(
				$this->namespace,
				'/' . $route_base . '/conflicts',
				array(
					array(
						'methods'             => 'POST',
						'callback'            => array( $this, 'report_conflicts' ),
						'permission_callback' => function() {
							return current_user_can( 'manage_options' ); },
						'args'                => array(),
					),
				)
			);

			register_rest_route(
				$this->namespace,
				'/' . $route_base . '/conflicts',
				array(
					array(
						'methods'             => 'DELETE',
						'callback'            => array( $this, 'delete_conflicts' ),
						'permission_callback' => function() {
							return current_user_can( 'manage_options' ); },
						'args'                => array(),
					),
				)
			);

			/**
			 * The given blocklist, an array of md5s, will become the new blocklist,
			 * for each md5 in the given array that already exists as a key in
			 * the unregistered_clients array.
			 */
			register_rest_route(
				$this->namespace,
				'/' . $route_base . '/conflicts/blocklist',
				array(
					array(
						'methods'             => 'PUT',
						'callback'            => array( $this, 'update_blocklist' ),
						'permission_callback' => function() {
							return current_user_can( 'manage_options' ); },
						'args'                => array(),
					),
				)
			);
		}

		/**
		 * Report conflicts. Adds and/or updates unregistered_clients
		 *
		 * The response will have an HTTP 204 status if the request results in no changes.
		 * If changes are made, the response will have an HTTP 200 status, and
		 * the response body will include just the new status of the
		 * unregistered_clients (not the entire conflict-detection option data).
		 *
		 * If the plugin is not currently in conflict detection mode, this
		 * returns an HTTP 404 status.
		 *
		 * @param WP_REST_Request $request the request.
		 * @return WP_Error|WP_REST_Response
		 */
		public function report_conflicts( $request ) {
			try {
				if ( ! fa()->detecting_conflicts() ) {
					return new WP_REST_Response( null, 404 );
				}

				$item = $this->prepare_unregistered_clients_for_database( $request );

				if ( is_null( $item ) ) {
					return new WP_Error(
						'fontawesome_unregistered_clients_schema',
						null,
						array( 'status' => 400 )
					);
				}

				$prev_option = get_option( FontAwesome::CONFLICT_DETECTION_OPTIONS_KEY );

				$prev_option_unregistered_clients = (
					isset( $prev_option['unregistered_clients'] )
					&& is_array( $prev_option['unregistered_clients'] )
				)
					? $prev_option['unregistered_clients']
					: array();

				$new_option_unregistered_clients = array_merge(
						$prev_option_unregistered_clients,
						$item
				);

				if( $this->unregistered_clients_array_has_changes( $prev_option_unregistered_clients, $new_option_unregistered_clients ) ) {
					// Update only the unregistered_clients key, leaving any other keys unchanged.
					$new_option_value = array_merge(
						$prev_option,
						array(
							'unregistered_clients' => $new_option_unregistered_clients
						)
					);

					if ( update_option( FontAwesome::CONFLICT_DETECTION_OPTIONS_KEY, $new_option_value ) ) {
						return new WP_REST_Response( $new_option_unregistered_clients, 200 );
					} else {
						return new WP_Error(
							'fontawesome_unregistered_clients_update',
							array( 'status' => 400 )
						);
					}
				} else {
					// No change.
					return new WP_REST_Response( null, 204 );
				}
			} catch ( Exception $e ) {
				// TODO: distinguish between problems that happen with the Font Awesome plugin versus those that happen in client plugins.
				return new WP_Error( 'caught_exception', 'Whoops, there was a critical exception with Font Awesome.', array( 'status' => 500 ) );
			} catch ( Error $error ) {
				return new WP_Error( 'caught_error', 'Whoops, there was a critical error with Font Awesome.', array( 'status' => 500 ) );
			}
		}

		/**
		 * Reads a json body of the given Request, validates it, and turns it
		 * into a valid value for the unregistered_clients key of the conflict detection
		 * option.
		 *
		 * @internal
		 * @ignore
		 */
		protected function prepare_unregistered_clients_for_database( $request ) {
			$body = $request->get_json_params();

			if( ! \is_array( $body ) || count( $body ) === 0 ) {
				return null;
			}

			$validated = array();

			foreach( $body as $md5 => $attrs) {
				if(! is_string( $md5 ) || ! strlen( $md5 ) === 32 ) {
					return null;
				}

				if(! is_array( $attrs ) ) {
					return null;
				}

				$validated[$md5] = array();

				foreach( $attrs as $key => $value) {
					if( in_array( $key, $this->valid_attrs, true ) ) {
						$validated[$md5][$key] = $value;
					}
				}
			}

			return $validated;
    }
    
	protected function unregistered_clients_array_has_changes($old, $new) {
		if( ! is_array( $old ) ) {
 			return TRUE;
		}

		if( count( array_diff_key( $old, $new ) ) > 0  || count( array_diff_key( $new, $old ) ) > 0 ) {
			return TRUE;
		} else {
 			foreach( $old as $key => $value )  {
				if( count( array_diff_assoc( $old[$key], $new[$key] ) ) > 0 ) {
					return TRUE;
				}
			}
			return FALSE;
		}
	}
}

endif; // end class_exists.

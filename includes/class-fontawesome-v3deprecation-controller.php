<?php
namespace FortAwesome;

use \WP_REST_Controller, \WP_REST_Response, \WP_Error, \Error, \Exception;

/**
 * Module for this plugin's V3 Deprecation REST API controller
 *
 * @noinspection PhpIncludeInspection
 */

// phpcs:ignore Generic.Commenting.DocComment.MissingShort
/**
 * @ignore
 */

if ( ! class_exists( 'FontAwesome_V3Deprecation_Controller' ) ) :

	/**
	 * Controller class for REST endpoint
	 */
	class FontAwesome_V3Deprecation_Controller extends WP_REST_Controller {

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
		public function __construct( $plugin_slug, $namespace ) {
			$this->plugin_slug = $plugin_slug;
			$this->namespace   = $namespace;
		}

		// phpcs:ignore Generic.Commenting.DocComment.MissingShort
		/**
		 * @ignore
		 */
		public function register_routes() {
			$route_base = 'v3deprecation';

			register_rest_route(
				$this->namespace,
				'/' . $route_base,
				array(
					array(
						'methods'             => 'GET',
						'callback'            => array( $this, 'get_item' ),
						'permission_callback' => function() {
							return current_user_can( 'manage_options' ); },
						'args'                => array(),
					),
					array(
						'methods'             => 'PUT',
						'callback'            => array( $this, 'update_item' ),
						'permission_callback' => function() {
							return current_user_can( 'manage_options' ); },
						'args'                => array(),
					),
				)
			);
		}

		// phpcs:ignore Generic.Commenting.DocComment.MissingShort
		/**
		 * @ignore
		 */
		protected function build_item( $fa ) {
			return array(
				'v3DeprecationWarning' => $fa->get_v3deprecation_warning_data(),
			);
		}

		/**
		 * Get the deprecation data, a singleton resource.
		 *
		 * @param WP_REST_Request $request Full data about the request.
		 * @return WP_Error|WP_REST_Response
		 */
		public function get_item( $request ) {
			// TODO: consider alternatives to using ini_set() to ensure that display_errors is disabled.
			// Without this, when a client plugin of Font Awesome throws an error (like our plugin-epsilon
			// in this repo), instead of this REST controller returning an HTTP status of 500, indicating
			// the server error, it sends back a status of 200, setting the data property in the response
			// object equal to an HTML document that describes the error. This confuses the client.
			// Ideally, we'd be able to detect which plugin results in such an error by catching it and then
			// reporting to the client which plugin caused the error. But at a minimum, we need to make sure
			// that we return 500 instead of 200 in these cases.
			// phpcs:disable
			ini_set( 'display_errors', 0 );
			// phpcs:enable

			try {
				$fa = fa();

				$data = $this->build_item( $fa );

				return new WP_REST_Response( $data, 200 );
			} catch ( Exception $e ) {
				return new WP_Error(
					'cant_fetch',
					$e->getMessage(),
					array(
						'status' => 500,
						'trace'  => $e->getTraceAsString(),
					)
				);
			}
		}

		/**
		 * Update the singleton resource.
		 *
		 * @param WP_REST_Request $request Full data about the request.
		 * @return WP_Error|WP_REST_Response
		 */
		public function update_item( $request ) {
			// phpcs:disable
			ini_set( 'display_errors', 0 );
			// phpcs:enable

			try {
				$fa = fa();

				$item = $this->prepare_item_for_database( $request );

				if ( isset( $item['snooze'] ) && $item['snooze'] ) {
					$fa->snooze_v3deprecation_warning();
				}

				$return_data = $this->build_item( $fa );

				return new WP_REST_Response( $return_data, 200 );
			} catch ( Exception $e ) {
				return new WP_Error(
					'cant_update',
					$e->getMessage(),
					array(
						'status' => 500,
						'trace'  => $e->getTraceAsString(),
					)
				);
			}
		}

		// phpcs:ignore Generic.Commenting.DocComment.MissingShort
		/**
		 * @ignore
		 */
		protected function prepare_item_for_database( $request ) {
			$body = $request->get_json_params();
			return array_merge( array(), $body );
		}
	}

endif; // end class_exists.

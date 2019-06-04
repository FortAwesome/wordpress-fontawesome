<?php
namespace FortAwesome;

use \WP_REST_Controller, \WP_REST_Response, \WP_Error, \Error, \Exception;

/**
 * Module for this plugin's Conflict Detection Controller controller
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
				'/' . $route_base,
				array(
					array(
						'methods'             => 'POST',
						'callback'            => array( $this, 'check_conflicts' ),
						'permission_callback' => function() {
							return current_user_can( 'manage_options' ); },
						'args'                => array(),
					),
				)
			);
		}

		/**
		 * Get conflicts.
		 *
		 * @param WP_REST_Request $request Full data about the request.
		 * @return WP_Error|WP_REST_Response
		 */
		public function check_conflicts( $request ) {
			try {
				fa()->gather_preferences();

				$conflicts = fa()->conflicts_by_option( $request->get_json_params() );

				return new WP_REST_Response( $conflicts, 200 );
			} catch ( Exception $e ) {
				// TODO: distinguish between problems that happen with the Font Awesome plugin versus those that happen in client plugins.
				return new WP_Error( 'cant-fetch', 'Whoops, there was a critical exception with Font Awesome.', array( 'status' => 500 ) );
			} catch ( Error $error ) {
				return new WP_Error( 'cant-fetch', 'Whoops, there was a critical error with Font Awesome.', array( 'status' => 500 ) );
			}
		}
	}

endif; // end class_exists.

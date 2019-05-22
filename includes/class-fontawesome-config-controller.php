<?php
namespace FortAwesome;

require_once trailingslashit( FONTAWESOME_DIR_PATH ) . 'includes/class-fontawesome-configurationexception.php';

use \WP_REST_Controller, \WP_REST_Response, \WP_Error, \Exception, \ReflectionMethod;

/**
 * Module for this plugin's Configuration REST API controller
 *
 * @noinspection PhpIncludeInspection
 */

// phpcs:ignore Generic.Commenting.DocComment.MissingShort
/**
 * @ignore
 */

if ( ! class_exists( 'FortAwesome\FontAwesome_Config_Controller' ) ) :

	/**
	 * Controller class for REST endpoint
	 */
	class FontAwesome_Config_Controller extends WP_REST_Controller {

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
			$route_base = 'config';

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
			/**
			 * Calling wp_enqueue_scripts() is required to trigger the 'wp_enqueue_scripts' action that is the
			 * conventional time in the WordPress lifecycle when plugins or themes would enqueue scripts or styles.
			 * We also have to explicitly run the detection function.
			 * Note that this can only possibly detect those clients who enqueue their styles or scripts within the context
			 * of the controller action that invokes this function.
			 * It's possible than some unregistered client enqueues a style or script in some other circumstance. We
			 * would not detect that here, but since _removal_ of unregistered clients would happen on any page load,
			 * it would still be removed. So, in that case, you'd have an unregistered client that this plugin removes
			 * at the right time, but which does not get reported here. If we wanted to be more sophisticated about
			 * all of this, we'd have to come up with a way to be more comprehensive about detection, such as
			 * caching in a transient any unregistered clients on any page load. Then, FontAwesome::unregistered_clients()
			 * could return that--what may have been detected across any number of page loads--instead of only that
			 * which is detected on the same page load for which FontAwesome::unregistered_clients() is queried.
			 */
			ob_start();
			wp_enqueue_scripts();
			$fa->detect_unregistered_clients();
			ob_end_clean();

			return array(
				'options'               => $fa->options(),
				'clientPreferences'     => $fa->client_preferences(),
				'conflicts'             => $fa->conflicts(),
				'pluginVersionWarnings' => $fa->get_plugin_version_warnings(),
				'pluginVersion'         => FontAwesome::PLUGIN_VERSION,
				'unregisteredClients'   => $fa->unregistered_clients(),
				'releaseProviderStatus' => $this->release_provider()->get_status(),
				'releases'              => array(
					'available'        => $fa->get_available_versions(),
					'latest_version'   => $fa->get_latest_version(),
					'previous_version' => $fa->get_previous_version(),
				),
			);
		}

		/**
		 * Get the config, a singleton resource.
		 *
		 * @param WP_REST_Request $request Full data about the request.
		 * @return WP_Error|WP_REST_Response
		 */
		public function get_item( $request ) {
			try {
				$fa = fa();

				$this->release_provider()->load_releases();

				$fa->gather_preferences();

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
			try {
				$item = $this->prepare_item_for_database( $request );

				$result = update_option(
					FontAwesome::OPTIONS_KEY,
					array_merge(
						FontAwesome::DEFAULT_USER_OPTIONS,
						$item['options']
					)
				);

				if ( $result ) {
					$return_data = $this->build_item( fa() );
					return new WP_REST_Response( $return_data, 200 );
				} else {
					return new WP_Error(
						'cant_update',
						'Whoops, we could not save your options. Please try again.',
						array( 'status' => 403 )
					);
				}
			} catch ( FontAwesome_ConfigurationException $e ) {
				return new WP_Error( 'cant_update', $e->getMessage(), array( 'status' => 400 ) );
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

		// phpcs:ignore Generic.Commenting.DocComment.MissingShort
		/**
		 * Allows a test subclass to mock the release provider.
		 *
		 * @ignore
		 */
		protected function release_provider() {
			return fa_release_provider();
		}
	}

endif; // end class_exists.

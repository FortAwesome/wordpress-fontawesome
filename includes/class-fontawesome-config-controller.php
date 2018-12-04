<?php
/**
 * Module for this plugin's REST API controller
 *
 * @noinspection PhpIncludeInspection
 */

// phpcs:ignore Generic.Commenting.DocComment.MissingShort
/**
 * @ignore
 */

if ( ! class_exists( 'FontAwesome_Config_Controller' ) ) :

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
			$options          = $fa->options();
			$locked_load_spec = isset( $options['lockedLoadSpec'] ) ? $options['lockedLoadSpec'] : false;

			return array(
				'adminClientInternal'   => FontAwesome::ADMIN_USER_CLIENT_NAME_INTERNAL,
				'adminClientExternal'   => FontAwesome::ADMIN_USER_CLIENT_NAME_EXTERNAL,
				'options'               => $fa->options(),
				'clientRequirements'    => $fa->requirements(),
				'conflicts'             => $fa->conflicts(),
				'pluginVersionWarnings' => $fa->get_plugin_version_warnings(),
				'pluginVersion'         => FontAwesome::PLUGIN_VERSION,
				'currentLoadSpec'       => $fa->load_spec(),
				'currentLoadSpecLocked' => $locked_load_spec && $fa->load_spec() === $locked_load_spec,
				'unregisteredClients'   => $fa->unregistered_clients(),
				'releases'              => array(
					'available'        => $fa->get_available_versions(),
					'latest_version'   => $fa->get_latest_version(),
					'latest_semver'    => $fa->get_latest_semver(),
					'previous_version' => $fa->get_previous_version(),
					'previous_semver'  => $fa->get_previous_semver(),
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
			// TODO: consider alternatives to using ini_set() to ensure that display_errors is disabled.
			// Without this, when a client plugin of Font Awesome throws an error (like our plugin-epsilon
			// in this repo), instead of this REST controller returning an HTTP status of 500, indicating
			// the server error, it sends back a status of 200, setting the data property in the response
			// object equal to an HTML document that describes the error. This confuses the client.
			// Ideally, we'd be able to detect which plugin results in such an error by catching it and then
			// reporting to the client which plugin caused the error. But at a minimum, we need to make sure
			// that we return 500 instead of 200 in these cases.
			// phpcs:ignore WordPress.PHP.DiscouragedPHPFunctions.runtime_configuration_ini_set
			ini_set( 'display_errors', 0 );

			try {
				$fa = fa();

				// Make sure our releases metadata is fresh.
				$load_releases = new ReflectionMethod( 'FontAwesome_Release_Provider', 'load_releases' );
				$load_releases->setAccessible( true );
				$load_releases->invoke( fa_release_provider() );

				$fa_load = new ReflectionMethod( 'FontAwesome', 'load' );
				$fa_load->setAccessible( true );
				$fa_load->invoke( $fa );

				$data = $this->build_item( $fa );

				return new WP_REST_Response( $data, 200 );
			} catch ( Exception $e ) {
				// TODO: distinguish between problems that happen with the Font Awesome plugin versus those that happen in client plugins.
				return new WP_Error( 'cant-fetch', 'Whoops, there was a critical exception trying to load Font Awesome.', array( 'status' => 500 ) );
			} catch ( Error $error ) {
				return new WP_Error( 'cant-fetch', 'Whoops, there was a critical error trying to load Font Awesome.', array( 'status' => 500 ) );
			}
		}

		/**
		 * Update the singleton resource.
		 *
		 * @param WP_REST_Request $request Full data about the request.
		 * @return WP_Error|WP_REST_Response
		 */
		public function update_item( $request ) {
			// phpcs:ignore WordPress.PHP.DiscouragedPHPFunctions.runtime_configuration_ini_set
			ini_set( 'display_errors', 0 );

			try {
				$item = $this->prepare_item_for_database( $request );
				$item['options']['adminClientLoadSpec']['clientVersion'] = time();

				// Rather than directly updating the options in the db, we'll run the new adminClientSpec through the
				// normal load process. If it satisfies all constraints, the new adminClientLoadSpec spec will be
				// updated with the lockedLoadSpec. Otherwise, no db update will occur and we'll be able to report
				// the error condition to the admin UI.
				// We reset to avoid duplication client registrations.
				$fa      = fa();
				$load_fa = new ReflectionMethod( 'FontAwesome', 'load' );
				$load_fa->setAccessible( true );
				$new_load_spec = $load_fa->invoke( $fa, $item['options'] );

				$return_data = $this->build_item( $fa );

				if ( $new_load_spec ) {
					return new WP_REST_Response( $return_data, 200 );
				} else {
					return new WP_Error(
						'cant_update',
						'Whoops, those options would have resulted in a conflict so we did not save them.',
						array( 'status' => 403 )
					);
				}
			} catch ( Exception $e ) {
				return new WP_Error( 'cant_update', 'Whoops, the attempt to update options failed.', array( 'status' => 500 ) );
			} catch ( Error $error ) {
				return new WP_Error( 'cant_update', 'Whoops, the attempt to update options failed.', array( 'status' => 500 ) );
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

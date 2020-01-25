<?php
/**
 * This module is not considered part of the public API, only internal.
 * Any data or functionality that it produces should be exported by the
 * main FontAwesome class and the API documented and semantically versioned there.
 */
namespace FortAwesome;

require_once trailingslashit( FONTAWESOME_DIR_PATH ) . 'includes/class-fontawesome-configurationexception.php';
require_once trailingslashit( FONTAWESOME_DIR_PATH ) . 'includes/class-fontawesome-api-settings.php';

use \WP_REST_Controller, \WP_REST_Response, \WP_Error, \Exception;

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
				'options'   => $fa->options(),
				'conflicts' => $fa->conflicts_by_option(),
			);
		}

		/**
		 * Update the singleton resource.
		 *
		 * @param WP_REST_Request $request Full data about the request.
		 * @return WP_Error|WP_REST_Response
		 */
		public function update_item( $request ) {
			try {
				$body = $request->get_json_params();

				$api_token = isset($body['options']) ? $body['options']['apiToken'] : null;

				if ( is_string( $api_token ) ) {
					$api_settings = FontAwesome_API_Settings::reset();
					$api_settings->set_api_token( $api_token );
					$result = $api_settings->request_access_token();

					if ( $result instanceof WP_Error ) {
						return $result;
					}
				}

				$db_item = $this->prepare_item_for_database( $body, boolval( $api_token ) );

				$result = update_option(
					FontAwesome::OPTIONS_KEY,
					$db_item
				);

				if ( $result ) {
					fa()->gather_preferences();
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

		/**
		 * Filters the incoming data, determines what should actually
		 * be stored in the database, and ensures that it's valid.
		 *
		 * @internal
		 * @ignore
		 * @param array $body the request body as returned by get_json_params()
		 * @throws FontAwesome_ConfigurationException when options indicate a non-kits
		 *   CDN configuration, but no valid version is present.
		 */
		protected function prepare_item_for_database( $body ) {
			// start with a copy of the defaults and just override them indivually
			$item = array_merge( array(), FontAwesome::DEFAULT_USER_OPTIONS );
			$given_options = isset( $body['options'] ) ? $body['options'] : [];

			// Most of the options are handled in the same way:
			// if they are provided at all, we just use that to override the default
			if ( isset( $given_options['usePro'] ) ) {
				$item['usePro'] = $given_options['usePro'];
			}
			if ( isset( $given_options['v4compat'] ) ) {
				$item['v4compat'] = $given_options['v4compat'];
			}
			if ( isset( $given_options['technology'] ) ) {
				$item['technology'] = $given_options['technology'];
			}
			if ( isset( $given_options['svgPseudoElements'] ) ) {
				$item['svgPseudoElements'] = $given_options['svgPseudoElements'];
			}
			if ( isset( $given_options['detectConflictsUntil'] ) ) {
				$item['detectConflictsUntil'] = $given_options['detectConflictsUntil'];
			}
			if ( isset( $given_options['kitToken'] ) ) {
				$item['kitToken'] = $given_options['kitToken'];
			}
			if ( isset( $given_options['usePro'] ) ) {
				$item['usePro'] = $given_options['usePro'];
			}
			if ( isset( $given_options['blocklist'] ) ) {
				$item['blocklist'] = $given_options['blocklist'];
			}

			// The apiToken is handled specially.
			// We only store a boolean value indicating whether and apiToken
			// has been stored. It's the responsibility of the calling code
			// to store the actual API Token appropriately.
			if ( isset( $given_options['apiToken'] ) ) {
				$item['apiToken'] = boolval( $given_options['apiToken'] );
			}

			// The version is handle specially.
			// 1. An valid version number but be used, if any version is present at all.
			//    The string 'latest' is not valid here. It's need to be something like 5.12.0.
			//
			// 2. If the options are configured to use a kit, then version is not
			//    required, because the version comes from the kit itself. Otherwise,
			//    we must have a version. It's configured to use a kit if the kitToken
			//    is some string value.
			//
			// 3. To ensure that switching back and forth between kits and non-kits
			//    configurations is smooth, if we do switch a kits config here, we'll
			//    keep the last-used version.
			if (! isset( $given_options['kitToken'] ) || ! is_string( $given_options['kitToken'] ) ) {
				if ( isset( $given_options['version'] ) && 1 === preg_match('/[0-9]+\.[0-9]+/', $given_options['version'] ) ) {
					$item['version'] = $given_options['version'];
				} else {
					throw new FontAwesome_ConfigurationException('valid version expected but not given');
				}
			} else {
				$item['version'] = fa()->version();
			}

			return $item;
		}

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

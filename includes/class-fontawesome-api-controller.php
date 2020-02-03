<?php
/**
 * This controller provides WordPress REST client access to the Font Awesome
 * via the Metadata Provider,
 * using the site owner's configured API Settings, managed by FontAwesome_API_Settings.
 *
 * Your theme or plugin would simply POST a GraphQL query document to this point
 * in order to query the Font Awesome GraphQL API using the site owner's credentials.
 *
 * If the site owner has not added an API Token in the plugin's settings, then
 * it just means that queries will not have any authorization scopes beyond "public".
 * As a result, any GraphQL schema fields that would require some higher privilege
 * will resolve as null.
 *
 * If you know that you need access to some part of the schema that requires some
 * additional authorization scope, the way to get that is to have the site owner
 * add an API Token that has been generated with adequate authorization scopes
 * on the plugin's settings page.
 */
namespace FortAwesome;

require_once trailingslashit( FONTAWESOME_DIR_PATH ) . 'includes/class-fontawesome-metadata-provider.php';

use \WP_REST_Controller, \WP_REST_Response, \WP_Error, \Exception;

// TODO: remove this hack
					class MockMetaDataProvider extends FontAwesome_Metadata_Provider {
						public function __construct() {
							/* noop */
						}
						public function metadata_query( $args, $ignore_auth = FALSE ) {
							error_log('DEBUG: mocking with MockMetaDataProvider');

							// An error response
							/*
							return new WP_Error(
								'fontawesome_api_failed_request',
								'mocked bad request',
								array( 'status' => 400 )
							);
							*/

							// An empty kits query result
							/*
							return json_decode(<<<EOD
								{
									"data": {
									  "me": {
										"kits": []
									  }
									}
								}								
EOD, true
							);
							*/

							return json_decode(<<<EOD
								{
									"data": {
									  "me": {
										"kits": [
										  {
											"autoAccessibilityEnabled": true,
											"domains": [
											  "*.*"
											],
											"integrityHash": "sha384-wPybhX+N4JKW9PJklK8cC+QNngu6rJv5lwuPRhqJgQM6hApd6s8hq9mJnb5IbeKM",
											"licenseSelected": "pro",
											"minified": true,
											"name": "Alpha Kit",
											"shimEnabled": true,
											"status": "publishing",
											"technologySelected": "webfonts",
											"token": "778ccf8260",
											"useIntegrityHash": false,
											"version": "5.4.1"
										  },
										  {
											"autoAccessibilityEnabled": false,
											"domains": [
											  "*.*"
											],
											"integrityHash": "sha384-ijo1t4DZohc965vcv1pXrIpQEz9Lij8s0/xDPK1Iz+IVfSBvgKY+kK1PXTuZ0lAZ",
											"licenseSelected": "free",
											"minified": true,
											"name": "Beta Kit",
											"shimEnabled": false,
											"status": "publishing",
											"technologySelected": "svg",
											"token": "7cf0c88c97",
											"useIntegrityHash": false,
											"version": "latest"
										  }
										]
									  }
									}
								  }								
EOD, true
							);
						}
					}

if ( ! class_exists( 'FortAwesome\FontAwesome_API_Controller' ) ) :

	/**
	 * Controller class for REST endpoint
	 */
	class FontAwesome_API_Controller extends WP_REST_Controller {

		/**
		 * @ignore
		 */
		private $plugin_slug = null;

		/**
		 * @ignore
		 */
		protected $namespace = null;

		/**
		 * @ignore
		 */
		private $_metadata_provider = null;

		/**
		 * @ignore
		 */
		public function __construct( $plugin_slug, $namespace ) {
			$this->plugin_slug = $plugin_slug;
			$this->namespace   = $namespace;

			// TODO: get rid of this mock hack
			$this->_metadata_provider = new MockMetaDataProvider();
		}

		/**
		 * @ignore
		 */
		public function register_routes() {
			$route_base = 'api';

			register_rest_route(
				$this->namespace,
				'/' . $route_base,
				array(
					array(
						'methods'             => 'POST',
						'callback'            => array( $this, 'query' ),
						'permission_callback' => function() {
							return current_user_can( 'edit_posts' ); },
						'args'                => array(),
					),
				)
			);
		}

		/**
		 * Run the query by delegating to {@see FontAwesome_Metadata_Provider}.
		 *
		 * @param WP_REST_Request $request Full data about the request.
		 * @return WP_Error|WP_REST_Response
		 */
		public function query( $request ) {
			try {
				$result = $this->metadata_provider()->metadata_query( $request->get_body() );

				if ( $result instanceof WP_Error ) {
					return new WP_Error(
						$result->get_error_code(),
						$result->get_error_message(),
						array ( 'status' => 400 )
					);
				} else {
					return new WP_REST_Response( $result, 200 );
				}
			} catch ( Exception $e ) {
				return new WP_Error(
					'fontawesome_api_query',
					$e->getMessage(),
					array(
						'status' => 500,
						'trace'  => $e->getTraceAsString(),
					)
				);
			}
		}

		/**
		 * Allows a test subclass to mock the metadata provider.
		 *
		 * @ignore
		 */
		protected function metadata_provider() {
			return $this->_metadata_provider;
		}
	}

endif; // end class_exists.

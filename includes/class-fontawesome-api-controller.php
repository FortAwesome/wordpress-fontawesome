<?php
namespace FortAwesome;

require_once trailingslashit( FONTAWESOME_DIR_PATH ) . 'includes/class-fontawesome-metadata-provider.php';

use \WP_REST_Controller, \WP_REST_Response, \WP_Error, \Exception;

if ( ! class_exists( 'FortAwesome\FontAwesome_API_Controller' ) ) :

	/**
	 * Controller class for the plugin's GraphQL API REST endpoint.
	 *
	 * This controller provides WordPress REST client access to the Font Awesome
	 * GraphQL API. Requests to the Font Awesome API
	 * server will automatically be authorized by the site owner's API Token,
	 * if they have added one through the plugin's settings page.
	 * 
	 * Many queries can be resolved with a public authorization scope. No API
	 * Token is required for entirely public scope queries.
	 * 
	 * <h3>Headers</h3>
	 * 
	 * `X-WP-Nonce`: include an appropriate nonce from WordPress.
	 *
	 * <h3>Body</h3>
	 *
	 * The request body should contain a GraphQL query document as a string.
	 *
	 * For example, when the site owner as configured an API Token, the following
	 * query would retrieve the name and version properites for each kit in that
	 * authenticated account:
	 *
	 * ```
	 * query {
     *   me {
     *     kits {
     *       name
     *       version
     *     }
     *   }
     * }
	 * ```
	 * 
	 * If the site owner has not added an API Token in the plugin's settings, then
	 * it just means that queries will not have any authorization scopes beyond "public".
	 * As a result, any GraphQL schema fields that would require some higher privilege
	 * will resolve as null. So in the example above, the "me" field would be returned
	 * with a null value.
	 * 
	 * The following query, by contrast, requires only "public" scope and will retrieve
	 * the label that describes each icon in the "latest" Font Awesome release:
	 *
	 * ```
	 * query {
	 *   release(version: "latest") {
     *     icons {
     *       label
     *     }
     *   }
     * }
	 * ```
	 *
	 * If you know that you need access to some part of the schema that requires some
	 * additional authorization scope, the way to get that is to instruct the site owner
	 * to copy an API Token from their fontawesome.com account and add it to this
	 * plugin's configuration the plugin's settings page.
	 * 
	 * As of version 4.0.0 of this plugin, the only non-public portions of the
	 * GraphQL schema that are relevant to usage in WordPress involve querying
	 * the user's kits, which requires the `kits_read` scope.
	 * 
	 * For example, the following query returns a list of the user's kits with
	 * each kit's name and token fields.
	 * 
	 * ```
     *  query {
     *    me {
     *      kits {
     *        name
     *        token
	 *      }
     *    }
     *  }
	 * ```
	 * 
	 * If the user has not configured this plugin with an API Token that has
	 * the `kits_read` scope, the response to this query request
	 * would have an HTTP 200 status with a json body like this:
	 * 
	 * ```json
	 * {
	 *   "data":{
	 *     "me":null
	 *   },
	 *   "errors":[
	 *     {
	 *       "locations":[
	 *         {"column":0,"line":1}
	 *       ],
	 *       "message":"unauthorized",
	 *       "path":["me"]
	 *     }
	 *   ]
	 * } 
	 * ```
	 * 
	 * <h3>Responses</h3>
	 *
	 * If api.fontawesome.com responds with HTTP 200, then this controller will
	 * respond with HTTP 200 and pass through the response body as received from
	 * the API server.
	 *
	 * Note that a 200 response does not necessarily mean that there are no errors.
	 *
	 * An invalid query, such as one that has typo in a field name, may return
	 * an HTTP 200 result, but its response body will include an `errors` property with
	 * details about the validation error.
	 * 
	 * Or a query that includes a mix of successful and unsuccessful field
	 * authorizations, may return results in the response's `data` for the
	 * portions of the schema that are authorized, null for unauthorized portions,
	 * with explanation on the `errors` property.
	 * 
	 * See documentation about [GraphQL validation](https://graphql.org/learn/validation/)
	 * for more on error handling.
	 * 
	 * <h3>Additional Resources</h3>
	 *
	 * For more on how to construct GraphQL queries, [see here](https://graphql.org/learn/queries/).
	 * 
	 * You can explore the Font Awesome GraphQL API using an app like [GraphiQL](https://www.electronjs.org/apps/graphiql).
	 * Point it at `https://api.fontawesome.com`.
	 *
	 * <h3>Internal Use vs. Public API</h3>
	 * 
	 * The PHP methods in this controller class are not part of this plugin's
	 * public API, but the REST route it exposes is.
	 * 
	 * If you need to issue a query from server-side PHP code to the
	 * Font Awesome API server, use the {@see FontAwesome::query()} method.
	 *
	 * If you need to issue a query from client-side JavaScript, send
	 * an HTTP POST request to WP REST route `/font-awesome/v1/api`.
	 *
	 * That `query()` method and REST route _are_ part of this plugin's public API.
	 */
	class FontAwesome_API_Controller extends WP_REST_Controller {

		/**
		 * @ignore
		 * @internal
		 */
		private $plugin_slug = null;

		/**
		 * @ignore
		 * @internal
		 */
		protected $namespace = null;

		/**
		 * @ignore
		 * @internal
		 */
		private $_metadata_provider = null;

		/**
		 * @ignore
		 * @internal
		 */
		public function __construct( $plugin_slug, $namespace ) {
			$this->plugin_slug = $plugin_slug;
			$this->namespace   = $namespace;
			$this->_metadata_provider = fa_metadata_provider();
		}

		/**
		 * Register REST routes.
		 *
		 * @internal
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
		 * Internal use only. This method is not part of this plugin's public API.
		 *
		 * @ignore
		 * @internal
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
		 * Internal use only, not part of this plugin's public API.
		 *
		 * @internal
		 * @ignore
		 */
		protected function metadata_provider() {
			return $this->_metadata_provider;
		}
	}

endif; // end class_exists.

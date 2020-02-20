<?php
namespace FortAwesome;

require_once trailingslashit( FONTAWESOME_DIR_PATH ) . 'includes/class-fontawesome-exception.php';

use \WP_REST_Controller, \WP_REST_Response, \WP_Error, \Error, \Exception;

/**
 * Module for this plugin's Preference Check controller
 *
 * @noinspection PhpIncludeInspection
 */

/**
 * Controller class for REST endpoint
 */
class FontAwesome_Preference_Check_Controller extends WP_REST_Controller {

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
		$route_base = 'preference-check';

		register_rest_route(
			$this->namespace,
			'/' . $route_base,
			array(
				array(
					'methods'             => 'POST',
					'callback'            => array( $this, 'check_preferences' ),
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
	public function check_preferences( $request ) {
		try {
			fa()->gather_preferences();

			$conflicts = fa()->conflicts_by_option( $request->get_json_params() );

			return new WP_REST_Response( $conflicts, 200 );
		} catch ( FontAwesome_ServerException $e ) {
			return fa_500( $e );
		} catch ( FontAwesome_Exception $e ) {
			return fa_400( $e );
		} catch ( Exception $e ) {
			return unknown_error_500( $e );
		} catch ( Error $e ) {
			return unknown_error_500( $e );
		}
	}
}

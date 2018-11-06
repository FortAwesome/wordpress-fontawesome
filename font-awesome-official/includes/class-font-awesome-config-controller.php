<?php

if (! class_exists('FontAwesomeConfigController') ) :

class FontAwesomeConfigController extends WP_REST_Controller {

  private $plugin_slug = null;

  protected $namespace = null;

  public function __construct($plugin_slug, $namespace) {
    $this->plugin_slug = $plugin_slug;
    $this->namespace = $namespace;
  }

  public function register_routes() {
    $route_base = 'config';

    register_rest_route($this->namespace, '/' . $route_base, array(
      array(
        'methods' => 'GET',
        'callback' => array($this, 'get_item'),
        'permission_callback' => array( $this, 'get_item_permissions_check' ),
        'args' => array()
      )
    ));
  }

  /**
   * Get the config, a singleton resource
   *
   * @param WP_REST_Request $request Full data about the request.
   * @return WP_Error|WP_REST_Response
   */
  public function get_item( $request ) {
    $data = FontAwesome()->options();

    return new WP_REST_Response( $data, 200 );
  }

  /**
   * Check if a given request has access to get a specific item
   *
   * @param WP_REST_Request $request Full data about the request.
   * @return WP_Error|bool
   */
  public function get_item_permissions_check( $request ) {
    return current_user_can( 'manage_options' );
  }
}

endif; // end class_exists

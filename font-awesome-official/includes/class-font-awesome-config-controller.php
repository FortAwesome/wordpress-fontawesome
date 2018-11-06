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
        'permission_callback' => function() { return current_user_can( 'manage_options' ); },
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
    $fa = FontAwesome();
    $data = array(
      "options" => $fa->options(),
      "clientRequirements" => $fa->requirements(),
      "conflicts" => $fa->conflicts(),
      "currentLoadSpec" => $fa->load_spec(),
      "unregisteredClients" => $fa->unregistered_clients(),
      "releases" => array(
        "available" => $fa->get_available_versions(),
        "latest_version" => $fa->get_latest_version(),
        "latest_semver" => $fa->get_latest_semver(),
        "previous_version" => $fa->get_previous_version(),
        "previous_semver" => $fa->get_previous_semver()
      )
    );

    return new WP_REST_Response( $data, 200 );
  }
}

endif; // end class_exists

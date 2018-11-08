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
      ),
      array(
        'methods' => 'PUT',
        'callback' => array($this, 'update_item'),
        'permission_callback' => function() { return current_user_can( 'manage_options' ); },
        'args' => array()
      )
    ));
  }

  protected function build_item($fa, $reload_options = false) {
    return array(
      "options" => $fa->options($reload_options),
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
  }

  /**
   * Get the config, a singleton resource
   *
   * @param WP_REST_Request $request Full data about the request.
   * @return WP_Error|WP_REST_Response
   */
  public function get_item( $request ) {
    $data = $this->build_item(FontAwesome());

    return new WP_REST_Response( $data, 200 );
  }

  /**
   * Update the singleton resource
   *
   * @param WP_REST_Request $request Full data about the request.
   * @return WP_Error|WP_REST_Request
   */
  public function update_item( $request ) {
    $item = $this->prepare_item_for_database( $request );

    if(update_option(FontAwesome::OPTIONS_KEY, $item['options'])) {
      $fa = FontAwesome::reset();
      $fa->load();
      $return_data = $this->build_item($fa, true);
      return new WP_REST_Response( $return_data, 200 );
    } else {
      return new WP_Error( 'cant-update', 'Whoops, we couldn\'t update those options.', array( 'status' => 500 ) );
    }
  }

  /**
   * Prepare the item for and update operation
   *
   * @param WP_REST_Request $request Request object
   * @return WP_Error|object $prepared_item
   */
  protected function prepare_item_for_database( $request ) {
    $body = $request->get_json_params();
    return array_merge(array(), $body);
  }
}

endif; // end class_exists

<?php

require_once( dirname(__FILE__ ) . '/../vendor/autoload.php');
use Composer\Semver\Semver;

if (! class_exists('FontAwesome') ) :

class FontAwesome {

  protected static $integrityKeys = array(
    'free' => array(
      'webfont' => array(
        'all' => 'sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp'
      ),
      'svg' => array(
        'all' => 'sha384-xymdQtn1n3lH2wcu0qhcdaOpQwyoarkgLVxC/wZ5q7h9gHtxICrpcaSUfygqZGOe'
      )
    ),
    'pro' => array(
      'webfont' => array(
        'all' => 'sha384-oi8o31xSQq8S0RpBcb4FaLB8LJi9AT8oIdmS1QldR8Ui7KUQjNAnDlJjp55Ba8FG'
      ),
      'svg' => array(
        'all' => 'sha384-d84LGg2pm9KhR4mCAs3N29GQ4OYNy+K+FBHX8WhimHpPm86c839++MDABegrZ3gn'
      )
    )
  );

  protected $_constants = [
    'version' => '0.0.1',
    'plugin_name' => 'font-awesome',
    'options_key' => 'font-awesome',
    'options_page' => 'font-awesome',
    'handle' => 'font-awesome-official',
    'v4shim_handle' => 'font-awesome-official-v4shim',
    'user_settings_section' => 'font-awesome-user-settings-section',
    'user_settings_field_id_method' => 'font-awesome-user-settings-field-method',
    'user_settings_field_id_pro' => 'font-awesome-user-settings-field-pro',
    'user_settings_field_id_v4shim' => 'font-awesome-user-settings-field-v4shim',
    'user_settings_field_id_version' => 'font-awesome-user-settings-field-version',
    'user_settings_field_id_pseudo_elements' => 'font-awesome-user-settings-field-pseudo-elements',
    'default_user_options' => array(
      'load_spec' => array(
        'name' => 'user'
      ),
      'pro' => 0,
      'remove_others' => false
    )
  ];

  // TODO: eventually change these hard-coded maps to be populated by
  // based on something returned from some web API endpoint we'll create.
  // However, they will only change as often as we increment the minor version number,
  // it's only as urgent as our next minor release.
  protected static $_map_human_version_to_semver = [
    'latest' => '~5.1.0',
    'previous' => '~5.0.0'
  ];

  protected static $_map_semver_to_human_version = [
    '~5.1.0' => 'latest',
    '~5.0.0' => 'previous'
  ];

  public function __get($name){
    if (isset($this->_constants[$name])) {
      return $this->_constants[$name];
    } else {
      throw new TypeError('Objects of type ' . self::class . ' have no ' . $name . ' property');
    }
  }

  /**
   * The single instance of the class.
   *
   */
  protected static $_instance = null;

  /**
   * The list of client requirements.
   *
   */
  protected $reqs = array();

  /**
   * The list of client requirement conflicts.
   *
   */
  protected $conflicts = null;

  /**
   * The resulting load specification after settling all client requirements.
   */
  protected $load_spec = null;

  /**
   * The list of unregistered clients we've discovered.
   * Empty by default.
   */
  protected $unregistered_clients = array();

  protected $options = null;

  /**
   * Main FontAwesome Instance.
   *
   * Ensures only one instance of FontAwesome is loaded or can be loaded.
   */
  public static function instance() {
    if ( is_null( self::$_instance ) ) {
      self::$_instance = new self();
    }
    return self::$_instance;
  }

  public function __construct() { /* noop */ }

  public function run(){
    add_action( 'init', array( $this, 'load' ));
    if( is_admin() ){
        $this->initialize_admin();
    }
  }

  private function settings_page_url() {
    return admin_url( "options-general.php?page=" . $this->options_page );
  }

  private function initialize_admin(){
    add_action('admin_enqueue_scripts', function(){
      wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'admin/css/font-awesome-admin.css', array(), $this->version, 'all' );
      wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'admin/js/font-awesome-admin.js', array('jquery'), $this->version );
    });

    add_action('admin_menu', function(){
      add_options_page(
        'Font Awesome Settings',
        'Font Awesome',
        'manage_options',
        $this->options_page,
        array( $this, 'create_admin_page' )
      );
    });
    add_action('admin_init', array($this, 'admin_page_init'));

    add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), function($links){
      $mylinks = array(
      '<a href="' . $this->settings_page_url() . '">Settings</a>',
      );
      return array_merge( $links, $mylinks );
    });
  }

  public function admin_page_init(){
    register_setting( $this->plugin_name, $this->options_key, [
      'type' => 'string',
      'default' => $this->default_user_options,
      'sanitize_callback' => array($this, 'sanitize_user_settings_input')
    ]);
    add_settings_section( $this->user_settings_section, 'Settings', array($this, 'user_settings_section_view'), $this->plugin_name );
    add_settings_field(
      $this->user_settings_field_id_method,
      'Method',
      array($this, 'user_settings_field_method_view'),
      $this->plugin_name,
      $this->user_settings_section
    );
    add_settings_field(
      $this->user_settings_field_id_pro,
      'Pro',
      array($this, 'user_settings_field_pro_view'),
      $this->plugin_name,
      $this->user_settings_section
    );
    add_settings_field(
      $this->user_settings_field_id_v4shim,
      'Version 4 Compatibility',
      array($this, 'user_settings_field_v4shim_view'),
      $this->plugin_name,
      $this->user_settings_section
    );
    add_settings_field(
      $this->user_settings_field_id_pseudo_elements,
      'Pseudo-elements Support',
      array($this, 'user_settings_field_pseudo_elements_view'),
      $this->plugin_name,
      $this->user_settings_section
    );
    add_settings_field(
      $this->user_settings_field_id_version,
      'Version',
      array($this, 'user_settings_field_version_view'),
      $this->plugin_name,
      $this->user_settings_section
    );
  }

  public function user_settings_section_view(){
  ?>
    <p class="user-settings-section-description">
      Configure your preferences for Font Awesome's installation here.
      Your preferences will be merged with any requirements registered by
      other themes or plugins, summarized in the table below.
      If you choose preferences that conflict with those required by other
      registered themes or plugins, you'll see an error here on this
      admin page.
    </p>
  <?php
  }

  /**
   * Returns current options.
   */
  public function options(){
    if(is_null($this->options)) {
      $this->options = wp_parse_args(get_option($this->options_key, $this->default_user_options));
    }
    return $this->options;
  }

  public function user_settings_field_pro_view(){
    $options = $this->options();
    $checked = (isset($options['pro']) && $options['pro']) ? 'checked' : '';
    $field_name = $this->options_key . '[pro]';
  ?>
    <input id="<?= $this->user_settings_field_id_pro ?>" type="checkbox" <?= $checked ?> name="<?= $field_name ?>" value="true">
  <?php
  }

  public function user_settings_field_method_view(){
    $options = $this->options();

    $svg_selected = '';
    $webfont_selected = '';
    $nothing_selected = '';

    if(isset($options['load_spec']['method'])){
      $svg_selected = $options['load_spec']['method'] == 'svg' ? 'selected' : '';
      $webfont_selected = $options['load_spec']['method'] == 'webfont' ? 'selected' : '';
    } else {
      $nothing_selected = 'selected';
    }

    $field_name = $this->options_key . '[load_spec][method]';
    ?>
    <select id="<?= $this->user_settings_field_id_method ?>" name="<?= $field_name ?>">
      <option value="svg" <?= $svg_selected ?>>svg</option>
      <option value="webfont" <?= $webfont_selected ?>>webfont</option>
      <option value="_" <?= $nothing_selected ?>>_</option>
    </select>
    <?php
  }

  public function user_settings_field_version_view(){
    $options = $this->options();

    $latest_selected = '';
    $previous_selected = '';
    $nothing_selected = '';

    if(isset($options['load_spec']['version'])){
      $latest_selected = $this->get_human_version_from_semver($options['load_spec']['version']) == 'latest' ? 'selected' : '';
      $previous_selected = $this->get_human_version_from_semver($options['load_spec']['version']) == 'previous' ? 'selected' : '';
    } else {
      $nothing_selected = 'selected';
    }

    $field_name = $this->options_key . '[load_spec][version]';
    ?>
    <select id="<?= $this->user_settings_field_id_version ?>" name="<?= $field_name ?>">
      <option value="<?= $this->get_semver_from_human_version('latest') ?>" <?= $latest_selected ?>>latest release</option>
      <option value="<?= $this->get_semver_from_human_version('previous') ?>" <?= $previous_selected ?>>previous release</option>
      <option value="_" <?= $nothing_selected ?>>_</option>
    </select>
    <?php
  }

  public function user_settings_field_v4shim_view(){
    $options = $this->options();

    $require_selected = '';
    $forbid_selected = '';
    $nothing_selected = '';

    if(isset($options['load_spec']['v4shim'])){
      $require_selected = $options['load_spec']['v4shim'] == 'require' ? 'selected' : '';
      $forbid_selected = $options['load_spec']['v4shim'] == 'forbid' ? 'selected' : '';
    } else {
      $nothing_selected = 'selected';
    }

    $field_name = $this->options_key . '[load_spec][v4shim]';
    ?>
    <select id="<?= $this->user_settings_field_id_v4shim ?>" name="<?= $field_name ?>">
      <option value="require" <?= $require_selected ?>>require</option>
      <option value="forbid" <?= $forbid_selected ?>>forbid</option>
      <option value="_" <?= $nothing_selected ?>>_</option>
    </select>
    <?php
  }

  public function user_settings_field_pseudo_elements_view(){
    $options = $this->options();

    $require_selected = '';
    $forbid_selected = '';
    $nothing_selected = '';

    if(isset($options['load_spec']['pseudo-elements'])){
      $require_selected = $options['load_spec']['pseudo-elements'] == 'require' ? 'selected' : '';
      $forbid_selected = $options['load_spec']['pseudo-elements'] == 'forbid' ? 'selected' : '';
    } else {
      $nothing_selected = 'selected';
    }

    $field_name = $this->options_key . '[load_spec][pseudo-elements]';
    ?>
    <select id="<?= $this->user_settings_field_id_pseudo_elements ?>" name="<?= $field_name ?>">
      <option value="require" <?= $require_selected ?>>require</option>
      <option value="forbid" <?= $forbid_selected ?>>forbid</option>
      <option value="_" <?= $nothing_selected ?>>_</option>
    </select>
    <?php
  }

  public function sanitize_user_settings_input($input){
    $new_input = $this->default_user_options;
    if( isset( $input['load_spec'] ) ){
      if( isset( $input['load_spec']['method'] ) && $input['load_spec']['method'] != '_')
        $new_input['load_spec']['method'] = sanitize_text_field( $input['load_spec']['method'] );

      if( isset( $input['load_spec']['v4shim'] ) ){
        switch( $input['load_spec']['v4shim'] ){
          case 'require':
            $new_input['load_spec']['v4shim'] = 'require';
            break;
          case 'forbid':
            $new_input['load_spec']['v4shim'] = 'forbid';
            break;
        }
      }

      if( isset( $input['load_spec']['pseudo-elements'] ) ){
        switch( $input['load_spec']['pseudo-elements'] ){
          case 'require':
            $new_input['load_spec']['pseudo-elements'] = 'require';
            break;
          case 'forbid':
            $new_input['load_spec']['pseudo-elements'] = 'forbid';
            break;
        }
      }

      if( isset( $input['load_spec']['version'] ) ){
        $previous_semver = $this->get_semver_from_human_version('previous');
        $latest_semver = $this->get_semver_from_human_version('latest');

        switch( $input['load_spec']['version'] ){
          case $latest_semver:
            $new_input['load_spec']['version'] = $latest_semver;
            break;
          case $previous_semver:
            $new_input['load_spec']['version'] = $previous_semver;
            break;
        }
      }
    }

    if( isset( $input['pro'] ) )
      $new_input['pro'] = wp_validate_boolean( $input['pro'] );

    return $new_input;
  }

  public function get_human_version_from_semver($semver){
    if( isset( self::$_map_semver_to_human_version[$semver] ) ){
      return self::$_map_semver_to_human_version[$semver];
    } else {
      error_log('WARNING: attemping to lookup a human version for semver "' . $semver . '", but it does not exist in the lookup map.');
      return null;
    }
  }

  public function get_semver_from_human_version($human_version){
    if( isset( self::$_map_human_version_to_semver[$human_version] ) ){
      return self::$_map_human_version_to_semver[$human_version];
    } else {
      error_log('WARNING: attemping to lookup a semver for human version "' . $human_version . '", but it does not exist in the lookup map.');
      return null;
    }
  }

  public function create_admin_page(){
    include_once( 'admin/views/main.php' );
  }

  public function reset(){
    self::$_instance = null;
    FontAwesome();
  }

    // TODO:
    // - [ ] resolve method: SVG with JavaScript or Webfonts with CSS
    // - [ ] resolve version: (only 5? or what about v4 with shims?)
    // - [ ] resolve asset URL host location: CDN or self-hosted?
    // - [ ] resolve any config: such as searchPseudoElements (which might only be relevant for SVG/JS)
    // - [ ] determine whether any shim is needed
    // - [ ] determine whether a subset of icons might suffice for loading
    // - [ ] resolve license: Free or Pro (future)
    // - [ ] Finally, enqueue either a style or a script

  /**
   * Main entry point for the loading process.
   * Returns the enqueued load_spec if successful.
   * Otherwise, returns null.
   */
  public function load() {
    $options = $this->options();

    // Register the web site user/ower as a client.
    $this->register($options['load_spec']);

    // Now, ask any other listening clients to register.
    do_action('font_awesome_requirements');
    // TODO: add some WP persistent cache here so we don't needlessly retrieve latest versions and re-process
    // all requirements each time. We'd only need to do that when something changes.
    // So what are those conditions for refreshing the cache?
    $load_spec = $this->build_load_spec(function($data){
      $this->conflicts = $data;
      // TODO: figure out the best way to present diagnostic information.
      // Probably in the error_log, but if we're on the admin screen, there's
      // probably a more helpful way to do it.
      $client_name_list = [];
      foreach($data['client-reqs'] as $client){
        array_push($client_name_list, $client['name']);
      }
      $error_msg = "Font Awesome Error! These themes or plugins have conflicting requirements: " . implode($client_name_list, ', ') . '.';
      error_log($error_msg . ' Dumping conflicting requirements: ' .  print_r($data, true));
      do_action('font_awesome_failed', $data);
      add_action('admin_notices', function() use($error_msg){
        ?>
        <div class="error notice">
        <p><?= $error_msg ?></p>
        </div>
        <?php
      });
    });
    if( isset($load_spec) ) {
      $this->load_spec = $load_spec;
      $this->enqueue($load_spec, $options['remove_others']);
      return $load_spec;
    } else {
      return null;
    }
  }

  /**
   * Return current requirements conflicts.
   */
  public function conflicts(){
    return $this->conflicts;
  }

  /**
   * Return current client requirements.
   */
  public function requirements(){
    return $this->reqs;
  }

  /**
   * Return list of found unregistered clients.
   */
  public function unregistered_clients(){
    return $this->unregistered_clients;
  }

  /**
   * Return current load specification, which may be null if has been settled.
   * If it is still null and $this->coflicts() is not null, that means the load failed.
   */
  public function load_spec(){
    return $this->load_spec;
  }

  /**
   * Builds the loading specification based on all registered requirements.
   * Returns the load spec if a valid one can be computed, else it returns null
   *   after invoking the error_callback function.
   */
  public function build_load_spec(callable $error_callback) {
    // 1. Iterate through $reqs once. For each requirement attribute, see if the current works with the accumulator.
    // 2. If we see any conflict along the way, bail out early. But how do we report the conflict helpfully?
    // 3. Compose a final result that uses defaults for keys that have no client-specified requirements.

    $load_spec = array(
      'method' => array(
        // returns new value if compatible, else null
        'resolve' => function($prevReqVal, $curReqVal){ return $prevReqVal == $curReqVal ? $prevReqVal : null; }
      ),
      'v4shim' => array(
        'resolve' => function($prevReqVal, $curReqVal){
          // Cases:
          // require, require => true
          // require, forbid => false
          // forbid, require => false
          // forbid, forbid => true
          if( 'require' == $prevReqVal ){
            if ( 'require' == $curReqVal ){ return $curReqVal; }
            elseif ( 'forbid' == $curReqVal ) { return null; }
            else { return null; }
          } elseif ( 'forbid' == $prevReqVal ){
            if ( 'forbid' == $curReqVal ){ return $curReqVal; }
            elseif ( 'require' == $curReqVal ){ return null; }
            else { return null; }
          } else { return null; }
        }
      ),
      'pseudo-elements' => array(
        'resolve' => function($prevReqVal, $curReqVal){
          if( 'require' == $prevReqVal ){
            if ( 'require' == $curReqVal ){ return $curReqVal; }
            elseif ( 'forbid' == $curReqVal ) { return null; }
            else { return null; }
          } elseif ( 'forbid' == $prevReqVal ){
            if ( 'forbid' == $curReqVal ){ return $curReqVal; }
            elseif ( 'require' == $curReqVal ){ return null; }
            else { return null; }
          } else { return null; }
        }
      ),
      // Version: start with all available versions. For each client requirement, narrow the list with that requirement's version constraint.
      // Hopefully, we end up with a non-zero list, in which case, we'll sort the list and take the most recent satisfying version.
      'version' => array(
        'value' => $this->get_available_versions(),
        'resolve' => function($prevReqVal, $curReqVal){
          $satisfyingVersions = Semver::satisfiedBy($prevReqVal, $curReqVal);
          return count($satisfyingVersions) > 0 ? $satisfyingVersions : null;
        },
      )
    );

    $validKeys = array_keys($load_spec);

    $bailEarlyReq = null;

    $clients = array();

    // Iterate through each set of requirements registered by a client
    foreach( $this->reqs as $req ) {
      $clients[$req['name']] = $req['client-call'];
      // For this set of requirements, iterate through each requirement key, like ['method', 'v4shim', ... ]
      foreach( $req as $key => $payload ){
        if ( in_array($key, ['client-call', 'name']) ) continue; // these are meta keys that we won't process here.
        if ( ! in_array($key, $validKeys) ) {
          error_log("Ignoring invalid requirement key: " . $key . ". Only these are allowed: " . join(', ', $validKeys));
          continue;
        }
        if( array_key_exists('value', $load_spec[$key])) {
          // Check compatibility with existing requirement value.
          // First, record that this client has made this new requirement.
          if(array_key_exists('client-reqs', $load_spec[$key])){
            array_unshift($load_spec[$key]['client-reqs'], $req);
          } else {
            $load_spec[$key]['client-reqs'] = array( $req );
          }
          $resolved_req = $load_spec[$key]['resolve']($load_spec[$key]['value'], $req[$key]);
          if (is_null($resolved_req)) {
            // the compatibility test failed
            $bailEarlyReq = $key;
            break 2;
          } else {
            // The previous and current requirements are compatible, so update the value
            $load_spec[$key]['value'] = $resolved_req;
          }
        } else {
          // Add this as the first client to make this requirement.
          $load_spec[$key]['value'] = $req[$key];
          $load_spec[$key]['client-reqs'] = [ $req ];
        }
      }
    }

    if($bailEarlyReq) {
      // call the error_callback, indicating which clients registered incompatible requirements
      is_callable($error_callback) && $error_callback(array(
        'req' => $bailEarlyReq,
        'client-reqs' => $load_spec[$bailEarlyReq]['client-reqs']
      ));
      return null;
    }

    // This is a good place to set defaults
    // pseudo-elements: when webfonts, true
    // when svg, false
    // TODO: should this be set up in the initial load_spec before, or must it be set at the end of the process here?
    $method = $this->specified_requirement_or_default($load_spec['method'], 'webfont');
    $pseudo_elements_default = $method == 'webfont' ? 'require' : null;
    $pseudo_elements = $this->specified_requirement_or_default($load_spec['pseudo-elements'], $pseudo_elements_default) == 'require';
    if( $method == 'webfont' && ! $pseudo_elements ) {
      error_log('WARNING: a client of Font Awesome has forbidden pseudo-elements, but since the webfont method has been selected, pseudo-element support cannot be eliminated.');
      $pseudo_elements = true;
    }
    return array(
      'method' => $method,
      'v4shim' => $this->specified_requirement_or_default($load_spec['v4shim'], 'require') == 'require',
      'pseudo-elements' => $pseudo_elements,
      'version' => Semver::rsort($load_spec['version']['value'])[0],
      'pro' => $this->is_pro_configured()
    );
  }

  protected function is_pro_configured(){
    $options = $this->options();
    return( wp_validate_boolean($options['pro']) );
  }

  /**
   * Convenience method. Returns boolean value indicating whether the current load specification
   * includes Pro. Should only be used after loading is complete.
   */
  public function using_pro(){
    $load_spec = $this->load_spec();
    return isset($load_spec['pro']) && $load_spec['pro'];
  }

  /**
   * Convenience method. Returns boolean value indicating whether the current load specification
   * includes support for pseudo-elements. Should only be used after loading is complete.
   */
  public function using_pseudo_elements(){
    $load_spec = $this->load_spec();
    return isset($load_spec['pseudo-elements']) && $load_spec['pseudo-elements'];
  }

  protected function specified_requirement_or_default($req, $default){
    return array_key_exists('value', $req) ? $req['value'] : $default;
  }

  /**
   * Returns a full version string of the latest stable version, or null
   * if there are no available versions.
   */
  public function get_latest_version(){
    $versions = $this->get_available_versions();
    return count($versions) > 0 ? Semver::rsort($versions)[0] : null;
  }

  // TODO: implement this for real, probably against some REST endpoint
  public function get_available_versions(){
    return array(
      '5.1.0',
      '5.0.13',
      '5.0.12',
      '5.0.11',
      '5.0.10',
      '5.0.9',
      '5.0.0'
    );
  }

  /**
   * Given a loading specification, enqueues Font Awesome to load accordingly.
   * Returns nothing.
   * remove_others (boolean): whether to attempt to dequeue unregistered clients.
   */
  protected function enqueue($load_spec, $remove_others = false) {
    $method = $load_spec['method'];
    $license = $load_spec['pro'] ? 'pro' : 'free';
    ($method == 'webfont' || $method == 'svg') || wp_die('method must be either webfont or svg');

    $faUrl = "https://";
    $faUrl .= $license == 'pro' ? 'pro.' : 'use.';
    $faUrl .= 'fontawesome.com/releases/v' . $load_spec['version'] . '/';
    $faShimUrl = $faUrl;

    $integrityKey = self::$integrityKeys[$license][$method]['all']; // hardcode 'all' for now

    if( $method == 'webfont' ){
      $faUrl .=  'css/all.css';
      wp_enqueue_style($this->handle, $faUrl, null, null);

      // Filter the <link> tag to add the integrity and crossorigin attributes for completeness.
      add_filter( 'style_loader_tag', function($html, $handle) use($integrityKey){
        if ( in_array($handle, [$this->handle]) ) {
          return preg_replace('/\/>$/', 'integrity="' . $integrityKey . '" crossorigin="anonymous" />', $html, 1);
        } else {
          return $html;
        }
      }, 10, 2 );


      if( $load_spec['v4shim'] ){
        $faShimUrl .= 'css/v4-shims.css';
        wp_enqueue_style($this->v4shim_handle, $faShimUrl, null, null);

        // TODO: add new integrity key specific to v4-shims, if necessary.
        // Filter the <link> tag to add the integrity and crossorigin attributes for completeness.
        add_filter( 'style_loader_tag', function($html, $handle) use($integrityKey){
          if ( in_array($handle, [$this->v4shim_handle]) ) {
            return preg_replace('/\/>$/', 'integrity="' . $integrityKey . '" crossorigin="anonymous" />', $html, 1);
          } else {
            return $html;
          }
        }, 10, 2 );
      }
    } else {
      $faUrl .= 'js/all.js';

      wp_enqueue_script($this->handle, $faUrl, null, null, false);

      if( $load_spec['pseudo-elements'] ){
        wp_add_inline_script( $this->handle, 'FontAwesomeConfig = { searchPseudoElements: true };', 'before' );
      }

      // Filter the <script> tag to add the integrity and crossorigin attributes for completeness.
      add_filter( 'script_loader_tag', function($tag, $handle) use($integrityKey){
        if ( in_array($handle, [$this->handle]) ) {
          return preg_replace('/\/>$/', 'integrity="' . $integrityKey . '" crossorigin="anonymous" />', $tag, 1);
        } else {
          return $tag;
        }
      }, 10, 2 );

      if( $load_spec['v4shim'] ){
        $faShimUrl .= 'js/v4-shims.js';
        wp_enqueue_script($this->v4shim_handle, $faShimUrl, null, null, false);

        // TODO: add new integrity key specific to v4-shims, if necessary.
        add_filter( 'script_loader_tag', function($tag, $handle) use($integrityKey){
          if ( in_array($handle, [$this->v4shim_handle]) ) {
            return preg_replace('/\/>$/', 'integrity="' . $integrityKey . '" crossorigin="anonymous" />', $tag, 1);
          } else {
            return $tag;
          }
        }, 10, 2 );
      }
    }

    $obj = $this;
    // Look for unregistered clients
    add_action('wp_enqueue_scripts', function() use($obj, $remove_others){
      $obj->detect_unregistered_clients();
      if($remove_others){
        $obj->remove_unregistered_clients();
      }
    }, 15);

    do_action('font_awesome_enqueued', $load_spec);
  }

  /**
   * Populates $this->unregistered_clients() after searching through $wp_styles and $wp_scripts
   * Returns nothing
   */
  protected function detect_unregistered_clients(){
    global $wp_styles;
    global $wp_scripts;

    $collections = array(
      'style' => $wp_styles,
      'script' => $wp_scripts
    );

    foreach( $collections as $key => $collection ) {
      foreach ($collection->registered as $handle => $details) {
        switch ($handle) {
          case $this->handle:
          case $this->v4shim_handle:
            continue;
            break;
          default:
            if (strpos($details->src, 'fontawesome') || strpos($details->src, 'font-awesome')) {
              array_push($this->unregistered_clients, array(
                'handle' => $handle,
                'type' => $key
              ));
            }
        }
      }
    }
  }

  protected function remove_unregistered_clients(){
    foreach( $this->unregistered_clients as $client ){
      switch($client['type']){
        case 'style':
          wp_dequeue_style($client['handle']);
          break;
        case 'script':
          wp_dequeue_script($client['handle']);
          break;
        default:
          error_log("WARNING: unexpected client type: " . $client['type']);
      }
    }
  }

  public function register($req) {
    $bt = debug_backtrace(1);
    $caller = array_shift($bt);
    if ( ! array_key_exists('name', $req) ){
      throw new InvalidArgumentException('missing required key: name');
    }
    // array (
    //  'method' => 'webfont',
    //  'v4shim' => 'require' | 'forbid',
    //  'pro' => 'require' | 'forbid',
    //  'pseudo-elements' => 'require',
    //  'version' => '5.0.13',
    //  'name' => 'clientA'
    // )
    $req['client-call'] = array(
      'file' => $caller['file'],
      'line' => $caller['line']
    );
    array_unshift($this->reqs, $req);
  }
}

endif; // ! class_exists

function FontAwesome() {
    return FontAwesome::instance();
}

<?php
require_once( __DIR__ . '/../defines.php');
require_once( FONTAWESOME_DIR_PATH . 'vendor/autoload.php');
require_once( FONTAWESOME_DIR_PATH . 'includes/class-font-awesome-release-provider.php');
require_once( FONTAWESOME_DIR_PATH . 'includes/class-font-awesome-resource.php');
require_once( FONTAWESOME_DIR_PATH . 'includes/class-font-awesome-config-controller.php');
require_once( ABSPATH . 'wp-admin/includes/screen.php' );
use Composer\Semver\Semver;

if (! class_exists('FontAwesome') ) :

class FontAwesome {

  // TODO: probably change the rest of these constants to be class constants so we don't have to
  // instantiate in order to access them.
  const OPTIONS_KEY = 'font-awesome-official';
  const ADMIN_USER_CLIENT_NAME_INTERNAL = 'user';
  const ADMIN_USER_CLIENT_NAME_EXTERNAL = 'You';

  const DEFAULT_USER_OPTIONS = array(
    'load_spec' => array(
      'name' => self::ADMIN_USER_CLIENT_NAME_INTERNAL
    ),
    'pro' => 0,
    'remove_others' => false
  );

  protected $_constants = [
    'version' => '0.1.0',
    'rest_api_version' => '1',
    'plugin_name' => 'font-awesome-official',
    'options_page' => 'font-awesome-official',
    'handle' => 'font-awesome-official',
    'v4shim_handle' => 'font-awesome-official-v4shim'
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

  protected $screen_id = null;

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

  private function __construct() { /* noop */ }

  public function run(){
    add_action( 'init', array( $this, 'load' ));

    // TODO: is it possible to get the REST API going only when the admin UI is active?
    $this->initialize_rest_api();

    if( is_admin() ){
        $this->initialize_admin();
    }
  }

  private function initialize_rest_api() {
    // Initialize each controller

    add_action( 'rest_api_init', array(
        new FontAwesomeConfigController($this->plugin_name, $this->rest_api_namespace()),
        'register_routes'
     )
    );
  }

  public function rest_api_namespace() {
    return $this->plugin_name . '/v' . $this->rest_api_version;
  }

  public function get_latest_version(){
    return FontAwesomeReleaseProvider()->latest_minor_release();
  }

  public function get_latest_semver(){
    return( '~' . $this->get_latest_version() );
  }

  public function get_previous_version(){
    return FontAwesomeReleaseProvider()->previous_minor_release();
  }

  public function get_previous_semver(){
    return ( '~' . $this->get_previous_version() );
  }

  public function get_available_versions(){
    return FontAwesomeReleaseProvider()->versions();
  }

  private function settings_page_url() {
    return admin_url( "options-general.php?page=" . $this->options_page );
  }

  /**
   * Retrieves the assets required to load the admin ui React app, based on
   * whether we're running in development or production.
   *
   * @return array|mixed|null|object
   * @throws \GuzzleHttp\Exception\GuzzleException
   */
  private function get_admin_asset_manifest() {
    if(FONTAWESOME_ENV == 'development') {
      $client = new GuzzleHttp\Client(['base_uri' => 'http://dockerhost:3030']);
      $response = $client->request('GET', '/asset-manifest.json', []);

      if($response->getStatusCode() != 200) {
        return null;
      }

      $body = $response->getBody();
      $bodyContents = $body->getContents();
      $bodyJson = json_decode($bodyContents, true);
      return $bodyJson;
    } else {
      $asset_manifest_file =  FONTAWESOME_DIR_PATH . 'admin/build/asset-manifest.json';
      if( !file_exists($asset_manifest_file) ) return null;
      $contents = file_get_contents($asset_manifest_file);
      if( empty($contents) ) return null;
      return json_decode($contents, true);
    }
  }

  private function initialize_admin(){
    add_action('admin_enqueue_scripts', function($hook){
      if( $hook == $this->screen_id) {

        $admin_asset_manifest = $this->get_admin_asset_manifest();
        $script_number = 0;

        if (FONTAWESOME_ENV == 'development') {
          $asset_url_base = "http://localhost:3030/";
        } else {
          $asset_url_base = FONTAWESOME_DIR_URL . "admin/build";
        }

        $added_wpr_object = false;
        foreach ($admin_asset_manifest as $key => $value) {
          if (preg_match('/\.js$/', $key)) {
            $script_name = $this->plugin_name . "-" . $script_number;
            wp_enqueue_script( $script_name, $asset_url_base . $value, [], null, true);

            if(!$added_wpr_object) {
              // We have to give a script handle as the first argument to wp_localize_script.
              // It doesn't really matter which one it is—we're only using it to inject a global JavaScript object
              // into a <script> tag. This is just a way to to make that injection on the first script handle
              // we come across.
              wp_localize_script( $script_name, 'wpFontAwesomeOfficial', array(
                  'api_nonce'   => wp_create_nonce( 'wp_rest' ),
                  'api_url'	  => rest_url( $this->rest_api_namespace() ),
                )
              );
              $added_wpr_object = true;
            }
          }
          if (preg_match('/\.css$/', $key)) {
            wp_enqueue_style($this->plugin_name . "-" . $script_number, $asset_url_base . $value, [], null, 'all');
          }
          $script_number++;
        }
      }
    });

    add_action('admin_menu', function(){
      $this->screen_id = add_options_page(
        'Font Awesome Settings',
        'Font Awesome',
        'manage_options',
        $this->options_page,
        array( $this, 'create_admin_page' )
      );
    });

    $pn = FontAwesome()->plugin_name;
    add_filter( 'plugin_action_links_' . trailingslashit($pn) . $pn . '.php',
      function($links){
      $mylinks = array(
      '<a href="' . $this->settings_page_url() . '">Settings</a>',
      );
      return array_merge( $links, $mylinks );
    });
  }

  /**
   * Returns current options with defaults.
   */
  public function options(){
    return wp_parse_args(get_option(self::OPTIONS_KEY), self::DEFAULT_USER_OPTIONS);
  }

  public function create_admin_page(){
    include_once( FONTAWESOME_DIR_PATH . 'admin/views/main.php' );
  }

  /**
   * Resets the singleton instance referenced by this class.
   */
  public static function reset(){
    self::$_instance = null;
    return FontAwesome();
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

    // TODO: reconsider whether this needs to run every time admin-ajax.php pings for the auth check
    // Probably not. How can we optimize?

    // Register the web site user/ower as a client.
    $this->register($options['load_spec']);

    // Now, ask any other listening clients to register.
    do_action('font_awesome_requirements');
    // TODO: add some WP persistent cache here so we don't needlessly retrieve latest versions and re-process
    // all requirements each time. We'd only need to do that when something changes.
    // So what are those conditions for refreshing the cache?
    $load_spec = $this->build_load_spec(function($data){
      // This is the error callback function. It only runs when build_load_spec() needs to report an error.
      $this->conflicts = $data;
      // TODO: figure out the best way to present diagnostic information.
      // Probably in the error_log, but if we're on the admin screen, there's
      // probably a more helpful way to do it.
      $client_name_list = [];
      foreach($data['client-reqs'] as $client){
        array_push($client_name_list,
          $client['name'] == self::ADMIN_USER_CLIENT_NAME_INTERNAL
          ? self::ADMIN_USER_CLIENT_NAME_EXTERNAL
          : $client['name']
        );
      }
      $error_msg = "Font Awesome Error! These themes or plugins have conflicting requirements: "
        . implode($client_name_list, ', ') . '.  '
        . 'To resolve these conflicts, <a href="' . $this->settings_page_url() . '">Go to Font Awesome Settings</a>.';

      error_log($error_msg . ' Dumping conflicting requirements: ' .  print_r($data, true));
      do_action('font_awesome_failed', $data);
      add_action('admin_notices', function() use($error_msg){
        $current_screen = get_current_screen();
        if($current_screen && $current_screen->id != $this->screen_id) {
          ?>
            <div class="error notice">
                <p><?= $error_msg ?></p>
            </div>
          <?php
        }
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
    $this->detect_unregistered_clients();
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
    $version = Semver::rsort($load_spec['version']['value'])[0];
    // Use v4shims by default, unless method == 'webfont' and version < 5.1.0
    // If we end up in an invalid state where v4shims are required for webfont v5.0.x, it should be because of an
    // invalid client requirement, and in that case, it will be acceptible to throw an exception. But we don't want
    // to *introduce* such an exception by our own defaults here.
    $v4shim_default = 'require';
    if('webfont' == $method && !Semver::satisfies($version, '>= 5.1.0')){
      $v4shim_default = 'forbid';
    }
    $pseudo_elements_default = $method == 'webfont' ? 'require' : null;
    $pseudo_elements = $this->specified_requirement_or_default($load_spec['pseudo-elements'], $pseudo_elements_default) == 'require';
    if( $method == 'webfont' && ! $pseudo_elements ) {
      error_log('WARNING: a client of Font Awesome has forbidden pseudo-elements, but since the webfont method has been selected, pseudo-element support cannot be eliminated.');
      $pseudo_elements = true;
    }
    return array(
      'method' => $method,
      'v4shim' => $this->specified_requirement_or_default($load_spec['v4shim'], $v4shim_default) == 'require',
      'pseudo-elements' => $pseudo_elements,
      'version' => $version,
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
   * Given a loading specification, enqueues Font Awesome to load accordingly.
   * Returns nothing.
   * remove_others (boolean): whether to attempt to dequeue unregistered clients.
   */
  protected function enqueue($load_spec, $remove_others = false) {
    $release_provider = FontAwesomeReleaseProvider();

    $method = $load_spec['method'];
    $use_svg = false;
    if('svg' == $method){
        $use_svg = true;
    } elseif ('webfont' != $method){
      error_log("WARNING: ignoring invalid method \"$method\". Expected either \"webfont\" or \"svg\". " .
        "Will use the default of \"webfont\"");
    }

    // For now, we're hardcoding the style_opt as 'all'. Eventually, we can open up the rest of the
    // feature for specifying a subset of styles.
    $resource_collection = $release_provider->get_resource_collection(
      $load_spec['version'], // version
      'all', // style_opt
      [
        'use_pro' => $load_spec['pro'],
        'use_svg' => $use_svg,
        'use_shim' => $load_spec['v4shim']
      ]
    );

    if( $method == 'webfont' ){
      wp_enqueue_style($this->handle, $resource_collection[0]->source(), null, null);

      // Filter the <link> tag to add the integrity and crossorigin attributes for completeness.
      add_filter( 'style_loader_tag', function($html, $handle) use($resource_collection){
        if ( in_array($handle, [$this->handle]) ) {
          return preg_replace('/\/>$/', 'integrity="' . $resource_collection[0]->integrity_key() .
            '" crossorigin="anonymous" />', $html, 1);
        } else {
          return $html;
        }
      }, 10, 2 );


      if( $load_spec['v4shim'] ){
        wp_enqueue_style($this->v4shim_handle, $resource_collection[1]->source(), null, null);

        // Filter the <link> tag to add the integrity and crossorigin attributes for completeness.
        // Not all resources have an integrity_key for all versions of Font Awesome, so we'll skip this for those
        // that don't.
        if(! is_null($resource_collection[1]->integrity_key()) ) {
          add_filter('style_loader_tag', function ($html, $handle) use ($resource_collection) {
            if (in_array($handle, [$this->v4shim_handle])) {
              return preg_replace('/\/>$/', 'integrity="' . $resource_collection[1]->integrity_key() .
                '" crossorigin="anonymous" />', $html, 1);
            } else {
              return $html;
            }
          }, 10, 2);
        }
      }
    } else {
      wp_enqueue_script($this->handle, $resource_collection[0]->source(), null, null, false);

      if( $load_spec['pseudo-elements'] ){
        wp_add_inline_script( $this->handle, 'FontAwesomeConfig = { searchPseudoElements: true };', 'before' );
      }

      // Filter the <script> tag to add the integrity and crossorigin attributes for completeness.
      if(! is_null($resource_collection[0]->integrity_key()) ) {
        add_filter('script_loader_tag', function ($tag, $handle) use ($resource_collection) {
          if (in_array($handle, [$this->handle])) {
            return preg_replace('/\/>$/', 'integrity="' . $resource_collection[0]->integrity_key() .
              '" crossorigin="anonymous" />', $tag, 1);
          } else {
            return $tag;
          }
        }, 10, 2);
      }

      if( $load_spec['v4shim'] ){
        wp_enqueue_script($this->v4shim_handle, $resource_collection[1]->source(), null, null, false);

        if(! is_null($resource_collection[1]->integrity_key()) ) {
          add_filter('script_loader_tag', function ($tag, $handle) use ($resource_collection) {
            if (in_array($handle, [$this->v4shim_handle])) {
              return preg_replace('/\/>$/', 'integrity="' . $resource_collection[1]->integrity_key() .
                '" crossorigin="anonymous" />', $tag, 1);
            } else {
              return $tag;
            }
          }, 10, 2);
        }
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
   * Cleans and re-populates $this->unregistered_clients() after searching through $wp_styles and $wp_scripts
   * Returns nothing
   */
  protected function detect_unregistered_clients(){
    global $wp_styles;
    global $wp_scripts;

    $collections = array(
      'style' => $wp_styles,
      'script' => $wp_scripts
    );

    $this->unregistered_clients = array(); // re-initialize

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
                'type' => $key,
                'src' => $details->src
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


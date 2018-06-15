<?php

/**
 * Plugin Name:       Font Awesome
 * Plugin URI:        https://fontawesome.com/wp-font-awesome/
 * Description:       Manage version resolution and loading for Font Awesome Free and Pro
 * Version:           0.0.1
 * Author:            Font Awesome
 * Author URI:        https://fontawesome.com/
 * License:           GPLv3
 */

defined( 'WPINC' ) || die;

require_once('vendor/autoload.php');
use Composer\Semver\Semver;

// 1. Make sure we haven't already been loaded
// 2. Run an action that tells all clients to say something about their requirements
// 3. Process the results of that to determine what will be loaded
// 4. Run another action notifying everyone what will be loaded, or nothing, so they can respond

if (! class_exists('FontAwesome') ) :

class FontAwesome {

  /**
   * FontAwesome version.
   *
   * @var string
   */
  public $version = '0.0.1';

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

  public function __construct() {
    add_action( 'init', array( $this, 'load' ));
  }

  public function reset(){
    $this->reqs = array();
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
   * Returns the enqueued loadSpec if successful.
   * Otherwise, returns null.
   */
  public function load() {
    do_action('font_awesome_requirements');
    $loadSpec = $this->build_load_spec(function($data){
      // TODO: figure out the best way to present diagnostic information.
      // Probably in the error_log, but if we're on the admin screen, there's
      // probably a more helpful way to do it.
      error_log('build_load_spec: Invalid load spec -- '. print_r($data, true));
      do_action('font_awesome_failed', $data);
    });
    if( isset($loadSpec) ) {
      $this->enqueue($loadSpec);
      do_action('font_awesome_enqueued', $loadSpec);
      return $loadSpec;
    } else {
      return null;
    }
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

    // Dealing with the version: start with a default that is the latest stable, and then see why that wouldn't work for clients
    // If it doesn't work for a given client, then use the latest that works for that client, then move to the next client's constraints.

    $loadSpec = array(
      'method' => array(
        // returns boolean: true if compatible.
        'is_compatible' => function($prevReqVal, $curReqVal){ return $prevReqVal == $curReqVal; },
        'keep_prev_when_compatible' => true
      ),
      'v4shim' => array(
        'is_compatible' => function($prevReqVal, $curReqVal){
          // Cases:
          // require, require => true
          // require, forbid => false
          // forbid, require => false
          // forbid, forbid => true
          if( 'require' == $prevReqVal ){
            if ( 'require' == $curReqVal ){ return true; }
            elseif ( 'forbid' == $curReqVal ) { return false; }
            else { return false; }
          } elseif ( 'forbid' == $prevReqVal ){
            if ( 'forbid' == $curReqVal ){ return true; }
            elseif ( 'require' == $curReqVal ){ return false; }
            else { return false; }
          } else { return false; }
        },
        'keep_prev_when_compatible' => false
      ),
      'pseudo-elements' => array(
        'is_compatible' => function($prevReqVal, $curReqVal){
          if( 'require' == $prevReqVal ){
            if ( 'require' == $curReqVal ){ return true; }
            elseif ( 'forbid' == $curReqVal ) { return false; }
            else { return false; }
          } elseif ( 'forbid' == $prevReqVal ){
            if ( 'forbid' == $curReqVal ){ return true; }
            elseif ( 'require' == $curReqVal ){ return false; }
            else { return false; }
          } else { return false; }
        }
      ),
      'version' => array(
        'value' => $this->get_latest_stable_version(),
        'is_compatible' => function($prevReqVal, $curReqVal){
          return $prevReqVal == $curReqVal; // hardcode a trivial test for now
        },
        'keep_prev_when_compatible' => true
      )
    );

    $bailEarlyReq = null;

    $clients = array();

    // Iterate through each set of requirements registered by a client
    foreach( $this->reqs as $req ) {
      $clients[$req['name']] = $req['client-call'];
      // For this set of requirements, iterate through each requirement key, like ['method', 'v4shim', ... ]
      foreach( $req as $key => $payload ){
        if ( in_array($key, ['client-call', 'name']) ) continue; // these are meta keys that we won't process here.
        if( array_key_exists('client-reqs', $loadSpec[$key]) ) {
          // This client has registered a requirement on a key where a req has already been established.
          // So we need to compare to see if these requirements are compatible.
          // First, record that this client has made this new requirement.
          array_unshift($loadSpec[$key]['client-reqs'], $req);
          if (call_user_func( $loadSpec[$key]['is_compatible'], $loadSpec[$key]['value'], $req[$key] ) ) {
            // The previous and current requirements are compatible, so (optionally) update the value
            $loadSpec[$key]['keep_prev_when_compatible'] || $loadSpec[$key]['value'] = $req[$key];
          } else {
            // the compatibility test failed
            $bailEarlyReq = $key;
            break 2;
          }
        } else {
          // Add this as the first client to make this requirement.
          $loadSpec[$key]['value'] = $req[$key];
          $loadSpec[$key]['client-reqs'] = [ $req ];
        }
      }
    }

    if($bailEarlyReq) {
      // call the error_callback, indicating which clients registered incompatible requirements
      is_callable($error_callback) && $error_callback(array(
        'req' => $bailEarlyReq,
        'client-reqs' => $loadSpec[$bailEarlyReq]['client-reqs']
      ));
      return null;
    }

    // This is a good place to set defaults
    // pseudo-elements: when webfonts, true
    // when svg, false
    // TODO: should this be set up in the initial loadSpec before, or must it be set at the end of the process here?
    $method = $this->specified_requirement_or_default($loadSpec['method'], 'webfont');
    $pseudo_elements_default = $method == 'webfont' ? 'require' : null;
    return array(
      'method' => $method,
      'v4shim' => $this->specified_requirement_or_default($loadSpec['v4shim'], null) == 'require',
      'pseudo-elements' => $this->specified_requirement_or_default($loadSpec['pseudo-elements'], $pseudo_elements_default) == 'require',
      'version' => $loadSpec['version']['value'],
      // For now, we'll hard code pro as always false and implement it in the future.
      'pro' => false,
    );
  }

  protected function specified_requirement_or_default($req, $default){
    return array_key_exists('value', $req) ? $req['value'] : $default;
  }

  /**
   * Returns a full version string of the latest stable version.
   */
  public function get_latest_stable_version(){
    return '5.0.13';
  }

  /**
   * Given a loading specification, enqueues Font Awesome to load accordingly.
   * Returns nothing.
   */
  protected function enqueue($loadSpec) {
    // Let's say that the default will be Webfonts with CSS, Free, all, (and when available, using the webfont shim)
    wp_enqueue_style('font-awesome-official', 'https://use.fontawesome.com/releases/v5.0.13/css/all.css', null, null);

    // Filter the <link> tag to add the integrity and crossorigin attributes for completeness.
    add_filter( 'style_loader_tag', function($html, $handle){
      if ( in_array($handle, ['font-awesome-official']) ) {
        return preg_replace('/\/>$/', 'integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous" />', $html, 1);
      } else {
        return $html;
      }
    }, 10, 2 );
  }

  public function register_requirements($req) {
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

/**
 * Main instance of FontAwesome.
 *
 * Returns the main instance of FontAwesome.
 *
 */
function FontAwesome() {
  return FontAwesome::instance();
}

FontAwesome();

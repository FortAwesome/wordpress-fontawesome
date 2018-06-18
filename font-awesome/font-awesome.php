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
    $this->reset(); // start from a clean slate on each load
    do_action('font_awesome_requirements');
    // TODO: add some WP persistent cache here so we don't needlessly retrieve latest versions and re-process
    // all requirements each time. We'd only need to do that when something changes.
    // So what are those conditions for refreshing the cache?
    $loadSpec = $this->build_load_spec(function($data){
      // TODO: figure out the best way to present diagnostic information.
      // Probably in the error_log, but if we're on the admin screen, there's
      // probably a more helpful way to do it.
      // error_log('build_load_spec: Invalid load spec -- '. print_r($data, true));
      do_action('font_awesome_failed', $data);
    });
    if( isset($loadSpec) ) {
      $this->enqueue($loadSpec);
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

    $loadSpec = array(
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

    $validKeys = array_keys($loadSpec);

    $bailEarlyReq = null;

    $clients = array();

    // Iterate through each set of requirements registered by a client
    foreach( $this->reqs as $req ) {
      $clients[$req['name']] = $req['client-call'];
      // For this set of requirements, iterate through each requirement key, like ['method', 'v4shim', ... ]
      foreach( $req as $key => $payload ){
        if ( in_array($key, ['client-call', 'name']) ) continue; // these are meta keys that we won't process here.
        // TODO: die is not graceful. What would be a more graceful way to handle this error?
        if ( ! in_array($key, $validKeys) ) die($key . " is an invalid requirement key. Only these are allowed: " . join(', ', $validKeys));
        if( array_key_exists('value', $loadSpec[$key])) {
          // Check compatibility with existing requirement value.
          // First, record that this client has made this new requirement.
          if(array_key_exists('client-reqs', $loadSpec[$key])){
            array_unshift($loadSpec[$key]['client-reqs'], $req);
          } else {
            $loadSpec[$key]['client-reqs'] = array( $req );
          }
          $resolved_req = $loadSpec[$key]['resolve']($loadSpec[$key]['value'], $req[$key]);
          if (is_null($resolved_req)) {
            // the compatibility test failed
            $bailEarlyReq = $key;
            break 2;
          } else {
            // The previous and current requirements are compatible, so update the value
            $loadSpec[$key]['value'] = $resolved_req;
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
    $pseudo_elements = $this->specified_requirement_or_default($loadSpec['pseudo-elements'], $pseudo_elements_default) == 'require';
    if( $method == 'webfont' && ! $pseudo_elements ) {
      error_log('WARNING: a client of Font Awesome has forbidden pseudo-elements, but since the webfont method has been selected, pseudo-element support cannot be eliminated.');
      $pseudo_elements = true;
    }
    return array(
      'method' => $method,
      'v4shim' => $this->specified_requirement_or_default($loadSpec['v4shim'], 'require') == 'require',
      'pseudo-elements' => $pseudo_elements,
      'version' => Semver::rsort($loadSpec['version']['value'])[0],
      'pro' => $this->is_pro_available()
    );
  }

  // TODO: replace this hard-coded implementation with a real one, based on what that web site owner configures
  // in the admin interface and stores in the db.
  function is_pro_available(){
    return false;
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
   */
  protected function enqueue($loadSpec) {
    $method = $loadSpec['method'];
    $license = $loadSpec['pro'] ? 'pro' : 'free';
    ($method == 'webfont' || $method == 'svg') || die('method must be either webfont or svg');

    $faUrl = "https://";
    $faUrl .= $license == 'pro' ? 'pro.' : 'use.';
    $faUrl .= 'fontawesome.com/releases/v' . $loadSpec['version'] . '/';
    $faShimUrl = $faUrl;

    $integrityKey = self::$integrityKeys[$license][$method]['all']; // hardcode 'all' for now

    if( $method == 'webfont' ){
      $faUrl .=  'css/all.css';
      wp_enqueue_style('font-awesome-official', $faUrl, null, null);

      // Filter the <link> tag to add the integrity and crossorigin attributes for completeness.
      add_filter( 'style_loader_tag', function($html, $handle) use($integrityKey){
        if ( in_array($handle, ['font-awesome-official']) ) {
          return preg_replace('/\/>$/', 'integrity="' . $integrityKey . '" crossorigin="anonymous" />', $html, 1);
        } else {
          return $html;
        }
      }, 10, 2 );


      if( $loadSpec['v4shim'] ){
        $faShimUrl .= 'css/v4-shims.css';
        wp_enqueue_style('font-awesome-official-v4shim', $faShimUrl, null, null);

        // TODO: add new integrity key specific to v4-shims, if necessary.
        // Filter the <link> tag to add the integrity and crossorigin attributes for completeness.
        add_filter( 'style_loader_tag', function($html, $handle) use($integrityKey){
          if ( in_array($handle, ['font-awesome-official-v4shim']) ) {
            return preg_replace('/\/>$/', 'integrity="' . $integrityKey . '" crossorigin="anonymous" />', $html, 1);
          } else {
            return $html;
          }
        }, 10, 2 );
      }
    } else {
      $faUrl .= 'js/all.js';

      wp_enqueue_script('font-awesome-official', $faUrl, null, null, false);

      // Filter the <script> tag to add the integrity and crossorigin attributes for completeness.
      add_filter( 'script_loader_tag', function($tag, $handle) use($integrityKey){
        if ( in_array($handle, ['font-awesome-official']) ) {
          return preg_replace('/\/>$/', 'integrity="' . $integrityKey . '" crossorigin="anonymous" />', $tag, 1);
        } else {
          return $tag;
        }
      }, 10, 2 );

      if( $loadSpec['v4shim'] ){
        $faShimUrl .= 'js/v4-shims.js';
        wp_enqueue_script('font-awesome-official-v4shim', $faShimUrl, null, null, false);

        // TODO: add new integrity key specific to v4-shims, if necessary.
        add_filter( 'script_loader_tag', function($tag, $handle) use($integrityKey){
          if ( in_array($handle, ['font-awesome-official-v4shim']) ) {
            return preg_replace('/\/>$/', 'integrity="' . $integrityKey . '" crossorigin="anonymous" />', $tag, 1);
          } else {
            return $tag;
          }
        }, 10, 2 );
      }
    }

    do_action('font_awesome_enqueued', $loadSpec);
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

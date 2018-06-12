<?php

/**
 * Plugin Name:       Font Awesome Plumbing
 * Plugin URI:        https://fontawesome.com/font-awesome-plumbing/
 * Description:       Manage version resolution and loading for Font Awesome Free and Pro
 * Version:           0.0.1
 * Author:            Font Awesome
 * Author URI:        https://fontawesome.com/
 * License:           UNLICENSED
 */

defined( 'WPINC' ) || die;

// 1. Make sure we haven't already been loaded
// 2. Run an action that tells all clients to say something about their version requirements
// 3. Process the results of that to determine what will be loaded
// 4. Run another action notifying everyone what will be loaded, or nothing, so they can respond
//
//

if (! class_exists('FontAwesomePlumbing') ) :

final class FontAwesomePlumbing {

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
   * The list of client dependencies.
   *
   */
  protected $deps = array();

  /**
   * Main FontAwesomePlumbing Instance.
   *
   * Ensures only one instance of FontAwesomePlumbing is loaded or can be loaded.
   */
  public static function instance() {
    if ( is_null( self::$_instance ) ) {
      self::$_instance = new self();
    }
    return self::$_instance;
  }

  public function __construct() {
    add_action( 'init', array( $this, 'gather_dependencies' ));
  }

  public function gather_dependencies() {
    do_action('font_awesome_dependencies');

    error_log('all deps: ' . print_r($this->deps, true));

    // TODO:
    // - [ ] resolve method: SVG with JavaScript or Webfonts with CSS
    // - [ ] resolve version: (only 5? or what about v4 with shims?)
    // - [ ] resolve asset URL host location: CDN or self-hosted?
    // - [ ] resolve any config: such as searchPseudoElements (which might only be relevant for SVG/JS)
    // - [ ] determine whether any shim is needed
    // - [ ] determine whether a subset of icons might suffice for loading
    // - [ ] resolve license: Free or Pro (future)
    // - [ ] Finally, enqueue either a style or a script
    //

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

    // TODO: generalize a final action to report what we ended up enqueuing for loading so that clients have an opportunity to react accordingly.
    do_action('font_awesome_enqueued', 'webfont', 'Free CDN', '5.0.13');
  }

  public function register_dependency($dep) {
    array_unshift($this->deps, $dep);
  }
}

endif; // ! class_exists

/**
 * Main instance of FontAwesomePlumbing.
 *
 * Returns the main instance of FontAwesomePlumbing.
 *
 */
function FontAwesomePlumbing() {
	return FontAwesomePlumbing::instance();
}

FontAwesomePlumbing();

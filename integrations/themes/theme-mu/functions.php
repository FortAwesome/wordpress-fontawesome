<?php
/**
 * This example theme bundles the Font Awesome WordPress composer package.
 */
define('THEME_MU_LOG_PREFIX', 'theme-mu');
define('THEME_MU_VERSION', '0.0.1');

// Load the composer package.
require_once __DIR__ . '/vendor/fortawesome/wordpress-fontawesome/index.php';
use function FortAwesome\fa;

// Register this theme as a client of Font Awesome.
add_action(
	'font_awesome_preferences',
	function() {
		fa()->register(
			array(
				'name' => THEME_MU_LOG_PREFIX,
			)
		);
	}
);

/**
 * When this theme is activated, initialize Font Awesome in a way that respects
 * other clients that may have already initialized it.
 */
add_action('after_switch_theme', 'FortAwesome\FontAwesome_Loader::initialize');

/**
 * When some other theme is activated, making this one inactive, run the deactivation
 * and uninstallation logic for Font Awesome. This will respect any other clients
 * of Font Awesome that may still be active, only cleaning up the db if this theme
 * would represent the last active client.
 */
add_action('switch_theme', function() {
	FortAwesome\FontAwesome_Loader::maybe_deactivate();
	FortAwesome\FontAwesome_Loader::maybe_uninstall();
});

// Any other theme functionality...

add_action( 'wp_enqueue_scripts', function (){
  $parent_style = 'twentyseventeen';
  // parent
  wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
  // child
  wp_enqueue_style( 'theme-mu',
      get_stylesheet_directory_uri() . '/style.css',
      array( $parent_style ),
      wp_get_theme()->get('Version')
  );
});

function theme_mu_fa_classes(){
  fa();
  $class_list = [ 'theme-mu' ];

  fa()->pro()
    ? array_push($class_list, 'fa-license-pro')
    : array_push($class_list, 'fa-license-free');

  strpos(fa()->version(), '5.0.') === 0
    ? array_push($class_list, 'fa-version-5-0')
    : array_push($class_list, 'fa-version-5-1');

  (fa()->technology() == 'svg')
    ? array_push($class_list, 'fa-method-svg')
    : array_push($class_list, 'fa-method-webfont');

  return implode(' ', $class_list);
}

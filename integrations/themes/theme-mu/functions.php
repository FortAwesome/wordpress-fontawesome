<?php
/**
 * This example theme bundles the Font Awesome WordPress composer package.
 */
define('THEME_MU_LOG_PREFIX', 'theme-mu');
define('THEME_MU_VERSION', '0.0.1');

require_once __DIR__ . '/vendor/autoload.php';
use function FortAwesome\fa;

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

add_action('after_switch_theme', 'FortAwesome\FontAwesome_Loader::initialize');

function unique_prefix_deactivate_theme() {
	FortAwesome\FontAwesome_Loader::maybe_deactivate();
	FortAwesome\FontAwesome_Loader::maybe_uninstall();
}

add_action('switch_theme', 'unique_prefix_deactivate_theme');

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

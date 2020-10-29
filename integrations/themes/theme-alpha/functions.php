<?php
/**
 * This example theme assumes the presence of the Font Awesome plugin.
 * It does not bundle Font Awesome as a library dependency, such as via composer.
 * See integrations/plugins/plugin-sigma for an example of do that.
 */
use function FortAwesome\fa;

define('THEME_ALPHA_LOG_PREFIX', 'theme-alpha');
define('THEME_ALPHA_VERSION', '0.0.1');

add_action( 'wp_enqueue_scripts', function (){
  $parent_style = 'twentyseventeen';
  // parent
  wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
  // child
  wp_enqueue_style( 'theme-alpha',
      get_stylesheet_directory_uri() . '/style.css',
      array( $parent_style ),
      wp_get_theme()->get('Version')
  );

  wp_enqueue_script( 'theme-alpha-fake-kit',
	  get_stylesheet_directory_uri() . '/fake-kit.js',
	  [], // no deps
	  null, // don't add version string
	  false // don't put it in the footer
  );
});

add_action('after_switch_theme', function(){
  error_log(THEME_ALPHA_LOG_PREFIX . ': switching theme to theme-alpha');
});

add_action(
	'font_awesome_preferences',
	function() {
		fa()->register(
			array(
				'name' => THEME_ALPHA_LOG_PREFIX,
			)
		);
	}
);

add_action('font_awesome_enqueued', function() {
	error_log(
		THEME_ALPHA_LOG_PREFIX .
		" font_awesome_enqueued: " .
		"method: " .
		fa()->technology() .
		", ver: " .
		fa()->version()
	);
}, 10, 3);

function theme_alpha_fa_classes(){
  fa();
  $class_list = [ 'theme-alpha' ];

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

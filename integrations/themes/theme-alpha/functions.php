<?php
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
});

add_action('after_switch_theme', function(){
  error_log(THEME_ALPHA_LOG_PREFIX . ': switching theme to theme-alpha');
});

add_action(
	'font_awesome_requirements',
	function() {
		if ( class_exists( 'FontAwesome' ) ) {
			fa()->register(
				array(
					'name'          => THEME_ALPHA_LOG_PREFIX,
					'clientVersion' => THEME_ALPHA_VERSION,
				)
			);
		}
	}
);

add_action('font_awesome_enqueued', function($loadSpec){
  if ( class_exists('FontAwesome') ) {
    error_log( THEME_ALPHA_LOG_PREFIX . " font_awesome_enqueued: " . "method: " . $loadSpec['method'] . ", ver: " . fa()->version());
  }
}, 10, 3);

function theme_alpha_fa_classes(){
  $fa = fa();
  $load_spec = $fa->load_spec();
  $class_list = [ 'theme-alpha' ];

  $fa->using_pro()
    ? array_push($class_list, 'fa-license-pro')
    : array_push($class_list, 'fa-license-free');

  strpos(fa()->version(), '5.0.') === 0
    ? array_push($class_list, 'fa-version-5-0')
    : array_push($class_list, 'fa-version-5-1');

  ($load_spec['method'] == 'svg')
    ? array_push($class_list, 'fa-method-svg')
    : array_push($class_list, 'fa-method-webfont');

  return implode(' ', $class_list);
}

<?php
define('THEME_ALPHA_LOG_PREFIX', 'theme-alpha');

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

add_action('font_awesome_requirements', function(){
  if ( class_exists('FontAwesome') ) {
    fa()->register(array(
      "name" => THEME_ALPHA_LOG_PREFIX,
//      "method" => 'webfont'
    ));
  }
});

add_action('font_awesome_enqueued', function($loadSpec){
  if ( class_exists('FontAwesome') ) {
    error_log( THEME_ALPHA_LOG_PREFIX . " font_awesome_enqueued: " . "method: " . $loadSpec['method'] . ", ver: " . $loadSpec['version']);
  }
}, 10, 3);

function theme_alpha_fa_classes(){
  $fa = fa();
  $load_spec = $fa->load_spec();
  $theme_alpha_class_list = [];

  $fa->using_pro()
    ? array_push($theme_alpha_class_list, 'theme-alpha-fa-license-pro')
    : array_push($theme_alpha_class_list, 'theme-alpha-fa-license-free');

  strpos($load_spec['version'], '5.0.')
    ? array_push($theme_alpha_class_list, 'theme-alpha-fa-version-5-0')
    : array_push($theme_alpha_class_list, 'theme-alpha-fa-version-5-1');

  ($load_spec['method'] == 'svg')
    ? array_push($theme_alpha_class_list, 'theme-alpha-fa-method-svg')
    : array_push($theme_alpha_class_list, 'theme-alpha-fa-method-webfont');

  return implode(' ', $theme_alpha_class_list);
}

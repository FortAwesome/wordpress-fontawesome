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

add_action('font_awesome_dependencies', function(){
  if ( class_exists('FontAwesome') ) {
    FontAwesome()->register_dependency(array("client" => THEME_ALPHA_LOG_PREFIX));
  }
});

add_action('font_awesome_enqueued', function($method, $host, $ver){
  if ( class_exists('FontAwesome') ) {
    error_log( THEME_ALPHA_LOG_PREFIX . " font_awesome_enqueued: " . "method: " . $method . ", host: " . $host . ", ver: " . $ver);
  }
}, 10, 3);
?>


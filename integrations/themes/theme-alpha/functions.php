<?php
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
})
?>

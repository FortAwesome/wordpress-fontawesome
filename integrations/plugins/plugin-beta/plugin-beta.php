<?php

/**
 * Plugin Name:       Plugin Beta
 * Plugin URI:        https://fontawesome.com/plugin-beta/
 * Description:       Test Client Plugin that depends upon Font Awesome
 * Version:           0.0.1
 * Author:            Font Awesome
 * Author URI:        https://fontawesome.com/
 * License:           UNLICENSED
 */

defined( 'WPINC' ) || die;
define( 'BETA_PLUGIN_VERSION', '0.0.1' );
define( 'BETA_PLUGIN_LOG_PREFIX', 'beta-plugin' );

add_action('font_awesome_requirements', function(){
  if ( class_exists('FontAwesome') ) {
    FontAwesome()->register(
      array(
        "name" => BETA_PLUGIN_LOG_PREFIX,
        'version' => '5.1.0',
        'v4shim' => 'require'
      )
    );
  }
});

add_action('init', function(){
  wp_enqueue_style(
    'plugin-beta-style',
    trailingslashit(plugins_url()) . trailingslashit(plugin_basename(__DIR__)) . 'style.css',
    array(),
    null,
    'all'
  );
});

add_action('font_awesome_enqueued', function($loadSpec){
  if ( class_exists('FontAwesome') ) {
    error_log( BETA_PLUGIN_LOG_PREFIX . " font_awesome_enqueued: " . "method: " . $loadSpec['method'] . ", ver: " . $loadSpec['version']);
  }
}, 10, 3);

add_filter('the_content', function($content){
  $pre_content = <<<EOT
<div class="plugin-beta-pre-content">
  <h2>Plugin Beta</h2>
  <p>Expected by plugin-beta: "fab fa-font-awesome": <i class="fab fa-font-awesome"></i></p>
  <p>Shim icon (using the v4): "fa fa-arrows": <i class="fa fa-arrows"></i></p>
  <p>Icon introduced in 5.1.0: "fas fa-angry": <i class="fas fa-angry"></i></p>
</div>
EOT;
  return $pre_content . $content;
}, 10, 1);

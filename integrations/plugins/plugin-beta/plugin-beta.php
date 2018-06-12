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

add_action('font_awesome_dependencies', function(){
  if ( class_exists('FontAwesome') ) {
    FontAwesome()->register_dependency(array("client" => BETA_PLUGIN_LOG_PREFIX));
  }
});

add_action('font_awesome_enqueued', function($method, $host, $ver){
  if ( class_exists('FontAwesome') ) {
    error_log( BETA_PLUGIN_LOG_PREFIX . " font_awesome_enqueued: " . "method: " . $method . ", host: " . $host . ", ver: " . $ver);
  }
}, 10, 3);

add_filter('the_content', function($content){
  $pre_content = <<<EOT
<div class="plugin-beta-pre-content">
  <p>Expected by plugin-beta: "fab fa-font-awesome": <i class="fab fa-font-awesome"></i></p>
</div>
EOT;
  return $pre_content . $content;
}, 10, 1);

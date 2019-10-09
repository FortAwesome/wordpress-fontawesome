<?php

/**
 * Plugin Name:       Plugin Kappa
 * Plugin URI:        https://fontawesome.com/
 * Description:       Unregistered Client: tries to enqueue its own self-hosted v4.7.0 webfont version. It prepends a block before each blog post that displays an icon with "fa fa-bathtub", which is a version 4 specification that the v4shim should translate to "fas fa-bath". It also uses some pseudo-elements with a hardcoded version 4 font-family.
 * Version:           0.0.1
 * Author:            Font Awesome
 * Author URI:        https://fontawesome.com/
 * License:           GPLv3
 */

defined( 'WPINC' ) || die;
define( 'KAPPA_PLUGIN_VERSION', '0.0.1' );
define( 'KAPPA_PLUGIN_LOG_PREFIX', 'kappa-plugin' );

add_action('wp_enqueue_scripts', function(){
  wp_enqueue_style(
  	'font-awesome-4-7',
    plugins_url( 'font-awesome-4.7.0/css/font-awesome.css', __FILE__ ),
    array(),
	null,
	'all'
  );

  wp_enqueue_style( 'plugin-kappa-style', plugins_url( 'style.css', __FILE__ ) );
}, 99);

add_filter('the_content', function($content){
  $pre_content = <<<EOT
<div class="plugin-kappa-pre-content" style="border: 1px solid grey;">
  <h2>Plugin Kappa</h2>
  <p>v4.7.0 icon name: "fa fa-bathtub": <i class="fa fa-bathtub"></i></p>
  <p class="group-icon"><code>:before</code> pseudo-element should match <code>fas fa-users</code>: <i class="fas fa-users"></i></p>
  <p class="facebook-icon"><code>:before</code> pseudo-element should match <code>fab fa-facebook</code>: <i class="fab fa-facebook"></i></p>
  <p class="hand-scissors-icon"><code>:before</code> pseudo-element should match <code>far fa-hand-scissors</code>: <i class="far fa-hand-scissors"></i></p>
</div>
EOT;
  return $pre_content . $content;
}, 10, 1);

<?php

/**
 * Plugin Name:       Plugin Gamma
 * Plugin URI:        https://fontawesome.com/
 * Description:       Unregistered Client: tries to enqueue its own v4.7.0 webfont version from cdn.jsdelivr.net. It prepends a block before each blog post that displays an icon with "fa fa-bathtub", which is a version 4 specification that the v4shim should translate to "fas fa-bath".
 * Version:           0.0.1
 * Author:            Font Awesome
 * Author URI:        https://fontawesome.com/
 * License:           GPLv3
 */

defined( 'WPINC' ) || die;
define( 'GAMMA_PLUGIN_VERSION', '0.0.1' );
define( 'GAMMA_PLUGIN_LOG_PREFIX', 'gamma-plugin' );

add_action('init', function(){
  wp_enqueue_style(
    'GAMMA_PLUGIN_LOG_PREFIX',
    'https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.css',
    array(),
    null,
    'all'
  );
});

wp_enqueue_style( 'plugin-gamma-style', plugins_url( 'style.css', __FILE__ ) );

add_action('font_awesome_enqueued', function($loadSpec){
	error_log(
		GAMMA_PLUGIN_LOG_PREFIX .
		" font_awesome_enqueued: " .
		"method: " .
		FortAwesome\fa()->fa_method() .
		", ver: " .
		FortAwesome\fa()->version()
	);
}, 10, 3);

add_filter('the_content', function($content){
  $pre_content = <<<EOT
<div class="plugin-gamma-pre-content" style="border: 1px solid grey;">
  <h2>Plugin Gamma</h2>
  <p>Expected by plugin-gamma (v4.7.0 icon name): "fa fa-bathtub": <i class="fa fa-bathtub"></i></p>
  <p class="group-icon">Also expected: before this paragraph, pseudo-element (v4.7.0 icon name group should become v5 users)</p>
  <p class="facebook-icon">Also expected: before this paragraph, pseudo-element (v4.7.0 icon name facebook should become v5 facebook-f)</p>
  <p class="hand-scissors-icon">Also expected: before this paragraph, pseudo-element (v4.7.0 icon name hand-scissors-o should become v5 hand-scissors)</p>
</div>
EOT;
  return $pre_content . $content;
}, 10, 1);

<?php

/**
 * Plugin Name:       Plugin Delta SVG with JavaScript
 * Plugin URI:        https://fontawesome.com/plugin-delta/
 * Description:       Test Client Plugin that tries to enqueue its own SVG with JavaScript
 *                    version of Font Awesome which conflicts with the FontAwesome
 *                    plugin.
 * Version:           0.0.1
 * Author:            Font Awesome
 * Author URI:        https://fontawesome.com/
 * License:           GPLv3
 */

defined( 'WPINC' ) || die;
define( 'DELTA_PLUGIN_VERSION', '0.0.1' );
define( 'DELTA_PLUGIN_LOG_PREFIX', 'delta-plugin' );

add_action('init', function(){
  wp_enqueue_script(
    'DELTA_PLUGIN_LOG_PREFIX',
    'https://use.fontawesome.com/releases/v5.0.4/js/all.js',
    array(),
    null,
    'all'
  );
});

add_action('font_awesome_enqueued', function($loadSpec){
  if ( class_exists('FontAwesome') ) {
    error_log( DELTA_PLUGIN_LOG_PREFIX . " font_awesome_enqueued: " . "method: " . $loadSpec['method'] . ", ver: " . $loadSpec['version']);
  }
}, 10, 3);


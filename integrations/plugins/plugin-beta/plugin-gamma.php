<?php

/**
 * Plugin Name:       Plugin Gamma Webfont
 * Plugin URI:        https://fontawesome.com/plugin-gamma/
 * Description:       Test Client Plugin that tries to enqueue its own webfont
 *                    version of Font Awesome which conflicts with the FontAwesome
 *                    plugin.
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

add_action('font_awesome_enqueued', function($loadSpec){
  if ( class_exists('FontAwesome') ) {
    error_log( GAMMA_PLUGIN_LOG_PREFIX . " font_awesome_enqueued: " . "method: " . $loadSpec['method'] . ", ver: " . $loadSpec['version']);
  }
}, 10, 3);


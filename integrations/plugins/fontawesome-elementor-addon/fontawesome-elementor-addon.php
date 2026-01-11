<?php

/**
 * Plugin Name:                Font Awesome Elementor Addon
 * Plugin URI:                 https://fontawesome.com/
 * Description:                Add Font Awesome Pro icons to Elementor.
 * Version:                    0.0.1
 * Author:                     Font Awesome
 * Author URI:                 https://fontawesome.com/
 * License:                    GPLv3
 * Text Domain:                fontawesome-elementor-addon
 * Requires Plugins:           elementor
 * Elementor tested up to:     3.34.1
 * Elementor Pro tested up to: 3.34.1
 */

defined( 'WPINC' ) || die;

add_action('elementor/editor/init', function() {
	require_once __DIR__ . '/autoload.php';
	\FontAwesomeElementorAddon\Plugin::instance()->init();
});

add_action( 'activate_fontawesome-elementor-addon/fontawesome-elementor-addon.php', function() {
	require_once __DIR__ . '/autoload.php';
	$api_token = getenv( 'API_TOKEN' );
	$kit_token = getenv( 'KIT_TOKEN' );
	if ( \FontAwesomeElementorAddon\Compatibility::is_compatible_for_activation() ) {
		\FontAwesomeElementorAddon\Setup_Kit::setup( $api_token, $kit_token );
	}
}, -1 );

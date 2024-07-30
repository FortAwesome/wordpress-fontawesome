<?php
namespace FortAwesome;

/**
 * Plugin Name:       Fake Font Awesome 42.0.1-rc12
 * Description:       Fake Font Awesome 42.0.1-rc12
 * Version:           42.0.1-rc12
 */

defined( 'WPINC' ) || die;

if ( ! function_exists( 'FortAwesome\font_awesome_load' ) ) {
	function font_awesome_load( $plugin_installation_path = __DIR__, $version = false ) {
		// noop.
	}
}

require_once __DIR__ . '/../../../../index.php';

FontAwesome_Loader::instance()->add( __DIR__, false );

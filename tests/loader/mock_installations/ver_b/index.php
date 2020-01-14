<?php
namespace FortAwesome;
/**
 * Plugin Name:       Fake Font Awesome 42.0.1-rc12
 * Description:       Fake Font Awesome 42.0.1-rc12
 * Version:           42.0.1-rc12
 */

defined( 'WPINC' ) || die;

if ( function_exists( 'FortAwesome\font_awesome_load' ) ) {
	font_awesome_load( __DIR__ );
}

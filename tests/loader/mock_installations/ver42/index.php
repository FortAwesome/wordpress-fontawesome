<?php
namespace FortAwesome;
/**
 * Plugin Name:       Fake Font Awesome 42
 * Description:       Fake Font Awesome 42
 * Version:           42
 */

defined( 'WPINC' ) || die;

if ( function_exists( 'FortAwesome\font_awesome_load' ) ) {
	font_awesome_load( __DIR__ );
}

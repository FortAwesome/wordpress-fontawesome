<?php
namespace FortAwesome;
/**
 * Plugin Name:       Fake Font Awesome 43
 * Description:       Fake Font Awesome 43
 * Version:           43
 */

defined( 'WPINC' ) || die;

if ( function_exists( 'FortAwesome\font_awesome_load' ) ) {
	font_awesome_load( __DIR__ );
}

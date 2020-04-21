<?php
namespace FortAwesome;

$fa_activate_call_count = 0;
$fa_initialize_call_count = 0;

class FontAwesome_Activator {
	public static function activate() {
		global $fa_activate_call_count;
		$fa_activate_call_count += 1;
		\update_option( 'font-awesome', 42 );
		\set_site_transient( 'font-awesome-releases', 42 );
	}

	public static function initialize() {
		global $fa_initialize_call_count;
		$fa_initialize_call_count += 1;
		\update_option( 'font-awesome', 42 );
		\set_site_transient( 'font-awesome-releases', 42 );
	}
}

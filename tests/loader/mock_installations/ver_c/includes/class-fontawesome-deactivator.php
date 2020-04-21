<?php
namespace FortAwesome;

$fa_deactivate_call_count = 0;
$fa_uninstall_call_count = 0;

class FontAwesome_Deactivator {
	public static function deactivate() {
		global $fa_deactivate_call_count;
		$fa_deactivate_call_count += 1;
		delete_site_transient( 'font-awesome-releases' );
	}

	public static function uninstall() {
		global $fa_uninstall_call_count;
		$fa_uninstall_call_count += 1;
		delete_option( 'font-awesome' );
	}
}

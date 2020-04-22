<?php
namespace FortAwesome;

$fa_deactivate_call_count = 0;
$fa_uninstall_call_count  = 0;

// phpcs:ignore Generic.Classes.DuplicateClassName.Found, Squiz.Commenting.ClassComment.Missing
class FontAwesome_Deactivator {
	public static function deactivate() {
		global $fa_deactivate_call_count;
		++$fa_deactivate_call_count;
		delete_site_transient( 'font-awesome-releases' );
	}

	public static function uninstall() {
		global $fa_uninstall_call_count;
		++$fa_uninstall_call_count;
		delete_option( 'font-awesome' );
	}
}

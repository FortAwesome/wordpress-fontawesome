<?php
namespace FortAwesome;

require_once trailingslashit( dirname( __FILE__ ) ) . 'class-fontawesome.php';
require_once trailingslashit( dirname( __FILE__ ) ) . 'class-fontawesome-api-settings.php';
require_once trailingslashit( dirname( __FILE__ ) ) . 'class-fontawesome-release-provider.php';

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 */
class FontAwesome_Deactivator {

	/**
	 * Any caches or transients are removed when deactivating.
	 * To remove options data, use uninstall().
	 */
	public static function deactivate() {
		if ( is_multisite() && is_network_admin() ) {
			for_each_blog(
				function( $blog_id ) {
					self::delete_transients();
				}
			);
		} else {
			self::delete_transients();
		}
	}

	private static function delete_transients() {
		FontAwesome_Release_Provider::delete_last_used_release();
		delete_transient( FontAwesome::V3DEPRECATION_TRANSIENT );
	}

	/**
	 * Delete options data.
	 */
	public static function uninstall() {
		if ( is_multisite() && is_network_admin() ) {
			for_each_blog(
				function( $blog_id ) {
					self::delete_options();
				}
			);
		} else {
			self::delete_options();
		}
	}

	private static function delete_options() {
		delete_option( FontAwesome::OPTIONS_KEY );
		FontAwesome_Release_Provider::delete_option();
		delete_option( FontAwesome::CONFLICT_DETECTION_OPTIONS_KEY );
		delete_option( FontAwesome_API_Settings::OPTIONS_KEY );
	}
}

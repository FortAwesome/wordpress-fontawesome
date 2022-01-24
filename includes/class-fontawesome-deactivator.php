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
			global $wpdb;
			$blog_ids = $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs" );
			$original_blog_id = get_current_blog_id();
		
			foreach ( $blog_ids as $blog_id ) {
				switch_to_blog( $blog_id );
				self::delete_transients_current_site();
			}

			switch_to_blog( $original_blog_id );
		} else {
			self::delete_transients_current_site();
		}
	}

	private static function delete_transients_current_site() {
		delete_site_transient( FontAwesome_Release_Provider::LAST_USED_RELEASE_TRANSIENT );
		delete_transient( FontAwesome::V3DEPRECATION_TRANSIENT );
	}

	/**
	 * Delete options data.
	 */
	public static function uninstall() {
		if ( is_network_admin() ) {
			global $wpdb;
			$blog_ids = $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs" );
			$original_blog_id = get_current_blog_id();
		
			foreach ( $blog_ids as $blog_id ) {
				switch_to_blog( $blog_id );
				self::delete_options_current_site();
			}

			switch_to_blog( $original_blog_id );
		} else {
			self::delete_options_current_site();
		}
	}

	private static function delete_options_current_site() {
		delete_option( FontAwesome::OPTIONS_KEY );
		delete_option( FontAwesome_Release_Provider::OPTIONS_KEY );
		delete_option( FontAwesome::CONFLICT_DETECTION_OPTIONS_KEY );
		delete_option( FontAwesome_API_Settings::OPTIONS_KEY );
	}
}

<?php
namespace FortAwesome;

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 */
class FontAwesome_Deactivator {

	/**
	 * Noop. All plugin options and transients are left alone when deactivating
	 * the plugin. To clean up all plugin state, use clean().
	 */
	public static function deactivate() {
		// noop
	}

	public static function clean() {
		delete_option( FontAwesome::OPTIONS_KEY );
		delete_transient( FontAwesome_Release_Provider::RELEASES_TRANSIENT );
		delete_transient( FontAwesome::V3DEPRECATION_TRANSIENT );
		delete_option( FontAwesome::UNREGISTERED_CLIENTS_OPTIONS_KEY );
	}
}

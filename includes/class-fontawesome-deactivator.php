<?php
namespace FortAwesome;

require_once trailingslashit( FONTAWESOME_DIR_PATH ) . 'includes/class-fontawesome-release-provider.php';

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 */
class FontAwesome_Deactivator {

	public static function deactivate() {
		delete_option( FontAwesome::OPTIONS_KEY );
		delete_transient( FontAwesome_Release_Provider::RELEASES_TRANSIENT );
		delete_transient( FontAwesome::V3DEPRECATION_TRANSIENT );
	}
}


<?php

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 */
class FontAwesome_Deactivator {

	public static function deactivate() {
		delete_option( FontAwesome::OPTIONS_KEY );
	}

}


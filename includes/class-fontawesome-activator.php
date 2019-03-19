<?php
namespace FortAwesome;

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 */
class FontAwesome_Activator {

	/**
	 * Sets default user options upon plugin activation.
	 */
	public static function activate() {
		update_option( FontAwesome::OPTIONS_KEY, FontAwesome::DEFAULT_USER_OPTIONS );
	}

}


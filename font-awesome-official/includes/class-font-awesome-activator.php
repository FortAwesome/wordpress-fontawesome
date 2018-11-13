<?php

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @package    FontAwesome
 * @subpackage FontAwesome/includes
 */
class FontAwesome_Activator {

	public static function activate() {
		update_option( FontAwesome::OPTIONS_KEY, FontAwesome::DEFAULT_USER_OPTIONS );
	}

}


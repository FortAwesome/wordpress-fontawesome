<?php
namespace FortAwesome;

require_once trailingslashit( dirname(__FILE__) ) . '../defines.php';
require_once trailingslashit( dirname(__FILE__) ) . 'class-fontawesome.php';

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 */
class FontAwesome_Activator {

	/**
	 * Sets default user options upon plugin activation.
	 *
	 * @throws FontAwesome_NoReleasesException
	 */
	public static function activate() {
		$version = fa()->get_latest_version();
		$options = array_merge( FontAwesome::DEFAULT_USER_OPTIONS, [ 'version' => $version ] );
		update_option( FontAwesome::OPTIONS_KEY, $options );
		update_option( FontAwesome::UNREGISTERED_CLIENTS_OPTIONS_KEY, array() );
	}
}


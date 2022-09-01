<?php
namespace FontAwesomeCleanup;

/**
 * Returns array of network plugin files to be included in global scope.
 *
 * Adapted from the private function in WP Core: wp_get_active_network_plugins()
 *
 * The default directory is wp-content/plugins. To change the default directory
 * manually, define `WP_PLUGIN_DIR` and `WP_PLUGIN_URL` in `wp-config.php`.
 *
 * @return string[] Array of absolute paths to files to include.
 */
function fa_get_active_network_plugins() {
	$active_plugins = (array) get_site_option( 'active_sitewide_plugins', array() );
	if ( empty( $active_plugins ) ) {
		return array();
	}

	$plugins        = array();
	$active_plugins = array_keys( $active_plugins );
	sort( $active_plugins );

	foreach ( $active_plugins as $plugin ) {
		if ( ! validate_file( $plugin )                     // $plugin must validate as file.
			&& '.php' === substr( $plugin, -4 )             // $plugin must end with '.php'.
			&& file_exists( WP_PLUGIN_DIR . '/' . $plugin ) // $plugin must exist.
			) {
			$plugins[] = WP_PLUGIN_DIR . '/' . $plugin;
		}
	}

	return $plugins;
}

/**
 * Retrieve an array of active and valid plugin files.
 *
 * Adapted from the private function in WP Core: wp_get_active_and_valid_plugins()
 *
 * The default directory is `wp-content/plugins`. To change the default
 * directory manually, define `WP_PLUGIN_DIR` and `WP_PLUGIN_URL`
 * in `wp-config.php`.
 *
 * @return string[] Array of paths to plugin files relative to the plugins directory.
 */
function fa_get_active_and_valid_plugins() {
	$plugins        = array();
	$active_plugins = (array) get_option( 'active_plugins', array() );

	if ( empty( $active_plugins ) || wp_installing() ) {
		return $plugins;
	}

	$network_plugins = is_multisite() ? fa_get_active_network_plugins() : false;

	foreach ( $active_plugins as $plugin ) {
		if ( ! validate_file( $plugin )                     // $plugin must validate as file.
			&& '.php' === substr( $plugin, -4 )             // $plugin must end with '.php'.
			&& file_exists( WP_PLUGIN_DIR . '/' . $plugin ) // $plugin must exist.
			// Not already included as a network plugin.
			&& ( ! $network_plugins || ! in_array( WP_PLUGIN_DIR . '/' . $plugin, $network_plugins, true ) )
			) {
			$plugins[] = WP_PLUGIN_DIR . '/' . $plugin;
		}
	}

	/*
	 * Remove plugins from the list of active plugins when we're on an endpoint
	 * that should be protected against WSODs and the plugin is paused.
	 */
	if ( wp_is_recovery_mode() ) {
		$plugins = wp_skip_paused_plugins( $plugins );
	}

	return $plugins;
}

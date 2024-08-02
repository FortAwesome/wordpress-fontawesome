<?php

namespace FortAwesome;

// Loader pattern follows that of wponion.
// Thanks to Varun Sridharan <varunsridharan23@gmail.com>.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once trailingslashit( __DIR__ ) . 'defines.php';
require_once trailingslashit( FONTAWESOME_DIR_PATH ) . 'includes/class-fontawesome-exception.php';
require_once trailingslashit( FONTAWESOME_DIR_PATH ) . 'includes/error-util.php';

if ( defined( 'FONTAWESOME_OFFICIAL_LOADED' ) ) {
	return;
}

/**
 * This hook ensures that when we're in multisite mode, and a new site is activated
 * after an initial plugin activation, that the plugin is initialized for that newly
 * created site, but only if this plugin is otherwise network activated.
 *
 * If the plugin is only activated on a per-site basis, then creating a new site should
 * not result in this plugin automatically being activated for it.
 */
if ( is_multisite() ) {
	add_action(
		'wp_initialize_site',
		function ( $site ) {
			if ( ! is_network_admin( FONTAWESOME_PLUGIN_FILE ) ) {
				return;
			}

			require_once trailingslashit( FONTAWESOME_DIR_PATH ) . 'includes/class-fontawesome-activator.php';
			switch_to_blog( $site->blog_id );

			try {
				FontAwesome_Activator::initialize_current_site( false );
			} finally {
				restore_current_blog();
			}
		},
		99,
		1
	);
}

register_deactivation_hook(
	FONTAWESOME_DIR_PATH . 'index.php',
	function () {
		try {
			require_once FONTAWESOME_DIR_PATH . 'includes/class-fontawesome-deactivator.php';
			FontAwesome_Deactivator::deactivate();
		} catch ( Exception $e ) {
			/**
			 * This will not block the deactivation since we're not exiting, but it will probably flash
			 * this error message before redirecting to plugins.php to report that the plugin was deactivated.
			 */
			echo '<div class="error"><p>Fatal exception while deactivating Font Awesome.</p></div>';
		} catch ( Error $e ) {
			echo '<div class="error"><p>Fatal error while deactivating Font Awesome.</p></div>';
		}
	}
);

try {
	require_once trailingslashit( FONTAWESOME_DIR_PATH ) . 'includes/class-fontawesome.php';

	define( 'FONTAWESOME_OFFICIAL_LOADED', 1 );
	fa()->init();
} catch ( Exception $e ) {
	notify_admin_fatal_error( $e );
} catch ( Error $e ) {
	notify_admin_fatal_error( $e );
}

<?php

namespace FortAwesome;

// Loader pattern follows that of wponion.
// Thanks to Varun Sridharan <varunsridharan23@gmail.com>.
if (!defined('ABSPATH')) {
	exit;
}

require_once trailingslashit(__DIR__) . 'defines.php';
require_once trailingslashit(FONTAWESOME_DIR_PATH) . 'includes/class-fontawesome-exception.php';
require_once trailingslashit(FONTAWESOME_DIR_PATH) . 'includes/error-util.php';
require_once trailingslashit(FONTAWESOME_DIR_PATH) . 'block-editor/block_init.php';

if (!function_exists('FortAwesome\fa_handle_init')) {
	function fa_handle_init()
	{
		// TODO: maybe rewire so that FontAwesome::init() always runs on init,
		// which is what it claims to do.
		wp_register_script(
			'font-awesome-block-editor',
			trailingslashit(FONTAWESOME_DIR_URL) . 'block-editor/build/index.js',
			array(
				FontAwesome::ADMIN_RESOURCE_HANDLE,
				FontAwesome::RESOURCE_HANDLE_ICON_CHOOSER,
			),
			FontAwesome::PLUGIN_VERSION
		);

		block_init();
	}
}

if (!defined('FONTAWESOME_OFFICIAL_LOADED')) {
	register_deactivation_hook(
		FONTAWESOME_DIR_PATH . 'index.php',
		function () {
			try {
				require_once FONTAWESOME_DIR_PATH . 'includes/class-fontawesome-deactivator.php';
				FontAwesome_Deactivator::deactivate();
			} catch (Exception $e) {
				/**
				 * This will not block the deactivation since we're not exiting, but it will probably flash
				 * this error message before redirecting to plugins.php to report that the plugin was deactivated.
				 */
				echo '<div class="error"><p>Fatal exception while deactivating Font Awesome.</p></div>';
			} catch (Error $e) {
				echo '<div class="error"><p>Fatal error while deactivating Font Awesome.</p></div>';
			}
		}
	);

	try {
		require_once trailingslashit(FONTAWESOME_DIR_PATH) . 'includes/class-fontawesome.php';

		define('FONTAWESOME_OFFICIAL_LOADED', 1);
		fa()->run();
	} catch (Exception $e) {
		notify_admin_fatal_error($e);
	} catch (Error $e) {
		notify_admin_fatal_error($e);
	}
}

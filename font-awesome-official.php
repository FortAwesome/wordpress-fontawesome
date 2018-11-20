<?php
/**
 * Plugin Name:       Font Awesome
 * Plugin URI:        https://fontawesome.com/wp-font-awesome/
 * Description:       Manage version resolution and loading for Font Awesome Free and Pro
 * Version:           0.1.0
 * Author:            Font Awesome
 * Author URI:        https://fontawesome.com/
 * License:           GPLv2 (or later)
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 *
 * @noinspection PhpIncludeInspection
 */

defined( 'WPINC' ) || die;

if(! defined('FONT_AWESOME_OFFICIAL_LOADED')) {
	require_once __DIR__ . '/defines.php';

	register_activation_hook(
		__FILE__,
		function() {
			require_once FONTAWESOME_DIR_PATH . 'includes/class-fontawesome-activator.php';
			FontAwesome_Activator::activate();
		}
	);

	register_deactivation_hook(
		__FILE__,
		function() {
			require_once FONTAWESOME_DIR_PATH . 'includes/class-fontawesome-deactivator.php';
			FontAwesome_Deactivator::deactivate();
		}
	);

	require_once FONTAWESOME_DIR_PATH . 'includes/class-fontawesome.php';

	define('FONT_AWESOME_OFFICIAL_LOADED', 1);
	fa()->run();
}

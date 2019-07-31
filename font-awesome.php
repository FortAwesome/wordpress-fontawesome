<?php
namespace FortAwesome;

use \Exception, \Error;

/**
 * Plugin Name:       Font Awesome
 * Plugin URI:        https://fontawesome.com/how-to-use/on-the-web/using-with/wordpress
 * Description:       Adds Font Awesome 5 icons to your WordPress site. Supports Font Awesome Pro. Resolves conflicts across many plugins or themes that use Font Awesome.
 * Version:           4.0.0-rc13
 * Author:            Font Awesome
 * Author URI:        https://fontawesome.com/
 * License:           GPLv2 (or later)
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 *
 * @noinspection PhpIncludeInspection
 */

defined( 'WPINC' ) || die;

if ( ! function_exists( 'font_awesome_handle_fatal_error' ) ) {
	/**
	 * Handle fatal errors
	 *
	 * @ignore
	 */
	function font_awesome_handle_fatal_error( $message = null ) {
		add_action(
			'admin_notices',
			function () use ( $message ) {
				?>
				<div class="error"><p>The Font Awesome plugin has experienced a fatal error
					<?php
					if ( ! is_null( $message ) ) {
						echo esc_html( ": $message" );
					}
					?>
				</p></div>
				<?php
			}
		);
	}
}

if ( ! defined( 'FONT_AWESOME_OFFICIAL_LOADED' ) ) {
	require_once __DIR__ . '/defines.php';

	register_activation_hook(
		__FILE__,
		function() {
			try {
				require_once FONTAWESOME_DIR_PATH . 'includes/class-fontawesome-activator.php';
				FontAwesome_Activator::activate();
			} catch ( Exception $e ) {
				echo '<div class="error"><p>Sorry, Font Awesome could not be activated.</p></div>';
				exit;
			} catch ( Error $e ) {
				echo '<div class="error"><p>Sorry, Font Awesome could not be activated.</p></div>';
				exit;
			}
		}
	);

	register_deactivation_hook(
		__FILE__,
		function() {
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
		require_once FONTAWESOME_DIR_PATH . 'includes/class-fontawesome.php';

		define( 'FONT_AWESOME_OFFICIAL_LOADED', 1 );
		fa()->run();
	} catch ( Exception $e ) {
		font_awesome_handle_fatal_error( $e->getMessage() );
	} catch ( Error $e ) {
		font_awesome_handle_fatal_error( $e->getMessage() );
	}
}

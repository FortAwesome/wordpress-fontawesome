<?php
namespace FortAwesome;

// Loader pattern follows that of wponion.
// Thanks to Varun Sridharan <varunsridharan23@gmail.com>.

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once trailingslashit( __DIR__ ) . 'defines.php';

if ( ! function_exists( 'FortAwesome\font_awesome_handle_fatal_error' ) ) {
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

if ( ! defined( 'FONTAWESOME_OFFICIAL_LOADED' ) ) {
	register_deactivation_hook(
		FONTAWESOME_DIR_PATH . 'index.php',
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

		define( 'FONTAWESOME_OFFICIAL_LOADED', 1 );
		fa()->run();
	} catch ( Exception $e ) {
		font_awesome_handle_fatal_error( $e->getMessage() );
	} catch ( Error $e ) {
		font_awesome_handle_fatal_error( $e->getMessage() );
	}
}

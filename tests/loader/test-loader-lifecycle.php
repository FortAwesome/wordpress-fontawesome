<?php
namespace FortAwesome;

/**
 * FontAwesomeLoaderTestLifecycle class
 *
 * @runTestsInSeparateProcesses
 */
class FontAwesomeLoaderTestLifecycle extends \WP_UnitTestCase {
	public function setUp() {
		\delete_site_transient( 'font-awesome-releases' );
		\delete_option( 'font-awesome' );
		require_once dirname( __FILE__ ) . '/mock_installations/ver_c/index.php';
		global $fa_deactivate_call_count;
		global $fa_uninstall_call_count;
		global $fa_initialize_call_count;

		$fa_deactivate_call_count = 0;
		$fa_uninstall_call_count = 0;
		$fa_initialize_call_count = 0;

		// Trigger the load of the plugin
		do_action('wp_loaded');
	}

	public function test_initialize() {
		$this->assertFalse( get_option( 'font-awesome' ) );

		FontAwesome_Loader::initialize();

		$this->assertTrue( boolval( get_option( 'font-awesome' ) ) );
	}

	/**
	 * When two of them are loaded, having the same version, and maybe_deactivate()
	 * is invoked, the plugin should NOT be deactivated.
	 */
	public function test_maybe_deactivate() {
		FontAwesome_Loader::maybe_deactivate();

		$this->assertFalse(
			\get_site_transient( 'font-awesome-releases' )
		);
	}
}

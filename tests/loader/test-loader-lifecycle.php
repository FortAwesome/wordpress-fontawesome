<?php
namespace FortAwesome;

use Yoast\WPTestUtils\WPIntegration\TestCase;

/**
 * FontAwesomeLoaderTestLifecycle class
 */
class FontAwesomeLoaderTestLifecycle extends TestCase {
	public function set_up() {
		parent::set_up();
		\delete_site_transient( 'font-awesome-releases' );
		\delete_option( 'font-awesome' );
		require_once __DIR__ . '/mock_installations/ver_c/index.php';
		global $fa_deactivate_call_count;
		global $fa_uninstall_call_count;
		global $fa_initialize_call_count;

		$fa_deactivate_call_count = 0;
		$fa_uninstall_call_count  = 0;
		$fa_initialize_call_count = 0;

		// Trigger the load of the plugin.
		do_action( 'wp_loaded' );
	}

	public function test_initialize() {
		$this->assertFalse( get_option( 'font-awesome' ) );

		FontAwesome_Loader::initialize();

		$this->assertTrue( boolval( get_option( 'font-awesome' ) ) );

		global $fa_initialize_call_count;
		$this->assertEquals( 1, $fa_initialize_call_count );
	}

	public function test_maybe_deactivate() {
		FontAwesome_Loader::initialize();
		FontAwesome_Loader::maybe_deactivate();

		$this->assertFalse(
			\get_site_transient( 'font-awesome-releases' )
		);

		global $fa_deactivate_call_count;
		$this->assertEquals( 1, $fa_deactivate_call_count );
	}

	public function test_maybe_uninstall() {
		FontAwesome_Loader::initialize();
		FontAwesome_Loader::maybe_uninstall();

		$this->assertFalse(
			\get_option( 'font-awesome' )
		);

		global $fa_uninstall_call_count;
		$this->assertEquals( 1, $fa_uninstall_call_count );
	}
}

<?php
namespace FortAwesome;

use Yoast\WPTestUtils\WPIntegration\TestCase;

/**
 * FontAwesomeLoaderTestRedundantVersions class
 */
class FontAwesomeLoaderTestRedundantVersions extends TestCase {
	public function set_up() {
		parent::set_up();
		require_once __DIR__ . '/mock_installations/ver_a/index.php';
		require_once __DIR__ . '/mock_installations/ver_c/index.php';
		// Trigger the load of the plugin.
		do_action( 'wp_loaded' );
		\set_site_transient( 'font-awesome-releases', 42 );
	}

	public function tear_down() {
		parent::tear_down();
		\delete_site_transient( 'font-awesome-releases' );
	}

	/**
	 * When two of them are loaded, having the same version, and maybe_deactivate()
	 * is invoked, the plugin should NOT be deactivated.
	 */
	public function test_maybe_deactivate_with_multiple_instances_of_same_version() {
		FontAwesome_Loader::maybe_deactivate();

		$this->assertEquals(
			\get_site_transient( 'font-awesome-releases' ),
			42
		);
	}
}

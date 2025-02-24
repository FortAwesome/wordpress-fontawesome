<?php

namespace FortAwesome;

use Yoast\WPTestUtils\WPIntegration\TestCase;

/**
 * FontAwesomeLoaderTestBasic class
 */
class FontAwesomeLoaderTestBasic extends TestCase {

	public function set_up() {
		parent::set_up();
		require_once __DIR__ . '/mock_installations/ver_a/index.php';
		require_once __DIR__ . '/mock_installations/ver_b/index.php';

		// Trigger the load of the plugin.
		do_action( 'init' );
	}
	// It should choose the latest *semantic* version.
	public function test_select_latest_plugin_installation() {
		$this->assertEquals(
			loader_scenario_version(),
			'42.0.1'
		);
		$this->assertEquals(
			FontAwesome_Loader::instance()->loaded_path(),
			trailingslashit( __DIR__ ) . 'mock_installations/ver_a/'
		);
	}
}

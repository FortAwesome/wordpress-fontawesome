<?php
namespace FortAwesome;

class FontAwesomeLoaderTest extends \WP_UnitTestCase {
	// It should choose the latest *semantic* version.
	public function test_select_latest_plugin_installation() {
		$this->assertEquals(
			loader_scenario_version(),
			'42.0.1'
		);
		$this->assertEquals(
			FontAwesome_Loader::instance()->loaded_path(),
			trailingslashit(__DIR__) . 'mock_installations/ver_a/'
		);
	}
}

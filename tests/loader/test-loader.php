<?php
namespace FortAwesome;

class FontAwesomeLoaderTest extends \WP_UnitTestCase {
	public function test_select_latest_plugin_installation() {
		$this->assertEquals(
			loader_scenario_version(),
			43
		);
	}
}

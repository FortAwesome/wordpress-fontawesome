<?php
namespace FortAwesome;

/**
 * FontAwesomeLoaderTestBasic class
 *
 * @runTestsInSeparateProcesses
 */
class FontAwesomeLoaderTestBasic extends \WP_UnitTestCase {
	public function setUp() {
		require_once dirname( __FILE__ ) . '/mock_installations/ver_a/index.php';
		require_once dirname( __FILE__ ) . '/mock_installations/ver_b/index.php';

		// Trigger the load of the plugin.
		do_action( 'wp_loaded' );
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

	public function test_escape_stack_trace() {
		$input    = <<<EOD
line 1
line "2"
line '3'
EOD;
		$expected = <<<EOD
line 1\\nline \"2\"\\nline \'3\'
EOD;
		$this->assertEquals( $expected, FontAwesome_Loader::escape_error_output( $input ) );
	}
}

<?php
namespace FortAwesome;

use Yoast\WPTestUtils\WPIntegration\TestCase;

/**
 * EscapeErrorOutputTest class
 */
class EscapeErrorOutputTest extends TestCase {
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

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

	public function test_escape_errors_with_javascript_unicode_sequences() {
		// The \u sequence would be interepreted by JavaScript as a unicode sequence unless escaped.
		$input    = <<<EOD
message: Call to undefined function FortAwesome\ugly_function()
EOD;
		$expected = <<<EOD
message: Call to undefined function FortAwesome\\x5Cugly_function()
EOD;
		$this->assertEquals( $expected, FontAwesome_Loader::escape_error_output( $input ) );

		// The \x sequence would be interepreted by JavaScript as a unicode sequence unless escaped.
		$input    = <<<EOD
message: Call to undefined function FortAwesome\\xact_function()
EOD;
		$expected = <<<EOD
message: Call to undefined function FortAwesome\\x5Cxact_function()
EOD;
		$this->assertEquals( $expected, FontAwesome_Loader::escape_error_output( $input ) );

		// What if both are in the same string?
		$input    = <<<EOD
foo\\xact_function() bar\\ugly_function()
EOD;
		$expected = <<<EOD
foo\\x5Cxact_function() bar\\x5Cugly_function()
EOD;
		$this->assertEquals( $expected, FontAwesome_Loader::escape_error_output( $input ) );
	}
}

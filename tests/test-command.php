<?php
namespace FortAwesome;
/**
 * Class CommandTest
 *
 * @noinspection PhpCSValidationInspection
 */
// phpcs:ignoreFile Squiz.Commenting.ClassComment.Missing
// phpcs:ignoreFile Generic.Commenting.DocComment.MissingShort
require_once dirname( __FILE__ ) . '/../includes/class-fontawesome-command.php';

use Yoast\WPTestUtils\WPIntegration\TestCase;

class CommandTest extends TestCase {
	public function test_command_basic() {
		$val = 42;
		$cmd = new FontAwesome_Command(
			function() use ( $val ) {
				return $val;
			}
		);

		$this->assertEquals(
			42,
			$cmd->run()
		);
	}

	public function test_command_with_args() {
		$val = 42;
		$arg1 = 1;
		$arg2 = 2;

		$cmd = new FontAwesome_Command(
			function( $a1, $a2 ) use ( $val ) {
				return $val + $a1 + $a2;
			}
		);

		$this->assertEquals(
			45,
			$cmd->run( $arg1, $arg2 )
		);
	}
}

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

class CommandTest extends \WP_UnitTestCase {
	public function test_command_basic() {
		$val = 42;
		$cmd = new FontAwesome_Command(function() use ($val){
			return $val;
		});

		$this->assertEquals(
			42,
			$cmd->run()
		);
	}
}

<?php
namespace FortAwesome;

require_once __DIR__ . '/../includes/class-fontawesome-deactivator.php';
require_once __DIR__ . '/../includes/class-fontawesome-api-settings.php';
use Yoast\WPTestUtils\WPIntegration\TestCase;

/**
 * Class DeactivationTest
 */
class DeactivationTest extends TestCase {

	public function set_up() {
		parent::set_up();
		reset_db();
		remove_all_filters( 'option_' . FontAwesome_Release_Provider::OPTIONS_KEY );
	}

	public function test_deactivate_preserves_options_deletes_transients() {
		$foobar = array( 'foo' => 'bar' );
		update_option( FontAwesome::OPTIONS_KEY, $foobar );
		update_option( FontAwesome_Release_Provider::OPTIONS_KEY, $foobar );
		update_option( FontAwesome::CONFLICT_DETECTION_OPTIONS_KEY, $foobar );

		FontAwesome_Deactivator::deactivate();

		$this->assertEquals(
			get_option( FontAwesome::OPTIONS_KEY ),
			$foobar
		);

		$this->assertEquals(
			get_option( FontAwesome_Release_Provider::OPTIONS_KEY ),
			$foobar
		);

		$this->assertEquals(
			get_option( FontAwesome::CONFLICT_DETECTION_OPTIONS_KEY ),
			$foobar
		);
	}

	public function test_uninstall_removes_options_data() {
		$foobar = array( 'foo' => 'bar' );
		update_option( FontAwesome::OPTIONS_KEY, $foobar );
		update_option( FontAwesome::CONFLICT_DETECTION_OPTIONS_KEY, $foobar );
		update_option( FontAwesome_API_Settings::OPTIONS_KEY, $foobar );

		FontAwesome_Deactivator::uninstall();

		$this->assertFalse( get_option( FontAwesome::OPTIONS_KEY ) );

		$this->assertFalse(
			get_option( FontAwesome::CONFLICT_DETECTION_OPTIONS_KEY )
		);

		$this->assertFalse(
			get_option( FontAwesome_API_Settings::OPTIONS_KEY )
		);
	}
}

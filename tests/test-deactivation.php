<?php
namespace FortAwesome;

require_once dirname( __FILE__ ) . '/../includes/class-fontawesome-deactivator.php';
require_once dirname( __FILE__ ) . '/../includes/class-fontawesome-api-settings.php';

/**
 * Class ActivationTest
 */
class DeactivationTest extends \WP_UnitTestCase {

	public function test_deactivate_preserves_options_deletes_transients() {
		$foobar = array( 'foo' => 'bar' );
		set_transient( FontAwesome::V3DEPRECATION_TRANSIENT, $foobar );
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

		$this->assertFalse(
			get_transient( FontAwesome::V3DEPRECATION_TRANSIENT )
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

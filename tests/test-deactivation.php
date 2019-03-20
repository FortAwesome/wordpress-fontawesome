<?php
namespace FortAwesome;

require_once dirname( __FILE__ ) . '/../includes/class-fontawesome-deactivator.php';

/**
 * Class ActivationTest
 */
class DeactivationTest extends \WP_UnitTestCase {

	public function setUp() {
		set_transient( FontAwesome_Release_Provider::RELEASES_TRANSIENT, array( 'foo' => 'bar' ) );
		set_transient( FontAwesome::V3DEPRECATION_TRANSIENT, array( 'foo' => 'bar' ) );
		update_option( FontAwesome::OPTIONS_KEY, array( 'foo' => 'bar' ) );
	}

	public function test_deactivation_deletes_db_state() {
		FontAwesome_Deactivator::deactivate();

		// Options.
		$options = get_option( FontAwesome::OPTIONS_KEY );
		$this->assertFalse( $options );

		// Releases transient.
		$this->assertFalse( get_transient( FontAwesome_Release_Provider::RELEASES_TRANSIENT ) );

		// V3 Deprecation Transient.
		$this->assertFalse( get_transient( FontAwesome::V3DEPRECATION_TRANSIENT ) );
	}
}

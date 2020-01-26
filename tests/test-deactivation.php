<?php
namespace FortAwesome;

require_once dirname( __FILE__ ) . '/../includes/class-fontawesome-deactivator.php';

/**
 * Class ActivationTest
 */
class DeactivationTest extends \WP_UnitTestCase {

	public function test_deactivate_preserves_options_deletes_transients() {
		$foobar = array( 'foo' => 'bar' );
		set_site_transient( FontAwesome_Release_Provider::RELEASES_TRANSIENT, $foobar );
		set_transient( FontAwesome::V3DEPRECATION_TRANSIENT, $foobar );
		update_option( FontAwesome::OPTIONS_KEY, $foobar );
		update_option( FontAwesome::UNREGISTERED_CLIENTS_OPTIONS_KEY, $foobar );

		FontAwesome_Deactivator::deactivate();

		$this->assertEquals(
			get_option( FontAwesome::OPTIONS_KEY ),
			$foobar
		);

		$this->assertEquals(
			get_option( FontAwesome::UNREGISTERED_CLIENTS_OPTIONS_KEY ),
			$foobar
		);

		$this->assertFalse(
			get_transient( FontAwesome::V3DEPRECATION_TRANSIENT )
		);

		$this->assertFalse(
			get_site_transient( FontAwesome_Release_Provider::RELEASES_TRANSIENT )
		);
	}

	public function test_uninstall_removes_options_data() {
		$foobar = array( 'foo' => 'bar' );
		update_option( FontAwesome::OPTIONS_KEY, $foobar );
		update_option( FontAwesome::UNREGISTERED_CLIENTS_OPTIONS_KEY, $foobar );

		FontAwesome_Deactivator::uninstall();

		$this->assertFalse( get_option( FontAwesome::OPTIONS_KEY ) );

		$this->assertFalse(
			get_option( FontAwesome::UNREGISTERED_CLIENTS_OPTIONS_KEY )
		);
	}
}

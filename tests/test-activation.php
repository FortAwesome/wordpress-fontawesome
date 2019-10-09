<?php
namespace FortAwesome;

require_once dirname( __FILE__ ) . '/../includes/class-fontawesome-activator.php';

/**
 * Class ActivationTest
 */
class ActivationTest extends \WP_UnitTestCase {

	/**
	 * Reset test data.
	 *
	 * @before
	 */
	protected function reset() {
		delete_option( FontAwesome::OPTIONS_KEY );
		delete_option( FontAwesome::UNREGISTERED_CLIENTS_OPTIONS_KEY );
		FontAwesome::reset();
		Mock_FontAwesome_Releases::mock();
	}

	public function test_before_activation() {
		$options = get_option( FontAwesome::OPTIONS_KEY );
		$this->assertFalse( $options );
	}

	public function test_activation_creates_default_config() {
		FontAwesome_Activator::activate();
		$actual_options   = get_option( FontAwesome::OPTIONS_KEY );
		$expected_options = array_merge( FontAwesome::DEFAULT_USER_OPTIONS, [ 'version' => fa()->get_latest_version() ] );
		$this->assertEquals( $expected_options, $actual_options );

		$this->assertEquals(
			array(),
			get_option( FontAwesome::UNREGISTERED_CLIENTS_OPTIONS_KEY )
		);
	}
}

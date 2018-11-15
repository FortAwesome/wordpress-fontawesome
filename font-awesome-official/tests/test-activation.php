<?php

require_once dirname( __FILE__ ) . '/../includes/class-fontawesome-activator.php';
require_once dirname( __FILE__ ) . '/../includes/class-fontawesome-deactivator.php';

/**
 * Class ActivationTest
 */
class ActivationTest extends WP_UnitTestCase {

	/**
	 * Reset test data.
	 *
	 * @before
	 */
	protected function reset() {
		delete_option( FontAwesome::OPTIONS_KEY );
	}

	public function test_before_activation() {
		$options = get_option( FontAwesome::OPTIONS_KEY );
		$this->assertFalse( $options );
	}

	public function test_activation_creates_default_config() {
		FontAwesome_Activator::activate();
		$options = get_option( FontAwesome::OPTIONS_KEY );
		$this->assertEquals( FontAwesome::DEFAULT_USER_OPTIONS['adminClientLoadSpec']['name'], $options['adminClientLoadSpec']['name'] );
	}
}

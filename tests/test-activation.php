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
		$expected_options = array_merge( FontAwesome::DEFAULT_USER_OPTIONS, [ 'version' => fa()->latest_version() ] );
		$this->assertEquals( $expected_options, $actual_options );

		$this->assertEquals(
			array(),
			get_option( FontAwesome::UNREGISTERED_CLIENTS_OPTIONS_KEY )
		);
	}

	public function test_initialize_from_scratch_creates_default_config() {
		FontAwesome_Activator::initialize();
		$actual_options   = get_option( FontAwesome::OPTIONS_KEY );
		$expected_options = array_merge( FontAwesome::DEFAULT_USER_OPTIONS, [ 'version' => fa()->latest_version() ] );
		$this->assertEquals( $expected_options, $actual_options );

		$this->assertEquals(
			array(),
			get_option( FontAwesome::UNREGISTERED_CLIENTS_OPTIONS_KEY )
		);
	}

	public function test_initialize_preserves_existing_options() {
		$expected_options = array_merge( FontAwesome::DEFAULT_USER_OPTIONS, [ 'version' => '5.11.1', 'usePro' => ! FontAwesome::DEFAULT_USER_OPTIONS['usePro'] ] );
		update_option( FontAwesome::OPTIONS_KEY, $expected_options );

		$expected_unregistered_clients_options = array(
			'a9a9aa2d454f77cd623d6755c902c408' => array(
			'type' => 'script',
			'src'  => 'http://example.com/fake.js'
			),
		);
    	update_option(
			FontAwesome::UNREGISTERED_CLIENTS_OPTIONS_KEY,
			$expected_unregistered_clients_options
		);

		FontAwesome_Activator::initialize();
		$actual_options = get_option( FontAwesome::OPTIONS_KEY );
		$actual_unregistered_clients_options = get_option( FontAwesome::UNREGISTERED_CLIENTS_OPTIONS_KEY );

		$this->assertEquals( $expected_options, $actual_options );

		$this->assertEquals(
			$expected_unregistered_clients_options,
			$actual_unregistered_clients_options
		);
	}

	public function test_initialize_force_overwrites_with_defaults() {
		$initial_options = array_merge( FontAwesome::DEFAULT_USER_OPTIONS, [ 'version' => '5.11.1', 'usePro' => ! FontAwesome::DEFAULT_USER_OPTIONS['usePro'] ] );
		update_option( FontAwesome::OPTIONS_KEY, $initial_options );

		$initial_unregistered_clients_options = array(
			'a9a9aa2d454f77cd623d6755c902c408' => array(
			'type' => 'script',
			'src'  => 'http://example.com/fake.js'
			),
		);
    	update_option(
			FontAwesome::UNREGISTERED_CLIENTS_OPTIONS_KEY,
			$initial_unregistered_clients_options
		);

		$expected_options = array_merge( FontAwesome::DEFAULT_USER_OPTIONS, [ 'version' => fa()->latest_version() ] );

		FontAwesome_Activator::initialize(TRUE);
		$actual_options = get_option( FontAwesome::OPTIONS_KEY );
		$actual_unregistered_clients_options = get_option( FontAwesome::UNREGISTERED_CLIENTS_OPTIONS_KEY );

		$this->assertEquals( $expected_options, $actual_options );

		$this->assertEquals(
			array(),
			get_option( FontAwesome::UNREGISTERED_CLIENTS_OPTIONS_KEY )
		);
	}
}

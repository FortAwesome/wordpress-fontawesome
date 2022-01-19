<?php
namespace FortAwesome;

require_once dirname( __FILE__ ) . '/../includes/class-fontawesome-activator.php';
require_once dirname( __FILE__ ) . '/../includes/class-fontawesome-exception.php';
require_once dirname( __FILE__ ) . '/_support/font-awesome-phpunit-util.php';

use Yoast\WPTestUtils\WPIntegration\TestCase;

/**
 * Class ActivationTest
 */
class ActivationTest extends TestCase {

	public function set_up() {
		parent::set_up();

		reset_db();
		remove_all_actions( 'font_awesome_preferences' );
		FontAwesome::reset();
		( new Mock_FontAwesome_Metadata_Provider() )->mock(
			array(
				wp_json_encode(
					array(
						'data' => graphql_releases_query_fixture(),
					)
				),
			)
		);
	}

	public function test_before_activation() {
		$this->assertFalse( get_option( FontAwesome::OPTIONS_KEY ) );
		$this->assertFalse( get_option( FontAwesome::CONFLICT_DETECTION_OPTIONS_KEY ) );
		$this->assertFalse( get_option( FontAwesome_Release_Provider::OPTIONS_KEY ) );
	}

	public function test_activation_creates_default_config() {
		FontAwesome_Activator::activate();
		$actual_options   = get_option( FontAwesome::OPTIONS_KEY );
		$expected_options = array_merge( FontAwesome::DEFAULT_USER_OPTIONS, array( 'version' => fa()->latest_version() ) );
		$this->assertEquals( $expected_options, $actual_options );

		$releases = get_option( FontAwesome_Release_Provider::OPTIONS_KEY );
		$this->assertTrue( boolval( $releases ) );

		$this->assertEquals(
			FontAwesome::DEFAULT_CONFLICT_DETECTION_OPTIONS,
			get_option( FontAwesome::CONFLICT_DETECTION_OPTIONS_KEY )
		);
	}

	public function test_initialize_from_scratch_creates_default_config() {
		FontAwesome_Activator::initialize();
		$actual_options   = get_option( FontAwesome::OPTIONS_KEY );
		$expected_options = array_merge( FontAwesome::DEFAULT_USER_OPTIONS, array( 'version' => fa()->latest_version() ) );
		$this->assertEquals( $expected_options, $actual_options );

		$this->assertEquals(
			FontAwesome::DEFAULT_CONFLICT_DETECTION_OPTIONS,
			get_option( FontAwesome::CONFLICT_DETECTION_OPTIONS_KEY )
		);
	}

	public function test_initialize_preserves_existing_options() {
		$expected_options = array_merge(
			FontAwesome::DEFAULT_USER_OPTIONS,
			array(
				'version' => '5.11.1',
				'usePro'  => ! FontAwesome::DEFAULT_USER_OPTIONS['usePro'],
			)
		);
		update_option( FontAwesome::OPTIONS_KEY, $expected_options );

		$expected_conflict_detection_option = array(
			'detectConflictsUntil' => 0,
			'unregisteredClients'  => array(
				'a9a9aa2d454f77cd623d6755c902c408' => array(
					'type' => 'script',
					'src'  => 'http://example.com/fake.js',
				),
			),
		);

		update_option(
			FontAwesome::CONFLICT_DETECTION_OPTIONS_KEY,
			$expected_conflict_detection_option
		);

		FontAwesome_Activator::initialize();
		$actual_options                   = get_option( FontAwesome::OPTIONS_KEY );
		$actual_conflict_detection_option = get_option( FontAwesome::CONFLICT_DETECTION_OPTIONS_KEY );

		$this->assertEquals( $expected_options, $actual_options );

		$this->assertEquals(
			$expected_conflict_detection_option,
			$actual_conflict_detection_option
		);
	}

	public function test_initialize_force_overwrites_with_defaults() {
		$initial_options = array_merge(
			FontAwesome::DEFAULT_USER_OPTIONS,
			array(
				'version' => '5.11.1',
				'usePro'  => ! FontAwesome::DEFAULT_USER_OPTIONS['usePro'],
			)
		);
		update_option( FontAwesome::OPTIONS_KEY, $initial_options );

		$initial_conflict_detection_option = array(
			'detectConflictsUntil' => 0,
			'unregisteredClients'  => array(
				'a9a9aa2d454f77cd623d6755c902c408' => array(
					'type' => 'script',
					'src'  => 'http://example.com/fake.js',
				),
			),
		);

		update_option(
			FontAwesome::CONFLICT_DETECTION_OPTIONS_KEY,
			$initial_conflict_detection_option
		);

		// 5.4.1 is the latest in the mock
		$expected_options = array_merge( FontAwesome::DEFAULT_USER_OPTIONS, array( 'version' => '5.4.1' ) );

		FontAwesome_Activator::initialize( true );
		$actual_options                   = get_option( FontAwesome::OPTIONS_KEY );
		$actual_conflict_detection_option = get_option( FontAwesome::CONFLICT_DETECTION_OPTIONS_KEY );

		$this->assertEquals( $expected_options, $actual_options );

		$this->assertEquals(
			FontAwesome::DEFAULT_CONFLICT_DETECTION_OPTIONS,
			get_option( FontAwesome::CONFLICT_DETECTION_OPTIONS_KEY )
		);
	}
}

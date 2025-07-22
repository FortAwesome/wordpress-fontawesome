<?php
namespace FortAwesome;

require_once __DIR__ . '/../includes/class-fontawesome-activator.php';
require_once __DIR__ . '/../includes/class-fontawesome-exception.php';
require_once __DIR__ . '/_support/font-awesome-phpunit-util.php';

use Yoast\WPTestUtils\WPIntegration\TestCase;

/**
 * Class ActivationTest
 */
class ActivationTest extends TestCase {

	public function set_up() {
		parent::set_up();

		reset_db();
		remove_all_actions( 'font_awesome_preferences' );
		uopz_set_return( FontAwesome_SVG_Styles_Manager::class, 'ensure_svg_styles_with_admin_notice_warning', true );
		uopz_set_return( FontAwesome_SVG_Styles_Manager::class, 'is_svg_stylesheet_present', false, false );
		remove_all_filters( 'font_awesome_disable_block_editor_support' );
		FontAwesome::reset();
		$this->setup_metadata_provider_mock();
	}

	public function test_before_activation() {
		$this->assertFalse( get_option( FontAwesome::OPTIONS_KEY ) );
		$this->assertFalse( get_option( FontAwesome::CONFLICT_DETECTION_OPTIONS_KEY ) );
		$this->assertFalse( FontAwesome_Release_Provider::get_option() );
	}

	public function test_activation_creates_default_config() {
		FontAwesome_Activator::activate();
		$actual_options   = get_option( FontAwesome::OPTIONS_KEY );
		$expected_options = array_merge( FontAwesome::DEFAULT_USER_OPTIONS, array( 'version' => fa()->latest_version_6() ) );
		$this->assertEquals( $expected_options, $actual_options );

		$releases = FontAwesome_Release_Provider::get_option();
		$this->assertTrue( boolval( $releases ) );

		$this->assertEquals(
			FontAwesome::DEFAULT_CONFLICT_DETECTION_OPTIONS,
			get_option( FontAwesome::CONFLICT_DETECTION_OPTIONS_KEY )
		);
	}

	public function test_initialize_from_scratch_creates_default_config() {
		FontAwesome_Activator::initialize();
		$actual_options   = get_option( FontAwesome::OPTIONS_KEY );
		$expected_options = array_merge( FontAwesome::DEFAULT_USER_OPTIONS, array( 'version' => fa()->latest_version_6() ) );
		$this->assertEquals( $expected_options, $actual_options );

		$this->assertEquals(
			FontAwesome::DEFAULT_CONFLICT_DETECTION_OPTIONS,
			get_option( FontAwesome::CONFLICT_DETECTION_OPTIONS_KEY )
		);
	}

	public function test_initialize_when_options_with_fa5_release_metadata_schema_is_present() {
		$mock_data        = graphql_releases_query_fixture();
		$latest_version_5 = $mock_data['latest_version_5']['version'];
		$latest_version_6 = $mock_data['latest_version_6']['version'];

		$releases_option_value = array(
			'refreshed_at' => time(),
			'data'         => array(
				'latest'   => $latest_version_5,
				'releases' => array(),
			),
		);

		update_option( FontAwesome_Release_Provider::OPTIONS_KEY, $releases_option_value, false );

		$this->setup_metadata_provider_mock();

		FontAwesome_Activator::initialize();
		FontAwesome::reset();

		$this->assertEquals( fa()->latest_version_6(), $latest_version_6 );
		$this->assertEquals( fa()->latest_version_5(), $latest_version_5 );
		$this->assertEquals( fa()->latest_version(), $latest_version_5 );
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

		$expected_options = array_merge( FontAwesome::DEFAULT_USER_OPTIONS, array( 'version' => '6.7.2' ) );

		FontAwesome_Activator::initialize( true );
		$actual_options                   = get_option( FontAwesome::OPTIONS_KEY );
		$actual_conflict_detection_option = get_option( FontAwesome::CONFLICT_DETECTION_OPTIONS_KEY );

		$this->assertEquals( $expected_options, $actual_options );

		$this->assertEquals(
			FontAwesome::DEFAULT_CONFLICT_DETECTION_OPTIONS,
			get_option( FontAwesome::CONFLICT_DETECTION_OPTIONS_KEY )
		);
	}

	public function test_svg_styles_ensured_when_enabled() {
		$call_count = 0;

		uopz_set_return(
			FontAwesome_SVG_Styles_Manager::class,
			'ensure_svg_styles_with_admin_notice_warning',
			function () use ( &$call_count ) {
				$call_count++;
				return true;
			},
			true
		);

		FontAwesome_Activator::initialize();

		$this->assertEquals( 1, $call_count );
	}

	public function test_no_svg_styles_when_disabled() {
		$call_count = 0;
		add_filter( 'font_awesome_disable_block_editor_support', '__return_true' );
		FontAwesome::reset();

		uopz_set_return(
			FontAwesome_SVG_Styles_Manager::class,
			'ensure_svg_styles_with_admin_notice_warning',
			function () use ( &$call_count ) {
				$call_count++;
				return true;
			},
			true
		);

		FontAwesome_Activator::initialize();

		$this->assertEquals( 0, $call_count );
	}

	public function test_fetch_svg_styles_when_no_filesystem_permission() {
		uopz_unset_return( FontAwesome_SVG_Styles_Manager::class, 'ensure_svg_styles_with_admin_notice_warning' );

		// Simulate the filesystem being inaccessible.
		uopz_set_return(
			'WP_Filesystem',
			false,
			false
		);

		$call_count     = 0;
		$notified_error = null;

		uopz_set_return(
			'FortAwesome\notify_admin_warning',
			function ( $e ) use ( &$call_count, &$notified_error ) {
				$call_count++;
				$notified_error = $e;
				return true;
			},
			true
		);

		$this->assertNull( FontAwesome_Activator::initialize() );
		$this->assertEquals( 1, $call_count );
		$this->assertMatchesRegularExpression( '/permission to save files/', $notified_error->getMessage() );
	}

	public function setup_metadata_provider_mock() {
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
}

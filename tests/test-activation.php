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
		uopz_set_return( FontAwesome_SVG_Styles_Manager::class, 'fetch_svg_styles', null );
		uopz_unset_return( FontAwesome_SVG_Styles_Manager::class, 'is_svg_stylesheet_present' );
		uopz_unset_return( FontAwesome_Release_Provider::class, 'get_svg_styles_resource' );
		uopz_unset_return( 'wp_remote_get' );
		remove_all_filters( 'font_awesome_disable_block_editor_support' );

		FontAwesome::reset();
		$this->setup_metadata_provider_mock();
		$admin_user = get_users( array( 'role' => 'administrator' ) )[0];
		wp_set_current_user( $admin_user->ID, $admin_user->user_login );
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

		// 6.1.1 is the latest version 6 in the mock
		$expected_options = array_merge( FontAwesome::DEFAULT_USER_OPTIONS, array( 'version' => '6.1.1' ) );

		FontAwesome_Activator::initialize( true );
		$actual_options                   = get_option( FontAwesome::OPTIONS_KEY );
		$actual_conflict_detection_option = get_option( FontAwesome::CONFLICT_DETECTION_OPTIONS_KEY );

		$this->assertEquals( $expected_options, $actual_options );

		$this->assertEquals(
			FontAwesome::DEFAULT_CONFLICT_DETECTION_OPTIONS,
			get_option( FontAwesome::CONFLICT_DETECTION_OPTIONS_KEY )
		);
	}

	public function test_no_fetch_svg_styles_when_disabled() {
		add_filter( 'font_awesome_disable_block_editor_support', '__return_true' );
		FontAwesome::reset();
		$fetch_svg_styles_call_count = 0;

		uopz_set_return(
			FontAwesome_SVG_Styles_Manager::class,
			'fetch_svg_styles',
			function () use ( &$fetch_svg_styles_call_count ) {
				$fetch_svg_styles_call_count++;
			},
			true
		);

		FontAwesome_Activator::initialize();
		$this->assertEquals( 0, $fetch_svg_styles_call_count );
	}

	public function test_fetch_svg_styles_when_enabled() {
		$fetch_svg_styles_call_count = 0;

		uopz_set_return( FontAwesome_SVG_Styles_Manager::class, 'is_svg_stylesheet_present', false, false );

		uopz_set_return(
			FontAwesome_SVG_Styles_Manager::class,
			'fetch_svg_styles',
			function ( $fa, $fa_release_provider ) use ( &$fetch_svg_styles_call_count ) {
				$fetch_svg_styles_call_count++;
				return uopz_call_user_func_array( array( FontAwesome_SVG_Styles_Manager::class, 'fetch_svg_styles' ), array( $fa, $fa_release_provider ) );
			},
			true
		);

		if ( ! function_exists( 'WP_Filesystem' ) ) {
			require_once ABSPATH . 'wp-admin/includes/file.php';
		}

		$this->assertTrue( WP_Filesystem( false ) );

		global $wp_filesystem;

		$filesystem_class = get_class( $wp_filesystem );

		$wp_remote_get_call_count = 0;

		$mock_css_contents = 'FAKE_CSS_CONTENTS';

		uopz_set_return(
			'wp_remote_get',
			function () use ( &$wp_remote_get_call_count, $mock_css_contents ) {
				$wp_remote_get_call_count++;

				return array(
					'response' => array(
						'code' => 200,
					),
					'body'     => $mock_css_contents,
				);
			},
			true
		);

		$mock_content_sha384_hash_hex = hash( 'sha384', $mock_css_contents );

		$written_asset_path = null;

		$hash_bin = hex2bin( $mock_content_sha384_hash_hex );

		// phpcs:ignore WordPress.PHP.DiscouragedPHPFunctions.obfuscation_base64_encode
		$mock_integrity_key = 'sha384-' . base64_encode( $hash_bin );

		uopz_set_return(
			FontAwesome_Release_Provider::class,
			'get_svg_styles_resource',
			function () use ( $mock_integrity_key ) {
				return new FontAwesome_Resource( 'svg-with-js.css', $mock_integrity_key );
			},
			true
		);

		uopz_set_return(
			$filesystem_class,
			'put_contents',
			function ( $asset_path ) use ( &$written_asset_path ) {
				$written_asset_path = $asset_path;
			},
			true
		);

		FontAwesome_Activator::initialize();

		$this->assertEquals( 1, $fetch_svg_styles_call_count );
		$this->assertEquals( 1, $wp_remote_get_call_count );
		$this->assertMatchesRegularExpression( '/svg-with-js\.css$/', $written_asset_path );
	}

	public function test_no_wp_remote_get_for_fetch_svg_styles_when_already_present() {
		uopz_unset_return( FontAwesome_SVG_Styles_Manager::class, 'fetch_svg_styles' );

		uopz_set_return(
			FontAwesome_SVG_Styles_Manager::class,
			'is_svg_stylesheet_present',
			true,
			false
		);

		$wp_remote_get_call_count = 0;

		uopz_set_return(
			'wp_remote_get',
			function () use ( &$wp_remote_get_call_count ) {
				$wp_remote_get_call_count++;
			},
			true
		);

		FontAwesome_Activator::initialize();
		$this->assertEquals( 0, $wp_remote_get_call_count );
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

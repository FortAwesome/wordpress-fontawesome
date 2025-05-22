<?php
namespace FortAwesome;

require_once __DIR__ . '/../includes/class-fontawesome-activator.php';
require_once __DIR__ . '/../includes/class-fontawesome-exception.php';
require_once __DIR__ . '/_support/font-awesome-phpunit-util.php';

use Yoast\WPTestUtils\WPIntegration\TestCase;

/**
 * Class SvgStyleManagerTest
 */
class SvgStyleManagerTest extends TestCase {

	public function set_up() {
		parent::set_up();

		reset_db();
		uopz_unset_return( FontAwesome_SVG_Styles_Manager::class, 'is_svg_stylesheet_present' );
		uopz_unset_return( FontAwesome_Release_Provider::class, 'get_svg_styles_resource' );
		uopz_unset_return( 'wp_remote_get' );
		remove_all_filters( 'font_awesome_disable_block_editor_support' );

		$this->setup_metadata_provider_mock();
		FontAwesome_Release_Provider::load_releases();
		$admin_user = get_users( array( 'role' => 'administrator' ) )[0];
		wp_set_current_user( $admin_user->ID, $admin_user->user_login );
		FontAwesome::reset();

		update_option(
			FontAwesome::OPTIONS_KEY,
			FontAwesome::DEFAULT_USER_OPTIONS
		);
	}

	public function test_fetch_svg_styles_when_styles_not_already_present() {
		$fetch_svg_styles_call_count = 0;

		uopz_set_return( FontAwesome_SVG_Styles_Manager::class, 'is_svg_stylesheet_present', false, false );

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
				return true;
			},
			true
		);

		FontAwesome_SVG_Styles_Manager::fetch_svg_styles( fa(), fa_release_provider() );

		$this->assertEquals( 1, $wp_remote_get_call_count );
		$this->assertMatchesRegularExpression( '/svg-with-js\.css$/', $written_asset_path );
	}

	public function test_fetch_svg_styles_when_no_filesystem_permission() {
		uopz_set_return( FontAwesome_SVG_Styles_Manager::class, 'is_svg_stylesheet_present', false, false );

		// Simulate the filesystem being inaccessible.
		uopz_set_return(
			'WP_Filesystem',
			false,
			false
		);

		$this->expectException( SelfhostSetupPermissionsException::class );
		$this->expectExceptionMessage( 'Failed to initialize filesystem usage' );
		FontAwesome_SVG_Styles_Manager::fetch_svg_styles( fa(), fa_release_provider() );
	}

	public function test_no_wp_remote_get_for_fetch_svg_styles_when_already_present() {
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

		FontAwesome_SVG_Styles_Manager::fetch_svg_styles( fa(), fa_release_provider() );
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

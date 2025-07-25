<?php
/**
 * Tests the release provider.
 *
 * @noinspection PhpIncludeInspection
 */

namespace FortAwesome;

require_once FONTAWESOME_DIR_PATH . 'includes/class-fontawesome-release-provider.php';
require_once FONTAWESOME_DIR_PATH . 'includes/class-fontawesome-exception.php';
require_once __DIR__ . '/_support/font-awesome-phpunit-util.php';
require_once __DIR__ . '/fixtures/graphql-releases-query-fixture.php';
use Yoast\WPTestUtils\WPIntegration\TestCase;

/**
 * Class ReleaseProviderTest
 *
 * @group api
 */
class ReleaseProviderTest extends TestCase {
	// sorted descending the way rsort would sort, lexically, not semver.
	protected $known_versions_sorted_desc = array(
		'7.0.0',
		'6.7.2',
		'6.7.1',
		'5.15.4',
		'5.15.3',
		'5.1.0',
		'5.0.13',
	);

	public function set_up() {
		parent::set_up();
		reset_db();
		remove_all_actions( 'font_awesome_preferences' );
	}

	protected static function build_success_response() {
		return wp_json_encode(
			array(
				'data' => graphql_releases_query_fixture(),
			)
		);
	}

	protected static function build_500_response() {
		return array(
			'response' => array(
				'code'    => 500,
				'message' => 'Internal Server Error',
			),
			'body'     => '',
			'headers'  => array(),
		);
	}

	protected function create_release_provider_with_mock_metadata( $response ) {
		mock_singleton_method(
			$this,
			FontAwesome_Metadata_Provider::class,
			'metadata_query',
			function ( $method ) use ( $response ) {
				$method->willReturn(
					$response
				);
			}
		);

		FontAwesome_Release_Provider::load_releases();

		return fa_release_provider();
	}

	protected function create_release_provider_that_throws( $exception ) {
		mock_singleton_method(
			$this,
			FontAwesome_Metadata_Provider::class,
			'metadata_query',
			function ( $method ) use ( $exception ) {
				$method->willReturn( array() );
			}
		);

		return fa_release_provider();
	}

	public function test_constructor_exception() {
		/**
		 * When the GET for releases does not return successfully and we have no version metadata available,
		 * we expect an exception to be thrown.
		 */
		delete_option( FontAwesome_Release_Provider::OPTIONS_KEY );

		$caught = false;

		try {
			FontAwesome_Release_Provider::reset();
		} catch ( ReleaseMetadataMissingException $e ) {
			$caught = true;
		}

		$this->assertTrue( $caught );
	}

	public function test_versions_success() {
		$mock_response = self::build_success_response();

		$farp = $this->create_release_provider_with_mock_metadata( $mock_response );

		$versions = $farp->versions();
		rsort( $versions );

		$this->assertCount( count( $this->known_versions_sorted_desc ), $versions );

		$this->assertEquals( $this->known_versions_sorted_desc, $versions );
	}

	public function test_5_0_all_free_shimless() {
		$mock_response = self::build_success_response();

		$farp = $this->create_release_provider_with_mock_metadata( $mock_response );

		$resource_collection = FontAwesome_Release_Provider::get_resource_collection(
			'5.0.13', // version.
			array(
				'use_pro'           => false,
				'use_svg'           => false,
				'use_compatibility' => false,
			)
		);

		$this->assertFalse( is_null( $resource_collection ) );
		$this->assertCount( 1, $resource_collection->resources() );
		$this->assertEquals(
			'https://use.fontawesome.com/releases/v5.0.13/css/all.css',
			$resource_collection->resources()['all']->source()
		);
		$this->assertEquals(
			'sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp',
			$resource_collection->resources()['all']->integrity_key()
		);
	}

	public function test_5_0_all_webfont_pro_shimless() {
		$mock_response = self::build_success_response();

		$farp = $this->create_release_provider_with_mock_metadata( $mock_response );

		$resource_collection = FontAwesome_Release_Provider::get_resource_collection(
			'5.0.13', // version.
			array(
				'use_pro'           => true,
				'use_svg'           => false,
				'use_compatibility' => false,
			)
		);

		$this->assertFalse( is_null( $resource_collection ) );
		$this->assertCount( 1, $resource_collection->resources() );
		$this->assertEquals( 'https://pro.fontawesome.com/releases/v5.0.13/css/all.css', $resource_collection->resources()['all']->source() );
		$this->assertEquals( 'sha384-oi8o31xSQq8S0RpBcb4FaLB8LJi9AT8oIdmS1QldR8Ui7KUQjNAnDlJjp55Ba8FG', $resource_collection->resources()['all']->integrity_key() );
	}

	/**
	 * There was no webfont shim in 5.0.x. So this should throw an exception.
	 */
	public function test_5_0_webfont_shim_exception() {
		$mock_response = self::build_success_response();

		$farp = $this->create_release_provider_with_mock_metadata( $mock_response );

		$this->expectException( ConfigSchemaException::class );

		FontAwesome_Release_Provider::get_resource_collection(
			'5.0.13', // version.
			array(
				'use_pro'           => true,
				'use_svg'           => false,
				'use_compatibility' => true,
			)
		);
	}

	public function test_5_1_all_webfont_pro_shimless() {
		$mock_response = self::build_success_response();

		$farp = $this->create_release_provider_with_mock_metadata( $mock_response );

		$resource_collection = FontAwesome_Release_Provider::get_resource_collection(
			'5.1.0', // version.
			array(
				'use_pro'           => true,
				'use_svg'           => false,
				'use_compatibility' => false,
			)
		);

		$this->assertFalse( is_null( $resource_collection ) );
		$this->assertCount( 1, $resource_collection->resources() );
		$this->assertEquals( 'https://pro.fontawesome.com/releases/v5.1.0/css/all.css', $resource_collection->resources()['all']->source() );
		$this->assertEquals( 'sha384-87DrmpqHRiY8hPLIr7ByqhPIywuSsjuQAfMXAE0sMUpY3BM7nXjf+mLIUSvhDArs', $resource_collection->resources()['all']->integrity_key() );
	}

	public function test_5_1_0_missing_webfont_free_shim_integrity() {
		$mock_response = self::build_success_response();

		$farp = $this->create_release_provider_with_mock_metadata( $mock_response );

		$resource_collection = FontAwesome_Release_Provider::get_resource_collection(
			'5.1.0', // version.
			array(
				'use_pro'           => false,
				'use_svg'           => false,
				'use_compatibility' => true,
			)
		);

		$this->assertFalse( is_null( $resource_collection ) );
		$this->assertCount( 2, $resource_collection->resources() );
		$this->assertEquals( 'https://use.fontawesome.com/releases/v5.1.0/css/all.css', $resource_collection->resources()['all']->source() );
		$this->assertEquals( 'sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt', $resource_collection->resources()['all']->integrity_key() );
		$this->assertEquals( 'https://use.fontawesome.com/releases/v5.1.0/css/v4-shims.css', $resource_collection->resources()['v4-shims']->source() );
	}

	public function test_5_0_all_svg_pro_shim() {
		$mock_response = self::build_success_response();

		$farp = $this->create_release_provider_with_mock_metadata( $mock_response );

		$resource_collection = FontAwesome_Release_Provider::get_resource_collection(
			'5.0.13', // version.
			array(
				'use_pro'           => true,
				'use_svg'           => true,
				'use_compatibility' => true,
			)
		);

		$this->assertFalse( is_null( $resource_collection ) );
		$this->assertCount( 2, $resource_collection->resources() );
		$this->assertEquals( 'https://pro.fontawesome.com/releases/v5.0.13/js/all.js', $resource_collection->resources()['all']->source() );
		$this->assertEquals( 'sha384-d84LGg2pm9KhR4mCAs3N29GQ4OYNy+K+FBHX8WhimHpPm86c839++MDABegrZ3gn', $resource_collection->resources()['all']->integrity_key() );
		$this->assertEquals( 'https://pro.fontawesome.com/releases/v5.0.13/js/v4-shims.js', $resource_collection->resources()['v4-shims']->source() );
		$this->assertEquals( 'sha384-LDfu/SrM7ecLU6uUcXDDIg59Va/6VIXvEDzOZEiBJCh148mMGba7k3BUFp1fo79X', $resource_collection->resources()['v4-shims']->integrity_key() );
	}

	public function test_invalid_version_exception() {
		$mock_response = self::build_success_response();

		$farp = $this->create_release_provider_with_mock_metadata( $mock_response );

		$this->expectException( ReleaseMetadataMissingException::class );

		$resource_collection = FontAwesome_Release_Provider::get_resource_collection(
			'4.0.13', // invalid version.
			array(
				'use_pro'           => true,
				'use_svg'           => false,
				'use_compatibility' => false,
			)
		);

		// END: since we're testing an exception, code won't run after the exception-throwing statement.
	}

	public function test_latest_version() {
		$mock_response = self::build_success_response();

		$farp = $this->create_release_provider_with_mock_metadata( $mock_response );

		$this->assertEquals( '5.15.4', $farp->latest_version() );
	}

	public function test_latest_version_5() {
		$mock_response = self::build_success_response();

		$farp = $this->create_release_provider_with_mock_metadata( $mock_response );

		$this->assertEquals( '5.15.4', $farp->latest_version_5() );
	}

	public function test_latest_version_6() {
		$mock_response = self::build_success_response();

		$farp = $this->create_release_provider_with_mock_metadata( $mock_response );

		$this->assertEquals( '6.7.2', $farp->latest_version_6() );
	}

	// Ensure that the ReleaseProvider sorts versions semantically.
	public function test_versions_with_6_0_0() {
		$mock_response = wp_json_encode(
			array(
				'data' => graphql_releases_query_fixture(),
			)
		);

		$this->create_release_provider_with_mock_metadata( $mock_response );
		$farp = FontAwesome_Release_Provider::reset();

		$this->assertEquals( '7.0.0', $farp->versions()[0] );

		/**
		 * The deprecated latest_version() is defined to be the latest 5.x version,
		 * because that reflects the data available on api.fontawesome.com, even though
		 * it's not the absolutely latest version.
		 */
		$this->assertEquals( '5.15.4', $farp->latest_version() );
	}

	/**
	 * Before changing to keys latest_version_5 and latest_version_6, there was just "latest",
	 * which referred to the latest FA 5.x release. On the first time the admin user
	 * loads the admin page after upgrading to the new schema, the initial view will be based
	 * the release metadata already in the database, which means that the Release Provider
	 * must be able to be instantiated without error and load itself from that older
	 * option schema. Once it's refreshed with a new query from the API server, it will
	 * write the option value with the new schema.
	 */
	public function test_loading_from_option_schema_with_latest_key() {
		$data = graphql_releases_query_fixture();

		$latest_version_5 = $data['latest_version_5']['version'];

		$option_value = array(
			'refreshed_at' => time(),
			'data'         => array(
				'latest'   => $latest_version_5,
				'releases' => $data['releases'],
			),
		);

		update_option( FontAwesome_Release_Provider::OPTIONS_KEY, $option_value, false );

		$farp = FontAwesome_Release_Provider::reset();

		$this->assertEquals( '5.15.4', $farp->latest_version_5() );
		$this->assertNull( $farp->latest_version_6() );
		$this->assertEquals( '5.15.4', $farp->latest_version() );
	}
}

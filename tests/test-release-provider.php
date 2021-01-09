<?php
namespace FortAwesome;

/**
 * Tests the release provider.
 *
 * @noinspection PhpIncludeInspection
 */

require_once FONTAWESOME_DIR_PATH . 'includes/class-fontawesome-release-provider.php';
require_once FONTAWESOME_DIR_PATH . 'includes/class-fontawesome-exception.php';
require_once dirname( __FILE__ ) . '/_support/font-awesome-phpunit-util.php';
require_once dirname( __FILE__ ) . '/fixtures/graphql-releases-query-fixture.php';

/**
 * Class ReleaseProviderTest
 *
 * @group api
 */
class ReleaseProviderTest extends \WP_UnitTestCase {
	protected $known_versions_sorted_desc = array(
		'5.4.1',
		'5.3.1',
		'5.2.0',
		'5.1.1',
		'5.1.0',
		'5.0.13',
		'5.0.12',
		'5.0.10',
		'5.0.9',
		'5.0.8',
		'5.0.6',
		'5.0.4',
		'5.0.3',
		'5.0.2',
		'5.0.1',
	);

	public function setUp() {
		reset_db();
		remove_all_actions( 'font_awesome_preferences' );
	}

	public function test_can_load_and_instantiate() {
		$obj = fa_release_provider();
		$this->assertFalse( is_null( $obj ) );
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

	protected function create_release_provider_with_mocked_response( $response ) {
		return mock_singleton_method(
			$this,
			FontAwesome_Release_Provider::class,
			'query',
			function( $method ) use ( $response ) {
				$method->willReturn(
					$response
				);
			}
		);
	}

	protected function create_release_provider_that_throws( $exception ) {
		return mock_singleton_method(
			$this,
			FontAwesome_Release_Provider::class,
			'query',
			function( $method ) use ( $exception ) {
				$method->will( $this->throwException( $exception ) );
			}
		);
	}

	public function test_versions_exception() {
		/**
		 * When the GET for releases does not return successfully and we have no version metadata available,
		 * we expect an exception to be thrown.
		 */
		delete_option( FontAwesome_Release_Provider::OPTIONS_KEY );

		$farp   = $this->create_release_provider_that_throws( new ApiResponseException() );
		$caught = false;

		try {
			$farp->versions();
		} catch ( ApiResponseException $e ) {
			$caught = true;
		}

		$this->assertTrue( $caught );
	}

	public function test_error_response() {
		$caught = false;

		try {
			$farp = $this->create_release_provider_that_throws( new ApiRequestException() );
		} catch ( ApiRequestException $e ) {
			$caught = true;
		}

		$this->assertTrue( $caught );
	}

	public function test_versions_success() {
		$mock_response = self::build_success_response();

		$farp = $this->create_release_provider_with_mocked_response( $mock_response );

		$versions = $farp->versions();
		$this->assertCount( count( $this->known_versions_sorted_desc ), $versions );
		$this->assertArraySubset( $this->known_versions_sorted_desc, $versions );
	}

	public function test_5_0_all_free_shimless() {
		$mock_response = self::build_success_response();

		$farp = $this->create_release_provider_with_mocked_response( $mock_response );

		$resource_collection = $farp->get_resource_collection(
			'5.0.13', // version.
			array(
				'use_pro'  => false,
				'use_svg'  => false,
				'use_shim' => false,
			)
		);

		$this->assertFalse( is_null( $resource_collection ) );
		$this->assertCount( 1, $resource_collection->resources() );
		$this->assertEquals(
			'https://use.fontawesome.com/releases/v5.0.13/css/all.css',
			$resource_collection->resources()[0]->source()
		);
		$this->assertEquals(
			'sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp',
			$resource_collection->resources()[0]->integrity_key()
		);
	}

	public function test_5_0_all_webfont_pro_shimless() {
		$mock_response = self::build_success_response();

		$farp = $this->create_release_provider_with_mocked_response( $mock_response );

		$resource_collection = $farp->get_resource_collection(
			'5.0.13', // version.
			array(
				'use_pro'  => true,
				'use_svg'  => false,
				'use_shim' => false,
			)
		);

		$this->assertFalse( is_null( $resource_collection ) );
		$this->assertCount( 1, $resource_collection->resources() );
		$this->assertEquals( 'https://pro.fontawesome.com/releases/v5.0.13/css/all.css', $resource_collection->resources()[0]->source() );
		$this->assertEquals( 'sha384-oi8o31xSQq8S0RpBcb4FaLB8LJi9AT8oIdmS1QldR8Ui7KUQjNAnDlJjp55Ba8FG', $resource_collection->resources()[0]->integrity_key() );
	}

	/**
	 * There was no webfont shim in 5.0.x. So this should throw an exception.
	 */
	public function test_5_0_webfont_shim_exception() {
		$mock_response = self::build_success_response();

		$farp = $this->create_release_provider_with_mocked_response( $mock_response );

		$this->expectException( ConfigSchemaException::class );

		$farp->get_resource_collection(
			'5.0.13', // version.
			array(
				'use_pro'  => true,
				'use_svg'  => false,
				'use_shim' => true,
			)
		);
	}

	public function test_5_1_all_webfont_pro_shimless() {
		$mock_response = self::build_success_response();

		$farp = $this->create_release_provider_with_mocked_response( $mock_response );

		$resource_collection = $farp->get_resource_collection(
			'5.1.0', // version.
			array(
				'use_pro'  => true,
				'use_svg'  => false,
				'use_shim' => false,
			)
		);

		$this->assertFalse( is_null( $resource_collection ) );
		$this->assertCount( 1, $resource_collection->resources() );
		$this->assertEquals( 'https://pro.fontawesome.com/releases/v5.1.0/css/all.css', $resource_collection->resources()[0]->source() );
		$this->assertEquals( 'sha384-87DrmpqHRiY8hPLIr7ByqhPIywuSsjuQAfMXAE0sMUpY3BM7nXjf+mLIUSvhDArs', $resource_collection->resources()[0]->integrity_key() );
	}

	// TODO: when 5.1.1 is released, add a test to make sure there is a v4-shims.css integrity key.
	public function test_5_1_0_missing_webfont_free_shim_integrity() {
		$mock_response = self::build_success_response();

		$farp = $this->create_release_provider_with_mocked_response( $mock_response );

		$resource_collection = $farp->get_resource_collection(
			'5.1.0', // version.
			array(
				'use_pro'  => false,
				'use_svg'  => false,
				'use_shim' => true,
			)
		);

		$this->assertFalse( is_null( $resource_collection ) );
		$this->assertCount( 2, $resource_collection->resources() );
		$this->assertEquals( 'https://use.fontawesome.com/releases/v5.1.0/css/all.css', $resource_collection->resources()[0]->source() );
		$this->assertEquals( 'sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt', $resource_collection->resources()[0]->integrity_key() );
		$this->assertEquals( 'https://use.fontawesome.com/releases/v5.1.0/css/v4-shims.css', $resource_collection->resources()[1]->source() );
	}

	public function test_5_0_all_svg_pro_shim() {
		$mock_response = self::build_success_response();

		$farp = $this->create_release_provider_with_mocked_response( $mock_response );

		$resource_collection = $farp->get_resource_collection(
			'5.0.13', // version.
			array(
				'use_pro'  => true,
				'use_svg'  => true,
				'use_shim' => true,
			)
		);

		$this->assertFalse( is_null( $resource_collection ) );
		$this->assertCount( 2, $resource_collection->resources() );
		$this->assertEquals( 'https://pro.fontawesome.com/releases/v5.0.13/js/all.js', $resource_collection->resources()[0]->source() );
		$this->assertEquals( 'sha384-d84LGg2pm9KhR4mCAs3N29GQ4OYNy+K+FBHX8WhimHpPm86c839++MDABegrZ3gn', $resource_collection->resources()[0]->integrity_key() );
		$this->assertEquals( 'https://pro.fontawesome.com/releases/v5.0.13/js/v4-shims.js', $resource_collection->resources()[1]->source() );
		$this->assertEquals( 'sha384-LDfu/SrM7ecLU6uUcXDDIg59Va/6VIXvEDzOZEiBJCh148mMGba7k3BUFp1fo79X', $resource_collection->resources()[1]->integrity_key() );
	}

	public function test_invalid_version_exception() {
		$mock_response = self::build_success_response();

		$farp = $this->create_release_provider_with_mocked_response( $mock_response );

		$this->expectException( ReleaseMetadataMissingException::class );

		$resource_collection = $farp->get_resource_collection(
			'4.0.13', // invalid version.
			array(
				'use_pro'  => true,
				'use_svg'  => false,
				'use_shim' => false,
			)
		);

		// END: since we're testing an exception, code won't run after the exception-throwing statement.
	}

	public function test_latest_version() {
		$mock_response = self::build_success_response();

		$farp = $this->create_release_provider_with_mocked_response( $mock_response );

		$this->assertEquals( '5.4.1', $farp->latest_version() );
	}
}

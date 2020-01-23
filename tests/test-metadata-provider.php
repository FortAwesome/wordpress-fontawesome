<?php
namespace FortAwesome;

/**
 * Tests the release provider.
 *
 * @noinspection PhpIncludeInspection
 */

require_once FONTAWESOME_DIR_PATH . 'includes/class-fontawesome-metadata-provider.php';
require_once dirname( __FILE__ ) . '/_support/font-awesome-phpunit-util.php';

use \Exception;

/**
 * Class ReleaseProviderTest
 *
 * @group api
 */
class MetadataProviderTest extends \WP_UnitTestCase {
  // Known at the time of capturing the "releases_api" vcr fixture on Oct 18, 2018.
	protected $known_versions_sorted_desc = [
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
  ];

  protected static function build_500_response() {
		return array(
			'response' => array(
				'code'    => 500,
				'message' => 'Internal Server Error',
			),
			'body'     => '',
		);
	}

	protected static function build_403_response() {
		return array(
			'response' => array(
				'code'    => 403,
				'message' => 'Forbidden',
			),
			'body'     => '',
		);
	}

	public function test_can_load_and_instantiate() {
		$obj = fa_metadata_provider();
		$this->assertFalse( is_null( $obj ) );
  }

  protected function create_metadata_provider_with_mocked_response( $response ) {
		return mock_singleton_method(
			$this,
			FontAwesome_Metadata_Provider::class,
			'get',
			function( $method ) use ( $response ) {
				$method->willReturn(
					$response
				);
			}
		);
	}

  public function test_get_available_versions_with_exception() {
		/**
		 * When the GET for get_available_versions does not return successfully
		 * we expect an exception to be thrown.
		 */

		$mock_response = self::build_500_response();
		$famp = $this->create_metadata_provider_with_mocked_response( $mock_response );

    $this->assertEquals( 0, $famp->get_available_versions()['code'] );
    $this->assertEquals( "Whoops, we failed to fetch the versions.", $famp->get_available_versions()['message'] );
  }

  public function test_get_available_versions_with_error() {
    /**
     * When the GET for get_available_versions has a 400 level response
     * we expect an error to be thrown.
     */

     $mock_response = self::build_403_response();
     $famp = $this->create_metadata_provider_with_mocked_response( $mock_response );

     $this->assertEquals( 0, $famp->get_available_versions()['code'] );
    //  $this->assertEquals( "Whoops, we failed when trying to fetch the versions.", $famp->get_available_versions()['message'] );
  }

  // public function test_get_available_versions() {
  //     $metadata_api = FontAwesome_Metadata_Provider::instance();
  //     $returned_value = $metadata_api->get_available_versions();
  //     print_r($returned_value);
  //   }

  // public function test_metadata_query() {
  //   $metadata_api = FontAwesome_Metadata_Provider::instance();
  //   $returned_value = $metadata_api->metadata_query('query {versions}');
  //   print_r($returned_value);
  // }
}
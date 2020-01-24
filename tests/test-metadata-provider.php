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

	protected static function build_success_response() {
		return array(
			'response' => array(
				'code'    => 200,
				'message' => 'OK',
			),
			'body' => '{"data":{"versions":["5.0.1","5.0.2","5.0.3","5.0.4","5.0.6","5.0.8","5.0.9","5.0.10","5.0.12","5.0.13","5.1.0","5.1.1","5.2.0","5.3.1","5.4.1","5.4.2","5.5.0","5.6.0","5.6.1","5.6.3","5.7.0","5.7.1","5.7.2","5.8.0","5.8.1","5.8.2","5.9.0","5.10.0","5.10.1","5.10.2","5.11.0","5.11.1","5.11.2"]}}',
		);
	}

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
			'post',
			function( $method ) use ( $response ) {
				$method->willReturn(
					$response
				);
			}
		);
	}

  // public function test_get_available_versions_with_exception() {
	// 	/**
	// 	 * When the GET for get_available_versions does not return successfully
	// 	 * we expect to receive a 500 response.
	// 	 */

	// 	$mock_response = self::build_500_response();
	// 	$famp = $this->create_metadata_provider_with_mocked_response( $mock_response );

  //   $this->assertEquals( 500, $famp->get_available_versions()['code'] );
  //   $this->assertEquals( "Internal Server Error", $famp->get_available_versions()['message'] );
  // }

  // public function test_get_available_versions_with_error() {
  //   /**
  //    * When the GET for get_available_versions has a 403 response
  //    * we expect to receive that error back.
  //    */

  //    $mock_response = self::build_403_response();
  //    $famp = $this->create_metadata_provider_with_mocked_response( $mock_response );

  //    $this->assertEquals( 403, $famp->get_available_versions()['code'] );
  //    $this->assertEquals( "Forbidden", $famp->get_available_versions()['message'] );
  // }

  // public function test_get_available_versions() {
	// 	$mock_response = self::build_success_response();
	// 	$famp = $this->create_metadata_provider_with_mocked_response( $mock_response );

	// 	$this->assertEquals("5.11.2", $famp->get_available_versions()[0]);
	// }

  public function test_metadata_query() {
		$mock_response = self::build_success_response();
		$famp = $this->create_metadata_provider_with_mocked_response( $mock_response );

    $this->assertEquals("", $famp->metadata_query( 'query {versions}' ));
  }
}
<?php
namespace FortAwesome;

/**
 * Tests the release provider.
 *
 * @noinspection PhpIncludeInspection
 */

require_once FONTAWESOME_DIR_PATH . 'includes/class-fontawesome-metadata-provider.php';
require_once dirname( __FILE__ ) . '/_support/font-awesome-phpunit-util.php';

use \Exception, \WP_Error;

/**
 * Class ReleaseProviderTest
 *
 * @group api
 */
class MetadataProviderTest extends \WP_UnitTestCase {

	protected static function build_success_response() {
		return array(
			'response'  => array(
				'code'    => 200,
				'message' => 'OK',
			),
			'body' => '{"data":{"versions":["5.0.1","5.0.2","5.0.3","5.0.4","5.0.6","5.0.8","5.0.9","5.0.10","5.0.12","5.0.13","5.1.0","5.1.1","5.2.0","5.3.1","5.4.1","5.4.2","5.5.0","5.6.0","5.6.1","5.6.3","5.7.0","5.7.1","5.7.2","5.8.0","5.8.1","5.8.2","5.9.0","5.10.0","5.10.1","5.10.2","5.11.0","5.11.1","5.11.2"]}}',
		);
	}

	protected static function build_query_error_response() {
		return array(
			'response'  => array(
				'code'    => 200,
				'message' => 'OK',
			),
			'body' => json_encode($object = (object) [
				'errors' => array(
					0 => $object = (object)['message' => 'syntax error before: "queryversions"']
				)
			]),
		);
	}

  protected static function build_500_response() {
		return array(
			'response'  => array(
				'code'    => 500,
				'message' => 'Internal Server Error',
			),
			'body'      => '',
		);
	}

	protected static function build_403_response() {
		return array(
			'response'  => array(
				'code'    => 403,
				'message' => 'Forbidden',
			),
			'body'      => '',
		);
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

	public function test_can_load_and_instantiate() {
		$obj = fa_metadata_provider();
		$this->assertFalse( is_null( $obj ) );
	}

	public function test_metadata_query_500_error() {
		/**
		 * When a query fails with a server error we expect a 500 response.
		 */
		$mock_response = self::build_500_response();
		$famp = $this->create_metadata_provider_with_mocked_response( $mock_response );

		$result = $famp->metadata_query( 'query {versions}' );

		$this->assertTrue( $result instanceof WP_Error);
    	$this->assertEquals( "Internal Server Error", $result->get_error_message() );
		$this->assertArraySubset( ["status" => 500], $result->get_error_data() );
		$this->assertEquals( "fontawesome_api_failed_request", $result->get_error_code() );
	}

	public function test_metadata_query_403_error() {
		/**
		 * When a query fails with a forbidden error we expect a 403 response.
		 */
		$mock_response = self::build_403_response();
		$famp = $this->create_metadata_provider_with_mocked_response( $mock_response );

		$result = $famp->metadata_query( 'query {versions}' );

		$this->assertTrue( $result instanceof WP_Error);
		$this->assertArraySubset( ["status" => 403], $result->get_error_data() );
		$this->assertEquals( "Forbidden", $result->get_error_message() );
		$this->assertEquals( "fontawesome_api_failed_request", $result->get_error_code() );
	}

	public function test_metadata_query_error_on_query() {
		/**
		 * When a query is malformed, we expect to get back a response with a
		 * message that tells us why.
		 */
		$mock_response = self::build_query_error_response();
		$famp = $this->create_metadata_provider_with_mocked_response( $mock_response );

		$result = $famp->metadata_query( 'queryversions' );

		$this->assertEquals( "fontawesome_api_query_error", $result->get_error_code() );
		$this->assertArraySubset( ["status" => 200], $result->get_error_data() );
		$this->assertEquals('syntax error before: "queryversions"', $result->get_error_message() );
	}

	public function test_metadata_query_success() {
		/**
		 * metadata_query() returns json decoded PHP objects in an array
		 */
		$mock_response = self::build_success_response();
		$famp = $this->create_metadata_provider_with_mocked_response( $mock_response );

		$result = $famp->metadata_query( 'query {versions}' );

		$this->assertFalse( $result instanceof WP_Error );
		$this->assertEquals("5.0.1", $result['versions'][0]);
	}
}

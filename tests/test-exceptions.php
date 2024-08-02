<?php
namespace FortAwesome;

require_once trailingslashit( FONTAWESOME_DIR_PATH ) . 'includes/class-fontawesome-exception.php';
use WP_Error, WP_HTTP_Response;
use Yoast\WPTestUtils\WPIntegration\TestCase;

/**
 * ExceptionsTest class
 */
class ExceptionsTest extends TestCase {
	public function test_api_token_missing_exception() {
		$e1 = new ApiTokenMissingException();

		$this->assertStringStartsWith( 'Whoops', $e1->getMessage() );
		$this->assertNull( $e1->get_wp_error() );
	}

	public function test_api_token_missing_exception_with_wp_error() {
		$code    = 'foo_code';
		$message = 'bar message';
		$e1      = ApiTokenMissingException::with_wp_error( new WP_Error( $code, $message ) );

		$this->assertStringStartsWith( 'Whoops', $e1->getMessage() );
		$this->assertNull( $e1->get_wp_response() );
		$wpe = $e1->get_wp_error();
		$this->assertTrue( is_a( $wpe, 'WP_Error' ) );
		$this->assertEquals( $code, $wpe->get_error_code() );
	}

	public function test_api_token_missing_exception_with_wp_http_response() {
		$e1 = ApiTokenMissingException::with_wp_response(
			array(
				'response' => array(
					'code'    => 403,
					'message' => 'Forbidden',
				),
				'body'     => '',
				'headers'  => array(),
			)
		);

		$this->assertStringStartsWith( 'Whoops', $e1->getMessage() );
		$this->assertNull( $e1->get_wp_error() );
		$wpr = $e1->get_wp_response();
		$this->assertTrue( is_array( $wpr ) );
		$this->assertEquals( 403, $wpr['response']['code'] );
	}

	public function test_config_exception_with_code() {
		$e = ConfigSchemaException::kit_token_no_api_token();

		$this->assertStringStartsWith( 'A kitToken', $e->getMessage() );
	}

	public function test_config_exception_default() {
		$this->assertEquals( '', ( new ConfigSchemaException() )->getMessage() );
	}

	public function test_upgrade_exception() {
		$this->assertInstanceOf(
			FontAwesome_ServerException::class,
			new UpgradeException()
		);
	}
}

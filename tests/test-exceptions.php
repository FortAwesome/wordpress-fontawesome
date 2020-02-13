<?php
namespace FortAwesome;

require_once trailingslashit( FONTAWESOME_DIR_PATH ) . 'includes/class-fontawesomeexception.php';
use \WP_Error, \WP_HTTP_Response;

class ExceptionsTest extends \WP_UnitTestCase {
	public function test_api_token_missing_exception() {
		$e1 = new ApiTokenMissingException();

		$this->assertStringStartsWith( 'Whoops', $e1->getMessage() );
		$this->assertNull( $e1->get_wp_error() );
	}

	public function test_api_token_missing_exception_with_wp_error() {
		$code = 'foo_code';
		$message = 'bar message';
		$e1 = ApiTokenMissingException::with_wp_error( new WP_Error( $code, $message ) );

		$this->assertStringStartsWith( 'Whoops', $e1->getMessage() );
		$this->assertNull( $e1->get_wp_response() );
		$wpe = $e1->get_wp_error();
		$this->assertTrue( is_a( $wpe, 'WP_Error' ) );
		$this->assertEquals( $code, $wpe->get_error_code() );
	}

	public function test_api_token_missing_exception_with_wp_http_response() {
		$e1 = ApiTokenMissingException::with_wp_http_response( new WP_HTTP_Response( null, 403 ) );

		$this->assertStringStartsWith( 'Whoops', $e1->getMessage() );
		$this->assertNull( $e1->get_wp_error() );
		$wpr = $e1->get_wp_response();
		$this->assertTrue( is_a( $wpr, 'WP_HTTP_Response' ) );
		$this->assertEquals( 403, $wpr->get_status() );
	}
}

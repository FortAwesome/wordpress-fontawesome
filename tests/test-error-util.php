<?php
namespace FortAwesome;

require_once dirname( __FILE__ ) . '/../includes/exception/error-util.php';

use FortAwesome\Exception\{ function unknown_error_500, function fa_400 };
use \Exception, \Error;

/**
 * Class ErrorUtilTest
 */
class ErrorUtilTest extends \WP_UnitTestCase {
	public function test_unknown_error_500_with_exception() {
		$message = 'foo';
		$code = 'fa_unknown_error';
		$e = new Exception($message);
		$result = unknown_error_500($e);

		$this->assertTrue( is_a($result, 'WP_Error') );
		$this->assertEquals( $code, $result->get_error_code() );
		$this->assertEquals( $message, $result->get_error_message( $code ) );
		$this->assertEquals( 500, $result->get_error_data( $code )['status'] );
		$this->assertTrue( isset( $result->get_error_data( $code )['trace'] ) );
	}

	public function test_unknown_error_500_with_error() {
		$message = 'foo';
		$code = 'fa_unknown_error';
		$e = new Error($message);
		$result = unknown_error_500($e);

		$this->assertTrue( is_a($result, 'WP_Error') );
		$this->assertEquals( $code, $result->get_error_code() );
		$this->assertEquals( $message, $result->get_error_message( $code ) );
		$this->assertEquals( 500, $result->get_error_data( $code )['status'] );
		$this->assertTrue( isset( $result->get_error_data( $code )['trace'] ) );
	}

	public function test_unknown_error_500_with_array() {
		$message = 'foo';
		$code = 'fa_unknown_error';
		$e = array('alpha' => 42);
		$result = unknown_error_500($e);

		$this->assertTrue( is_a($result, 'WP_Error') );
		$this->assertEquals( $code, $result->get_error_code() );
		$this->assertStringEndsWith( "cannot be stringified.", $result->get_error_message( $code ) );
		$this->assertEquals( 500, $result->get_error_data( $code )['status'] );
		$this->assertTrue( isset( $result->get_error_data( $code )['trace'] ) );
	}

	public function test_unknown_error_500_with_string() {
		$message = 'foo';
		$code = 'fa_unknown_error';
		$e = $message;
		$result = unknown_error_500($e);

		$this->assertTrue( is_a($result, 'WP_Error') );
		$this->assertEquals( $code, $result->get_error_code() );
		$this->assertStringStartsWith( "Unexpected Thing", $result->get_error_message( $code ) );
		$this->assertStringEndsWith( "foo", $result->get_error_message( $code ) );
		$this->assertEquals( 500, $result->get_error_data( $code )['status'] );
		$this->assertTrue( isset( $result->get_error_data( $code )['trace'] ) );
	}

	public function test_fa_400_with_exception() {
		$message = 'foo';
		$code = 'fontawesome_exception';
		$e = new Exception($message);
		$result = fa_400($e);

		$this->assertTrue( is_a($result, 'WP_Error') );
		$this->assertEquals( $code, $result->get_error_code() );
		$this->assertEquals( $message, $result->get_error_message( $code ) );
		$this->assertEquals( 400, $result->get_error_data( $code )['status'] );
		$this->assertTrue( isset( $result->get_error_data( $code )['trace'] ) );
	}

	public function test_fa_400_with_error() {
		$message = 'foo';
		$code = 'fontawesome_exception';
		$e = new Error($message);
		$result = fa_400($e);

		$this->assertTrue( is_a($result, 'WP_Error') );
		$this->assertEquals( $code, $result->get_error_code() );
		$this->assertEquals( $message, $result->get_error_message( $code ) );
		$this->assertEquals( 400, $result->get_error_data( $code )['status'] );
		$this->assertTrue( isset( $result->get_error_data( $code )['trace'] ) );
	}
}

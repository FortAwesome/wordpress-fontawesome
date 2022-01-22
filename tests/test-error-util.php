<?php
namespace FortAwesome;

require_once dirname( __FILE__ ) . '/../includes/error-util.php';

use function FortAwesome\unknown_error_500;
use function FortAwesome\fa_400;
use function FortAwesome\fa_500;
use \Exception, \Error;
use Yoast\WPTestUtils\WPIntegration\TestCase;

/**
 * Class ErrorUtilTest
 */
class ErrorUtilTest extends TestCase {
	public function test_wpe_fontawesome_unknown_error_with_exception() {
		$message = 'foo';
		$code    = 'fontawesome_unknown_error';
		$e       = new Exception( $message );
		$result  = wpe_fontawesome_unknown_error( $e );

		$this->assertTrue( is_a( $result, 'WP_Error' ) );
		$this->assertEquals( $code, $result->get_error_code() );
		$this->assertEquals( $message, $result->get_error_message( $code ) );
		$this->assertTrue( isset( $result->get_error_data( $code )['trace'] ) );
	}

	public function test_wpe_fontawesome_unknown_error_with_error() {
		$message = 'foo';
		$code    = 'fontawesome_unknown_error';
		$e       = new Error( $message );
		$result  = wpe_fontawesome_unknown_error( $e );

		$this->assertTrue( is_a( $result, 'WP_Error' ) );
		$this->assertEquals( $code, $result->get_error_code() );
		$this->assertEquals( $message, $result->get_error_message( $code ) );
		$this->assertTrue( isset( $result->get_error_data( $code )['trace'] ) );
	}

	public function test_wpe_fontawesome_unknown_error_with_array() {
		$message = 'foo';
		$code    = 'fontawesome_unknown_error';
		$e       = array( 'alpha' => 42 );
		$result  = wpe_fontawesome_unknown_error( $e );

		$this->assertTrue( is_a( $result, 'WP_Error' ) );
		$this->assertEquals( $code, $result->get_error_code() );
		$this->assertStringEndsWith( 'cannot be stringified.', $result->get_error_message( $code ) );
		$this->assertTrue( isset( $result->get_error_data( $code )['trace'] ) );
	}

	public function test_wpe_fontawesome_unknown_error_with_string() {
		$message = 'foo';
		$code    = 'fontawesome_unknown_error';
		$e       = $message;
		$result  = wpe_fontawesome_unknown_error( $e );

		$this->assertTrue( is_a( $result, 'WP_Error' ) );
		$this->assertEquals( $code, $result->get_error_code() );
		$this->assertStringStartsWith( 'Unexpected Thing', $result->get_error_message( $code ) );
		$this->assertStringEndsWith( 'foo', $result->get_error_message( $code ) );
		$this->assertTrue( isset( $result->get_error_data( $code )['trace'] ) );
	}

	public function test_fontawesome_client_exception_with_exception() {
		$message = 'foo';
		$code    = 'fontawesome_client_exception';
		$e       = new Exception( $message );
		$result  = wpe_fontawesome_client_exception( $e );

		$this->assertTrue( is_a( $result, 'WP_Error' ) );
		$this->assertEquals( $code, $result->get_error_code() );
		$this->assertEquals( $message, $result->get_error_message( $code ) );
		$this->assertTrue( isset( $result->get_error_data( $code )['trace'] ) );
	}

	public function test_fontawesome_client_exception_with_error() {
		$message = 'foo';
		$code    = 'fontawesome_client_exception';
		$e       = new Error( $message );
		$result  = wpe_fontawesome_client_exception( $e );

		$this->assertTrue( is_a( $result, 'WP_Error' ) );
		$this->assertEquals( $code, $result->get_error_code() );
		$this->assertEquals( $message, $result->get_error_message( $code ) );
		$this->assertTrue( isset( $result->get_error_data( $code )['trace'] ) );
	}

	public function test_fontawesome_server_exception_with_exception() {
		$message = 'foo';
		$code    = 'fontawesome_server_exception';
		$e       = new Exception( $message );
		$result  = wpe_fontawesome_server_exception( $e );

		$this->assertTrue( is_a( $result, 'WP_Error' ) );
		$this->assertEquals( $code, $result->get_error_code() );
		$this->assertEquals( $message, $result->get_error_message( $code ) );
		$this->assertTrue( isset( $result->get_error_data( $code )['trace'] ) );
	}

	public function test_build_wp_error_with_a_previous() {
		$prev = new Exception( 'some previous' );
		$e    = PreferenceRegistrationException::with_thrown( $prev );

		$result = wpe_fontawesome_server_exception( $e );

		$this->assertEquals( array( 'fontawesome_server_exception', 'previous_exception' ), $result->get_error_codes() );
	}

	public function test_notify_admin_fatal_error_when_user_is_not_privileged() {
		$e = new Exception( 'foobar' );

		$this->assertEquals( current_user_can( 'manage_options' ), false );

		notify_admin_fatal_error( $e );

		global $wp_filter;
		$this->assertFalse( $this->filter_has_fa_command( $wp_filter['admin_notices'] ) );
		$this->assertFalse( $this->filter_has_fa_command( $wp_filter['wp_print_scripts'] ) );
	}

	public function test_notify_admin_fatal_error_when_user_is_privileged() {
		$admin_user = get_users( array( 'role' => 'administrator' ) )[0];

		wp_set_current_user( $admin_user->ID, $admin_user->user_login );

		$this->assertEquals( current_user_can( 'manage_options' ), true );

		$e = new Exception( 'foobar' );

		notify_admin_fatal_error( $e );
		global $wp_filter;
		$this->assertTrue( $this->filter_has_fa_command( $wp_filter['admin_notices'] ) );
		$this->assertTrue( $this->filter_has_fa_command( $wp_filter['wp_print_scripts'] ) );
	}

	public function filter_has_fa_command( $filter ) {
		if ( ! $filter ) {
			return false;
		}

		foreach ( $filter as $priority => $pri_callbacks ) {
			foreach ( $pri_callbacks as $cur ) {
				if ( isset( $cur['function'] ) ) {
					$class = is_object( $cur['function'][0] ) ? get_class( $cur['function'][0] ) : null;

					if ( is_string( $class ) && 1 === preg_match( '/^FortAwesome\\\\FontAwesome_Command.*/', $class ) ) {
						return true;
					}
				}
			}
		}

		return false;
	}
}

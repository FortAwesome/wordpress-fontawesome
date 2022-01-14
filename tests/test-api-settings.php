<?php
namespace FortAwesome;

/**
 * Class ApiSettingsTest
 */
require_once dirname( __FILE__ ) . '/../includes/class-fontawesome-activator.php';
require_once dirname( __FILE__ ) . '/../includes/class-fontawesome-api-settings.php';
require_once dirname( __FILE__ ) . '/_support/font-awesome-phpunit-util.php';
require_once trailingslashit( FONTAWESOME_DIR_PATH ) . 'includes/class-fontawesome-exception.php';

use \WP_Error, \InvalidArgumentException;
use FortAwesome\ApiTokenMissingException;
use FortAwesome\ApiTokenInvalidException;

use Yoast\WPTestUtils\WPIntegration\TestCase;

/**
 * ApiSettingsTest class
 */
class ApiSettingsTest extends TestCase {

	public function setUp() {
		reset_db();
		remove_all_actions( 'font_awesome_preferences' );
		delete_option( FontAwesome_API_Settings::OPTIONS_KEY );
		FontAwesome_API_Settings::reset();
		FontAwesome::reset();
	}

	protected function create_api_settings_with_mocked_response( $response ) {
		return mock_singleton_method(
			$this,
			FontAwesome_API_Settings::class,
			'post',
			function( $method ) use ( $response ) {
				$method->willReturn(
					$response
				);
			}
		);
	}

	public function test_write() {
		// Start with nothing and force re-read.
		$api_settings = FontAwesome_API_Settings::reset();

		$api_settings->set_api_token( 'foo' );
		$api_settings->set_access_token( 'bar' );
		$api_settings->set_access_token_expiration_time( 42 );

		$result = $api_settings->write();
		$this->assertTrue( $result, 'writing api settings failed' );

		// Force re-read.
		$api_settings = FontAwesome_API_Settings::reset();

		$this->assertEquals( 'foo', $api_settings->api_token() );
		$this->assertEquals( 'bar', $api_settings->access_token() );
		$this->assertEquals( 42, $api_settings->access_token_expiration_time() );
		$this->assertTrue( is_int( $api_settings->access_token_expiration_time() ) );

		// Round-trip it again.
		$result = $api_settings->write();
		// Force re-read.
		$api_settings = FontAwesome_API_Settings::reset();

		$this->assertEquals( 'foo', $api_settings->api_token() );
		$this->assertEquals( 'bar', $api_settings->access_token() );
		$this->assertEquals( 42, $api_settings->access_token_expiration_time() );
		$this->assertTrue( is_int( $api_settings->access_token_expiration_time() ) );
	}

	/**
	 * What if we only write an api token, leave the others null, and then
	 * read it back in?
	 */
	public function test_round_trip_only_api_token() {
		// Start with nothing and force re-read.
		$api_settings = FontAwesome_API_Settings::reset();

		$api_settings->set_api_token( 'foo' );

		$result = $api_settings->write();
		$this->assertTrue( $result, 'writing api settings failed' );

		$option = get_option( FontAwesome_API_Settings::OPTIONS_KEY );

		$this->assertEquals( 'foo', $api_settings->decrypt( $option['api_token'] ) );

		// Force re-read.
		$api_settings = FontAwesome_API_Settings::reset();

		$this->assertEquals( 'foo', $api_settings->api_token() );
		$this->assertNull( $api_settings->access_token() );
		$this->assertNull( $api_settings->access_token_expiration_time() );
	}

	public function test_request_access_token() {
		$access_token = 'eyJhbGciOiJIUzUxMiIsInR5cCI6IkpXVCJ9.eyJhdWQiOiJGb250YXdlc29tZSIsImV4cCI6MTU4Mzc3MTQwOCwiaWF0IjoxNTgzNzY3ODA4LCJpc3MiOiJGb250YXdlc29tZSIsImp0aSI6ImE3ZWQ3MTUxLTczZmMtNDUzZC05MzlhLTA4YjY3MDQyZTQ0MCIsIm5iZiI6MTU4Mzc2NzgwNywic3ViIjoiVG9rZW46MTYiLCJ0eXAiOiJhY2Nlc3MifQ.j-0mpIfOsf2TLIj4X1vLcerTRMNSI5s5OjCAb9BduTSQbNegMeOdlJoIIFdkx0r4ZiB65HZ3TjYjH6uNHjOivQ';
		$api_token    = '8095F4A5-3ED5-4709-8468-F771A046D703';
		$api_settings = $this->create_api_settings_with_mocked_response(
			array(
				'response' => array(
					'code'    => 200,
					'message' => 'OK',
				),
				'body'     => wp_json_encode(
					array(
						'access_token' => $access_token,
						'expires_in'   => 3600,
					)
				),
			)
		);

		// Our mock doesn't run the constructor, so we'll initialize it separately.
		$api_settings->initialize();

		$api_settings->set_api_token( $api_token );
		$result = $api_settings->request_access_token();

		$written_option = get_option( FontAwesome_API_Settings::OPTIONS_KEY );

		$this->assertTrue( $result );
		$this->assertEquals( $access_token, $api_settings->access_token() );
		$this->assertEquals( $api_token, $api_settings->api_token() );
		$delta = abs( ( time() + 3600 ) - $api_settings->access_token_expiration_time() );
		$this->assertLessThanOrEqual( 2.0, $delta );

		// Force re-read.
		$api_settings = FontAwesome_API_Settings::reset();

		// Everything should have remained the same through the write/read round trip.
		$this->assertEquals( $access_token, $api_settings->access_token() );
		$this->assertEquals( $api_token, $api_settings->api_token() );
		$delta = abs( ( time() + 3600 ) - $api_settings->access_token_expiration_time() );
		$this->assertLessThanOrEqual( 2.0, $delta );
	}

	public function test_request_access_token_without_api_token() {
		$api_settings = $this->create_api_settings_with_mocked_response(
			array(
				'response' => array(
					'code'    => 200,
					'message' => 'OK',
				),
				'body'     => wp_json_encode(
					array(
						'access_token' => '123',
						'expires_in'   => 3600,
					)
				),
			)
		);

		$this->expectException( ApiTokenMissingException::class );
		$api_settings->request_access_token();
	}

	public function test_request_access_token_when_request_errors() {
		$api_settings = $this->create_api_settings_with_mocked_response(
			new WP_Error()
		);

		$api_settings->set_api_token( 'xyz' );

		try {
			$api_settings->request_access_token();
		} catch ( FontAwesome_Exception $e ) {
			$this->assertNotNull( $e->get_wp_error() );
		}

		$this->expectException( ApiTokenEndpointRequestException::class );
		$api_settings->request_access_token();
	}

	public function test_request_access_token_when_request_returns_non_200_response() {
		$api_settings = $this->create_api_settings_with_mocked_response(
			array(
				'response' => array(
					'code'    => 403,
					'message' => 'Forbidden',
				),
				'body'     => '',
				'headers'  => array(),
			)
		);

		$api_settings->set_api_token( 'xyz' );

		try {
			$api_settings->request_access_token();
		} catch ( FontAwesome_Exception $e ) {
			$this->assertNotNull( $e->get_wp_response() );
			$this->assertEquals( 403, $e->get_wp_response()['response']['code'] );
		}

		$this->expectException( ApiTokenInvalidException::class );
		$result = $api_settings->request_access_token();
	}

	public function test_request_access_token_when_request_body_lacks_access_token() {
		$api_settings = $this->create_api_settings_with_mocked_response(
			array(
				'response' => array(
					'code'    => 200,
					'message' => 'OK',
				),
				'body'     => wp_json_encode(
					array(
						'expires_in' => 3600,
					)
				),
				'headers'  => array(),
			)
		);

		$api_settings->set_api_token( 'xyz' );

		try {
			$api_settings->request_access_token();
		} catch ( FontAwesome_Exception $e ) {
			$this->assertNotNull( $e->get_wp_response() );
			$this->assertEquals( 200, $e->get_wp_response()['response']['code'] );
			$this->assertStringEndsWith( 'an invalid response.', $e->getMessage() );
		}

		$this->expectException( ApiTokenEndpointResponseException::class );
		$result = $api_settings->request_access_token();
	}

	public function test_request_access_token_when_request_body_lacks_expires_in() {
		$api_settings = $this->create_api_settings_with_mocked_response(
			array(
				'response' => array(
					'code'    => 200,
					'message' => 'OK',
				),
				'body'     => wp_json_encode(
					array(
						'access_token' => 'abc',
					)
				),
				'headers'  => array(),
			)
		);

		$api_settings->set_api_token( 'xyz' );

		try {
			$api_settings->request_access_token();
		} catch ( FontAwesome_Exception $e ) {
			$this->assertNotNull( $e->get_wp_response() );
			$this->assertEquals( 200, $e->get_wp_response()['response']['code'] );
			$this->assertStringEndsWith( 'an invalid response.', $e->getMessage() );
		}

		$this->expectException( ApiTokenEndpointResponseException::class );
		$result = $api_settings->request_access_token();
	}

	public function test_set_access_token_expiration_time_non_integer() {
		$api_settings = FontAwesome_API_Settings::reset();

		$this->expectException( InvalidArgumentException::class );

		$api_settings->set_access_token_expiration_time( 'abc' );
	}

	public function test_set_access_token_expiration_time_given_zero() {
		$api_settings = FontAwesome_API_Settings::reset();

		$this->expectException( InvalidArgumentException::class );

		$api_settings->set_access_token_expiration_time( 0 );
	}

	public function test_reset() {
		$api_settings = FontAwesome_API_Settings::reset();

		update_option(
			FontAwesome_API_Settings::OPTIONS_KEY,
			array(
				'api_token'                    => $api_settings->encrypt( 'abc123' ),
				'access_token'                 => $api_settings->encrypt( 'xyz456' ),
				'access_token_expiration_time' => 999999999,
			)
		);

		// Force re-read.
		$api_settings = FontAwesome_API_Settings::reset();

		$this->assertEquals( 'abc123', $api_settings->api_token() );
		$this->assertEquals( 'xyz456', $api_settings->access_token() );
		$this->assertEquals( 999999999, $api_settings->access_token_expiration_time() );
	}

	public function test_remove() {
		$api_settings = FontAwesome_API_Settings::reset();

		update_option(
			FontAwesome_API_Settings::OPTIONS_KEY,
			array(
				'api_token'                    => $api_settings->encrypt( 'abc123' ),
				'access_token'                 => $api_settings->encrypt( 'xyz456' ),
				'access_token_expiration_time' => 999999999,
			)
		);

		// Force re-read.
		$api_settings = FontAwesome_API_Settings::reset();

		$this->assertEquals( 'abc123', $api_settings->api_token() );
		$this->assertEquals( 'xyz456', $api_settings->access_token() );
		$this->assertEquals( 999999999, $api_settings->access_token_expiration_time() );

		// Now remove it, expecting both the in-memory and db data to be cleared.
		$api_settings->remove();

		// Force re-read again.
		$api_settings = FontAwesome_API_Settings::reset();
		$this->assertNull( $api_settings->api_token() );
		$this->assertNull( $api_settings->access_token() );
		$this->assertNull( $api_settings->access_token_expiration_time() );

		$this->assertFalse( get_option( FontAwesome_API_Settings::OPTIONS_KEY ) );
	}

	public function test_encrypt_decrypt() {
		$data = 'foobar';

		$encrypted = fa_api_settings()->encrypt( $data );

		if ( extension_loaded( 'openssl' ) ) {
			$this->assertNotEquals(
				$data,
				$encrypted
			);
		} else {
			$this->assertEquals(
				$data,
				$encrypted
			);
		}

		$this->assertEquals(
			$data,
			fa_api_settings()->decrypt( $encrypted )
		);
	}

	public function test_without_encryption() {
		$access_token                 = 'eyJhbGciOiJIUzUxMiIsInR5cCI6IkpXVCJ9.eyJhdWQiOiJGb250YXdlc29tZSIsImV4cCI6MTU4Mzc3MTQwOCwiaWF0IjoxNTgzNzY3ODA4LCJpc3MiOiJGb250YXdlc29tZSIsImp0aSI6ImE3ZWQ3MTUxLTczZmMtNDUzZC05MzlhLTA4YjY3MDQyZTQ0MCIsIm5iZiI6MTU4Mzc2NzgwNywic3ViIjoiVG9rZW46MTYiLCJ0eXAiOiJhY2Nlc3MifQ.j-0mpIfOsf2TLIj4X1vLcerTRMNSI5s5OjCAb9BduTSQbNegMeOdlJoIIFdkx0r4ZiB65HZ3TjYjH6uNHjOivQ';
		$api_token                    = '8095F4A5-3ED5-4709-8468-F771A046D703';
		$access_token_expiration_time = 999999999;

		$api_settings = mock_singleton_method(
			$this,
			FontAwesome_API_Settings::class,
			'prepare_encryption',
			function( $method ) {
				$method->willReturn(
					null
				);
			}
		);

		$this->assertNull( $api_settings->api_token() );
		$this->assertNull( $api_settings->access_token() );
		$this->assertNull( $api_settings->access_token_expiration_time() );

		$api_settings->set_api_token( $api_token );
		$api_settings->set_access_token( $access_token );
		$api_settings->set_access_token_expiration_time( $access_token_expiration_time );

		$api_settings->write();

		$written_option = get_option( FontAwesome_API_Settings::OPTIONS_KEY );

		$this->assertEquals(
			$api_token,
			$written_option['api_token']
		);

		$this->assertEquals(
			$access_token,
			$written_option['access_token']
		);

		// Re-build to re-set.
		$api_settings = mock_singleton_method(
			$this,
			FontAwesome_API_Settings::class,
			'prepare_encryption',
			function( $method ) {
				$method->willReturn(
					null
				);
			}
		);
		// The mock builder won't run the constructor, so we'll initialize it subsequently.
		$api_settings->initialize();

		$this->assertEquals(
			$api_token,
			$written_option['api_token']
		);

		$this->assertEquals(
			$access_token,
			$written_option['access_token']
		);
	}

	public function test_removal_of_old_api_settings_file_on_write() {
		$file = trailingslashit( ABSPATH ) . 'font-awesome-api.ini';
		// Start with nothing and force re-read.
		$api_settings = FontAwesome_API_Settings::reset();

		$write_results = @file_put_contents( $file, 'foo' );

		$this->assertTrue( boolval( $write_results ) );
		$this->assertTrue( file_exists( $file ) );

		$api_settings->set_api_token( 'foo' );
		$api_settings->set_access_token( 'bar' );
		$api_settings->set_access_token_expiration_time( 42 );

		$result = $api_settings->write();
		$this->assertTrue( $result, 'writing api settings failed' );

		// Force re-read.
		$api_settings = FontAwesome_API_Settings::reset();

		$this->assertEquals( 'foo', $api_settings->api_token() );
		$this->assertEquals( 'bar', $api_settings->access_token() );
		$this->assertEquals( 42, $api_settings->access_token_expiration_time() );
		$this->assertTrue( is_int( $api_settings->access_token_expiration_time() ) );

		// Round-trip it again.
		$result = $api_settings->write();

		$this->assertFalse( file_exists( $file ) );

		// Force re-read.
		$api_settings = FontAwesome_API_Settings::reset();

		$this->assertEquals( 'foo', $api_settings->api_token() );
		$this->assertEquals( 'bar', $api_settings->access_token() );
		$this->assertEquals( 42, $api_settings->access_token_expiration_time() );
		$this->assertTrue( is_int( $api_settings->access_token_expiration_time() ) );

	}
}

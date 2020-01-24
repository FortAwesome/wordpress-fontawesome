<?php
namespace FortAwesome;
/**
 * Class ApiSettingsTest
 */
require_once dirname( __FILE__ ) . '/../includes/class-fontawesome-activator.php';
require_once dirname( __FILE__ ) . '/../includes/class-fontawesome-api-settings.php';
require_once dirname( __FILE__ ) . '/_support/font-awesome-phpunit-util.php';

//use \DateTime, \DateInterval, \DateTimeInterface, \DateTimeZone;

class ApiSettingsTest extends \WP_UnitTestCase {

	public function setUp() {
		wp_delete_file(FontAwesome_API_Settings::ini_path());
		FontAwesome_Activator::activate();
	}

	public function test_read_from_file() {
		$contents = <<< EOD
api_token = "abc123"
access_token = "xyz456"
access_token_expiration_time = "999999999"
EOD;		
		$path = FontAwesome_API_Settings::ini_path();
		$this->assertStringEndsWith(FontAwesome_API_Settings::FILENAME, $path);

		$write_result = @file_put_contents( $path, $contents ); 

		$this->assertGreaterThan(0, $write_result, 'writing ini file failed');

		// Force re-read
		$api_settings = FontAwesome_API_Settings::reset();

		$this->assertEquals('abc123', $api_settings->api_token());
		$this->assertEquals('xyz456', $api_settings->access_token());
		$this->assertEquals('999999999', $api_settings->access_token_expiration_time());

	}

	public function test_read_from_file_when_no_file_exists() {
		// Force re-read
		$api_settings = FontAwesome_API_Settings::reset();

		$this->assertNull($api_settings->api_token());
		$this->assertNull($api_settings->access_token());
		$this->assertNull($api_settings->access_token_expiration_time());
	}

	public function test_write() {
		// Start with nothing
		// Force re-read
		$api_settings = FontAwesome_API_Settings::reset();

		$api_settings->set_api_token('foo');
		$api_settings->set_access_token('bar');
		$api_settings->set_access_token_expiration_time('42');

		$result = $api_settings->write();
		$this->assertTrue($result, 'writing ini file failed');

		// Force re-read
		$api_settings = FontAwesome_API_Settings::reset();

		$this->assertEquals('foo', $api_settings->api_token());
		$this->assertEquals('bar', $api_settings->access_token());
		$this->assertEquals('42', $api_settings->access_token_expiration_time());

	}

	// What if we only write an api token, leave the others null, and the
	// read it back in?
	public function test_round_trip_only_api_token() {
		// Start with nothing
		// Force re-read
		$api_settings = FontAwesome_API_Settings::reset();

		$api_settings->set_api_token('foo');

		$result = $api_settings->write();
		$this->assertTrue($result, 'writing ini file failed');

		// Force re-read
		$api_settings = FontAwesome_API_Settings::reset();

		$this->assertEquals('foo', $api_settings->api_token());
		$this->assertNull($api_settings->access_token());
		$this->assertNull($api_settings->access_token_expiration_time());
	}
}

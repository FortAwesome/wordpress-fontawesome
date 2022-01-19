<?php
namespace FortAwesome;

require_once trailingslashit( FONTAWESOME_DIR_PATH ) . 'includes/class-fontawesome-rest-response.php';
use \WP_REST_Response;
use Yoast\WPTestUtils\WPIntegration\TestCase;

/**
 * RestResponseTest class
 */
class RestResponseTest extends TestCase {
	public function test_defaults() {
		$r = new FontAwesome_REST_Response();

		$this->assertTrue( is_a( $r, 'WP_REST_Response' ) );
		$this->assertNull( $r->get_data() );
		$this->assertEquals( 200, $r->get_status() );
		$this->assertArrayHasKey( FontAwesome_REST_Response::CONFIRMATION_HEADER, $r->get_headers() );
	}

	public function test_non_default() {
		$r = new FontAwesome_REST_Response( 'foo', 422, array( 'FakeHeader' => 42 ) );

		$this->assertTrue( is_a( $r, 'WP_REST_Response' ) );
		$this->assertEquals( 'foo', $r->get_data() );
		$this->assertEquals( 422, $r->get_status() );
		$this->assertArrayHasKey( FontAwesome_REST_Response::CONFIRMATION_HEADER, $r->get_headers() );
		$this->assertArrayHasKey( 'FakeHeader', $r->get_headers() );
		$this->assertEquals( 42, $r->get_headers()['FakeHeader'] );

	}
}

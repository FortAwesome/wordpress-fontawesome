<?php
namespace FortAwesome;

/**
 * Class ConflictDetectionControllerTest
 *
 * @noinspection PhpCSValidationInspection
 */
// phpcs:ignoreFile Squiz.Commenting.ClassComment.Missing
// phpcs:ignoreFile Generic.Commenting.DocComment.MissingShort
require_once dirname( __FILE__ ) . '/_support/font-awesome-phpunit-util.php';

use \DateTime, \DateInterval, \DateTimeInterface, \DateTimeZone;

/**
 * Class ConflictDetectionControllerTest
 */
class ConflictDetectionControllerTest extends \WP_UnitTestCase {
	protected $server;
	protected $admin_user;
	protected $namespaced_conflicts_route = "/" . FontAwesome::REST_API_NAMESPACE . '/conflict-detection/conflicts';
	protected $namespaced_detect_until_route = "/" . FontAwesome::REST_API_NAMESPACE . '/conflict-detection/until';
	protected $namespaced_blocklist_route = "/" . FontAwesome::REST_API_NAMESPACE . '/conflict-detection/conflicts/blocklist';
	protected $fa;

	public function setUp() {
		reset_db();
		remove_all_actions( 'font_awesome_preferences' );
		FontAwesome::reset();
		$this->set_options('5.4.1');

		global $wp_rest_server;

		$this->server = $wp_rest_server = new \WP_REST_Server;
		$this->admin_user = get_users( [ 'role' => 'administrator' ] )[0];

		wp_set_current_user( $this->admin_user->ID, $this->admin_user->user_login );

		add_action(
			'rest_api_init',
			array(
				new FontAwesome_Conflict_Detection_Controller(
					FontAwesome::PLUGIN_NAME,
					FontAwesome::REST_API_NAMESPACE
				),
				'register_routes',
			)
		);

		do_action( 'rest_api_init' );
	}

	public function set_options( $version ) {
		update_option(
			FontAwesome::OPTIONS_KEY,
			array_merge(
				FontAwesome::DEFAULT_USER_OPTIONS,
				[ 'version' => $version ]
			)
		);
	}

	public function test_register_route() {
		$routes = $this->server->get_routes();
		$this->assertArrayHasKey( $this->namespaced_conflicts_route, $routes );
		$this->assertArrayHasKey( $this->namespaced_detect_until_route, $routes );
		$this->assertArrayHasKey( $this->namespaced_blocklist_route, $routes );
  }

	public function test_report_conflicts_when_detecting_conflicts() {
		$now = time();
		// ten minutes later
		$later = $now + (10 * 60);

		update_option(
			FontAwesome::CONFLICT_DETECTION_OPTIONS_KEY,
			array_merge(
				FontAwesome::DEFAULT_CONFLICT_DETECTION_OPTIONS,
				array(
					'detectConflictsUntil' => $later
				)
			)
		);

		$body = array(
			'a9a9aa2d454f77cd623d6755c902c408' => array(
				'type' => 'script',
				'src'  => 'http://example.com/fake.js'
			),
			'83c869f6fa4c3138019f564a3358e877' => array(
				'type' => 'style',
				'src'  => 'http://example.com/fake.css'
			)
		);

		$request  = new \WP_REST_Request(
			'POST',
			$this->namespaced_conflicts_route
		);

		$request->add_header('Content-Type', 'application/json');

		$request->set_body( wp_json_encode( $body ) );

		$response = $this->server->dispatch( $request );
		
		$this->assertEquals( 200, $response->get_status() );

		$this->assertEquals(
			fa()->unregistered_clients(),
			$response->get_data()
		);
    
		$this->assertEquals(
			$body,
			fa()->unregistered_clients()
		);
	}

	public function test_report_conflicts_when_no_change() {
		$now = time();
		// ten minutes later
		$later = $now + (10 * 60);

		$initial_data = array(
			'a9a9aa2d454f77cd623d6755c902c408' => array(
				'type' => 'script',
				'src'  => 'http://example.com/fake.js'
			),
			'83c869f6fa4c3138019f564a3358e877' => array(
				'type' => 'style',
				'src'  => 'http://example.com/fake.css'
			)
		);

		update_option(
			FontAwesome::CONFLICT_DETECTION_OPTIONS_KEY,
			array_merge(
				FontAwesome::DEFAULT_CONFLICT_DETECTION_OPTIONS,
				array(
					'detectConflictsUntil' => $later,
					'unregisteredClients' => $initial_data
				)
			)
		);

		$request  = new \WP_REST_Request(
			'POST',
			$this->namespaced_conflicts_route
		);

		$request->add_header('Content-Type', 'application/json');

		$request->set_body( wp_json_encode( $initial_data ) );

		$response = $this->server->dispatch( $request );
		
		$this->assertEquals( 204, $response->get_status() );
    
		$this->assertEquals(
			$initial_data,
			fa()->unregistered_clients()
		);

		// This should have remained unchanged.
		$this->assertEquals(
			$later,
			get_option( FontAwesome::CONFLICT_DETECTION_OPTIONS_KEY )['detectConflictsUntil']
		);
	}

	public function test_report_conflicts_when_not_detecting_conflicts() {
		update_option(
			FontAwesome::CONFLICT_DETECTION_OPTIONS_KEY,
			array(
				'detectConflictsUntil' => 0,
				'unregisteredClients' => array()
			)
		);

		$body = array(
			'a9a9aa2d454f77cd623d6755c902c408' => array(
				'type' => 'script',
				'src'  => 'http://example.com/fake.js'
			),
		);

		$request  = new \WP_REST_Request(
			'POST',
			$this->namespaced_conflicts_route
		);

		$request->add_header('Content-Type', 'application/json');

		$request->set_body( wp_json_encode( $body ) );

		$response = $this->server->dispatch( $request );

		$this->assertEquals( 404, $response->get_status() );
 
 		$this->assertEquals(
			array(),
			fa()->unregistered_clients()
		);
	}

	public function test_report_conflicts_when_adding_additional_conflicts() {
		$now = time();
		// ten minutes later
		$later = $now + (10 * 60);

		$initial_data = array(
			'a9a9aa2d454f77cd623d6755c902c408' => array(
				'type' => 'script',
				'src'  => 'http://example.com/fake.js'
			),
			'83c869f6fa4c3138019f564a3358e877' => array(
				'type' => 'style',
				'src'  => 'http://example.com/fake.css'
			)
		);

		$new_data = array(
			'deadbeefdeadbeefdeadbeefdeadbeef' => array(
				'type' => 'script',
				'src'  => 'http://example.com/deadbeef42.js'
			),
		);

		update_option(
			FontAwesome::CONFLICT_DETECTION_OPTIONS_KEY,
			array_merge(
				FontAwesome::DEFAULT_CONFLICT_DETECTION_OPTIONS,
				array(
					'detectConflictsUntil' => $later,
					'unregisteredClients' => $initial_data
				)
			)
		);

		$request  = new \WP_REST_Request(
			'POST',
			$this->namespaced_conflicts_route
		);

		$request->add_header('Content-Type', 'application/json');

		$request->set_body( wp_json_encode( $new_data ) );

		$response = $this->server->dispatch( $request );
    
		$this->assertEquals( 200, $response->get_status() );

		$this->assertEquals(
			fa()->unregistered_clients(),
			$response->get_data()
		);

		$this->assertEquals(
 			array_merge(
				$initial_data,
				$new_data
			),
			fa()->unregistered_clients()
		);

		// This should have remained unchanged.
		$this->assertEquals(
			$later,
			get_option( FontAwesome::CONFLICT_DETECTION_OPTIONS_KEY )['detectConflictsUntil']
		);
	}

	public function test_report_conflicts_when_adding_with_bad_schema() {
		$now = time();
		// ten minutes later
		$later = $now + (10 * 60);

		$initial_data = array(
			'a9a9aa2d454f77cd623d6755c902c408' => array(
				'type' => 'script',
				'src'  => 'http://example.com/fake.js'
			)
		);

		update_option(
			FontAwesome::CONFLICT_DETECTION_OPTIONS_KEY,
			array(
				'detectConflictsUntil' => $later,
				'unregisteredClients' => $initial_data
			)
		);

		$body = array(
			'type' => 'style',
			'src'  => 'http://example.com/fake.css',
			'md5'  => '83c869f6fa4c3138019f564a3358e877',
		);

		$request  = new \WP_REST_Request(
			'POST',
			$this->namespaced_conflicts_route
		);

		$request->add_header('Content-Type', 'application/json');

		$request->set_body( wp_json_encode( $body ) );

		$response = $this->server->dispatch( $request );
 
		$this->assertEquals( 400, $response->get_status() );

		$error = $response->as_error();

 		$this->assertEquals( 'fontawesome_client_exception', $error->get_error_code() );

		$this->assertEquals(
			$initial_data,
			fa()->unregistered_clients()
		);
	}

	public function test_update_detect_conflicts_until() {
		$now = time();
		// ten minutes later
		$later = $now + (10 * 60);

		$initial_unregistered_clients = array(
			'a9a9aa2d454f77cd623d6755c902c408' => array(
				'type' => 'script',
				'src'  => 'http://example.com/fake.js'
			),
		);

		update_option(
			FontAwesome::CONFLICT_DETECTION_OPTIONS_KEY,
			array(
				'detectConflictsUntil' => 0,
				'unregisteredClients'  => $initial_unregistered_clients
			)
		);

		$this->assertFalse( fa()->detecting_conflicts() );

		$request = new \WP_REST_Request(
			'PUT',
			$this->namespaced_detect_until_route
		);

		$request->add_header('Content-Type', 'application/json');

		$body = $later;
		$request->set_body( wp_json_encode( $body ) );

		$response = $this->server->dispatch( $request );

		$this->assertEquals( 200, $response->get_status() );

		$this->assertEquals(
			$later,
			$response->get_data()
		);

		$this->assertTrue( fa()->detecting_conflicts() );

		// There should have been no change in this.
		$this->assertEquals(
			$initial_unregistered_clients,
			fa()->unregistered_clients()
		);
	}

	public function test_update_detect_conflicts_until_when_no_change() {
		$initial_unregistered_clients = array(
			'a9a9aa2d454f77cd623d6755c902c408' => array(
				'type' => 'script',
				'src'  => 'http://example.com/fake.js'
			),
		);

		update_option(
			FontAwesome::CONFLICT_DETECTION_OPTIONS_KEY,
			array(
				'detectConflictsUntil' => 1234,
				'unregisteredClients'  => $initial_unregistered_clients
			)
		);

		$this->assertFalse( fa()->detecting_conflicts() );

		$request = new \WP_REST_Request(
			'PUT',
			$this->namespaced_detect_until_route
		);

		$request->add_header('Content-Type', 'application/json');

		$body = 1234;

		$request->set_body( wp_json_encode( $body ) );

		$response = $this->server->dispatch( $request );

		$this->assertEquals( 204, $response->get_status() );

		$this->assertFalse( fa()->detecting_conflicts() );

		$this->assertEquals(
			1234,
			get_option( FontAwesome::CONFLICT_DETECTION_OPTIONS_KEY )['detectConflictsUntil']
		);

		// There should have been no change in this.
		$this->assertEquals(
			$initial_unregistered_clients,
			fa()->unregistered_clients()
		);
	}

	public function test_update_detect_conflicts_until_when_bad_schema() {
		$now = time();
		// ten minutes later
		$later = $now + (10 * 60);

		$initial_unregistered_clients = array(
			'a9a9aa2d454f77cd623d6755c902c408' => array(
				'type' => 'script',
				'src'  => 'http://example.com/fake.js'
			),
		);

		update_option(
			FontAwesome::CONFLICT_DETECTION_OPTIONS_KEY,
			array(
				'detectConflictsUntil' => $later,
				'unregisteredClients'  => $initial_unregistered_clients
			)
		);

		$request = new \WP_REST_Request(
			'PUT',
			$this->namespaced_detect_until_route
		);

		$request->add_header('Content-Type', 'application/json');

		$body = array(
			'detectConflictsUntil' => 'foo'
		);

		$request->set_body( wp_json_encode( $body ) );

		$response = $this->server->dispatch( $request );

		$this->assertEquals( 400, $response->get_status() );

		$error = $response->as_error();

		$this->assertEquals(
			'fontawesome_detect_conflicts_until_schema',
			$error->get_error_code()
		);

		$this->assertTrue( fa()->detecting_conflicts() );

		// There should have been no change in this.
		$this->assertEquals(
			$initial_unregistered_clients,
			fa()->unregistered_clients()
		);
	}

	public function test_delete_conflicts() {
		$initial_data = array(
			'a9a9aa2d454f77cd623d6755c902c408' => array(
				'type' => 'script',
				'src'  => 'http://example.com/fake.js'
			),
			'83c869f6fa4c3138019f564a3358e877' => array(
				'type' => 'style',
				'src'  => 'http://example.com/fake.css'
			),
			'deadbeefdeadbeefdeadbeefdeadbeef' => array(
				'type' => 'script',
				'src'  => 'http://example.com/deadbeef42.js'
			),
		);

		$expected_after_deletion = array(
			'deadbeefdeadbeefdeadbeefdeadbeef' => array(
				'type' => 'script',
				'src'  => 'http://example.com/deadbeef42.js'
			),
		);

		update_option(
			FontAwesome::CONFLICT_DETECTION_OPTIONS_KEY,
			array_merge(
				FontAwesome::DEFAULT_CONFLICT_DETECTION_OPTIONS,
				array(
					// Should not matter whether conflict detection is enabled.
					'detectConflictsUntil' => 42,
					'unregisteredClients' => $initial_data
				)
			)
		);

		// Two that exist and should be deleted. One that does not exist and should be ignored.
		$ids = [ 'a9a9aa2d454f77cd623d6755c902c408', '83c869f6fa4c3138019f564a3358e877', 'abcabcabcabcabcabcabcabc3358e877' ];

		$request  = new \WP_REST_Request(
			'DELETE',
			$this->namespaced_conflicts_route
		);

		$request->add_header('Content-Type', 'application/json');

		$request->set_body( wp_json_encode( $ids ) );

		$response = $this->server->dispatch( $request );
    
		$this->assertEquals( 200, $response->get_status() );

		$this->assertEquals(
			fa()->unregistered_clients(),
			$response->get_data()
		);

		$this->assertEquals(
			$expected_after_deletion,
			fa()->unregistered_clients()
		);

		// This should have remained unchanged.
		$this->assertEquals(
			42,
			get_option( FontAwesome::CONFLICT_DETECTION_OPTIONS_KEY )['detectConflictsUntil']
		);
	}

	public function test_delete_conflicts_when_no_change() {
		$initial_data = array(
			'a9a9aa2d454f77cd623d6755c902c408' => array(
				'type' => 'script',
				'src'  => 'http://example.com/fake.js'
			),
			'83c869f6fa4c3138019f564a3358e877' => array(
				'type' => 'style',
				'src'  => 'http://example.com/fake.css'
			),
			'deadbeefdeadbeefdeadbeefdeadbeef' => array(
				'type' => 'script',
				'src'  => 'http://example.com/deadbeef42.js'
			),
		);

		update_option(
			FontAwesome::CONFLICT_DETECTION_OPTIONS_KEY,
			array_merge(
				FontAwesome::DEFAULT_CONFLICT_DETECTION_OPTIONS,
				array(
					// Should not matter whether conflict detection is enabled.
					'detectConflictsUntil' => 42,
					'unregisteredClients' => $initial_data
				)
			)
		);

		// One md5 that does not exist.
		$ids = [ 'abcabcabcabcabcabcabcabc3358e877' ];

		$request  = new \WP_REST_Request(
			'DELETE',
			$this->namespaced_conflicts_route
		);

		$request->add_header('Content-Type', 'application/json');

		$request->set_body( wp_json_encode( $ids ) );

		$response = $this->server->dispatch( $request );
    
		$this->assertEquals( 204, $response->get_status() );

		$this->assertEquals(
			$initial_data,
			fa()->unregistered_clients()
		);

		// This should have remained unchanged.
		$this->assertEquals(
			42,
			get_option( FontAwesome::CONFLICT_DETECTION_OPTIONS_KEY )['detectConflictsUntil']
		);
	}

	public function test_delete_conflicts_when_invalid_input() {
		$initial_data = array(
			'a9a9aa2d454f77cd623d6755c902c408' => array(
				'type' => 'script',
				'src'  => 'http://example.com/fake.js'
			),
			'83c869f6fa4c3138019f564a3358e877' => array(
				'type' => 'style',
				'src'  => 'http://example.com/fake.css'
			),
			'deadbeefdeadbeefdeadbeefdeadbeef' => array(
				'type' => 'script',
				'src'  => 'http://example.com/deadbeef42.js'
			),
		);

		update_option(
			FontAwesome::CONFLICT_DETECTION_OPTIONS_KEY,
			array_merge(
				FontAwesome::DEFAULT_CONFLICT_DETECTION_OPTIONS,
				array(
					// Should not matter whether conflict detection is enabled.
					'detectConflictsUntil' => 42,
					'unregisteredClients' => $initial_data
				)
			)
		);

		// One invalid md5.
		$ids = [ 'foo' ];

		$request  = new \WP_REST_Request(
			'DELETE',
			$this->namespaced_conflicts_route
		);

		$request->add_header('Content-Type', 'application/json');

		$request->set_body( wp_json_encode( $ids ) );

		$response = $this->server->dispatch( $request );
    
		$this->assertEquals( 400, $response->get_status() );

		$this->assertEquals(
			$initial_data,
			fa()->unregistered_clients()
		);

		$this->assertEquals(
			'fontawesome_client_exception',
			$response->as_error()->get_error_code()
		);

		// This should have remained unchanged.
		$this->assertEquals(
			42,
			get_option( FontAwesome::CONFLICT_DETECTION_OPTIONS_KEY )['detectConflictsUntil']
		);
	}

	public function test_update_blocklist() {
		$initial_data = array(
			'a9a9aa2d454f77cd623d6755c902c408' => array(
				'type' => 'script',
				'src'  => 'http://example.com/fake.js'
			),
			'83c869f6fa4c3138019f564a3358e877' => array(
				'type' => 'style',
				'src'  => 'http://example.com/fake.css'
			),
			'deadbeefdeadbeefdeadbeefdeadbeef' => array(
				'type' => 'script',
				'src'  => 'http://example.com/deadbeef42.js'
			),
		);

		update_option(
			FontAwesome::CONFLICT_DETECTION_OPTIONS_KEY,
			array_merge(
				FontAwesome::DEFAULT_CONFLICT_DETECTION_OPTIONS,
				array(
					// Should not matter whether conflict detection is enabled.
					'detectConflictsUntil' => 42,
					'unregisteredClients' => $initial_data
				)
			)
		);

		$ids = [ 'a9a9aa2d454f77cd623d6755c902c408', '83c869f6fa4c3138019f564a3358e877' ];

		$request  = new \WP_REST_Request(
			'PUT',
			$this->namespaced_blocklist_route
		);

		$request->add_header('Content-Type', 'application/json');

		$request->set_body( wp_json_encode( $ids ) );

		$response = $this->server->dispatch( $request );
    
		$this->assertEquals( 200, $response->get_status() );

		$this->assertEquals(
			$ids,
			$response->get_data()
		);

		$this->assertEquals(
			$ids,
			fa()->blocklist()
		);

		// This should have remained unchanged.
		$this->assertEquals(
			42,
			get_option( FontAwesome::CONFLICT_DETECTION_OPTIONS_KEY )['detectConflictsUntil']
		);
	}

	public function test_update_blocklist_clearing_all_blocks() {
		$initial_data = array(
			'a9a9aa2d454f77cd623d6755c902c408' => array(
				'type'    => 'script',
				'src'     => 'http://example.com/fake.js',
				'blocked' => false
			),
			'83c869f6fa4c3138019f564a3358e877' => array(
				'type'    => 'style',
				'src'     => 'http://example.com/fake.css',
				'blocked' => true
			),
			'deadbeefdeadbeefdeadbeefdeadbeef' => array(
				'type'    => 'script',
				'src'     => 'http://example.com/deadbeef42.js',
				'blocked' => true
			),
		);

		update_option(
			FontAwesome::CONFLICT_DETECTION_OPTIONS_KEY,
			array_merge(
				FontAwesome::DEFAULT_CONFLICT_DETECTION_OPTIONS,
				array(
					// Should not matter whether conflict detection is enabled.
					'detectConflictsUntil' => 42,
					'unregisteredClients' => $initial_data
				)
			)
		);

		$ids = [];

		$request  = new \WP_REST_Request(
			'PUT',
			$this->namespaced_blocklist_route
		);

		$request->add_header('Content-Type', 'application/json');

		$request->set_body( wp_json_encode( $ids ) );

		$response = $this->server->dispatch( $request );
    
		$this->assertEquals( 200, $response->get_status() );

		$this->assertEquals(
			$ids,
			$response->get_data()
		);

		$this->assertEquals(
			$ids,
			fa()->blocklist()
		);

		// This should have remained unchanged.
		$this->assertEquals(
			42,
			get_option( FontAwesome::CONFLICT_DETECTION_OPTIONS_KEY )['detectConflictsUntil']
		);
	}

	public function test_update_blocklist_when_no_change() {
		$initial_data = array(
			'a9a9aa2d454f77cd623d6755c902c408' => array(
				'type'    => 'script',
				'src'     => 'http://example.com/fake.js',
				'blocked' => TRUE
			),
			'83c869f6fa4c3138019f564a3358e877' => array(
				'type'    => 'style',
				'src'     => 'http://example.com/fake.css',
				'blocked' => TRUE
			),
			'deadbeefdeadbeefdeadbeefdeadbeef' => array(
				'type'    => 'script',
				'src'     => 'http://example.com/deadbeef42.js',
				'blocked' => FALSE
			),
		);

		update_option(
			FontAwesome::CONFLICT_DETECTION_OPTIONS_KEY,
			array_merge(
				FontAwesome::DEFAULT_CONFLICT_DETECTION_OPTIONS,
				array(
					// Should not matter whether conflict detection is enabled.
					'detectConflictsUntil' => 42,
					'unregisteredClients' => $initial_data
				)
			)
		);

		$ids = [ 'a9a9aa2d454f77cd623d6755c902c408', '83c869f6fa4c3138019f564a3358e877' ];

		$request  = new \WP_REST_Request(
			'PUT',
			$this->namespaced_blocklist_route
		);

		$request->add_header('Content-Type', 'application/json');

		$request->set_body( wp_json_encode( $ids ) );

		$response = $this->server->dispatch( $request );
    
		$this->assertEquals( 204, $response->get_status() );

		$this->assertEquals(
			$ids,
			fa()->blocklist()
		);

		// This should have remained unchanged.
		$this->assertEquals(
			42,
			get_option( FontAwesome::CONFLICT_DETECTION_OPTIONS_KEY )['detectConflictsUntil']
		);
	}
}

<?php
namespace FortAwesome;

require_once dirname( __FILE__ ) . '/_support/font-awesome-phpunit-util.php';

/**
 * Class V3DeprecationControllerTest
 */
class V3DeprecationControllerTest extends \WP_UnitTestCase {
	protected $server;
	protected $admin_user;
	protected $namespaced_route = "/" . FontAwesome::REST_API_NAMESPACE . '/v3deprecation';
	protected $fa;

	public function setUp() {
		reset_db();
		remove_all_actions( 'font_awesome_preferences' );
		FontAwesome::reset();

		update_option(
			FontAwesome::OPTIONS_KEY,
			array_merge(
				FontAwesome::DEFAULT_USER_OPTIONS,
				[
					'version' => '5.4.1'
				]
			)
		);

		global $wp_rest_server;

		$this->server = $wp_rest_server = new \WP_REST_Server;
		$this->admin_user = get_users( [ 'role' => 'administrator' ] )[0];

		wp_set_current_user( $this->admin_user->ID, $this->admin_user->user_login );

		add_action(
			'rest_api_init',
			array(
				new FontAwesome_V3Deprecation_Controller(
					FontAwesome::PLUGIN_NAME,
					FontAwesome::REST_API_NAMESPACE
				),
				'register_routes',
			)
		);

		do_action( 'rest_api_init' );
	}

	public function test_register_route() {
		$routes = $this->server->get_routes();
		$this->assertArrayHasKey( $this->namespaced_route, $routes );
	}

	public function test_update_item() {
		$this->assertFalse( boolval( fa()->get_v3deprecation_warning_data() )  );
		$request  = new \WP_REST_Request(
			'PUT',
			$this->namespaced_route
		);

		$request->add_header('Content-Type', 'application/json');

		$request->set_body(
			wp_json_encode(
				[
					'snooze' => true
				]
			)
		);
		$response = $this->server->dispatch( $request );
		$this->assertEquals( 200, $response->get_status() );
		$data = $response->get_data();

		$this->assertTrue( boolval( fa()->get_v3deprecation_warning_data() ) );

		$warning_data = isset( $data['v3DeprecationWarning']['snooze'] ) && boolval( $data['v3DeprecationWarning']['snooze'] );
		$this->assertTrue( $warning_data );
		$this->assertEquals( fa()->get_v3deprecation_warning_data(), $data['v3DeprecationWarning'] );
	}

	public function test_get_item() {
		fa()->snooze_v3deprecation_warning();

		$request  = new \WP_REST_Request(
			'GET',
			$this->namespaced_route
		);

		$response = $this->server->dispatch( $request );
		$this->assertEquals( 200, $response->get_status() );
		$data = $response->get_data();

		$warning_data = isset( $data['v3DeprecationWarning']['snooze'] ) && boolval( $data['v3DeprecationWarning']['snooze'] );
		$this->assertTrue( $warning_data );

		$this->assertEquals( fa()->get_v3deprecation_warning_data(), $data['v3DeprecationWarning'] );
	}
}

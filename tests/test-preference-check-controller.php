<?php
namespace FortAwesome;

require_once dirname( __FILE__ ) . '/_support/font-awesome-phpunit-util.php';
use Yoast\WPTestUtils\WPIntegration\TestCase;

/**
 * Class PreferenceCheckControllerTest
 */
class PreferenceCheckControllerTest extends TestCase {
	protected $server;
	protected $admin_user;
	protected $namespaced_route = '/' . FontAwesome::REST_API_NAMESPACE . '/preference-check';
	protected $fa;

	public function set_up() {
		parent::set_up();
		reset_db();
		remove_all_actions( 'font_awesome_preferences' );
		FontAwesome::reset();
		$this->set_options( '5.4.1' );

		global $wp_rest_server;

		$wp_rest_server = new \WP_REST_Server();

		$this->server = $wp_rest_server;

		$this->admin_user = get_users( array( 'role' => 'administrator' ) )[0];

		wp_set_current_user( $this->admin_user->ID, $this->admin_user->user_login );

		add_action(
			'rest_api_init',
			array(
				new FontAwesome_Preference_Check_Controller(
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
				array( 'version' => $version )
			)
		);
	}

	public function test_register_route() {
		$routes = $this->server->get_routes();
		$this->assertArrayHasKey( $this->namespaced_route, $routes );
	}

	public function test_check_conflicts_when_no_conflicts() {
		fa()->register(
			array(
				'name'    => 'alpha',
				'version' => array( array( '5.4.0', '>=' ) ),
			)
		);

		fa()->register(
			array(
				'name'           => 'beta',
				'pseudoElements' => FontAwesome::DEFAULT_USER_OPTIONS['pseudoElements'],
			)
		);

		$request = new \WP_REST_Request(
			'POST',
			$this->namespaced_route
		);
		$request->add_header( 'Content-Type', 'application/json' );
		$options =
			array_merge(
				FontAwesome::DEFAULT_USER_OPTIONS,
				array(
					'compat'  => false,
					'version' => '53.1.3',
				)
			);
		$request->set_body(
			wp_json_encode(
				$options
			)
		);
		$response = $this->server->dispatch( $request );
		$this->assertEquals( 200, $response->get_status() );
		$data = $response->get_data();

		$this->assertEquals( array(), $data );
	}

	public function test_check_conflicts_with_conflicts() {
		fa()->register(
			array(
				'name'    => 'alpha',
				'version' => array( array( '5.8.0', '>=' ) ),
			)
		);

		fa()->register(
			array(
				'name'   => 'beta',
				'compat' => ! FontAwesome::DEFAULT_USER_OPTIONS['compat'],
			)
		);

		$request = new \WP_REST_Request(
			'POST',
			$this->namespaced_route
		);
		$request->add_header( 'Content-Type', 'application/json' );
		$request->set_body(
			wp_json_encode(
				array_merge(
					FontAwesome::DEFAULT_USER_OPTIONS,
					array( 'version' => '5.6.0' )
				)
			)
		);
		$response = $this->server->dispatch( $request );
		$this->assertEquals( 200, $response->get_status() );

		$data = $response->get_data();
		$this->assertEquals(
			array(
				'version' => array( 'alpha' ),
				'compat'  => array( 'beta' ),
			),
			$data
		);
	}
}

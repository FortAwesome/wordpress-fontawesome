<?php
namespace FortAwesome;

/**
 * Class PreferenceCheckControllerTest
 *
 * @noinspection PhpCSValidationInspection
 */
// phpcs:ignoreFile Squiz.Commenting.ClassComment.Missing
// phpcs:ignoreFile Generic.Commenting.DocComment.MissingShort
require_once dirname( __FILE__ ) . '/_support/font-awesome-phpunit-util.php';

/**
 * Class PreferenceCheckControllerTest
 */
class PreferenceCheckControllerTest extends \WP_UnitTestCase {
	protected $server;
	protected $admin_user;
	protected $namespaced_route = "/" . FontAwesome::REST_API_NAMESPACE . '/preference-check';
	protected $fa;

	public function setUp() {
		reset_db();
		FontAwesome::reset();
		$this->set_options('5.4.1');

		global $wp_rest_server;

		$this->server = $wp_rest_server = new \WP_REST_Server;
		$this->admin_user = get_users( [ 'role' => 'administrator' ] )[0];

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
				[ 'version' => $version ]
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
				'name' => 'alpha',
				'version' => [ ['5.4.0', '>='] ]
			)
		);

		fa()->register(
			array(
				'name'              => 'beta',
				'svgPseudoElements' => FontAwesome::DEFAULT_USER_OPTIONS['svgPseudoElements']
			)
		);

		$request  = new \WP_REST_Request(
			'POST',
			$this->namespaced_route
		);
		$request->add_header('Content-Type', 'application/json');
		$options =
			array_merge(
				FontAwesome::DEFAULT_USER_OPTIONS,
				array(
					'v4compat' => false,
					'version' => '53.1.3'
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

		$this->assertEquals([], $data);
	}

	public function test_check_conflicts_with_conflicts() {
		fa()->register(
			array(
				'name' => 'alpha',
				'version' => [ ['5.8.0', '>='] ]
			)
		);

		fa()->register(
			array(
				'name'              => 'beta',
				'v4compat' => ! FontAwesome::DEFAULT_USER_OPTIONS['v4compat']
			)
		);

		$request  = new \WP_REST_Request(
			'POST',
			$this->namespaced_route
		);
		$request->add_header('Content-Type', 'application/json');
		$request->set_body(
			wp_json_encode(
				array_merge(
					FontAwesome::DEFAULT_USER_OPTIONS,
					[ 'version' => '5.6.0' ]
				)
			)
		);
		$response = $this->server->dispatch( $request );
		$this->assertEquals( 200, $response->get_status() );

		$data = $response->get_data();
		$this->assertEquals(
			array(
				'version'  => [ 'alpha' ],
				'v4compat' => [ 'beta' ]
			),
			$data
		);
	}
}

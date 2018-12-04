<?php
/**
 * Class RequirementsTest
 *
 * @noinspection PhpCSValidationInspection
 */
// phpcs:ignoreFile Squiz.Commenting.ClassComment.Missing
// phpcs:ignoreFile Generic.Commenting.DocComment.MissingShort
require_once dirname( __FILE__ ) . '/_support/font-awesome-phpunit-util.php';
require_once FONTAWESOME_DIR_PATH . 'includes/class-fontawesome-config-controller.php';

/**
* Class ConfigControllerTest
*/
class ConfigControllerTest extends WP_UnitTestCase {
	protected $server;

	public function setUp() {
		global $wp_rest_server;
		$this->server = $wp_rest_server = new \WP_REST_Server;
		$fa = FontAwesome::reset();
		$fa->run();
		do_action( 'rest_api_init' );
	}

	public function test_register_route() {
		$routes = $this->server->get_routes();
		$namespaced_route = "/" . FontAwesome::REST_API_NAMESPACE . '/config';
		$this->assertArrayHasKey( $namespaced_route, $routes );
	}
}

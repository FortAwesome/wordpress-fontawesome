<?php

namespace FortAwesome;

use Yoast\WPTestUtils\WPIntegration\TestCase;

/**
 * Class RequirementsTest
 *
 * @noinspection PhpCSValidationInspection
 */
// phpcs:ignoreFile Squiz.Commenting.ClassComment.Missing
// phpcs:ignoreFile Generic.Commenting.DocComment.MissingShort
require_once dirname(__FILE__) . '/_support/font-awesome-phpunit-util.php';

/**
 * Class ConfigControllerTest
 * Thanks to Josh Pollock for a helpful guide to testing this controller:
 * https://torquemag.io/2017/01/testing-api-endpoints/
 */
class ConfigControllerTest extends TestCase
{
    protected $server;
    protected $admin_user;
    protected $namespaced_route = "/" . FontAwesome::REST_API_NAMESPACE . '/config';
    protected $fa;

    public function set_up()
    {
        parent::set_up();
        reset_db();
        remove_all_actions('font_awesome_preferences');

        (new Mock_FontAwesome_Metadata_Provider())->mock(
            array(
                wp_json_encode(
                    array(
                        'data' => graphql_releases_query_fixture(),
                    )
                )
            )
        );

        mock_singleton_method(
            $this,
            FontAwesome_SVG_Styles_Manager::class,
            'maybe_setup_selfhosting',
            function ($method) {
                $method->willReturn(null);
            }
        );

        FontAwesome_Release_Provider::load_releases();

        global $wp_rest_server;

        $this->server = $wp_rest_server = new \WP_REST_Server();
        $this->admin_user = get_users(['role' => 'administrator'])[0];

        wp_set_current_user($this->admin_user->ID, $this->admin_user->user_login);

        add_action(
            'rest_api_init',
            array(
                new FontAwesome_Config_Controller(FontAwesome::PLUGIN_NAME, FontAwesome::REST_API_NAMESPACE),
                'register_routes',
            )
        );

        do_action('rest_api_init');
    }

    public function tear_down()
    {
        parent::tear_down();
        remove_all_actions('rest_api_init');
    }

    public function set_version($version)
    {
        update_option(
            FontAwesome::OPTIONS_KEY,
            array_merge(
                FontAwesome::DEFAULT_USER_OPTIONS,
                ['version' => $version]
            )
        );
    }

    public function test_register_route()
    {
        $routes = $this->server->get_routes();
        $this->assertArrayHasKey($this->namespaced_route, $routes);
    }

    public function test_endpoints()
    {
        $the_route = $this->namespaced_route;
        $routes = $this->server->get_routes();
        foreach ($routes as $route => $route_config) {
            if (0 === strpos($the_route, $route)) {
                $this->assertTrue(is_array($route_config));
                foreach ($route_config as $i => $endpoint) {
                    $this->assertArrayHasKey('callback', $endpoint);
                    $this->assertArrayHasKey(0, $endpoint['callback'], get_class($this));
                    $this->assertArrayHasKey(1, $endpoint['callback'], get_class($this));
                    $this->assertTrue(is_callable(array($endpoint['callback'][0], $endpoint['callback'][1])));
                }
            }
        }
    }

    /**
     * When we update the options to use a kit, and that kit's version is not
     * 'latest', but an concrete version number like '5.4.1', then that 5.4.1
     * is what should be stored.
     */
    public function test_update_with_kit_not_latest_version()
    {
        // Start with the version being something else.
        $this->set_version('5.3.1');

        $request_body = array(
            'options' => array(
                'usePro' => true,
                'compat' => true,
                'technology' => 'webfont',
                'pseudoElements' => true,
                'kitToken' => '778ccf8260',
                'apiToken' => true,
                'version' => '5.4.1',
            ),
            'conflicts' => array()
        );

        $request  = new \WP_REST_Request(
            'POST',
            $this->namespaced_route
        );

        $request->add_header('Content-Type', 'application/json');
        $request->set_body(wp_json_encode($request_body));
        $response = $this->server->dispatch($request);
        $this->assertEquals(200, $response->get_status());
        $data = $response->get_data();
        $this->assertArrayHasKey('conflicts', $data);
        $this->assertArrayHasKey('options', $data);
        $this->assertEquals('5.4.1', $data['options']['version']);
        $this->assertEquals('5.4.1', fa()->version());
    }

    /**
     * When we update the options to use a kit, and that kit's version is not
     * 'latest', but a major version range, '5.x' or '6.x' then that range
     * value is what is stored.
     */
    public function test_update_kit_major_version_range()
    {
        // Start with the version being something else.
        $this->set_version('5.3.1');

        $request_body = array(
            'options' => array(
                'usePro' => true,
                'compat' => true,
                'technology' => 'webfont',
                'pseudoElements' => true,
                'kitToken' => '778ccf8260',
                'apiToken' => true,
                'version' => '5.x',
            ),
            'conflicts' => array()
        );

        $request  = new \WP_REST_Request(
            'POST',
            $this->namespaced_route
        );

        $request->add_header('Content-Type', 'application/json');
        $request->set_body(wp_json_encode($request_body));
        $response = $this->server->dispatch($request);
        $this->assertEquals(200, $response->get_status());
        $data = $response->get_data();
        $this->assertArrayHasKey('conflicts', $data);
        $this->assertArrayHasKey('options', $data);
        $this->assertEquals('5.x', $data['options']['version']);
        $this->assertEquals('5.x', fa()->version());

        // Now try 6.x

        $request_body = array(
            'options' => array(
                'usePro' => true,
                'compat' => true,
                'technology' => 'webfont',
                'pseudoElements' => true,
                'kitToken' => '778ccf8260',
                'apiToken' => true,
                'version' => '6.x',
            ),
            'conflicts' => array()
        );

        $request  = new \WP_REST_Request(
            'POST',
            $this->namespaced_route
        );

        $request->add_header('Content-Type', 'application/json');
        $request->set_body(wp_json_encode($request_body));
        $response = $this->server->dispatch($request);
        $this->assertEquals(200, $response->get_status());
        $data = $response->get_data();
        $this->assertArrayHasKey('conflicts', $data);
        $this->assertArrayHasKey('options', $data);
        $this->assertEquals('6.x', $data['options']['version']);
        $this->assertEquals('6.x', fa()->version());
    }

    public function test_update_with_kit_using_symbolic_latest_version()
    {
        // Start with the version being something else.
        $this->set_version('5.3.1');

        $request_body = array(
            'options' => array(
                'usePro' => true,
                'compat' => true,
                'technology' => 'webfont',
                'pseudoElements' => true,
                'kitToken' => '778ccf8260',
                'apiToken' => true,
                'version' => 'latest',
            ),
            'conflicts' => array()
        );

        $request  = new \WP_REST_Request(
            'POST',
            $this->namespaced_route
        );

        $request->add_header('Content-Type', 'application/json');
        $request->set_body(wp_json_encode($request_body));
        $response = $this->server->dispatch($request);
        $this->assertEquals(200, $response->get_status());
        $data = $response->get_data();
        $this->assertArrayHasKey('conflicts', $data);
        $this->assertArrayHasKey('options', $data);
        $this->assertEquals('latest', $data['options']['version']);
        $this->assertEquals('latest', fa()->version());
    }

    public function test_update_with_kit_invalid_version()
    {
        // Start with the version being something else.
        $this->set_version('5.3.1');

        $request_body = array(
            'options' => array(
                'usePro' => true,
                'compat' => true,
                'technology' => 'webfont',
                'pseudoElements' => false,
                'detectConflictsUntil' => 0,
                'blocklist' => [],
                'kitToken' => '778ccf8260',
                'apiToken' => true,
                'version' => 'cat.dog',
            ),
            'conflicts' => array()
        );

        $request  = new \WP_REST_Request(
            'POST',
            $this->namespaced_route
        );

        $request->add_header('Content-Type', 'application/json');
        $request->set_body(wp_json_encode($request_body));
        $response = $this->server->dispatch($request);
        $this->assertEquals(400, $response->get_status());
        // Version unchanged
        $this->assertEquals('5.3.1', fa()->version());
        $data = $response->get_data();

        $this->assertInstanceOf(\WP_Error::class, $data);
        $this->assertEquals('fontawesome_client_exception', $data->get_error_code());
    }

    public function test_update_with_webfont_pseudo_elements_false()
    {
        // Start with the version being something else.
        $this->set_version('5.3.1');

        $request_body = array(
            'options' => array(
                'usePro' => false,
                'compat' => false,
                'technology' => 'webfont',
                'pseudoElements' => false,
                'kitToken' 	=> null,
                'apiToken' => false,
                'version' => '5.12.1'
            ),
            'conflicts' => array()
        );

        $request  = new \WP_REST_Request(
            'POST',
            $this->namespaced_route
        );

        $request->add_header('Content-Type', 'application/json');
        $request->set_body(wp_json_encode($request_body));
        $response = $this->server->dispatch($request);
        $this->assertEquals(400, $response->get_status());
        // Version unchanged
        $this->assertEquals('5.3.1', fa()->version());
        $data = $response->get_data();
        $this->assertInstanceOf(\WP_Error::class, $data);
        $this->assertEquals('fontawesome_client_exception', $data->get_error_code());
    }

    public function test_update_with_nonkit_invalid_version()
    {
        // Start with the version being something else.
        $this->set_version('5.3.1');

        $request_body = array(
            'options' => array(
                'usePro' => true,
                'compat' => true,
                'technology' => 'webfont',
                'pseudoElements' => false,
                'detectConflictsUntil' => 0,
                'blocklist' => [],
                'kitToken' => null,
                'apiToken' => false,
                'version' => 'cat.dog',
            ),
            'conflicts' => array()
        );

        $request  = new \WP_REST_Request(
            'POST',
            $this->namespaced_route
        );

        $request->add_header('Content-Type', 'application/json');
        $request->set_body(wp_json_encode($request_body));
        $response = $this->server->dispatch($request);
        $this->assertEquals(400, $response->get_status());
        // Version unchanged
        $this->assertEquals('5.3.1', fa()->version());
        $data = $response->get_data();
        $this->assertInstanceOf(\WP_Error::class, $data);
        $this->assertEquals('fontawesome_client_exception', $data->get_error_code());
    }

    public function test_update_with_nonkit_v4_compat_old_webfont()
    {
        // Start with the version being something else.
        $this->set_version('5.3.1');

        $request_body = array(
            'options' => array(
                'usePro' => true,
                'compat' => true,
                'technology' => 'webfont',
                'pseudoElements' => false,
                'kitToken' => null,
                'apiToken' => false,
                'version' => '5.0.13',
            ),
            'conflicts' => array()
        );

        $request  = new \WP_REST_Request(
            'POST',
            $this->namespaced_route
        );

        $request->add_header('Content-Type', 'application/json');
        $request->set_body(wp_json_encode($request_body));
        $response = $this->server->dispatch($request);
        $this->assertEquals(400, $response->get_status());
        // Version unchanged
        $this->assertEquals('5.3.1', fa()->version());
        $data = $response->get_data();
        $this->assertInstanceOf(\WP_Error::class, $data);
        $this->assertEquals('fontawesome_client_exception', $data->get_error_code());
    }

    public function test_update_with_nonkit_symbolic_latest_version()
    {
        // Start with the version being something else.
        $this->set_version('5.3.1');

        $request_body = array(
            'options' => array(
                'usePro' => true,
                'compat' => true,
                'technology' => 'webfont',
                'pseudoElements' => false,
                'kitToken' => null,
                'apiToken' => false,
                'version' => 'latest',
            ),
            'conflicts' => array()
        );

        $request  = new \WP_REST_Request(
            'POST',
            $this->namespaced_route
        );

        $request->add_header('Content-Type', 'application/json');
        $request->set_body(wp_json_encode($request_body));
        $response = $this->server->dispatch($request);
        $this->assertEquals(400, $response->get_status());
        // Version unchanged.
        $this->assertEquals('5.3.1', fa()->version());
        $data = $response->get_data();
        $this->assertInstanceOf(\WP_Error::class, $data);
        $this->assertEquals('fontawesome_client_exception', $data->get_error_code());
    }

    public function test_update_with_nonkit_valid_version()
    {
        // Start with the version being something else.
        $this->set_version('5.3.1');

        $request_body = array(
            'options' => array(
                'usePro' => true,
                'compat' => true,
                'technology' => 'webfont',
                'pseudoElements' => true,
                'detectConflictsUntil' => 0,
                'blocklist' => [],
                'kitToken' => null,
                'apiToken' => false,
                'version' => '5.4.1',
            ),
            'conflicts' => array()
        );

        $request  = new \WP_REST_Request(
            'POST',
            $this->namespaced_route
        );

        $request->add_header('Content-Type', 'application/json');
        $request->set_body(wp_json_encode($request_body));

        $response = $this->server->dispatch($request);
        $this->assertNotNull(fa()->latest_version());
        $this->assertEquals(200, $response->get_status());
        $data = $response->get_data();
        $this->assertArrayHasKey('conflicts', $data);
        $this->assertArrayHasKey('options', $data);
        $this->assertEquals('5.4.1', $data['options']['version']);
        $this->assertEquals('5.4.1', fa()->version());
    }

    public function test_update_with_no_options_in_body()
    {
        // Start with the version being something else.
        $this->set_version('5.3.1');

        $request_body = array();

        $request  = new \WP_REST_Request(
            'POST',
            $this->namespaced_route
        );

        $request->add_header('Content-Type', 'application/json');
        $request->set_body(wp_json_encode($request_body));
        $response = $this->server->dispatch($request);
        $this->assertEquals(400, $response->get_status());
        $data = $response->get_data();
        $this->assertInstanceOf(\WP_Error::class, $data);
        $this->assertEquals('fontawesome_client_exception', $data->get_error_code());
        // Version unchanged
        $this->assertEquals('5.3.1', fa()->version());
    }

    public function test_update_with_valid_cdn_config()
    {
        // Start with the version being something else.
        $this->set_version('5.3.1');

        $detect_conflicts_until = time() + 10;

        $request_body = array(
            'options' => array(
                'usePro' => true,
                'compat' => true,
                'technology' => 'svg',
                'pseudoElements' => true,
                'kitToken' => null,
                'apiToken' => false,
                'version' => '5.4.1',
            ),
            'conflicts' => array()
        );

        $request  = new \WP_REST_Request(
            'POST',
            $this->namespaced_route
        );

        $request->add_header('Content-Type', 'application/json');
        $request->set_body(wp_json_encode($request_body));
        $response = $this->server->dispatch($request);
        $this->assertEquals(200, $response->get_status());
        $data = $response->get_data();
        $this->assertArrayHasKey('conflicts', $data);
        $this->assertArrayHasKey('options', $data);
        $this->assertEquals('5.4.1', $data['options']['version']);
        $this->assertEquals('5.4.1', fa()->version());

        $this->assertTrue($data['options']['usePro']);
        $this->assertTrue(fa()->pro());

        $this->assertTrue($data['options']['compat']);
        $this->assertTrue(fa()->v4_compatibility());

        $this->assertEquals('svg', $data['options']['technology']);
        $this->assertEquals('svg', fa()->technology());

        $this->assertTrue($data['options']['pseudoElements']);
        $this->assertTrue(fa()->pseudo_elements());

        $this->assertEquals(null, $data['options']['kitToken']);
        $this->assertEquals('svg', fa()->technology());

        $this->assertFalse($data['options']['apiToken']);
        $this->assertFalse(fa()->options()['apiToken']);
    }

    public function test_update_with_valid_kit_config()
    {
        // Start with the version being something else.
        $this->set_version('5.3.1');

        $detect_conflicts_until = time() + 10;

        $request_body = array(
            'options' => array(
                'usePro' => true,
                'compat' => true,
                'technology' => 'svg',
                'pseudoElements' => true,
                'kitToken' => 'abc123',
                'apiToken' => true,
                'version' => '5.4.1',
            ),
            'conflicts' => array()
        );

        $request  = new \WP_REST_Request(
            'POST',
            $this->namespaced_route
        );

        $request->add_header('Content-Type', 'application/json');
        $request->set_body(wp_json_encode($request_body));
        $response = $this->server->dispatch($request);
        $this->assertEquals(200, $response->get_status());
        $data = $response->get_data();
        $this->assertArrayHasKey('conflicts', $data);
        $this->assertArrayHasKey('options', $data);
        $this->assertEquals('5.4.1', $data['options']['version']);
        $this->assertEquals('5.4.1', fa()->version());

        $this->assertTrue($data['options']['usePro']);
        $this->assertTrue(fa()->pro());

        $this->assertTrue($data['options']['compat']);
        $this->assertTrue(fa()->v4_compatibility());

        $this->assertEquals('svg', $data['options']['technology']);
        $this->assertEquals('svg', fa()->technology());

        $this->assertTrue($data['options']['pseudoElements']);
        $this->assertTrue(fa()->pseudo_elements());

        $this->assertEquals('abc123', $data['options']['kitToken']);
        $this->assertEquals('abc123', $data['options']['kitToken']);

        $this->assertEquals('svg', fa()->technology());

        $this->assertTrue($data['options']['apiToken']);
        $this->assertTrue(fa()->options()['apiToken']);
    }

    public function test_fail_when_kit_config_has_no_api_token()
    {
        // Start with the version being something else.
        $this->set_version('5.3.1');

        $detect_conflicts_until = time() + 10;

        $request_body = array(
            'options' => array(
                'usePro' => true,
                'compat' => true,
                'technology' => 'svg',
                'pseudoElements' => true,
                'detectConflictsUntil' => $detect_conflicts_until,
                'blocklist' => [],
                'kitToken' => 'abc123',
                'apiToken' => false,
                'version' => '5.4.1',
            ),
            'conflicts' => array()
        );

        $request  = new \WP_REST_Request(
            'POST',
            $this->namespaced_route
        );

        $request->add_header('Content-Type', 'application/json');
        $request->set_body(wp_json_encode($request_body));
        $response = $this->server->dispatch($request);
        $this->assertEquals(400, $response->get_status());
        $data = $response->get_data();
        $this->assertInstanceOf(\WP_Error::class, $data);
        $this->assertEquals('fontawesome_client_exception', $data->get_error_code());

        // Version unchanged
        $this->assertEquals('5.3.1', fa()->version());
    }

    public function test_update_with_nonkit_v6_beta3_free()
    {
        // Start with the version being something else.
        $this->set_version('5.0.13');

        $request_body = array(
            'options' => array(
                'usePro' => false,
                'compat' => true,
                'technology' => 'webfont',
                'pseudoElements' => true,
                'detectConflictsUntil' => 0,
                'blocklist' => [],
                'kitToken' => null,
                'apiToken' => false,
                'version' => '6.0.0-beta3',
            ),
            'conflicts' => array()
        );

        $request  = new \WP_REST_Request(
            'POST',
            $this->namespaced_route
        );

        $request->add_header('Content-Type', 'application/json');
        $request->set_body(wp_json_encode($request_body));

        $response = $this->server->dispatch($request);
        $this->assertNotNull(fa()->latest_version());
        $this->assertEquals(200, $response->get_status());
        $data = $response->get_data();
        $this->assertArrayHasKey('conflicts', $data);
        $this->assertArrayHasKey('options', $data);
        $this->assertEquals('6.0.0-beta3', $data['options']['version']);
        $this->assertEquals('6.0.0-beta3', fa()->version());
    }

    public function test_update_with_nonkit_v6_beta3_pro()
    {
        // Start with the version being something else.
        $this->set_version('5.0.13');

        $request_body = array(
            'options' => array(
                'usePro' => true,
                'compat' => true,
                'technology' => 'webfont',
                'pseudoElements' => true,
                'detectConflictsUntil' => 0,
                'blocklist' => [],
                'kitToken' => null,
                'apiToken' => false,
                'version' => '6.0.0-beta3',
            ),
            'conflicts' => array()
        );

        $request  = new \WP_REST_Request(
            'POST',
            $this->namespaced_route
        );

        $request->add_header('Content-Type', 'application/json');
        $request->set_body(wp_json_encode($request_body));

        $response = $this->server->dispatch($request);
        $this->assertNotNull(fa()->latest_version());
        // Can't use v6 via Pro CDN
        $this->assertEquals(400, $response->get_status());
        // Version unchanged
        $this->assertEquals('5.0.13', fa()->version());
        $data = $response->get_data();

        $this->assertInstanceOf(\WP_Error::class, $data);
        $this->assertEquals('fontawesome_client_exception', $data->get_error_code());
    }

    public function test_update_with_v4_compat_or_compat()
    {
        // Start with the version being something else.
        $this->set_version('5.0.13');

        $request_body = array(
            'options' => array(
                'usePro' => false,
                'v4Compat' => true,
                'technology' => 'webfont',
                'pseudoElements' => true,
                'detectConflictsUntil' => 0,
                'blocklist' => [],
                'kitToken' => null,
                'apiToken' => false,
                'version' => '6.0.0-beta3',
            ),
            'conflicts' => array()
        );

        $request  = new \WP_REST_Request(
            'POST',
            $this->namespaced_route
        );

        $request->add_header('Content-Type', 'application/json');
        $request->set_body(wp_json_encode($request_body));

        $response = $this->server->dispatch($request);
        $this->assertNotNull(fa()->latest_version());
        $this->assertEquals(200, $response->get_status());
        // Version changed
        $this->assertEquals('6.0.0-beta3', fa()->version());
        $data = $response->get_data();

        $this->assertArrayHasKey('options', $data);
        $this->assertTrue($data['options']['compat']);
        $this->assertTrue(fa()->compatibility());
        $this->assertTrue(fa()->v4_compatibility());

        $request_body = array(
            'options' => array(
                'usePro' => false,
                'compat' => false,
                'technology' => 'webfont',
                'pseudoElements' => true,
                'detectConflictsUntil' => 0,
                'blocklist' => [],
                'kitToken' => null,
                'apiToken' => false,
                'version' => '6.0.0-beta3',
            ),
            'conflicts' => array()
        );

        $request  = new \WP_REST_Request(
            'POST',
            $this->namespaced_route
        );

        $request->add_header('Content-Type', 'application/json');
        $request->set_body(wp_json_encode($request_body));

        $response = $this->server->dispatch($request);
        $data = $response->get_data();
        $this->assertArrayHasKey('options', $data);
        $this->assertFalse($data['options']['compat']);
        $this->assertFalse(fa()->compatibility());
        $this->assertFalse(fa()->v4_compatibility());
    }
}

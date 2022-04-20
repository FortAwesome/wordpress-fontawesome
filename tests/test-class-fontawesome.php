<?php
namespace FortAwesome;
/**
 * Class RequirementsTest
 *
 * @noinspection PhpCSValidationInspection
 */
// phpcs:ignoreFile Squiz.Commenting.ClassComment.Missing
// phpcs:ignoreFile Generic.Commenting.DocComment.MissingShort
require_once dirname( __FILE__ ) . '/../includes/class-fontawesome-activator.php';
require_once dirname( __FILE__ ) . '/../includes/class-fontawesome-release-provider.php';
require_once dirname( __FILE__ ) . '/_support/font-awesome-phpunit-util.php';

use \DateTime, \DateInterval, \DateTimeInterface, \DateTimeZone, \Exception;
use Yoast\WPTestUtils\WPIntegration\TestCase;

class MockFontAwesome extends FontAwesome {
	public function __construct() {
		// no-op
	}
	
	public static function instance() {
		self::$instance = new self();
	}

	public function mock_maybe_refresh_releases() {
		$this->maybe_refresh_releases();
	}
}

class FontAwesomeTest extends TestCase {

	public function set_up() {
		parent::set_up();
		reset_db();
		remove_all_actions( 'font_awesome_preferences' );
		wp_script_is( 'font-awesome', 'enqueued' ) && wp_dequeue_script( 'font-awesome' );
		wp_script_is( 'font-awesome-v4shim', 'enqueued' ) && wp_dequeue_script( 'font-awesome-v4shim' );
		wp_style_is( 'font-awesome', 'enqueued' ) && wp_dequeue_style( 'font-awesome' );
		wp_style_is( 'font-awesome-v4shim', 'enqueued' ) && wp_dequeue_style( 'font-awesome-v4shim' );
		(new Mock_FontAwesome_Metadata_Provider())->mock(
			array(
				wp_json_encode(
					array(
						'data' => graphql_releases_query_fixture(),
					)
				)
			)
		);
		FontAwesome_Activator::activate();
		FontAwesome_Release_Provider::reset();
		FontAwesome::reset();
	}

	protected function mock_with_plugin_version($plugin_version) {
		return mock_singleton_method(
			$this,
			FontAwesome::class,
			'plugin_version',
			function( $method ) use ( $plugin_version ) {
				$method->willReturn( $plugin_version );
			}
		);
	}

	public function test_conflicts_by_client_when_no_conflicts() {
		fa()->register(
			array(
				'name' => 'alpha',
			)
		);

		$this->assertEquals( [], fa()->conflicts_by_client() );
	}

	public function test_conflicts_by_client_when_conflicts() {
		fa()->register(
			array(
				'name' => 'alpha',
			)
		);

		fa()->register(
			array(
				'name'           => 'beta',
				'pseudoElements' => ! FontAwesome::DEFAULT_USER_OPTIONS['pseudoElements']
			)
		);

		fa()->register(
			array(
				'name'   => 'gamma',
				'version' => [ ['5.4.0', '='] ]
			)
		);

		$this->assertEquals(
			array( 'beta' => ['pseudoElements'], 'gamma' => ['version'] ),
			fa()->conflicts_by_client()
		);
	}

	public function test_conflicts_by_option_when_no_conflicts() {
		fa()->register(
			array(
				'name' => 'alpha',
			)
		);

		$this->assertEquals( [], fa()->conflicts_by_option() );
	}

	public function test_conflicts_by_option_when_conflicts() {
		fa()->register(
			array(
				'name' => 'alpha',
				'version' => [ ['51.23.45', '='] ]
			)
		);

		fa()->register(
			array(
				'name'              => 'beta',
				'pseudoElements' => ! FontAwesome::DEFAULT_USER_OPTIONS['pseudoElements']
			)
		);

		fa()->register(
			array(
				'name'   => 'gamma',
				'version' => [ ['5.4.0', '='] ]
			)
		);

		$this->assertEquals(
			array( 'version' => ['alpha', 'gamma'], 'pseudoElements' => ['beta'] ),
			fa()->conflicts_by_option()
		);
	}

	public function test_conflicts_by_option_when_no_conflicts_with_non_default() {
		fa()->register(
			array(
				'name'              => 'beta',
				'pseudoElements' => ! FontAwesome::DEFAULT_USER_OPTIONS['pseudoElements']
			)
		);

		$this->assertEquals(
			array(),
			fa()->conflicts_by_option(
				array_merge(
					FontAwesome::DEFAULT_USER_OPTIONS,
					[ 'pseudoElements' => ! FontAwesome::DEFAULT_USER_OPTIONS['pseudoElements'] ]
				)
			)
		);
	}

	public function test_conflicts_by_client_when_no_conflicts_with_non_default() {
		fa()->register(
			array(
				'name'              => 'beta',
				'pseudoElements' => ! FontAwesome::DEFAULT_USER_OPTIONS['pseudoElements']
			)
		);

		$this->assertEquals(
			array(),
			fa()->conflicts_by_option(
				array_merge(
					FontAwesome::DEFAULT_USER_OPTIONS,
					[ 'pseudoElements' => ! FontAwesome::DEFAULT_USER_OPTIONS['pseudoElements'] ]
				)
			)
		);
	}

	public function test_unregistered_clients_option_storage_and_retrieval() {
		// Before setting anything
		$this->assertEquals(
			array(),
			fa()->unregistered_clients()
		);

		$conflict_detection = array(
			'unregisteredClients' => array(
				'abc123' => array(
					'type' => 'style',
					'src' => "http://example.com"
				),
				'XYZ456' => array(
					'type' => 'script',
					'excerpt' => "some bit of inline script"
				)
			)
		);

		update_option(
			FontAwesome::CONFLICT_DETECTION_OPTIONS_KEY,
			$conflict_detection,
			false
		);

		$this->assertEquals(
			$conflict_detection['unregisteredClients'],
			fa()->unregistered_clients()
		);
	}

	public function test_blocklist_storage_and_retrieval() {
		// blocklist is empty by default
		$this->assertEquals(
			array(),
			fa()->blocklist()
		);

		$conflict_detection = array(
			'unregisteredClients' => array(
				'abc123' => array(
					'type' => 'style',
					'src' => "http://example.com",
					'blocked' => true
				),
				'XYZ456' => array(
					'type' => 'script',
					'excerpt' => "some bit of inline script",
				),
				'baz123' => array(
					'type' => 'script',
					'src' => 'http://foo.example.com',
					'blocked' => false
				),
				'foo123' => array(
					'type' => 'script',
					'src' => "http://example.com/all.js",
					'blocked' => true
				),
			)
		);

		update_option(
			FontAwesome::CONFLICT_DETECTION_OPTIONS_KEY,
			$conflict_detection
		);

		$this->assertEquals(
			['abc123', 'foo123'],
			fa()->blocklist()
		);
	}

	public function test_detecting_conflicts_when_enabled() {
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

		$this->assertTrue(
			fa()->detecting_conflicts()
		);
	}

	public function test_detecting_conflicts_default() {
		$this->assertFalse(
			fa()->detecting_conflicts()
		);
	}

	public function test_detecting_conflicts_when_expired() {
		$now = time();
		// ten minutes earlier
		$past = time() - (60 * 10);

		update_option(
			FontAwesome::CONFLICT_DETECTION_OPTIONS_KEY,
			array_merge(
				FontAwesome::DEFAULT_CONFLICT_DETECTION_OPTIONS,
				array(
					'detectConflictsUntil' => $past
				)
			)
		);

		$this->assertFalse(
			fa()->detecting_conflicts()
		);
	}

	public function test_detecting_conflicts_when_invalid_date_string() {
		update_option(
			FontAwesome::CONFLICT_DETECTION_OPTIONS_KEY,
			array_merge(
				FontAwesome::DEFAULT_CONFLICT_DETECTION_OPTIONS,
				array(
					'detectConflictsUntil' => 'foo'
				)
			)
		);

		$this->assertFalse(
			fa()->detecting_conflicts()
		);
	}

	public function test_refresh_releases() {
		// Before
		$this->assertEquals( '5.4.1', fa()->latest_version() );

		(new Mock_FontAwesome_Metadata_Provider())->mock(
			array(
				wp_json_encode(
					array(
						'data' => 
							array(
								'latest_version_5'   => array(
									'version' => '5.15.2',
								),
								'latest_version_6'   => array(
									'version' => '6.42.1',
								),
								'releases' =>
								array()
							)
					)
				)
			));

		fa()->refresh_releases();

		FontAwesome_Release_Provider::reset();

		// After
		$this->assertEquals( '5.15.2', fa()->latest_version() );
		$this->assertEquals( '5.15.2', fa()->latest_version_5() );
		$this->assertEquals( '6.42.1', fa()->latest_version_6() );
	}

	public function test_refresh_releases_when_latest_version_6_is_not_set() {
        $option_value = array(
            'refreshed_at' => time(),
            'data'         => array(
                'latest'   => '5.15.2',
                'releases' => array(),
            ),
        );

        update_option( FontAwesome_Release_Provider::OPTIONS_KEY, $option_value, false );

		/**
		 * Re-instantiate the ReleaseProvider from the option already stored in the db.
		 * This simulates the scenario were a site has a previous version of the plugin installed
		 * where the release metadata did not include "latest_version_6", but only "latest".
		 */
		FontAwesome_Release_Provider::reset();

		// Before
		$this->assertNull( fa()->latest_version_6() );

		// Now set up a mock that will return release metadata with the newer schema.
		(new Mock_FontAwesome_Metadata_Provider())->mock(
			array(
				wp_json_encode(
					array(
						'data' => 
							array(
								'latest_version_5'   => array(
									'version' => '5.15.2',
								),
								'latest_version_6'   => array(
									'version' => '6.42.1',
								),
								'releases' =>
								array()
							)
					)
				)
			));

		// Because maybe_refresh_releases is protected, we need a subclass than can access it.
		$mock_fa = new MockFontAwesome();

		// Now invoke the code being tested here.
		$mock_fa->mock_maybe_refresh_releases();

		FontAwesome_Release_Provider::reset();

		// After
		$this->assertEquals( '5.15.2', $mock_fa->latest_version() );
		$this->assertEquals( '5.15.2', $mock_fa->latest_version_5() );
		$this->assertEquals( '6.42.1', $mock_fa->latest_version_6() );
	}

	public function test_latest_version() {
		$this->assertEquals( '5.4.1', fa()->latest_version() );
	}

	public function test_releases_refreshed_at() {
		$delta = time() - fa()->releases_refreshed_at();
		$this->assertLessThanOrEqual(1, $delta );
  	}

	public function test_using_kits_when_default() {
		update_option(
			FontAwesome::OPTIONS_KEY,
			array_merge(
				FontAwesome::DEFAULT_USER_OPTIONS,
				[ 'version' => '5.3.1' ]
			)
		);

		$this->assertFalse(
			fa()->using_kit()
		);
	}

	public function test_using_kits_when_lacking_kit_token() {
		update_option(
			FontAwesome::OPTIONS_KEY,
			array_merge(
				FontAwesome::DEFAULT_USER_OPTIONS,
				array(
					'version' => '5.3.1',
					'apiToken' => true
				)
			)
		);

		$this->assertFalse(
			fa()->using_kit()
		);
	}

	public function test_using_kits_when_lacking_api_token() {
		update_option(
			FontAwesome::OPTIONS_KEY,
			array_merge(
				FontAwesome::DEFAULT_USER_OPTIONS,
				array(
					'version'  => '5.3.1',
					'kitToken' => 'abc123'
				)
			)
		);

		$this->assertFalse(
			fa()->using_kit()
		);
	}

	public function test_using_kits_when_valid_kit() {
		update_option(
			FontAwesome::OPTIONS_KEY,
			array_merge(
				FontAwesome::DEFAULT_USER_OPTIONS,
				array(
					'version'  => '5.3.1',
					'kitToken' => 'abc123',
					'apiToken' => true
				)
			)
		);

		$this->assertTrue(
			fa()->using_kit()
		);
	}

	/**
	 * This simply verifies that when 'latest' is stored in the db as the
	 * version under the options key, it is returned by our accessor method,
	 * instead of prior revisions of this code which would not have allowed that.
	 */
	public function test_version_as_symbolic_latest() {
		update_option(
			FontAwesome::OPTIONS_KEY,
			array_merge(
				FontAwesome::DEFAULT_USER_OPTIONS,
				array(
					'kitToken' => 'abc123',
					'apiToken' => true,
					'version'  => 'latest'
				)
			)
		);

		$this->assertEquals( 'latest', fa()->version() );
	}

	public function test_gather_preferences_exception() {
		add_action(
			'font_awesome_preferences',
			function() {
				throw new Exception( 'fake exception' );
			}
		);

		try {
			fa()->gather_preferences();
		} catch( PreferenceRegistrationException $e ) {
			$this->assertStringStartsWith( 'A theme or plugin', $e->getMessage() );
			$this->assertNotNull( $e->getPrevious() );
			$prev = $e->getPrevious();
			$this->assertEquals( 'fake exception', $prev->getMessage() );
		}

		$this->expectException( PreferenceRegistrationException::class );
		fa()->gather_preferences();
	}
}

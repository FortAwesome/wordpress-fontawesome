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

class FontAwesomeTest extends \WP_UnitTestCase {

	public function setUp() {
		reset_db();
		remove_all_actions( 'font_awesome_preferences' );
		FontAwesome::reset();
		(new Mock_FontAwesome_Metadata_Provider())->mock(
			array(
				wp_json_encode(
					array(
						'data' => graphql_releases_query_fixture(),
					)
				)
			)
		);
		wp_script_is( 'font-awesome', 'enqueued' ) && wp_dequeue_script( 'font-awesome' );
		wp_script_is( 'font-awesome-v4shim', 'enqueued' ) && wp_dequeue_script( 'font-awesome-v4shim' );
		wp_style_is( 'font-awesome', 'enqueued' ) && wp_dequeue_style( 'font-awesome' );
		wp_style_is( 'font-awesome-v4shim', 'enqueued' ) && wp_dequeue_style( 'font-awesome-v4shim' );
		FontAwesome_Activator::activate();
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
								'latest'   => array(
									'version' => '5.15.2',
								),
								'releases' =>
								array(
									0  =>
									array(
										'date'          => '2017-12-08 00:00:00',
										'iconCount'     =>
										array(
											'free' => 899,
											'pro'  => 1278,
										),
										'srisByLicense' =>
										array(
											'free' =>
											array(
												0  =>
												array(
													'path'  => 'css/all.css',
													'value' => 'sha384-VVoO3UHXsmXwXvf1kJx2jV3b1LbOfTqKL46DdeLG8z4pImkQ4GAP9GMy+MxHMDYG',
												),
												1  =>
												array(
													'path'  => 'css/brands.css',
													'value' => 'sha384-JT52EiskN0hkvVxJA8d2wg8W/tLxrC02M4u5+YAezNnBlY/N2yy3X51pKC1QaPkw',
												),
												2  =>
												array(
													'path'  => 'css/fontawesome.css',
													'value' => 'sha384-7mC9VNNEUg5vt0kVQGblkna/29L8CpTJ5fkpo0nlmTbfCoDXyuK/gPO3wx8bglOz',
												),
												3  =>
												array(
													'path'  => 'css/regular.css',
													'value' => 'sha384-JZ2w5NHrKZS6hqVAVlhUO3eHPVzjDZqOpWBZZ6opcmMwVjN7uoagKSSftrq8F0pn',
												),
												4  =>
												array(
													'path'  => 'css/solid.css',
													'value' => 'sha384-TQW9cJIp+U8M7mByg5ZKUQoIxj0ac36aOpNzqQ04HpwyrJivS38EQsKHO2rR5eit',
												),
												5  =>
												array(
													'path'  => 'css/svg-with-js.css',
													'value' => 'sha384-X1ZQAmDHBeo7eaAJwWMyyA3mva9mMK10CpRFvX8PejR0XIUjwvGDqr2TwJqwbH9S',
												),
												6  =>
												array(
													'path'  => 'js/all.js',
													'value' => 'sha384-2CD5KZ3lSO1FK9XJ2hsLsEPy5/TBISgKIk2NSEcS03GbEnWEfhzd0x6DBIkqgPN1',
												),
												7  =>
												array(
													'path'  => 'js/brands.js',
													'value' => 'sha384-i3UPn8g8uJGiS6R/++68nHyfYAnr/lE/biTuWYbya2dONccicnZZPlAH6P8EWf28',
												),
												8  =>
												array(
													'path'  => 'js/fontawesome.js',
													'value' => 'sha384-tqpP2rDLsdWkeBrG3Jachyp0yzl/pmhnsdV88ySUFZATuziAnHWsHRSS97l5D9jn',
												),
												9  =>
												array(
													'path'  => 'js/regular.js',
													'value' => 'sha384-hXqI+wajk6jJu2DXwf2oqBg6q5+HqXM5yz9smX94pDjiLzH81gAuVtjter66i1Ct',
												),
												10 =>
												array(
													'path'  => 'js/solid.js',
													'value' => 'sha384-kbPfTyGdGugnvSKEBJCd6+vYipOQ6a+2np5O4Ty3sW7tgI0MpwPyAh+QwUpMujV9',
												),
												11 =>
												array(
													'path'  => 'js/v4-shims.js',
													'value' => 'sha384-BRge2B8T+0rmvB/KszFfdQ0PDvPnhV2J80JMKrnq21Fq6tHeKFhSIrdoroXvk7eB',
												),
											),
											'pro'  =>
											array(),
										),
										'version'       => '5.0.1',
									)
								)
							)
					)
				)
			));
		FontAwesome_Release_Provider::reset();

		// After
		$this->assertNotNull( fa()->latest_version() );
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

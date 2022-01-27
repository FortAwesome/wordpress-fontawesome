<?php
namespace FortAwesome;
/**
 * Class OptionsTest
 *
 * @noinspection PhpCSValidationInspection
 */
// phpcs:ignoreFile Squiz.Commenting.ClassComment.Missing
// phpcs:ignoreFile Generic.Commenting.DocComment.MissingShort
require_once dirname( __FILE__ ) . '/../includes/class-fontawesome-activator.php';
require_once dirname( __FILE__ ) . '/_support/font-awesome-phpunit-util.php';
use Yoast\WPTestUtils\WPIntegration\TestCase;

class OptionsTest extends TestCase {

	public function set_up() {
		parent::set_up();
		wp_cache_delete ( 'alloptions', 'options' );
		delete_option( FontAwesome::OPTIONS_KEY );

		FontAwesome::reset();
		(new Mock_FontAwesome_Metadata_Provider())->mock(
			array(
				wp_json_encode(
					array(
						'data' => graphql_releases_query_fixture(),
					)
				),
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

		remove_all_filters(
			'pre_option_' . FontAwesome_Release_Provider::OPTIONS_KEY
		);
	}

	public function tear_down() {
		FontAwesome_Metadata_Provider::reset();
	}

	protected function block_metadata_query() {
		mock_singleton_method(
			$this,
			FontAwesome_Metadata_Provider::class,
			'metadata_query',
			function( $method ) {
				$method->willThrowException( new \Exception('unexpected: metadata_query was invoked') );
			}
		);
	}

	public function test_option_defaults() {
		FontAwesome_Activator::activate();

		$this->assertEquals(
			'webfont',
			fa()->technology()
		);

		$this->assertTrue(
			fa()->pseudo_elements()
		);

		$this->assertNull(
			fa()->kit_token()
		);
	}

	public function test_option_throws_when_empty() {
		$this->expectException( ConfigCorruptionException::class );

		fa()->options();
	}

	public function test_convert_options_from_v1() {
		$this->assertEquals(
			array(
				'version' => '5.8.1',
				'pseudoElements' => true,
				'technology' => 'svg',
				'usePro' => true,
				'compat' => true,
				'kitToken' => null,
				'apiToken' => false,
				'dataVersion' => 4
			),
			fa()->convert_options_from_v1(
				array (
				'adminClientLoadSpec' =>
					array (
						'name' => 'user',
						'method' => 'webfont',
						'v4shim' => 'require',
						'pseudoElements' => 'require',
						// clientVersion was a previous option
						'clientVersion' => 1554559421,
					),
				'version' => '5.8.1',
				'usePro' => true,
				'removeUnregisteredClients' => true,
				'lockedLoadSpec' =>
					array (
						'method' => 'svg',
						'v4shim' => true,
						'pseudoElements' => true,
						'clients' =>
							array (
								'user' => 1554559421,
							),
					),
				)
			)
		);
	}

	public function test_try_upgrade_when_upgrade_required_from_pre_rc13() {
		$this->block_metadata_query();

		update_option(
			FontAwesome::OPTIONS_KEY,
			array (
			'adminClientLoadSpec' =>
				array (
					'name' => 'user',
					'method' => 'webfont',
					'v4shim' => 'require',
					'pseudoElements' => 'require',
					// clientVersion was a previous option
					'clientVersion' => 1554559421,
				),
			'version' => '5.8.1',
			'usePro' => true,
			'removeUnregisteredClients' => true,
			'lockedLoadSpec' =>
				array (
					'method' => 'svg',
					'v4shim' => true,
					'pseudoElements' => true,
					'clients' =>
						array (
							'user' => 1554559421,
						),
				),
			)
		);

		fa()->try_upgrade();

		$this->assertEquals(
			array(
				'version' => '5.8.1',
				'pseudoElements' => true,
				'technology' => 'svg',
				'usePro' => true,
				'compat' => true,
				'kitToken' => null,
				'apiToken' => false,
				'dataVersion' => 4,
			),
			fa()->options()
		);

		$releases_option = get_option( FontAwesome_Release_Provider::OPTIONS_KEY );

		$this->assertTrue(boolval($releases_option));
	}

	public function test_try_upgrade_when_upgrade_required_from_post_rc13_pre_rc22() {
		$this->block_metadata_query();

		update_option(
			FontAwesome::OPTIONS_KEY,
			array(
				'version' => '5.8.1',
				'pseudoElements' => true,
				'technology' => 'svg',
				'usePro' => true,
				'v4Compat' => true,
				'kitToken' => null,
				'apiToken' => false,
			)
		);

		fa()->try_upgrade();

		$this->assertEquals(
			array(
				'version' => '5.8.1',
				'pseudoElements' => true,
				'technology' => 'svg',
				'usePro' => true,
				'compat' => true,
				'kitToken' => null,
				'apiToken' => false,
				'dataVersion' => 4
			),
			fa()->options()
		);

		$releases_option = get_option( FontAwesome_Release_Provider::OPTIONS_KEY );

		$this->assertTrue(boolval($releases_option));
	}

	public function test_try_upgrade_from_v4_compat_to_compat_option() {
		$this->block_metadata_query();

		update_option(
			FontAwesome::OPTIONS_KEY,
			array(
				'version' => '5.8.1',
				'pseudoElements' => true,
				'technology' => 'svg',
				'usePro' => true,
				'v4Compat' => true,
				'kitToken' => null,
				'apiToken' => false,
			)
		);

		fa()->try_upgrade();

		$this->assertEquals(
			array(
				'version' => '5.8.1',
				'pseudoElements' => true,
				'technology' => 'svg',
				'usePro' => true,
				'compat' => true,
				'kitToken' => null,
				'apiToken' => false,
				'dataVersion' => 4
			),
			fa()->options()
		);

		$releases_option = get_option( FontAwesome_Release_Provider::OPTIONS_KEY );

		$this->assertTrue(boolval($releases_option));
	}

	public function test_try_upgrade_when_upgrade_not_required() {
		$this->block_metadata_query();

		update_option(
			FontAwesome::OPTIONS_KEY,
			array_merge(
				FontAwesome::DEFAULT_USER_OPTIONS,
				[
					// Non-default option values preserved
					'version'    => '5.12.0',
					'technology' => 'svg',
					'usePro'     => true
				]
			)
		);

		fa()->try_upgrade();

		$this->assertEquals(
			array(
				'version' => '5.12.0',
				'pseudoElements' => true,
				'technology' => 'svg',
				'usePro' => true,
				'compat' => true,
				'kitToken' => null,
				'apiToken' => false,
				'dataVersion' => 4,
			),
			fa()->options()
		);
	}

	public function test_try_upgrade_when_upgraded_with_prior_releases_metadata_transient() {
		// First, establish what's expected.
		FontAwesome_Release_Provider::load_releases();
		$expected = get_option( FontAwesome_Release_Provider::OPTIONS_KEY );

		// Now, clear it all away and start clean.
		delete_option( FontAwesome_Release_Provider::OPTIONS_KEY );
		delete_site_transient( 'font-awesome-releases' );
		delete_transient( 'font-awesome-releases' );
		delete_option( FontAwesome_Release_Provider::OPTIONS_KEY );

		// And block to ensure no query is issued during upgrade.
		$this->block_metadata_query();

		// Setup a scenario that requires upgrade.
		update_option(
			FontAwesome::OPTIONS_KEY,
			array_merge(
				FontAwesome::DEFAULT_USER_OPTIONS,
				[
					'version'     => '5.12.0',
					'v4Compat'    => false,
					'dataVersion' => 3
				]
			)
		);

		// Simulate storing it in this alternative location.
		set_transient( 'font-awesome-releases', $expected );

		// Now try to upgrade.
		fa()->try_upgrade();

		// If we can reset without throwing an exception, it means we migrated *something*.
		$this->assertTrue( boolval( FontAwesome_Release_Provider::reset() ) );

		$this->assertEquals( get_option( FontAwesome_Release_Provider::OPTIONS_KEY ), $expected );
	}

	/**
	 * This tests our block_metadata_query(), making sure that if metadata_query is invoked
	 * after being blocked, then we get an exception.
	 */
	public function test_block_metadata_query() {
		$this->block_metadata_query();

		$this->expectException( \Exception::class );

		FontAwesome_Release_Provider::load_releases();
	}

	public function test_convert_options_from_v1_coerce_pseudo_elements_true_for_webfont() {
		$this->assertEquals(
			array(
				'version' => '5.8.1',
				'pseudoElements' => true,
				'technology' => 'webfont',
				'usePro' => true,
				'compat' => true,
				'kitToken' => null,
				'apiToken' => false,
				'dataVersion' => 4,
			),
			fa()->convert_options_from_v1(
				array (
				'adminClientLoadSpec' =>
					array (
						'name' => 'user',
						'method' => 'webfont',
						'v4shim' => 'require',
						'pseudoElements' => 'forbid',
						// clientVersion was a previous option
						'clientVersion' => 1554559421,
					),
				'version' => '5.8.1',
				'usePro' => true,
				'removeUnregisteredClients' => true,
				'lockedLoadSpec' =>
					array (
						'method' => 'webfont',
						'v4shim' => true,
						'pseudoElements' => false,
						'clients' =>
							array (
								'user' => 1554559421,
							),
					),
				)
			)
		);
	}

	public function test_convert_options_from_v1_coerce_pseudo_elements_true_for_webfont_when_absent() {
		$this->assertEquals(
			array(
				'version' => '5.8.1',
				'pseudoElements' => true,
				'technology' => 'webfont',
				'usePro' => true,
				'compat' => true,
				'kitToken' => null,
				'apiToken' => false,
				'dataVersion' => 4,
			),
			fa()->convert_options_from_v1(
				array (
				'adminClientLoadSpec' =>
					array (
						'name' => 'user',
						'method' => 'svg',
						'v4shim' => 'require',
						'pseudoElements' => 'forbid',
						// clientVersion was a previous option
						'clientVersion' => 1554559421,
					),
				'version' => '5.8.1',
				'usePro' => true,
				'removeUnregisteredClients' => true,
				'lockedLoadSpec' =>
					array (
						'v4shim' => true,
						'clients' =>
							array (
								'user' => 1554559421,
							),
					),
				)
			)
		);
	}

	public function test_validate_options_empty() {
		$this->expectException( ConfigCorruptionException::class );

		fa()->validate_options( [] );
	}

	public function test_options_missing_technology() {
		$options = array_merge(
			FontAwesome::DEFAULT_USER_OPTIONS,
			[
				'version' => '5.3.1'
			]
		);

		unset( $options['technology'] );

		update_option( FontAwesome::OPTIONS_KEY, $options );

		$this->expectException( ConfigCorruptionException::class );

		fa()->technology();
	}

	public function test_options_invalid_technology() {
		$options = array_merge(
			FontAwesome::DEFAULT_USER_OPTIONS,
			[
				'version' => '5.3.1',
				'technology' => 'foo'
			]
		);

		update_option( FontAwesome::OPTIONS_KEY, $options );

		$this->expectException( ConfigCorruptionException::class );

		fa()->technology();
	}

	public function test_options_invalid_pro_v6_cdn() {
		$options = array_merge(
			FontAwesome::DEFAULT_USER_OPTIONS,
			[
				'version' => '6.0.0-beta3',
				'usePro'  => true
			]
		);

		$this->expectException( ConfigCorruptionException::class );

		fa()->validate_options( $options );
	}

	public function test_options_missing_pro() {
		$options = array_merge(
			FontAwesome::DEFAULT_USER_OPTIONS,
			[
				'version' => '5.3.1'
			]
		);

		unset( $options['usePro'] );

		update_option( FontAwesome::OPTIONS_KEY, $options );

		$this->expectException( ConfigCorruptionException::class );

		fa()->pro();
	}

	public function test_options_invalid_pro() {
		$options = array_merge(
			FontAwesome::DEFAULT_USER_OPTIONS,
			[
				'version' => '5.3.1',
				'usePro' => 42
			]
		);

		update_option( FontAwesome::OPTIONS_KEY, $options );

		$this->expectException( ConfigCorruptionException::class );

		fa()->pro();
	}

	public function test_options_pseudo_elements_missing() {
		$options = array_merge(
			FontAwesome::DEFAULT_USER_OPTIONS,
			[
				'version' => '5.3.1'
			]
		);

		unset( $options['pseudoElements'] );

		update_option( FontAwesome::OPTIONS_KEY, $options );

		$this->expectException( ConfigCorruptionException::class );

		fa()->pseudo_elements();
	}

	public function test_options_pseudo_elements_invalid() {
		$options = array_merge(
			FontAwesome::DEFAULT_USER_OPTIONS,
			[
				'version' => '5.3.1',
				'pseudoElements' => 42
			]
		);

		update_option( FontAwesome::OPTIONS_KEY, $options );

		$this->expectException( ConfigCorruptionException::class );

		fa()->pseudo_elements();
	}

	public function test_options_v4_compatibility_missing() {
		$options = array_merge(
			FontAwesome::DEFAULT_USER_OPTIONS,
			[
				'version' => '5.3.1'
			]
		);

		unset( $options['compat'] );

		update_option( FontAwesome::OPTIONS_KEY, $options );

		$this->expectException( ConfigCorruptionException::class );

		fa()->v4_compatibility();
	}

	public function test_options_v4_compatibility_invalid() {
		$options = array_merge(
			FontAwesome::DEFAULT_USER_OPTIONS,
			[
				'version' => '5.3.1',
				'compat' => 42
			]
		);

		update_option( FontAwesome::OPTIONS_KEY, $options );

		$this->expectException( ConfigCorruptionException::class );

		fa()->v4_compatibility();
	}

	public function test_options_version_must_be_concrete() {
		$options = array_merge(
			FontAwesome::DEFAULT_USER_OPTIONS,
			[
				'version' => 'latest'
			]
		);

		update_option( FontAwesome::OPTIONS_KEY, $options );

		$this->expectException( ConfigCorruptionException::class );

		fa()->validate_options( $options );
	}

	public function test_validate_options_does_not_query_release_metadata() {
		$all_releases_query_count      = 0;

		add_filter(
			'pre_option_' . FontAwesome_Release_Provider::OPTIONS_KEY,
			function( $value ) use ( &$all_releases_query_count ) {
				$all_releases_query_count++;
				return $value;
			}
		);

		$options = array_merge(
			FontAwesome::DEFAULT_USER_OPTIONS,
			[
				'version' => '5.0.13'
			]
		);

		fa()->validate_options( $options );

		$this->assertEquals( $all_releases_query_count, 0 );

		/**
		 * Ensure no false positives by asserting that the count would have
		 * been incremented if the query had been attempted.
		 */
		get_option( FontAwesome_Release_Provider::OPTIONS_KEY );
		$this->assertEquals( $all_releases_query_count, 1 );
	}

	public function test_kit_options() {
		update_option(
			FontAwesome::OPTIONS_KEY,
			array_merge(
				FontAwesome::DEFAULT_USER_OPTIONS,
				[
					'version'  => '5.8.1',
					'kitToken' => 'abc123',
					'apiToken' => 'DEAD-BEEF'
				]
			)
		);

		$this->assertTrue(
			fa()->using_kit(),
			true
		);

		$this->assertEquals(
			fa()->kit_token(),
			'abc123'
		);
	}
}

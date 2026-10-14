<?php
/**
 * Tests the release provider, integrated with the main Font Awesome class simulating loading and
 * caching scenarios.
 *
 * @noinspection PhpIncludeInspection
 */

namespace FortAwesome;

use WP_Error;
use Yoast\WPTestUtils\WPIntegration\TestCase;

require_once FONTAWESOME_DIR_PATH . 'includes/class-fontawesome-release-provider.php';
require_once FONTAWESOME_DIR_PATH . 'includes/class-fontawesome.php';
require_once FONTAWESOME_DIR_PATH . 'font-awesome.php';
require_once __DIR__ . '/_support/font-awesome-phpunit-util.php';
require_once __DIR__ . '/fixtures/graphql-releases-query-fixture.php';

/**
 * Class ReleaseProviderIntegrationTest
 */
class ReleaseProviderIntegrationTest extends TestCase {
	public function set_up() {
		parent::set_up();
		reset_db();
		remove_all_actions( 'font_awesome_preferences' );
		remove_all_filters(
			'pre_option_' . FontAwesome_Release_Provider::OPTIONS_KEY
		);
		remove_all_filters(
			'pre_transient_' . FontAwesome_Release_Provider::LAST_USED_RELEASE_TRANSIENT
		);
	}

	// Pass an array of responses, in the shape returned by wp_remote_get(), or a WP_Error().
	// A release provider will be mocked to return those responses, in order,
	// on consecutive GETs to the fontawesome API,
	// or to throw an exception if given an error.
	protected function prepare( $arg ) {
		if ( \is_wp_error( $arg ) ) {
			mock_singleton_method(
				$this,
				FontAwesome_Metadata_Provider::class,
				'metadata_query',
				function ( $method ) use ( $arg ) {
					$method->will( $this->throwException( new ApiRequestException() ) );
				}
			);
		} elseif ( \is_array( $arg ) ) {
			mock_singleton_method(
				$this,
				FontAwesome_Metadata_Provider::class,
				'metadata_query',
				function ( $method ) use ( $arg ) {
					$method->will( $this->onConsecutiveCalls( ...$arg ) );
				}
			);

			FontAwesome_Activator::activate();
		} else {
			throw new Exception( 'arg must be a callable or array of responses' );
		}
	}

	protected static function build_success_response() {
		return wp_json_encode(
			array(
				'data' => graphql_releases_query_fixture(),
			)
		);
	}

	/**
	 * This is to test the scenario that's come up when releasing 4.0.0-rc1, where the release provider initially loads
	 * correctly, so it builds locked load spec with some version, but then on a subsequent call to
	 * get_resource_collection(), probably on a subsequent page load when the singleton data structure hasn't yet
	 * been loaded, it calls resources() and gets back a set (probably empty) that does not include the version
	 * being enqueued.
	 *
	 * So we need to simulate the scenario where we expect that metadata to be cached so that we can be sure that
	 * a locked load spec, once locked, will not depend on any subsequent network requests to the metadata API
	 * in order to load correctly.
	 */
	public function test_releases_caching() {
		$this->prepare(
			array(
				self::build_success_response(),
			)
		);

		$enqueued_count = 0;

		$enqueued_callback = function () use ( &$enqueued_count ) {
			++$enqueued_count;
			$this->assertEquals( fa()->latest_version_7(), fa()->version() );
		};
		add_action( 'font_awesome_enqueued', $enqueued_callback );

		fa()->gather_preferences();

		$resource_collection = fa_release_provider()->get_resource_collection( '5.15.4' );
		fa()->enqueue_cdn( fa()->options(), $resource_collection );

		$this->assertEquals( 1, $enqueued_count );

		$versions = fa_release_provider()->versions();

		// Now, reset to simulate a subsequent PHP process running, so the Singletons will have to
		// refresh themselves, but we already have the load configuration in the db from the previous run.
		$this->prepare(
			new WP_Error()
		);

		fa()->enqueue_cdn( fa()->options(), $resource_collection );

		/**
		 * If it loads the second time without choking on the mock 500 response, then we're good.
		 */
		$this->assertEquals( 2, $enqueued_count );

		/**
		 * The ReleaseProvider shouldn't even issue the subsequent query, and it should provide the same set of
		 * versions as the last time it was successful.
		 */
		$this->assertEquals( $versions, fa_release_provider()->versions() );
	}

	/**
	 * Invoking get_resource_collection() should only hit the database when the
	 * LAST_USED_RELEASE transient is not already populated.
	 */
	public function test_last_used_cache() {
		$all_releases_query_count      = 0;
		$last_used_release_query_count = 0;

		add_filter(
			'pre_option_' . FontAwesome_Release_Provider::OPTIONS_KEY,
			function ( $value ) use ( &$all_releases_query_count ) {
				$all_releases_query_count++;
				return $value;
			},
			0
		);

		add_filter(
			'pre_transient_' . FontAwesome_Release_Provider::LAST_USED_RELEASE_TRANSIENT,
			function () use ( &$last_used_release_query_count ) {
				$last_used_release_query_count++;
				return false;
			},
			0
		);

		/**
		 * This will activate the plugin, which would initialize the ReleaseProvider option.
		 * That process is expected to write the option, but it doesn't need to
		 * read it.
		 */
		$this->prepare(
			array(
				self::build_success_response(),
			)
		);

		$this->assertEquals( 0, $last_used_release_query_count );
		$this->assertEquals( 2, $all_releases_query_count );
		$this->assertTrue( is_array( get_option( FontAwesome_Release_Provider::OPTIONS_KEY ) ) );

		$resource_collection = FontAwesome_Release_Provider::get_resource_collection(
			'5.15.4',
			array(
				'use_pro'           => true,
				'use_svg'           => false,
				'use_compatibility' => false,
			)
		);

		// each are incremented.
		$this->assertEquals( 1, $last_used_release_query_count );
		$this->assertEquals( 3, $all_releases_query_count );

		$resource_collection = FontAwesome_Release_Provider::get_resource_collection(
			'5.15.4',
			array(
				'use_pro'           => true,
				'use_svg'           => false,
				'use_compatibility' => false,
			)
		);

		// only on the transient query count is incremented.
		$this->assertEquals( 2, $last_used_release_query_count );
		$this->assertEquals( 3, $all_releases_query_count );

		/**
		 * Ensure no false positives by asserting that the count would have
		 * been incremented if the query had been attempted.
		 */
		FontAwesome_Release_Provider::get_option();
		FontAwesome_Release_Provider::get_last_used_release();

		$this->assertEquals( 3, $last_used_release_query_count );
		$this->assertEquals( 4, $all_releases_query_count );
	}

	/**
	 * When there exists an old 'font-awesome-last-used-release' site transient
	 * that has not been cleaned up, it should not cause a problem when instantiating
	 * a new ReleaseProvider that uses a normal transient. It's deleted when the
	 * cache is rebuilt.
	 */
	public function test_no_conflict_with_old_site_transient() {
		/**
		 * We used to use a site_transient for this setting.
		 * This simulates that old behavior, as if the plugin was updated
		 * to use the new behavior but did not delete the previous un-expired transient.
		 */
		set_site_transient(
			FontAwesome_Release_Provider::LEGACY_LAST_USED_RELEASE_TRANSIENT,
			array( 'foo' => 42 ),
			3600
		);

		/**
		 * This will activate the plugin, which would initialize the ReleaseProvider option.
		 * That process is expected to write the option and new transient.
		 */
		$this->prepare(
			array(
				self::build_success_response(),
			)
		);

		$this->assertTrue( (bool) FontAwesome_Release_Provider::get_option() );

		$resource_collection = FontAwesome_Release_Provider::get_resource_collection(
			'5.15.4',
			self::PRO_WEBFONT_FLAGS
		);

		$this->assertTrue( (bool) $resource_collection );

		$this->assertFalse(
			get_site_transient( FontAwesome_Release_Provider::LEGACY_LAST_USED_RELEASE_TRANSIENT )
		);

		$this->assertTrue(
			is_array( get_transient( FontAwesome_Release_Provider::LAST_USED_RELEASE_TRANSIENT ) )
		);
	}

	/**
	 * Builds a value in the format that versions prior to 5.2.2 stored in the
	 * LEGACY_LAST_USED_RELEASE_TRANSIENT: resources are FontAwesome_Resource objects.
	 */
	protected static function build_legacy_cached_value( $version, $flags, $source ) {
		$resources = array(
			'all' => new FontAwesome_Resource( $source, 'sha384-legacy' ),
		);

		if ( $flags['use_compatibility'] ) {
			$resources['v4-shims'] = new FontAwesome_Resource( $source . '?v4-shims', 'sha384-legacy' );
		}

		return array(
			'version'           => $version,
			'use_pro'           => $flags['use_pro'],
			'use_svg'           => $flags['use_svg'],
			'use_compatibility' => $flags['use_compatibility'],
			'resources'         => $resources,
		);
	}

	/**
	 * A copy of how version 5.2.1 read its cache in get_resource_collection(), and
	 * then how enqueue_cdn() used the result. This represents what happens if a site
	 * is downgraded to 5.2.1 after having run this version.
	 *
	 * Returns the cached 'all' source, or null on a cache miss, after which 5.2.1
	 * would have rebuilt from the release metadata. A fatal error here would
	 * mean that a downgrade breaks the site.
	 */
	protected static function read_cache_as_5_2_1( $version, $flags ) {
		$last_used_transient = get_transient( FontAwesome_Release_Provider::LEGACY_LAST_USED_RELEASE_TRANSIENT );

		if ( $last_used_transient ) {
			if (
				$version === $last_used_transient['version']
				&& $flags['use_pro'] === $last_used_transient['use_pro']
				&& $flags['use_svg'] === $last_used_transient['use_svg']
				&& $flags['use_compatibility'] === $last_used_transient['use_compatibility']
				&& is_array( $last_used_transient['resources'] )
				&& isset( $last_used_transient['resources']['all'] )
			) {
				return $last_used_transient['resources']['all']->source();
			}
		}

		return null;
	}

	/**
	 * Asserts that the cached value is made only of arrays and scalars, such
	 * that it can be unserialized before any of this plugin's classes are loaded.
	 */
	protected function assert_cached_value_has_no_objects() {
		$cached = get_transient( FontAwesome_Release_Provider::LAST_USED_RELEASE_TRANSIENT );

		$this->assertTrue( is_array( $cached ) );

		array_walk_recursive(
			$cached,
			function ( $value ) {
				$this->assertFalse( is_object( $value ) );
			}
		);

		// Serializing our own test value, as the object cache would, to check it has no object tokens.
		// phpcs:ignore WordPress.PHP.DiscouragedPHPFunctions.serialize_serialize
		$this->assertFalse( strpos( serialize( $cached ), 'O:' ) );
	}

	/**
	 * Asserts that the collection holds FontAwesome_Resource objects equivalent to the expected ones.
	 */
	protected function assert_same_resources( $expected, $actual, $message = '' ) {
		$this->assertInstanceOf( FontAwesome_ResourceCollection::class, $actual, $message );
		$this->assertEquals( array_keys( $expected->resources() ), array_keys( $actual->resources() ), $message );

		foreach ( $expected->resources() as $key => $resource ) {
			$this->assertInstanceOf( FontAwesome_Resource::class, $actual->resources()[ $key ], $message );
			$this->assertEquals( $resource->source(), $actual->resources()[ $key ]->source(), $message );
			$this->assertEquals( $resource->integrity_key(), $actual->resources()[ $key ]->integrity_key(), $message );
		}
	}

	/**
	 * Builds the resource collection with no cache, as the reference for what
	 * should be returned from cache.
	 */
	protected function build_uncached( $version, $flags ) {
		FontAwesome_Release_Provider::delete_last_used_release();

		$collection = FontAwesome_Release_Provider::get_resource_collection( $version, $flags );

		$this->assertTrue( is_string( $collection->resources()['all']->integrity_key() ) );

		FontAwesome_Release_Provider::delete_last_used_release();

		return $collection;
	}

	/**
	 * Fails the test if anything writes the legacy transient, which a downgraded
	 * version would read.
	 */
	protected function forbid_legacy_writes() {
		foreach ( array( 'pre_set_transient_', 'pre_set_site_transient_' ) as $prefix ) {
			add_filter(
				$prefix . FontAwesome_Release_Provider::LEGACY_LAST_USED_RELEASE_TRANSIENT,
				function () {
					$this->fail( 'The legacy last used release transient must never be written.' );
				}
			);
		}
	}

	const PRO_WEBFONT_FLAGS = array(
		'use_pro'           => true,
		'use_svg'           => false,
		'use_compatibility' => false,
	);

	const FREE_SVG_COMPAT_FLAGS = array(
		'use_pro'           => false,
		'use_svg'           => true,
		'use_compatibility' => true,
	);

	public function cache_format_flags_provider() {
		return array(
			'pro webfont'       => array( self::PRO_WEBFONT_FLAGS ),
			'free svg + compat' => array( self::FREE_SVG_COMPAT_FLAGS ),
		);
	}

	/**
	 * The cached value must contain no objects. Persistent object caches that
	 * prefetch, like Object Cache Pro, unserialize it before this plugin's
	 * classes are loaded.
	 *
	 * @dataProvider cache_format_flags_provider
	 */
	public function test_cached_value_contains_no_objects( $flags ) {
		$this->prepare( array( self::build_success_response() ) );

		$expected = $this->build_uncached( '5.15.4', $flags );

		// Cache miss: builds and caches.
		$this->assert_same_resources( $expected, FontAwesome_Release_Provider::get_resource_collection( '5.15.4', $flags ) );
		$this->assert_cached_value_has_no_objects();

		// Cache hit: should come back as the same FontAwesome_Resource objects.
		FontAwesome_Release_Provider::reset();
		$this->assert_same_resources( $expected, FontAwesome_Release_Provider::get_resource_collection( '5.15.4', $flags ) );

		$cached = get_transient( FontAwesome_Release_Provider::LAST_USED_RELEASE_TRANSIENT );
		$this->assertEquals(
			array(
				'source'        => $expected->resources()['all']->source(),
				'integrity_key' => $expected->resources()['all']->integrity_key(),
			),
			$cached['resources']['all']
		);
	}

	/**
	 * Upgrade: a site that ran a version prior to 5.2.2 has a cached value in the
	 * legacy transient, containing objects. This version should ignore it, rebuild
	 * into the new transient, and delete the legacy one.
	 *
	 * @dataProvider cache_format_flags_provider
	 */
	public function test_upgrade_from_legacy_cached_value( $flags ) {
		$this->prepare( array( self::build_success_response() ) );

		$expected = $this->build_uncached( '5.15.4', $flags );

		// This is what 5.2.1 would have left behind, matching the current configuration.
		set_transient(
			FontAwesome_Release_Provider::LEGACY_LAST_USED_RELEASE_TRANSIENT,
			self::build_legacy_cached_value( '5.15.4', $flags, 'https://example.com/legacy/all.css' ),
			YEAR_IN_SECONDS
		);
		set_site_transient(
			FontAwesome_Release_Provider::LEGACY_LAST_USED_RELEASE_TRANSIENT,
			self::build_legacy_cached_value( '5.15.4', $flags, 'https://example.com/legacy/all.css' ),
			YEAR_IN_SECONDS
		);

		$this->forbid_legacy_writes();

		$legacy_reads = 0;
		add_filter(
			'pre_transient_' . FontAwesome_Release_Provider::LEGACY_LAST_USED_RELEASE_TRANSIENT,
			function ( $value ) use ( &$legacy_reads ) {
				$legacy_reads++;
				return $value;
			}
		);

		FontAwesome_Release_Provider::reset();
		$collection = FontAwesome_Release_Provider::get_resource_collection( '5.15.4', $flags );

		// It did not use the legacy value.
		$this->assert_same_resources( $expected, $collection );
		$this->assertEquals( 0, $legacy_reads );

		// It wrote the new format into the new transient.
		$this->assert_cached_value_has_no_objects();

		// And it removed the legacy transients.
		remove_all_filters( 'pre_transient_' . FontAwesome_Release_Provider::LEGACY_LAST_USED_RELEASE_TRANSIENT );
		$this->assertFalse( get_transient( FontAwesome_Release_Provider::LEGACY_LAST_USED_RELEASE_TRANSIENT ) );
		$this->assertFalse( get_site_transient( FontAwesome_Release_Provider::LEGACY_LAST_USED_RELEASE_TRANSIENT ) );

		// Enqueuing from the rebuilt collection works.
		fa()->enqueue_cdn(
			array_merge(
				fa()->options(),
				array(
					'version'    => '5.15.4',
					'usePro'     => $flags['use_pro'],
					'technology' => $flags['use_svg'] ? 'svg' : 'webfont',
					'compat'     => $flags['use_compatibility'],
				)
			),
			$collection
		);
	}

	/**
	 * A cached value that has objects in it, or that some caching layer could
	 * not fully unserialize, should be treated as a cache miss and overwritten.
	 */
	public function test_cached_value_with_objects_or_incomplete_class_is_rebuilt() {
		$this->prepare( array( self::build_success_response() ) );

		$flags    = self::PRO_WEBFONT_FLAGS;
		$expected = $this->build_uncached( '5.15.4', $flags );

		// phpcs:ignore WordPress.PHP.DiscouragedPHPFunctions.serialize_unserialize
		$incomplete = unserialize( 'O:30:"FortAwesome\\Not_A_Loaded_Class":0:{}' );
		$this->assertInstanceOf( \__PHP_Incomplete_Class::class, $incomplete );

		$bad_values = array(
			'legacy format, with objects' => self::build_legacy_cached_value( '5.15.4', $flags, 'https://example.com/legacy/all.css' ),
			'incomplete class'            => array_merge(
				self::build_legacy_cached_value( '5.15.4', $flags, 'unused' ),
				array( 'resources' => array( 'all' => $incomplete ) )
			),
			'incomplete class value'      => $incomplete,
			'missing integrity_key'       => array_merge(
				self::build_legacy_cached_value( '5.15.4', $flags, 'unused' ),
				array( 'resources' => array( 'all' => array( 'source' => 'https://example.com/legacy/all.css' ) ) )
			),
			'scalar'                      => 42,
		);

		foreach ( $bad_values as $label => $bad_value ) {
			set_transient( FontAwesome_Release_Provider::LAST_USED_RELEASE_TRANSIENT, $bad_value, YEAR_IN_SECONDS );
			FontAwesome_Release_Provider::reset();

			$this->assert_same_resources(
				$expected,
				FontAwesome_Release_Provider::get_resource_collection( '5.15.4', $flags ),
				$label
			);

			$this->assert_cached_value_has_no_objects();
		}
	}

	/**
	 * Downgrade: after this version has run, an older version must still work when
	 * it reads its own (legacy) transient. This version must never write that
	 * transient, so the older version will only ever find either nothing, or a
	 * value it wrote itself.
	 */
	public function test_downgrade_after_running_this_version() {
		$this->prepare( array( self::build_success_response() ) );

		$this->forbid_legacy_writes();

		$flags    = self::PRO_WEBFONT_FLAGS;
		$expected = $this->build_uncached( '5.15.4', $flags );

		// Run this version: cache miss, cache hit, upgrade, and deactivation.
		FontAwesome_Release_Provider::get_resource_collection( '5.15.4', $flags );
		FontAwesome_Release_Provider::reset();
		FontAwesome_Release_Provider::get_resource_collection( '5.15.4', $flags );
		fa()->try_upgrade();
		$this->assert_cached_value_has_no_objects();

		// Now simulate the downgraded version reading its cache: a miss, not a fatal error.
		$this->assertNull( self::read_cache_as_5_2_1( '5.15.4', $flags ) );
		$this->assertNull( self::read_cache_as_5_2_1( '5.15.4', self::FREE_SVG_COMPAT_FLAGS ) );

		// After that miss, the downgraded version writes its own format to the legacy transient.
		remove_all_filters( 'pre_set_transient_' . FontAwesome_Release_Provider::LEGACY_LAST_USED_RELEASE_TRANSIENT );
		set_transient(
			FontAwesome_Release_Provider::LEGACY_LAST_USED_RELEASE_TRANSIENT,
			self::build_legacy_cached_value( '5.15.4', $flags, 'https://example.com/legacy/all.css' ),
			YEAR_IN_SECONDS
		);

		// And then reads it back successfully on subsequent page loads.
		$this->assertEquals( 'https://example.com/legacy/all.css', self::read_cache_as_5_2_1( '5.15.4', $flags ) );

		// Deactivating this version removes both transients.
		FontAwesome_Deactivator::deactivate();
		$this->assertFalse( get_transient( FontAwesome_Release_Provider::LAST_USED_RELEASE_TRANSIENT ) );
		$this->assertFalse( get_transient( FontAwesome_Release_Provider::LEGACY_LAST_USED_RELEASE_TRANSIENT ) );
	}

	/**
	 * Upgrade, then downgrade, then upgrade again. While downgraded, the configuration
	 * may have changed, so this version's cached value may be stale. It must only be
	 * used if it matches the current configuration.
	 */
	public function test_upgrade_again_after_downgrade() {
		$this->prepare( array( self::build_success_response() ) );

		$this->forbid_legacy_writes();

		$expected_pro_webfont = $this->build_uncached( '5.15.4', self::PRO_WEBFONT_FLAGS );
		$expected_free_svg    = $this->build_uncached( '5.15.4', self::FREE_SVG_COMPAT_FLAGS );

		// First upgrade: this version caches the pro webfont configuration.
		FontAwesome_Release_Provider::get_resource_collection( '5.15.4', self::PRO_WEBFONT_FLAGS );

		// While downgraded, the configuration changed to free svg, and the older version cached that.
		remove_all_filters( 'pre_set_transient_' . FontAwesome_Release_Provider::LEGACY_LAST_USED_RELEASE_TRANSIENT );
		set_transient(
			FontAwesome_Release_Provider::LEGACY_LAST_USED_RELEASE_TRANSIENT,
			self::build_legacy_cached_value( '5.15.4', self::FREE_SVG_COMPAT_FLAGS, 'https://example.com/legacy/all.js' ),
			YEAR_IN_SECONDS
		);
		$this->forbid_legacy_writes();

		// Upgrade again: the stale cached value is not used, it's rebuilt for the current configuration.
		FontAwesome_Release_Provider::reset();
		$this->assert_same_resources(
			$expected_free_svg,
			FontAwesome_Release_Provider::get_resource_collection( '5.15.4', self::FREE_SVG_COMPAT_FLAGS )
		);
		$this->assert_cached_value_has_no_objects();
		$this->assertFalse( get_transient( FontAwesome_Release_Provider::LEGACY_LAST_USED_RELEASE_TRANSIENT ) );

		// And if the configuration goes back, it's rebuilt again.
		FontAwesome_Release_Provider::reset();
		$this->assert_same_resources(
			$expected_pro_webfont,
			FontAwesome_Release_Provider::get_resource_collection( '5.15.4', self::PRO_WEBFONT_FLAGS )
		);
	}
}

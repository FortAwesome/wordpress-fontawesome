<?php
namespace FortAwesome;

use \WP_Error;

/**
 * Tests the release provider, integrated with the main Font Awesome class simulating loading and
 * caching scenarios.
 *
 * @noinspection PhpIncludeInspection
 */

require_once FONTAWESOME_DIR_PATH . 'includes/class-fontawesome-release-provider.php';
require_once FONTAWESOME_DIR_PATH . 'includes/class-fontawesome.php';
require_once FONTAWESOME_DIR_PATH . 'font-awesome.php';
require_once dirname( __FILE__ ) . '/_support/font-awesome-phpunit-util.php';
require_once dirname( __FILE__ ) . '/fixtures/graphql-releases-query-fixture.php';

/**
 * Class ReleaseProviderIntegrationTest
 */
class ReleaseProviderIntegrationTest extends \WP_UnitTestCase {
	public function setUp() {
		reset_db();
		remove_all_actions( 'font_awesome_preferences' );
		remove_all_filters(
			'pre_option_' . FontAwesome_Release_Provider::OPTIONS_KEY
		);
		remove_all_filters(
			'pre_site_transient_' . FontAwesome_Release_Provider::LAST_USED_RELEASE_TRANSIENT
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
				function( $method ) use ( $arg ) {
					$method->will( $this->throwException( new ApiRequestException() ) );
				}
			);
		} elseif ( \is_array( $arg ) ) {
			mock_singleton_method(
				$this,
				FontAwesome_Metadata_Provider::class,
				'metadata_query',
				function( $method ) use ( $arg ) {
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

		$enqueued_callback = function() use ( &$enqueued_count ) {
			$enqueued_count++;
			$this->assertEquals( fa()->latest_version(), fa()->version() );
		};
		add_action( 'font_awesome_enqueued', $enqueued_callback );

		fa()->gather_preferences();

		$resource_collection = fa_release_provider()->get_resource_collection( '5.2.0' );
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
			function( $value ) use ( &$all_releases_query_count ) {
				$all_releases_query_count++;
				return $value;
			},
			0
		);

		add_filter(
			'pre_site_transient_' . FontAwesome_Release_Provider::LAST_USED_RELEASE_TRANSIENT,
			function() use ( &$last_used_release_query_count ) {
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
			'5.4.1',
			array(
				'use_pro'  => true,
				'use_svg'  => false,
				'use_shim' => false,
			)
		);

		// each are incremented.
		$this->assertEquals( 1, $last_used_release_query_count );
		$this->assertEquals( 3, $all_releases_query_count );

		$resource_collection = FontAwesome_Release_Provider::get_resource_collection(
			'5.4.1',
			array(
				'use_pro'  => true,
				'use_svg'  => false,
				'use_shim' => false,
			)
		);

		// only on the transient query count is incremented.
		$this->assertEquals( 2, $last_used_release_query_count );
		$this->assertEquals( 3, $all_releases_query_count );

		/**
		 * Ensure no false positives by asserting that the count would have
		 * been incremented if the query had been attempted.
		 */
		get_option( FontAwesome_Release_Provider::OPTIONS_KEY );
		get_site_transient( FontAwesome_Release_Provider::LAST_USED_RELEASE_TRANSIENT );

		$this->assertEquals( 3, $last_used_release_query_count );
		$this->assertEquals( 4, $all_releases_query_count );
	}
}

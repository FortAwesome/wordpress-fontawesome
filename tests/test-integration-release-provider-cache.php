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
	protected $fa;
	protected $release_provider;

	public function setUp() {
		reset_db();
		remove_all_actions( 'font_awesome_preferences' );
	}

	// Pass an array of responses, in the shape returned by wp_remote_get().
	// A release provider will be mocked to return those responses, in order,
	// on consecutive GETs to the fontawesome API.
	protected function prepare( $responses ) {
		$mocked_release_provider = mock_singleton_method(
			$this,
			FontAwesome_Release_Provider::class,
			'query',
			function( $method ) use ( $responses ) {
				$method->will( $this->onConsecutiveCalls( ...$responses ) );
			}
		);

		$this->release_provider = $mocked_release_provider;

		$this->fa = mock_singleton_method(
			$this,
			FontAwesome::class,
			'release_provider',
			function( $method ) use ( $mocked_release_provider ) {
				$method->willReturn( $mocked_release_provider );
			}
		);

		FontAwesome_Activator::activate();
	}

	protected static function build_success_response() {
		return wp_json_encode(
			array(
				'data' => graphql_releases_query_fixture(),
			)
		);
	}

	protected static function build_error_response() {
		return new WP_Error();
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
	public function test_caching() {
		$this->prepare(
			array(
				self::build_success_response(), // An initial successful one.
			)
		);

		$fa = $this->fa;

		$enqueued_count = 0;

		$enqueued_callback = function() use ( $fa, &$enqueued_count ) {
			$enqueued_count++;
			$this->assertEquals( $fa->latest_version(), $fa->version() );
		};
		add_action( 'font_awesome_enqueued', $enqueued_callback );

		$fa->gather_preferences();

		$resource_collection = $this->release_provider->get_resource_collection( '5.2.0' );
		$fa->enqueue_cdn( $fa->options(), $resource_collection );

		$this->assertEquals( 1, $enqueued_count );

		$versions = $this->release_provider->versions();

		// Now, reset to simulate a subsequent PHP process running, so the Singletons will have to
		// refresh themselves, but we already have the load configuration in the db from the previous run.
		$this->prepare(
			array(
				self::build_error_response(),
			)
		);

		$fa->enqueue_cdn( $fa->options(), $resource_collection );

		/**
		 * If it loads the second time without choking on the mock 500 response, then we're good.
		 */
		$this->assertEquals( 2, $enqueued_count );

		/**
		 * The ReleaseProvider shouldn't even issue the subsequent query, and it should provide the same set of
		 * versions as the last time it was successful.
		 */
		$this->assertEquals( $versions, $this->release_provider->versions() );
	}
}

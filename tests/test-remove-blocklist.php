<?php
namespace FortAwesome;

/**
 * Module for RemoveBlocklistTest
 */
require_once dirname( __FILE__ ) . '/../includes/class-fontawesome-activator.php';
require_once dirname( __FILE__ ) . '/_support/font-awesome-phpunit-util.php';

/**
 * Class RemoveBlocklistTest
 */
class RemoveBlocklistTest extends \WP_UnitTestCase {

	// TODO: add testing for removal of blocked inline scripts and styles.
	protected $fake_unregistered_clients = array(
		'3c937b6d9b50371df1e78b5d70e11512' => array(
			'handle'     => 'conflicting-fa-webfont',
			'href'       => 'https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.css',
			'technology' => 'webfont',
			'blocked'    => true,
		),
		'f975719c4e7654191a03e5f111418585' => array(
			'handle'     => 'conflicting-fa-js',
			'src'        => 'https://use.fontawesome.com/releases/v5.0.13/js/all.js',
			'technology' => 'js',
			'blocked'    => true,
		),
	);

	protected function fake_md5s() {
		return array_keys( $this->fake_unregistered_clients );
	}

	/**
	 * Resets test data.
	 *
	 * @before
	 */
	protected function reset() {
		FontAwesome::instance()->reset();
		Mock_FontAwesome_Releases::mock();
		wp_script_is( 'font-awesome', 'enqueued' ) && wp_dequeue_script( 'font-awesome' );
		wp_script_is( 'font-awesome-v4shim', 'enqueued' ) && wp_dequeue_script( 'font-awesome-v4shim' );
		wp_style_is( 'font-awesome', 'enqueued' ) && wp_dequeue_style( 'font-awesome' );
		wp_style_is( 'font-awesome-v4shim', 'enqueued' ) && wp_dequeue_style( 'font-awesome-v4shim' );
		foreach ( $this->fake_unregistered_clients as $md5 => $style ) {
			wp_dequeue_style( $style['handle'] );
			wp_deregister_style( $style['handle'] );
		}
		foreach ( $this->fake_unregistered_clients as $md5 => $script ) {
			wp_dequeue_script( $script['handle'] );
			wp_deregister_script( $script['handle'] );
		}
		FontAwesome_Activator::activate();

		update_option(
			FontAwesome::CONFLICT_DETECTION_OPTIONS_KEY,
			array(
				'detectConflictsUntil' => 0,
				'unregisteredClients'  => $this->fake_unregistered_clients,
			)
		);
	}

	// By default, we'll enqueue as late as possible, to make sure these are still detected.
	public function enqueue_fakes( $priority = 99 ) {
		add_action(
			'wp_enqueue_scripts',
			function () {
				// Add some unregistered clients, both styles and scripts.
				foreach ( $this->fake_unregistered_clients as $md5 => $client ) {
					if ( 'js' === $client['technology'] ) {
						// phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion
						wp_enqueue_script( $client['handle'], $client['src'], array(), null, 'all' );
					} else {
						// phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion
						wp_enqueue_style( $client['handle'], $client['href'], array(), null, 'all' );
					}
				}
			},
			$priority
		);
	}

	public function test_unregistered_conflict_cleaned() {
		$fa = mock_singleton_method(
			$this,
			FontAwesome::class,
			'options',
			function( $method ) {
				$opts = wp_parse_args(
					array(
						'version' => '5.0.13',
					),
					FontAwesome::DEFAULT_USER_OPTIONS
				);
				$method->willReturn( $opts );
			}
		);

		$this->enqueue_fakes();

		add_action(
			'font_awesome_preferences',
			function() use ( $fa ) {
				$fa->register(
					[
						'name' => 'clientA',
					]
				);
			}
		);

		fa()->gather_preferences();

		$resource_collection = fa_release_provider()->get_resource_collection( '5.2.0' );
		fa()->enqueue_cdn( fa()->options(), $resource_collection );

		ob_start();
		wp_head(); // required to trigger the 'wp_enqueue_scripts' action.
		ob_end_clean();

		// make sure that the fake unregistered clients are no longer enqueued and that our plugin succeeded otherwise.
		$this->assertCount(
			count( $this->fake_unregistered_clients ),
			fa()->blocklist()
		);

		foreach ( $this->fake_unregistered_clients as $key => $client ) {
			switch ( $client['technology'] ) {
				case 'webfont':
					$this->assertTrue( wp_style_is( $client['handle'], 'registered' ) ); // is *was* there.
					$this->assertFalse( wp_style_is( $client['handle'], 'enqueued' ) ); // now it's gone.
					break;
				case 'js':
					$this->assertTrue( wp_script_is( $client['handle'], 'registered' ) ); // is *was* there.
					$this->assertFalse( wp_script_is( $client['handle'], 'enqueued' ) ); // now it's gone.
					break;
			}
		}

		$this->assertTrue( wp_style_is( FontAwesome::RESOURCE_HANDLE, 'enqueued' ) ); // and our plugin's style *is* there.
	}

	public function test_unregistered_conflict_cleaned_automatically_when_old_feature_detected() {
		$options_v1_schema = array(
			'adminClientLoadSpec'       => array(
				'name'           => 'admin-user',
				'clientVersion'  => 0,
				'method'         => 'svg',
				'pseudoElements' => true,
				'v4shim'         => true,
			),
			'usePro'                    => false,
			'removeUnregisteredClients' => true,
			'version'                   => 'latest',
		);

		update_option( FontAwesome::OPTIONS_KEY, $options_v1_schema );

		$this->enqueue_fakes();

		add_action(
			'font_awesome_preferences',
			function() {
				fa()->register(
					[
						'name' => 'clientA',
					]
				);
			}
		);

		fa()->gather_preferences();

		$resource_collection = fa_release_provider()->get_resource_collection( '5.2.0' );
		fa()->enqueue_cdn( fa()->options(), $resource_collection );

		ob_start();
		wp_head(); // required to trigger the 'wp_enqueue_scripts' action.
		ob_end_clean();

		// make sure that the fake unregistered clients are no longer enqueued and that our plugin succeeded otherwise.
		$this->assertCount(
			count( $this->fake_unregistered_clients ),
			fa()->blocklist()
		);
		foreach ( $this->fake_unregistered_clients as $md5 => $client ) {
			switch ( $client['technology'] ) {
				case 'webfont':
					$this->assertTrue( wp_style_is( $client['handle'], 'registered' ) ); // is *was* there.
					$this->assertFalse( wp_style_is( $client['handle'], 'enqueued' ) ); // now it's gone.
					break;
				case 'js':
					$this->assertTrue( wp_script_is( $client['handle'], 'registered' ) ); // is *was* there.
					$this->assertFalse( wp_script_is( $client['handle'], 'enqueued' ) ); // now it's gone.
					break;
			}
		}

		$this->assertTrue( wp_script_is( FontAwesome::RESOURCE_HANDLE, 'enqueued' ) ); // and our plugin's style *is* there.

		// There are some expected side effects:
		// 1. the options should have been updated as a result of the plugin upgrade.
		$this->assertEquals(
			array(
				'usePro'         => false,
				'v4Compat'       => true,
				'technology'     => 'svg',
				'pseudoElements' => true,
				'version'        => 'latest',
				'kitToken'       => null,
				'apiToken'       => false,
			),
			fa()->options()
		);

		// 2. the blocklist should have been populated.
		$this->assertEquals(
			$this->fake_md5s(),
			fa()->blocklist()
		);

		$this->assertEquals(
			array(
				'3c937b6d9b50371df1e78b5d70e11512' => array(
					'src'     => 'https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.css',
					'type'    => 'style',
					'blocked' => true,
				),
				'f975719c4e7654191a03e5f111418585' => array(
					'src'     => 'https://use.fontawesome.com/releases/v5.0.13/js/all.js',
					'type'    => 'script',
					'blocked' => true,
				),
			),
			get_option( FontAwesome::CONFLICT_DETECTION_OPTIONS_KEY )['unregisteredClients']
		);
	}

	public function test_unregistered_client_not_blocked_by_default() {
		$fa = fa();

		$unregistered_clients = $this->fake_unregistered_clients;

		foreach ( $unregistered_clients as $md5 => $client ) {
			unset( $unregistered_clients[ $md5 ]['blocked'] );
		}

		update_option(
			FontAwesome::CONFLICT_DETECTION_OPTIONS_KEY,
			array(
				'detectConflictsUntil' => 0,
				'unregisteredClients'  => $unregistered_clients,
			)
		);

		$this->enqueue_fakes();

		add_action(
			'font_awesome_preferences',
			function() use ( $fa ) {
				$fa->register(
					[
						'name' => 'clientA',
					]
				);
			}
		);

		fa()->gather_preferences();

		$resource_collection = fa_release_provider()->get_resource_collection( '5.2.0' );
		fa()->enqueue_cdn( fa()->options(), $resource_collection );

		ob_start();
		wp_head(); // required to trigger the 'wp_enqueue_scripts' action.
		ob_end_clean();

		// make sure that the fake unregistered clients remain enqueued.
		foreach ( $this->fake_unregistered_clients as $md5 => $client ) {
			switch ( $client['technology'] ) {
				case 'webfont':
					$this->assertTrue( wp_style_is( $client['handle'], 'enqueued' ) );
					break;
				case 'js':
					$this->assertTrue( wp_script_is( $client['handle'], 'enqueued' ) );
					break;
			}
		}
	}
}


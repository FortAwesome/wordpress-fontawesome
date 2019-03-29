<?php
namespace FortAwesome;

/**
 * Module for UnregisteredClientsTest
 */
require_once dirname( __FILE__ ) . '/../includes/class-fontawesome-activator.php';
require_once dirname( __FILE__ ) . '/_support/font-awesome-phpunit-util.php';

/**
 * Class UnregisteredClientsTest
 */
class UnregisteredClientsTest extends \WP_UnitTestCase {

	protected $fake_unregistered_clients = array(
		'styles'  => [
			array(
				'handle' => 'fa-4.7-jsdelivr-css',
				'src'    => 'https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.css',
			),
		],
		'scripts' => [
			array(
				'handle' => 'fa-5.0.13-js',
				'src'    => 'https://use.fontawesome.com/releases/v5.0.13/js/all.js',
			),
		],
	);

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
		foreach ( $this->fake_unregistered_clients['styles'] as $style ) {
			wp_dequeue_style( $style['handle'] );
			wp_deregister_style( $style['handle'] );
		}
		foreach ( $this->fake_unregistered_clients['scripts'] as $script ) {
			wp_dequeue_script( $script['handle'] );
			wp_deregister_script( $script['handle'] );
		}
	}

	// By default, we'll enqueue as late as possible, to make sure these are still detected.
	public function enqueue_fakes( $priority = 99 ) {
		add_action(
			'wp_enqueue_scripts',
			function () {
				// Add some unregistered clients, both styles and scripts.
				foreach ( $this->fake_unregistered_clients['styles'] as $style ) {
					// phpcs:ignore WordPress.WP.EnqueuedResourceParameters
					wp_enqueue_style( $style['handle'], $style['src'], array(), null, 'all' );
				}

				foreach ( $this->fake_unregistered_clients['scripts'] as $script ) {
					// phpcs:ignore WordPress.WP.EnqueuedResourceParameters
					wp_enqueue_script( $script['handle'], $script['src'], array(), null, 'all' );
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
						'removeUnregisteredClients' => true,
						'version'                   => '5.0.13',
					),
					FontAwesome::DEFAULT_USER_OPTIONS
				);
				$method->willReturn( $opts );
			}
		);

		$this->enqueue_fakes();

		add_action(
			'font_awesome_requirements',
			function() use ( $fa ) {
				$fa->register(
					[
						'name'          => 'clientA',
						'clientVersion' => '1',
					]
				);
			}
		);

		global $fa_load;
		$fa_load->invoke( $fa );

		ob_start();
		wp_head(); // required to trigger the 'wp_enqueue_scripts' action.
		ob_end_clean();

		// make sure that the fake unregistered clients are no longer enqueued and that our plugin succeeded otherwise.
		$unregistered_clients = $fa->unregistered_clients();
		$this->assertCount(
			count( $this->fake_unregistered_clients['styles'] ) + count( $this->fake_unregistered_clients['scripts'] ),
			$unregistered_clients
		);
		foreach ( $unregistered_clients as $client ) {
			switch ( $client['type'] ) {
				case 'style':
					$this->assertTrue( wp_style_is( $client['handle'], 'registered' ) ); // is *was* there.
					$this->assertFalse( wp_style_is( $client['handle'], 'enqueued' ) ); // now it's gone.
					break;
				case 'script':
					$this->assertTrue( wp_script_is( $client['handle'], 'registered' ) ); // is *was* there.
					$this->assertFalse( wp_script_is( $client['handle'], 'enqueued' ) ); // now it's gone.
					break;
			}
		}
		$this->assertTrue( wp_style_is( FontAwesome::RESOURCE_HANDLE, 'enqueued' ) ); // and our plugin's style *is* there.
	}

	public function test_unregistered_conflict_unresolved_by_default() {
		$fa = fa();

		$this->enqueue_fakes();

		add_action(
			'font_awesome_requirements',
			function() use ( $fa ) {
				$fa->register(
					[
						'name'          => 'clientA',
						'clientVersion' => '1',
					]
				);
			}
		);

		global $fa_load;
		$fa_load->invoke( fa() );

		ob_start();
		wp_head(); // required to trigger the 'wp_enqueue_scripts' action.
		ob_end_clean();

		// make sure that the fake unregistered clients remain enqueued.
		$unregistered_clients = $fa->unregistered_clients();
		$this->assertCount(
			count( $this->fake_unregistered_clients['styles'] ) + count( $this->fake_unregistered_clients['scripts'] ),
			$unregistered_clients
		);
		foreach ( $unregistered_clients as $client ) {
			switch ( $client['type'] ) {
				case 'style':
					$this->assertTrue( wp_style_is( $client['handle'], 'enqueued' ) );
					break;
				case 'script':
					$this->assertTrue( wp_script_is( $client['handle'], 'enqueued' ) );
					break;
			}
		}
	}
}


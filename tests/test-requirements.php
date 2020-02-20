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
require_once dirname( __FILE__ ) . '/_support/font-awesome-phpunit-util.php';

class RequirementsTest extends \WP_UnitTestCase {

	/**
	 * Reset test state.
	 *
	 * @before
	 */
	protected function reset() {
		reset_db();
		FontAwesome::reset();
		Mock_FontAwesome_Releases::mock();
		wp_script_is( 'font-awesome', 'enqueued' ) && wp_dequeue_script( 'font-awesome' );
		wp_script_is( 'font-awesome-v4shim', 'enqueued' ) && wp_dequeue_script( 'font-awesome-v4shim' );
		wp_style_is( 'font-awesome', 'enqueued' ) && wp_dequeue_style( 'font-awesome' );
		wp_style_is( 'font-awesome-v4shim', 'enqueued' ) && wp_dequeue_style( 'font-awesome-v4shim' );
		FontAwesome_Activator::activate();
	}

	public function assert_defaults( $load_spec ) {
		$this->assertEquals( 'webfont', $load_spec['method'] );
		$this->assertTrue( $load_spec['v4shim'] );
		$this->assertTrue( $load_spec['pseudoElements'] );
		$this->assertEquals( fa()->get_latest_version(), fa()->version() );
	}

	public function test_all_default_with_single_client() {
		fa()->register(
			array(
				'name' => 'test',
				'clientVersion' => '1',
			)
		);

		$enqueued          = false;
		$enqueued_callback = function() use ( &$enqueued ) {
			$enqueued = true;
			$this->assert_defaults( fa()->load_spec() );
		};
		add_action( 'font_awesome_enqueued', $enqueued_callback );

		$failed          = false;
		$failed_callback = function() use ( &$failed ) {
			$failed = true;
		};
		add_action( 'font_awesome_failed', $failed_callback );

		global $fa_load;
		$fa_load->invoke( fa() );

		$this->assertFalse( $failed );
		$this->assertTrue( $enqueued );

		$this->assertEquals( 'webfont', fa()->technology() );

		$stuff_enqueued = false;

		add_action('wp_enqueue_scripts', function () use (&$stuff_enqueued){
			$stuff_enqueued = true;
			$this->assertTrue( wp_style_is( FontAwesome::RESOURCE_HANDLE, 'enqueued' ) );
			$this->assertTrue( wp_style_is( FontAwesome::RESOURCE_HANDLE_V4SHIM, 'enqueued' ) );
		}, 99);

		do_action('wp_enqueue_scripts');

		$this->assertTrue($stuff_enqueued);
	}

	public function test_all_default_with_multiple_clients() {
		// Before loading
		$this->assertNull(fa()->technology());
		$this->assertFalse(fa()->v4shim());

		fa()->register(
			array(
				'name' => 'Client A',
				'clientVersion' => '1',
			)
		);

		fa()->register(
			array(
				'name' => 'Client B',
				'clientVersion' => '1',
			)
		);

		$enqueued          = false;
		$enqueued_callback = function() use ( &$enqueued ) {
			$enqueued = true;
			$this->assert_defaults( fa()->load_spec() );
		};
		add_action( 'font_awesome_enqueued', $enqueued_callback );

		$failed          = false;
		$failed_callback = function() use ( &$failed ) {
			$failed = true;
		};
		add_action( 'font_awesome_failed', $failed_callback );

		global $fa_load;
		$fa_load->invoke( fa() );

		$this->assertFalse( $failed );
		$this->assertTrue( $enqueued );
		$this->assertTrue( wp_style_is( FontAwesome::RESOURCE_HANDLE, 'enqueued' ) );
		$this->assertTrue( wp_style_is( FontAwesome::RESOURCE_HANDLE_V4SHIM, 'enqueued' ) );
		$this->assertArrayHasKey( 'Client A', fa()->requirements() );
		$this->assertArrayHasKey( 'Client B', fa()->requirements() );
		$this->assertArrayHasKey( FontAwesome::ADMIN_USER_CLIENT_NAME_INTERNAL, fa()->requirements() );
		$this->assertEquals( 'webfont', fa()->technology() );
		$this->assertTrue( fa()->v4shim() );
	}

	public function test_register_without_name() {
		$this->expectException( \InvalidArgumentException::class );

		fa()->register(
			array(
				'method' => 'svg',
				'v4shim' => 'require',
				'clientVersion' => '1',
			)
		);

		$enqueued          = false;
		$enqueued_callback = function() use ( &$enqueued ) {
			$enqueued = true;
		};
		add_action( 'font_awesome_enqueued', $enqueued_callback );

		$failed          = false;
		$failed_callback = function() use ( &$failed ) {
			$failed = true;
		};
		add_action( 'font_awesome_failed', $failed_callback );

		global $fa_load;
		$fa_load->invoke( fa() );

		// We don't expect either callback to be invoked because throwing the
		// InvalidArgumentException preempts further processing.
		$this->assertFalse( $failed );
		$this->assertFalse( $enqueued );
	}

	public function test_single_client_gets_what_it_wants() {
		add_action(
			'font_awesome_requirements',
			function() {
				fa()->register(
					array(
						'name'   => 'test',
						'method' => 'svg',
						'v4shim' => 'require',
						'clientVersion' => '1',
					)
				);
			}
		);

		$enqueued          = false;
		$enqueued_callback = function() use ( &$enqueued ) {
			$enqueued = true;
		};
		add_action( 'font_awesome_enqueued', $enqueued_callback );

		global $fa_load;
		$fa_load->invoke( fa() );
		$this->assertTrue( $enqueued );
		$this->assertEquals( 'svg', fa()->technology() );
		$this->assertTrue( fa()->v4shim() );
	}

	public function test_duplicate_client_registry() {
		add_action(
			'font_awesome_requirements',
			function() {
				fa()->register(
					array(
						'name'   => 'test',
						'method' => 'svg',
						'v4shim' => 'require',
						'clientVersion' => '1',
					)
				);
				fa()->register(
					array(
						'name'   => 'test',
						'method' => 'svg',
						'v4shim' => 'require',
						'clientVersion' => '1',
					)
				);
			}
		);

		$enqueued          = false;
		$enqueued_callback = function() use ( &$enqueued ) {
			$enqueued = true;
		};
		add_action( 'font_awesome_enqueued', $enqueued_callback );

		global $fa_load;
		$fa_load->invoke( fa() );
		$this->assertTrue( $enqueued );
		$registered_test_clients = array_filter(fa()->requirements(), function( $client ) { return 'test' === $client['name']; });
		$this->assertEquals( 1, count( $registered_test_clients ) );
		$this->assertEquals( 'svg', fa()->technology() );
		$this->assertTrue( fa()->v4shim() );
	}

	public function test_two_compatible_clients() {
		add_action(
			'font_awesome_requirements',
			function() {

				fa()->register(
					array(
						'name'   => 'clientA',
						'method' => 'svg',
						'v4shim' => 'require',
						'clientVersion' => '1',
					)
				);

				fa()->register(
					array(
						'name'   => 'clientB',
						'method' => 'svg',
						'clientVersion' => '1',
					// leaves v4shim alone.
					)
				);
			}
		);

		global $fa_load;
		$fa_load->invoke( fa() );
		$this->assertEquals( 'svg', fa()->technology() );
		$this->assertTrue( fa()->v4shim() );
	}

	public function test_incompatible_method() {
		add_action(
			'font_awesome_requirements',
			function() {

				fa()->register(
					array(
						'name'   => 'clientA',
						'method' => 'svg',
						'clientVersion' => '1'
					)
				);

				fa()->register(
					array(
						'name'   => 'clientB',
						'method' => 'webfont', // not compatible with svg.
						'clientVersion' => '1'
					)
				);
			}
		);

		$enqueued          = false;
		$enqueued_callback = function() use ( &$enqueued ) {
			$enqueued = true;
		};
		add_action( 'font_awesome_enqueued', $enqueued_callback );

		$failed          = false;
		$failed_callback = function( $data ) use ( &$failed ) {
			$failed = true;
			$this->assertEquals( 'method', $data['requirement'] );
			$this->assertTrue( $this->client_requirement_exists( 'clientB', $data['conflictingClientRequirements'] ) );
		};
		add_action( 'font_awesome_failed', $failed_callback );

		global $fa_load;

		$this->assertFalse( $fa_load->invoke( fa() ) );
		$this->assertTrue( $failed );
		$this->assertFalse( $enqueued );
		$this->assertNotNull( fa()->conflicts() );
	}

	public function test_pseudo_element_default_false_when_svg() {
		add_action(
			'font_awesome_requirements',
			function() {
				fa()->register(
					array(
						'name'   => 'test',
						'method' => 'svg',
						'clientVersion' => '1',
					)
				);
			}
		);

		global $fa_load;
		$fa_load->invoke( fa() );
		$this->assertEquals( 'svg', fa()->technology() );
		$this->assertFalse( fa()->using_pseudo_elements() );
	}

	public function test_pseudo_element_default_true_when_webfont() {
		add_action(
			'font_awesome_requirements',
			function() {
				fa()->register(
					array(
						'name'   => 'test',
						'method' => 'webfont',
						'clientVersion' => '1',
					)
				);
			}
		);

		global $fa_load;
		$fa_load->invoke( fa() );
		$this->assertEquals( 'webfont', fa()->technology() );
		$this->assertTrue( fa()->using_pseudo_elements() );
	}

	public function client_requirement_exists( $name, $reqs ) {
		$found = false;
		foreach ( $reqs as $req ) {
			if ( $name === $req['name'] ) {
				$found = true;
				break;
			}
		}
		return $found;
	}

	/**
	 * @group pro
	 */
	public function test_pro_is_configured() {
		mock_singleton_method(
			$this,
			FontAwesome::class,
			'is_pro_configured',
			function( $method ) {
				$method->willReturn( true );
			}
		);

		add_action(
			'font_awesome_requirements',
			function() {
				fa()->register(
					array(
						'name' => 'test',
						'clientVersion' => '1',
					)
				);
			}
		);

		global $fa_load;
		$fa_load->invoke( fa() );
		$this->assertTrue( fa()->using_pro() );
	}

	/**
	 * @group pro
	 */
	public function test_pro_not_configured() {
		mock_singleton_method(
			$this,
			FontAwesome::class,
			'is_pro_configured',
			function( $method ) {
				$method->willReturn( false );
			}
		);

		add_action(
			'font_awesome_requirements',
			function() {
				fa()->register(
					array(
						'name' => 'test',
						'clientVersion' => '1',
					)
				);
			}
		);

		global $fa_load;
		$fa_load->invoke( fa() );
		$this->assertFalse( fa()->using_pro() );
	}

	/**
	 * @group shim
	 */
	public function test_shim_svg() {
		add_action(
			'font_awesome_requirements',
			function() {
				fa()->register(
					array(
						'name'   => 'test',
						'method' => 'svg',
						'v4shim' => 'require',
						'clientVersion' => '1',
					)
				);
			}
		);

		global $fa_load;
		$fa_load->invoke( fa() );

		$stuff_enqueued = false;

		add_action('wp_enqueue_scripts', function () use (&$stuff_enqueued){
			$stuff_enqueued = true;
			$this->assertTrue( wp_script_is( FontAwesome::RESOURCE_HANDLE_V4SHIM, 'enqueued' ) );
		}, 99);

		do_action('wp_enqueue_scripts');

		$this->assertTrue($stuff_enqueued);
	}

	/**
	 * One client requires v4shim. The other does not forbid, but also does not require it.
	 * Expected: Client A's requirement should be honored, since Client B does not forbid.
	 *
	 * @group shim
	 */
	public function test_shim_webfont() {
		add_action(
			'font_awesome_requirements',
			function() {
				fa()->register(
					array(
						'name'   => 'Client A',
						'method' => 'webfont',
						'v4shim' => 'require',
						'clientVersion' => '1',
					)
				);
				fa()->register(
					array(
						'name'   => 'Client B',
						'method' => 'webfont',
						'clientVersion' => '1',
					)
				);
			}
		);

		global $fa_load;
		$fa_load->invoke( fa() );
		$this->assertTrue( wp_style_is( FontAwesome::RESOURCE_HANDLE_V4SHIM, 'enqueued' ) );
	}

	/**
	 * @group shim
	 */
	public function test_shim_conflict() {
		add_action(
			'font_awesome_requirements',
			function() {
				fa()->register(
					array(
						'name'   => 'Client A',
						'method' => 'webfont',
						'v4shim' => 'require',
						'clientVersion' => '1',
					)
				);
				fa()->register(
					array(
						'name'   => 'Client B',
						'method' => 'webfont',
						'v4shim' => 'forbid',
						'clientVersion' => '1',
					)
				);
			}
		);

		$enqueued          = false;
		$enqueued_callback = function() use ( &$enqueued ) {
			$enqueued = true;
		};
		add_action( 'font_awesome_enqueued', $enqueued_callback );

		$failed          = false;
		$failed_callback = function( $data ) use ( &$failed ) {
			$failed = true;
			$this->assertEquals( 'v4shim', $data['requirement'] );
			$this->assertTrue( $this->client_requirement_exists( 'Client B', $data['conflictingClientRequirements'] ) );
		};
		add_action( 'font_awesome_failed', $failed_callback );

		global $fa_load;

		$this->assertFalse( $fa_load->invoke( fa() ) );
		$this->assertTrue( $failed );
		$this->assertFalse( $enqueued );
		$this->assertFalse( wp_script_is( 'font-awesome-v4shim', 'enqueued' ) );
	}

	/**
	 * It should be considered at most redundant, but not an error, if one client requires
	 * the webfont method and another explicitly requires pseudo-element support.
	 * Webfont with CSS always implies pseudo-element support.
	 */
	public function test_webfont_with_pseudo_elements() {
		add_action(
			'font_awesome_requirements',
			function() {
				fa()->register(
					array(
						'name'   => 'Client A',
						'method' => 'webfont',
						'clientVersion' => '1',
					)
				);
				fa()->register(
					array(
						'name'           => 'Client B',
						'pseudoElements' => 'require',
						'clientVersion' => '1',
					)
				);
			}
		);

		$enqueued          = false;
		$enqueued_callback = function() use ( &$enqueued ) {
			$enqueued = true;
		};
		add_action( 'font_awesome_enqueued', $enqueued_callback );

		$failed          = false;
		$failed_callback = function() use ( &$failed ) {
			$failed = true;
		};
		add_action( 'font_awesome_failed', $failed_callback );

		global $fa_load;
		$fa_load->invoke( fa() );
		$this->assertTrue( $enqueued );
		$this->assertFalse( $failed );
		$this->assertEquals( 'webfont', fa()->technology() );
		$this->assertTrue( fa()->using_pseudo_elements() );
	}

	/**
	 * It should be considered at most a warning, but not an error, if one client requires
	 * the webfont method and another forbids pseudo-element support.
	 * Webfont with CSS always implies pseudo-element support.
	 */
	public function test_webfont_and_forbid_pseudo_elements() {
		add_action(
			'font_awesome_requirements',
			function() {
				fa()->register(
					array(
						'name'   => 'Client A',
						'method' => 'webfont',
						'clientVersion' => '1',
					)
				);
				fa()->register(
					array(
						'name'           => 'Client B',
						'pseudoElements' => 'forbid',
						'clientVersion' => '1',
					)
				);
			}
		);

		$enqueued          = false;
		$enqueued_callback = function() use ( &$enqueued ) {
			$enqueued = true;
		};
		add_action( 'font_awesome_enqueued', $enqueued_callback );

		$failed          = false;
		$failed_callback = function() use ( &$failed ) {
			$failed = true;
		};
		add_action( 'font_awesome_failed', $failed_callback );

		$state = array();
		begin_error_log_capture( $state );
		global $fa_load;
		$fa_load->invoke( fa() );
		$err = end_error_log_capture( $state );

		$this->assertTrue( $enqueued );
		$this->assertFalse( $failed );
		$this->assertEquals( 'webfont', fa()->technology() );
		$this->assertTrue( fa()->using_pseudo_elements() );
		$this->assertRegExp( '/WARNING: a client of Font Awesome has forbidden pseudo-elements/', $err );
	}

	public function test_changing_client_version_rebuilds_load_spec() {
		global $fa_load;

		fa()->register(
			array(
				'name'   => 'test',
				'method' => 'svg',
				'pseudoElements' => 'require',
				'clientVersion' => '1',
			)
		);

		$fa_load->invoke( fa() );
		$load_spec1 = fa()->load_spec();
		$this->assertNotNull( $load_spec1 );

		// The first requirements required pseudoElements
		$this->assertTrue( $load_spec1['pseudoElements'] );

		// For a subsequent load, register the same client name, different version and different requirements
		fa()->register(
			array(
				'name'   => 'test',
				'method' => 'svg',
				'v4shim' => 'forbid',
				'clientVersion' => '2',
			)
		);

		$fa_load->invoke( fa() );
		$load_spec2 = fa()->load_spec();
		$this->assertNotNull( $load_spec2 );

		$this->assertNotEquals( $load_spec1, $load_spec2 );

		// The first requirements forbid pseudoElements
		$this->assertFalse( $load_spec2['pseudoElements'] );
	}

	/**
	 * This is really just a black box (with respect to build(), anyway) way to test that our should_rebuild() logic
	 * is working as expected, and that we're actually only rebuilding the load spec when appropriate to do so.
	 * So we will call load() twice, the second time with different requirements that *would* change the load spec,
	 * but without updating the clientVersion. So we'll know that the load spec caching mechanism did it's job
	 * right if the second load spec is the same as the first.
	 */
	public function test_no_rebuild_without_client_version_update() {
		global $fa_load;

		fa()->register(
			array(
				'name'   => 'test',
				'method' => 'svg',
				'pseudoElements' => 'require',
				'clientVersion' => '1',
			)
		);

		$fa_load->invoke( fa() );
		$load_spec1 = fa()->load_spec();
		$this->assertNotNull( $load_spec1 );

		// The first requirements required pseudoElements
		$this->assertTrue( $load_spec1['pseudoElements'] );

		// For a subsequent load, register the same client name, different version and different requirements
		fa()->register(
			array(
				'name'   => 'test',
				'method' => 'svg',
				'v4shim' => 'forbid',
				'clientVersion' => '1',
			)
		);

		$fa_load->invoke( fa() );
		$load_spec2 = fa()->load_spec();
		$this->assertNotNull( $load_spec2 );

		$this->assertEquals( $load_spec1, $load_spec2 );
	}

	/**
	 * Since there was no webfont shim in 5.0.x, after throwing an exception,
	 * fa()->load_spec() should remain null, and fa()->options() should remain unchanged.
	 */
	public function test_5_0_webfont_shim_null_no_changes_saved() {
		global $fa_load;

		$original_options = fa()->options();

		$new_options = array_replace_recursive($original_options, array( 'version' => '5.0.9' ));

		// load_spec should be null before
		$this->assertNull(fa()->load_spec());

		fa()->register(
			array(
				'name'   => 'test',
				'method' => 'webfont',
				'v4shim' => 'require',
				'clientVersion' => '1',
			)
		);

		try {
			$fa_load->invoke( fa(), $new_options );
		} catch( FontAwesome_ConfigurationException $e ){
			// no-op.
		}

		// load_spec should also be null after
		$this->assertNull( fa()->load_spec() );

		// no changes should have been saved to options
		$this->assertEquals($original_options, fa()->options());
	}
	// TODO: test where the ReleaseProvider would return a null integrity key, both for webfont and svg.
}

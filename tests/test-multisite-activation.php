<?php
namespace FortAwesome;

require_once dirname( __FILE__ ) . '/../includes/class-fontawesome-activator.php';
require_once dirname( __FILE__ ) . '/../includes/class-fontawesome-exception.php';
require_once dirname( __FILE__ ) . '/_support/font-awesome-phpunit-util.php';

use Yoast\WPTestUtils\WPIntegration\TestCase;

/**
 * Class MultisiteActivationTest
 */
class MultisiteActivationTest extends TestCase {
	protected $sub_sites           = array();
	protected $original_blog_id    = null;
	protected $original_network_id = null;
	protected $added_network_ids   = array();

	public function set_up() {
		parent::set_up();
		/**
		 * We need this to be defined for this test, though it's normally defined in
		 * the top-level loader file that is not being included in this test configuration.
		 */
		if ( ! defined( 'FONTAWESOME_PLUGIN_FILE' ) ) {
			define( 'FONTAWESOME_PLUGIN_FILE', 'font-awesome/index.php' );
		}

		if ( ! is_multisite() ) {
			throw new \Exception();
		}

		$this->original_blog_id    = get_current_blog_id();
		$this->original_network_id = get_current_network_id();

		reset_db();
		remove_all_actions( 'font_awesome_preferences' );
		remove_all_filters( 'wp_is_large_network' );
		add_action( 'add_network', curry_add_network_handler( $this->added_network_ids ), 99, 2 );
		FontAwesome::reset();
		( new Mock_FontAwesome_Metadata_Provider() )->mock(
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
				),
			)
		);

		FontAwesome_Release_Provider::load_releases();

		if ( $this->is_wp_version_compatible() ) {
			$sites = create_subsites();
			foreach ( $sites as $domain => $site_id ) {
				array_push( $this->sub_sites, $site_id );
			}

			switch_to_blog( $this->original_blog_id );
		}
	}

	public function tear_down() {
		parent::tear_down();

		remove_all_actions( 'add_network' );

		switch_to_blog( $this->original_blog_id );

		// Delete all sites on the non-original network.
		foreach ( $this->added_network_ids as $network_id ) {
			\switch_to_network( $network_id );
			$sites = get_sites(
				array(
					'network_id' => $network_id,
				)
			);

			foreach ( $sites as $site ) {
				wp_delete_site( $site->ID );
			}
		}

		\switch_to_network( $this->original_network_id );

		foreach ( $this->sub_sites as $blog_id ) {
			wp_delete_site( $blog_id );
		}
	}

	public function is_wp_version_compatible() {
		global $wp_version;

		return version_compare( $wp_version, '5.1.0', '>=' );
	}

	public function test_multisite_activation() {
		if ( ! $this->is_wp_version_compatible() ) {
			$this->assertTrue( true );
			return;
		}

		if ( is_network_admin() ) {
			FontAwesome_Activator::initialize();
			$site_count       = 0;
			$test_obj         = $this;
			$expected_options = array_merge( FontAwesome::DEFAULT_USER_OPTIONS, array( 'version' => fa()->latest_version_6() ) );

			for_each_blog(
				function( $blog_id ) use ( $test_obj, $expected_options, &$site_count ) {
					$site_count     = ++$site_count;
					$actual_options = get_option( FontAwesome::OPTIONS_KEY );
					$test_obj->assertEquals( $expected_options, $actual_options );

					$test_obj->assertEquals(
						FontAwesome::DEFAULT_CONFLICT_DETECTION_OPTIONS,
						get_option( FontAwesome::CONFLICT_DETECTION_OPTIONS_KEY )
					);
				}
			);

			$this->assertEquals( $site_count, 3 );
		} else {
			$this->assertEquals( count( $this->sub_sites ), 2 );

			// Only activate on the second sub-site.
			switch_to_blog( $this->sub_sites[1] );

			FontAwesome_Activator::initialize();
			$expected_options = array_merge( FontAwesome::DEFAULT_USER_OPTIONS, array( 'version' => fa()->latest_version_6() ) );

			// It is active there on the second sub-site.
			$this->assertEquals( $expected_options, get_option( FontAwesome::OPTIONS_KEY ) );

			// The first sub-site will not have been initialized.
			switch_to_blog( $this->sub_sites[0] );
			$this->assertFalse( boolval( get_option( FontAwesome::OPTIONS_KEY ) ) );

			// The original site will not have been initialized.
			switch_to_blog( $this->original_blog_id );
			$this->assertFalse( boolval( get_option( FontAwesome::OPTIONS_KEY ) ) );

			// The network wide release metadata will have been initialized.
			$this->assertTrue( boolval( get_network_option( get_main_network_id(), FontAwesome_Release_Provider::OPTIONS_KEY ) ) );
		}
	}

	public function test_site_created_after_network_activation() {
		if ( ! $this->is_wp_version_compatible() ) {
			$this->assertTrue( true );
			return;
		}

		if ( ! is_network_admin() ) {
			// Do nothing when we're not in network admin mode.
			$this->assertTrue( true );
			return;
		}

		$test_obj = $this;

		// This activates network wide, for all sites that exist at the time.
		FontAwesome_Activator::initialize();

		switch_to_blog( $this->original_blog_id );

		$options_for_main_blog_id = fa()->options();

		$expected_options = array_merge( FontAwesome::DEFAULT_USER_OPTIONS, array( 'version' => fa()->latest_version_6() ) );

		/**
		 * We'll first, separately ensure that the options are initialized on the main site,
		 * because it seems that in some runtime environments, the main site is not being
		 * activated even when the sub-sites are.
		 */
		$this->assertEquals( $expected_options, $options_for_main_blog_id );

		for_each_blog(
			function( $blog_id ) use ( $test_obj, $expected_options ) {
				$actual_options = fa()->options();
				$test_obj->assertEquals( $expected_options, $actual_options );
			}
		);

		// Create a new site after the initial network activation above.
		$sites = create_subsites( array( 'gamma.example.com' ) );

		// Now switch to it and access the options to ensure that it has been initialized properly.
		switch_to_blog( $sites['gamma.example.com'] );

		try {
			$this->assertEquals( $expected_options, fa()->options() );
		} catch ( FontAwesome_Exception $e ) {
			$this->assertTrue( false );
		}
	}

	public function test_activation_exception_when_incompatible_wp_version() {
		if ( $this->is_wp_version_compatible() ) {
			$this->assertTrue( true );
			return;
		}

		$this->expectException( ActivationException::class );

		FontAwesome_Activator::initialize();
	}

	/**
	 * @group slow
	 */
	public function test_for_each_blog_on_many_sites() {
		if ( ! $this->is_wp_version_compatible() ) {
			$this->assertTrue( true );
			return;
		}

		if ( is_network_admin() ) {
			// Do nothing when we're not in network admin mode.
			$this->assertTrue( true );
			return;
		}

		$site_names = array();
		for ( $i = 1; $i <= 205; $i++ ) {
			array_push( $site_names, "test_site_$i" );
		}

		// Create many more sites, more than the default limit in get_sites().
		$sites             = create_subsites( $site_names );
		$network_id        = get_current_network_id();
		$site_count        = get_sites(
			array(
				'network_id' => $network_id,
				'count'      => true,
			)
		);
		$all_site_blog_ids = array_map(
			function( $site ) {
				return $site->blog_id;
			},
			get_sites(
				array(
					'network_id' => $network_id,
					'number'     => 300,
				)
			)
		);

		sort( $all_site_blog_ids );

		$this->assertEquals( $site_count, 208 );

		$visited_blog_ids = array();

		for_each_blog(
			function( $blog_id ) use ( &$visited_blog_ids ) {
				array_push( $visited_blog_ids, $blog_id );
			}
		);

		sort( $visited_blog_ids );

		$this->assertEquals( $all_site_blog_ids, $visited_blog_ids );
	}

	public function test_add_network_after_activation() {
		if ( ! $this->is_wp_version_compatible() ) {
			$this->assertTrue( true );
			return;
		}

		if ( ! is_network_admin() ) {
			// Do nothing when we're not in network admin mode.
			$this->assertTrue( true );
			return;
		}

		$test_obj = $this;

		// This activates network wide, for all sites that exist at the time.
		FontAwesome_Activator::initialize();

		// Now create a new network.
		$new_network_id = add_network();

		// Switch to it.
		\switch_to_network( $new_network_id );

		FontAwesome_Release_Provider::reset();

		// This should not throw an exception, despite switching networks.
		$ver = fa()->latest_version_6();
		$this->assertEquals( $ver, '6.1.1' );

		$expected_options = array_merge( FontAwesome::DEFAULT_USER_OPTIONS, array( 'version' => fa()->latest_version_6() ) );
		$this->assertEquals( $expected_options, fa()->options() );
	}
}

<?php
namespace FortAwesome;

require_once __DIR__ . '/../font-awesome-init.php';
require_once __DIR__ . '/../includes/class-fontawesome-activator.php';
require_once __DIR__ . '/../includes/class-fontawesome-exception.php';
require_once __DIR__ . '/_support/font-awesome-phpunit-util.php';
require_once __DIR__ . '/../includes/class-fontawesome-svg-styles-manager.php';

use Yoast\WPTestUtils\WPIntegration\TestCase;

/**
 * Class MultisiteActivationTest
 */
class MultisiteActivationTest extends TestCase {
	protected $sub_sites        = array();
	protected $original_blog_id = null;

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

		$this->original_blog_id = get_current_blog_id();

		reset_db();
		remove_all_actions( 'font_awesome_preferences' );
		remove_all_filters( 'wp_is_large_network' );
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

		uopz_set_return(
			FontAwesome_SVG_Styles_Manager::class,
			'fetch_svg_styles',
			null
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

		switch_to_blog( $this->original_blog_id );

		foreach ( $this->sub_sites as $blog_id ) {
			wp_delete_site( $blog_id );
		}

		uopz_unset_return( FontAwesome_SVG_Styles_Manager::class, 'fetch_svg_styles' );
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

		$fetch_svg_styles_call_count = 0;

		uopz_set_return(
			FontAwesome_SVG_Styles_Manager::class,
			'fetch_svg_styles',
			function () use ( &$fetch_svg_styles_call_count ) {
				$fetch_svg_styles_call_count++;
			},
			true
		);

		if ( is_network_admin() ) {
			FontAwesome_Activator::initialize();
			$site_count       = 0;
			$test_obj         = $this;
			$expected_options = array_merge( FontAwesome::DEFAULT_USER_OPTIONS, array( 'version' => fa()->latest_version_7() ) );

			for_each_blog(
				function () use ( $test_obj, $expected_options, &$site_count ) {
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
			$this->assertTrue( $fetch_svg_styles_call_count > 0 );
		} else {
			$this->assertEquals( count( $this->sub_sites ), 2 );

			// Only activate on the second sub-site.
			switch_to_blog( $this->sub_sites[1] );

			FontAwesome_Activator::initialize();
			$expected_options = array_merge( FontAwesome::DEFAULT_USER_OPTIONS, array( 'version' => fa()->latest_version_7() ) );

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
			$this->assertTrue( $fetch_svg_styles_call_count > 0 );
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

		$expected_options = array_merge( FontAwesome::DEFAULT_USER_OPTIONS, array( 'version' => fa()->latest_version_7() ) );

		/**
		 * We'll first, separately ensure that the options are initialized on the main site,
		 * because it seems that in some runtime environments, the main site is not being
		 * activated even when the sub-sites are.
		 */
		$this->assertEquals( $expected_options, $options_for_main_blog_id );

		for_each_blog(
			function () use ( $test_obj, $expected_options ) {
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
			function ( $site ) {
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
			function ( $blog_id ) use ( &$visited_blog_ids ) {
				array_push( $visited_blog_ids, $blog_id );
			}
		);

		sort( $visited_blog_ids );

		$this->assertEquals( $all_site_blog_ids, $visited_blog_ids );
	}
}

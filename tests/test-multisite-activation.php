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
	protected $_sub_sites = array();

	public function set_up() {
		parent::set_up();

		if ( ! is_multisite() ) {
			throw new \Exception();
		}

		reset_db();
		remove_all_actions( 'font_awesome_preferences' );
		FontAwesome::reset();
		( new Mock_FontAwesome_Metadata_Provider() )->mock(
			array(
				wp_json_encode(
					array(
						'data' => graphql_releases_query_fixture(),
					)
				),
			)
		);

		foreach( ['alpha.example.com', 'beta.example.com'] as $domain ) {
			$site_id = wp_insert_site( [ 'domain' => $domain ] );

			if ( is_wp_error( $site_id ) ) {
				throw new \Exception();
			}

			array_push( $this->_sub_sites, $site_id );
		}
	}

	public function tear_down() {
		parent::tear_down();

		foreach( $this->_sub_sites as $site_id ) {
			wp_delete_site( $site_id );
		}
	}

	public function test_multisite_activation() {
		if ( is_network_admin() ) {
			FontAwesome_Activator::initialize();
			$site_count = 0;
			$test_obj = $this;
			$expected_options = array_merge( FontAwesome::DEFAULT_USER_OPTIONS, array( 'version' => fa()->latest_version() ) );

			for_each_blog( function( $blog_id ) use ( $test_obj, $expected_options, &$site_count ) {
				$site_count = $site_count + 1;
				$actual_options = get_option( FontAwesome::OPTIONS_KEY );
				$test_obj->assertEquals( $expected_options, $actual_options );

				$test_obj->assertEquals(
					FontAwesome::DEFAULT_CONFLICT_DETECTION_OPTIONS,
					get_option( FontAwesome::CONFLICT_DETECTION_OPTIONS_KEY )
				);
			});

			$this->assertEquals( $site_count, 3 );
		} else {
			$this->assertEquals( count( $this->_sub_sites ), 2 );

			// Only activate on the second sub-site.
			switch_to_blog( $this->_sub_sites[1] );

			FontAwesome_Activator::initialize();
			$expected_options = array_merge( FontAwesome::DEFAULT_USER_OPTIONS, array( 'version' => fa()->latest_version() ) );

			// It is active there on the second sub-site.
			$this->assertEquals( $expected_options, get_option( FontAwesome::OPTIONS_KEY ) );

			// The first sub-site will not have been initialized.
			switch_to_blog( $this->_sub_sites[0] );
			$this->assertFalse( boolval( get_option( FontAwesome::OPTIONS_KEY ) ) );

			// The main site will not have been initialized.
			switch_to_blog( get_main_site_id() );
			$this->assertFalse( boolval( get_option( FontAwesome::OPTIONS_KEY ) ) );

			// The network wide release metadata will have been initialized.
			$this->assertTrue( boolval( get_network_option( get_main_network_id(), FontAwesome_Release_Provider::OPTIONS_KEY ) ) );
		}
	}
}

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
use Yoast\WPTestUtils\WPIntegration\TestCase;

class RegisterTest extends TestCase {

	public function set_up() {
		parent::set_up();
		reset_db();
		FontAwesome::reset();
		(new Mock_FontAwesome_Metadata_Provider())->mock(
			array(
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
		FontAwesome_Activator::activate();
	}

	public function test_register_without_name() {
		$this->expectException( ClientPreferencesSchemaException::class );

		fa()->register(
			array(
				'technology' => 'svg',
				'compat' => true
			)
		);
	}

	public function test_duplicate_client_registry() {
		fa()->register(
			array(
				'name'   => 'test',
				'technology' => 'svg',
				'compat' => true,
			)
		);
		fa()->register(
			array(
				'name'   => 'test',
				'technology' => 'svg',
				'compat' => true,
			)
		);

		$registered_test_clients = array_filter(fa()->client_preferences(), function( $client ) { return 'test' === $client['name']; });
		$this->assertEquals( 1, count( $registered_test_clients ) );
	}

	public function test_v4_compat_translated_to_compat() {
		fa()->register(
			array(
				'name'   => 'test',
				'technology' => 'svg',
				'v4Compat' => true,
			)
		);

		$registered_test_clients = array_filter(fa()->client_preferences(), function( $client ) { return 'test' === $client['name']; });
		$this->assertEquals( 1, count( $registered_test_clients ) );
		$this->assertTrue( array_key_exists( 'compat', $registered_test_clients['test'] ) );
		$this->assertTrue( $registered_test_clients['test']['compat'] );
	}

	// If a client specifies both, they must have the same value.
	public function test_v4_compat_and_compat_must_be_equal() {
		fa()->register(
			array(
				'name'   => 'test',
				'technology' => 'svg',
				'v4Compat' => true,
				'compat' => true,
			)
		);

		$registered_test_clients = array_filter(fa()->client_preferences(), function( $client ) { return 'test' === $client['name']; });
		$this->assertEquals( 1, count( $registered_test_clients ) );
		$this->assertTrue( array_key_exists( 'compat', $registered_test_clients['test'] ) );
		$this->assertTrue( $registered_test_clients['test']['compat'] );

		// If they differ, it's an exception.
		$this->expectException( ClientPreferencesSchemaException::class );
		fa()->register(
			array(
				'name'   => 'test2',
				'technology' => 'svg',
				'v4Compat' => false,
				'compat' => true,
			)
		);
	}

	public function test_compat_may_be_false() {
		fa()->register(
			array(
				'name'   => 'test',
				'technology' => 'svg',
				'compat' => false,
			)
		);

		$registered_test_clients = array_filter(fa()->client_preferences(), function( $client ) { return 'test' === $client['name']; });
		$this->assertEquals( 1, count( $registered_test_clients ) );
		$this->assertTrue( array_key_exists( 'compat', $registered_test_clients['test'] ) );
		$this->assertFalse( $registered_test_clients['test']['compat'] );

		fa()->register(
			array(
				'name'   => 'test2',
				'technology' => 'svg',
				'v4Compat' => false,
			)
		);

		$registered_test_clients = array_filter(fa()->client_preferences(), function( $client ) { return 'test2' === $client['name']; });
		$this->assertEquals( 1, count( $registered_test_clients ) );
		$this->assertTrue( array_key_exists( 'compat', $registered_test_clients['test2'] ) );
		$this->assertFalse( $registered_test_clients['test2']['compat'] );
	}

	public function client_preference_exists( $name, $prefs ) {
		$found = false;
		foreach ( $prefs as $pref ) {
			if ( $name === $pref['name'] ) {
				$found = true;
				break;
			}
		}
		return $found;
	}

	// TODO: test where the ReleaseProvider would return a null integrity key, both for webfont and svg.
}

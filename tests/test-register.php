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

class RegisterTest extends \WP_UnitTestCase {

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

	public function test_register_without_name() {
		$this->expectException( \InvalidArgumentException::class );

		fa()->register(
			array(
				'technology' => 'svg',
				'v4compat' => true
			)
		);
	}

	public function test_duplicate_client_registry() {
		fa()->register(
			array(
				'name'   => 'test',
				'technology' => 'svg',
				'v4compat' => true,
			)
		);
		fa()->register(
			array(
				'name'   => 'test',
				'technology' => 'svg',
				'v4compat' => true,
			)
		);

		$registered_test_clients = array_filter(fa()->client_preferences(), function( $client ) { return 'test' === $client['name']; });
		$this->assertEquals( 1, count( $registered_test_clients ) );
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

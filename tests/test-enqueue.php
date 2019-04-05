<?php
namespace FortAwesome;
/**
 * Class EnqueueTest
 *
 * @noinspection PhpCSValidationInspection
 */
// phpcs:ignoreFile Squiz.Commenting.ClassComment.Missing
// phpcs:ignoreFile Generic.Commenting.DocComment.MissingShort
require_once dirname( __FILE__ ) . '/../includes/class-fontawesome-activator.php';
require_once dirname( __FILE__ ) . '/../includes/class-fontawesome-resourcecollection.php';
require_once dirname( __FILE__ ) . '/_support/font-awesome-phpunit-util.php';

class EnqueueTest extends \WP_UnitTestCase {

	public function setUp() {
		reset_db();
		FontAwesome::reset();
		Mock_FontAwesome_Releases::mock();
		wp_script_is( 'font-awesome', 'enqueued' ) && wp_dequeue_script( 'font-awesome' );
		wp_script_is( 'font-awesome-v4shim', 'enqueued' ) && wp_dequeue_script( 'font-awesome-v4shim' );
		wp_style_is( 'font-awesome', 'enqueued' ) && wp_dequeue_style( 'font-awesome' );
		wp_style_is( 'font-awesome-v4shim', 'enqueued' ) && wp_dequeue_style( 'font-awesome-v4shim' );
		FontAwesome_Activator::activate();
	}

	public function test_default_options() {
		$options = FontAwesome::DEFAULT_USER_OPTIONS;

		$latest_version = '5.2.0';

		$resource_collection = new FontAwesome_ResourceCollection( '5.2.0', [
			new FontAwesome_Resource(
				"https://use.fontawesome.com/releases/v${latest_version}/css/all.css",
				'sha384-fake123'
			),
			new FontAwesome_Resource(
				"https://use.fontawesome.com/releases/v${latest_version}/css/v4-shims.css",
				'sha384-fake246'
			),
		]);

		fa()->enqueue( $options, $resource_collection );

		do_action('wp_enqueue_scripts');

		$this->assertTrue( wp_style_is( FontAwesome::RESOURCE_HANDLE, 'enqueued' ) );
		$this->assertTrue( wp_style_is( FontAwesome::RESOURCE_HANDLE_V4SHIM, 'enqueued' ) );
		$this->assertEquals(fa()->version(), $latest_version);
		$this->assertEquals(fa()->technology(), 'webfont');
		$this->assertTrue(fa()->v4_compatibility());
	}
}

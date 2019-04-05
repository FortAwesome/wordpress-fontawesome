<?php
namespace FortAwesome;
/**
 * Class EnqueueTest
 *
 * Apparently, it's necessary to use the runTestsInSeparateProcesses annotation. Otherwise, the output buffering
 * seems to get confused between the tests, resulting in false negatives.
 * And since doing this normally involves serializing global data between parent and child processes, which doesn't
 * work in our case (singletons?), we also need to use preserverGlobalState disabled.
 *
 * @preserveGlobalState disabled
 * @runTestsInSeparateProcesses
 * @noinspection PhpCSValidationInspection
 */
// phpcs:ignoreFile Squiz.Commenting.ClassComment.Missing
// phpcs:ignoreFile Generic.Commenting.DocComment.MissingShort
require_once dirname( __FILE__ ) . '/../includes/class-fontawesome-activator.php';
require_once dirname( __FILE__ ) . '/../includes/class-fontawesome-resourcecollection.php';
require_once dirname( __FILE__ ) . '/_support/font-awesome-phpunit-util.php';

class EnqueueTest extends \WP_UnitTestCase {

	const OUTPUT_MATCH_FAILURE_MESSAGE = 'Failed output match.';

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

	protected function captureOutput() {
		/**
		 * For some reason the expectOutputRegex feature of PHPUnit is resulting in false positives, so we'll
		 * handle output buffering and matching ourselves here.
		 */
		ob_start();
		wp_head(); // generates the output
		return ob_get_clean();
	}

	public function test_default_options() {
		$options = FontAwesome::DEFAULT_USER_OPTIONS;

		$version = '5.2.0';

		$resource_collection = new FontAwesome_ResourceCollection( $version, [
			new FontAwesome_Resource(
				"https://use.fontawesome.com/releases/v${version}/css/all.css",
				'sha384-fake123'
			),
			new FontAwesome_Resource(
				"https://use.fontawesome.com/releases/v${version}/css/v4-shims.css",
				'sha384-fake246'
			),
		]);

		fa()->enqueue_cdn( $options, $resource_collection );

		do_action('wp_enqueue_scripts');

		$this->assertTrue( wp_style_is( FontAwesome::RESOURCE_HANDLE, 'enqueued' ) );
		$this->assertTrue( wp_style_is( FontAwesome::RESOURCE_HANDLE_V4SHIM, 'enqueued' ) );

		$output = $this->captureOutput();

		// Make sure the main css looks right.
		$this->assertTrue(
			boolval(
				preg_match(
					'/<link[\s]+rel=\'stylesheet\'[\s]+id=\'font-awesome-official-css\'[\s]+href=\'https:\/\/use\.fontawesome\.com\/releases\/v5\.2\.0\/css\/all\.css\'[\s]+type=\'text\/css\'[\s]+media=\'all\'[\s]+integrity="sha384-fake123"[\s]+crossorigin="anonymous"[\s]*\/>/',
					$output
				)
			),
			self::OUTPUT_MATCH_FAILURE_MESSAGE
		);

		// Make sure the v4shim css looks right.
		$this->assertTrue(
			boolval(
				preg_match(
					'/<link[\s]+rel=\'stylesheet\'[\s]+id=\'font-awesome-official-v4shim-css\'[\s]+href=\'https:\/\/use\.fontawesome\.com\/releases\/v5\.2\.0\/css\/v4-shims\.css\'[\s]+type=\'text\/css\'[\s]+media=\'all\'[\s]+integrity="sha384-fake246"[\s]+crossorigin="anonymous"[\s]*\/>/',
					$output
				)
			),
			self::OUTPUT_MATCH_FAILURE_MESSAGE
		);

		// Make sure the font-face overrides are present.
		$this->assertTrue(
			boolval(
				preg_match(
					"/<style.*?>\n@font-face {\n.*?font-family: \"FontAwesome\";\n[\s]+src: url.*?${version}\/webfonts\/fa-brands-400\.eot/",
					$output
				)
			),
			self::OUTPUT_MATCH_FAILURE_MESSAGE
		);

		// Make sure the font-face overrides are present only once.
		$this->assertFalse(
			boolval(
				preg_match(
					"/(@font-face {\n.*?font-family: \"FontAwesome\";\n[\s]+src: url.*?${version}\/webfonts\/fa-brands-400\.eot).*?\\1/",
					$output
				)
			),
			self::OUTPUT_MATCH_FAILURE_MESSAGE
		);

		// Make sure that the order is right: main css, followed by v4shim css, followed by font-face overrides.
		$this->assertTrue(
			boolval(
				preg_match(
					"/<link.+?font-awesome-official-css.+?>.+?<link.+?font-awesome-official-v4shim-css.*?font-face {\n.*?font-family: \"FontAwesome\"/s",
					$output
				)
			),
			self::OUTPUT_MATCH_FAILURE_MESSAGE
		);
	}
}

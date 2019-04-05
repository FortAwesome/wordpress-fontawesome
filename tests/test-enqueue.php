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

	const MOCK_LATEST_VERSION = '5.2.0';

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

	public function build_mock_resource_collection($options) {
		$version = ( 'latest' === $options['version'] ) ? self::MOCK_LATEST_VERSION : $options['version'];

		$license_subdomain = boolval( $options['usePro'] ) ? 'pro' : 'use';

		$technology_path_part = boolval( $options['technology'] === 'svg' ) ? 'js' : 'css';

		$resources = [
			new FontAwesome_Resource(
				"https://${license_subdomain}.fontawesome.com/releases/v${version}/${technology_path_part}/all.${technology_path_part}",
				'sha384-fake123'
			)
		];

		if( boolval( $options['v4compat'] ) ) {
			array_push(
				$resources,
				new FontAwesome_Resource(
					"https://${license_subdomain}.fontawesome.com/releases/v${version}/${technology_path_part}/v4-shims.${technology_path_part}",
					'sha384-fake246'
				)
			);
		}

		return new FontAwesome_ResourceCollection( $version, $resources );
	}

	public function assert_webfont($output, $license_subdomain, $version) {
		$this->assertEquals(
			1,
			preg_match(
				"/<link[\s]+rel=\'stylesheet\'[\s]+id=\'font-awesome-official-css\'[\s]+href=\'https:\/\/${license_subdomain}\.fontawesome\.com\/releases\/v${version}\/css\/all\.css\'[\s]+type=\'text\/css\'[\s]+media=\'all\'[\s]+integrity=\"sha384-fake123\"[\s]+crossorigin=\"anonymous\"[\s]*\/>/",
				$output
			),
			self::OUTPUT_MATCH_FAILURE_MESSAGE
		);
	}

	public function assert_webfont_v4shim($output, $license_subdomain, $version, $refute = false){
		$this->assertEquals(
			$refute ? 0 : 1,
			preg_match(
				"/<link[\s]+rel=\'stylesheet\'[\s]+id=\'font-awesome-official-v4shim-css\'[\s]+href=\'https:\/\/${license_subdomain}\.fontawesome\.com\/releases\/v${version}\/css\/v4-shims\.css\'[\s]+type=\'text\/css\'[\s]+media=\'all\'[\s]+integrity=\"sha384-fake246\"[\s]+crossorigin=\"anonymous\"[\s]*\/>/",
				$output
			),
			self::OUTPUT_MATCH_FAILURE_MESSAGE
		);
	}

	public function refute_webfont_v4shim($output, $license_subdomain, $version ) {
		$this->assert_webfont_v4shim($output, $license_subdomain, $version, true);
	}

	public function assert_font_face_overrides($output, $license_subdomain, $version, $refute = false){
		$font_face_match_count = preg_match_all(
			"/@font-face {\n.*?font-family: \"FontAwesome\";\n[\s]+src: url\(\"https:\/\/${license_subdomain}\.fontawesome\.com.*?${version}\/webfonts\/fa-brands-400\.eot\"/",
			$output,
			$font_face_matches
		);

		// Make sure the font-face overrides are present.
		$this->assertEquals(
			$refute ? 0 : 1,
			$font_face_match_count,
			self::OUTPUT_MATCH_FAILURE_MESSAGE
		);
	}

	public function refute_font_face_overrides($output, $license_subdomain, $version){
		$this->assert_font_face_overrides($output, $license_subdomain, $version, true);
	}

	public function assert_webfont_v4_compatibility_load_order($output){
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

	public function test_default_options() {
		$options = FontAwesome::DEFAULT_USER_OPTIONS;

		$resource_collection = $this->build_mock_resource_collection( $options );

		$version = $resource_collection->version();

		fa()->enqueue_cdn( $options, $resource_collection );

		$output = $this->captureOutput();

		$this->assertTrue( wp_style_is( FontAwesome::RESOURCE_HANDLE, 'enqueued' ) );
		$this->assertTrue( wp_style_is( FontAwesome::RESOURCE_HANDLE_V4SHIM, 'enqueued' ) );

		$this->assert_webfont( $output, 'use', $version );
		$this->assert_webfont_v4shim( $output, 'use', $version );
		$this->assert_font_face_overrides( $output, 'use', $version );
		$this->assert_webfont_v4_compatibility_load_order($output);
	}

	public function test_webfont_without_v4_compat() {
		$options = wp_parse_args( ['v4compat' => false], FontAwesome::DEFAULT_USER_OPTIONS);

		$resource_collection = $this->build_mock_resource_collection( $options );

		$version = $resource_collection->version();

		fa()->enqueue_cdn( $options, $resource_collection );

		$output = $this->captureOutput();

		$this->assertTrue( wp_style_is( FontAwesome::RESOURCE_HANDLE, 'enqueued' ) );
		$this->assertFalse( wp_style_is( FontAwesome::RESOURCE_HANDLE_V4SHIM, 'enqueued' ) );

		$this->assert_webfont( $output, 'use', $version );
		$this->refute_webfont_v4shim( $output, 'use', $version );
		$this->refute_font_face_overrides( $output, 'use', $version );
	}
}

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
use \DateTime, \DateInterval, \DateTimeInterface, \DateTimeZone;

class EnqueueTest extends \WP_UnitTestCase {

	const OUTPUT_MATCH_FAILURE_MESSAGE = 'Failed output match.';

	const MOCK_LATEST_VERSION = '5.2.0';

	protected $admin_user;

	public function setUp() {
		reset_db();
		FontAwesome::reset();
		Mock_FontAwesome_Releases::mock();
		$this->admin_user = get_users( [ 'role' => 'administrator' ] )[0];
		wp_set_current_user( $this->admin_user->ID, $this->admin_user->user_login );
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

	public function assert_webfont($output, $license_subdomain, $version, $refute = false) {
		$ignore_detection = fa()->detecting_conflicts() ? "data-fa-detection-ignore " : "";
		$this->assertEquals(
			$refute ? 0 : 1,
			preg_match(
				"/<link[\s]+${ignore_detection}[\s]*rel=\'stylesheet\'[\s]+id=\'font-awesome-official-css\'[\s]+href=\'https:\/\/${license_subdomain}\.fontawesome\.com\/releases\/v${version}\/css\/all\.css\'[\s]+type=\'text\/css\'[\s]+media=\'all\'[\s]+integrity=\"sha384-fake123\"[\s]+crossorigin=\"anonymous\"[\s]*\/>/",
				$output
			),
			self::OUTPUT_MATCH_FAILURE_MESSAGE
		);
	}

	public function refute_webfont($output, $license_subdomain, $version){
		$this->assert_webfont($output, $license_subdomain, $version, true);
	}

	public function assert_svg($output, $license_subdomain, $version, $refute = false) {
		$ignore_detection = fa()->detecting_conflicts() ? "data-fa-detection-ignore " : "";
		$this->assertEquals(
			$refute ? 0 : 1,
			preg_match(
				"/<script[\s]+${ignore_detection}[\s]*defer[\s]+crossorigin=\"anonymous\"[\s]+integrity=\"sha384-fake123\"[\s]+type=\'text\/javascript\'[\s]+src=\'https:\/\/${license_subdomain}\.fontawesome\.com\/releases\/v${version}\/js\/all\.js\'><\/script>/",
				$output
			),
			self::OUTPUT_MATCH_FAILURE_MESSAGE
		);
	}

	public function refute_svg($output, $license_subdomain, $version){
		$this->assert_svg($output, $license_subdomain, $version, true);
	}

	public function assert_webfont_v4shim($output, $license_subdomain, $version, $refute = false){
		$ignore_detection = fa()->detecting_conflicts() ? "data-fa-detection-ignore " : "";
		$this->assertEquals(
			$refute ? 0 : 1,
			preg_match(
				"/<link[\s]+${ignore_detection}[\s]*rel=\'stylesheet\'[\s]+id=\'font-awesome-official-v4shim-css\'[\s]+href=\'https:\/\/${license_subdomain}\.fontawesome\.com\/releases\/v${version}\/css\/v4-shims\.css\'[\s]+type=\'text\/css\'[\s]+media=\'all\'[\s]+integrity=\"sha384-fake246\"[\s]+crossorigin=\"anonymous\"\s*\/>/",
				$output
			),
			self::OUTPUT_MATCH_FAILURE_MESSAGE
		);
	}

	public function refute_webfont_v4shim($output, $license_subdomain, $version ) {
		$this->assert_webfont_v4shim($output, $license_subdomain, $version, true);
	}

	public function assert_svg_v4shim($output, $license_subdomain, $version, $refute = false){
		$ignore_detection = fa()->detecting_conflicts() ? "data-fa-detection-ignore " : "";
		$this->assertEquals(
			$refute ? 0 : 1,
			preg_match(
				"/<script[\s]+${ignore_detection}[\s]*defer[\s]+crossorigin=\"anonymous\"[\s]+integrity=\"sha384-fake246\"[\s]+type=\'text\/javascript\'[\s]+src=\'https:\/\/${license_subdomain}\.fontawesome\.com\/releases\/v${version}\/js\/v4-shims\.js\'><\/script>/",
				$output
			),
			self::OUTPUT_MATCH_FAILURE_MESSAGE . "\n\n$output\n\n"
		);
	}

	public function refute_svg_v4shim($output, $license_subdomain, $version){
		$this->assert_svg_v4shim($output, $license_subdomain, $version, true);
	}

	public function assert_font_face_inline_style_detection_ignore($output, $refute = false) {
		$this->assertEquals(
			$refute ? 0 : 1,
			preg_match(
				"/<style[\s]+data-fa-detection-ignore[\s]+id=\'font-awesome-official-v4shim-inline-css\'/",
				$output
			),
			self::OUTPUT_MATCH_FAILURE_MESSAGE
		);
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
		$this->assertEquals(
			1,
			preg_match(
				"/<link.+?font-awesome-official-css.+?>.+?<link.+?font-awesome-official-v4shim-css.*?font-face {\n.*?font-family: \"FontAwesome\"/s",
				$output
			),
			self::OUTPUT_MATCH_FAILURE_MESSAGE
		);
	}

	public function assert_svg_pseudo_elements($output, $refute = false){
		$ignore_detection = fa()->detecting_conflicts() ? "data-fa-detection-ignore " : "";
		$this->assertEquals(
			$refute ? 0 : 1,
			preg_match(
				"/<script\s*${ignore_detection}.*?>\s*.*?searchPseudoElements:\s*true/",
				$output
			),
			self::OUTPUT_MATCH_FAILURE_MESSAGE
		);
	}

	public function refute_svg_pseudo_elements($output) {
		$this->assert_svg_pseudo_elements($output,  true);
	}

	public function test_default_options() {
		$options = fa()->options();

		$resource_collection = $this->build_mock_resource_collection( fa()->options() );

		$version = $resource_collection->version();

		fa()->enqueue_cdn( $options, $resource_collection );

		$output = $this->captureOutput();

		$this->assertTrue( wp_style_is( FontAwesome::RESOURCE_HANDLE, 'enqueued' ) );
		$this->assertTrue( wp_style_is( FontAwesome::RESOURCE_HANDLE_V4SHIM, 'enqueued' ) );

		$this->refute_svg( $output, 'use', $version );
		$this->assert_webfont( $output, 'use', $version );
		$this->assert_webfont_v4shim( $output, 'use', $version );
		$this->assert_font_face_overrides( $output, 'use', $version );
		$this->assert_webfont_v4_compatibility_load_order($output);
	}

	public function test_webfont_without_v4_compat() {
		$options = wp_parse_args( ['v4compat' => false], fa()->options() );

		$resource_collection = $this->build_mock_resource_collection( $options );

		$version = $resource_collection->version();

		fa()->enqueue_cdn( $options, $resource_collection );

		$output = $this->captureOutput();

		$this->assertTrue( wp_style_is( FontAwesome::RESOURCE_HANDLE, 'enqueued' ) );
		$this->assertFalse( wp_style_is( FontAwesome::RESOURCE_HANDLE_V4SHIM, 'enqueued' ) );

		$this->refute_svg( $output, 'use', $version );
		$this->assert_webfont( $output, 'use', $version );
		$this->refute_webfont_v4shim( $output, 'use', $version );
		$this->refute_font_face_overrides( $output, 'use', $version );
	}

	public function test_pro_webfont_non_latest() {
		$options = wp_parse_args(
			['usePro' => true, 'version' => '5.1.1' ],
			fa()->options()
		);

		$resource_collection = $this->build_mock_resource_collection( $options );

		$version = $resource_collection->version();

		fa()->enqueue_cdn( $options, $resource_collection );

		$output = $this->captureOutput();

		$this->assertTrue( wp_style_is( FontAwesome::RESOURCE_HANDLE, 'enqueued' ) );
		$this->assertTrue( wp_style_is( FontAwesome::RESOURCE_HANDLE_V4SHIM, 'enqueued' ) );

		$this->refute_svg( $output, 'pro', $version );
		$this->assert_webfont( $output, 'pro', $version );
		$this->assert_webfont_v4shim( $output, 'pro', $version );
		$this->assert_font_face_overrides( $output, 'pro', $version );
	}

	public function test_svg_default() {
		$options = wp_parse_args(
			[ 'technology' => 'svg' ],
			fa()->options()
		);

		$resource_collection = $this->build_mock_resource_collection( $options );

		$version = $resource_collection->version();

		fa()->enqueue_cdn( $options, $resource_collection );

		$output = $this->captureOutput();

		$this->assertTrue( wp_script_is( FontAwesome::RESOURCE_HANDLE, 'enqueued' ) );
		$this->assertTrue( wp_script_is( FontAwesome::RESOURCE_HANDLE_V4SHIM, 'enqueued' ) );

		$this->refute_webfont( $output, 'use', $version );
		$this->assert_svg( $output, 'use', $version );
		$this->assert_svg_v4shim( $output, 'use', $version );
		$this->refute_svg_pseudo_elements( $output );
	}

	public function test_svg_pro_no_v4_compat_non_default_version() {
		$options = wp_parse_args(
			[ 'technology' => 'svg', 'usePro' => true, 'v4compat' => false, 'version' => '5.1.1' ],
			fa()->options()
		);

		$resource_collection = $this->build_mock_resource_collection( $options );

		$version = $resource_collection->version();

		fa()->enqueue_cdn( $options, $resource_collection );

		$output = $this->captureOutput();

		$this->assertTrue( wp_script_is( FontAwesome::RESOURCE_HANDLE, 'enqueued' ) );
		$this->assertFalse( wp_script_is( FontAwesome::RESOURCE_HANDLE_V4SHIM, 'enqueued' ) );

		$this->refute_webfont( $output, 'pro', $version );
		$this->assert_svg( $output, 'pro', $version );
		$this->refute_svg_v4shim( $output, 'pro', $version );
		$this->refute_svg_pseudo_elements( $output );
	}

	public function test_svg_with_pseudo_elements() {
		$options = wp_parse_args(
			[ 'technology' => 'svg', 'usePro' => true, 'v4compat' => false, 'svgPseudoElements' => true ],
			fa()->options()
		);

		$resource_collection = $this->build_mock_resource_collection( $options );

		$version = $resource_collection->version();

		fa()->enqueue_cdn( $options, $resource_collection );

		$output = $this->captureOutput();

		$this->assertTrue( wp_script_is( FontAwesome::RESOURCE_HANDLE, 'enqueued' ) );
		$this->assertFalse( wp_script_is( FontAwesome::RESOURCE_HANDLE_V4SHIM, 'enqueued' ) );

		$this->refute_webfont( $output, 'pro', $version );
		$this->assert_svg( $output, 'pro', $version );
		$this->refute_svg_v4shim( $output, 'pro', $version );
		$this->assert_svg_pseudo_elements( $output );
	}

	public function test_conflict_detector_enqueued_when_enabled_svg() {
		$now = new DateTime('now', new DateTimeZone('UTC'));
		// ten minutes later
		$later = $now->add(new DateInterval('PT10M'));

		update_option(
			FontAwesome::OPTIONS_KEY,
			array_merge(
				FontAwesome::DEFAULT_USER_OPTIONS,
				array(
					'detectConflictsUntil' => $later->format(DateTimeInterface::ATOM)
				)
			)
		);

		$options = wp_parse_args(
			[ 'technology' => 'svg', 'version' => '5.1.1', 'v4compat' => true, 'svgPseudoElements' => true ],
			fa()->options()
		);
		$resource_collection = $this->build_mock_resource_collection( $options );
		$version = $resource_collection->version();

		fa()->enqueue_cdn( $options, $resource_collection );

		$output = $this->captureOutput();

		$this->assertTrue( wp_script_is( FontAwesome::RESOURCE_HANDLE_CONFLICT_DETECTOR, 'enqueued' ) );

		$this->assert_svg( $output, 'use', $version );
		$this->assert_svg_pseudo_elements( $output );
		$this->assert_svg_v4shim( $output, 'use', $version );
	}

	public function test_conflict_detector_enqueued_when_enabled_webfont() {
		$now = new DateTime('now', new DateTimeZone('UTC'));
		// ten minutes later
		$later = $now->add(new DateInterval('PT10M'));

		update_option(
			FontAwesome::OPTIONS_KEY,
			array_merge(
				FontAwesome::DEFAULT_USER_OPTIONS,
				array(
					'detectConflictsUntil' => $later->format(DateTimeInterface::ATOM)
				)
			)
		);

		$options = wp_parse_args(
			[ 'version' => '5.1.1', 'v4compat' => true ],
			fa()->options()
		);
		$resource_collection = $this->build_mock_resource_collection( $options );
		$version = $resource_collection->version();

		fa()->enqueue_cdn( $options, $resource_collection );

		$output = $this->captureOutput();

		$this->assertTrue( wp_script_is( FontAwesome::RESOURCE_HANDLE_CONFLICT_DETECTOR, 'enqueued' ) );

		$this->assert_webfont( $output, 'use', $version );
		$this->assert_webfont_v4shim( $output, 'use', $version );

		/**
		 * We do not test the v4 font face shim inline style has the detection ignore
		 * attr, since we can't filter the inline style tag.
		 * 
		 * (Probably we'll have a separate mechanism for ignoring that, if the
		 * conflict detector reports it.)
		 */
	}
}

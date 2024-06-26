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
 * @group output
 */
// phpcs:ignoreFile Squiz.Commenting.ClassComment.Missing
// phpcs:ignoreFile Generic.Commenting.DocComment.MissingShort
require_once dirname( __FILE__ ) . '/../includes/class-fontawesome-activator.php';
require_once dirname( __FILE__ ) . '/../includes/class-fontawesome-resourcecollection.php';
require_once dirname( __FILE__ ) . '/_support/font-awesome-phpunit-util.php';
use \DateTime, \DateInterval, \DateTimeInterface, \DateTimeZone;
use Yoast\WPTestUtils\WPIntegration\TestCase;

class EnqueueTest extends TestCase {

	const OUTPUT_MATCH_FAILURE_MESSAGE = 'Failed output match.';

	const MOCK_LATEST_VERSION = '6.1.1';

	protected $admin_user;

	public function set_up() {
		parent::set_up();
		reset_db();
		remove_all_actions( 'font_awesome_preferences' );
		(new Mock_FontAwesome_Metadata_Provider())->mock(
			array(
				wp_json_encode(
					array(
						'data' => graphql_releases_query_fixture(),
					)
				)
			)
		);
		FontAwesome_Release_Provider::load_releases();
		FontAwesome_Release_Provider::reset();
		FontAwesome::reset();
		$this->admin_user = get_users( [ 'role' => 'administrator' ] )[0];
		wp_set_current_user( $this->admin_user->ID, $this->admin_user->user_login );
		wp_script_is( 'font-awesome', 'enqueued' ) && wp_dequeue_script( 'font-awesome' );
		wp_script_is( 'font-awesome-v4shim', 'enqueued' ) && wp_dequeue_script( 'font-awesome-v4shim' );
		wp_style_is( 'font-awesome', 'enqueued' ) && wp_dequeue_style( 'font-awesome' );
		wp_style_is( 'font-awesome-v4shim', 'enqueued' ) && wp_dequeue_style( 'font-awesome-v4shim' );
		delete_option( FontAwesome::OPTIONS_KEY );
		FontAwesome_Activator::activate();
	}

	public function build_mock_resource_collection($options) {
		$version = ( 'latest' === $options['version'] ) ? self::MOCK_LATEST_VERSION : $options['version'];

		$license_subdomain = boolval( $options['usePro'] ) ? 'pro' : 'use';

		$technology_path_part = boolval( $options['technology'] === 'svg' ) ? 'js' : 'css';

		$resources = array();

		$resources['all'] = new FontAwesome_Resource(
			"https://{$license_subdomain}.fontawesome.com/releases/v{$version}/{$technology_path_part}/all.{$technology_path_part}",
			'sha384-fake123'
		);

		if( boolval( $options['compat'] ) ) {
			$resources['v4-shims'] = new FontAwesome_Resource(
				"https://{$license_subdomain}.fontawesome.com/releases/v{$version}/{$technology_path_part}/v4-shims.{$technology_path_part}",
				'sha384-fake246'
			);
		}

		return new FontAwesome_ResourceCollection( $version, $resources );
	}

	public function assert_webfont($output, $license_subdomain, $version, $refute = false) {
		$ignore_detection = fa()->detecting_conflicts() ? "data-fa-detection-ignore " : "";
		$this->assertEquals(
			$refute ? 0 : 1,
			preg_match(
				"/<link[\s]+{$ignore_detection}[\s]*rel=\'stylesheet\'[\s]+id=\'font-awesome-official-css\'[\s]+href=\'https:\/\/{$license_subdomain}\.fontawesome\.com\/releases\/v{$version}\/css\/all\.css\'[\s]+type=\'text\/css\'[\s]+media=\'all\'[\s]+integrity=\"sha384-fake123\"[\s]+crossorigin=\"anonymous\"[\s]*\/>/",
				$output
			),
			self::OUTPUT_MATCH_FAILURE_MESSAGE
		);
	}

	public function refute_webfont($output, $license_subdomain, $version){
		$this->assert_webfont($output, $license_subdomain, $version, true);
	}

	public function assert_svg($output, $license_subdomain, $version, $refute = false) {
		$match_result = match_all(
			"/<script(?P<attrs>.*?all\.js.*?)><\/script>/",
			$output
		);

		if ( $refute ) {
		  $this->assertEquals( $match_result->match_count(), 0, 'expected zero matching script tags');
		  return;
		}

		$this->assertEquals( $match_result->match_count(), 1, 'expected exactly one matching script tag');

		$attrs = parse_attrs($match_result->matches()['attrs'][0]);

		if ( fa()->detecting_conflicts() ) {
			$this->assertEquals( 1, $attrs['data-fa-detection-ignore'] );
		} else {
			$this->assertFalse( array_key_exists( 'data-fa-detection-ignore', $attrs ) );
		}

		$this->assertEquals('"anonymous"', $attrs['crossorigin']);
		$this->assertEquals('"sha384-fake123"', $attrs['integrity']);
		$this->assertTrue( array_key_exists( 'defer', $attrs ) );
		$this->assertEquals('"text/javascript"', $attrs['type']);
		$expected_src = "\"https://$license_subdomain.fontawesome.com/releases/v$version/js/all.js\"";
		$actual_src = $attrs['src'];
		$this->assertEquals(
			$expected_src,
			$actual_src
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
				"/<link[\s]+{$ignore_detection}[\s]*rel=\'stylesheet\'[\s]+id=\'font-awesome-official-v4shim-css\'[\s]+href=\'https:\/\/{$license_subdomain}\.fontawesome\.com\/releases\/v{$version}\/css\/v4-shims\.css\'[\s]+type=\'text\/css\'[\s]+media=\'all\'[\s]+integrity=\"sha384-fake246\"[\s]+crossorigin=\"anonymous\"\s*\/>/",
				$output
			),
			self::OUTPUT_MATCH_FAILURE_MESSAGE
		);
	}

	public function refute_webfont_v4shim($output, $license_subdomain, $version ) {
		$this->assert_webfont_v4shim($output, $license_subdomain, $version, true);
	}

	public function assert_svg_v4shim($output, $license_subdomain, $version, $refute = false){
		$match_result = match_all(
			"/<script(?P<attrs>.*?v4-shims\.js.*?)><\/script>/",
			$output
		);

		if ( $refute ) {
		  $this->assertEquals( $match_result->match_count(), 0, 'expected zero matching script tags');
		  return;
		}

		$this->assertEquals( $match_result->match_count(), 1, 'expected exactly one matching script tag');

		$attrs = parse_attrs($match_result->matches()['attrs'][0]);

		if ( fa()->detecting_conflicts() ) {
			$this->assertEquals( 1, $attrs['data-fa-detection-ignore'] );
		} else {
			$this->assertFalse( array_key_exists( 'data-fa-detection-ignore', $attrs ) );
		}

		$this->assertEquals('"anonymous"', $attrs['crossorigin']);
		$this->assertEquals('"sha384-fake246"', $attrs['integrity']);
		$this->assertTrue( array_key_exists( 'defer', $attrs ) );
		$this->assertEquals('"text/javascript"', $attrs['type']);
		$expected_src = "\"https://$license_subdomain.fontawesome.com/releases/v$version/js/v4-shims.js\"";
		$actual_src = $attrs['src'];
		$this->assertEquals(
			$expected_src,
			$actual_src
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
			"/@font-face {\n.*?font-family: \"FontAwesome\";\n.*?font-display: block;\n[\s]*src: url\(\"https:\/\/{$license_subdomain}\.fontawesome\.com.*?{$version}\/webfonts\/fa-brands-400\.eot\"/",
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

	public function assert_webfont_compatibility_load_order_legacy_font_face($output){
		$this->assertEquals(
			1,
			preg_match(
				"/<link.+?font-awesome-official-css.+?>.+?<link.+?font-awesome-official-v4shim-css.*?font-face {\n.*?font-family: \"FontAwesome\"/s",
				$output
			),
			self::OUTPUT_MATCH_FAILURE_MESSAGE
		);
	}

	public function assert_webfont_compatibility_load_order_font_face_assets($output){
		$this->assertEquals(
			1,
			preg_match(
				"/<link.+?font-awesome-official-css.+?>.+?<link.+?font-awesome-official-v4shim-css/s",
				$output
			),
			self::OUTPUT_MATCH_FAILURE_MESSAGE
		);
	}

	public function assert_pseudo_elements($output, $refute = false){
		$match_result = match_all(
			"/<script.*?>.*?searchPseudoElements:\s*true.*?<\/script>/s",
			$output
		);

		if ( $refute ) {
			$this->assertEquals(
				0,
				$match_result->match_count(),
				"expected no matches of script tags setting searchPseudoElements to true, but found at least one"
			);
		} else {
			$this->assertEquals(
				1,
				$match_result->match_count(),
				"expected exactly one match of script tags setting searchPseudoElements to true, but found none."
			);
		}
	}

	public function refute_pseudo_elements($output) {
		$this->assert_pseudo_elements($output,  true);
	}

	public function test_default_options() {
		$options = fa()->options();

		$resource_collection = $this->build_mock_resource_collection( fa()->options() );

		$version = $resource_collection->version();

		fa()->enqueue_cdn( $options, $resource_collection );

		$this->expectOutputRegex("/awesome/");
		wp_head(); // generates the output

		$output = $this->getActualOutput();

		$this->assertTrue( wp_style_is( FontAwesome::RESOURCE_HANDLE, 'enqueued' ) );
		$this->assertTrue( wp_style_is( FontAwesome::RESOURCE_HANDLE_V4SHIM, 'enqueued' ) );

		$this->refute_svg( $output, 'use', $version );
		$this->assert_webfont( $output, 'use', $version );
		$this->assert_webfont_v4shim( $output, 'use', $version );
		/**
		 * This refutation should be present because this plugin does not add its own font face overrides
		 * for v6. They're built into the standard v6 CSS.
		 */
		$this->refute_font_face_overrides( $output, 'use', $version );
	}

	public function test_webfont_6_0_0_beta3_with_compat() {
		$options = wp_parse_args( ['compat' => true, 'version' => '6.0.0-beta3' ], fa()->options() );

		$resource_collection = $this->build_mock_resource_collection( $options );

		$version = $resource_collection->version();

		fa()->enqueue_cdn( $options, $resource_collection );

		$this->expectOutputRegex("/awesome/");
		wp_head(); // generates the output

		$output = $this->getActualOutput();

		$this->assertTrue( wp_style_is( FontAwesome::RESOURCE_HANDLE, 'enqueued' ) );
		$this->assertTrue( wp_style_is( FontAwesome::RESOURCE_HANDLE_V4SHIM, 'enqueued' ) );

		$this->refute_svg( $output, 'use', $version );
		$this->assert_webfont( $output, 'use', $version );
		$this->assert_webfont_v4shim( $output, 'use', $version );
		// This should be present because it's not necessary for v6.
		$this->refute_font_face_overrides( $output, 'use', $version );
		$this->assert_webfont_compatibility_load_order_font_face_assets($output);
	}

	public function test_webfont_6_0_0_beta3_with_compat_and_conflict_detection() {
		$options = wp_parse_args( ['compat' => true, 'version' => '6.0.0-beta3' ], fa()->options() );

		$now = time();
		// ten minutes later
		$later = $now + (10 * 60);

		update_option(
			FontAwesome::CONFLICT_DETECTION_OPTIONS_KEY,
			array_merge(
				FontAwesome::DEFAULT_CONFLICT_DETECTION_OPTIONS,
				array(
					'detectConflictsUntil' => $later
				)
			)
		);

		$resource_collection = $this->build_mock_resource_collection( $options );

		$version = $resource_collection->version();

		fa()->enqueue_cdn( $options, $resource_collection );

		$this->expectOutputRegex("/awesome/");
		wp_head(); // generates the output

		$output = $this->getActualOutput();

		$this->assertTrue( wp_style_is( FontAwesome::RESOURCE_HANDLE, 'enqueued' ) );
		$this->assertTrue( wp_style_is( FontAwesome::RESOURCE_HANDLE_V4SHIM, 'enqueued' ) );

		$this->refute_svg( $output, 'use', $version );
		$this->assert_webfont( $output, 'use', $version );
		$this->assert_webfont_v4shim( $output, 'use', $version );
		// This should be present because it's not necessary for v6.
		$this->refute_font_face_overrides( $output, 'use', $version );
		$this->assert_webfont_compatibility_load_order_font_face_assets($output);
	}

	public function test_webfont_without_compat() {
		$options = wp_parse_args( ['compat' => false], fa()->options() );

		$resource_collection = $this->build_mock_resource_collection( $options );

		$version = $resource_collection->version();

		fa()->enqueue_cdn( $options, $resource_collection );

		$this->expectOutputRegex("/awesome/");
		wp_head(); // generates the output

		$output = $this->getActualOutput();

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

		$this->expectOutputRegex("/awesome/");
		wp_head(); // generates the output

		$output = $this->getActualOutput();

		$this->assertTrue( wp_style_is( FontAwesome::RESOURCE_HANDLE, 'enqueued' ) );
		$this->assertTrue( wp_style_is( FontAwesome::RESOURCE_HANDLE_V4SHIM, 'enqueued' ) );

		$this->refute_svg( $output, 'pro', $version );
		$this->assert_webfont( $output, 'pro', $version );
		$this->assert_webfont_v4shim( $output, 'pro', $version );
		// This should be present because version is < 6.0.0-beta3
		$this->assert_font_face_overrides( $output, 'pro', $version );
	}

	public function test_svg_default() {
		$options = array_merge(
			FontAwesome::DEFAULT_USER_OPTIONS,
			[
				'technology'     => 'svg',
				'pseudoElements' => false,
				'version'        => '5.3.1'
			]
		);

		$resource_collection = $this->build_mock_resource_collection( $options );

		$version = $resource_collection->version();

		fa()->enqueue_cdn( $options, $resource_collection );

		$this->expectOutputRegex("/awesome/");
		wp_head(); // generates the output

		$output = $this->getActualOutput();

		$this->assertTrue( wp_script_is( FontAwesome::RESOURCE_HANDLE, 'enqueued' ) );
		$this->assertTrue( wp_script_is( FontAwesome::RESOURCE_HANDLE_V4SHIM, 'enqueued' ) );

		$this->refute_webfont( $output, 'use', $version );
		$this->assert_svg( $output, 'use', $version );
		$this->assert_svg_v4shim( $output, 'use', $version );
		$this->refute_pseudo_elements( $output );
	}

	public function test_svg_pro_no_compat_with_pseudo_elements_non_default_version() {
		$options = array_merge(
			FontAwesome::DEFAULT_USER_OPTIONS,
			[
				'technology'     => 'svg',
				'pseudoElements' => true,
				'usePro'         => true,
				'compat'       => false,
				'version'        => '5.1.1'
			]
		);

		$resource_collection = $this->build_mock_resource_collection( $options );

		$version = $resource_collection->version();

		fa()->enqueue_cdn( $options, $resource_collection );

		$this->expectOutputRegex("/awesome/");
		wp_head(); // generates the output

		$output = $this->getActualOutput();

		$this->assertTrue( wp_script_is( FontAwesome::RESOURCE_HANDLE, 'enqueued' ) );
		$this->assertFalse( wp_script_is( FontAwesome::RESOURCE_HANDLE_V4SHIM, 'enqueued' ) );

		$this->refute_webfont( $output, 'pro', $version );
		$this->assert_svg( $output, 'pro', $version );
		$this->refute_svg_v4shim( $output, 'pro', $version );
		$this->assert_pseudo_elements( $output );
	}

	public function test_svg_with_pseudo_elements() {
		$options = wp_parse_args(
			[ 'technology' => 'svg', 'usePro' => true, 'compat' => false, 'pseudoElements' => true ],
			fa()->options()
		);

		$resource_collection = $this->build_mock_resource_collection( $options );

		$version = $resource_collection->version();

		fa()->enqueue_cdn( $options, $resource_collection );

		$this->expectOutputRegex("/awesome/");
		wp_head(); // generates the output

		$output = $this->getActualOutput();

		$this->assertTrue( wp_script_is( FontAwesome::RESOURCE_HANDLE, 'enqueued' ) );
		$this->assertFalse( wp_script_is( FontAwesome::RESOURCE_HANDLE_V4SHIM, 'enqueued' ) );

		$this->refute_webfont( $output, 'pro', $version );
		$this->assert_svg( $output, 'pro', $version );
		$this->refute_svg_v4shim( $output, 'pro', $version );
		$this->assert_pseudo_elements( $output );
	}

	public function test_conflict_detector_enqueued_when_enabled_svg() {
		$now = time();
		// ten minutes later
		$later = $now + (10 * 60);

		update_option(
			FontAwesome::CONFLICT_DETECTION_OPTIONS_KEY,
			array_merge(
				FontAwesome::DEFAULT_CONFLICT_DETECTION_OPTIONS,
				array(
					'detectConflictsUntil' => $later
				)
			)
		);

		$options = wp_parse_args(
			[ 'technology' => 'svg', 'version' => '5.1.1', 'compat' => true, 'pseudoElements' => true ],
			fa()->options()
		);
		$resource_collection = $this->build_mock_resource_collection( $options );
		$version = $resource_collection->version();

		fa()->enqueue_cdn( $options, $resource_collection );

		$this->expectOutputRegex("/awesome/");
		wp_head(); // generates the output

		$output = $this->getActualOutput();

		$this->assertTrue( wp_script_is( FontAwesome::RESOURCE_HANDLE_CONFLICT_DETECTOR, 'enqueued' ) );

		$this->assert_svg( $output, 'use', $version );
		$this->assert_pseudo_elements( $output );
		$this->assert_svg_v4shim( $output, 'use', $version );
	}

	public function test_conflict_detector_enqueued_when_enabled_webfont() {
		$now = time();
		// ten minutes later
		$later = $now + (10 * 60);

		update_option(
			FontAwesome::CONFLICT_DETECTION_OPTIONS_KEY,
			array_merge(
				FontAwesome::DEFAULT_CONFLICT_DETECTION_OPTIONS,
				array(
					'detectConflictsUntil' => $later
				)
			)
		);

		$options = wp_parse_args(
			[ 'version' => '5.1.1', 'compat' => true ],
			fa()->options()
		);
		$resource_collection = $this->build_mock_resource_collection( $options );
		$version = $resource_collection->version();

		fa()->enqueue_cdn( $options, $resource_collection );

		$this->expectOutputRegex("/awesome/");
		wp_head(); // generates the output

		$output = $this->getActualOutput();

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


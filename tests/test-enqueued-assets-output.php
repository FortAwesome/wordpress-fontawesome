<?php
namespace FortAwesome;
/**
 * Class EnqueuedAssetsOutputTest
 *
 * Apparently, it's necessary to use the runTestsInSeparateProcesses annotation. Otherwise, the output buffering
 * seems to get confused between the tests, resulting in false negatives.
 * And since doing this normally involves serializing global data between parent and child processes, which doesn't
 * work in our case (singletons?), we also need to use preserverGlobalState disabled.
 *
 * @noinspection PhpCSValidationInspection
 *
 * @preserveGlobalState disabled
 * @runTestsInSeparateProcesses
 */
// phpcs:ignoreFile Squiz.Commenting.ClassComment.Missing
// phpcs:ignoreFile Generic.Commenting.DocComment.MissingShort
require_once dirname( __FILE__ ) . '/_support/font-awesome-phpunit-util.php';

class EnqueuedAssetsOutputTest extends \WP_UnitTestCase {

	protected $mock_release_provider = null;

	const OUTPUT_MATCH_FAILURE_MESSAGE = 'Failed output match.';

	/**
	 * Not using the other release provider mocking features because have multiple methods to mock at the same time.
	 * Probably means we're due for a refactor on the test utilities here so this doesn't have to be done ad-hoc.
	 */
	public function init_mock_release_provider() {
		$type = FontAwesome_Release_Provider::class;

		$mock_builder = $this->getMockBuilder( FontAwesome_Release_Provider::class )
		                    ->setMethods( [ 'releases', 'get_resource_collection' ] )
		                    ->disableOriginalConstructor();

		$mock = $mock_builder->getMock();

		try {
			$ref = new \ReflectionProperty( $type, 'instance' );
			$ref->setAccessible( true );
			$ref->setValue( null, $mock );
		} catch ( \ReflectionException $e ) {
			// phpcs:ignore WordPress.PHP.DevelopmentFunctions
			error_log( 'Reflection error: ' . $e );
			return null;
		}

		$mock->method( 'releases' )->willReturn( get_mocked_releases() );

		$this->mock_release_provider = $mock;

		return $mock;
    }

	public function setUp() {
		FontAwesome::reset();
		$this->init_mock_release_provider();
		wp_script_is( 'font-awesome', 'enqueued' ) && wp_dequeue_script( 'font-awesome' );
		wp_script_is( 'font-awesome-v4shim', 'enqueued' ) && wp_dequeue_script( 'font-awesome-v4shim' );
		wp_style_is( 'font-awesome', 'enqueued' ) && wp_dequeue_style( 'font-awesome' );
		wp_style_is( 'font-awesome-v4shim', 'enqueued' ) && wp_dequeue_style( 'font-awesome-v4shim' );
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

	/**
	 * @group output
	 */
	public function test_free_webfont_assets_enqueued() {
		$resource_collection = [
			new FontAwesome_Resource(
				'https://use.fontawesome.com/releases/v5.2.0/css/all.css',
				'sha384-fake123'
			),
			new FontAwesome_Resource(
				'https://use.fontawesome.com/releases/v5.2.0/css/v4-shims.css',
				'sha384-fake246'
			),
		];

		$this->mock_release_provider
			->method( 'get_resource_collection' )
			->willReturn( $resource_collection );

		global $fa_load;
		$fa_load->invoke( fa() );

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

		// Make sure that the order is right: main css, followed by v4shim css.
		$this->assertTrue(
			boolval(
				preg_match(
					'/<link.+?font-awesome-official-css.+?>.+?<link.+?font-awesome-official-v4shim-css/s',
					$output
				)
			),
			self::OUTPUT_MATCH_FAILURE_MESSAGE
		);
	}

	/**
	 * @group output
	 */
	public function test_free_svg_assets_enqueued() {
		$resource_collection = [
			new FontAwesome_Resource(
				'https://use.fontawesome.com/releases/v5.2.0/js/all.js',
				'sha384-fake123'
			),
			new FontAwesome_Resource(
				'https://use.fontawesome.com/releases/v5.2.0/js/v4-shims.js',
				'sha384-fake246'
			),
		];

		$this->mock_release_provider
			->method( 'get_resource_collection' )
			->willReturn( $resource_collection );

		add_action(
			'font_awesome_requirements',
			function() {
				fa()->register(
					array(
						'name' => 'test',
						'clientVersion' => '1',
						'method' => 'svg',
						'v4shim' => 'require',
					)
				);
			}
		);

		global $fa_load;
		$fa_load->invoke( fa() );

		$output = $this->captureOutput();

		// Make sure the main <script. looks right.
		$this->assertTrue(
			boolval(
				preg_match(
					'/<script[\s]+defer[\s]+crossorigin="anonymous"[\s]+integrity="sha384-fake123"[\s]+type=\'text\/javascript\'[\s]+src=\'https:\/\/use\.fontawesome\.com\/releases\/v5\.2\.0\/js\/all\.js\'><\/script>/',
					$output
				)
			),
			self::OUTPUT_MATCH_FAILURE_MESSAGE
		);

		// Make sure the v4shim <script> looks right.
		$this->assertTrue(
			boolval(
				preg_match(
					'/<script[\s]+defer[\s]+crossorigin="anonymous"[\s]+integrity="sha384-fake246"[\s]+type=\'text\/javascript\'[\s]+src=\'https:\/\/use\.fontawesome\.com\/releases\/v5\.2\.0\/js\/v4-shims\.js\'><\/script>/',
					$output
				)
			),
			self::OUTPUT_MATCH_FAILURE_MESSAGE
		);

		// Make sure that the order is right: main script, followed by v4shim script.
		$this->assertTrue(
			boolval(
				preg_match(
					'/<script.+?all\.js.+?<script.+?v4-shims\.js/s',
					$output
				)
			),
			self::OUTPUT_MATCH_FAILURE_MESSAGE
		);
	}

	/**
	 * @group pro
	 * @group output
	 */
	public function test_pro_webfont_assets_enqueued() {
		$resource_collection = [
			new FontAwesome_Resource(
				'https://pro.fontawesome.com/releases/v5.2.0/css/all.css',
				'sha384-fake123'
			),
			new FontAwesome_Resource(
				'https://pro.fontawesome.com/releases/v5.2.0/css/v4-shims.css',
				'sha384-fake246'
			),
		];

		$this->mock_release_provider
			->method( 'get_resource_collection' )
			->willReturn( $resource_collection );

		global $fa_load;
		$fa_load->invoke( fa() );

		$output = $this->captureOutput();

		// Make sure the main css looks right.
		$this->assertTrue(
			boolval(
				preg_match(
					'/<link[\s]+rel=\'stylesheet\'[\s]+id=\'font-awesome-official-css\'[\s]+href=\'https:\/\/pro\.fontawesome\.com\/releases\/v5\.2\.0\/css\/all\.css\'[\s]+type=\'text\/css\'[\s]+media=\'all\'[\s]+integrity="sha384-fake123"[\s]+crossorigin="anonymous"[\s]*\/>/',
					$output
				)
			),
			self::OUTPUT_MATCH_FAILURE_MESSAGE
		);

		// Make sure the v4shim css looks right.
		$this->assertTrue(
			boolval(
				preg_match(
					'/<link[\s]+rel=\'stylesheet\'[\s]+id=\'font-awesome-official-v4shim-css\'[\s]+href=\'https:\/\/pro\.fontawesome\.com\/releases\/v5\.2\.0\/css\/v4-shims\.css\'[\s]+type=\'text\/css\'[\s]+media=\'all\'[\s]+integrity="sha384-fake246"[\s]+crossorigin="anonymous"[\s]*\/>/',
					$output
				)
			),
			self::OUTPUT_MATCH_FAILURE_MESSAGE
		);

		// Make sure that the order is right: main css, followed by v4shim css.
		$this->assertTrue(
			boolval(
				preg_match(
					'/<link.+?font-awesome-official-css.+?>.+?<link.+?font-awesome-official-v4shim-css/s',
					$output
				)
			),
			self::OUTPUT_MATCH_FAILURE_MESSAGE
		);
	}

	/**
	 * @group output
	 */
	public function test_pseudo_element_config_enqueued_when_svg() {
		$resource_collection = [
			new FontAwesome_Resource(
				'https://use.fontawesome.com/releases/v5.2.0/js/all.js',
				get_mocked_releases()['5.2.0']['sri']['free']['js/all.js']
			),
			new FontAwesome_Resource(
				'https://use.fontawesome.com/releases/v5.2.0/js/v4-shims.js',
				get_mocked_releases()['5.2.0']['sri']['free']['js/v4-shims.js']
			),
		];

		$this->mock_release_provider
			->method( 'get_resource_collection' )
			->willReturn( $resource_collection );

		add_action(
			'font_awesome_requirements',
			function() {
				fa()->register(
					array(
						'name' => 'test',
						'clientVersion' => '1',
						'method' => 'svg',
						'pseudoElements' => 'require',
						'v4shim' => 'require',
					)
				);
			}
		);

		global $fa_load;
		$fa_load->invoke( fa() );

		$this->assertTrue( fa()->using_pseudo_elements() );
		$this->assertEquals( 'svg', fa()->fa_method() );

		$output = $this->captureOutput();

		$this->assertTrue(
			boolval(
				preg_match(
					'/searchPseudoElements:\s*true/',
					$output
				)
			),
			self::OUTPUT_MATCH_FAILURE_MESSAGE
		);
	}

	/**
	 * @group pro
	 */
	public function test_pro_svg_assets_enqueued() {
		$resource_collection = [
			new FontAwesome_Resource(
				'https://pro.fontawesome.com/releases/v5.2.0/js/all.js',
				'sha384-fake123'
			),
			new FontAwesome_Resource(
				'https://pro.fontawesome.com/releases/v5.2.0/js/v4-shims.js',
				'sha384-fake246'
			),
		];

		$this->mock_release_provider
			->method( 'get_resource_collection' )
			->willReturn( $resource_collection );

		add_action(
			'font_awesome_requirements',
			function() {
				fa()->register(
					array(
						'name' => 'test',
						'clientVersion' => '1',
						'method' => 'svg',
						'v4shim' => 'require',
					)
				);
			}
		);

		global $fa_load;
		$fa_load->invoke( fa() );

		$output = $this->captureOutput();

		// Make sure the main <script> looks right.
		$this->assertTrue(
			boolval(
				preg_match(
					'/<script[\s]+defer[\s]+crossorigin="anonymous"[\s]+integrity="sha384-fake123"[\s]+type=\'text\/javascript\'[\s]+src=\'https:\/\/pro\.fontawesome\.com\/releases\/v5\.2\.0\/js\/all\.js\'><\/script>/',
					$output
				)
			),
			self::OUTPUT_MATCH_FAILURE_MESSAGE
		);

		// Make sure the v4shim <script> looks right.
		$this->assertTrue(
			boolval(
				preg_match(
					'/<script[\s]+defer[\s]+crossorigin="anonymous"[\s]+integrity="sha384-fake246"[\s]+type=\'text\/javascript\'[\s]+src=\'https:\/\/pro\.fontawesome\.com\/releases\/v5\.2\.0\/js\/v4-shims\.js\'><\/script>/',
					$output
				)
			),
			self::OUTPUT_MATCH_FAILURE_MESSAGE
		);

		// Make sure that the order is right: main script, followed by v4shim script
		$this->assertTrue(
			boolval(
				preg_match(
					'/<script.+?all\.js.+?<script.+?v4-shims\.js/s',
					$output
				)
			),
			self::OUTPUT_MATCH_FAILURE_MESSAGE
		);
	}
}

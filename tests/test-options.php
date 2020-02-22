<?php
namespace FortAwesome;
/**
 * Class OptionsTest
 *
 * @noinspection PhpCSValidationInspection
 */
// phpcs:ignoreFile Squiz.Commenting.ClassComment.Missing
// phpcs:ignoreFile Generic.Commenting.DocComment.MissingShort
require_once dirname( __FILE__ ) . '/../includes/class-fontawesome-activator.php';
require_once dirname( __FILE__ ) . '/_support/font-awesome-phpunit-util.php';

class OptionsTest extends \WP_UnitTestCase {

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

	public function test_option_defaults() {
		$this->assertEquals(
			'webfont',
			fa()->technology()
		);

		$this->assertTrue(
			fa()->pseudo_elements()
		);
	}

	public function test_convert_options() {
		$this->assertEquals(
			array(
				'version' => '5.8.1',
				'pseudoElements' => true,
				'technology' => 'svg',
				'usePro' => true,
				'v4Compat' => true,
				'kitToken' => null,
				'apiToken' => false
			),
			fa()->convert_options(
				array (
				'adminClientLoadSpec' =>
					array (
						'name' => 'user',
						'method' => 'webfont',
						'v4shim' => 'require',
						'pseudoElements' => 'require',
						// clientVersion was a previous option
						'clientVersion' => 1554559421,
					),
				'version' => '5.8.1',
				'usePro' => true,
				'removeUnregisteredClients' => true,
				'lockedLoadSpec' =>
					array (
						'method' => 'svg',
						'v4shim' => true,
						'pseudoElements' => true,
						'clients' =>
							array (
								'user' => 1554559421,
							),
					),
				)
			)
		);
	}

	public function test_convert_options_coerce_pseudo_elements_true_for_webfont() {
		$this->assertEquals(
			array(
				'version' => '5.8.1',
				'pseudoElements' => true,
				'technology' => 'webfont',
				'usePro' => true,
				'v4Compat' => true,
				'kitToken' => null,
				'apiToken' => false
			),
			fa()->convert_options(
				array (
				'adminClientLoadSpec' =>
					array (
						'name' => 'user',
						'method' => 'webfont',
						'v4shim' => 'require',
						'pseudoElements' => 'forbid',
						// clientVersion was a previous option
						'clientVersion' => 1554559421,
					),
				'version' => '5.8.1',
				'usePro' => true,
				'removeUnregisteredClients' => true,
				'lockedLoadSpec' =>
					array (
						'method' => 'webfont',
						'v4shim' => true,
						'pseudoElements' => false,
						'clients' =>
							array (
								'user' => 1554559421,
							),
					),
				)
			)
		);
	}

	public function test_convert_options_coerce_pseudo_elements_true_for_webfont_when_absent() {
		$this->assertEquals(
			array(
				'version' => '5.8.1',
				'pseudoElements' => true,
				'technology' => 'webfont',
				'usePro' => true,
				'v4Compat' => true,
				'kitToken' => null,
				'apiToken' => false
			),
			fa()->convert_options(
				array (
				'adminClientLoadSpec' =>
					array (
						'name' => 'user',
						'method' => 'svg',
						'v4shim' => 'require',
						'pseudoElements' => 'forbid',
						// clientVersion was a previous option
						'clientVersion' => 1554559421,
					),
				'version' => '5.8.1',
				'usePro' => true,
				'removeUnregisteredClients' => true,
				'lockedLoadSpec' =>
					array (
						'v4shim' => true,
						'clients' =>
							array (
								'user' => 1554559421,
							),
					),
				)
			)
		);
	}
}

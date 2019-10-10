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

	public function test_convert_options() {
		$this->assertEquals(
			array(
				'version' => '5.8.1',
				'svgPseudoElements' => true,
				'technology' => 'svg',
				'usePro' => true,
				'v4compat' => true,
				'blacklist' => array(),
				'detectConflictsUntil' => null,
			),
			fa()->convert_options(
				array (
				'adminClientLoadSpec' =>
					array (
						'name' => 'user',
						'method' => 'webfont',
						'v4shim' => 'require',
						'pseudoElements' => 'require',
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
}

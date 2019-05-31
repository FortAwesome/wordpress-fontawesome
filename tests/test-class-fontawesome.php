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

class FontAwesomeTest extends \WP_UnitTestCase {

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

	protected function mock_with_plugin_version($plugin_version) {
		return mock_singleton_method(
			$this,
			FontAwesome::class,
			'plugin_version',
			function( $method ) use ( $plugin_version ) {
				$method->willReturn( $plugin_version );
			}
		);
	}

	public function test_satisfies () {
		$this->assertTrue(
			FontAwesome::satisfies('42.1.3', [['42.1.3', '=']])
		);
		$this->assertTrue(
			FontAwesome::satisfies('42.1.3', [['42.1.2', '>='], ['43', '<']])
		);
	}

	public function test_satisfies_bad_operator () {
		$this->expectException( \InvalidArgumentException::class );

		$this->assertTrue(
			FontAwesome::satisfies('42.1.3', [['42.1.2', 'xyz']])
		);
	}

	public function test_satisfies_bad_argument_1 () {
		$this->expectException( \InvalidArgumentException::class );

		$this->assertTrue(
			FontAwesome::satisfies('42.1.3', ['42.1.2', 'xyz'])
		);
	}

	public function test_satisfies_bad_argument_2 () {
		$this->expectException( \InvalidArgumentException::class );

		$this->assertTrue(
			$this->mock_with_plugin_version( '42.1.3' )
			     ->satisfies('42.1.2', '>')
		);
	}

	public function test_plugin_version_satisfies_or_warn_when_successful () {
		$this->assertTrue(
			$this->mock_with_plugin_version( '42.1.3' )
			     ->plugin_version_satisfies_or_warn([['42.1.2', '>']], 'this_test')
		);
	}

	public function test_plugin_version_satisfies_or_warn_when_failing () {
		$this->assertFalse(
			fa()->plugin_version_satisfies_or_warn([['0.0.1', '<']], 'this_test')
		);

		$this->assertEquals(
			fa()->get_plugin_version_warnings(),
			[ 'this_test' => [ 'name' => 'this_test', 'constraint' => '< 0.0.1' ] ]
		);

		set_current_screen('foo');
		do_action('admin_notices');
		$this->expectOutputRegex('/Font Awesome plugin version conflict with a plugin or theme named/');
	}
}

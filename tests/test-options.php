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
		wp_cache_delete ( 'alloptions', 'options' );
		delete_option( FontAwesome::OPTIONS_KEY );

		FontAwesome::reset();
		Mock_FontAwesome_Releases::mock();
		wp_script_is( 'font-awesome', 'enqueued' ) && wp_dequeue_script( 'font-awesome' );
		wp_script_is( 'font-awesome-v4shim', 'enqueued' ) && wp_dequeue_script( 'font-awesome-v4shim' );
		wp_style_is( 'font-awesome', 'enqueued' ) && wp_dequeue_style( 'font-awesome' );
		wp_style_is( 'font-awesome-v4shim', 'enqueued' ) && wp_dequeue_style( 'font-awesome-v4shim' );
	}

	public function test_option_defaults() {
		FontAwesome_Activator::activate();

		$this->assertEquals(
			'webfont',
			fa()->technology()
		);

		$this->assertTrue(
			fa()->pseudo_elements()
		);
	}

	public function test_convert_options() {
		FontAwesome_Activator::activate();

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
		FontAwesome_Activator::activate();

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
		FontAwesome_Activator::activate();

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

	public function test_options_empty() {
		$this->expectException( ConfigCorruptionException::class );

		fa()->options();
	}

	public function test_options_missing_technology() {
		$options = array_merge(
			FontAwesome::DEFAULT_USER_OPTIONS,
			[
				'version' => '5.3.1'
			]
		);

		unset( $options['technology'] );

		update_option( FontAwesome::OPTIONS_KEY, $options );

		$this->expectException( ConfigCorruptionException::class );

		fa()->technology();
	}

	public function test_options_invalid_technology() {
		$options = array_merge(
			FontAwesome::DEFAULT_USER_OPTIONS,
			[
				'version' => '5.3.1',
				'technology' => 'foo'
			]
		);

		update_option( FontAwesome::OPTIONS_KEY, $options );

		$this->expectException( ConfigCorruptionException::class );

		fa()->technology();
	}

	public function test_options_missing_pro() {
		$options = array_merge(
			FontAwesome::DEFAULT_USER_OPTIONS,
			[
				'version' => '5.3.1'
			]
		);

		unset( $options['usePro'] );

		update_option( FontAwesome::OPTIONS_KEY, $options );

		$this->expectException( ConfigCorruptionException::class );

		fa()->pro();
	}

	public function test_options_invalid_pro() {
		$options = array_merge(
			FontAwesome::DEFAULT_USER_OPTIONS,
			[
				'version' => '5.3.1',
				'usePro' => 42
			]
		);

		update_option( FontAwesome::OPTIONS_KEY, $options );

		$this->expectException( ConfigCorruptionException::class );

		fa()->pro();
	}

	public function test_options_pseudo_elements_missing() {
		$options = array_merge(
			FontAwesome::DEFAULT_USER_OPTIONS,
			[
				'version' => '5.3.1'
			]
		);

		unset( $options['pseudoElements'] );

		update_option( FontAwesome::OPTIONS_KEY, $options );

		$this->expectException( ConfigCorruptionException::class );

		fa()->pseudo_elements();
	}

	public function test_options_pseudo_elements_invalid() {
		$options = array_merge(
			FontAwesome::DEFAULT_USER_OPTIONS,
			[
				'version' => '5.3.1',
				'pseudoElements' => 42
			]
		);

		update_option( FontAwesome::OPTIONS_KEY, $options );

		$this->expectException( ConfigCorruptionException::class );

		fa()->pseudo_elements();
	}

	public function test_options_v4_compatibility_missing() {
		$options = array_merge(
			FontAwesome::DEFAULT_USER_OPTIONS,
			[
				'version' => '5.3.1'
			]
		);

		unset( $options['v4Compat'] );

		update_option( FontAwesome::OPTIONS_KEY, $options );

		$this->expectException( ConfigCorruptionException::class );

		fa()->v4_compatibility();
	}

	public function test_options_v4_compatibility_invalid() {
		$options = array_merge(
			FontAwesome::DEFAULT_USER_OPTIONS,
			[
				'version' => '5.3.1',
				'v4Compat' => 42
			]
		);

		update_option( FontAwesome::OPTIONS_KEY, $options );

		$this->expectException( ConfigCorruptionException::class );

		fa()->v4_compatibility();
	}
}

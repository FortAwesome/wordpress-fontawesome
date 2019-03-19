<?php
namespace FortAwesome;

use \ReflectionMethod;

/**
 * Class ShortcodeTest
 */
class ShortcodeTest extends \WP_UnitTestCase {

	public function test_shortcode() {
		$fa = fa();

		$sc = new ReflectionMethod( 'FortAwesome\FontAwesome', 'process_shortcode' );
		$sc->setAccessible( true );

		$this->assertRegExp( '/<i class="fas fa-coffee">.*?<\/i>/', $sc->invoke( $fa, [ 'name' => 'coffee' ] ) );
		$this->assertRegExp(
			'/<i class="far fa-bell">.*?<\/i>/',
			$sc->invoke(
				$fa,
				[
					'name'   => 'bell',
					'prefix' => 'far',
				]
			)
		);
		$this->assertRegExp(
			'/<i class="fas fa-coffee fa-2x foo">.*?<\/i>/',
			$sc->invoke(
				$fa,
				[
					'name'  => 'coffee',
					'class' => 'fa-2x foo',
				]
			)
		);
	}
}

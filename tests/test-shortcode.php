<?php
namespace FortAwesome;

/**
 * Class ShortcodeTest
 */
class ShortcodeTest extends \WP_UnitTestCase {
	public static function setUpBeforeClass() {
		add_shortcode(
			FontAwesome::SHORTCODE_TAG,
			array( fa(), 'process_shortcode' )
		);
	}

	public function test_shortcode() {
		$this->assertRegExp( '/<i class="fas fa-coffee">.*?<\/i>/', do_shortcode( '[icon name="coffee"/]' ) );

		$this->assertRegExp(
			'/<i class="far fa-bell">.*?<\/i>/',
			do_shortcode( '[icon prefix="far" name="bell" /]' )
		);

		$this->assertRegExp(
			'/<i class="fas fa-coffee fa-2x foo">.*?<\/i>/',
			do_shortcode( '[icon class="fa-2x foo" name="coffee" /]' )
		);

		$this->assertRegExp(
			'/<i class="fas fa-coffee" style="color: red;">.*?<\/i>/',
			do_shortcode( '[icon style="color: red;" name="coffee" /]' )
		);
	}
}

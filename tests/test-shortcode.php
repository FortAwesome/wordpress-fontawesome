<?php
namespace FortAwesome;
use Yoast\WPTestUtils\WPIntegration\TestCase;

/**
 * Class ShortcodeTest
 */
class ShortcodeTest extends TestCase {
	public static function set_up_before_class() {
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

		$content = do_shortcode( '[icon role="img" aria-label="blah" aria-labelledby="foo" aria-hidden="true" title="coffee" name="coffee" /]' );

		$this->assertRegExp(
			'/<i.*?\sclass="fas fa-coffee".*?>.*?<\/i>/',
			$content
		);
		$this->assertRegExp(
			'/<i.*?\srole="img".*?>.*?<\/i>/',
			$content
		);
		$this->assertRegExp(
			'/<i.*?\stitle="coffee".*?>.*?<\/i>/',
			$content
		);
		$this->assertRegExp(
			'/<i.*?\saria-hidden="true".*?>.*?<\/i>/',
			$content
		);
		$this->assertRegExp(
			'/<i.*?\saria-labelledby="foo".*?>.*?<\/i>/',
			$content
		);
		$this->assertRegExp(
			'/<i.*?\saria-label="blah".*?>.*?<\/i>/',
			$content
		);
	}
}

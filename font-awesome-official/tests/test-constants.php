<?php

class ConstantsTest extends WP_UnitTestCase {

	function test_expected_constants_exist() {
		$fa = FontAwesome();
		$this->assertRegExp( '/^[0-9]+\.[0-9]+\.[0-9]+/', $fa->version );
	}

	function test_magic_get_throws_error_for_non_existent_property() {
		$fa = FontAwesome();
		$this->expectException( TypeError::class );

		$fa->foobar;
	}
}

<?php
namespace FortAwesome;

require_once trailingslashit( FONTAWESOME_DIR_PATH ) . 'includes/exception/class-apitokenmissingexception.php';

class ExceptionsTest extends \WP_UnitTestCase {
	public function test_api_token_presence_exception() {
		$e1 = new Exception\ApiTokenMissingException();

		$this->assertStringStartsWith( 'Whoops', $e1->ui_message );
		$this->assertEquals( $e1->ui_message, $e1->getMessage() );
	}
}

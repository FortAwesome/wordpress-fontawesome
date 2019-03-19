<?php

namespace FortAwesome;

require_once FONTAWESOME_DIR_PATH . 'tests/fixtures/releases.php';

use \PHPUnit\Framework\TestCase;

/**
 * Class Mock_FontAwesome_Releases
 *
 * @package FontAwesomePhpUnitUtil
 */
class Mock_FontAwesome_Releases extends TestCase {
	public static $releases = null;

	public static function releases() {
		if ( null === self::$releases ) {
			self::$releases = get_mocked_releases();
		}
		return self::$releases;
	}

	public static function mock() {
		$obj = new self();
		mock_singleton_method(
			$obj,
			FontAwesome_Release_Provider::class,
			'releases',
			function( $method ) {
				$method->willReturn(
					Mock_FontAwesome_Releases::releases()
				);
			}
		);
	}


	public function test_mock_releases_loaded() {
		$this->assertNotNull( self::releases() );
	}
}

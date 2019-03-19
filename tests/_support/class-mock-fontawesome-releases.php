<?php

namespace FortAwesome;

use \PHPUnit\Framework\TestCase;

/**
 * Class Mock_FontAwesome_Releases
 *
 * @package FontAwesomePhpUnitUtil
 */
class Mock_FontAwesome_Releases extends TestCase {
	public static $releases = null;

	public static function load_releases() {
		$mocked_releases = array();
		$files           = glob( trailingslashit( FONTAWESOME_DIR_PATH ) . 'tests/fixtures/releases/release*.yml' );
		foreach ( $files as $file ) {
			$basename = basename( $file );
			$matches  = [];
			if ( preg_match( '/release-([0-9]+\.[0-9]+\.[0-9]+)\.yml/', $basename, $matches ) ) {
				$release_data                   = \Spyc::YAMLLoad( $file );
				$mocked_releases[ $matches[1] ] = $release_data;
			}
		}

		self::$releases = $mocked_releases;

	}

	public static function releases() {
		if ( null === self::$releases ) {
			self::load_releases();
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

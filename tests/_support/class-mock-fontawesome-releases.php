<?php

namespace FortAwesome;

require_once dirname( __FILE__ ) . '/../fixtures/graphql-releases-query-fixture.php';

use \PHPUnit\Framework\TestCase;

/**
 * Class Mock_FontAwesome_Releases
 *
 * @package FontAwesomePhpUnitUtil
 */
class Mock_FontAwesome_Releases extends TestCase {
	public static function mock() {
		$obj = new self();
		mock_singleton_method(
			$obj,
			FontAwesome_Release_Provider::class,
			'query',
			function( $method ) {
				$method->willReturn(
					wp_json_encode(
						array(
							'data' => graphql_releases_query_fixture(),
						)
					)
				);
			}
		);
	}

	public function test_basic() {
		self::mock();
		FontAwesome_Release_Provider::instance()->load_releases();

		$this->assertEquals( '5.4.1', fa()->latest_version() );
	}
}

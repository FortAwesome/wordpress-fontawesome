<?php

namespace FortAwesome;

require_once dirname( __FILE__ ) . '/../fixtures/graphql-releases-query-fixture.php';

use \PHPUnit\Framework\TestCase;

/**
 * Class Mock_FontAwesome_Metadata_Provider
 *
 * @package FontAwesomePhpUnitUtil
 */
class Mock_FontAwesome_Metadata_Provider extends TestCase {
	public function mock( $responses ) {
		if ( ! is_array( $responses ) ) {
			throw new Exception( 'expecting an array of json responses' );
		}

		$obj = new self();

		mock_singleton_method(
			$obj,
			FontAwesome_Metadata_Provider::class,
			'metadata_query',
			function( $method ) use ( $responses ) {
				$method->will( $this->onConsecutiveCalls( ...$responses ) );
			}
		);
	}

	public function test_basic() {
		$this->mock(
			array(
				wp_json_encode(
					array(
						'data' => graphql_releases_query_fixture(),
					)
				),
			)
		);

		FontAwesome_Release_Provider::load_releases();

		$this->assertEquals( '5.4.1', fa()->latest_version() );
	}
}

<?php

require_once dirname( __FILE__ ) . '/../includes/class-fontawesome-v3mapper.php';

use FortAwesome\FontAwesome_V3Mapper;
use Yoast\WPTestUtils\WPIntegration\TestCase;

/**
 * Class V3MapperTest
 */
class V3MapperTest extends TestCase {

	public function test_icons() {
		$obj = FontAwesome_V3Mapper::instance();
		$this->assertEquals( 'fab fa-android', $obj->map_v3_to_v5( 'icon-android' ) );
		$this->assertEquals( 'fas fa-th-list', $obj->map_v3_to_v5( 'icon-th-list' ) );
		$this->assertEquals( 'fas fa-archive', $obj->map_v3_to_v5( 'icon-archive' ) );
		$this->assertEquals( 'far fa-edit', $obj->map_v3_to_v5( 'icon-edit' ) );
	}
}

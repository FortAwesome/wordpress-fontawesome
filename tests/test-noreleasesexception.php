<?php

require_once dirname( __FILE__ ) . '/../includes/class-fontawesome-noreleasesexception.php';

/**
 * Class NoReleasesExceptionTest
 */
class NoReleasesExceptionTest extends WP_UnitTestCase {

	public function throw_me() {
		throw new FontAwesome_NoReleasesException();
	}

	public function test_try_catch() {
		$this->expectException( FontAwesome_NoReleasesException::class );

		$this->throw_me();
	}
}

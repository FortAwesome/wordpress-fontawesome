<?php
/**
 * Module for VersionsTest.
 *
 * @noinspection PhpIncludeInspection
 */
require_once 'vendor/autoload.php';
use Composer\Semver\Semver;

/**
 * Class VersionsTest
 */
class VersionsTest extends WP_UnitTestCase {
	/**
	 * This is here mainly to provide development notes about what kind of
	 * results to expect from the Semver library. It does not test our plugin.
	 * If anything, it tests the Semver library for regressions in a handful of cases.
	 *
	 * @group version
	 */
	public function test_explore_semver() {
		$this->assertTrue( Semver::satisfies( '5.0.13', '5.0.13' ) );
		$this->assertFalse( Semver::satisfies( '5.0.13', '5.0.12' ) );
		$this->assertTrue( Semver::satisfies( '5.0.13', '>5.0.10' ) );
		$this->assertTrue( Semver::satisfies( '5.0.13', '^5.0' ) );
		$this->assertFalse( Semver::satisfies( '5.1.1', '~5.0.0' ) );
		$this->assertTrue( Semver::satisfies( '5.0.11', '~5.0.10' ) );
		$this->assertFalse( Semver::satisfies( '5.1.0', '~5.0.10' ) );
		$this->assertTrue( Semver::satisfies( '5.1.0', '^5.0.0' ) );
		$this->assertFalse( Semver::satisfies( '5.0.13', '^5.1.0' ) );
		$this->assertEquals(
			Semver::rsort(
				Semver::satisfiedBy(
					[
						'5.0.12',
						'5.0.13',
						'5.1.0',
						'5.1.1',
					],
					'~5.0.0'
				)
			)[0],
			'5.0.13'
		);

		/**
		 * Probably we need to provide only stable versions, not development ones,
		 * because this doesn't behave as might be expected.
		 * $this->assertFalse(Semver::satisfies('5.1.0.11-dev', '^5.0.0-stable'));
		 */
	}
}

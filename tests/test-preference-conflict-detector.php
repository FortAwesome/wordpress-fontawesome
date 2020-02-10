<?php
namespace FortAwesome;

require_once dirname( __FILE__ ) . '/../includes/class-fontawesome-preference-conflict-detector.php';

/**
 * Class PreferenceConflictDetectorTest
 *
 * @noinspection PhpCSValidationInspection
 */
class PreferenceConflictDetectorTest extends \WP_UnitTestCase {

	public function test_when_all_prefs_match() {
		$options = array(
			'technology'        => 'webfont',
			'v4Compat'          => false,
			'usePro'            => false,
			'removeConflicts'   => false,
			'svgPseudoElements' => false,
			'version'           => '5.8.2',
		);

		$client_preferences = array(
			'technology'        => 'webfont',
			'v4Compat'          => false,
			'usePro'            => false,
			'removeConflicts'   => false,
			'svgPseudoElements' => false,
			'version'           => [ [ '5.8.2', '=' ] ],
		);

		$this->assertEquals( [], FontAwesome_Preference_Conflict_Detector::detect( $options, $client_preferences ) );
	}

	public function test_when_something_does_not_match() {
		$options = array(
			'method'   => 'svg',
			'v4Compat' => false,
		);

		$client_preferences = array(
			'method'   => 'webfont',
			'v4Compat' => false,
		);

		$this->assertEquals( [ 'method' ], FontAwesome_Preference_Conflict_Detector::detect( $options, $client_preferences ) );
	}

	public function test_when_version_does_not_match() {
		$options = array(
			'version' => '5.2.0',
		);

		$client_preferences = array(
			'version' => [ [ '5.8.2', '>' ] ],
		);

		$this->assertEquals( [ 'version' ], FontAwesome_Preference_Conflict_Detector::detect( $options, $client_preferences ) );
	}

	public function test_with_empty_preference() {
		$options = array(
			'method'   => 'svg',
			'v4Compat' => false,
		);

		$client_preferences = array();

		$this->assertEquals( [], FontAwesome_Preference_Conflict_Detector::detect( $options, $client_preferences ) );
	}
}

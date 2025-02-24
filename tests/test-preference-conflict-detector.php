<?php
namespace FortAwesome;

require_once __DIR__ . '/../includes/class-fontawesome-preference-conflict-detector.php';
use Yoast\WPTestUtils\WPIntegration\TestCase;

/**
 * Class PreferenceConflictDetectorTest
 *
 * @noinspection PhpCSValidationInspection
 */
class PreferenceConflictDetectorTest extends TestCase {

	public function test_when_all_prefs_match() {
		$options = array(
			'technology'      => 'webfont',
			'v4Compat'        => false,
			'usePro'          => false,
			'removeConflicts' => false,
			'pseudoElements'  => false,
			'version'         => '5.8.2',
		);

		$client_preferences = array(
			'technology'      => 'webfont',
			'v4Compat'        => false,
			'usePro'          => false,
			'removeConflicts' => false,
			'pseudoElements'  => false,
			'version'         => array( array( '5.8.2', '=' ) ),
		);

		$this->assertEquals( array(), FontAwesome_Preference_Conflict_Detector::detect( $options, $client_preferences ) );
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

		$this->assertEquals( array( 'method' ), FontAwesome_Preference_Conflict_Detector::detect( $options, $client_preferences ) );
	}

	public function test_when_version_does_not_match() {
		$options = array(
			'version' => '5.2.0',
		);

		$client_preferences = array(
			'version' => array( array( '5.8.2', '>' ) ),
		);

		$this->assertEquals( array( 'version' ), FontAwesome_Preference_Conflict_Detector::detect( $options, $client_preferences ) );
	}

	public function test_success_when_configured_version_is_symbolically_latest() {

		$options = array(
			'version' => 'latest',
		);

		$client_preferences = array(
			'version' => array( array( '5.8.2', '>' ) ),
		);

		$this->assertEquals( array(), FontAwesome_Preference_Conflict_Detector::detect( $options, $client_preferences, '5.12.0', '6.1.1' ) );
	}

	public function test_failure_when_configured_version_is_symbolically_latest() {

		$options = array(
			'version' => 'latest',
		);

		$client_preferences = array(
			'version' => array( array( '5.8.2', '=' ) ),
		);

		$this->assertEquals( array( 'version' ), FontAwesome_Preference_Conflict_Detector::detect( $options, $client_preferences, '5.12.0', '6.1.1' ) );
	}

	public function test_with_empty_preference() {
		$options = array(
			'method'   => 'svg',
			'v4Compat' => false,
		);

		$client_preferences = array();

		$this->assertEquals( array(), FontAwesome_Preference_Conflict_Detector::detect( $options, $client_preferences ) );
	}

	public function test_satisfies() {
		$this->assertTrue(
			FontAwesome_Preference_Conflict_Detector::version_satisfies( '42.1.3', array( array( '42.1.3', '=' ) ) )
		);
		$this->assertTrue(
			FontAwesome_Preference_Conflict_Detector::version_satisfies( '42.1.3', array( array( '42.1.2', '>=' ), array( '43', '<' ) ) )
		);
	}

	public function test_satisfies_bad_operator() {
		$this->expectException( ClientPreferencesSchemaException::class );

		$this->assertTrue(
			FontAwesome_Preference_Conflict_Detector::version_satisfies( '42.1.3', array( array( '42.1.2', 'xyz' ) ) )
		);
	}

	public function test_satisfies_bad_argument_1() {
		$this->expectException( ClientPreferencesSchemaException::class );

		$this->assertTrue(
			FontAwesome_Preference_Conflict_Detector::version_satisfies( '42.1.3', array( '42.1.2', 'xyz' ) )
		);
	}
}

<?php /** @noinspection PhpIncludeInspection */

namespace FontAwesomePhpUnitUtil;

require_once FONTAWESOME_DIR_PATH . 'tests/_support/mock_font_awesome_releases.php';
/**
 * Shared utilities for testing FontAwesome with PhpUnit and WordPress.
 */

/**
 * Replaces the singleton static property _instance on the given $class with a mock object,
 * and then sets up mock a method for the given $method name. It passes that mock $method
 * as a param to the given callable $init, which should use something like ->willReturn().
 *
 * @param object a PHPUnit_Framework_TestCase instance (of which WP_UnitTestCase is a subclass) that can be used
 *        to invoke getMockBuilder(...);
 * @param string name of the class, an instance of which will be mocked.
 * @param string                                                                                                 $method name of method to be mocked
 * @param callable                                                                                               $init a function to invoke, passing the method mock as the sole param.
 * @return null
 */
function mock_singleton_method( $obj, $type, $method, callable $init ) {
	$mock_builder = $obj->getMockBuilder( $type )
	->setMethods( [ $method ] )
	->disableOriginalConstructor();
	$mock         = $mock_builder->getMock();
	try {
		$ref = new \ReflectionProperty( $type, '_instance' );
		$ref->setAccessible( true );
		$ref->setValue( null, $mock );
		$init( $mock->method( $method ) );
		return $mock;
	} catch ( \ReflectionException $e ) {
		error_log( 'Reflection error: ' . $e );
		return null;
	}
}

/**
 * @param array &$state an array in which this function will state some state, which should be passed back in
 *              to end_error_log_capture.
 */
function begin_error_log_capture( &$state ) {
	$state['error_log_file']     = uniqid( 'fa_error_log' ) . '.log';
	$state['error_log_original'] = ini_get( 'error_log' );
	ini_set( 'error_log', $state['error_log_file'] );
}

/**
 * @param array &$state pass in the same state that was passed by reference to begin_error_log_capture
 * @return bool|string contents of error log file
 */
function end_error_log_capture( &$state ) {
	$error_log_contents = file_get_contents( $state['error_log_file'] );
	unlink( $state['error_log_file'] );
	ini_set( 'error_log', $state['error_log_original'] );
	return $error_log_contents;
}

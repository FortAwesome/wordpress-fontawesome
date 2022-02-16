<?php

/**
 * Shared utilities for testing FontAwesome with PhpUnit and WordPress.
 *
 * @noinspection PhpIncludeInspection
 */

// phpcs:ignoreFile

namespace FortAwesome;

use \ReflectionException, \ReflectionProperty, \Exception;

require_once FONTAWESOME_DIR_PATH . 'tests/_support/class-mock-fontawesome-metadata-provider.php';
require_once FONTAWESOME_DIR_PATH . 'includes/class-fontawesome.php';
require_once FONTAWESOME_DIR_PATH . 'includes/class-fontawesome-release-provider.php';

/**
 * Replaces the singleton static property instance on the given $class with a mock object,
 * and then sets up mock a method for the given $method name. It passes that mock $method
 * as a param to the given callable $init, which should use something like ->willReturn().
 *
 * @param object a PHPUnit_Framework_TestCase instance (of which WP_UnitTestCase is a subclass) that can be used
 *        to invoke getMockBuilder(...);
 * @param string name of the class, an instance of which will be mocked.
 * @param string name of method to be mocked
 * @param callable a function to invoke, passing the method mock as the sole param.
 * @return object|null
 */
function mock_singleton_method( $obj, $type, $method, callable $init ) {
	$mock_builder = $obj->getMockBuilder( $type )
	->setMethods( [ $method ] )
	->disableOriginalConstructor();
	$mock         = $mock_builder->getMock();
	try {
		$ref = new ReflectionProperty( $type, 'instance' );
		$ref->setAccessible( true );
		$ref->setValue( null, $mock );
		$init( $mock->method( $method ) );
		return $mock;
	} catch ( ReflectionException $e ) {
		print( 'Reflection error: ' . $e );
		return null;
	}
}

/**
 * Starts error log capture.
 *
 * @param array &$state an array in which this function will state some state, which should be passed back in
 *              to end_error_log_capture.
 */
function begin_error_log_capture( &$state ) {
	$state['error_log_file']     = uniqid( 'fa_error_log' ) . '.log';
	$state['error_log_original'] = ini_get( 'error_log' );
	// phpcs:disable
	ini_set( 'error_log', $state['error_log_file'] );
	// phpcs:enable
}

/**
 * Ends error log capture.
 *
 * @param array &$state pass in the same state that was passed by reference to begin_error_log_capture
 * @return bool|string contents of error log file
 */
function end_error_log_capture( &$state ) {
	// phpcs:ignore WordPress.WP.AlternativeFunctions
	$error_log_contents = file_get_contents( $state['error_log_file'] );
	unlink( $state['error_log_file'] );
	// phpcs:disable
	ini_set( 'error_log', $state['error_log_original'] );
	// phpcs:enable
	return $error_log_contents;
}

function reset_db() {
	wp_cache_delete ( 'alloptions', 'options' );

	if ( ! delete_option( FontAwesome::OPTIONS_KEY ) ) {
		// false could mean either that it doesn't exist, or that the delete wasn't successful.
		if ( get_option( FontAwesome::OPTIONS_KEY ) ) {
			throw new Exception( 'Unsuccessful clearing the Font Awesome option key in the db.' );
		}
	}

	if ( ! delete_option( FontAwesome::CONFLICT_DETECTION_OPTIONS_KEY ) ) {
		// false could mean either that it doesn't exist, or that the delete wasn't successful.
		if ( get_option( FontAwesome::CONFLICT_DETECTION_OPTIONS_KEY ) ) {
			throw new Exception( 'Unsuccessful clearing the Font Awesome option key in the db.' );
		}
	}

	if ( ! FontAwesome_Release_Provider::delete_option()  ) {
		// false could mean either that it doesn't exist, or that the delete wasn't successful.
		if ( FontAwesome_Release_Provider::get_option() ) {
			throw new Exception( 'Unsuccessful clearing the Releases option.' );
		}
	}

	if ( ! FontAwesome_Release_Provider::delete_last_used_release() ) {
		// false could mean either that it doesn't exist, or that the delete wasn't successful.
		if ( FontAwesome_Release_Provider::get_last_used_release() ) {
			throw new Exception( 'Unsuccessful clearing the Last Used Release transient.' );
		}
	}
}

function create_subsites($domains = ['alpha.example.com', 'beta.example.com']) {
	if ( ! is_multisite() ) {
		throw new \Exception("expected to be in multisite mode");
	}

	$results = array();

	foreach( $domains as $domain ) {
		$site_id = wp_insert_site( [ 'domain' => $domain ] );

		if ( is_wp_error( $site_id ) ) {
			throw new \Exception();
		}

		$results[$domain] = $site_id;
	}

	return $results;
}

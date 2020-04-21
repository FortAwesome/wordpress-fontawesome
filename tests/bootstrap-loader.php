<?php
/**
 * PHPUnit bootstrap file
 *
 * @package Font_Awesome
 * @noinspection PhpCSValidationInspection
 */

// phpcs:ignoreFile Generic.Commenting.DocComment.MissingShort
// phpcs:ignore WordPress.PHP.DevelopmentFunctions
$_tests_dir = getenv( 'WP_TESTS_DIR' );

if ( ! $_tests_dir ) {
	$_tests_dir = rtrim( sys_get_temp_dir(), '/\\' ) . '/wordpress-tests-lib';
}

if ( ! file_exists( $_tests_dir . '/includes/functions.php' ) ) {
	error_log( "Could not find $_tests_dir/includes/functions.php, have you run bin/install-wp-tests.sh ?" . PHP_EOL );
	exit( 1 );
}

/**
 * Intentionally omitting the manual loading of the plugin under test, because
 * it's the loading that's being tested for the test cases being run under this
 * bootstrap.
 */

// Start up the WP testing environment.
/** @noinspection PhpIncludeInspection */
require_once $_tests_dir . '/includes/bootstrap.php';


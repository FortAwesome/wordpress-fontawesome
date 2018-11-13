<?php /** @noinspection PhpCSValidationInspection */
/**
 * PHPUnit bootstrap file
 *
 * @package Font_Awesome
 */

$_tests_dir = getenv( 'WP_TESTS_DIR' );

if ( ! $_tests_dir ) {
	$_tests_dir = rtrim( sys_get_temp_dir(), '/\\' ) . '/wordpress-tests-lib';
}

if ( ! file_exists( $_tests_dir . '/includes/functions.php' ) ) {
	error_log( "Could not find $_tests_dir/includes/functions.php, have you run bin/install-wp-tests.sh ?" . PHP_EOL );
	exit( 1 );
}

// Give access to tests_add_filter() function.
/** @noinspection PhpIncludeInspection */
require_once $_tests_dir . '/includes/functions.php';

/**
 * Manually load the plugin being tested.
 */
function _manually_load_plugin() {
	require_once dirname(dirname(__FILE__)) . '/includes/class-fontawesome.php';
}
set_include_path( get_include_path() . PATH_SEPARATOR . dirname( dirname( __FILE__ ) . '../' ) );
tests_add_filter( 'muplugins_loaded', '_manually_load_plugin' );

// Start up the WP testing environment.
/** @noinspection PhpIncludeInspection */
require_once $_tests_dir . '/includes/bootstrap.php';


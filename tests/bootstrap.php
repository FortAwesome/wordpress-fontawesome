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

// Give access to tests_add_filter() function.
/** @noinspection PhpIncludeInspection */
require_once $_tests_dir . '/includes/functions.php';

/**
 * Manually load the plugin being tested.
 */
function _manually_load_plugin() {
	require_once dirname( dirname( __FILE__ ) ) . '/includes/class-fontawesome.php';
}
set_include_path( get_include_path() . PATH_SEPARATOR . dirname( dirname( __FILE__ ) . '../' ) );
tests_add_filter( 'muplugins_loaded', '_manually_load_plugin' );

// Start up the WP testing environment.
/** @noinspection PhpIncludeInspection */
require_once $_tests_dir . '/includes/bootstrap.php';

// Add a global reference to FortAwesome\FontAwesome::load() that has been made accessible for tests to use.
$fa_load  = new ReflectionMethod( 'FortAwesome\FontAwesome', 'load' );
$fa_load->setAccessible( true );

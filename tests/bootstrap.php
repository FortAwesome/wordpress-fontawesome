<?php
use Yoast\WPTestUtils\WPIntegration;

if ( getenv( 'WP_PLUGIN_DIR' ) !== false ) {
	define( 'WP_PLUGIN_DIR', getenv( 'WP_PLUGIN_DIR' ) );
} else {
	define( 'WP_PLUGIN_DIR', __DIR__ . '/../..' );
}

$active_plugins = ( defined( 'LOAD_PLUGIN' ) && boolval( LOAD_PLUGIN ) )
	? array( 'index.php' )
	: array();

$GLOBALS['wp_tests_options'] = array(
	'active_plugins' => $active_plugins,
);

if ( ! getenv( 'COMPOSER_VENDOR_DIR' ) ) {
	echo PHP_EOL, 'ERROR: COMPOSER_VENDOR_DIR env var must be set.', PHP_EOL;
	exit( 1 );
}

require_once getenv( 'COMPOSER_VENDOR_DIR' ) . '/yoast/wp-test-utils/src/WPIntegration/bootstrap-functions.php';

/*
 * Bootstrap WordPress. This will also load the Composer autoload file, the PHPUnit Polyfills
 * and the custom autoloader for the TestCase and the mock object classes.
 */
WPIntegration\bootstrap_it();

if ( ! defined( 'WP_PLUGIN_DIR' ) || file_exists( WP_PLUGIN_DIR . '/index.php' ) === false ) {
	echo PHP_EOL, 'ERROR: Please check whether the WP_PLUGIN_DIR environment variable is set and set to the correct value. The integration test suite won\'t be able to run without it.', PHP_EOL;
	exit( 1 );
}

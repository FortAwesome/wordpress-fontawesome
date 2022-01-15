<?php
use Yoast\WPTestUtils\WPIntegration;

if ( getenv( 'WP_PLUGIN_DIR' ) !== false ) {
    define( 'WP_PLUGIN_DIR', getenv( 'WP_PLUGIN_DIR' ) );
} else {
    define( 'WP_PLUGIN_DIR',  dirname( __FILE__ )  . '/../..' );
}

print "\n\nWP_PLUGIN_DIR: " . WP_PLUGIN_DIR . "\n\n";

$GLOBALS['wp_tests_options'] = [
    'active_plugins' => [ 'index.php' ],
];

require_once dirname( __DIR__ ) . '/vendor/yoast/wp-test-utils/src/WPIntegration/bootstrap-functions.php';

/*
 * Bootstrap WordPress. This will also load the Composer autoload file, the PHPUnit Polyfills
 * and the custom autoloader for the TestCase and the mock object classes.
 */
WPIntegration\bootstrap_it();

if ( ! defined( 'WP_PLUGIN_DIR' ) || file_exists( WP_PLUGIN_DIR . '/index.php' ) === false ) {
    echo PHP_EOL, 'ERROR: Please check whether the WP_PLUGIN_DIR environment variable is set and set to the correct value. The integration test suite won\'t be able to run without it.', PHP_EOL;
    exit( 1 );
}

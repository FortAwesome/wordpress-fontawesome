<?php

defined( 'FONTAWESOME_DIR_PATH' ) || define( 'FONTAWESOME_DIR_PATH', plugin_dir_path( __FILE__ ) );
defined( 'FONTAWESOME_DIR_URL' ) || define( 'FONTAWESOME_DIR_URL', plugin_dir_url( __FILE__ ) );
defined( 'FONTAWESOME_API_URL' ) || define( 'FONTAWESOME_API_URL', 'https://fontawesome.com' );
defined( 'FONTAWESOME_ENV' ) || define( 'FONTAWESOME_ENV', getenv( 'FONTAWESOME_ENV' ) );

// Find the vendor dir.
if ( ! defined( 'FONTAWESOME_VENDOR_DIR' ) ) {
	$matches = [];
	if ( 1 === preg_match( '/^(.*)\/vendor\/.*?(?!vendor)$/', __DIR__, $matches ) ) {
		define( 'FONTAWESOME_VENDOR_DIR', trailingslashit( $matches[1] ) . 'vendor' );
	} else {
		/*
		 * This should never actually be called, because the above regex should always match in one of the valid
		 * scenarios: either (a) we're being loaded directly as a WordPress plugin, or (b) we're being loaded
		 * as a composer dependency out of some other plugin's vendor directory.
		 * This fallback really is just another way of defining the vendor directory as if we were in scenario (a).
		 * TODO: come back later and consider some better error handling
		 */
		define( 'FONTAWESOME_VENDOR_DIR', trailingslashit( __DIR__ ) . '/vendor' );
	}
}

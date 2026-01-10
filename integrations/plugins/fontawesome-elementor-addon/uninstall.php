<?php

// if uninstall.php is not called by WordPress, die
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    die;
}

require_once trailingslashit(__DIR__) . 'includes/Options.php';

delete_option( FontAwesomeElementorAddon\Options::options_key() );

// for site options in Multisite
delete_site_option( FontAwesomeElementorAddon\Options::options_key() );

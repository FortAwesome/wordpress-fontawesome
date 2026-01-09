<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$vendor_dir = getenv('COMPOSER_VENDOR_DIR');

if (is_string($vendor_dir) && $vendor_dir !== '') {
    require_once trailingslashit($vendor_dir) . 'autoload.php';
} else {
	require_once trailingslashit(__DIR__) . '../vendor/autoload.php';
}

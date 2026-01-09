<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$configured_vendor_dir = getenv('COMPOSER_VENDOR_DIR');

$vendor_dir = $configured_vendor_dir;

if (!is_string($configured_vendor_dir) || $configured_vendor_dir === '') {
    $vendor_dir = trailingslashit(__DIR__) . '../vendor';
}

$vendor_autoload_path = trailingslashit($vendor_dir) . 'autoload.php';

if (file_exists($vendor_autoload_path)) {
	require_once $vendor_autoload_path;
}

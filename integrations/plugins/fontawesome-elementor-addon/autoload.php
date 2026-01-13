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

// TODO: Use PSR-4 autoloading via Composer instead of requiring files manually.
require_once __DIR__ . '/includes/Compatibility.php';
require_once __DIR__ . '/includes/Plugin.php';
require_once __DIR__ . '/includes/Setup_Kit.php';
require_once __DIR__ . '/includes/Options.php';
require_once __DIR__ . '/includes/Settings_Page.php';

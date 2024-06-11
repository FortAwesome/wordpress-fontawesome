<?php

namespace FortAwesome;

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

function fa_icon_block_init() {
	register_block_type(__DIR__ . '/build');
}

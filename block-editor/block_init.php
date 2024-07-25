<?php

namespace FortAwesome;

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

function block_init() {
	// TODO: we may need guard these and issue warnings if these APIs are not
	// available on earlier versions for WordPress.
	// Requires WP 5.8.0 for this API to allow the path to the block.json dir.
	register_block_type(__DIR__ . '/build');

	// This will only show up on a page where the block icon is used.
	register_block_style('font-awesome/icon', array(
		'name' => 'font-awesome-block-icon-base',
		'label' => 'Font Awesome Block Icon Base',
		'inline_style' => '.wp-block-font-awesome-icon svg { height: 1em;  } .wp-block-font-awesome-icon svg::before { content: unset;  }'
	));

	// This will only show up on a page where the rich text icon is used.
	register_block_style('font-awesome/rich-text-icon', array(
		'name' => 'font-awesome-rich-text-icon-base',
		'label' => 'Font Awesome Rich Text Icon Base',
		'inline_style' => '.wp-rich-text-font-awesome-icon svg { height: 1em; } .wp-rich-text-font-awesome-icon svg::before { content: unset; }'
	));
}

<?php

namespace FortAwesome;

require_once trailingslashit( FONTAWESOME_DIR_PATH ) . 'includes/class-fontawesome-svg-styles-manager.php';

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

function block_init() {
	if ( ! function_exists('is_wp_version_compatible') || ! is_wp_version_compatible('5.8.0') ) {
		return;
	}

	// We need to register the block-editor script explicitly here, instead of
	// just relying on `register_block_type` because we need to add some dependencies.
	wp_register_script(
		'font-awesome-block-editor',
		trailingslashit(FONTAWESOME_DIR_URL) . 'block-editor/build/index.js',
		array(
			FontAwesome::ADMIN_RESOURCE_HANDLE,
			FontAwesome::RESOURCE_HANDLE_ICON_CHOOSER,
		),
		FontAwesome::PLUGIN_VERSION
	);

	wp_register_style(
		'font-awesome-block-editor',
		trailingslashit(FONTAWESOME_DIR_URL) . 'block-editor/build/index.css',
		array(
			FontAwesome_SVG_Styles_Manager::RESOURCE_HANDLE_SVG_STYLES
		),
		FontAwesome::PLUGIN_VERSION
	);

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

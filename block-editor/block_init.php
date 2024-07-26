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

	/* This is to ensure that even when a webfont/css stylesheet is loaded at
     * the same time as we have inline SVGs in the page, the icon classes
     * on the <svg> elements don't up with ::before pseudo-elements on them
     * due to the rules in the webfont/css stylesheet. It probably wouldn't
     * result in anything rendering there, but it's better for there to be no
     * pseudo-elements present at all on the <svg> elements.
	 */
	$frontend_inline_style = <<< EOT
.wp-block-font-awesome-icon svg::before,
.wp-rich-text-font-awesome-icon svg::before {content: unset;}
EOT;
	wp_add_inline_style(
		FontAwesome_SVG_Styles_Manager::RESOURCE_HANDLE_SVG_STYLES,
		$frontend_inline_style
	);

	/* This is to ensure that the size of SVGs in the block editor content iframe
	 * don't flash HUGE before the SVG stylesheet is loaded. We'll hook an inline
	 * style onto an early-loaded stylesheet 
	 */
	$editor_inline_style = <<< EOT
.wp-block-font-awesome-icon svg,
.wp-rich-text-font-awesome-icon svg {height: 1em;}
EOT;
	wp_add_inline_style(
		'wp-block-editor',
		$editor_inline_style
	);

	register_block_type(__DIR__ . '/build');
}

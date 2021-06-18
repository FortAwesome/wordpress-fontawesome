<?php
namespace FortAwesome;

/**
 * Functions to register client-side assets (scripts and stylesheets) for the
 * block editor.
 *
 * @package font-awesome
 */

/**
 * Registers all block assets so that they can be enqueued through Gutenberg in
 * the corresponding context.
 *
 * @see https://wordpress.org/gutenberg/handbook/blocks/writing-your-first-block-type/#enqueuing-block-scripts
 */
function font_awesome_block_init() {
	// Skip block registration if Gutenberg is not enabled/merged.
	if ( ! function_exists( 'register_block_type' ) ) {
		return;
	}

	$editors_dir = trailingslashit( FONTAWESOME_DIR_PATH ) . "editors";

	$editor_js = 'editor-support.block.js';
	$editors_js_build_dir = trailingslashit($editors_dir) . "build";

	wp_register_script(
		'font-awesome-block-editor',
		plugins_url( $editor_js, trailingslashit($editors_js_build_dir) . $editor_js ),
		array(
			'wp-blocks',
			'wp-i18n',
			'wp-element',
			'wp-components',
			'wp-editor'
		),
		filemtime( trailingslashit($editors_js_build_dir) . "$editor_js" )
	);

	/**
	 * The block editing code needs to know some of the configuration data.
	 */
	wp_localize_script(
		'font-awesome-block-editor',
		'__FontAwesomeOfficialPlugin_BlockEditorConfig__',
		array(
			'version' => fa()->version(),
			'usingPro' => fa()->pro() ? true : false,
			'usingKit' => fa()->using_kit() ? true : false,
			'technology' => fa()->technology()
		)
	);

	$editor_css = 'editor.css';
	$editors_block_css_dir = trailingslashit($editors_dir) . "block/css";
	wp_register_style(
		'font-awesome-block-editor',
		plugins_url( $editor_css, trailingslashit($editors_block_css_dir) . $editor_css ),
		array(),
		filemtime( trailingslashit($editors_block_css_dir) . "$editor_css" )
	);

	$style_css = 'style.css';
	wp_register_style(
		'font-awesome-block',
		plugins_url( $style_css, trailingslashit($editors_block_css_dir) . $style_css ),
		array(),
		filemtime( trailingslashit($editors_block_css_dir) . "$style_css" )
	);

	register_block_type( 'font-awesome/font-awesome', array(
		'editor_script' => 'font-awesome-block-editor',
		'editor_style'  => 'font-awesome-block-editor',
		'style'         => 'font-awesome-block',
	) );
}

add_action( 'wp_loaded', 'FortAwesome\font_awesome_block_init' );

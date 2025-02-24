<?php

namespace FortAwesome;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

require_once trailingslashit( FONTAWESOME_DIR_PATH ) . 'includes/class-fontawesome-svg-styles-manager.php';

/**
 *  We need to register the block-editor script explicitly, instead of
 *  just relying on it to be registered by `register_block_type`, because we need to add some dependencies.
 *
 *  Thus, our block.json does not express its "editorScript" as something like "file:./index.js",
 *  it will reference the resource handle used in this registration, like: "font-awesome-block-editor".
 */
function enqueue_font_awesome_block_editor_assets() {
	wp_register_script(
		'font-awesome-block-editor',
		trailingslashit( FONTAWESOME_DIR_URL ) . 'block-editor/build/index.js',
		array(
			FontAwesome::ADMIN_RESOURCE_HANDLE,
			FontAwesome::RESOURCE_HANDLE_ICON_CHOOSER,
		),
		FontAwesome::PLUGIN_VERSION,
		array( 'in_footer' => false )
	);

	wp_register_style(
		'font-awesome-block-editor',
		trailingslashit( FONTAWESOME_DIR_URL ) . 'block-editor/build/index.css',
		array(
			FontAwesome_SVG_Styles_Manager::RESOURCE_HANDLE_SVG_STYLES,
		),
		FontAwesome::PLUGIN_VERSION
	);

	/**
	 * This is to ensure that even when a webfont/css stylesheet is loaded at
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
}

function block_init() {
	if ( ! function_exists( 'is_wp_version_compatible' ) || ! is_wp_version_compatible( '5.8.0' ) ) {
		return;
	}

	/**
	 *  It's important that our block editor assets are registered on the `enqueue_block_editor_assets` action, because:
	 *
	 *  1. otherwise, it would happen on the `init` hook, and apparently this always triggers `wp_default_packages_vendor`
	 *     in WordPress core wp-includes/script-loader.php to run, and when it does, if there are
	 *     any `lodash` dependencies, it adds a duplicate inline `after` script like this:
	 *     ```
	 *     window.lodash = _.noConflict()
	 *     window.lodash = _.noConflict()
	 *     ```
	 *
	 *     This is not idempotent: so calling it twice has the effect of making the global `_` undefined,
	 *     which breaks other scripts that depend on the global `_`.
	 *
	 *     By invoking `wp_register_script()` within the `enqueue_block_editor_assets` hook,
	 *     that `wp_default_packages_vendor` function doesn't get called a second time, and thus,
	 *     the `window.lodash  = _.noConflict()` is not duplicated, and thus the `_` global is not
	 *     reset to `undefined`.
	 *
	 *     At the time of writing, this plugin depended on neither the 'lodash' nor 'underscore' script
	 *     handles. So wasn't that this plugin had loaded a conflicting version of lodash. It's that other
	 *     code in WordPress core *does* load conflicting versions, and it depends on the proper functioning
	 *     of `_.noConflict()` to resolve that. So we need to avoid running our code in such a way that causes
	 *     the side effect of calling `_.noConflict()` twice.
	 *
	 *     (Since resolving this problem, this plugin *did* take a dependency on the 'lodash' version that
	 *      ships with WordPress core, to eliminate the need to bundle it separately. It still has no
	 *      direct or transitive dependencies on underscore--the older version of lodash).
	 *
	 *  2. We need these assets to be loaded for the block editor, on the back end only, never on
	 *       frontend page loads. The docs indicate that we should prefer using `enqueue_block_assets`.
	 *     However, since this plugin needs to be compatible with WordPress earlier than 6.3, we can't,
	 *     because it was only in WP 6.3 that assets enqueued under `enqueue_block_assets` would be
	 *     added to the editor content iframe as well as outside the iframe. So we need to continue
	 *     using the older hook. It's no big deal, though, since--for our plugin--the older mechanism
	 *     happens to accomplish exactly what we want:
	 *     (a) load the assets in the editor UI, and
	 *     (b) load them inside the editor's content iframe,
	 *     (c) but only load them there on the back end, never on the front end.
	 *
	 *     https://developer.wordpress.org/block-editor/how-to-guides/enqueueing-assets-in-the-editor/
	 */
	if ( is_wp_version_compatible( '6.3.0' ) ) {
		add_action( 'enqueue_block_assets', 'FortAwesome\enqueue_font_awesome_block_editor_assets' );
	} else {
		add_action( 'enqueue_block_editor_assets', 'FortAwesome\enqueue_font_awesome_block_editor_assets' );
	}

	register_block_type( __DIR__ . '/build' );
}

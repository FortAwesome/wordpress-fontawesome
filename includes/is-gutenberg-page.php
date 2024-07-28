<?php

namespace FortAwesome;

/**
 * Internal use only, not part of this plugin's public API.
 *
 * Code borrowed from Freemius SDK by way of Benjamin Intal on Stack Overflow,
 * under GPL. Thanks Benjamin! Hey everybody, get the Stackable plugin to do
 * cool stuff with Font Awesome in your Blocks!
 *
 * See: https://github.com/Freemius/wordpress-sdk
 * See: https://wordpress.stackexchange.com/questions/309862/check-if-gutenberg-is-currently-in-use
 * See: https://wordpress.org/plugins/stackable-ultimate-gutenberg-blocks/
 *
 * @internal
 * @ignore
 */
function is_gutenberg_page() {
	// The present function is called `is_gutenberg_page()`, but it's in our own namespace.
	// If there's a *global* function by that name, then delegate to it.
	if ( function_exists( 'is_gutenberg_page' ) && \is_gutenberg_page() ) {
		// The Gutenberg plugin is on.
		return true;
	}

	if ( function_exists( 'get_current_screen' ) ) {
		$current_screen = get_current_screen();

		if ( is_object( $current_screen ) && method_exists( $current_screen, 'is_block_editor' ) && $current_screen->is_block_editor() ) {
			// Gutenberg page on 5+.
			return true;
		}
	}

	return false;
}

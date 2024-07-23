<?php
namespace FortAwesome;

/**
 * Class FontAwesome_SVG_Styles_Manager
 */
class FontAwesome_SVG_Styles_Manager {
	/**
	 * Indicates whether to enqueue the kit.
	 *
	 * @since 4.5.0
	 * @return bool
	 */
	public static function skip_enqueue_kit() {
		/**
		 * Determines whether to enqueue the kit.
		 *
		 * @since 4.5.0
		 */
		return apply_filters( 'font_awesome_skip_enqueue_kit', false );
	}

	/**
     * Given the plugin's options, as would be returned by `get_option(FontAwesome::OPTIONS_KEY)`,
     * returns `true` when the options indicate that webfont technology
     * is in use, or when `$is_skipping_enqueue_kit` is `false`.
     *
     * These `true` conditions mean that the SVG support styles must be loaded
     * either via CDN or self-host, in order to support inline SVG icons, such
     * as those that may be added in the block editor.
     *
     * When an SVG kit is already being loaded, it's not necessary to separately
     * load the SVG support styles, because the kit does that itself.
     *
	 * @since 4.5.0
	 * @param $options array
	 * @param $is_skipping_enqueue_kit bool
	 * @return bool
 	 */
	public static function requires_additional_svg_support_css($options, $is_skipping_enqueue_kit = false) {
		if ( boolval( $is_skipping_enqueue_kit ) ) {
			return true;
		}

		if (
		    is_array( $options ) &&
			isset( $options['technology'] ) &&
			$options['technology'] === 'webfont'
		) {
			return true;
		}

		return false;
	}
}

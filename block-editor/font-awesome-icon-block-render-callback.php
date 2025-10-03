<?php

/**
 * Rendering callback for the SVG Icon block.
 */

namespace FortAwesome;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

function font_awesome_icon_render_callback( $attributes ) {
	$svg = '';
	$icon_layers = $attributes['iconLayers'] ?? null;

	if ( is_array( $icon_layers ) && !empty( $icon_layers ) ) {
		// We do not yet support multiple layers in this application, so just use the first one.
		$svg = render_svg_from_icon_layer( $icon_layers[0] ) ?? '';
	}

	$html = "<div class=\"wp-block-font-awesome-icon wp-font-awesome-icon\">$svg</div>";
	return $html;
}

function render_svg_from_icon_layer( $icon_layer = [] ) {
	if ( !is_array( $icon_layer ) || empty( $icon_layer ) ) {
		return;
	}

	$icon_definition = $icon_layer['iconDefinition'] ?? null;

	if ( null === $icon_definition || !is_array( $icon_definition ) ) {
		return;
	}

	$icon_name = $icon_definition['iconName'] ?? null;

	if ( null === $icon_name || !is_string( $icon_name ) ) {
		return;
	}

	$prefix = $icon_definition['prefix'] ?? null;

	if ( null === $prefix || !is_string( $prefix ) ) {
		return;
	}

	$icon_data = $icon_definition['icon'] ?? null;

	if ( null === $icon_data || !is_array( $icon_data ) || count( $icon_data ) < 5 ) {
		return;
	}

	$width = $icon_data[0];

	if ( !is_numeric( $width ) ) {
		return;
	}

	$height = $icon_data[1];

	if ( !is_numeric( $height ) ) {
		return;
	}

	$svg = "<svg aria-hidden=\"true\" focusable=\"false\" data-prefix=\"$prefix\" data-icon=\"$icon_name\" class=\"svg-inline--fa fa-$icon_name\" role=\"img\" xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 $width $height\">";

	$path_or_paths = $icon_data[4];

	$normalized_paths = [];

	if ( is_string( $path_or_paths ) ) {
		$normalized_paths = [ $path_or_paths ];
	} elseif ( is_array( $path_or_paths ) ) {
		$normalized_paths = $path_or_paths;
	}

	foreach ( $normalized_paths as $index => $path ) {
		if ( !is_string( $path ) ) {
			continue;
		}

		$opacity_attribute = count( $normalized_paths ) > 1 && 0 === $index
			? 'opacity="0.4" '
			: $opacity_attribute = '';

		$svg = $svg . '<path ' . $opacity_attribute . 'fill="currentColor" d="' . esc_attr( $path ) . '"/>';
	}

	// TODO: handle spin and transform attributes.

	$svg = "$svg</svg>";

	return $svg;
}

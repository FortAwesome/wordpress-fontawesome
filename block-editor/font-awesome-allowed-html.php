<?php

namespace FortAwesome;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Allow the <svg> element and its children and attributes.
 */
function allow_font_awesome_html( $allowed_html ) {
	add_filter('wp_kses_allowed_html', function ($tags, $context) use ($allowed_html) {
		foreach ( $allowed_html as $tag => $attributes ) {
			if (isset($tags[$tag]) && is_array($tags[$tag])) {
				// Merge with existing attributes
				$tags[$tag] = array_merge($tags[$tag], $attributes);
			} else {
				$tags[$tag] = $attributes;
			}
		}

        return $tags;
    }, 10, 2 );
}

function allowed_html() {
	/**
	 * This is based on an analysis of the code in `@fortawesome/fontawesome-svg-core` that is responsible
	 * for building the SVG elements. It may need to be updated if that code changes.
	 */
	return add_lowercase_attributes( array(
		'div'      => array(
			'class' => true,
			'style' => true,
		),
		'svg'      => array(
			'xmlns' => true,
			'viewBox' => true,
			'width' => true,
			'height' => true,
			'class' => true,
			'color' => true,
			'role' => true,
			'aria-hidden' => true,
			'aria-label' => true,
			'aria-labelledby' => true,
			'data-prefix' => true,
			'data-icon' => true,
			'data-fa-i2svg' => true,
			'data-fa-pseudo-element' => true,
			'focusable' => true,
			'style' => true,
			'transform-origin' => true,
		),
		'path'     => array(
			'fill' => true,
			'opacity' => true,
			'd' => true,
			'class' => true,
			'transform' => true,
		),
		'span'     => array(
			'class' => true,
			'style' => true,
			'aria-label' => true,
			'data-fa-i2svg' => true,
		),
		'g'        => array(
			'class' => true,
			'transform' => true,
		),
		'symbol'   => array(
			'id' => true,
			'viewBox' => true,
			'class' => true,
			'role' => true,
			'aria-hidden' => true,
			'aria-label' => true,
			'aria-labelledby' => true,
			'data-prefix' => true,
			'data-icon' => true,
		),
		'rect'     => array(
			'x' => true,
			'y' => true,
			'width' => true,
			'height' => true,
			'fill' => true,
			'clip-path' => true,
			'mask' => true,
		),
		'circle'   => array(
			'cx' => true,
			'cy' => true,
			'r' => true,
			'fill' => true,
		),
		'mask'     => array(
			'x' => true,
			'y' => true,
			'width' => true,
			'height' => true,
			'id' => true,
			'maskUnits' => true,
			'maskContentUnits' => true,
		),
		'defs'     => array(),
		'clipPath' => array(
			'id' => true,
		),
		'animate'  => array(
			'attributeType' => true,
			'repeatCount' => true,
			'dur' => true,
			'attributeName' => true,
			'values' => true,
		),
	) );
}

/**
 * Add lowercase versions of all attributes to the allowed HTML.
 *
 * This is necessary because some attribute names like `viewBox` will not be
 * matched by the KSES filter, which seems to lowercase attributes when filtering.
 *
 * So this will add `viewbox` as an allowed attribute alongside `viewBox`,
 * and will do the same for all other mixed-case attributes.
 *
 * @param array $allowed_html The original allowed HTML tags and attributes.
 * @return array The modified allowed HTML tags and attributes with lowercase attributes added.
 */
function add_lowercase_attributes( $allowed_html ) {
	foreach ( $allowed_html as $tag => $attributes ) {
		$additional_attributes = array();

		if ( is_array( $attributes ) ) {
			foreach ( $attributes as $name => $value ) {
				$lowercase_name = strtolower( $name );
				if ( $lowercase_name !== $name ) {
					$additional_attributes[ $lowercase_name ] = $value;
				}
			}
		}

		if ( ! empty( $additional_attributes ) ) {
			$allowed_html[ $tag ] = array_merge( $attributes, $additional_attributes );
		}
	}

	return $allowed_html;
}

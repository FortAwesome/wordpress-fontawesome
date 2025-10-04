<?php

/**
 * Rendering callback for the SVG Icon block.
 */

namespace FortAwesome;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

function font_awesome_icon_render_callback( $attributes ) {
	$allowed_html       = allowed_html();
	$wrapper_attributes = $attributes['wrapperAttributes'] ?? array();
	$html               = '<div';
	$allowed_attributes = $allowed_html['div'] ?? array();

	foreach ( $wrapper_attributes as $attribute_name => $attribute_value ) {
		if ( in_array( $attribute_name, $allowed_attributes, true ) && is_string( $attribute_value ) ) {
			$html .= ' ' . esc_attr( $attribute_name ) . '="' . esc_attr( $attribute_value ) . '"';
		}
	}

	$html .= '>';

	$abstract = $attributes['abstract'] ?? array();

	if ( is_array( $abstract ) && ! empty( $abstract ) ) {
		foreach ( $abstract as $abstract_tag ) {
			$html .= render_abstract_tag( $abstract_tag, $allowed_html );
		}
	}

	return "$html</div>";
}

function render_abstract_tag( $abstract_tag, $allowed_html ) {
	$empty_result = '';

	$html = $empty_result;

	if ( ! is_array( $abstract_tag ) || empty( $abstract_tag ) ) {
		return $empty_result;
	}

	$tag                = $abstract_tag['tag'] ?? null;
	$attributes         = $abstract_tag['attributes'] ?? array();
	$children           = $abstract_tag['children'] ?? array();
	$allowed_attributes = $allowed_html[ $tag ] ?? array();

	if ( ! is_string( $tag ) || ! isset( $allowed_html[ $tag ] ) || ! is_array( $attributes ) || ! is_array( $children ) ) {
		return $empty_result;
	}

	$html .= "<$tag";

	$allowed_attributes = $allowed_html[ $tag ] ?? array();

	if ( ! is_array( $allowed_attributes ) ) {
		return $empty_result;
	}

	foreach ( $attributes as $attribute_name => $attribute_value ) {
		if ( in_array( $attribute_name, $allowed_attributes, true ) && is_string( $attribute_value ) ) {
			$html .= ' ' . esc_attr( $attribute_name ) . '="' . esc_attr( $attribute_value ) . '"';
		}
	}

	$html .= '>';

	foreach ( $children as $child ) {
		$html .= render_abstract_tag( $child, $allowed_html );
	}

	$html .= "</$tag>";

	return $html;
}

function allowed_html() {
	/**
	 * This is based on an analysis of the code in `@fortawesome/fontawesome-svg-core` that is responsible
	 * for building the SVG elements. It may need to be updated if that code changes.
	 */
	return array(
		'div'      => array(
			'class',
			'style',
		),
		'svg'      => array(
			'xmlns',
			'viewBox',
			'width',
			'height',
			'class',
			'color',
			'role',
			'aria-hidden',
			'aria-label',
			'aria-labelledby',
			'data-prefix',
			'data-icon',
			'data-fa-i2svg',
			'data-fa-pseudo-element',
			'style',
			'transform-origin',
		),
		'path'     => array(
			'fill',
			'opacity',
			'd',
			'class',
			'transform',
		),
		'span'     => array(
			'class',
			'style',
			'aria-label',
			'data-fa-i2svg',
		),
		'g'        => array(
			'class',
			'transform',
		),
		'symbol'   => array(
			'id',
			'viewBox',
			'class',
			'role',
			'aria-hidden',
			'aria-label',
			'aria-labelledby',
			'data-prefix',
			'data-icon',
		),
		'rect'     => array(
			'x',
			'y',
			'width',
			'height',
			'fill',
			'clip-path',
			'mask',
		),
		'circle'   => array(
			'cx',
			'cy',
			'r',
			'fill',
		),
		'mask'     => array(
			'x',
			'y',
			'width',
			'height',
			'id',
			'maskUnits',
			'maskContentUnits',
		),
		'defs'     => array(),
		'clipPath' => array(
			'id',
		),
		'animate'  => array(
			'attributeType',
			'repeatCount',
			'dur',
			'attributeName',
			'values',
		),
	);
}

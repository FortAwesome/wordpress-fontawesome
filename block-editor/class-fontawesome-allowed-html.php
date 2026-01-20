<?php

namespace FortAwesome;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class FontAwesome_Allowed_HTML {
	/**
	 * @internal
	 * @ignore
	 */
	protected static $instance = null;

	protected static $allowed_html = null;

	private function __construct() {
		if ( is_null( self::$allowed_html ) ) {
			self::$allowed_html = self::build_allowed_html();
		}
	}

	public static function instance()
	{
		if (is_null(self::$instance)) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	public function get_allowed_html() {
		return self::$allowed_html;
	}

	public static function build_allowed_html() {
		/**
		 * This is based on an analysis of the code in `@fortawesome/fontawesome-svg-core` that is responsible
		 * for building the SVG elements. It may need to be updated if that code changes.
		 */
		return self::add_lowercase_attributes( array(
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
	public static function add_lowercase_attributes( $allowed_html ) {
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
}

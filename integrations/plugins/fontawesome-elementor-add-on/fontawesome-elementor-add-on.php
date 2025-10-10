<?php

/**
 * Plugin Name:       Font Awesome Elementor Add-on
 * Plugin URI:        https://fontawesome.com/
 * Description:       Add Font Awesome Pro icons to Elementor.
 * Version:           0.0.1
 * Author:            Font Awesome
 * Author URI:        https://fontawesome.com/
 * License:           GPLv3
 */

defined( 'WPINC' ) || die;

function replace_font_awesome( $settings ) {
	$json_url = FONTAWESOME_PRO_ASSETS_URL . '/%s.js';
	$icons['fa-regular'] = [
		'name' => 'fa-regular',
		'label' => esc_html__( 'Font Awesome - Regular Pro', 'elementor-pro' ),
		'url' => false,
		'enqueue' => false,
		'prefix' => 'fa-',
		'displayPrefix' => 'far',
		'labelIcon' => 'fab fa-font-awesome-alt',
		'ver' => '5.15.1-pro',
		'fetchJson' => sprintf( $json_url, 'regular' ),
		'native' => true,
	];
	$icons['fa-solid'] = [
		'name' => 'fa-solid',
		'label' => esc_html__( 'Font Awesome - Solid Pro', 'elementor-pro' ),
		'url' => false,
		'enqueue' => false,
		'prefix' => 'fa-',
		'displayPrefix' => 'fas',
		'labelIcon' => 'fab fa-font-awesome',
		'ver' => '5.15.1-pro',
		'fetchJson' => sprintf( $json_url, 'solid' ),
		'native' => true,
	];
	$icons['fa-brands'] = [
		'name' => 'fa-brands',
		'label' => esc_html__( 'Font Awesome - Brands Pro', 'elementor-pro' ),
		'url' => false,
		'enqueue' => false,
		'prefix' => 'fa-',
		'displayPrefix' => 'fab',
		'labelIcon' => 'fab fa-font-awesome-flag',
		'ver' => '5.15.1-pro',
		'fetchJson' => sprintf( $json_url, 'brands' ),
		'native' => true,
	];
	$icons['fa-light'] = [
		'name' => 'fa-light',
		'label' => esc_html__( 'Font Awesome - Light Pro', 'elementor-pro' ),
		'url' => false,
		'enqueue' => false,
		'prefix' => 'fa-',
		'displayPrefix' => 'fal',
		'labelIcon' => 'fal fa-flag',
		'ver' => '5.15.1-pro',
		'fetchJson' => sprintf( $json_url, 'light' ),
		'native' => true,
	];
	$icons['fa-duotone'] = [
		'name' => 'fa-duotone',
		'label' => esc_html__( 'Font Awesome - Duotone Pro', 'elementor-pro' ),
		'url' => false,
		'enqueue' => false,
		'prefix' => 'fa-',
		'displayPrefix' => 'fad',
		'labelIcon' => 'fad fa-flag',
		'ver' => '5.15.1-pro',
		'fetchJson' => sprintf( $json_url, 'duotone' ),
		'native' => true,
	];
	// remove Free
	unset(
		$settings['fa-solid'],
		$settings['fa-regular'],
		$settings['fa-brands']
	);
	return array_merge( $icons, $settings );

}

add_filter( 'elementor/icons_manager/native', 'replace_font_awesome' );

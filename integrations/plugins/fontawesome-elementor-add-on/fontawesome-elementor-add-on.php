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

define( 'FONTAWESOME_PRO_ASSETS_DIR', 'font-awesome-pro-assets' );

define('FA_VERSION', '7.1.0');

require_once trailingslashit(__DIR__) . './includes/class-fontawesome-elementor-data-manager.php';

function get_upload_dir() {
	$upload_dir = wp_upload_dir( null, true, false );

	if ( isset( $upload_dir['error'] ) && false !== $upload_dir['error'] ) {
		throw new Exception(
			esc_html__(
				'Failed to get or initialize WP uploads directory.',
				'font-awesome'
			)
		);
	}

	return $upload_dir;
}

function get_versioned_fa_pro_assets_dir($fa_version) {
	return trailingslashit( WP_CONTENT_DIR ) . trailingslashit( FONTAWESOME_PRO_ASSETS_DIR ) . $fa_version;
}

function get_versioned_selfhost_dir($upload_dir, $fa_version) {
	return trailingslashit( $upload_dir['basedir'] ) . get_versioned_selfhost_relative_path( $fa_version );
}

function get_versioned_selfhost_relative_path($fa_version) {
	return "font-awesome-pro/$fa_version";
}

function build_metadata_relative_path($fa_version, $file = '') {
	return trailingslashit( get_versioned_selfhost_relative_path( $fa_version ) ) . 'metadata/' . $file;
}

function build_metadata_disk_path($upload_dir, $fa_version, $file = '') {
	return trailingslashit($upload_dir['basedir']) . build_metadata_relative_path($fa_version, $file);
}

function ensure_versioned_fa_pro_assets_dir($fa_version) {
	$dir = get_versioned_fa_pro_assets_dir($fa_version);

	if ( ! wp_mkdir_p( $dir ) ) {
		throw new Exception(
			esc_html__(
				'Failed creating a directory for self-hosted assets. Contact your WordPress server administrator.',
				'font-awesome'
			)
		);
	}
}

function ensure_uploads_metadata_dir( $fa_version ) {
	$upload_dir = get_upload_dir();

	$metadata_dir = build_metadata_disk_path($upload_dir, $fa_version);

	if ( ! wp_mkdir_p( $metadata_dir ) ) {
		throw new Exception(
			esc_html__(
				'Failed creating a directory for self-hosted assets. Contact your WordPress server administrator.',
				'font-awesome'
			)
		);
	}
}

function write_metadata_file( $full_asset_path, $contents ) {
	if ( ! function_exists( 'WP_Filesystem' ) ) {
		require_once ABSPATH . 'wp-admin/includes/file.php';
	}

	if ( ! WP_Filesystem( false ) ) {
		throw new Exception(
			esc_html__(
				'Failed to initialize filesystem usage for creating self-hosted assets. Please report this on the plugin support forum so it can be investigated.',
				'font-awesome'
			)
		);
	}

	global $wp_filesystem;

	if ( ! $wp_filesystem->put_contents( $full_asset_path, $contents ) ) {
		throw new Exception(
			esc_html__(
				'Failed creating self-hosted assets. Contact your WordPress server administrator.',
				'font-awesome'
			)
		);
	}
}

function extract_selectively($upload_dir, $fa_version ) {
	$tmp_file = "/tmp/fontawesome-pro-$fa_version-web.zip";
	$temp_dir = WP_CONTENT_DIR . '/upgrade/myplugin-temp-' . wp_generate_password( 8, false );

	if ( ! wp_mkdir_p( $temp_dir ) ) {
		throw new Exception("failed creating temp_dir: $temp_dir");
	}
	$zip = new ZipArchive;
	$dirs_for_selfhost = [ 'css', 'webfonts' ];
	$dirs_for_temporary_use = [ 'metadata' ];
	$dirs_for_extraction = array_merge( $dirs_for_selfhost, $dirs_for_temporary_use );
	$prefix = "fontawesome-pro-$fa_version-web/";

	$prefixed_dirs_for_extraction = array_map(function($item) use ($prefix) {
	    return $prefix . $item;
	}, $dirs_for_extraction);

	$prefixed_dirs_for_selfhost = array_map(function($item) use ($prefix) {
	    return $prefix . $item;
	}, $dirs_for_selfhost);

	if ( $zip->open( $tmp_file ) === TRUE ) {
	  for ( $i = 0; $i < $zip->numFiles; $i++ ) {
	        $entry = $zip->getNameIndex($i);

	        foreach ( $prefixed_dirs_for_extraction as $dir ) {
	            if ( strpos($entry, trailingslashit( $dir ) ) === 0 ) {
					if (!$zip->extractTo($temp_dir, [$entry])) {
						throw new Exception(
						"failed extracting entry: $entry"
						);
					}
	                break;
	            }
	        }
	   }
	    $zip->close();
	}

	global $wp_filesystem;
	WP_Filesystem();

	foreach ($prefixed_dirs_for_selfhost as $dir) {
		$source = trailingslashit( $temp_dir ) . $dir;
		$destination = trailingslashit( get_versioned_selfhost_dir($upload_dir, $fa_version) ) . str_replace($prefix, '', $dir);
		$wp_filesystem->move($source, $destination, true);
	}

	build_metadata_json_assets($upload_dir, $fa_version, trailingslashit($temp_dir) . "$prefix/metadata/icon-families.json");
}

function build_metadata_json_assets($upload_dir, $fa_version, $icon_families_json_path) {
	if ( ! function_exists( 'WP_Filesystem' ) ) {
    	require_once ABSPATH . 'wp-admin/includes/file.php';
	}

	global $wp_filesystem;

	// Initialize the API — returns false if credentials are needed
	WP_Filesystem();

	$file_path = $icon_families_json_path;
	$svg_objects_dir = trailingslashit(get_versioned_selfhost_dir($upload_dir, $fa_version)) . '/svg-objects';
	if ( file_exists( $file_path ) && is_readable( $file_path ) ) {
	    $json_str = file_get_contents( $file_path );
	    $data = json_decode( $json_str, true );

	    if ( json_last_error() === JSON_ERROR_NONE ) {
			$icons_by_shorthand = [];

			foreach ($data as $icon_name => $icon_data) {
				foreach ($icon_data['svgs'] as $family => $style_map) {
					foreach ($style_map as $style => $svg_data) {
						$svg_object = [
							"width" => $svg_data['width'],
							"height" => $svg_data['height'],
							"path" => $svg_data['path']
						];

						$style_shorthand = get_style_shorthand($family, $style);
						$svg_object_json = json_encode($svg_object);
						$family_style_dir = trailingslashit($svg_objects_dir) . $style_shorthand;

						if ( ! wp_mkdir_p( $family_style_dir ) ) {
							throw new Exception(
								esc_html__(
									'Failed creating a directory for self-hosted assets. Contact your WordPress server administrator.',
									'font-awesome'
								)
							);
						}

						$icon_file_path = trailingslashit($family_style_dir) . "$icon_name.json";

						if ( ! $wp_filesystem->put_contents( $icon_file_path, $svg_object_json, FS_CHMOD_FILE ) ) {
							throw new Exception(
								esc_html__(
									'Failed creating an svg-objects file.',
									'font-awesome'
								)
							);
						}

						if (!isset($icons_by_shorthand[$style_shorthand])) {
							$icons_by_shorthand[$style_shorthand] = [];
						}

						// must quote icon names in case some are numeric.
						$icons_by_shorthand[$style_shorthand][] = "$icon_name";
					}
				}
			}

			foreach ($icons_by_shorthand as $style_shorthand => $icon_names) {
				$icon_names_json = json_encode(["icons" => $icon_names]);
				$file_name = "$style_shorthand.js";
				$metadata_file_path = build_metadata_disk_path($upload_dir, $fa_version, $file_name);

				if ( ! $wp_filesystem->put_contents( $metadata_file_path, $icon_names_json, FS_CHMOD_FILE ) ) {
					throw new Exception("failed creating metadata file: $metadata_file_path" );
				}
			}
	    } else {
	        error_log( 'JSON parse error: ' . json_last_error_msg() );
	    }
	}
}

function get_style_shorthand($family, $style) {
	if ('classic' === $family) {
		return $style;
	}

	if ('duotone' === $family && 'solid' === $style) {
		return 'duotone';
	}

	return "$family-$style";
}

function get_style_shorthands( $upload_dir, $fa_version ) {
	global $wp_filesystem;
	require_once ABSPATH . 'wp-admin/includes/file.php';

	// Initialize the filesystem
	WP_Filesystem();

	$dir = trailingslashit( $upload_dir['basedir'] ) . trailingslashit(build_metadata_relative_path($fa_version));
	$files = $wp_filesystem->dirlist( $dir );

	$shorthands = [];

	if ( ! empty( $files ) ) {
	    foreach ( $files as $file => $fileinfo ) {
		    $shorthands[] = pathinfo( $file, PATHINFO_FILENAME );
	    }
	}

	return $shorthands;
}

function replace_font_awesome( $settings ) {
	$upload_dir = get_upload_dir();
	$fa_version = '7.1.0';
	$style_shorthands = get_style_shorthands( $upload_dir, $fa_version );

	$json_url =  trailingslashit( $upload_dir['baseurl'] ) . trailingslashit( build_metadata_relative_path($fa_version) ) . '%s.js';

	$shorthand_to_short_prefix_id = [
			'solid' => 'fas',
			'regular' => 'far',
			'light' => 'fal',
			'thin' => 'fat',
			'brands' => 'fab',
			'duotone' => 'fad',
			'sharp-solid' => 'fass',
			'sharp-regular' => 'fasr',
			'sharp-light' => 'fasl',
			'sharp-thin' => 'fast',
			'sharp-duotone-solid' => 'fasds',
			'sharp-duotone-regular' => 'fasdr',
			'sharp-duotone-light' => 'fasdl',
			'sharp-duotone-thin' => 'fasdt'
	];

	$icons = [];

	foreach($style_shorthands as $style_shorthand) {
		$short_prefix_id = $shorthand_to_short_prefix_id[$style_shorthand] ?? 'fas';

		$icons["fa-$style_shorthand"] = [
			'name' => "fa-$style_shorthand",
			'label' => "Font Awesome Pro - $style_shorthand",
			'url' => false,
			'enqueue' => false,
			'prefix' => 'fa-',
			'displayPrefix' => "$short_prefix_id",
			'labelIcon' => "$short_prefix_id fa-font-awesome",
			'ver' => $fa_version,
			'fetchJson' => sprintf( $json_url, $style_shorthand ),
			'native' => true,
			'render_callback' => 'render_font_awesome_svg_icon'
		];
	}
	// remove Free
	unset(
		$settings['fa-solid'],
		$settings['fa-regular'],
		$settings['fa-brands']
	);
	return array_merge( $icons, $settings );
}

function shorthand_to_short_prefix_id_map() {
	return [
			'solid' => 'fas',
			'regular' => 'far',
			'light' => 'fal',
			'thin' => 'fat',
			'brands' => 'fab',
			'duotone' => 'fad',
			'sharp-solid' => 'fass',
			'sharp-regular' => 'fasr',
			'sharp-light' => 'fasl',
			'sharp-thin' => 'fast',
			'sharp-duotone-solid' => 'fasds',
			'sharp-duotone-regular' => 'fasdr',
			'sharp-duotone-light' => 'fasdl',
			'sharp-duotone-thin' => 'fasdt'
	];
}

function short_prefix_id_to_shorthand_map() {
	$data = [];

	foreach (shorthand_to_short_prefix_id_map() as $shorthand => $short_prefix_id) {
		$data[$short_prefix_id] = $shorthand;
	}

	return $data;
}

function unprefixed_icon_name($prefix, $prefixed_icon_name) {
	$result = preg_replace('/^' . preg_quote($prefix, '/') . '/', '', $prefixed_icon_name);
	return $result;
}

function render_font_awesome_svg_icon($icon, $attributes = [], $tag = 'i') {
	$value_parts = explode(' ', $icon['value'], 2);

	error_log("render_callback for: ", print_r($icon, true));

	$short_prefix_id_to_shorthand = short_prefix_id_to_shorthand_map();
	$shorthand = $short_prefix_id_to_shorthand[$value_parts[0]] ?? 'solid';
	$icon_name = unprefixed_icon_name('fa-', $value_parts[1]);
	$icon_data = FortAwesome\FontAwesome_Elementor_Data_Manager::instance()->get_icon_data($shorthand, $icon_name);
	$width = $icon_data['width'] ?? null;
	$height = $icon_data['height'] ?? null;
	$path_data = $icon_data['path'] ?? null;

	if ( !is_integer( $width ) || !is_integer( $height ) ) {
		return '';
	}

	$paths = [];

	if ( is_string( $path_data ) ) {
		$paths[] = $path_data;
	} else if ( is_array( $path_data ) ) {
		foreach($path_data as $path) {
			if ( is_string( $path ) ) {
				$paths[] = $path;
			}
		}
	}

	if ( empty( $paths ) ) {
		return '';
	}

	$is_duotone = count( $paths ) > 1;

	$svg = sprintf('<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 %d %d">', esc_attr($width), esc_attr($height));

	foreach($paths as $index => $path) {
		if ( $is_duotone && $index === 0 ) {
			$svg .= sprintf('<path opacity=".4" d="%s"/>', esc_attr($path));
		} else {
			$svg .= sprintf('<path d="%s"/>', esc_attr($path));
		}
	}

	$svg .= '</svg>';

	error_log("REAL_SVG for: " . print_r($icon, true));

	return $svg;
}

function enqueue_fa_pro_css() {
	$upload_dir = get_upload_dir();
	$fa_version = FA_VERSION;
	$stylesheet_basenames = [
		'all',
		'sharp-solid',
		'sharp-regular',
		'sharp-light',
		'sharp-thin',
		'sharp-duotone-solid',
		'sharp-duotone-regular',
		'sharp-duotone-light',
		'sharp-duotone-thin'
	];

	foreach($stylesheet_basenames as $stylesheet_basename) {
		$stylesheet_rel_path = "css/$stylesheet_basename.min.css";
		$fa_pro_css_path = trailingslashit( get_versioned_selfhost_dir( $upload_dir, $fa_version ) ) . $stylesheet_rel_path;
		if ( file_exists( $fa_pro_css_path ) ) {
			$fa_pro_css_url = trailingslashit( $upload_dir['baseurl'] ) . trailingslashit( get_versioned_selfhost_relative_path( $fa_version ) ) . $stylesheet_rel_path;
			wp_enqueue_style( "font-awesome-pro-$stylesheet_basename", $fa_pro_css_url, [], $fa_version );
		}
	}
}

add_filter( 'elementor/icons_manager/native', 'replace_font_awesome' );
add_action( 'elementor/editor/after_enqueue_scripts', 'enqueue_fa_pro_css' );
add_action( 'elementor/frontend/after_enqueue_scripts', 'enqueue_fa_pro_css' );

/**
 * Recursively delete a directory
 */
function myplugin_rrmdir( $dir ) {
    if ( ! is_dir( $dir ) ) return;
    $items = scandir( $dir );
    foreach ( $items as $item ) {
        if ( $item == '.' || $item == '..' ) continue;
        $path = $dir . '/' . $item;
        if ( is_dir( $path ) ) {
            myplugin_rrmdir( $path );
        } else {
            unlink( $path );
        }
    }
    rmdir( $dir );
}

function fontawesome_elementor_add_on_activate_plugin() {
	$fa_version = FA_VERSION;
	$upload_dir = get_upload_dir();
	ensure_uploads_metadata_dir( $fa_version );
	extract_selectively( $upload_dir, $fa_version );
}

function initialize_fontawesome_elementor_data_manager() {
	$data_manager = FortAwesome\FontAwesome_Elementor_Data_Manager::instance();
	$data_manager->set_dir( get_versioned_selfhost_dir( get_upload_dir(), FA_VERSION ) );
}

initialize_fontawesome_elementor_data_manager();

add_action( 'activate_fontawesome-elementor-add-on/fontawesome-elementor-add-on.php', 'fontawesome_elementor_add_on_activate_plugin', -1 );

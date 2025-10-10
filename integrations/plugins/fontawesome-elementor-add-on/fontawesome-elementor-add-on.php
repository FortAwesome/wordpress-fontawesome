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
			foreach ($data as $icon_name => $icon_data) {
				foreach ($icon_data['svgs'] as $family => $style_map) {
					foreach ($style_map as $style => $svg_data) {
						$svg_object = [
							"width" => $svg_data['width'],
							"height" => $svg_data['height'],
							"path" => $svg_data['path']
						];
						$svg_object_json = json_encode($svg_object);
						$family_style_dir = trailingslashit($svg_objects_dir) . "$family/$style";

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
					}
				}
			}
	    } else {
	        error_log( 'JSON parse error: ' . json_last_error_msg() );
	    }
	}
}

function replace_font_awesome( $settings ) {
	$upload_dir = get_upload_dir();
	$fa_version = '7.1.0';
	$json_url =  trailingslashit( $upload_dir['baseurl'] ) . trailingslashit( build_metdata_relative_path($fa_version) ) . '%s.js';
	$icons['fa-regular'] = [
		'name' => 'fa-regular',
		'label' => esc_html__( 'Font Awesome - Regular Pro', 'elementor-pro' ),
		'url' => false,
		'enqueue' => false,
		'prefix' => 'fa-',
		'displayPrefix' => 'far',
		'labelIcon' => 'fab fa-font-awesome-alt',
		'ver' => $fa_version,
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
		'ver' => $fa_version,
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
		'ver' => $fa_version,
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
		'ver' => $fa_version,
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
		'ver' => $fa_version,
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
	//myplugin_download_and_extract( $fa_version, $upload_dir );
	extract_selectively( $upload_dir, $fa_version );
}

add_action( 'activate_fontawesome-elementor-add-on/fontawesome-elementor-add-on.php', 'fontawesome_elementor_add_on_activate_plugin', -1 );

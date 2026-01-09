<?php

/**
 * Plugin Name:       Font Awesome Elementor Addon
 * Plugin URI:        https://fontawesome.com/
 * Description:       Add Font Awesome Pro icons to Elementor.
 * Version:           0.0.1
 * Author:            Font Awesome
 * Author URI:        https://fontawesome.com/
 * License:           GPLv3
 */

defined( 'WPINC' ) || die;

define('FONT_AWESOME_ELEMENTOR_PLUGIN_VERSION', '0.0.1');

define( 'FONTAWESOME_PRO_ASSETS_DIR', 'font-awesome-pro-assets' );

// To use this experiment, make sure there's a web distribution zip file,
// like fontawesome-pro-7.1.0-web.zip, in /tmp, as configured by the following defines.
// On activation of this addon plugin, it will extract the necessary files.
// It may also require increasing PHP memory limits and max execution time.
// Add to php.ini:
// memory_limit = 512M
// max_execution_time = 600
define('FA_VERSION', '7.1.0');

require_once trailingslashit( __DIR__ ) . 'autoload.php';

use FontAwesomeLib\Base\Query_Resolver_Base;
use FontAwesomeLib\Base\Auth_Token_Provider_Base;
use FontAwesomeLib\Kit_Download;
use FontAwesomeLib\Metadata;

function fontawesome_elementor_addon_option_key() {
	return 'fontawesome_elementor_addon';
}

function get_upload_dir() {
	return wp_upload_dir( null, false, false );
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

function replace_font_awesome_native($settings) {
	// remove Free
	unset(
		$settings['fa-solid'],
		$settings['fa-regular'],
		$settings['fa-brands']
	);
	return $settings;
}

function fontawesome_elementor_fake_notify_warning($notices) {
	if (!class_exists('Elementor\Core\Admin\Notices\Base_Notice')) {
		return $notices;
	}

	require_once trailingslashit( __DIR__ ) . 'Notice.php';

	$title = __( 'Font Awesome Elementor Addon', 'fontawesome-elementor-addon' );

	$description = __( 'Thank you for installing the Font Awesome Elementor Addon! Start using Font Awesome icons in your Elementor designs today.', 'fontawesome-elementor-addon' );

	$notice = new \FontAwesomeElementorAddon\Notice($title, $description);

	return [$notice];

	//$message = sprintf(
	//	/* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
	//	esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'fontawesome-elementor-addon' ),
	//	'<strong>' . esc_html__( 'Font Awesome Elementor Addon', 'fontawesome-elementor-addon' ) . '</strong>',
	//	'<strong>' . esc_html__( 'Elementor', 'fontawesome-elementor-addon' ) . '</strong>',
	//	'42'
	//);

	//printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
}

// add_action('elementor/core/admin/notices', 'fontawesome_elementor_fake_notify_warning');

function fontawesome_elementor_addon_build_metadata(): array|WP_Error {
	$upload_dir = get_upload_dir();

	if ( (isset( $upload_dir['error'] ) && false !== $upload_dir['error']) || !isset( $upload_dir['basedir'] ) || !isset( $upload_dir['basedir'] ) ) {
		return new WP_Error(
			"fontawesome_elementor_addon_upload_dir_error",
			__(
				"Font Awesome Elementor Addon: failed to get WP upload dir.",
				"fontawesome-elementor-addon",
			)
		);
	}

	$option = get_option( fontawesome_elementor_addon_option_key() );

	if(!is_array($option) || !isset($option["kit_assets_relative_dir"])) {
		return new WP_Error(
			"fontawesome_elementor_addon_option_error",
			__(
				"Font Awesome Elementor Addon: no kit assets dir configured in options.",
				"fontawesome-elementor-addon",
			)
		);
	}

	$kit_assets_absolute_dir = trailingslashit( $upload_dir['basedir'] ) . trailingslashit( $option["kit_assets_relative_dir"] );

	if (!function_exists("WP_Filesystem")) {
    	require_once ABSPATH . "wp-admin/includes/file.php";
    }

    if (!WP_Filesystem(false)) {
    	return new WP_Error(
			"fontawesome_elementor_addon_filesystem_init_error",
			__(
				"Font Awesome Elementor Addon: WP_Filesystem could not be initialized.",
				"fontawesome-elementor-addon",
			)
		);
    }

    global $wp_filesystem;

    if (!$wp_filesystem->is_dir($kit_assets_absolute_dir)) {
    	return new WP_Error(
			"fontawesome_elementor_addon_kit_assets_dir_error",
			__(
				"Font Awesome Elementor Addon: kit assets dir is not a directory.",
				"fontawesome-elementor-addon",
			),
			["dir" => $kit_assets_absolute_dir]
		);
    }

    $kit_json_metadata_path = trailingslashit( $kit_assets_absolute_dir ) . 'metadata/kit.json';

    if (!$wp_filesystem->is_file($kit_json_metadata_path) || !$wp_filesystem->is_readable($kit_json_metadata_path)) {
    	return new WP_Error(
			"fontawesome_elementor_addon_kit_metadata_file_error",
			__(
				"Font Awesome Elementor Addon: kit metadata file is not accessible.",
				"fontawesome-elementor-addon",
			),
			["file" => $kit_json_metadata_path]
		);
    }

    $kit_json_metadata_str = $wp_filesystem->get_contents(
        $kit_json_metadata_path
    );

    if (!$kit_json_metadata_str) {
    	return new WP_Error(
			"fontawesome_elementor_addon_kit_metadata_read_error",
			__(
				"Font Awesome Elementor Addon: kit metadata file could not be read.",
				"fontawesome-elementor-addon",
			),
			["file" => $kit_json_metadata_path]
		);
    }

    $kit_metadata = json_decode($kit_json_metadata_str, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
    	return new WP_Error(
			"fontawesome_elementor_addon_kit_metadata_json_parse_error",
			__(
				"Font Awesome Elementor Addon: kit metadata JSON could not be parsed.",
				"fontawesome-elementor-addon",
			),
			["file" => $kit_json_metadata_path, "json_error" => json_last_error_msg()]
		);
    }

    // TODO: switch this validation to use JSON schema validation.
    if(!is_array($kit_metadata) || !isset($kit_metadata["included_family_styles"]) || !is_array($kit_metadata["included_family_styles"]) || !isset($kit_metadata["fontawesome_version"])) {
    	return new WP_Error(
			"fontawesome_elementor_addon_kit_metadata_invalid_error",
			__(
				"Font Awesome Elementor Addon: kit metadata is invalid.",
				"fontawesome-elementor-addon",
			),
			["file" => $kit_json_metadata_path, "metadata" => $kit_metadata]
		);
    }

    return [
    	"kit_metadata" => $kit_metadata,
		"kit_assets_absolute_dir" => $kit_assets_absolute_dir,
		"option" => $option,
		"upload_dir" => $upload_dir
    ];
}

// We have to add ours as "additional_tabs". Otherwise, their render_callback won't be used
// on initial insertion, because of Elementor's logic in:
// get_icon_manager_tabs()
function replace_font_awesome_additional_tabs() {
	$md = fontawesome_elementor_addon_build_metadata();

	if (is_wp_error( $md )) {
		error_log("Font Awesome Elementor Addon: failed to build metadata: " . $md->get_error_message() . "\n");
		return [];
	}

	$kit_metadata = $md["kit_metadata"];
	$upload_dir = $md["upload_dir"];
	$option = $md["option"];
	$kit_assets_absolute_dir = $md["kit_assets_absolute_dir"];

	$included_family_styles = $kit_metadata["included_family_styles"];

	$json_url =  trailingslashit( $upload_dir['baseurl'] ) . trailingslashit( $option["kit_assets_relative_dir"] ) . '/metadata/%s.json';

	$svg_data_dir = trailingslashit( $kit_assets_absolute_dir ) . 'svg-objects';
	$render_callback = function ($icon, $attributes, $tag) use( $svg_data_dir ) {
		return render_font_awesome_svg_icon($svg_data_dir, $icon, $attributes = [], $tag = 'i');
	};

	$icons = [];

	foreach($included_family_styles as $family_style) {
		if(!is_array($family_style) || !isset($family_style["prefix"]) || !isset($family_style["label"]) || !isset($family_style["shorthand"])) {
			error_log("Font Awesome Elementor Addon: kit metadata included_family_styles entry is missing expected properties.\n");
			continue;
		}

		$short_prefix_id = $family_style["prefix"];
		$label = $family_style["label"];
		$style_shorthand = $family_style["shorthand"];
		// TODO: lookup whether the current style includes the font-awesome icon.
		// If so, use that for the label icon.
		$label_icon = "eicon-font-awesome";

		// Use fapro prefix to avoid hardcoded 'fa-' prefix in Elementor that may cause
		// these to be handled like other Font Awesome Free icons using Elementor's built-in
		// Font Awesome Data Manager.
		$icons["fapro-$style_shorthand"] = [
			'name' => "fapro-$style_shorthand",
			'label' => "$label - FA Pro",
			'url' => false,
			'enqueue' => false,
			'prefix' => 'fa-',
			'displayPrefix' => "$short_prefix_id",
			'labelIcon' => $label_icon,
			'ver' => $kit_metadata["fontawesome_version"],
			'fetchJson' => sprintf( $json_url, $style_shorthand ),
			'native' => true,
			'render_callback' => $render_callback
		];
	}

	return $icons;
}

function unprefixed_icon_name($prefix, $prefixed_icon_name) {
	$result = preg_replace('/^' . preg_quote($prefix, '/') . '/', '', $prefixed_icon_name);
	return $result;
}

// This render_callback seems to fire on the backend in the editor, loading a saved page with
// with an icon. When initially inserting a new icon, it uses an `<i>` tag and relies on Webfont/CSS.
// When the Elementor experiment for inline SVGs is enabled, and our icon tabs are added as "native" tabs,
// then it bypasses this render_callback
// and uses its internal Font Awesome data manager to look up the SVG objects and render them.
// Of course, it won't have access to FA Pro styles and icons.
// So, to make this work on both the backend and front end, either that experiment must be disabled,
// or our icon tabs must be added as "additional_tabs".
//
// Disabling the experiment can be done in Elementor -> Settings --> Experiments --> Inline Font Icons.
// Or by adding this filter--see below:
//
// add_action('elementor/experiments/default-features-registered', function($experiments_manager) {
//   $experiments_manager->set_feature_default_state('e_font_icon_svg', 'inactive');
// });
function render_font_awesome_svg_icon($svg_data_dir, $icon, $attributes = [], $tag = 'i') {
	$value_parts = explode(' ', $icon['value'], 2);

	if ( count( $value_parts ) < 2 ) {
		return '';
	}

	$short_prefix_id_to_shorthand = short_prefix_id_to_shorthand_map();
	$shorthand = $short_prefix_id_to_shorthand[$value_parts[0]] ?? null;

	if ( is_null( $shorthand ) ) {
		return '';
	}

	$icon_name = unprefixed_icon_name('fa-', $value_parts[1]);
	$icon_data = get_icon_data($svg_data_dir, $shorthand, $icon_name);

	return render_svg_from_icon_data( $icon_data );
}

function render_svg_from_icon_data( $icon_data ) {
	if ( !is_array( $icon_data ) ) {
		return '';
	}

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

	return $svg;
}

function enqueue_fa_pro_css() {
	$md = fontawesome_elementor_addon_build_metadata();
	$build_id = $md["kit_metadata"]["build_id"];

	if (is_wp_error( $md )) {
		error_log("Font Awesome Elementor Addon: failed to build metadata: " . $md->get_error_message() . "\n");
		return;
	}

	$stylesheet_file_stems = array_map(function ($family_style) {
    	return Metadata::map_family_style_to_asset_file_stem($family_style["family"], $family_style["style"]);
    }, $md["kit_metadata"]["included_family_styles"]);

    $relative_kit_assets_url = trailingslashit($md["upload_dir"]["baseurl"]) . $md["option"]["kit_assets_relative_dir"];

    $fa_pro_css_url = trailingslashit( $relative_kit_assets_url ) . 'css/fontawesome.min.css';
    wp_enqueue_style( "font-awesome-pro-fontawesome", $fa_pro_css_url, [], $build_id );

	foreach($stylesheet_file_stem as $stylesheet_file_stem) {
		$stylesheet_rel_path = "css/$stylesheet_file_stem.min.css";
		$fa_pro_css_url = trailingslashit( $relative_kit_assets_url ) . $stylesheet_rel_path;
		wp_enqueue_style( "font-awesome-pro-$stylesheet_file_stem", $fa_pro_css_url, [], $build_id );
	}
}

add_filter( 'elementor/icons_manager/native', 'replace_font_awesome_native' );
add_filter( 'elementor/icons_manager/additional_tabs', 'replace_font_awesome_additional_tabs' );
add_action( 'elementor/editor/after_enqueue_scripts', 'enqueue_fa_pro_css' );
// If inline SVG rendering is working, then we don't need to enqueue the CSS on the frontend,
// unless we want to also have the CSS loaded for the sake of compatibility with any <i> tags that might
// be present.
add_action( 'elementor/frontend/after_enqueue_scripts', 'enqueue_fa_pro_css' );

function fontawesome_elementor_addon_activate_plugin() {
	$upload_dir = get_upload_dir();

	if ( isset( $upload_dir['error'] ) && false !== $upload_dir['error'] ) {
			wp_die(
            __('There was an error initializing the uploads directory for setting up the Font Awesome Kit', 'fontawesome-elementor-addon'),
            'Font Awesome Elementor Addon',
            ["back_link" => true]
        );
	}

	$api_token = getenv( 'API_TOKEN' );

	if ( false === $api_token || '' === $api_token ) {
		wp_die(
            __('No Font Awesome API token was found. Cannot initialize a Font Awesome Kit', 'fontawesome-elementor-addon'),
            'Font Awesome Elementor Addon',
            ["back_link" => true]
        );
	}

	$kit_token = getenv( 'KIT_TOKEN' );

	if ( false === $kit_token || '' === $kit_token ) {
		wp_die(
            __('No Font Awesome Kit token was found. Cannot initialize a Font Awesome Kit', 'fontawesome-elementor-addon'),
            'Font Awesome Elementor Addon',
            ["back_link" => true]
        );
	}

	$token_provider = new Auth_Token_Provider_Base($api_token);
	$access_token = $token_provider->get_access_token();
	$query_resolver = new Query_Resolver_Base();

	// Planned workflow:
	// 1. create_kit_download to get buildId. This will be returned to the client.
	// 2. poll with buildId until status is "READY".
	// 3. invoke download_and_prepare_selfhosting to download and extract the zip.

	// This is what it will look to initially create a kit download:
	$kit_download_initial = Kit_Download::create_kit_download( $query_resolver, $token_provider, $kit_token );

	if (is_wp_error( $kit_download_initial )) {
		$kit_download_initial->add(
            "fontawesome_elementor_addon_create_kit_download_error",
            __(
                "Font Awesome Elementor Addon was unable to create a Kit Download.",
                "fontawesome-elementor-addon",
            )
		);

		wp_die(
            $kit_download_initial,
            'Font Awesome Elementor Addon',
            ["back_link" => true]
        );
	}

	// When the client polls, it will provide the build_id and kit_token from above, which
	// will allow it to poll and/or download the zip:
	$kit_download = new Kit_Download(
		$kit_download_initial->get_kit_token(),
		$kit_download_initial->get_build_id()
	);

	$poll_result = $kit_download->poll( $query_resolver, $token_provider );

	if (is_wp_error( $poll_result )) {
		$poll_result->add(
			"fontawesome_elementor_addon_poll_kit_download_error",
			__(
				"Font Awesome Elementor Addon was unable to poll the Kit Download status.",
				"fontawesome-elementor-addon",
			)
		);

		wp_die(
            $poll_result,
            'Font Awesome Elementor Addon',
            ["back_link" => true]
        );
	}

	if (!$kit_download->is_ready()) {
		$wp_error = new WP_Error(
			"fontawesome_elementor_addon_kit_not_ready_error",
			__(
				"Font Awesome Elementor Addon Kit Download is not ready yet.",
				"fontawesome-elementor-addon",
			)
		);

		wp_die(
            $wp_error,
            'Font Awesome Elementor Addon',
            ["back_link" => true]
        );
	}

	$upload_base_dir = $upload_dir["basedir"];

	$kit_assets_absolute_dir = $kit_download->download_and_prepare_selfhosting($query_resolver, $token_provider, $upload_base_dir);

	if (is_wp_error( $kit_assets_absolute_dir )) {
		$kit_assets_absolute_dir->add(
			"fontawesome_elementor_addon_download_kit_error",
			__(
				"Font Awesome Elementor Addon was unable to download and prepare the Font Awesome Kit for self-hosting.",
				"fontawesome-elementor-addon",
			)
		);

		wp_die(
			$kit_assets_absolute_dir,
			'Font Awesome Elementor Addon',
			["back_link" => true]
		);
	}

	$kit_assets_relative_dir = str_replace( trailingslashit( $upload_base_dir ), '', trailingslashit( $kit_assets_absolute_dir ) );

	$options = [
		"option_schema_version" => 1,
		"kit_assets_relative_dir" => $kit_assets_relative_dir
	];

	$update_result = update_option( fontawesome_elementor_addon_option_key(), $options );

	if ( false === $update_result ) {
		$existing_option = get_option( fontawesome_elementor_addon_option_key() );

		if ($existing_option != $options) {
			wp_die(
				__('Font Awesome Elementor Addon was unable to save its configuration options.', 'fontawesome-elementor-addon'),
				'Font Awesome Elementor Addon',
				["back_link" => true]
			);
		}
	}
}

function get_icon_data( $dir, $style_shorthand, $icon_name ) {
	$file_path = $dir . "/svg-objects/$style_shorthand/$icon_name.json";

	if ( file_exists( $file_path ) && is_readable( $file_path ) ) {
	    $json_str = file_get_contents( $file_path );
		$data = json_decode( $json_str, true );

		if ( json_last_error() === JSON_ERROR_NONE ) {
			return $data;
		}
	}

	return [];
}

add_action( 'activate_fontawesome-elementor-addon/fontawesome-elementor-addon.php', 'fontawesome_elementor_addon_activate_plugin', -1 );

// Uncomment this to force the experiment off
// add_action('elementor/experiments/default-features-registered', function($experiments_manager) {
// 	$experiments_manager->set_feature_default_state('e_font_icon_svg', 'inactive');
// });

add_action('elementor/frontend/after_enqueue_scripts', function () {
	wp_register_script(
		'fontawesome-elementor-js',
		plugin_dir_url( __FILE__ ) . '/js/fontawesome-elementor.js',
		['jquery'],
		FONT_AWESOME_ELEMENTOR_PLUGIN_VERSION,
		[]
	);
	wp_enqueue_script('fontawesome-elementor-js');
});

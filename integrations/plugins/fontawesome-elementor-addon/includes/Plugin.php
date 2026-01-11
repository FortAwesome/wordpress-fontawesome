<?php

namespace FontAwesomeElementorAddon;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use FontAwesomeLib\Base\Query_Resolver_Base;
use FontAwesomeLib\Base\Auth_Token_Provider_Base;
use FontAwesomeLib\Svg_icon;
use FontAwesomeLib\Family_Style;
use FontAwesomeLib\Family_Style_Collection;

final class Plugin {
	/**
	 * Instance
	 *
	 * @since 0.1.0
	 * @access private
	 * @static
	 * @var \FontAwesomeElementorAddon\Plugin The single instance of the class.
	 */
	private static $_instance = null;

	/**
	 * Ensures only one instance of the class is loaded or can be loaded.
	 *
	 * @since 0.1.0
	 * @access public
	 * @static
	 * @return \FontAwesomeElementorAddon\Plugin An instance of the class.
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 * @access private
	 */
	private function __construct() { /* noop */ }

	/**
	 * Initialize
	 *
	 * @since 0.1.0
	 * @access public
	 */
	public function init(): void {
		if (! Compatibility::is_compatible_for_editing() ) {
			return;
		}

		// TODO: initialize any options or metadata needed

		add_action( 'elementor/editor/after_register_styles', [ $this, 'register_editor_styles' ] );
		add_action( 'elementor/editor/before_enqueue_styles', [ $this, 'enqueue_editor_styles' ] );
		add_filter( 'elementor/icons_manager/native', [ $this, 'replace_font_awesome_native' ]);
		add_filter( 'elementor/icons_manager/additional_tabs', [ $this, 'replace_font_awesome_additional_tabs' ] );
	}

	public function register_editor_styles(): void {

	}

	public function enqueue_editor_styles(): void {
		$this->enqueue_font_awesome_pro_css();
	}

	public function replace_font_awesome_native($settings) {
		// TODO: only remove Free for the styles we're replacing with Pro
		unset(
			$settings['fa-solid'],
			$settings['fa-regular'],
			$settings['fa-brands']
		);
		return $settings;
	}

	// We have to add ours as "additional_tabs". Otherwise, their render_callback won't be used
	// on initial insertion, because of Elementor's logic in:
	// get_icon_manager_tabs()
	public function replace_font_awesome_additional_tabs() {
		$md = $this->fontawesome_elementor_addon_build_metadata();

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

		if (!function_exists("WP_Filesystem")) {
	    	require_once ABSPATH . "wp-admin/includes/file.php";
	    }

	    if (!WP_Filesystem(false)) {
	       	error_log("Font Awesome Elementor Addon: failed to initialize WP_Filesystem.\n");
	       	return [];
	    }

	    global $wp_filesystem;

		$render_callback = function ($icon, $attributes, $tag) use( $included_family_styles, $svg_data_dir, $wp_filesystem ) {
			return $this->render_font_awesome_svg_icon($wp_filesystem, $svg_data_dir, $included_family_styles, $icon, $attributes = [], $tag = 'i');
		};

		$icons = [];

		foreach($included_family_styles as $family_style) {
			if(!is_array($family_style) || !isset($family_style["prefix"]) || !isset($family_style["label"]) || !isset($family_style["shorthand"])) {
				error_log("Font Awesome Elementor Addon: kit metadata included_family_styles entry is missing expected properties.\n");
				continue;
			}

			$label = $family_style["label"];
			$family_style_shorthand = $family_style["shorthand"];
			$short_prefix_id = $family_style["prefix"];

			// TODO: lookup whether the current style includes the font-awesome icon.
			// If so, use that for the label icon.
			$label_icon = "eicon-font-awesome";

			// Use fapro prefix to avoid hardcoded 'fa-' prefix in Elementor that may cause
			// these to be handled like other Font Awesome Free icons using Elementor's built-in
			// Font Awesome Data Manager.
			$icons["fapro-$family_style_shorthand"] = [
				'name' => "fapro-$family_style_shorthand",
				'label' => "$label - FA Pro",
				'url' => false,
				'enqueue' => false,
				'prefix' => 'fa-',
				'displayPrefix' => "$short_prefix_id",
				'labelIcon' => $label_icon,
				'ver' => $kit_metadata["fontawesome_version"],
				'fetchJson' => sprintf( $json_url, $family_style_shorthand ),
				'native' => true,
				'render_callback' => $render_callback
			];
		}

		return $icons;
	}

	private function fontawesome_elementor_addon_build_metadata(): array|WP_Error {
		$upload_dir = wp_upload_dir( null, false, false );

		if ( (isset( $upload_dir['error'] ) && false !== $upload_dir['error']) || !isset( $upload_dir['basedir'] ) || !isset( $upload_dir['baseurl'] ) ) {
			return new WP_Error(
				"fontawesome_elementor_addon_upload_dir_error",
				__(
					"Font Awesome Elementor Addon: failed to get WP upload dir.",
					"fontawesome-elementor-addon",
				)
			);
		}

		$option = get_option( Options::options_key() );

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

	private function unprefixed_icon_name($prefix, $prefixed_icon_name) {
		if (!is_string($prefixed_icon_name) || !is_string($prefix)) {
			return '';
		}

		return preg_replace('/^' . preg_quote($prefix, '/') . '/', '', $prefixed_icon_name);
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
	private function render_font_awesome_svg_icon($wp_filesystem, $svg_data_dir, $included_family_styles, $icon, $attributes = [], $tag = 'i') {
		$value_parts = explode(' ', $icon['value'], 2);

		if ( count( $value_parts ) < 2 ) {
			return '';
		}

		$family_style_collection = new Family_Style_Collection($included_family_styles);

		$family_style = $family_style_collection->get_by_short_prefix_id($value_parts[0]);

		$family_style_shorthand = $family_style->shorthand();

		if ( !is_string( $family_style_shorthand) ) {
			return '';
		}

		$icon_name = $this->unprefixed_icon_name('fa-', $value_parts[1]);
		$icon_data = $this->get_icon_data($wp_filesystem, $svg_data_dir, $family_style_shorthand, $icon_name);

		$svg_icon = new Svg_Icon($icon_data);
		return $svg_icon->stringify();
	}

	private function enqueue_font_awesome_pro_css() {
		$md = $this->fontawesome_elementor_addon_build_metadata();
		$build_id = $md["kit_metadata"]["build_id"];

		if (is_wp_error( $md )) {
			error_log("Font Awesome Elementor Addon: failed to build metadata: " . $md->get_error_message() . "\n");
			return;
		}

		$stylesheet_file_stems = array_map(function ($family_style) {
	    	return Family_Style::map_family_and_style_to_asset_file_stem($family_style["family"], $family_style["style"]);
	    }, $md["kit_metadata"]["included_family_styles"]);

	    $relative_kit_assets_url = trailingslashit($md["upload_dir"]["baseurl"]) . $md["option"]["kit_assets_relative_dir"];

	    $fa_pro_css_url = trailingslashit( $relative_kit_assets_url ) . 'css/fontawesome.min.css';
	    wp_enqueue_style( "font-awesome-pro-fontawesome", $fa_pro_css_url, [], $build_id );

		foreach($stylesheet_file_stems as $stylesheet_file_stem) {
			$stylesheet_rel_path = "css/$stylesheet_file_stem.min.css";
			$fa_pro_css_url = trailingslashit( $relative_kit_assets_url ) . $stylesheet_rel_path;
			wp_enqueue_style( "font-awesome-pro-$stylesheet_file_stem", $fa_pro_css_url, [], $build_id );
		}
	}

	private function get_icon_data( $wp_filesystem, $dir, $family_style_shorthand, $icon_name ) {
		$file_path = trailingslashit($dir) . "$family_style_shorthand/$icon_name.json";

		if ( $wp_filesystem->exists( $file_path ) && $wp_filesystem->is_readable( $file_path ) ) {
		    $json_str = $wp_filesystem->get_contents( $file_path );
			$data = json_decode( $json_str, true );

			if ( json_last_error() === JSON_ERROR_NONE ) {
				return $data;
			}
		}

		return [];
	}
}

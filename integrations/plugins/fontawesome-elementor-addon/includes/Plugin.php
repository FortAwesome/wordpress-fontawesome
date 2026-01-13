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
use \WP_Error;

final class Plugin {
	/**
	 * Plugin version.
	 *
	 * @since 0.1.0
	 * @access private
	 * @var string the plugin version.
	 */
	private $_plugin_version = '0.1.0';

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

		add_action( 'elementor/editor/after_enqueue_styles', fn () => $this->enqueue_editor_styles() );
		add_action( 'elementor/preview/enqueue_styles', fn () => $this->enqueue_preview_styles() );
		add_action( 'elementor/frontend/enqueue_styles', fn () => $this->enqueue_frontend_styles() );
		add_action( 'wp_ajax_fontawesome_elementor_get_editor_notice', fn () => $this->setup_editor_notice_handling() );
		add_action( 'elementor/editor/after_enqueue_scripts', fn () => $this->enqueue_editor_scripts() );

		add_filter( 'elementor/icons_manager/native', fn ($settings) => $this->replace_font_awesome_native($settings) );
		add_filter( 'elementor/icons_manager/additional_tabs', fn () => $this->replace_font_awesome_additional_tabs() );

		if ( is_admin() ) {
			Settings_Page::instance()->init();
		}
	}

	private function enqueue_preview_styles(): void {
		$this->enqueue_font_awesome_style_css();
		$this->enqueue_font_awesome_pro_css();
	}

	private function enqueue_frontend_styles(): void {
		$this->enqueue_font_awesome_style_css();
		$this->enqueue_font_awesome_pro_css();
	}

	private function enqueue_editor_styles(): void {
		$this->enqueue_font_awesome_pro_css();
	}

	private function enqueue_editor_scripts(): void {
		wp_enqueue_script(
			'fontawesome-elementor-addon-editor',
			plugins_url('assets/js/editor.js', dirname(__FILE__) ),
			['jquery'],
			$this->_plugin_version,
	  		true
		);

		wp_localize_script('fontawesome-elementor-addon-editor', 'FontawesomeElementorAddonEditor', [
			'nonce' => wp_create_nonce('fontawesome_elementor_addon'),
			'ajaxUrl' => admin_url('admin-ajax.php'),
		]);
	}

	private function setup_editor_notice_handling() {
	  check_ajax_referer('fontawesome_elementor_addon', 'nonce');

	  $user_id = get_current_user_id();
	  $notice  = get_user_meta($user_id, '_fontawesome_elementor_addon_editor_error', true);

	  if ($notice) {
	    delete_user_meta($user_id, '_fontawesome_elementor_addon_editor_error');
	  }

	  wp_send_json_success($notice ?: null);
	}

	private function replace_font_awesome_native($settings) {
		unset(
			$settings['fa-solid'],
			$settings['fa-regular'],
			$settings['fa-brands']
		);
		return $settings;
	}

	private function send_toast_notice($type, $message): void {
		if(!is_string($type) || !is_string($message)) {
			return;
		}

		update_user_meta(get_current_user_id(), '_fontawesome_elementor_addon_editor_error', [
		  'type' => $type,
		  'message' => $message,
		  'time' => time(),
		]);
	}

	/**
	 * Get metadata. If it has not already been read retrieved from storage, read and parse it now.
	 * If an error occurs, returns null and schedules an admin notice.
	 * @return array|null Kit metadata, or null on error.
	 */
	public function kit_metadata(): array|null {
		static $kit_metadata = null;

		if ( ! $kit_metadata ) {
			$result = $this->load_kit_metadata();

			if ( is_wp_error( $result ) ) {
				$this->send_toast_notice( 'error', $result->get_error_message() );
				return null;
			}

			$kit_metadata = $result;
		}

		return $kit_metadata;
	}

	public function upload_dir(): array|null {
		static $upload_dir = null;

		if (! $upload_dir ) {
			$upload_dir = wp_upload_dir( null, false, false );
		}

		return $upload_dir;
	}

	public function kit_assets_absolute_dir(): string|null {
		static $kit_assets_absolute_dir = null;

		if (! $kit_assets_absolute_dir ) {
			$upload_dir = $this->upload_dir();
			$option = $this->option();

			if (!is_array($upload_dir) || !is_array($option) || !isset($option["kit_assets_relative_dir"]) || !isset($upload_dir["basedir"])) {
				return null;
			}

			$kit_assets_absolute_dir = trailingslashit( $upload_dir['basedir'] ) . trailingslashit( $option["kit_assets_relative_dir"] );
		}

		return $kit_assets_absolute_dir;
	}

	public function option(): array|null {
		static $option = null;

		if ($option) {
			return $option;
		}

		$result = get_option( Options::options_key() );

		if (!is_array($result)) {
			return null;
		}

		$option = $result;

		return $option;
	}

	// We have to add ours as "additional_tabs". Otherwise, their render_callback won't be used
	// on initial insertion, because of Elementor's logic in:
	// get_icon_manager_tabs()
	private function replace_font_awesome_additional_tabs() {
		$kit_metadata = $this->kit_metadata();
		$upload_dir = $this->upload_dir();
		$kit_assets_absolute_dir = $this->kit_assets_absolute_dir();
		$option = $this->option();
  		$wp_filesystem = $this->wp_filesystem();

		if (!$kit_metadata || !$upload_dir || !$kit_assets_absolute_dir || !$option || is_wp_error( $wp_filesystem ) ) {
			return [];
		}

		$included_family_styles = $kit_metadata["included_family_styles"];

		$json_url =  trailingslashit( $upload_dir['baseurl'] ) . trailingslashit( $option["kit_assets_relative_dir"] ) . '/metadata/%s.json';

		$svg_data_dir = trailingslashit( $kit_assets_absolute_dir ) . 'svg-objects';

		$render_callback = function ($icon, $attributes, $tag) use( $included_family_styles, $svg_data_dir, $wp_filesystem ) {
			return $this->render_font_awesome_svg_icon($wp_filesystem, $svg_data_dir, $included_family_styles, $icon, $attributes = [], $tag = 'i');
		};

		$icons = [];

		foreach($included_family_styles as $family_style) {
			if(!is_array($family_style) || !isset($family_style["prefix"]) || !isset($family_style["label"]) || !isset($family_style["shorthand"])) {
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
				'enqueue' => $this->get_frontend_css_urls(),
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

	/**
	 * Get the WP_Filesystem instance, initializing it if necessary.
	 * @return \WP_Filesystem_Base|WP_Error WP_Filesystem instance on success, WP_Error on failure.
	 */
	private function wp_filesystem():\WP_Filesystem_Base|WP_Error {
		static $_wp_filesystem = null;

		if ( $_wp_filesystem ) {
			return $_wp_filesystem;
		}

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

	    $_wp_filesystem = $wp_filesystem;

		return $_wp_filesystem;
	}

	/**
	 * Load kit metadata from storage.
	 * @return array|WP_Error array with keys 'kit_metadata', 'kit_assets_absolute_dir', 'option', and 'upload_dir' on success, WP_Error on failure.
	 */
	private function load_kit_metadata(): array|WP_Error {
		$upload_dir = $this->upload_dir();

		if ( !is_array($upload_dir) || (isset( $upload_dir['error'] ) && false !== $upload_dir['error']) || !isset( $upload_dir['basedir'] ) || !isset( $upload_dir['baseurl'] ) ) {
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

		$kit_assets_absolute_dir = $this->kit_assets_absolute_dir();

		$wp_filesystem = $this->wp_filesystem();

		if (is_wp_error( $wp_filesystem )) {
			return $wp_filesystem;
		}

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

	    if( !is_array($kit_metadata) || !isset($kit_metadata["included_family_styles"]) || !is_array($kit_metadata["included_family_styles"]) || !isset($kit_metadata["fontawesome_version"]) || !isset($kit_metadata["build_id"]) ) {
	    	return new WP_Error(
					"fontawesome_elementor_addon_kit_metadata_invalid_error",
					__(
						"Font Awesome Elementor Addon: kit metadata is invalid.",
						"fontawesome-elementor-addon",
					),
					["file" => $kit_json_metadata_path, "metadata" => $kit_metadata]
				);
	    }

	    return $kit_metadata;
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
		return $svg_icon->stringify(["class" => "fontawesome-elementor-addon-icon"]);
	}

	private function style_resource_handle_prefix(): string {
		return "font-awesome-pro-";
	}

	private function get_css_url_common_data(): ?array {
		$kit_metadata = $this->kit_metadata();
		$upload_dir = $this->upload_dir();
		$option = $this->option();

		if (
			!is_array( $upload_dir )
			|| !isset( $upload_dir["baseurl"] )
			|| !is_array( $option )
			|| !isset( $option["kit_assets_relative_dir"] )
			|| !is_array( $kit_metadata )
			|| !isset( $kit_metadata["build_id"] )
			|| !is_string( $kit_metadata["build_id"] )
			|| !isset( $kit_metadata["included_family_styles"] )
			|| !is_array( $kit_metadata["included_family_styles"] )
			) {
			return null;
		}

		$build_id = $kit_metadata["build_id"];

  		$url = trailingslashit($upload_dir["baseurl"]) . $option["kit_assets_relative_dir"];

        return [
        	"kit_assets_relative_url" => $url,
			"build_id" => $build_id,
			"included_family_styles" => $kit_metadata["included_family_styles"]
        ];
	}

	private function get_style_css_url(): string {
		return plugins_url('assets/css/style.css', dirname(__FILE__) );
	}

	private function get_style_css_resource_handle(): string {
		return "font-awesome-pro-style";
	}

	private function enqueue_font_awesome_style_css(): void {
     	wp_enqueue_style( $this->get_style_css_resource_handle(), $this->get_style_css_url(), [], $this->_plugin_version );
      	$this->add_inline_style( $this->get_style_css_resource_handle() );
	}

	private function webfont_icon_element_tag(): string {
		return 'i';
	}

	private function add_inline_style( $resource_handle ): void {
		$kit_metadata = $this->kit_metadata();

		if ( !is_array( $kit_metadata) || !isset( $kit_metadata["included_family_styles"] ) || !is_array( $kit_metadata["included_family_styles"] ) || !is_string( $resource_handle )) {
			return;
		}

		$css_selector_parts = array_map(function ($family_style) {
			if (
				!is_array( $family_style )
				|| !isset( $family_style["prefix"] )
			) {
				return null;
			}

	    	return "." . $family_style["prefix"];
	    }, $kit_metadata["included_family_styles"]);

		$filtered_css_selector_parts = array_filter($css_selector_parts, fn($part) => is_string($part) && $part !== '');

		$is_selector = implode( ',', $filtered_css_selector_parts );

		$tag = $this->webfont_icon_element_tag();

		$selector = ".elementor-icon $tag:is($is_selector)";

		$style = ".elementor-icon i";

		$style = <<< EOT
$selector {
  width: var(--fa-width, 1.25em);
}
EOT;
		wp_add_inline_style(
			$resource_handle,
			$style
		);
	}

	private function get_webfont_css_urls(): ?array {
		$data = $this->get_css_url_common_data();

		if ( !is_array( $data) ) {
			return null;
		}

		$stylesheet_file_stems = array_map(function ($family_style) {
			if (
				!is_array( $family_style )
				|| !isset( $family_style["family"] )
				|| !isset( $family_style["style"] )
				|| !is_string( $family_style["family"] )
				|| !is_string( $family_style["style"] )
			) {
				return null;
			}

	    	return Family_Style::map_family_and_style_to_asset_file_stem($family_style["family"], $family_style["style"]);
	    }, $data["included_family_styles"]);

		$filtered_stylesheet_file_stems = array_filter($stylesheet_file_stems, fn($stem) => is_string($stem) && $stem !== '');

		$urls = [
  			trailingslashit( $data["kit_assets_relative_url"] ) . 'css/fontawesome.min.css'
		];

		foreach($filtered_stylesheet_file_stems as $stylesheet_file_stem) {
			$stylesheet_rel_path = "css/$stylesheet_file_stem.min.css";
			$url = trailingslashit( $data["kit_assets_relative_url"] ) . $stylesheet_rel_path;
			$urls[] = $url;
		}

		$data["webfont_css_urls"] = $urls;

		return $data;
	}

	private function enqueue_font_awesome_pro_css(): void {
		$data = $this->get_webfont_css_urls();

		if ( !is_array( $data) || !isset( $data["webfont_css_urls"] ) || !is_array( $data["webfont_css_urls"] ) ) {
			return;
		}

		$build_id = $data["build_id"];

		foreach( $data["webfont_css_urls"] as $index => $url ) {
   			wp_enqueue_style( "font-awesome-pro-$index", $url, [], $build_id );
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

	private function get_frontend_css_urls() {
		return [ $this->get_style_css_url() ];
	}
}

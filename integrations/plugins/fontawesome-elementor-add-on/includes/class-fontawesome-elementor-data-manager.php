<?php

/**
 * Font Awesome Elementor Data Manager.
 */

namespace FortAwesome;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class FontAwesome_Elementor_Data_Manager {
	protected static $instance = null;

	protected $data = [];

	protected $dir = null;

	private function __construct() {
	}

	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	public function set_dir( $dir ) {
		$this->dir = $dir;
	}

	public function get_icon_data( $style_shorthand, $icon_name ) {
		$file_path= $this->dir . "/svg-objects/$style_shorthand/$icon_name.json";
		error_log("FILE_PATH: $file_path");

		if ( file_exists( $file_path ) && is_readable( $file_path ) ) {
		    $json_str = file_get_contents( $file_path );
			$data = json_decode( $json_str, true );

			if ( json_last_error() === JSON_ERROR_NONE ) {
				return $data;
			}
		}

		return [];
	}
}

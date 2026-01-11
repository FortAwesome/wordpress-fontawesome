<?php

namespace FontAwesomeElementorAddon;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use FontAwesomeLib\Base\Query_Resolver_Base;
use FontAwesomeLib\Base\Auth_Token_Provider_Base;

class Compatibility {
	/**
	 * Minimum PHP Version
	 *
	 * @since 0.1.0
	 * @var string Minimum PHP version required to run the addon.
	 */
	const MINIMUM_PHP_VERSION = '7.4';

	public static function is_compatible_for_activation(): bool {
		if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', [ 'FontAwesomeElementorAddon\Compatibility', 'admin_notice_minimum_php_version' ] );
			return false;
		}

		if (! self::check_compatibility_wp_filesystem() ) {
			return false;
		}

		global $wp_filesystem;

		if (! self::check_compatibility_wp_upload_dir($wp_filesystem)) {
			return false;
		}

		if (! self::check_compatibility_temp_dir($wp_filesystem)) {
			return false;
		}

		if (! self::check_compatibility_api_service() ) {
			return false;
		}

		return true;
	}

	public static function is_compatible_for_editing(): bool {
		if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', [ 'FontAwesomeElementorAddon\Compatibility', 'admin_notice_minimum_php_version' ] );
			return false;
		}

		if (! self::check_compatibility_wp_filesystem() ) {
			return false;
		}

		return true;
	}

	private static function check_compatibility_api_service(): bool {
		$query_resolver = new Query_Resolver_Base();
		$auth_token_provider = new Auth_Token_Provider_Base('FAKE_API_TOKEN');
		$query = <<<EOT
        query {
          release(version: "7.x") {
            version
          }
        }
        EOT;

		$response = $query_resolver->query(["query" => $query], $auth_token_provider, ["ignore_auth" => true]);

		if (is_wp_error($response) || 200 !== wp_remote_retrieve_response_code($response) ) {
			add_action( 'admin_notices', [ 'FontAwesomeElementorAddon\Compatibility', 'admin_notice_api_service_requirement' ] );
			return false;
		}

		return true;
	}

	private static function check_compatibility_wp_filesystem(): bool {
		if (!function_exists("WP_Filesystem")) {
    		require_once ABSPATH . "wp-admin/includes/file.php";
    	}

	    if (!WP_Filesystem(false)) {
			add_action( 'admin_notices', [ 'FontAwesomeElementorAddon\Compatibility', 'admin_notice_wp_filesystem_requirement' ] );
			return false;
	    }

		return true;
	}

	private static function check_compatibility_wp_upload_dir($wp_filesystem): bool {
		$upload_dir = wp_upload_dir( null, false, false );

		if ( !is_array($upload_dir) || (isset( $upload_dir['error'] ) && false !== $upload_dir['error']) || !isset( $upload_dir['basedir'] ) || !isset( $upload_dir['baseurl'] ) || !$wp_filesystem->is_dir( $upload_dir['basedir'] ) || !$wp_filesystem->is_writable( $upload_dir['basedir'] ) ) {
			add_action( 'admin_notices', [ 'FontAwesomeElementorAddon\Compatibility', 'admin_notice_wp_upload_dir_requirement' ] );
			return false;
		}

		return true;
	}

	private static function check_compatibility_temp_dir($wp_filesystem): bool {
		// Check for temp dir write access.
		$base_temp_dir = get_temp_dir();

  		$temp_dir =
            $base_temp_dir .
            "fontawesome-elementor-addon-" .
            wp_generate_uuid4() .
            "/";

        $was_temp_dir_created = $wp_filesystem->mkdir($temp_dir);

        if (!$was_temp_dir_created) {
        	add_action( 'admin_notices', [ 'FontAwesomeElementorAddon\Compatibility', 'admin_notice_temp_dir_requirement' ] );
			return false;
        }

        try {
        	$wp_filesystem->delete($temp_dir, true);
        } catch (\Exception $e) {}

        return true;
	}
}

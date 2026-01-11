<?php

namespace FontAwesomeElementorAddon;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use FontAwesomeLib\Base\Query_Resolver_Base;
use FontAwesomeLib\Base\Auth_Token_Provider_Base;
use FontAwesomeLib\Kit_Download;
use FontAwesomeElementorAddon\Options;

class Setup_Kit {
	public static function setup($api_token, $kit_token) {
		$upload_dir = \wp_upload_dir( null, false, false );

		if ( isset( $upload_dir['error'] ) && false !== $upload_dir['error'] ) {
				wp_die(
            __('There was an error initializing the uploads directory for setting up the Font Awesome Kit', 'fontawesome-elementor-addon'),
            'Font Awesome Elementor Addon',
            ["back_link" => true]
        );
		}

		if ( !is_string($api_token) || '' === $api_token ) {
			wp_die(
            __('No Font Awesome API token was found. Cannot initialize a Font Awesome Kit', 'fontawesome-elementor-addon'),
            'Font Awesome Elementor Addon',
            ["back_link" => true]
        );
		}

		if ( !is_string( $kit_token ) || '' === $kit_token ) {
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

		$update_result = update_option( Options::options_key(), $options );

		if ( false === $update_result ) {
			$existing_option = get_option( Options::options_key() );

			if ($existing_option != $options) {
				wp_die(
					__('Font Awesome Elementor Addon was unable to save its configuration options.', 'fontawesome-elementor-addon'),
					'Font Awesome Elementor Addon',
					["back_link" => true]
				);
			}
		}
	}
}

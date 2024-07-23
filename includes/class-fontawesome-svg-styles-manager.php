<?php
namespace FortAwesome;

/**
 * Class FontAwesome_SVG_Styles_Manager
 */
class FontAwesome_SVG_Styles_Manager {
	/**
	 * Indicates whether to enqueue the kit.
	 *
	 * @since 4.5.0
	 * @return bool
	 */
	public static function skip_enqueue_kit() {
		/**
		 * Determines whether to enqueue the kit.
		 *
		 * @since 4.5.0
		 */
		return apply_filters( 'font_awesome_skip_enqueue_kit', false );
	}

	/**
     * Given the plugin's options, as would be returned by `get_option(FontAwesome::OPTIONS_KEY)`,
     * returns `true` when the options indicate that webfont technology
     * is in use, or when `$is_skipping_enqueue_kit` is `false`.
     *
     * These `true` conditions mean that the SVG support styles must be loaded
     * either via CDN or self-host, in order to support inline SVG icons, such
     * as those that may be added in the block editor.
     *
     * When an SVG kit is already being loaded, it's not necessary to separately
     * load the SVG support styles, because the kit does that itself.
     *
	 * @since 4.5.0
	 * @param $options array
	 * @param $is_skipping_enqueue_kit bool
	 * @return bool
 	 */
	public static function requires_additional_svg_support_css($options, $is_skipping_enqueue_kit = false) {
		if ( boolval( $is_skipping_enqueue_kit ) ) {
			return true;
		}

		if (
		    is_array( $options ) &&
			isset( $options['technology'] ) &&
			$options['technology'] === 'webfont'
		) {
			return true;
		}

		return false;
	}

	public static function asset_path($version) {
		$upload_dir = wp_upload_dir(null, true, false);

		if ( isset( $upload_dir['error'] ) && false !== $upload_dir['error'] ) {
			// TODO: exception
			return;
		}

		// TODO: refactor with asset_url
		$asset_subdir = "font-awesome/v$version/css";

		$file = 'svg-with-js.css';

		$asset_subpath = "$asset_subdir/$file";

		return [
			'dir' => trailingslashit( $upload_dir['basedir'] ) . $asset_subdir,
			'file' => $file
		];
	}

	public static function asset_url($version) {
		$upload_dir = wp_upload_dir(null, false, false);

		if ( isset( $upload_dir['error'] ) && false !== $upload_dir['error'] ) {
			// TODO: exception
			return;
		}

		$asset_subpath_subdir = "font-awesome/v$version/css";

		$asset_subpath = "$asset_subpath_subdir/svg-with-js.css";

		return trailingslashit( $upload_dir['baseurl'] ) . $asset_subpath;
	}

	/**
    * If self-hosting is required, this ensures that the SVG support style asset(s)
    * have been retrieved for self-hosting.
    *
	 * @throws ReleaseMetadataMissingException
	 * @throws ApiRequestException
	 * @throws ApiResponseException
	 * @throws ReleaseProviderStorageException
	 * @throws ConfigCorruptionException when called with an invalid configuration
	 * @return void
 	*/
	public static function maybe_setup_selfhosting($options) {
		$is_skipping_enqueue_kit = self::skip_enqueue_kit();

		if ( ! self::requires_additional_svg_support_css($options, $is_skipping_enqueue_kit) ) {
			return;
		}

		$version_option = isset( $options['version'] ) ? $options['version'] : null;

		$concrete_version = null;

		if ( $version_option === 'latest' ) {
			$concrete_version = fa()->latest_version_5();
		} else if ( $version_option === '5.x' ) {
			$concrete_version = fa()->latest_version_5();
		} else if ( $version_option === '6.x' ) {
			$concrete_version = fa()->latest_version_6();
		} else {
			$concrete_version = $version_option;
		}

		if ( ! $concrete_version ) {
			// TODO: throw a new kind of exception here.
			return;
		}

		$asset_path = self::asset_path( $concrete_version );

		if ( !$asset_path || ! isset($asset_path['dir']) || ! isset($asset_path['file'])) {
			// TODO: exception
			return;
		}

		$full_asset_path = trailingslashit( $asset_path['dir'] ) . $asset_path['file'];

		if ( file_exists( $full_asset_path ) ) {
			// Nothing more to do.
			return;
		}

	    $resource = fa_release_provider()->get_svg_support_styles_resource($concrete_version);

		if ( ! $resource->source() || ! $resource->integrity_key() ) {
			// TODO: throw a new kind of exception here.
			return;
		}

		$response = wp_remote_get( $resource->source() );

		if ( is_wp_error( $response ) ) {
			// TODO: throw an exception
			return;
		}

		$code = null;

		if ( isset( $response['response']['code'] ) ) {
			$code = $response['response']['code'];
		}

		if ( ! $code || $code >= 400 || ! isset( $response['body'] ) ) {
			// TODO: throw exception
			return;
		}

		$hyphen_pos = strpos( $resource->integrity_key(), '-' );

		if ( $hyphen_pos === false ) {
			// TODO: exception
			return;
		}

		$algo = substr( $resource->integrity_key(), 0, $hyphen_pos );

		if ( ! in_array($algo, hash_algos() ) ) {
			// TODO: throw exception
			return;
		}

		$hash_hex = hash($algo, $response['body']);

		$hash_bin = hex2bin($hash_hex);
		if ( ! $hash_bin ) {
			// TOOD: exception
			return;
		}

		$hash = base64_encode( $hash_bin );

		if ( "$algo-$hash" !== $resource->integrity_key() ) {
			// TODO: throw exception
			return;
		}

		wp_mkdir_p( $asset_path['dir'] );

		if ( ! file_exists( $asset_path['dir'] ) ) {
			// TODO: exception
			return;
		}

		$fp = fopen($full_asset_path, 'w');

		if ( $fp === false ) {
			// TODO: exception
			return;
		}

		$write_result = fwrite( $fp, $response['body'] );

		if ( $write_result === false ) {
			// TODO: exception
			return;
		}
	}
}

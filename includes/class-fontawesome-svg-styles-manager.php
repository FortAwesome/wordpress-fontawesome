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
     * Internal use only. This is not part of the plugin's public API.
     *
     * However, this relies on the `font_awesome_enqueue_additional_svg_styles` filter,
     * which *is* part of the public API.
     *
     * @internal
     * @ignore
	 * @param $options array
	 * @return string | false
 	 */
	public static function additional_svg_styles_loading($options) {
		$using_kit = FontAwesome::using_kit_given_options($options);
		$tech = 'webfont';
		$load_mode = false;
		$skip_enqueue_kit = self::skip_enqueue_kit();
		$pro = false;

		if ( isset( $options['usePro'] ) && boolval( $options['usePro'] ) ) {
			$pro = true;
		}

		if (
		    is_array( $options ) &&
			isset( $options['technology'] )
		) {
			$tech = $options['technology'];
		}

		// Initial setting.
		if ( $tech === 'webfont' ){
			$load_mode = 'cdn';
		} else if ( $using_kit && $skip_enqueue_kit ) {
			/* 
             * When using an SVG kit, and not enqueuing it on the front end,
             * this implies that supporting styles should also not use the CDN.
             */
			$load_mode = 'selfhost';
		} else {
			$load_mode = false;
		}

		/**
 	 	 * Determine whether and how to enqueue the SVG support styles asset.
 	 	 *
 	 	 * As of plugin version 4.5.0, the SVG support styles are required to
 	 	 * support the SVG icons added using the icon chooser.
 	 	 *
 	 	 * When using SVG tech, either with a kit or the legacy CDN, it's not
 	 	 * necessary to enqueue this *additional* stylesheet, because the SVG
 	 	 * tech's JavaScript automatically injects the support styles into the
 	 	 * DOM when loaded in the browser.
 	 	 *
 	 	 * However, the `font_awesome_skip_enqueue_kit` filter might be used to
 	 	 * disable the loading of the kit on the front end, in order not to use
 	 	 * a CDN, for example.
 	 	 *
 	 	 * For such cases, where there will be no automatic injection of the
 	 	 * SVG support styles into the DOM, this additional stylesheet can be
 	 	 * enqueued separately.
 	 	 *
 	 	 * It can be loaded from either CDN, or retrieved and stored on the
 	 	 * WordPress server for self-hosting.
 	 	 *
 	 	 * Valid values:
 	 	 *
 	 	 * - `false`: no additional support styles will be enqueued.
 	 	 * - "cdn": enqueue the additional support styles from the Font Awesome CDN.
 	 	 * - "selfhost": retrieve the additional stylesheet and store it on the WordPress
 	 	 *   server for self-hosting.
 	 	 *
 	 	 * @since 4.5.0
 	 	 */
		return apply_filters(
			'font_awesome_enqueue_additional_svg_styles',
			$load_mode,
			[
				'using_kit' => $using_kit,
				'tech' => $tech,
				'pro' => $pro,
				'skip_enqueue_kit' => $skip_enqueue_kit
			]
		);
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

		if ( self::additional_svg_styles_loading($options, $is_skipping_enqueue_kit) !== 'selfhost' ) {
			return;
		}

		$concrete_version = fa()->concrete_version( $options );

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

	    $resource = fa_release_provider()->get_svg_styles_resource($concrete_version);

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

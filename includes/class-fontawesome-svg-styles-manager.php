<?php

namespace FortAwesome;

/**
 * Class FontAwesome_SVG_Styles_Manager
 */
class FontAwesome_SVG_Styles_Manager {

	/**
	 * The handle used when enqueuing SVG support styles.
	 *
	 * @since 5.0.0
	 */
	public const RESOURCE_HANDLE_SVG_STYLES = 'font-awesome-svg-styles';

	/**
	 * @internal
	 * @ignore
	 */
	protected static $instance = null;

	/**
	 * Returns the singleton instance of this class.
	 *
	 * Internal use only, not part of this plugin's public API.
	 *
	 * Ideally, this wouldn't be a singleton, but being a singleton will
	 * make it mockable with PHPUnit.
	 *
	 * @internal
	 * @ignore
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Internal use only, not part of this plugin's public API.
	 *
	 * @internal
	 * @ignore
	 */
	private function __construct() {
		/* noop */
	}

	/**
	 * Indicates whether to enqueue the kit.
	 *
	 * Internal use only, not part of the plugin's public API.
	 *
	 * However, this depends on the `font_awesome_skip_enqueue_kit` filter
	 * which is part of the public API.
	 *
	 * @internal
	 * @ignore
	 */
	public function skip_enqueue_kit() {
		/**
		 * Determines whether to skip the kit enqueue.
		 *
		 * When the plugin is configured to use a kit, the normal behavior is
		 * to use `wp_enqueue_script()` to enqueue the kit's embed code, a JavaScript
		 * loaded from the Font Awesome Kits CDN. The kit being loaded on front end page
		 * renderings enables rendering `<i>` tags, for example, as Font Awesome icons.
		 *
		 * By setting this to `true`, that `wp_enqueue_script()` will be skipped. Thus, the
		 * kit will not be loaded from the Font Awesome CDN on front end page loads. As a
		 * consequence, this plugin will not render `<i>` tags as Font Awesome icons.
		 *
		 * You may prefer to skip loading the kit if:
		 *
		 * 1. You only use the block editor.
		 *
		 * As of version 5.0.0 of this plugin, icons are added in the
		 * block editor as `<svg>` elements and require no further rendering like `<i>` tags.
		 *
		 * 2. You want to avoid using a CDN for front end page loads.
		 *
		 * If you want to avoid using the CDN for front end page loads, you should also use the
		 * `font_awesome_svg_styles_loading` filter and return a value of "selfhost" in order
		 * to fetch and selfhost the support styles for those SVGs inserted in the block editor.
		 *
		 * Even when disabling the use of CDN for front end page loads, the back end still uses the CDN
		 * for editing content.
		 *
		 * Default: false (that is, by default, enqueue the kit to be loaded from the CDN)
		 *
		 * @since 5.0.0
		 */
		return apply_filters( 'font_awesome_skip_enqueue_kit', false );
	}

	/**
	 * Internal use only. This is not part of the plugin's public API.
	 *
	 * However, this relies on the `font_awesome_svg_styles_loading` filter,
	 * which *is* part of the public API.
	 *
	 * @internal
	 * @ignore
	 * @param $fa FontAwesome
	 * @return string | false
	 */
	public function additional_svg_styles_loading( $fa ) {
		$tech             = $fa->technology();
		$using_kit        = $fa->using_kit();
		$skip_enqueue_kit = $this->skip_enqueue_kit();

		// Initial setting.
		if ( 'webfont' === $tech ) {
			$load_mode = 'cdn';
		} elseif ( $using_kit && $skip_enqueue_kit ) {
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
		 * The first filter argument is either "cdn" or "selfhost", the current value
		 * for `font_awesome_svg_styles_loading`.
		 *
		 * The second filter argument is an associative array with the following keys:
		 * - `using_kit`: boolean, whether the plugin is configured to use a kit.
		 * - `tech`: string, either "svg" or "webfont".
		 * - `skip_enqueue_kit`: boolean, whether the kit's enqueue is being skipped.
		 *
		 * Valid return values:
		 *
		 * - `false`: no additional support styles will be enqueued.
		 * - "cdn": enqueue the additional support styles from the Font Awesome CDN.
		 * - "selfhost": retrieve the additional stylesheet and store it on the WordPress
		 *   server for self-hosting.
		 *
		 * @since 5.0.0
		 */
		return apply_filters(
			'font_awesome_svg_styles_loading',
			$load_mode,
			array(
				'using_kit'        => $using_kit,
				'tech'             => $tech,
				'skip_enqueue_kit' => $skip_enqueue_kit,
			)
		);
	}

	/**
	 * Internal use only, not part of this plugin's public API.
	 *
	 * The asset path on the server's filesystem, where the svg support stylesheet
	 * is stored. This uses `wp_upload_dir()`.
	 *
	 * @throws SelfhostSetupException
	 * @internal
	 * @ignore
	 */
	public function selfhost_asset_path( $version ) {
		$upload_dir = wp_upload_dir( null, true, false );

		if ( isset( $upload_dir['error'] ) && false !== $upload_dir['error'] ) {
			throw new SelfhostSetupException(
				esc_html__(
					'Failed to get or initialize WP uploads directory.',
					'font-awesome'
				)
			);
		}

		return array(
			'dir'  => trailingslashit( $upload_dir['basedir'] ) . $this->selfhost_asset_subdir( $version ),
			'file' => $this->selfhost_asset_filename(),
		);
	}

	/**
	 * Internal use only, not part of this plugin's public API.
	 *
	 * The URL source to use with `wp_enqueue_style()` when self-hosting the SVG styles.
	 *
	 * @throws SelfhostSetupException
	 * @internal
	 * @ignore
	 */
	public function selfhost_asset_url( $version ) {
		$upload_dir = wp_upload_dir( null, false, false );

		if ( isset( $upload_dir['error'] ) && false !== $upload_dir['error'] ) {
			throw new SelfhostSetupException(
				esc_html__(
					'Failed to get WP uploads directory.',
					'font-awesome'
				)
			);
		}

		return trailingslashit( $upload_dir['baseurl'] ) . $this->selfhost_asset_subpath( $version );
	}

	/**
	 * Internal use only, not part of this plugin's public API.
	 *
	 * @ignore
	 * @internal
	 */
	public function selfhost_asset_subdir( $version ) {
		return "font-awesome/v$version/css";
	}

	/**
	 * Internal use only, not part of this plugin's public API.
	 *
	 * @ignore
	 * @internal
	 */
	public function selfhost_asset_filename() {
		return 'svg-with-js.css';
	}

	/**
	 * Internal use only, not part of this plugin's public API.
	 *
	 * @ignore
	 * @internal
	 */
	public function selfhost_asset_subpath( $version ) {
		return trailingslashit( $this->selfhost_asset_subdir( $version ) ) . $this->selfhost_asset_filename();
	}

	/**
	 * Internal use only, not part of the plugin's public API.
	 *
	 * However, this relies on the `font_awesome_svg_styles_loading` filter,
	 * which *is* part of the public API.
	 *
	 * This registers the svg styles stylesheet according to cdn or selfhost
	 * loading, using cdn by default, which can be override by the
	 * `font_awesome_svg_styles_loading` filter.
	 *
	 * It also adds an action to update the `<link>` with an sri integrity key,
	 * whether loaded from cdn or selfhost.
	 *
	 * @internal
	 * @ignore
	 */
	public function register_svg_styles( $fa, $fa_release_provider ) {
		$load_mode = 'cdn';

		$load_mode = apply_filters(
			'font_awesome_svg_styles_loading',
			$load_mode,
			array(
				'using_kit' => $fa->using_kit(),
				'tech'      => $fa->technology(),
			)
		);

		$concrete_version = $fa->concrete_version( $fa->options() );

		$cdn_resource = $fa_release_provider->get_svg_styles_resource( $concrete_version );

		$integrity_key = $cdn_resource->integrity_key();

		$source = $cdn_resource->source();

		if ( 'selfhost' === $load_mode ) {
			$source = self::selfhost_asset_url( $concrete_version );
		}

		wp_register_style(
			self::RESOURCE_HANDLE_SVG_STYLES,
			$source,
			array(),
		    // phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion
			null,
			'all'
		);

		add_filter(
			'style_loader_tag',
			function ( $html, $handle ) use ( $integrity_key, $load_mode ) {
				if ( in_array( $handle, array( self::RESOURCE_HANDLE_SVG_STYLES ), true ) ) {
					$crossorigin_attr = 'selfhost' === $load_mode
					? '' : ' crossorigin="anonymous"';

					$integrity_attr = "integrity=\"$integrity_key\"";

					return preg_replace(
						'/\/>$/',
						$integrity_attr . $crossorigin_attr . ' />',
						$html,
						1
					);
				} else {
					return $html;
				}
			},
			10,
			2
		);
	}

	/**
	 * Internal use only, not part of this plugin's public API.
	 *
	 * If self-hosting is required, this ensures that the SVG support style asset(s)
	 * have been retrieved for self-hosting.
	 *
	 * @param $fa FontAwesome
	 * @param $fa_release_provider FontAwesome_Release_Provider
	 * @throws ReleaseMetadataMissingException
	 * @throws ApiRequestException
	 * @throws ApiResponseException
	 * @throws ReleaseProviderStorageException
	 * @throws SelfhostSetupException
	 * @throws ConfigCorruptionException when called with an invalid configuration
	 * @return void
	 */
	public function maybe_setup_selfhosting( $fa, $fa_release_provider ) {
		if ( ! current_user_can( 'manage_options' ) ) {
			throw new SelfhostSetupException(
				esc_html__(
					'Current user lacks permissions required to set up asset self-hosting. Try logging in as an admin user.',
					'font-awesome'
				)
			);
		}

		$is_skipping_enqueue_kit = self::skip_enqueue_kit();
		$options                 = $fa->options();

		if ( $this->additional_svg_styles_loading( $fa, $is_skipping_enqueue_kit ) !== 'selfhost' ) {
			return;
		}

		$concrete_version = fa()->concrete_version( $options );

		if ( ! $concrete_version ) {
			throw new SelfhostSetupException(
				esc_html__(
					'Failed to determine Font Awesome version when setting up self-hosted assets.',
					'font-awesome'
				)
			);
		}

		$asset_path = $this->selfhost_asset_path( $concrete_version );

		if ( ! $asset_path || ! isset( $asset_path['dir'] ) || ! isset( $asset_path['file'] ) ) {
			throw new SelfhostSetupException(
				esc_html__(
					'Failed to determine filesystem location for self-hosted asset. Please report this on the plugin support forum so it can be investigated.',
					'font-awesome'
				)
			);
		}

		$full_asset_path = trailingslashit( $asset_path['dir'] ) . $asset_path['file'];

		if ( ! function_exists( 'WP_Filesystem' ) ) {
			require_once ABSPATH . 'wp-admin/includes/file.php';
		}

		if ( ! WP_Filesystem( false ) ) {
			throw new SelfhostSetupException(
				esc_html__(
					'Failed to initialize filesystem usage for creating self-hosted assets. Please report this on the plugin support forum so it can be investigated.',
					'font-awesome'
				)
			);
		}

		global $wp_filesystem;

		if ( $wp_filesystem->exists( $full_asset_path ) ) {
			// Nothing more to do.
			return;
		}

		$resource = $fa_release_provider->get_svg_styles_resource( $concrete_version );

		if ( ! $resource->source() || ! $resource->integrity_key() ) {
			throw new SelfhostSetupException(
				esc_html__(
					'Invalid metadata for self-hosted asset. Please report this on the plugin support forum so it can be investigated.',
					'font-awesome'
				)
			);
		}

		$response = wp_remote_get( $resource->source() );

		$code = null;

		if ( isset( $response['response']['code'] ) ) {
			$code = $response['response']['code'];
		}

		if ( is_wp_error( $response ) || ! $code || $code >= 400 | ! isset( $response['body'] ) ) {
			throw new SelfhostSetupException(
				esc_html__(
					'Failed retrieving an asset for self-hosting. Try again.',
					'font-awesome'
				)
			);
		}

		$hyphen_pos = strpos( $resource->integrity_key(), '-' );

		if ( false === $hyphen_pos ) {
			throw new SelfhostSetupException(
				esc_html__(
					'Invalid integrity key metadata for a self-hosted asset. Please report this on the plugin support forum so it can be investigated.',
					'font-awesome'
				)
			);
		}

		$algo = substr( $resource->integrity_key(), 0, $hyphen_pos );

		if ( ! in_array( $algo, hash_algos(), true ) ) {
			throw new SelfhostSetupException(
			    /* translators: 1: hash algorithm name */
    			sprintf( __( 'Your WordPress server\'s PHP environment does not support the %s hash algorithm required to securely fetch assets for self-hosting. Contact your WordPress server administrator.', 'font-awesome'),
    						$algo
    					)
			);
		}

		$hash_hex = hash( $algo, $response['body'] );

		$hash_bin = hex2bin( $hash_hex );
		if ( ! $hash_bin ) {
			throw new SelfhostSetupException(
				esc_html__(
					'Failed computing hash for self-hosted asset. Please report this on the plugin support forum so it can be investigated.',
					'font-awesome'
				)
			);
		}

		// phpcs:ignore WordPress.PHP.DiscouragedPHPFunctions.obfuscation_base64_encode
		$hash = base64_encode( $hash_bin );

		if ( "$algo-$hash" !== $resource->integrity_key() ) {
			throw new SelfhostSetupException(
				esc_html__(
					'Asset integrity key does not match for self-hosted asset. Try removing your font_awesome_svg_styles_loading filter.',
					'font-awesome'
				)
			);
		}

		if ( ! wp_mkdir_p( $asset_path['dir'] ) ) {
			throw new SelfhostSetupException(
				esc_html__(
					'Failed creating a directory for self-hosted assets. Contact your WordPress server administrator.',
					'font-awesome'
				)
			);
		}

		if ( ! $wp_filesystem->put_contents( $full_asset_path, $response['body'] ) ) {
			throw new SelfhostSetupException(
				esc_html__(
					'Failed creating self-hosted assets. Contact your WordPress server administrator.',
					'font-awesome'
				)
			);
		}
	}
}

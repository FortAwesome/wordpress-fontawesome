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
	 * This registers the self-hosted svg support stylesheet.
	 *
	 * @internal
	 * @ignore
	 */
	public function register_svg_styles( $fa ) {
		$concrete_version = $fa->concrete_version( $fa->options() );
		$source           = self::selfhost_asset_url( $concrete_version );

		wp_register_style(
			self::RESOURCE_HANDLE_SVG_STYLES,
			$source,
			array(),
		    // phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion
			null,
			'all'
		);
	}

	/**
	 *
	 * Internal use only, not part of the plugin's public API.
	 *
	 * Returns the full path to the SVG support stylesheet on the server's filesystem.
	 *
	 * @param $fa FontAwesome
	 * @param $fa_release_provider FontAwesome_Release_Provider
	 * @throws ReleaseMetadataMissingException
	 * @throws ReleaseProviderStorageException
	 * @throws SelfhostSetupException
	 * @throws ConfigCorruptionException when called with an invalid configuration
	 * @internal
	 * @ignore
	 * @return string
	 */
	public function selfhost_asset_full_path( $fa ) {
		$options          = $fa->options();
		$concrete_version = $fa->concrete_version( $options );

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

		return trailingslashit( $asset_path['dir'] ) . $asset_path['file'];
	}

	/**
	 * Internal use only, not part of the plugin's public API.
	 *
	 * This checks whether the SVG support stylesheet is present.
	 *
	 * @param $fa FontAwesome
	 * @param $fa_release_provider FontAwesome_Release_Provider
	 * @throws ReleaseMetadataMissingException
	 * @throws ReleaseProviderStorageException
	 * @throws SelfhostSetupException
	 * @throws ConfigCorruptionException when called with an invalid configuration
	 * @internal
	 * @ignore
	 * @return bool
	 */
	public function is_svg_stylesheet_present( $fa ) {
		if ( ! current_user_can( 'manage_options' ) ) {
			throw new SelfhostSetupException(
				esc_html__(
					'Current user lacks permissions required to fetch Font Awesome SVG stylesheets for self-hosting. Try logging in as an admin user.',
					'font-awesome'
				)
			);
		}

		$asset_full_path = $this->selfhost_asset_full_path( $fa );

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

		return $wp_filesystem->exists( $asset_full_path );
	}

	/**
	 * Internal use only, not part of this plugin's public API.
	 *
	 * Fetches SVG support style asset(s) for self-hosting.
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
	public function fetch_svg_styles( $fa, $fa_release_provider ) {
		if ( ! current_user_can( 'manage_options' ) ) {
			throw new SelfhostSetupException(
				esc_html__(
					'Current user lacks permissions required to fetch Font Awesome SVG stylesheets for self-hosting. Try logging in as an admin user.',
					'font-awesome'
				)
			);
		}

		if ( $this->is_svg_stylesheet_present( $fa ) ) {
			// Nothing more to do.
			return;
		}

		$concrete_version = $fa->concrete_version( $fa->options() );

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
				sprintf(
					/* translators: 1: hash algorithm name */
					esc_html__(
						'Your WordPress server\'s PHP environment does not support the %s hash algorithm required to securely fetch assets for self-hosting. Contact your WordPress server administrator.',
						'font-awesome'
					),
					esc_html( $algo )
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

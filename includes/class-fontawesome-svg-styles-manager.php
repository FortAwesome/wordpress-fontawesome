<?php
namespace FortAwesome;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

require_once trailingslashit( FONTAWESOME_DIR_PATH ) . 'includes/error-util.php';

use Exception;
use Error;

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
	 * The handle used when enqueuing default SVG support styles. This is a stylesheet
	 * that's bundled with the plugin, and will be loaded when a version-specific stylesheet
	 * cannot be loaded for some reason.
	 *
	 * @since 5.0.2
	 */
	public const RESOURCE_HANDLE_SVG_STYLES_DEFAULT = 'font-awesome-svg-styles-default';

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
	public static function selfhost_asset_path( $version ) {
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
			'dir'  => trailingslashit( $upload_dir['basedir'] ) . self::selfhost_asset_subdir( $version ),
			'file' => self::selfhost_asset_filename(),
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
	public static function selfhost_asset_url( $version ) {
		$upload_dir = wp_upload_dir( null, false, false );

		if ( isset( $upload_dir['error'] ) && false !== $upload_dir['error'] ) {
			throw new SelfhostSetupException(
				esc_html__(
					'Failed to get WP uploads directory.',
					'font-awesome'
				)
			);
		}

		return trailingslashit( $upload_dir['baseurl'] ) . self::selfhost_asset_subpath( $version );
	}

	/**
	 * Internal use only, not part of this plugin's public API.
	 *
	 * @ignore
	 * @internal
	 */
	public static function selfhost_asset_subdir( $version ) {
		return "font-awesome/v$version/css";
	}

	/**
	 * Internal use only, not part of this plugin's public API.
	 *
	 * @ignore
	 * @internal
	 */
	public static function selfhost_asset_filename() {
		return 'svg-with-js.css';
	}

	/**
	 * Internal use only, not part of this plugin's public API.
	 *
	 * @ignore
	 * @internal
	 */
	public static function selfhost_asset_subpath( $version ) {
		return trailingslashit( self::selfhost_asset_subdir( $version ) ) . self::selfhost_asset_filename();
	}

	/**
	 * Internal use only, not part of the plugin's public API.
	 *
	 * This registers the self-hosted svg support stylesheet.
	 *
	 * @internal
	 * @ignore
	 */
	public static function register_svg_styles( $fa ) {
		$concrete_version = $fa->concrete_version( $fa->options() );
		$source           = self::selfhost_asset_url( $concrete_version );

		// phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion
		wp_register_style(
			self::RESOURCE_HANDLE_SVG_STYLES_DEFAULT,
			false
		);

		/**
		 * This is a minimal default style for SVGs, which will always be overriden when the
		 * real stylesheet is loaded successfully. It's only here as a fallback to ensure that,
		 * in the event that the real stylesheet fails to load, the SVG icons are sized
		 * correctly, and aren't HUGE.
		 */
		$default_svg_style = <<< EOT
.svg-inline--fa {
  display: inline-block;
  height: 1em;
  overflow: visible;
  vertical-align: -.125em;
}
EOT;

		wp_add_inline_style(
			self::RESOURCE_HANDLE_SVG_STYLES_DEFAULT,
			$default_svg_style
		);

		wp_register_style(
			self::RESOURCE_HANDLE_SVG_STYLES,
			$source,
			array( self::RESOURCE_HANDLE_SVG_STYLES_DEFAULT ),
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
	public static function selfhost_asset_full_path( $fa ) {
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

		$asset_path = self::selfhost_asset_path( $concrete_version );

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
	public static function is_svg_stylesheet_path_present( $fa ) {
		if ( ! current_user_can( 'manage_options' ) ) {
			throw new SelfhostSetupPermissionsException(
				esc_html__(
					'Current user lacks permissions required to fetch Font Awesome SVG stylesheets for self-hosting. Try logging in as an admin user.',
					'font-awesome'
				)
			);
		}

		$asset_full_path = self::selfhost_asset_full_path( $fa );

		if ( ! function_exists( 'WP_Filesystem' ) ) {
			require_once ABSPATH . 'wp-admin/includes/file.php';
		}

		if ( ! WP_Filesystem( false ) ) {
			throw new SelfhostSetupPermissionsException(
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
	 * Internal use only, not part of the plugin's public API.
	 *
	 * This checks whether the SVG support stylesheet is present by making a HEAD
	 * request on this WordPress server. This can be used when the current process
	 * lacks filesystem permissions for checking the exists of the file on disk.
	 *
	 * @param $version a concrete Font Awesome version
	 * @throws SelfhostSetupException
	 * @throws SvgStylesheetCheckException
	 * @throws ConfigCorruptionException when called with an invalid configuration
	 * @internal
	 * @ignore
	 * @return bool
	 */
	public static function is_svg_stylesheet_url_present( $version ) {
		$stylesheet_url = self::selfhost_asset_url( $version );

		$response = wp_remote_head( $stylesheet_url );

		if ( is_wp_error( $response ) ) {
			// phpcs:ignore WordPress.Security.EscapeOutput.ExceptionNotEscaped
			throw SvgStylesheetCheckException::with_wp_error( $response );
		}

		$response_code = wp_remote_retrieve_response_code( $response );

		return is_int( $response_code ) && $response_code >= 200 && $response_code < 300;
	}

	/**
	 * Internal use only, not part of the plugin's public API.
	 *
	 * This checks whether the SVG support stylesheet is present.
	 *
	 * @param $fa FontAwesome
	 * @throws SelfhostSetupException
	 * @throws ConfigCorruptionException when called with an invalid configuration
	 * @internal
	 * @ignore
	 * @return bool
	 */
	public static function is_svg_stylesheet_present( $fa ) {
		try {
			// First, try using the filesystem.
			return self::is_svg_stylesheet_path_present( $fa );
		} catch ( SelfhostSetupPermissionsException $_e ) {
			// Fallback to checking the URL via HTTP.
			$version = $fa->concrete_version( $fa->options() );
			return self::is_svg_stylesheet_url_present( $version );
		}
	}

	/**
	 * Internal use only, not part of this plugin's public API.
	 *
	 * Fetches SVG support style asset(s) for self-hosting, and
	 * and emits an admin notice warning when there's a problem.
	 *
	 * @param $fa FontAwesome
	 * @param $fa_release_provider FontAwesome_Release_Provider
	 * @return void
	 */
	public static function ensure_svg_styles_with_admin_notice_warning( $fa, $fa_release_provider ) {
		try {
			self::fetch_svg_styles( $fa, $fa_release_provider );
		} catch ( SelfhostSetupPermissionsException $_e ) {
			$message_main = __(
				'We couldn\'t save the stylesheet required to render SVG icons added in the Block Editor. We don\'t have permission to save files on your WordPress site. Make an exception to allow it, or place the stylesheet manually.',
				'font-awesome'
			);

			$message_part2 = __(
				'Due to another issue, we couldn\'t determine the URL where you need to make the stylesheet available.',
				'font-awesome'
			);

			$message_part3 = __(
				'Due to another issue, we couldn\'t find a link to the stylesheet\'s contents for you to manually place.',
				'font-awesome'
			);

			try {
				$concrete_version = $fa->concrete_version( $fa->options() );
				$url              = self::selfhost_asset_url( $concrete_version );

				$message_part2 = sprintf(
					/* translators: 1: newline, 2: self-hosted stylesheet URL,  */
					__(
						'Here\'s the URL on your WordPress server where you need to make the stylesheet available:%1$s%2$s',
						'font-awesome'
					),
					"\n",
					$url
				);

				$resource = $fa_release_provider->get_svg_styles_resource( $concrete_version );

				if ( $resource->source() ) {
					$message_part3 = sprintf(
						/* translators: 1: newline, 2: Font Awesome CDN stylesheet URL */
						__(
							'Here\'s a link to the stylesheet whose contents should be copied to that location on your WordPress site:%1$s%2$s',
							'font-awesome'
						),
						"\n",
						$resource->source()
					);
				}
				// phpcs:ignore Generic.CodeAnalysis.EmptyStatement.DetectedCatch
			} catch ( Exception $_e ) {
				// Silently ignore to use the default notification message.
				// phpcs:ignore Generic.CodeAnalysis.EmptyStatement.DetectedCatch
			} catch ( Error $_e ) {
				// Silently ignore to use the default notification message.
			}

			$full_message    = $message_main . "\n" . $message_part2 . "\n" . $message_part3;
			$escaped_message = esc_html( $full_message );

			$e = new SelfhostSetupPermissionsException( $escaped_message );

			notify_admin_warning( $e );
		} catch ( Exception $e ) {
			notify_admin_warning( $e );
		} catch ( Error $e ) {
			notify_admin_warning( $e );
		}
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
	 * @throws SelfhostSetupPermissionsException
	 * @throws ConfigCorruptionException when called with an invalid configuration
	 * @return void
	 */
	public static function fetch_svg_styles( $fa, $fa_release_provider ) {
		if ( self::is_svg_stylesheet_present( $fa ) ) {
			// Nothing more to do.
			return;
		}

		if ( ! current_user_can( 'manage_options' ) ) {
			throw new SelfhostSetupPermissionsException(
				esc_html__(
					'Current user lacks permissions required to fetch Font Awesome SVG stylesheets for self-hosting. Try logging in as an admin user.',
					'font-awesome'
				)
			);
		}

		$concrete_version = $fa->concrete_version( $fa->options() );

		$asset_path = self::selfhost_asset_path( $concrete_version );

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
			throw new SelfhostSetupPermissionsException(
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

		$is_error = false;

		if ( is_wp_error( $response ) ) {
			$is_error = true;
		} else {
			$code = null;

			if ( isset( $response['response']['code'] ) ) {
				$code = $response['response']['code'];
			}

			if ( ! $code || $code >= 400 | ! isset( $response['body'] ) ) {
				$is_error = true;
			}
		}

		if ( $is_error ) {
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
					'Asset integrity key does not match for self-hosted asset.',
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

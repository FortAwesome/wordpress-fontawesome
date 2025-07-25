<?php
namespace FortAwesome;

require_once trailingslashit( __DIR__ ) . '../defines.php';
require_once trailingslashit( __DIR__ ) . 'class-fontawesome.php';
require_once trailingslashit( __DIR__ ) . 'class-fontawesome-release-provider.php';
require_once trailingslashit( __DIR__ ) . 'class-fontawesome-svg-styles-manager.php';
require_once trailingslashit( FONTAWESOME_DIR_PATH ) . 'includes/error-util.php';

/**
 * Plugin activation logic.
 *
 * Client code that depends upon this plugin should use {@see FontAwesome_Loader::initialize()}.
 *
 * @since 4.0.0
 */
class FontAwesome_Activator {
	/**
	 * Initializes plugin options only if they are empty.
	 *
	 * @since 4.0.0
	 * @throws ApiRequestException
	 * @throws ApiResponseException
	 * @throws ActivationException
	 * @throws ReleaseProviderStorageException
	 */
	public static function activate() {
		try {
			self::initialize();
		} catch ( \Exception $e ) {
			wp_die(
				esc_html( $e->getMessage() ),
				esc_html( __( 'Font Awesome Activation Error', 'font-awesome' ) ),
				array( 'back_link' => true )
			);
		} catch ( \Error $e ) {
			wp_die(
				esc_html( $e->getMessage() ),
				esc_html( __( 'Font Awesome Activation Error', 'font-awesome' ) ),
				array( 'back_link' => true )
			);
		}
	}

	/**
	 * Initializes plugin options with defaults only if they are empty.
	 *
	 * Internal use only, not part of this plugin's public API.
	 *
	 * Otherwise, it leaves alone options that are already present.
	 *
	 * Sets default user options. Will attempt to get the latest available version,
	 * which requires access to the Font Awesome API server. Throws an exception
	 * if that request fails.
	 *
	 * @param bool $force if true, overwrite any existing options with defaults
	 *
	 * @ignore
	 * @internal
	 * @throws ApiRequestException
	 * @throws ApiResponseException
	 * @throws ActivationException
	 * @throws ReleaseProviderStorageException
	 */
	public static function initialize( $force = false ) {
		self::initialize_release_metadata();

		if ( is_multisite() ) {
			global $wp_version;

			if ( version_compare( $wp_version, '5.1.0', '<' ) ) {
				throw ActivationException::multisite_requires_at_least_5_1_0();
			}
		}

		if ( is_multisite() && is_network_admin() ) {
			for_each_blog(
				function () use ( $force ) {
					self::initialize_current_site( $force );
				}
			);
		} else {
			self::initialize_current_site( $force );
		}
	}

	/**
	 * Internal use only.
	 *
	 * @ignore
	 * @internal
	 */
	public static function initialize_current_site( $force ) {
		if ( $force || ! get_option( FontAwesome::OPTIONS_KEY ) ) {
			self::initialize_user_options();
		}

		if ( $force || ! get_option( FontAwesome::CONFLICT_DETECTION_OPTIONS_KEY ) ) {
			self::initialize_conflict_detection_options();
		}

		if ( fa()->is_block_editor_support_enabled() ) {
			self::initialize_svg_styles();
		}
	}

	/**
	 * Internal use only.
	 *
	 * @ignore
	 * @internal
	 * @throws ApiRequestException
	 * @throws ApiResponseException
	 * @throws ReleaseProviderStorageException
	 */
	private static function initialize_release_metadata( $force = false ) {
		$release_provider_option = get_option( FontAwesome_Release_Provider::OPTIONS_KEY );

		if ( $force || ! $release_provider_option || ! isset( $release_provider_option['data']['latest_version_6'] ) ) {

			FontAwesome_Release_Provider::load_releases();
		}
	}

	/**
	 * Internal use only.
	 *
	 * @ignore
	 * @internal
	 */
	private static function initialize_user_options() {
		$version = fa()->latest_version_7();
		$options = array_merge( FontAwesome::DEFAULT_USER_OPTIONS, array( 'version' => $version ) );
		update_option( FontAwesome::OPTIONS_KEY, $options );
	}

	/**
	 * Internal use only.
	 *
	 * @ignore
	 * @internal
	 */
	private static function initialize_conflict_detection_options() {
		update_option( FontAwesome::CONFLICT_DETECTION_OPTIONS_KEY, FontAwesome::DEFAULT_CONFLICT_DETECTION_OPTIONS );
	}

	/**
	 * Internal use only.
	 *
	 * @ignore
	 * @internal
	 * @throws ReleaseMetadataMissingException
	 * @throws ApiRequestException
	 * @throws ApiResponseException
	 * @throws ReleaseProviderStorageException
	 * @throws SelfhostSetupException
	 * @throws ConfigCorruptionException
	 */
	private static function initialize_svg_styles() {
		FontAwesome_SVG_Styles_Manager::ensure_svg_styles_with_admin_notice_warning( fa(), fa_release_provider() );
	}
}

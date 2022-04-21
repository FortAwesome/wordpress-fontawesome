<?php
namespace FortAwesome;

require_once trailingslashit( dirname( __FILE__ ) ) . '../defines.php';
require_once trailingslashit( dirname( __FILE__ ) ) . 'class-fontawesome.php';
require_once trailingslashit( dirname( __FILE__ ) ) . 'class-fontawesome-release-provider.php';

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
	 * @throws ReleaseProviderStorageException
	 */
	public static function activate() {
		self::initialize();
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
	 * @throws ReleaseProviderStorageException
	 */
	public static function initialize( $force = false ) {
		$release_provider_option = get_option( FontAwesome_Release_Provider::OPTIONS_KEY );

		if ( $force || ! $release_provider_option || ! isset( $release_provider_option['data']['latest_version_6'] ) ) {
			self::initialize_release_metadata();
		}

		if ( $force || ! get_option( FontAwesome::OPTIONS_KEY ) ) {
			self::initialize_user_options();
		}

		if ( $force || ! get_option( FontAwesome::CONFLICT_DETECTION_OPTIONS_KEY ) ) {
			self::initialize_conflict_detection_options();
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
	private static function initialize_release_metadata() {
		FontAwesome_Release_Provider::load_releases();
	}

	/**
	 * Internal use only.
	 *
	 * @ignore
	 * @internal
	 */
	private static function initialize_user_options() {
		$version = fa()->latest_version_6();
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
}


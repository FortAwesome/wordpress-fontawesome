<?php
/**
 * This module is not considered part of the public API, only internal.
 * Any data or functionality that it produces should be exported by the
 * main FontAwesome class and the API documented and semantically versioned there.
 */
namespace FortAwesome;

use \WP_Error, \Error, \Exception;

/**
 * Provides metadata about Font Awesome releases.
 *
 * @noinspection PhpIncludeInspection
 */

// phpcs:ignore Generic.Commenting.DocComment.MissingShort
/**
 * @ignore
 */

require_once trailingslashit( FONTAWESOME_DIR_PATH ) . 'includes/class-fontawesome-resource.php';
require_once trailingslashit( FONTAWESOME_DIR_PATH ) . 'includes/class-fontawesome-resourcecollection.php';
require_once trailingslashit( FONTAWESOME_DIR_PATH ) . 'includes/class-fontawesome-metadata-provider.php';
require_once trailingslashit( FONTAWESOME_DIR_PATH ) . 'includes/class-fontawesome-exception.php';

/**
 * Provides metadata about Font Awesome releases by querying fontawesome.com.
 *
 * Theme and plugin developers normally should _not_ access this Release Provider API directly. It's here to support the
 * functionality of {@see FontAwesome}.
 */
class FontAwesome_Release_Provider {
	/**
	 * Name of the option that stores the Font Awesome release metadata so we won't query
	 * the fontawesome.com releases API except when the admin settings page is re-loaded.
	 *
	 * @since 4.0.0-rc22
	 * @ignore
	 */
	const OPTIONS_KEY = 'font-awesome-releases';

	/**
	 * Name of the transient that stores the cache of the last used Font Awesome
	 * release so we won't load all of the releases metadata on each page load.
	 *
	 * @since 4.0.0-rc4
	 * @ignore
	 * @internal
	 */
	const LAST_USED_RELEASE_TRANSIENT = 'font-awesome-last-used-release';

	/**
	 * Expiry time for the releases transient.
	 *
	 * @ignore
	 * @internal
	 */
	const LAST_USED_RELEASE_TRANSIENT_EXPIRY = YEAR_IN_SECONDS;

	// phpcs:ignore Generic.Commenting.DocComment.MissingShort
	/**
	 * @ignore
	 */
	protected $releases = null;

	// phpcs:ignore Generic.Commenting.DocComment.MissingShort
	/**
	 * @ignore
	 */
	protected $refreshed_at = null;

	// phpcs:ignore Generic.Commenting.DocComment.MissingShort
	/**
	 * @ignore
	 */
	protected $latest_version = null;

	// phpcs:ignore Generic.Commenting.DocComment.MissingShort
	/**
	 * @ignore
	 */
	protected $api_client = null;

	// phpcs:ignore Generic.Commenting.DocComment.MissingShort
	/**
	 * @ignore
	 */
	protected static $instance = null;

	/**
	 * Returns the FontAwesome_Release_Provider singleton instance.
	 *
	 * @return FontAwesome_Release_Provider
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Resets the singleton instance referenced by this class and returns that new instance.
	 * All previous releases metadata held in the previous instance will be abandoned.
	 *
	 * @return FontAwesome_Release_Provider
	 */
	public static function reset() {
		self::$instance = null;
		return self::instance();
	}

	/**
	 * Private constructor.
	 *
	 * Requires that releases metadata have already been loaded into the db option.
	 *
	 * @ignore
	 * @internal
	 * @throws ReleaseMetadataMissingException
	 */
	private function __construct() {
		$option_value = self::get_option();

		if ( $option_value ) {
			$this->releases     = $option_value['data']['releases'];
			$this->refreshed_at = $option_value['refreshed_at'];

			/**
			 * Gracefully handle the upgrade scenario from plugin version 4.1.1 where
			 * there was a "latest", referring to the latest 5.x, but not yet
			 * keys for "latest_version_5" and "latest_version_6".
			 */
			$latest_version_5 = isset( $option_value['data']['latest_version_5'] )
				? $option_value['data']['latest_version_5']
				: ( isset( $option_value['data']['latest'] )
					? $option_value['data']['latest']
					: null
				);

			$this->latest_version_5 = $latest_version_5;

			$this->latest_version_6 = isset( $option_value['data']['latest_version_6'] )
				? $option_value['data']['latest_version_6']
				: null;
		} else {
			throw new ReleaseMetadataMissingException();
		}
	}

	/**
	 * Loads release metadata and saves to the options table.
	 *
	 * Internal use only. Not part of this plugin's public API.
	 *
	 * @internal
	 * @ignore
	 * @throws ApiRequestException
	 * @throws ApiResponseException
	 * @throws ReleaseProviderStorageException
	 * @return void
	 */
	public static function load_releases() {
		$query = <<< EOD
query {
	latest_version_5: release(version: "5.x") {
		version
	}
	latest_version_6: release(version: "6.x") {
		version
	}
	releases {
		version
		srisByLicense {
			free {
				path
				value
			}
			pro {
				path
				value
			}
		}
	}
}
EOD;

		$body = json_decode( self::query( $query ), true );

		$releases = array();

		foreach ( $body['data']['releases'] as $release ) {
			$sris = array();

			foreach ( $release['srisByLicense'] as $license => $sri_set ) {
				$sris[ $license ] = array();
				foreach ( $sri_set as $sri ) {
					$sris[ $license ][ $sri['path'] ] = $sri['value'];
				}
			}

			$releases[ $release['version'] ] = array(
				'sri' => $sris,
			);
		}

		$refreshed_at     = time();
		$latest_version_5 = isset( $body['data']['latest_version_5']['version'] ) ? $body['data']['latest_version_5']['version'] : null;
		$latest_version_6 = isset( $body['data']['latest_version_6']['version'] ) ? $body['data']['latest_version_6']['version'] : null;

		if ( is_null( $latest_version_5 ) ) {
			throw ApiResponseException::with_wp_error( new WP_Error( 'missing_latest_version_5' ) );
		}

		if ( is_null( $latest_version_6 ) ) {
			throw ApiResponseException::with_wp_error( new WP_Error( 'missing_latest_version_6' ) );
		}

		$option_value = array(
			'refreshed_at' => $refreshed_at,
			'data'         => array(
				'latest_version_5' => $latest_version_5,
				'latest_version_6' => $latest_version_6,
				'releases'         => $releases,
			),
		);

		self::update_option( $option_value );
	}

	/**
	 * Internal use only, not part of this plugin's public API.
	 *
	 * @internal
	 * @ignore
	 * @return FontAwesome_Resource
	 */
	private function build_resource( $version, $file_basename, $flags = array(
		'use_svg' => false,
		'use_pro' => false,
	) ) {
		$full_url  = 'https://';
		$full_url .= boolval( $flags['use_pro'] ) ? 'pro.' : 'use.';
		$full_url .= 'fontawesome.com/releases/v' . $version . '/';

		// use the style to build the relative url lookup the relative url.
		$relative_url  = $flags['use_svg'] ? 'js/' : 'css/';
		$relative_url .= $file_basename . '.';
		$relative_url .= $flags['use_svg'] ? 'js' : 'css';

		$full_url .= $relative_url;

		$license = $flags['use_pro'] ? 'pro' : 'free';

		// if we can't resolve an integrity_key in this deeply nested lookup, it will remain null.
		$integrity_key = null;
		if ( isset( $this->releases()[ $version ]['sri'][ $license ][ $relative_url ] ) ) {
			$integrity_key = $this->releases()[ $version ]['sri'][ $license ][ $relative_url ];
		}

		return( new FontAwesome_Resource( $full_url, $integrity_key ) );
	}

	/**
	 * Internal use only. Not part of this plugin's public API.
	 *
	 * @ignore
	 * @internal
	 * @throws ApiTokenMissingException
	 * @throws ApiTokenEndpointRequestException
	 * @throws ApiTokenEndpointResponseException
	 * @throws ApiTokenInvalidException
	 * @throws AccessTokenStorageException
	 * @throws ApiRequestException
	 * @throws ApiResponseException
	 * @return array
	 */
	protected static function query( $query ) {
		return fa_metadata_provider()->metadata_query( $query, true );
	}

	/**
	 * Retrieves Font Awesome releases metadata from the singleton instance.
	 *
	 * Makes no network or database requests.
	 *
	 * @return array
	 */
	protected function releases() {
		return $this->releases;
	}

	/**
	 * Returns the time, in unix epoch seconds when the releases metadata were
	 * last refreshed, or null for never.
	 *
	 * Internal use only. Clients should use the public API method on the
	 * FontAwesome object.
	 *
	 * @ignore
	 * @internal
	 * @return null|int
	 */
	public function refreshed_at() {
		return $this->refreshed_at;
	}

	/**
	 * Returns a simple array of available Font Awesome versions as strings, sorted in descending version order.
	 *
	 * @return array
	 */
	public function versions() {
		$versions = array_keys( $this->releases() );
		usort(
			$versions,
			function( $first, $second ) {
				return version_compare( $second, $first );
			}
		);
		return $versions;
	}

	/**
	 * Returns an array containing version, shim, source URLs and integrity keys for given params.
	 * They should be loaded in the order they appear in this collection.
	 *
	 * First tries to resolve this by using the LAST_USED_RELEASE_TRANSIENT, without
	 * instantiating a Release Provider and thus incurring the cost of a trip to
	 * the database to load the release metadata. If it does need to instantiate
	 * the Release Provider, it will also populate that transient so that subsequent
	 * invocations of the function will probably not incur the cost of a database
	 * query.
	 *
	 * @param string $version
	 * @param array  $flags boolean flags, defaults: array('use_pro' => false, 'use_svg' => false, 'use_compatibility' => true)
	 * @throws ReleaseMetadataMissingException
	 * @throws ApiRequestException
	 * @throws ApiResponseException
	 * @throws ReleaseProviderStorageException
	 * @throws ConfigCorruptionException when called with an invalid configuration
	 * @return array
	 */
	public static function get_resource_collection( $version, $flags = array(
		'use_pro'           => false,
		'use_svg'           => false,
		'use_compatibility' => true,
	) ) {
		$resources = array();

		if ( ! is_string( $version ) || 0 === strlen( $version ) ) {
			throw new ConfigCorruptionException();
		}

		if ( $flags['use_compatibility'] && ! $flags['use_svg'] && version_compare( '5.1.0', $version, '>' ) ) {
			throw ConfigSchemaException::webfont_v4compat_introduced_later();
		}

		// If this is the same query as last time, then our LAST_USED_RELEASE_TRANSIENT should be current.
		$last_used_transient = self::get_last_used_release();

		if ( $last_used_transient ) {
			// For simplicity, we're require that it's exactly what we're looking for, else we'll re-build and overwrite it.
			if (
				$version === $last_used_transient['version']
				&& $flags['use_pro'] === $last_used_transient['use_pro']
				&& $flags['use_svg'] === $last_used_transient['use_svg']
				&& $flags['use_compatibility'] === $last_used_transient['use_compatibility']
				&& is_array( $last_used_transient['resources'] )
				/**
				 * Checking for all because we only want to use a newer transient whose
				 * resources is key/value array. So if it's the older version that is
				 * just a list, we'll fall through and rebuild it below.
				 */
				&& isset( $last_used_transient['resources']['all'] )
			) {
				return new FontAwesome_ResourceCollection( $version, $last_used_transient['resources'] );
			}
		}

		$provider = self::instance();

		if ( ! array_key_exists( $version, $provider->releases() ) ) {
			throw new ReleaseMetadataMissingException();
		}

		$resources['all'] = $provider->build_resource( $version, 'all', $flags );

		if ( $flags['use_compatibility'] ) {
			$resources['v4-shims'] = $provider->build_resource( $version, 'v4-shims', $flags );
		}

		$transient_value = array(
			'version'           => $version,
			'use_pro'           => $flags['use_pro'],
			'use_svg'           => $flags['use_svg'],
			'use_compatibility' => $flags['use_compatibility'],
			'resources'         => $resources,
		);

		self::update_last_used_release( $transient_value );

		return new FontAwesome_ResourceCollection( $version, $resources );
	}

	/**
	 * Returns a version number corresponding to the most recent minor release
	 * in the 5.x line.
	 *
	 * Internal use only. Clients should use the FontAwesome::latest_version_5()
	 * or FontAwesome::latest_version_6() public API methods instead.
	 *
	 * @internal
	 * @ignore
	 * @deprecated
	 * @return string|null most recent major.minor.patch 5.x version or null if there's
	 *   not yet been a successful query to the API server for releases metadata.
	 */
	public function latest_version() {
		return $this->latest_version_5;
	}

	/**
	 * Returns a version number corresponding to the most recent minor release
	 * in the 5.x line.
	 *
	 * Internal use only. Clients should use the FontAwesome::latest_version_5()
	 * public API methods instead.
	 *
	 * @internal
	 * @ignore
	 * @deprecated
	 * @return string|null most recent major.minor.patch 5.x version or null if there's
	 *   not yet been a successful query to the API server for releases metadata.
	 */
	public function latest_version_5() {
		return $this->latest_version_5;
	}

	/**
	 * Returns a version number corresponding to the most recent minor release
	 * in the 6.x line.
	 *
	 * Internal use only. Clients should use the FontAwesome::latest_version_6()
	 * public API methods instead.
	 *
	 * @internal
	 * @ignore
	 * @deprecated
	 * @return string|null most recent major.minor.patch 6.x version or null if there's
	 *   not yet been a successful query to the API server for releases metadata.
	 */
	public function latest_version_6() {
		return $this->latest_version_6;
	}

	/**
	 * In multisite mode, we will store the releases metadata just once for the
	 * whole network in a network option.
	 *
	 * Internal use only, not part of this plugin's public API.
	 *
	 * @internal
	 * @ignore
	 */
	public static function update_option( $option_value ) {
		if ( is_multisite() ) {
			$network_id = get_current_network_id();
			return update_network_option( $network_id, self::OPTIONS_KEY, $option_value );
		} else {
			return update_option( self::OPTIONS_KEY, $option_value, false );
		}
	}

	/**
	 * In multisite mode, we will store the releases metadata just once for the
	 * whole network in a network option.
	 *
	 * Internal use only, not part of this plugin's public API.
	 *
	 * @internal
	 * @ignore
	 */
	public static function get_option() {
		if ( is_multisite() ) {
			$network_id = get_current_network_id();
			return get_network_option( $network_id, self::OPTIONS_KEY );
		} else {
			return get_option( self::OPTIONS_KEY );
		}
	}

	/**
	 * Internal use only, not part of this plugin's public API.
	 *
	 * @internal
	 * @ignore
	 */
	public static function delete_option() {
		if ( is_multisite() ) {
			$network_id = get_current_network_id();
			return delete_network_option( $network_id, self::OPTIONS_KEY );
		} else {
			return delete_option( self::OPTIONS_KEY );
		}
	}

	/**
	 * Internal use only, not part of this plugin's public API.
	 *
	 * @internal
	 * @ignore
	 */
	public static function get_last_used_release() {
		return get_transient( self::LAST_USED_RELEASE_TRANSIENT );
	}

	/**
	 * Internal use only, not part of this plugin's public API.
	 *
	 * @internal
	 * @ignore
	 */
	public static function update_last_used_release( $transient_value ) {
		return set_transient( self::LAST_USED_RELEASE_TRANSIENT, $transient_value, self::LAST_USED_RELEASE_TRANSIENT_EXPIRY );
	}

	/**
	 * Internal use only, not part of this plugin's public API.
	 *
	 * @internal
	 * @ignore
	 */
	public static function delete_last_used_release() {
		return delete_transient( self::LAST_USED_RELEASE_TRANSIENT );
	}
}

/**
 * Convenience global function to get a singleton instance of the Release Provider.
 * Normally, plugins and themes should not need to access this directly.
 *
 * @see FontAwesome_Release_Provider::instance()
 * @return FontAwesome_Release_Provider
 */
function fa_release_provider() {
	return FontAwesome_Release_Provider::instance();
}

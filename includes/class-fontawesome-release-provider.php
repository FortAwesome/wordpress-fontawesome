<?php
namespace FortAwesome;

use \WP_Error, \Error, \Exception, \InvalidArgumentException;

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
require_once trailingslashit( FONTAWESOME_DIR_PATH ) . 'includes/class-fontawesome-noreleasesexception.php';
require_once trailingslashit( FONTAWESOME_DIR_PATH ) . 'includes/class-fontawesome-configurationexception.php';

/**
 * Provides metadata about Font Awesome releases by querying fontawesome.com.
 *
 * Theme and plugin developers normally should _not_ access this Release Provider API directly. It's here to support the
 * functionality of {@see FontAwesome}.
 */
class FontAwesome_Release_Provider {
	/**
	 * Name of the transient that stores the cache of Font Awesome releases so we won't query
	 * the fontawesome.com releases API except when the admin settings page is re-loaded.
	 *
	 * @since 4.0.0-rc4
	 * @ignore
	 */
	const RELEASES_TRANSIENT = 'font-awesome-releases';

	/**
	 * Expiry time for the releases transient.
	 *
	 * @ignore
	 */
	const RELEASES_TRANSIENT_EXPIRY = 0;

	// phpcs:ignore Generic.Commenting.DocComment.MissingShort
	/**
	 * @ignore
	 */
	protected $releases = null;

	// phpcs:ignore Generic.Commenting.DocComment.MissingShort
	/**
	 * @ignore
	 */
	protected $status = null;

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
	 * Returns an associative array indicating the status of the status of the last network
	 * request that attempted to retrieve releases metadata, or null if no network request has
	 * been issued during the life time of the current Singleton instance.
	 *
	 * The shape of an array return looks like this:
	 * ```php
	 * array(
	 *   'code' => 403,
	 *   'message' => 'some message',
	 * )
	 * ```
	 *
	 * The value of the `code` key is one of:
	 * - `200` if successful,
	 * - `0` if there was some code error that prevented the network request from completing
	 * - otherwise some HTTP error code as returned by `wp_remote_get()`
	 *
	 * @return array|null
	 */
	public function get_status() {
		return $this->status;
	}

	/**
	 * Private constructor.
	 *
	 * @ignore
	 */
	private function __construct() {
		$cached_releases = get_transient( self::RELEASES_TRANSIENT );

		if ( $cached_releases ) {
			$this->releases = $cached_releases;
		}
	}

	// phpcs:ignore Generic.Commenting.DocComment.MissingShort
	/**
	 * @ignore
	 */
	private function map_api_release( $release ) {
		$mapped_release              = array();
		$mapped_release['version']   = $release['attributes']['version'];
		$mapped_release['download']  = $release['attributes']['download'];
		$mapped_release['date']      = $release['attributes']['date'];
		$mapped_release['iconCount'] = $release['attributes']['icon-count'];
		$mapped_release['sri']       = $release['attributes']['sri'];

		return $mapped_release;
	}

	// phpcs:ignore Generic.Commenting.DocComment.MissingShort
	/**
	 * @ignore
	 */
	// phpcs:ignore Squiz.Commenting.FunctionCommentThrowTag.Missing
	private function load_releases() {
		$init_status = array(
			'code'    => null,
			'message' => '',
		);

		try {
			$response = $this->get( FONTAWESOME_API_URL . '/api/releases' );

			if ( $response instanceof WP_Error ) {
				throw new Error();
			}

			$this->status = array_merge(
				$init_status,
				array(
					'code'    => $response['response']['code'],
					'message' => $response['response']['message'],
				)
			);

			if ( 200 !== $this->status['code'] ) {
				return;
			}

			$body_contents = $response['body'];
			$body_json     = json_decode( $body_contents, true );
			$api_releases  = array_map( array( $this, 'map_api_release' ), $body_json['data'] );
			$releases      = array();
			foreach ( $api_releases as $release ) {
				$releases[ $release['version'] ] = $release;
			}

			$previous_transient = get_transient( self::RELEASES_TRANSIENT );

			if ( $previous_transient ) {
				// We must be refreshing the releases metadata, so delete the transient before trying to set it again.
				delete_transient( self::RELEASES_TRANSIENT );
			}

			$ret = set_transient( self::RELEASES_TRANSIENT, $releases, self::RELEASES_TRANSIENT_EXPIRY );

			if ( ! $ret ) {
				throw new Exception();
			}

			$this->releases = $releases;
		} catch ( Exception $e ) {
			$this->status = array_merge(
				$init_status,
				array(
					'code'    => 0,
					'message' => 'Whoops, we failed to update the releases data.',
				)
			);
		} catch ( Error $e ) {
			$this->status = array_merge(
				$init_status,
				array(
					'code'    => 0,
					'message' => 'Whoops, we failed when trying to update the releases data.',
				)
			);
		}
	}

	// phpcs:ignore Generic.Commenting.DocComment.MissingShort
	/**
	 * @ignore
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

	// phpcs:ignore Generic.Commenting.DocComment.MissingShort
	/**
	 * @ignore
	 */
	protected function get( $url, $args = array() ) {
		return wp_remote_get( $url, $args );
	}

	/**
	 * Retrieves Font Awesome releases metadata with as few network requests as possible.
	 *
	 * Will first attempt to return releases already memoized by this Singleton instance.
	 * Next, will try to retrieve a cached set of releases from a non-expiring transient.
	 *
	 * If there's nothing cached, then it tries to load releases by making a network request to the
	 * releases API endpoint.
	 *
	 * If that fails, it throws an exception.
	 *
	 * @see FontAwesome_Release_Provider::RELEASES_TRANSIENT()
	 * @see FontAwesome_Release_Provider::RELEASES_TRANSIENT_EXPIRY()
	 * @throws FontAwesome_NoReleasesException
	 * @return array
	 */
	protected function releases() {
		if ( $this->releases ) {
			return $this->releases;
		} else {
			$cached_releases = get_transient( self::RELEASES_TRANSIENT );

			if ( $cached_releases ) {
				return $cached_releases;
			} elseif ( is_null( $this->releases ) ) {
				$this->load_releases();

				// TODO: consider adding retry logic for loading Font Awesome releases.
				if ( is_null( $this->releases ) ) {
					throw new FontAwesome_NoReleasesException();
				} else {
					return $this->releases;
				}
			} else {
				return $this->releases;
			}
		}
	}

	/**
	 * Returns a simple array of available Font Awesome versions as strings, sorted in descending version order.
	 *
	 * @throws FontAwesome_NoReleasesException
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
	 * Throws InvalidArgumentException if called with use_svg = true, use_shim = true and version < 5.1.0.
	 * Shims were not introduced for webfonts until 5.1.0.
	 *
	 * Throws InvalidArgumentException when called with an array for $style_opt that contains no known style specifiers.
	 *
	 * Throws FontAwesome_NoReleasesException when no releases metadata could be loaded.
	 *
	 * @param string $version
	 * @param mixed  $style_opt either the string 'all' or an array containing any of the following:
	 *         ['solid', 'regular', 'light', 'brands']
	 * @param array  $flags boolean flags, defaults: array('use_pro' => false, 'use_svg' => false, 'use_shim' => true)
	 * @throws InvalidArgumentException | FontAwesome_NoReleasesException
	 * @throws FontAwesome_ConfigurationException
	 * @return array
	 */
	public function get_resource_collection( $version, $style_opt, $flags = array(
		'use_pro'  => false,
		'use_svg'  => false,
		'use_shim' => true,
	) ) {
		$resources = array();

		if ( $flags['use_shim'] && ! $flags['use_svg'] && version_compare( '5.1.0', $version, '>' ) ) {
			throw new FontAwesome_ConfigurationException(
				'Whoops! You found a corner case here. ' .
				'Version 4 compatibility for our webfont method was not introduced until Font Awesome 5.1.0. ' .
				'Try using a newer version, disabling version 4 compatibility, or switch your method to SVG.'
			);
		}

		if ( ! array_key_exists( $version, $this->releases() ) ) {
			throw new InvalidArgumentException( "Font Awesome version \"$version\" is not one of the available versions." );
		}

		if ( gettype( $style_opt ) === 'string' && 'all' === $style_opt ) {
			array_push( $resources, $this->build_resource( $version, 'all', $flags ) );
			if ( $flags['use_shim'] ) {
				array_push( $resources, $this->build_resource( $version, 'v4-shims', $flags ) );
			}
		} elseif ( is_array( $style_opt ) ) {
			// These can be added to the collection in any order.
			// Silently ignore any invalid ones, but if there are no styles, then we should die.
			$load_styles = array();
			foreach ( $style_opt as $style ) {
				switch ( $style ) {
					case 'solid':
					case 'regular':
					case 'light':
					case 'brands':
						$load_styles[ $style ] = true;
						break;
					default:
						// phpcs:ignore WordPress.PHP.DevelopmentFunctions
						error_log( 'WARNING: ignorning an unrecognized style specifier: ' . $style );
				}
			}
			$styles = array_keys( $load_styles );
			if ( count( $styles ) === 0 ) {
				throw new InvalidArgumentException(
					'No icon styles were specified to Font Awesome, so none would be loaded.' .
					"If that's what you intend, then you should probably just disable the Font Awesome plugin."
				);
			}

			// Add the main library first.
			array_push( $resources, $this->build_resource( $version, 'fontawesome', $flags ) );

			// create a new FontAwesome_Resource for each style, in any order.
			foreach ( $styles as $style ) {
				array_push( $resources, $this->build_resource( $version, $style, $flags ) );
			}

			if ( $flags['use_shim'] ) {
				array_push( $resources, $this->build_resource( $version, 'v4-shims', $flags ) );
			}
		} else {
			throw new InvalidArgumentException(
				'$style_opt must be either the string "all" or a collection of ' .
				'style specifiers: solid, regular, light, brands.'
			);
		}

		return $resources;
	}

	/**
	 * Returns a version number corresponding to the most recent minor release.
	 *
	 * @throws FontAwesome_NoReleasesException
	 * @return string|null most recent major.minor.patch version. Returns null if no versions available.
	 */
	public function latest_minor_release() {
		$sorted_versions = $this->versions();
		return count( $sorted_versions ) > 0 ? $sorted_versions[0] : null;
	}

	/**
	 * Returns a version number corresponding to the minor release immediately prior to the most recent minor release.
	 *
	 * @throws FontAwesome_NoReleasesException
	 * @return string|null latest patch level for the previous minor version. major.minor.patch version.
	 *         Returns null if there is no latest (and therefore no previous).
	 *         Returns null if there's no previous, because the latest represents the only minor version in the set
	 *           of available versions.
	 */
	public function previous_minor_release() {
		// Find the latest.
		$latest = $this->latest_minor_release();

		if ( is_null( $latest ) ) {
			return null;
		}

		// Build a major.minor version corresponding to the previous minor.
		$version_parts    = explode( '.', $latest );
		$new_minor_number = intval( $version_parts[1] ) - 1;
		// make sure we don't try to use a negative number.
		$new_minor_number = $new_minor_number >= 0 ? $new_minor_number : 0;
		$version_parts[1] = $new_minor_number;
		// This will look like "5.2", instead of "5.2.0".
		$previous_minor_version_partial = implode( '.', array_slice( $version_parts, 0, 2 ) );

		$satisfying_versions = array_filter(
			$this->versions(),
			function( $version ) use ( $previous_minor_version_partial ) {
				return preg_match( "/$previous_minor_version_partial\.[0-9]+$/", $version );
			}
		);

		$result = array_shift( $satisfying_versions );

		return $result === $latest ? null : $result;
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

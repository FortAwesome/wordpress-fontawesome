<?php
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

use Composer\Semver\Semver;
use GuzzleHttp\Client;

/**
 * Provides metadata about Font Awesome releases by querying fontawesome.com.
 *
 * @package    FontAwesome
 * @subpackage FontAwesome/includes
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

	// phpcs:ignore Generic.Commenting.DocComment.MissingShort
	/**
	 * @ignore
	 */
	protected static $handler = null;

	// phpcs:ignore Generic.Commenting.DocComment.MissingShort
	/**
	 * @ignore
	 */
	public static function set_handler( $handler ) {
		self::$handler = $handler;
	}

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
	 * - otherwise some HTTP error code as returned by {@see \Guzzle\Client}
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
		$client_params = array(
			// Base URI is used with relative requests.
			'base_uri' => FONTAWESOME_API_URL,
			// You can set any number of default request options.
			'timeout'  => 2.0,
		);
		if ( self::$handler ) {
			$client_params['handler'] = self::$handler;
		}
		$this->api_client = new Client( $client_params );

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
			$response = $this->api_client->get( 'api/releases' );

			$this->status = array_merge(
				$init_status,
				array(
					'code'    => $response->getStatusCode(),
					'message' => 'ok',
				)
			);

			$body          = $response->getBody();
			$body_contents = $body->getContents();
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
		} catch ( GuzzleHttp\Exception\ConnectException $e ) {
			$this->status = array_merge(
				$init_status,
				array(
					'code'    => $e->getCode(),
					'message' => 'Whoops, we could not connect to the Font Awesome server to get releases data.  ' .
						'There seems to be an internet connectivity problem between your WordPress server ' .
						'and the Font Awesome server.',
				)
			);
		} catch ( GuzzleHttp\Exception\ServerException $e ) {
			$this->status = array_merge(
				$init_status,
				array(
					'code'    => $e->getCode(),
					'message' => 'Whoops, there was a problem on the fontawesome.com server when we attempted to get releases data.  ' .
						'Probably if you reload to try again, it will work.',
				)
			);
		} catch ( GuzzleHttp\Exception\ClientException $e ) {
			$this->status = array_merge(
				$init_status,
				array(
					'code'    => $e->getCode(),
					'message' => 'Whoops, we could not update the releases data from the Font Awesome server.',
				)
			);
		} catch ( Exception $e ) {
			$this->status = array_merge(
				$init_status,
				array(
					'code'    => 0,
					'message' => 'Whoops, we failed to update the releases data.',
				)
			);
		} catch ( \Error $e ) {
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
	 * Returns a simple array of available Font Awesome versions as strings, sorted in descending semantic version order.
	 *
	 * @throws FontAwesome_NoReleasesException
	 * @return array
	 */
	public function versions() {
		return Semver::rsort( array_keys( $this->releases() ) );
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
	 * @return array
	 */
	public function get_resource_collection( $version, $style_opt, $flags = array(
		'use_pro'  => false,
		'use_svg'  => false,
		'use_shim' => true,
	) ) {
		$resources = array();

		if ( $flags['use_shim'] && ! $flags['use_svg'] && ! Semver::satisfies( $version, '>= 5.1.0' ) ) {
			throw new InvalidArgumentException(
				'A shim was requested for webfonts in Font Awesome version < 5.1.0, ' .
				'but webfont shims were not introduced until version 5.1.0.'
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
	 * @return string|null most recent major.minor.patch version (not a semver). Returns null if no versions available.
	 */
	public function latest_minor_release() {
		$sorted_versions = $this->versions();
		return count( $sorted_versions ) > 0 ? $sorted_versions[0] : null;
	}

	/**
	 * Returns a version number corresponding to the minor release immediately prior to the most recent minor release.
	 *
	 * @throws FontAwesome_NoReleasesException
	 * @return string|null latest patch level for the previous minor version. major.minor.patch version (not a semver).
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

		// Build a previous minor version semver.
		$version_parts    = explode( '.', $latest );
		$new_minor_number = intval( $version_parts[1] ) - 1;
		// make sure we don't try to use a negative number.
		$new_minor_number                         = $new_minor_number >= 0 ? $new_minor_number : 0;
		$version_parts[1]                         = $new_minor_number;
		$version_parts[2]                         = 0; // set patch level of the semver to zero.
		$previous_minor_release_semver_constraint = '~' . implode( '.', $version_parts );

		$satisfying_versions = Semver::rsort(
			Semver::satisfiedBy( $this->versions(), $previous_minor_release_semver_constraint )
		);

		$result = count( $satisfying_versions ) > 0 ? $satisfying_versions[0] : null;

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

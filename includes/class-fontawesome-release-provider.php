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

use Composer\Semver\Semver;
use GuzzleHttp\Client;

/**
 * Provides metadata about Font Awesome releases by querying fontawesome.com.
 *
 * @package    FontAwesome
 * @subpackage FontAwesome/includes
 */
class FontAwesome_Release_Provider {
	// phpcs:ignore Generic.Commenting.DocComment.MissingShort
	/**
	 * @ignore
	 */
	protected $_releases = null;

	// phpcs:ignore Generic.Commenting.DocComment.MissingShort
	/**
	 * @ignore
	 */
	protected $_status = array(
		'code'    => null,
		'message' => '',
	);

	// phpcs:ignore Generic.Commenting.DocComment.MissingShort
	/**
	 * @ignore
	 */
	protected $_api_client = null;

	// phpcs:ignore Generic.Commenting.DocComment.MissingShort
	/**
	 * @ignore
	 */
	protected static $_instance = null;

	// phpcs:ignore Generic.Commenting.DocComment.MissingShort
	/**
	 * @ignore
	 */
	protected static $_handler = null;

	// phpcs:ignore Generic.Commenting.DocComment.MissingShort
	/**
	 * @ignore
	 */
	public static function set_handler( $handler ) {
		self::$_handler = $handler;
	}

	/**
	 * Returns the FontAwesome_Release_Provider singleton instance.
	 *
	 * @return FontAwesome_Release_Provider
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * Resets the singleton instance referenced by this class and returns that new instance.
	 * All previous releases metadata held in the previous instance will be abandoned.
	 *
	 * @return FontAwesome_Release_Provider
	 */
	public static function reset() {
		self::$_instance = null;
		return self::instance();
	}

	/**
	 * Returns an associative array indicating the status of the status of the last network
	 * request that attempted to retrieve releases metadata.
	 *
	 * The shape looks like this:
	 * ```php
	 * array(
	 *   'code' => 403, // 200 if successful, otherwise some HTTP error code as returned by {@see \Guzzle\Client}
	 *   'message' => 'some message',
	 * )
	 * ```
	 * All previous releases metadata held in the previous instance will be abandoned.
	 *
	 * @return FontAwesome_Release_Provider
	 */
	public function get_status() {
		return $this->_status;
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
		if ( self::$_handler ) {
			$client_params['handler'] = self::$_handler;
		}
		$this->_api_client = new Client( $client_params );
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
	private function load_releases() {
		try {
			$response = $this->_api_client->get( 'api/releases' );

			$this->_status['code']    = $response->getStatusCode();
			$this->_status['message'] = 'ok';

			$body          = $response->getBody();
			$body_contents = $body->getContents();
			$body_json     = json_decode( $body_contents, true );
			$api_releases  = array_map( array( $this, 'map_api_release' ), $body_json['data'] );
			$releases      = array();
			foreach ( $api_releases as $release ) {
				$releases[ $release['version'] ] = $release;
			}
			$this->_releases = $releases;
		} catch ( GuzzleHttp\Exception\ConnectException $e ) {
			$this->_status['code']    = $e->getCode();
			$this->_status['message'] = 'Whoops, we could not connect to the Font Awesome server to get releases data.  ' .
										'There seems to be an internet connectivity problem between your WordPress server ' .
										'and the Font Awesome server.';
		} catch ( GuzzleHttp\Exception\ServerException $e ) {
			$this->_status['code']    = $e->getCode();
			$this->_status['message'] = 'Whoops, there was a problem on the fontawesome.com server when we attempted to get releases data.  ' .
										'Probably if you reload to try again, it will work.';
		} catch ( GuzzleHttp\Exception\ClientException $e ) {
			$this->_status['code']    = $e->getCode();
			$this->_status['message'] = 'Whoops, we could not update the releases data from the Font Awesome server.';
		} catch ( Exception $e ) {
			$this->_status['code']    = 0;
			$this->_status['message'] = 'Whoops, we failed to update the releases data from the Font Awesome server.';
		} catch ( Error $e ) {
			$this->_status['code']    = 0;
			$this->_status['message'] = 'Whoops, we failed when trying to update the releases data from the Font Awesome server.';
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
	protected function releases() {
		if ( is_null( $this->_releases ) ) {
			$this->load_releases();
		}
		// TODO: after figuring out how we'll handle releases API failures we may want to change what we return in the null case here.
		return is_null( $this->_releases ) ? array() : $this->_releases;
	}

	/**
	 * Returns a simple array of available Font Awesome versions as strings, sorted in descending semantic version order.
	 *
	 * @return array
	 */
	public function versions() {
		return Semver::rsort( array_keys( $this->releases() ) );
	}

	/**
	 * Returns an array containing version, shim, source URLs and integrity keys for given params.
	 * They should be loaded in the order they appear in this collection.
	 *
	 * @param string $version
	 * @param mixed  $style_opt either the string 'all' or an array containing any of the following:
	 *         ['solid', 'regular', 'light', 'brands']
	 * @param array  $flags boolean flags, defaults: array('use_pro' => false, 'use_svg' => false, 'use_shim' => true)
	 * @throws InvalidArgumentException if called with use_svg = true, use_shim = true and version < 5.1.0.
	 *         Shims were not introduced for webfonts until 5.1.0. Throws when called with an array for $style_opt
	 *         that contains no known style specifiers.
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
	 * @return string|null most recent major.minor.patch version (not a semver). Returns null if no versions available.
	 */
	public function latest_minor_release() {
		$sorted_versions = $this->versions();
		return count( $sorted_versions ) > 0 ? $sorted_versions[0] : null;
	}

	/**
	 * Returns a version number corresponding to the minor release immediately prior to the most recent minor release.
	 *
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
		$result              = count( $satisfying_versions ) > 0 ? $satisfying_versions[0] : null;
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

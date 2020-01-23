<?php
/**
 * This module is not considered part of the public API, only internal.
 * Any data or functionality that it produces should be exported by the
 * main FontAwesome class and the API documented and semantically versioned there.
 */
namespace FortAwesome;

use \WP_Error, \Error, \Exception, \InvalidArgumentException;

/**
 * Provides metadata about Font Awesome icons.
 *
 * @noinspection PhpIncludeInspection
 */

 // phpcs:ignore Generic.Commenting.DocComment.MissingShort
/**
 * @ignore
 */

class FontAwesome_Metadata_Provider {

  // phpcs:ignore Generic.Commenting.DocComment.MissingShort
	/**
	 * @ignore
	 */
  protected static $instance = null;

  // phpcs:ignore Generic.Commenting.DocComment.MissingShort
	/**
	 * @ignore
	 */
	protected function get( $url, $args = array() ) {
		return wp_remote_get( $url, $args );
  }

  // phpcs:ignore Generic.Commenting.DocComment.MissingShort
	/**
	 * @ignore
	 */
	protected function build_query_url( $url, $query ) {
		return "{$url}?{$query}";
	}


	/**
	 * Returns the FontAwesome_Metadata_Provider singleton instance.
	 *
	 * @return FontAwesome_Metadata_Provider
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
	 * @return FontAwesome_Metadata_Provider
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

  // phpcs:ignore Generic.Commenting.DocComment.MissingShort
	/**
	 * Loads all versions.
	 *
	 * @ignore
	 */
	public function get_available_versions() {
		$init_status = array(
			'code'    => null,
			'message' => '',
		);

		$args = array(
			'headers' => array(
				'Content-Type' => 'application/json'
				)
			);
		$url = FONTAWESOME_API_URL;
		$query = 'query={versions}';

		try {
			$response = $this->get( $this->build_query_url( $url, $query), $args );

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
      $json_body = json_decode( $body_contents );
      $versions = array();

      foreach($json_body->data->versions as $key => $val) {
        array_push( $versions, strval( $val ) );
      }

      usort(
        $versions,
        function( $first, $second ) {
          return version_compare( $second, $first );
        }
      );

			return $versions;
		} catch ( Exception $e ) {
			$this->status = array_merge(
				$init_status,
				array(
					'code'    => 0,
					'message' => 'Whoops, we failed to fetch the versions.',
				)
			);
		} catch ( Error $e ) {
			$this->status = array_merge(
				$init_status,
				array(
					'code'    => 0,
					'message' => 'Whoops, we failed when trying to fetch the versions.',
				)
			);
		}
	}

};
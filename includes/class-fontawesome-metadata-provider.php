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
 * Internal use only. Not part of this plugin's public API.
 *
 * @internal
 */
class FontAwesome_Metadata_Provider {
	/**
	 * Singleton instance.
	 * 
	 * @internal
	 */
	protected static $instance = null;

	/**
	 * Post method that wraps wp_remote_post.
	 * 
	 * Internal use only. Not part of this plugin's public API.
	 * 
	 * @internal
	 */
	protected function post( $url, $args = array() ) {
		return wp_remote_post( $url, $args );
	}

	/**
	 * Returns the FontAwesome_Metadata_Provider singleton instance.
	 *
	 * Internal use only. Not part of this plugin's public API.
	 *
	 * @return FontAwesome_Metadata_Provider
	 * @internal
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Returns query errors if there was a problem querying the
	 * graphql api in a readable string.
	 *
	 * @ignore
	 */
	protected function query_errors( $errors ) {
		$error_string = '';

		foreach ( $errors as $error ) {
			$error_string .= $error->message;
		}

		return $error_string;
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
	 * Loads all versions.
	 * 
	 * Internal use only. Not part of this plugin's public API.
	 *
	 * @internal
	 */
	public function get_available_versions() {
		$query         = 'query {versions}';
		$json          = $this->metadata_query( $query );
		$version_array = array();

		if ( 200 !== $this->status['code'] ) {
			return $this->status;
		}

		try {
			$versions = $json->versions;
			foreach ( $versions as $key => $val ) {
				array_push( $version_array, strval( $val ) );
			}

			usort(
				$versions,
				function( $first, $second ) {
					return version_compare( $second, $first );
				}
			);

			return $versions;
		} catch ( Exception $e ) {
			return array(
				'code'    => 0,
				'message' => 'Whoops, we failed to fetch the versions.',
			);
		} catch ( Error $e ) {
			return array(
				'code'    => 0,
				'message' => 'Whoops, we failed when trying to fetch the versions.',
			);
		}
	}

	/**
	 * Provides a way to query the API and return the data as parsed json
	 * based on the passed in query string.
	 * 
	 * Internal use only. Not part of this plugin's public API.
	 * Use the query() method on FortAwesome\FontAwesome instead.
	 *
	 * @ignore
	 */
	public function metadata_query( $query_string ) {
		$init_status = array(
			'code'    => null,
			'message' => '',
		);

		$args = array(
			'method'  => 'POST',
			'headers' => array(
				'Content-Type' => 'application/json',
			),
			'body'    => '{"query": ' . json_encode( $query_string ) . '}',
		);
		$url  = FONTAWESOME_API_URL;

		try {
			$response = $this->post( $url, $args );

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
				return $this->status;
			}

			$body_contents = $response['body'];
			$json_body     = json_decode( $body_contents );

			if ( property_exists( $json_body, 'errors' ) ) {
				return array(
					'code'    => 200,
					'message' => $this->query_errors( $json_body->errors ),
				);
			}

			return $json_body->data;
		} catch ( Exception $e ) {
			$this->status = array_merge(
				$init_status,
				array(
					'code'    => 0,
					'message' => 'Whoops, the query failed.',
				)
			);
		} catch ( Error $e ) {
			$this->status = array_merge(
				$init_status,
				array(
					'code'    => 0,
					'message' => 'Whoops, there was an error while querying.',
				)
			);
		}
	}
}

/**
 * Convenience global function to get a singleton instance of the Metadata Provider.
 * 
 * Internal use only. Not part of this plugin's public API.
 *
 * @see FontAwesome_Metadata_Provider::instance()
 * @return FontAwesome_Metadata_Provider
 * @internal
 */
function fa_metadata_provider() {
	return FontAwesome_Metadata_Provider::instance();
}

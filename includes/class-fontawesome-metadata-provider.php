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
			$error_string .= $error['message'];
		}

		return $error_string;
	}

	/**
	 * Provides a way to query the API and return the data as parsed json
	 * based on the passed in query string.
	 *
	 * Internal use only. Not part of this plugin's public API.
	 * Use the query() method on FortAwesome\FontAwesome instead.
	 *
	 * @ignore
	 * @return WP_Error | array
	 */
	public function metadata_query( $query_string ) {
		$args = array(
			'method'  => 'POST',
			'headers' => array(
				'Content-Type' => 'application/json',
			),
			'body'    => '{"query": ' . json_encode( $query_string ) . '}',
		);

		try {
			$response = $this->post( FONTAWESOME_API_URL, $args );

			if ( $response instanceof WP_Error ) {
				return $response;
			}

			if ( 200 !== $response['response']['code'] ) {
				return new WP_Error(
					'fontawesome_api_failed_request',
					$response['response']['message'],
					array( 'status' => $response['response']['code'] )
				);
			}

			$body = json_decode( $response['body'], true );

			$export = var_export($body, true);

			if ( isset( $body['errors'] ) ) {
				return new WP_Error(
					'fontawesome_api_query_error',
					$this->query_errors( $body['errors'] ),
					array( 'status' => $response['response']['code'] )
				);
			}

			return $body['data'];
		} catch ( Exception $e ) {
			return new WP_Error(
				'fontawesome_exception',
				$e->getMessage()
			);
		} catch ( Error $e ) {
			return new WP_Error(
				'fontawesome_error',
				$e->getMessage()
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

<?php
namespace FortAwesome;

use \Exception;

// phpcs:disable Generic.Files.OneClassPerFile.MultipleFound

abstract class FontAwesomeException extends Exception {

	/**
	 * A message appropriate for display to a user.
	 */
	protected $ui_message = null;

	/**
	 * A WP_Error object that was the occassion for this exception.
	 */
	protected $wp_error = null;

	/**
	 * An HTTP response array that is the occassion for this exception.
	 * Array keys should be like an array that would be returned from wp_remote_post().
	 */
	protected $wp_response = null;

	public function __construct( $message = "", $code = 0, $previous = NULL ) {
		parent::__construct( $message, $code, $previous );

		if( is_string( $message ) && !empty( $message ) ) {
			$this->message = $message;
		} elseif( ! is_null( $this->ui_message ) ) {
			$this->message = $this->ui_message;
		}
	}

	public static function with_wp_error( $wp_error ) {
		// This is how we invoke the derived class's constructor from an inherited static method.
		$obj = new static();

		if( ! is_null( $wp_error ) && is_a( $wp_error, 'WP_Error' ) ) {
			$obj->wp_error = $wp_error;
		}

		return $obj;
	}
	
	/**
	 * Construct an exception with an associated HTTP response.
	 *
	 * @param $wp_reponse a response array as would be returned by wp_remote_post()
	 *   with keys like: 'headers', 'body', 'response'
	 */
	public static function with_wp_response( $wp_response ) {
		// This is how we invoke the derived class's constructor from an inherited static method.
		$obj = new static();

		if(
			!is_null( $wp_response ) &&
			is_array( $wp_response ) &&
			isset( $wp_response['headers'] ) &&
			isset( $wp_response['body'] ) &&
			isset( $wp_response['response'] )
		) {
			$obj->wp_response = $wp_response;
		}

		return $obj;
	}

	public function get_wp_error() {
		return $this->wp_error;
	}

	public function get_wp_response() {
		return $this->wp_response;
	}
}

class ApiTokenMissingException extends FontAwesomeException {
	public $ui_message = 'Whoops, it looks like you have not provided a ' .
		'Font Awesome API Token. Enter one on the Font Awesome plugin settings page.';
}

class ApiTokenEndpointRequestException extends FontAwesomeException {
	public $ui_message = 'Your WordPress server failed when trying to communicate ' .
		'with the Font Awesome API token endpoint.';
}

class ApiTokenEndpointResponseException extends FontAwesomeException {
	public $ui_message = 'Whoops, it looks like that API Token is not valid. Try another one?';

	const BAD_RESPONSE_SCHEMA_MESSAGE = 'Oh no! It looks like your API Token was valid, ' .
		'but the Font Awesome API server still returned an invalid response.';

	public static function with_wp_response( $wp_response, $extra_code = NULL ) {
		$e = parent::with_wp_response( $wp_response );

		if('schema' === $extra_code) {
			$e->message = $e->ui_message = self::BAD_RESPONSE_SCHEMA_MESSAGE;
		}

		return $e;
	}
}

class AccessTokenStorageException extends FontAwesomeException {
	public $ui_message = 'There was a problem trying to store API credentials. Your API Token ' .
		' was valid, but storage failed.';
}

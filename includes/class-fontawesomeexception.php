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

	public function get_wp_error() {
		return $this->wp_error;
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

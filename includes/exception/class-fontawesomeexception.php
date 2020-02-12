<?php
namespace FortAwesome\Exception;

use \Exception;

abstract class FontAwesomeException extends Exception {

	/**
	 * A message appropriate for display to a user.
	 */
	public $ui_message = null;

	public function __construct( $message = "", $code = 0, $previous = NULL ) {
		parent::__construct( $message, $code, $previous );

		if( is_string( $message ) && !empty( $message ) ) {
			$this->message = $message;
		} elseif( ! is_null( $this->ui_message ) ) {
			$this->message = $this->ui_message;
		}
	}
}

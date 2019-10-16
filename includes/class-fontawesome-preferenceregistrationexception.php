<?php
namespace FortAwesome;

use \Exception;

/**
 * Module for FontAwesome_PreferenceRegistrationException.
 *
 * @noinspection PhpIncludeInspection
 */

/**
 * An exception class whose instances have messages intended to be returned as user-readable errors in the admin UI.
 *
 * @ignore
 * @internal
 */
class FontAwesome_PreferenceRegistrationException extends Exception {
		/**
     * Ignore
     *
		 * @ignore
     * @internal
		 */
    protected $original_exception = null;
    
		/**
     * Ignore
     *
		 * @ignore
		 */
		public function __construct($original_exception = null) {
      $this->original_exception = $original_exception;
    }
    
    /**
     * Returns the exception that was caught in third party code and re-thrown as
     * this exception.
     *
     * @ignore
     * @internal
     * @return Exception
     */
    public function getOriginalException() {
      return $this->original_exception;
    }
}

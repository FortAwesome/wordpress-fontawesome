<?php
namespace FortAwesome;

use \Exception;

// phpcs:disable Generic.Files.OneClassPerFile.MultipleFound

abstract class FontAwesome_Exception extends Exception {

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

	/**
	 * Construct an exception with a previously thrown Error or Exception.
	 * 
	 * (The Throwable interface is not available until PHP 7, and we support back to 5.6.)
	 *
	 * @param $e Error or Exception
	 */
	public static function with_thrown( $e ) {
		return new static( null, 0, $e );
	}

	public function get_wp_error() {
		return $this->wp_error;
	}

	public function get_wp_response() {
		return $this->wp_response;
	}
}

abstract class FontAwesome_ServerException extends FontAwesome_Exception {}

abstract class FontAwesome_ClientException extends FontAwesome_Exception {}

class ApiTokenMissingException extends FontAwesome_ClientException {
	public $ui_message = 'Whoops, it looks like you have not provided a ' .
		'Font Awesome API Token. Enter one on the Font Awesome plugin settings page.';
}

class ApiTokenEndpointRequestException extends FontAwesome_ServerException {
	public $ui_message = 'Your WordPress server failed when trying to communicate ' .
		'with the Font Awesome API token endpoint.';
}

class ApiTokenInvalidException extends FontAwesome_ClientException {
	public $ui_message = 'Whoops, it looks like that API Token is not valid. Try another one?';
}

class ApiTokenEndpointResponseException extends FontAwesome_ServerException {
	public $ui_message = 'Oh no! It looks like your API Token was valid, ' .
		'but the Font Awesome API server still returned an invalid response.';
}

class AccessTokenStorageException extends FontAwesome_ServerException {
	public $ui_message = 'There was a problem trying to store API credentials. Your API Token ' .
		' was valid, but storage failed.';
}

class ConfigSchemaException extends FontAwesome_ClientException {
	public function __construct( $code = NULL ) {
		switch( $code ) {
			case 'kit_token_no_api_token':
				return parent::__construct(
					'A kitToken was given without a valid apiToken'
				);
			case 'concrete_version_expected':
				return parent::__construct(
					'A Font Awesome version number was expected but not given',
				);
			case 'webfont_v4compat_introduced_later':
				return parent::__construct(
					'Whoops! You found a corner case here. ' .
					'Version 4 compatibility for our webfont technology was not introduced until Font Awesome 5.1.0. ' .
					'Try using a newer version, disabling version 4 compatibility, or switch to SVG.'
				);
			default:
				return parent::__construct(
					'Invalid options were given'
				);
		}
	}
}

class PreferenceRegistrationException extends FontAwesome_ServerException {
	public $ui_message = 'A theme or plugin registered with Font Awesome threw an exception.';
}

class ApiRequestException extends FontAwesome_ServerException {
	public $ui_message = 'Your WordPress server failed trying to send a request to the Font Awesome API server.';
}

class ApiResponseException extends FontAwesome_ServerException {
	public $ui_message = 'An unexpected response was received from the Font Awesome API server.';
}

class ReleaseProviderStorageException extends FontAwesome_ServerException {
	public $ui_message = 'Failed to store releases transient';
}

class ReleaseMetadataMissingException extends FontAwesome_ServerException {
	public $ui_message = "Somehow, we're missing metadata about available Font Awesome releaes, which should have " .
		"already been queried from the Font Awesome API server. Try deactivating and re-activating the Font Awesome plugin.";
}

class ConfigCorruptionException extends FontAwesome_ServerException {
	public $ui_message = "When trying to load Font Awesome, the plugin's configuration was invalid. " .
		"Try deactivating, uninstalling, and re-activating the Font Awesome plugin.";
}

class ConflictDetectionSchemaException extends FontAwesome_ClientException {
	public $ui_message = "When trying to load Font Awesome, the plugin's configuration was invalid. " .
		"Try deactivating, uninstalling, and re-activating the Font Awesome plugin.";

}

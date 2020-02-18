<?php
namespace FortAwesome;

use \Exception;

// phpcs:disable Generic.Files.OneClassPerFile.MultipleFound

abstract class FontAwesome_Exception extends Exception {
	/**
	 * A WP_Error object that was the occassion for this exception.
	 */
	protected $wp_error = null;

	/**
	 * An HTTP response array that is the occassion for this exception.
	 * Array keys should be like an array that would be returned from wp_remote_post().
	 */
	protected $wp_response = null;

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
	public function __construct( $message = null, $code = 0, $previous = null ) {
		return parent::__construct(
			esc_html__(
				'Whoops, it looks like you have not provided a ' .
				'Font Awesome API Token. Enter one on the Font Awesome plugin settings page.',
				FONTAWESOME_TEXT_DOMAIN
			),
			$code,
			$previous
		);
	}
}

class ApiTokenEndpointRequestException extends FontAwesome_ServerException {
	public function __construct( $message = null, $code = 0, $previous = null ) {
		return parent::__construct(
			esc_html__(
				'Your WordPress server failed when trying to communicate ' .
				'with the Font Awesome API token endpoint.',
				FONTAWESOME_TEXT_DOMAIN
			),
			$code,
			$previous
		);
	}
}

class ApiTokenInvalidException extends FontAwesome_ClientException {
	public function __construct( $message = null, $code = 0, $previous = null ) {
		return parent::__construct(
			esc_html__(
				'Whoops, it looks like that API Token is not valid. Try another one?',
				FONTAWESOME_TEXT_DOMAIN
			),
			$code,
			$previous
		);
	}
}

class ApiTokenEndpointResponseException extends FontAwesome_ServerException {
	public function __construct( $message = null, $code = 0, $previous = null ) {
		return parent::__construct(
			esc_html__(
				'Oh no! It looks like your API Token was valid, ' .
				'but the Font Awesome API server still returned an invalid response.',
				FONTAWESOME_TEXT_DOMAIN
			),
			$code,
			$previous
		);
	}
}

class AccessTokenStorageException extends FontAwesome_ServerException {
	public function __construct( $message = null, $code = 0, $previous = null ) {
		return parent::__construct(
			esc_html__(
				'There was a problem trying to store API credentials. Your API Token ' .
				'was valid, but storage failed.',
				FONTAWESOME_TEXT_DOMAIN
			),
			$code,
			$previous
		);
	}
}

class ConfigSchemaException extends FontAwesome_ClientException {

	public static function kit_token_no_api_token() {
		return new static(
			esc_html__(
				'A kitToken was given without a valid apiToken',
				FONTAWESOME_TEXT_DOMAIN
			)
		);
	}

	public static function concrete_version_expected() {
		return new static(
			esc_html__(
				'A Font Awesome version number was expected but not given',
				FONTAWESOME_TEXT_DOMAIN
			)
		);
	}

	public static function webfont_v4compat_introduced_later() {
		return new static(
			esc_html__(
				'Whoops! You found a corner case here. ' .
				'Version 4 compatibility for our webfont technology was not introduced until Font Awesome 5.1.0. ' .
				'Try using a newer version, disabling version 4 compatibility, or switch to SVG.',
				FONTAWESOME_TEXT_DOMAIN
			)
		);
	}
}

class PreferenceRegistrationException extends FontAwesome_ServerException {
	public function __construct( $message = null, $code = 0, $previous = null ) {
		return parent::__construct(
			esc_html__(
				'A theme or plugin registered with Font Awesome threw an exception.',
				FONTAWESOME_TEXT_DOMAIN
			),
			$code,
			$previous
		);
	}
}

class ApiRequestException extends FontAwesome_ServerException {
	public function __construct( $message = null, $code = 0, $previous = null ) {
		return parent::__construct(
			esc_html__(
				'Your WordPress server failed trying to send a request to the Font Awesome API server.',
				FONTAWESOME_TEXT_DOMAIN
			),
			$code,
			$previous
		);
	}
}

class ApiResponseException extends FontAwesome_ServerException {
	public function __construct( $message = null, $code = 0, $previous = null ) {
		return parent::__construct(
			esc_html__(
				'An unexpected response was received from the Font Awesome API server.',
				FONTAWESOME_TEXT_DOMAIN
			),
			$code,
			$previous
		);
	}
}

class ReleaseProviderStorageException extends FontAwesome_ServerException {
	public function __construct( $message = null, $code = 0, $previous = null ) {
		return parent::__construct(
			esc_html__(
				'Failed to store Font Awesome releases metadata in your WordPress datbase.',
				FONTAWESOME_TEXT_DOMAIN
			),
			$code,
			$previous
		);
	}
}

class ReleaseMetadataMissingException extends FontAwesome_ServerException {
	public function __construct( $message = null, $code = 0, $previous = null ) {
		return parent::__construct(
			esc_html__(
				"Somehow, we're missing metadata about available Font Awesome releaes, which should have " .
				"already been queried from the Font Awesome API server. Try deactivating and re-activating the Font Awesome plugin.",
				FONTAWESOME_TEXT_DOMAIN
			),
			$code,
			$previous
		);
	}
}

class ConfigCorruptionException extends FontAwesome_ServerException {
	public function __construct( $message = null, $code = 0, $previous = null ) {
		return parent::__construct(
			esc_html__(
				"When trying to load Font Awesome, the plugin's configuration was invalid. " .
				"Try deactivating, uninstalling, and re-activating the Font Awesome plugin.",
				FONTAWESOME_TEXT_DOMAIN
			),
			$code,
			$previous
		);
	}
}

class ConflictDetectionSchemaException extends FontAwesome_ClientException {
	public function __construct( $message = null, $code = 0, $previous = null ) {
		return parent::__construct(
			esc_html__(
				"The conflict detection data sent to your WordPress server was invalid.",
				FONTAWESOME_TEXT_DOMAIN
			),
			$code,
			$previous
		);
	}
}

class ConflictDetectionStorageException extends FontAwesome_ServerException {
	public function __construct( $message = null, $code = 0, $previous = null ) {
		return parent::__construct(
			esc_html__(
				"We were not able to save conflict detection data to your WordPress database.",
				FONTAWESOME_TEXT_DOMAIN
			),
			$code,
			$previous
		);
	}
}

/**
 * Indicates that an incorrect array schema has been provided as the client perferences
 * parameter to {@see FontAwesome::register()}.
 */
class ClientPreferencesSchemaException extends FontAwesome_ServerException {}

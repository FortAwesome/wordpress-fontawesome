<?php
/**
 * This module is not considered part of the public API, only internal.
 */
namespace FortAwesome;

use \WP_Error, \InvalidArgumentException;

/**
 * Provides read/write access to the Font Awesome API settings.
 */
class FontAwesome_API_Settings {
	/**
	 * Name of the settings file that will be stored adjacent to wp-config.php.
	 *
	 * @since 4.0.0
	 * @ignore
	 */
	const FILENAME = 'font-awesome-api.ini';

	/**
	 * TODO: remove either this one or the one that has been defined
	 * in the new Metadata API module.
	 */
	const FONTAWESOME_API_URL = 'https://api.fontawesome.com';

	/**
	 * Current access token.
	 *
	 * @internal
	 * @ignore
	 */
	protected $_access_token = null;

	/**
	 * Expiration time for current access token.
	 * 
	 * @internal
	 * @ignore
	 */
	protected $_access_token_expiration_time = null;

	/**
	 * Current API token.
	 * 
	 * @internal
	 * @ignore
	 */
	protected $_api_token = null;

	/**
	 * Singleton instance.
	 * 
	 * @internal
	 * @ignore
	 */
	protected static $instance = null;

	/**
	 * Returns the FontAwesome_API_Settings singleton instance.
	 * 
	 * Internal use only. Not part of this plugin's public API.
	 *
	 * @return FontAwesome_API_Settings
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
	 * @return FontAwesome_API_Settings
	 */
	public static function reset() {
		self::$instance = null;
		return self::instance();
	}

	/**
	 * Private constructor.
	 *
	 * @ignore
	 */
	private function __construct() {
		$initial_data = self::read_from_file();

		if ( ! boolval( $initial_data ) ) {
			return;
		} else {
			if ( isset( $initial_data['api_token'] ) ) {
				$this->_api_token = $initial_data['api_token'];
			}
			if ( isset( $initial_data['access_token'] ) ) {
				$this->_access_token = $initial_data['access_token'];
			}
			if ( isset( $initial_data['access_token_expiration_time'] ) ) {
				$int_val = intval( $initial_data['access_token_expiration_time'] );

				if ( 0 !== $int_val ) {
					$this->_access_token_expiration_time = $int_val;
				} else {
					$this->_access_token_expiration_time = null;
				}
			}
		}
	}

	/**
	 * Reads ini file into an associative array, or returns false
	 * if the file does not exist or there is an error.
	 * 
	 * Internal use only, not part of this plugin's public API.
	 * 
	 * @ignore
	 * @internal
	 */
	protected static function read_from_file() {
		$config_path = self::ini_path(); 

        if ( ! file_exists( $config_path ) ) { 
            return false; 
		} 

		return parse_ini_file ( $config_path, TRUE );
	}

	/**
     * Returns the path to our font-awesome-api.ini file where we'll store
	 * API token and access token data.
	 * 
	 * Internal use only. Not part of this plugin's public API.
	 *
	 * @ignore
	 * @internal
	 */
	static public function ini_path() {
		return trailingslashit( ABSPATH ) . self::FILENAME;
	}

	/**
	 * Writes current config.
	 * 
	 * Internal use only. Not part of this plugin's public API.
	 * 
	 * @ignore
	 * @internal
	 * @return bool whether write succeeded
	 */
	public function write() {
		$date = date(DATE_RFC2822);
		$api_token = $this->api_token();
		$access_token = $this->access_token();
		$access_token_expiration_time = $this->access_token_expiration_time();
		$contents = <<< EOD
; Font Awesome API Settings
;
; Created by the font-awesome plugin on $date
;
; This was created when you added your Font Awesome API Token in the plugin's
; settings page. It allows your WordPress server to connect to your Font Awesome
; account for using kits and such.
;
; Use the plugin's settings page to manage the contents of this file.
; To get rid of it entirely, instead of just deleting this file, use the
; plugin settings page to delete the API Token. That will cause this whole file
; to go away, and also do the other cleanup necessary in the database.

EOD;
		// Write each setting to the file conditionally, if it doesn't have
		// a string value in memory, don't write it at all.
		if ( is_string( $api_token ) ) {
			$contents .= "\napi_token = \"" . $api_token . "\"\n";
		}

		if ( is_string( $access_token ) ) {
			$contents .= "\naccess_token = \"" . $access_token . "\"\n";
		}

		if ( is_int( $access_token_expiration_time ) ) {
			$contents .= "\naccess_token_expiration_time = " . $access_token_expiration_time . "\n";
		}

		if ( !@file_put_contents( self::ini_path(), $contents ) ) { 
			return false; 
		}  else {
			return true;
		}
	}

	/**
	 * Removes current API Token and related settings, setting them all to null,
	 * and deletes the backing ini file store.
	 * 
	 * Internal use only. Not part of this plugin's public API.
	 * 
	 * @internal
	 * @ignore
	 */
	public function remove() {
		wp_delete_file( self::ini_path() );
		self::reset();
	}

	/**
	 * Returns the current API Token.
	 * 
	 * Internal use only. Not part of this plugin's public API.
	 * 
	 * @ignore
	 * @internal
	 */
	public function api_token() {
		return $this->_api_token;
	}

	/**
	 * Sets the API Token.
	 * 
	 * Internal use only. Not part of this plugin's public API.
	 */
	public function set_api_token($api_token) {
		$this->_api_token = $api_token;
	}

	/**
	 * Returns the current access token.
	 * 
	 * Internal use only. Not part of this plugin's public API.
	 * 
	 * @ignore
	 * @internal
	 */
	public function access_token() {
		return $this->_access_token;
	}

	/**
	 * Sets the current access_token.
	 * 
	 * Internal use only. Not part of this plugin's public API.
	 */
	public function set_access_token($access_token) {
		$this->_access_token = $access_token;
	}

	/**
	 * Sets the current access_token_expiration_time.
	 * 
	 * Internal use only. Not part of this plugin's public API.
	 * 
	 * @param int $access_token_expiration_time time in unix epoch seconds as non-zero integer value
	 * @throws InvalidArgumentException if the given param is zero or cannot be cast as an integer
	 */
	public function set_access_token_expiration_time($access_token_expiration_time) {
		$int_val = intval( $access_token_expiration_time );

		if ( 0 !== $int_val ) {
			$this->_access_token_expiration_time = $access_token_expiration_time;
		} else {
			throw new InvalidArgumentException("value must be a non-zero integer");
		}
	}

	/**
	 * Returns the expiration time for the current access token.
	 * 
	 * Internal use only. Not part of this plugin's public API.
	 * 
	 * @ignore
	 * @internal
	 */
	public function access_token_expiration_time() {
		return $this->_access_token_expiration_time;
	}

	/**
	 * Requests an access_token with the current api_token. Stores the result
	 * upon successfully retrieving an access token.
	 * 
	 * Internal use only. Not part of this plugin's API.
	 * 
	 * @ignore
	 * @internal
	 * @return WP_Error | TRUE if the request was successful and we have an access_token; otherwise, WP_Error
	 * @throws WP_Error
	 */
	public function request_access_token() {
		if ( ! is_string( $this->api_token() ) ) {
			return new WP_Error(
				'api_token',
				'Whoops, it looks like you have not provided an API Token. Enter one on the Font Awesome plugin settings page.',
				array( 'status' => 403 )
			);
		}

		$response = $this->post(
			array(
				'body'    => '',
				'headers' => array(
					'authorization' => 'Bearer ' . $this->api_token()
				)
			)
		);

		if ( $response instanceof WP_Error ) {
			return new WP_Error(
				'access_token',
				'Sorry, our attempt to authenticate with the Font Awesome API server failed. Reload and try again?',
				array( 'status' => 403 )
			);
		}

		if ( 200 !== $response['response']['code'] ) {
			return new WP_Error(
				'access_token',
				'Whoops, it looks like that API Token is not valid. Try another one?',
				array( 'status' => 403 )
			);
		}

		$body = json_decode( $response['body'], true );

		if (
			! isset( $body['access_token'] ) ||
			! is_string( $body['access_token'] ) ||
			! isset( $body['expires_in'] ) ||
		 	! is_int( $body['expires_in'] )
		) {
			return new WP_Error(
				'access_token',
				'Oh no! It looks like your API Token was valid, but the Font Awesome API server failed anyway.',
				array( 'status' => 403 )
			);
		}

		$this->set_access_token( $body['access_token'] );
		$this->set_access_token_expiration_time( $body['expires_in'] + time() );

		$result = $this->write();

		if ( ! boolval( $result ) ) {
			return new WP_Error(
				'access_token',
				'Ouch. Your API Token was valid, but when we tried to save it on your WordPress server, it failed.',
				array( 'status' => 403 )
			);
		} else {
			return TRUE;
		}
	}

	/**
	 * Wrapper for wp_remote_post(). Mostly to make it easier to mock the network
	 * request with a subclass.
	 * 
	 * Internal use only. Not part of this plugin's public API.
	 * 
	 * @ignore
	 * @internal
	 * @return WP_Error | array just like wp_remote_post()
	 */
	protected function post( $args ) {
		return wp_remote_post( self::FONTAWESOME_API_URL . '/token', $args );
	}
}

/**
 * Convenience global function to get a singleton instance of the API Settings.
 * 
 * Internal use only. Not part of this plugin's public API.
 *
 * @return FontAwesome_API_Settings
 */
function fa_api_settings() {
	return FontAwesome_API_Settings::instance();
}

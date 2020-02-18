<?php
namespace FortAwesome;

use \WP_Error, \Exception;

/**
 * Handle fatal errors
 *
 * @ignore
 */
function notify_admin_fatal_error( $e ) {
	if ( method_exists( 'FortAwesome\FontAwesome_Loader', 'emit_admin_error_output' ) ) {
		add_action(
			'admin_notices',
			function() use( $e ) {
				FontAwesome_Loader::emit_admin_error_output( $e );
			}
		);
	}
}

/**
 * Internal use only, not part of this plugin's public API.
 *
 * @internal
 * @ignore
 */
function build_wp_error($e, $code, $status) {
	if( is_a($e, 'Error') || is_a($e, 'Exception') ) {
		$previous = boolval( $e->getPrevious() )
			? build_wp_error( $e->getPrevious(), 'previous_exception', 500 )
			: null;

		$current = new WP_Error(
			$code,
			$e->getMessage(),
			array(
				'status' => $status,
				'trace'  => $e->getTraceAsString(),
			)
		);

		if( ! is_null( $previous ) ) {
			$current->add(
				$previous->get_error_code(),
				$previous->get_error_message(),
				$previous->get_error_data()
			);
		}

		return $current;
	} else {
		try {
			$as_string = (
				method_exists( $e, '__toString' ) ||
				is_string( $e ) ||
				is_numeric( $e ) 
			) ? strval( $e ) : null;

			$message = 'Unexpected Thing, neither Error or Exception';

			if( is_null( $as_string ) ) {
				$message .= ', which cannot be stringified.';
			} else {
				$message .= ", stringified: $as_string";
			}

			throw new Exception( $message );
		} catch( Exception $e ) {
			return new WP_Error(
				$code,
				$e->getMessage(),
				array(
					'status' => $status,
					'trace'  => $e->getTraceAsString()
				)
			);
		}
	}

}

/**
 * Internal use only, not part of this plugin's public API.
 *
 * @internal
 * @ignore
 */
function unknown_error_500( $e ) {
	return build_wp_error( $e, 'fontawesome_unknown_error', 500 );
}

/**
 * Internal use only, not part of this plugin's public API.
 *
 * @internal
 * @ignore
 */
function fa_400( $e ) {
	return build_wp_error( $e, 'fontawesome_client_exception', 400 );
}

/**
 * Internal use only, not part of this plugin's public API.
 *
 * @internal
 * @ignore
 */
function fa_500( $e ) {
	return build_wp_error( $e, 'fontawesome_server_exception', 500 );
}

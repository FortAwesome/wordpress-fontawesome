<?php
namespace FortAwesome;

use \WP_Error, \Exception;

function build_wp_error($e, $code, $status) {
	if( is_a($e, 'Error') || is_a($e, 'Exception') ) {
		return new WP_Error(
			$code,
			$e->getMessage(),
			array(
				'status' => $status,
				'trace'  => $e->getTraceAsString(),
			)
		);
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

function unknown_error_500( $e ) {
	return build_wp_error( $e, 'fa_unknown_error', 500 );
}

function fa_400( $e ) {
	return build_wp_error( $e, 'fontawesome_exception', 400 );
}

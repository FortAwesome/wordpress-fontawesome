<?php
namespace FortAwesome\Exception;

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
			throw new Exception('Unexpected Thing, neither Error or Exception: ' . strval( $e ));
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

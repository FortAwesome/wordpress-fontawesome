<?php
namespace FortAwesome\Exception;

use \WP_Error, \Exception;

function wp_error_500($e, $code = 'fa_unknown_error') {
	if( is_a($e, 'Error') || is_a($e, 'Exception') ) {
		return new WP_Error(
			$code,
			$e->getMessage(),
			array(
				'status' => 500,
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
					'status' => 500,
					'trace'  => $e->getTraceAsString()
				)
			);
		}
	}
}

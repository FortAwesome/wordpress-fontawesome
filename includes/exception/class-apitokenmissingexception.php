<?php
namespace FortAwesome\Exception;

require_once trailingslashit( FONTAWESOME_DIR_PATH ) . 'includes/exception/class-fontawesomeexception.php';

use \Exception;

class ApiTokenMissingException extends FontAwesomeException {
	public $ui_message = 'Whoops, it looks like you have not provided a ' .
		'Font Awesome API Token. Enter one on the Font Awesome plugin settings page.';
}

<?php

namespace FontAwesomeElementorAddon;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Options {
	private const OPTIONS_KEY = 'fontawesome_elementor_addon';

	public static function options_key(): string {
		return self::OPTIONS_KEY;
	}
}

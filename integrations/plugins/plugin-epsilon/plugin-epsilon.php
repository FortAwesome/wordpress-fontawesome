<?php

/**
 * Plugin Name:       Plugin Epsilon
 * Plugin URI:        https://fontawesome.com/plugin-epsilon/
 * Description:       Test Client Plugin that registers with Font Awesome but throws an exception when processing requirements.
 * Version:           0.0.1
 * Author:            Font Awesome
 * Author URI:        https://fontawesome.com/
 * License:           UNLICENSED
 */

defined( 'WPINC' ) || die;
define( 'EPSILON_PLUGIN_VERSION', '0.0.1' );
define( 'EPSILON_PLUGIN_LOG_PREFIX', 'epsilon-plugin' );

add_action(
	'font_awesome_requirements',
	function() {
		throw new Exception( EPSILON_PLUGIN_LOG_PREFIX . ' throwing' );
	}
);


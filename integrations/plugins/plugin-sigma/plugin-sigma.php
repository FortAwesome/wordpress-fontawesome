<?php

/**
 * Plugin Name:       Plugin Sigma
 * Plugin URI:        https://fontawesome.com/
 * Description:       Registered Client embedding Font Awesome as a composer dependency. When this plugin is activated, Font Awesome is implicitly activated, whether or not the Font Awesome plugin is directly installed or activated. Running this often requires updating plugin-sigma's composer.json to require an updated version of the Font Awesome plugin. Be sure to run composer update after making such changes.
 * Version:           0.0.1
 * Author:            Font Awesome
 * Author URI:        https://fontawesome.com/
 * License:           UNLICENSED
 */

defined( 'WPINC' ) || die;
define( 'SIGMA_PLUGIN_VERSION', '0.0.1' );
define( 'SIGMA_PLUGIN_LOG_PREFIX', 'sigma-plugin' );

// index.php is the entry point that must be required in order to leverage
// the FontAwesome_Loader.
require_once __DIR__ . '/vendor/fortawesome/wordpress-fontawesome/index.php';

use function FortAwesome\fa;

// A client like this should initialize() Font Awesome upon its own activation.
// Otherwise, it will not have the initial options settings it requires.
// See the doc for initialize() regarding how any pre-existing option settings
// are handled, preserved, or overwritten.
register_activation_hook(
	__FILE__,
	'FortAwesome\FontAwesome_Loader::initialize'
);

// A client should invoke FortAwesome\FontAwesome_Loader::maybe_deactivate()
// when it is deactivated. Actual deactivation will only occur if this is the
// last remaining plugin installation.
register_deactivation_hook(
	__FILE__,
	'FortAwesome\FontAwesome_Loader::maybe_deactivate'
);

// A client should invoke FortAwesome\FontAwesome_Loader::maybe_uninstall()
// when it is uninstalled. Actual uninstall will only occur if this is the
// last remaining plugin installation.
register_uninstall_hook(
	__FILE__,
	'FortAwesome\FontAwesome_Loader::maybe_uninstall'
);

// It is good to register as a client, even if no configuration preferences
// are being specified, because the plugin's settings page may show the site owner
// a listing of which plugins or themes are actively using Font Awesome and
// what their preferences are.
add_action(
	'font_awesome_preferences',
	function() {
		fa()->register(
			array(
				'name' => SIGMA_PLUGIN_LOG_PREFIX,
			)
		);
	}
);

add_action(
	'init',
	function() {
		// phpcs:ignore WordPress.WP.EnqueuedResourceParameters
		wp_enqueue_style(
			'plugin-sigma-style',
			trailingslashit( plugins_url() ) . trailingslashit( plugin_basename( __DIR__ ) ) . 'style.css',
			array(),
			null,
			'all'
		);
	}
);

add_filter(
	'the_content',
	function( $content ) {
		$pre_content = <<<EOT
<div class="plugin-sigma-pre-content" style="border: 1px solid grey;">
  <h2>Plugin Sigma</h2>
  <p>Expected by plugin-sigma: "fab fa-fort-awesome": <i class="fab fa-fort-awesome"></i></p>
</div>
EOT;
		return $pre_content . $content;
	},
	10,
	1
);

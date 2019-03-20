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

require_once __DIR__ . '/vendor/fortawesome/wordpress-fontawesome/font-awesome.php';

use function FortAwesome\fa;

add_action(
	'font_awesome_requirements',
	function() {
		if ( class_exists( 'FontAwesome' ) ) {
			fa()->register(
				array(
					'name'          => SIGMA_PLUGIN_LOG_PREFIX,
					'clientVersion' => SIGMA_PLUGIN_VERSION,
				)
			);
		}
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

add_action(
	'font_awesome_enqueued',
	function( $load_spec ) {
		if ( class_exists( 'FontAwesome' ) ) {
			// phpcs:ignore WordPress.PHP.DevelopmentFunctions
			error_log( SIGMA_PLUGIN_LOG_PREFIX . ' font_awesome_enqueued: method: ' . $load_spec['method'] . ', ver: ' . fa()->version() );
		}
	},
	10,
	3
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

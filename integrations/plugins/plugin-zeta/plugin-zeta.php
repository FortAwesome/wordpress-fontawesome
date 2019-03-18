<?php

/**
 * Plugin Name:       Plugin Zeta
 * Plugin URI:        https://fontawesome.com/
 * Description:       Registered Client requiring method: svg. Prepends a block before each blog post that displays a magic icon with a rotate-90 power transform.
 * Version:           0.0.1
 * Author:            Font Awesome
 * Author URI:        https://fontawesome.com/
 * License:           UNLICENSED
 */

defined( 'WPINC' ) || die;
define( 'ZETA_PLUGIN_VERSION', '0.0.1' );
define( 'ZETA_PLUGIN_LOG_PREFIX', 'zeta-plugin' );

add_action(
	'font_awesome_requirements',
	function() {
		if ( class_exists( 'FontAwesome' ) ) {
			fa()->register(
				array(
					'name'    => ZETA_PLUGIN_LOG_PREFIX,
					'clientVersion' => ZETA_PLUGIN_VERSION,
					'method' => 'svg',
				)
			);
		}
	}
);

add_action(
	'font_awesome_enqueued',
	function( $load_spec ) {
		if ( class_exists( 'FontAwesome' ) ) {
			// phpcs:ignore WordPress.PHP.DevelopmentFunctions
			error_log( ZETA_PLUGIN_LOG_PREFIX . ' font_awesome_enqueued: method: ' . $load_spec['method'] . ', ver: ' . fa()->version() );
		}
	},
	10,
	3
);

add_filter(
	'the_content',
	function( $content ) {
		$pre_content = <<<EOT
<div class="plugin-zeta-pre-content" style="border: 1px solid grey;">
  <h2>Plugin Zeta</h2>
  <p>Expected by plugin-zeta: magic icon with rotate-90 power transform:
    <span class="fa-4x">
      <i class="fas fa-magic" data-fa-transform="rotate-90" style="background:MistyRose"></i>
    </span>
  </p>
</div>
EOT;
		return $pre_content . $content;
	},
	10,
	1
);

<?php

/**
 * Plugin Name:       Plugin Beta
 * Plugin URI:        https://fontawesome.com/
 * Description:       Registered Client requiring version: 5.1.0, v4shim: require. Prepends a block before each blog post that displays (1) "fab fa-font-awesome", (2) "fa fa-arrows", which is a v4 icon declaration that the v4 shim should translate to "fas fa-arrows-alt", and (3) "fas fa-angry", which was a new icon in v5.1.0.
 * Version:           0.0.1
 * Author:            Font Awesome
 * Author URI:        https://fontawesome.com/
 * License:           UNLICENSED
 */

defined( 'WPINC' ) || die;
define( 'BETA_PLUGIN_VERSION', '0.0.1' );
define( 'BETA_PLUGIN_LOG_PREFIX', 'beta-plugin' );

add_action(
	'font_awesome_requirements',
	function( $register ) {
		if ( class_exists( 'FontAwesome' ) ) {
			$register(
				array(
					'name'          => BETA_PLUGIN_LOG_PREFIX,
					'clientVersion' => BETA_PLUGIN_VERSION,
					'version'       => '5.1.0',
					'v4shim'        => 'require',
				)
			);
		}
	},
	10,
	1
);

add_action(
	'font_awesome_enqueued',
	function( $load_spec ) {
		if ( class_exists( 'FontAwesome' ) ) {
			// phpcs:ignore WordPress.PHP.DevelopmentFunctions
			error_log( BETA_PLUGIN_LOG_PREFIX . ' font_awesome_enqueued: method: ' . $load_spec['method'] . ', ver: ' . $load_spec['version'] );
		}
	},
	10,
	3
);

add_filter(
	'the_content',
	function( $content ) {
		$pre_content = <<<EOT
<div class="plugin-beta-pre-content" style="border: 1px solid grey;">
  <h2>Plugin Beta</h2>
  <p>Expected by plugin-beta: "fab fa-font-awesome": <i class="fab fa-font-awesome"></i></p>
  <p>Shim icon (using the v4 class name): "fa fa-arrows": <i class="fa fa-arrows"></i></p>
  <p>Icon introduced in 5.1.0: "fas fa-angry": <i class="fas fa-angry"></i></p>
</div>
EOT;
		return $pre_content . $content;
	},
	10,
	1
);

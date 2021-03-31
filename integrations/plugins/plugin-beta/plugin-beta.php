<?php

/**
 * Plugin Name:       Plugin Beta
 * Plugin URI:        https://fontawesome.com/
 * Description:       Registered Client with preferences version: webfont, 5.1.0, v4shim: on. Adds content to the page footer that displays (1) "fab fa-font-awesome", (2) "fa fa-arrows", which is a v4 icon declaration that the v4 shim should translate to "fas fa-arrows-alt", and (3) "fas fa-angry", which was a new icon in v5.1.0.
 * Version:           0.0.1
 * Author:            Font Awesome
 * Author URI:        https://fontawesome.com/
 * License:           UNLICENSED
 */

defined( 'WPINC' ) || die;
define( 'BETA_PLUGIN_VERSION', '0.0.1' );
define( 'BETA_PLUGIN_LOG_PREFIX', 'beta-plugin' );

use function FortAwesome\fa;

add_action(
	'font_awesome_preferences',
	function() {
		fa()->register(
			array(
				'name'     => BETA_PLUGIN_LOG_PREFIX,
				'v4Compat' => true,
				'technology' => 'webfont',
				'version' => [ [ '5.1.0', '>=' ] ]
			)
		);
	}
);

add_action('wp_print_footer_scripts', function() use($pre_content) {
?>
<div class="plugin-beta-content" style="border: 1px solid grey;">
  <h2>Plugin Beta</h2>
  <p>Expected by plugin-beta: "fab fa-font-awesome": <i class="fab fa-font-awesome"></i></p>
  <p>Shim icon (using the v4 class name): "fa fa-arrows": <i class="fa fa-arrows"></i></p>
  <p>Icon introduced in 5.1.0: "fas fa-angry": <i class="fas fa-angry"></i></p>
</div>
<?php
});

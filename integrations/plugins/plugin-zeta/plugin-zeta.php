<?php

/**
 * Plugin Name:       Plugin Zeta
 * Plugin URI:        https://fontawesome.com/
 * Description:       Registered Client preferring technology: svg (but not pseudo-elements). Adds content to the template footer that displays a magic icon with a rotate-90 power transform.
 * Version:           0.0.1
 * Author:            Font Awesome
 * Author URI:        https://fontawesome.com/
 * License:           UNLICENSED
 */

defined( 'WPINC' ) || die;
define( 'ZETA_PLUGIN_VERSION', '0.0.1' );
define( 'ZETA_PLUGIN_LOG_PREFIX', 'zeta-plugin' );

use function FortAwesome\fa;

add_action(
	'font_awesome_preferences',
	function() {
		fa()->register(
			array(
				'name'    => ZETA_PLUGIN_LOG_PREFIX,
				'technology' => 'svg',
			)
		);
	}
);

add_action('wp_print_footer_scripts', function() use($pre_content) {
?>
<div class="plugin-zeta-pre-content" style="border: 1px solid grey;">
  <h2>Plugin Zeta</h2>
  <p>Expected by plugin-zeta: magic icon with rotate-90 power transform:
    <span class="fa-4x">
      <i class="fas fa-magic" data-fa-transform="rotate-90" style="background:MistyRose"></i>
    </span>
  </p>
</div>
<?php
});

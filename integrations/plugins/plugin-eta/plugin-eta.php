<?php

/**
 * Plugin Name:       Plugin Eta
 * Plugin URI:        https://fontawesome.com/
 * Description:       Registered Client with preferences: technology: svg, pseudoElements: true. Adds content to the page footer that displays the "fa-bed" icon as a :before pseudo-element.
 * Version:           0.0.1
 * Author:            Font Awesome
 * Author URI:        https://fontawesome.com/
 * License:           GPLv3
 */

use function FortAwesome\fa;

defined( 'WPINC' ) || die;
define( 'ETA_PLUGIN_VERSION', '0.0.1' );
define( 'ETA_PLUGIN_LOG_PREFIX', 'eta-plugin' );

add_action(
	'font_awesome_preferences',
	function() {
		fa()->register(
			array(
				'name'           => ETA_PLUGIN_LOG_PREFIX,
				'pseudoElements' => true,
				'technology' => 'svg'
			)
		);
	}
);

add_action(
	'init',
	function() {
		// phpcs:ignore WordPress.WP.EnqueuedResourceParameters
		wp_enqueue_style(
			'plugin-eta-style',
			trailingslashit( plugins_url() ) . trailingslashit( plugin_basename( __DIR__ ) ) . 'style.css',
			array(),
			null,
			'all'
		);
	}
);

add_action('wp_print_footer_scripts', function() {
?>
<div class="<?php echo esc_html__(plugin_eta_fa_classes(), 'font-awesome'); ?>" style="border: 1px solid grey;">
  <h2>Plugin Eta</h2>
  <p>Expected by plugin-eta: "fas fa-bed" icon as :before pseudo-element. <span class="bed"><- bed?</span></p>
</div>
<?php
});

function plugin_eta_fa_classes(){
	$fa = fa();
	$class_list = [ 'plugin-eta' ];

	$fa->pro()
		? array_push($class_list, 'fa-license-pro')
		: array_push($class_list, 'fa-license-free');

	strpos(fa()->version(), '5.0.') === 0
		? array_push($class_list, 'fa-version-5-0')
		: array_push($class_list, 'fa-version-5-1');

	($fa->technology() == 'svg')
		? array_push($class_list, 'fa-method-svg')
		: array_push($class_list, 'fa-method-webfont');

	return implode(' ', $class_list);
}

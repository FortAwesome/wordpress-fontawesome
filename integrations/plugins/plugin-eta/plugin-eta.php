<?php

/**
 * Plugin Name:       Plugin Eta
 * Plugin URI:        https://fontawesome.com/
 * Description:       Registered Client requiring pseudoElements. Prepends a block to each blog post that displays the "fa-bed" icon as a :before pseudo-element.
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
	'font_awesome_requirements',
	function() {
		FortAwesome\fa()->register(
			array(
				'name'           => ETA_PLUGIN_LOG_PREFIX,
				'pseudoElements' => 'require',
				'clientVersion'  => ETA_PLUGIN_VERSION,
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

add_filter('the_content', function($content){
	$classes = plugin_eta_fa_classes();
  $pre_content = <<<EOT
<div class="$classes" style="border: 1px solid grey;">
  <h2>Plugin Eta</h2>
  <p>Expected by plugin-eta: "fas fa-bed" icon as :before pseudo-element. <span class="bed"><- bed?</span></p>
</uiv>
EOT;
  return $pre_content . $content;
}, 10, 1);

function plugin_eta_fa_classes(){
	$fa = fa();
	$load_spec = $fa->load_spec();
	$class_list = [ 'plugin-eta' ];

	$fa->using_pro()
		? array_push($class_list, 'fa-license-pro')
		: array_push($class_list, 'fa-license-free');

	strpos(fa()->version(), '5.0.') === 0
		? array_push($class_list, 'fa-version-5-0')
		: array_push($class_list, 'fa-version-5-1');

	($load_spec['method'] == 'svg')
		? array_push($class_list, 'fa-method-svg')
		: array_push($class_list, 'fa-method-webfont');

	return implode(' ', $class_list);
}

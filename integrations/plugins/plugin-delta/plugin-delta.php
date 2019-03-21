<?php

/**
 * Plugin Name:       Plugin Delta
 * Plugin URI:        https://fontawesome.com/
 * Description:       Unregistered Client: tries to enqueue its own v5.0.11 SVG/JS from use.fontawesome.com. For display, prepends a block before every blog post that displays an icon with classes "fas fa-cloud-download". This icon appeared in v5.0.11 and is only available in Pro.
 * Version:           0.0.1
 * Author:            Font Awesome
 * Author URI:        https://fontawesome.com/
 * License:           GPLv3
 */

defined( 'WPINC' ) || die;
define( 'DELTA_PLUGIN_VERSION', '0.0.1' );
define( 'DELTA_PLUGIN_LOG_PREFIX', 'delta-plugin' );

add_action('init', function(){
  wp_enqueue_script(
    'DELTA_PLUGIN_LOG_PREFIX',
    'https://use.fontawesome.com/releases/v5.0.11/js/all.js',
    array(),
    null,
    false
  );
});

add_action('font_awesome_enqueued', function(){
	error_log(
		DELTA_PLUGIN_LOG_PREFIX .
		" font_awesome_enqueued: " .
		"method: " .
		\FortAwesome\fa()->load_spec()['method'] .
		", ver: " .
		FortAwesome\fa()->version()
	);
}, 10, 3);

add_filter('the_content', function($content){
  $pre_content = <<<EOT
<div class="plugin-delta-pre-content" style="border: 1px solid grey;">
  <h2>Plugin Delta</h2>
  <p>Expected by plugin-delta (introduced v5.0.11): "fas fa-cloud-download": <i class="fas fa-cloud-download"></i></p>
</div>
EOT;
  return $pre_content . $content;
}, 10, 1);

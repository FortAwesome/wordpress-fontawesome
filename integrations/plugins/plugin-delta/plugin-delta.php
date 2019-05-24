<?php

/**
 * Plugin Name:       Plugin Delta
 * Plugin URI:        https://fontawesome.com/
 * Description:       Unregistered Client: tries to enqueue its own v5.0.11 SVG/JS from use.fontawesome.com. For display, prepends a block before every blog post that displays an icon with classes "fas fa-cloud-download". This icon appeared in v5.0.11 and is only available in Pro. It adds the same output on the login page, and in the footer of admin pages.
 * Version:           0.0.1
 * Author:            Font Awesome
 * Author URI:        https://fontawesome.com/
 * License:           GPLv3
 */

defined( 'WPINC' ) || die;
define( 'DELTA_PLUGIN_VERSION', '0.0.1' );
define( 'DELTA_PLUGIN_LOG_PREFIX', 'delta-plugin' );

foreach( ['wp_enqueue_scripts', 'admin_enqueue_scripts', 'login_enqueue_scripts'] as $action ) {
	wp_enqueue_script(
		'DELTA_PLUGIN_LOG_PREFIX',
		'https://use.fontawesome.com/releases/v5.0.11/js/all.js',
		array(),
		null,
		false
	);
}

  $pre_content = <<<EOT
<div class="plugin-delta-pre-content" style="border: 1px solid grey;">
  <h2>Plugin Delta</h2>
  <p>Expected by plugin-delta (introduced v5.0.11): "fas fa-cloud-download": <i class="fas fa-cloud-download"></i></p>
</div>
EOT;

add_filter('the_content', function($content) use($pre_content) {
  return $pre_content . $content;
}, 10, 1);

add_filter('login_message', function($content) use($pre_content) {
	return $pre_content . $content;
});

add_action('admin_footer', function() use($pre_content) {
	?>
	<style>.plugin-delta-pre-content{position:absolute; margin-left: 20rem;}</style>
	<?php
	echo $pre_content;
});

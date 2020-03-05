<?php

/**
 * Plugin Name:       Plugin Gamma
 * Plugin URI:        https://fontawesome.com/
 * Description:       Unregistered Client: tries to enqueue its own v4.7.0 webfont version from cdn.jsdelivr.net. On the front end, it prepends a block before each blog post that displays an icon with "fa fa-bathtub", which is a version 4 specification that the v4shim should translate to "fas fa-bath". It adds the same output on the login page, and in the footer of admin pages. It also emits rogue output that might break our REST API responses, like a buggy plugin might do.
 * Version:           0.0.1
 * Author:            Font Awesome
 * Author URI:        https://fontawesome.com/
 * License:           GPLv3
 */

defined( 'WPINC' ) || die;
define( 'GAMMA_PLUGIN_VERSION', '0.0.1' );
define( 'GAMMA_PLUGIN_LOG_PREFIX', 'gamma-plugin' );

print "This rogue output from " . GAMMA_PLUGIN_LOG_PREFIX . " should not break our handling of REST API responses from our controllers.";

foreach( ['wp_enqueue_scripts', 'admin_enqueue_scripts', 'login_enqueue_scripts'] as $action ) {
	add_action( $action, function () {
		wp_enqueue_style(
			'GAMMA_PLUGIN_LOG_PREFIX',
			'https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.css',
			array(),
			null,
			'all'
		);

		wp_enqueue_style( 'plugin-gamma-style', plugins_url( 'style.css', __FILE__ ) );
	}, 99 );
}

  $pre_content = <<<EOT
<div class="plugin-gamma-pre-content" style="border: 1px solid grey;">
  <h2>Plugin Gamma</h2>
  <p>v4.7.0 icon name: "fa fa-bathtub": <i class="fa fa-bathtub"></i></p>
  <p class="group-icon"><code>:before</code> pseudo-element should match <code>fas fa-users</code>: <i class="fas fa-users"></i></p>
  <p class="facebook-icon"><code>:before</code> pseudo-element should match <code>fab fa-facebook</code>: <i class="fab fa-facebook"></i></p>
  <p class="hand-scissors-icon"><code>:before</code> pseudo-element should match <code>far fa-hand-scissors</code>: <i class="far fa-hand-scissors"></i></p>
</div>
EOT;

add_filter('the_content', function($content) use($pre_content){
  return $pre_content . $content;
});

add_filter('login_message', function($content) use($pre_content) {
	return $pre_content . $content;
});

add_action('admin_footer', function() use($pre_content) {
	?>
	<style>.plugin-gamma-pre-content{position:absolute; margin-left: 20rem;}</style>
	<?php
	echo $pre_content;
}, 10, 1);

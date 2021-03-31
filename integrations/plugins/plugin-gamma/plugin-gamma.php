<?php

/**
 * Plugin Name:       Plugin Gamma
 * Plugin URI:        https://fontawesome.com/
 * Description:       Unregistered Client: tries to enqueue its own v4.7.0 webfont version from cdn.jsdelivr.net. On the front end, it adds content to the footer of the template that displays an icon with "fa fa-bathtub", which is a version 4 specification that the v4shim should translate to "fas fa-bath". It adds the same output on the login page, and in the footer of admin pages.
 * Version:           0.0.1
 * Author:            Font Awesome
 * Author URI:        https://fontawesome.com/
 * License:           GPLv3
 */

defined( 'WPINC' ) || die;
define( 'GAMMA_PLUGIN_VERSION', '0.0.1' );
define( 'GAMMA_PLUGIN_LOG_PREFIX', 'gamma-plugin' );

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

  $extra_content = <<<EOT
<div class="plugin-gamma-content" style="border: 1px solid grey;">
  <h2>Plugin Gamma</h2>
  <p>v4.7.0 icon name: "fa fa-bathtub": <i class="fa fa-bathtub"></i></p>
  <p class="group-icon"><code>:before</code> pseudo-element should match <code>fas fa-users</code>: <i class="fas fa-users"></i></p>
  <p class="facebook-icon"><code>:before</code> pseudo-element should match <code>fab fa-facebook</code>: <i class="fab fa-facebook"></i></p>
  <p class="hand-scissors-icon"><code>:before</code> pseudo-element should match <code>far fa-hand-scissors</code>: <i class="far fa-hand-scissors"></i></p>
</div>
EOT;

add_action('wp_print_footer_scripts', function() use($extra_content) {
	echo $extra_content;
});

add_action('admin_footer', function() use($extra_content) {
	?>
	<style>.plugin-gamma-content{position:absolute; margin-left: 20rem;}</style>
	<?php
	echo $extra_content;
}, 10, 1);

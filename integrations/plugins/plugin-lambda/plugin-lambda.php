<?php

/**
 * Plugin Name:       Plugin Lambda
 * Plugin URI:        https://fontawesome.com/
 * Description:       Unregistered Client: tries to enqueue its own v4.7.0 webfont version as an inline style. Otherwise, it works like plugin-gamma.
 * Version:           0.0.1
 * Author:            Font Awesome
 * Author URI:        https://fontawesome.com/
 * License:           GPLv3
 */

defined( 'WPINC' ) || die;
define( 'LAMBDA_PLUGIN_VERSION', '0.0.1' );
define( 'LAMBDA_PLUGIN_LOG_PREFIX', 'lambda-plugin' );

foreach( ['wp_enqueue_scripts', 'admin_enqueue_scripts', 'login_enqueue_scripts'] as $action ) {
	add_action( $action, function () {
		$style = file_get_contents(trailingslashit( plugin_dir_path( __FILE__ ) ) . 'font-awesome-4.7.0/css/font-awesome.css');

		wp_enqueue_style( 'plugin-lambda-style', plugins_url( 'style.css', __FILE__ ) );
		wp_add_inline_style( 'plugin-lambda-style', $style );
	}, 99 );
}

  $extra_content = <<<EOT
<div class="plugin-lambda-content" style="border: 1px solid grey;">
  <h2>Plugin Lambda</h2>
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
	<style>.plugin-lambda-content{position:absolute; margin-left: 20rem;}</style>
	<?php
	echo $extra_content;
}, 10, 1);

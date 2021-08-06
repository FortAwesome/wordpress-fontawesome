<?php

/**
 * Plugin Name:       Plugin Nu
 * Plugin URI:        https://fontawesome.com/
 * Description:       On a Gutenberg (Block Editor) page, adds a tinymce (Classic) editor instance, to exercise Icon Chooser integration where both kinds of editors are present.
 * Version:           0.0.1
 * Author:            Font Awesome
 * Author URI:        https://fontawesome.com/
 * License:           UNLICENSED
 */

defined( 'WPINC' ) || die;

function nu_is_gutenberg_page() {
  if ( function_exists( 'is_gutenberg_page' ) && is_gutenberg_page() ) {
    // The Gutenberg plugin is on.
    return true;
  }
  $current_screen = get_current_screen();
  if ( method_exists( $current_screen, 'is_block_editor' ) && $current_screen->is_block_editor() ) {
    // Gutenberg page on 5+.
    return true;
  }

  return false;
}

add_action('admin_print_footer_scripts', function() {
  if( nu_is_gutenberg_page() ) {
	?>
	<div class="plugin-nu-content" style="border: 1px solid grey; margin-left: 200px; width: 50%;">
	<h2>Plugin Nu</h2>
	<?php wp_editor('(The block editor shoudl be working above, and the Icon Chooser should be useable in it.)', 'plugin-nu-editor');?>
	</div>
	<?php
  }
});

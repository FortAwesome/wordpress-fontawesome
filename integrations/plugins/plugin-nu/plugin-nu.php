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

add_action('admin_print_footer_scripts', function() {
?>
<div class="plugin-nu-content" style="border: 1px solid grey; margin-left: 200px; width: 50%;">
<h2>Plugin Nu</h2>
<?php wp_editor("(If there's a block editor above, it should be working, and the Icon Chooser should be useable in it, and this editor should not have an Add Font Awesome media button. If this is not a Gutenberg page, then this editor should have an Add Font Awesome media button that works.)", 'plugin-nu-editor');?>
</div>
<?php
});

<?php

/**
 * Plugin Name:       Plugin Nu
 * Plugin URI:        https://fontawesome.com/
 * Description:       Adds a tinymce (Classic) editor instance to the page. On a Gutenber page, this can exercise Icon Chooser integration where both kinds of editors are present (not yet supported). On a Classic Editor page, this excercises integration with the Icon Chooser, with the expectation that each Icon Chooser instance should be bound to its own editor: clicking to add an icon for an editor should result in the icon being added only to that editor.
 * Version:           0.0.2
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

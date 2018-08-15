<?php

/**
 * Plugin Name:       Font Awesome
 * Plugin URI:        https://fontawesome.com/wp-font-awesome/
 * Description:       Manage version resolution and loading for Font Awesome Free and Pro
 * Version:           0.0.1
 * Author:            Font Awesome
 * Author URI:        https://fontawesome.com/
 * License:           GPLv2 (or later)
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 */

defined( 'WPINC' ) || die;

define( 'FONTAWESOME_DIR_PATH', plugin_dir_path( __FILE__ ) );
define( 'FONTAWESOME_DIR_URL', plugin_dir_url( __FILE__ ) );
register_activation_hook( __FILE__, function(){
  require_once FONTAWESOME_DIR_PATH . 'includes/class-font-awesome-activator.php';
  FontAwesome_Activator::activate();
});

register_deactivation_hook( __FILE__, function(){
  require_once FONTAWESOME_DIR_PATH . 'includes/class-font-awesome-deactivator.php';
  FontAwesome_Deactivator::deactivate();
});

require_once FONTAWESOME_DIR_PATH . 'includes/class-font-awesome.php';

FontAwesome()->run();

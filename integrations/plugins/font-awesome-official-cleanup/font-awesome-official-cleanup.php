<?php
namespace FortAwesome;

/**
 * Plugin Name:       Font Awesome Official Cleanup
 * Plugin URI:        https://fontawesome.com/
 * Description:       Cleans out Font Awesome plugin settings from the WordPress database, including any child sites in multisite.
 * Version:           0.0.1
 * Author:            Font Awesome
 * Author URI:        https://fontawesome.com/
 * License:           GPLv2 (or later)
 */

defined( 'WPINC' ) || die;

const PLUGIN_NAME = 'font-awesome-official-cleanup';
const PLUGIN_DIR_URL = plugin_dir_url( __FILE__ );
const PLUGIN_VERSION = '0.0.1';

function create_admin_page() {
}

function settings_page_url() {
  return admin_url( "options-general.php?page=" . PLUGIN_NAME );
}

function admin_page_init() {

}

function initialize_admin() {
  add_action('admin_enqueue_scripts', function(){
    wp_enqueue_style( PLUGIN_NAME, PLUGIN_DIR_URL . 'css/style.css', array(), PLUGIN_VERSION, 'all' );
  });

  add_action('admin_menu', function(){
    add_options_page(
      'Font Awesome Official Cleanup',
      'Font Awesome Official Cleanup',
      'manage_options',
      PLUGIN_NAME,
      'create_admin_page'
    );
  });

  add_action('admin_init', 'admin_page_init');

  add_filter( 'plugin_action_links_' . trailingslashit(PLUGIN_NAME) . PLUGIN_NAME . '.php',
    function($links){
    $mylinks = array(
    '<a href="' . settings_page_url() . '">Settings</a>',
    );
    return array_merge( $links, $mylinks );
  });
}

if( is_admin() ){
    $this->initialize_admin();
}

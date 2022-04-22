<?php
namespace FontAwesomeOfficialCleanup;

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

function plugin_version() { return '0.0.1'; }

function plugin_name() { return 'font-awesome-official-cleanup'; }

function plugin_dir_url() { return \plugin_dir_url( __FILE__ ); }

function plugin_dir_path() { return \plugin_dir_path( __FILE__ ); }

function create_admin_page() {
	include_once( plugin_dir_path() . 'admin-view.php' );
}

function settings_page_url() {
  return admin_url( "options-general.php?page=" . plugin_name() );
}

function admin_page_init() {
	register_setting( plugin_name(), plugin_name(), [
		'type' => 'boolean',
		'default' => true
	]);
}

function initialize_admin() {
	add_action('admin_post_font_awesome_official_cleanup', 'FontAwesomeOfficialCleanup\cleanup');

	add_action('admin_enqueue_scripts', function(){
		wp_enqueue_style( plugin_name(), plugin_dir_url() . 'css/style.css', array(), plugin_version(), 'all' );
	});

	add_action('admin_menu', function(){
		add_options_page(
		'Font Awesome Official Cleanup',
		'Font Awesome Official Cleanup',
		'manage_options',
		plugin_name(),
		'FontAwesomeOfficialCleanup\create_admin_page'
		);
	});

	add_action('admin_init', 'FontAwesomeOfficialCleanup\admin_page_init');

	add_filter( 'plugin_action_links_' . trailingslashit(plugin_name()) . plugin_name() . '.php',
		function($links){
		$mylinks = array(
		'<a href="' . settings_page_url() . '">Settings</a>',
		);
		return array_merge( $links, $mylinks );
	});
}

function cleanup() {
	?>
	<p>CLEANED UP!</p>
	<?php
}

if( is_admin() ){
    initialize_admin();
}

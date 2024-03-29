<?php
namespace FontAwesomeCleanup;

/**
 * Plugin Name:       Font Awesome Cleanup
 * Plugin URI:        https://fontawesome.com/
 * Description:       Cleans out Font Awesome plugin settings from the WordPress database, including any child sites in multisite.
 * Version:           0.0.3
 * Author:            Font Awesome
 * Author URI:        https://fontawesome.com/
 * License:           GPLv2 (or later)
 */

defined( 'WPINC' ) || die;

require_once trailingslashit( __DIR__ ) . 'utils.php';

function plugin_version() { return '0.0.3'; }

function plugin_name() { return 'font-awesome-cleanup'; }

function plugin_dir_url() { return \plugin_dir_url( __FILE__ ); }

function plugin_dir_path() { return \plugin_dir_path( __FILE__ ); }

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
	add_action('admin_post_font_awesome_cleanup', 'FontAwesomeCleanup\cleanup');

	add_action('admin_menu', function(){
		add_options_page(
		'Font Awesome Official Cleanup',
		'Font Awesome Official Cleanup',
		'manage_options',
		plugin_name(),
		'FontAwesomeCleanup\create_admin_page'
		);
	});

	add_action('admin_init', 'FontAwesomeCleanup\admin_page_init');

	add_filter( 'plugin_action_links_' . trailingslashit(plugin_name()) . plugin_name() . '.php',
		function($links){
		$mylinks = array(
		'<a href="' . settings_page_url() . '">Settings</a>',
		);
		return array_merge( $links, $mylinks );
	});
}

function cleanup() {
	$nonce = sanitize_text_field($_POST['font_awesome_cleanup_nonce']);

	if( 1 !== wp_verify_nonce( $nonce, 'font_awesome_cleanup_nonce') || ! current_user_can( 'manage_options' ) ) {
		header('Location:'.$_SERVER["HTTP_REFERER"].'&status=nope');
        exit();
	}

	if ( is_plugin_active_for_network( plugin_file() ) ) {
		for_each_blog(
			function( ) {
				cleanup_site();
			}
		);
	} else {
		cleanup_site();
	}

	header('Location:'.$_SERVER["HTTP_REFERER"].'&status=done');
	exit();
}

/**
 * Iterates through each blog in the current network, switches to it,
 * and invokes the given callback function, restoring the current blog
 * after each callback invocation.
 *
 * Internal use only, not part of this plugin's public API.
 *
 * @internal
 * @ignore
 */
function for_each_blog( $cb ) {
	$network_id = get_current_network_id();
	$site_count = get_sites(
		array(
			'network_id' => $network_id,
			'count'      => true,
		)
	);
	$limit      = 100;
	$offset     = 0;

	while ( $offset < $site_count ) {
		$sites = get_sites(
			array(
				'network_id' => $network_id,
				'offset'     => $offset,
				'number'     => $limit,
			)
		);

		foreach ( $sites as $site ) {
			$blog_id = $site->blog_id;
			switch_to_blog( $blog_id );

			try {
				$cb( $site );
			} finally {
				restore_current_blog();
			}
		}

		$offset = $offset + $limit;
	}
}

function get_options() {
	return [
		'font-awesome',
		'font-awesome-releases',
		'font-awesome-conflict-detection',
		'font-awesome-api-settings'
	];
}

function get_transients() {
	return [
		'font-awesome-releases',
		'font-awesome-v3-deprecation-data',
		'font-awesome-last-used-release'
	];
}

function cleanup_site() {
	foreach(get_options() as $option) {
		delete_option( $option );
		delete_site_option( $option );
	}

	foreach(get_transients() as $transient) {
		delete_transient($transient);
		delete_site_transient($transient);
	}
}

function font_awesome_plugin_is_active() {
	$active_plugins = array_merge(
		fa_get_active_and_valid_plugins(),
		fa_get_active_network_plugins()
	);

	return count(array_filter($active_plugins, function($plugin_name) {
		return 1 === preg_match(
			"/font-awesome\/index\.php$/",
			$plugin_name
		);
	})) > 0;
}

function plugin_file() {
	return plugin_name() . '/index.php';
}

function filter_action_links( $links ) {
	$mylinks = array(
		'<a href="' . settings_page_url() . '">' . 'Go Clean Up' . '</a>',
	);

	return array_merge( $links, $mylinks );
}

add_filter(
	'network_admin_plugin_action_links_' . plugin_file(),
	'FontAwesomeCleanup\filter_action_links'	
);

add_filter(
	'plugin_action_links_' . plugin_file(),
	'FontAwesomeCleanup\filter_action_links'	
);

function display_cleanup_scope() {
	if ( is_multisite() ) {
		display_cleanup_scope_multisite();
	}
}

function display_cleanup_scope_multisite() {
	$is_cleanup_network_active = is_plugin_active_for_network( plugin_file() );

	$sites = [];

	if ( $is_cleanup_network_active ) {
		$network_id = get_current_network_id();

		for_each_blog(
			function( $site ) use (&$sites) {
				array_push( $sites, $site );
			}
		);
		?>
		<p>Cleaning ALL sites in network with network_id: <?= $network_id ?>.</p>
		<p>To clean up only one site, activate this cleanup plugin only on that one site instead of activating it network-wide.</p>
		<?php
	} else {
		array_push( $sites, get_site() );
		$site = get_site();
		?>
		<p>Cleaning ONLY the current site. </p>
		<p>To clean up all sites in the network, activate this cleanup plugin network-wide instead of activating it only on this site.</p>
		<?php
	}
	?>

	<table>
		<thead><th>site_id</th><th>domain</th><th>path</th></thead>
		<tbody>
			<?php foreach($sites as $site) { ?>
				<tr>
					<td><?= $site->blog_id ?></td>
					<td><?= $site->domain ?></td>
					<td><?= $site->path ?></td>
				</tr>
			<?php }	?>
		</tbody>
	</table>

	<?php
}

function create_admin_page() {
	$font_awesome_cleanup_nonce = wp_create_nonce( 'font_awesome_cleanup_nonce' ); 
	$status = isset( $_GET['status'] ) ? $_GET['status'] : null;
	?>
		<div class="<?= plugin_name() ?>-wrapper">
			<?php if ( current_user_can( 'manage_options' ) ) { ?>
				<?php if ( font_awesome_plugin_is_active() ) { ?>
					<p>The Font Awesome Official plugin is still active, so we can't do a clean up right now.</p>
					<p>Deactivate it and return here to do the clean up.</p>
				<?php } else { ?>
					<?php if ( 'done' === $status ) { ?>
						All done.
					<?php } else if ( 'nope' === $status ) { ?>
						Security check failed. Maybe logout and login again before retrying?
					<?php } else { ?>
						<p>Clean up all Font Awesome plugin data in the WordPress database.</p>

						<?php display_cleanup_scope() ?>

						<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
							<input type="hidden" name="action" value="font_awesome_cleanup">
							<input type="hidden" name="font_awesome_cleanup_nonce" value="<?= $font_awesome_cleanup_nonce ?>" />
							<?php submit_button('Clean Up!'); ?>
						</form>
					<?php } ?>
				<?php } ?>
			<?php } else { ?>
				Sorry, you are not allowed to use this tool.
			<?php } ?>
		</div>
	<?php
}

if( is_admin() ){
    initialize_admin();
}

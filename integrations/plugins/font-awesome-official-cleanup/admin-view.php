<?php namespace FontAwesomeCleanup;
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
				Clean up all Font Awesome Official plugin data in the WordPress database.

				<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
					<input type="hidden" name="action" value="font_awesome_official_cleanup">
					<input type="hidden" name="font_awesome_cleanup_nonce" value="<?= $font_awesome_cleanup_nonce ?>" />
					<?php submit_button('Clean Up!'); ?>
				</form>
			<?php } ?>
		<?php } ?>
	<?php } else { ?>
		Sorry, you are not allowed to use this tool.
	<?php } ?>
</div>

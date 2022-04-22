<?php namespace FontAwesomeOfficialCleanup;

$font_awesome_official_cleanup_meta_nonce = wp_create_nonce( 'font_awesome_official_cleanup_meta_nonce' ); 
?>

<div class="<?= plugin_name() ?>-wrapper">
hello, world
<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
	<input type="hidden" name="action" value="font_awesome_official_cleanup">
	<input type="hidden" name="font_awesome_official_cleanup_meta_nonce" value="<?= $font_awesome_official_cleanup_meta_nonce ?>" />
  <?php
  submit_button();
  ?>
</form>
</div>

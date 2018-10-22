<?php

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @package    FontAwesome
 * @subpackage FontAwesome/includes
 */
class FontAwesome_Activator {

  public static function activate() {
    $fa = FontAwesome();
    update_option($fa->options_key, $fa->default_user_options);
  }

}


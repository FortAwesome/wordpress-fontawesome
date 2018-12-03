<?php

/**
 * Plugin Name:       Plugin Theta
 * Plugin URI:        https://fontawesome.com/
 * Description:       Registered Client warns when the loaded plugin version does not satisfy its plugin version requirments, which are intended to be satisfied.
 * Version:           0.0.1
 * Author:            Font Awesome
 * Author URI:        https://fontawesome.com/
 * License:           UNLICENSED
 */

defined( 'WPINC' ) || die;
define( 'THETA_PLUGIN_VERSION', '0.0.1' );
define( 'THETA_PLUGIN_LOG_PREFIX', 'theta-plugin' );
define( 'THETA_PLUGIN_VERSION_CONSTRAINT_FOR_FA_PLUGIN', '9.0.42' );

add_action(
	'font_awesome_requirements',
	function() {
		fa()->satisfies_or_warn( THETA_PLUGIN_VERSION_CONSTRAINT_FOR_FA_PLUGIN, 'Theta' );
		if ( class_exists( 'FontAwesome' ) ) {
			fa()->register(
				array(
					'name'          => THETA_PLUGIN_LOG_PREFIX,
					'clientVersion' => THETA_PLUGIN_VERSION,
				)
			);
		}
	}
);

add_filter(
	'the_content',
	function( $content ) {
		$expected = 'NO';
		$actual = fa()->satisfies( THETA_PLUGIN_VERSION_CONSTRAINT_FOR_FA_PLUGIN ) ? 'YES' : 'NO';
		$constraint = THETA_PLUGIN_VERSION_CONSTRAINT_FOR_FA_PLUGIN;
		$version = FontAwesome::PLUGIN_VERSION;

		$pre_content = <<<EOT
<div class="plugin-theta-pre-content" style="border: 1px solid grey;">
  <h2>Plugin Theta</h2>
  <p>
    Is Theta's Font Awesome plugin version requirement satisfied? 
  </p>
  <p>
    Expected: $expected <br/>
    Actual  : $actual
  </p>
  <p>
    Also expecting there to be an admin notice in the admin dashboard.
  </p>
  <p>
    Theta expects the version of the active Font Awesome plugin to satisfy this version constraint:
    $constraint <br/>
    The Font Awesome plugin version currently active is: $version
  </p>
</div>
EOT;
		return $pre_content . $content;
	},
	10,
	1
);

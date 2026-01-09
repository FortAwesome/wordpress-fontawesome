<?php

namespace FontAwesomeElementorAddon;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * An admin Notice that appears on the WordPress admin dashboard with Elementor styling.
 */
class Notice extends \Elementor\Core\Admin\Notices\Base_Notice  {
	protected $title = null;
	protected $description = null;

	public function __construct($title, $description) {
		$this->title = $title;
		$this->description = $description;
	}

	public function should_print() {
		return true;
	}

	public function get_config() {
		return [
			'id' => 'fontawesome-elementor-addon-notice',
			'title' => $this->title,
			'description' => $this->description,
			// include WP's default notice class so it will be properly handled by WP's js handler.
			'classes' => [ 'notice', 'e-notice' ],
			'type' => '',
			'dismissible' => true,
			'icon' => 'eicon-font-awesome',
			'button' => [],
			'button_secondary' => [],
		];
	}
}

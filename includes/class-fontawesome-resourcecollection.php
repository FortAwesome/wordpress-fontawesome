<?php
namespace FortAwesome;

if ( ! class_exists( 'FontAwesome_ResourceCollection' ) ) :
	/**
	 * Class to wrap a set of resources to be enqueued, along with the version.
	 */
	class FontAwesome_ResourceCollection {
		protected $resources;
		protected $version;

		public function __construct( $version, $resources ) {
			$this->version   = $version;
			$this->resources = $resources;
		}

		public function resources() {
			return $this->resources;
		}

		public function version() {
			return $this->version;
		}
	}
endif; // !class_exists

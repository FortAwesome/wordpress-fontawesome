<?php

if ( ! class_exists( 'FontAwesome_Release_Provider' ) ) :
	/**
	 * Class to provide structure and wrapping around the source URI and integrity key
	 * to be used when enqueuing a script or style resource.
	 */
	class FontAwesome_Resource {
		protected $_source;
		protected $_integrity_key;

		public function __construct( $source, $integrity_key ) {
			$this->_source        = $source;
			$this->_integrity_key = $integrity_key;
		}

		public function source() {
			return $this->_source; }
		public function integrity_key() {
			return $this->_integrity_key; }
	}
endif; // !class_exists

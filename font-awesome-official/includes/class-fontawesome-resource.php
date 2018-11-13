<?php

if ( ! class_exists('FontAwesome_Release_Provider') ) :
	class FontAwesomeResource {
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

<?php
/**
 * Main plugin class module.
 *
 * @noinspection PhpIncludeInspection
 * @deprecated Provided temporarily for an upgrade path for previous font-awesome plugin users.
 * @ignore
 */

// phpcs:ignore Generic.Commenting.DocComment.MissingShort
/**
 * @ignore
 */

if ( ! class_exists( 'FontAwesome_V3Mapper' ) ) :
	/**
	 * FontAwesome_V3Mapper Class
	 *
	 * @deprecated Provided temporarily for an upgrade path for previous font-awesome plugin users.
	 * @ignore
	 */
	class FontAwesome_V3Mapper {

		// phpcs:ignore Generic.Commenting.DocComment.MissingShort
		/**
		 * @ignore
		 */
		private $map = null;

		// phpcs:ignore Generic.Commenting.DocComment.MissingShort
		/**
		 * @ignore
		 */
		private static $instance = null;

		/**
		 * Returns the singleton instance of this class.
		 *
		 * @since 4.0.0
		 *
		 * @deprecated Provided temporarily for an upgrade path for previous font-awesome plugin users.
		 * @return FontAwesome_V3Mapper
		 * @ignore
		 */
		public static function instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}
			return self::$instance;
		}

		// phpcs:ignore Generic.Commenting.DocComment.MissingShort
		/**
		 * @ignore
		 */
		private function __construct() {
			$this->load_map();
		}

		// phpcs:ignore Generic.Commenting.DocComment.MissingShort
		/**
		 * @deprecated Provided temporarily for an upgrade path for previous font-awesome plugin users.
		 * @ignore
		 */
		private function load_map() {
			// Don't load again if it's already loaded.
			if ( is_null( $this->map ) ) {
				$v3shims_file = trailingslashit( FONTAWESOME_DIR_PATH ) . 'v3shims.yml';

				$this->map = \Spyc::YAMLLoad( $v3shims_file );
			}
		}

		/**
		 * Map a Font Awesome version 3 icon name to the equivalent Font Awesome 5 prefix and name.
		 *
		 * @deprecated Provided temporarily for an upgrade path for previous font-awesome plugin users.
		 * @ignore
		 */
		public function map_v3_to_v5( $v3name ) {
			if ( isset( $this->map[ $v3name ] ) ) {
				return $this->map[ $v3name ];
			} else {
				return '';
			}
		}
	}

endif; // ! class_exists

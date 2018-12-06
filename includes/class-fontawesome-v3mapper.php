<?php
/**
 * Main plugin class module.
 *
 * @noinspection PhpIncludeInspection
 */

// phpcs:ignore Generic.Commenting.DocComment.MissingShort
/**
 * @ignore
 */

if ( ! class_exists( 'FontAwesome_V3Mapper' ) ) :
	/**
	 * FontAwesome_V3Mapper Class
	 *
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
		private static $_instance = null;

		/**
		 * Returns the singleton instance of this class.
		 *
		 * @since 0.2.0
		 *
		 * @return FontAwesome_V3Mapper
		 * @ignore
		 */
		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}

		// phpcs:ignore Generic.Commenting.DocComment.MissingShort
		/**
		 * @ignore
		 */
		private function __construct() {
			$this->load_map();
		}

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

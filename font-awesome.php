<?php
/**
 * Main loading logic.
 */
namespace FortAwesome;

use \Exception, \Error;

defined( 'WPINC' ) || die;

if(! defined( 'FONTAWESOME_PLUGIN_FILE' ) ) {
	/**
	 * Name of this plugin's entrypoint file.
	 * 
	 * Relative to the WordPress plugins directory, as would
	 * be used for `$plugin` in the
	 * [`activate_{$plugin}`](https://developer.wordpress.org/reference/hooks/activate_plugin/) action hook.
	 * 
	 * @since 4.0.0
	 */
	define( 'FONTAWESOME_PLUGIN_FILE', 'font-awesome/index.php' );
}

if(! defined( 'FONTAWESOME_TEXT_DOMAIN' ) ) {
	/**
	 * Name of this plugin's text domain.
	 * 
	 * @since 4.0.0
	 */
	define( 'FONTAWESOME_TEXT_DOMAIN', 'font-awesome-official' );
}

if ( ! class_exists( 'FortAwesome\FontAwesome_Loader' ) ) :
	/**
	 * Loader class, a Singleton. Coordinates potentially multiple installations of
	 * the Font Awesome plugin code, and ensures that the latest available semantic
	 * version is selected for execution at runtime. Exposes a few public API
	 * methods for initialization (activation), deactivation, and uninstallation
	 * of plugin code.
	 *
	 * Font Awesome plugin installations may be installed either directly
	 * as a plugin appearing in the plugins table, or as a composer dependency
	 * of any number of themes or other plugins.
	 * 
	 * We only have in mind various installations of this code base,
	 * of course. Not other non-official Font Awesome plugins. We don't try 
	 * to anticipate what _other_ potentially conflicting plugins might be installed.
	 *
	 * All Font Awesome plugin installations should attempt to load themselves via this loader,
	 * which will ensure that the code for plugin installation with the latest
	 * semantic version is what actually runs. It also ensures appropriate
	 * handling of initialization, deactivation and uninstallation, so that the
	 * actions of one plugin installation don't interfere with another's.
	 * 
	 * Refer to `integrations/plugins/plugin-sigma` 
	 * in this repo for an example of how to load the Font Awesome plugin code
	 * via this Loader when including it as a composer dependency.
	 * 
	 * The client code should `require_once` the `index.php` found
	 * in the root of this code base:
	 * 
	 * ```php
	 * require_once __DIR__ . '/vendor/fortawesome/wordpress-fontawesome/index.php';
	 * ```
	 *
	 * For example, suppose the following scenario: A later version of the plugin
	 * is installed from the WordPress plugins directory and appears in the
	 * plugins table. It is activated.
	 * Then suppose a page builder plugin is installed and activated. That page builder
	 * plugin includes this plugin code as a composer dependency. In that case,
	 * the plugin code with the later semantic version will be the one loaded
	 * and executed at runtime.
	 * The page builder plugin should work just as expected, even though it would
	 * be running against a newer version of the Font Awesome plugin code than it
	 * had shipped in its own vendor bundle.
	 * 
	 * Now suppose that the site owner deactivates and deletes the plugin that
	 * appears in the plugins table, the one that had been installed from the 
	 * WordPress plugins directory. Because this loader knows that the page builder
	 * plugin's installation is still present, that deactivation and uninstallation
	 * will not cause the Font Awesome plugin's options and transients to be removed from the
	 * database. And as soon as that plugin installation is removed,
	 * the Font Awesome plugin installation included in the page builder plugin's
	 * composer vendor bundle is automatically promoted and runs as expected with
	 * no change to the plugin's state in the database.
	 * 
	 * This loader pattern follows that of [wponion](https://github.com/wponion/wponion/blob/master/wponion.php).
	 * Thanks to Varun Sridharan.
	 *
	 * @since 4.0.0
	 */
	final class FontAwesome_Loader {
		const LOAD_FAIL_MSG = 'Unable To Load Font Awesome Plugin.';
		const PHP_VERSION_INCOMPATIBLE_MSG = 'The Font Awesome plugin require a PHP Version of at least 5.6.';
		const PHP_CURRENT_VERSION_MSG = 'Your current version of PHP is';
		const ACTIVATION_FAILED_MSG = 'Font Awesome could not be activated.';
		const INITIALIZATION_FAILED_MSG = 'Font Awesome could not be initialized.';
		const CONSOLE_ERROR_PREAMBLE = 'Font Awesome Plugin Error Details';
		const ADMIN_NOTICE_FATAL_ERROR_PREAMBLE = 'The Font Awesome plugin caught a fatal error';

		/**
		 * Stores Loader Instance.
		 *
		 * @ignore
		 * @internal
		 */
		private static $_instance = null;

		/**
		 * Stores metadata about the various modules attempted to be
		 * loaded as the FontAwesome plugin.
		 *
		 * @ignore
		 * @internal
		 */
		private static $_loaded = array();

		/**
		 * Stores data about each plugin installation that has
		 * invoked font_awesome_load().
		 *
		 * @ignore
		 * @internal
		 */
		private static $data = array();

		/**
		 * FontAwesome_Loader constructor.
		 *
		 * @ignore
		 * @internal
		 */
		private function __construct() {
			add_action( 'plugins_loaded', [ &$this, 'load_plugin' ], -1 );
			add_action( 'activate_' . FONTAWESOME_PLUGIN_FILE, [ &$this, 'activate_plugin' ], -1);
		}

		/**
		 * Choose the plugin installation with the latest semantic version to be
		 * the one that we'll load and use for other lifecycle operations like
		 * initialization, deactivation or uninstallation.
		 *
		 * @ignore
		 * @internal
		 */
		private function select_latest_version_plugin_installation() {
			if ( count(self::$_loaded) > 0 ) return;

			$versions = array_keys( self::$data );

			usort($versions, function($a, $b) {
				if(version_compare($a, $b, '=')){
				  return 0;
				} elseif(version_compare($a, $b, 'gt')) {
				  return -1;
				} else {
				  return 1;
				}
			});

			$latest_version = $versions[0];
			$info           = ( isset( self::$data[ $latest_version ] ) ) ? self::$data[ $latest_version ] : [];

			if ( empty( $info ) ) {
				$ms = __( self::LOAD_FAIL_MSG, FONTAWESOME_TEXT_DOMAIN );
				wp_die( $ms . '<p style="word-break: break-all;">' . base64_encode( wp_json_encode( self::$data ) ) . '</p>' );
			}

			if ( ! version_compare( PHP_VERSION, '5.6', '>=' ) ) {
				wp_die(
					__( self::PHP_CURRENT_VERSION_MSG, FONTAWESOME_TEXT_DOMAIN )
					. ' '
					. __( self::PHP_CURRENT_VERSION_MSG, FONTAWESOME_TEXT_DOMAIN )
					. ': '
					. PHP_VERSION
				);
			}

			self::$_loaded = array(
				'path'    => $info,
				'version' => $latest_version,
			);
		}

		/**
		 * Loads the plugin installation that has been selected for loading.
		 * 
		 * This is public because it's a callback, but should not be considered
		 * part of this plugin's API.
		 * 
		 * For an example of how to use this loader when importing this plugin
		 * as a composer dependency, see `integrations/plugins/plugin-sigma.php`
		 * in this repo.
		 * 
		 * @internal
		 * @ignore
		 */
		public function load_plugin() {
			try {
				$this->select_latest_version_plugin_installation();
				require self::$_loaded['path'] . 'font-awesome-init.php';
			} catch ( Exception $e ) {
				self::emit_error_output( __( self::INITIALIZATION_FAILED_MSG, FONTAWESOME_TEXT_DOMAIN ), $e );
			} catch ( Error $e ) {
				self::emit_error_output( __( self::INITIALIZATION_FAILED_MSG, FONTAWESOME_TEXT_DOMAIN ), $e );
			}
		}

		/**
		 * Returns the path to the plugin installation that is actively loaded.
		 * 
		 * @since 4.0.0
		 */
		public function loaded_path() {
			return self::$_loaded['path'];
		}

		/**
		 * Loads the activation hook for the plugin installation that has been
		 * selected for loading.
		 *
		 * This is public because it's a callback, but should not be considered
		 * part of this plugin's API.
		 * 
		 * @internal
		 * @ignore 
		 */
		public function activate_plugin() {
			$this->select_latest_version_plugin_installation();
			try {
				require_once self::$_loaded['path'] . 'includes/class-fontawesome-activator.php';
				FontAwesome_Activator::activate();
			} catch ( Exception $e ) {
				self::emit_error_output( __( self::ACTIVATION_FAILED_MSG, FONTAWESOME_TEXT_DOMAIN ), $e );
				exit;
			} catch ( Error $e ) {
				self::emit_error_output( __( self::ACTIVATION_FAILED_MSG, FONTAWESOME_TEXT_DOMAIN ), $e );
				exit;
			}
		}

		/**
		 * Internal use only, not part of this plugin's public API.
		 *
		 * @internal
		 * @ignore
		 */
		private static function emit_error_output( $ui_message, $e ) {
			if( is_admin() ) {
				add_action(
					'admin_notices',
					function () use ( $e ) {
						echo '<div class="error">';
						echo '<p>' . __( self::ADMIN_NOTICE_FATAL_ERROR_PREAMBLE, FONTAWESOME_TEXT_DOMAIN ) .
							": " . $e->getMessage() . '</p>';
						echo '</div>';
						self::emit_error_output_to_console( $e );
					}
				);
			}
		}

		/**
		 * Internal use only.
		 *
		 * @ignore
		 * @internal
		 * @param Error|Exception
		 */
		public static function emit_error_output_to_console( $e ) {
			if ( ! is_a( $e, 'Exception' ) && ! is_a( $e, 'Error' ) ) {
				return;
			}

			echo '<script>';
			echo "console.group('" . __( self::CONSOLE_ERROR_PREAMBLE, FONTAWESOME_TEXT_DOMAIN ) . "');";
			echo "console.info('message: " . self::escape_error_output( $e->getMessage() ) . "');";
			echo "console.info('stack trace:\\n" . self::escape_error_output( $e->getTraceAsString() ) . "');";
			echo 'console.groupEnd()';
			echo '</script>';
		}

		/**
		 * Internal use only, not part of this plugin's public API.
		 *
		 * @internal
		 * @ignore
		 */
		public static function escape_error_output( $trace ) {
			$result = preg_replace( '/\'/', "\\'", $trace );
			$result = preg_replace( '/\"/', '\\"', $result );
			$result = preg_replace( '/\n/', '\\n', $result );

			return $result;
		}

		/**
		 * Initializes the Font Awesome plugin's options.
		 * 
		 * If multiple installations of the plugin are installed, such as by
		 * composer dependencies in multiple plugins, this will ensure that the
		 * plugin is not re-initialized.
		 * 
		 * If the plugin's options are empty, this will initialize with defaults.
		 * Otherwise, it will leave them alone.
		 * 
		 * Any theme or plugin that uses this plugin as a composer dependency
		 * should call this method from its own activation hook. For example:
		 * 
		 * ```php
		 * register_activation_hook(
		 *     __FILE__,
		 *     'FortAwesome\FontAwesome_Loader::initialize'
		 * );
		 * ```
		 *
		 * @since 4.0.0
		 */
		public static function initialize() {
			self::instance()->initialize_plugin();
		}

		/**
		 * Runs initialize() for the plugin installation that has been selected for loading.
		 * 
		 * @ignore
		 * @internal
		 */
		private function initialize_plugin() {
			$this->select_latest_version_plugin_installation();
			try {
				require_once self::$_loaded['path'] . 'includes/class-fontawesome-activator.php';
				FontAwesome_Activator::initialize();
			} catch ( Exception $e ) {
				self::emit_error_output( __( self::INITIALIZATION_FAILED_MSG, FONTAWESOME_TEXT_DOMAIN ), $e );
				exit;
			} catch ( Error $e ) {
				self::emit_error_output( __( self::INITIALIZATION_FAILED_MSG, FONTAWESOME_TEXT_DOMAIN ), $e );
				exit;
			}
		}

		/**
		 * Runs uninstall logic for the plugin, but only if its invocation
		 * represents the last plugin installation trying to clean up.
		 *
		 * Deletes options records in the database.
		 *
		 * If there would be other remaining installations previously added to this
		 * loader via {@link \FortAwesome\font_awesome_load()}, it does not delete the plugin options,
		 * since one of those others will end up becoming active and relying on the options data.
		 * 
		 * Any theme or plugin that includes this Font Awesome plugin as a library
		 * dependency should call this from its own uninstall hook. For example:
		 * 
		 * ```php
		 *	register_uninstall_hook(
		 *		__FILE__,
		 *		'FortAwesome\FontAwesome_Loader::maybe_uninstall'
		 *	);
		 * ```
		 *
		 * @since 4.0.0
		 */
		public static function maybe_uninstall() {
			if( count( self::$data ) == 1 ) {
				// If there's only installation in the list, then it's
				// the one that has invoked this function and is is about to
				// go away, so it's safe to clean up.
				$version_key = array_keys( self::$data )[0];

				require_once trailingslashit( self::$data[$version_key] ) . 'includes/class-fontawesome-deactivator.php';
				FontAwesome_Deactivator::uninstall();
			}
		}

		/**
		 * Deactivates, cleaning up temporary data, such as transients, if this
		 * represents the last installed copy of the Font Awesome plugin being deactivated.
		 *
		 * However, if this loader is aware of any remaining installations, it does
		 * not clean up temporary data, since one of those other Font Awesome plugin
		 * installations, if active, will be promoted and end up relying on the data.
		 * 
		 * Any theme or plugin that includes this Font Awesome plugin as a library
		 * dependency should call this from its own uninstall hook. For example:
		 * 
		 * ```php
		 *  register_deactivation_hook(
		 *  	__FILE__,
		 *  	'FortAwesome\FontAwesome_Loader::maybe_deactivate'
		 *  );
		 * ```
		 * @since 4.0.0
		 */
		public static function maybe_deactivate() {
			if( count( self::$data ) == 1 ) {
				$version_key = array_keys( self::$data )[0];

				require_once trailingslashit( self::$data[$version_key] ) . 'includes/class-fontawesome-deactivator.php';
				FontAwesome_Deactivator::deactivate();
			}
		}

		/**
		 * Creates and/or returns the static instance for this Singleton.
		 *
		 * It is probably not necessary for a theme or plugin that depends upon
		 * the Font Awesome plugin to invoke this. It's probably more convenient
		 * to access the Loader's functionality through the its public static methods.
		 *
		 * @return \FortAwesome\FontAwesome_Loader
		 * @see FontAwesome_Loader::initialize()
		 * @see FontAwesome_Loader::maybe_deactivate()
		 * @see FontAwesome_Loader::maybe_uninstall()
		 * @since 4.0.0
		 */
		public static function instance() {
			if ( null === self::$_instance ) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}

		/**
		 * Stores plugin version and details for an installation that is being
		 * registered with this loader.
		 *
		 * This method is not part of this plugin's public API.
		 *
		 * @param string      $data other information.
		 * @param string|bool $version framework version.
		 *
		 * @ignore
		 * @internal
		 * @return $this
		 */
		public function add( $data = '', $version = false ) {
			if ( file_exists( trailingslashit( $data ) . 'index.php' ) ) {
				if ( false === $version ) {
					$args    = get_file_data( trailingslashit( $data ) . 'index.php', array( 'version' => 'Version' ) );
					$version = ( isset( $args['version'] ) && ! empty( $args['version'] ) ) ? $args['version'] : $version;
				}
				self::$data[ $version ] = trailingslashit( $data );
			}
			return $this;
		}
	}
endif; // ! class_exists

if ( ! function_exists( 'FortAwesome\font_awesome_load' ) ) {
	/**
	 * Adds plugin installation path to be managed by this loader.
	 * 
	 * @param string $plugin_installation_path
	 * @param bool   $version
	 * @ignore
	 * @internal
	 * @since 4.0.0
	 */
	function font_awesome_load( $plugin_installation_path = __DIR__, $version = false ) {
		FontAwesome_Loader::instance()
			->add( $plugin_installation_path, $version );
	}
}

if ( function_exists( 'FortAwesome\font_awesome_load' ) ) {
	font_awesome_load( __DIR__ );
}

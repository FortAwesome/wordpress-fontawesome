<?php
namespace FortAwesome;

use \Exception, \Error, \InvalidArgumentException;

/**
 * Main plugin class module.
 *
 * @noinspection PhpIncludeInspection
 */

// phpcs:ignore Generic.Commenting.DocComment.MissingShort
/**
 * @ignore
 */
require_once trailingslashit( __DIR__ ) . '../defines.php';
require_once trailingslashit( FONTAWESOME_DIR_PATH ) . 'includes/class-fontawesome-release-provider.php';
require_once trailingslashit( FONTAWESOME_DIR_PATH ) . 'includes/class-fontawesome-resource.php';
require_once trailingslashit( FONTAWESOME_DIR_PATH ) . 'includes/class-fontawesome-config-controller.php';
require_once trailingslashit( FONTAWESOME_DIR_PATH ) . 'includes/class-fontawesome-v3deprecation-controller.php';
require_once trailingslashit( FONTAWESOME_DIR_PATH ) . 'includes/class-fontawesome-v3mapper.php';
require_once trailingslashit( FONTAWESOME_DIR_PATH ) . 'includes/class-fontawesome-noreleasesexception.php';
require_once trailingslashit( FONTAWESOME_DIR_PATH ) . 'includes/class-fontawesome-configurationexception.php';
require_once ABSPATH . 'wp-admin/includes/screen.php';

if ( ! class_exists( 'FortAwesome\FontAwesome' ) ) :
	/**
	 * Main plugin class, a singleton.
	 *
	 * <h3>Action Hooks</h3>
	 *
	 * Fires the following WordPress action hooks:
	 *
	 * - `font_awesome_requirements`
	 *
	 *   Fired when the plugin is ready for clients to register their requirements.
	 *
	 *   Client plugins and themes should normally use this action hook to call {@see FontAwesome::register()}
	 *   with their requirements.
	 *
	 *   This hook is _not_ fired when a previously built ("locked") load specification is found.
	 *
	 *   No parameters.
	 *
	 * - `font_awesome_enqueued`
	 *
	 *   Called when a version of Font Awesome has been successfully prepared for enqueuing,
	 *   whether by building a new load specification, or by using a locked load specification from a previous load.
	 *
	 *   Clients should register a callback on this action to be notified when it is valid to query the FontAwesome
	 *   plugin's metadata using methods such as:
	 *     - {@see FontAwesome::version()} to discover the version of Font Awesome being loaded
	 *     - {@see FontAwesome::using_pro()} to discover whether a version with Pro icons is being loaded
	 *     - {@see FontAwesome::using_pseudo_elements()} to discover whether Font Awesome is being loaded with support for pseudo-elements
	 *
	 * - `font_awesome_failed`
	 *
	 *   Called when the plugin fails to compute a load specification because of client requirements that cannot be satisfied.
	 *
	 *   One parameter, an `array` with a shape like that returned by {@see FontAwesome::conflicts()}
	 *
	 * @since 4.0.0
	 */
	class FontAwesome {

		/**
		 * Name of this plugin's shortcode tag.
		 *
		 * @since 4.0.0
		 */
		const SHORTCODE_TAG = 'icon';
		/**
		 * Default style prefix.
		 *
		 * @since 4.0.0
		 */
		const DEFAULT_PREFIX = 'fas';
		/**
		 * Key where this plugin's saved data are stored in the WordPress options table.
		 *
		 * @since 4.0.0
		 */
		const OPTIONS_KEY = 'font-awesome';
		// phpcs:ignore Generic.Commenting.DocComment.MissingShort
		/**
		 * @ignore
		 */
		const ADMIN_USER_CLIENT_NAME_INTERNAL = 'user';
		// phpcs:ignore Generic.Commenting.DocComment.MissingShort
		/**
		 * @ignore
		 */
		const ADMIN_USER_CLIENT_NAME_EXTERNAL = 'You';
		/**
		 * The unique WordPress plugin slug for this plugin.
		 *
		 * @since 4.0.0
		 */
		const PLUGIN_NAME = 'font-awesome';
		/**
		 * The version of this WordPress plugin.
		 */
		const PLUGIN_VERSION = '4.0.0-rc13';
		/**
		 * The version of this plugin's REST API.
		 *
		 * @since 4.0.0
		 */
		const REST_API_VERSION = '1';
		/**
		 * The namespace for this plugin's REST API.
		 *
		 * @since 4.0.0
		 */
		const REST_API_NAMESPACE = self::PLUGIN_NAME . '/v' . self::REST_API_VERSION;
		/**
		 * The name of this plugin's options page, or WordPress admin dashboard page.
		 *
		 * @since 4.0.0
		 */
		const OPTIONS_PAGE = 'font-awesome';
		/**
		 * The handle used when enqueuing this plugin's resulting resource.
		 * Used when this plugin calls either `wp_enqueue_script` or `wp_enqueue_style` to enqueue Font Awesome assets.
		 *
		 * @since 4.0.0
		 */
		const RESOURCE_HANDLE = 'font-awesome-official';
		/**
		 * The handle used when enqueuing the v4shim, when it is included in the load specification.
		 *
		 * @since 4.0.0
		 */
		const RESOURCE_HANDLE_V4SHIM = 'font-awesome-official-v4shim';

		/**
		 * The base name of the handle used for enqueuing this plugin's admin assets, those required for running
		 * the admin settings page.
		 *
		 * @since 4.0.0
		 */
		const ADMIN_RESOURCE_HANDLE = self::RESOURCE_HANDLE . '-admin';

		// phpcs:ignore Generic.Commenting.DocComment.MissingShort
		/**
		 * @ignore
		 * @deprecated
		 */
		const V3DEPRECATION_TRANSIENT = 'font-awesome-v3-deprecation-data';

		// phpcs:ignore Generic.Commenting.DocComment.MissingShort
		/**
		 * @ignore
		 * @deprecated
		 */
		const V3DEPRECATION_EXPIRY = WEEK_IN_SECONDS;

		// phpcs:ignore Generic.Commenting.DocComment.MissingShort
		/**
		 * @ignore
		 */
		const DEFAULT_USER_OPTIONS = array(
			'adminClientLoadSpec'       => array(
				'name'          => self::ADMIN_USER_CLIENT_NAME_INTERNAL,
				'clientVersion' => 0,
			),
			'usePro'                    => false,
			'removeUnregisteredClients' => false,
			'version'                   => 'latest',
		);

		// phpcs:ignore Generic.Commenting.DocComment.MissingShort
		/**
		 * @ignore
		 */
		protected static $instance = null;

		// phpcs:ignore Generic.Commenting.DocComment.MissingShort
		/**
		 * @ignore
		 */
		protected $client_requirements = array();

		// phpcs:ignore Generic.Commenting.DocComment.MissingShort
		/**
		 * @ignore
		 */
		protected $conflicts = null;

		// phpcs:ignore Generic.Commenting.DocComment.MissingShort
		/**
		 * @ignore
		 */
		protected $plugin_version_warnings = null;

		// phpcs:ignore Generic.Commenting.DocComment.MissingShort
		/**
		 * @ignore
		 */
		protected $load_spec = null;

		// phpcs:ignore Generic.Commenting.DocComment.MissingShort
		/**
		 * @ignore
		 */
		protected $unregistered_clients = array();

		// phpcs:ignore Generic.Commenting.DocComment.MissingShort
		/**
		 * @ignore
		 */
		protected $screen_id = null;

		/**
		 * Returns the singleton instance of the FontAwesome plugin.
		 *
		 * @since 4.0.0
		 *
		 * @see fa()
		 * @return FontAwesome
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
			/* noop */
		}

		/**
		 * Returns this plugin's admin page's screen_id. Only valid after the admin_menu hook has run.
		 *
		 * @since 4.0.0
		 */
		public function admin_screen_id() {
			return $this->screen_id;
		}

		/**
		 * Main entry point for running the plugin. Called automatically when the plugin is loaded. Clients should
		 * not invoke it directly.
		 *
		 * @since 4.0.0
		 */
		public function run() {
			$fa = $this;
			add_action(
				'init',
				function () use ( $fa ) {
					add_shortcode(
						self::SHORTCODE_TAG,
						function( $params ) use ( $fa ) {
							return $fa->process_shortcode( $params );
						}
					);

					add_filter( 'widget_text', 'do_shortcode' );

					try {
						$fa->load();
					} catch ( FontAwesome_NoReleasesException $e ) {
						font_awesome_handle_fatal_error(
							'Sorry, your WordPress server was unable to contact the Font Awesome server to retrieve available ' .
							'releases data. Most likely, just re-loading this page to get it try again should work. But if you\'re running ' .
							'WordPress offline, from an airplane, or in some other way that blocks your WordPress server from reaching ' .
							'fontawesome.com, then that will block you from proceeding until you can connect successfully.'
						);
					} catch ( Exception $e ) {
						font_awesome_handle_fatal_error( $e->getMessage() );
					} catch ( Error $e ) {
						font_awesome_handle_fatal_error( $e->getMessage() );
					}
				},
				10,
				/**
				 * Explicitly indicate to the init action hook that 0 args should be passed in when invoking the
				 * callback function, so that the default parameter will be used.
				 * Otherwise, the callback seems to be called with a single empty string parameter, which confuses it.
				 */
				0
			);

			$this->initialize_rest_api();

			if ( is_admin() ) {
				$this->initialize_admin();
			}
		}

		/**
		 * Reports whether the currently loaded version of the Font Awesome plugin satisfies the given constraints.
		 *
		 * NOTE: this method is not concerned with the version of Font Awesome assets being loaded by this plugin,
		 * but with the version of this plugin itself.
		 *
		 * The constraints array should contain one element per constraint, where each individual constraint is itself
		 * an array of arguments that can be passed as the second and third arguments to the standard `version_compare`
		 * function.
		 *
		 * The constraints will be ANDed together.
		 *
		 * For example the following constraints...
		 *
		 * ```php
		 *   array(
		 *     [ '1.0.0', '>='],
		 *     [ '2.0.0', '<']
		 *   )
		 * ```
		 *
		 * ...mean: "assert that this plugin's version number is greater than or equal 1.0.0 AND strictly less than 2.0.0"
		 *
		 * To express OR conditions, make multiple calls to this function and OR the results together in your own code.
		 *
		 * @since 4.0.0
		 *
		 * @link http://php.net/manual/en/function.version-compare.php
		 * @param array $constraints
		 * @return bool
		 * @throws InvalidArgumentException
		 */
		public function satisfies( $constraints ) {
			$valid_operators = [ '<', 'lt', '<=', 'le', '>', 'gt', '>=', 'ge', '==', '=', 'eq', '!=', '<>', 'ne' ];

			if ( ! is_array( $constraints ) ) {
				throw new InvalidArgumentException( 'constraints argument must be an array of constraints' );
			}
			$result_so_far = true;
			foreach ( $constraints as $constraint ) {
				if ( ! is_array( $constraint ) || 2 !== count( $constraint ) || false === array_search( $constraint[1], $valid_operators, true ) ) {
					throw new InvalidArgumentException( 'each constraint must be an array of [ version, operator ] compatible with PHP\'s version_compare' );
				}
				if ( ! version_compare( $this->plugin_version(), $constraint[0], $constraint[1] ) ) {
					$result_so_far = false;
					break;
				}
			}
			return $result_so_far;
		}

		/**
		 * Reports a warning if currently loaded version of the Font Awesome plugin does not
		 * satisfy the given constraints.
		 *
		 * This can help site owners better diagnose conflicts.
		 *
		 * Issues warnings in two ways:
		 *
		 * 1. An admin notice using the `admin_notices` WordPress hook. This appears in admin pages _other_ than
		 *    this plugin's options page.
		 *
		 * 2. A section on this plugin's options page.
		 *
		 * In order for the second warning to appear, this function should be called during
		 * this plugin's main loading logic. Therefore, the recommended time to call this function is from the client's
		 * callback on the `font_awesome_requirements` action hook.
		 *
		 * The shape of the `$constraints` argument is the same as for {@see FortAwesome\FontAwesome::satisfies()}.
		 *
		 * For example:
		 * ```php
		 * add_action(
		 *   'font_awesome_enqueued',
		 *   function() {
		 *     FortAwesome\fa()->satisfies_or_warn( [['4.0.0', '>=']], 'Theta' );
		 *   }
		 * );
		 * ```
		 *
		 * @since 4.0.0
		 *
		 * @param array $constraints as required by FontAwesome::satisfies()
		 * @param string $name name to be displayed in admin notice if the loaded Font Awesome version does not satisfy the
		 *        given constraint.
		 * @see FontAwesome font_awesome_enqueued action hook
		 * @see FortAwesome\FontAwesome::satisfies() satisfies()
		 * @return bool
		 * @throws InvalidArgumentException if the constraints provided are not in the expected format
		 */
		public function satisfies_or_warn( $constraints, $name ) {
			if ( $this->satisfies( $constraints ) ) {
				return true;
			} else {
				$stringified_constraints = $this->stringify_constraints( $constraints );
				$this->add_plugin_version_warning(
					array(
						'name'       => $name,
						'constraint' => $stringified_constraints,
					)
				);

				add_action(
					'admin_notices',
					function() use ( $stringified_constraints, $name ) {
						$current_screen = get_current_screen();
						if ( $current_screen && $current_screen->id !== $this->screen_id ) {
							?>
							<div class="notice notice-warning is-dismissible">
								<p>
									Font Awesome plugin version conflict with a plugin or theme named:
									<b><?php echo esc_html( $name ); ?> </b><br/>
									It requires plugin version <?php echo esc_html( $stringified_constraints ); ?>
									but the currently loaded version of the Font Awesome plugin is
									<?php echo esc_html( self::PLUGIN_VERSION ); ?>.
								</p>
							</div>
							<?php
						}
					}
				);
				return false;
			}
		}

		// phpcs:ignore Generic.Commenting.DocComment.MissingShort
		/**
		 * @ignore
		 */
		protected function stringify_constraints( $constraints ) {
			$flipped_concat_each = array_map(
				function ( $constraint ) {
					return "$constraint[1] $constraint[0]";
				},
				$constraints
			);
			return implode( ' and ', $flipped_concat_each );
		}

		// phpcs:ignore Generic.Commenting.DocComment.MissingShort
		/**
		 * @ignore
		 */
		private function initialize_rest_api() {
			add_action(
				'rest_api_init',
				array(
					new FontAwesome_Config_Controller( self::PLUGIN_NAME, self::REST_API_NAMESPACE ),
					'register_routes',
				)
			);
			add_action(
				'rest_api_init',
				array(
					new FontAwesome_V3Deprecation_Controller( self::PLUGIN_NAME, self::REST_API_NAMESPACE ),
					'register_routes',
				)
			);
		}

		/**
		 * Returns the latest available version of Font Awesome as a string.
		 *
		 * @since 4.0.0
		 *
		 * @throws FontAwesome_NoReleasesException
		 * @return null|string
		 */
		public function get_latest_version() {
			return $this->release_provider()->latest_minor_release();
		}

		/**
		 * Returns the previous minor version of Font Awesome as a string.
		 *
		 * Example: if the most recent available versions of Font Awesome were "5.3.0", "5.4.0", "5.4.1" and "5.5.1",
		 * this function returns "5.4.1".
		 *
		 * @since 4.0.0
		 *
		 * @throws FontAwesome_NoReleasesException
		 * @return null|string
		 */
		public function get_previous_version() {
			return $this->release_provider()->previous_minor_release();
		}

		/**
		 * Returns all available versions of Font Awesome as an array of strings in descending version order.
		 *
		 * Example: if the most recent available versions of Font Awesome were "5.3.0", "5.4.0", "5.4.1" and "5.5.1",
		 * this function returns [ "5.5.1", "5.4.1", "5.4.0", "5.3.0"].
		 *
		 * @since 4.0.0
		 *
		 * @throws FontAwesome_NoReleasesException
		 * @see FontAwesome_Release_Provider::versions()
		 * @return array
		 */
		public function get_available_versions() {
			return $this->release_provider()->versions();
		}

		// phpcs:ignore Generic.Commenting.DocComment.MissingShort
		/**
		 * @ignore
		 */
		private function settings_page_url() {
			return admin_url( 'options-general.php?page=' . self::OPTIONS_PAGE );
		}

		// phpcs:ignore Generic.Commenting.DocComment.MissingShort
		/**
		 * @ignore
		 */
		private function get_admin_asset_manifest() {
			if ( FONTAWESOME_ENV === 'development' ) {
				$response = wp_remote_get( 'http://dockerhost:3030/asset-manifest.json' );

				if ( is_wp_error( $response ) ) {
					wp_die(
						esc_html(
							__(
								"You're running in dev mode (FONTAWESOME_ENV === 'development'), but we got an error trying to wp_remote_get the admin UI's asset manifest. That usually means you haven't started up the webpack dev server for admin. Make sure that's running. You can start it under the 'admin/' dir with 'yarn start'.",
								'font-awesome'
							)
						)
					);
				}

				if ( 200 !== $response['response']['code'] ) {
					return null;
				}

				return json_decode( $response['body'], true );
			} else {
				$asset_manifest_file = FONTAWESOME_DIR_PATH . 'admin/build/asset-manifest.json';
				if ( ! file_exists( $asset_manifest_file ) ) {
					return null;
				}
				// phpcs:ignore WordPress.WP.AlternativeFunctions
				$contents = file_get_contents( $asset_manifest_file );
				if ( empty( $contents ) ) {
					return null;
				}
				return json_decode( $contents, true );
			}
		}

		// phpcs:ignore Generic.Commenting.DocComment.MissingShort
		/**
		 * @ignore
		 */
		private function emit_v3_deprecation_admin_notice( $data ) {
			?>
			<div class="notice notice-warning is-dismissible">
				<p>
					Hey there, from the new and improved Font Awesome plugin!
				</p>
				<p>
					Looks like you're using an <code>[icon]</code> shortcode with an old Font Awesome 3 icon name: <code><?php echo( esc_html( $data['atts']['name'] ) ); ?></code>.
					We're phasing those out, so it will stop working on your site in the not too distant future.
				</p>
				<p>
					Head over to the <a href="<?php echo esc_html( $this->settings_page_url() ); ?>">Font Awesome Settings</a> page to see how you can fix it up, or
					snooze this warning for a while.
				</p>
			</div>
			<?php
		}

		/**
		 * This function is not part of this plugin's public API.
		 *
		 * @ignore
		 * @internal
		 */
		public function initialize_admin() {
			$v3deprecation_warning_data = $this->get_v3deprecation_warning_data();

			if ( $v3deprecation_warning_data && ! ( isset( $v3deprecation_warning_data['snooze'] ) && $v3deprecation_warning_data['snooze'] ) ) {
				add_action(
					'admin_notices',
					function() use ( $v3deprecation_warning_data ) {
						$current_screen = get_current_screen();
						if ( $current_screen && $current_screen->id !== $this->screen_id ) {
							$this->emit_v3_deprecation_admin_notice( $v3deprecation_warning_data );
						}
					}
				);
			}
			add_action(
				'admin_enqueue_scripts',
				function( $hook ) {
					if ( $hook === $this->screen_id ) {

						$admin_asset_manifest = $this->get_admin_asset_manifest();
						$script_number        = 0;

						if ( FONTAWESOME_ENV === 'development' ) {
							$asset_url_base = 'http://localhost:3030/';
						} else {
							$asset_url_base = FONTAWESOME_DIR_URL . 'admin/build';
						}

						$added_wpr_object = false;
						foreach ( $admin_asset_manifest as $key => $value ) {
							if ( preg_match( '/\.js$/', $key ) ) {
								$script_name = self::ADMIN_RESOURCE_HANDLE . '-' . $script_number;
								// phpcs:ignore WordPress.WP.EnqueuedResourceParameters
								wp_enqueue_script( $script_name, $asset_url_base . $value, [], null, true );

								if ( ! $added_wpr_object ) {
									// We have to give a script handle as the first argument to wp_localize_script.
									// It doesn't really matter which one it is—we're only using it to inject a global JavaScript object
									// into a <script> tag. This is just a way to to make that injection on the first script handle
									// we come across.
									wp_localize_script(
										$script_name,
										'wpFontAwesomeOfficial',
										array(
											'api_nonce' => wp_create_nonce( 'wp_rest' ),
											'api_url'   => rest_url( self::REST_API_NAMESPACE ),
										)
									);
									$added_wpr_object = true;
								}
							}
							if ( preg_match( '/\.css$/', $key ) ) {
								// phpcs:ignore WordPress.WP.EnqueuedResourceParameters
								wp_enqueue_style( self::ADMIN_RESOURCE_HANDLE . '-' . $script_number, $asset_url_base . $value, [], null, 'all' );
							}
							/**
							 * This will increment even when there's not a match, so the sequence might be 1, 3, 5,
							 * instead of 1, 2, 3. That's fine--this is just for uniqueification.
							 */
							$script_number++;
						}
					}
				}
			);

			add_action(
				'admin_menu',
				function() {

					$count_plugin_version_warnings = count(
						is_null( $this->plugin_version_warnings )
						? []
						: $this->plugin_version_warnings
					);

					$count_conflicts = is_null( $this->conflicts() ) ? 0 : 1;

					$alert_count = $count_plugin_version_warnings + $count_conflicts;

					$menu_label = sprintf(
						'Font Awesome %s',
						"<span class='update-plugins count-$alert_count' title='Font Awesome Conflicts'><span class='update-count'>"
						. number_format_i18n( $alert_count ) . '</span></span>'
					);

					$this->screen_id = add_options_page(
						'Font Awesome Settings',
						$menu_label,
						'manage_options',
						self::OPTIONS_PAGE,
						array( $this, 'create_admin_page' )
					);
				}
			);

			add_filter(
				'plugin_action_links_' . trailingslashit( self::PLUGIN_NAME ) . self::PLUGIN_NAME . '.php',
				function( $links ) {
					$mylinks = array(
						'<a href="' . $this->settings_page_url() . '">Settings</a>',
					);
					return array_merge( $links, $mylinks );
				}
			);
		}

		/**
		 * Returns current options with defaults.
		 *
		 * Clients should normally not access this.
		 *
		 * @since 4.0.0
		 *
		 * @see FontAwesome::OPTIONS_KEY
		 * @see FontAwesome::DEFAULT_USER_OPTIONS
		 * @throws FontAwesome_NoReleasesException
		 * @return array
		 */
		public function options() {
			$options = wp_parse_args( get_option( self::OPTIONS_KEY ), self::DEFAULT_USER_OPTIONS );
			if ( 'latest' === $options['version'] ) {
				$options['version'] = $this->get_latest_version();
			}
			return $options;
		}

		/**
		 * Callback function for creating the plugin's admin page.
		 *
		 * @since 4.0.0
		 */
		public function create_admin_page() {
			include_once FONTAWESOME_DIR_PATH . 'admin/views/main.php';
		}

		/**
		 * Resets the singleton instance referenced by this class.
		 *
		 * All releases metadata and computed load specification are abandoned.
		 *
		 * @since 4.0.0
		 *
		 * @return FontAwesome
		 */
		public static function reset() {
			self::$instance = null;
			return fa();
		}

		/**
		 * Main entry point for the loading process. Returns true if loading is successful, otherwise false.
		 *
		 * There are two sets of inputs that need to be gathered in order to load Font Awesome: the "load_spec"
		 * and the "options".
		 *
		 * The names and meanings of these have become perhaps unintuitive as this codebase has evolved, which suggests
		 * that it's due for some refactoring.
		 *
		 * 1. The "load_spec" really just pertains to those properties that can be constrained by any client of Font Awesome,
		 *    such as specifying that the "method" should be "webfont" or "svg". To compute this, we have to go through
		 *    all of the requirements registered by all clients. We resolve the final values of these properties based
		 *    on our defaults combined with the requirements that may be provided by clients.
		 *    It's possible that two clients will register mutually exclusive requirements: for example, one could
		 *    require a method of "webfont" while another requires a method of "svg". That would be a case where this
		 *    method returns a false result, failing to compute a settled load spec.
		 *
		 * 2. The "options" includes properties that can be specified only by the site administrator. For example,
		 *    whether or not to use Pro icons. We must know that in order to load the correct bundles of Font Awesome assets,
		 *    but it's not a property that can be constrained by clients other than the site owner.
		 *
		 * 3. For completeness, note too that the site admin can also specify constraints on those properties in the load_spec.
		 *
		 * If we already have a previously built ("locked") load specification saved under our options key in the WordPress
		 * database, then, by default, this function enqueues that load specification without recomputing a new one.
		 * In that case, the `font_awesome_requirements` hook will _not_ be triggered.
		 *
		 * The `font_awesome_enqueued` hook is always triggered when we are ready to successfully load Font Awesome,
		 * whether the load specification was locked from a previous build, or built anew.
		 *
		 * If the load cannot be done successfully, then neither the options nor the load_spec should be changed
		 * in the db.
		 *
		 * @param array $options optional, overrides any options in the db when load is successful, using array_replace_recursive()
		 *        Default: null, no override.
		 * @throws FontAwesome_NoReleasesException|\Exception
		 * @return bool
		 * @ignore
		 */
		private function load( $options = null ) {
			$load_spec = null;

			/**
			 * Fired when the plugin is ready for clients to register their requirements.
			 *
			 * Clients should call {@see FontAwesome::register()} and {@see FontAwesome::satisfies_or_warn()}
			 * from a callback registered on this hook.
			 *
			 * @since 4.0.0
			 */
			do_action( 'font_awesome_requirements' );

			$current_options = is_null( $options )
				? $this->options()
				: $options;

			// Register the web site admin as a client.
			$this->register( $current_options['adminClientLoadSpec'] );

			$using_locked_load_spec = false;
			// Always rebuild when the options are changing.
			if ( ! is_null( $options ) || $this->should_rebuild() ) {
				$load_spec = $this->build();
			} else {
				$load_spec = $this->options()['lockedLoadSpec'];

				$using_locked_load_spec = true;
			}

			if ( isset( $load_spec ) ) {
				$finalized_load_resources = $this->finalize_load_resources( $load_spec, $current_options );

				/**
				 * Only now have we completed all of the validation and resolution of all requirements, including
				 * both those in the load_spec and the options, accounting for any dependencies there may be
				 * between them.
				 *
				 * So we'll save any changes, and then enqueue the result.
				 *
				 * We need to update/save both the options and the load_spec at least before firing the
				 * font_awesome_enqueued action, because clients may be expecting to query this Font Awesome
				 * object in order to detect the configuration state.
				 */

				$this->enqueue( $finalized_load_resources );

				// Save any options that need saving.
				if ( ! $using_locked_load_spec ) {
					wp_cache_delete( 'alloptions', 'options' );
					$current_options['lockedLoadSpec'] = $load_spec;
					if ( ! update_option( self::OPTIONS_KEY, $current_options ) ) {
						// TODO: add test coverage for this case.
						throw new \Exception(
							'Could not save new options for some unexpected reason. ' .
							'Maybe try again? In the meantime, the last known good configuration will remain active.'
						);
					}
				}

				// Update the load spec.
				$this->load_spec = $load_spec;

				/**
				 * Fired when the plugin has successfully built a load specification that satisfies all clients.
				 *
				 * @since 4.0.0
				 */
				do_action( 'font_awesome_enqueued' );

				return true;
			} else {
				return false;
			}
		}

		// phpcs:ignore Generic.Commenting.DocComment.MissingShort
		/**
		 * @ignore
		 */
		private function should_rebuild() {
			$options = $this->options();
			if ( ! isset( $options['lockedLoadSpec'] ) ) {
				return true;
			}

			$locked_clients = $options['lockedLoadSpec']['clients'];

			$processed_clients = array();

			foreach ( $this->client_requirements as $client_name => $client_requirement ) {
				if ( ! isset( $locked_clients[ $client_name ] ) || $locked_clients[ $client_name ] !== $client_requirement['clientVersion'] ) {
					return true;
				} else {
					array_push( $processed_clients, $client_name );
				}
			}

			// Get all client names in $locked_clients that we didn't just process in $this->client_requirements.
			// This would include clients that have just been deactivated, for example, since they would have
			// previously been part of the lockedLoadSpec, but would not be part of the current client_requirements.
			// If there are any at all, regardless of version, it means the lockedLoadSpec needs to be re-built.
			$remaining_clients = array_diff( array_keys( $locked_clients ), $processed_clients );
			if ( count( $remaining_clients ) > 0 ) {
				return true;
			}

			return false;
		}

		// phpcs:ignore Generic.Commenting.DocComment.MissingShort
		/**
		 * @ignore
		 */
		private function build() {
			$load_spec = $this->compute_load_spec(
				function( $data ) {
					// This is the error callback function. It only runs when build_load_spec() needs to report an error.
					$this->conflicts  = $data;
					$client_name_list = [];
					foreach ( $data['conflictingClientRequirements'] as $client ) {
						array_push(
							$client_name_list,
							self::ADMIN_USER_CLIENT_NAME_INTERNAL === $client['name']
							? self::ADMIN_USER_CLIENT_NAME_EXTERNAL
							: $client['name']
						);
					}

					/**
					 * Fired when the plugin reaches the first conflicting requirement.
					 *
					 * @since 4.0.0
					 *
					 * @see FontAwesome
					 */
					do_action( 'font_awesome_failed', $data );
					add_action(
						'admin_notices',
						function() use ( $client_name_list ) {
							$current_screen = get_current_screen();
							if ( $current_screen && $current_screen->id !== $this->screen_id ) {
								?>
									<div class="notice notice-warning is-dismissible">
									<p>
										Font Awesome Error! These themes or plugins have conflicting requirements:
										<?php echo esc_html( implode( $client_name_list, ', ' ) ); ?>.
										To resolve these conflicts, <a href="<?php echo esc_html( $this->settings_page_url() ); ?>"> Go to Font Awesome Settings</a>.
									</p>
									</div>
								<?php
							}
						}
					);
				}
			);

			return $load_spec;
		}

		/**
		 * Returns current requirements conflicts.
		 *
		 * Should normally only be called after the `font_awesome_failed` action has triggered, indicating that there
		 * are some conflicts.
		 *
		 * The returned array indicates just the _first_ requirement that failed to be settled among the various
		 * client requirements, along with all of those client's requirements. This allows code to detect or log
		 * which clients are responsible for the conflict. This is the same information that is displayed in the
		 * admin UI.
		 *
		 * The shape of the conflicts array looks like this:
		 * ```php
		 *   array(
		 *     // the requirement in conflict, as supplied in the params to FontAwesome::register()
		 *     "requirement" => "version",
		 *     // one entry per client that registered a constraint on the conflicting requirement
		 *     "conflictingClientRequirements" => array(
		 *       [0] => array(
		 *          'name' => 'my-plugin',
		 *          'version' => '5.5.3', // this client's conflicting constraint on this requirement
		 *            'clientCallSite' => array(
		 *              'file' => '/var/www/html/wp-content/plugins/my-plugin/includes/my-plugin.php',
		 *              'line' => 552
		 *            )
		 *       ),
		 *      // ...
		 *     )
		 *   )
		 * ```
		 * This array will describe the conflict of exactly one requirement—the first conflict found—because this hook is
		 * triggered on the first failure.
		 *
		 * @since 4.0.0
		 *
		 * @see FontAwesome::register() register() documents all client requirement keys
		 * @return array|null
		 */
		public function conflicts() {
			return $this->conflicts;
		}

		/**
		 * Returns plugin version warnings.
		 *
		 * These are the warnings that would be reported in the admin UI as a result of clients calling
		 * {@see FortAwesome\FontAwesome::satisfies_or_warn()}.
		 *
		 * @since 4.0.0
		 *
		 * @return array|null
		 */
		public function get_plugin_version_warnings() {
			return $this->plugin_version_warnings;
		}

		// phpcs:ignore Generic.Commenting.DocComment.MissingShort
		/**
		 * @ignore
		 */
		private function add_plugin_version_warning( $warning ) {
			if ( is_null( $this->plugin_version_warnings ) || ! is_array( $this->plugin_version_warnings ) ) {
				$this->plugin_version_warnings = array();
			}
			$this->plugin_version_warnings[ $warning['name'] ] = $warning;
		}

		/**
		 * Return current client requirements for all registered clients.
		 *
		 * The website owner (i.e. the one who uses the WordPress admin dashboard) is considered a registered client.
		 * So that owner's requirements will be represented here. But note that these requirements do not include
		 * the `options`, as returned by {@see FortAwesome\FontAwesome::options()} which also help determine the
		 * final result of how the Font Awesome assets are loaded.
		 *
		 * Each element of the array has the same shape as the requirements given to {@see FortAwesome\FontAwesome::register()}.
		 *
		 * @since 4.0.0
		 *
		 * @see FortAwesome\FontAwesome::register()
		 * @return array
		 */
		public function requirements() {
			return $this->client_requirements;
		}

		/**
		 * Return list of found unregistered clients.
		 *
		 * Unregistered clients are those for which this plugin detects an enqueued script or stylesheet having a
		 * URI that appears to load Font Awesome, but which has not called {@see FortAwesome\FontAwesome::register()} to register
		 * its requirements with this plugin.
		 *
		 * Unregistered clients are detected late in the wp_print_styles action hook, after the wp_enqueue_scripts hook,
		 * which is when we'd  normally expect any themes or plugins to enqueue their styles.
		 *
		 * @since 4.0.0
		 *
		 * @return array
		 */
		public function unregistered_clients() {
			return $this->unregistered_clients;
		}

		/**
		 * Returns the subset of metadata required to load Font Awesome that corresponds to client requirements.
		 *
		 * *DEPRECATED*
		 *
		 * A successful resolution of all factors necessary to load Font Awesome without conflict involves:
		 * 1. A load specification (this `load_spec`) that satisfies all requirements registered by clients, including the
		 *    site owner's requirements as specified on the options page.
		 * 2. Options specified by the site owner that cannot be controlled by other clients. This is available from {@see FortAwesome\FontAwesome::options()}.
		 *
		 * Since the metadata returned by this method only includes a _subset_ of what determines how
		 * Font Awesome is loaded, it's a bit of a misnomer. Rather than trying to keep track of what's stored where,
		 * it's best to just use the various accessor methods, like these:
		 *
		 *   - {@see FortAwesome\FontAwesome::version()} to discover the version of Font Awesome being loaded
		 *   - {@see FortAwesome\FontAwesome::using_pro()} to discover whether a version with Pro icons is being loaded
		 *   - {@see FortAwesome\FontAwesome::using_pseudo_elements()} to discover whether Font Awesome is being loaded with support
		 *     for pseudo-elements
		 *
		 * Returns `null` if a load spec has not yet been determined.
		 * If it is still `null` and {@see FontAwesome::conflicts()} returns _not_ `null`, that means the load failed:
		 * there is no settled load specification because none could be found that satisfies all client requirements.
		 * For example, one client may have required `'method' => 'svg'` while another required `'method' => 'webfont'`.
		 *
		 * @since 4.0.0
		 * @deprecated
		 *
		 * @return array
		 */
		public function load_spec() {
			return $this->load_spec;
		}

		// phpcs:ignore Generic.Commenting.DocComment.MissingShort
		/**
		 * @ignore
		 */
		protected function compute_load_spec( callable $error_callback ) {
			// 1. Iterate through $reqs once. For each requirement attribute, see if the current works with the accumulator.
			// 2. If we see any conflict along the way, bail out early. But how do we report the conflict helpfully?
			// 3. Compose a final result that uses defaults for keys that have no client-specified requirements.
			$load_spec = array(
				'method'         => array(
					// returns new value if compatible, else null.
					'resolve' => function( $prev_req_val, $cur_req_val ) {
						return $prev_req_val === $cur_req_val ? $prev_req_val : null; },
				),
				'v4shim'         => array(
					'resolve' => function( $prev_req_val, $cur_req_val ) {
						/*
						 * Cases:
						 * require, require => true
						 * require, forbid => false
						 * forbid, require => false
						 * forbid, forbid => true
						 */
						if ( 'require' === $prev_req_val ) {
							if ( 'require' === $cur_req_val ) {
								return $cur_req_val; } elseif ( 'forbid' === $cur_req_val ) {
								return null; } else {
										return null; }
						} elseif ( 'forbid' === $prev_req_val ) {
							if ( 'forbid' === $cur_req_val ) {
								return $cur_req_val;
							} elseif ( 'require' === $cur_req_val ) {
								return null; } else {
								return null; }
						} else {
							return null; }
					},
				),
				'pseudoElements' => array(
					'resolve' => function( $prev_req_val, $cur_req_val ) {
						if ( 'require' === $prev_req_val ) {
							if ( 'require' === $cur_req_val ) {
								return $cur_req_val; } elseif ( 'forbid' === $cur_req_val ) {
								return null; } else {
										return null; }
						} elseif ( 'forbid' === $prev_req_val ) {
							if ( 'forbid' === $cur_req_val ) {
								return $cur_req_val;
							} elseif ( 'require' === $cur_req_val ) {
								return null; } else {
								return null; }
						} else {
							return null; }
					},
				),
			);

			$valid_keys      = array_keys( $load_spec );
			$bail_early_req  = null;
			$clients         = array();
			$client_versions = array();

			// Iterate through each set of requirements registered by a client.
			foreach ( $this->client_requirements as $requirement ) {
				$clients[ $requirement['name'] ]         = $requirement['clientCallSite'];
				$client_versions[ $requirement['name'] ] = $requirement['clientVersion'];

				// For this set of requirements, iterate through each requirement key, like ['method', 'v4shim', ... ].
				foreach ( $requirement as $key => $payload ) {
					if ( in_array( $key, [ 'clientCallSite', 'name', 'clientVersion' ], true ) ) {
						continue; // these are meta keys that we won't process here.
					}
					if ( ! in_array( $key, $valid_keys, true ) ) {
						// ignore silently.
						continue;
					}
					if ( array_key_exists( 'value', $load_spec[ $key ] ) ) {
						// Check compatibility with existing requirement value.
						// First, record that this client has made this new requirement.
						if ( array_key_exists( 'clientRequirements', $load_spec[ $key ] ) ) {
							array_unshift( $load_spec[ $key ]['clientRequirements'], $requirement );
						} else {
							$load_spec[ $key ]['clientRequirements'] = array( $requirement );
						}
						$resolved_req = $load_spec[ $key ]['resolve']($load_spec[ $key ]['value'], $requirement[ $key ]);
						if ( is_null( $resolved_req ) ) {
							// the compatibility test failed.
							$bail_early_req = $key;
							break 2;
						} else {
							// The previous and current requirements are compatible, so update the value.
							$load_spec[ $key ]['value'] = $resolved_req;
						}
					} else {
						// Add this as the first client to make this requirement.
						$load_spec[ $key ]['value']              = $requirement[ $key ];
						$load_spec[ $key ]['clientRequirements'] = [ $requirement ];
					}
				}
			}

			if ( $bail_early_req ) {
				// call the error_callback, indicating which clients registered incompatible requirements.
				is_callable( $error_callback ) && $error_callback(
					array(
						'requirement'                   => $bail_early_req,
						'conflictingClientRequirements' => $load_spec[ $bail_early_req ]['clientRequirements'],
					)
				);
				return null;
			}

			$method  = $this->specified_requirement_or_default( $load_spec['method'], 'webfont' );
			$version = $this->version();

			/*
			 * Use v4shims by default, unless method === 'webfont' and version < 5.1.0
			 * If we end up in an invalid state where v4shims are required for webfont v5.0.x, it should be because of an
			 * invalid client requirement, and in that case, it will be acceptible to throw an exception. But we don't want
			 * to introduce such an exception by our own defaults here.
			 */
			$v4shim_default = 'require';
			if ( 'webfont' === $method && version_compare( $version, '5.1.0', '<' ) ) {
				$v4shim_default = 'forbid';
			}
			$pseudo_elements_default = 'webfont' === $method ? 'require' : null;
			$pseudo_elements         = 'require' === $this->specified_requirement_or_default( $load_spec['pseudoElements'], $pseudo_elements_default );
			if ( 'webfont' === $method && ! $pseudo_elements ) {
				// TODO: propagate this warning up to the admin UI instead of error_log.
				// phpcs:ignore WordPress.PHP.DevelopmentFunctions
				error_log( 'WARNING: a client of Font Awesome has forbidden pseudo-elements, but since the webfont method has been selected, pseudo-element support cannot be eliminated.' );
				$pseudo_elements = true;
			}

			return array(
				'method'         => $method,
				'v4shim'         => $this->specified_requirement_or_default( $load_spec['v4shim'], $v4shim_default ) === 'require',
				'pseudoElements' => $pseudo_elements,
				'clients'        => $client_versions,
			);
		}

		// phpcs:ignore Generic.Commenting.DocComment.MissingShort
		/**
		 * @ignore
		 */
		protected function is_pro_configured() {
			$options = $this->options();
			return( wp_validate_boolean( $options['usePro'] ) );
		}

		/**
		 * Indicates whether Font Awesome Pro is being loaded.
		 *
		 * Its results are valid only after the `font_awesome_enqueued` has been triggered.
		 *
		 * It's a handy way to toggle the use of Pro icons in client theme or plugin template code.
		 *
		 * @since 4.0.0
		 *
		 * @return boolean
		 */
		public function using_pro() {
			return $this->is_pro_configured();
		}

		/**
		 * Indicates which Font Awesome method is being loaded: 'webfont' or 'svg'.
		 *
		 * Its result is valid only after the `font_awesome_enqueued` has been triggered.
		 *
		 * @since 4.0.0
		 *
		 * @return string|null
		 */
		public function fa_method() {
			return isset( $this->load_spec['method'] ) ? $this->load_spec['method'] : null;
		}

		/**
		 * Reports the version of Font Awesome assets being loaded.
		 *
		 * Its results are valid only after the `font_awesome_enqueued` has been triggered.
		 *
		 * Your theme or plugin should probably query this in order to determine whether all of the icons used in your
		 * templates will be available, especially if you tend to use newer icons. It should be really easy
		 * for site owners to update to a new Font Awesome version to accommodate your templates--just a simple dropdown
		 * selection on the Font Awesome plugin options page. But you might need to show an admin notice to nudge
		 * them to do so if you detect that the current version of Font Awesome being loaded is older than you'd like.
		 *
		 * @since 4.0.0
		 *
		 * @throws FontAwesome_NoReleasesException
		 * @return string
		 */
		public function version() {
			$options = $this->options();
			if ( 'latest' === $options['version'] ) {
				return $this->get_latest_version();
			} else {
				return $options['version'];
			}
		}

		/**
		 * Indicates whether Font Awesome is being loaded with a version 4 shim.
		 *
		 * Its result is valid only after the `font_awesome_enqueued` has been triggered.
		 *
		 * @since 4.0.0
		 *
		 * @return boolean
		 */
		public function v4shim() {
			return isset( $this->load_spec['v4shim'] ) ? boolval( $this->load_spec['v4shim'] ) : false;
		}

		/**
		 * Indicates whether Font Awesome is being loaded with support for CSS pseudo-elements.
		 *
		 * Its results are only valid after the `font_awesome_enqueued` action has been triggered.
		 *
		 * You might use this, for example, to detect when the SVG with JavaScript method is being used with
		 * pseudo-elements enabled. There are known performance problems with this combination.
		 * It's usually better that you don't "forbid" pseudo-elements in your requirements--to avoid causing unnecessary
		 * hard conflicts. But you might use this detection to show a relevant warning as an admin notice.
		 *
		 * @since 4.0.0
		 *
		 * @return boolean
		 */
		public function using_pseudo_elements() {
			$load_spec = $this->load_spec();
			return isset( $load_spec['pseudoElements'] ) && $load_spec['pseudoElements'];
		}

		// phpcs:ignore Generic.Commenting.DocComment.MissingShort
		/**
		 * @ignore
		 */
		protected function specified_requirement_or_default( $requirement, $default ) {
			return array_key_exists( 'value', $requirement ) ? $requirement['value'] : $default;
		}

		/**
		 * Once this runs through successfully and returns a resource collection, we are sure that we have successfully
		 * resolved everything required to enqueue the assets.
		 *
		 * What's returned by this function is safe to pass on to enqueue()
		 *
		 * @param $load_spec
		 * @param $options
		 *
		 * @return array
		 * @throws FontAwesome_ConfigurationException|FontAwesome_NoReleasesException|\InvalidArgumentException
		 */
		protected function finalize_load_resources( $load_spec, $options ) {
			if ( ! isset( $options['removeUnregisteredClients'] ) ) {
				throw new InvalidArgumentException( 'missing param: removeUnregisteredClients' );
			}

			if ( ! isset( $options['usePro'] ) ) {
				throw new InvalidArgumentException( 'missing param: usePro' );
			}

			if ( ! isset( $options['version'] ) ) {
				throw new InvalidArgumentException( 'missing param: version' );
			}

			$release_provider = $this->release_provider();

			$method  = $load_spec['method'];
			$use_svg = false;
			if ( 'svg' === $method ) {
				$use_svg = true;
			} elseif ( 'webfont' !== $method ) {
				// phpcs:ignore WordPress.PHP.DevelopmentFunctions
				error_log(
					"WARNING: ignoring invalid method \"$method\". Expected either \"webfont\" or \"svg\". " .
					'Will use the default of "webfont"'
				);
			}

			$version = 'latest' === $options['version']
				? $this->get_latest_version()
				: $options['version'];

			/*
			 * For now, we're hardcoding the style_opt as 'all'. Eventually, we can open up the rest of the
			 * feature for specifying a subset of styles.
			 */
			$resource_collection = $release_provider->get_resource_collection(
				$version,
				'all',
				[
					'use_pro'  => $options['usePro'],
					'use_svg'  => $use_svg,
					'use_shim' => $load_spec['v4shim'],
				]
			);

			return array(
				'resource_collection' => $resource_collection,
				'load_spec'           => $load_spec,
				'options'             => $options,
			);
		}

		/**
		 * This wants to receive params as returned by resolve_resource_collection(), which are guaranteed to work.
		 *
		 * @param $params
		 */
		protected function enqueue( $params ) {
			$resource_collection = $params['resource_collection'];
			$options             = $params['options'];
			$load_spec           = $params['load_spec'];
			$license_subdomain   = $this->using_pro() ? 'pro' : 'use';
			$version             = $options['version'];

			if ( 'webfont' === $load_spec['method'] ) {

				foreach ( [ 'wp_enqueue_scripts', 'admin_enqueue_scripts', 'login_enqueue_scripts' ] as $action ) {
					add_action(
						$action,
						function () use ( $resource_collection ) {
							// phpcs:ignore WordPress.WP.EnqueuedResourceParameters
							wp_enqueue_style( self::RESOURCE_HANDLE, $resource_collection[0]->source(), null, null );
						}
					);
				}

				// Filter the <link> tag to add the integrity and crossorigin attributes for completeness.
				add_filter(
					'style_loader_tag',
					function( $html, $handle ) use ( $resource_collection ) {
						if ( in_array( $handle, [ self::RESOURCE_HANDLE ], true ) ) {
									return preg_replace(
										'/\/>$/',
										'integrity="' . $resource_collection[0]->integrity_key() .
										'" crossorigin="anonymous" />',
										$html,
										1
									);
						} else {
									return $html;
						}
					},
					10,
					2
				);

				if ( $load_spec['v4shim'] ) {
					/**
					 * Enqueue v4 compatibility as late as possible, though still within the normal script enqueue hooks.
					 * We need the @font-face override, especially to appear after any unregistered loads of Font Awesome
					 * that may try to declare a @font-face with a font-family of "FontAwesome".
					 */
					foreach ( [ 'wp_enqueue_scripts', 'admin_enqueue_scripts', 'login_enqueue_scripts' ] as $action ) {
						add_action(
							$action,
							function () use ( $resource_collection, $options, $license_subdomain, $version ) {
								// phpcs:ignore WordPress.WP.EnqueuedResourceParameters
								wp_enqueue_style( self::RESOURCE_HANDLE_V4SHIM, $resource_collection[1]->source(), null, null );

								$font_face = <<< EOT
@font-face {
    font-family: "FontAwesome";
    src: url("https://${license_subdomain}.fontawesome.com/releases/v${version}/webfonts/fa-brands-400.eot"),
         url("https://${license_subdomain}.fontawesome.com/releases/v${version}/webfonts/fa-brands-400.eot?#iefix") format("embedded-opentype"),
         url("https://${license_subdomain}.fontawesome.com/releases/v${version}/webfonts/fa-brands-400.woff2") format("woff2"),
         url("https://${license_subdomain}.fontawesome.com/releases/v${version}/webfonts/fa-brands-400.woff") format("woff"),
         url("https://${license_subdomain}.fontawesome.com/releases/v${version}/webfonts/fa-brands-400.ttf") format("truetype"),
         url("https://${license_subdomain}.fontawesome.com/releases/v${version}/webfonts/fa-brands-400.svg#fontawesome") format("svg");
}

@font-face {
    font-family: "FontAwesome";
    src: url("https://${license_subdomain}.fontawesome.com/releases/v${version}/webfonts/fa-solid-900.eot"),
         url("https://${license_subdomain}.fontawesome.com/releases/v${version}/webfonts/fa-solid-900.eot?#iefix") format("embedded-opentype"),
         url("https://${license_subdomain}.fontawesome.com/releases/v${version}/webfonts/fa-solid-900.woff2") format("woff2"),
         url("https://${license_subdomain}.fontawesome.com/releases/v${version}/webfonts/fa-solid-900.woff") format("woff"),
         url("https://${license_subdomain}.fontawesome.com/releases/v${version}/webfonts/fa-solid-900.ttf") format("truetype"),
         url("https://${license_subdomain}.fontawesome.com/releases/v${version}/webfonts/fa-solid-900.svg#fontawesome") format("svg");
}

@font-face {
    font-family: "FontAwesome";
    src: url("https://${license_subdomain}.fontawesome.com/releases/v${version}/webfonts/fa-regular-400.eot"),
         url("https://${license_subdomain}.fontawesome.com/releases/v${version}/webfonts/fa-regular-400.eot?#iefix") format("embedded-opentype"),
         url("https://${license_subdomain}.fontawesome.com/releases/v${version}/webfonts/fa-regular-400.woff2") format("woff2"),
         url("https://${license_subdomain}.fontawesome.com/releases/v${version}/webfonts/fa-regular-400.woff") format("woff"),
         url("https://${license_subdomain}.fontawesome.com/releases/v${version}/webfonts/fa-regular-400.ttf") format("truetype"),
         url("https://${license_subdomain}.fontawesome.com/releases/v${version}/webfonts/fa-regular-400.svg#fontawesome") format("svg");
    unicode-range: U+F004-F005,U+F007,U+F017,U+F022,U+F024,U+F02E,U+F03E,U+F044,U+F057-F059,U+F06E,U+F070,U+F075,U+F07B-F07C,U+F080,U+F086,U+F089,U+F094,U+F09D,U+F0A0,U+F0A4-F0A7,U+F0C5,U+F0C7-F0C8,U+F0E0,U+F0EB,U+F0F3,U+F0F8,U+F0FE,U+F111,U+F118-F11A,U+F11C,U+F133,U+F144,U+F146,U+F14A,U+F14D-F14E,U+F150-F152,U+F15B-F15C,U+F164-F165,U+F185-F186,U+F191-F192,U+F1AD,U+F1C1-F1C9,U+F1CD,U+F1D8,U+F1E3,U+F1EA,U+F1F6,U+F1F9,U+F20A,U+F247-F249,U+F24D,U+F254-F25B,U+F25D,U+F267,U+F271-F274,U+F279,U+F28B,U+F28D,U+F2B5-F2B6,U+F2B9,U+F2BB,U+F2BD,U+F2C1-F2C2,U+F2D0,U+F2D2,U+F2DC,U+F2ED,U+F328,U+F358-F35B,U+F3A5,U+F3D1,U+F410,U+F4AD;
}
EOT;

								wp_add_inline_style(
									self::RESOURCE_HANDLE_V4SHIM,
									$font_face
								);

							},
							PHP_INT_MAX
						);
					}

					// Filter the <link> tag to add the integrity and crossorigin attributes for completeness.
					// Not all resources have an integrity_key for all versions of Font Awesome, so we'll skip this for those
					// that don't.
					if ( ! is_null( $resource_collection[1]->integrity_key() ) ) {
						add_filter(
							'style_loader_tag',
							function ( $html, $handle ) use ( $resource_collection ) {
								if ( in_array( $handle, [ self::RESOURCE_HANDLE_V4SHIM ], true ) ) {
									return preg_replace(
										'/\/>$/',
										'integrity="' . $resource_collection[1]->integrity_key() .
										'" crossorigin="anonymous" />',
										$html,
										1
									);
								} else {
									return $html;
								}
							},
							10,
							2
						);
					}
				}
			} else {
				foreach ( [ 'wp_enqueue_scripts', 'admin_enqueue_scripts', 'login_enqueue_scripts' ] as $action ) {
					add_action(
						$action,
						function () use ( $resource_collection, $load_spec ) {
							// phpcs:ignore WordPress.WP.EnqueuedResourceParameters
							wp_enqueue_script( self::RESOURCE_HANDLE, $resource_collection[0]->source(), null, null, false );

							if ( $load_spec['pseudoElements'] ) {
								wp_add_inline_script( self::RESOURCE_HANDLE, 'FontAwesomeConfig = { searchPseudoElements: true };', 'before' );
							}
						}
					);
				}

				// Filter the <script> tag to add additional attributes for integrity, crossorigin, defer.
				add_filter(
					'script_loader_tag',
					function ( $tag, $handle ) use ( $resource_collection ) {
						if ( in_array( $handle, [ self::RESOURCE_HANDLE ], true ) ) {
							$extra_tag_attributes = 'defer crossorigin="anonymous"';

							if ( ! is_null( $resource_collection[0]->integrity_key() ) ) {
								$extra_tag_attributes .= ' integrity="' . $resource_collection[0]->integrity_key() . '"';
							}
							$modified_script_tag = preg_replace(
								// phpcs:ignore WordPress.WP.EnqueuedResources.NonEnqueuedScript
								'/<script\s*(.*?src=.*?)>/',
								"<script $extra_tag_attributes " . '\1>',
								$tag,
								1
							);
							return $modified_script_tag;
						} else {
							return $tag;
						}
					},
					10,
					2
				);

				if ( $load_spec['v4shim'] ) {
					foreach ( [ 'wp_enqueue_scripts', 'admin_enqueue_scripts', 'login_enqueue_scripts' ] as $action ) {
						add_action(
							$action,
							function () use ( $resource_collection ) {
								// phpcs:ignore WordPress.WP.EnqueuedResourceParameters
								wp_enqueue_script( self::RESOURCE_HANDLE_V4SHIM, $resource_collection[1]->source(), null, null, false );
							}
						);
					}

					add_filter(
						'script_loader_tag',
						function ( $tag, $handle ) use ( $resource_collection ) {
							if ( in_array( $handle, [ self::RESOURCE_HANDLE_V4SHIM ], true ) ) {
								$extra_tag_attributes = 'defer crossorigin="anonymous"';
								if ( ! is_null( $resource_collection[1]->integrity_key() ) ) {
									$extra_tag_attributes .= ' integrity="' . $resource_collection[1]->integrity_key() . '"';
								}
								$modified_script_tag = preg_replace(
									// phpcs:ignore WordPress.WP.EnqueuedResources.NonEnqueuedScript
									'/<script\s*(.*?src=.*?)>/',
									"<script $extra_tag_attributes " . '\1>',
									$tag,
									1
								);
								return $modified_script_tag;
							} else {
								return $tag;
							}
						},
						10,
						2
					);
				}
			}

			$obj = $this;
			/**
			 * We need to detect unregistered clients *after* they would have been enqueued, if they used
			 * the recommended mechanism of wp_enqueue_style and wp_enqueue_script (or the admin equivalents).
			 * The wp_print_styles action hook is fired after the wp_enqueue_scripts hook
			 * (admin_print_styles after admin_enqueue_scripts).
			 * We'll use priority 0 in an effort to be as early as possible, to prevent any unregistered client
			 * from actually being printed to the head.
			 */
			foreach ( [ 'wp_print_styles', 'admin_print_styles', 'login_head' ] as $action ) {
				add_action(
					$action,
					function() use ( $obj, $options ) {
						$obj->detect_unregistered_clients();
						if ( $options['removeUnregisteredClients'] ) {
							$obj->remove_unregistered_clients();
						}
					},
					0
				);
			}
		}

		/**
		 * Detects unregistered clients, which can be retrieved with {@see FontAwesome::unregistered_clients()}.
		 * For internal use only. Not part of this plugin's public API.
		 *
		 * @internal
		 * @ignore
		 */
		public function detect_unregistered_clients() {
			$wp_styles  = wp_styles();
			$wp_scripts = wp_scripts();

			$collections = array(
				'style'  => $wp_styles,
				'script' => $wp_scripts,
			);

			$this->unregistered_clients = array(); // re-initialize.

			foreach ( $collections as $key => $collection ) {
				foreach ( $collection->registered as $handle => $details ) {
					if ( preg_match( '/' . self::RESOURCE_HANDLE . '/', $handle )
						|| preg_match( '/' . self::RESOURCE_HANDLE . '/', $handle ) ) {
						continue;
					}
					if ( strpos( $details->src, 'fontawesome' ) || strpos( $details->src, 'font-awesome' ) ) {
						array_push(
							$this->unregistered_clients,
							array(
								'handle' => $handle,
								'type'   => $key,
								'src'    => $details->src,
							)
						);
					}
				}
			}
		}

		// phpcs:ignore Generic.Commenting.DocComment.MissingShort
		/**
		 * @ignore
		 */
		protected function remove_unregistered_clients() {
			foreach ( $this->unregistered_clients as $client ) {
				switch ( $client['type'] ) {
					case 'style':
						wp_dequeue_style( $client['handle'] );
						break;
					case 'script':
						wp_dequeue_script( $client['handle'] );
						break;
					default:
						// phpcs:ignore WordPress.PHP.DevelopmentFunctions
						error_log( 'WARNING: unexpected client type: ' . $client['type'] );
				}
			}
		}

		/**
		 * Registers client requirements. This is the "front door" for registered clients—themes and plugins—that depend
		 * upon this Font Awesome plugin to load a compatible, properly configured version of Font Awesome.
		 *
		 * *Note on using Pro:* registered clients cannot _require_ the use Font Awesome Pro. That is a feature that
		 * must be enabled by the web site owner.
		 *
		 * If you are shipping a theme or plugin for which you insist on being able to use Font Awesome Pro, your only
		 * option is to instruct your users to purchase and enable appropriate licenses of Font Awesome Pro for their
		 * websites.
		 *
		 * The shape of the `$client_requirements` array parameter looks like this:
		 * ```php
		 *   array(
		 *     'method'         => 'svg', // "svg" or "webfont"
		 *     'v4shim'         => 'require', // "require" or "forbid"
		 *     'pseudoElements' => 'require', // "require" or "forbid"
		 *     'name'           => 'Foo Plugin', // (required, but the name in @see FontAwesome::ADMIN_USER_CLIENT_NAME_INTERNAL is reserved)
		 *     'clientVersion'  => '1.0.1', // (required) The version of your plugin or client
		 *   )
		 * ```
		 *
		 * We use camelCase instead of snake_case for these keys, because they end up being passed via json
		 * to the JavaScript admin UI client and camelCase is preferred for object properties in JavaScript.
		 *
		 * All requirement specifications are optional, except `name`. Any that are not specified will allow defaults,
		 * or the requirements of other registered clients to take precedence.
		 *
		 * <h3>Be Flexible: Narrower Constraints Cause More Conflicts</h3>
		 *
		 * Just because you _can_ set requirements here doesn't mean you _should_. A huge design goal for this plugin
		 * is to make it easy for WordPress site owners to install and use Font Awesome conflict-free. And where there
		 * are unavoidable conflicts, we want the site owner to be able to diagnose and resolve them easily.
		 * WordPress is a big world and there are limitless combinations of installed themes and plugins. Font Awesome
		 * is very popular, so it shows up in a lot of those combinations.
		 *
		 * One of the most common sources of conflict with Font Awesome on WordPress is a combination of theme and/or
		 * plugins that each try to do their own
		 * thing with Font Awesome and break one another in the process. This plugin serves as a coordination point
		 * to help developers gain a sense of control and predictability, while also respecting the fact that site owners
		 * will--and should remain free to--mix and match themes and plugins, any of which may incorporate Font Awesome.
		 *
		 * So don't _require_ what you merely _prefer_; require only what you'll die without. Do your best to adapt to
		 * the various configurations that the _site owner_ may prefer. This will improve their experience with _your_
		 * code as well, since it will decrease or eliminate the friction they experience when trying to combine
		 * your theme or plugin with the others they've selected.
		 *
		 * Here's a quick adaptability checklist:
		 *
		 * - Make sure your plugin or theme works just as well with either webfont or svg methods.
		 * - Update your icon references to use version 5 names so no {@link https://fontawesome.com/how-to-use/on-the-web/setup/upgrading-from-version-4 v4 shim} is required.
		 * - Don't use {@link https://fontawesome.com/how-to-use/on-the-web/advanced/css-pseudo-elements pseudo-elements}
		 * - Be mindful of which {@link https://fontawesome.com/icons icons you use and in which versions of Font Awesome they're available}.
		 * - Adapt gracefully when the version loaded lacks icons you want to use (see more below).
		 *
		 * A good example of a legitimate use case for setting one of these requirements is to require the `svg` method,
		 * in order to make use of {@link https://fontawesome.com/how-to-use/on-the-web/styling/power-transforms Power Transforms}.
		 *
		 * Another good example: Suppose your theme or plugin has a legacy codebase that makes heavy use of pseudo-elements.
		 * So you should require pseudo-element support. But suppose you test and find that when the svg method is used
		 * for Font Awesome, all your pseudo-element usage results in a significant performance hit--too much to tolerate.
		 * A temporary measure might then be to require the `webfont` method (your pseudo-elements will perform fine with webfonts).
		 * You really should consider that to be a temporary measure, though, and plan on a future iteration to remove
		 * pseudo-element usage. After removing pseudo-elements from your templates, remove that requirement for pseudo-elements
		 * in your call to this method.
		 *
		 * <h3>Font Awesome version</h3>
		 *
		 * Only the WordPress site owner gets to specify the version of Font Awesome assets that are loaded.
		 *
		 * To maximize compatibility and user-friendliness, keep track of the icons you use and in which versions they're
		 * introduced ({@link https://fontawesome.com/changelog/latest new ones are being added all the time}).
		 * Add a hook on the `font_awesome_enqueued` action to discover what version of Font Awesome is being loaded
		 * and either turn off or replace newer icons that are not available in older releases, or warn the
		 * site owner in your own WordPress admin UI that they'll need to update to a new version in order for icons
		 * to work as expected in your templates.
		 *
		 * <h3>Updates: clientVersion and the load specification cache</h3>
		 *
		 * This plugin is optimized to rebuild the Font Awesome load specification if and only if the inputs change.
		 * Those inputs include options that can be set only by the site owner in the Font Awesome admin settings UI,
		 * and these client requirements registered here. Each client's requirements are identified by `name` and `clientVersion`,
		 * taken together.
		 * Therefore, if a client plugin or theme should update its version number, that would trigger a rebuild of
		 * the load specification. Simply changing your requirements without bumping the `clientVersion` will _not_
		 * trigger a rebuild.
		 *
		 * So if you ship a new version of your theme or plugin with different Font Awesome requirements, you should also
		 * bump this `clientVersion` number. You can use the same version number you've assigned to your theme or plugin,
		 * or any version number scheme you like.
		 *
		 * <h3>Notes on "require" and "forbid"</h3>
		 *
		 * Specifying `require` for a requirement like `pseudoElements` or `v4shim` will cause the loading of
		 * Font Awesome to fail unless all clients are satisfied with this requirement.
		 *
		 * Specifying `forbid` for a requirement will cause loading to fail if any other client specifies `require`
		 * that requirement. For example, because enabling pseudo-elements with SVG with JavaScript may have a negative
		 * impact on performance, a client that requires svg might forbid pseudo-elements.
		 *
		 * Again, theme and plugin developers should normally strive _not_ to add constraints in order to reduce
		 * the likelihood of conflicts. Instead of requiring how Font Awesome must be loaded for your code to work,
		 * write your code to adapt to however Font Awesome might be loaded.
		 *
		 * <h3>Additional Notes on Specific Requirements</h3>
		 *
		 * - `v4shim`
		 *
		 *   There were major changes between Font Awesome 4 and Font Awesome 5, including some re-named icons.
		 *   It's best to upgrade name references to the version 5 names,
		 *   but to [ease the upgrade path](https://fontawesome.com/how-to-use/on-the-web/setup/upgrading-from-version-4),
		 *   the "v4 shims" accept the v4 icon names and translate them into the equivalent v5 icon names.
		 *   Shims for SVG with JavaScript have been available since `5.0.0` and shims for Web Font with CSS have been
		 *   available since `5.1.0`.
		 *
		 * - `pseudoElements`
		 *
		 *   [Pseudo-elements](https://fontawesome.com/how-to-use/on-the-web/advanced/css-pseudo-elements)
		 *   are always intrinsically available when using the Web Font with CSS method.
		 *   However, for the SVG with JavaScript method, additional functionality must be enabled. It's not a recommended
		 *   approach, because the performance can be poor. _Really_ poor, in some cases. However, sometimes, it's necessary.
		 *
		 * @since 4.0.0
		 *
		 * @see FontAwesome::using_pro()
		 * @param array $client_requirements
		 * @throws InvalidArgumentException
		 */
		public function register( $client_requirements ) {
			// TODO: consider using a mechanism other than debug_backtrace() to track the calling module, since phpcs complains.
			// phpcs:ignore WordPress.PHP.DevelopmentFunctions
			$bt     = debug_backtrace( 1 );
			$caller = array_shift( $bt );
			if ( ! array_key_exists( 'name', $client_requirements ) ) {
				throw new InvalidArgumentException( 'missing required key: name' );
			}
			if ( ! array_key_exists( 'clientVersion', $client_requirements ) ) {
				throw new InvalidArgumentException( 'missing required key: clientVersion' );
			}
			$client_requirements['clientCallSite'] = array(
				'file' => $caller['file'],
				'line' => $caller['line'],
			);

			$this->client_requirements[ $client_requirements['name'] ] = $client_requirements;
		}

		// phpcs:ignore Generic.Commenting.DocComment.MissingShort
		/**
		 * @ignore
		 */
		private function process_shortcode( $params ) {
			/**
			 * TODO: add extras to shortcode
			 * class: just add extra classes
			 */
			$atts = shortcode_atts(
				array(
					'name'   => '',
					'prefix' => self::DEFAULT_PREFIX,
					'class'  => '',
				),
				$params,
				self::SHORTCODE_TAG
			);

			// Handle version 3 compatibility and setting data for a deprecation warning.
			if ( preg_match( '/^icon-/', $atts['name'] ) ) {
				$prefix_and_name_classes = FontAwesome_V3Mapper::instance()->map_v3_to_v5( $atts['name'] );

				$v3deprecation_data = $this->get_v3deprecation_warning_data();
				if ( ! $v3deprecation_data ) {
					$v5_prefix_name_arr = explode( ' ', $prefix_and_name_classes );

					$v5name = explode( '-', $v5_prefix_name_arr[1] )[1];

					$v3deprecation_data = array(
						'atts'     => $atts,
						'v5name'   => $v5name,
						'v5prefix' => $v5_prefix_name_arr[0],
					);
					$this->set_v3_deprecation_warning_data( $v3deprecation_data );
				}
			} else {
				$prefix_and_name_classes = $atts['prefix'] . ' fa-' . $atts['name'];
			}

			$classes = rtrim( implode( ' ', [ $prefix_and_name_classes, $atts['class'] ] ) );
			return '<i class="' . $classes . '">&nbsp;</i>';
		}

		/**
		 * Sets a v3 deprecation warning.
		 *
		 * @deprecated Only for temporary internal plugin use while deprecating
		 * @ignore
		 * @param array $data
		 * @return void
		 */
		public function set_v3_deprecation_warning_data( $data ) {
			set_transient( self::V3DEPRECATION_TRANSIENT, $data );
		}

		/**
		 * Retrieves transient warning data for v3 icon name usage.
		 *
		 * @deprecated Only for temporary internal plugin use while deprecating
		 * @return array
		 * @ignore
		 */
		public function get_v3deprecation_warning_data() {
			return get_transient( self::V3DEPRECATION_TRANSIENT );
		}

		/**
		 * Dismisses the v3 deprecation warning for a while.
		 *
		 * @deprecated Only for temporary internal plugin use while deprecating
		 * @ignore
		 */
		public function snooze_v3deprecation_warning() {
			delete_transient( self::V3DEPRECATION_TRANSIENT );
			set_transient( self::V3DEPRECATION_TRANSIENT, array( 'snooze' => true ), self::V3DEPRECATION_EXPIRY );
		}

		// phpcs:ignore Generic.Commenting.DocComment.MissingShort
		/**
		 * Allows a test subclass to mock the release provider.
		 *
		 * @ignore
		 */
		protected function release_provider() {
			return fa_release_provider();
		}

		// phpcs:ignore Generic.Commenting.DocComment.MissingShort
		/**
		 * Allows a test subclass to mock the version.
		 *
		 * @ignore
		 */
		protected function plugin_version() {
			return self::PLUGIN_VERSION;
		}
	}

endif; // ! class_exists

/**
 * Convenience global function to get a singleton instance of the Font Awesome plugin.
 *
 * @since 4.0.0
 *
 * @see FontAwesome::instance()
 * @returns FontAwesome
 */
function fa() {
	return FontAwesome::instance();
}

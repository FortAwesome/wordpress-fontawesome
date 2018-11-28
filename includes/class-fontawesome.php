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
require_once trailingslashit( __DIR__ ) . '../defines.php';
require_once trailingslashit( FONTAWESOME_VENDOR_DIR ) . 'autoload.php';
require_once trailingslashit( FONTAWESOME_DIR_PATH ) . 'includes/class-fontawesome-release-provider.php';
require_once trailingslashit( FONTAWESOME_DIR_PATH ) . 'includes/class-fontawesome-resource.php';
require_once trailingslashit( FONTAWESOME_DIR_PATH ) . 'includes/class-fontawesome-config-controller.php';
require_once ABSPATH . 'wp-admin/includes/screen.php';

use Composer\Semver\Semver;

if ( ! class_exists( 'FontAwesome' ) ) :
	/**
	 * Main plugin class, a singleton.
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
	 *   No parameters.
	 *
	 * - `font_awesome_enqueued`
	 *
	 *   Called when a {@see FontAwesome::load_spec() load specification} has been successfully computed.
	 *
	 *   One parameter `array`: the load specification.
	 *
	 *   Clients could inspect that array to detect whether, say, Pro or pseudo-elements are enabled. Or
	 *   clients may just use the timing of the action's trigger to call the convenience methods like {@see FontAwesome::using_pro()}
	 *   or {@see FontAwesome::using_pseudo_elements()} to detect the same values.
	 *
	 * - `font_awesome_failed`
	 *
	 *   Called when the plugin fails to compute a load specification because of clients requirements that cannot be satisfied.
	 *
	 *   One parameter, an `array` of conflicts where each element
	 *   resolution fails, with up to one argument, an associative array indicating which conflicting requirement between which clients caused resolution to fail. |
	 *
	 * @since 0.1.0
	 *
	 * @package    FontAwesome
	 * @subpackage FontAwesome/includes
	 */
	class FontAwesome {

		/**
		 * Key where this plugin's saved data are stored in the WordPress options table.
		 *
		 * @since 0.1.0
		 */
		const OPTIONS_KEY = 'font-awesome-official';
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
		 * @since 0.1.0
		 */
		const PLUGIN_NAME = 'font-awesome-official';
		/**
		 * The version of this WordPress plugin.
		 */
		const PLUGIN_VERSION = '0.2.0';
		/**
		 * The version of this plugin's REST API.
		 *
		 * @since 0.2.0
		 */
		const REST_API_VERSION = '1';
		/**
		 * The namespace for this plugin's REST API.
		 *
		 * @since 0.2.0
		 */
		const REST_API_NAMESPACE = self::PLUGIN_NAME . '/v' . self::REST_API_VERSION;
		/**
		 * The name of this plugin's options page, or WordPress admin dashboard page.
		 *
		 * @since 0.1.0
		 */
		const OPTIONS_PAGE = 'font-awesome-official';
		/**
		 * The handle used when enqueuing this plugin's resulting resource, whether `<script>` or `<link>`,
		 * via `wp_enqueue_script` or `wp_enqueue_style`.
		 *
		 * @since 0.1.0
		 */
		const RESOURCE_HANDLE = 'font-awesome-official';
		/**
		 * The handle used when enqueuing the v4shim, when it is included in the load specification.
		 *
		 * @since 0.1.0
		 *
		 * @see FontAwesome::load_spec()
		 */
		const RESOURCE_HANDLE_V4SHIM = 'font-awesome-official-v4shim';

		// phpcs:ignore Generic.Commenting.DocComment.MissingShort
		/**
		 * @ignore
		 */
		const DEFAULT_USER_OPTIONS = array(
			'adminClientLoadSpec'       => array(
				'name' => self::ADMIN_USER_CLIENT_NAME_INTERNAL,
			),
			'usePro'                    => false,
			'removeUnregisteredClients' => false,
		);

		// phpcs:ignore Generic.Commenting.DocComment.MissingShort
		/**
		 * @ignore
		 */
		protected static $_instance = null;

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
		 * @since 0.1.0
		 *
		 * @see fa()
		 * @return FontAwesome
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
			/* noop */
		}

		/**
		 * Main entry point for running the plugin. Called automatically when the plugin is loaded. Clients should
		 * not invoke it directly.
		 *
		 * @since 0.1.0
		 */
		public function run() {
			/*
			 * Explicitly indicate that 0 args should be passed in when invoking the function,
			 * so that the default parameter will be used. Otherwise, the callback seems to be
			 * called with a single empty string parameter, which confuses load().
			 */
			add_action( 'init', array( $this, 'load' ), 10, 0 );

			$this->initialize_rest_api();

			if ( is_admin() ) {
				$this->initialize_admin();
			}
		}

		/**
		 * Reports whether the currently loaded version of the Font Awesome plugin satisies the given constraints.
		 *
		 * @since 0.2.0
		 *
		 * @param string $constraint expressed as a constraint that can be understood by `Composer\Semver\Semver`
		 * @link https://getcomposer.org/doc/articles/versions.md
		 * @return bool
		 */
		public function satisfies( $constraint ) {
			return Semver::satisfies( self::PLUGIN_VERSION, $constraint );
		}

		/**
		 * Reports whether the currently loaded version of the Font Awesome plugin satisies the given constraints,
		 * and if not, it warns the WordPress admin in the admin dashboard in order to aid conflict diagnosis.
		 *
		 * @since 0.2.0
		 *
		 * @param string $constraint expressed as a constraint that can be understood by `Composer\Semver\Semver`
		 * @param string $name name to be displayed in admin notice if the loaded Font Awesome version does not satisfy the
		 *        given constraint.
		 * @link https://getcomposer.org/doc/articles/versions.md
		 * @return bool
		 */
		public function satisfies_or_warn( $constraint, $name ) {
			if ( Semver::satisfies( self::PLUGIN_VERSION, $constraint ) ) {
				return true;
			} else {
				$this->add_plugin_version_warning(
					array(
						'name'       => $name,
						'constraint' => $constraint,
					)
				);

				add_action(
					'admin_notices',
					function() use ( $constraint, $name ) {
						$current_screen = get_current_screen();
						if ( $current_screen && $current_screen->id !== $this->screen_id ) {
							?>
							<div class="notice notice-warning is-dismissible">
								<p>
									Font Awesome plugin version conflict with a plugin or theme named:
									<b><?php echo esc_html( $name ); ?> </b><br/>
									It requires plugin version <?php echo esc_html( $constraint ); ?>
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
		private function initialize_rest_api() {
			add_action(
				'rest_api_init',
				array(
					new FontAwesome_Config_Controller( self::PLUGIN_NAME, self::REST_API_NAMESPACE ),
					'register_routes',
				)
			);
		}

		/**
		 * Returns the latest available version of Font Awesome as a string.
		 *
		 * @since 0.1.0
		 *
		 * @return null|string
		 */
		public function get_latest_version() {
			return fa_release_provider()->latest_minor_release();
		}

		/**
		 * Returns the latest available version of Font Awesome as a string, formatted
		 * as a semver.
		 *
		 * Example: if the latest version is "5.5.0", this function returns "~5.5.0"
		 *
		 * @since 0.1.0
		 *
		 * @link https://getcomposer.org/doc/articles/versions.md
		 * @return null|string
		 */
		public function get_latest_semver() {
			return( '~' . $this->get_latest_version() );
		}

		/**
		 * Returns the previous minor version of Font Awesome as a string.
		 *
		 * Example: if the most recent available versions of Font Awesome were "5.3.0", "5.4.0", "5.4.1" and "5.5.1",
		 * this function returns "5.4.1".
		 *
		 * @since 0.1.0
		 *
		 * @return null|string
		 */
		public function get_previous_version() {
			return fa_release_provider()->previous_minor_release();
		}

		/**
		 * Returns the previous minor version of Font Awesome as a string, formatted as a semver.
		 *
		 * Example: if the most recent available versions of Font Awesome were "5.3.0", "5.4.0", "5.4.1" and "5.5.1",
		 * this function returns "~5.4.1".
		 *
		 * @since 0.1.0
		 *
		 * @link https://getcomposer.org/doc/articles/versions.md
		 * @return null|string
		 */
		public function get_previous_semver() {
			return ( '~' . $this->get_previous_version() );
		}

		/**
		 * Returns all available versions of Font Awesome as an array of strings.
		 *
		 * Example: if the most recent available versions of Font Awesome were "5.3.0", "5.4.0", "5.4.1" and "5.5.1",
		 * this function returns "~5.4.1".
		 *
		 * @since 0.1.0
		 *
		 * @see FontAwesome_Release_Provider::versions()
		 * @return null|string
		 */
		public function get_available_versions() {
			return fa_release_provider()->versions();
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
				$client   = new GuzzleHttp\Client( [ 'base_uri' => 'http://dockerhost:3030' ] );
				$response = $client->request( 'GET', '/asset-manifest.json', [] );

				if ( $response->getStatusCode() !== 200 ) {
					return null;
				}

				return json_decode( $response->getbody()->getContents(), true );
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
		private function initialize_admin() {
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
								$script_name = self::PLUGIN_NAME . '-' . $script_number;
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
								wp_enqueue_style( self::PLUGIN_NAME . '-' . $script_number, $asset_url_base . $value, [], null, 'all' );
							}
							$script_number++;
						}
					}
				}
			);

			add_action(
				'admin_menu',
				function() {
					$this->screen_id = add_options_page(
						'Font Awesome Settings',
						'Font Awesome',
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
		 * Clients should normally not be access this.
		 *
		 * @since 0.1.0
		 *
		 * @see FontAwesome::OPTIONS_KEY
		 * @see FontAwesome::DEFAULT_USER_OPTIONS
		 * @return array
		 */
		public function options() {
			return wp_parse_args( get_option( self::OPTIONS_KEY ), self::DEFAULT_USER_OPTIONS );
		}

		/**
		 * Callback function for creating the plugin's admin page.
		 *
		 * @since 0.1.0
		 */
		public function create_admin_page() {
			include_once FONTAWESOME_DIR_PATH . 'admin/views/main.php';
		}

		/**
		 * Resets the singleton instance referenced by this class.
		 *
		 * All releases metadata and computed load specification are abandoned.
		 *
		 * @since 0.1.0
		 *
		 * @return FontAwesome
		 */
		public static function reset() {
			self::$_instance = null;
			return fa();
		}

		/**
		 * Main entry point for the loading process. Returns the enqueued load specification if successful, otherwise null.
		 * If we already have a previously built load specification saved under our options key in the WordPress
		 * database, then, by default, this function enqueues that load specification without recomputing a new one.
		 *
		 * Pass <code>['rebuild' => true]</code> for $params to trigger a rebuild if even a previous one exists in options.
		 * Pass <code>['save' => true]</code> to save a rebuilt load specification to the options table in the db to be used
		 *   subsequent loads.
		 *
		 * @since 0.1.0
		 *
		 * @param array $params
		 * @return array|null
		 */
		public function load( $params = [
			'rebuild' => false,
			'save'    => false,
		] ) {
			$options = $this->options();

			$load_spec = null;

			if ( isset( $options['lockedLoadSpec'] ) && ! $params['rebuild'] ) {
				$load_spec = $options['lockedLoadSpec'];
			} else {
				$load_spec = $this->build( $options );

				if ( isset( $load_spec ) ) {
					if ( true && $params['save'] /* build a test that should only be true if the new load spec is different and should be saved */ ) {
						wp_cache_delete( 'alloptions', 'options' );
						$options['lockedLoadSpec'] = $load_spec;
						if ( ! update_option( self::OPTIONS_KEY, $options ) ) {
							return null;

							/*
							 * TODO: consider alternative ways to handle this condition.
							 * We've managed to build a new load spec, and verified that it's
							 * different, but when trying to update it, we got a falsey response,
							 * and the docs say that means that the update either the update failed
							 * or no update was made.
							 * If we add a warning or error mechanism for passing non-fatal warnings up to admin UI client
							 * for display, it would probably make sense to pass such a message up for this one.
							 */
						}
					}
				}
			}

			if ( isset( $load_spec ) ) {
				// We have a load_spec, whether by retrieving a previously build (locked) one or by building a new one.
				// Now enqueue it.
				$this->load_spec = $load_spec;
				$this->enqueue( $load_spec, $options['removeUnregisteredClients'] );
				return $load_spec;
			} else {
				return null;
			}
		}

		private function build( $options ) {
			// Register the web site user/admin as a client.
			$this->register( $options['adminClientLoadSpec'] );

			// Now, ask any other listening clients to register.
			/**
			 * Fired when the plugin is ready for clients to register their requirements.
			 *
			 * Client plugins and themes should normally have their call to {@see FontAwesome::register()} invoked
			 * from a callback registered on this action.
			 *
			 * @since 0.1.0
			 *
			 * @see FontAwesome::register()
			 */
			do_action( 'font_awesome_requirements' );
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
		 *
		 * ```php
		 * array(
		 *   'requirement' => "version", // "version", "method", or some other client requirement key
		 *   'clientRequirements
		 * )
		 * ```
		 *
		 *  "conflicts": {
		"requirement": "version",
		"clientRequirements": [
		{
		"name": "user",
		"version": "5.4.2",
		"clientCallSite": {
		"file": "/var/www/html/wp-content/plugins/font-awesome-official.prev/includes/class-fontawesome.php",
		"line": 390
		}
		},
		{
		"name": "beta-plugin",
		"version": "5.1.0",
		"v4shim": "require",
		"clientCallSite": {
		"file": "/var/www/html/wp-content/plugins/plugin-beta/plugin-beta.php",
		"line": 25
		}
		}
		]
		},
		 *
		 * @since 0.1.0
		 *
		 * @see FontAwesome::register() For a full list of possible client requirement keys
		 * @return array | null
		 */
		public function conflicts() {
			return $this->conflicts;
		}

		/**
		 * Returns plugin version warnings.
		 *
		 * @since 0.2.0
		 *
		 * @return array | null
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
				$this->plugin_version_warnings = [];
			}
			array_push( $this->plugin_version_warnings, $warning );
		}

		/**
		 * Return current client requirements for all registered clients. The website owner (i.e. the one who
		 * uses the WordPress admin dashboard) is considered a registered client. So that owner's requirements
		 * will be represented here.
		 *
		 * Each element of the array has the same shape as the requirements given to {@see FontAwesome::register()}.
		 *
		 * @since 0.1.0
		 *
		 * @see FontAwesome::register()
		 * @return array
		 */
		public function requirements() {
			return $this->client_requirements;
		}

		/**
		 * Return list of found unregistered clients.
		 *
		 * Unregistered clients are those for which this plugin detects an enqueued script or stylesheet having a
		 * URI that appears to load Font Awesome, but which has not called {@see FontAwesome::register()} to register
		 * its requirements with this plugin.
		 *
		 * @since 0.1.0
		 *
		 * @return array
		 */
		public function unregistered_clients() {
			$this->detect_unregistered_clients();
			return $this->unregistered_clients;
		}

		/**
		 * Return current load specification, which may be null if has not yet been computed.
		 * If it is still `null` and {@see FontAwesome::conflicts()} returns _not_ `null`, that means the load failed:
		 * there is no settled load specification because none could be found that satisfies all client requirements.
		 * For example, one client may have required `'method' => 'svg'` while another required `'method' => 'webfont'`.
		 *
		 * A `load_spec` or _load specification_ contains the metadata necessary to enqueue the appropriate
		 * `<script>` (for SVG with JavaScript) or `<link>` (for Web Fonts with CSS) in the `<head>` of the WordPress
		 * template. It is guaranteed to satisfy all requirements specified by all registered clients of this plugin.
		 *
		 * Its shape looks like this:
		 * ```php
		 *   array(
		 *     'method'         => 'svg', // "svg" or "webfont"
		 *     'v4shim'         => 'require', // "require" or "forbid"
		 *     'pseudoElements' => 'require', // "require" or "forbid"
		 *     'version'        => '5.5.0',
		 *     'usePro'         => true, // boolean indicating whether to use Font Awesome Pro or Free
		 *  )
		 * ```
		 *
		 * @since 0.1.0
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
				// Version: start with all available versions. For each client requirement, narrow the list with that requirement's version constraint.
				// Hopefully, we end up with a non-zero list, in which case, we'll sort the list and take the most recent satisfying version.
				'version'        => array(
					'value'   => $this->get_available_versions(),
					'resolve' => function( $prev_req_val, $cur_req_val ) {
						$satisfying_versions = Semver::satisfiedBy( $prev_req_val, $cur_req_val );
						return count( $satisfying_versions ) > 0 ? $satisfying_versions : null;
					},
				),
			);

			$valid_keys = array_keys( $load_spec );

			$bail_early_req = null;

			$clients = array();

			// Iterate through each set of requirements registered by a client.
			foreach ( $this->client_requirements as $requirement ) {
				$clients[ $requirement['name'] ] = $requirement['clientCallSite'];
				// For this set of requirements, iterate through each requirement key, like ['method', 'v4shim', ... ].
				foreach ( $requirement as $key => $payload ) {
					if ( in_array( $key, [ 'clientCallSite', 'name' ], true ) ) {
						continue; // these are meta keys that we won't process here.
					}
					if ( ! in_array( $key, $valid_keys, true ) ) {
						// phpcs:ignore WordPress.PHP.DevelopmentFunctions
						error_log( 'Ignoring invalid requirement key: ' . $key . '. Only these are allowed: ' . join( ', ', $valid_keys ) );
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
						$load_spec[ $key ]['value']       = $requirement[ $key ];
						$load_spec[ $key ]['clientRequirements'] = [ $requirement ];
					}
				}
			}

			if ( $bail_early_req ) {
				// call the error_callback, indicating which clients registered incompatible requirements.
				is_callable( $error_callback ) && $error_callback(
					array(
						'requirement'         => $bail_early_req,
						'conflictingClientRequirements' => $load_spec[ $bail_early_req ]['clientRequirements'],
					)
				);
				return null;
			}

			$method  = $this->specified_requirement_or_default( $load_spec['method'], 'webfont' );
			$version = Semver::rsort( $load_spec['version']['value'] )[0];

			/*
			 * Use v4shims by default, unless method === 'webfont' and version < 5.1.0
			 * If we end up in an invalid state where v4shims are required for webfont v5.0.x, it should be because of an
			 * invalid client requirement, and in that case, it will be acceptible to throw an exception. But we don't want
			 * to introduce such an exception by our own defaults here.
			 */
			$v4shim_default = 'require';
			if ( 'webfont' === $method && ! Semver::satisfies( $version, '>= 5.1.0' ) ) {
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
				'version'        => $version,
				'usePro'         => $this->is_pro_configured(),
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
		 * Convenience method that returns boolean indicating whether, given the currently settled `load_spec`,
		 * we are loading Font Awesome Pro.
		 *
		 * Since it returns false when {@see FontAwesome::load_spec()} is `null`, it's best to call this only after loading
		 * is complete and successful.
		 *
		 * It's a handy way to toggle the use of Pro icons in client theme or plugin template code.
		 *
		 * @since 0.1.0
		 *
		 * @return boolean
		 */
		public function using_pro() {
			$load_spec = $this->load_spec();
			return isset( $load_spec['usePro'] ) && $load_spec['usePro'];
		}

		/**
		 * Convenience method that returns boolean indicating whether the currently settled `load_spec`
		 * includes support for pseudoElements.
		 *
		 * Since it returns false when {@see FontAwesome::load_spec()} is `null`, it's best to call this only after loading
		 * is complete and successful.
		 *
		 * It's a handy way to toggle the use of pseudo elements icons in a client theme or plugin template code,
		 * or to present a warning in an admin notice in the event that your client code uses pseudo elements, and
		 * the `svg` method is loaded. (There may be a performance penalty with that combination, particularly in earlier
		 * versions of Font Awesome 5.x.)
		 *
		 * @since 0.1.0
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

		// phpcs:ignore Generic.Commenting.DocComment.MissingShort
		/**
		 * @ignore
		 */
		protected function enqueue( $load_spec, $remove_unregistered_clients = false ) {
			$release_provider = fa_release_provider();

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

			/*
			 * For now, we're hardcoding the style_opt as 'all'. Eventually, we can open up the rest of the
			 * feature for specifying a subset of styles.
			 */
			$resource_collection = $release_provider->get_resource_collection(
				$load_spec['version'],
				'all',
				[
					'use_pro'  => $load_spec['usePro'],
					'use_svg'  => $use_svg,
					'use_shim' => $load_spec['v4shim'],
				]
			);

			if ( 'webfont' === $method ) {
				// phpcs:ignore WordPress.WP.EnqueuedResourceParameters
				wp_enqueue_style( self::RESOURCE_HANDLE, $resource_collection[0]->source(), null, null );

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
					// phpcs:ignore WordPress.WP.EnqueuedResourceParameters
					wp_enqueue_style( self::RESOURCE_HANDLE_V4SHIM, $resource_collection[1]->source(), null, null );

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
				// phpcs:ignore WordPress.WP.EnqueuedResourceParameters
				wp_enqueue_script( self::RESOURCE_HANDLE, $resource_collection[0]->source(), null, null, false );

				if ( fa()->using_pseudo_elements() ) {
					wp_add_inline_script( self::RESOURCE_HANDLE, 'FontAwesomeConfig = { searchPseudoElements: true };', 'before' );
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
					// phpcs:ignore WordPress.WP.EnqueuedResourceParameters
					wp_enqueue_script( self::RESOURCE_HANDLE_V4SHIM, $resource_collection[1]->source(), null, null, false );

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
			// Look for unregistered clients.
			add_action(
				'wp_enqueue_scripts',
				function() use ( $obj, $remove_unregistered_clients ) {
					$obj->detect_unregistered_clients();
					if ( $remove_unregistered_clients ) {
						$obj->remove_unregistered_clients();
					}
				},
				15
			);

			do_action( 'font_awesome_enqueued', $load_spec );
		}

		// phpcs:ignore Generic.Commenting.DocComment.MissingShort
		/**
		 * @ignore
		 */
		protected function detect_unregistered_clients() {
			$wp_styles  = wp_styles();
			$wp_scripts = wp_scripts();

			$collections = array(
				'style'  => $wp_styles,
				'script' => $wp_scripts,
			);

			$this->unregistered_clients = array(); // re-initialize.

			foreach ( $collections as $key => $collection ) {
				foreach ( $collection->registered as $handle => $details ) {
					switch ( $handle ) {
						case self::RESOURCE_HANDLE:
						case self::RESOURCE_HANDLE_V4SHIM:
							break;
						default:
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
		 * must be enabled by the web site owner. However, if the web site owner does enable it, then the resulting
		 * `load_spec` will cause Pro to be loaded, and this will be indicated by the return value of {@see FontAwesome::using_pro()}.
		 * If you are shipping at theme or plugin for which you insist on being able to use Font Awesome Pro, your only
		 * option is to instruct your users to purchase and enable appropriate licenses of Font Awesome Pro for their
		 * websites.
		 *
		 * The shape of the `$client_requirements` array parameter looks like this:
		 * ```php
		 *   array(
		 *     'method'         => 'svg', // "svg" or "webfont"
		 *     'v4shim'         => 'require', // "require" or "forbid"
		 *     'pseudoElements' => 'require', // "require" or "forbid"
		 *     'version'        => '~5.5.0', // semver in the form of \Composer\Semver\Semver
		 *     'name'           => 'Foo Plugin' // (required)
		 *   )
		 * ```
		 *
		 * All requirement specifications are optional, except `name`. Any that are not specified will allow defaults,
		 * or the requirements of other registered clients to take precedence. The fewer requirements your client specifies,
		 * the easier it will be to settle a load specification without conflict.
		 *
		 * We use camelCase instead of snake_case for these keys, because they end up being passed via json
		 * to the JavaScript admin UI client and camelCase is preferred for object properties in JavaScript.
		 *
		 * @since 0.1.0
		 *
		 * @see FontAwesome::using_pro()
		 * @param array $client_requirements
		 * @throws InvalidArgumentException
		 */
		public function register( $client_requirements ) {
			/*
			 * TODO: consider using some other means of tracking the calling module, since phpcs complains
			 * that debug_backtrace is "debug" code.
			 */
			// phpcs:ignore WordPress.PHP.DevelopmentFunctions
			$bt     = debug_backtrace( 1 );
			$caller = array_shift( $bt );
			if ( ! array_key_exists( 'name', $client_requirements ) ) {
				throw new InvalidArgumentException( 'missing required key: name' );
			}
			$client_requirements['clientCallSite'] = array(
				'file' => $caller['file'],
				'line' => $caller['line'],
			);
			array_unshift( $this->client_requirements, $client_requirements );
		}
	}

endif; // ! class_exists

/**
 * Convenience global function to get a singleton instance of the Font Awesome plugin.
 *
 * @since 0.2.0
 *
 * @see FontAwesome::instance()
 * @returns FontAwesome
 */
function fa() {
	return FontAwesome::instance();
}

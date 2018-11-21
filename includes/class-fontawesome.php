<?php
/**
 * Main plugin module.
 *
 * @noinspection PhpIncludeInspection
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
	 */
	class FontAwesome {

		const OPTIONS_KEY                     = 'font-awesome-official';
		const ADMIN_USER_CLIENT_NAME_INTERNAL = 'user';
		const ADMIN_USER_CLIENT_NAME_EXTERNAL = 'You';
		const PLUGIN_NAME                     = 'font-awesome-official';
		const PLUGIN_VERSION                  = '0.1.0';
		const REST_API_VERSION                = '1';
		const REST_API_NAMESPACE              = self::PLUGIN_NAME . '/v' . self::REST_API_VERSION;
		const OPTIONS_PAGE                    = 'font-awesome-official';
		const RESOURCE_HANDLE                 = 'font-awesome-official';
		const RESOURCE_HANDLE_V4SHIM          = 'font-awesome-official-v4shim';

		const DEFAULT_USER_OPTIONS = array(
			'adminClientLoadSpec'       => array(
				'name' => self::ADMIN_USER_CLIENT_NAME_INTERNAL,
			),
			'usePro'                    => false,
			'removeUnregisteredClients' => false,
		);

		/**
		 * The single instance of the class.
		 */
		protected static $_instance = null;

		/**
		 * The list of client requirements.
		 */
		protected $reqs = array();

		/**
		 * The list of client requirement conflicts.
		 */
		protected $conflicts = null;

		/**
		 * The list of plugin version warnings.
		 */
		protected $plugin_version_warnings = null;

		/**
		 * The resulting load specification after settling all client requirements.
		 */
		protected $load_spec = null;

		/**
		 * The list of unregistered clients we've discovered.
		 * Empty by default.
		 */
		protected $unregistered_clients = array();

		protected $screen_id = null;

		/**
		 * Main FontAwesome Instance.
		 *
		 * Ensures only one instance of FontAwesome is loaded.
		 *
		 * @return FontAwesome|null
		 */
		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}

		/**
		 * Make constructor private so clients cannot instantiate this directly.
		 * Must use fa() or FontAwesome::instance()
		 */
		private function __construct() {
			/* noop */
		}

		/**
		 * Main entry point for running the plugin.
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
		 * @param string $constraints expressed as a constraint that can be understood by Composer\Semver\Semver
		 * @return bool
		 */
		public function satisfies( $constraints ) {
			return Semver::satisfies( self::PLUGIN_VERSION, $constraints );
		}

		/**
		 * Reports whether the currently loaded version of the Font Awesome plugin satisies the given constraints,
		 * and if not, it warns the WordPress admin in the admin dashboard in order to aid conflict diagnosis.
		 *
		 * @param string $constraint expressed as a constraint that can be understood by Composer\Semver\Semver
		 * @param string $name name to be displayed in admin notice if the loaded Font Awesome version does not satisfy the
		 *        given constraints.
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
									<b><?php esc_html( $name ); ?> </b><br/>
									It requires plugin version <?php esc_html( $constraint ); ?>
									but the currently loaded version of the Font Awesome plugin is
									<?php esc_html( self::PLUGIN_VERSION ); ?>.
								</p>
							</div>
							<?php
						}
					}
				);
				return false;
			}
		}

		private function initialize_rest_api() {
			add_action(
				'rest_api_init',
				array(
					new FontAwesome_Config_Controller( self::PLUGIN_NAME, self::REST_API_NAMESPACE ),
					'register_routes',
				)
			);
		}

		public function get_latest_version() {
			return fa_release_provider()->latest_minor_release();
		}

		public function get_latest_semver() {
			return( '~' . $this->get_latest_version() );
		}

		public function get_previous_version() {
			return fa_release_provider()->previous_minor_release();
		}

		public function get_previous_semver() {
			return ( '~' . $this->get_previous_version() );
		}

		public function get_available_versions() {
			return fa_release_provider()->versions();
		}

		private function settings_page_url() {
			return admin_url( 'options-general.php?page=' . self::OPTIONS_PAGE );
		}

		/**
		 * Retrieves the assets required to load the admin ui React app, based on
		 * whether we're running in development or production.
		 *
		 * @return array|mixed|null|object
		 * @throws \GuzzleHttp\Exception\GuzzleException
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
		 */
		public function options() {
			return wp_parse_args( get_option( self::OPTIONS_KEY ), self::DEFAULT_USER_OPTIONS );
		}

		public function create_admin_page() {
			include_once FONTAWESOME_DIR_PATH . 'admin/views/main.php';
		}

		/**
		 * Resets the singleton instance referenced by this class.
		 */
		public static function reset() {
			self::$_instance = null;
			return fa();
		}

		/**
		 * Main entry point for the loading process.
		 * Returns the enqueued load_spec if successful.
		 * Otherwise, returns null.
		 * If we already have a previously built load spec saved in options enqueue that without recomputing.
		 * Or pass in ['rebuild' => true] for $params to trigger a rebuild.
		 * If ['save' => true] and the rebuild is successful, then the rebuilt load spec will be
		 * saved as options in the db for use on the next load.
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

		/**
		 * Gathers all client requirements, invokes the core requirements resolution logic and emits admin UI
		 * notices about any conflicts.
		 *
		 * @param $options
		 * @return array|null
		 */
		// TODO: consider refactor and/or better distinguishing between this function and compute_load_spec.
		protected function build( $options ) {
			// Register the web site user/admin as a client.
			$this->register( $options['adminClientLoadSpec'] );

			// Now, ask any other listening clients to register.
			do_action( 'font_awesome_requirements' );
			// TODO: add some WP persistent cache here so we don't needlessly retrieve latest versions and re-process
			// all requirements each time. We'd only need to do that when something changes.
			// So what are those conditions for refreshing the cache?
			$load_spec = $this->compute_load_spec(
				function( $data ) {
					// This is the error callback function. It only runs when build_load_spec() needs to report an error.
					$this->conflicts = $data;
					// TODO: figure out the best way to present diagnostic information.
					// Probably in the error_log, but if we're on the admin screen, there's
					// probably a more helpful way to do it.
					$client_name_list = [];
					foreach ( $data['client-reqs'] as $client ) {
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
										<?php esc_html( implode( $client_name_list, ', ' ) ); ?>.
										To resolve these conflicts, <a href="<?php esc_html( $this->settings_page_url() ); ?>"> Go to Font Awesome Settings</a>.
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
		 * @return array | null
		 */
		public function conflicts() {
			return $this->conflicts;
		}

		/**
		 * Returns plugin version warnings.
		 *
		 * @return array | null
		 */
		public function get_plugin_version_warnings() {
			return $this->plugin_version_warnings;
		}

		/**
		 * Adds a plugin version warning.
		 *
		 * @param array $warning
		 */
		private function add_plugin_version_warning( $warning ) {
			if ( is_null( $this->plugin_version_warnings ) || ! is_array( $this->plugin_version_warnings ) ) {
				$this->plugin_version_warnings = [];
			}
			array_push( $this->plugin_version_warnings, $warning );
		}

		/**
		 * Return current client requirements.
		 */
		public function requirements() {
			return $this->reqs;
		}

		/**
		 * Return list of found unregistered clients.
		 */
		public function unregistered_clients() {
			$this->detect_unregistered_clients();
			return $this->unregistered_clients;
		}

		/**
		 * Return current load specification, which may be null if has been settled.
		 * If it is still null and $this->coflicts() is not null, that means the load failed.
		 */
		public function load_spec() {
			return $this->load_spec;
		}

		/**
		 * Builds the loading specification based on all registered requirements.
		 * Returns the load spec if a valid one can be computed, else it returns null
		 *   after invoking the error_callback function.
		 *
		 * @param callable $error_callback
		 * @return array|null
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
			foreach ( $this->reqs as $req ) {
				$clients[ $req['name'] ] = $req['client-call'];
				// For this set of requirements, iterate through each requirement key, like ['method', 'v4shim', ... ].
				foreach ( $req as $key => $payload ) {
					if ( in_array( $key, [ 'client-call', 'name' ], true ) ) {
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
						if ( array_key_exists( 'client-reqs', $load_spec[ $key ] ) ) {
							array_unshift( $load_spec[ $key ]['client-reqs'], $req );
						} else {
							$load_spec[ $key ]['client-reqs'] = array( $req );
						}
						$resolved_req = $load_spec[ $key ]['resolve']($load_spec[ $key ]['value'], $req[ $key ]);
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
						$load_spec[ $key ]['value']       = $req[ $key ];
						$load_spec[ $key ]['client-reqs'] = [ $req ];
					}
				}
			}

			if ( $bail_early_req ) {
				// call the error_callback, indicating which clients registered incompatible requirements.
				is_callable( $error_callback ) && $error_callback(
					array(
						'req'         => $bail_early_req,
						'client-reqs' => $load_spec[ $bail_early_req ]['client-reqs'],
					)
				);
				return null;
			}

			/*
			 * This is a good place to set defaults
			 * pseudoElements: when webfonts, true
			 * when svg, false
			 */
			// TODO: should this be set up in the initial load_spec before, or must it be set at the end of the process here?
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
				// TODO: we probably need a mechanism for passing such warnings up to the admin UI.
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

		protected function is_pro_configured() {
			$options = $this->options();
			return( wp_validate_boolean( $options['usePro'] ) );
		}

		/**
		 * Convenience method. Returns boolean value indicating whether the current load specification
		 * includes Pro. Should only be used after loading is complete.
		 */
		public function using_pro() {
			$load_spec = $this->load_spec();
			return isset( $load_spec['usePro'] ) && $load_spec['usePro'];
		}

		/**
		 * Convenience method. Returns boolean value indicating whether the current load specification
		 * includes support for pseudoElements. Should only be used after loading is complete.
		 */
		public function using_pseudo_elements() {
			$load_spec = $this->load_spec();
			return isset( $load_spec['pseudoElements'] ) && $load_spec['pseudoElements'];
		}

		protected function specified_requirement_or_default( $req, $default ) {
			return array_key_exists( 'value', $req ) ? $req['value'] : $default;
		}

		/**
		 * Given a loading specification, enqueues Font Awesome to load accordingly.
		 * Returns nothing.
		 * removeUnregisteredClients (boolean): whether to attempt to dequeue unregistered clients.
		 *
		 * @param $load_spec
		 * @param bool      $remove_unregistered_clients
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

		/**
		 * Cleans and re-populates $this->unregistered_clients() after searching through $wp_styles and $wp_scripts
		 * Returns nothing
		 */
		protected function detect_unregistered_clients() {
			global $wp_styles;
			global $wp_scripts;

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
		 * Registers client requirements.
		 *
		 * Keys for the $client_requirements array:
		 *   method: 'webfont' or 'svg'
		 *   v4shim: 'require' or 'forbid'
		 *   pro: 'require' or 'forbid'
		 *   pseudoElements: 'require' or 'forbid'
		 *   version: a semver string such as '5.0.13' for a precise version, or '~5.1'
		 *   name: 'clientA' (required)
		 *
		 * We use camelCase instead of snake_case for these keys, because they end up being passed via json
		 * to the JavaScript admin UI client and camelCase is preferred for object properties in JavaScript.
		 *
		 * @param $client_requirements
		 * @throws InvalidArgumentException
		 */
		// TODO: add more comprehensive PhpDoc for this function and the options.
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
			$client_requirements['client-call'] = array(
				'file' => $caller['file'],
				'line' => $caller['line'],
			);
			array_unshift( $this->reqs, $client_requirements );
		}
	}


endif; // ! class_exists

/**
 * Main instance of Font Awesome.
 *
 * Returns the main instance of Font Awesome.
 *
 * @returns FontAwesome
 */
function fa() {
	return FontAwesome::instance();
}

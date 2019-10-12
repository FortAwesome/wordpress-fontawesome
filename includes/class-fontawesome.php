<?php
namespace FortAwesome;

use \Exception, \Error, \InvalidArgumentException, \DateTime, \DateInterval, \DateTimeInterface, \DateTimeZone;

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
require_once trailingslashit( FONTAWESOME_DIR_PATH ) . 'includes/class-fontawesome-preference-conflict-detector.php';
require_once trailingslashit( FONTAWESOME_DIR_PATH ) . 'includes/class-fontawesome-preference-check-controller.php';
require_once trailingslashit( FONTAWESOME_DIR_PATH ) . 'includes/class-fontawesome-conflict-detection-controller.php';
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
	 * - `font_awesome_preferences`
	 *
	 *   Fired when the plugin is ready for clients to register their preferences.
	 *
	 *   Client plugins and themes should normally use this action hook to call {@see FontAwesome::register()}
	 *   with their preferences.
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
	 *     - {@see FontAwesome::pro()} to discover whether a version with Pro icons is being loaded
	 *     - {@see FontAwesome::svg_pseudo_elements()} to discover whether Font Awesome is being loaded with support for svg pseudo-elements
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
		 * Key where this plugin's saved options data are stored in the WordPress options table.
		 *
		 * @since 4.0.0
		 */
		const OPTIONS_KEY = 'font-awesome';
		/**
		 * Key where this plugin stores metadata about detected unregistered clients in the WordPress options table.
		 *
		 * @since 4.0.0
		 */
		const UNREGISTERED_CLIENTS_OPTIONS_KEY = 'font-awesome-unregistered-clients';
		// phpcs:ignore Generic.Commenting.DocComment.MissingShort
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
		 * The handle used when enqueuing the v4shim.
		 *
		 * @since 4.0.0
		 */
		const RESOURCE_HANDLE_V4SHIM = 'font-awesome-official-v4shim';

		/**
		 * The handle used when enqueuing the conflict detector.
		 *
		 * @since 4.0.0
		 */
		const RESOURCE_HANDLE_CONFLICT_DETECTOR = 'font-awesome-official-conflict-detector';

		/**
		 * The handle used when enqueuing the conflict detector.
		 *
		 * @since 4.0.0
		 */
		const RESOURCE_HANDLE_CONFLICT_DETECTION_REPORTER = 'font-awesome-official-conflict-detection-reporter';

		/**
		 * The source URL for the conflict detector, a feature introduced in Font Awesome 5.10.0.
		 *
		 * @since 4.0.0
		 */
		const CONFLICT_DETECTOR_SOURCE = 'https://use.fontawesome.com/releases/v5.11.2/js/conflict-detection.js';

		/**
		 * The custom data attribute added to script, link, and style elements enqueued
		 * by this plugin when conflict detection is enabled, in order for them to be
		 * ignored by the conflict detector.
		 *
		 * @since 4.0.0
		 */
		const CONFLICT_DETECTION_IGNORE_ATTR = "data-fa-detection-ignore";

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
		 * We will not use a default for version, since we want the version stored in the options
		 * to always be resolved to an actual version number, which requires that the release
		 * provider successfully runs at least once. We'll do that upon plugin activation.
		 *
		 * @ignore
		 */
		const DEFAULT_USER_OPTIONS = array(
			'usePro'               => false,
			'v4compat'             => true,
			'technology'           => 'webfont',
			'svgPseudoElements'    => false,
			'detectConflictsUntil' => null,
			'blacklist'            => array()
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
		protected $client_preferences = array();

		// phpcs:ignore Generic.Commenting.DocComment.MissingShort
		/**
		 * @ignore
		 */
		protected $conflicts_by_client = null;

		// phpcs:ignore Generic.Commenting.DocComment.MissingShort
		/**
		 * @ignore
		 */
		protected $plugin_version_warnings = null;

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
		 * Main entry point for running the plugin. Called automatically when the plugin is loaded.
		 *
		 * Internal only. Clients should * not invoke it directly.
		 *
		 * @internal
		 * @ignore
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
						$options = $this->options();

						$resource_collection = fa()
							->release_provider()
							->get_resource_collection(
								$options['version'],
								'all',
								array(
									'use_pro'  => $this->pro(),
									'use_svg'  => 'svg' === $this->technology(),
									'use_shim' => $this->v4_compatibility(),
								)
							);

						$this->enqueue_cdn( $options, $resource_collection );
					} catch ( FontAwesome_NoReleasesException $e ) {
						$current_screen = get_current_screen();
						if ( $current_screen && $current_screen->id !== $this->screen_id ) {
							// Don't put up an admin notice on our plugin's admin screen, since it will be redundant.
							font_awesome_handle_fatal_error(
								'Sorry, your WordPress server was unable to contact the Font Awesome server to retrieve available ' .
								'releases data. Most likely, just re-loading this page to get it try again should work. But if you\'re running ' .
								'WordPress offline, from an airplane, or in some other way that blocks your WordPress server from reaching ' .
								'fontawesome.com, then that will block you from proceeding until you can connect successfully.'
							);
						}
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
		 * Reports whether the given $version satisfies the given $constraints.
		 *
		 * It's really just a generalized utility function, instead of incorporating a full-blown semver library.
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
		 * ...mean: "assert that the given $version is greater than or equal 1.0.0 AND strictly less than 2.0.0"
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
		public static function satisfies( $version, $constraints ) {
			$valid_operators = [ '<', 'lt', '<=', 'le', '>', 'gt', '>=', 'ge', '==', '=', 'eq', '!=', '<>', 'ne' ];

			if ( ! is_array( $constraints ) ) {
				throw new InvalidArgumentException( 'constraints argument must be an array of constraints' );
			}
			$result_so_far = true;
			foreach ( $constraints as $constraint ) {
				if ( ! is_array( $constraint ) || 2 !== count( $constraint ) || false === array_search( $constraint[1], $valid_operators, true ) ) {
					throw new InvalidArgumentException( 'each constraint must be an array of [ version, operator ] compatible with PHP\'s version_compare' );
				}
				if ( ! version_compare( $version, $constraint[0], $constraint[1] ) ) {
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
		 * callback on the `font_awesome_preferences` action hook.
		 *
		 * The shape of the `$constraints` argument is the same as for {@see FortAwesome\FontAwesome::satisfies()}.
		 *
		 * For example:
		 * ```php
		 * add_action(
		 *   'font_awesome_enqueued',
		 *   function() {
		 *     FortAwesome\fa()->plugin_version_satisfies_or_warn( [['4.0.0', '>=']], 'Theta' );
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
		public function plugin_version_satisfies_or_warn( $constraints, $name ) {
			if ( self::satisfies( $this->plugin_version(), $constraints ) ) {
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

		/**
		 * Returns boolean indicating whether the plugin's options are currently set
		 * to detect conflicts.
		 *
		 * @since 4.0.0
		 *
		 * @return bool
		 */
		public function detecting_conflicts() {
			$until = $this->options()['detectConflictsUntil'];
			$until_date_time = is_string($until)
				? DateTime::createFromFormat(DateTimeInterface::ATOM, $until)
				: null;
			$interval = $until_date_time
				? $until_date_time->diff(new DateTime('now', new DateTimeZone('UTC')))
				: null;

			if ( $interval && $interval->invert == 1 ) {
				return true;
			} else {
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
					new FontAwesome_Preference_Check_Controller( self::PLUGIN_NAME, self::REST_API_NAMESPACE ),
					'register_routes',
				)
			);
			add_action(
				'rest_api_init',
				array(
					new FontAwesome_Conflict_Detection_Controller( self::PLUGIN_NAME, self::REST_API_NAMESPACE ),
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

						$url = $this->get_webpack_asset_url('admin.js');

						wp_enqueue_script( self::ADMIN_RESOURCE_HANDLE, $url, [], null, true );
						wp_localize_script(
							self::ADMIN_RESOURCE_HANDLE,
							'wpFontAwesomeOfficial',
							array(
								'api_nonce' => wp_create_nonce( 'wp_rest' ),
								'api_url'   => rest_url( self::REST_API_NAMESPACE ),
							)
						);
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

					$alert_count = $count_plugin_version_warnings + count( $this->conflicts_by_option() );

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
		 * @internal
		 * @ignore
		 * @return array
		 */
		public function options() {
			$options = get_option( self::OPTIONS_KEY );
			return $this->convert_options( $options );
		}

		/**
		 * Converts options array from a previous schema version to the current one.
		 *
		 * @internal
		 * @ignore
		 * @param $options
		 * @return array
		 */
		public function convert_options( $options ) {
			if ( isset( $options['lockedLoadSpec'] ) ) {
				// v1 schema.
				return $this->convert_options_from_v1( $options );
			} else {
				// Nothing to convert.
				return $options;
			}
		}

		/**
		 * md5 hashes that represent detections of conflicting loads of Font Awesome
		 * that the administrator has chosen to blacklist, causing the styles and
		 * scripts associated with these md5 hashes to be dequeued by this plugin.
		 * 
		 * @since 4.0.0
		 * @return array
		 */
		public function blacklist() {
			return $this->options()['blacklist'];
		}

		/**
		 * Converts a given options array with a v1 schema to one with a v2 schema.
		 * There are significant changes from the schema used by 4.0.0-rc9 and before.
		 *
		 * @internal
		 * @ignore
		 * @param $options
		 * @return array
		 */
		protected function convert_options_from_v1( $options ) {
			$converted_options = self::DEFAULT_USER_OPTIONS;

			if ( isset( $options['usePro'] ) ) {
				$converted_options['usePro'] = $options['usePro'];
			}

			if ( isset( $options['version'] ) ) {
				$converted_options['version'] = $options['version'];
			}

			if ( isset( $options['lockedLoadSpec'] ) ) {
				$converted_options['technology'] = $options['lockedLoadSpec']['method'];

				$converted_options['svgPseudoElements'] = 'svg' === $options['lockedLoadSpec']['method']
					&& $options['lockedLoadSpec']['pseudoElements'];

				$converted_options['v4compat'] = $options['lockedLoadSpec']['v4shim'];
			} elseif ( isset( $options['adminClientLoadSpec'] ) ) {
				$converted_options['technology'] = $options['adminClientLoadSpec']['method'];

				$converted_options['svgPseudoElements'] = 'svg' === $options['adminClientLoadSpec']['method']
					&& $options['adminClientLoadSpec']['pseudoElements'];

				$converted_options['v4compat'] = $options['adminClientLoadSpec']['v4shim'];
			}

			return $converted_options;
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
		 * Triggers the font_awesome_preferences action to gather preferences from clients.
		 *
		 * @since 4.0.0
		 */
		public function gather_preferences() {
			/**
			 * Fired when the plugin is ready for clients to register their preferences.
			 *
			 * Clients should call {@see FontAwesome::register()} and {@see FontAwesome::plugin_version_satisfies_or_warn()}
			 * from a callback registered on this hook.
			 *
			 * @since 4.0.0
			 */
			do_action( 'font_awesome_preferences' );
		}

		/**
		 * Returns current preferences conflicts, keyed by option name.
		 *
		 * Should normally only be called after the `font_awesome_enqueued` action has triggered, indicating that all
		 * client preferences have been registered and processed.
		 *
		 * The returned array includes all conflicts between the options configured for this plugin by the site owner
		 * and any preferences registered by themes or plugins.
		 *
		 * The presence of conflicts will not stop this plugin from loading Font Awesome according to its
		 * configured options, but they will be presented to the site owner in the plugin's admin settings page to
		 * aid in troubleshooting.
		 *
		 * @since 4.0.0
		 *
		 * @param $options options to use for comparison. Uses $this->options() by default.
		 * @see FontAwesome::register() register() documents all client preference keys
		 * @return array
		 */
		public function conflicts_by_option( $options = null ) {
			$conflicts = array();

			$options_for_comparison = is_null( $options ) ? $this->options() : $options;

			foreach ( $this->conflicts_by_client( $options_for_comparison ) as $client_name => $client_conflicts ) {
				foreach ( $client_conflicts as $conflicted_option ) {
					// Initialize the key with an empty array if it doesn't already have something in it.
					$conflicts[ $conflicted_option ] = isset( $conflicts[ $conflicted_option ] )
						? $conflicts[ $conflicted_option ]
						: array();

					// Push the current client onto that array.
					array_push( $conflicts[ $conflicted_option ], $client_name );
				}
			}

			return $conflicts;
		}

		/**
		 * Returns current preferences conflicts, keyed by client name.
		 *
		 * Should normally only be called after the `font_awesome_enqueued` action has triggered, indicating that all
		 * client preferences have been registered and processed.
		 *
		 * The returned array includes all conflicts between the given options and any preferences registered
		 * by themes or plugins.
		 *
		 * The presence of conflicts will not stop this plugin from loading Font Awesome according to its
		 * configured options, but they will be presented to the site owner in the plugin's admin settings page to
		 * aid in troubleshooting.
		 *
		 * @since 4.0.0
		 *
		 * @param $options options to use for comparison. Uses $this->options() by default.
		 * @see FontAwesome::register() register() documents all client preference keys
		 * @return array
		 */
		public function conflicts_by_client( $options = null ) {
			if ( is_null( $this->conflicts_by_client ) ) {
				$conflicts = array();

				$options_for_comparison = is_null( $options ) ? $this->options() : $options;

				foreach ( $this->client_preferences as $client_name => $client_preferences ) {
					$current_conflicts = FontAwesome_Preference_Conflict_Detector::detect(
						$options_for_comparison,
						$client_preferences
					);
					if ( count( $current_conflicts ) > 0 ) {
						$conflicts[ $client_name ] = $current_conflicts;
					}
				}

				$this->conflicts_by_client = $conflicts;

				return $conflicts;
			} else {
				return $this->conflicts_by_client;
			}
		}

		/**
		 * Returns plugin version warnings.
		 *
		 * These are the warnings that would be reported in the admin UI as a result of clients calling
		 * {@see FortAwesome\FontAwesome::plugin_version_satisfies_or_warn()}.
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
		 * Return current client preferences for all registered clients.
		 *
		 * The website owner (i.e. the one who uses the WordPress admin dashboard) is considered a registered client.
		 * So that owner's preferences will be represented here. But note that these preferences do not include
		 * the `options`, as returned by {@see FortAwesome\FontAwesome::options()} which also help determine the
		 * final result of how the Font Awesome assets are loaded.
		 *
		 * Each element of the array has the same shape as the preferences given to {@see FortAwesome\FontAwesome::register()}.
		 *
		 * @since 4.0.0
		 *
		 * @see FortAwesome\FontAwesome::register()
		 * @return array
		 */
		public function client_preferences() {
			return $this->client_preferences;
		}

		/**
		 * Return unregistered clients that have been detected and stored in the WordPress db.
		 *
		 * Unregistered clients are those for which the in-browser conflict detector
		 * detects the presence of a Font Awesome version that is not being loaded by
		 * this plugin, and therefore is likely causing a conflict.
		 *
		 * Client-side conflict detection is enabled in this plugin's setting page in WP admin.
		 *
		 * @since 4.0.0
		 *
		 * @return array
		 */
		public function unregistered_clients() {
			$unregistered_clients = get_option( self::UNREGISTERED_CLIENTS_OPTIONS_KEY );
			return is_array( $unregistered_clients ) ? $unregistered_clients : array();
		}

		/**
		 * Indicates whether Font Awesome Pro is being loaded.
		 *
		 * It's a handy way to toggle the use of Pro icons in client theme or plugin template code.
		 *
		 * @since 4.0.0
		 * @throws FontAwesome_NoReleasesException
		 *
		 * @return boolean
		 */
		public function pro() {
			try {
				$options = $this->options();
				return( wp_validate_boolean( $options['usePro'] ) );
			} catch ( FontAwesome_NoReleasesException $e ) {
				return self::DEFAULT_USER_OPTIONS['usePro'];
			}
		}

		/**
		 * Indicates which Font Awesome technology is configured: 'webfont' or 'svg'.
		 *
		 * @since 4.0.0
		 *
		 * @return string
		 */
		public function technology() {
			$options = $this->options();
			return isset( $options['technology'] ) ? $options['technology'] : null;
		}

		/**
		 * Reports the version of Font Awesome assets being loaded.
		 *
		 * Your theme or plugin should probably query this in order to determine whether all of the icons used in your
		 * templates will be available, especially if you tend to use newer icons. It should be really easy
		 * for site owners to update to a new Font Awesome version to accommodate your templates--just a simple dropdown
		 * selection on the Font Awesome plugin options page. But you might need to show an admin notice to nudge
		 * them to do so if you detect that the current version of Font Awesome being loaded is older than you'd like.
		 *
		 * @since 4.0.0
		 *
		 * @return string
		 */
		public function version() {
			return $this->options()['version'];
		}

		/**
		 * Indicates whether Font Awesome is being loaded with version 4 compatibility.
		 *
		 * Its result is valid only after the `font_awesome_enqueued` has been triggered.
		 *
		 * @since 4.0.0
		 *
		 * @return boolean
		 */
		public function v4_compatibility() {
			$options = $this->options();
			return isset( $options['v4compat'] ) ? boolval( $options['v4compat'] ) : self::DEFAULT_USER_OPTIONS['v4compat'];
		}

		/**
		 * Indicates whether Font Awesome is being loaded with support for SVG pseudo-elements.
		 *
		 * Its results are only valid after the `font_awesome_enqueued` action has been triggered.
		 * Its value is irrelevant if technology() === 'webfont'.
		 *
		 * There are known performance problems with this combination, but it is provided for added
		 * compatibility where pseudo-elements must be used.
		 *
		 * Pseudo-elements are always inherently supported by the webfont technology.
		 *
		 * @since 4.0.0
		 *
		 * @return boolean
		 */
		public function svg_pseudo_elements() {
			$options = $this->options();
			return isset( $options['svgPseudoElements'] )
					? boolval( $options['svgPseudoElements'] )
					: self::DEFAULT_USER_OPTIONS['svgPseudoElements'];
		}

		// phpcs:ignore Generic.Commenting.DocComment.MissingShort
		/**
		 * @ignore
		 */
		protected function specified_preference_or_default( $preference, $default ) {
			return array_key_exists( 'value', $preference ) ? $preference['value'] : $default;
		}

		/**
		 * Enqueues <script> or <link> resources to load from Font Awesome 5 free or pro cdn.
		 *
		 * @internal
		 * @ignore
		 * @param $options
		 * @param FontAwesome_ResourceCollection $resource_collection
		 * @throws InvalidArgumentException
		 */
		public function enqueue_cdn( $options, $resource_collection ) {
			if ( ! array_key_exists( 'svgPseudoElements', $options ) ) {
				throw new InvalidArgumentException( 'missing required options key: svgPseudoElements' );
			}

			if ( ! array_key_exists( 'usePro', $options ) ) {
				throw new InvalidArgumentException( 'missing required options key: usePro' );
			}

			if ( ! array_key_exists( 'version', $options ) ) {
				throw new InvalidArgumentException( 'missing required options key: version' );
			}

			if ( ! ( array_key_exists( 'technology', $options ) && ( 'svg' === $options['technology'] || 'webfont' === $options['technology'] ) ) ) {
				throw new InvalidArgumentException( 'missing required options key: technology, which must equal either svg or webfont' );
			}

			$resources = $resource_collection->resources();

			if ( $this->detecting_conflicts() && current_user_can( 'manage_options' ) ) {
				$conflict_detection_url = $this->get_webpack_asset_url('conflictDetection.js');
				$prev_unregistered_clients = $this->unregistered_clients();
				$settings_page_url = $this->settings_page_url();

				// Enqueue the conflict detector
				foreach ( [ 'wp_enqueue_scripts', 'admin_enqueue_scripts', 'login_enqueue_scripts' ] as $action ) {
					add_action(
						$action,
						function () use ( $conflict_detection_url, $prev_unregistered_clients, $settings_page_url ) {
							// phpcs:ignore WordPress.WP.EnqueuedResourceParameters
							wp_enqueue_script(
								self::RESOURCE_HANDLE_CONFLICT_DETECTION_REPORTER,
								$conflict_detection_url,
								null,
								null,
								false
							);

							wp_localize_script(
								self::RESOURCE_HANDLE_CONFLICT_DETECTION_REPORTER,
								'wpFontAwesomeOfficialConflictReporting',
								array(
									'apiNonce'                => wp_create_nonce( 'wp_rest' ),
									'apiUrl'                  => rest_url( self::REST_API_NAMESPACE ) . '/report-conflicts',
									'prevUnregisteredClients' => $prev_unregistered_clients,
									'settingsPageUrl'         => $settings_page_url,
								)
							);

							// phpcs:ignore WordPress.WP.EnqueuedResourceParameters
							wp_enqueue_script(
								self::RESOURCE_HANDLE_CONFLICT_DETECTOR,
								self::CONFLICT_DETECTOR_SOURCE,
								[ self::RESOURCE_HANDLE_CONFLICT_DETECTION_REPORTER ],
								null,
								false
							);
						}
					);
				}

				add_filter(
					'style_loader_tag',
					function( $html, $handle ) {
						if ( in_array( $handle, [ self::RESOURCE_HANDLE, self::RESOURCE_HANDLE_V4SHIM ], true ) ) {
							return preg_replace(
								'/<link[\s]+(.*?)>/',
								"<link " . self::CONFLICT_DETECTION_IGNORE_ATTR . ' \1>',
								$html,
								1
							);
						} else {
							return $html;
						}
					},
					11, // later than the integrity and crossorigin attr filter.
					2
				);

				add_filter(
					'script_loader_tag',
					function ( $html, $handle ) {
						if ( in_array( $handle, [ self::RESOURCE_HANDLE, self::RESOURCE_HANDLE_V4SHIM, self::RESOURCE_HANDLE_CONFLICT_DETECTOR, self::RESOURCE_HANDLE_CONFLICT_DETECTION_REPORTER ], true ) ) {
							 return preg_replace(
								'/<script[\s]+(.*?)>/',
								"<script " . self::CONFLICT_DETECTION_IGNORE_ATTR . ' \1>',
								$html,
							);
						} else {
							return $html;
						}
					},
					11, // later than the integrity and crossorigin attr filter.
					2
				);
			}

			if ( 'webfont' === $options['technology'] ) {
				add_action(
					'wp_enqueue_scripts',
					function () use ( $resources ) {
						// phpcs:ignore WordPress.WP.EnqueuedResourceParameters
						wp_enqueue_style( self::RESOURCE_HANDLE, $resources[0]->source(), null, null );
					}
				);

				// Filter the <link> tag to add the integrity and crossorigin attributes for completeness.
				add_filter(
					'style_loader_tag',
					function( $html, $handle ) use ( $resources ) {
						if ( in_array( $handle, [ self::RESOURCE_HANDLE ], true ) ) {
									return preg_replace(
										'/\/>$/',
										'integrity="' . $resources[0]->integrity_key() .
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

				if ( ! array_key_exists( 'v4compat', $options ) ) {
					throw new InvalidArgumentException( 'missing required options key: v4compat' );
				}

				$version = $resource_collection->version();

				if ( $options['v4compat'] ) {
					/**
					 * Enqueue v4 compatibility as late as possible, though still within the normal script enqueue hooks.
					 * We need the @font-face override, especially to appear after any unregistered loads of Font Awesome
					 * that may try to declare a @font-face with a font-family of "FontAwesome".
					 */
					foreach ( [ 'wp_enqueue_scripts', 'admin_enqueue_scripts', 'login_enqueue_scripts' ] as $action ) {
						add_action(
							$action,
							function () use ( $resources, $options, $version ) {
								// phpcs:ignore WordPress.WP.EnqueuedResourceParameters
								wp_enqueue_style( self::RESOURCE_HANDLE_V4SHIM, $resources[1]->source(), null, null );
							
								$license_subdomain = boolval( $options['usePro'] ) ? 'pro' : 'use';

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
					if ( ! is_null( $resources[1]->integrity_key() ) ) {
						add_filter(
							'style_loader_tag',
							function ( $html, $handle ) use ( $resources ) {
								if ( in_array( $handle, [ self::RESOURCE_HANDLE_V4SHIM ], true ) ) {
									return preg_replace(
										'/\/>$/',
										'integrity="' . $resources[1]->integrity_key() .
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
						function () use ( $resources, $options ) {
							// phpcs:ignore WordPress.WP.EnqueuedResourceParameters
							wp_enqueue_script( self::RESOURCE_HANDLE, $resources[0]->source(), null, null, false );

							if ( $options['svgPseudoElements'] ) {
								wp_add_inline_script( self::RESOURCE_HANDLE, 'FontAwesomeConfig = { searchPseudoElements: true };', 'before' );
							}
						}
					);
				}

				// Filter the <script> tag to add additional attributes for integrity, crossorigin, defer.
				add_filter(
					'script_loader_tag',
					function ( $tag, $handle ) use ( $resources ) {
						if ( in_array( $handle, [ self::RESOURCE_HANDLE ], true ) ) {
							$extra_tag_attributes = 'defer crossorigin="anonymous"';

							if ( ! is_null( $resources[0]->integrity_key() ) ) {
								$extra_tag_attributes .= ' integrity="' . $resources[0]->integrity_key() . '"';
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

				if ( $options['v4compat'] ) {
					foreach ( [ 'wp_enqueue_scripts', 'admin_enqueue_scripts', 'login_enqueue_scripts' ] as $action ) {
						add_action(
							$action,
							function () use ( $resources ) {
								// phpcs:ignore WordPress.WP.EnqueuedResourceParameters
								wp_enqueue_script( self::RESOURCE_HANDLE_V4SHIM, $resources[1]->source(), null, null, false );
							}
						);
					}

					add_filter(
						'script_loader_tag',
						function ( $tag, $handle ) use ( $resources ) {
							if ( in_array( $handle, [ self::RESOURCE_HANDLE_V4SHIM ], true ) ) {
								$extra_tag_attributes = 'defer crossorigin="anonymous"';
								if ( ! is_null( $resources[1]->integrity_key() ) ) {
									$extra_tag_attributes .= ' integrity="' . $resources[1]->integrity_key() . '"';
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
			 * We need to remove unregistered clients *after* they would have been enqueued, if they used
			 * the recommended mechanism of wp_enqueue_style and wp_enqueue_script (or the admin equivalents).
			 * The wp_print_styles action hook is fired after the wp_enqueue_scripts hook
			 * (admin_print_styles after admin_enqueue_scripts).
			 * We'll use priority 0 in an effort to be as early as possible, to prevent any unregistered client
			 * from actually being printed to the head.
			 */
			foreach ( [ 'wp_print_styles', 'admin_print_styles', 'login_head' ] as $action ) {
				add_action(
					$action,
					function() use ( $obj ) {
						$obj->remove_blacklist();
					},
					0
				);
			}

			/**
			 * Fired when the plugin has enqueued a version of Font Awesome. Callback functions on this action
			 * will be able to query the various accessor methods on the FontAwesome object to discover that configuration.
			 *
			 * @since 4.0.0
			 */
			do_action( 'font_awesome_enqueued' );
		}

		/**
		 * This function is not part of this plugin's public API.
		 *
		 * @ignore
		 * @internal
		 */
		public function is_url_blacklisted($url) {
		  return FALSE !== array_search( md5($url), $this->blacklist() );
		}

		/**
		 * This function is not part of this plugin's public API.
		 *
		 * @ignore
		 * @internal
		 */
		public function is_inline_data_blacklisted($data) {
			/**
			 * As of WordPress 5.2.2, both WP_Styles::print_inline_style and WP_Scripts::print_inline_script
			 * join (implode) the set of 'before' or 'after' resources with a newline, and then wrap the whole
			 * thing in newlines when printing the <style> or <script> tag. So that's how we'll have to
			 * reconstruct those inline resources here in order to produce the same input for the md5 function
			 * that would have been used by the Conflict Detector in the browser.
			 * 
			 * Since this newline handling is not documenting as part of the spec, we're admittedly at some risk
			 * of this changing out from under us. At worst, if that implementation detail changes, it
			 * will just mean that we get a false negative when matching for blacklisted elements.
			 * Nothing will crash, but a conflict that we'd intended to catch will
			 * have slipped through. Our automated test suite should catch this, though.
			 */
			if ( $data && is_array($data) && count($data) > 0 ) {
			  return FALSE !== array_search( md5("\n" . implode("\n", $data) . "\n"), $this->blacklist() );
			} else {
				return FALSE;
			}
		}		

		/**
		 * For each handle, we need to check whether there's a conflict for the base resource itself,
		 * on its "src" attribute (the URL of an external script or stylesheet).
		 * We also need to check the 'before' and 'after' data for every resource to see if it has
		 * any inline style or script data associated with it. For our purposes, these are independent potential
		 * sources of conflict. In other words, the Conflict Detector reports md5 checksums for every external
		 * or inline style and script without reference to each other. So the only way we can know that we've
		 * found all of the conflicts is to make sure that we've inspected all of the inline styles and scripts.
		 * And the only way we can know that we've done that is to look at all of the 'before' and 'after' data
		 * for every resource.
		 *
		 * If we dequeue the main asset, then it automatically gets rid of any associated inline styles or scripts,
		 * so we can skip looking for those. Hopefully, it's a rare-to-never case that there's a conflict
		 * with the main resource AND something we need to keep in that resource's "before" or "after" extras.
		 * In that case, removal of the main resource will be too greedy / aggressive. We seem to be
		 * at the mercy of how WordPress handles inline styles and scripts--that is, inline styles
		 * or scripts are always added to some other "main" asset which has its own resource handle.
		 * 
		 * @ignore
		 */
		protected function remove_blacklist() {
			if( count( $this->blacklist() ) == 0 ) {
				return;
			}

			$wp_styles  = wp_styles();
			$wp_scripts = wp_scripts();

			$collections = array(
				'style'  => $wp_styles,
				'script' => $wp_scripts,
			);

			foreach ( $collections as $type => $collection ) {
				foreach ( $collection->registered as $handle => $details ) {
					foreach ( [ 'before', 'after' ] as $position ) {
						$data = $collection->get_data($handle, $position);
						if( $this->is_inline_data_blacklisted($data) ) {
							unset( $collection->registered[$handle]->extra[$position] );
						}
					}

					if ( $this->is_url_blacklisted($details->src) ) {
						call_user_func("wp_dequeue_$type", $handle );
					}
				}
			}
		}

		/**
		 * Registers client preferences. This is the "front door" for registered clients—themes or plugins—that depend
		 * upon this Font Awesome plugin to load a compatible version of Font Awesome.
		 *
		 * The shape of the `$client_preferences` array parameter looks like this:
		 * ```php
		 *   array(
		 *     'technology'        => 'svg', // "svg" or "webfont"
		 *     'v4compat'          => true, // true or false
		 *     'svgPseudoElements' => false, // true or false
		 *     'name'              => 'Foo Plugin', // (required, but the name in @see FontAwesome::ADMIN_USER_CLIENT_NAME_INTERNAL is reserved)
		 *   )
		 * ```
		 *
		 * We use camelCase instead of snake_case for these keys, because they end up being passed via json
		 * to the JavaScript admin UI client and camelCase is preferred for object properties in JavaScript.
		 *
		 * All preference specifications are optional, except `name`. Any that are not specified will allow defaults,
		 * or the preferences of other registered clients to take precedence.
		 * Only the WordPress site owner can *determine* the Font Awesome configuration, using the plugin's admin
		 * settings page. But plugin or theme developers can provide hints to the site owner as to their preferred
		 * configurations by setting those preferences during registration. When site owners selection configuration
		 * options that conflict with those preferences, they'll be shown a warning. Hopefully, they'll be able to
		 * set a configuration that satisfies their theme and any plugins that rely upon this plugin for loading
		 * Font Awesome. However, similar to writing mobile responsive code where you don't control the size
		 * of display, but can detect the screen size and adapt, here too, theme and plugin developers do not
		 * control the Font Awesome environment but should be prepared to adapt.
		 *
		 * This plugin gives you a structured API for discovering with those configured options are so you can
		 * be sure that Font Awesome is loaded, and can adapt to any configuration differences, or possibly issue
		 * your own admin notices to the site owner as may be appropriate.
		 *
		 * <h3>Adapting Your Code to the given Font Awesome environment</h3>
		 *
		 * Here's a quick adaptability checklist:
		 *
		 * - Make sure your plugin or theme works just as well with either webfont or svg methods.
		 * - Update your icon references to use version 5 names so no {@link https://fontawesome.com/how-to-use/on-the-web/setup/upgrading-from-version-4 v4 shim} is required.
		 * - Don't use {@link https://fontawesome.com/how-to-use/on-the-web/advanced/css-pseudo-elements pseudo-elements}
		 * - Be mindful of which {@link https://fontawesome.com/icons icons you use and in which versions of Font Awesome they're available}.
		 * - Adapt gracefully when the version loaded lacks icons you want to use (see more below).
		 *
		 * <h3>Using Pro icons</h3>
		 *
		 * If you are shipping a theme or plugin for which you insist on being able to use Font Awesome Pro, your only
		 * option is to instruct your users to purchase and enable appropriate licenses of Font Awesome Pro for their
		 * websites.
		 *
		 * <h3>Font Awesome version</h3>
		 *
		 * To maximize compatibility and user-friendliness, keep track of the icons you use and in which versions they're
		 * introduced ({@link https://fontawesome.com/changelog/latest new ones are being added all the time}).
		 * Add a hook on the `font_awesome_enqueued` action to discover what version of Font Awesome is being loaded
		 * and either turn off or replace newer icons that are not available in older releases, or warn the
		 * site owner in your own WordPress admin UI that they'll need to update to a new version in order for icons
		 * to work as expected in your templates.
		 *
		 * <h3>Additional Notes on Specific Preferences</h3>
		 *
		 * - `v4compat`
		 *
		 *   There were major changes between Font Awesome 4 and Font Awesome 5, including some re-named icons.
		 *   It's best to upgrade name references to the version 5 names,
		 *   but to [ease the upgrade path](https://fontawesome.com/how-to-use/on-the-web/setup/upgrading-from-version-4),
		 *   the "v4 shims" accept the v4 icon names and translate them into the equivalent v5 icon names.
		 *   Shims for SVG with JavaScript have been available since `5.0.0` and shims for Web Font with CSS have been
		 *   available since `5.1.0`.
		 *
		 *   Another common pattern out there on the web (not a recommended practice these days, though) is to place
		 *   icons as pseudo-elements where the unicode is specific in CSS as `content` and `"FontAwesome"` is specified
		 *   as the `font-family`. The main problem here is that the `font-family` name has changed for Font Awesome 5,
		 *   and there are multiple `font-family` names. So the v4compat feature of this plugin also "shims" those
		 *   hardcoded version 4 `font-family` names so that they will use the corresponding Font Awesome 5 webfont files.
		 *
		 * - `svgPseudoElements`
		 *
		 *   [Pseudo-elements](https://fontawesome.com/how-to-use/on-the-web/advanced/css-pseudo-elements)
		 *   are always intrinsically available when using the Web Font with CSS method.
		 *   However, for the SVG with JavaScript method, additional functionality must be enabled. It's not a recommended
		 *   approach, because the performance can be poor. _Really_ poor, in some cases. However, sometimes, it's necessary.
		 *
		 * @since 4.0.0
		 *
		 * @see FontAwesome::pro()
		 * @param array $client_preferences
		 * @throws InvalidArgumentException
		 */
		public function register( $client_preferences ) {
			// TODO: consider using a mechanism other than debug_backtrace() to track the calling module, since phpcs complains.
			// phpcs:ignore WordPress.PHP.DevelopmentFunctions
			$bt     = debug_backtrace( 1 );
			$caller = array_shift( $bt );
			if ( ! array_key_exists( 'name', $client_preferences ) ) {
				throw new InvalidArgumentException( 'missing required key: name' );
			}
			$client_preferences['clientCallSite'] = array(
				'file' => $caller['file'],
				'line' => $caller['line'],
			);

			$this->client_preferences[ $client_preferences['name'] ] = $client_preferences;
		}

		// phpcs:ignore Generic.Commenting.DocComment.MissingShort
		/**
		 * @internal
		 * @ignore
		 */
		public function process_shortcode( $params ) {
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

		/**
		 * Not public API.
		 *
		 * @internal
		 * @ignore
		 */
		private function get_webpack_asset_manifest() {
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

		/**
		 * Not public API.
		 *
		 * @internal
		 * @ignore
		 */
		private function get_webpack_asset_url($asset = '') {
			$asset_manifest = $this->get_webpack_asset_manifest();

			if ( FONTAWESOME_ENV === 'development' ) {
				$asset_url_base = 'http://localhost:3030';
			} else {
				$asset_url_base = FONTAWESOME_DIR_URL . 'admin/build';
			}

			return $asset_url_base . $asset_manifest[$asset];
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

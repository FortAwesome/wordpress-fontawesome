<?php
/**
 * Main plugin logic.
 */
namespace FortAwesome;

use \Exception, \Error, \DateTime, \DateInterval, \DateTimeInterface, \DateTimeZone;

require_once trailingslashit( __DIR__ ) . '../defines.php';
require_once trailingslashit( FONTAWESOME_DIR_PATH ) . 'includes/class-fontawesome-release-provider.php';
require_once trailingslashit( FONTAWESOME_DIR_PATH ) . 'includes/class-fontawesome-metadata-provider.php';
require_once trailingslashit( FONTAWESOME_DIR_PATH ) . 'includes/class-fontawesome-api-settings.php';
require_once trailingslashit( FONTAWESOME_DIR_PATH ) . 'includes/class-fontawesome-resource.php';
require_once trailingslashit( FONTAWESOME_DIR_PATH ) . 'includes/class-fontawesome-config-controller.php';
require_once trailingslashit( FONTAWESOME_DIR_PATH ) . 'includes/class-fontawesome-api-controller.php';
require_once trailingslashit( FONTAWESOME_DIR_PATH ) . 'includes/class-fontawesome-preference-conflict-detector.php';
require_once trailingslashit( FONTAWESOME_DIR_PATH ) . 'includes/class-fontawesome-preference-check-controller.php';
require_once trailingslashit( FONTAWESOME_DIR_PATH ) . 'includes/class-fontawesome-conflict-detection-controller.php';
require_once trailingslashit( FONTAWESOME_DIR_PATH ) . 'includes/class-fontawesome-v3deprecation-controller.php';
require_once trailingslashit( FONTAWESOME_DIR_PATH ) . 'includes/class-fontawesome-v3mapper.php';
require_once trailingslashit( FONTAWESOME_DIR_PATH ) . 'includes/class-fontawesome-exception.php';
require_once trailingslashit( FONTAWESOME_DIR_PATH ) . 'includes/class-fontawesome-command.php';
require_once ABSPATH . 'wp-admin/includes/screen.php';

/**
 * Main plugin class, a Singleton. Exposes all API methods and hooks that may be used by
 * client code to register with this plugin, to receive notifications about runtime
 * configuration, or to query the runtime configuration.
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
 *   The hook passes no parameters to its callbacks.
 *
 * - `font_awesome_enqueued`
 *
 *   Called when a version of Font Awesome has been successfully prepared for enqueuing.
 *
 *   Clients should register a callback on this action to be notified when it is valid to query the FontAwesome
 *   plugin's metadata using methods such as:
 *     - {@see FontAwesome::version()} to discover the version of Font Awesome being loaded
 *     - {@see FontAwesome::pro()} to discover whether a version with Pro icons is being loaded
 *     - {@see FontAwesome::pseudo_elements()} to discover whether Font Awesome is being loaded with support for svg pseudo-elements
 *
 * <h3>Internal Use vs. Public API</h3>
 *
 * Developers should take care to notice which functions, methods, classes,
 * constants, defines, REST routes, or data structures are indicated as part of
 * this plugin's public API and which are not.
 *
 * A method, for example, being declared in PHP with `public` visibility does not
 * indicate its inclusion in the plugin's _public API_.
 *
 * A method may be declared with public visibility in PHP in order to satisfy
 * the language's requirements for access across code modules, or for callbacks.
 * Yet this does not mean it can be relied upon as a stable interface by client
 * code.
 *
 * A method that is part of _this plugin's public API_ can be relied upon to
 * change, or not change, according to [semantic versioning best practices](https://semver.org/).
 * No such conventions apply to a method that is for internal use only, even
 * if it is declared `public` in PHP.
 *
 * Generally, public API members are accessed only from this `FontAwesome` class.
 *
 * For example, the {@see FontAwesome::releases_refreshed_at()} method provides a way
 * to find out when releases metadata were last fetched from `api.fontawesome.com`.
 * It delegates to another class internally. But that other class and its methods
 * are not part of this plugin's public API. They may change significantly from
 * one patch release to another, but no breaking changes would be made to
 * {@see FontAwesome::releases_refreshed_at()} without a major version change.
 *
 * References to "API" in this section refer to this plugin's PHP code or REST
 * routes, not to the Font Awesome GraphQL API at `api.fontawesome.com`.
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
	 * Internal use only, not part of this plugin's public API.
	 *
	 * @ignore
	 * @internal
	 */
	const OPTIONS_KEY = 'font-awesome';
	/**
	 * Key where this plugin stores conflict detection data in the WordPress options table.
	 *
	 * Internal use only, not part of this plugin's public API.
	 *
	 * @internal
	 * @ignore
	 */
	const CONFLICT_DETECTION_OPTIONS_KEY = 'font-awesome-conflict-detection';
	/**
	 * The unique WordPress plugin slug for this plugin.
	 *
	 * @since 4.0.0
	 */
	const PLUGIN_NAME = 'font-awesome';
	/**
	 * The version of this WordPress plugin.
	 *
	 * @since 4.0.0
	 */
	const PLUGIN_VERSION = '4.2.0';
	/**
	 * The namespace for this plugin's REST API.
	 *
	 * @internal
	 * @deprecated
	 * @ignore
	 */
	const REST_API_NAMESPACE = self::PLUGIN_NAME . '/v1';
	/**
	 * The name of this plugin's options page, or WordPress admin dashboard page.
	 *
	 * @since 4.0.0
	 */
	const OPTIONS_PAGE = 'font-awesome';

	/**
	 * GET param used for linking to a particular starting tab in the admin UI.
	 *
	 * @ignore
	 * @internal
	 */
	const ADMIN_TAB_QUERY_VAR = 'tab';

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
	 * @ignore
	 * @internal
	 */
	const RESOURCE_HANDLE_CONFLICT_DETECTOR = 'font-awesome-official-conflict-detector';

	/**
	 * The source URL for the conflict detector, a feature introduced in Font Awesome 5.10.0.
	 *
	 * @ignore
	 * @internal
	 */
	const CONFLICT_DETECTOR_SOURCE = 'https://use.fontawesome.com/releases/v6.1.1/js/conflict-detection.js';

	/**
	 * The custom data attribute added to script, link, and style elements enqueued
	 * by this plugin when conflict detection is enabled, in order for them to be
	 * ignored by the conflict detector.
	 *
	 * @internal
	 * @ignore
	 */
	const CONFLICT_DETECTION_IGNORE_ATTR = 'data-fa-detection-ignore';

	/**
	 * The base name of the handle used for enqueuing this plugin's admin assets, those required for running
	 * the admin settings page.
	 *
	 * @ignore
	 * @internal
	 */
	const ADMIN_RESOURCE_HANDLE = self::RESOURCE_HANDLE . '-admin';

	/**
	 * Name used for inline data attached to the JavaScript admin bundle.
	 * Not part of this plugin's public API.
	 *
	 * @internal
	 * @ignore
	 */
	const ADMIN_RESOURCE_LOCALIZATION_NAME = '__FontAwesomeOfficialPlugin__';

	/**
	 * @ignore
	 * @deprecated
	 */
	const V3DEPRECATION_TRANSIENT = 'font-awesome-v3-deprecation-data';

	/**
	 * @ignore
	 * @deprecated
	 */
	const V3DEPRECATION_EXPIRY = WEEK_IN_SECONDS;

	/**
	 * Refresh the ReleaseProvider automatically no more often than this
	 * number of seconds.
	 *
	 * Internal use only. Not part of this plugin's public API.
	 *
	 * @ignore
	 * @internal
	 */
	const RELEASES_REFRESH_INTERVAL = 10 * 60;

	/**
	 * We will not use a default for version, since we want the version stored in the options
	 * to always be resolved to an actual version number, which requires that the release
	 * provider successfully runs at least once. We'll do that upon plugin activation.
	 *
	 * @ignore
	 * @internal
	 */
	const DEFAULT_USER_OPTIONS = array(
		'usePro'         => false,
		'compat'         => true,
		'technology'     => 'webfont',
		'pseudoElements' => true,
		'kitToken'       => null,
		// whether the token is present, not the token's value.
		'apiToken'       => false,
		'dataVersion'    => 4,
	);

	/**
	 * Default conflict detection options.
	 *
	 * @ignore
	 * @internal
	 */
	const DEFAULT_CONFLICT_DETECTION_OPTIONS = array(
		'detectConflictsUntil' => 0,
		'unregisteredClients'  => array(),
	);

	/**
	 * @internal
	 * @ignore
	 */
	protected static $instance = null;

	/**
	 * @internal
	 * @ignore
	 */
	protected $client_preferences = array();

	/**
	 * @internal
	 * @ignore
	 */
	protected $icon_chooser_screens = array( 'post.php', 'post-new.php' );

	/**
	 * @internal
	 * @ignore
	 */
	protected $conflicts_by_client = null;

	/**
	 * @internal
	 * @ignore
	 */
	protected $screen_id = null;

	/**
	 * This tracks the state of whether, when we process options after the
	 * plugin upgrades from using the v1 options schema to v2, the former
	 * removeUnregisteredClients option was set. If so we use some automatic
	 * conflict detection and resolution, like that old feature worked.
	 *
	 * Internal use only, not part of this plugin's public API.
	 *
	 * @deprecated
	 * @internal
	 * @ignore
	 */
	protected $old_remove_unregistered_clients = false;

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

	/**
	 * Internal use only, not part of this plugin's public API.
	 *
	 * @internal
	 * @ignore
	 */
	private function __construct() {
		/* noop */
	}

	/**
	 * Returns this plugin's admin page's screen_id. Only valid after the admin_menu hook has run.
	 *
	 * Internal only, not part of this plugin's public API.
	 *
	 * @ignore
	 * @internal
	 */
	public function admin_screen_id() {
		return $this->screen_id;
	}

	/**
	 * Main entry point for running the plugin. Called automatically when the plugin is loaded.
	 *
	 * Internal only, not part of this plugin's public API.
	 *
	 * @internal
	 * @ignore
	 */
	public function run() {
		$this->init();

		$this->initialize_rest_api();

		if ( is_admin() ) {
			$this->initialize_admin();
		}
	}

	/**
	 * Callback for init.
	 *
	 * Internal use only.
	 *
	 * @ignore
	 * @internal
	 */
	public function init() {
		try {
			$this->try_upgrade();

			add_shortcode(
				self::SHORTCODE_TAG,
				array( $this, 'process_shortcode' )
			);

			$this->validate_options( fa()->options() );

			try {
				$this->gather_preferences();
			// phpcs:ignore Generic.CodeAnalysis.EmptyStatement.DetectedCatch
			} catch ( PreferenceRegistrationException $e ) {
				/**
				 * Ignore this on normal page loads.
				 * If something seems amiss, the site owner may try to look
				 * into it on the plugin settings page where some additional
				 * diagnostic information may be found.
				 */
			}

			$this->maybe_enqueue_admin_assets();

			// Setup JavaScript internationalization if we're on WordPress 5.0+.
			if ( function_exists( 'wp_set_script_translations' ) ) {
				wp_set_script_translations( self::ADMIN_RESOURCE_HANDLE, 'font-awesome' );
			}

			if ( $this->using_kit() ) {
				$this->enqueue_kit( $this->options()['kitToken'] );
			} else {
				$resource_collection = $this->cdn_resource_collection_for_current_options();
				$this->enqueue_cdn( $this->options(), $resource_collection );
			}
		} catch ( Exception $e ) {
			notify_admin_fatal_error( $e );
		} catch ( Error $e ) {
			notify_admin_fatal_error( $e );
		}
	}

	/**
	 * Not part of this plugin's public API.
	 *
	 * @ignore
	 * @internal
	 * @throws ConfigCorruptionException
	 * @return array
	 */
	public function cdn_resource_collection_for_current_options() {
		return FontAwesome_Release_Provider::get_resource_collection(
			$this->options()['version'],
			array(
				'use_pro'           => $this->pro(),
				'use_svg'           => 'svg' === $this->technology(),
				'use_compatibility' => $this->v4_compatibility(),
			)
		);
	}

	/**
	 * Detects whether upgrade is necessary and performs upgrade if so.
	 *
	 * Internal use only.
	 *
	 * @throws UpgradeException
	 * @throws ApiRequestException
	 * @throws ApiResponseException
	 * @throws ReleaseProviderStorageException
	 * @throws ReleaseMetadataMissingException
	 * @throws ConfigCorruptionException if options are invalid
	 * @internal
	 * @ignore
	 */
	public function try_upgrade() {
		$options = get_option( self::OPTIONS_KEY );

		$should_upgrade = false;

		// Upgrade from v1 schema: 4.0.0-rc13 or earlier.
		if ( isset( $options['lockedLoadSpec'] ) || isset( $options['adminClientLoadSpec'] ) ) {
			if ( isset( $options['removeUnregisteredClients'] ) && $options['removeUnregisteredClients'] ) {
				$this->old_remove_unregistered_clients = true;
			}

			$upgraded_options = $this->convert_options_from_v1( $options );

			/**
			 * If the version is still not set for some reason, set it to a
			 * default of the latest available version.
			 */
			if ( ! isset( $upgraded_options['version'] ) ) {
				$upgraded_options['version'] = fa()->latest_version_6();
			}

			$should_upgrade = true;

			$options = $upgraded_options;
		}

		if ( ! isset( $options['dataVersion'] ) || $options['dataVersion'] < 4 ) {

			if ( ! isset( $options['compat'] ) && isset( $options['v4Compat'] ) ) {
				$v4_compat         = boolval( $options['v4Compat'] );
				$options['compat'] = $v4_compat;
				unset( $options['v4Compat'] );
			} else {
				$options['compat'] = self::DEFAULT_USER_OPTIONS['compat'];
			}

			if ( isset( $options['v4Compat'] ) ) {
				unset( $options['v4Compat'] );
			}

			$options['dataVersion'] = 4;

			$should_upgrade = true;
		}

		if ( $should_upgrade ) {
			$this->validate_options( $options );

			$this->maybe_update_last_used_release_schema_for_upgrade();

			$this->maybe_move_release_metadata_for_upgrade();

			/**
			 * Delete the main option to make sure it's removed entirely, including
			 * from the autoload cache.
			 *
			 * Function delete_option() returns false when it fails, including when the
			 * option does not exist. We know the option exists, because we just
			 * queried it above. So any other failure should halt the upgrade
			 * process to avoid inconsistent states.
			 */
			if ( ! delete_option( self::OPTIONS_KEY ) ) {
				throw UpgradeException::main_option_delete();
			}

			update_option( self::OPTIONS_KEY, $options );
		}
	}

	/**
	 * Some upgrades have involved changing how we store release metadata.
	 *
	 * If the plugin's backing data was in a valid sate before upgrade, then
	 * it should always be possible to apply any fixups to how the release
	 * metadata are stored without issuing a request to the API server for
	 * fresh metadata. Since issuing such a blocking request upon upgrade
	 * is known to cause load problems and request timeouts, let's never
	 * do it on upgrade.
	 *
	 * Internal use only.
	 *
	 * @throws ReleaseMetadataMissingException
	 * @ignore
	 * @internal
	 */
	private function maybe_move_release_metadata_for_upgrade() {
		if ( boolval( get_option( FontAwesome_Release_Provider::OPTIONS_KEY ) ) ) {
			// If this option is set, then we're all caught up.
			return;
		}

		// It used to be stored in one of these.
		$release_metadata = get_site_transient( 'font-awesome-releases' );
		if ( ! $release_metadata ) {
			$release_metadata = get_transient( 'font-awesome-releases' );
		}

		// Move it into where it belongs now.
		if ( boolval( $release_metadata ) ) {
			update_option( FontAwesome_Release_Provider::OPTIONS_KEY, $release_metadata, false );
		}

		/**
		 * Now we'll reset the release provider.
		 *
		 * If we've fallen through to this point, and we haven't found the release
		 * metadata stored in one of the previous locations, then this will throw an
		 * exception.
		 */
		FontAwesome_Release_Provider::reset();
	}

	/**
	 * With 4.1.0, the name of one of the keys in the LAST_USED_RELEASE_TRANSIENT changed.
	 * We can fix it up.
	 *
	 * Internal use only.
	 *
	 * @throws ReleaseMetadataMissingException
	 * @ignore
	 * @internal
	 */
	private function maybe_update_last_used_release_schema_for_upgrade() {
		$last_used_transient = get_site_transient( FontAwesome_Release_Provider::LAST_USED_RELEASE_TRANSIENT );
		if ( ! $last_used_transient ) {
			$last_used_transient = get_transient( FontAwesome_Release_Provider::LAST_USED_RELEASE_TRANSIENT );
		}

		if ( $last_used_transient && isset( $last_used_transient['use_shim'] ) ) {
			$compat = $last_used_transient['use_shim'];
			unset( $last_used_transient['use_shim'] );
			$last_used_transient['use_compatibility'] = $compat;
			set_site_transient( FontAwesome_Release_Provider::LAST_USED_RELEASE_TRANSIENT, $last_used_transient, FontAwesome_Release_Provider::LAST_USED_RELEASE_TRANSIENT_EXPIRY );
		}
	}

	/**
	 * Returns boolean indicating whether the plugin is currently configured
	 * to run the client-side conflict detection scanner.
	 *
	 * @since 4.0.0
	 * @return bool
	 */
	public function detecting_conflicts() {
		$conflict_detection = get_option( self::CONFLICT_DETECTION_OPTIONS_KEY );

		if ( isset( $conflict_detection['detectConflictsUntil'] ) && is_integer( $conflict_detection['detectConflictsUntil'] ) ) {
			return time() < $conflict_detection['detectConflictsUntil'];
		} else {
			return false;
		}
	}

	/**
	 * Returns boolean indicating whether a kit is configured.
	 *
	 * It normally shouldn't make a difference to other theme's or plugins
	 * as to whether Font Awesome is configured to use the standard CDN or a kit.
	 * Yet this is a valid way to determine that.
	 *
	 * @since 4.0.0
	 * @throws ConfigCorruptionException
	 * @return bool
	 */
	public function using_kit() {
		$options = $this->options();
		$this->validate_options( $options );
		return $this->using_kit_given_options( $options );
	}

	/**
	 * Internal use only.
	 *
	 * @internal
	 * @ignore
	 * @return bool
	 */
	private function using_kit_given_options( $options ) {
		return isset( $options['kitToken'] )
			&& isset( $options['apiToken'] )
			&& $options['apiToken']
			&& is_string( $options['kitToken'] );
	}

	/**
	 * Internal use only, not part of this plugin's public API.
	 *
	 * @internal
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

	/**
	 * Internal use only, not part of this plugin's public API.
	 *
	 * @internal
	 * @ignore
	 */
	private function initialize_rest_api() {
		add_action(
			'rest_api_init',
			array(
				new FontAwesome_API_Controller( self::PLUGIN_NAME, self::REST_API_NAMESPACE ),
				'register_routes',
			)
		);
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
	 * Returns the latest available full release version of Font Awesome 5 as a string,
	 * or null if the releases metadata has not yet been successfully retrieved from the
	 * API server.
	 *
	 * As of the release of Font Awesome 6.0.0-beta1, this API is being deprecated,
	 * because the symbolic version "latest" is being deprecated. It now just means
	 * "the latest full release of Font Awesome with major version 5." Therefore,
	 * it may not be very useful any more as Font Awesome 6 is released.
	 *
	 * The recommended way to resolve the symbolic versions 'latest',
	 * '5.x', or '6.x' into their current concrete values is to query the GraphQL
	 * API like this:
	 *
	 * ```
	 * query { release(version: "5.x") { version } }
	 * ```
	 *
	 * The `version` argument on the `release` field can accept any of these symbolic
	 * version values.  So that release's `version` field will be the corresponding
	 * current concrete version value at the time the query is run.
	 *
	 * This query could be issued from a front-end script through `FontAwesome_API_Controller`
	 * like this, assuming `@wordpress/api-fetch` is at `wp.apiFetch`,
	 * and you've [setup a nonce](https://developer.wordpress.org/block-editor/reference-guides/packages/packages-api-fetch/#built-in-middlewares) correctly,
	 * and the logged in user has the appropriate permissions.
	 *
	 * ```
	 * wp.apiFetch( {
	 *      path: '/font-awesome/v1/api',
	 *      method: 'POST',
	 *      body: 'query { release(version: "5.x") { version } }'
	 *  } ).then( res => {
	 *      console.log( res );
	 *  } )
	 * ```
	 *
	 * Or you could issue your own `POST` request directly `api.fontawesome.com`.
	 * [See the Font Awesome GraphQL API reference here](https://fontawesome.com/v5.15/how-to-use/graphql-api/intro/getting-started).
	 *
	 * @since 4.0.0
	 * @deprecated
	 *
	 * @return null|string
	 */
	public function latest_version() {
		return $this->release_provider()->latest_version();
	}

	/**
	 * Returns the latest available full release version of Font Awesome 5 as a string,
	 * or null if the releases metadata has not yet been successfully retrieved from the
	 * API server.
	 *
	 * @since 4.2.0
	 *
	 * @return null|string
	 */
	public function latest_version_5() {
		return $this->release_provider()->latest_version_5();
	}

	/**
	 * Returns the latest available full release version of Font Awesome 6 as a string,
	 * or null if the releases metadata has not yet been successfully retrieved from the
	 * API server.
	 *
	 * @since 4.2.0
	 *
	 * @return null|string
	 */
	public function latest_version_6() {
		return $this->release_provider()->latest_version_6();
	}

	/**
	 * Queries the Font Awesome API to load releases metadata. Results are stored
	 * in the wp database.
	 *
	 * This is the metadata that supports API
	 * methods like {@see FontAwesome::latest_version()}
	 * and all other metadata required to enqueue Font Awesome when configured
	 * to use the standard CDN (non-kits).
	 *
	 * This has been deprecated to discourage themes or plugins from invoking
	 * it as a blocking network request during front-end page loads. If we find
	 * that functionality like this is still needed for some use cases, let's
	 * design an alternative API that encourages best-practice use while
	 * discouraging anti-patterns.
	 *
	 * @since 4.0.0
	 * @deprecated
	 * @ignore
	 * @throws ApiRequestException
	 * @throws ApiResponseException
	 * @throws ReleaseProviderStorageException
	 */
	public function refresh_releases() {
		$this->release_provider()->load_releases();
	}

	/**
	 * Returns the time when releases metadata was last
	 * refreshed.
	 *
	 * @since 4.0.0
	 * @return integer|null the time in unix epoch seconds or null if never
	 */
	public function releases_refreshed_at() {
		return $this->release_provider()->refreshed_at();
	}

	/**
	 * Refreshes releases only if it's a been a while.
	 *
	 * Internal use only, not part of this plugin's public API.
	 *
	 * @ignore
	 * @internal
	 * @return WP_Error|1 error if there was a problem, otherwise 1.
	 */
	protected function maybe_refresh_releases() {
		$refreshed_at = $this->releases_refreshed_at();

		/**
		 * If we've just upgraded from an older plugin version that didn't have this metadata value,
		 * then we should refresh to get it.
		 */
		$latest_version_6 = $this->latest_version_6();

		if ( is_null( $latest_version_6 ) || is_null( $refreshed_at ) || ( time() - $refreshed_at ) > self::RELEASES_REFRESH_INTERVAL ) {
			return FontAwesome_Release_Provider::load_releases();
		} else {
			return 1;
		}
	}

	/**
	 * URL for this plugin's admin settings page.
	 *
	 * Internal use only, not part of this plugin's public API.
	 *
	 * @ignore
	 * @internal
	 */
	private function settings_page_url() {
		return admin_url( 'admin.php?page=' . self::OPTIONS_PAGE );
	}

	/**
	 * The value of the "ts" GET param given for this page request, or null if none.
	 *
	 * Internal use only, not part of this plugin's public API.
	 *
	 * We'll be super-strict validating what values we'll accept, insead of passing
	 * through whatever is on the query string.
	 *
	 * @ignore
	 * @internal
	 * @return string|null
	 */
	private function active_admin_tab() {
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended
		if ( ! isset( $_REQUEST[ self::ADMIN_TAB_QUERY_VAR ] ) || empty( $_REQUEST[ self::ADMIN_TAB_QUERY_VAR ] ) ) {
			return null;
		}

		// phpcs:ignore WordPress.Security.NonceVerification.Recommended, WordPress.Security.ValidatedSanitizedInput.MissingUnslash, WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
		$value = $_REQUEST[ self::ADMIN_TAB_QUERY_VAR ];

		// These values are defined in the Redux reducer module of the admin JS React app.
		switch ( $value ) {
			case 'ts':
				return 'ADMIN_TAB_TROUBLESHOOT';
			case 's':
				return 'ADMIN_TAB_SETTINGS';
			default:
				return null;
		}
	}

	/**
	 * Internal use only, not part of this plugin's public API.
	 *
	 * @internal
	 * @ignore
	 */
	private function emit_v3_deprecation_admin_notice( $data ) {
		?>
		<div class="notice notice-warning is-dismissible">
			<p>
				<?php esc_html_e( 'Hey there, from the Font Awesome plugin!', 'font-awesome' ); ?>
			</p>
			<p>
				<?php
					printf(
						/* translators: 1: detected icon name 2: literal icon shortcode */
						esc_html__(
							'Looks like you\'re using an %2$s shortcode with an old Font Awesome 3 icon name: %1$s. We\'re phasing those out, so it will stop working on your site soon.',
							'font-awesome'
						),
						'<code>' . esc_html( $data['atts']['name'] ) . '</code>',
						'<code>[icon]</code>'
					);
				?>
			</p>
			<p>
				<?php
					printf(
						/* translators: 1: opening anchor tag with url 2: closing anchor tag */
						esc_html__(
							'Head over to the %1$sFont Awesome Settings%2$s page to see how you can fix it up, or snooze this warning for a while.',
							'font-awesome'
						),
						'<a href="' . esc_html( $this->settings_page_url() ) . '&tab=ts">',
						'</a>'
					);
				?>
			</p>
		</div>
		<?php
	}

	/**
	 * Initalizes everything about the admin environment except the React app
	 * bundle, which is handled in maybe_enqueue_admin_assets().
	 *
	 * Internal use only, not part of this plugin's public API.
	 *
	 * @ignore
	 * @internal
	 */
	public function initialize_admin() {
		$v3deprecation_warning_data = $this->get_v3deprecation_warning_data();

		if ( $v3deprecation_warning_data && ! ( isset( $v3deprecation_warning_data['snooze'] ) && $v3deprecation_warning_data['snooze'] ) ) {

			$v3_deprecation_command = new FontAwesome_Command(
				function() use ( $v3deprecation_warning_data ) {
					$current_screen = get_current_screen();
					if ( $current_screen && fa()->screen_id !== $current_screen->id ) {
						fa()->emit_v3_deprecation_admin_notice( $v3deprecation_warning_data );
					}
				}
			);

			add_action(
				'admin_notices',
				array( $v3_deprecation_command, 'run' )
			);
		}

		$admin_menu_command = new FontAwesome_Command(
			function() {
				fa()->screen_id = add_options_page(
					/* translators: add_options_page page_title */
					esc_html__( 'Font Awesome Settings', 'font-awesome' ),
					/* translators: add_options_page menu_title */
					esc_html__( 'Font Awesome', 'font-awesome' ),
					'manage_options',
					self::OPTIONS_PAGE,
					array( fa(), 'create_admin_page' )
				);
			}
		);

		add_action(
			'admin_menu',
			array( $admin_menu_command, 'run' )
		);

		$plugin_action_links_command = new FontAwesome_Command(
			function ( $links ) {
				$mylinks = array(
					/* translators: label for link to settings page on plugin listing */
					'<a href="' . fa()->settings_page_url() . '">' . esc_html__( 'Settings', 'font-awesome' ) . '</a>',
				);
				return array_merge( $links, $mylinks );
			}
		);

		add_filter(
			'plugin_action_links_' . FONTAWESOME_PLUGIN_FILE,
			array( $plugin_action_links_command, 'run' )
		);

		$multi_version_warning_command = new FontAwesome_Command(
			function( $plugin_file, $plugin_data, $status ) {
				if ( version_compare( FontAwesome::PLUGIN_VERSION, $plugin_data['Version'], 'ne' ) ) {
					$loader_version = FontAwesome_Loader::instance()->loaded_path();
					?>
					<tr>
						<td>&nbsp;</td>
						<td colspan="2" class="notice notice-info notice-alt">
							<p>
								<b><?php esc_html_e( 'Great Scott!', 'font-awesome' ); ?></b>
								<?php
									printf(
										/* translators: 1: path to plugin or theme code file 2: current Font Awesome plugin version number */
										esc_html__(
											'The active version of the Font Awesome plugin is being loaded by this plugin or theme: %1$s since it\'s the newest (%2$s). We recommend you update the plugin above to the latest version. In the meantime, we\'ll use that newer version for editing your Font Awesome settings so you\'ll be sure to hit 88mph with those icons.',
											'font-awesome'
										),
										'<code>' . esc_html( $loader_version ) . '</code>',
										'<b>ver. ' . esc_html( FontAwesome::PLUGIN_VERSION ) . '</b>'
									);
								?>
							</p>
							<p>
								<?php
									esc_html_e( 'You\'ve got more than one version of the Font Awesome plugin installed.', 'font-awesome' );
								?>
							</p>
						</td>
					</tr>
					<?php
				}
			}
		);

		add_action(
			'after_plugin_row_' . FONTAWESOME_PLUGIN_FILE,
			array( $multi_version_warning_command, 'run' ),
			10,
			3
		);
	}

	/**
	 * Returns current options.
	 *
	 * Internal use only. Not part of this plugin's public API.
	 *
	 * @throws ConfigCorruptionException
	 * @internal
	 * @ignore
	 * @return array
	 */
	public function options() {
		$options = get_option( self::OPTIONS_KEY );

		if ( ! $options ) {
			throw new ConfigCorruptionException();
		}

		return $options;
	}

	/**
	 * Validates options.
	 *
	 * Internal use only. Not part of this plugin's public API.
	 *
	 * @ignore
	 * @internal
	 * @throws ConfigCorruptionException if options are invalid
	 */
	public function validate_options( $options ) {
		$using_kit = $this->using_kit_given_options( $options );
		$kit_token = isset( $options['kitToken'] ) ? $options['kitToken'] : null;
		$api_token = isset( $options['apiToken'] ) ? $options['apiToken'] : null;
		$version   = isset( $options['version'] ) ? $options['version'] : null;

		if ( ! isset( $options['usePro'] ) || ! is_bool( $options['usePro'] ) ) {
			throw new ConfigCorruptionException();
		}

		if ( $using_kit ) {
			if ( ! boolval( $api_token ) ) {
				throw new ConfigCorruptionException();
			}

			if ( ! is_string( $kit_token ) ) {
				throw new ConfigCorruptionException();
			}

			if ( ! is_string( $version ) ) {
				throw new ConfigCorruptionException();
			}
		} else {
			/**
			 * If we're not using a kit, then the version cannot be "latest",
			 * "5.x", or "6.x" at this point. It must have already been resolved
			 * into a concrete version.
			 */
			$version_is_concrete = is_string( $version )
				&& 1 === preg_match( '/^[0-9]+\.[0-9]+\.[0-9]+/', $version );

			if ( ! $version_is_concrete ) {
				throw new ConfigCorruptionException();
			}

			$version_is_v6 = is_string( $version )
				&& 1 === preg_match( '/^6\./', $version );

			$is_pro = boolval( $options['usePro'] );

			/**
			 * Pro Version 6 CDN is not supported.
			 */
			if ( $version_is_v6 && $is_pro ) {
				throw new ConfigCorruptionException();
			}
		}

		if ( ! isset( $options['compat'] ) || ! is_bool( $options['compat'] ) ) {
			throw new ConfigCorruptionException();
		}

		if ( ! isset( $options['pseudoElements'] ) || ! is_bool( $options['pseudoElements'] ) ) {
			throw new ConfigCorruptionException();
		}

		if (
			! isset( $options['technology'] ) ||
			! is_string( $options['technology'] ) ||
			false === array_search( $options['technology'], array( 'svg', 'webfont' ), true )
		) {
			throw new ConfigCorruptionException();
		}
	}

	/**
	 * An array of md5 hashes that identify detected conflicting versions of
	 * Font Awesome that the site owner has chosen to block from being enqueued.
	 *
	 * It is managed through the plugin's settings page.
	 *
	 * @since 4.0.0
	 * @return array
	 */
	public function blocklist() {
		$conflict_detection = get_option( self::CONFLICT_DETECTION_OPTIONS_KEY );

		$unregistered_clients = (
			isset( $conflict_detection['unregisteredClients'] )
			&& is_array( $conflict_detection['unregisteredClients'] )
		)
			? $conflict_detection['unregisteredClients']
			: array();

		$blocklist = array_reduce(
			array_keys( $unregistered_clients ),
			function( $carry, $md5 ) use ( $unregistered_clients ) {
				if (
					isset( $unregistered_clients[ $md5 ]['blocked'] )
					&& boolval( $unregistered_clients[ $md5 ]['blocked'] )
				) {
					array_push( $carry, $md5 );
				}
				return $carry;
			},
			array()
		);

		return $blocklist;
	}

	/**
	 * Gets the current value of detectConflictsUntil from the conflict detection
	 * option key in the database.
	 *
	 * Returns 0 if that value is unset in the db.
	 *
	 * Internal use only, not part of this plugin's public API.
	 *
	 * @ignore
	 * @internal
	 * @return integer
	 */
	protected function detect_conflicts_until() {
		$conflict_detection = get_option(
			self::CONFLICT_DETECTION_OPTIONS_KEY,
			self::DEFAULT_CONFLICT_DETECTION_OPTIONS
		);

		return isset( $conflict_detection['detectConflictsUntil'] )
			? $conflict_detection['detectConflictsUntil'] : 0;
	}

	/**
	 * Converts a given options array with a v1 schema to one with a v2 schema.
	 * There are significant changes from the schema used by 4.0.0-rc9 and before.
	 *
	 * Internal use only, not part of this plugin's public API.
	 *
	 * @internal
	 * @ignore
	 * @param $options
	 * @return array
	 */
	public function convert_options_from_v1( $options ) {
		$converted_options = self::DEFAULT_USER_OPTIONS;

		if ( isset( $options['usePro'] ) ) {
			$converted_options['usePro'] = $options['usePro'];
		} else {
			$converted_options['usePro'] = self::DEFAULT_USER_OPTIONS['usePro'];
		}

		if ( isset( $options['version'] ) ) {
			$converted_options['version'] = $options['version'];
		}

		if ( isset( $options['lockedLoadSpec'] ) ) {
			$converted_options['technology'] = isset( $options['lockedLoadSpec']['method'] )
				? $options['lockedLoadSpec']['method']
				: 'webfont';

			/**
			 * If technology is webfont, always coerce pseudo-elements to true.
			 * Otherwise, carry over whatever value it had before.
			 */
			$converted_options['pseudoElements'] =
				'webfont' === $converted_options['technology']
					? true
					: (
						isset( $options['lockedLoadSpec']['pseudoElements'] )
							? $options['lockedLoadSpec']['pseudoElements']
							: false
					);

			$converted_options['compat'] = $options['lockedLoadSpec']['v4shim'];
		} elseif ( isset( $options['adminClientLoadSpec'] ) ) {
			$converted_options['technology'] = $options['adminClientLoadSpec']['method'];

			$converted_options['pseudoElements'] = 'svg' === $options['adminClientLoadSpec']['method']
				&& $options['adminClientLoadSpec']['pseudoElements'];

			$converted_options['compat'] = $options['adminClientLoadSpec']['v4shim'];
		}

		return $converted_options;
	}

	/**
	 * Callback function for creating the plugin's admin page.
	 *
	 * Internal use only, not part of this plugin's public API.
	 *
	 * @ignore
	 * @internal
	 */
	public function create_admin_page() {
		include_once FONTAWESOME_DIR_PATH . 'admin/views/main.php';
	}

	/**
	 * Resets the singleton instance referenced by this class.
	 *
	 * Internal use only, not part of this plugin's public API.
	 *
	 * @ignore
	 * @internal
	 * @return FontAwesome
	 */
	public static function reset() {
		self::$instance = null;
		return fa();
	}

	/**
	 * Triggers the font_awesome_preferences action to gather preferences from clients.
	 *
	 * Internal use only, not part of this plugin's public API.
	 *
	 * @internal
	 * @ignore
	 * @throws PreferenceRegistrationException
	 */
	public function gather_preferences() {
		/**
		 * Fired when the plugin is ready for clients to register their preferences.
		 *
		 * @since 4.0.0
		 */
		try {
			do_action( 'font_awesome_preferences' );
		} catch ( Exception $e ) {
			throw PreferenceRegistrationException::with_thrown( $e );
		} catch ( Error $e ) {
			throw PreferenceRegistrationException::with_thrown( $e );
		}
	}

	/**
	 * Returns current preferences conflicts, keyed by option name.
	 *
	 * Internal use only, not part of this plugin's public API.
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
	 * @ignore
	 * @internal
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
	 * Internal use only, not part of this plugin's public API.
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
	 * @ignore
	 * @internal
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
					$client_preferences,
					$this->latest_version_5(),
					$this->latest_version_6()
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
	 * Return current client preferences for all registered clients.
	 *
	 * Internal use only, not part of this plugin's public API.
	 *
	 * The website owner (i.e. the one who uses the WordPress admin dashboard) is considered a registered client.
	 * So that owner's preferences will be represented here. But note that these preferences do not include
	 * the `options`, as returned by {@see FortAwesome\FontAwesome::options()} which also help determine the
	 * final result of how the Font Awesome assets are loaded.
	 *
	 * Each element of the array has the same shape as the preferences given to {@see FortAwesome\FontAwesome::register()}.
	 *
	 * @ignore
	 * @internal
	 * @see FortAwesome\FontAwesome::register()
	 * @return array
	 */
	public function client_preferences() {
		return $this->client_preferences;
	}

	/**
	 * Return unregistered clients that have been detected and stored in the WordPress db.
	 *
	 * Internal use only, not part of this plugin's public API.
	 *
	 * Unregistered clients are those for which the in-browser conflict detector
	 * detects the presence of a Font Awesome version that is not being loaded by
	 * this plugin, and therefore is likely causing a conflict.
	 *
	 * Client-side conflict detection is enabled in this plugin's setting page in WP admin.
	 *
	 * @ignore
	 * @internal
	 * @return array
	 */
	public function unregistered_clients() {
		$conflict_detection = get_option( self::CONFLICT_DETECTION_OPTIONS_KEY );
		if ( isset( $conflict_detection['unregisteredClients'] ) && is_array( $conflict_detection['unregisteredClients'] ) ) {
			return $conflict_detection['unregisteredClients'];
		} else {
			return array();
		}
	}

	/**
	 * Indicates whether Font Awesome Pro is being loaded.
	 *
	 * It's a handy way to toggle the use of Pro icons in client theme or plugin template code.
	 *
	 * @since 4.0.0
	 * @throws ConfigCorruptionException
	 *
	 * @return boolean
	 */
	public function pro() {
		$options = $this->options();
		$this->validate_options( $options );
		return $options['usePro'];
	}

	/**
	 * Indicates which Font Awesome technology is configured: 'webfont' or 'svg'.
	 *
	 * @since 4.0.0
	 * @throws ConfigCorruptionException
	 *
	 * @return string
	 */
	public function technology() {
		$options = $this->options();
		$this->validate_options( $options );

		return $options['technology'];
	}

	/**
	 * Reports the version of Font Awesome assets being loaded, which may have
	 * a symbolic value like "latest" (deprecated), "5.x", or "6.x" if configured
	 * for a kit. If not configured for a kit, the version is guaranteed to be
	 * a concrete, semver parseable value, like 5.15.3.
	 *
	 * Your theme or plugin can call this method in order to determine
	 * whether all of the icons used in your templates will be available,
	 * especially if you tend to use newer icons.
	 *
	 * It should be really easy for site owners to update to a new Font Awesome
	 * version to accommodate your templates--just a simple dropdown selection
	 * on the Font Awesome plugin settings page. You might need to show an admin
	 * notice to nudge them to do so if you detect that the current version of
	 * Font Awesome being loaded is older than you'd like.
	 *
	 * When Font Awesome is configured to use a kit, that kit may be configured
	 * to load the "latest" version. The resolution of that symoblic "latest"
	 * version happens internal to the kit's own loading logic, which is
	 * outside the scope of this plugin.
	 *
	 * Before the release of Font Awesome 6.0.0-beta1, the symbolic version "latest"
	 * on a kit always meant: "the latest stable release with major version 5."
	 * Using "latest" for kits has been deprecated, but where it is still present
	 * on a kit, it will continue to mean just "the latest stable release with
	 * major version 5."
	 *
	 * New symbolic major version ranges have been introduced instead "5.x" and "6.x".
	 * These mean, respectively: "the latest stable release with major version 5",
	 * and "the latest stable release with major version 6, when available, otherwise
	 * the latest pre-release with major version 6."
	 *
	 * So if this function does not return a semver parseable version, then
	 * it must be one of these symbolic versions.
	 *
	 * The recommended way to resolve the symbolic versions 'latest',
	 * '5.x', or '6.x' into their current concrete values is to query the GraphQL
	 * API like this:
	 *
	 * ```
	 * query { release(version: "5.x") { version } }
	 * ```
	 *
	 * @since 4.0.0
	 * @see FontAwesome::latest_version()
	 * @see FontAwesome::releases_refreshed_at()
	 * @throws ConfigCorruptionException
	 * @return string|null null if no version has yet been saved in the options
	 * in the db. Otherwise, 5.x, or 6.x, or a semantic version string.
	 */
	public function version() {
		$options = $this->options();
		$this->validate_options( $options );

		return $options['version'];
	}

	/**
	 * Returns the currently configured kit token, if the plugin is currently
	 * configured to load a kit.
	 *
	 * @since 4.0.0
	 * @throws ConfigCorruptionException
	 * @return string|null kit token if present, or null
	 */
	public function kit_token() {
		$options = $this->options();
		$this->validate_options( $options );

		return isset( $options['kitToken'] ) ? $options['kitToken'] : null;
	}

	/**
	 * Indicates whether Font Awesome is being loaded with version 4 compatibility.
	 *
	 * Its result is valid only after the `font_awesome_enqueued` has been triggered.
	 *
	 * @since 4.0.0
	 * @throws ConfigCorruptionException
	 * @deprecated
	 *
	 * @return boolean
	 */
	public function v4_compatibility() {
		return $this->compatibility();
	}

	/**
	 * Indicates whether Font Awesome is being loaded with older version compatibility.
	 *
	 * Its result is valid only after the `font_awesome_enqueued` has been triggered.
	 *
	 * @since 4.1.0
	 * @throws ConfigCorruptionException
	 *
	 * @return boolean
	 */
	public function compatibility() {
		$options = $this->options();
		$this->validate_options( $options );
		return $options['compat'];
	}

	/**
	 * Indicates whether Font Awesome is being loaded with support for pseudo-elements.
	 *
	 * Its results are only valid after the `font_awesome_enqueued` action has been triggered.
	 *
	 * There are known performance problems with this SVG and pseudo-elements,
	 * but it is provided for added compatibility where pseudo-elements must be used.
	 *
	 * Always returns true if technology() === 'webfont', because pseudo-elements
	 * are always inherently supported by the CSS/Webfont technology.
	 *
	 * @since 4.0.0
	 * @link https://fontawesome.com/how-to-use/on-the-web/advanced/css-pseudo-elements CSS Pseudo-Elements and Font Awesome
	 * @throws ConfigCorruptionException
	 * @return boolean
	 */
	public function pseudo_elements() {
		$options = $this->options();
		$this->validate_options( $options );

		return $options['pseudoElements'];
	}

	/**
	 * Internal use only, not part of this plugin's public API.
	 *
	 * @internal
	 * @ignore
	 */
	protected function specified_preference_or_default( $preference, $default ) {
		return array_key_exists( 'value', $preference ) ? $preference['value'] : $default;
	}

	/**
	 * Enqueues the JavaScript bundle that is the React app for the admin
	 * settings page as well as the conflict detection reporter.
	 *
	 * The same bundle will be enqueued for both purposes. When enqueued, it
	 * must be configured to indicate which React components to mount in the DOM,
	 * which may be either, both, or neither.
	 *
	 * Internal use only, not part of this plugin's public API.
	 *
	 * @internal
	 * @ignore
	 */
	public function maybe_enqueue_admin_assets() {
		add_action(
			'admin_enqueue_scripts',
			function( $hook ) {
				$should_enable_icon_chooser = $this->should_icon_chooser_be_enabled( $hook );

				try {
					if ( $this->detecting_conflicts() || $hook === $this->screen_id || $should_enable_icon_chooser ) {
						$this->enqueue_admin_js_assets( $should_enable_icon_chooser );
					}

					if ( $hook === $this->screen_id ) {
						$this->maybe_refresh_releases();

						wp_localize_script(
							self::ADMIN_RESOURCE_HANDLE,
							self::ADMIN_RESOURCE_LOCALIZATION_NAME,
							array_merge(
								$this->common_data_for_js_bundle(),
								array(
									'showAdmin'            => true,
									'onSettingsPage'       => true,
									'clientPreferences'    => $this->client_preferences(),
									'releases'             => array(
										'available'        => $this->release_provider()->versions(),
										'latest_version_5' => $this->latest_version_5(),
										'latest_version_6' => $this->latest_version_6(),
									),
									'pluginVersion'        => FontAwesome::PLUGIN_VERSION,
									'preferenceConflicts'  => $this->conflicts_by_option(),
									'v3DeprecationWarning' => $this->get_v3deprecation_warning_data(),
								)
							)
						);
					} elseif ( $should_enable_icon_chooser ) {
						wp_localize_script(
							self::ADMIN_RESOURCE_HANDLE,
							self::ADMIN_RESOURCE_LOCALIZATION_NAME,
							array_merge(
								$this->common_data_for_js_bundle(),
								array(
									'enableIconChooser' => true,
								)
							)
						);

						/**
						 * TODO: re-enable the possibility of integrating with TinyMCE
						 * even on pages where Gutenberg is also present.
						 * This is an initial fix for GitHub Issue: #133
						 * https://github.com/FortAwesome/wordpress-fontawesome/issues/133
						 *
						 * UPATE: Now that the bundles are building differently
						 * and external dependencies are working correctly, this
						 * is close to working (try loading a new post in Gutenberg
						 * with integration plugin-nu enabled). It requires disabling
						 * the dynamic import of the components style.css. In the
						 * case where we're already on Gutenberg page, it is not
						 * necessary to load it, so it should be easy to check for that.
						 *
						 * The remaining issue seems to be just determining into
						 * which editor the shortcode should be inserted. When
						 * running plugin-nu, activating the Icon Chooser from either
						 * Gutenberg or the plugin-nu's TinyMCE editor, the shortcode
						 * is always inserted into to the TinyMCE editors. Seems
						 * like that should be easy to resolve when there's time
						 * and priority to continue investigating.
						 */
						if ( ! $this->is_gutenberg_page() ) {
							// These are needed for the Tiny MCE Classic Editor.
							add_action(
								'media_buttons',
								function() {
									printf(
										/* translators: 1: open button tag and icon tag 2: close button tag */
										esc_html__(
											'%1$sAdd Font Awesome%2$s',
											'font-awesome'
										),
										'<button type="button" onclick="__FontAwesomeOfficialPlugin__openIconChooserModal()" class="button font-awesome-icon-chooser-media-button"><i class="fab fa-font-awesome-flag"></i> ',
										'</button>'
									);
								},
								99
							);

							add_action(
								'before_wp_tiny_mce',
								function() {
									printf( '<div id="font-awesome-icon-chooser-container"></div>' );
								},
								99
							);
						}
					} else {
						wp_localize_script(
							self::ADMIN_RESOURCE_HANDLE,
							self::ADMIN_RESOURCE_LOCALIZATION_NAME,
							$this->common_data_for_js_bundle()
						);
					}

					/**
					 * There are some vendor dependencies in WP5 that create globals
					 * as side effects. We might use those in our JS bundle and
					 * we need to make sure that we don't accidently change the global
					 * version that other themes or plugins might be depending upon.
					 *
					 * Here's the recommendation we're following here:
					 * https://make.wordpress.org/core/2018/12/06/javascript-packages-and-interoperability-in-5-0-and-beyond/
					 */
					$vendor_globals = array( '_', 'React', 'ReactDOM', 'moment' );

					$originals_global = '__originalsBeforeFontAwesome';

					$originals = array_map(
						function ( $var ) {
							return "$var: window.$var";
						},
						$vendor_globals
					);

					$capture_vendor_global_originals_script = sprintf(
						'window.%1$s = { %2$s }',
						$originals_global,
						implode( ',', $originals )
					);

					wp_add_inline_script(
						self::ADMIN_RESOURCE_HANDLE,
						$capture_vendor_global_originals_script,
						'before'
					);

					$original_restore_conditions = array_map(
						function ( $var ) {
							return "if(window.__originalsBeforeFontAwesome.$var){window.$var = window.__originalsBeforeFontAwesome.$var}";
						},
						$vendor_globals
					);

					wp_add_inline_script(
						self::ADMIN_RESOURCE_HANDLE,
						implode( ' ', $original_restore_conditions ),
						'after'
					);
				} catch ( Exception $e ) {
					notify_admin_fatal_error( $e );
				} catch ( Error $e ) {
					notify_admin_fatal_error( $e );
				}
			}
		);

		if ( $this->detecting_conflicts() && current_user_can( 'manage_options' ) ) {
			foreach ( array( 'wp_enqueue_scripts', 'login_enqueue_scripts' ) as $action ) {
				add_action(
					$action,
					function () {
						try {
							$current_screen             = get_current_screen();
							$should_enable_icon_chooser = $this->should_icon_chooser_be_enabled( $current_screen );

							$this->enqueue_admin_js_assets( $should_enable_icon_chooser );

							wp_localize_script(
								self::ADMIN_RESOURCE_HANDLE,
								self::ADMIN_RESOURCE_LOCALIZATION_NAME,
								array_merge(
									$this->common_data_for_js_bundle(),
									array(
										'onSettingsPage' => false,
										'showAdmin'      => false,
										'showConflictDetectionReporter' => true,
									)
								)
							);
						} catch ( Exception $e ) {
							notify_admin_fatal_error( $e );
						} catch ( Error $e ) {
							notify_admin_fatal_error( $e );
						}
					}
				);
			}
		}
	}

	/**
	 * Enqueues the entrypoint JavaScript index.js, and declares relevant js
	 * dependencies.
	 *
	 * @param bool $with_icon_chooser
	 * @ignore
	 * @internal
	 * @return string $main_js_handle
	 */
	private function enqueue_admin_js_assets( $with_icon_chooser ) {
		global $wp_version;

		$enable_icon_chooser = boolval( $with_icon_chooser );

		$deps = array();

		/**
		 * If we're on a recent enough version of WordPress 5, then the supporting
		 * libraries are adequate for us to use as externals.
		 *
		 * For earlier versions, we'll need to load our own compatibility bundle,
		 * and disable Gutenberg integration, since our compatibility bundle
		 * uses a newer version of React than what would be available in WordPress
		 * Core in that earlier version.
		 */
		if ( $this->compat_js_required() ) {
			$wp4_compat_resource_handle = self::ADMIN_RESOURCE_HANDLE . '-compat';

			wp_enqueue_script(
				$wp4_compat_resource_handle,
				trailingslashit( FONTAWESOME_DIR_URL ) . 'compat-js/build/compat.js',
				array(),
				self::PLUGIN_VERSION,
				true
			);

			// We need our main bundle to depend on the compat bundle.
			array_push( $deps, $wp4_compat_resource_handle );
		} else {
			$deps = array_merge( $deps, array( 'react', 'react-dom', 'wp-i18n', 'wp-element', 'wp-components', 'wp-api-fetch' ) );

			/**
			 * We don't need these Gutenberg dependencies unless we're on a Gutenberg
			 * page. Declaring them unnecessarily (when not on a Gutenberg page)
			 * has resulted in conflict for at least one other plugin: RankMath.
			 *
			 * See: https://wordpress.org/support/topic/plugin-conflicts-with-rankmath
			 */
			if ( $enable_icon_chooser && $this->is_gutenberg_page() ) {
				$deps = array_merge( $deps, array( 'wp-blocks', 'wp-editor', 'wp-rich-text', 'wp-block-editor' ) );
			}
		}

		if ( $enable_icon_chooser ) {
			/**
			 * TODO: re-enable the case where TinyMCE and Gutenberg are present on the same
			 * page load. For now, we're eliminating that case because
			 * some customers experienced Gutenberg failures on pages where both
			 * editors were active.
			 *
			 * If we're not on a Gutenberg (as plugin) or Block Editor (as WP 5 Core editor),
			 * then we want to enable our TinyMCE integration. We'll initialize it
			 * on the wp_tiny_mce_init action hook.
			 *
			 * According to the docs:
			 * "Fires after tinymce.js is loaded, but before any TinyMCE editor instances are created."
			 *
			 * So we expect this to only fire once, even if multiple instances of the editor
			 * are added to a single page.
			 *
			 * If TinyMCE is not present or not active, then this action hook will
			 * never be fired and thus our TinyMCE integration will never be setup,
			 * which is what we want.
			 */
			add_action( 'wp_tiny_mce_init', array( $this, 'print_classic_editor_icon_chooser_setup_script' ) );
		}

		wp_enqueue_script(
			self::ADMIN_RESOURCE_HANDLE,
			trailingslashit( $this->get_webpack_asset_url_base() ) . 'index.js',
			$deps,
			self::PLUGIN_VERSION,
			true
		);
	}

	/**
	 * Internal use only, not part of this plugin's public API.
	 *
	 * @ignore
	 * @internal
	 */
	public function common_data_for_js_bundle() {
		return array(
			'apiNonce'                      => wp_create_nonce( 'wp_rest' ),
			'apiUrl'                        => rest_url( self::REST_API_NAMESPACE ),
			'restApiNamespace'              => self::REST_API_NAMESPACE,
			'rootUrl'                       => rest_url(),
			'detectConflictsUntil'          => $this->detect_conflicts_until(),
			'unregisteredClients'           => $this->unregistered_clients(),
			'showConflictDetectionReporter' => $this->detecting_conflicts(),
			'settingsPageUrl'               => $this->settings_page_url(),
			'activeAdminTab'                => $this->active_admin_tab(),
			'options'                       => $this->options(),
			'webpackPublicPath'             => trailingslashit( FONTAWESOME_DIR_URL ) . 'admin/build/',
			'usingCompatJs'                 => $this->compat_js_required(),
			'isGutenbergPage'               => $this->is_gutenberg_page(),
		);
	}

	/**
	 * Enqueues a kit loader <script>.
	 *
	 * Internal use only, not part of this plugin's public API.
	 *
	 * A proper kit loader <script>  looks like this:
	 *
	 * <script src="https://kit.fontawesome.com/deadbeef00.js" crossorigin="anonymous"></script>
	 *
	 * where deadbeef00 is the kitToken
	 *
	 * @ignore
	 * @internal
	 * @throws ConfigCorruptionException if the kit_token is not a string
	 */
	public function enqueue_kit( $kit_token ) {
		if ( ! is_string( $kit_token ) ) {
			throw new ConfigCorruptionException();
		}

		foreach ( array( 'wp_enqueue_scripts', 'admin_enqueue_scripts', 'login_enqueue_scripts' ) as $action ) {
			$enqueue_command = new FontAwesome_Command(
				function () use ( $kit_token ) {
					try {
						// phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion
						wp_enqueue_script(
							FontAwesome::RESOURCE_HANDLE,
							trailingslashit( FONTAWESOME_KIT_LOADER_BASE_URL ) . $kit_token . '.js',
							array(),
							null,
							false
						);

						/**
						 * Kits have built-in support for detecting conflicts, but we need to
						 * inject some configuration to turn it on. We will do that by manipulating
						 * the FontAwesomeKitConfig global property.
						 */
						if ( fa()->detecting_conflicts() ) {
							/**
							 * Kits Conflict Detection expects this value to be in milliseconds
							 * since the unix epoch.
							 */
							$detect_conflicts_until = fa()->detect_conflicts_until() * 1000;

							$script_content = <<< EOT
window.__FontAwesome__WP__KitConfig__ = {
	detectConflictsUntil: ${detect_conflicts_until}
}

Object.defineProperty(window, 'FontAwesomeKitConfig', {
	enumerable: true,
	configurable: false,
	get() { return window.__FontAwesome__WP__KitConfig__ },
	set( newValue ) {
		var newValueCopy = Object.assign({}, newValue)
		window.__FontAwesome__WP__KitConfig__ = Object.assign(newValueCopy, window.__FontAwesome__WP__KitConfig__)
	}
})
EOT;

							wp_add_inline_script(
								FontAwesome::RESOURCE_HANDLE,
								$script_content,
								'before'
							);
						}
					} catch ( Exception $e ) {
						notify_admin_fatal_error( $e );
					} catch ( Error $e ) {
						notify_admin_fatal_error( $e );
					}
				}
			);
			add_action(
				$action,
				array( $enqueue_command, 'run' )
			);
		}

		$script_loader_tag_command = new FontAwesome_Command(
			function ( $html, $handle ) {
				$revised_html = $html;

				/**
				 * Set the crossorigin attr to ensure that the Origin header is
				 * by the browser when the kit loader script is loaded.
				 * Needed for authorization.
				 */
				if ( self::RESOURCE_HANDLE === $handle ) {
					$revised_html = preg_replace(
						'/<script[\s]+(.*?)>/',
						'<script crossorigin="anonymous" \1>',
						$revised_html
					);
				}

				return $revised_html;
			}
		);

		add_filter(
			'script_loader_tag',
			array( $script_loader_tag_command, 'run' ),
			11,
			2
		);

		if ( $this->detecting_conflicts() ) {
			$this->apply_detection_ignore_attr();
		}

		$this->common_enqueue_actions();
	}

	/**
	 * Enqueues <script> or <link> resources to load from Font Awesome 5 free or pro cdn.
	 *
	 * Internal use only, not part of this plugin's public API.
	 *
	 * @internal
	 * @ignore
	 * @param $options
	 * @param FontAwesome_ResourceCollection $resource_collection
	 * @throws ConfigCorruptionException
	 */
	public function enqueue_cdn( $options, $resource_collection ) {
		if ( ! array_key_exists( 'pseudoElements', $options ) ) {
			throw new ConfigCorruptionException();
		}

		if ( ! array_key_exists( 'usePro', $options ) ) {
			throw new ConfigCorruptionException();
		}

		if ( ! array_key_exists( 'version', $options ) ) {
			throw new ConfigCorruptionException();
		}

		if ( ! ( array_key_exists( 'technology', $options ) && ( 'svg' === $options['technology'] || 'webfont' === $options['technology'] ) ) ) {
			throw new ConfigCorruptionException();
		}

		$resources = $resource_collection->resources();

		$conflict_detection_enqueue_command = new FontAwesome_Command(
			function () {
				// phpcs:ignore WordPress.WP.EnqueuedResourceParameters
				wp_enqueue_script(
					FontAwesome::RESOURCE_HANDLE_CONFLICT_DETECTOR,
					FontAwesome::CONFLICT_DETECTOR_SOURCE,
					array( FontAwesome::ADMIN_RESOURCE_HANDLE ),
					null,
					true
				);
			}
		);

		if ( $this->detecting_conflicts() && current_user_can( 'manage_options' ) ) {
			// Enqueue the conflict detector.
			foreach ( array( 'wp_enqueue_scripts', 'admin_enqueue_scripts', 'login_enqueue_scripts' ) as $action ) {
				add_action(
					$action,
					array( $conflict_detection_enqueue_command, 'run' ),
					PHP_INT_MAX
				);
			}

			$this->apply_detection_ignore_attr();
		}

		if ( ! isset( $resources['all'] ) ) {
			throw new ConfigCorruptionException();
		}

		$all_source    = $resources['all']->source();
		$all_integrity = $resources['all']->integrity_key();

		if ( 'webfont' === $options['technology'] ) {

			foreach ( array( 'wp_enqueue_scripts', 'admin_enqueue_scripts', 'login_enqueue_scripts' ) as $action ) {
				add_action(
					$action,
					function () use ( $all_source ) {
						// phpcs:ignore WordPress.WP.EnqueuedResourceParameters
						wp_enqueue_style( self::RESOURCE_HANDLE, $all_source, null, null );
					}
				);
			}

			// Filter the <link> tag to add the integrity and crossorigin attributes for completeness.
			add_filter(
				'style_loader_tag',
				function( $html, $handle ) use ( $all_integrity ) {
					if ( in_array( $handle, array( self::RESOURCE_HANDLE ), true ) ) {
								return preg_replace(
									'/\/>$/',
									'integrity="' . $all_integrity .
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

			if ( ! array_key_exists( 'compat', $options ) ) {
				throw new ConfigCorruptionException();
			}

			$version = $resource_collection->version();

			if ( $options['compat'] ) {
				if ( ! isset( $resources['v4-shims'] ) ) {
					throw new ConfigCorruptionException();
				}

				$v4_shims_source    = $resources['v4-shims']->source();
				$v4_shims_integrity = $resources['v4-shims']->integrity_key();

				/**
				 * Enqueue v4 compatibility as late as possible, though still within the normal script enqueue hooks.
				 * We need the @font-face override, especially to appear after any unregistered loads of Font Awesome
				 * that may try to declare a @font-face with a font-family of "FontAwesome".
				 */
				foreach ( array( 'wp_enqueue_scripts', 'admin_enqueue_scripts', 'login_enqueue_scripts' ) as $action ) {
					add_action(
						$action,
						function () use ( $v4_shims_source, $v4_shims_integrity, $options, $version ) {
							// phpcs:ignore WordPress.WP.EnqueuedResourceParameters
							wp_enqueue_style( self::RESOURCE_HANDLE_V4SHIM, $v4_shims_source, null, null );

							/**
							 * Version 6 Beta 3 is when some new compatiblity accommodations were introduced, built into all.css.
							 * So this @font-face override is only useful for enqueuing V5. The new stuff in V6 supercedes it.
							 */
							if ( version_compare( $version, '6.0.0-beta3', '<' ) ) {
								$license_subdomain = boolval( $options['usePro'] ) ? 'pro' : 'use';
								$font_face_content = $this->build_legacy_font_face_overrides_for_v4( $license_subdomain, $version );
								wp_add_inline_style(
									self::RESOURCE_HANDLE_V4SHIM,
									$font_face_content
								);
							}
						},
						PHP_INT_MAX
					);
				}

				// Filter the <link> tag to add the integrity and crossorigin attributes for completeness.
				// Not all resources have an integrity_key for all versions of Font Awesome, so we'll skip this for those
				// that don't.
				if ( ! is_null( $v4_shims_integrity ) ) {
					add_filter(
						'style_loader_tag',
						function ( $html, $handle ) use ( $v4_shims_integrity ) {
							if ( self::RESOURCE_HANDLE_V4SHIM === $handle ) {
								return preg_replace(
									'/\/>$/',
									'integrity="' . $v4_shims_integrity .
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
			foreach ( array( 'wp_enqueue_scripts', 'admin_enqueue_scripts', 'login_enqueue_scripts' ) as $action ) {
				add_action(
					$action,
					function () use ( $all_source, $options ) {
						// phpcs:ignore WordPress.WP.EnqueuedResourceParameters
						wp_enqueue_script( self::RESOURCE_HANDLE, $all_source, null, null, false );

						if ( $options['pseudoElements'] ) {
							wp_add_inline_script( self::RESOURCE_HANDLE, 'FontAwesomeConfig = { searchPseudoElements: true };', 'before' );
						}
					}
				);
			}

			// Filter the <script> tag to add additional attributes for integrity, crossorigin, defer.
			add_filter(
				'script_loader_tag',
				function ( $tag, $handle ) use ( $all_integrity ) {
					if ( self::RESOURCE_HANDLE === $handle ) {
						$extra_tag_attributes = 'defer crossorigin="anonymous"';

						if ( ! is_null( $all_integrity ) ) {
							$extra_tag_attributes .= ' integrity="' . $all_integrity . '"';
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

			if ( $options['compat'] ) {
				if ( ! isset( $resources['v4-shims'] ) ) {
					throw new ConfigCorruptionException();
				}

				$v4_shims_source    = $resources['v4-shims']->source();
				$v4_shims_integrity = $resources['v4-shims']->integrity_key();

				foreach ( array( 'wp_enqueue_scripts', 'admin_enqueue_scripts', 'login_enqueue_scripts' ) as $action ) {
					add_action(
						$action,
						function () use ( $v4_shims_source ) {
							// phpcs:ignore WordPress.WP.EnqueuedResourceParameters
							wp_enqueue_script( self::RESOURCE_HANDLE_V4SHIM, $v4_shims_source, null, null, false );
						}
					);
				}

				add_filter(
					'script_loader_tag',
					function ( $tag, $handle ) use ( $v4_shims_integrity ) {
						if ( self::RESOURCE_HANDLE_V4SHIM === $handle ) {
							$extra_tag_attributes = 'defer crossorigin="anonymous"';
							if ( ! is_null( $v4_shims_integrity ) ) {
								$extra_tag_attributes .= ' integrity="' . $v4_shims_integrity . '"';
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

		$this->common_enqueue_actions();
	}

	/**
	 * Internal use only.
	 *
	 * @ignore
	 * @internal
	 */
	private function apply_detection_ignore_attr() {
		require_once trailingslashit( FONTAWESOME_DIR_PATH ) . 'includes/ignored-handles.php';

		add_filter(
			'style_loader_tag',
			function( $html, $handle ) {
				if (
					in_array(
						$handle,
						array_merge(
							array( self::RESOURCE_HANDLE, self::RESOURCE_HANDLE_V4SHIM ),
							handles_ignored_for_conflict_detection()
						),
						true
					)
				) {
					return preg_replace(
						'/<link[\s]+(.*?)>/',
						'<link ' . self::CONFLICT_DETECTION_IGNORE_ATTR . ' \1>',
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
				if (
					in_array(
						$handle,
						array_merge(
							array(
								self::RESOURCE_HANDLE,
								self::RESOURCE_HANDLE_V4SHIM,
								self::RESOURCE_HANDLE_CONFLICT_DETECTOR,
								self::ADMIN_RESOURCE_HANDLE,
							),
							handles_ignored_for_conflict_detection()
						),
						true
					)
				) {
					return preg_replace(
						'/<script(.*?)>/',
						'<script ' . self::CONFLICT_DETECTION_IGNORE_ATTR . ' \1>',
						$html
					);
				} else {
					return $html;
				}
			},
			11, // later than the integrity and crossorigin attr filter.
			2
		);
	}

	/**
	 * Things that are done whether we are configured to enqueue Kit or CDN resources.
	 *
	 * Internal use only, not part of this plugin's public API.
	 *
	 * @ignore
	 * @internal
	 */
	private function common_enqueue_actions() {
		/**
		 * If we're upgrading from the v1 option schema and the previous
		 * removeUnregisteredClients feature had been enabled, then we will
		 * run some server-side detection like that old feature worked and
		 * add what we find to the new-style blocklist.
		 */
		if ( $this->old_remove_unregistered_clients ) {
			foreach ( array( 'wp_enqueue_scripts', 'admin_enqueue_scripts', 'login_enqueue_scripts' ) as $action ) {
				add_action(
					$action,
					function() {
						try {
							fa()->infer_unregistered_clients_by_resource_url();
						} catch ( Exception $e ) {
							notify_admin_fatal_error( $e );
						} catch ( Error $e ) {
							notify_admin_fatal_error( $e );
						}
					},
					PHP_INT_MAX - 1
				);
			}
		}

		/**
		 * We need to remove unregistered clients *after* they would have been
		 * enqueued, if they used the recommended mechanism of wp_enqueue_style
		 * and wp_enqueue_script (or the admin equivalents).
		 * We'll use priority PHP_INT_MAX in an effort to run as late as possible,
		 * hopefully allowing any unregistered client to have already enqueued
		 * itself so that our attempt to dequeue it will be successful.
		 */
		foreach ( array( 'wp_enqueue_scripts', 'admin_enqueue_scripts', 'login_enqueue_scripts' ) as $action ) {
			add_action(
				$action,
				function() {
					try {
						fa()->remove_blocklist();
					} catch ( Exception $e ) {
						notify_admin_fatal_error( $e );
					} catch ( Error $e ) {
						notify_admin_fatal_error( $e );
					}
				},
				PHP_INT_MAX
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
	 * Updates the unregistered clients option and blocklist with any enqueued
	 * styles or scripts whose src matches 'fontawesome' or 'font-awesome'.
	 *
	 * Internal use only, not part of this plugin's public API.
	 *
	 * @internal
	 * @ignore
	 */
	private function infer_unregistered_clients_by_resource_url() {
		$wp_styles  = wp_styles();
		$wp_scripts = wp_scripts();

		$collections = array(
			'style'  => $wp_styles,
			'script' => $wp_scripts,
		);

		$inferred_unregistered_clients = array();

		foreach ( $collections as $key => $collection ) {
			foreach ( $collection->registered as $handle => $details ) {
				if ( preg_match( '/' . self::RESOURCE_HANDLE . '/', $handle )
					|| preg_match( '/' . self::RESOURCE_HANDLE . '/', $handle ) ) {
					continue;
				}
				if ( strpos( $details->src, 'fontawesome' ) || strpos( $details->src, 'font-awesome' ) ) {
					/**
					 * For each match we find, we'll update both the main option's
					 * blocklist, and the unregistered clients option.
					 *
					 * We'll accumulate those matches in these data structures,
					 * and then call update_option() once for each option at the end.
					 */
					$md5 = md5( $details->src );

					$inferred_unregistered_clients[ $md5 ] = array(
						'src'     => $details->src,
						'type'    => $key,
						'blocked' => true,
					);
				}
			}
		}

		if ( count( $inferred_unregistered_clients ) > 0 ) {
			$prev_unreg_clients_option = get_option( self::CONFLICT_DETECTION_OPTIONS_KEY, array() );

			$new_option = array_merge(
				$prev_unreg_clients_option,
				array(
					'unregisteredClients' => $inferred_unregistered_clients,
				)
			);

			update_option(
				self::CONFLICT_DETECTION_OPTIONS_KEY,
				$new_option
			);
		}
	}

	/**
	 * Reports whether the given url should be blocked based on an
	 * md5 hash of its value.
	 *
	 * Internal use only, not part of this plugin's public API.
	 *
	 * @ignore
	 * @internal
	 * @return bool
	 */
	public function is_url_blocked( $url ) {
		return false !== array_search( md5( $url ), $this->blocklist(), true );
	}

	/**
	 * Reports whether the given inline data should be blocked based on an
	 * md5 hash of its contents.
	 *
	 * Internal use only, not part of this plugin's public API.
	 *
	 * @ignore
	 * @internal
	 * @return bool
	 */
	public function is_inline_data_blocked( $data ) {
		/**
		 * As of WordPress 5.2.2, both WP_Styles::print_inline_style and WP_Scripts::print_inline_script
		 * join (implode) the set of 'before' or 'after' resources with a newline, and then wrap the whole
		 * thing in newlines when printing the <style> or <script> tag. So that's how we'll have to
		 * reconstruct those inline resources here in order to produce the same input for the md5 function
		 * that would have been used by the Conflict Detector in the browser.
		 *
		 * Since this newline handling is not documenting as part of the spec, we're admittedly at some risk
		 * of this changing out from under us. At worst, if that implementation detail changes, it
		 * will just mean that we get a false negative when matching for blocked elements.
		 * Nothing will crash, but a conflict that we'd intended to catch will
		 * have slipped through. Our automated test suite should catch this, though.
		 */
		if ( $data && is_array( $data ) && count( $data ) > 0 ) {
			return false !== array_search( md5( "\n" . implode( "\n", $data ) . "\n" ), $this->blocklist(), true );
		} else {
			return false;
		}
	}

	/**
	 * Removes detect conflicts marked for blocking.
	 *
	 * Internal use only, not part of this plugin's public API.
	 *
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
	 * @internal
	 */
	protected function remove_blocklist() {
		if ( count( $this->blocklist() ) === 0 ) {
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
				foreach ( array( 'before', 'after' ) as $position ) {
					$data = $collection->get_data( $handle, $position );
					if ( $this->is_inline_data_blocked( $data ) ) {
						unset( $collection->registered[ $handle ]->extra[ $position ] );
					}
				}

				if ( $this->is_url_blocked( $details->src ) ) {
					call_user_func( "wp_dequeue_$type", $handle );
				}
			}
		}
	}

	/**
	 * Registers client preferences. This is the "front door" for registered clients,
	 * themes or plugins, that depend upon this Font Awesome plugin to load a
	 * compatible version of Font Awesome.
	 *
	 * The shape of the `$client_preferences` array parameter looks like this:
	 * ```php
	 *   array(
	 *     'technology'        => 'svg', // "svg" or "webfont"
	 *     'compat'            => true, // true or false
	 *     'pseudoElements'    => false, // true or false
	 *     'name'              => 'Foo Plugin', // (required)
	 *     'version'           => [
	 *                              [ '5.10.0', '>=']
	 *                            ]
	 *   )
	 * ```
	 *
	 * We use camelCase instead of snake_case for these keys, because they end up
	 * being passed to the JavaScript admin UI client encoded as json and camelCase
	 * is preferred for object properties in JavaScript.
	 *
	 * All preference specifications are optional, except `name`. The name provided
	 * here is how your theme or plugin will be identified in the Troubleshoot
	 * tab on the plugin settings page.
	 *
	 * Only the WordPress site owner can *determine* the Font Awesome configuration,
	 * using the plugin's admin settings page. This registration mechanism only
	 * allows plugin or theme developers to provide hints to the site owner as
	 * to their preferred configurations. These preferences are automatically checked
	 * any time the user makes configuration changes, providing immediate visual
	 * feedback before saving changes that might cause problems for your theme or
	 * plugin.
	 *
	 * Because this plugin also gives you an API for discovering those
	 * configured options at page load time, you can adapt to any configuration
	 * differences, or possibly issue your own admin notices to the site owner
	 * as may be appropriate.
	 *
	 * Hopefully, the site owner will be able to set a configuration that satisfies
	 * any preferences registered by their theme and any plugins that rely upon
	 * this Font Awesome plugin. However, similar to writing mobile responsive
	 * code where you don't control the size of display but can detect the screen
	 * size and adapt, here too, theme and plugin developers do not control the
	 * Font Awesome environment but should be prepared to adapt.
	 *
	 * The reason is that when any one theme or plugin *controls* or *determines*
	 * the Font Awesome configuration, it is very likely to produce conflicts for
	 * others. This plugin provides a coordination service to significantly increase
	 * the likelihood that everyone has a reliable Font Awesome environment.
	 *
	 * <h3>Maximize Compatibility</h3>
	 *
	 * Here is a checklist for maximizing compatibility.
	 *
	 * - Write your plugin or theme to works just as well with either Webfont or
	 *   SVG technology.
	 *
	 *     There may be a good reason that you need to insist on SVG. For example,
	 *     you might be building a page designer that includes a feature for
	 *     for visually composing icons with Power Transforms, Layering, or Text,
	 *     all features that are only avaialble in SVG. For that feature to work
	 *     in your theme or plugin, the site owner must configure SVG, not Webfont.
	 *
	 *     That may be a good use case for registering a preference for SVG. It
	 *     will aid your communication with the site owner, increasingly the
	 *     likelihood that they'll avoid mis-configuring Font Awesome.
	 *
	 *     However, a tradeoff will be that using your theme or plugin is that much
	 *     less compatible with others. For example, some themes or plugins reference
	 *     icons as CSS pseudo-elements (not recommended, but it's common).
	 *     Pseudo-elements can be enabled under the SVG technology, but there can
	 *     be some significant performance problems with SVG Pseudo-elements.
	 *
	 *     Summary: you may have a good reason to try and insist on SVG over Webfont,
	 *     but your code might be running on a WordPress site where some other theme
	 *     or plugin assumes a similar good reason for insisting on Webfont over
	 *     SVG. We're trying to work together here to make it more delightful for
	 *     the site owner to get our code up and running painlessly. Consider the
	 *     tradeoffs carefully any time you think it's necessary to insist on
	 *     a particular Font Awesome configuration.
	 *
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
	 * The `version` key in the $client_preferences array should contain one element
	 * per version constraint, where each individual constraint is itself an array
	 * of arguments that can be passed as the second and third arguments to the
	 * standard PHP `version_compare` function. The constraints will be ANDed together.
	 *
	 * For example, the following means "prefer a Font Awesome version greater than
	 * or equal to 5.10.0."
	 *
	 * ```php
	 *   [
	 *     [ '5.10.0', '>=']
	 *   ]
	 * ```
	 *
	 * Your theme may add this if you prefer to use Duotone
	 * style icons, since Duotone was first released in Font Awesome 5.10.0.
	 *
	 * The following means "greater than or equal to 5.10.0 AND strictly less than 6.0.0".
	 *
	 * ```php
	 *   [
	 *     [ '5.10.0', '>='],
	 *     [ '6.0.0', '<']
	 *   ]
	 * ```
	 *
	 * <h3>Additional Notes on Specific Preferences</h3>
	 *
	 * - `compat`
	 *
	 *   This was previously called 'v4Compat'. If older code uses v4Compat, it will be taken as the value for v4Compat.
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
	 *   and there are multiple `font-family` names. So the compat feature of this plugin also "shims" those
	 *   hardcoded version 4 `font-family` names so that they will use the corresponding Font Awesome 5 webfont files.
	 *
	 *   There have been some changes across major versions at the level of unicode differences. For example,
	 *   the glyph associated with the v4 icon named "diamond" with unicode f219 appears in FA5 and FA6
	 *   as the icon named "gem" with unicode f3a5. That glyph looked like the "precious stone" diamond.
	 *
	 *   The glyph associated with the icon named "diamond" and unicode f3a5 in FA5 and FA6 is
	 *   like the diamond as a suit in playing cards.
	 *
	 *   Without all of the compatibility assets to fix up such mappings, any old pseudo-elements that
	 *   used the v4 font-family of "FontAwesome" with a unicode of f219, when rendered using the FA5 or
	 *   FA6 fonts, will get the "suit" diamond instead of the "precious stone" diamond.
	 *
	 *   In general, a key improvement in v6 is much more comprehensive compatibility with pseudo-elements that may
	 *   have been defined using font-family or unicode values from older versions. This option enables all of
	 *   the various compatibility accommodations.
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
	 * @param array $client_preferences
	 * @throws ClientPreferencesSchemaException
	 */
	public function register( $client_preferences ) {
		if ( ! array_key_exists( 'name', $client_preferences ) ) {
			throw new ClientPreferencesSchemaException();
		}

		$updated_client_preferences = $client_preferences;

		if ( array_key_exists( 'v4Compat', $client_preferences ) ) {
			$v4_compat = $client_preferences['v4Compat'];

			if ( array_key_exists( 'compat', $client_preferences ) ) {
				$compat = $client_preferences['compat'];

				if ( $compat !== $v4_compat ) {
					throw new ClientPreferencesSchemaException();
				}
			}

			$updated_client_preferences['compat'] = $v4_compat;
		}

		$this->client_preferences[ $client_preferences['name'] ] = $updated_client_preferences;
	}

	/**
	 * Runs a GraphQL query against the Font Awesome GraphQL API.
	 *
	 * It accepts a GraphQL query string like 'query { releases { version } }' and returns
	 * the json encoded body of response from the API server when the response
	 * has an HTTP status of 200. Otherwise, it throws an exception whose
	 * message, if non-null, is appropriate for displaying in the WordPress admin ui
	 * to an admin user.
	 *
	 * Requests to the Font Awesome API server will automatically be authorized
	 * by the WordPress site owner's API Token if they have added one through the
	 * plugin's settings page. The API Token is used to retrieve a short-lived
	 * access_token, and that that access_token is used for subsequent API requests.
	 *
	 * Refreshing an expired access_token using the API Token is also handled
	 * automatically, when necessary.
	 *
	 * Each API Token has any number of authorization scopes on it. Most fields
	 * in the GraphQL schema have a `public` scope, and so do not require an
	 * API Token at all.
	 *
	 * For example, the following query lists all icons in the latest
	 * version of Font Awesome, with various metadata properties, including an
	 * icon's membership in Font Awesome Pro and/or Font Awesome Free. All fields
	 * in this query are in the `public` scope.
	 *
	 * ```
	 * query {
	 *   release(version:"latest") {
	 *     icons {
	 *       id
	 *       label
	 *       membership {
	 *         free
	 *         pro
	 *       }
	 *       shim {
	 *         id
	 *         name
	 *         prefix
	 *       }
	 *       styles
	 *       unicode
	 *     }
	 *   }
	 * }
	 * ```
	 *
	 * When the site owner has configured an API Token that includes
	 * the `kits_read` scope, the following query would retrieve the name and
	 * version properites for each kit in that authenticated account:
	 *
	 * ```
	 * query {
	 *   me {
	 *     kits {
	 *       name
	 *       version
	 *     }
	 *   }
	 * }
	 * ```
	 *
	 * <h3>Error Handling</h3>
	 *
	 * Errors that prevent the API server from handling the query will result
	 * in thrown exceptions.
	 *
	 * If the query is resolved and the request returns with an HTTP 200 status,
	 * there may still be GraphQL errors encoded in the response.
	 *
	 * For example, if the site owner has not added an API Token, then requests
	 * to the API will only have `public` scope. In that case, any GraphQL schema fields
	 * that would require some higher privilege will be resolved as `null`, and
	 * the response body will include errors indicating the resolution failure.
	 *
	 * For example, if the above kits query were made without an API Token having
	 * the `kits_read` scope, then the following response would be returned:
	 *
	 * ```json
	 * {
	 *   "data":{
	 *     "me":null
	 *   },
	 *   "errors":[
	 *     {
	 *       "locations":[
	 *         {"column":0,"line":1}
	 *       ],
	 *       "message":"unauthorized",
	 *       "path":["me"]
	 *     }
	 *   ]
	 * }
	 * ```
	 *
	 * It is possible that a query could select both authorized and unauthorized
	 * fields. The `data` property in the response will include all of those
	 * field resolutions, and the `error` property--if present--will include
	 * any errors during resolution, such as attempting to resolve fields without
	 * proper authorization. This is all standard GraphQL: this plugin just passes
	 * through the GraphQL query and passes back the GraphQL response without
	 * modification.
	 *
	 * See documentation about [GraphQL validation](https://graphql.org/learn/validation/)
	 * for more on error handling.
	 *
	 * <h3>Adding Authorization</h3>
	 *
	 * If you know that you need access to some part of the schema that requires some
	 * additional authorization scope, the way to get that is to instruct the site owner
	 * to copy an API Token from their fontawesome.com account and add it to this
	 * plugin's configuration on the plugin's settings page.
	 *
	 * As of version 4.0.0 of this plugin, the only non-public portions of the
	 * GraphQL schema that are relevant to usage in WordPress involve querying
	 * the user's kits, which requires the `kits_read` scope, as shown above.
	 *
	 * <h3>Additional Resources</h3>
	 *
	 * For more on how to construct GraphQL queries, [see here](https://graphql.org/learn/queries/).
	 *
	 * A reference on the Font Awesome GraphQL API is [available here](https://fontawesome.com/how-to-use/with-the-api).
	 *
	 * You can explore the Font Awesome GraphQL API using an app like [GraphiQL](https://www.electronjs.org/apps/graphiql).
	 * Point it at `https://api.fontawesome.com`.
	 *
	 * @since 4.0.0
	 * @param string $query_string a GraphQL query document
	 * @throws ApiTokenMissingException
	 * @throws ApiTokenEndpointRequestException
	 * @throws ApiTokenEndpointResponseException
	 * @throws ApiTokenInvalidException
	 * @throws AccessTokenStorageException
	 * @throws ApiRequestException
	 * @return string json encoded response body when the API server response
	 *     has a HTTP 200 status.
	 */
	public function query( $query_string ) {
		return $this->metadata_provider()->metadata_query( $query_string );
	}

	/**
	 * Process a shortode.
	 *
	 * Internal use only, not part of this plugin's public API.
	 *
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
				'name'            => '',
				'prefix'          => self::DEFAULT_PREFIX,
				'class'           => '',
				'style'           => null,
				'aria-hidden'     => null,
				'aria-label'      => null,
				'aria-labelledby' => null,
				'title'           => null,
				'role'            => null,
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

		$classes    = rtrim( implode( ' ', array( $prefix_and_name_classes, $atts['class'] ) ) );
		$class_attr = "class=\"$classes\"";

		$tag_attrs = array( $class_attr );

		foreach ( array( 'style', 'aria-hidden', 'role', 'title', 'aria-label', 'aria-labelledby' ) as $attr_name ) {
			if ( isset( $atts[ $attr_name ] ) ) {
				array_push( $tag_attrs, $attr_name . '="' . $atts[ $attr_name ] . '"' );
			}
		}

		return '<i ' . implode( ' ', $tag_attrs ) . '></i>';
	}

	/**
	 * Sets a v3 deprecation warning.
	 *
	 * Internal use only, not part of this plugin's public API.
	 *
	 * @deprecated Only for temporary internal plugin use while deprecating
	 * @ignore
	 * @internal
	 * @param array $data
	 * @return void
	 */
	public function set_v3_deprecation_warning_data( $data ) {
		set_transient( self::V3DEPRECATION_TRANSIENT, $data );
	}

	/**
	 * Retrieves transient warning data for v3 icon name usage.
	 *
	 * Internal use only, not part of this plugin's public API.
	 *
	 * @deprecated Only for temporary internal plugin use while deprecating
	 * @return array
	 * @ignore
	 * @internal
	 */
	public function get_v3deprecation_warning_data() {
		return get_transient( self::V3DEPRECATION_TRANSIENT );
	}

	/**
	 * Dismisses the v3 deprecation warning for a while.
	 *
	 * Internal use only, not part of this plugin's public API.
	 *
	 * @deprecated Only for temporary internal plugin use while deprecating
	 * @ignore
	 * @internal
	 */
	public function snooze_v3deprecation_warning() {
		delete_transient( self::V3DEPRECATION_TRANSIENT );
		set_transient( self::V3DEPRECATION_TRANSIENT, array( 'snooze' => true ), self::V3DEPRECATION_EXPIRY );
	}

	/**
	 * Allows a test subclass to mock the release provider.
	 *
	 * Internal use only, not part of this plugin's public API.
	 *
	 * @ignore
	 * @internal
	 */
	protected function release_provider() {
		return fa_release_provider();
	}

	/**
	 * Allows a test subclass to mock the release provider.
	 *
	 * Internal use only, not part of this plugin's public API.
	 *
	 * @ignore
	 * @internal
	 */
	protected function metadata_provider() {
		return fa_metadata_provider();
	}

	/**
	 * Allows a test subclass to mock the version.
	 *
	 * Internal use only, not part of this plugin's public API.
	 *
	 * @ignore
	 * @internal
	 */
	protected function plugin_version() {
		return self::PLUGIN_VERSION;
	}

	/**
	 * Internal use only, not part of this plugin's public API.
	 *
	 * @internal
	 * @ignore
	 */
	private function get_webpack_asset_url_base() {
		return trailingslashit( FONTAWESOME_DIR_URL ) . 'admin/build';
	}

	/**
	 * Internal use only, not part of this plugin's public API.
	 *
	 * @internal
	 * @ignore
	 * @return bool
	 */
	private function should_icon_chooser_be_enabled( $screen_id ) {
		if ( ! is_string( $screen_id ) ) {
			return false;
		}

		return false !== array_search( $screen_id, $this->icon_chooser_screens, true );
	}

	/**
	 * Internal use only, not part of this plugin's public API.
	 *
	 * Code borrowed from Freemius SDK by way of Benjamin Intal on Stack Overflow,
	 * under GPL. Thanks Benjamin! Hey everybody, get the Stackable plugin to do
	 * cool stuff with Font Awesome in your Blocks!
	 *
	 * See: https://github.com/Freemius/wordpress-sdk
	 * See: https://wordpress.stackexchange.com/questions/309862/check-if-gutenberg-is-currently-in-use
	 * See: https://wordpress.org/plugins/stackable-ultimate-gutenberg-blocks/
	 *
	 * @internal
	 * @ignore
	 */
	private function is_gutenberg_page() {
		if ( function_exists( 'is_gutenberg_page' ) && is_gutenberg_page() ) {
			// The Gutenberg plugin is on.
			return true;
		}
		$current_screen = get_current_screen();
		if ( is_object( $current_screen ) && method_exists( $current_screen, 'is_block_editor' ) && $current_screen->is_block_editor() ) {
			// Gutenberg page on 5+.
			return true;
		}

		return false;
	}

	/**
	 * Internal use only, not part of this plugin's public API.
	 *
	 * We can't guarantee the timing of when this global hook will be set.
	 * So if we find that it's already set, we'll invoke it. Otherwise, we'll
	 * assign a truthy value to it to indicate that it should be invoked as
	 * soon as the hook is ready.
	 *
	 * @internal
	 * @ignore
	 */
	public function print_classic_editor_icon_chooser_setup_script() {
		?>
	<script type="text/javascript">
		if( window.tinymce ) {
			if( typeof window.__FontAwesomeOfficialPlugin__setupClassicEditorIconChooser === 'function' ) {
				window.__FontAwesomeOfficialPlugin__setupClassicEditorIconChooser()
			} else {
				window.__FontAwesomeOfficialPlugin__setupClassicEditorIconChooser = true
			}
		}
	</script>
		<?php
	}

	/**
	 * Internal use only, not part of this plugin's public API.
	 *
	 * @internal
	 * @ignore
	 */
	private function compat_js_required() {
		global $wp_version;

		return ! version_compare( $wp_version, '5.4', '>=' );
	}

	/**
	 * Internal use only, not part of this plugin's public API.
	 *
	 * This builds font-face rules to override the v4 font-family
	 * name of "FontAwesome", pointing to current assets. This is only
	 * needed for CDN setups in FA5. FA 5 kits have their own built-in
	 * version of this. FA6 (since beta3) has improved compatibility handling
	 * that does this and more, both in FA6 kits and Free CDN.
	 *
	 * @internal
	 * @ignore
	 */
	private function build_legacy_font_face_overrides_for_v4( $license_subdomain, $version ) {
		return <<< EOT
@font-face {
font-family: "FontAwesome";
font-display: block;
src: url("https://${license_subdomain}.fontawesome.com/releases/v${version}/webfonts/fa-brands-400.eot"),
		url("https://${license_subdomain}.fontawesome.com/releases/v${version}/webfonts/fa-brands-400.eot?#iefix") format("embedded-opentype"),
		url("https://${license_subdomain}.fontawesome.com/releases/v${version}/webfonts/fa-brands-400.woff2") format("woff2"),
		url("https://${license_subdomain}.fontawesome.com/releases/v${version}/webfonts/fa-brands-400.woff") format("woff"),
		url("https://${license_subdomain}.fontawesome.com/releases/v${version}/webfonts/fa-brands-400.ttf") format("truetype"),
		url("https://${license_subdomain}.fontawesome.com/releases/v${version}/webfonts/fa-brands-400.svg#fontawesome") format("svg");
}

@font-face {
font-family: "FontAwesome";
font-display: block;
src: url("https://${license_subdomain}.fontawesome.com/releases/v${version}/webfonts/fa-solid-900.eot"),
		url("https://${license_subdomain}.fontawesome.com/releases/v${version}/webfonts/fa-solid-900.eot?#iefix") format("embedded-opentype"),
		url("https://${license_subdomain}.fontawesome.com/releases/v${version}/webfonts/fa-solid-900.woff2") format("woff2"),
		url("https://${license_subdomain}.fontawesome.com/releases/v${version}/webfonts/fa-solid-900.woff") format("woff"),
		url("https://${license_subdomain}.fontawesome.com/releases/v${version}/webfonts/fa-solid-900.ttf") format("truetype"),
		url("https://${license_subdomain}.fontawesome.com/releases/v${version}/webfonts/fa-solid-900.svg#fontawesome") format("svg");
}

@font-face {
font-family: "FontAwesome";
font-display: block;
src: url("https://${license_subdomain}.fontawesome.com/releases/v${version}/webfonts/fa-regular-400.eot"),
		url("https://${license_subdomain}.fontawesome.com/releases/v${version}/webfonts/fa-regular-400.eot?#iefix") format("embedded-opentype"),
		url("https://${license_subdomain}.fontawesome.com/releases/v${version}/webfonts/fa-regular-400.woff2") format("woff2"),
		url("https://${license_subdomain}.fontawesome.com/releases/v${version}/webfonts/fa-regular-400.woff") format("woff"),
		url("https://${license_subdomain}.fontawesome.com/releases/v${version}/webfonts/fa-regular-400.ttf") format("truetype"),
		url("https://${license_subdomain}.fontawesome.com/releases/v${version}/webfonts/fa-regular-400.svg#fontawesome") format("svg");
unicode-range: U+F004-F005,U+F007,U+F017,U+F022,U+F024,U+F02E,U+F03E,U+F044,U+F057-F059,U+F06E,U+F070,U+F075,U+F07B-F07C,U+F080,U+F086,U+F089,U+F094,U+F09D,U+F0A0,U+F0A4-F0A7,U+F0C5,U+F0C7-F0C8,U+F0E0,U+F0EB,U+F0F3,U+F0F8,U+F0FE,U+F111,U+F118-F11A,U+F11C,U+F133,U+F144,U+F146,U+F14A,U+F14D-F14E,U+F150-F152,U+F15B-F15C,U+F164-F165,U+F185-F186,U+F191-F192,U+F1AD,U+F1C1-F1C9,U+F1CD,U+F1D8,U+F1E3,U+F1EA,U+F1F6,U+F1F9,U+F20A,U+F247-F249,U+F24D,U+F254-F25B,U+F25D,U+F267,U+F271-F274,U+F279,U+F28B,U+F28D,U+F2B5-F2B6,U+F2B9,U+F2BB,U+F2BD,U+F2C1-F2C2,U+F2D0,U+F2D2,U+F2DC,U+F2ED,U+F328,U+F358-F35B,U+F3A5,U+F3D1,U+F410,U+F4AD;
}
EOT;
	}
}

/**
 * Convenience global function to get a singleton instance of the main Font Awesome
 * class.
 *
 * @since 4.0.0
 *
 * @see FontAwesome::instance()
 * @returns FontAwesome
 */
function fa() {
	return FontAwesome::instance();
}

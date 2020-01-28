<?php
namespace FortAwesome;

/**
 * Class FontAwesome_Preference_Conflict_Detector
 */
class FontAwesome_Preference_Conflict_Detector {

	protected static function resolve_version( $configured_option, $current_preference, $latest_version ) {
		// If the version given as configured_option is 'latest', as it may be for
		// a kit, then we'll resolve that 'latest' into whatever actual version
		// is known as the latest right now.

		$resolved_version = ('latest' === $configured_option && is_string( $latest_version ) )
			? $latest_version
			: $configured_option;

		return FontAwesome::satisfies( $resolved_version, $current_preference );
	}

	/**
	 * Because all of our options currently require strict equality, all or nothing, to be considered "satisfied" or
	 * non-conflicted, except for version:
	 * Use function_exists to see if something like resolve_$option exists, if not, assume equality.
	 * If it does, then delegate to it. We would need to delegate to it for the version option, because
	 * clients should be able to specify an expression to represent version compatibility.
	 * 
	 * The $latest_version param will be passed as the third argument to any resolver
	 * functions, and should be set to the actual version number of the latest version known,
	 * like '5.12.0', not the word 'latest'. It is the value that can be used
	 * when checking whether a version preference is satisfied when 'latest' is the
	 * configured version in a kit.
	 *
	 * Internal use only. Not part of this plugin's public API.
	 *
	 * @internal
	 * @ignore
	 * @since 4.0.0
	 */
	public static function detect( $configured_options = [], $client_preferences = [], $latest_version = NULL ) {
		return array_reduce(
			array_keys( $configured_options ),
			function( $carry, $option ) use ( $configured_options, $client_preferences, $latest_version ) {
				$resolve_method_candidate = 'resolve_' . $option;
				if ( isset( $client_preferences[ $option ] ) ) {
					if ( method_exists( __CLASS__, $resolve_method_candidate ) ) {
						return call_user_func(
							array( __CLASS__, $resolve_method_candidate ),
							$configured_options[ $option ],
							$client_preferences[ $option ],
							$latest_version
						) ? $carry : array_merge( $carry, [ $option ] );
					} else {
						return $configured_options[ $option ] === $client_preferences[ $option ]
						? $carry
						: array_merge( $carry, [ $option ] );
					}
				} else {
					return $carry;
				}
			},
			[]
		);
	}
}




<?php
namespace FortAwesome;

/**
 * Class FontAwesome_Preference_Conflict_Detector
 */
class FontAwesome_Preference_Conflict_Detector {

	protected static function resolve_version( $configured_option, $current_preference ) {
		return FontAwesome::satisfies( $configured_option, $current_preference );
	}

	/**
	 * Because all of our options currently require strict equality, all or nothing, to be considered "satisfied" or
	 * non-conflicted, except for version:
	 * Use function_exists to see if something like resolve_$option exists, if not, assume equality.
	 * If it does, then delegate to it. We would need to delegate to it for the version option, because
	 * clients should be able to specify an expression to represent version compatibility.
	 *
	 * Internal only. Clients should * not invoke this directly.
	 *
	 * @internal
	 * @ignore
	 * @since 4.0.0
	 */
	public static function detect( $configured_options, $client_preferences ) {
		return array_reduce(
			array_keys( $configured_options ),
			function( $carry, $option ) use ( $configured_options, $client_preferences ) {
				$resolve_method_candidate = 'resolve_' . $option;
				if ( isset( $client_preferences[ $option ] ) ) {
					if ( method_exists( __CLASS__, $resolve_method_candidate ) ) {
						return call_user_func(
							array( __CLASS__, $resolve_method_candidate ),
							$configured_options[ $option ],
							$client_preferences[ $option ]
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




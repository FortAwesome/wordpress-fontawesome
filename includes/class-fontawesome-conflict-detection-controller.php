<?php
namespace FortAwesome;

use \WP_REST_Controller, \WP_REST_Response, \WP_Error, \Error, \Exception;

/**
 * Module for this plugin's Conflict Detection controller
 *
 * @noinspection PhpIncludeInspection
 */

// phpcs:ignore Generic.Commenting.DocComment.MissingShort
/**
 * @ignore
 */

if ( ! class_exists( 'FontAwesome_Conflict_Detection_Controller' ) ) :

	/**
	 * Controller class for REST endpoint
	 */
	class FontAwesome_Conflict_Detection_Controller extends WP_REST_Controller {

		// phpcs:ignore Generic.Commenting.DocComment.MissingShort
		/**
		 * @ignore
		 */
		private $plugin_slug = null;

		// phpcs:ignore Generic.Commenting.DocComment.MissingShort
		/**
		 * @ignore
		 */
		protected $namespace = null;

		// phpcs:ignore Generic.Commenting.DocComment.MissingShort
		/**
		 * @ignore
		 */
		protected $valid_attrs = ['type', 'technology', 'href', 'src', 'innerText', 'tagName'];

		// phpcs:ignore Generic.Commenting.DocComment.MissingShort
		/**
		 * @ignore
		 */
		public function __construct( $plugin_slug, $namespace ) {
			$this->plugin_slug = $plugin_slug;
			$this->namespace   = $namespace;
		}

		// phpcs:ignore Generic.Commenting.DocComment.MissingShort
		/**
		 * @ignore
		 */
		public function register_routes() {
			$route_base = 'report-conflicts';

			register_rest_route(
				$this->namespace,
				'/' . $route_base,
				array(
					array(
						'methods'             => 'POST',
						'callback'            => array( $this, 'report_conflicts' ),
						'permission_callback' => function() {
							return current_user_can( 'manage_options' ); },
						'args'                => array(),
					),
				)
			);
		}

		/**
		 * Get conflicts.
		 *
		 * @param WP_REST_Request $request Full data about the request.
		 * @return WP_Error|WP_REST_Response
		 */
		public function report_conflicts( $request ) {
			try {
        if ( ! fa()->detecting_conflicts() ) {
				  return new WP_REST_Response( null, 404 );
        }

				$item = $this->prepare_item_for_database( $request );
				
				if ( is_null( $item ) ) {
					return new WP_Error( 'bad_request', "incorrect data schema", array( 'status' => 400 ) );
				}
        
        $prev_option = get_option( FontAwesome::UNREGISTERED_CLIENTS_OPTIONS_KEY );

        $new_option_value = null;

        if( $prev_option ) {
          $new_option_value = array_merge(
            $prev_option,
            $item
          );
        } else {
          $new_option_value = $item;
        }

        if( $this->option_has_changes( $prev_option, $new_option_value ) ) {
          if ( update_option(
            FontAwesome::UNREGISTERED_CLIENTS_OPTIONS_KEY,
            $new_option_value
          ) ) {
				    return new WP_REST_Response( null, 204 );
          } else {
				    return new WP_Error( 'update_failed', "We weren't able to update the unregistered clients data.", array( 'status' => 400 ) );
          }
        } else {
				  return new WP_REST_Response( null, 204 );
        }
			} catch ( Exception $e ) {
				// TODO: distinguish between problems that happen with the Font Awesome plugin versus those that happen in client plugins.
				return new WP_Error( 'caught_exception', 'Whoops, there was a critical exception with Font Awesome.', array( 'status' => 500 ) );
			} catch ( Error $error ) {
				return new WP_Error( 'caught_error', 'Whoops, there was a critical error with Font Awesome.', array( 'status' => 500 ) );
			}
		}

    // phpcs:ignore Generic.Commenting.DocComment.MissingShort
		/**
		 * @ignore
		 */
		protected function prepare_item_for_database( $request ) {
			$body = $request->get_json_params();

			if( ! \is_array( $body ) || count( $body ) === 0 ) {
				return null;
			}

			$validated = array();

			foreach( $body as $md5 => $attrs) {
				if(! is_string( $md5 ) || ! strlen( $md5 ) === 32 ) {
					return null;
				}

				if(! is_array( $attrs ) ) {
					return null;
				}

				$validated[$md5] = array();

				foreach( $attrs as $key => $value) {
					if( in_array( $key, $this->valid_attrs, true ) ) {
						$validated[$md5][$key] = $value;
					}
				}
			}

			return $validated;
    }
    
    protected function option_has_changes($old, $new) {
      if( ! is_array( $old ) ) {
        return TRUE;
      }

      if( count( array_diff_key( $old, $new ) ) > 0  || count( array_diff_key( $new, $old ) ) > 0 ) {
        return TRUE;
      } else {
        foreach( $old as $key => $value )  {
          if( count( array_diff_assoc( $old[$key], $new[$key] ) ) > 0 ) {
            return TRUE;
          }
        }

        return FALSE;
      }
    }
	}

endif; // end class_exists.

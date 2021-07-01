<?php

namespace FortAwesome;

function fa_tiny_mce_setup() {
	add_filter( 'mce_external_plugins', function( $plugin_array ) {
		$js_file = 'editor-support.tinymce.js';

		$plugin_array['font-awesome-official'] = plugins_url( $js_file, trailingslashit( FONTAWESOME_DIR_PATH ) . "editors/build/$js_file" );
		return $plugin_array;
	} );

	add_action( 'media_buttons', function() {
		printf( '<button type="button" class="button" id="font-awesome-icon-chooser-media-button">' . '<i class="fab fa-font-awesome-flag"></i> %s' . '</button>', __( 'Add Font Awesome', 'font-awesome' ) );	
	}, 99 );

	add_action( 'after_wp_tiny_mce', function() {
		printf( '<div id="font-awesome-icon-chooser-container"></div>');
	}, 99);

	$resource = fa()->cdn_url_with_sri();

	$cdn_url = isset($resource['cdnUrl']) ? $resource['cdnUrl'] : null;
	$integrity = isset($resource['integrity']) ? $resource['integrity'] : null;

	wp_localize_script(
		'wp-tinymce',
		'__FontAwesomeOfficialPlugin_EditorSupportConfig__',
		array(
			'version'  => fa()->version(),
			'usingPro' => fa()->pro() ? true : false,
			'usingKit' => fa()->using_kit() ? true : false,
			'kitToken' => fa()->kit_token(),
			'cdnUrl'   => $cdn_url,
			'integrity' => $integrity,
			'apiNonce' => wp_create_nonce( 'wp_rest' ),
			'apiUrl'   => rest_url( FontAwesome::REST_API_NAMESPACE ),
			'restApiNamespace' => FontAwesome::REST_API_NAMESPACE,
			'rootUrl'  => rest_url()
		)
	);
}

fa_tiny_mce_setup();

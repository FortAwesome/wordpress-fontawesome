<?php

namespace FortAwesome;

add_filter( 'mce_external_plugins', function( $plugin_array) {
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

wp_localize_script(
	'wp-tinymce',
	'__FontAwesomeOfficialPlugin_EditorSupportConfig__',
	array(
		'version'  => fa()->version(),
		'usingPro' => fa()->pro() ? true : false,
		'usingKit' => fa()->using_kit() ? true : false,
		// TODO: replace with the kitToken() API method when available.
		'kitToken' => fa()->options()['kitToken'],
		// TODO: replace this placeholder cdnUrl with a real computation, based on what's happening in fa()->enqueue_cdn()
		'cdnUrl'   => fa()->technology() === 'webfont' ? 'https://example.com/all.css' : 'https://example.com/all.js',
		'apiNonce' => wp_create_nonce( 'wp_rest' ),
		'apiUrl'   => rest_url( FontAwesome::REST_API_NAMESPACE )
	)
);

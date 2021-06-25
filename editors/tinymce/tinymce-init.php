<?php

// add new buttons
add_filter( 'mce_buttons', function ( $buttons ) {
	error_log("DEBUG: buttons: " . print_r($buttons, true) );
   array_push( $buttons, 'separator', 'font-awesome-official' );
   return $buttons;
} );

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

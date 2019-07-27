/*
 *
 * sources: https://mikejolley.com/2012/12/21/using-the-new-wordpress-3-5-media-uploader-in-plugins/
 *          https://plugins.trac.wordpress.org/browser/wp-excel-2-db/trunk/admin/js/wp-excel-2-db-admin.js
 *
 */

jQuery( document ).ready( function( $ ) {

	// Uploading files
	var file_frame;
	if( typeof wp.media != 'undefined' ) {
		var wp_media_post_id = wp.media.model.settings.post.id; // Store the old id

		jQuery( '#upload_kregen_button' ).on( 'click', function( event ) {

			event.preventDefault();
			// Create the media frame.
			file_frame = wp.media( {
				title: 'Select csv file',
				button: {
					text: 'Use this file',
				},
				library: {
					type: "application" // limits the frame to show only application files
				},
				multiple: false // Set to true to allow multiple files to be selected
			} );

			// When an file is selected, run a callback.
			file_frame.on( 'select', function() {
				// We set multiple to false so only get one file from the uploader
				attachment = file_frame.state().get( 'selection' ).first().toJSON();
				convertFile( attachment.id );
				// Do something with attachment.id and/or attachment.url here
				jQuery( '#file_status' ).html( 'Please Wait Until Processing ... <i class="fa fa-spinner fa-spin"></i>' );
				jQuery( '#file_log' ).html( '' );

				// Restore the main post ID
				wp.media.model.settings.post.id = wp_media_post_id;
			} );

				// Finally, open the modal
				file_frame.open();
		} );

		// Restore the main ID when the add media button is pressed
		jQuery( 'a.add_media' ).on( 'click', function() {
			wp.media.model.settings.post.id = wp_media_post_id;
		} );

/*		jQuery( '#reset_nodelist_button' ).on( 'click', function( event ) {
			event.preventDefault();
			jQuery.ajax( {
				type: "POST",
				url: ajaxurl,
				data: {
					action: "wmn_reset_nodelist"
				},
				success: function( response ) {
					var result = JSON.parse( response );
					if ( result['status'] == 'success' ) {
						jQuery( '#file_log' ).html( '<p>' + result['message'] + '</p>' );
					} else {
						jQuery( '#file_log' ).html( '<p>ERROR! Unable to reset master nodelist file!</p>' );
					}
					jQuery( '#file_status' ).html( '' );
				}
			} );
		} ); */

	}
} );


function convertFile( attachment_id ) {
	jQuery.ajax( {
		type: "POST",
		url: ajaxurl,
		data: {
			action: "dnd_import_kregen",
			attachment_id: attachment_id,
		},
		success: function ( response ) {
			var result = JSON.parse( response );
			if( ( result['status'] == 'success' ) && ( result['type'] == 'incomplete' ) ) {
				jQuery( "#file_log" ).append( '<p>' + result['message'] + '</p>' );
				return false;
			} else if( ( result['status'] == 'success' ) && ( result['type'] == 'complete' ) ) {
				jQuery( '#file_status' ).html( '' );
				jQuery( "#file_log" ).html( '<p>' + result['message'] + '</p>' );
				return true;
			} else {
				jQuery( '#file_status' ).html( '' );
				jQuery( "#file_log" ).append( '<p>' + result['message'] + '</p>' );
				return true;
			}
		}
	} );
}

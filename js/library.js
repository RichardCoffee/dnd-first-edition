

function dnd1e_get_content( action, div, out, wait ) {
	var async  = ( typeof( wait ) === 'undefined' ) ? false : !wait;
	var retval = false;
	jQuery.ajax({
		url: ajaxurl,
		type: 'post',
		data: {
			action: action,
			info:   out,
		},
		async: async, // jQuery default is true, or not to wait
		success: function( result, textStatus, jqXHR ) {
			if ( result ) {
				$( div ).html( result );
				retval = true;
			}
		},
		error: function( jqXHR, textStatus, errorThrown ) { // FIXME: log all errors
			alert( 'Server Error: ' + errorThrown );
		}
	});
	return retval;
}

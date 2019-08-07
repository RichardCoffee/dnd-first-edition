

function dnd1e_get_content( action, div, out ) {
	var retval = false;
	jQuery.ajax({
		url: ajaxurl,
		type: 'post',
		data: {
			action: action,
			info:   out,
		},
		success: function( result, textStatus, jqXHR ) {
console.log(textStatus);
console.log(result);
			if ( result ) {
				$( '#'+div ).html( result );
				retval = true;
			}
		},
		error: function( jqXHR, textStatus, errorThrown ) { // FIXME: log all errors
			alert( 'Server Error: ' + errorThrown );
		}
	});
	return retval;
}

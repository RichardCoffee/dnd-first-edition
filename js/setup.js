

jQuery( document ).ready( function( $ ) {

	$('input.assignment').click( function( event ) {
		if ( this.checked ) {
			$('#dnd1e_character_assignment_button').prop('disabled', false );
		} else {
			var state = false;
			$("input.assignment:checked").each( function() {
				state = true;
			} );
			if ( ! state ) {
				$('#dnd1e_character_assignment_button').prop('disabled', true );
			}
		}
	} );

	$( '#dnd1e_character_assignment_button' ).click( function( event ) {
		var assigned = [];
		$("input.assignment:checked").each( function() {
			var name = this.id.split('_');
			assigned.push( name[2] );
		} );
		dnd1e_get_content( 'wp_ajax_dnd1e_combat_party', 'combat_party', JSON.stringify( assigned ) );
	} );

} );

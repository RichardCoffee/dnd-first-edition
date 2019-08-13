let dnd1e = {
	assigned: [],
}

jQuery( document ).ready( function( $ ) {

	$('#dnd1e_character_clear_button').prop('disabled', true );

	$('input.assignment').click( function( event ) {
		if ( this.checked ) {
			$('#dnd1e_character_assignment_button').prop('disabled', false );
		} else {
			var state = false;
			$("input.assignment:checked").each( function() { state = true; } );
			if ( ! state ) { $('#dnd1e_character_assignment_button').prop('disabled', true ); }
		}
	} );

	$('#dnd1e_character_assignment_button').click( function( event ) {
		$("input.assignment:checked").each( function() {
			var name = this.id.split('_');
			dnd1e.assigned.push( name[2] );
		} );
		dnd1e_get_content( 'dnd1e_combat_party', 'combat_party', JSON.stringify( dnd1e.assigned ) );
		$('#dnd1e_character_clear_button').prop('disabled', false );
	} );

	$('#dnd1e_character_clear_button').click( function( event ) {
		$( '#combat_party' ).html( '' );
		dnd1e.assigned = [];
		$('#dnd1e_character_clear_button').prop('disabled', true );
	} );

} );

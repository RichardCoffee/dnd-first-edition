<?php

class DND_Combat_Plugin extends DND_Combat_Combat {


#	protected $casting = array();
#	public    $effects = array();
#	protected $enemy   = array();
#	protected $holding = array();
#	protected $party   = array();
#	protected $range   = 2000;
#	protected $rounds  = 3;
#	protected $segment = 1;


	public function __construct( array $args = array() ) {
		# when advancing segment
		# add_action( 'dnd1e_combat_init', [ $this, 'new_segment_housekeeping' ], 5 );
	}

	public function __toString() {
		return 'Plugin class';
	}


}

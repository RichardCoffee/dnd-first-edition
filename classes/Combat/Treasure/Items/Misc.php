<?php

class DND_Combat_Treasure_Items_Misc extends DND_Combat_Treasure_Items_Item {


#	protected $active  = false;
	protected $charges = 0;
#	protected $effect  = '';
#	protected $filters = array();
#	protected $gp      = 0;
#	private   $key     = '';
#	protected $link    = '';
#	protected $name    = '';
#	protected $owner   = '';
#	private   $prefix  = '';
#	protected $symbol  = '';
	protected $type    = array( 'Potion' );
#	public    $typepub = '';
#	protected $xp      = 0;


	public function __construct( array $args = array() ) {
		parent::__construct( $args );
	}


}

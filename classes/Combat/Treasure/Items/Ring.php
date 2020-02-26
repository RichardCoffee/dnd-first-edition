<?php

class DND_Combat_Treasure_Items_Ring extends DND_Combat_Treasure_Items_Item {


#	protected $active  = false;
#	protected $effect  = '';
#	protected $filters = array();
#	protected $gp      = 0;
#	private   $key     = '';
#	protected $link    = '';
#	protected $name    = '';
#	protected $owner   = '';
#	private   $prefix  = '';
#	protected $symbol  = '';
	protected $type    = array( 'Ring' );
#	public    $typepub = '';
#	protected $xp      = 0;


	public function __construct( array $args = array() ) {
		parent::__construct( $args );
	}


	/**  Commandline functions  **/

	protected function generate_index_line( $type ) {
		return "Ring of {$this->name}";
}


}

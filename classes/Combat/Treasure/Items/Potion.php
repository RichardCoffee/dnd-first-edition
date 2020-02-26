<?php

class DND_Combat_Treasure_Items_Potion extends DND_Combat_Treasure_Items_Item {


#	protected $active  = false;   // DND_Combat_Treasure_Items_Item
#	protected $data    = array(); // DND_Combat_Treasure_Items_Item
#	protected $effect  = '';      // DND_Combat_Treasure_Items_Item
	protected $fake    = array();
#	protected $filters = array(); // DND_Combat_Treasure_Items_Item
#	protected $gp      = 0;       // DND_Combat_Treasure_Items_Item
#	private   $key     = '';      // DND_Combat_Treasure_Items_Item
#	protected $link    = '';      // DND_Combat_Treasure_Items_Item
#	protected $name    = '';      // DND_Combat_Treasure_Items_Item
#	protected $owner   = '';      // DND_Combat_Treasure_Items_Item
#	private   $prefix  = '';      // DND_Combat_Treasure_Items_Item
#	protected $symbol  = '';      // DND_Combat_Treasure_Items_Item
	protected $type    = array( 'Potion' );
#	public    $typepub = '';      // DND_Combat_Treasure_Items_Item
#	protected $xp      = 0;       // DND_Combat_Treasure_Items_Item


	public function __construct( array $args = array() ) {
		parent::__construct( $args );
	}


	/**  Commandline functions  **/

	protected function generate_index_line( $type ) {
		if ( empty( $this->fake ) ) {
			$line = $this->generate_potion_name( $this->name );
			$line.= ( empty( $this->symbol ) ) ? "" : " : {$this->symbol}";
		} else {
			$line = "'" . $this->generate_potion_name( $this->fake['text'] ) . "'";
			$line.= ( empty( $this->fake['symbol'] ) ) ? "" : " : {$this->fake['symbol']}";
		}
		return $line;
	}

	protected function generate_potion_name( $name ) {
		if ( ( substr( $name, 0, 6 ) === 'Oil of' ) || ( substr( $name, 0, 10 ) === 'Philter of' ) ) {
			return $name;
		} else {
			return "Potion of $name";
		}
	}


}

<?php

class DND_Combat_Treasure_Items_Ammo extends DND_Combat_Treasure_Items_Item {


#	public    $active  = false;   //  DND_Combat_Treasure_Items_Item
	protected $bonus   = 0;
#	protected $effect  = '';      //  DND_Combat_Treasure_Items_Item
#	protected $filters = array(); //  DND_Combat_Treasure_Items_Item
#	protected $gp      = 0;       //  DND_Combat_Treasure_Items_Item
#	private   $key     = '';      //  DND_Combat_Treasure_Items_Item
#	protected $link    = '';      //  DND_Combat_Treasure_Items_Item
#	protected $name    = '';      //  DND_Combat_Treasure_Items_Item
#	protected $owner   = '';      //  DND_Combat_Treasure_Items_Item
#	private   $prefix  = '';      //  DND_Combat_Treasure_Items_Item
	protected $quan    = 0;
#	protected $symbol  = '';      //  DND_Combat_Treasure_Items_Item
#	protected $type    = array(); //  DND_Combat_Treasure_Items_Item
	protected $user    = array();
#	protected $xp      = 0;       //  DND_Combat_Treasure_Items_Item


	public function __construct( $args = array() ) {
		parent::__construct( $args );
		$this->filters = array(
			array( 'dnd1e_to_hit_object',       'adjustment_to_hit',    $this->bonus, 10, 3 ),
			array( 'dnd1e_weapon_damage_bonus', 'adjustment_to_damage', $this->bonus, 10, 3 ),
			array( 'dnd1e_origin_damage',       'track_quantity',       $this->quan,  10, 2 ),
		);
	}


	/**  Weapon functions  **/

	public function merge_gear_info( $weapon ) {
		$weapon = parent::weapon_merge_info( $weapon );
		$weapon['quan'] = $this->quan;
		if ( in_array( 'Sling', $this->user ) ) {
			$weapon['type']   = array( -3, -3, -2, -2, -1, 0, 0, 0, 2, 1, 3 );
			$weapon['damage'] = array( '1d4+1', '1d6+1', 'Yes' );
			$weapon['range']  = array( 50, 100, 200 );
		}
		return $weapon;
	}


	/**  Filter functions  **/

	public function adjustment_to_hit( $to_hit, $origin, $target, $delta ) {
		if ( $origin->get_key() === $this->owner ) {
			$to_hit -= $delta;
		}
		return $to_hit;
	}

	public function adjustment_to_damage( $damage, $origin, $target, $delta ) {
		if ( $origin->get_key() === $this->owner ) {
			$damage += $delta;
		}
		return $damage;
	}


	/**  Commandline functions  **/

	protected function generate_index_line( $type ) {
		$line = parent::generate_index_line( $type );
		if ( $this->quan > 0 ) {
			$line.= "\tNum: {$this->quan}";
		}
		return $line;
	}


}

<?php

class DND_Combat_Treasure_Items_Legacy extends DND_Combat_Treasure_Items_Weapon {


#	public    $active  = false;   //  DND_Combat_Treasure_Items_Item
#	protected $align   = '';      //  DND_Combat_Treasure_Items_Weapon
#	protected $bonus   = 0;       //  DND_Combat_Treasure_Items_Weapon
#	protected $comm    = '';      //  DND_Combat_Treasure_Items_Weapon
#	protected $effect  = '';      //  DND_Combat_Treasure_Items_Item
#	protected $ego     = 0;       //  DND_Combat_Treasure_Items_Weapon
#	protected $extra   = array(); //  DND_Combat_Treasure_Items_Weapon
#	protected $filters = array(); //  DND_Combat_Treasure_Items_Item
#	protected $gp      = 0;       //  DND_Combat_Treasure_Items_Item
#	protected $int     = 0;       //  DND_Combat_Treasure_Items_Weapon
#	private   $key     = '';      //  DND_Combat_Treasure_Items_Item
#	protected $langs   = 0;       //  DND_Combat_Treasure_Items_Weapon
	private   $legacy  = array();
#	protected $link    = '';      //  DND_Combat_Treasure_Items_Item
#	protected $name    = '';      //  DND_Combat_Treasure_Items_Item
#	protected $owner   = '';      //  DND_Combat_Treasure_Items_Item
#	protected $power   = '';      //  DND_Combat_Treasure_Items_Weapon
#	private   $prefix  = '';      //  DND_Combat_Treasure_Items_Item
#	protected $primary = array(); //  DND_Combat_Treasure_Items_Weapon
#	protected $purpose = '';      //  DND_Combat_Treasure_Items_Weapon
#	protected $symbol  = '';      //  DND_Combat_Treasure_Items_Item
#	protected $target  = '';      //  DND_Combat_Treasure_Items_Weapon
#	protected $type    = array(); //  DND_Combat_Treasure_Items_Item
#	protected $xp      = 0;       //  DND_Combat_Treasure_Items_Item


	public function __construct( $args = array() ) {
		parent::__construct( $args );
		$this->add_filter( [ 'dnd1e_origin_damage', 'legacy_weapon_bonus', 0, 10, 2 ] );
	}


	/**  Weapon functions  **/

	public function legacy_weapon_bonus( $damage, $origin, $delta ) {
		if ( $origin->get_key() === $this->owner ) {
			$bonus = min( intval( ceil( $origin->level / 4 ) ), 5 );
			if ( $bonus > $this->bonus ) {
				$this->bonus = $bonus;
#				$this->discover_legacy_power();
			}
		}
		return $damage;
	}

	private function discover_legacy_power() {
		$src = new DND_Combat_Treasure_Treasure;
		$prelim = array(
			'ego' => $this->bonus * 2,
			'restrict' => ':' . $this->align,
		);
		$step = array( 76, 84, 90, 95, 98, 100 );
		$args = $src->generate_special_weapon( $prelim, $step[ $this->bonus ] );
		$this->legacy[ $this->bonus ] = $args['powers'];
		$this->parse_powers( $this->merge_legacy( $args ) );
	}

	private function merge_legacy( $merge ) {
		$this->primary = array();
		$prime = array();
		foreach( $this->legacy as $step ) {
			$merge['ego']   = max( $merge['ego'],   $step['ego']   );
			$merge['langs'] = max( $merge['langs'], $step['langs'] );
			foreach( $step['primary'] as $primary ) {
			}
		}
		return $merge;
	}

	/**  Filter functions  **/


	/**  Commandline functions  **/

#	protected function generate_index_line( $type ) {
#		$line = parent::generate_index_line( $type );
#		return $line;
#	}


}

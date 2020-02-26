<?php

class DND_Combat_Treasure_Items_Weapon extends DND_Combat_Treasure_Items_Item {


#	public    $active  = false;   //  DND_Combat_Treasure_Items_Item
	protected $align   = 'neutral';
	protected $bonus   = 0;
	protected $comm    = '';
#	protected $data    = array(); //  DND_Combat_Treasure_Items_Item
#	protected $effect  = '';      //  DND_Combat_Treasure_Items_Item
	protected $ego     = 0;
	protected $extra   = array();
#	protected $filters = array(); //  DND_Combat_Treasure_Items_Item
#	protected $gp      = 0;       //  DND_Combat_Treasure_Items_Item
	protected $int     = 0;
#	private   $key     = '';      //  DND_Combat_Treasure_Items_Item
	protected $langs   = 0;
#	protected $link    = '';      //  DND_Combat_Treasure_Items_Item
#	protected $name    = '';      //  DND_Combat_Treasure_Items_Item
#	protected $owner   = '';      //  DND_Combat_Treasure_Items_Item
	protected $power   = '';
#	private   $prefix  = '';      //  DND_Combat_Treasure_Items_Item
	protected $primary = array();
	protected $purpose = '';
	protected $quan    = false;
#	protected $symbol  = '';      //  DND_Combat_Treasure_Items_Item
	protected $target  = '';
#	protected $type    = array(); //  DND_Combat_Treasure_Items_Item
#	protected $typepub = '';      //  DND_Combat_Treasure_Items_Item
#	protected $xp      = 0;       //  DND_Combat_Treasure_Items_Item


	public function __construct( $args = array() ) {
		parent::__construct( $args );
		if ( array_key_exists( 'powers', $args ) && ( ! ( $args['powers'] === 'none' ) ) ) {
			$this->parse_powers( $args['powers'] );
		}
		if ( is_numeric( $this->quan ) ) {
			$this->add_filter( array( 'dnd1e_origin_damage', 'track_quantity', $this->quan,  10, 2 ) );
		}
#if ( $this->key === 'DGT4_Trindle' ) $this->symbol = 'wide V';
	}

	protected function parse_powers( $powers ) {
		$this->parse_primary( $powers['primary'] );
		unset( $powers['primary'] );
		$this->parse_extraordinary( $powers['extra'] );
		unset( $powers['extra'] );
		if ( array_key_exists( 'purpose', $powers ) ) {
			$this->purpose = $powers['purpose']['purpose'];
			$this->power   = $powers['purpose']['power'];
			unset( $powers['purpose'] );
		}
		$this->parse_args( $powers );
	}

	protected function parse_primary( $primary ) {
		foreach( $primary as $power ) {
			if ( is_array( $power ) ) {
				$this->primary[] = "{$power['ability']} in a {$power['radius']} foot redius.";
			} else {
				$this->primary[] = $power;
			}
		}
	}

	protected function parse_extraordinary( $extra ) {
		foreach( $extra as $power ) {
			$this->extra[] = $power['ability'];
		}
	}


	/**  Weapon functions  **/

	public function merge_gear_info( $weapon ) {
		$weapon = parent::merge_gear_info( $weapon );
		$weapon['bonus'] = $this->bonus;
		return apply_filters( 'dnd1e_weapon_merge', $weapon );
	}


	/**  Filter functions  **/

	public function damage_die_multiplier( $damage, $origin, $target, $delta ) {
		if ( $origin->get_key() === $this->owner ) {
			if ( in_array( $this->effect, $target->vulnerable ) ) {
				if ( $target->name === "{$this->target} Dragon" ) {
					$damage *= $delta;
				}
			}
		}
		return $damage;
	}

	public function javelin_of_lightning_damage( $damage, $origin, $target, $delta ) {
		if ( $origin->get_key() === $this->owner ) {
			if ( ! in_array( 'electric', $target->immune ) ) {
				$damage += 20;
			}
		}
		return $damage;
	}

	public function javelin_of_lightning_range( $weapon, $delta ) {
		$weapon['range'] = array( 90, 90, 90 );
		return $weapon;
	}

	public function javelin_of_piercing_range( $weapon, $delta ) {
		$weapon['range'] = array( 60, 60, 60 );
		return $weapon;
	}

	public function sword_of_the_planes( $delta, $origin, $target, $unused ) {
		if ( $origin->get_key() === $this->owner ) {
			$delta = ( in_array( 'elemental', $target-vulnerable ) ) ? 2 : $delta;
			$delta = ( in_array( 'astral',    $target-vulnerable ) ) ? 3 : $delta;
			$delta = ( in_array( 'ethereal',  $target-vulnerable ) ) ? 3 : $delta;
			$delta = ( in_array( 'outer',     $target-vulnerable ) ) ? 4 : $delta;
		}
		return $delta;
	}

	public function sword_of_wounding( $damage, $origin, $target, $type, $unused ) {
		if ( $origin->get_key() === $this->owner ) {
			$combat = dnd1e()->combat;
			$this->data[ $combat->segment ] = $target->get_key();
		}
		return $damage;
	}

	public function sow_new_segment( $segment, $unused ) {
		$combat = dnd1e()->combat;
		foreach( $this->data as $seg => $target ) {
			if ( ( $seg + 100 ) > $segment ) continue;
			if ( ( ( $segment - $seg ) % 10 ) === 0 ) {
				$combat->object_damage_with_origin( null, $target, 1, $this->effect );
			}
		}
	}


	/**  Commandline functions  **/

	protected function generate_index_line( $type ) {
		$name = implode( ' ', array_reverse( explode( ',', $type ) ) );
		$line = ( in_array( 'Cursed', $this->type ) ) ? "'$name'" : $name;
		$line.= ' : ' . ( ( empty( $this->symbol ) ) ? "(no symbol)" : $this->symbol );
		return $line;
	}


}

<?php

class DND_Combat_Treasure_Items_Shield extends DND_Combat_Treasure_Items_Item {


	public    $active  = true;    //  DND_Combat_Treasure_Items_Item
	protected $bonus   = 0;
	protected $count   = 0;
	protected $defense = array();
#	protected $effect  = '';      //  DND_Combat_Treasure_Items_Item
#	protected $filters = array(); //  DND_Combat_Treasure_Items_Item
#	protected $gp      = 0;       //  DND_Combat_Treasure_Items_Item
#	private   $key     = '';      //  DND_Combat_Treasure_Items_Item
#	protected $link    = '';      //  DND_Combat_Treasure_Items_Item
#	protected $name    = '';      //  DND_Combat_Treasure_Items_Item
#	protected $owner   = '';      //  DND_Combat_Treasure_Items_Item
#	private   $prefix  = '';      //  DND_Combat_Treasure_Items_Item
#	protected $symbol  = '';      //  DND_Combat_Treasure_Items_Item
#	protected $type    = array(); //  DND_Combat_Treasure_Items_Item
#	protected $typepub = '';      //  DND_Combat_Treasure_Items_Item
#	protected $xp      = 0;       //  DND_Combat_Treasure_Items_Item


	public function __construct( $args = array() ) {
		parent::__construct( $args );
		$defaults = array(
			array( 'dnd1e_shield_type',   'shield_type',   $this->type[0], 10, 2 ),
			array( 'dnd1e_shield_bonus',  'shield_bonus',  $this->bonus,   10, 2 ),
			array( 'dnd1e_has_no_shield', 'not_active',    false,          10, 2 ),
			array( 'dnd1e_attack_made',   'count_attack',  $this->attacks, 10, 2 ),
			array( 'dnd1e_new_segment',   'reset_attacks', $this->count,   10, 1 ),
		);
		$this->filters = $this->remove_duplicate_filters( array_merge( $this->filters, $defaults ) );
		$this->randomize_filters();
#		$this->remove_filter( 'dnd1e_attack_made' );
		$this->set_count();
	}

	protected function shield_type( $type, $owner, $delta ) {
		if ( $owner->get_key() === $this->owner ) {
			return $delta;
		}
		return $type;
	}

	protected function shield_bonus( $bonus, $owner, $delta ) {
		if ( $owner->get_key() === $this->owner ) {
			if ( ( $bonus > -1 ) && ( $delta > -1 ) ) {
				$bonus = ( $bonus > $delta ) ? $bonus : $delta;
			} else { // Cursed items will take precedence
				$bonus = ( $bonus < $delta ) ? $bonus : $delta;
			}
		}
		return $bonus;
	}


	/**  Attack Count functions  **/

	protected function set_count() {
		$this->count = 0;
		switch( $this->type[0] ) {
			case 'Large':
				$this->count++;
			case 'Medium':
				$this->count++;
			case 'Small':
			default:
				$this->count++;
		}
	}

	protected function not_active( $no_shld, $owner, $delta ) {
		if ( $owner->get_key() === $this->owner ) {
			if ( count( $this->defense ) > $this->count ) return true;
		}
		return $no_shld;
	}

	protected function count_attack( $attacker, $segment, $delta ) {
		if ( $attacker->get_key() === $this->owner ) {
			$this->defense[] = $segment;
			return true;
		}
		return false;
	}

	protected function reset_attacks( $segment, $delta ) {
		$new = array();
		foreach( $this->defense as $seg ) {
			if ( ( $seg + 11 ) > $segment ) $new[] = $seg;
		}
		$this->defense = $new;
		return true;
	}

}

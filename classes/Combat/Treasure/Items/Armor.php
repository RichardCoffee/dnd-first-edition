<?php

class DND_Combat_Treasure_Items_Armor extends DND_Combat_Treasure_Items_Item {


	public    $active  = true;    // DND_Combat_Treasure_Items_Item
	protected $bonus   = 0;
#	protected $effect  = '';      // DND_Combat_Treasure_Items_Item
#	protected $filters = array(); // DND_Combat_Treasure_Items_Item
#	protected $gp      = 0;       // DND_Combat_Treasure_Items_Item
#	private   $key     = '';      // DND_Combat_Treasure_Items_Item
#	protected $link    = '';      // DND_Combat_Treasure_Items_Item
#	protected $name    = '';      // DND_Combat_Treasure_Items_Item
#	protected $owner   = '';      // DND_Combat_Treasure_Items_Item
#	private   $prefix  = '';      // DND_Combat_Treasure_Items_Item
#	protected $symbol  = '';      // DND_Combat_Treasure_Items_Item
#	protected $type    = array(); // DND_Combat_Treasure_Items_Item
#	protected $typepub = '';      // DND_Combat_Treasure_Items_Item
#	protected $xp      = 0;       // DND_Combat_Treasure_Items_Item


	public function __construct( $args = array() ) {
		parent::__construct( $args );
		$defaults = array(
			array( 'dnd1e_armor_armor',         'armor_armor',  $this->type[0], 10, 2 ),
			array( 'dnd1e_armor_bonus',         'armor_bonus',  $this->bonus,   10, 2 ),
			array( 'dnd1e_armor_saving_throws', 'armor_saving', $this->bonus,   10, 3 ),
		);
		$this->filters = $this->remove_duplicate_filters( array_merge( $this->filters, $defaults ) );
		$this->randomize_filters();
	}

	protected function armor_armor( $type, $owner, $delta ) {
		if ( $owner->get_key() === $this->owner ) {
			return $delta;
		}
		return $type;
	}

	protected function armor_bonus( $bonus, $owner, $delta ) {
		if ( $owner->get_key() === $this->owner ) {
			if ( ( $bonus > -1 ) && ( $delta > -1 ) ) {
				$bonus = ( $bonus > $delta ) ? $bonus : $delta;
			} else { // Cursed items will take precedence
				$bonus = ( $bonus < $delta ) ? $bonus : $delta;
			}
		}
		return $bonus;
	}

	protected function armor_saving( $base, $object, $effect, $delta ) {
		return $this->armor_bonus( $base, $object, $delta );
	}


	/**  Effect functions  **/

	protected function vulnerability( $target, $delta ) {
		if ( $target->get_key() === $this->owner ) {
			$this->turn_off();
			$this->bonus = 0;
			$this->type  = array();
			$this->owner = 'delete_me';
			return true;
		}
		return false;
	}


}

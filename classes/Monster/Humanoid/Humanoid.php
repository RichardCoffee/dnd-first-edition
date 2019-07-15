<?php

abstract class DND_Monster_Humanoid_Humanoid extends DND_Monster_Monster {


#	protected $alignment    = 'Neutral';
#	protected $appearing    = array( 1, 1, 0 );
#	protected $armor_class  = 10;
#	protected $armor_type   = 11;
	protected $attacks      = array( 'Weapon' => [ 1, 8, 0 ] );
	protected $fighter      = null;
#	protected $frequency    = 'Common';
#	protected $hp_extra     = 0;
#	protected $in_lair      = 0;
#	protected $initiative   = 1;
#	protected $intelligence = 'Animal';
#	protected $movement     = array( 'foot' => 12 );
#	protected $name         = 'Monster';
#	protected $psionic      = 'Nil';
#	protected $race         = 'Monster';
#	protected $reference    = 'Monster Manual page';
#	protected $resistance   = 'Standard';
#	protected $size         = 'Medium';
#	protected $specials     = array();
#	protected $treasure     = 'Nil';
#	protected $xp_value     = array();


	public function __construct( $args = array() ) {
		parent::__construct( $args );
		$this->load_fighter();
	}

	protected function determine_hit_dice() {
		$this->hit_dice = 1;
	}

	protected function load_fighter( $new = 'Fighter' ) {
		$data = $this->get_fighter_data();
		$create = 'DND_Character_' . $new;
		$this->fighter = new $create( $data );
		if ( ! empty( $this->fighter->weapons ) ) {
			$weapon = array_key_first( $this->fighter->weapons );
			$this->fighter->set_current_weapon( $weapon );
		}
	}

	protected function get_fighter_data() {
		$data = array(
			'ac_rows'    => $this->ac_rows,
			'experience' => 1,
			'hit_die'    => array( 'limit' => $this->hit_dice, 'size' => $this->hd_value ),
			'max_move'   => $this->movement['foot'],
			'movement'   => $this->movement['foot'],
			'name'       => $this->name,
			'race'       => $this->race,
			'stats'      => array( 'str' => 12, 'int' => 12, 'wis' => 12, 'dex' => 12, 'con' => 12, 'chr' => 12 ),
		);
		return apply_filters( 'humanoid_fighter_data', $data, get_class( $this ) );
	}



}

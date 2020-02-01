<?php

abstract class DND_Monster_Humanoid_Humanoid extends DND_Monster_Monster {


#	protected $ac_rows      = array(); // DND_Monster_Trait_Combat
#	protected $alignment    = 'Neutral';
#	protected $appearing    = array( 1, 1, 0 );
#	protected $armor_class  = 10;
#	protected $armor_type   = 11;
	protected $attacks      = array( 'Weapon' => [ 1, 8, 0 ] );
#	private   $combat_key   = '';      // DND_Monster_Trait_Combat
#	public    $current_hp   = -10000;
#	protected $description  = '';
	protected $fighter      = null;
#	protected $frequency    = 'Common';
#	protected $hd_minimum   = 1;
#	protected $hd_value     = 8;
#	protected $hit_dice     = 0;
#	protected $hit_points   = 0;
#	protected $hp_extra     = 0;
#	protected $in_lair      = 0;
#	protected $initiative   = 1;
#	protected $intelligence = 'Animal';
#	protected $magic_user   = null;
#	protected $movement     = array( 'foot' => 12 );
	protected $name         = 'Humanoid';
#	protected $psionic      = 'Nil';
	protected $race         = 'Humanoid';
#	protected $reference    = 'Monster Manual page';
#	protected $resistance   = 'Standard';
#	protected $saving       = array( 'fight' );
#	protected $segment      = 0;
#	protected $size         = 'Medium';
#	protected $specials     = array();
#	protected $to_hit_row   = array(); // DND_Monster_Trait_Combat
#	protected $treasure     = 'Nil';
#	protected $weap_allow   = array(); // DND_Character_Trait_Weapons
#	protected $weap_dual    = false;   // DND_Character_Trait_Weapons
#	protected $weapon       = array(); // DND_Character_Trait_Weapons
#	protected $weapons      = array(); // DND_Character_Trait_Weapons
#	protected $xp_value     = array();
	protected $extra        = array();


	public function __construct( $args = array() ) {
		if ( array_key_exists( 'fighter', $args ) ) {
			$this->fighter = unserialize( $args['fighter'] );
			unset( $args['fighter'] );
		} else {
			$this->load_fighter();
		}
		parent::__construct( $args );
	}

	protected function determine_hit_dice() {
		$this->hit_dice = 1;
	}

	protected function non_sequence_chance( $segment ) {
		return 100;
	}

	protected function is_sequence_attack( $check ) {
		return false;
	}

	protected function load_fighter( $new = 'Fighter' ) {
		$data = $this->get_fighter_data( $this->hit_dice );
		$create = 'DND_Character_' . $new;
		$this->fighter = new $create( $data );
		if ( ! empty( $this->fighter->weapons ) ) {
			$weapon = array_key_first( $this->fighter->weapons );
			$this->fighter->set_current_weapon( $weapon );
		}
	}

	protected function get_fighter_data( $level = 1 ) {
		$data = array(
			'ac_rows'    => $this->ac_rows,
			'experience' => 1,
			'hit_die'    => array( 'limit' => $this->hit_dice, 'size' => $this->hd_value ),
			'max_move'   => $this->movement['foot'],
			'movement'   => $this->movement['foot'],
			'name'       => $this->name,
			'race'       => $this->race,
			'stats'      => array(
				'str' => 12 + mt_rand( 1, 6 ),
				'int' => 12 + mt_rand( 1, 6 ),
				'wis' => 12 + mt_rand( 1, 6 ),
				'dex' => 12 + mt_rand( 1, 6 ),
				'con' => 12 + mt_rand( 1, 6 ),
				'chr' => 12 + mt_rand( 1, 6 ),
			),
		);
		return apply_filters( 'humanoid_fighter_data', $data );
	}

	protected function get_character_accouterments( DND_Character_Character $object, $chance = 0 ) {
		$data  = array();
		$treas = new DND_Combat_Treasure_Treasure;
		$accs  = $treas->acc_get_accouterments( $this, $chance );
		foreach( $accs as $item ) {
			switch( $item['type'] ) {
				case 'armor':
					
					break;
				case 'shields':
					
					break;
				case 'swords':
					
					break;
				case 'weapons':
					
					break;
				case 'potions':
					
					break;
				case 'scrolls':
					
					break;
				case 'rings':
					
					break;
				case 'none':
					break;
				default:
			}
			$this->extra[] = $item;
		}
if ( ! empty( $this->extra ) ) print_r( $this->extra );
	}


}

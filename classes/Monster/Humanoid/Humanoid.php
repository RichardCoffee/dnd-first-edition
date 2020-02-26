<?php

abstract class DND_Monster_Humanoid_Humanoid extends DND_Monster_Monster {


#	protected $ac_rows      = array(); // DND_Monster_Trait_Combat
#	protected $alignment    = 'Neutral';
#	protected $appearing    = array( 1, 1, 0 );
#	protected $armor        = array(); // DND_Character_Trait_Armor
#	protected $armor_class  = 10;
#	protected $armor_type   = 11;
	protected $attacks      = array( 'Weapon' => [ 1, 8, 0 ] );
#	private   $combat_key   = '';      // DND_Monster_Trait_Combat
#	public    $current_hp   = -10000;
#	protected $description  = '';
#	protected $frequency    = 'Common';
	protected $gear         = array();
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
#	protected $shield       = array(); // DND_Character_Trait_Armor
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


	use DND_Character_Trait_Armor;


	/**  Override functions  **/

	protected function determine_hit_dice() {
		$this->hit_dice = 1;
	}

	protected function determine_hit_points() {
		parent::determine_hit_points();
		if ( $this->weapon['current'] === 'none' ) $this->generate_humanoid_accouterments();
	}

	protected function initialize_sequence_attacks() {
		if ( array_key_exists( 'Weapon', $this->attacks ) ) {
			$this->attacks = array_key_replace( $this->attacks, 'Weapon', 'Spear' );
		}
		parent::initialize_sequence_attacks();
	}

	protected function non_sequence_chance( $segment ) {
		return 100;
	}

	protected function is_sequence_attack( $check ) {
		return false;
	}

	public function set_current_weapon( $new ) {
		if ( $status = $this->set_character_weapon( $new ) ) {
			$this->determine_armor_class();
		}
		return $status;
	}

	protected function base_weapon_array( $name, $skill = 'PF' ) {
		return parent::base_weapon_array( $name, $skill );
	}


	/**  Humanoid functions  **/

	protected function generate_humanoid_accouterments( $chance = 0 ) {
		$treas = new DND_Combat_Treasure_Treasure;
		$this->gear = $treas->acc_get_accouterments( $this, $chance );
		foreach( $this->gear as $item ) {

		}
/*			$type = $item['sub'];
			if ( ! array_key_exists( $type, $this->gear ) ) $this->gear[ $type ] = array();
			switch( $type ) {
				case 'potions':
				case 'scrolls':
				case 'rings':
					$this->gear[ $type ][] = $item;
					break;
				case 'armor':
					if ( ( $this->get_armor_ac_value( $item['key'], true ) - abs( $item['bonus'] ) ) < $this->armor_class ) {
						$this->armor['armor'] = $item['key'];
						$this->armor['bonus'] = $item['bonus'];
						$item['size'] = $this->race;
					}
					$this->gear[ $type ] = $item;
					break;
				case 'shields':
					$this->gear[ $type ]   = $item;
					$this->shield['type']  = "{$item['size']} {$item['text']}";
					$this->shield['bonus'] = $item['bonus'];
					$this->shield['size']  = $item['size'];
					break;
				case 'weapons':
					if ( ! array_key_exists( 'key', $item ) ) {
						$this->gear[ $type ][] = $item;
						break;
					}
				case 'swords':
					$key = $item['key'];
					$this->gear[ $type ][ $key ] = $item;
					if ( ! array_key_exists( $key, $this->attacks ) ) {
						$this->attacks[ $key ] = $this->get_weapon_damage_array( $key );
						$this->attacks[ $key ][2] += $item['bonus'];
						if ( array_key_exists( 'Weapon', $this->attacks ) ) unset( $this->attacks['Weapon'] );
					}
					break;
				case 'none':
					break;
				default:
			}
		}*/
	}


	/**  Placeholder functions  **/

	protected function get_ac_dex_bonus() { return 0; }


}

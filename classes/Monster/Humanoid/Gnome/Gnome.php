<?php
/* Name: Gnome
 * Class: DND_Monster_Humanoid_Gnome_Gnome
 * Encounter: {}
 */
abstract class DND_Monster_Humanoid_Gnome_Gnome extends DND_Monster_Humanoid_DemiHuman {


	protected $alignment    = 'Neutral to Lawful Good';
	protected $appearing    = array( 40, 10, 0 );
	protected $armor_class  = 5;
#	protected $armor_type   = 11;
	protected $attacks      = array( 'Weapon' => [ 1, 6, 0 ] );
#	protected $extra        = array();
#	protected $fighter      = null;
	protected $frequency    = 'Rare';
#	protected $hp_extra     = 0;
	protected $in_lair      = 50;
#	protected $initiative   = 1;
	protected $intelligence = 'Very';
	protected $movement     = array( 'foot' => 6 );
	protected $name         = 'Gnome';
#	protected $psionic      = 'Nil';
	protected $race         = 'Gnome';
	protected $reference    = 'Monster Manual page 45';
#	protected $resistance   = 'Standard';
	protected $size         = "Small 3'+ tall";
#	protected $specials     = array();
	protected $treasure     = 'M,C,Q';
#	protected $xp_value     = array();


	protected function determine_hit_dice() {
		$this->hit_dice = 1;
	}

	protected function determine_specials() {
		$this->specials = array(
			'saving' => 'Saves at 4 levels higher',
		);
	}

	protected function get_saving_throw_level() {
		return parent::get_saving_throw_level() + 4;
	}

	protected function get_fighter_data( $level = 1 ) {
		$armor  = 'Scale';
		$bonus  = 0;
		$shield = 0;
		if ( $level > 1 ) {
			$armor = 'Chain';
			if ( $level > 5 ) {
				$opts = [ 'Plate Mail', 'Field Plate', 'Full Plate' ];
				$mail = mt_rand( 0, 2 );
				$armor = $opts[ $mail ];
			}
			if ( $this->check_chance( $level * 10 ) ) {
				$bonus = mt_rand( 1, min( 5, $level ) );
			}
			if ( $this->check_chance( $level * 10 ) ) {
				$shield = mt_rand( 1, min( 5, $level ) );
			}
		}
		$data = array(
			'ac_rows'    => $this->ac_rows,
			'armor'      => [ 'armor' => $armor, 'bonus' => $bonus ],
			'experience' => 1,
			'max_move'   => $this->movement['foot'],
			'movement'   => $this->movement['foot'],
			'name'       => $this->name,
			'race'       => $this->race,
			'shield'     => [ 'type' => 'Small', 'bonus' => $shield ],
			'stats'      => array(
				'str' => 12 + mt_rand( 1, 6 ),
				'int' => 12 + mt_rand( 1, 6 ),
				'wis' => 12 + mt_rand( 1, 6 ),
				'dex' => 12 + mt_rand( 1, 6 ),
				'con' => 12 + mt_rand( 1, 6 ),
				'chr' => 12 + mt_rand( 1, 6 ),
			),
			'weapons' => $this->weapon_choices( $level ),
		);
		$data = apply_filters( 'humanoid_fighter_data', $data, $this );
		return apply_filters( 'gnome_fighter_data', $data, $this );
	}

	protected function weapon_choices( $level = 1 ) {
		$max  = 100 - ( ( $level - 1 ) * 10 );
		$roll = mt_rand( 1, $max );
		if ( $roll < 11 ) {
			$carry = array( 'Bow,Short', 'Sword,Short' );
		} else if ( $roll < 31 ) {
			$carry = array( 'Sword,Short', 'Spear', 'Spear,Thrown' );
		} else if ( $roll < 46 ) {
			$carry = array( 'Club', 'Sword,Short' );
		} else if ( $roll < 86 ) {
			$carry = array( 'Club', 'Spear', 'Spear,Thrown' );
		} else {
			$carry = array( 'Club', 'Sling' );
		}
		$weapons = array();
		$single  = array( 'bonus' => 0, 'skill' => 'PF' );
		foreach( $carry as $weap ) {
			$weapons[ $weap ] = $single;
			if ( $level > 1 ) {
				if ( $this->check_chance( $level * 10 ) ) {
					$weapons[ $weap ]['bonus'] = mt_rand( 1, min( 5, $level ) );
				}
			}
		}
		return $weapons;
	}

	public function group_composition( $num ) {
		if ( $this->extra ) return $this->extra;
		$extra = array();
		$f = intval( $num / 40 );
		$opts = [ '0', '1st', '2nd', '3rd', '4th', '5th', '6th' ];
		for( $i = 1; $i <= $f; $i++ ) {
			$level = mt_rand( 2, 4 );
			$extra[] = $opts[ $level ] . ' level fighter';
		}
		if ( $num > 159 ) {
			$extra[] = '3rd level fighter';
			$extra[] = '5th level fighter';
		}
		if ( $num > 199 ) {
			$level = mt_rand( 4, 6 );
			$extra[] = $opts[ $level ] . ' level cleric';
		}
		if ( $num > 319 ) {
			$extra[] = '6th level fighter';
			$extra[] = '5th level fighter';
			$extra[] = '5th level fighter';
			$extra[] = '7th level cleric';
			$extra[] = '3rd level cleric';
			$extra[] = '3rd level cleric';
			$extra[] = '3rd level cleric';
			$extra[] = '3rd level cleric';
		}
		if ( $this->check_for_lair() ) {
			$f = mt_rand( 1, 4 ) + mt_rand( 1, 4 );
			for( $i = 1; $i <= $f; $i++ ) {
				$level = mt_rand( 2, 3 );
				$extra[] = $opts[ $level ] . ' level fighter';
			}
			$f = mt_rand( 1, 4 );
			for( $i = 1; $i <= $f; $i++ ) {
				$extra[] = '2nd level cleric';
			}
			$extra[] = sprintf( '%u females', intval( $num / 2 ) );
			$extra[] = sprintf( '%u young',   intval( $num / 4 ) );
		}
		$this->extra = $extra;
		return $extra;
	}


}

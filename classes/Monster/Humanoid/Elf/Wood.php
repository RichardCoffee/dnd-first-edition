<?php
/* Name: Wood Elf
 * Class: DND_Monster_Humanoid_Elf_Wood
 * Encounter: {"CC":{"H":"VR","F":"U","S":"VR"},"CW":{"H":"VR","F":"U","S":"VR"},"TC":{"H":"VR","F":"U","S":"VR"},"TW":{"H":"VR","F":"U","S":"VR"},"TSC":{"H":"VR","F":"U","S":"VR"},"TSW":{"H":"VR","F":"U","S":"VR"}}
 */

class DND_Monster_Humanoid_Elf_Wood extends DND_Monster_Humanoid_Elf_Elf {


	protected $alignment    = 'Chaotic Neutral';
#	protected $appearing    = array( 20, 10, 0 );
#	protected $armor_class  = 5;
#	protected $armor_type   = 11;
#	protected $attacks      = array( 'Weapon' => [ 1, 10, 0 ] );
#	protected $extra        = array();
#	protected $fighter      = null;
#	protected $frequency    = 'Uncommon';
#	protected $hit_dice     = 1;
#	protected $hp_extra     = 1;
#	protected $in_lair      = 10;
#	protected $initiative   = 1;
#	protected $intelligence = 'High and up';
#	protected $movement     = array( 'foot' => 12 );
	protected $name         = 'Wood Elf';
#	protected $psionic      = 'Nil';
#	protected $race         = 'Elf';
	protected $reference    = 'Monster Manual page 38-39';
#	protected $resistance   = 'Standard';
#	protected $size         = "Medium (5'+ tall)";
#	protected $specials     = array();
#	protected $treasure     = 'N,G,S,T';
#	protected $xp_value     = array();



	protected function determine_hit_points() {
		$this->description = 'Sometimes called sylvan elves, these creatures are very are always underground, for they prefer darkness and are nocturnal.  reclusive and generally (75%) avoid all contact. Wood elves are more neutral than are other elves. They live in primaeval forests and distant woodlands.  Wood elves speak only elvish and the languages of certain woods animals and treants. Their complexions are fair, their hair is yellow to coppery red and their eyes are light brown, light green, or hazel. They wear russets, reds, brown and tans. Their cloaks are usually green or greenish brown.  Wood elves have a life span of centuries.';
	}

	protected function get_fighter_data( $level = 1 ) {
		$opts   = array( 'Studded', 'Ring' );
		$roll   = mt_rand( 0, 1 );
		$armor  = $opt[ $roll ];
		$bonus  = 0;
		$sbonus = 0;
		if ( $level > 1 ) {
			$opts[] = 'Elfin Chain';
			$roll   = mt_rand( $roll, 2 );
			$armor  = $opt[ $roll ];
			if ( $this->check_chance( $level * 10 ) ) {
				$bonus = mt_rand( 1, min( 5, ceil( $level / 4 ) ) );
			}
			if ( $this->check_chance( $level * 10 ) ) {
				$sbonus = mt_rand( 1, min( 5, ceil( $level / 3 ) ) );
			}
		}
		$weapons = $this->weapon_choices( $level );
		if ( ( count( $weapons ) > 1 ) || ( ! array_key_exists[ 'Bow,Long', $weapons ) ) {
			$shield = array( 'type' => 'Medium', 'bonus' => $sbonus );
		} else {
			$shield = array( 'type' => 'none', 'bonus' => 0 );
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
				'str' => 13 + mt_rand( 1, 6 ),
				'int' => 11 + mt_rand( 1, 6 ),
				'wis' => 12 + mt_rand( 1, 6 ),
				'dex' => 12 + mt_rand( 1, 6 ),
				'con' => 12 + mt_rand( 1, 6 ),
				'chr' => 12 + mt_rand( 1, 6 ),
			),
			'weapons' => $weapons,
		);
		$data = apply_filters( 'dnd1e_humanoid_fighter_data', $data, $this );
		$data = apply_filters( 'dnd1e_elf_fighter_data', $data, $this );
		return apply_filters( 'dnd1e_wood_elf_fighter_data', $data, $this );
	}

	protected function weapon_choices( $level = 1 ) {
		$max  = 100 - ( ( $level - 1 ) * 10 );
		$roll = mt_rand( 1, $max );
		if ( $roll < 11 ) {
			$carry = array( 'Sword,Long' );
		} else if ( $roll < 16 ) {
			$carry = array( 'Bow,Long', 'Sword,Long' );
		} else if ( $roll < 56 ) {
			$carry = array( 'Bow,Long' );
		} else if ( $roll < 61 ) {
			$carry = array( 'Sword,Long', 'Spear', 'Spear,Thrown' );
		} else {
			$carry = array( 'Spear', 'Spear,Thrown' );
		}
		$weapons = array();
		$single  = array( 'bonus' => 0, 'skill' => 'PF' );
		foreach( $carry as $weap ) {
			$weapons[ $weap ] = $single;
			if ( $level > 1 ) {
				if ( $this->check_chance( $level * 10 ) ) {
					$weapons[ $weap ]['bonus'] = mt_rand( 1, min( 5, ceil( $level / 3 ) ) );
				}
			}
		}
		return $weapons;
	}

	public function group_composition( $num ) {
		if ( $this->extra ) return $this->extra;
		$extra = array();
		$f = intval( $num / 20 );
		$opts = [ '0', '1st', '2nd', '3rd', '4th', '5th', '6th' ];
		for( $i = 1; $i <= $f; $i++ ) {
			$level = mt_rand( 2, 3 );
			$extra[] = $opts[ $level ] . ' level fighter';
		}
		$f = intval( $num / 40 );
		for( $i = 1; $i <= $f; $i++ ) {
			$level = mt_rand( 2, 3 );
			$extra[] = $opts[ $level ] . ' level fighter / ' . $opts[ $level - 1 ] . ' level magic-user';
		}
		if ( $num > 99 ) {
			$extra[] = '4th level fighter/8th level magic-user';
			$extra[] = '4th level fighter/5th level magic-user';
			$extra[] = '4th level fighter/5th level magic-user';
			$extra[] = '4th level fighter/4th level magic-user/4th level cleric';
		}
		if ( $num > 160 ) {
			$extra[] = '6th level fighter/9th level magic-user';
			$extra[] = '4th level fighter/5th level magic-user';
			$extra[] = '3rd level fighter/3rd level magic-user/3rd level cleric';
			$extra[] = '6th level fighter/6th level magic-user/6th level cleric';
			$extra[] = '4th level fighter/5th level magic-user';
			$extra[] = '3rd level fighter/3rd level magic-user/3rd level cleric';
		}
		if ( $this->check_for_lair() ) {
			$extra[] = '4th level fighter/7th level magic-user';
			$f = intval( $num / 40 );
			for( $i = 1; $i <= $f; $i++ ) {
				$extra[] = '4th level fighter';
				$extra[] = '2nd level fighter/2nd level magic-user/2nd level cleric';
			}
			$extra[] = '5th level fighter';
			$extra[] = '6th level fighter';
			$extra[] = sprintf( '%u females', $num );
			$extra[] = sprintf( '%u young', intval( $num / 20 ) );
			if ( $this->check_chance( 70 ) ) {
				if ( $this->check_chance( 80 ) ) {
					$count = mt_rand( 1, 6 );
					$count+= mt_rand( 1, 6 );
					$extra[] = sprintf( '%u giant owls', $count );
				} else {
					$count = mt_rand( 1, 6 );
					$extra[] = sprintf( '%u giant lynx', $count );
				}
			}
		}
		$this->extra = $extra;
		return $extra;
	}


}

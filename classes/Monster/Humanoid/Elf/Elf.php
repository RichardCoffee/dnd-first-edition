<?php

abstract class DND_Monster_Humanoid_Elf_Elf extends DND_Monster_Humanoid_DemiHuman {


	protected $alignment    = 'Chaotic Good';
	protected $appearing    = array( 20, 10, 0 );
	protected $armor_class  = 5;
#	protected $armor_type   = 11;
	protected $attacks      = array( 'Weapon' => [ 1, 10, 0 ] );
#	protected $extra        = array();
#	protected $fighter      = null;
	protected $frequency    = 'Uncommon';
	protected $hit_dice     = 1;
	protected $hp_extra     = 1;
	protected $in_lair      = 10;
#	protected $initiative   = 1;
	protected $intelligence = 'High and up';
#	protected $movement     = array( 'foot' => 12 );
#	protected $name         = 'Elf';
#	protected $psionic      = 'Nil';
	protected $race         = 'Elf';
#	protected $reference    = 'Monster Manual page';
#	protected $resistance   = 'Standard';
	protected $size         = "Medium (5'+ tall)";
#	protected $specials     = array();
	protected $treasure     = 'N,G,S,T';
#	protected $xp_value     = array();



	protected function get_fighter_data( $level = 1 ) {
		$opts   = array( 'Ring', 'Scale', 'Chain' );
		$roll   = mt_rand( 0, 2 );
		$armor  = $opt[ $roll ];
		$bonus  = 0;
		if ( $level > 1 ) {
			$opts[] = 'Elfin Chain';
			$roll   = mt_rand( $roll, 3 );
			$armor  = $opt[ $roll ];
			if ( $this->check_chance( $level * 10 ) ) {
				$bonus = mt_rand( 1, min( 5, ceil( $level / 4 ) ) );
			}
		}
		$weapons = $this->weapon_choices( $level );
		if ( ( count( $weapons ) > 1 ) || ( ! in_array( 'Bow,Long', $weapons ) ) ) {
			$sbonus = 0;
			if ( $this->check_chance( $level * 10 ) ) {
				$sbonus = mt_rand( 1, min( 5, ceil( $level / 3 ) ) );
			}
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
			'shield'     => $shield,
			'stats'      => array(
				'str' => 12 + mt_rand( 1, 6 ),
				'int' => 12 + mt_rand( 1, 6 ),
				'wis' => 12 + mt_rand( 1, 6 ),
				'dex' => 12 + mt_rand( 1, 6 ),
				'con' => 12 + mt_rand( 1, 6 ),
				'chr' => 12 + mt_rand( 1, 6 ),
			),
			'weapons' => $weapons,
		);
		$data = apply_filters( 'dnd1e_humanoid_fighter_data', $data, $this );
		return apply_filters( 'dnd1e_elf_fighter_data', $data, $this );
	}

	protected function weapon_choices( $level = 1 ) {
		$max  = 100 - ( ( $level - 1 ) * 10 );
		$roll = mt_rand( 1, $max );
		if ( $roll < 6 ) {
			$carry = array( 'Sword,Two-Handed' );
		} else if ( $roll < 26 ) {
			$carry = array( 'Sword,Long' );
		} else if ( $roll < 36 ) {
			$carry = array( 'Bow,Long', 'Sword,Long' );
		} else if ( $roll < 51 ) {
			$carry = array( 'Bow,Long' );
		} else if ( $roll < 71 ) {
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

	public function possible_cleric_items( $level ) {
		if ( $this->check_chance( $level * 10 ) ) {
			
		}
	}

	public function possible_magic_user_items( $level ) {
		if ( $this->check_chance( $level * 10 ) ) {
			
			if ( $level > 4 ) {
				$roll = mt_rand( 2, 5 );
				for ( $i = 1; $i <= $roll; $i++ ) {
					
				}
			}
		}
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
			if ( $this->check_chance( 65 ) ) {
				$count = mt_rand( 1, 6 );
				$count+= mt_rand( 1, 6 );
				$extra[] = sprintf( '%u giant eagles', $count );
			}
		}
		$this->extra = $extra;
		return $extra;
	}


}

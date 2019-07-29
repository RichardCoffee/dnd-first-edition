<?php

class DND_Character_Thief extends DND_Character_Character {


	protected $ac_rows    = array( 1, 1, 2, 2, 3, 3, 4, 5, 6, 6, 7, 7, 8, 8, 9, 10, 10, 11, 11, 12 );
	protected $armr_allow = array( 'Elfin Chain', 'Leather', 'Padded', 'Studded' );
	protected $hit_die    = array( 'limit' => 10, 'size' => 6, 'step' => 2 );
	protected $non_prof   = -3;
	protected $skills     = array( 'Pick Pockets' => 30, 'Open Locks' => 25, 'Find Traps' => 20, 'Move Silently' => 15, 'Hide Shadow' => 10, 'Hear Noise' => 10, 'Climb Walls' => 85, 'Languages' => 1 );
	protected $stats      = array( 'str' => 3, 'int' => 3, 'wis' => 3, 'dex' => 9, 'con' => 3, 'chr' => 3 );
	protected $weap_allow = array( 'Bow,Short', 'Caltrop', 'Club', 'Crossbow,Hand', 'Dagger', 'Dagger,Off-Hand', 'Dart', 'Garrot', 'Knife', 'Sap', 'Sling', 'Sword,Broad', 'Sword,Falchion', 'Sword,Long', 'Sword,Short' );
	protected $weap_init  = array( 'initial' => 2, 'step' => 4 );
	protected $xp_bonus   = array( 'dex' => 16 );
	protected $xp_step    = 220000;
	protected $xp_table   = array( 0, 1250, 2500, 5000, 10000, 20000, 42500, 70000, 110000, 160000, 220000 );


	public function initialize_character() {
		parent::initialize_character();
		$this->determine_thief_skills();
	}

	protected function determine_thief_skills() {
		$table  = $this->get_thief_table();
		$racial = $this->get_thief_racial_adjustments();
		$armor  = $this->get_thief_armor_adjustments();
		$dex    = $this->get_thief_dexterity_adjustments();
		foreach( $this->skills as $key => $value ) {
			$index = ( isset( $table[ $key ][ $this->level ] ) ) ? $this->level : count( $table[ $key ] ) - 1;
#echo "$key: $index  ";
			$this->skills[ $key ] = $table[ $key ][ $index ];
#echo "B:{$this->skills[ $key ]}  ";
			if ( isset( $racial[ $key ] ) ) {
				$this->skills[ $key ] += $racial[ $key ];
			}
#echo "R:{$this->skills[ $key ]}  ";
			if ( isset( $armor[ $key ] ) ) {
				$this->skills[ $key ] += $armor[ $key ];
			}
#echo "A:{$this->skills[ $key ]}  ";
			if ( isset( $dex[ $key ] ) ) {
				$this->skills[ $key ] += $dex[ $key ];
			}
#echo "D:{$this->skills[ $key ]}\n";
		}
		if ( $this->skills['Climb Walls'] < 99 ) {
			$this->skills['Climb Walls'] = round( $this->skills['Climb Walls'] );
		}
	}

	public function get_thief_skills_list() {
		$list = array(); // FIXME
		return $list;
	}

	public function get_thief_skill( $skill ) {
		$percentage = 0;
		if ( isset( $this->skills[ $skill ] ) ) {
			$percentage = $this->skills[ $skill ];
		}
		return $percentage;
	}

	protected function get_thief_table() {
		return array(            /**  0   1   2   3   4   5   6   7   8   9  10  11    12    13    14    15    16    17   18  19  **/
			'Pick Pockets'  => array( 25, 30, 35, 40, 45, 50, 55, 60, 65, 70, 80, 90,  100,  105,  110,  115,  125 ),
			'Open Locks'    => array( 21, 25, 29, 33, 37, 42, 47, 52, 57, 62, 67, 72,   77,   82,   87,   92,   97,   99 ),
			'Find Traps'    => array( 15, 20, 25, 30, 35, 40, 45, 50, 55, 60, 65, 70,   75,   80,   85,   90,   95,   99 ),
			'Move Silently' => array(  9, 15, 21, 27, 33, 40, 47, 55, 62, 70, 78, 86,   94,   99 ),
			'Hide Shadow'   => array(  5, 10, 15, 20, 25, 31, 37, 43, 49, 56, 63, 70,   77,   85,   93,   99 ),
			'Hear Noise'    => array(  5, 10, 10, 15, 15, 20, 20, 25, 25, 30, 30, 35,   35,   40,   40,   45,   45,   50,  50, 55 ),
			'Climb Walls'   => array( 84, 85, 86, 87, 88, 90, 92, 94, 96, 98, 99, 99.1, 99.2, 99.3, 99.4, 99.5, 99.6, 99.7 ),
			'Languages'     => array(  0,  1,  5, 10, 15, 20, 25, 30, 35, 40, 45, 50,   55,   60,   65,   70,   75,   80 ),
		);
	}

	protected function get_thief_racial_adjustments() {
		$adj = array();
		switch( strtolower( $this->race ) ) {
			case 'dwarf':
				$adj = array( 'Open Locks' => 15, 'Find Traps' => 15, 'Move Silently' => -5, 'Climb Walls' => -10, 'Languages' => -5 );
				break;
			case 'elf':
				$adj = array( 'Pick Pockets' => 5, 'Open Locks' => -5, 'Find Traps' => 5, 'Move Silently' => 5, 'Hide Shadow' => 10, 'Hear Noise' => 5, 'Climb Walls' => -5, 'Languages' => 10 );
				break;
			case 'gnome':
				$adj = array( 'Open Locks' => 10, 'Hear Noise' => 5, 'Climb Walls' => -15 );
				break;
			case 'half-elf':
				$adj = array( 'Pick Pockets' => 10, 'Hide Shadow' => 5 );
				break;
			case 'halfling':
				$adj = array( 'Pick Pockets' => 5, 'Move Silently' => 15, 'Hide Shadow' => 15, 'Hear Noise' => 5, 'Climb Walls' => -15, 'Languages' => -5 );
				break;
			case 'half-orc':
				$adj = array( 'Pick Pockets' => -5, 'Open Locks' => 5, 'Find Traps' => 5, 'Hear Noise' => 5, 'Climb Walls' => 5, 'Languages' => -10 );
				break;
			case 'human':
				$adj = array( 'Open Locks' => 5, 'Climb Walls' => 5 );
				break;
			default:
		}
		return $adj;
	}

	protected function get_thief_armor_adjustments() {
		$adj = array();
		switch( strtolower( $this->armor['armor'] ) ) {
			case 'none':
				$adj = array( 'Pick Pockets' => 5, 'Move Silently' => 10, 'Hide Shadow' => 5, 'Climb Walls' => 10 );
				break;
			case 'elfin chain':
				switch( $this->armor['bonus'] ) {
					case 5:
						$adj = array( 'Pick Pockets' => -5, 'Climb Walls' => -5 );
						break;
					case 4:
						$adj = array( 'Pick Pockets' => -8, 'Open Locks' => -1, 'Find Traps' => -1, 'Move Silently' => -1, 'Hide Shadow' => -2, 'Hear Noise' => -2, 'Climb Walls' => -8 );
						break;
					case 3:
						$adj = array( 'Pick Pockets' => -11, 'Open Locks' => -2, 'Find Traps' => -2, 'Move Silently' => -2, 'Hide Shadow' => -4, 'Hear Noise' => -4, 'Climb Walls' => -11 );
						break;
					case 2:
						$adj = array( 'Pick Pockets' => -14, 'Open Locks' => -3, 'Find Traps' => -3, 'Move Silently' => -3, 'Hide Shadow' => -6, 'Hear Noise' => -6, 'Climb Walls' => -14 );
						break;
					case 1:
						$adj = array( 'Pick Pockets' => -17, 'Open Locks' => -4, 'Find Traps' => -4, 'Move Silently' => -4, 'Hide Shadow' => -8, 'Hear Noise' => -8, 'Climb Walls' => -17 );
						break;
					default:
						$adj = array( 'Pick Pockets' => -20, 'Open Locks' => -5, 'Find Traps' => -5, 'Move Silently' => -5, 'Hide Shadow' => -10, 'Hear Noise' => -10, 'Climb Walls' => -20 );
				}
				break;
			case 'padded':
			case 'studded':
				switch( $this->armor['bonus'] ) {
					case 5:
						$adj = array( 'Pick Pockets' => -15, 'Open Locks' => -5, 'Find Traps' => -5, 'Move Silently' => -5, 'Hide Shadow' => -10, 'Hear Noise' => -10, 'Climb Walls' => -15 );
						break;
					case 4:
						$adj = array( 'Pick Pockets' => -18, 'Open Locks' => -6, 'Find Traps' => -6, 'Move Silently' => -6, 'Hide Shadow' => -12, 'Hear Noise' => -12, 'Climb Walls' => -18 );
						break;
					case 3:
						$adj = array( 'Pick Pockets' => -21, 'Open Locks' => -7, 'Find Traps' => -7, 'Move Silently' => -7, 'Hide Shadow' => -14, 'Hear Noise' => -14, 'Climb Walls' => -21 );
						break;
					case 2:
						$adj = array( 'Pick Pockets' => -24, 'Open Locks' => -8, 'Find Traps' => -8, 'Move Silently' => -8, 'Hide Shadow' => -16, 'Hear Noise' => -16, 'Climb Walls' => -24 );
						break;
					case 1:
						$adj = array( 'Pick Pockets' => -27, 'Open Locks' => -9, 'Find Traps' => -9, 'Move Silently' => -9, 'Hide Shadow' => -18, 'Hear Noise' => -18, 'Climb Walls' => -27 );
						break;
					default:
						$adj = array( 'Pick Pockets' => -30, 'Open Locks' => -10, 'Find Traps' => -10, 'Move Silently' => -10, 'Hide Shadow' => -20, 'Hear Noise' => -20, 'Climb Walls' => -30 );
				}
				break;
			case 'leather':
			default:
		}
		return $adj;
	}

	protected function get_thief_dexterity_adjustments() {
		$adj = array();
		switch( $this->stats['dex'] ) {
			case 3:
				$adj = array( 'Pick Pockets' => -45, 'Open Locks' => -40, 'Find Traps' => -25, 'Move Silently' => -50, 'Hide Shadow' => -40 );
				break;
			case 4:
				$adj = array( 'Pick Pockets' => -40, 'Open Locks' => -35, 'Find Traps' => -25, 'Move Silently' => -45, 'Hide Shadow' => -35 );
				break;
			case 5:
				$adj = array( 'Pick Pockets' => -35, 'Open Locks' => -30, 'Find Traps' => -20, 'Move Silently' => -40, 'Hide Shadow' => -30 );
				break;
			case 6:
				$adj = array( 'Pick Pockets' => -30, 'Open Locks' => -25, 'Find Traps' => -20, 'Move Silently' => -35, 'Hide Shadow' => -25 );
				break;
			case 7:
				$adj = array( 'Pick Pockets' => -25, 'Open Locks' => -20, 'Find Traps' => -15, 'Move Silently' => -30, 'Hide Shadow' => -20 );
				break;
			case 8:
				$adj = array( 'Pick Pockets' => -20, 'Open Locks' => -15, 'Find Traps' => -15, 'Move Silently' => -25, 'Hide Shadow' => -15 );
				break;
			case 9:
				$adj = array( 'Pick Pockets' => -15, 'Open Locks' => -10, 'Find Traps' => -10, 'Move Silently' => -20, 'Hide Shadow' => -10 );
				break;
			case 10:
				$adj = array( 'Pick Pockets' => -10, 'Open Locks' => -5, 'Find Traps' => -10, 'Move Silently' => -15, 'Hide Shadow' => -5 );
				break;
			case 11:
				$adj = array( 'Pick Pockets' => -5, 'Find Traps' => -5, 'Move Silently' => -10 );
				break;
			case 12:
				$adj = array( 'Move Silently' => -5 );
				break;
			case 13:
			case 14:
			case 15:
				$adj = array();
				break;
			case 16:
				$adj = array( 'Open Locks' => 5 );
				break;
			case 17:
				$adj = array( 'Pick Pockets' => 5, 'Open Locks' => 10, 'Move Silently' => 5, 'Hide Shadow' => 5 );
				break;
			case 18:
				$adj = array( 'Pick Pockets' => 10, 'Open Locks' => 15, 'Find Traps' => 5, 'Move Silently' => 10, 'Hide Shadow' => 10 );
				break;
			case 19:
				$adj = array( 'Pick Pockets' => 15, 'Open Locks' => 20, 'Find Traps' => 10, 'Move Silently' => 12, 'Hide Shadow' => 12 );
				break;
			case 20:
				$adj = array( 'Pick Pockets' => 20, 'Open Locks' => 25, 'Find Traps' => 15, 'Move Silently' => 15, 'Hide Shadow' => 15 );
				break;
			case 21:
				$adj = array( 'Pick Pockets' => 25, 'Open Locks' => 30, 'Find Traps' => 20, 'Move Silently' => 18, 'Hide Shadow' => 18 );
				break;
			case 22:
				$adj = array( 'Pick Pockets' => 30, 'Open Locks' => 35, 'Find Traps' => 25, 'Move Silently' => 20, 'Hide Shadow' => 20 );
				break;
			case 23:
				$adj = array( 'Pick Pockets' => 35, 'Open Locks' => 40, 'Find Traps' => 30, 'Move Silently' => 23, 'Hide Shadow' => 23 );
				break;
			case 24:
				$adj = array( 'Pick Pockets' => 40, 'Open Locks' => 45, 'Find Traps' => 35, 'Move Silently' => 25, 'Hide Shadow' => 25 );
				break;
			case 25:
				$adj = array( 'Pick Pockets' => 45, 'Open Locks' => 50, 'Find Traps' => 40, 'Move Silently' => 30, 'Hide Shadow' => 30 );
				break;
			default:
		}
		return $adj;
	}

	protected function define_specials() {
		$this->specials = array(
			'integer_backstab' => sprintf( 'Backstab: Hit +4, Damage x%u', $this->special_integer_backstab() ),
		);
	}

	public function special_integer_backstab() {
		return ceil( ( $this->level / 4 ) + 1 );
	}

	protected function get_saving_throw_table() {
		return $this->get_thief_saving_throw_table();
	}


}

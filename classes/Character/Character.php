<?php

abstract class DND_Character_Character {

	protected $ac_rows    = array( 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22 );
	protected $armor      = array( 'armor' => 'none', 'bonus' => 0, 'type' => 10, 'class' => 10 );
	protected $experience = 0;
	protected $hit_die    = array( 'limit' => -1, 'size' => -1, 'step' => -1 );
	protected $hit_points = array( 'base' => 0, 'current' => -100 );
	private   $import_task = 'import';
	protected $level      = 0;
	protected $movement   = '12';
	protected $name       = 'Character Name';
	protected $non_prof   = -100;
	protected $race       = 'Human';
	protected $shield     = array( 'type' => 'none', 'bonus' => 0 );
	protected $specials   = array();
	protected $spells     = array();
	protected $stats      = array( 'str' => 3, 'int' => 3, 'wis' => 3, 'dex' => 3, 'con' => 3, 'chr' => 3 );
	protected $weap_init  = array( 'initial' => 1, 'step' => 10 );
	protected $weap_reqs  = array();
	protected $weapon     = array( 'current' => 'none', 'skill' => 'NP', 'attack' => 'hand', 'bonus' => 0 );
	protected $weapons    = array();
	protected $xp_bonus   = array();
	protected $xp_step    = 1000000;
	protected $xp_table   = array( 1000000 );

	use DND_Character_Import_Kregen;
	use DND_Character_Trait_Armor;
	use DND_Character_Trait_Attributes;
	use DND_Character_Trait_Weapons;
	use DND_Trait_Magic;
	use DND_Trait_ParseArgs;

	public function __construct( $args = array() ) {
		$this->parse_args_merge( $args );
		$this->initialize_character();
	}

	public function initialize_character() {
		if ( ( $this->level === 0 ) && ( $this->experience > 0 ) ) {
			$this->level = $this->calculate_level( $this->experience );
		}
		if ( $this->hit_points['base'] === 0 ) {
			$this->determine_hit_points();
		}
		if ( ! ( $this->weapon['current'] === 'none' ) ) {
			$this->set_current_weapon( $this->weapon['current'] );
		} else {
			$this->determine_armor_class(); // this is called in set_current_weapon()
		}
	}

	protected function calculate_level( $xp ) {
		$level = 0;
		foreach( $this->xp_table as $key => $needed ) {
			$level = $key;
			if ( $xp < $needed ) {
				break;
			}
		}
		while ( $xp > 0 ) {
			$xp -= $this->xp_step;
			$level++;
		}
		return --$level;
	}

	public function set_level( $level ) {
		$this->level = $level;
		$old_hp = $this->hit_points['base'];
		$this->determine_hit_points();
		if ( $this->hit_points['current'] < $this->hit_points['base'] ) {
			$this->hit_points['current'] += $this->hit_points['base'] - $old_hp;
		}
		$this->weapon['to_hit'] = $this->to_hit_ac_row();
		if ( method_exists( $this, 'reload_spells' ) ) {
			$this->reload_spells();
		}
	}

	public function add_experience( $xp ) {
		$bonus = true;
		foreach( $this->xp_bonus as $stat => $limit ) {
			if ( $this->stats[ $stat ] < $limit ) {
				$bonus = false;
			}
		}
		$this->experience = ( $bonus ) ? round( $xp * 1.1 ) : $xp;
		$level = calculate_level( $this->experience );
		if ( $level > $this->level ) {
			$this->set_level( $level );
#			$this->export_character();
		}
	}

	protected function determine_hit_points() {
		$base = $this->hit_die['size'] + $this->get_constitution_hit_point_adjustment( $this->stats['con'] );
		$this->hit_points['base'] = $base * min( $this->hit_die['limit'], $this->level );
		if ( $this->level > $this->hit_die['limit'] ) {
			$this->hit_points['base'] += ( $this->level - $this->hit_die['limit'] ) * $this->hit_die['step'];
		}
		if ( $this->hit_points['current'] === -100 ) {
			$this->hit_points['current'] = $this->hit_points['base'];
		}
	}

	protected function determine_armor_class() {
		$no_shld = in_array( $this->weapon['attack'], $this->get_weapons_not_allowed_shield() );
		if ( ! ( $this->armor === 'none' ) ) {
			$this->armor['type'] = $this->get_armor_ac_value( $this->armor['armor'] );
			if ( ! ( ( $this->shield['type'] === 'none' ) || $no_shld ) ) {
				$this->armor['type']--;
			}
			$this->armor['class'] = $this->armor['type'];
			$this->movement = min( 12, $this->get_armor_base_movement( $this->armor['armor'] ) + $this->armor['bonus'] );
		}
		$this->armor['class'] += $this->get_armor_class_dexterity_adjustment( $this->stats['dex'] );
		$this->armor['class'] -= $this->armor['bonus'];
		$this->armor['class'] -= ( $no_shld ) ? 0 : $this->shield['bonus'];
	}

	public function set_current_weapon( $new = '' ) {
		if ( ! empty ( $new ) ) {
			$this->weapon = array( 'current' => $new, 'skill' => 'NP', 'attacks' => array( 1, 1 ), 'bonus' => 0 );
			if ( ( ! empty( $this->weapons ) ) && isset( $this->weapons[ $new ] ) ) {
				$this->weapon = array_merge( $this->weapon, $this->weapons[ $new ] );
			}
			$data = $this->get_weapon_info( $this->weapon['current'] );
			$this->weapon = array_merge( $this->weapon, $data );
			$atts  = $this->get_weapon_attacks_array( $data['attack'] );
			$index = $this->get_weapon_attacks_per_round_index( $this->skill );
			$this->weapon['attacks'] = $atts[ $index ];
			$this->weapon['to_hit']  = $this->to_hit_ac_row();
		}
		$this->determine_armor_class();
	}

	protected function get_weapon_attacks_per_round_index( $skill = 'NP' ) {
		$index = 0;
		switch( $skill ) {
			case 'DS':
				$index = 2;
				break;
			case 'SP':
				$index = 1;
				break;
			case 'NP':
			case 'PF':
			default:
				$index = 0;
		}
		return $index;
	}

	protected function to_hit_ac_row() {
		$base = $this->to_hit_ac_table();
		$row  = $this->ac_rows[ $this->level ];
		return $base[ $row ];
	}

	protected function to_hit_ac_table() {
		return array(
			/*     10   9   8   7   6   5   4   3   2   1   0  -1  -2  -3  -4  -5  -6  -7  -8  -9 -10 */
			array( 12, 13, 14, 15, 16, 17, 18, 19, 20, 20, 20, 20, 20, 20, 21, 22, 23, 24, 25, 26, 27 ), //  0
			array( 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 20, 20, 20, 20, 20, 21, 22, 23, 24, 25, 26 ), //  1
			array( 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 20, 20, 20, 20, 20, 21, 22, 23, 24, 25 ), //  2
			array(  9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 20, 20, 20, 20, 20, 21, 22, 23, 24 ), //  3
			array(  8,  9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 20, 20, 20, 20, 20, 21, 22, 23 ), //  4
			array(  7,  8,  9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 20, 20, 20, 20, 20, 21, 22 ), //  5
			array(  6,  7,  8,  9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 20, 20, 20, 20, 20, 21 ), //  6
			array(  5,  6,  7,  8,  9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 20, 20, 20, 20, 20 ), //  7
			array(  4,  5,  6,  7,  8,  9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 20, 20, 20, 20 ), //  8
			array(  3,  4,  5,  6,  7,  8,  9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 20, 20, 20 ), //  9
			array(  2,  3,  4,  5,  6,  7,  8,  9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 20, 20 ), // 10
			array(  1,  2,  3,  4,  5,  6,  7,  8,  9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 20 ), // 11
			array(  0,  1,  2,  3,  4,  5,  6,  7,  8,  9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20 ), // 12
			array( -1,  0,  1,  2,  3,  4,  5,  6,  7,  8,  9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19 ), // 13
			array( -2, -1,  0,  1,  2,  3,  4,  5,  6,  7,  8,  9, 10, 11, 12, 13, 14, 15, 16, 17, 18 ), // 14
			array( -3, -2, -1,  0,  1,  2,  3,  4,  5,  6,  7,  8,  9, 10, 11, 12, 13, 14, 15, 16, 17 ), // 15
			array( -4, -3, -2, -1,  0,  1,  2,  3,  4,  5,  6,  7,  8,  9, 10, 11, 12, 13, 14, 15, 16 ), // 16
			array( -5, -4, -3, -2, -1,  0,  1,  2,  3,  4,  5,  6,  7,  8,  9, 10, 11, 12, 13, 14, 15 ), // 17
			array( -6, -5, -4, -3, -2, -1,  0,  1,  2,  3,  4,  5,  6,  7,  8,  9, 10, 11, 12, 13, 14 ), // 18
			array( -7, -6, -5, -4, -3, -2, -1,  0,  1,  2,  3,  4,  5,  6,  7,  8,  9, 10, 11, 12, 13 ), // 19
			array( -8, -7, -6, -5, -4, -3, -2, -1,  0,  1,  2,  3,  4,  5,  6,  7,  8,  9, 10, 11, 12 ), // 20
			array( -9, -8, -7, -6, -5, -4, -3, -2, -1,  0,  1,  2,  3,  4,  5,  6,  7,  8,  9, 10, 11 ), // 21
			array(-10, -9, -8, -7, -6, -5, -4, -3, -2, -1,  0,  1,  2,  3,  4,  5,  6,  7,  8,  9, 10 ), // 22
		);
	}

	public function get_to_hit_number( $target_ac, $target_at = -1, $range = -1 ) {
		$target_at = max( $target_ac, $target_at, 0 );
		$to_hit  = $this->get_to_hit_base( $target_ac );
		$to_hit -= $this->get_weapon_adjustment( $target_at );
		if ( in_array( $this->weapon['attack'], $this->get_weapons_using_strength_bonuses() ) ) {
			$percent = $this->parse_strength_percentage( $this->stats['str'] );
			$to_hit -= $this->get_strength_to_hit_bonus( $this->stats['str'], $percent );
			$to_hit -= $this->get_weapon_proficiency_bonus( $this->weapon['skill'], $this->non_prof );
		} else if ( $this->weapon['attack'] === 'bow' ) {
			$to_hit -= $this->get_missile_to_hit_adjustment( $this->stats['dex'] );
			$to_hit -= $this->get_missile_range_adjustment( $this->weapon['range'], $range );
			$to_hit -= $this->get_missile_proficiency_bonus( $this->weapon['skill'], $this->non-prof, $range );
		}
		$to_hit -= $this->weapon['bonus'];
		return $to_hit;
	}

	protected function get_to_hit_base( $target_ac = 10 ) {
		$ac_index = 10 - $target_ac;
		if ( isset( $this->weapon['to_hit'][ $ac_index ] ) ) {
			return $this->weapon['to_hit'][ $ac_index ];
		}
		return 10000;
	}

	protected function get_weapon_adjustment( $target_at ) {
		return $this->weapon['type'][ $target_at ];
	}

	protected function get_weapon_proficiencies_total() {
		$profs = 0;
		foreach( $this->weapons as $weapon => $data ) {
			if ( $weapon === 'Spell' ) continue;
			switch( $data['skill'] ) {
				case 'NP':
					break;
				case 'PF':
					$profs++;
					break;
				case 'SP':
					$profs += 2;
					break;
				case 'DS':
					$profs += 3;
					break;
				default:
			}
		}
		return $profs;
	}

	public function get_available_weapon_proficiencies() {
		$total = $this->weap_init['initial'] + intval( ( $this->level - 1 ) / $this->weap_init['step'] );
		$current = $this->get_weapon_proficiencies_total();
		return $total - $current;
	}


}

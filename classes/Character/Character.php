<?php

abstract class DND_Character_Character implements JsonSerializable, Serializable {


	protected $ac_rows    = array( 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22 );
	protected $alignment  = 'Neutral';
	protected $armor      = array( 'armor' => 'none', 'bonus' => 0, 'type' => 10, 'class' => 10, 'rear' => 10, 'spell' => 10 );
	protected $armr_allow = array();
	public    $assigned   = 'Unassigned';
	protected $base_xp    = 0;
	public    $current_hp = -100;
	protected $experience = 0;
	protected $hit_die    = array( 'limit' => -1, 'size' => -1, 'step' => -1 );
	protected $hit_points = 0;
	protected $horse      = '';
	protected $initiative = array( 'roll' => 0, 'actual' => 0, 'segment' => 0 );
	protected $level      = 0;
	protected $max_move   = 12;
	protected $movement   = 12;
	protected $name       = 'Character Name';
	protected $non_prof   = -100;
	protected $race       = 'Human';
	protected $segment    = 0;  # attack segment
	protected $shield     = array( 'type' => 'none', 'bonus' => 0 );
	protected $shld_allow = array();
	protected $specials   = array();
	protected $spells     = array();
	protected $stats      = array( 'str' => 3, 'int' => 3, 'wis' => 3, 'dex' => 3, 'con' => 3, 'chr' => 3 );
#	protected $weap_allow = array(); // DND_Character_Trait_Weapons
#	protected $weap_dual  = false;   // DND_Character_Trait_Weapons
	protected $weap_init  = array( 'initial' => 1, 'step' => 10 );
	protected $weap_reqs  = array();
#	protected $weapon     = array( 'current' => 'none', 'skill' => 'NP', 'attacks' => [ 1, 1 ], 'bonus' => 0 ); // DND_Character_Trait_Weapons
#	protected $weapons    = array(); // DND_Character_Trait_Weapons
	protected $xp_bonus   = array();
	protected $xp_step    = 1000000;
	protected $xp_table   = array( 1000000 );

	use DND_Character_Trait_Armor;
	use DND_Character_Trait_Attributes;
	use DND_Character_Trait_SavingThrows;
	use DND_Character_Trait_Serialize;
	use DND_Character_Trait_Weapons;
	use DND_Trait_Logging;
	use DND_Trait_Magic { __get as magic__get; }
	use DND_Trait_ParseArgs;

	abstract protected function define_specials();

	public function __construct( $args = array() ) {
		if ( array_key_exists( 'ac_rows', $args ) ) {
			$this->ac_rows = $args['ac_rows'];
			unset( $args['ac_rows'] );
		}
		$this->parse_args_merge( $args );
		$this->initialize_character();
		if ( array_key_exists( 'spell_list', $args ) ) {
			$this->initialize_spell_list( $args['spell_list'] ); // This needs to be done =after= the level has been set.
		}
	}

	public function __get( $name ) {
		if ( $name === 'armor_class' ) {
			return $this->armor['class'];
		} else if ( $name === 'armor_type' ) {
			return $this->armor['type'];
		}
		return $this->magic__get( $name );
	}

	public function __toString() {
		return $this->name;
	}

	public function initialize_character() {
		if ( ( $this->level < 2 ) && ( $this->experience > 0 ) ) {
			$new_level = $this->calculate_level( $this->experience );
			if ( $new_level > $this->level ) {
				$this->level = $new_level;
				$this->set_level( $this->level );
			}
		} else if ( $this->hit_points === 0 ) {
			$this->determine_hit_points();
		}
		if ( $this->weapon['current'] === 'none' ) {
			$list = array_keys( $this->weapons );
			if ( $list ) $this->set_current_weapon( $list[0] );
		} else {
			$this->set_current_weapon( $this->weapon['current'] );
		}
		$this->define_specials();
		$this->determine_initiative();
		$this->add_filters();
	}

	public function get_name( $full = false ) {
		if ( $full ) {
			return $this->name;
		} else {
			$name = explode( ' ', $this->name );
			return $name[0];
		}
	}

	public function get_key() {
		return $this->get_name();
	}

	public function get_class() {
		return substr( get_class( $this ), 14 );
	}

	public function get_level() {
		return $this->level;
	}

	protected function calculate_level( $xp ) {
		$level = 0;
		foreach( $this->xp_table as $key => $needed ) {
			$level = $key;
			if ( $xp < $needed ) {
				break;
			}
		}
		$xp -= $this->xp_step;
		while ( $xp > 0 ) {
			$xp -= $this->xp_step;
			$level++;
		}
		return $level;
	}

	public function set_level( $level ) {
		$this->level = $level;
		$old_hp = $this->hit_points;
		$this->determine_hit_points();
		$this->current_hp = $this->hit_points;
		if ( method_exists( $this, 'reload_spells' ) ) $this->reload_spells();
	}

	public function add_experience( $xp ) {
		$bonus = ! empty( $this->xp_bonus );
		foreach( $this->xp_bonus as $stat => $limit ) {
			if ( $this->stats[ $stat ] < $limit ) {
				$bonus = false;
			}
		}
		$this->base_xp    += $xp;
		$this->experience += ( $bonus ) ? round( $xp * 1.1 ) : $xp;
		$level = $this->calculate_level( $this->experience );
		if ( $level > $this->level ) {
			$this->set_level( $level );
		}
	}

	protected function determine_hit_points() {
		$base = $this->hit_die['size'] + $this->get_constitution_hit_point_adjustment( $this->stats['con'] );
		$this->hit_points = $base * min( $this->hit_die['limit'], $this->level );
		if ( $this->level > $this->hit_die['limit'] ) {
			$this->hit_points += ( $this->level - $this->hit_die['limit'] ) * $this->hit_die['step'];
		}
		if ( ! ( $this->current_hp === -100 ) ) $this->current_hp = $this->hit_points;
	}

	protected function get_constitution_hit_point_adjustment( $con ) {
		$bonus = $this->attr_get_constitution_hit_point_adjustment( $con );
		return min( $bonus, 2 );
	}

	public function get_hit_points() {
		return $this->current_hp + apply_filters( 'character_temporary_hit_points', 0, $this );
	}

	protected function determine_armor_class() {
		$no_shld = in_array( $this->weapon['attack'], $this->get_weapons_not_allowed_shield() );
		$this->armor['type'] = $this->get_armor_ac_value( $this->armor['armor'] );
		$this->armor['rear'] = $this->armor['type'];
		if ( ! ( ( $this->shield['type'] === 'none' ) || $no_shld ) ) {
			$this->armor['type']--;
		}
		$this->armor['class'] = $this->armor['type'];
		$this->movement = min( $this->max_move, $this->get_armor_base_movement( $this->armor['armor'], $this->movement ) + $this->armor['bonus'] );
		$this->armor['class'] -= $this->armor['bonus'];
		$this->armor['rear']  -= $this->armor['bonus'];
		$this->armor['class'] -= ( $no_shld ) ? 0 : $this->shield['bonus'];
		$this->armor['class'] -= apply_filters( 'character_armor_class_adjustments', 0, $this );
		$this->armor['spell']  = $this->armor['class'];
		$this->armor['class'] += $this->get_armor_class_dexterity_adjustment( $this->stats['dex'] );
		if ( ! ( $this->armor['bonus'] === 0 ) ) {
			$filter = $this->get_name() . '_all_saving_throws';
			if ( ! has_filter( $filter ) ) {
				add_filter( $filter, function( $num ) { return $num - $this->armor['bonus']; } );
			}
		}
	}

	protected function determine_initiative() {
		if ( $this->initiative['roll'] > 0 ) {
			$this->initiative['actual']  = $this->initiative['roll'] + $this->get_missile_to_hit_adjustment( $this->stats['dex'] );
			$this->initiative['segment'] = 11 - $this->initiative['actual'];
			if ( $this->segment === 0 ) $this->segment = $this->initiative['segment'];
		}
	}

	public function set_initiative( $roll ) {
		$roll = intval( $roll, 10 );
		if ( $roll ) {
			$this->initiative['roll'] = $roll;
			$this->determine_initiative();
		}
	}

	public function set_attack_segment( $segment ) {
		if ( intval( $segment ) > 0 ) {
			$this->segment = intval( $segment );
		}
	}

	protected function add_filters() {
		$this->add_racial_saving_throw_filters();
#		$this->add_dexterity_saving_throw_filters();
	}

	public function set_current_weapon( $new = '' ) {
		return $this->set_character_weapon( $new );
	}

	public function get_to_hit_number( $target, $range = -1, $extra = '' ) {
		if ( ! is_object( $target ) ) { return -1; }
		if ( $this->weapons_armor_type_check( $target ) && property_exists( $target, 'armor' ) ) {
			$to_hit  = $this->get_to_hit_base( $target->armor['class'] );
			$to_hit -= $this->get_weapon_type_adjustment( $this->weapon['current'], $target->armor['type'] );
		} else {
			if ( $target->armor_class === -11 ) return 100; // error in target class
			$to_hit  = $this->get_to_hit_base( $target->armor_class );
		}
		if ( in_array( $this->weapon['attack'], $this->get_weapons_using_strength_bonuses() ) ) {
			$to_hit -= $this->get_strength_to_hit_bonus( $this->stats['str'] );
			$to_hit -= $this->get_weapon_proficiency_bonus( $this->weapon['skill'] );
		} else if ( in_array( $this->weapon['attack'], $this->get_weapons_using_missile_adjustment() ) ) {
			$to_hit -= $this->get_missile_to_hit_adjustment( $this->stats['dex'] );
			$to_hit -= $this->get_missile_range_adjustment( $this->weapon['range'], $range );
			$to_hit -= $this->get_missile_proficiency_bonus( $this->weapon, $range );
		}
		$to_hit -= $this->weapon['bonus'];
		$to_hit -= apply_filters( 'character_to_hit_opponent', 0, $to_hit, $this );
		return $to_hit;
	}

	protected function get_to_hit_base( $target_ac = 10 ) {
		$index = 10 - $target_ac;
		$table = $this->to_hit_ac_table();
		$key   = min( $this->level, count( $this->ac_rows ) - 1 );
		$row   = $this->ac_rows[ $key ];
		$base  = $table[ $row ];
		if ( array_key_exists( $index, $base ) ) {
			return $base[ $index ];
		}
		return 10000;
	}

	public function get_weapon_damage( $size ) {
		$string = "Size passed: $size, can only be 'Small', 'Medium', or 'Large'";
		$test   = substr( $size, 0, 1 );
		if ( in_array( $test, [ 'S', 'M', 'L' ] ) ) {
			if ( $test === 'L' ) {
				$string = $this->weapon['damage'][1];
			} else {
				$string = $this->weapon['damage'][0];
			}
		}
		return $string;
	}

	public function get_weapon_damage_bonus( $target = null, $range = -1 ) {
		$bonus = $this->get_missile_proficiency_bonus( $this->weapon, $range, 'damage' );
		if ( in_array( $this->weapon['attack'], $this->get_weapons_using_strength_damage() ) ) {
			$bonus += $this->get_strength_damage_bonus( $this->stats['str'] );
		}
		$bonus += $this->weapon['bonus'];
		return apply_filters( 'character_weapon_damage_bonus', $bonus, $this, $target );
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
		$total   = $this->weap_init['initial'] + intval( ( $this->level - 1 ) / $this->weap_init['step'] );
		$current = $this->get_weapon_proficiencies_total();
		return $total - $current;
	}

	/** Filters Effects **/

	public function this_character_only( $purpose, $spell, $char ) {
		if ( $char->get_name() === $spell['target'] ) {
			return true;
		}
		return false;
	}

	public function check_temporary_hit_points( $damage ) {
		$damage = intval( $damage );
		if ( $damage > 0 ) {
			$combat = dnd1e()->combat;
			$name   = $this->get_name();
			foreach( $combat->effects as $key => $effect ) {
				if ( $effect['target'] === $name ) {
					if ( array_key_exists( 'condition', $effect ) ) {
						// TODO: check for aoe conditions
						if ( $effect['condition'] === 'this_character_only' ) {
							foreach( $effect['filters'] as $index => $filter ) {
								if ( $filter[0] === 'character_temporary_hit_points' ) {
									$remaining = $combat->effects[ $key ]['filters'][ $index ][1];
									$remaining -= $damage;
									if ( $remaining > 0 ) {
										$combat->effects[ $key ]['filters'][ $index ][1] -= $remaining;
										$damage = 0;
									} else {
										$damage = abs( $remaining );
										$combat->remove_effect( $key );
										break;
									}
								}
							}
						}
					}
				}
			}
		}
		return $damage;
	}


}

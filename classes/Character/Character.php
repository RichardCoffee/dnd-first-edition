<?php

abstract class DND_Character_Character implements JsonSerializable, Serializable {


	protected $ac_rows    = array( 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22 );
	protected $alignment  = 'Neutral';
#	protected $armor      = array(); // DND_Character_Trait_Armor
	protected $armr_allow = array();
	public    $assigned   = 'Unassigned';
	protected $base_xp    = 0;
	public    $current_hp = -100;
	protected $experience = 0;
	protected $gear       = array();
	protected $hit_die    = array( 'limit' => -1, 'size' => -1, 'step' => -1 );
	protected $hit_points = 0;
	protected $horse      = '';
	protected $initiative = array( 'roll' => 0, 'actual' => 0, 'segment' => 0 );
	protected $level      = 0;
	protected $move       = array( 'max' => 12, 'foot' => 12, 'segment' => 0 );
	protected $max_move   = 12;
	protected $movement   = 12;
	protected $name       = 'Character Name';
	protected $non_prof   = -100;
	protected $race       = 'Human';
	protected $segment    = 0;  # attack segment
#	protected $shield     = array(); // DND_Character_Trait_Armor
	protected $shld_allow = array();
	protected $specials   = array();
	protected $spells     = array();
	protected $stats      = array( 'str' => 3, 'int' => 3, 'wis' => 3, 'dex' => 3, 'con' => 3, 'chr' => 3 );
#	protected $weap_allow = array(); // DND_Character_Trait_Weapons
#	protected $weap_dual  = false;   // DND_Character_Trait_Weapons
	protected $weap_init  = array( 'initial' => 1, 'step' => 10 );
	protected $weap_reqs  = array();
#	protected $weapon     = array(); // DND_Character_Trait_Weapons
#	protected $weapons    = array(); // DND_Character_Trait_Weapons
	protected $xp_bonus   = array();
	protected $xp_step    = 1000000;
	protected $xp_table   = array( 1000000 );

	use DND_Character_Trait_Armor;
	use DND_Character_Trait_Attributes;
	use DND_Character_Trait_SavingThrows;
	use DND_Character_Trait_Serialize;
	use DND_Character_Trait_Utilities;
	use DND_Character_Trait_Weapons;
	use DND_Trait_Logging;
	use DND_Trait_Magic;
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

	public function __toString() {
		return $this->name;
	}

	protected function initialize_character() {
		if ( ( $this->level < 2 ) && ( $this->experience > 0 ) ) {
			# FIXME: this section may be either unnecessary or need to be rewritten
			$new_level = $this->calculate_level( $this->experience );
			if ( $new_level > $this->level ) {
				$this->level = $new_level;
				$this->set_level( $this->level );
			}
		} else if ( $this->hit_points === 0 ) {
			$this->determine_hit_points();
		}
		if ( $this->weapon['current'] === 'none' ) $this->set_current_weapon( array_key_first( $this->weapons ) );
		$this->define_specials();
		$this->determine_initiative();
		$this->add_filters();
	}

	public function get_name( $full = false ) {
		if ( $full ) return $this->name;
		$name = explode( ' ', $this->name );
		return $name[0];
	}

	public function get_key( $underscore = false ) {
		if ( $underscore ) return str_replace( ' ', '_', $this->get_name( true ) );
		return $this->get_name();
	}

	// Compatibility function
	public function set_key( $new ) {
		if ( $this->name === 'Character Name' ) {
			$this->name = $new;
		}
	}

	public function get_class() {
		return array_reverse( explode( '_', get_class( $this ) ) )[0];
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
		return $this->current_hp + apply_filters( 'dnd1e_temporary_hp', 0, $this );
	}

	protected function get_ac_dex_bonus() {
		if ( $this->is_immobilized() ) return 0;
		if ( $this->is_prone() )       return 0;
		if ( $this->is_stunned() )     return 0;
		return $this->get_armor_class_dexterity_adjustment( $this->stats['dex'] );
	}

	protected function determine_initiative() {
		if ( ( $this->segment === 0 ) &&  ( $this->initiative['roll'] > 0 ) ) {
			$this->initiative['actual']  = $this->initiative['roll'] + $this->get_missile_to_hit_adjustment( $this->stats['dex'] );
			$this->initiative['segment'] = 11 - $this->initiative['actual'];
			$this->segment = $this->initiative['segment'];
		}
	}

	public function set_initiative( $roll ) {
		$roll = intval( $roll );
		if ( $roll ) {
			$this->initiative['roll'] = $roll;
			$this->determine_initiative();
		}
	}

	public function set_attack_segment( $segment ) {
		if ( is_numeric( $segment ) ) {
			$this->segment = intval( $segment );
			if ( $this->segment === 0 ) $this->initiative['roll'] = 0;
		}
	}

	protected function add_filters() {
		$this->add_racial_saving_throw_filters();
#		$this->add_dexterity_saving_throw_filters();
	}

	public function set_current_weapon( $new = '' ) {
		if ( $status = $this->set_character_weapon( $new ) ) {
			$this->determine_armor_class();
			$bonus  = apply_filters( 'dnd1e_armor_bonus', $this->armor['bonus'], $this );
			$this->move['foot'] = min( $this->move['max'], $this->get_armor_base_movement( $this->armor['armor'], $this->move['foot'] ) + $bonus );
		}
		return $status;
	}

	public function get_to_hit_number( $target, $range = -1 ) {
		if ( ! is_object( $target ) ) { return -1; }
		$to_hit = $this->weapon_to_hit_number( $this->weapon, $target, $range );
		$to_hit -= apply_filters( 'dnd1e_object_to_hit_opponent', 0, $this );
		return $to_hit;
	}

	protected function weapon_to_hit_number( $weapon, $target, $range ) {
#$stat = ( ! ( strpos( $weapon['current'], 'Dagger' ) === false ) );
$stat = false;
		$target_armor = ( $weapon['current'] == 'Spell' ) ? $target->get_armor_spell() : $target->get_armor_class();
		if ( $target_armor < -10 ) return 99; // error in target class
		$to_hit = $this->get_to_hit_base( $target_armor );
if ( $stat ) echo "to hit1: $to_hit\n";
		if ( $this->weapons_armor_type_check( $target ) ) {
			$to_hit -= $$weapon['type'][ $target->get_armor_type() ];
if ( $stat ) echo "to hit2: $to_hit\n";
		}
		if ( in_array( $weapon['attack'], $this->get_weapons_using_strength_bonuses() ) ) {
			$to_hit -= $this->get_strength_to_hit_bonus( $this->stats['str'] );
if ( $stat ) echo "to hit3: $to_hit\n";
			$to_hit -= $this->get_weapon_proficiency_bonus( $weapon['skill'] );
if ( $stat ) echo "to hit4: $to_hit\n";
		} else if ( in_array( $weapon['attack'], $this->get_weapons_using_missile_adjustment() ) ) {
			$to_hit -= $this->get_missile_to_hit_adjustment( $this->stats['dex'] );
if ( $stat ) echo "to hit5: $to_hit\n";
			$to_hit -= $this->get_missile_range_adjustment( $weapon['range'], $range );
if ( $stat ) echo "to hit6: $to_hit\n";
			$to_hit -= $this->get_missile_proficiency_bonus( $weapon, $range );
if ( $stat ) echo "to hit7: $to_hit\n";
		}
		$to_hit -= $weapon['bonus'];
if ( $stat ) echo "to hit8: $to_hit\n";
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


	/**  Proficiency functions  **/

	protected function get_weapon_proficiencies_total() {
		$profs = 0;
		foreach( $this->weapons as $weapon => $data ) {
			if ( $weapon === 'Spell' ) continue;
			switch( $data['skill'] ) {
				case 'DS':
					$profs++;
				case 'SP':
					$profs++;
				case 'PF':
					$profs++;
				case 'NP':
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


	/**  Spell functions  **/

	public function is_listed_spell( $spell ) { return false; }


}

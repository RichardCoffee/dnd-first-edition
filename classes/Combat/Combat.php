<?php

/*
  Implement notes:

target stunned, prone, motionless - no ac dex bonus, opponent gets +4 to hit
target flank - no shield bonus
target rear - no shield or ac dex bonus, opponent gets +2 to hit
target invisible - opponent gets -4 to hit, no flank or rear attacks


*/

abstract class DND_Combat_Combat implements JsonSerializable, Serializable {


	protected $casting = array();
	public    $effects = array();
	protected $enemy   = array();
	protected $error   = '';
	protected $holding = array();
	protected $party   = array();
	protected $range   = 2000;
	protected $rounds  = 3;
	protected $segment = 1;


	use DND_Combat_Movement;
	use DND_Trait_Magic;
	use DND_Trait_ParseArgs;
	use DND_Trait_Singleton;


	protected function __construct( array $args = array() ) {
		$this->parse_args( $args );
		$this->rounds += floor( $this->segment / 10 );
		if ( $this->effects ) $this->integrate_effects();
		if ( $this->party )   $this->integrate_party();
		if ( $this->enemy )   $this->integrate_enemy();
		if ( $this->holding ) $this->update_holds();
		$this->determine_movement();
		do_action( 'dnd1e_combat_init', $this );
	}

	public function __toString() {
		return 'Combat base class';
	}


	/**  Startup functions  **/

	protected function integrate_effects() {
		foreach( $this->effects as $key => $effect ) {
			if ( $effect->has_ended( $this->segment ) ) {
				$this->remove_effect( $key );
				continue;
			}
			$this->process_effect_filters( $effect );
		}
	}

	protected function process_effect_filters( $effect ) {
		if ( $effect->rewrite ) {
			$origin = $this->get_object( $effect->get_caster() );
			$effect->activate_filters( $origin );
			return;
		}
#echo $effect->get_name()." 1\n";
		if ( $effect->get_when() > $this->segment ) return;
#echo $effect->get_name()." 2\n";
		$filters = $effect->get_filters();
		$replace = apply_filters( 'dnd1e_replacement_filters', array() ); //
		// TODO: take aoe into account
		foreach( $filters as $filter ) {
			list ( $name, $delta, $priority, $argn ) = $filter;
#print_r($filter);
			add_filter( $name, function( $value, $b = null, $c = null, $d = null ) use ( $filter, $effect, $replace ) {
static $cnt = 0;
				list ( $name, $delta, $priority, $argn ) = $filter;
				if ( $effect->has_condition() ) {
					foreach( [ $b, $c, $d, $this ] as $object ) {
						if ( $object === null ) continue;
						if ( $effect->condition_applies( $object ) ) {
/*
echo $object->get_key()."\n";
echo "condition: ".$effect->get_condition()."\n";
echo $effect->get_target()."\n";
echo "  purpose: $name\n";
echo "prior: $value  new: $delta cnt: $cnt\n";
#if ( $cnt > 1 ) trigger_error( 'effect filters', E_ERROR );
$cnt++;
//*/
							if ( in_array( $name, $replace ) ) {
								return $delta;
							} else {
								return $value + $delta;
							}
						} else {
							return $value;
						}
					}
				}
				return $value + $delta;
			}, $priority, $argn );
		}
	}

	protected function integrate_party() {
		foreach( $this->party as $name => $char ) {
			if ( is_array( $char ) ) {
				$create = $char['what_am_i'];
				$this->party[ $name ] = new $create( $char );
			}
			if ( $char->is_stunned() ) {
				$char->set_current_weapon( 'Stunned' );
			} else if ( $char->weapon['current'] === 'Stunned' ) {
				$char->set_current_weapon( array_key_first( $char->weapons ) );
			}
			$this->check_casting( $char );
		}
	}

	protected function integrate_enemy() {
		foreach( $this->enemy as $key => $monster ) {
			if ( is_array( $monster ) ) {
				if ( array_key_exists( 'what_am_i', $monster ) ) {
					$create = $monster['what_am_i'];
					$obj = new $create( $monster );
					if ( is_string( $key ) ) {
						$name = $key;
					} else {
						$name = $obj->get_name() . " $key";
					}
					$this->enemy[ $name ] = $obj;
					if ( ! is_string( $key ) ) {
						unset( $this->enemy[ $key ] );
					}
				} else { echo "\nError importing monster\n";print_r( $monster ); }
			}
			$this->check_casting( $monster );
		}
	}

	protected function update_holds() {
		foreach( $this->holding as $name ) {
			$object  = $this->get_object( $name );
			$segment = max( $this->segment, $object->segment );
			$object->set_attack_segment( $segment );
		}
	}

	public function new_segment_housekeeping( $unused = null ) {
		foreach( $this->enemy as $key => $object ) {
			$object->check_for_weapon_change( $this->segment );
			do_action( 'dnd1e_new_seg_enemy', $this, $object );
		}
		add_filter( 'dnd1e_check_weapon_sequence', function( $arg ) { return true; } );
	}

	protected function reset_combat() {
		$this->casting = array();
		$this->effects = array();
		$this->enemy   = array();
		$this->holding = array();
		$this->party   = array();
		$this->rounds  = 3;
		$this->segment = 1;
	}

	protected function get_party_attackers() {
		$party = array();
		foreach( $this->party as $char ) {
			if ( $this->filter_attacker( $char ) ) {
				$party[] = $char;
			}
		}
		return $party;
	}

	protected function get_enemy_attackers() {
		$enemy = array();
		foreach( $this->enemy as $object ) {
			if ( $object->current_hp < 1 ) continue;
			if ( $this->filter_attacker( $object ) ) {
				$enemy[] = new DND_Monster_Ranking( $object );
			}
		}
		return $enemy;
	}

	protected function filter_attacker( $object ) {
		$sequence = $this->get_attack_sequence( $object );
		if ( in_array( $this->segment, $sequence ) ) return true;
		$key = $object->get_key();
		if ( $this->is_casting( $key ) ) return true;
		return false;
	}

	protected function rank_attackers( &$rank ) {
		usort( $rank, function( $a, $b ) {
			$aname = $a->get_key();
			$bname = $b->get_key();
			if ( $this->holding ) {
				if ( in_array( $aname, $this->holding ) && in_array( $bname, $this->holding ) ) {
				} else if ( in_array( $aname, $this->holding ) ) {
					return -1;
				} else if ( in_array( $bname, $this->holding ) ) {
					return 1;
				}
			}
			if ( $this->casting ) {
				$aspell = $this->find_casting( $aname );
				$bspell = $this->find_casting( $bname );
				if ( $aspell && $bspell ) {
				} else if ( $aspell && ( ! ( $aspell->get_when() === $this->segment ) ) ) {
					return -1;
				} else if ( $bspell && ( ! ( $bspell->get_when() === $this->segment ) ) ) {
					return 1;
				}
			}
			if ( $a->stats['dex'] === $b->stats['dex'] ) {
				return ( $b->initiative['actual'] - $a->initiative['actual'] );
			} else {
				return ( $b->stats['dex'] - $a->stats['dex'] );
			}
		} );
	}


	/**  Utility functions  **/

	protected function add_holding( $target, $segment = 0 ) {
		if ( $object = $this->get_object( $target ) ) {
			$this->holding[] = $object->get_key();
			$segment = ( $segment > 0 ) ? max ( $segment, $this->segment ) : $this->segment;
			$object->set_attack_segment( $segment );
		}
	}

	protected function critical_hit_result( $roll, $type ) {
		$dr = new DND_DieRolls;
		return $dr->get_crit_result( $roll, $type );
	}

	protected function fumble_roll_result( $roll ) {
		$dr = new DND_DieRolls;
		return $dr->get_fumble_result( $roll );
	}

	protected function get_attack_sequence( $object ) {
		return $object->get_attack_sequence( $this->rounds );
	}

	public function get_key() {
		return $this->__toString();
	}

	protected function get_object( $name, $strict = false ) {
		if ( is_object( $name ) ) return $name;
		if ( array_key_exists( $name, $this->party ) ) {
			return $this->party[ $name ];
		} else if ( array_key_exists( $name, $this->enemy ) ) {
			return $this->enemy[ $name ];
		} else if ( $strict && ! is_numeric( $name ) ) {
		} else {
			return $this->get_specific_enemy( intval( $name ) );
		}
		return null;
	}

	protected function remove_holding( $one ) {
		$object = $this->get_object( $one );
		if ( $object ) {
			$key = $object->get_key();
			if ( in_array( $key, $this->holding ) ) {
				$this->holding = array_diff( $this->holding, [ $key ] );
				$object->set_attack_segment( $this->segment );
			}
		}
	}


	/**  Monster  **/

	public function initialize_enemy( DND_Monster_Monster $monster ) {
		$base = get_class( $monster );
		$this->add_to_enemy( $monster );
		$number = $monster->get_number_appearing();
		if ( is_array( $number ) ) {
			foreach( $number as $enemy ) {
				$this->add_to_enemy( ( is_array( $enemy ) ) ? new $base( $enemy ) : $enemy );
			}
		} else {
			if ( $number > 1 ) {
				$points = $monster->get_appearing_hit_points( $number );
				for( $i = 1; $i < $number; $i++ ) {
					$new = new $base( [ 'current_hp' => $points[ $i ][0], 'hit_points' => $points[ $i ][1] ] );
					$this->add_to_enemy( $new );
				}
			}
		}
		$adds = apply_filters( 'dnd1e_additional_appearing', array() );
		if ( ! empty( $adds ) ) {
			foreach( $adds as $object ) {
				$this->add_to_enemy( $object );
			}
		}
	}

	public function add_to_enemy( DND_Monster_Monster $object ) {
		$cnt = count( $this->enemy );
		$key = $object->get_name() . " $cnt";
		while( array_key_exists( $key, $this->enemy ) ) {
			$cnt++;
			$key = $object->get_name() . " $cnt";
		}
		$object->set_key( $key );
		$object->set_initiative( mt_rand( 1, 10 ) );
		$this->enemy[ $key ] = $object;
	}

	public function remove_from_enemy( $key ) {
		if ( array_key_exists( $key, $this->enemy ) ) {
			unset( $this->enemy[ $key ] );
			return true;
		}
		return false;
	}

	protected function set_monster_initiative_all( $init ) {
		$init = intval( $init, 10 );
		foreach( $this->enemy as $name => $monster ) {
			$monster->set_initiative( $init );
		}
	}

	protected function get_base_monster() {
		return $this->get_specific_enemy();
	}

	protected function get_specific_enemy( $num = 0 ) {
		$list = array_keys( $this->enemy );
		if ( $list && array_key_exists( $num, $list ) ) {
			return $this->enemy[ $list[ $num ] ];
		}
		return null;
	}

	protected function get_enemy_morale() {
		$base = count( $this->enemy );
		$cnt  = 0;
		foreach( $this->enemy as $obj ) {
			if ( $obj->current_hp > 0 ) $cnt++;
		}
		return round( $cnt / $base * 100 );
	}


	/**  Spells  **/

	protected function pre_cast_spell( $origin, $object, $target = '' ) {
		if ( $this->segment < 2 ) {
			if ( $effect = $this->start_casting( $origin, $object, $target ) ) {
				$effect->set_pre_cast();
				$this->finish_casting( $effect );
				$this->remove_casting( $effect->get_caster() );
				return $effect;
			}
		}
		return false;
	}

	protected function start_casting( $origin, $spell, $target = false ) {
		$object = $this->get_object( $origin );
		if ( $object && $spell ) {
			$this->remove_holding( $object->get_key() );
			if ( ( $target === false ) && ( $spell->get_target() === 'required' ) ) {
				$this->error = "Spell '" . $spell->get_name() . "' missing required target.";
			} else {
				$target = $this->get_object( $target );
				$spell->set_target( ( $target ) ? $target : $origin );
				$spell->set_when( $this->segment );
				$this->casting[] = $spell;
				return $spell;
			}
		}
		return false;
	}

	protected function is_casting( $caster ) {
		if ( empty( $this->casting ) ) return false;
		return $this->find_casting( $caster );
	}

	protected function find_casting( $caster ) {
		foreach( $this->casting as $spell ) {
			if ( $spell->get_caster() === $caster ) {
				return $spell;
			}
		}
		return false;
	}

	protected function process_spell_data( $caster, $data ) {
		$origin = $this->get_object( $caster );
		$spell  = $this->find_casting( $origin->get_key() );
		$spell->process_apply( $origin, $data );
		$this->finish_casting( $spell );
	}

	protected function remove_casting( $caster ) {
		$this->casting = array_filter(
			$this->casting,
			function( $a ) use ( $caster ) {
				if ( $a->get_caster() === $caster ) return false;
				return true;
			}
		);
	}

	protected function finish_casting( $spell ) {
		$caster = $this->get_object( $spell->get_caster() );
		$target = $this->get_object( $spell->get_target() );
		$spell->process_apply( $caster, $target );
		if ( count( $spell->get_filters() ) > 0 ) {
			$this->add_effect( $spell );
		}
		$caster->spend_manna( $spell );
		$this->remove_casting( $caster->get_key() );
	}

	protected function abort_casting( $origin ) {
		$obj = $this->get_object( $origin );
		$key = $obj->get_key();
		if ( $this->is_casting( $key ) ) {
			$obj->spend_manna( $this->find_casting( $key ) );
			$this->remove_casting( $key );
		}
	}

	protected function check_casting( $object ) {
		$key = $object->get_key();
		if ( $this->is_casting( $key ) ) {
			$spell = $this->find_casting( $key );
			if ( $this->segment > $spell->get_when() ) {
				$this->finish_casting( $spell );
			}
		}
	}

	protected function add_effect( $effect ) {
		$key = $effect->get_key();
		$this->effects[ $key ] = $effect;
		$this->process_effect_filters( $effect );
	}

	protected function find_effect() {
	}

	protected function remove_effect( $key ) {
		if ( $key && array_key_exists( $key, $this->effects ) ) {
			unset( $this->effects[ $key ] );
		}
	}

	/**  Party  **/

	public function add_to_party( $obj, $data = array() ) {
		if ( is_object( $obj ) ) {
			$key = $obj->get_key();
			$this->party[ $key ] = $obj;
			return true;
		} else if ( is_string( $obj ) && defined( 'CSV_PATH' ) ) {
			$file = CSV_PATH . $obj . '.csv';
			if ( is_readable( $file ) ) {
				$save = $this->pre_existing_character_check( $obj, $data );
				$temp = new DND_Character_Import_Kregen( $file, $data );
				$name = $temp->character->get_key();
				$this->party[ $name ] = $temp->character;
				if ( $save ) $this->pre_existing_character_update( $name, $save );
				return true;
			}
		}
		return false;
	}

	protected function pre_existing_character_check( $name, $data ) {
		$data = array();
		if ( array_key_exists( $name, $this->party ) ) {
			$char = $this->party[ $name ];
			$data['segment'] = $char->segment;
			$data['weapon']  = $char->weapon['current'];
			$data['current'] = $char->current_hp;
		}
		return $data;
	}

	protected function pre_existing_character_update( $name, $data ) {
		$char = $this->party[ $name ];
		$char->set_attack_segment( $data['segment'] );
		$char->set_current_weapon( $data['weapon'] );
		$char->current_hp = $data['current'];
	}

	protected function remove_from_party( $name ) {
		if ( array_key_exists( $name, $this->party ) ) {
			unset( $this->party[ $name ] );
			return true;
		}
		return false;
	}

	protected function temporary_hit_points( $object, $damage ) {
		$damage = intval( $damage );
		if ( $damage > 0 ) {
			$applies = array_filter(
				$this->effects,
				function( $a ) use ( $object ) {
					if ( $a->condition_applies( $object ) ) {
						foreach( $a->get_filters() as $filter ) {
							if ( $filter[0] === 'temporary_hit_points' )   return true; // Ill: Phantom Armor
							if ( $filter[0] === 'dissipation_hit_points' ) return true; // MU: Armor
						}
					}
					return false;
				}
			);
			foreach( $applies as $key => $effect ) {
				foreach( $effect->get_filters() as $index => $filter ) {
					if ( $filter[0] === 'temporary_hit_points' ) {
						$remaining = $filter[1];
						$remaining-= $damage;
						if ( $remaining > 0 ) {
							$effect->set_filter_delta( $index, $remaining, true );
							$damage = 0;
						} else {
							$damage = abs( $remaining );
							$this->remove_effect( $key );
							break;
						}
					}
					if ( $filter[0] === 'dissipation_hit_points' ) {
						if ( $effect->set_filter_delta( $index, $damage ) < 1 ) {
							$this->remove_effect( $key );
							break;
						}
					}
				}
			}
		}
		return $damage;
	}


	/**  Combat functions  **/

	protected function change_weapon( $object, $weapon ) {
		$sequence = $this->get_attack_sequence( $object );
		if ( $this->segment === 1 ) {
			$object->set_current_weapon( $weapon );
		} else if ( in_array( $this->segment, $sequence ) ) {
			if ( $object->set_current_weapon( $weapon ) ) {
				$object->set_attack_segment( $this->segment );
			}
		} else {
			foreach( $sequence as $seggie ) {
				if ( $seggie > $this->segment ) {
					if ( $object->set_current_weapon( $weapon ) ) {
						$object->set_attack_segment( $seggie );
					}
					break;
				}
			}
		}
	}

	public function get_to_hit_number( $name1, $name2 ) {
		$origin = $this->get_object( $name1, true );
		if ( ( ! $origin ) || $origin->is_stunned() ) return 100;
		$target = $this->get_object( $name2, true );
		if ( ! $target ) return 100;
		$target->determine_armor_class();
		$to_hit = $origin->get_to_hit_number( $target, $this->range );
		$to_hit-= ( $target->is_down() ) ? 4 : 0;
		$to_hit = apply_filters( 'opponent_to_hit_object', $to_hit, $target, $origin );
		return apply_filters( 'opponent_to_hit_opponent', $to_hit, $origin, $target );
	}

	protected function object_damage( $name, $damage, $type = '' ) {
		$target = $this->get_object( $name );
		if ( $target ) {
			$damage = intval( apply_filters( 'dnd1e_damage_to_target', $damage, $target, $type ) );
			if ( $damage ) {
				if ( $target instanceOf DND_Character_Character ) {
					$damage = $this->temporary_hit_points( $target, $damage );
				}
				$target->assign_damage( $damage, $this->segment, $type );
				$this->abort_casting( $target );
			}
		}
	}

	protected function add_hit_effect( $from, $to, $type ) {
		$origin = $this->get_object( $from );
		$target = $this->get_object( $to );
		if ( $origin && $target ) {
			$func = $origin->get_name(1) . "_{$type}_effect";
			if ( method_exists( $origin, $func ) ) {
				$effect = $origin->$func( $target, $this->segment );
				if ( $effect ) {
					$this->add_effect( $effect );
					$filters = array_column( $effect['filters'], 0 );
					if ( $effect->has_filter( 'target_prone' ) ) {
						$adj = 10 + $target->get_armor_class_dexterity_adjustment( $target->stats['dex'] );
						$effect->set_ends( $this->segment + $adj );
						$this->add_holding( $target, max( $this->segment + $adj, $target->segment ) );
					}
					if ( $effect->has_secondary() ) {
						list( $f, $t, $y ) = $effect->get_secondary();
						$this->add_hit_effect( $f, $t, $y );
					}
				}
			} else { $this->show_message( "Function '$func' not found!" ); }
		}
	}


	/**  JsonSerializable and Serializable functions  **/

	public function JsonSerialize() {
		$table = $this->get_serialization_data();
		return $table;
	}

	public function serialize() {
		return serialize( $this->get_serialization_data() );
	}

	protected function get_serialization_data() {
		$table = array(
			'casting' => $this->casting,
			'effects' => $this->effects,
			'enemy'   => $this->enemy,
			'holding' => $this->holding,
			'party'   => $this->party,
			'segment' => $this->segment,
		);
		$table['what_am_i'] = get_class( $this );
		return $table;
	}

	public function unserialize( $data ) {
		$args = unserialize( $data );
		$this->__construct( $args );
	}


}

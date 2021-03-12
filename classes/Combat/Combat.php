<?php

/*
  Implement notes:

target stunned, prone, motionless - no ac dex bonus, opponent gets +4 to hit - PARTLY DONE
target flank - no shield bonus
target rear - no shield or ac dex bonus, opponent gets +2 to hit
target invisible - opponent gets -4 to hit, no flank or rear attacks


*/

abstract class DND_Combat_Combat implements JsonSerializable, Serializable {


	protected $action   = array();
	protected $base     = null;
#	protected $casting  =  array(); // DND_Combat_Spells
	public    $effects  = array();
	protected $enemy    = array();
	protected $error    = '';
#	protected $gear     = array();  // DND_Combat_Gear
	protected $holding  = array();
	public    $messages = array();
	protected $party    = array();
	protected $range    = 2000;
	protected $rounds   = 3;
	protected $segment  = 1;


	protected $dcc_debug = array(
		'atp'  => false,    # add_to_party
		'gthn' => false,    # get_to_hit_number
		'oaa'  => false,    # opp_attack_adj
	);


	use DND_Combat_Gear;
	use DND_Combat_Movement;
	use DND_Combat_Spells;
	use DND_Trait_Magic;
	use DND_Trait_ParseArgs;
	use DND_Trait_Singleton;


	abstract protected function show_error( $error );
	abstract protected function show_messages( $messages = array() );


	protected function __construct( array $args = array() ) {
		$this->parse_args( $args );
		$this->rounds += floor( $this->segment / 10 );
		if ( $this->effects ) $this->integrate_effects();
		if ( $this->party )   $this->integrate_party();
		if ( $this->enemy )   $this->integrate_enemy();
		if ( empty( $this->gear ) ) $this->load_transient_gear();
		if ( $this->gear )    $this->integrate_gear();
#print_r($this->gear);
		if ( $this->holding ) $this->update_holds();
		$this->determine_movement();
		if ( $this->segment % 10 === 0 ) $this->messages[] = 'Enemy Morale check!';
		do_action( 'dnd1e_combat_init', $this );
	}

	public function __toString() {
		return 'Combat';
	}


	/**  Startup functions  **/

	protected function integrate_effects() {
		foreach( $this->effects as $key => $effect ) {
if ( is_array( $effect ) ) continue;
			if ( $effect->has_ended( $this->segment ) ) {
				$this->remove_effect( $key );
				continue;
			}
			$this->process_effect_filters( $effect );
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
#			} else if ( $char->weapon['current'] === 'Stunned' ) {
#				$char->set_current_weapon( array_key_first( $char->weapons ) );
			}
			$this->integrate_object( $char );
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
			$this->integrate_object( $monster );
		}
	}

	protected function integrate_object( $object ) {
		$this->check_casting( $object );
		if ( array_key_exists( 'range', $object->weapon ) ) {
			$this->search_gear_for_ammo( $object );
		}
	}

	protected function integrate_gear() {
		foreach( $this->gear as $key => $item ) {
			if ( empty( $item->owner ) ) continue;
			if ( $this->owner === 'delete_me' ) {
				unset( $this->gear[ $key ] );
				continue;
			}
#echo "{$item->owner}\n";
			$owner = $this->get_object( $item->owner, false, true );
			if ( $owner === false ) continue;
			if ( $item->active ) $item->activate_filters();
		}
	}

	protected function update_holds() {
		foreach( $this->holding as $name ) {
			$object = $this->get_object( $name );
			if ( $object->segment > $this->segment ) continue;
			$object->set_attack_segment( $this->segment );
		}
#		$this->holding = array_unique( $this->holding );
	}

	public function new_segment_housekeeping( $unused = null ) {
		do_action( 'dnd1e_new_segment', $this->segment );
		$this->action = array();
		$this->range  = 2000;
		foreach( $this->enemy as $key => $object ) {
			$object->check_for_weapon_change( $this->segment );
			do_action( 'dnd1e_new_seg_enemy', $this, $object );
		}
		add_filter( 'dnd1e_check_weapon_sequence', function( $arg ) { return true; } );
	}

	protected function reset_combat() {
		$this->casting = array();
		$this->effects = array();
		foreach( $this->gear as $key => $gear ) {
			if ( array_key_exists( $gear->owner, $this->party ) ) continue;
			$gear->turn_off();
			unset( $this->gear[ $key ] );
		}
		$this->enemy   = array();
		$this->holding = array();
		foreach( $this->party as $char ) {
#echo "crc: $char\n";
			$char->set_attack_segment( 1 );
#echo "crc: $char: {$char->segment}\n";
		}
		$this->rounds  = 3;
		$this->segment = 1;
	}


	/**  Ranking functions  **/

	protected function get_ranked_attackers() {
		$party = $this->get_party_attackers();
		$enemy = $this->get_enemy_attackers();
		$rank  = array_merge( $party, $enemy );
		$this->rank_attackers( $rank );
		return $rank;
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
			if ( $object->get_hit_points() < 1 ) continue;
			if ( $this->filter_attacker( $object ) ) {
				$enemy[] = new DND_Monster_Ranking( $object );
			}
		}
		return $enemy;
	}

	protected function filter_attacker( $object ) {
#print_r( $object );
		if ( in_array( $object->get_key(), $this->action ) ) return false;
		$sequence = $object->get_attack_sequence( $this->rounds, $object->weapon );
		if ( in_array( $this->segment, $sequence ) ) return true;
		return $this->is_casting( $object->get_key() );
	}

	protected function rank_attackers( &$rank ) {
		usort( $rank, function( $a, $b ) {
			$aname = $a->get_key();
			$bname = $b->get_key();
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
			if ( ! ( $a->initiative['actual'] === $b->initiative['actual'] ) ) {
				return ( $b->initiative['actual'] - $a->initiative['actual'] );
			}
			if ( array_key_exists( 'speed', $a->weapon ) && array_key_exists( 'speed', $b->weapon ) ) {
				if ( ! ( $a->weapon['speed'] === $b->weapon['speed'] ) ) {
					return ( $b->weapon['speed'] - $a->weapon['speed'] );
				}
			}
			if ( ! ( $a->stats['dex'] === $b->stats['dex'] ) ) {
				return ( $b->stats['dex'] - $a->stats['dex'] );
			}
			return $b->segment - $a->segment;
		} );
	}


	/**  Utility functions  **/

	protected function add_holding( $target, $new = 0 ) {
		if ( $object = $this->get_object( $target ) ) {
			$key = $object->get_key();
			if ( ! in_array( $key, $this->holding ) ) $this->holding[] = $key;
			$new = max( $new, $this->segment );
			if ( $new > $object->segment ) $object->set_attack_segment( $new );
		}
	}

	protected function critical_hit_result( $roll, $type ) {
		$dr = new DND_DieRolls;
		return $dr->get_crit_result( $roll, $type );
	}

	protected function fumble_roll_result( $roll ) {
		$dr = new DND_DieRolls;
		$this->messages[] = $dr->get_fumble_result( $roll );
	}

	protected function generate_z( $x, $y ) {
		return intval( round( sqrt( $x**2 + $y**2 ) ) );
	}

	public function get_key() {
		return $this->__toString();
	}

	protected function get_object( $name, $strict = false, $suppress = false ) {
		if ( is_null( $name ) ) return false;
		if ( is_object( $name ) ) return $name;
		if ( array_key_exists( $name, $this->party ) ) {
			return $this->party[ $name ];
		} else if ( array_key_exists( $name, $this->enemy ) ) {
			return $this->enemy[ $name ];
		} else if ( ! is_numeric( $name ) ) {
			if ( ! $strict ) {
				$keys = array_keys( $this->party );
				$len  = strlen( $name );
				if ( $len > 0 ) {
					$poss = array_filter(
						$this->party,
						function( $k ) use ( $name, $len ) {
							if ( substr( $k, 0, $len ) === $name ) {
								return true;
							}
							return false;
						},
						ARRAY_FILTER_USE_KEY
					);
					if ( count( $poss ) === 1 ) {
						return array_shift( $poss );
					}
				}
			} else {
				$poss = $this->get_object( $name );
				if ( is_object( $poss ) ) {
					return $poss;
				}
			}
		} else {
			return $this->get_specific_enemy( intval( $name ) );
		}
		if ( ! $suppress ) {
			$this->messages[] = "'$name' not found.";
		}
		return false;
	}

	protected function remove_holding( $name ) {
		$this->holding = array_diff( $this->holding, [ $name ] );
	}

	protected function reset_hit_points() {
		foreach( $this->party as $char ) {
			$char->reset_hit_points();
		}
	}

	protected function reset_manna_points() {
		foreach( $this->party as $char ) {
			if ( method_exists( $char, 'reset_manna_points' ) ) {
				$char->reset_manna_points();
			}
		}
	}

	protected function set_initiative( $name, $roll ) {
		$object = $this->get_object( $name );
		if ( $object ) $object->set_initiative( $roll );
	}

	protected function set_segment( $name, $segment ) {
		$object = $this->get_object( $name );
		if ( $object ) $object->set_attack_segment( $segment );
	}

	protected function store_data( $name, $label ) {
		if ( in_array( $name, [ 'enemy', 'gear', 'party' ] ) ) {
			$trans = $name;
			$data  = array();
			switch( $name ) {
				case 'gear':
					if ( array_key_exists( $label, $this->party ) ) {
						$data  = $this->get_owner_gear( $label );
						$trans = implode( '_', [ $name, $label ] );
					}
					break;
				case 'enemy':
					$data = array(
						'enemy' => $this->enemy,
						'gear'  => array_filter(
							$this->gear,
							function( $a ) {
								if ( array_key_exists( $a->owner, $this->enemy ) ) return true;
								return false;
							}
						),
					);
					$trans = ( $label === 'common' ) ? $name : "{$name}_{$label}";
					break;
				case 'party':
					if ( array_key_exists( $label, $this->party ) ) {
						$data = array(
							'party' => $this->party[ $label ],
							'gear'  => $this->get_owner_gear( $label ),
						);
						$trans = implode( '_', [ $name, $label ] );
					}
					break;
				default:
			}
			if ( empty( $data ) ) {
				$data  = $this->$name;
			}
			dnd1e()->transient( $trans, $data );
		}
	}

	protected function retrieve_data( $name, $label ){
		$trans = ( $label === 'common' ) ? $name : implode( '_', [ $name, $label ] );
		$data  = dnd1e()->transient( $trans );
		if ( $data ) {
			switch( $name ) {
				case 'party':
					foreach( $data['party'] as $char ) {
						$key = $char->get_key();
						if ( $this->add_to_party( $char ) ) $refer[ $key ] = $key;
					}
					$this->retrieved_gear( $data['gear'], $refer );
					$count = count( $data['party'] );
					$this->messages[] = "Import for $label $name: $count";
					break;
				case 'enemy':
					if ( array_key_exists( 'enemy', $data ) ) {
						$refer = array();
						foreach( $data['enemy'] as $enemy ) {
							$old = $enemy->get_key();
							$this->add_to_enemy( $enemy );
							$refer[ $old ] = $enemy->get_key();
						}
						$count = count( $data['enemy'] );
						$this->retrieved_gear( $data['gear'], $refer );
					} else {
						foreach( $data as $enemy ) $this->add_to_enemy( $enemy );
						$count = count( $data );
					}
					$this->messages[] = "Import for $label $name: $count";
					break;
				case 'gear' :
					$this->import_gear( $data );
					break;
				default:
					$this->messages[] = "Invalid '$name' value.  Data was retrieved but discarded.";
			}
		} else {
			$this->messages[] = "No data returned for $label $name.";
		}
	}


	/**  Monster  **/

	public function initialize_enemy( DND_Monster_Monster $monster, $limit = 0 ) {
		$base = get_class( $monster );
		$this->add_to_enemy( $monster );
		$number = $monster->get_number_appearing();
		if ( is_array( $number ) ) {
			foreach( $number as $enemy ) {
				if ( is_object( $enemy ) ) {
					$this->add_to_enemy( $enemy );
				} else if ( is_array( $enemy ) ) {
					$this->add_to_enemy( new $base( $enemy ) );
				} else if ( is_numeric( $enemy ) ) {
					$this->add_enemy_number( $base, $enemy, $limit );
				}
			}
		} else {
			$this->add_enemy_number( $base, $number, $limit );
		}
		$adds = apply_filters( 'dnd1e_additional_appearing', array() );
		if ( ! empty( $adds ) ) {
			foreach( $adds as $object ) {
				$this->add_to_enemy( $object );
			}
		}
	}

	protected function add_enemy_number( $base, $number, $limit = 0 ) {
		if ( $number > 1 ) {
			$cnt  = count( $this->enemy );
			$loop = ( $limit === 0 ) ? $number : $limit;
			for( $i = 1; $i < $loop; $i++ ) {
				$this->add_to_enemy( new $base );
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
		if ( empty( $this->base ) ) return $this->get_object(0);
		return $this->get_object( $this->base );
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
		$cnt  = $this->get_surviving_enemy( true );
		return intval( round( $cnt / $base * 100 ) );
	}

	protected function get_surviving_enemy( $morale = false ) {
		$num = 0;
		foreach( $this->enemy as $key => $obj ) {
			if ( $obj->get_hit_points() > 0 ) {
				$num++;
				continue;
			}
			if ( ! $obj->morale ) {
				$num++;
				continue;
			}
		}
		return $num;
	}


	/**  Party  **/

	public function add_to_party( $obj, $data = array() ) {
		if ( is_object( $obj ) ) {
			$key = $obj->get_key();
			$save = $this->pre_existing_character_check( $key, $data );
			$this->party[ $key ] = $obj;
			if ( $save ) $this->pre_existing_character_update( $key, $save );
			return true;
		} else if ( is_string( $obj ) && defined( 'CSV_PATH' ) ) {
			$file = CSV_PATH . $obj . '.csv';
												if ( $this->dcc_debug['atp'] ) { echo "file1: $file\n"; }
			if ( is_readable( $file ) ) {
												if ( $this->dcc_debug['atp'] ) { echo "file2: $file\n"; }
				$save = $this->pre_existing_character_check( $obj, $data );
				$temp = new DND_Character_Import_Kregen( $file, $data );
												if ( $this->dcc_debug['atp'] ) { echo "hp1: {$temp->character->hit_points}\n"; }
				$name = $temp->character->get_key();
				$this->party[ $name ] = $temp->character;
												if ( $this->dcc_debug['atp'] ) { echo "hp2: {$this->party[$name]->hit_points}\n"; }
				if ( $save ) $this->pre_existing_character_update( $name, $save );
												if ( $this->dcc_debug['atp'] ) { echo "hp3: {$this->party[$name]->hit_points}\n"; }
				return true;
			} else {
				$this->messages[] = sprintf( 'file %s not found or not readable.', $file );
			}
		}
		return false;
	}

	protected function pre_existing_character_check( $name, $data ) {
		$data = array();
		if ( array_key_exists( $name, $this->party ) ) {
			$char = $this->party[ $name ];
			if ( ! $char ) { $this->messages[] = "$name is a null object"; return null; }
			$data['hp_diff']    = $char->hit_points - $char->current_hp;
			$data['initiative'] = $char->initiative['roll'];
			$data['segment']    = $char->segment;
			$data['weapon']     = $char->weapon['current'];
		}
		return $data;
	}

	protected function pre_existing_character_update( $name, $data ) {
		$char = $this->party[ $name ];
		$char->current_hp = $char->hit_points - $data['hp_diff'];
		$char->set_attack_segment( $data['segment'] );
		$char->set_initiative( $data['initiative'] );
		$this->change_weapon( $char, $data['weapon'] );
	}

	protected function remove_from_party( $name ) {
		if ( array_key_exists( $name, $this->party ) ) {
			$char = $this->get_object( $name, true );
			$this->deactivate_gear( $name );
			unset( $this->party[ $name ] );
			return true;
		}
		return false;
	}

	protected function temporary_hit_points( $damage, $object, $type ) {
		$damage = intval( $damage );
		if ( $damage > 0 ) {
			$names = array(
				'dnd1e_absorption_hp',    // D:  Protection from Fire
				'dissipation_hit_points', // MU: Armor
				'dnd1e_temporary_hp',     // I:  Phantom Armor
			);
			foreach( $this->effects as $key => $effect ) {
				if ( ! $effect->condition_applies( $object ) ) continue;
				foreach( $effect->get_filters() as $index => $filter ) {
					if ( $filter[0] === 'dissipation_hit_points' ) {
						if ( $effect->set_filter_delta( $index, $damage ) < 1 ) {
							$this->remove_effect( $key );
							break;
						}
					} else if ( ( $filter[0] === 'dnd1e_absorption_hp' ) && ( ! ( $type === $effect->effect ) ) ) {
					} else if ( in_array( $filter[0], $names ) ) {
						$remaining = $effect->set_filter_delta( $index, $damage );
						if ( $remaining > 0 ) {
							$damage = 0;
						} else {
							$damage = abs( $remaining );
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

	public function change_weapon( $object, $weapon, $normal = false ) {
		if ( $this->check_for_cursed_gear( $object, 'weapon' ) ) return;
		$sequence = $object->get_attack_sequence( $this->rounds, $object->weapon );
		$key = ( array_key_exists( 'key', $object->weapon ) ) ? $object->weapon['key'] : false;
		if ( is_string( $weapon ) && ( $normal === false ) ) $weapon = $this->search_gear( $object->get_key(), $weapon );
		if ( $object->set_current_weapon( $weapon ) ) {
			$this->set_object_attack_segment( $object, $sequence );
			if ( $key ) $this->deactivate_weapon( $key, $object );
			if ( $object->weap_dual ) $this->check_for_secondary_gear( $object );
			if ( $object->weapon['skill'] === 'NP' ) $this->messages[] = $object->get_key() . " is not proficient in the use of '{$object->weapon['current']}'";
			$this->remove_holding( $object->get_key() );
		}
		$this->search_gear_for_ammo( $object );
		$object->determine_armor_class();
	}

	protected function set_object_attack_segment( $object, $sequence ) {
		$next = false;
		if ( $this->segment === 1 ) {
		} else if ( in_array( $this->segment, $sequence ) ) {
			$next = $this->segment;
		} else {
			foreach( $sequence as $seggie ) {
				if ( $seggie > $this->segment ) {
					$next = $seggie;
					break;
				}
			}
		}
		if ( $next ) $object->set_attack_segment( $next );
	}

	public function get_to_hit_number( $name1, $name2 ) {
		$origin = $this->get_object( $name1, true );
		if ( ( ! $origin ) || $origin->is_stunned() ) return 100;
		$target = $this->get_object( $name2, true );
		if ( ! $target ) return 100;
		$to_hit = $origin->get_to_hit_number( $target, $this->range );
		$to_hit-= ( $target->is_down() ) ? 4 : 0;
#		$to_hit+= $this->opp_attack_adj( $origin );
		if ( $this->dcc_debug['gthn'] ) {
			$prefil = $to_hit;
			$to_hit = apply_filters( 'dnd1e_to_hit_object', $to_hit, $origin, $target );
			$this->messages[] = sprintf( '%s : %d : %d', $origin->get_key(), $prefil, $to_hit );
			return $to_hit;
		}
		return apply_filters( 'dnd1e_to_hit_object', $to_hit, $origin, $target );
	}

	public function missed_attack( $name ) {
		$origin = $this->get_object( $name );
		if ( $origin ) {
			$this->action_taken( $origin );
		}
	}

	public function resolve_damage( $params = array() ) {
		$origin = null;
		$target = null;
		$damage = 0;
		$type   = 'attack';
		extract( $params, EXTR_IF_EXISTS );
		$origin   = $this->get_object( $origin, true );
		$target   = $this->get_object( $target, true );
		$dam_type = $type;
		if ( $target ) {
			if ( $origin ) {
				if ( in_array( $origin->get_key(), $this->action ) ) {
					$this->messages[] = $origin->get_key() . ' has already attacked this segment.';
					return;
				}
				if ( $origin->get_hit_points() < 1 ) {
					$this->messages[] = $origin->get_key() . ' is dead or incapacitated.  No attacks possible.';
					return;
				}
				$damage += $origin->get_weapon_damage_bonus( $target, $this->range );
				if ( empty( $type ) && array_key_exists( 'effect', $origin->weapon ) && ( ! empty($origin->weapon['effect'] ) ) ) $type = $origin->weapon['effect'];
				$damage = apply_filters( 'dnd1e_origin_damage', $damage, $origin, $target, $type );
				if ( $damage < 0 ) return;
				if ( $origin->segment > $this->segment ) $object->segment = $this->segment;
				$this->action_taken( $origin );
				$this->remove_holding( $origin->get_key() );
			} else if ( array_key_exists( 'origin', $params ) ) {
				$this->messages[] = sprintf( 'Invalid origin %s', $params['origin'] );
				return;
			}
			$damage = intval( apply_filters( 'dnd1e_damage_to_target', $damage, $target, $type ) );
			if ( $damage < 0 ) return;
			if ( $damage ) {
				if ( $target instanceOf DND_Character_Character ) {
					$damage = $this->temporary_hit_points( $damage, $target, $type );
				}
				$target->assign_damage( $damage, $this->segment, $type );
				$this->abort_casting( $target );
				$dam_type = $this->message_damage_type( $origin, $target, $type );
				$string   = ( $dam_type === 'none' ) ? '%s took %u %s of damage' : '%s took %u %s of %s damage';
				$points   = ( $damage === 1 ) ? 'point' : 'points';
				$this->messages[] = sprintf( $string, $target->get_key(), $damage, $points, $dam_type );
				if ( ( $target->get_hit_points() < 1 ) && ( array_key_exists( $target->get_key(), $this->enemy ) ) ) {
					$this->messages[] = sprintf( '%s is dead!', $target->get_key() );
					if ( $target->morale ) $this->messages[] = 'Enemy Morale check!';
				} else {
					if ( $origin && ( $origin instanceOf DND_Monster_Monster ) ) {
						$string = $origin->monster_damage_string( $target );
						if ( $string ) $this->messages[] = $string;
					}
				}
			}
			do_action( 'dnd1e_attack_made', $target, $this->segment );
		} else {
			$this->messages[] = sprintf( 'Invalid target %s', $params['target'] );
		}
	}

	protected function message_damage_type( $origin, $target, $type = 'attack' ) {
		if ( $origin ) {
			if ( empty( $target->vulnerable ) || ! in_array( $type, $target->vulnerable ) ) {
				$type = $origin->get_weapon_effect( $origin->weapon['current'] );
			}
		}
		return $type;
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
			} else { $this->show_error( "Function '$func' not found!" ); }
		}
	}

	protected function opp_attack_adj( $origin ) {
		if ( $origin->segment < $this->segment ) {
			if ( $this->dcc_debug['oaa'] ) $this->messages[] = sprintf( '%s : %d : %d', $origin->name, $origin->segment, $origin->initiative['segment'] );
			$origin->set_next_attack_segment( $this->segment );
		}
		$adj = $origin->segment - $this->segment;
		if ( $this->dcc_debug['oaa'] ) $this->messages[] = sprintf( '%s : %d : %d : %d', $origin->name, $origin->segment, $origin->initiative['segment'], $adj );
		return max( $adj, 0 );
	}

	protected function action_taken( $origin ) {
		if ( $origin ) {
			$key = $origin->get_key();
			if ( ! in_array( $key, $this->action ) ) {
				$this->action[] = $key;
			}
			$this->remove_holding( $key );
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
			'action'  => $this->action,
			'casting' => $this->casting,
			'effects' => $this->effects,
			'enemy'   => $this->enemy,
			'gear'    => $this->gear,
			'holding' => $this->holding,
			'party'   => $this->party,
			'range'   => $this->range,
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

<?php

abstract class DND_Combat_Combat implements JsonSerializable, Serializable {


	protected $casting = array();
	public    $effects = array();
	protected $enemy   = array();
	protected $holding = array();
	protected $party   = array();
	public    $range   = 2000;
	protected $rounds  = 3;
	protected $segment = 1;


	use DND_Trait_Movement;
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
	}

	public function __toString() {
		return 'Combat base class';
	}


	/**  Startup functions  **/

	protected function integrate_effects() {
		foreach( $this->effects as $key => $spell ) {
			if ( array_key_exists( 'ends', $spell ) && ( $this->segment > $spell['ends'] ) ) {
				$this->remove_effect( $key );
				continue;
			}
			$filters = $spell['filters'];
			// TODO: take aoe into account
			foreach( $filters as $filter ) {
				add_filter( $filter[0], function( $value, $b = null, $c = null, $d = null ) use ( $filter, $spell ) {
					if ( array_key_exists( 'condition', $spell ) ) {
						$condition = $spell['condition'];
						foreach( [ $b, $c, $d ] as $obj ) {
							if ( ( gettype( $obj ) === 'object' ) && method_exists( $obj, $condition ) ) {
								if ( $obj->$condition( $filter[0], $spell, $obj ) ) {
									$replace = apply_filters( 'dnd1e_replacement_filters', array() );
									if ( in_array( $filter[0], $replace ) ) {
										return $filter[1];
									}
								} else {
									return $value;
								}
							}
						}
					}
					return $value + $filter[1];
				}, $filter[2], $filter[3] );
			}
		}
	}

	protected function integrate_party() {
		foreach( $this->party as $name => $char ) {
			if ( is_array( $char ) ) {
				$create = $char['what_am_i'];
				$this->party[ $name ] = new $create( $char );
			}
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
		}
	}

	protected function update_holds() {
		foreach( $this->holding as $name ) {
			$object  = $this->get_object( $name );
			$segment = max( $this->segment, $object->segment );
			$object->set_attack_segment( $segment );
		}
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


	/**  Utility functions  **/

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
			if ( $seq = $this->filter_attacker( $object ) ) {
				$type = ( is_array( $seq ) ) ? $object->get_attack_type( $seq, $this->segment ) : 'casting';
				$object->set_sequence_weapon( $type );
				$enemy[] = new DND_Monster_Ranking( $object, $type );
			}
		}
		return $enemy;
	}

	protected function filter_attacker( $object ) {
		$sequence = $this->get_attack_sequence( $object->segment, $object->weapon['attacks'] );
		$key = $object->get_key();
		if ( in_array( $this->segment, $sequence ) ) {
			return $sequence;
		} else if ( $this->is_casting( $key ) ) {
			$spell = $this->find_casting( $key );
			if ( $this->segment > $spell['when'] ) {
				$this->remove_casting( $key );
			} else {
				return true;
			}
		} else if ( $object instanceOf DND_Monster_Monster ) {
			$object->set_next_attack( $sequence, $this->segment );
		}
		return false;
	}

	protected function rank_attackers( &$rank ) {
		usort( $rank, function( $a, $b ) {
			$aname = $a->get_name();
			$bname = $b->get_name();
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
				} else if ( $aspell && ( ! ( $aspell['when'] === $this->segment ) ) ) {
					return -1;
				} else if ( $bspell && ( ! ( $bspell['when'] === $this->segment ) ) ) {
					return 1;
				}
			}
			if ( $a->stats['dex'] === $b->stats['dex'] ) {
				if ( $a->initiative['actual'] === $b->initiative['actual'] ) {
					return 0;
				} else if ( $a->initiative['actual'] > $b->initiative['actual'] ) {
					return -1;
				} else {
					return 1;
				}
			} else if ( $a->stats['dex'] > $b->stats['dex'] ) {
				return -1;
			} else {
				return 1;
			}
		} );
	}

	protected function critical_hit_result( $param, $type = 's' ) {
		$args = explode( ':', $param );
		$poss = ( count( $args ) > 1 ) ? $args[1] : $type;
		$dr   = new DND_DieRolls;
		$crit = $dr->get_crit_result( $args[0], $poss );
		return $crit;
	}

	protected function fumble_roll_result( $roll ) {
		$dr  = new DND_DieRolls;
		$fum = $dr->get_fumble_result( $roll );
		return $fum;
	}

	protected function get_object( $name, $strict = false ) {
		$obj = null;
		if ( array_key_exists( $name, $this->party ) ) {
			$obj = $this->party[ $name ];
		} else if ( array_key_exists( $name, $this->enemy ) ) {
			$obj = $this->enemy[ $name ];
		} else if ( $strict && ( ! is_numeric( $name ) ) ) {
		} else {
			$num = intval( $name, 10 );
			$obj = $this->get_specific_enemy( $num );
		}
		return $obj;
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
	}

	public function add_to_enemy( DND_Monster_Monster $obj ) {
		$cnt = count( $this->enemy );
		$key = $obj->get_name() . " $cnt";
		while( array_key_exists( $key, $this->enemy ) ) {
			$cnt++;
			$key = $obj->get_name() . " $cnt";
		}
		$obj->set_key( $key );
		$obj->set_initiative( mt_rand( 1, 10 ) );
		$this->enemy[ $key ] = $obj;
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

	protected function get_monster_attacks( DND_Monster_Monster $monster ) {
		$index  = 0;
		$seqent = array();
		$count  = count( $monster->attacks );
		$other  = $monster->single_attacks( [ 'Spell', 'Special' ] );
		foreach( $other as $attack ) {
			$count -= ( array_key_exists( $attack,  $monster->attacks ) ) ? 1 : 0;
		}
		$multi = $this->get_attack_sequence( $monster->initiative, [ $count, 1 ] );
		foreach( $monster->att_types as $type => $attack ) {
			if ( in_array( $type, $other ) ) {
				$seqent[ $type ] = $this->get_attack_sequence( $monster->initiative, [ 1, 1 ] );
			} else {
				$seqent[ $type ] = $this->get_attack_sequence( $multi[ $index++ ], [ 1, 1 ] );
			}
		}
		return $seqent;
	}

	/**  Spells  **/

	protected function pre_cast_spell( $origin, $spell, $target = '' ) {
		$result = false;
		if ( $this->segment < 2 ) {
			$result = $this->start_casting( $origin, $spell, $target );
			if ( $result ) $this->finish_casting( $spell );
		}
		return $result;
	} //*/

	protected function is_casting( $caster ) {
		if ( empty( $this->casting ) ) return false;
		return in_array( $caster, array_column( $this->casting, 'caster' ) );
	}

	protected function find_casting( $caster ) {
		$spell = array_filter( $this->casting, function( $a ) use ( $caster ) {
			if ( ! is_array( $a ) ) return false;
			if ( $a['caster'] === $caster ) return true;
			return false;
		} );
		if ( $spell ) {
			return array_shift($spell);
		}
		return false;
	}

	protected function remove_casting( $caster ) {
		$this->casting = array_filter( $this->casting, function( $a ) use ( $caster ) {
			if ( ! is_array( $a ) ) return true;
			if ( $a['caster'] === $caster ) return false;
			return true;
		} );
	}

	protected function start_casting( $origin, $spell, $target = '' ) {
		$result = false;
		if ( $spell && $this->get_object( $origin ) ) {
			$this->remove_holding( $origin );
			$length = ( strpos( $spell['cast'], 'segment' ) ) ? intval( $spell['cast'], 10 ) : intval( $spell['cast'], 10 ) * 10;
			$spell['target'] = ( $target ) ? $target : $origin;
			$spell['caster'] = $origin;
			$spell['when']   = $this->segment + $length;
#print_r($spell);
			$this->casting[] = $spell;
			$result = true;
		}
		return $result;
	}

	protected function finish_casting( $spell ) {
		if ( array_key_exists( 'filters', $spell ) ) {
			$spell['segment'] = $this->segment;
			if ( array_key_exists( 'duration', $spell ) ) {
				$length = ( strpos( $spell['duration'], 'segment' ) ) ? intval( $spell['duration'] ) : intval( $spell['duration'] ) * 10;
				$length = ( strpos( $spell['duration'], 'turn'    ) ) ? intval( $spell['duration'] ) * 100  : $length;
				$length = ( strpos( $spell['duration'], 'hour'    ) ) ? intval( $spell['duration'] ) * 1000 : $length;
				$spell['ends'] = $this->segment + $length;
			}
			$key = $spell['name'] . $spell['caster'] . $spell['target'];
			$this->effects[ $key ] = $spell;
		}
	}

	protected function remove_effect( $key ) {
		if ( $key && array_key_exists( $key, $this->effects ) ) {
			unset( $this->effects[ $key ] );
		}
	}

	/**  Party  **/

	public function add_to_party( $obj, $data = array() ) {
		if ( is_object( $obj ) ) {
			$key = $obj->get_name();
			$this->party[ $key ] = $obj;
			return true;
		} else if ( is_string( $obj ) && defined( 'CSV_PATH' ) ) {
			$file = CSV_PATH . $obj . '.csv';
			if ( is_readable( $file ) ) {
				$save = $this->pre_existing_character_check( $obj, $data );
				$temp = new DND_Character_Import_Kregen( $file, $data );
				$name = $temp->character->get_name();
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

	protected function add_holding( $hold ) {
		$data = explode( ':', $hold );
		$key  = $data[0];
		if ( $object = $this->get_object( $key ) ) {
			$this->holding[] = $key;
			if ( array_key_exists( 1, $data ) ) {
				$segment = intval( $data[1], 10 );
				$segment = max ( $segment, $this->segment );
				$object->set_attack_segment( $segment );
			} else {
				$object->set_attack_segment( $this->segment );
			}
		}
	}

	protected function remove_holding( $key ) {
		if ( in_array( $key, $this->holding ) ) {
			$this->holding = array_diff( $this->holding, [ $key ] );
			$object = $this->get_object( $key );
			$object->set_attack_segment( $this->segment );
		}
	}

	protected function change_weapon( $object, $weapon ) {
		$sequence = $this->get_attack_sequence( $object->segment, $object->weapon['attacks'] );
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

	protected function get_attack_sequence( $segment, $attacks = array( 1, 1 ) ) {
		$segment  = intval( $segment, 10 );
		$seqent   = array();
		$interval = 10 / ( $attacks[0] / $attacks[1] );
		do {
			$seqent[] = round( $segment );
			$segment += $interval;
		} while( $segment < ( ( $this->rounds * 10 ) + 1 ) );
		return $seqent;
	}

	public function get_to_hit_number( $name1, $name2, $weapon = '' ) {
		$origin = $this->get_object( $name1, true );
		$target = $this->get_object( $name2, true );
		if ( ! ( $origin && $target ) ) return 100;
		return $this->get_combat_to_hit_number( $origin, $target, $weapon );
	}

	public function get_combat_to_hit_number( $origin, $target, $weapon = '' ) {
		return $origin->get_to_hit_number( $target, $this->range, $weapon );
	}

	protected function object_damage( $name, $damage ) {
		$obj = $this->get_object( $name );
		if ( $obj ) {
			$damage = intval( $damage );
			if ( $damage ) {
				if ( $obj instanceOf DND_Character_Character ) {
					$damage = $obj->check_temporary_hit_points( $damage );
				}
				$obj->current_hp -= $damage;
			}
		}
	}

	/**  JsonSerializable and Serializable functions  **/

	public function JsonSerialize() {
		$table = $this->get_serialization_data();
		$table['what_am_i'] = get_class( $this );
		return $table;
	}

	public function serialize() {
		return serialize( $this->get_serialization_data() );
	}

	private function get_serialization_data() {
		$table = array(
			'casting' => $this->casting,
			'effects' => $this->effects,
			'enemy'   => $this->enemy,
			'holding' => $this->holding,
			'party'   => $this->party,
			'segment' => $this->segment,
		);
		return $table;
	}

	public function unserialize( $data ) {
		$args = unserialize( $data );
		$this->__construct( $args );
	}


}

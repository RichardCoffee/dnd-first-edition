<?php

class DND_Combat implements JsonSerializable, Serializable {


	protected $casting = array();
	protected $effects = array();
	protected $enemy   = array();
	protected $holding = array();
	protected $party   = array();
	public    $range   = 2000;
	protected $rounds  = 3;
	protected $segment = 1;


	use DND_Trait_Magic;
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


	/**  Startup functions  **/

	protected function integrate_effects() {
		foreach( $this->effects as $name => $spell ) {
			if ( array_key_exists( 'ends', $spell ) && ( $this->segment > $spell['ends'] ) ) {
				$this->remove_effect( $name );
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
				} else { print_r( $monster ); }
			}
		}
	}

	protected function update_holds() {
		foreach( $this->holding as $name ) {
 			$segment = max( $this->segment, $this->party[ $name ]->segment );
			$this->party[ $name ]->set_attack_segment( $segment );
		}
	}


	/**  Utility functions  **/

	public function increment_segment() {
/*		if ( $this->party ) {
			foreach( $this->party as $name => $obj ) {
				$sequence = $this->get_attack_sequence( $obj->segment, $obj->weapon['attacks'] );
				foreach( $sequence as $seggie ) {
					if ( $seggie === $this->segment ) {
						if ( ( ( $seggie - $obj->segment ) % 10 ) === 0 ) {
							$obj->set_attack_segment( $seggie );
							break;
						}
					}
				}
			}
		} //*/
#		$this->segment++;
		$this->update_holds();
	}

	protected function get_party_attackers() {
		$party = array();
		foreach( $this->party as $name => $char ) {
			$sequence = $this->get_attack_sequence( $char->segment, $char->weapon['attacks'] );
			if ( in_array( $this->segment, $sequence ) ) {
				$party[] = $char;
			} else if ( $this->casting && $this->is_casting( $name ) ) {
				$spell = $this->find_casting( $name );
				if ( $this->segment > $spell['when'] ) {
					$this->remove_casting( $name );
				} else {
					$party[] = $char;
				}
			}
		}
		return $party;
	}

	protected function get_enemy_attackers() {
		$enemy   = array();
		$monster = $this->get_base_monster();
		if ( $monster ) {
			$sequent = $this->get_monster_attacks( $monster );
			if ( $monster instanceOf DND_Monster_Humanoid_Humaniod ) {
/*foreach( $monster->attacks as $type => $damage ) {
if ( in_array( $segment, $att_seq[ $type ] ) ) {
$enemy[] = new DND_Monster_Ranking( $monster, $type );
}
} //*/
			} else {
				foreach( $sequent as $type => $attack ) {
					if ( in_array( $this->segment, $attack ) ) {
						$enemy[] = new DND_Monster_Ranking( $monster, $type );
					}
				}
			}
		}
		return $enemy;
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

	protected function critical_hit_result( $param ) {
		$args = explode( ':', $param );
		$poss = ( count( $args ) > 1 ) ? $args[1] : 's';
		$dr   = new DND_DieRolls;
		$crit = $dr->get_crit_result( $args[0], $poss );
		return $crit;
	}

	protected function fumble_roll_result( $roll ) {
		$dr  = new DND_DieRolls;
		$fum = $dr->get_fumble_result( $roll );
		return $fum;
	}

	/**  Monster  **/

	public function add_to_enemy( DND_Monster_Monster $obj ) {
		$count = count( $this->enemy );
		$name  = $obj->get_name() . " $count";
		$this->enemy[ $name ] = $obj;
	}

	public function remove_from_enemy( $name ) {
		if ( array_key_exists( $name, $this->enemy ) ) {
			unset( $this->enemy[ $name ] );
			return true;
		}
		return false;
	}

	protected function get_monster_key( $number ) {
		$number = intval( $number, 10 );
		if ( $number ) {
			$cnt = 1;
			foreach( $this->monster as $key => $monster ) {
				if ( $cnt === $number ) {
					return $key;
				}
				$cnt++;
			}
		}
		return "Enemy $number not found.";
	}

	protected function set_monster_initiative_all( $init ) {
		$init = intval( $init, 10 );
		foreach( $this->enemy as $name => $monster ) {
			$this->set_monster_initiative( $name, $init );
		}
	}

	protected function set_monster_initiative( $name, $init ) {
		$init = intval( $init, 10 );
		if ( array_key_exists( $name, $this->enemy ) ) {
			$this->enemy[ $name ]->set_initiative( $init );
			return true;
		}
		return false;
	}


	protected function get_base_monster() {
		$list = array_keys( $this->enemy );
		if ( $list ) {
			return $this->enemy[ $list[0] ];
		} else {
			return false;
		}
	}

	protected function get_monster_attacks( DND_Monster_Monster $monster ) {
		$index  = 0;
		$seqent = array();
		$count  = count( $monster->attacks );
		$other  = [ 'Breath', 'Spell', 'Special' ];
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
		return in_array( $caster, array_column( $this->casting, 'caster' ) );
	}

	protected function find_casting( $caster ) {
		$spell = array_filter( $this->casting, function( $a ) use ( $caster ) {
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
			if ( $a['caster'] === $caster ) return false;
			return true;
		} );
	}

	protected function start_casting( $origin, $spell, $target = '' ) {
		$result = false;
		if ( array_key_exists( $origin, $this->party ) ) {
			if ( array_key_exists( $origin, $this->party ) ) {
				if ( $spell ) {
					$length = ( strpos( $spell['cast'], 'segment' ) ) ? intval( $spell['cast'], 10 ) : intval( $spell['cast'], 10 ) * 10;
					$spell['target'] = ( $target ) ? $target : $origin;
					$spell['caster'] = $origin;
					$spell['when']   = $this->segment + $length;
print_r($spell);
					$this->casting[] = $spell;
					$this->remove_holding( $origin );
					$result = true;
				}
			}
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
			$this->add_effect( $spell );
		}
	}

	protected function add_effect( $spell ) {
		$this->effects[ $spell['name'] ] = $spell;
#print_r($this->effects);
	}

	protected function remove_effect( $effect ) {
		if ( $effect && array_key_exists( $effect, $this->effects ) ) {
			unset( $this->effects[ $effect ] );
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
		$name = $data[0];
		if ( array_key_exists( $name, $this->party ) ) {
			$this->holding[] = $name;
			if ( array_key_exists( 1, $data ) ) {
				$segment = intval( $data[1], 10 );
				$segment = max ( $segment, $this->segment );
				$this->party[ $name ]->set_attack_segment( $segment );
			} else {
				$this->party[ $name ]->set_attack_segment( $this->segment );
			}
		}
	}

	protected function remove_holding( $name ) {
		if ( in_array( $name, $this->holding ) ) {
			$this->holding = array_diff( $this->holding, [ $name ] );
			$this->party[ $name ]->set_attack_segment( $this->segment );
		}
	}

	protected function change_weapon( DND_Character_Character $char, $weapon ) {
		$rounds   = intval( $this->segment / 10 ) + 3;
		$sequence = $this->get_attack_sequence( $char->segment, $char->weapon['attacks'] );
		if ( $this->segment === 1 ) {
			$char->set_current_weapon( $weapon );
		} else if ( in_array( $this->segment, $sequence ) ) {
			if ( $char->set_current_weapon( $weapon ) ) {
				$char->set_attack_segment( $this->segment );
			}
		} else {
			foreach( $sequence as $seggie ) {
				if ( $seggie > $this->segment ) {
					if ( $char->set_current_weapon( $weapon ) ) {
						$char->set_attack_segment( $seggie );
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
		if ( array_key_exists( $name1, $this->party ) ) {
			$origin = $this->party[ $name1 ];
		} else if ( array_key_exists( $name1, $this->enemy ) ) {
			$origin = $this->enemy[ $name1 ];
		} else {
			return 100;
		}
		if ( array_key_exists( $name2, $this->party ) ) {
			$target = $this->party[ $name2 ];
		} else if ( array_key_exists( $name2, $this->enemy ) ) {
			$target = $this->enemy[ $name2 ];
		} else {
			return 100;
		}
		return $this->get_combat_to_hit_number( $origin, $target, $weapon );
	}

	public function get_combat_to_hit_number( $origin, $target, $weapon = '' ) {
		if ( $origin instanceOf DND_Character_Character ) {
			return $origin->get_to_hit_number( $target, $this->range );
		}
		if ( $origin instanceOf DND_Monster_Monster ) {
			if ( $weapon && array_key_exists( $weapon, $origin->att_types ) ) {
				if ( $target instanceOf DND_Character_Character ) {
					// TODO: allow for rear facing
					return $origin->get_to_hit_number( $target->armor['class'], $target->armor['type'], $origin->att_types[ $weapon ], $this->range );
				} else {
					return $origin->get_to_hit_number( $target->armor_class, $target->armor_type, $origin->att_types[ $weapon ], $this->range );
				}
			}
		}
		return 100;
	}

	protected function party_damage( $name, $damage ) {
		if ( array_key_exists( $name, $this->party ) ) {
			$damage = $this->party[ $name ]->check_temporary_hit_points( $damage );
			$this->party[ $name ]->current_hp -= $damage;
		}
	}

	protected function enemy_damage( $name, $damage ) {
		if ( array_key_exists( $name, $this->enemy ) ) {
			$this->enemy[ $name ]->current_hp -= $damage;
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

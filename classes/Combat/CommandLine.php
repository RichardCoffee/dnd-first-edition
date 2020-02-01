<?php

class DND_Combat_CommandLine extends DND_Combat_Combat {


#	protected $casting = array(); // DND_Combat_Combat
	protected $default = false;
#	public    $effects = array(); // DND_Combat_Combat
#	protected $enemy   = array(); // DND_Combat_Combat
#	protected $holding = array(); // DND_Combat_Combat
	protected $limit   = 1000;
	protected $minus   = 0;
#	protected $party   = array(); // DND_Combat_Combat
#	protected $range   = 2000;    // DND_Combat_Combat
	protected $rng_svd = 0;
#	protected $rounds  = 3;       // DND_Combat_Combat
#	protected $segment = 1;       // DND_Combat_Combat
	protected $show    = 0;
	protected $targets = array();


	use DND_Combat_GetOpts;
	use DND_Trait_Singleton;


	protected function __construct( array $args = array() ) {
		$this->get_opts();
		if ( array_key_exists( 's', $this->opts ) ) {
			if ( array_key_exists( 'segment', $args ) ) {
				$args['segment']++;
			}
			add_action( 'dnd1e_combat_init', [ $this, 'new_segment_housekeeping' ], 5 );
		}
		parent::__construct( $args );
#		$this->process_opts();
		$this->minus = ( ( ( $this->segment - 1 ) + floor( ( $this->segment - 1 ) / 10 ) ) * 2 );
		if ( $this->rng_svd > 0 ) $this->range = $this->rng_svd;
		if ( count( $this->enemy ) > 20 ) $this->default = true;
	}

	public function __toString() {
		return 'Commandline version';
	}


	/**  Setup functions  **/

	public function import_party( $list ) {
		foreach( $list as $name => $data ) {
			$file = CSV_PATH . $name . '.csv';
			if ( is_readable( $file ) ) {
				$info = ( array_key_exists( 'data', $data ) ) ? $data['data'] : array();
				$temp = new DND_Character_Import_Kregen( $file, $info );
				$data = serialize( $temp->character );
				$this->party[ $name ] = unserialize( $data );
			}
		}
	}

	public function reimport_character( $name ) {
		$file = CSV_PATH . $name . '.csv';
		if ( is_readable( $file ) ) {
			$temp = new DND_Character_Import_Kregen( $file );
			$this->party[ $name ] = $temp->character;
		}
	}

	public function generate_encounter( $string ) {
		$options = explode( ':', $string );
		$terrain = $options[0];
		$area    = ( array_key_exists( 1, $options ) ) ? $options[1] : false;
		if ( $terrain && $area ) {
			$enc  = new DND_Combat_Encounters;
			$roll = ( array_key_exists( 2, $options ) ) ? intval( $options[2] ) : 0;
			$crea = ( array_key_exists( 3, $options ) ) ? intval( $options[3] ) : 0;
			$listing = $enc->get_random_encounter( "$terrain:$area", $roll, $crea );
			if ( $crea ) {
				echo "\n\t{$listing['name']}";
				echo "\t{$listing['class']}\n\n";
			} else {
				print_r($listing);
				echo "Count: " . count( $listing ) . "\n";
			}
			if ( $crea ) {
				$new = $listing['class'];
				$this->reset_combat();
				$monster = new $new;
				$this->initialize_enemy( $monster );
				$this->new_segment_housekeeping();
				return;
			} else {
				exit;
			}
		}
		$this->show_help();
		exit;
	}

	protected function reset_combat() {
		parent::reset_combat();
		$this->limit   = 1000;
		$this->minus   = 0;
		$this->show    = 0;
		$this->targets = array();
	}


	/**  Set functions  **/

	protected function set_limit( $limit ) {
		$this->limit = $limit;
	}

	protected function set_targets( $targets ) {
		if ( count( $targets ) === 1 ) {
			$param = $targets[0];
			if ( $param === 'reset' ) {
				$this->targets = array();
			}
			if ( ! is_numeric( $param ) ) {
				foreach( $this->enemy as $key => $object ) {
					if ( $object->weapon['current'] === $param ) {
						$this->targets[] = $key;
					}
				}
			}
		}
		foreach( $targets as $target ) {
			$object = $this->get_object( $target );
			if ( $object && is_object( $object ) ) {
				$key = $object->get_key();
				if ( ! in_array( $key, $this->targets ) ) {
					$this->targets[] = $key;
				}
			}
		}
	}


	/**  Monsters  **/

	protected function show_enemy_text() {
		$object = $this->get_base_monster();
		$text = explode( "\n", $object->description );
		echo "\n";
		foreach( $text as $line ) {
			echo wordwrap( $line );
			echo "\n\n";
		}
		echo "\n";
	}

	public function show_enemy_information() {
		$this->show_enemy_description( $this->show );
		$this->show_enemy_heading();
		$this->show_enemy_attacks();
	}

	protected function show_enemy_description( $num ) {
		if ( empty( $this->enemy ) ) return;
		$enemy = $this->get_specific_enemy( $num );
		echo "\n";
		echo "Appearing: " . count( $this->enemy );
		echo "   Morale: " . $this->get_enemy_morale() . "%\n";
		echo $enemy->command_line_display();
		echo "\n";
	}

	protected function change_shown_enemy( $num ) {
		$num = intval( $num, 10 );
		$list = array_keys( $this->enemy );
		if ( array_key_exists( $num, $list ) ) {
			$this->show = $num;
		}
	}

	protected function show_enemy_heading() {
		$heading = '           ';
		$heading.= 'Name                ';
		$heading.= 'Weapon              ';
		$heading.= 'Dam   ';
		$heading.= 'Atts          ';
		$heading.= 'Movement           ';
		$heading.= 'Seg   Attack Sequence';
		echo "$heading\n";
	}

	protected function show_enemy_attacks() {
		$win   = true;
		$limit = 1;
		foreach( $this->enemy as $key => $object ) {
			if ( $this->skip_object( $object, $limit ) ) continue;
			$seq  = $this->get_attack_sequence( $object );
			$object->check_weapon_sequence( $seq, $this->segment );
			$str  = sprintf( '%s (%d/%d)', substr( $object->get_key(), -16 ), $object->current_hp, $object->hit_points );
			$line = ' '   . sprintf( '%26s', $str );
			$line.= '  '  . sprintf( '%-18s', $object->weapon['current'] );
			$line.= ''    . sprintf( '%7s', $this->format_damage_string( $object->weapon['damage'] ) );
			$line.= '   ' . sprintf( '%2u/%u', $object->weapon['attacks'][0], $object->weapon['attacks'][1] );
			$line.= '  '  . sprintf( '%2u"', $object->movement );
			$line.= ' '   . $this->get_mapped_movement_sequence( $object->movement );
			$line.= '  '  . sprintf( '%2d', $object->segment );
			$line.= '  '  . substr( $this->get_mapped_attack_sequence( $seq ), $this->minus );
			echo "$line\n";
			$win = false;
			$limit++;
		}
		if ( $win ) echo "                   YOU WIN!!\n";
		echo "\n";
	}

	protected function show_experience_value() {
		$xp_total = 0;
		foreach( $this->enemy as $key => $entity ) {
			if ( $entity->xp_value ) {
				$xp_total += $entity->xp_value;
			}
		}
		echo "\nXP Total: $xp_total\n\n";
	}

	protected function skip_object( $object, $limit ) {
			$key = $object->get_key();
			if ( $object->current_hp < 1 ) {
				if ( $this->targets ) {
					if ( in_array( $key, $this->targets ) ) {
						$this->targets = array_diff( $this->targets, [ $key ] );
					}
				}
				return true;
			}
			if ( $object->segment === $this->segment ) return false;
			if ( $limit > $this->limit ) return true;
			if ( $this->targets && ! in_array( $key, $this->targets ) ) return true;
		return $this->default;
	}

	/**  Spells  **/

	protected function show_possible_spells( $object ) {
		$list = $object->get_spell_list();
		if ( empty( $list ) ) {
			echo "\n" . $object->get_name() . " has NO spells!\n\n";
		} else {
			echo "\n" . $object->get_name() . " has Spells!\n\n";
			if ( isset( $list['multi'] ) ) {
				$index = 1;
				foreach( $list as $key => $spells ) {
					if ( $key === 'multi' ) continue;
					echo "$key Spells\n";
					$index = $this->show_numbered_spell_list( $spells, $index );
				}
			} else {
				$this->show_numbered_spell_list( $list );
			}
		}
	}

	protected function show_numbered_spell_list( $spells, $index = 1 ) {
		foreach( $spells as $level => $list ) {
			echo "\t$level level spells\n";
			foreach( $list as $name => $spell ) {
				$line = sprintf( "\t\t%3u) %-22s", $index, $name );
				$line.= $spell->get_listing_line();
				echo "$line\n";
				$index++;
			}
		}
		return $index;
	}

	protected function get_numbered_spell( $object, $number ) {
		$number = intval( $number );
		if ( $number ) {
			$list = $object->get_spell_list();
			if ( $list ) {
				$index = 1;
				if ( ! isset( $list['multi'] ) ) {
					$list = array( 'Single' => $list );
				}
				foreach( $list as $type => $listing ) {
					foreach( $listing as $level => $spells ) {
						foreach( $spells as $name => $spell ) {
							if ( $index === $number ) {
								return $object->locate_magic_spell( $name, $type );
							}
							$index++;
						}
					}
				}
			}
		}
		return false;
	}

	protected function pre_cast_spell( $origin, $number, $target = '' ) {
		if ( is_numeric( $number ) ) {
			$spell = $this->get_numbered_spell( $origin, $number );
		} else {
			$object = $this->get_object( $origin );
			if ( ! $object ) {
				echo "\nUnable to locate $origin\n\n";
				exit;
			}
			$spell = $object->get_listed_spell( $number );
		}
		if ( ! is_object( $spell ) ) {
			if ( is_string( $spell ) ) {
				echo "$spell\n";
			} else {
				echo "\nUnable to locate spell $number for $origin\n\n";
			}
			exit;
		}
		if ( $this->insufficent_manna( $spell ) ) {
			echo "\n" . $spell->get_caster() . " cannot cast " . $spell->get_name() . " due to insufficent manna points.\n\n";
			exit;
		}
		if ( $cast = parent::pre_cast_spell( $origin, $spell, $target ) ) {
			echo "\n" . $cast->get_caster() . " has cast " . $cast->get_name() . " on " . $cast->get_target() . "\n\n";
			if ( $cast->has_special() ) echo $cast->get_special() . "\n\n";
		} else {
			if ( $this->error ) $this->show_message( $this->error );
			echo "\npre cast bombed!\n\n";
			exit;
		}
	}

	protected function insufficent_manna( $spell ) {
		$caster = $this->get_object( $spell->get_caster() );
		if ( $spell->manna_cost() > $caster->manna ) return true;
		return false;
	}


	/**  Party  **/

	public function show_party_information() {
		if ( $this->party ) {
			$this->show_party_heading();
			$this->show_party_attacks();
		}
	}

	protected function show_party_heading() {
		$heading = '  ';
		$heading.= 'Att      ';
		$heading.= 'Name           ';
		$heading.= sprintf( 'Weapon %-12s', $this->range_check() );
		$heading.= 'Hit   ';
		$heading.= 'Dam   ';
		$heading.= 'Atts          ';
		$heading.= 'Movement           ';
		$heading.= 'Seg   Attack Sequence';
		echo "$heading\n";
	}

	protected function range_check() {
		if ( $this->rng_svd > 0 ) {
			return sprintf( '( r = %u )', $this->rng_svd );
		}
		if ( $this->range < 2000 ) {
			return sprintf( '( r: %u )', $this->range );
		}
		return '';
	}

	protected function show_party_attacks() {
		$separator = 0;
		foreach( $this->party as $name => $char ) {
			if ( $separator++ % 3 === 0 ) echo str_repeat( '-', 120 ) . "\n";
			$seq  = $this->get_attack_sequence( $char );
			$line = sprintf( ' %5s ', $this->enemy_to_hit_string( $char ) );
			$name = $char->get_name() . $this->status_letter( $char );
			$info = sprintf( '%7s(%d/%d)', $name, $char->get_hit_points(), $char->hit_points );
			$line.= sprintf( '%16s',  $info );
			$line.= sprintf( '%-34s ',   $this->get_weapon_string( $char ) );
			if ( $char->is_off_hand_weapon() ) {
				$seq = $this->show_primary_dual_weapon( $char, $info );
			}
			$line.= sprintf( '%u/%u  ', $char->weapon['attacks'][0], $char->weapon['attacks'][1] );
			$line.= sprintf( '%2u" ',   $char->movement );
			$line.= sprintf( '%s  ',    $this->get_mapped_movement_sequence( $char->movement ) );
			$line.= sprintf( '%2d  ',   ( $char->segment ));//% 10 ) );
			$line.= substr( $this->get_mapped_attack_sequence( $seq ), $this->minus );
			echo "$line\n";
		}
	}

	protected function status_letter( $obj ) {
		$state = apply_filters( 'dnd1e_object_status', '', $obj );
		if ( $obj->is_immobilized() ) return $state .= 'I';
		if ( $obj->is_prone() )       return $state .= 'P';
		if ( $obj->is_deaf() )        return $state .= 'D';
		return $state;
	}

	protected function enemy_to_hit_string( DND_Character_Character $target ) {
		$list   = array();
		$to_hit = array();
		$limit  = 1;
		foreach( $this->enemy as $key => $object ) {
			if ( $this->skip_object( $object, $limit ) ) continue;
			$weapon = $object->weapon['current'];
			if ( ! array_key_exists( $weapon, $list ) ) {
				$list[ $weapon ] = $object;
			}
			$limit++;
		}
		foreach( $list as $weapon => $object ) {
			$number = $this->get_to_hit_number( $object, $target );
			if ( ! in_array( $number, $to_hit ) ) $to_hit[] = $number;
		}
#		$to_hit = apply_filters( 'enemy_to_hit_array', $to_hit, $target );
		return ( empty( $to_hit ) ) ? '-1/-1' : implode( '/', $to_hit );
	}

	protected function get_weapon_string( DND_Character_Character $char ) {
		$string = sprintf( ': %-20s', substr( $this->get_weapon_text( $char ), 0, 19 ) );
		$monster = $this->get_base_monster();
		if ( $monster ) {
			$to_hit = max( 2, $this->get_to_hit_number( $char, $monster ) );
			$damage = $this->get_weapon_damage_string( $char, $monster );
			$string.= sprintf( '%2d %6s', $to_hit, $damage );
		} else {
			$string.= 'No opponent ';
		}
		return $string;
	}

	protected function get_weapon_text( DND_Character_Character $char ) {
		$weapon = $char->weapon['current'];
		$key    = $char->get_key();
		if ( $weapon === 'Spell' ) {
			if ( $this->is_casting( $key ) ) {
				$spell = $this->find_casting( $key );
				$weapon .= ':' . $spell->get_name();
			} else {
				$weapon .= "({$char->manna}/{$char->manna_init})";
			}
		} else if ( ( substr( $weapon, 0, 3) === 'Bow' ) && ( $this->range < BOW_POINT_BLANK ) ) {
			if ( in_array( $char->weapon['skill'], [ 'SP', 'DS' ] ) ) $weapon .= ": Damage*2";
		} else if ( ( substr( $weapon, 0, 5) === 'Cross' ) && ( $this->range < CROSSBOW_POINT_BLANK ) ) {
			if ( in_array( $char->weapon['skill'], [ 'SP', 'DS' ] ) ) $weapon .= ": D*2";
		}
		return $weapon;
	}

	protected function get_weapon_damage_string( DND_Character_Character $char, DND_Monster_Monster $monster ) {
		$string = '        ';
		$basic = $char->get_weapon_damage( $monster->size );
		if ( $basic === 'spec' ) {
			$string = 'Special';
		} else {
			$bonus = $char->get_weapon_damage_bonus( $monster, $this->range );
			$index = strpos( $basic, '+' );
			if ( $index ) {
				$bonus += intval( substr( $basic, $index + 1 ), 10 );
				$basic  = substr( $basic, 0, $index );
			}
			$arr = explode( 'd', $basic );
			$string = $this->format_damage_string( $arr[0], $arr[1], $bonus );
		}
		return $string;
	}

	protected function format_damage_string( $num, $die = 1, $bonus = 0 ) {
		if ( is_array( $num ) ) {
			list( $num, $die, $bonus ) = $num;
		} else if ( is_string( $num ) && ! is_numeric( $num ) ) {
			return $num;
		}
		if ( $die === 1 ) {
			$hp = $num + $bonus;
			$string = sprintf( '%dhp', $hp );
		} else {
			$basic = sprintf( '%dd%d', $num, $die );
			if ( $bonus > 0 ) {
				$string = sprintf( '%s+%u', $basic, $bonus );
			} else if ( $bonus < 0 ) {
				$string = sprintf( '%s-%u', $basic, $bonus );
			} else {
				$string = $basic;
			}
		}
		return $string;
	}

	protected function show_primary_dual_weapon( DND_Character_Character $char, $name ) {
		$char->set_primary_weapon();
		printf( '       %16s%s ', $name, $this->get_weapon_string( $char ) );
		printf( '%u/%u  ', $char->weapon['attacks'][0], $char->weapon['attacks'][1] );
		printf( '                           %2d  ', ( $char->segment ));//% 10 ) );
		$char->set_dual_weapon();
		$seq = $this->get_attack_sequence( $char );
		echo substr( $this->get_mapped_attack_sequence( $seq ), $this->minus );
		echo "\n";
		return $this->get_dual_attack_sequence( $seq, $char );
	}

	# WARNING: only handles dual weapons with attacks of 2/1 and 5/2 derived from 1/1:1/1 and 3/2:1/1
	protected function get_dual_attack_sequence( array $seq, DND_Character_Character $char ) {
		$sec   = array();
		$skip  = ( $char->weapon['attacks'][0] % 2 ) ? false : true;
		$five  = array( [ 4, 2, 4, 2, 4, 2 ], [ 5, 7, 5, 7, 5, 7 ], [ 6, 8, 6, 8, 6, 8 ], [ 7, 5, 7, 5, 7, 5 ], [ 8, 6, 8, 6, 8, 6 ], [ 9, 7, 5, 7, 5, 7 ], [ 0, 8, 6, 8, 6, 8 ], [ 1, 3, 1, 3, 1, 3 ], [ 2, 4, 2, 4, 2, 4 ], [ 3, 1, 3, 1, 3, 1 ] );
		$index = $seq[0] % 10;
		$curr  = $five[ $index ];
		$count = 0;
		foreach( $seq as $key => $seg ) {
			if ( $skip ) {
				$test = ( $key % 2 );
				if ( $test === 0 ) {
					continue;
				}
			} else {
				$segmt = $seg % 10;
				if ( $segmt === $curr[ $count ] ) {
					$count++;
				} else {
					continue;
				}
			}
			$sec[] = $seg;
		}
		return $sec;
	}

	protected function get_mapped_attack_sequence( $seqent ) {
		$map  = '|';
		$cur  = $cnt = 0;
		$keys = 1;
		foreach( $seqent as $att ) {
			if ( $keys > 1 ) {
				$keys = 1;
				continue;
			}
			if ( ( $cnt++ % 10 === 0 ) && ( $cnt > 1 ) ) $map .='^|';
			$step = $att - $cur;
			for( $i = 1; $i < $step; $i++ ) {
				$map .= '-|';
				if ( $cnt++ % 10 === 0 ) $map .='^|';
			}
			$keys = count( array_keys( $seqent, $att ) );
			$map .= ( ( $keys > 1 ) ? '@' : $att % 10 ) . '|';
			$cur  = $att;
		}
		$end = ( $this->rounds * 10 ) + 1;
		for( $i = $cur; $i < $end; $i++ ) {
			if ( ( $cnt++ % 10 === 0 ) && ( $cnt > 1 ) ) $map .='^|';
			$map .= '-|';
		}
		return $map;
	}

	protected function show_possible_weapons( $object ) {
		echo "\n{$object->name} has these weapons available:\n\n";
		if ( $object instanceOf DND_Monster_Monster ) {
			foreach( $object->weapons as $attack => $data ) {
				if ( $attack === 'sequence' ) {
					echo "\t{$data[0]}\n";
				} else {
					echo "\t$attack\n";
				}
			}
		} else {
			foreach( $object->weapons as $weapon => $info ) {
				echo "\t$weapon ({$info['skill']})\n";
			}
		}
		echo "\n";
		exit;
	}


	/**  Attack/Movement functions  **/

	public function show_notifications() {
		echo "\nSegment {$this->segment}\n";
		echo "---Attacks---\n";
		$this->show_attackers();
		echo "---Movement---\n";
		$call = 'show_movement_by_' . $this->show_moves;
		call_user_func( [ $this, $call ] );
		echo "\n";
	}

	protected function show_attackers() {
		$party = $this->get_party_attackers();
		$enemy = $this->get_enemy_attackers();
		$rank  = array_merge( $party, $enemy );
		$this->rank_attackers( $rank );
		foreach( $rank as $body ) {
			$key = $body->get_key();
			echo "\t" . $body->get_name('w');
			if ( $this->holding && in_array( $key, $this->holding ) ) {
				echo " (holding)";
			} else {
				$this->check_for_dual_weapon( $body );
			}
			if ( $this->is_casting( $key ) ) {
				$spell = $this->find_casting( $key );
				if ( $this->segment === $spell->get_when() ) {
					$spell->show_casting();
				} else {
					echo " (casting {$this->segment}/" . $spell->get_when() . ")";
				}
			} else if ( array_key_exists( $key, $this->moves ) ) {
				$this->movement_when_attacking( $key );
			}
			echo "\n";
		}
	}

	protected function check_for_dual_weapon( $char ) {
		if ( $char instanceOf DND_Character_Character ) {
			if ( $char->weap_dual && stripos( $char->weapon['current'], 'off-hand' ) ) {
				$sequence  = $this->get_attack_sequence( $char );
				$secondary = $this->get_dual_attack_sequence( $sequence, $char );
				if ( in_array( $this->segment, $secondary ) ) {
					echo " {$char->weap_dual[1]}";
				} else {
					echo " {$char->weap_dual[0]}";
				}
			}
		}
	}


	/**  Notification functions  **/

	protected function show_active_effects() {
		echo "\n";
		foreach( $this->effects as $key => $effect ) {
			$origin = $this->get_object( $effect->get_caster() );
			$effect->show_status( $origin );
			echo "\n";
		}
		exit;
	}

	protected function show_message( $text ) {
		echo "\n$text\n\n";
		exit;
	}

	protected function show_saving_throws( $name, $source = 0 ) {
		$object = $this->get_object( $name );
		$source = $this->get_object( $source );
		$throws = $object->get_saving_throws( $source );
		echo "\n";
		echo "                  Saving Throws for {$object->name}\n";
		echo "\n";
		foreach( $throws as $key => $roll ) {
			printf( '%40s: %2d', $key, $roll );
			echo "\n";
		}
		echo "\n";
		exit;
	}

	protected function critical_hit_result( $param, $type ) {
		$crit = parent::critical_hit_result( $param, $type );
		if ( is_array( $crit ) ) {
			print_r( $crit );
		} else {
			echo "\n$crit\n\n";
		}
		exit;
	}

	protected function fumble_roll_result( $roll ) {
		$fumble = parent::fumble_roll_result( $roll );
		echo "\n$fumble\n\n";
		exit;
	}

	protected function get_serialization_data() {
		$table = parent::get_serialization_data();
		$table['limit']   = $this->limit;
		$table['rng_svd'] = $this->rng_svd;
		$table['show']    = $this->show;
		$table['targets'] = $this->targets;
		return $table;
	}


}

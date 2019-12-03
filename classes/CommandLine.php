<?php

class DND_CommandLine extends DND_Combat {


	protected $minus = 0;
	protected $text  = array();


	use DND_Trait_GetOpts;
	use DND_Trait_Singleton;


	protected function __construct( array $args = array() ) {
		$this->get_opts();
		if ( array_key_exists( 's', $this->opts ) ) {
			if ( array_key_exists( 'segment', $args ) ) {
				$args['segment']++;
			}
		}
		parent::__construct( $args );
		$this->process_opts();
		$this->minus = ( ( ( $this->segment - 1 ) + floor( ( $this->segment - 1 ) / 10 ) ) * 2 );
	}


	/**  Setup functions  **/

	public function import_party( $list ) {
		foreach( $list as $name => $data ) {
			$file = CSV_PATH . $name . '.csv';
			if ( is_readable( $file ) ) {
				$info = ( array_key_exists( 'data', $data ) ) ? $data['data'] : array();
				$temp = new DND_Character_Import_Kregen( $file, $info );
				$this->party[ $name ] = $temp->character;
			}
		}
	}

	public function reimport_character( $name ) {
		$file = CSV_PATH . $name . '.csv';
		if ( is_readable( $file ) ) {
#			$info = ( array_key_exists( 'data', $data ) ) ? $data['data'] : array();
			$temp = new DND_Character_Import_Kregen( $file ); #, $info );
			$this->party[ $name ] = $temp->character;
		}
	}

	public function generate_encounter( $string ) {
		$options = explode( ':', $string );
		$terrain = $options[0];
		$area    = ( array_key_exists( 1, $options ) ) ? $options[1] : false;
		if ( $terrain && $area ) {
			$enc  = new DND_Encounters;
			$roll = ( array_key_exists( 2, $options ) ) ? intval( $options[2] ) : 0;
			$listing = $enc->get_random_encounter( "$terrain:$area", $roll );
			print_r($listing);
			exit;
		}
	}

	/**  Display functions  **/

	/**  Monsters  **/

	public function show_enemy_information() {
		$monster = $this->get_base_monster();
		if ( $monster ) {
			echo "\n";
			echo $monster->command_line_display();
			echo "\n";
			echo count( $this->enemy ) . " Appearing HP: ";
			$number = 0;
			foreach( $this->enemy as $key => $entity ) {
				// TODO: check for regeneration when segment advances
				if ( $entity->current_hp < 1 ) continue;
				echo "  $key: {$entity->current_hp}/{$entity->hit_points}";
				$number++;
			}
			echo "\nRemaining: $number\n\n";
			$this->show_enemy_heading();
			if ( $monster instanceOf DND_Monster_Humanoid_Humanoid ) {
				$this->show_humanoid_attacks( $monster );
			} else {
				$this->show_monster_attacks( $monster );
			}
		} else {
			return "No enemy found.";
		}
	}

	protected function show_enemy_heading() {
		$heading = '            ';
		$heading.= 'Name                ';
		$heading.= 'Weapon             ';
		$heading.= 'Dam   ';
		$heading.= 'Atts          ';
		$heading.= 'Movement           ';
		$heading.= 'Seg   Attack Sequence';
		echo "$heading\n";
	}

	protected function show_humanoid_attacks( $monster ) {
		$weapons = array();
		foreach( $this->enemy as $key => $entity ) {

		}
		$this->show_monster_attacks( $monster );
	}

	protected function show_monster_attacks( DND_Monster_Monster $monster ) {
		$att_seq = $this->get_monster_attacks( $monster );
		foreach( $monster->att_types as $type => $attack ) {
			$line = '   '         . sprintf( '%14s', substr( $monster->name, 0, 13 ) );
			$line.= '        '    . sprintf( '%15s', $type );
			$line.= '           ' . sprintf( '%-5s', $monster->get_possible_damage( $type ) );
			$line.= '     ';
			$line.= '      '      . $this->get_mapped_movement_sequence( $monster->movement );
			$line.= '  '          . sprintf( '%2d', ( $att_seq[ $type ][0] ) );//% 10 ) );
			$line.= '  '          . substr( $this->get_mapped_attack_sequence( $att_seq[ $type ] ), $this->minus );
			echo "$line\n";
		}
		echo "\n";
	}

	/**  Spells  **/

	protected function show_possible_spells( DND_Character_Character $char ) {
		$list = $char->get_spell_list();
		if ( empty( $list ) ) {
			echo "\n{$char->name} has NO spells!\n\n";
		} else {
			echo "\n{$char->name} has Spells!\n\n";
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
			foreach( $list as $name => $info ) {
				echo "\t\t$index) $name";
				if ( strlen( $name ) < 13 ) echo "\t";
				if ( strlen( $name ) < 21 ) echo "\t";
#				if ( strlen( $name ) < 24 ) echo "\t";
				echo "\t{$info['page']}";
				if ( strlen( $info['page'] ) < 8 ) echo "\t";
				if ( strlen( $info['page'] ) < 16 ) echo "\t";
				if ( array_key_exists( 'cast', $info ) ) {
					echo "\tC: {$info['cast']}";
				}
				if ( array_key_exists( 'range', $info ) ) {
					echo "\tR: {$info['range']}";
				}
				if ( array_key_exists( 'duration', $info ) ) {
					echo "\tD: {$info['duration']}";
				}
				if ( array_key_exists( 'special', $info ) ) {
					echo "\tS: {$info['special']}";
				}
				echo "\n";
				$index++;
#print_r($info);
			}
		}
		return $index;
	}

	protected function get_numbered_spell( DND_Character_Character $char, $number ) {
		$number = intval( $number );
		if ( $number ) {
			$list = $char->get_spell_list();
			if ( $list ) {
				$index = 1;
				if ( ! isset( $list['multi'] ) ) {
					$list = array( 'Single' => $list );
				}
				foreach( $list as $type => $listing ) {
					foreach( $listing as $level => $spells ) {
						foreach( $spells as $spell => $data ) {
							if ( $index === $number ) {
								return $char->get_magic_spell_info( $level, $spell, $type );
							}
							$index++;
						}
					}
				}
			}
		}
		return false;
	}

	/**  Party  **/

	public function show_party_information() {
		if ( $this->party ) {
			$this->show_party_heading();
			$separator = 0;
			foreach( $this->party as $name => $char ) {
				if ( $separator++ % 3 === 0 ) echo str_repeat( '-', 120 ) . "\n";
#				$separator++;
				$seq  = $this->get_attack_sequence( $char->segment, $char->weapon['attacks'] );
				$line = sprintf( ' %5s ', $this->enemy_to_hit_string( $char ) );
				$name = sprintf( '%7s(%d/%d)', $char->get_name(), $char->get_hit_points(), $char->hit_points );
				$line.= sprintf( '%16s',  $name );
				$line.= sprintf( '%s ',   $this->get_weapon_string( $char ) );
				if ( $char->is_off_hand_weapon() ) {
					$seq = $this->show_primary_dual_weapon( $char, $name );
				}
				$line.= sprintf( '%u/%u  ', $char->weapon['attacks'][0], $char->weapon['attacks'][1] );
				$line.= sprintf( '%2u" ',   $char->movement );
				$line.= sprintf( '%s  ',    $this->get_mapped_movement_sequence( $char->movement ) );
				$line.= sprintf( '%2d  ',   ( $char->segment ));//% 10 ) );
				$line.= substr( $this->get_mapped_attack_sequence( $seq ), $this->minus );
				echo "$line\n";
			}
		}
	}

	protected function show_party_heading() {
		$heading = '  ';
		$heading.= 'Att      ';
		$heading.= 'Name           ';
		$heading.= 'Weapon          ';
		$heading.= 'To Hit   ';
		$heading.= 'Dam   ';
		$heading.= 'Atts          ';
		$heading.= 'Movement           ';
		$heading.= 'Seg   Attack Sequence';
		echo "$heading\n";
	}

	protected function enemy_to_hit_string( DND_Character_Character $target ) {
		$origin = $this->get_base_monster();
		$to_hit = array();
		foreach( $origin->att_types as $type => $attack ) {
			$number = $this->get_combat_to_hit_number( $origin, $target, $type );
			if ( ! in_array( $number, $to_hit ) ) $to_hit[] = $number;
		}
		return implode( '/', $to_hit );
	}

	protected function get_weapon_string( DND_Character_Character $char ) {
		$monster = $this->get_base_monster();
		$string = sprintf( ': %-20s', substr( $this->get_weapon_text( $char ), 0, 19 ) );
		$string.= sprintf( '%2d  ',   max( 2, $this->get_combat_to_hit_number( $char, $monster ) ) );
		$string.= $this->get_weapon_damage_string( $char, $monster );
		return $string;
	}

	protected function get_weapon_text( DND_Character_Character $char ) {
		$weapon = $char->weapon['current'];
		$name   = $char->get_name();
		if ( $weapon === 'Spell' ) {
			if ( $this->is_casting( $name ) ) {
				$spell = $this->find_casting( $name );
				$weapon .= ':' . $spell['name'];
			}
		} else if ( ( substr( $weapon, 0, 3) === 'Bow' ) && ( $this->range < BOW_POINT_BLANK ) ) {
			if ( in_array( $this->party[ $name ]->weapon['skill'], [ 'SP', 'DS' ] ) ) $weapon .= ": Damage*2";
		} else if ( ( substr( $weapon, 0, 5) === 'Cross' ) && ( $this->range < CROSSBOW_POINT_BLANK ) ) {
			if ( in_array( $this->party[ $name ]->weapon['skill'], [ 'SP', 'DS' ] ) ) $weapon .= ": D*2";
		}
		return $weapon;
	}

	protected function get_weapon_damage_string( DND_Character_Character $char, DND_Monster_Monster $monster ) {
		$string = '        ';
		$basic = $char->get_weapon_damage( $monster->size );
		if ( $basic === 'spec' ) {
			$string = ' Special';
		} else {
			$bonus = $char->get_weapon_damage_bonus( $monster, $this->range );
			$index = strpos( $basic, '+' );
			if ( $index ) {
				$bonus += intval( substr( $basic, $index + 1 ), 10 );
				$basic  = substr( $basic, 0, $index );
			}
			if ( $bonus > 0 ) {
				$string = sprintf( '%5s+%-2u', $basic, $bonus );
			} else if ( $bonus < 0 ) {
				$string = sprintf( '%5s-%-2u', $basic, $bonus );
			} else {
				$string = sprintf( '%5s   ', $basic );
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
		$seq = $this->get_attack_sequence( $char->segment, $char->weapon['attacks'] );
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
			$keys = count( array_keys( $seqent, ( $att % 10 ) ) );
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

	protected function show_possible_weapons( DND_Character_Character $char ) {
		echo "\n{$char->name} has these weapons available:\n\n";
		foreach( $char->weapons as $weapon => $info ) {
			echo "\t$weapon ({$info['skill']})\n";
		}
		echo "\n";
		exit;
	}

	/**  Notification functions  **/

	public function show_notifications() {
		echo "\nSegment {$this->segment}\n";
		echo "---Attacks---\n";
		$this->show_attackers();
		echo "---Movement---\n";
		$this->show_movers();
		echo "\n";
	}

	protected function show_attackers() {
		$party = $this->get_party_attackers();
		$enemy = $this->get_enemy_attackers();
		$rank  = array_merge( $party, $enemy );
		$this->rank_attackers( $rank );
		foreach( $rank as $body ) {
			$name = $body->get_name();
			echo "\t$name";
			if ( $this->holding && in_array( $name, $this->holding ) ) {
				echo " (holding)";
			} else {
				$this->check_for_dual_weapon( $body );
			}
			if ( $this->casting && $this->is_casting( $name ) ) {
				$spell = $this->find_casting( $name );
				if ( $this->segment === $spell['when'] ) {
					$this->show_casting( $spell );
					$this->finish_casting( $spell );
				} else {
					echo " (casting {$this->segment}/{$spell['when']})";
				}
			}
			echo "\n";
		}
	}

	protected function show_casting( $spell ) {
		echo " casting {$spell['name']} {$spell['page']}";
		if ( array_key_exists( 'reversible', $spell ) ) echo " Reversible";
		if ( array_key_exists( 'range',      $spell ) ) echo "\n\t\t         Range: {$spell['range']}";
		if ( array_key_exists( 'duration',   $spell ) ) echo "\n\t\t      Duration: {$spell['duration']}";
		if ( array_key_exists( 'aoe',        $spell ) ) echo "\n\t\tArea of Effect: {$spell['aoe']}";
		if ( array_key_exists( 'saving',     $spell ) ) echo "\n\t\t  Saving Throw: {$spell['saving']}";
		if ( array_key_exists( 'special',    $spell ) ) echo "\n\t\t       Special: {$spell['special']}";
	}

	protected function show_movers() {
		if ( $this->moves ) {
			foreach( $this->moves as $moving ) {
				echo "\t$moving\t";
			}
			echo "\n";
		}
	}

	protected function check_for_dual_weapon( $char ) {
		if ( $char instanceOf DND_Character_Character ) {
			if ( $char->weap_dual && stripos( $char->weapon['current'], 'off-hand' ) ) {
				$sequence  = $this->get_attack_sequence( $char->segment, $char->weapon['attacks'] );
				$secondary = $this->get_dual_attack_sequence( $sequence, $char );
				if ( in_array( $this->segment, $secondary ) ) {
					echo " {$char->weap_dual[1]}";
				} else {
					echo " {$char->weap_dual[0]}";
				}
			}
		}
	}

	protected function show_saving_throws( $name, $source = null ) {
echo "\nST Name: $name\n";
		if ( array_key_exists( $name, $this->party ) ) {
			$char = $this->party[ $name ];
			if ( ! $source ) {
				$key = array_key_first( $this->enemy );
				$source = $this->enemy[ $key ];
			}
			$saving = $char->get_character_saving_throws( $source );
			echo "\n";
			echo "                  Saving Throws for " . $char->get_name() . "\n";
			echo "\n";
			foreach( $saving as $key => $roll ) {
				printf( '%40s: %2d', $key, $roll );
				echo "\n";
			}
			echo "\n";
			exit;
		}
	}

	protected function critical_hit_result( $param ) {
		$crit = parent::critical_hit_result( $param );
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


}

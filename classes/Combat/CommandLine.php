<?php

class DND_Combat_CommandLine extends DND_Combat_Combat {


#	protected $base     = null;    // DND_Combat_Combat
#	protected $casting  = array(); // DND_Combat_Spells
	private   $columns  = 71;
	protected $default  = false;
#	public    $effects  = array(); // DND_Combat_Combat
#	protected $enemy    = array(); // DND_Combat_Combat
#	protected $gear     = array(); // DND_Combat_Gear
#	protected $holding  = array(); // DND_Combat_Combat
	protected $limit    = 12;
#	protected $messages = array(); // DND_Combat_Combat
	protected $minus    = 0;
#	protected $party    = array(); // DND_Combat_Combat
#	protected $range    = 2000;    // DND_Combat_Combat
	protected $ranked   = array();
	protected $rng_svd  = 0;
#	protected $rounds   = 3;       // DND_Combat_Combat
#	protected $segment  = 1;       // DND_Combat_Combat
	protected $show     = 0;
	protected $shown    = array();
	protected $targets  = array();


	use DND_Combat_Opts;
	use DND_Trait_Singleton;


	protected function __construct( array $args = array() ) {
		$this->get_opts();
		if ( array_key_exists( 's', $this->opts ) ) {
			if ( array_key_exists( 'segment', $args ) ) {
				$args['segment']++;
			}
			add_action( 'dnd1e_combat_init', [ $this, 'new_segment_housekeeping' ], 5 );
		}
		add_action( 'dnd1e_new_segment', [ $this, 'reset_targets' ] );
		parent::__construct( $args );
		$this->post_parent();
	}

	protected function post_parent() {
		$this->minus = ( ( ( $this->segment - 1 ) + floor( ( $this->segment - 1 ) / 10 ) ) * 2 );
		if ( $this->rng_svd > 0 ) $this->range = $this->rng_svd;
		if ( count( $this->enemy ) > $this->limit ) $this->default = true;
		add_action( 'dnd1e_attack_made', [ $this, 'set_target' ] );
	}

	public function __toString() {
		return 'Commandline';
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

	public function generate_encounter( $terrain, $area, $freq, $crea, $limit ) {
		if ( $terrain && $area ) {
			$enc = new DND_Combat_Encounters;
			$listing = $enc->get_random_encounter( "$terrain:$area", $freq, $crea );
			if ( $crea ) {
				echo "\n\t{$listing['name']}";
				echo "\t{$listing['class']}\n\n";
			} else {
				print_r( $listing );
				echo "Count: " . count( $listing ) . "\n";
			}
			if ( $crea ) {
				$new = $listing['class'];
				$this->reset_combat();
				$monster = new $new;
				$this->initialize_enemy( $monster, $limit );
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
		$this->limit   = 10;
		$this->minus   = 0;
		$this->rng_svd = 0;
		$this->show    = 0;
		$this->targets = array();
	}


	/**  Set functions  **/

	protected function set_limit( $limit ) {
		$this->limit = $limit;
	}

	public function set_target( $target ) {
		$this->targets[] = $target->get_key();
	}

	public function reset_targets( $unused ) {
		$this->targets = array();
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
		$enemy = $this->get_object( $num );
		echo "\n";
		echo "Appearing: " . $this->get_surviving_enemy() . "/" . count( $this->enemy );
		echo "   Morale: " . $this->get_enemy_morale() . "%\n";
		echo $enemy->command_line_display();
		echo "\n";
		if ( $enemy->get_hit_points() < 1 ) $this->show = null;
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
			$seq = $object->get_attack_sequence( $this->rounds, $object->weapon );
			if ( $this->skip_object( $object, $seq, $limit ) ) continue;
			if ( $this->show === null ) $this->show = $key;
			$object->monster_armor_class();
			$object->check_weapon_sequence( $seq, $this->segment );
			$line = ' '   . sprintf( '%26s', $this->show_enemy_name( $object ) );
			$line.= '  '  . sprintf( '%-18s', substr( $this->get_weapon_text( $object ), 0, 18 ) );
			$line.= ''    . sprintf( '%7s', $this->format_damage_string( $object->weapon['damage'] ) );
			$line.= '   ' . sprintf( '%2u/%u', $object->weapon['attacks'][0], $object->weapon['attacks'][1] );
			$line.= '  '  . sprintf( '%2u"', $object->movement );
			$line.= ' '   . $this->get_mapped_movement_sequence( $object->movement );
			$line.= '  '  . sprintf( '%2d', $object->segment );
			$line.= '  '  . substr( substr( $this->get_mapped_attack_sequence( $seq ), $this->minus ), 0, $this->columns );
			echo "$line\n";
			$win = false;
			$limit++;
			if ( empty( $this->base ) && in_array( $this->segment, $seq ) ) $this->base = $object->get_key();
		}
		if ( $win ) echo "                   YOU WIN!!\n";
		echo "\n";
	}

	protected function show_enemy_name( $object ) {
		static $base_ac = 11;
		if ( $base_ac === 11 ) $base_ac = $this->get_base_ac();
		$name = substr( $object->get_key(), -16 );
		if ( $object instanceOf DND_Monster_Humanoid_Humanoid ) $object->determine_armor_class();
		if ( ! ( $base_ac === $object->get_armor_class() ) ) {
#echo "$base_ac:".$object->get_armor_class()."\n";
			$name .= sprintf( ':%d', $object->get_armor_class() - $base_ac );
			$name  = substr( $name, -16 );
		}
		return sprintf( '%s (%d/%d)', $name, $object->get_hit_points(), $object->hit_points );
	}

	protected function get_base_ac() {
		$object = $this->get_shown_monster();
#echo "gba: {$object->armor_class}\n";
		return $object->get_armor_class();
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

	protected function skip_object( $object, $seq, $limit ) {
		$key = $object->get_key();
		if ( $object->get_hit_points() < 1 ) {
			if ( $this->targets ) {
				if ( in_array( $key, $this->targets ) ) {
					$this->targets = array_diff( $this->targets, [ $key ] );
				}
			}
			return true;
		}
		if ( ! array_key_exists( get_class( $object ), $this->shown ) ) {
			$this->add_to_shown( $object );
			return false;
		}
		if ( ( $limit - 1 ) < $this->limit ) return false;
		if ( in_array( $this->segment, $seq ) ) return false;
		if ( $this->targets && in_array( $key, $this->targets ) ) return false;
		if ( $limit > $this->limit ) return true;
		return $this->default;
	}

	protected function add_to_shown( $object ) {
		$key = get_class( $object );
		$this->shown[ $key ] = $object;
	}

	protected function get_shown_monster() {
		$first  = array_key_first( $this->shown );
		return $this->shown[ $first ];
	}

	protected function get_ranked_monster() {
		if ( empty( $this->ranked ) ) $this->ranked = $this->get_ranked_attackers();
		foreach( $this->ranked as $rank ) {
			if ( $rank instanceOf DND_Monster_Ranking ) {
				return $this->get_object( $rank->get_key() );
			}
		}
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
				$index = $this->show_numbered_spell_list( $list );
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
								return $object->get_listed_spell( $name, $type );
							}
							$index++;
						}
					}
				}
			}
		}
		return false;
	}

	protected function pre_cast_spell( $name, $number, $target = '' ) {
		$object = $this->get_object( $name );
		if ( is_numeric( $number ) ) {
			$spell = $this->get_numbered_spell( $object, $number );
		} else {
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
		if ( $cast = parent::pre_cast_spell( $name, $spell, $target ) ) {
			$this->messages[] = $cast->get_caster() . " has cast " . $cast->get_name() . " on " . $cast->get_target();
			if ( $cast->has_special() ) $this->messages[] = $cast->get_special();
		} else {
			if ( $this->error ) $this->show_error( $this->error );
			$this->show_error( 'pre cast bombed!' );
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
			if ( $char->get_hit_points() < -10 ) continue;
			if ( $separator++ % 3 === 0 ) echo str_repeat( '-', 120 ) . "\n";
			if ( $char->is_dual_weapon() ) {
				$char->set_dual_flag( 'primary' );
				$this->show_character_info( $char );
				$this->show_secondary_weapon( $char );
				$char->set_dual_flag( 'all' );
			} else {
				$this->show_character_info( $char );
			}
		}
	}

	# This function has evolved into a crock of shit, and should be rewritten.
	protected function show_character_info( $char ) {
		$char->determine_armor_class();
		$hits = $this->enemy_to_hit_string( $char );
		$len  = max( 0, strlen( $hits ) - 5 );
		$line = sprintf( ' %5s ', $hits );
		$name = $char->get_name() . $this->status_letter( $char );
		$info = trim( sprintf( '%7s(%d/%d)', $name, $char->get_hit_points(), $char->hit_points ) );
		list( $len, $string ) = $this->minimize_string( [ '%', 17, 's' ], $len, $info );
		$line.= sprintf( $string,  $info );
		$weap = $this->get_weapon_string( $char, $len );
		list( $len, $string ) = $this->minimize_string( [ '%-', 33, 's ' ], $len, $weap );
		$line.= sprintf( $string, $weap );
		$line.= sprintf( '%u/%u  ', $char->weapon['attacks'][0], $char->weapon['attacks'][1] );
		$line.= sprintf( '%2u" ',   $char->movement );
		$line.= sprintf( '%s  ',    $this->get_mapped_movement_sequence( $char->movement ) );
		$line.= sprintf( '%2d  ',   ( $char->segment ) );//% 10 ) );
		$seq  = $char->get_attack_sequence( $this->rounds, $char->weapon );
		$line.= substr( substr( $this->get_mapped_attack_sequence( $seq ), $this->minus ), 0, $this->columns );
		echo "$line\n";
	}

	private function minimize_string( $base, $len, $string ) {
		if ( $len > 0 ) {
			$diff = $base[1] - strlen( $string );
			$base[1] -= ( $len > $diff ) ? $diff : $len;
			$len -= $diff;
		}
		return array( $len, implode( '', $base ) );
	}

	protected function status_letter( $obj ) {
		$state = apply_filters( 'dnd1e_object_status', '', $obj );
		if ( $obj->is_immobilized() ) return $state .= 'I';
		if ( $obj->is_prone() )       return $state .= 'P';
		if ( $obj->is_deaf() )        return $state .= 'D';
		return $state;
	}

	protected function enemy_to_hit_string( DND_Character_Character $target ) {
		if ( empty( $this->ranked ) ) $this->ranked = $this->get_ranked_attackers();
		$to_hit = array();
		foreach( $this->ranked as $key => $object ) {
			if ( ! $object instanceOf DND_Monster_Ranking ) continue;
			$current = $this->get_object( $object->get_key() );
			if ( $this->filter_attacker( $current ) ) {
				$number = $this->get_to_hit_number( $current, $target );
				if ( ! in_array( $number, $to_hit ) ) $to_hit[] = $number;
			}
		}
		return ( empty( $to_hit ) ) ? '-1/-1' : implode( '/', $to_hit );
	}

	protected function get_weapon_string( DND_Character_Character $char, $len ) {
		$text = substr( $this->get_weapon_text( $char ), 0, 19 );
		list( $len, $sprint ) = $this->minimize_string( [ ': %-', 20, 's' ], $len, $text );
		$string = sprintf( $sprint, $text );
		$string.= $this->get_to_hit_string( $char );
		return $string;
	}

	protected function get_weapon_text( $object ) {
		$weapon = $object->weapon['current'];
		$key    = $object->get_key();
		if ( $weapon === 'Spell' ) {
			if ( $spell = $this->is_casting( $key ) ) {
				$weapon .= ':' . $spell->get_name();
			} else {
				$weapon .= "({$object->manna}/{$object->manna_init})";
			}
		} else if ( ( substr( $weapon, 0, 3) === 'Bow' ) && ( $this->range < BOW_POINT_BLANK ) ) {
			if ( in_array( $object->weapon['skill'], [ 'SP', 'DS' ] ) ) $weapon .= ": Damage*2";
		} else if ( ( substr( $weapon, 0, 5) === 'Cross' ) && ( $this->range < CROSSBOW_POINT_BLANK ) ) {
			if ( in_array( $object->weapon['skill'], [ 'SP', 'DS' ] ) ) $weapon .= ": D*2";
		} else if ( array_key_exists( 'symbol', $object->weapon ) ) {
			$weapon .= ':' . $object->weapon['symbol'];
		}
		return $weapon;
	}

	protected function get_to_hit_string( DND_Character_Character $char ) {
		static $monster = null;
		if ( ! $monster ) $monster = $this->get_shown_monster();
		if ( $monster ) {
			$to_hit = max( 2, $this->get_to_hit_number( $char, $monster ) );
			$damage = $this->get_weapon_damage_string( $char, $monster );
			return sprintf( '%2d %6s', $to_hit, $damage );
		}
		return 'No opponent ';
	}

	protected function get_weapon_damage_string( DND_Character_Character $char, DND_Monster_Monster $monster ) {
		$string = '        ';
		$size   = ( $monster->size[0] === 'L' ) ? 'L' : 'SM';
		$damage = $char->get_weapon_damage_array( $char->weapon['current'], $size );
		if ( $damage[0] === 'Spec' ) {
			$string = 'Special';
		} else {
			$damage[1]  = apply_filters( 'dnd1e_damage_die', $damage[1], $char, $monster );
#			$damage[2] += $char->get_weapon_damage_bonus( $monster, $this->range );
			$string = $this->format_damage_string( $damage );
		}
		return $string;
	}

	protected function format_damage_string( $num, $die = 1, $bonus = 0 ) {
		if ( is_array( $num ) ) {
			list( $num, $die, $bonus ) = $num;
		}
		if ( is_string( $num ) && ! is_numeric( $num ) ) {
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
				$string = sprintf( '%s-%u', $basic, abs( $bonus ) );
			} else {
				$string = $basic;
			}
		}
		return $string;
	}

	protected function show_secondary_weapon( $char ) {
		$char->set_dual_flag( 'secondary' );
		$weapon = $char->weap_twins['secondary'];
		$line   = str_repeat( ' -', 12 ) . ' ';
		$string = $weapon['current'] . ( ( array_key_exists( 'symbol', $weapon ) ) ? ':' . $weapon['symbol'] : '' );
		$line  .= sprintf( ' %-20s', substr( $string, 0, 20 ) );
		$line  .= $this->get_to_hit_string( $char );
		$line  .= sprintf( '   %u/%u', $weapon['attacks'][0], $weapon['attacks'][1] );
		$line  .= str_repeat( ' -', 16 ) . ' ';
		$seq    = $char->get_dual_attack_sequence( $this->rounds, 'secondary' );
		$line  .= substr( $this->get_mapped_attack_sequence( $seq ), $this->minus );
		echo "$line\n";
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
		echo "\n" . $object->get_key() . " has these weapons available:\n\n";
		if ( $object instanceOf DND_Monster_Monster ) {
			foreach( $object->weapons as $attack => $data ) {
				if ( empty( $data ) ) continue;
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
			if ( method_exists( $object, 'special_string_undead' ) ) {
				echo "\tTurn Undead\n";
			}
		}
		echo "\n";
	}


	/**  Attack/Movement functions  **/

	public function show_notifications() {
		if ( ! empty( $this->error ) ) $this->show_error( $this->error );
		echo "\nSegment {$this->segment}\n";
		echo "---Attacks---\n";
		$this->show_attackers();
		echo "---Movement---\n";
		$call = 'show_movement_by_' . $this->show_moves;
		call_user_func( [ $this, $call ] );
		echo "\n";
		if ( ! empty( $this->messages ) ) $this->show_messages( $this->messages );
	}

	protected function show_attackers() {
		if ( empty( $this->ranked ) ) $this->ranked = $this->get_ranked_attackers();
		foreach( $this->ranked as $body ) {
			$key = $body->get_key();
			echo "\t" . $body->get_name('w');
			if ( $this->holding && in_array( $key, $this->holding ) ) {
				echo " (holding)";
			} else {
				$this->check_for_dual_weapon( $body );
			}
			$chk = ( $body instanceOf DND_Monster_Ranking ) ? $body->race : $key;
			if ( $spell = $this->is_casting( $key ) ) {
				if ( $this->segment === $spell->get_when() ) {
					$spell->show_casting();
				} else {
					echo " (casting {$this->segment}/" . $spell->get_when() . ")";
				}
			} else if ( array_key_exists( $chk, $this->moves ) ) {
				$this->movement_when_attacking( $chk );
			}
			echo "\n";
		}
	}

	protected function check_for_dual_weapon( $char ) {
		if ( $char instanceOf DND_Character_Character ) {
			if ( $char->weap_dual ) {
				$secondary = $char->get_dual_attack_sequence( $this->rounds, 'secondary' );
				if ( in_array( $this->segment, $secondary ) ) {
					echo " {$char->weap_dual[1]}";
				} else {
					echo " {$char->weap_dual[0]}";
				}
			}
		}
	}

	protected function damage_parameters( $in ) {
		$in  = explode( ':', $this->opts['hit'] );
		$cnt = count( $in );
		if ( $cnt === 2 ) {
			list( $target, $damage ) = $in;
			$this->object_damage( $target, $damage ); # DEPRECATED - Do not use this form - will be removed in the future
		} else if ( $cnt === 4 ) {
			list( $origin, $target, $damage, $effect ) = $in;
			$this->object_damage_with_origin( $origin, $target, $damage, $effect );
		} else if ( $cnt === 3 ) {
			list( $origin, $target, $damage ) = $in;
			if ( is_numeric( $damage ) ) {
				$this->object_damage_with_origin( $origin, $target, $damage );
			} else { //               target   damage   effect
				$this->object_damage( $origin, $target, $damage ); # DEPRECATED - All hits should include origin
			}
		}
	}


	/**  Notification functions  **/

	protected function show_active_effects() {
		echo "\n";
		foreach( $this->effects as $key => $effect ) {
			$origin = $this->get_object( $effect->get_caster() );
			$effect->show_status( $origin, $this );
			echo "\n";
		}
		exit;
	}

	protected function show_loot() {
		foreach( $this->enemy as $body ) {
			if ( $body->get_hit_points() > 0 ) continue;
			# FIXME:  use $this->get_owner_gear( $body->get_key() );
			if ( ! empty( $body->gear ) ) {
				print_r( $body->gear );
			}
		}
		exit;
	}

	protected function show_error( $text ) {
		echo "\n$text\n\n";
		exit;
	}

	protected function show_messages( $messages = array () ) {
		if ( $messages ) {
			foreach( (array) $messages as $key => $text ) {
				if ( empty( $text ) ) continue;
				if ( ! is_numeric( $key ) ) {
					echo "$key: $text\n";
				} else {
					echo "$text\n";
				}
			}
			echo "\n";
		}
	}

	protected function show_saving_throws( $name, $effect = '' ) {
		$object = $this->get_object( $name );
		$throws = $object->get_saving_throws( $effect );
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

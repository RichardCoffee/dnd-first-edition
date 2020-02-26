<?php

trait DND_Combat_Treasure_Generate {


	protected function generate_random_result( $table, $roll = false ) {
		$total = array_sum( array_column( $table, 'chance' ) );
		$roll  = ( is_numeric( $roll ) ) ? intval( $roll ) : mt_rand( 1, $total );
		if ( $roll > $total ) $roll = intval( $roll / ( ( ( $total > 100 ) ? 1000 : 100 ) / $total ) );
		return $this->get_table_result( $table, $roll );
	}

	protected function get_table_total( $table ) {
		$total = 0;
		foreach( $table as $entry ) {
			if ( is_array( $entry ) ) {
				$total += $entry['chance'];
			}
		}
		return $total;
	}

	protected function get_table_result( $table, $roll ) {
		foreach( $table as $entry ) {
			if ( is_array( $entry ) ) {
				$roll -= $entry['chance'];
				if ( $roll < 1 ) {
					return $entry;
				}
			}
		}
		return array();
	}


	/**  Potion functions  **/

	protected function generate_fake_potions() {
		$table = $this->get_potions_table();
		return $this->generate_random_result( $table );
	}

	protected function generate_random_scrolls( $scroll, $type ) {
		$max = 0;
		$scr = array();
		$types = $this->get_scrolls_type_table();
		$list  = array_column( $types, 'class', 'type' );
		$base  = $list[ $type ];
		$zero  = ( in_array( $type, [ 'I', 'M' ] ) ) ? 'Cantrip' : 'Orison';
		list( $number, $start, $end ) = ( array_key_exists( 'm', $scroll ) && ( $type === 'M' ) ) ? $scroll['m'] : $scroll['cdi'];
		$obj = new $base;
		$ord = DND_Enum_Ordinal::get_instance( [ $zero ] );
		for( $i = 1; $i <= $number; $i++ ) {
			$level = mt_rand( $start, $end );
			$max   = max( $max, $level );
			$rank  = $ord->get( $level );
			$spell = $obj->generate_random_spell( $level );
			if ( $spell ) $scr[] = array( 'rank' => $rank, 'spell' => $spell );
		}
		usort(
			$scr,
			function( $a, $b ) use ( $ord ) {
				$cmp = $ord->compare( $a['rank'], $b['rank'] );
				if ( $cmp === 0 ) $cmp = strcmp( $a['spell'], $b['spell'] );
				return $cmp;
			}
		);
		$scroll['class']  = $base;
		$scroll['data']   = $scr;
		$scroll['prefix'].= "{$type}{$max}";
		$scroll['zero']   = $zero;
		return $scroll;
	}

	protected function generate_random_charge( $base, $delta ) {
		return $base - ( mt_rand( 1, $delta ) - 1 );
	}

	protected function generate_shield_size( $item, $roll = 0 ) {
		$size  = $this->generate_random_result( $this->get_shields_size_table() );
		$item['size'] = $size['size'];
		if ( strlen( $item['prefix'] ) === 2 ) {
			$item['prefix'] .= substr( $size['size'], 0, 1 ) . $item['bonus'];
		}
		return $item;
	}

	protected function generate_armor_size( $item, $roll = 0 ) {
		$table = $this->get_armor_size_table();
		$size  = $this->generate_random_result( $table, $roll );
		$item['size'] = $size['size'];
		return $item;
	}

	protected function generate_swords_type( $item ) {
		if ( ! ( strpos( $item['text'], 'Dragon Slayer' ) === false ) ) {
			$item['target'] = $this->generate_random_result( $this->get_dragon_type_table() )['text'];
		}
		if ( ! array_key_exists( 'type', $item ) ) {
			$type = $this->generate_random_result( $this->get_swords_type_table() );
			$item['type'] = array( "Sword,{$type['text']}" );
			$item['prefix'] = "S{$type['pre']}";
		}
		if ( ! ( strpos( $item['text'], 'Cursed' ) === false ) ) $item['type'][] = 'Cursed';
		return $item;
	}

	protected function merge_swords_info( $item ) {
		if ( array_key_exists( 'post', $item ) ) {
			$table = $this->get_swords_info_table();
			if ( array_key_exists( $item['post'], $table ) ) {
				$item = array_merge( $item, $table[ $item['post'] ] );
			}
		}
		return $item;
	}

	public function generate_special_weapon( $item, $roll = 0 ) {
		if ( $roll === 0 ) $roll = mt_rand( 1, 100 );
		$powers = 'none';
		if ( $roll > 75 ) {
			$powers = array(
				'align'   => $this->generate_weapon_alignment( $item ),
				'ego'     => ( $item['ego'] > 0 ) ? $item['ego'] : $item['bonus'] * 2,
				'int'     => 12,
				'primary' => array(),
				'extra'   => array(),
				'comm'    => 'semi-empathy',
				'lang'    => 0,
			);
			$powers = $this->generate_weapon_primary_ability( $powers );
		}
		if ( $roll > 83 ) {
			$powers['int']  = 13;
			$powers['comm'] = 'empathy';
			$powers = $this->generate_weapon_primary_ability( $powers );
		}
		if ( $roll > 89 ) {
			$powers['int']  = 14;
			$powers['comm'] = 'speech';
			$powers = $this->generate_weapon_languages( $powers );
		}
		if ( $roll > 94 ) {
			$powers['int'] = 15;
			$powers = $this->generate_weapon_primary_ability( $powers );
		}
		if ( $roll > 97 ) {
			$powers['int'] = 16;
			$powers['primary'][] = 'Read languages/maps of any non-magical sort.';
			$powers['ego']++;
		}
		if ( $roll > 99 ) {
			$powers['comm'] = 'speech and telepathy';
			$powers['ego'] += 2;
			$powers['primary'][] = 'Reads magical writings.';
			$powers['ego'] += 2;
			$powers = $this->generate_weapon_extra_ability( $powers );
		}
		$item['powers'] = $powers;
		return $item;
	}

	protected function generate_weapon_alignment( $item, $roll = false ) {
		$restrict = ( array_key_exists( 'restrict', $item ) ) ? substr( $item['restrict'], 1 ) : 'any';
		$table = $this->get_swords_alignment_table();
		$align = $this->generate_random_result( $table, $roll );
		if ( $restrict === 'any' ) return $align['align'];
		if ( strpos( $align['align'], $restrict ) === false ) {
			return $this->generate_weapon_alignment( $item );
		}
		return $align['align'];
	}

	protected function generate_weapon_primary_ability( $powers, $roll = false ) {
		$roll = ( is_numeric( $roll ) ) ? intval( $roll ) : mt_rand( 1, 100 );
		if ( $roll < 93 ) {
			$powers = $this->generate_single_primary_ability( $powers, $roll );
		} else if ( $roll > 92 ) {
			$powers = $this->generate_single_primary_ability( $powers );
			$powers = $this->generate_single_primary_ability( $powers );
			if ( $roll === 100 ) $powers = $this->generate_weapon_extra_ability( $powers );
		}
		return $powers;
	}

	protected function generate_single_primary_ability( $powers, $roll = false ) {
		$roll = ( is_numeric( $roll ) ) ? intval( $roll ) : mt_rand( 1, 100 );
		$table = $this->get_swords_primary_ability_table();
		$ability = $this->generate_random_result( $table, $roll );
		foreach( $powers['primary'] as $key => $primary ) {
			if ( $primary['ability'] === $ability['ability'] ) {
				$powers['primary'][$key]['radius'] += $ability['radius'];
				$ability['ability'] = 'Found';
			}
		}
		if ( ! ( $ability['ability'] === 'Found' ) ) {
			$powers['primary'][] = $ability;
		}
		$powers['ego']++;
		return $powers;
	}

	protected function generate_weapon_languages( $powers, $roll = false ) {
		$roll = ( is_numeric( $roll ) ) ? intval( $roll ) : mt_rand( 1, 100 );
		$table = $this->get_swords_languages_table();
		$langs = $this->generate_random_result( $table, $roll );
		$powers['langs'] = intval( $langs['text'] );
		if ( $roll === 100 ) {
			do { $lang1 = $this->generate_random_result( $table ); } while( $lang1['chance'] === 1 );
			do { $lang2 = $this->generate_random_result( $table ); } while( $lang2['chance'] === 1 );
			$powers['langs'] = max( 6, intval( $lang1['text'] ) + intval( $lang2['text'] ) );
		}
		$powers['ego'] += ceil( $powers['langs'] * 0.5 );
		return $powers;
	}

	protected function generate_weapon_extra_ability( $powers, $roll = false ) {
		$roll = ( is_numeric( $roll ) ) ? intval( $roll ) : mt_rand( 1, 100 );
		if ( $roll < 95 ) {
			$powers = $this->generate_single_extra_ability( $powers, $roll );
		} else if ( $roll > 94 ) {
			$powers = $this->generate_single_extra_ability( $powers );
			$powers = $this->generate_single_extra_ability( $powers );
			if ( $roll === 100 ) $powers = $this->generate_weapon_special_purpose( $powers );
		}
		return $powers;
	}

	protected function generate_single_extra_ability( $powers, $roll = 0 ) {
		$table = $this->get_swords_extra_ability_table();
		$powers['extra'][] = $this->generate_random_result( $table, $roll );
		$powers['ego'] += 2;
		return $powers;
	}

	protected function generate_weapon_special_purpose( $powers, $roll1 = false, $roll2 = false ) {
		$roll1 = ( is_numeric( $roll1 ) ) ? intval( $roll1 ) : mt_rand( 1, 100 );
		$roll2 = ( is_numeric( $roll2 ) ) ? intval( $roll2 ) : mt_rand( 1, 100 );
		$purpose = $this->generate_random_result( $this->get_swords_special_purpose_table(), $roll1 );
		$power   = $this->generate_random_result( $this->get_swords_special_powers_table(),  $roll2 );
		$powers['purpose'] = array(
			'purpose' => $purpose['text'],
			'power'   => $power['text'],
		);
		$powers['ego'] += 5;
		return $powers;
	}

	protected function merge_weapons_info( $item ) {
		$table = $this->get_weapons_info_table();
		if ( array_key_exists( $item['prefix'], $table ) ) {
			$item = array_merge( $item, $table[ $item['prefix'] ] );
		}
		return $item;
	}

	protected function generate_bow_type( $item, $roll = false, $rtwo = false ) {
		if ( substr( $item['text'], 0, 3 ) === 'Bow' ) {
			$roll = ( is_numeric( $roll ) ) ? intval( $roll ) : mt_rand( 1, 100 );
			$type = ( $roll > 60 ) ? 'Short' : 'Long';
			$item['prefix'] .= substr( $type, 0, 1 );
			$item['text'] = "$type {$item['text']}";
			$item['type'] = array( "Bow,$type" );
		} else if ( substr( $item['text'], 0, 8 ) === 'Crossbow' ) {
			$roll = ( is_numeric( $roll ) ) ? intval( $roll ) : mt_rand( 1, 100 );
			$type = ( $roll > 50 ) ? 'Hand'  : 'Heavy';
			$rtwo = ( is_numeric( $rtwo ) ) ? intval( $rtwo ) : mt_rand( 1, 100 );
			$type = ( $rtwo > 65 ) ? 'Light' : $type;
			$item['prefix'] .= ( $type === 'Light' ) ? 'L' : ( ( $type === 'Heavy' ) ? 'H' : 'A' );
			$item['text'] = "$type {$item['text']}";
			$item['type'] = array( "Crossbow,$type" ) ;
		}
		return $item;
	}

	protected function generate_flail_type( $item, $roll = false ) {
		$roll = ( is_numeric( $roll ) ) ? intval( $roll ) : mt_rand( 1, 100 );
		$type = ( $roll > 65 ) ? 'Horse' : 'Foot';
		$item['type'][0] .= ",$type";
		$item['prefix']  .= substr( $type, 0, 1 );
		return $item;
	}

	protected function generate_hammer_type( $item, $roll = false ) {
		$item['type'] = array( 'Hammer', 'Hammer,Thrown' );
		if ( strlen( $item['prefix'] < 4 ) ) {
			$roll = ( is_numeric( $roll ) ) ? intval( $roll ) : mt_rand( 1, 100 );
			if ( $roll > 75 ) {
				$item['type'] = array( 'Hammer,Lucern' );
				$item['text'] = "Lucern {$item['text']}";
				$item['prefix'].= 'L';
			} else {
				$item['prefix'].= 'M';
			}
		}
		return $item;
	}

	protected function generate_hornblade_type( $item, $roll = false ) {
		$item = $this->generate_random_weapons_pluses( $item );
		switch( $item['bonus'] ) {
			case 1:
				$item['type'] = array( 'Knife', 'Knife,Thrown' );
				break;
			case 2:
			case 3:
				$item['type'] = array( 'Dagger', 'Dagger,Thrown', 'Dagger,Off-Hand' );
				break;
			case 4:
			case 5:
				$item['type'] = array( 'Scimitar' );
			default:
		}
		return $item;
	}

	protected function generate_lance_type( $item, $roll = false ) {
		$roll = ( is_numeric( $roll ) ) ? intval( $roll ) : mt_rand( 1, 100 );
		$type = ( $roll < 51 ) ? 'Medium' : ( ( $roll < 80 ) ? 'Light' : 'Heavy' );
		$item['prefix'] .= substr( $type, 0, 1 );
		$item['text'] = "$type {$item['text']}";
		$item['type'] = array( "Lance,$type" );
		return $item;
	}

	protected function generate_random_weapons_pluses( $item, $roll = false ) {
		$table = $this->get_weapons_adjustment_table();
		return $this->generate_random_pluses( $table, $item, $roll, '*' );
	}

	protected function generate_ammo_quantity( $item ) {
		if ( array_key_exists( 'q', $item ) ) {
			$item['quan'] = $item['q'][2];
			for( $i = 1; $i <= $item['q'][0]; $i++ ) {
				$item['quan'] += mt_rand( 1, $item['q'][1] );
			}
		}
		return $item;
	}

	protected function generate_random_missile_pluses( $item, $roll = false ) {
		$table = $this->get_missile_adjustment_table();
		return $this->generate_random_pluses( $table, $item, $roll, '**' );
	}

	protected function generate_random_pluses( $table, $item, $roll, $search ) {
		$plus  = $this->generate_random_result( $table, $roll );
		$item['bonus'] = $plus['plus'];
		$item['xp'] = intval( $item['xp'] * $plus['gp'] );
		$item['gp'] = intval( $item['gp'] * $plus['gp'] );
		$string  = ( $plus['plus'] > 0 ) ? ' +%d' : ' %d, Cursed';
		$replace = sprintf( $string, $plus['plus'] );
		$item['text'] = str_replace( $search, $replace, $item['text'] );
		if ( $item['bonus'] < 0 ) $item['type'][] = 'Cursed';
		switch( strlen( $item['prefix'] ) ) {
			case 2:
				$item['prefix'] .= ( $item['bonus'] === -1 ) ? 'C1' : "P{$item['bonus']}";
				break;
			case 3:
				$item['prefix'] .= ( $item['bonus'] === -1 ) ? 'C' : $item['bonus'];
				break;
			case 1:
			case 4:
			default:
		}
		return $item;
	}

	public function generate_random_symbol() {
		static $symbols = array();
		if ( empty( $symbols ) ) {
			$base = [ 'potions', 'swords' ];
#			$base = array_column( $this->get_items_table(), 'sub' );
			$base[] = 'swords_info'; #array_merge( $base, [ 'swords_info' ] );
			foreach( $base as $sub ) {
				$table = $this->get_sub_table( $sub );
				foreach( $table as $item ) {
					if ( is_string( $item ) ) continue;
					if ( array_key_exists( 'symbol', $item ) ) {
						$symbols[] = array( 'chance' => 1, 'symbol' => $item['symbol'] );
					}
				}
			}
		}
		return $this->generate_random_result( $symbols )['symbol'];
	}


}

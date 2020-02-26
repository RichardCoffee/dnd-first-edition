<?php

class DND_Combat_Treasure_Treasure {


	use DND_Combat_Treasure_Generate;
	use DND_Combat_Treasure_Tables;
	use DND_Combat_Treasure_Accouterments;


	public function get_sub_table_name( $roll = 0 ) {
		$roll = intval( $roll, 10 );
		$next = '';
		if ( $roll ) {
			$main = $this->get_items_table();
			$result = $this->get_table_result( $main, $roll );
			if ( $result ) {
				$next = $result['sub'];
			}
		}
		return $next;
	}

	/**  Command Line  **/

	public function show_possible_monster_treasure( $enemy ) {
		if ( is_array( $enemy ) ) {
			$possible = $this->get_combined_monster_treasure( $enemy );
			$monster  = array_pop( $enemy );
		} else if ( is_object( $enemy ) ) {
			$monster  = $enemy;
			$possible = $monster->treasure;
		}
		$treasure = $monster->get_treasure( $possible );
		echo "\n";
		if ( is_array( $treasure ) ) {
			foreach( $treasure as $item ) {
				echo "$item\n";
			}
		} else {
			echo "$treasure\n";
		}
		echo "\n";
	}

	private function get_combined_monster_treasure( $group ) {
		$types = array();
		foreach( $group as $member ) {
			$treas = $member->treasure;
			if ( $treas === 'Nil' ) continue;
			$check = explode( ',', $treas );
			foreach( $check as $category ) {
				if ( ! in_array( $category, $types ) ) $types[] = $category;
			}
		}
		return implode( ',', $types );
	}

	public function show_treasure_table( $table = 'items' ) {
		if ( ! $table ) return;
		$table = strtolower( $table );
		$func  = $this->get_sub_table_string( $table );
		$items = $this->$func();
		$forms = ( in_array( $table , [ 'potions', 'rings', 'armor_shields' ] ) ) ? [ '%03u', '  %1$03u  ' ] : [ '%02u', '  %1$02u ' ];
		$perc  = 1;
		foreach( $items as $key => $item ) {
			if ( ! is_array( $item ) ) {
				if ( $key === 'title' ) echo "\n";
				echo "\t$item\n";
				continue;
			}
			$rg_end  = $perc + $item['chance'] - 1;
			$format  = ( $perc === $rg_end ) ? $forms[1] : "{$forms[0]}-{$forms[0]}";
			$format .= ' : %3$-30s';
			$line = sprintf( $format, $perc, $rg_end, $item['text'] );
			echo "  $line\n";
			$perc += $item['chance'];
		}
		echo "\n";
	}

	public function show_treasure_item( $table, $roll, $type = '' ) {
		$func = $this->get_sub_table_string( $table );
		$sec  = $this->$func();
		$roll = intval( $roll );
		$pick = '';
		$stop = false;
		foreach( $sec as $key => $item ) {
			if ( ! is_array( $item ) ) {
				if ( $key === 'title' ) echo "\n";
				echo "\t$item\n\n";
				continue;
			}
			$roll -= $item['chance'];
			if ( $roll < 1 ) {
				if ( ! array_key_exists( 'sub', $item ) ) $item['sub'] = $table;
				$item = $this->convert_item_to_object( $item, $type );
				$this->show_item( $item );
				$roll = 1000000;
				switch( $table ) {
					case 'potions':
						if ( array_key_exists( 'fake', $item ) ) {
							echo "\tmasquerading as:\n\n";
							$this->show_item( $item['fake'] );
						}
					case 'scrolls':
						if ( ! empty( $item['spells'] ) ) {
							echo "\t{$item['class']}\n";
							foreach( $item['spells'] as $spell ) {
								echo "\t{$spell['rank']}\t{$spell['spell']}\n";
							}
						}
						break;
					case 'rods':
					case 'staves':
					case 'wands':
						echo "\tCharges: {$item['charges']}\n";
						$stop = true;
						break;
					case 'swords':
					case 'weapons':
						print_r( $item );
						break;
					default:
				}
				if ( $stop ) break;
			}
		}
		echo "\n";
	}

	protected function show_item( $item ) {
		$xp = ( array_key_exists( 'xp',   $item ) ) ? "\t{$item['xp']} xp" : '';
		$gp = ( array_key_exists( 'gp',   $item ) ) ? "\t{$item['gp']} gp" : '';
		$lk = ( array_key_exists( 'link', $item ) ) ? "\tlink: {$item['link']}" : '';
		echo "\t{$item['text']}{$xp}{$gp}{$lk}\n\n";
	}

	public function get_sub_table( $sub ) {
		$name = $this->get_sub_table_string( $sub );
		if ( method_exists( $this, $name ) ) return $this->$name();
		return array();
	}

	protected function get_sub_table_string( $sub ) {
		return "get_{$sub}_table";
	}

	protected function convert_item_to_object( $item, $data = false ) {
		switch( $item['sub'] ) {
			case 'potions':
				$base = 'DND_Combat_Treasure_Items_Potion';
				if ( $item['xp'] === '~' ) {
					do {
						$item['fake'] = $this->generate_fake_potions();
					} while( $item['fake']['xp'] === '~' );
				} else if ( strlen( $item['prefix'] ) === 3 ) {
					$control = substr( $item['text'], 0, 6 );
					if ( $control === 'Dragon' ) {
						$type = $this->generate_random_result( $this->get_dragon_type_table() );
					} else if ( $control === 'Giant ' ) {
						$type = $this->generate_random_result( $this->get_giant_type_table() );
					} else if ( $control === 'Human ' ) {
						$type = $this->generate_random_result( $this->get_human_type_table() );
					} else if ( $control === 'Undead' ) {
						$type = $this->generate_random_result( $this->get_undead_type_table() );
					} else if ( strpos( $item['text'], 'Elemental Invulnerability' ) ) {
						$type = $this->generate_random_result( $this->get_elemental_type_table() );
					}
					$item['effect']  = $type['text'];
					$item['prefix'] .= $type['postfix'];
					$item['text']   .= ": {$type['text']}";
				}
				break;
			case 'scrolls':
				$base = 'DND_Combat_Treasure_Items_Scroll';
				if ( strlen( $item['prefix'] ) === 2 ) {
					if ( $data && ( in_array( $data, [ 'C', 'D', 'I', 'M' ] ) ) ) {
						$class = $data;
					} else {
						$type  = $this->generate_random_result( $this->get_scrolls_type_table() );
						$class = $type['type'];
					}
					$item = $this->generate_random_scrolls( $item, $class );
				} else if ( $item['prefix'] === 'SCUR' ) {
					$item['effect'] = $this->generate_random_result( $this->get_scrolls_curse_table() );
				}
				break;
			case 'rings':
				$base = 'DND_Combat_Treasure_Items_Ring';
				if ( $item['prefix'] === 'RSS' ) $item['prefix'] .= mt_rand( 1, 4 ) + 2;
				if ( $item['prefix'] === 'RWM' ) $item['prefix'] .= mt_rand( 1, 4 ) + mt_rand( 1, 4 );
				break;
			case 'rods':
				$base = 'DND_Combat_Treasure_Items_Rod';
				$item['charges'] = $this->generate_random_charge( 50, 10 );
				break;
			case 'staves':
				$base = 'DND_Combat_Treasure_Items_Staff';
				$item['charges'] = $this->generate_random_charge( 25, 6 );
				break;
			case 'wands':
				$base = 'DND_Combat_Treasure_Items_Wand';
				$item['charges'] = $this->generate_random_charge( 100, 20 );
				break;
			case 'shields':
			case 'armor_shields':
				$base = 'DND_Combat_Treasure_Items_Shield';
				if ( strpos( $item['text'], 'Shield' ) === 0 ) {
					$item = $this->generate_shield_size( $item );
					$item['sub']  = 'shields';
					$item['type'] = array( $item['size'] );
				}
			case 'armor':
				if ( strpos( $item['text'], 'Shield' ) === false ) {
					$base = 'DND_Combat_Treasure_Items_Armor';
					$item = $this->generate_armor_size( $item );
					$item['sub']  = 'armor';
					$item['type'] = array( $item['key'] );
					unset( $item['key'] );
					$item['filters'] = $this->retrieve_item_filters( $item, $item['prefix'] );
				}
				break;
			case 'swords':
				$base = 'DND_Combat_Treasure_Items_Weapon';
				$item = $this->merge_swords_info( $item );
				$item = $this->generate_swords_type( $item );
				$item = $this->generate_special_weapon( $item );
				$item['filters'] = $this->retrieve_item_filters( $item, $item['post'] );
				if ( in_array( $item['post'], [ 'C1', 'C2', 'CB' ] ) ) $item['symbol'] = $this->generate_random_symbol();
				break;
			case 'weapons':
				$base = 'DND_Combat_Treasure_Items_Weapon';
				$item = $this->merge_weapons_info( $item );
				if ( in_array( $item['prefix'], [ 'AR', 'ARD', 'ARS3', 'BS', 'BT' ] ) ) {
					$base = 'DND_Combat_Treasure_Items_Ammo';
					$item = $this->generate_ammo_quantity( $item );
				}
				$check = substr( $item['text'], 0, 4 );
				if ( in_array( $check, [ 'Bow*', 'Cros' ] ) ) {
					$item = $this->generate_bow_type( $item );
				} else if ( in_array( $check, [ 'Flai', 'Mace', 'Mili' ] ) ) {
					$item = $this->generate_flail_type( $item );
				} else if ( $check === 'Hamm' ) {
					$item = $this->generate_hammer_type( $item );
				} else if ( $check === 'Horn' ) {
					$item = $this->generate_hornblade_type( $item );
				} else if ( $check === 'Lanc' ) {
					$item = $this->generate_lance_type( $item );
				}
				if ( $item['bonus'] === 0 ) {
					list( $spec, $tab ) = explode( ':', $item['ex'] );
					if ( $tab == 1 ) {
						$item = $this->generate_random_weapons_pluses( $item );
					} else if ( $tab == 2 ) {
						$item = $this->generate_random_missile_pluses( $item );
					}
				}
				if ( array_key_exists( 'ego', $item ) ) $item = $this->generate_special_weapon( $item );
				$item['filters'] = $this->retrieve_item_filters( $item, $item['prefix'] );
				break;
			default:
				$base = 'DND_Combat_Treasure_Items_Misc';
		}
		if ( ! array_key_exists( 'name', $item ) ) $item['name'] = $item['text'];
		$gear = new $base( $item );
		return $gear;
	}


}

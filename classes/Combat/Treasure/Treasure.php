<?php

class DND_Combat_Treasure_Treasure {


	use DND_Combat_Treasure_Generate;
	use DND_Combat_Treasure_Tables;
	use DND_Monster_Trait_Accouterments;


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

	public function show_possible_monster_treasure( $enemy, $possible = '' ) {
		$monster = null;
		if ( is_array( $enemy ) ) {
			$monster = array_pop( $enemy );
		} else if ( is_object( $enemy ) ) {
			$monster = $enemy;
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

	public function show_treasure_table( $table = 'items' ) {
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
				echo "\t$item\n";
				continue;
			}
			$roll -= $item['chance'];
			if ( $roll < 1 ) {
				$xp = ( array_key_exists( 'xp',   $item ) ) ? "\t{$item['xp']} xp" : '';
				$gp = ( array_key_exists( 'gp',   $item ) ) ? "\t{$item['gp']} gp" : '';
				$lk = ( array_key_exists( 'link', $item ) ) ? "\tlink: {$item['link']}" : '';
				echo "\t{$item['text']}{$xp}{$gp}{$lk}\n\n";
				$roll = 1000000;
				switch( $table ) {
					case 'potions':
						if ( $item['xp'] === '~' ) {
							$fake = $this->generate_fake_potions();
echo "masquerading as:\n";
print_r($fake);
						}
					case 'scrolls':
						if ( $type && ( in_array( $type, [ 'C', 'D', 'I', 'M' ] ) ) ) {
							$scroll = $this->generate_random_scrolls( $item, $type );
							if ( ! empty( $scroll ) ) {
								foreach( $scroll as $entry ) {
									echo "\t{$entry['rank']}\t{$entry['spell']}\n";
								}
							}
						}
						break;
					case 'rods':
						$charge = $this->generate_random_charge( 50, 10 );
						echo "\tCharges: $charge\n";
						$stop = true;
						break;
					case 'staves':
						$charge = $this->generate_random_charge( 25, 6 );
						echo "\tCharges: $charge\n";
						$stop = true;
						break;
					case 'wands':
						$charge = $this->generate_random_charge( 100, 20 );
						echo "\tCharges: $charge\n";
						$stop = true;
						break;
					case 'weapons':
						break;
					default:
				}
				if ( $stop ) break;
			}
		}
		echo "\n";
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

	protected function get_table_total( $table ) {
		$total = 0;
		foreach( $table as $entry ) {
			if ( is_array( $entry ) ) {
				$total += $entry['chance'];
			}
		}
		return $total;
	}

	protected function get_sub_table_string( $sub ) {
		return "get_{$sub}_table";
	}

	protected function check_for_specials( $item ) {
		switch( $item['type'] ) {
			case 'potions':
				if ( $item['xp'] === '~' ) $item['fake'] = $this->generate_fake_potions();
				if ( $item['text'] === 'Oil of Elemental Invulnerability' ) {
					$table   = $this->get_elemental_type_table();
					$element = $this->generate_random_result( $table );
					$item['element'] = $element['element'];
				}
				break;
			case 'scrolls':
				$table  = $this->get_scrolls_type_table();
				$type   = $this->generate_random_result( $table );
				$scroll = $this->generate_random_scrolls( $item, $type['type'] );
				$item['spells'] = $scroll;
				break;
			case 'armor_shields':
				$item['type'] = 'shields';
				if ( strpos( $item['text'], 'Shield, large' ) === false ) {
					if ( strpos( $item['text'], 'Shield' ) === 0 ) {
						$item = $this->generate_shield_size( $item );
					} else {
						$item = $this->generate_armor_size( $item );
						$item['type'] = 'armor';
					}
				}
				break;
			case 'swords':
				$item = $this->generate_swords_type( $item );
				$item = $this->generate_special_swords( $item );
				break;
			case 'weapons':
				list( $spec, $tab ) = explode( ':', $item['ex'] );
				if ( $tab == 1 ) {
					$item = $this->generate_random_weapons_pluses( $item );
					if ( substr( $item['text'], 0, 3 ) === 'Bow' ) {
						$prefix = ( mt_rand( 1, 100 ) > 60 ) ? 'Short ' : 'Long ';
						$item['text'] = $prefix . $item['text'];
					}
					if ( substr( $item['text'], 0, 8 ) === 'Crossbow' ) {
						$prefix = ( mt_rand( 1, 100 ) > 50 ) ? 'Hand '  : 'Heavy ';
						$prefix = ( mt_rand( 1, 100 ) > 65 ) ? 'Light ' : $prefix;
						$item['text'] = $prefix . $item['text'];
					}
				} else if ( $tab == 2 ) {
					$item = $this->generate_random_missile_pluses( $item );
				}
				if ( $spec === 'Y' ) $item = $this->generate_special_swords( $item );
				break;
			default:
		}
		return $item;
	}


}

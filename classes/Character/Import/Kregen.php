<?php

trait DND_Character_Import_Kregen {


	private $import_task = 'import';


	public function import_kregen_csv( $file ) {
		$contents = file ( $file, FILE_IGNORE_NEW_LINES );
		if ( ! ( $contents === false ) ) {
			$this->set_import_task();
			foreach( $contents as $line ) {
#echo "$line\n";
				$parsed = array_values( array_filter( explode( ',', $line ) ) );
				if ( $parsed && ( count( $parsed ) > 1 ) ) {
					$this->parse_csv_line( $parsed );
				}
			}
			$this->initialize_character();
		}
	}

	public function set_import_task( $task = 'import' ) {
		$this->import_task = $task;
	}

	public function parse_csv_line( $line ) {
#print_r ( $line );
		switch( $line[0] ) {
			case 'HP':
				$this->current_hp = $line[1];
				break;
			case 'AC':
				$index = array_search( 'XP', $line );
				$this->experience = $line[ ++$index ];
				if ( ( $this->level === 0 ) && ( $this->experience > 0 ) ) {
					$this->level = $this->calculate_level( $this->experience );
				}
				break;
			case 'Str':
				$this->stats['str'] = $line[1];
				break;
			case 'Int':
				$this->stats['int'] = $line[1];
				break;
			case 'Wis':
				$this->stats['wis'] = $line[1];
				break;
			case 'Dex':
				$this->stats['dex'] = $line[1];
				break;
			case 'Con':
				$this->stats['con'] = $line[1];
				break;
			case 'Chr':
				$this->stats['chr'] = $line[1];
				break;
			case 'Armor':
				if ( ! ( $this->import_task === 'import' ) ) break;
				$armor = $this->parse_name( $line[1] );
				$this->armor['armor'] = ( $armor === '(armor)' ) ? 'none' : $armor;
				if ( ! isset( $line[2] ) ) break;
				$test = intval( $line[2] );
				if ( $test > 0 ) {
					$this->armor['bonus'] = $test;
					$index = 3;
				} else {
					$index = 2;
				}
				if ( $line[ $index ] === '(shield)' ) {
				} else {
					$this->shield['type'] = $line[ $index ];
					$test = intval( $line[ ++$index ] );
					if ( $test < 6 ) {
						$this->shield['bonus'] = $test;
					}
				}
				break;
			case 'Needed':
				break;
			case 'WP':
				break;
			case 'Non-Proficiency':
				$this->import_task = 'spells';
				break;
			default:
				if ( in_array( 'Race', $line ) ) {
					$index = array_search( 'Race', $line );
					$this->name = $this->parse_name( $line[0] );
					$this->race = $line[ ++$index ];
				} else if ( in_array( 'Base', $line ) && in_array( 'Base', [ $line[3], $line[4] ] ) ) {
					$this->import_task = 'weapons';
				} else if ( $this->import_task === 'weapons' ) {
					$bonus = 0;
					$index = 0;
					if ( intval( $line[0] ) > 0 ) {
						$bonus = intval( $line[0] );
						$index = 1;
					}
					if ( ( strpos( $line[ $index ], '"' ) === 0 ) && ( substr( $line[ $index + 1 ], -1 ) === '"' ) ) {
						$weapon = substr( $line[ $index ], 1 ) . ',' . substr( $line[ $index + 1 ], 0, -1 );
					} else {
						$weapon = $line[ $index ];
					}
					if ( $this->weapons_check( $weapon ) ) {
						$this->set_kregen_weapon_skill( $weapon, $line, $bonus );
						$this->check_current_weapon( $weapon );
					}
				} else if ( in_array( $this->import_task, [ 'cleric', 'magic', 'spells' ] ) ) {
#print_r ( $line );
					if ( method_exists( $this, 'locate_magic_spell' ) ) {
						foreach( $line as $item ) {
							if ( intval( $item ) > 0 ) {
								continue;
							}
							$name = $this->parse_name( $item );
							if ( ( $pos = strpos( $name, ' PH' ) ) > 0 ) {
								$name = substr( $name, 0, $pos );
							}
							if ( ( $pos = strpos( $name, ' UA' ) ) > 0 ) {
								$name = substr( $name, 0, $pos );
							}
#echo __CLASS__."  spell: $name\n";
							$check = $this->locate_magic_spell( $name );
							if ( ! empty( $check['page'] ) ) {
								$this->add_spell( $check );
							}
						}
					}
				} else {
				} //*/
		}
	}

	private function parse_name( $name ) {
		if ( substr( $name, 0, 1 ) === '"' ) {
			$name = substr( $name, 1 );
			$name = substr( $name, 0, -1 );
		}
		return $name;
	}

	private function set_kregen_weapon_skill( $weapon, $line, $bonus ) {
		$this->weapons[ $weapon ] = array( 'bonus' => $bonus, 'skill' => 'NP' );
		if ( in_array( '*', $line, true ) ) {
			$keys = array_keys( $line, '*', true );
			switch( count( $keys ) ) {
				case 1:
					$this->weapons[ $weapon ]['skill'] = 'PF';
					break;
				case 2:
					$this->weapons[ $weapon ]['skill'] = 'SP';
					break;
				case 3:
					$this->weapons[ $weapon ]['skill'] = 'DS';
					break;
				default:
			}
		} else if ( $weapon === 'Spell' ) {
			$this->weapons[ $weapon ]['skill'] = 'PF';
		}
	}

	private function check_current_weapon( $weapon ) {
		if ( $this->weapon['current'] === 'none' ) {
			$this->set_current_weapon( $weapon );
		}
	}


}

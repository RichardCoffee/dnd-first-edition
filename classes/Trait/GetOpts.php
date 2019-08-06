<?php

trait DND_Trait_GetOpts {


	protected $opts = array();


	protected function getopts() {
		$this->opts = getopt( 'hr:st::', [ 'add:', 'att:', 'help', 'hit:', 'hold:', 'mi:', 'pre:', 'st:' ] );
		if ( $this->opts ) {
			foreach( $this->opts as $key => $option ) {
				switch( $key ) {
					case 'h':
					case 'help':
						$this->show_help();
						exit;
						break;
					case 'r':
						$this->range = intval( $this->opts['r'], 10 );
						break;
					case 's':
						$this->increment_segment();
						break;
					case 't':
						dnd1e_show_possible_monster_treasure( $this->enemy, $this->opts['t'] );
						exit;
						break;
					case 'add':
						$this->add_to_party( $this->opts['add'] );
						break;
					case 'att':
						$this->remove_holding( $this->opts['att'] );
						break;
					case 'hit':
						$this->record_damage();
						break;
					case 'hold':
						$this->add_holding( $this->opts['hold'] );
						break;
					case 'mi':
						$this->monster_initiative();
						break;
					case 'pre':
						$this->pre_cast_spell();
						break;
					case 'st':
						$this->show_saving_throws( $this->opts['st'] );
						break;
					default:
				}
			}
		}
	}

	protected function show_help() {
		echo "

	php command_line.php [OPTIONS] [NAME [WEAPON|SPELL#]]


	-h, --help      Display this help screen.

	-rn             Control missile weapon range, where n = range in feet.

	-s              Increment the combat segment.

	-t              Show possible monster treasure, if any.

	--add=name      Add a character to the party.  The csv file must exist.  Will overwrite a character already in the party.

	--hold=name     Place a character's attack on hold.  Indicate the monster is holding it's attack by using a name value of 'Monster'.

	--att=name      Remove character from hold list, because the character is attacking on this segment.

	--hit=name:#    Use to record damage to a character, format is <name>:<damage>.  Use a negative number to indicate healing.
	                For monsters, the format is M:<#>:<damage>, where 'M' is the letter M, and '#' is the number of the monster.

	--mi=number     Set the monster's initiative.

	--pre=name:#    Use this when a character casts a spell before combat, where '#' indicates the spell's number, from the numbered spell list.

";
	}

	protected function record_damage() {
		$sitrep = explode( ':', $this->opts['hit'] );
		$name   = $sitrep[0];
		if ( array_key_exists( $name, $this->party ) ) {
			$damage = intval( $sitrep[1], 10 );
			$this->party_damage( $name, $damage );
		} else if ( count( $sitrep ) === 2 ) {
			$name = $sitrep[0];
			if ( in_array( $name, $this->enemy ) ) {
				$damage = intval( $sitrep[1], 10 );
				$this->enemy_damage( $name, $damage );
			}
		} else if ( count( $sitrep ) === 3 ) {
			$name = sprintf( '%s %u', $name, intval( $sitrep[1], 10 ) - 1 );
			if ( in_array( $name, $this->enemy ) ) {
				$damage = intval( $sitrep[2], 10 );
				$this->enemy_damage( $name, $damage );
			}
		}
	}

	protected function monster_initiative() {
		$sitrep = explode( ':', $this->opts['mi'] );
		if ( count( $sitrep ) === 1 ) {
			$init = intval( $sitrep[0], 10 );
			$this->set_monster_initiative_all( $init );
		} else if ( count( $sitrep ) === 2 ) {
			$name = $sitrep[0];
			if ( in_array( $name, $this->enemy ) ) {
				$init = intval( $sitrep[1], 10 );
				$this->set_monster_initiative( $name, $init );
			}
		} else if ( count( $sitrep ) === 3 ) {
			$name = sprintf( '%s %u', $sitrep[0], intval( $sitrep[1], 10 ) - 1 );
			if ( in_array( $name, $this->enemy ) ) {
				$init = intval( $sitrep[2], 10 );
				$this->set_monster_initiative( $name, $init );
			}
		}
	}

	protected function pre_cast_spell( $unused1 = '', $unused2 = '', $unused3 = '' ) {
		if ( $this->segment < 2 ) {
			$sitrep = explode( ':', $this->opts['pre'] );
			$name   = $sitrep[0];
			if ( array_key_exists( $name, $this->party ) ) {
				$number = intval( $sitrep[1], 10 );
				if ( $number ) {
					$spell = $this->get_numbered_spell( $this->party[ $name ], $number );
					if ( $spell ) {
						$target = ( array_key_exists( 2, $sitrep ) ) ? $sitrep[2] : $name;
						$result = $this->start_casting( $name, $spell['name'], $target );
						if ( $result ) {
							$this->finish_casting( $spell['name'] );
							echo "\n$name has cast {$spell['name']} on $target\n\n";
							exit;
						}
					}
				}
			}
		}
	}

	public function process_arguments( $argv ) {
		if ( $argv && ! $this->opts ) {
			$count = count( $argv );
			if ( $count > 1 ) {
				$name = $argv[1];
				if ( in_array( $name, $this->party ) ) {
					if ( $count > 2 ) {
						if ( intval( $argv[2] ) ) {
							$spell = $this->get_numbered_spell( $this->party[ $name ], $argv[2] );
							if ( $spell ) {
								echo "\n{$argv[1]}\n";
								$target = ( array_key_exists( 3, $argv ) ) ? $argv[3] : $name;
								$this->start_casting( $name, $spell, $target );
							}
						} else {
							if ( ( $count === 4 ) && method_exists( $this->party[ $name ], 'set_dual_weapons' ) ) {
								$this->party[ $name ]->set_dual_weapons( $argv[2], $argv[3] );
							}
							$this->change_weapon( $this->party[ $name ], $argv[2] );
						}
					} else if ( $this->party[ $name ]->weapon['current'] === 'Spell' ) {
						$this->show_possible_spells( $this->party[ $name ] );
						$this->show_possible_weapons( $this->party[ $name ] );
						exit;
					} else {
						$this->show_possible_weapons( $this->party[ $name ] );
						exit;
					}
				}
			}
		}
	}


}

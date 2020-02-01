<?php

trait DND_Combat_GetOpts {


	protected $opts = array();


	protected function get_opts() {
		$opts = [ 'add:', 'att:', 'crit:', 'desc::', 'eff:', 'fumble:', 'enc:', 'help', 'hit:', 'hold:', 'limit:', 'mi:', 'pre:', 'show:', 'spell:', 'st:', 'tar:', 'text' ];
		$this->opts = getopt( 'aghr:stx', $opts );
		$this->process_immediate_opts();
	}

	protected function process_immediate_opts() {
		if ( $this->opts ) {
			foreach( $this->opts as $key => $option ) {
				switch( $key ) {
					case 'h':
					case 'help':
						$this->show_help();
						exit;
					default:
				}
			}
		}
	}

	public function process_opts() {
		if ( $this->opts ) {
			foreach( $this->opts as $key => $option ) {
				switch( $key ) {
					case 'a':
						$this->show_active_effects();
					case 'g':
						break;
					case 'r':
						$this->rng_svd = 0;
						$this->range   = intval( $this->opts['r'] );
						if ( array_key_exists( 'g', $this->opts ) ) {
							$this->rng_svd = $this->range;
						}
						break;
					case 's':
						$this->update_holds();
						break;
					case 't':
						$t = new DND_Combat_Treasure_Treasure;
						$t->show_possible_monster_treasure( $this->enemy, $this->opts['t'] );
						exit;
					case 'x':
						$this->show_experience_value();
						exit;
					case 'add':
						$this->add_to_party( $this->opts['add'] );
						break;
					case 'att':
						$this->remove_holding( $this->opts['att'] );
						break;
					case 'crit':
						$this->parse_critical();
						break;
					case 'desc':
						$this->change_shown_enemy( $this->opts['desc'] );
						break;
					case 'eff':
						$this->parse_effect();
						break;
					case 'fumble':
						$this->fumble_roll_result( $this->opts['fumble'] );
						break;
					case 'enc':
						$this->generate_encounter( $this->opts['enc'] );
						break;
					case 'hit':
						$this->parse_hits();
						break;
					case 'hold':
						$this->parse_holding();
						break;
					case 'limit':
						$this->parse_limit();
						break;
					case 'mi':
						$this->monster_initiative();
						break;
					case 'pre':
						$this->parse_pre_cast();
						break;
					case 'show':
						$this->show_variable();
						exit;
					case 'spell':
						$this->parse_spell();
						break;
					case 'st':
						$this->show_saving_throws( $this->opts['st'] );
						break;
					case 'tar':
						$this->parse_targets();
						break;
					case 'text':
						$this->show_enemy_text();
						exit;
					default:
						echo "Unknown opt '$key'.\n";
						exit;
				}
			}
		}
	}

	protected function show_help() {
		echo "

	php command_line.php [OPTIONS] [NAME [WEAPON|SPELL#]]

	-a              Display all active effects

	-h, --help      Display this help screen.

	-r n            Control missile weapon range, where n = range in feet.  Use -g for sticky range.

	-s              Increment the combat segment.

	-t              Show possible monster treasure, if any.

	-x              Show monster experience point value.

	--add=name      Add a character to the party.  The csv file must exist.  Will overwrite a character already in the party.

	--att=name      Remove a character from the hold list, because the character is attacking on this segment.

	--crit=#[:b|p]  Display the possible result of a critical hit, where # is the number rolled on percentile dice.
	                Second parameter of 'b' or 'p' can be added to indicate blunt or piercing damage, otherwise defaults to slashing damage.

	--desc=#        Display the description information for the selected enemy.

	--fumble=#      Display the possible result of a fumble roll, where # is the number rolled on percentile dice.

	--eff=<origin>:<target>:<effect>  Apply an effect from an attack.

	--enc=<terrain>:<area>  Possibly generate a random encounter where terrain can be 'CC','CW','TC','TW','TSC','TSW' and area can be 'M','H','F','S','P','D'
	                        For water encounters terrain can be 'CF','CS','TF','TS','TSF','TSS' and area can be 'S','D'

	--hit=name:#[:effect]   Use to record damage to a combatant, format is <name>:<damage>.  Use a negative number to indicate healing.
	                        The effect can be used for the type of damage, recognized effects are 'cold', 'fire', and 'electic'.

	--hold=name[:#] Place a combatant's attack on hold.  Adding a segment value indicates that the combatant can attack on the specified segment.

	--limit=#       Limit how many enemies are processed and shown on the screen.

	--mi=number     Set the monster's initiative.

	--pre=name:#    Use this when a character casts a spell before combat, where '#' indicates the spell's number, from the numbered spell list.

	--spell=name:data  Use to pass data to a spell that a combatant is casting.

	--st=name       Show the saving throws for the indicated combatant.

	--tar=#[:#][:#]...  Use to isolate which enemies are shown.  Not inclusive.

	--text          Show the enemy description if available.

";
	}

	protected function monster_initiative() {
		$sitrep = explode( ':', $this->opts['mi'] );
		if ( count( $sitrep ) === 1 ) {
			$init = intval( $sitrep[0], 10 );
			$this->set_monster_initiative_all( $init );
		} else if ( count( $sitrep ) === 2 ) {
			$num  = intval( $sitrep[0], 10 );
			$init = intval( $sitrep[1], 10 );
			$obj  = $this->get_specific_enemy( $num );
			$obj->set_initiative( $init );
		}
	}

	protected function parse_critical() {
		list( $roll, $type ) = array_pad( explode( ':', $this->opts['crit'] ), 2, 's' );
		$this->critical_hit_result( $roll, $type );
	}

	protected function parse_effect() {
		list( $origin, $target, $effect ) = array_pad( explode( ':', $this->opts['eff'] ), 3, '' );
		$this->add_hit_effect( $origin, $target, $effect );
	}

	protected function parse_hits() {
		list( $target, $damage, $effect ) = array_pad( explode( ':', $this->opts['hit'] ), 3, '' );
		$this->object_damage( $target, $damage, $effect );
	}

	protected function parse_holding() {
		list( $target, $time ) = array_pad( explode( ':', $this->opts['hold'] ), 2, 0 );
		$this->add_holding( $target, $time );
	}

	protected function parse_limit() {
		$limit = intval( $this->opts['limit'] );
		$this->set_limit( $limit );
	}

	protected function parse_pre_cast() {
		list( $origin, $spell, $target ) = array_pad( explode( ':', $this->opts['pre'] ), 3, null );
		$this->pre_cast_spell( $origin, $spell, $target );
	}

	protected function parse_spell() {
		list( $caster, $data ) = array_pad( explode( ':', $this->opts['spell'] ), 2, false );
		$this->process_spell_data( $caster, $data );
	}

	protected function parse_targets() {
		$targets = explode( ':', $this->opts['tar'] );
		$this->set_targets( $targets );
	}

	public function process_arguments( $argv ) {
		if ( $argv && ! $this->opts ) {
			list ( $command, $name, $action, $secondary ) = array_pad( $argv, 4, false );
			if ( strlen( $name ) ) {
				$object = $this->get_object( $name );
				if ( $object ) {
					if ( $action ) {
						if ( intval( $action ) ) {
							$spell = $this->get_numbered_spell( $object, $action );
							if ( $spell ) $this->gopa_start_casting( $name, $spell, $secondary );
						} else if ( method_exists( $object, 'locate_magic_spell' ) && ( $spell = $object->locate_magic_spell( $action ) ) ) {
							$this->gopa_start_casting( $name, $spell, $secondary );
						} else {
							if ( ( $secondary ) && method_exists( $object, 'set_dual_weapons' ) ) {
								$object->set_dual_weapons( $action, $secondary );
							}
							$this->change_weapon( $object, $action );
						}
					} else if ( $object->weapon['current'] === 'Spell' ) {
						$this->show_possible_spells( $object );
						$this->show_possible_weapons( $object );
					} else {
						$this->show_possible_weapons( $object );
					}
				}
			}
		}
	}

	protected function show_variable() {
		$var = $this->opts['show'];
		if ( property_exists( $this, $var ) ) {
			if ( is_array( $this->{$var} ) || is_object( $this->{$var} ) ) {
				print_r( $this->{$var} );
			} else {
				echo "$var: {$this->$var}\n";
			}
		} else {
			if ( $var === 'base' ) {
				print_r( $this->get_base_monster() );
			} else {
				$show = $this->get_object( $var );
				if ( $show ) print_r( $show );
			}
		}
	}

	protected function gopa_start_casting( $name, $spell, $target = false ) {
		echo "\n$name\n";
		$result = $this->start_casting( $name, $spell, $target );
		if ( $result === false ) {
			if ( $this->error ) $this->show_message( $this->error );
			echo "Exiting!\n\n";
			exit;
		}
	}


}

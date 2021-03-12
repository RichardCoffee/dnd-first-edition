<?php

trait DND_Combat_Opts {


	protected $opts = array();


	protected function get_opts() {
		$opts = array(
			'add:',
			'att:',
			'claim:',
			'crit:',
			'desc::',
			'eff:',
			'enc:',
			'fumble:',
			'help',
			'hit:',
			'hold:',
			'import:',
			'init:',
			'limit:',
			'loot',
			'miss:',
			'mod:',
			'monster:',
			'pre:',
			'remove:',
			'reset:',
			'show:',
			'spell:',
			'st:',
			'store:',
			'text'
		);
		$this->opts = getopt( 'afhr:stx', $opts );
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
						break;
					case 'f':
						add_action( 'dnd1e_combat_init', [ $this, 'show_filters' ], 100 );
						$this->show_filters();
						break;
					case 'r':
						$this->parse_range();
						break;
					case 's':
						$this->update_holds();
						break;
					case 't':
						$t = new DND_Combat_Treasure_Treasure;
						$t->show_possible_monster_treasure( $this->enemy );
						exit;
					case 'x':
						$this->show_experience_value();
						exit;
					case 'add':
						$this->add_to_party( $this->opts['add'] );
						break;
					case 'att':
						$this->parse_attacks();
						break;
					case 'claim':
						$this->parse_claim();
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
					case 'enc':
						$this->parse_encounter();
						break;
					case 'fumble':
						$this->parse_fumble();
						break;
					case 'hit':
						$this->parse_hits();
						break;
					case 'hold':
						$this->parse_holding();
						break;
					case 'import':
						$this->parse_import();
						break;
					case 'init':
						$this->parse_init();
						break;
					case 'limit':
						$this->parse_limit();
						break;
					case 'loot':
						$this->show_loot();
						break;
					case 'miss':
						$this->parse_miss();
						break;
					case 'mod':
						$this->parse_mod();
						break;
					case 'monster':
						$this->parse_monster();
						break;
					case 'pre':
						$this->parse_pre_cast();
						break;
					case 'remove':
						$this->parse_remove();
						break;
					case 'reset':
						$this->parse_reset();
						break;
					case 'show':
						$this->show_variable();
						exit;
					case 'spell':
						$this->parse_spell();
						break;
					case 'st':
						$this->parse_saving_throws();
						break;
					case 'store':
						$this->parse_store();
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

	--crit=#[:b|p]  Display the possible result of a critical hit, where # is the number rolled on percentile dice.
	                Second parameter of 'b' or 'p' can be added to indicate blunt or piercing damage, otherwise defaults to slashing damage.

	--desc=#        Display the description information for the selected enemy.

	--fumble=#      Display the possible result of a fumble roll, where # is the number rolled on percentile dice.

	--eff=<origin>:<target>:<effect>  Apply an effect from an attack.

	--enc=<terrain>:<area>[:roll[:roll][:num]]
	                Possibly generate a random encounter where terrain can be 'CC','CW','TC','TW','TSC','TSW' and area can be 'M','H','F','S','P','D'
	                For water encounters terrain can be 'CF','CS','TF','TS','TSF','TSS' and area can be 'S','D'.  First roll is d100 for
	                appearence category, second roll is for the creature.  Number is the number of creatures encountered, otherwise this
	                number is generated using standard encounter determinants.

	--hit=origin:target:#[:effect]  Use to record damage to a combatant, format is <name>:<damage>.  The effect can be used for the
	                                type of damage, recognized effects are 'cold', 'fire', 'electic', 'mental', 'sleep', 'charm', 'undead'

	--hold=name[:#]  Place a combatant's attack on hold.  Adding a segment value indicates that the combatant can attack on the specified segment.

	--import=group[:label]  Import data from a previously stored file.

	--init=name:#   Set a participant's initiative.

	--loot          Show whatever loot dead opponents may have.

	--miss=name     Indicate an attack has missed.

	--mod=name:hp|mp:diff  Modify a character's hit points or manna points.

	--monster=class[:num]  Add a specific monster to the current encounter.  If unspecified, the number defaults to 1.

	--pre=name:#[:data]  Use this when a character casts a spell before combat, where '#' indicates the spell's number, from the numbered spell list.

	--remove=name   Remove character from party.

	--reset=hp|mp   Reset either all character hit points, or all character manna points.

	--spell=name:data  Use to pass data to a spell that a combatant is casting.  Use the semi-colon as a data separator.

	--st=name       Show the saving throws for the indicated combatant.

	--store=group[:label]  Store a group.  Possible values as 'party', 'enemy', and 'gear'.  The label can be used to sub-identify.

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

	protected function parse_attacks() {
		$this->damage_parameters( explode( ':', $this->opts['att'] ) );
	}

	protected function parse_claim() {
		list( $key, $owner ) = explode( ':', $this->opts['claim'] );
		$this->claim_gear( $key, $owner );
	}

	protected function parse_critical() {
		list( $roll, $type ) = array_pad( explode( ':', $this->opts['crit'] ), 2, 's' );
		$this->critical_hit_result( $roll, $type );
	}

	protected function parse_effect() {
		list( $origin, $target, $effect ) = array_pad( explode( ':', $this->opts['eff'] ), 3, '' );
		$this->add_hit_effect( $origin, $target, $effect );
	}

	protected function parse_encounter() {
		list( $terrain, $area, $freq, $crea, $num ) = array_pad( explode( ':', $this->opts['enc'] ), 5, 0 );
		$this->generate_encounter( $terrain, $area, $freq, $crea, $num );
	}

	protected function parse_fumble() {
		list( $origin, $roll, $seg ) = array_pad( explode( ':', $this->opts['fumble'] ), 3, 0 );
		if ( is_numeric( $origin ) ) {
			$this->fumble_roll_result( $origin );
		} else {
			$this->fumble_roll_result( $roll );
			if ( $seg === 0 ) $seg = mt_rand( 1, 10 );
			$obj = $this->get_object( $origin );
			if ( $obj ) {
				$obj->set_attack_segment( $this->segment + 10 + $seg );
			}
		}
	}

	protected function parse_hits() {
		$this->damage_parameters( explode( ':', $this->opts['hit'] ) );
	}

	protected function parse_holding() {
		list( $target, $time ) = array_pad( explode( ':', $this->opts['hold'] ), 2, 0 );
		$this->add_holding( $target, $time );
	}

	protected function parse_import() {
		list( $group, $label ) = array_pad( explode( ':', $this->opts['import'] ), 2, 'common' );
		$this->retrieve_data( $group, $label );
	}

	protected function parse_init() {
		list( $name, $roll ) = explode( ':', $this->opts['init'] );
		$this->set_initiative( $name, $roll );
	}

	protected function parse_limit() {
		$limit = intval( $this->opts['limit'] );
		$this->set_limit( $limit );
	}

	protected function parse_miss() {
		$this->missed_attack( $this->opts['miss'] );
	}

	protected function parse_mod() {
		list( $name, $stat, $diff ) = array_pad( explode( ':', $this->opts['mod'] ), 3, null );
		$this->modify_char_stat( $name, $stat, $diff );
	}

	protected function parse_monster() {
		list( $class, $num ) = array_pad( explode( ':', $this->opts['monster'] ), 2, 1 );
		$this->add_monster( $class, $num );
	}

	protected function parse_pre_cast() {
		list( $name, $title, $target ) = array_pad( explode( ':', $this->opts['pre'] ), 3, null );
		$this->pre_cast_spell( $name, $title, $target );
	}

	protected function parse_range() {
		list( $x, $y, $z ) = array_pad( explode( ':', $this->opts['r'] ), 3, '0' );
		$this->range   = ( $y === '0' ) ? intval( $x ) : $this->generate_z( intval( $x ), intval( $y ) );
		$this->range   = ( $z === '0' ) ? $this->range : $this->generate_z( $this->range, intval( $z ) );
	}

	protected function parse_remove() {
		$this->remove_from_party( $this->opts['remove'] );
	}

	protected function parse_reset() {
		if ( $this->opts['reset'] === 'hp' ) {
			$this->reset_hit_points();
		} else if ( $this->opts['reset'] === 'mp' ) {
			$this->reset_manna_points();
		} else {
			$this->messages[] = 'No reset option given.';
		}
	}

	protected function parse_saving_throws() {
		list( $safety, $effect ) = array_pad( explode( ':', $this->opts['st'] ), 2, '' );
		$this->show_saving_throws( $safety, $effect );
	}

	protected function parse_spell() {
		list( $caster, $data ) = array_pad( explode( ':', $this->opts['spell'] ), 2, false );
echo "$caster\n";
echo "$data\n";
		$this->process_spell_data( $caster, $data );
	}

	protected function parse_store() {
		list( $group, $label ) = array_pad( explode( ':', $this->opts['store'] ), 2, 'common' );
		$this->store_data( $group, $label );
	}

	public function process_arguments( $argv ) {
		if ( $argv && ! $this->opts ) {
			list ( $command, $name, $action, $secondary ) = array_pad( $argv, 4, false );
			if ( strlen( $name ) ) {
				$object = $this->get_object( $name );
				if ( $object ) {
					if ( $object->get_hit_points() < 1 ) {
						$this->messages[] = $object->get_key() . ' is dead or unconscious.  He can take no actions.';
						return;
					}
					if ( $action ) {
						if ( intval( $action ) ) {
							$spell = $this->get_numbered_spell( $object, $action );
							if ( $spell ) $this->gopa_start_casting( $name, $spell, $secondary );
						} else if ( strlen( $action ) === 1 ) {
							$item = $this->get_lettered_gear( $object, $action );
							if ( $item ) $this->activate_weapon( $object, $item, $secondary );
						} else if ( method_exists( $object, 'get_listed_spell' ) && ( $spell = $object->get_listed_spell( $action ) ) ) {
							$this->gopa_start_casting( $name, $spell, $secondary );
						} else {
							if ( ( $secondary ) && method_exists( $object, 'set_dual_weapons' ) ) {
								$object->set_dual_weapons( $action, $secondary );
								$secondary = false;
							}
							$this->change_weapon( $object, $action, $secondary );
						}
					} else if ( array_key_exists( 'Spell', $object->weapons ) ) {
						$this->show_possible_spells( $object );
						$this->show_possible_weapons( $object );
						$this->show_special_gear( $object );
						exit;
					} else {
						$this->show_possible_weapons( $object );
						$this->show_special_gear( $object );
						exit;
					}
				}
			}
		}
	}

	public function show_filters() {
		global $wp_filter;
		print_r( $wp_filter );
#echo "in show_filters\n";
	}

	protected function show_variable() {
		list( $var, $part ) = array_pad( explode( ':', $this->opts['show'] ), 2, false );
#print_r($this->opts);
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
				if ( $show ) {
					print_r( $show );
					$key = $show->get_key();
					if ( array_key_exists( $key, $this->party ) || array_key_exists( $key, $this->enemy ) ) {
						foreach( $this->gear as $idx => $item ) {
							if ( $item->owner === $key ) print_r( $item );
						}
					}
				}
			}
		}
	}

	protected function gopa_start_casting( $name, $spell, $target = false ) {
		$result = $this->start_casting( $name, $spell, $target );
		if ( $result === false ) {
			if ( $this->error ) $this->show_error( $this->error );
			$this->show_error( 'Exiting!' );
		}
	}


	/**  Testing functions  **/

	public function set_range( $range ) {
		$this->range = $range;
	}


}

<?php

class DND_Character_Ranger extends DND_Character_Fighter {

	protected $ac_rows    = array( 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21 );
	protected $alignment  = 'Good';
#	protected $classes    = array( 'druid' => 'Druid', 'magic' => 'Magic User' );
#	protected $druid      = null;
	protected $hit_die    = array( 'limit' => 11, 'size' => 8, 'step' => 2 );
#	protected $magic      = null;
	protected $non_prof   = -2;
	protected $spell_list = array();
	protected $stats      = array( 'str' => 13, 'int' => 13, 'wis' => 14, 'dex' => 3, 'con' => 14, 'chr' => 3 );
#	protected $weapons    = array( 'Spell' => array( 'bonus' => 0, 'skill' => 'PF' ) );
	protected $weap_init  = array( 'initial' => 3, 'step' => 3 );
	protected $weap_reqs  = array( 'Bow/Crossbow,Light', 'Dagger/Knife', 'Spear/Axe', 'Sword' );
	protected $xp_bonus   = array( 'str' => 16, 'int' => 16, 'wis' => 16 );
	protected $xp_step    = 325000;
	protected $xp_table   = array( 0, 2250, 4500, 10000, 20000, 40000, 90000, 150000, 225000, 325000 );

	use DND_Character_Trait_Magic { locate_magic_spell as locate_spell; }
	use DND_Character_Trait_Ranger { DND_Character_Trait_Ranger::locate_magic_spell insteadof DND_Character_Trait_Magic; }
	use DND_Character_Trait_Spells_Druid;
	use DND_Character_Trait_Spells_MagicUser;
	use DND_Character_Trait_Spells_Effects_MagicUser;


	public function __construct( $args = array() ) {
		parent::__construct( $args );
		if ( array_key_exists( 'spell_import', $args ) ) {
			$this->import_spells( $args['spell_import'] );
		}
		$this->calculate_ranger_manna_points();
		add_filter( 'dnd1e_weapon_damage_bonus',    [ $this, 'ranger_damage_bonus' ], 10, 3 );
		add_filter( 'dnd1e_secondary_damage_bonus', [ $this, 'ranger_damage_bonus' ], 10, 3 );
	}

	protected function initialize_character() {
		parent::initialize_character();
	}

	protected function calculate_level( $xp ) {
		$level = parent::calculate_level( $xp );
		if ( ( $level > 7 ) && ( ! array_key_exists( 'Spell', $this->weapons ) ) ) {
			$this->weapons['Spell'] = array( 'bonus' => 0, 'skill' => 'PF' );
		}
		return $level;
	}

	protected function determine_hit_points() {
		parent::determine_hit_points();
		$adj = $this->hit_die['size'] + $this->get_constitution_hit_point_adjustment( $this->stats['con'] );
		$this->hit_points+= $adj;
		$this->current_hp+= $adj;
	}

	protected function define_specials() {
		$this->specials = array(
			'integer_giant'   => sprintf( "Damage vs 'giant' class opponent: +%u (UA 22)", $this->special_integer_giant( 'giant', 'int' ) ),
			'integer_track'   => sprintf( 'Tracking: %u%% (PH 25,UA 21-22)', $this->special_integer_track() ),
			'string_surprise' => sprintf( 'Surprise: %s', $this->special_string_surprise() ),
		);
	}

	public function special_integer_giant() {
		return $this->level;
	}

	public function special_array_giant() {
		return array( 'bugbear', 'cyclopskin', 'dune stalker', 'ettin', 'flind', 'giant', 'gibberling', 'gnoll',
			'goblin', 'grimlock', 'hobgoblin', 'kobold', 'meazel', 'norker', 'ogre',
			'ogre mage', 'ogrillon', 'orc', 'quaggoth', 'tasloi', 'troll', 'xvart',
			'cloud giant', 'fire giant', 'frost giant', 'hill giant', 'stone giant', 'storm giant',
			'fog giant', 'mountain giant', 'fomorian giant', 'firbolg giant', 'verbeeg giant',
		);
	}

	public function special_attack_giant( $race, $type = 'bool' ) {
		$race   = strtolower( $race );
		$result = in_array( $race, $this->special_array_giant() );
		if ( $type === 'int' ) {
			$result = ( $result ) ? $this->special_integer_giant() : 0;
		}
		return $result;
	}

	public function ranger_damage_bonus( $bonus, $origin, $target ) {
		if ( $origin === $this ) {
			if ( $target instanceOf DND_Monster_Monster ) {
				if ( in_array( $this->weapon['attack'], $this->get_weapons_using_strength_bonuses() ) ) {
					$bonus += $this->special_attack_giant( $target->race, 'int' );
				}
			}
		}
		return $bonus;
	}

	public function special_integer_track() {
		return min( 100, $this->level * 10 ) + 10;
	}

	public function special_string_surprise() {
		return 'opponents 50% (3 in 6), self 16% (1 in 6)';
	}


	/**  Spell functions  **/

	protected function initialize_spell_list( $book ) {
		if ( $book ) {
			foreach( $book as $level => $spells ) {
				$this->spells[ $level ] = array();
				foreach( $spells as $name ) {
					$this->spells[ $level ][ $name ] = $this->locate_magic_spell( $name );
				}
			}
		}
	}

	protected function import_spells( $spells ) {
		foreach( $spells as $spell ) {
			$new = $this->locate_magic_spell( $spell );
			if ( ! $new ) continue;
			$this->add_spell( $new );
		}
	}

	protected function add_spell( $spell ) {
		$level = $spell->get_level();
		$name  = $spell->get_name();
		if ( ! array_key_exists( $level, $this->spells ) ) $this->spells[ $level ] = array();
		if ( ! array_key_exists( $name,  $this->spells[ $level ] ) ) $this->spells[ $level ][ $name ] = $spell;
	}

	public function get_spell_list() {
		return $this->spells;
	}

	public function calculate_manna_points() {
		$this->calculate_ranger_manna_points();
	}

	protected function calculate_ranger_manna_points() {
		if ( $this->level < 8 ) return;
		if ( $this->manna_init === 0 ) {
			$tables = array( 'druid_manna_points' );
			if ( $this->level > 8 ) $tables[] = 'magic_user_manna_points';
			foreach( $tables as $type ) {
				$table = $this->$type();
				$level = ( array_key_exists( $this->level, $table ) ) ? $table[ $this->level ] : array_pop( $table );
				foreach( $level as $key => $value ) {
					$this->manna_init += $value * ( $key + 1 );
				}
			}
			if ( $this->manna === 0 ) $this->manna = $this->manna_init;
		}
	}

	protected function druid_manna_points() {
		return array(
			8  => array( 1 ),
			9  => array( 1 ),
			10 => array( 2 ),
			11 => array( 2 ),
			12 => array( 2, 1 ),
			13 => array( 2, 1 ),
			14 => array( 2, 2 ),
			15 => array( 2, 2 ),
			16 => array( 2, 2, 1 ),
			17 => array( 2, 2, 2 ),
		);
	}

	protected function magic_user_manna_points() {
		return array(
			9  => array( 1 ),
			10 => array( 1 ),
			11 => array( 2 ),
			12 => array( 2 ),
			13 => array( 2, 1 ),
			14 => array( 2, 1 ),
			15 => array( 2, 2 ),
		);
	}


}

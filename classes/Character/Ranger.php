<?php

class DND_Character_Ranger extends DND_Character_Fighter {

	protected $ac_rows   = array( 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21 );
	private   $druid     = null;
	protected $hit_die   = array( 'limit' => 11, 'size' => 8, 'step' => 2 );
	private   $magic     = null;
	protected $non_prof  = -2;
	protected $stats     = array( 'str' => 13, 'int' => 13, 'wis' => 14, 'dex' => 3, 'con' => 14, 'chr' => 3 );
	private   $user      = null;
	protected $weap_init = array( 'initial' => 3, 'step' => 3 );
	protected $weap_reqs = array( 'Bow/Crossbow,Light', 'Dagger/Knife', 'Spear/Axe', 'Sword' );
	protected $xp_bonus  = array( 'str' => 16, 'int' => 16, 'wis' => 16 );
	protected $xp_step   = 325000;
	protected $xp_table  = array( 0, 2250, 4500, 10000, 20000, 40000, 90000, 150000, 225000, 325000 );


	public function __construct( $args = array() ) {
		$this->specials = array(
			'integer_giant' => 'Damage vs giant class',
			'integer_track' => 'Tracking',
			'string_surprise' => 'Surprise',
		);
		parent::__construct( $args );
	}

	public function initialize_character() {
		parent::initialize_character();
		$this->druid = new DND_Character_Druid( [ 'level' => max( 1, $this->level - 7 ) ] );
		$this->magic = new DND_Character_MagicUser( [ 'level' => max( 1, $this->level - 8 ) ] );
	}

	protected function determine_hit_points() {
		parent::determine_hit_points();
		if ( $this->hit_points['base'] > 0 ) {
			$this->hit_points['base'] += $this->hit_die['size'] + $this->get_constitution_hit_point_adjustment( $this->stats['con'] );
		}
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

	public function special_integer_track() {
		return min( 100, $this->level * 10 ) + 10;
	}

	public function special_string_surprise() {
		return 'Surprise: opponents 50% (3 in 6), self 16% (1 in 6)';
	}

	public function get_spell_info( $spell ) {
		$info = $this->druid->get_spell_info( $spell );
		if ( $info ) {
			$info['caster'] = 'druid';
		} else {
			$info = $this->magic->get_spell_info( $spell );
			if ( $info ) {
				$info['caster'] = 'magic';
			}
		}
		return $info;
	}

	protected function add_spell( $data ) {
		if ( ! isset( $this->spells[ $data['caster'] ][ $data['level'] ][ $data['name'] ] ) ) {
			$this->spells[ $data['caster'] ][ $data['level'] ][ $data['name'] ] = $data['data'];
		}
	}




}

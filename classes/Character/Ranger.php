<?php

class DND_Character_Ranger extends DND_Character_Fighter {

	protected $ac_rows   = array( 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21 );
	private   $druid     = null;
	protected $hit_die   = array( 'limit' => 11, 'size' => 8, 'step' => 2 );
	private   $magic     = null;
	protected $non_prof  = -2;
	protected $stats     = array( 'str' => 13, 'int' => 13, 'wis' => 14, 'dex' => 3, 'con' => 14, 'chr' => 3 );
	protected $weap_init = array( 'initial' => 3, 'step' => 3 );
	protected $weap_reqs = array( 'Bow/Crossbow,Light', 'Dagger/Knife', 'Spear/Axe', 'Sword' );
	protected $xp_bonus  = array( 'str' => 16, 'int' => 16, 'wis' => 16 );
	protected $xp_step   = 325000;
	protected $xp_table  = array( 0, 2250, 4500, 10000, 20000, 40000, 90000, 150000, 225000, 325000 );


	public function initialize_character() {
		parent::initialize_character();
		if ( empty( $this->druid ) ) {
			$this->druid = new DND_Character_Druid( [ 'level' => $this->level ] );
			$this->magic = new DND_Character_MagicUser( [ 'level' => $this->level ] );
		}
	}

	protected function calculate_level( $xp ) {
		$level = parent::calculate_level( $xp );
		$this->druid->set_level( $level );
		$this->magic->set_level( $level );
		return $level;
	}

	protected function determine_hit_points() {
		parent::determine_hit_points();
		$this->hit_points += $this->hit_die['size'] + $this->get_constitution_hit_point_adjustment( $this->stats['con'] );
	}

	protected function define_specials() {
		$this->specials = array(
			'integer_giant'   => "Damage vs 'giant' class opponent: +" . $this->special_integer_giant( 'giant', 'int' ),
			'integer_track'   => 'Tracking: ' . $this->special_integer_track() . '%',
			'string_surprise' => 'Surprise: ' . $this->special_string_surprise(),
		);
	}

	public function special_integer_giant() {
		return $this->level;
	} //*/

	public function special_array_giant() {
		return array( 'bugbear', 'cyclopskin', 'dune stalker', 'ettin', 'flind', 'giant', 'gibberling', 'gnoll',
			'goblin', 'grimlock', 'hobgoblin', 'kobold', 'meazel', 'norker', 'ogre',
			'ogre mage', 'ogrillon', 'orc', 'quaggoth', 'tasloi', 'troll', 'xvart',
			'cloud giant', 'fire giant', 'frost giant', 'hill giant', 'stone giant', 'storm giant',
			'giant,cloud', 'giant,fire', 'giant,frost', 'giant,hill', 'giant,stone', 'giant,storm',
			'fog giant', 'mountain giant', 'fomorian giant', 'firbolg giant', 'verbeeg giant',
			'giant,fog', 'giant,mountain', 'giant,fomorian', 'giant,firbolg', 'giant,verbeeg',
		);
	} //*/

	public function special_attack_giant( $race, $type = 'bool' ) {
		$race   = strtolower( $race );
		$result = in_array( $race, $this->special_array_giant() );
		if ( $type === 'int' ) {
			$result = ( $result ) ? $this->special_integer_giant() : 0;
		}
		return $result;
	} //*/

	public function get_weapon_damage_bonus( $range = -1 ) {
		$bonus = parent::get_weapon_damage_bonus( $range );
		if ( ! empty( $this->opponent['type'] ) ) {
			if ( in_array( $this->weapon['attack'], $this->get_weapons_using_strength_bonuses() ) ) {
				$bonus += $this->special_attack_giant( $this->opponent['type'], 'int' );
			}
		}
		return $bonus;
	}

	public function special_integer_track() {
		return min( 100, $this->level * 10 ) + 10;
	} //*/

	public function special_string_surprise() {
		return 'opponents 50% (3 in 6), self 16% (1 in 6)';
	} //*/

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

	public function parse_csv_line( $line ) {
#print_r($line);
		parent::parse_csv_line( $line );
#echo "druid task: {$this->druid->import_task}\n";
		$this->druid->parse_csv_line( $line );
#echo "magic task: {$this->magic->import_task}\n";
		$this->magic->parse_csv_line( $line );
	}


}

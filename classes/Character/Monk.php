<?php

class DND_Character_Monk extends DND_Character_Thief {


	protected $ac_rows    = array( 1, 1, 2, 2, 3, 3, 4, 5, 6, 6, 7, 7, 8, 8, 9, 10, 10, 11, 11, 12 );
	protected $armor_adj  = array( 0, 0, 1, 2, 3, 3, 4, 5, 6, 6, 7, 8, 9, 10, 11, 11, 12, 13 );
	protected $armr_allow = array( 'none' );
	protected $hit_die    = array( 'limit' => 17, 'size' => 4, 'step' => 2 );
	protected $non_prof   = -3;
	protected $skills     = array( 'Open Locks' => 25, 'Find Traps' => 20, 'Move Silently' => 15, 'Hide Shadow' => 10, 'Hear Noise' => 10, 'Climb Walls' => 85 );
	protected $stats      = array( 'str' => 3, 'int' => 3, 'wis' => 3, 'dex' => 9, 'con' => 3, 'chr' => 3 );
	protected $weap_allow = array( 'Axe,Hand', 'Bo Sticks', 'Club', 'Crossbow,Hand', 'Crossbow,Heavy', 'Crossbow,Light','Dagger', 'Dagger,Thrown', 'Dagger,Off-Hand', 'Javelin', 'Jo Stick', 'pole arm', 'Spear', 'Spear,Thrown', 'Staff,Quarter' );
	protected $weap_init  = array( 'initial' => 1, 'step' => 2 );
	protected $xp_bonus   = array();
	protected $xp_step    = 220000;
	protected $xp_table   = array( 0, 2250, 4750, 10000, 22500, 47500, 98000, 200000, 350000, 500000, 700000, 950000, 1250000, 1750000, 2250000, 2750000, 3250000 );


	protected function initialize_character() {
		$this->add_filters();
		parent::initialize_character();
		$this->determine_thief_skills();
	}

	protected function add_filters() {
		parent::add_filters();
		add_filter( 'dnd1e_armor_class_adj', [ $this, 'monk_armor_class' ], 10, 2 );
	}

	public function monk_armor_class( $current, $object ) {
		if ( $object === $this ) {
			$current = $this->armor_adj[ $this->level ];
		}
		return $current;
	}

	protected function determine_hit_points() {
		parent::determine_hit_points();
		$adj = $this->hit_die['size'] + $this->get_constitution_hit_point_adjustment( $this->stats['con'] );
		$this->hit_points+= $adj;
										if ( $this->dcc_debug['dhp'] ) { echo "hp3: {$this->hit_points}\n"; }
		$this->current_hp+= $adj;
	}

	protected function determine_thief_skills() {
		$table  = $this->get_thief_table();
		$racial = $this->get_thief_racial_adjustments();
		$dex    = $this->get_thief_dexterity_adjustments();
		foreach( $this->skills as $key => $value ) {
			$index = ( isset( $table[ $key ][ $this->level ] ) ) ? $this->level : count( $table[ $key ] ) - 1;
			$this->skills[ $key ] = $table[ $key ][ $index ];
			if ( array_key_exists( $key, $racial ) ) {
				$this->skills[ $key ] += $racial[ $key ];
			}
			if ( array_key_exists( $key, $dex ) ) {
				$this->skills[ $key ] += $dex[ $key ];
			}
		}
		if ( $this->skills['Climb Walls'] < 99 ) {
			$this->skills['Climb Walls'] = intval( round( $this->skills['Climb Walls'] ) );
		}
	}

	public function get_thief_skills_list() {
		$list = array(); // FIXME
		return $list;
	}

	public function get_armor_class_dexterity_adjustment( $dex = 9 ) {
		return 0;
	}


}

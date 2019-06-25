<?php

abstract class DND_Character_Character {

	protected $armorclass = 10;
	protected $armortype  = 10;
	protected $attacks    = '1/1';
	protected $current    = '';
	protected $experience = 0;
	protected $hd_limit   = 0;
	protected $hit_die    = 1000;
	protected $hit_points = -1;
	protected $hp_step    = 100;
	protected $level      = 1;
	protected $movement   = '12';
	protected $name       = 'Character Name';
	protected $non_prof   = -100;
	protected $skill      = 'NP';
	protected $stats      = array( 'str' => 3, 'int' => 3, 'wis' => 3, 'dex' => 3, 'con' => 3, 'chr' => 3 );
	protected $to_hit_ac  = array();
	protected $weapon     = array();
	protected $weapons    = array();

	use DND_Character_Trait_Attributes;
	use DND_Character_Trait_Weapons;
	use DND_Trait_Magic;
	use DND_Trait_ParseArgs;

	abstract protected function to_hit_ac_row();

	public function __construct( $args = array() ) {
		$this->parse_args( $args );
		if ( ( $this->level === 1 ) && ( $this->experience > 0 ) ) {
			$this->level = $this->get_level( $this->experience );
		}
		if ( ! empty( $this->current ) ) {
			$this->set_current_weapon( $this->current );
		}
		$this->to_hit_ac = $this->to_hit_ac_row();
	}

	protected function get_level( $xp ) {
		$level = 0;
		foreach( $this->xp_table as $needed ) {
			$level++;
			if ( $xp < $needed ) {
				break;
			}
		}
		$xp -= $this->xp_table[ count( $this->xp_table ) - 1 ];
		while ( $xp > 0 ) {
			$xp -= $this->xp_step;
			$level++;
		}
		return $level - 1;
	}

	protected function set_current_weapon( $new = '' ) {
		if ( ! empty ( $new ) ) {
			$this->current = $new;
			$this->skill   = 'NP';
			if ( ( ! empty( $this->weapons ) ) && isset( $this->weapons[ $new ] ) ) {
				$this->skill = $this->weapons[ $new ];
			}
			$this->load_current_weapon();
		}
	}

	protected function load_current_weapon() {
		$this->weapon = $this->get_weapon_info( $this->current );
		$attacks = $this->get_weapon_attacks_array( $this->weapon['attack'] );
		$index   = $this->get_weapon_attacks_index( $this->skill );
		$this->attacks = $attacks[ $index ];
	}

	protected function get_weapon_attacks_index( $skill = 'NP' ) {
		$index = 0;
		switch( $skill ) {
			case 'DS':
				$index = 2;
				break;
			case 'SP':
				$index = 1;
				break;
			case 'NP':
			case 'PF':
			default:
				$index = 0;
		}
		return $index;
	}

	protected function to_hit_ac_table() {
		return array(
			/*     10   9   8   7   6   5   4   3   2   1   0  -1  -2  -3  -4  -5  -6  -7  -8  -9 -10 */
			array( 12, 13, 14, 15, 16, 17, 18, 19, 20, 20, 20, 20, 20, 20, 21, 22, 23, 24, 25, 26, 27 ), //  0
			array( 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 20, 20, 20, 20, 20, 21, 22, 23, 24, 25, 26 ), //  1
			array( 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 20, 20, 20, 20, 20, 21, 22, 23, 24, 25 ), //  2
			array(  9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 20, 20, 20, 20, 20, 21, 22, 23, 24 ), //  3
			array(  8,  9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 20, 20, 20, 20, 20, 21, 22, 23 ), //  4
			array(  7,  8,  9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 20, 20, 20, 20, 20, 21, 22 ), //  5
			array(  6,  7,  8,  9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 20, 20, 20, 20, 20, 21 ), //  6
			array(  5,  6,  7,  8,  9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 20, 20, 20, 20, 20 ), //  7
			array(  4,  5,  6,  7,  8,  9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 20, 20, 20, 20 ), //  8
			array(  3,  4,  5,  6,  7,  8,  9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 20, 20, 20 ), //  9
			array(  2,  3,  4,  5,  6,  7,  8,  9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 20, 20 ), // 10
			array(  1,  2,  3,  4,  5,  6,  7,  8,  9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 20 ), // 11
			array(  0,  1,  2,  3,  4,  5,  6,  7,  8,  9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20 ), // 12
			array( -1,  0,  1,  2,  3,  4,  5,  6,  7,  8,  9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19 ), // 13
			array( -2, -1,  0,  1,  2,  3,  4,  5,  6,  7,  8,  9, 10, 11, 12, 13, 14, 15, 16, 17, 18 ), // 14
			array( -3, -2, -1,  0,  1,  2,  3,  4,  5,  6,  7,  8,  9, 10, 11, 12, 13, 14, 15, 16, 17 ), // 15
			array( -4, -3, -2, -1,  0,  1,  2,  3,  4,  5,  6,  7,  8,  9, 10, 11, 12, 13, 14, 15, 16 ), // 16
			array( -5, -4, -3, -2, -1,  0,  1,  2,  3,  4,  5,  6,  7,  8,  9, 10, 11, 12, 13, 14, 15 ), // 17
			array( -6, -5, -4, -3, -2, -1,  0,  1,  2,  3,  4,  5,  6,  7,  8,  9, 10, 11, 12, 13, 14 ), // 18
			array( -7, -6, -5, -4, -3, -2, -1,  0,  1,  2,  3,  4,  5,  6,  7,  8,  9, 10, 11, 12, 13 ), // 19
			array( -8, -7, -6, -5, -4, -3, -2, -1,  0,  1,  2,  3,  4,  5,  6,  7,  8,  9, 10, 11, 12 ), // 20
			array( -9, -8, -7, -6, -5, -4, -3, -2, -1,  0,  1,  2,  3,  4,  5,  6,  7,  8,  9, 10, 11 ), // 21
			array(-10, -9, -8, -7, -6, -5, -4, -3, -2, -1,  0,  1,  2,  3,  4,  5,  6,  7,  8,  9, 10 ), // 22
		);
	}

	public function get_to_hit_number( $target_ac, $target_at = -1 ) {
		$target_at = max( $target_ac, $target_at, 0 );
		$to_hit  = $this->get_to_hit_base( $target_ac );
		$to_hit -= $this->get_weapon_adjustment( $target_at );
		if ( $this->weapon['attack'] === 'hand' ) {
			$percent = $this->parse_strength_percentage( $this->stats['str'] );
			$to_hit -= $this->get_strength_to_hit_bonus( $this->stats['str'], $percent );
		} else if ( $this->weapon['attack'] === 'bow' ) {
			$to_hit -= $this->get_missile_to_hit_adjustment( $this->stats['dex'] );
		}
		return $to_hit;
	}

	protected function get_to_hit_base( $target_ac = 10 ) {
		$ac_index = 10 - $target_ac;
		if ( isset( $this->to_hit_ac[ $ac_index ] ) ) {
			return $this->to_hit_ac[ $ac_index ];
		}
		return 10000;
	}

	protected function get_weapon_adjustment( $target_at ) {
		return $this->weapon['type'][ $target_at ];
	}

}

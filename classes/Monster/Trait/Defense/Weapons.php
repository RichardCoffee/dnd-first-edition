<?php

trait DND_Monster_Trait_Defense_Weapons {


	protected $mtdw_limit  = 0;
	protected $mtdw_silver = false;


	private function mtdw_setup() {
		add_filter( 'character_to_hit_opponent', [ $this, 'mtdw_verify_to_hit' ], 10, 3 );
	}

	protected function mtdw_add_weapon_defense_special() {
		$format  = 'Can only be hit by ';
		$format .= ( $this->mtdw_silver ) ? 'silver or ' : '';
		$format .= 'magical (+%u or better) weapons.';
		$this->specials['weapon_defense'] = sprintf( $format, $this->mtdw_limit );
	}

	public function mtdw_verify_to_hit( $to_hit, $weapon, $target ) {
		if ( $weapon['bonus'] < $this->mtdw_limit ) {
			return 99;
		}
		return $to_hit;
	}

	protected function mtdw_command_line_display_string() {
		return $this->specials['weapon_defense'] . "\n";
	}


}

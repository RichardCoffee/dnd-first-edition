<?php

trait DND_Monster_Trait_Defense_Weapons {


	protected $mtdw_limit  = 0;
	protected $mtdw_silver = false;


	private function mtdw_setup() {
		add_action( 'monster_determine_specials', [ $this, 'mtdw_add_weapon_defense_special' ] );
		add_filter( 'character_to_hit_opponent',  [ $this, 'mtdw_verify_to_hit' ], 10, 3 );
	}

	public function mtdw_add_weapon_defense_special() {
		$format  = 'Can only be hit by ';
		$format .= ( $this->mtdw_silver ) ? 'silver or ' : '';
		$format .= 'magical (+%u or better) weapons.';
		$this->specials['weapon_defense'] = sprintf( $format, $this->mtdw_limit );
	}

	public function mtdw_verify_to_hit( $number, $to_hit, $character ) {
		// TODO: apply check for silver weapons
		// FIXME: add check for multiple opponents
		if ( $character->weapon['bonus'] < $this->mtdw_limit ) {
			return ( $to_hit - 99 );
		}
		return $number;
	}

	protected function mtdw_command_line_display_string() {
		return $this->specials['weapon_defense'] . "\n";
	}


}

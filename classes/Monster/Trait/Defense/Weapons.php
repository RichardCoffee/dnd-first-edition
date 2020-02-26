<?php

trait DND_Monster_Trait_Defense_Weapons {


	protected $mtdw_iron   = false;
	protected $mtdw_limit  = 1;
	protected $mtdw_silver = false;


	private function mtdw_setup() {
		add_action( 'monster_determine_specials',   [ $this, 'mtdw_add_weapon_defense_special' ] );
		add_filter( 'dnd1e_object_to_hit_opponent', [ $this, 'mtdw_verify_to_hit' ], 10, 2 );
	}

	public function mtdw_add_weapon_defense_special() {
		$format  = 'Can only be hit by ';
		$format .= ( $this->mtdw_iron   ) ? 'cold-wrought iron or ' : '';
		$format .= ( $this->mtdw_silver ) ? 'silver or ' : '';
		$format .= 'magical (+%u or better) weapons.';
		$this->specials['weapon_defense'] = sprintf( $format, $this->mtdw_limit );
	}

	public function mtdw_verify_to_hit( $number, $object ) {
		// TODO: apply check for iron weapons
		// TODO: apply check for silver weapons
		// TODO: add check for multiple opponents
		if ( $object->weapon['current'] !== 'Spell' ) {
			if ( $object->weapon['bonus'] < $this->mtdw_limit ) {
				return $number - 100;
			}
		}
		return $number;
	}

	protected function mtdw_command_line_display_string() {
		return $this->specials['weapon_defense'] . "\n";
	}


}

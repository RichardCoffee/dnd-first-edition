<?php

trait DND_Character_Trait_Magic {


	protected $spell_table = array();


	protected function get_constitution_hit_point_adjustment( $con ) {
		$bonus = parent::get_constitution_hit_point_adjustment( $con );
		return min( $bonus, 2 );
	}

	public function get_spell_info( $spell ) {
		if ( empty( $this->spell_table ) ) {
			$this->spell_table = $this->get_spell_table();
		}
		foreach( $this->spell_table as $level => $spells ) {
			foreach( $spells as $name => $data ) {
				if ( $name === $spell ) {
					return array( 'name' => $name, 'level' => $level, 'data' => $data );
				}
			}
		}
		return false;
	}

	protected function add_spell( $data ) {
		if ( ! isset( $this->spells[ $data['level'] ][ $data['name'] ] ) ) {
			$this->spells[ $data['level'] ][ $data['name'] ] = $data['data'];
		}
	}

	protected function reload_spells() {
		$this->spell_table = $this->get_spell_table();
		foreach( $this->spells as $level => $spells ) {
			foreach( $spells as $name => $data ) {
				$info = $this->get_spell_info( $name );
				if ( $info ) {
					$this->spells[ $level ][ $name ] = $info['data'];
				}
			}
		}
	}

	protected function set_kregen_weapon_skill( $weapon, $line, $bonus ) {
		if ( $weapon === 'Spell' ) {
			$this->weapons[ $weapon ] = array( 'bonus' => 0, 'skill' => 'PF' );
		} else {
			parent::set_kregen_weapon_skill( $weapon, $line, $bonus );
		}
	}


}

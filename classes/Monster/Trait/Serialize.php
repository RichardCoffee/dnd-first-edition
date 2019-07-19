<?php

trait DND_Monster_Trait_Serialize {


	public function JsonSerialize() {
		$table = $this->get_serialization_data();
		$table['what_am_i'] = get_class( $this );
		return $table;
	}

	public function serialize() {
		return serialize( $this->get_serialization_data() );
	}

	private function get_serialization_data() {
		$table = array(
			'attacks'    => $this->attacks,
			'current_hp' => $this->current_hp,
			'hit_dice'   => $this->hit_dice,
			'hit_points' => $this->hit_points,
			'initiative' => $this->initiative,
			'name'       => $this->name,
			'xp_value'   => $this->xp_value,
		);
		if ( $this->spells ) {
			$list = array();
			foreach( $this->spells as $level => $spells ) {
				$list[ $level ] = array();
				foreach( $spells as $name => $info ) {
					$list[ $level ][] = $name;
				}
			}
			$table['spell_list'] = $list;
		}
		/** Dragons **/
		if ( $this instanceOf DND_Monster_Dragon_Dragon ) {
			$table['hd_minimum']   = $this->hd_minimum;
			$table['co_speaking']  = $this->co_speaking;
			$table['co_magic_use'] = $this->co_magic_use;
			$table['co_sleeping']  = $this->co_sleeping;
			$table['speaking']     = $this->speaking;
			$table['magic_use']    = $this->magic_use;
			$table['sleeping']     = $this->sleeping;
		}
		return $table;
	}

	public function unserialize( $data ) {
		$args = unserialize( $data );
		$this->__construct( $args );
	}


}

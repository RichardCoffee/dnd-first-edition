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
			'attacks'      => $this->attacks,
			'current_hp'   => $this->current_hp,
			'hit_dice'     => $this->hit_dice,
			'hit_points'   => $this->hit_points,
			'in_lair'      => $this->in_lair,
			'initiative'   => $this->initiative,
			'intelligence' => $this->intelligence,
			'name'         => $this->name,
			'xp_value'     => $this->xp_value,
		);
		foreach( [ 'extra' ] as $prop ) {
			if ( property_exists( $this, $prop ) ) {
				$table[ $prop ] = $this->$prop;
			}
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
			if ( $this->spells ) {
				$table['spell_list'] = array();
				foreach( $this->spells as $spell ) {
					$table['spell_list'][] = array( 'name' => $spell['name'], 'level' => $spell['level'] );
				}
			}
			if ( property_exists( $this, 'mate' ) && $this->mate ) {
				$table['mate'] = serialize( $this->mate );
			}
			if ( $this instanceOf DND_Monster_Dragon_Shadow ) {
				$table['stats'] = $this->stats;
			}
		} else {
			if ( $this->spells ) {
				$table['spell_list'] = array();
				foreach( $this->spells as $level => $spells ) {
					$table['spell_list'][ $level ] = array();
					foreach( $spells as $name => $info ) {
						$table['spell_list'][ $level ][] = $name;
					}
				}
			}
		}
		return $table;
	}

	public function unserialize( $data ) {
		$args = unserialize( $data );
		$this->__construct( $args );
		if ( $this instanceOf DND_Monster_Dragon_Cloud ) {
			$this->mate = unserialize( $args['mate'] );
			$this->specials['mate'] = sprintf( 'Mated Pair: HD %u, HP %u', $this->mate->hit_dice, $this->mate->hit_points );
		}
	}


}

<?php

trait DND_Monster_Trait_Serialize {


	public function JsonSerialize() {
		return $this->get_serialization_data();
	}

	public function serialize() {
		return serialize( $this->get_serialization_data() );
	}

	private function get_serialization_data() {
		$table = array(
			'attacks'      => $this->attacks,
			'combat_key'   => $this->get_key(),
			'current_hp'   => $this->current_hp,
			'hit_dice'     => $this->hit_dice,
			'hit_points'   => $this->hit_points,
			'in_lair'      => $this->in_lair,
			'initiative'   => $this->initiative,
			'intelligence' => $this->intelligence,
			'name'         => $this->name,
			'saving'       => $this->saving,
			'segment'      => $this->segment,
			'stats'        => $this->stats,
			'weapon'       => $this->weapon,
			'xp_value'     => $this->xp_value,
		);
		foreach( [ 'extra', 'gear' ] as $prop ) {
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
			$table['mate']         = $this->mate;
			$table['magic_use']    = $this->magic_use;
			$table['sleeping']     = $this->sleeping;
			if ( $this->spells ) {
				$table['spell_list'] = array();
				foreach( $this->spells as $spell ) {
					$table['spell_list'][] = $spell->get_name();
				}
			}
			if ( $this instanceOf DND_Monster_Dragon_Faerie ) {
				$table['co_druid'] = $this->co_druid;
			}
		} else if ( $this instanceOf DND_Monster_Humanoid_Humanoid ) {
			$table['armor']  = $this->armor;
			$table['shield'] = $this->shield;
#			$table['fighter'] = serialize( $this->fighter );
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
		$table['what_am_i'] = get_class( $this );
		return $table;
	}

	public function unserialize( $data ) {
		$args = unserialize( $data );
		$this->__construct( $args );
	}


}

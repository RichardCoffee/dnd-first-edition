<?php

trait DND_Monster_Trait_JsonSerial {


	public function JsonSerialize() {
		$table = array(
			'monster'    => get_class( $this ),
			'attacks'    => $this->attacks,
			'hit_dice'   => $this->hit_dice,
			'hit_points' => $this->hit_points,
			'initiative' => $this->initiative,
			'name'       => $this->name,
			'xp_value'   => $this->xp_value,
		);
		/** Dragons **/
		if ( property_exists( $this, 'co_speaking' ) ) {
			$table['co_speaking']  = $this->co_speaking;
			$table['co_magic_use'] = $this->co_magic_use;
			$table['co_sleeping']  = $this->co_sleeping;
			$table['speaking']     = $this->speaking;
			$table['magic_use']    = $this->magic_use;
			$table['sleeping']     = $this->sleeping;
		}
		return $table;
	}


}

<?php

abstract class DND_Monster_Invertebrates_Spider_Spider extends DND_Monster_Monster {


	public function __get( $name ) {
		if ( $name === 'movement' ) {
			return $this->movement['web'];
		}
		return parent::__get( $name );
	}


}

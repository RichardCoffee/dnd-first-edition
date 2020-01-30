<?php

abstract class DND_Monster_Humanoid_DemiHuman extends DND_Monster_Humanoid_Humanoid {


#	protected $alignment    = 'Neutral';
#	protected $appearing    = array( 1, 1, 0 );
#	protected $armor_class  = 10;
#	protected $armor_type   = 11;
#	protected $attacks      = array( 'Weapon' => [ 1, 8, 0 ] );
	protected $extra        = array();
#	protected $fighter      = null;
#	protected $frequency    = 'Common';
#	protected $hit_dice     = 0;
#	protected $hp_extra     = 0;
#	protected $in_lair      = 0;
#	protected $initiative   = 1;
#	protected $intelligence = 'Animal';
#	protected $movement     = array( 'foot' => 12 );
	protected $name         = 'DemiHuman';
#	protected $psionic      = 'Nil';
	protected $race         = 'DemiHuman';
#	protected $reference    = 'Monster Manual page';
#	protected $resistance   = 'Standard';
#	protected $size         = "Medium";
#	protected $specials     = array();
#	protected $treasure     = 'Nil';
#	protected $xp_value     = array();


	protected function possible_magic_items( DND_Character_Character $obj ) {
		$this->get_character_accouterments( $obj, $obj->level * 10 );
	}


}

<?php

class DND_Monster_Animal_Boar_Sounder extends DND_Monster_Animal_Boar_Wild {


#	protected $alignment    = 'Neutral';
#	protected $appearing    = array( 1, 12, 0 );
#	protected $armor_class  = 7;
#	protected $armor_type   = 11;
	protected $attacks      = array( 'Bite' => [ 1, 4, 0 ] );
#	public    $current_hp   = 0;
#	protected $description  = '';
#	protected $frequency    = 'Common';
#	protected $hd_minimum   = 1;
	protected $hd_value     = 4;
#	protected $hit_dice     = 3;
#	protected $hit_points   = 0;
	protected $hp_extra     = 0;
#	protected $in_lair      = 0;
#	protected $initiative   = 1;
#	protected $intelligence = 'Semi-';
#	protected $magic_user   = null;
#	protected $maximum_hp   = false;
#	protected $movement     = array( 'foot' => 15 );
	protected $name         = 'Boar Sounder';
#	protected $psionic      = 'Nil';
#	protected $race         = 'Boar';
#	protected $reference    = 'Monster Manual page 10';
#	protected $resistance   = 'Standard';
#	protected $saving       = array( 'fight' );
	protected $size         = "Small";
#	protected $specials     = array();
#	protected $treasure     = 'Nil';
#	protected $xp_value     = array( 0, 0, 0, 0 );


	protected function determine_hit_dice() {
		$this->description = 'Wild Boar: If more than 1 is encountered the others will be sows (3 hit dice, 2-8 hit points damage/attack), on a 1 :4, sows: sounders, ratio. Thus if 12 are encountered there will be 1 boar, 3 sows, and 8 young. The boar will fight for 2-5 melee rounds after reaching 0 to -6 hit points but dies immediately at -7 or greater damage.';
	}


}

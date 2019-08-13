<?php
/* Name: Water Beetle
 * Class: DND_Monster_Beetle_Water
 * Encounter: {"TF":{"S":"R","D":"C"},"TSF":{"S":"R","D":"C"}}
 */

class DND_Monster_Beetle_Water extends DND_Monster_Beetle_Beetle {


#	protected $alignment    = 'Neutral';
	protected $appearing    = array( 1, 12, 0 );
#	protected $armor_class  = 3;
#	protected $armor_type   = 11;
	protected $attacks      = array( 'Bite' => [ 3, 6, 0 ] );
#	public    $current_hp   = 0;
#	protected $description  = '';
#	protected $frequency    = 'Common';
#	protected $hd_minimum   = 1;
#	protected $hd_value     = 8;
	protected $hit_dice     = 4;
#	protected $hit_points   = 0;
#	protected $hp_extra     = 0;
#	protected $in_lair      = 0;
#	protected $initiative   = 1;
#	protected $intelligence = 'Non-';
#	protected $magic_user   = null;
#	protected $maximum_hp   = false;
	protected $movement     = array( 'foot' => 3, 'swim' => 12 );
	protected $name         = 'Giant Water Beetle';
#	protected $psionic      = 'Nil';
#	protected $race         = 'Beetle';
#	protected $reference    = 'Monster Manual page 8';
#	protected $resistance   = 'Standard';
#	protected $saving       = array( 'fight' );
	protected $size         = "Large (6' long)";
#	protected $specials     = array();
#	protected $treasure     = 'Nil';
#	protected $xp_value     = array( 0, 0, 0, 0 );


	protected function determine_hit_dice() {
		$this->description = "The giant water beetle is found only in fresh water of not less than 30' deep. As they are voracious eaters, they prey upon virtually any form of animal but will eat almost anything. Slow and ponderous on land, they move very quickly in water. Giant water beetles hunt food by scent and vibration.";
	}


}

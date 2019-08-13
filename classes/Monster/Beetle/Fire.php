<?php
/* Name: Fire Beetle
 * Class: DND_Monster_Beetle_Fire
 * Encounter: {"TC":{"M":"R","H":"R","F":"C","S":"R"},"TW":{"M":"R","H":"R","F":"C","S":"R"},"TSC":{"M":"R","H":"R","F":"C","S":"R"}}
 */

class DND_Monster_Beetle_Fire extends DND_Monster_Beetle_Beetle {


#	protected $alignment    = 'Neutral';
#	protected $appearing    = array( 3, 4, 0 );
	protected $armor_class  = 4;
#	protected $armor_type   = 11;
	protected $attacks      = array( 'Bite' => [ 2, 4, 0 ] );
#	public    $current_hp   = 0;
#	protected $description  = '';
#	protected $frequency    = 'Common';
#	protected $hd_minimum   = 1;
#	protected $hd_value     = 8;
	protected $hit_dice     = 1;
#	protected $hit_points   = 0;
	protected $hp_extra     = 2;
#	protected $in_lair      = 0;
#	protected $initiative   = 1;
#	protected $intelligence = 'Non-';
#	protected $magic_user   = null;
#	protected $maximum_hp   = false;
#	protected $movement     = array( 'foot' => 12 );
	protected $name         = 'Giant Fire Beetle';
#	protected $psionic      = 'Nil';
#	protected $race         = 'Beetle';
#	protected $reference    = 'Monster Manual page 8';
#	protected $resistance   = 'Standard';
#	protected $saving       = array( 'fight' );
	protected $size         = "Small ( 2.5' Long )";
#	protected $specials     = array();
#	protected $treasure     = 'Nil';
#	protected $xp_value     = array( 0, 0, 0, 0 );


	protected function determine_hit_dice() {
		$this->description = "The smallest of the giant beetles, fire beetles, nevertheless are capable of delivering serious damage with their powerful mandibles. They are found both above and below ground, being primarily nocturnal. Fire beetles have two glands above their eyes and one near the back of their abdomen which give off a red glow. Far this reason they are highly prized by miners and adventurers, as this luminosity will persist for from 1 - 6 days after the glands are removed from the beetle. The light shed illuminates a 10' radius.";
	}


}

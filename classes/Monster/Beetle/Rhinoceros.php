<?php
/* Name: Rhinoceros Beetle
 * Class: DND_Monster_Beetle_Rhinoceros
 * Encounter: {
"TSW"{"H":"VR","F":"U","S":"VR"
}
 */

class DND_Monster_Beetle_Rhinoceros extends DND_Monster_Beetle_Beetle {


#	protected $alignment    = 'Neutral';
	protected $appearing    = array( 1, 6, 0 );
	protected $armor_class  = 2;
#	protected $armor_type   = 11;
	protected $attacks      = array( 'Horn' => [ 3, 6, 0 ], 'Bite' => [ 2, 8, 0 ] );
#	public    $current_hp   = 0;
#	protected $description  = '';
	protected $frequency    = 'Uncommon';
#	protected $hd_minimum   = 1;
#	protected $hd_value     = 8;
	protected $hit_dice     = 12;
#	protected $hit_points   = 0;
#	protected $hp_extra     = 0;
#	protected $in_lair      = 0;
#	protected $initiative   = 1;
#	protected $intelligence = 'Non-';
#	protected $magic_user   = null;
#	protected $maximum_hp   = false;
	protected $movement     = array( 'foot' => 6 );
	protected $name         = 'Giant Rhinoceros Beetle';
#	protected $psionic      = 'Nil';
#	protected $race         = 'Beetle';
#	protected $reference    = 'Monster Manual page 8';
#	protected $resistance   = 'Standard';
#	protected $saving       = array( 'fight' );
	protected $size         = "Large (12' Long plus horn)";
#	protected $specials     = array();
#	protected $treasure     = 'Nil';
#	protected $xp_value     = array( 0, 0, 0, 0 );


	protected function determine_hit_dice() {
		$this->description = "This uncommon monster inhabits tropical and subtropical jungles. They roam these regions searching for fruits and vegetation, crushing anything in their paths. The horn of a giont rhinoceros beetle extends about 6'.";
	}


}

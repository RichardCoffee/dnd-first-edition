<?php
/* Name: Stag Beetle
 * Class: DND_Monster_Invertebrates_Beetle_Stag
 * Encounter: {"TC"{"H":"R","F":"C","P":"C"},"TW"{"H":"R","F":"C","P":"C"}}
 */

class DND_Monster_Invertebrates_Beetle_Stag extends DND_Monster_Invertebrates_Beetle_Beetle {


#	protected $alignment    = 'Neutral';
	protected $appearing    = array( 2, 6, 0 );
#	protected $armor_class  = 3;
#	protected $armor_type   = 11;
	protected $attacks      = array( 'Bite' => [ 4, 4, 0 ], 'Horn L' => [ 1, 10, 0 ], 'Horn R' => [ 1, 10, 0 ] );
#	public    $current_hp   = 0;
#	protected $description  = '';
#	protected $frequency    = 'Common';
#	protected $hd_minimum   = 1;
#	protected $hd_value     = 8;
	protected $hit_dice     = 7;
#	protected $hit_points   = 0;
#	protected $hp_extra     = 0;
#	protected $in_lair      = 0;
#	protected $initiative   = 1;
#	protected $intelligence = 'Non-';
#	protected $magic_user   = null;
#	protected $maximum_hp   = false;
	protected $movement     = array( 'foot' => 6 );
	protected $name         = 'Giant Stag Beetle';
#	protected $psionic      = 'Nil';
#	protected $race         = 'Beetle';
#	protected $reference    = 'Monster Manual page 8';
#	protected $resistance   = 'Standard';
#	protected $saving       = array( 'fight' );
	protected $size         = "Large (10' Long)";
#	protected $specials     = array();
#	protected $treasure     = 'Nil';
#	protected $xp_value     = array( 0, 0, 0, 0 );


	protected function determine_hit_dice() {
		$this->description = "These woodland dwelling beetles are very fond of grains and similar growing crops, so they will sometimes become highly pestiferous and raid cultivated lands. Like other beetles, they have poor sight and hearing, but they will fight if attacked or attack if they encounter organic material they consider food. The giant stag beetle's two horns are usually not less than 8' long.";
	}


}

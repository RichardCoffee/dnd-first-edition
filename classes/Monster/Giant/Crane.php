<?php
/* Name: Crane, Giant
 * Class: DND_Monster_Giant_Crane
 * Encounter: {"TC":{"S":"R"},"TW":{"S":"R"},"TSC":{"S":"R"},"TSW":{"S":"R"},"TF":{"S":"R"},"TS":{"S":"R"},"TSF":{"S":"R"},"TSS":{"S":"R"}}
 */

class DND_Monster_Giant_Crane extends DND_Monster_Monster {


#	protected $alignment    = 'Neutral';
	protected $appearing    = array( 1, 20, 0 );
	protected $armor_class  = 5;
#	protected $armor_type   = 11;
	protected $attacks      = array( 'Beak' => [ 1, 10, 0 ] );
	protected $frequency    = 'Rare';
#	protected $initiative   = 1;
#	protected $intelligence = 'Animal';
	protected $movement     = array( 'foot' => 9, 'air' => 18 );
	protected $name         = 'Giant Crane';
#	protected $psionic      = 'Nil';
	protected $race         = 'Crane';
	protected $reference    = 'Monster Manual II page 26';
#	protected $resistance   = 'Standard';
#	protected $size         = 'Medium';
#	protected $treasure     = 'Nil';
	protected $xp_value     = array( 35, 3 );


	protected function determine_hit_dice() {
		$this->hit_dice = 3;
	}


}

<?php
/* Name: Clubnek
 * Class: DND_Monster_Animal_Bird_Flightless_Clubnek
 * Encounter: {"TW":{"H":"VR","F":"U","S":"VR","P":"U","D":"VR"}}
 */

class DND_Monster_Animal_Bird_Flightless_Clubnek extends DND_Monster_Animal_Bird_Flightless_Ostrich {


#	protected $alignment    = 'Neutral';
	protected $appearing    = array( 2, 8, 0 );
	protected $armor_class  = 8;
#	protected $armor_type   = 11;
	protected $attacks      = array( 'Beak' => [ 1, 8, 0 ], 'Claw Right' => [ 1, 6, 0 ], 'Claw Left' => [ 1, 6, 0 ] );
#	public    $current_hp   = 0;
#	protected $description  = '';
#	protected $frequency    = 'Common';
#	protected $hd_minimum   = 1;
#	protected $hd_value     = 8;
	protected $hit_dice     = 2;
#	protected $hit_points   = 0;
#	protected $hp_extra     = 0;
#	protected $in_lair      = 0;
#	protected $initiative   = 1;
	protected $intelligence = 'Low';
#	protected $magic_user   = null;
#	protected $maximum_hp   = false;
	protected $movement     = array( 'foot' => 12 );
	protected $name         = 'Clubnek';
#	protected $psionic      = 'Nil';
#	protected $race         = 'Flightless Bird';
	protected $reference    = 'Fiend Folio page 19';
#	protected $resistance   = 'Standard';
#	protected $saving       = array( 'fight' );
#	protected $size         = 'Medium';
#	protected $specials     = array();
#	protected $treasure     = 'Nil';
	protected $xp_value     = array( 20, 2, 0, 0 );


	protected function determine_hit_dice() {
		$this->description = 'These creatures are mutated forms of the ostrich with hard bony beaks which can inflict 1-8 hit points of damage. They also fight with their two claws, each of which inflicts 1-6 hit points of damage.
They can make occasional bursts of high speed and can achieve a movement rate of 24" one melee round in every five.
Clubneks are coloured varying shades of green and have yellow beaks. They are not normally aggressive unless threatened, but their behaviour is rather erratic and unpredictable. Normally they are herbivorous and are rarely found below the ground, preferring to roam meadowland and woods.';
	}

	protected function determine_specials() {
		parent::determine_specials();
		$this->specials['movement'] = 'One round in five movement is 24"';
	}


}

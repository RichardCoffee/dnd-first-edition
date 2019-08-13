<?php
/* Name: Death Watch Beetle
 * Class: DND_Monster_Beetle_DeathWatch
 * Encounter: {"TW":{"F":"VR"."S":"VR","P":"VR"}}
 */

class DND_Monster_Beetle_DeathWatch extends DND_Monster_Beetle_Beetle {


#	protected $alignment    = 'Neutral';
	protected $appearing    = array( 1, 1, 0 );
#	protected $armor_class  = 3;
#	protected $armor_type   = 11;
	protected $attacks      = array( 'Bite' => [ 3, 4, 0 ] );
#	public    $current_hp   = 0;
#	protected $description  = '';
	protected $frequency    = 'Very Rare';
#	protected $hd_minimum   = 1;
#	protected $hd_value     = 8;
	protected $hit_dice     = 9;
#	protected $hit_points   = 0;
#	protected $hp_extra     = 0;
	protected $in_lair      = 10;
#	protected $initiative   = 1;
	protected $intelligence = 'Animal';
#	protected $magic_user   = null;
#	protected $maximum_hp   = false;
#	protected $movement     = array( 'foot' => 12 );
	protected $name         = 'Giant Death Watch Beetle';
#	protected $psionic      = 'Nil';
#	protected $race         = 'Beetle';
	protected $reference    = 'Monster Manual II page 17';
#	protected $resistance   = 'Standard';
#	protected $saving       = array( 'fight' );
	protected $size         = "Large (5' long)";
#	protected $specials     = array();
#	protected $treasure     = 'Nil';
#	protected $xp_value     = array( 1400, 12, 0, 0 );


	protected function determine_hit_dice() {
		$this->description = "This monstrous insect is found in temperate regions. It is particularly dreaded as it often disguises itself.These disguises range from wearing carapaces of other giant beetles tosticking rubbish to itself with a glue of earth and saliva. Although commonly encountered outdoors, death watch beetles of the giant sort have also been known to invade subterranean areas in search of food.";
		$this->description = "\n\nThe normal attack of a death watch beetle is by biting with its great mandibles. Before such an attack, however, the monster will make a clicking sound with its carapace. This sound produces sonic vibrations which are deadly. Creatures within a 30-foot radius must save vs. death magic or die. Those saving must take from 5-20 points of damage. The clicking of the death watch resembles that of a drum or gong. As the sound is diffused and seems to come from everywhere, location of the monster thereby is 90% unlikely. After 1 round, the vibrations have the stated effect. The effort required to produce the killing vibrations is such that the monster is able to perform the clicking only once every 2-5 hours.";
		$this->description = "\n\nAs a death watch moves frequently in search of food, it is unlikely that it will have treasure, other than an incidental item possibly stuck upon its back as camouflage. Even if a beetle stays in one locale for an extended period (10% chance) only the treasure carried by victims slain by the monster will be in the area.";
	}

	protected function determine_specials() {
		parent::determine_specials();
		$this->specials['vibration'] = 'Death vibrations.  Save vs death magic or die, success suffers 5d4 damage.';
	}


}

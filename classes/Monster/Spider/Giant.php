<?php
/* Name: Spider, Giant
 * Class: DND_Monster_Spider_Giant
 * Encounter: {"TC":{"M":"VR","H":VR","F":"U"},"TW":{"M":"VR","F":"U"},"TSC":{"M":"VR","H":VR","F":"U"},"TSW":{"M":"VR","H":VR","F":"U"}}
 */

class DND_Monster_Spider_Giant extends DND_Monster_Spider_Spider {


	protected $alignment    = 'Chaotic Evil';
	protected $appearing    = array( 1, 8, 0 );
	protected $armor_class  = 4;
#	protected $armor_type   = 11;
	protected $attacks      = array( 'Bite' => [ 2, 4, 0 ] );
	protected $frequency    = 'Uncommon';
	protected $hp_extra     = 4;
	protected $in_lair      = 70;
#	protected $initiative   = 1;
	protected $intelligence = 'Low';
	protected $movement     = array( 'foot' => 3, 'web' => 12 );
	protected $name         = 'Giant Spider';
#	protected $psionic      = 'Nil';
	protected $race         = 'Spider';
	protected $reference    = 'Monster Manual page 88';
#	protected $resistance   = 'Standard';
	protected $size         = 'Large';
#	protected $specials     = array();
	protected $treasure     = 'C';
#	protected $xp_value     = array();


	protected function determine_hit_dice() {
		$this->hit_dice = 4;
		$this->description = 'These monsters are web builders. They will construct their sticky traps horizontally or vertically so as to entrap any creature which touches the web. Some will lurk above a path in order to drop upon prey. The web is as tough and clinging as a web spell. Any creature with 18 or greater strength con break free in 1 melee round, a 17 strength requires 2 melee rounds, etc. Webs are quite inflammable.  The bite of a giant spider is poisonous. A victim must save versus poison or be killed. A giant spider will flee from an encounter with a superior foe, typically hiding in some secret spot for safety.';
	}

	protected function determine_specials() {
		$this->specials = array(
			'bite_poison' => 'Bite victim must save versus poison or die.',
		);
	}


}

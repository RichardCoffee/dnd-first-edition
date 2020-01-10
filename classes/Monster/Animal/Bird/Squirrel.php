<?php
/* Name: Carnivorous Flying Squirrel
 * Class: DND_Monster_Animal_Bird_Squirrel
 * Encounter: {"CW":{"M":"VR","F":"R"},"TW":{"M":"VR","F":"R"}}
 */

class DND_Monster_Animal_Bird_Squirrel extends DND_Monster_Animal_Squirrel {


#	protected $alignment    = 'Neutral';
	protected $appearing    = array( 3, 6, 0 );
	protected $armor_class  = 7;
#	protected $armor_type   = 11;
	protected $attacks      = array( 'Bite' => [ 1, 2, 0 ] );
#	public    $current_hp   = 0;
#	protected $description  = '';
	protected $frequency    = 'Rare';
#	protected $hd_minimum   = 1;
	protected $hd_value     = 7;
#	protected $hit_dice     = 0;
#	protected $hit_points   = 0;
#	protected $hp_extra     = 0;
	protected $in_lair      = 40;
#	protected $initiative   = 1;
#	protected $intelligence = 'Animal';
#	protected $magic_user   = null;
#	protected $maximum_hp   = false;
	protected $movement     = array( 'foot' => 9, 'air' => 15 );
	protected $name         = 'Carnivorous Flying Squirrel';
#	protected $psionic      = 'Nil';
#	protected $race         = 'Squirrel';
#	protected $reference    = 'Monster Manual II page 114';
#	protected $resistance   = 'Standard';
#	protected $saving       = array( 'fight' );
	protected $size         = "Small (1/2' long)";
#	protected $specials     = array();
#	protected $treasure     = 'Nil';
	protected $xp_value     = array( 10, 1, 0, 0 );


	protected function determine_hit_dice() {
		$this->hit_dice = 1;
		$this->description = 'Flying squirrels "fly" by means of loose folds of skin on the inside of their fore and rear legs. In fact, they can only glide and cannot gain altitude once they have jumped. Their range is 5 feet for every foot of altitude from which they jump (usually a tree). If surprise is achieved during a flying attack, they make their initial attack as 2 hit dice monsters. They attack only when they have 2 to 1 odds or better. In their lair, a tree top nest, there can occasionally be found gems, jewelry and other small items that are bright and shiny. Thus, they could never have armor, shields, most weapons, potions, etc. Treasure is incidental only.';
	}

	protected function determine_specials() {
		parent::determine_specials();
		$this->specials['surprise'] = 'On successful surprise, initial attack is as 2 HD creature.';
	}


}

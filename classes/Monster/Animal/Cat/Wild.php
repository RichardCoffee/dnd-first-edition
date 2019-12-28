<?php
/* Name: Cat
 * Class: DND_Monster_Animal_Cat_Wild
 * Encounter: {}
 */

class DND_Monster_Animal_Cat_Wild extends DND_Monster_Animal_Cat_Domestic {


#	protected $alignment    = 'Neutral';
	protected $appearing    = array( 1, 4, 1 );
	protected $armor_class  = 5;
#	protected $armor_type   = 11;
	protected $attacks      = array( 'Bite' => [ 1, 2, 0 ], 'Right Claw' => [ 1, 2, 0 ], 'Left Claw' => [ 1, 2, 0 ] );
#	public    $current_hp   = 0;
#	protected $description  = '';
	protected $frequency    = 'Uncommon';
#	protected $hd_minimum   = 1;
	protected $hd_value     = 8;
#	protected $hit_dice     = 0;
#	protected $hit_points   = 0;
#	protected $hp_extra     = 0;
#	protected $in_lair      = 0;
#	protected $initiative   = 1;
#	protected $intelligence = 'Animal';
#	protected $magic_user   = null;
#	protected $maximum_hp   = false;
	protected $movement     = array( 'foot' => 18 );
	protected $name         = 'Wild Cat';
#	protected $psionic      = 'Nil';
#	protected $race         = 'Cat';
#	protected $reference    = 'Monster Manual II page 22';
#	protected $resistance   = 'Standard';
#	protected $saving       = array( 'fight' );
#	protected $size         = 'Small';
#	protected $specials     = array();
#	protected $treasure     = 'Nil';
	protected $xp_value     = array( 10, 1, 0, 0 );


	protected function determine_hit_dice() {
		$this->hit_dice = 1;
		$this->description = 'Domestic and wild cats are closely related and most species can interbreed. Domestic cats are found nearly everywhere in temperate to tropical climes; some have "gone wild." Wild cats are found from sub-arctic to tropical regions. The smaller domestic variety has only 1 effective attack with forepawclaws, while the larger wild cat has 2 .such attacks. Both gain rear claw rakes if forepaw claw attacks succeed in hitting the opponent. From a domestic cat, rear claw rakes inflict 1-2 points of damage and from a wild cat 1-2/1-2 points of damage.
Both sorts of felines surprise prey on 3 in 6. Both are surprised only on a 1 in 6. Both species are agile climbers and can move up and along tree limbs at half their normal movement rate. Domestic cats will not normally attack medium or large creatures.';
	}

	protected function determine_specials() {
		parent:determine_specials();
		$this->specials['rearclaws'] = 'Rear claws do 1-2/1-2';
	}

}

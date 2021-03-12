<?php
/* Name: Spider, Large
 * Class: DND_Monster_Invertebrates_Spider_Large
 * Encounter: {"TC":{"M":"C","H":"C","F":"C","S":"C","P":"C","D":"C"},"TW":{"M":"C","H":"C","F":"C","S":"C","P":"C","D":"C"},"TSC":{"M":"C","H":"C","F":"C","S":"C","P":"C","D":"C"},"TSW":{"M":"C","H":"C","F":"C","S":"C","P":"C","D":"C"}}
 */

class DND_Monster_Invertebrates_Spider_Large extends DND_Monster_Invertebrates_Spider_Spider {


#	protected $alignment    = 'Neutral';
	protected $appearing    = array( 2, 10, 0 );
	protected $armor_class  = 8;
#	protected $armor_type   = 11;
	protected $attacks      = array( 'Bite' => [ 2, 4, 0 ] );
	protected $frequency    = 'Common';
	protected $hit_dice     = 1;
	protected $hp_extra     = 1;
	protected $in_lair      = 60;
#	protected $initiative   = 1;
	protected $intelligence = 'Non-';
	protected $movement     = array( 'foot' => 6, 'web' => 15 );
	protected $name         = 'Large Spider';
#	protected $psionic      = 'Nil';
	protected $race         = 'Spider';
	protected $reference    = 'Monster Manual page 88';
#	protected $resistance   = 'Standard';
	protected $size         = 'Small';
#	protected $specials     = array();
	protected $treasure     = 'J-N';
#	protected $xp_value     = array();


	protected function determine_hit_dice() {
		$this->description = '';
	}

	protected function determine_specials() {
		$this->specials = array(
			'bite_poison' => 'Bite victim must save versus poison (+2) or die.',
		);
	}

	public function monster_damage_string( $target ) {
		add_filter( "dnd1e_object_Poison_saving_throws", [ $this, 'large_spider_poison_bite' ], 10, 3 );
		$st = $target->saving_throw( 'Poison' );
		remove_filter( "dnd1e_object_Poison_saving_throws", [ $this, 'large_spider_poison_bite' ], 10, 3 );
		if ( $st ) {
			return sprintf( '%s must make a saving throw versus Poison - %d', $target->get_name, $st );
		}
		return false;
	}

	public function large_spider_poison_bite( $base, $target, $effect ) {
		return $base - 2;
	}


}

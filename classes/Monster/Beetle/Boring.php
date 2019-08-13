<?php
/* Name: Boring Beetle
 * Class: DND_Monster_Beetle_Boring
 * Encounter: {"TW":{"M":"R","H":"R","F":"C","S":"R"},"TSW":{"M":"R","H":"R","F":"C","S":"R"}}
 */

class DND_Monster_Beetle_Boring extends DND_Monster_Beetle_Beetle {


#	protected $alignment    = 'Neutral';
	protected $appearing    = array( 3, 6, 0 );
#	protected $armor_class  = 3;
#	protected $armor_type   = 11;
	protected $attacks      = array( 'Bite' => [ 5, 4, 0 ] );
#	public    $current_hp   = 0;
#	protected $description  = '';
#	protected $frequency    = 'Common';
#	protected $hd_minimum   = 1;
#	protected $hd_value     = 8;
	protected $hit_dice     = 5;
#	protected $hit_points   = 0;
#	protected $hp_extra     = 0;
	protected $in_lair      = 40;
#	protected $initiative   = 1;
	protected $intelligence = 'Animal';
#	protected $magic_user   = null;
#	protected $maximum_hp   = false;
	protected $movement     = array( 'foot' => 6 );
	protected $name         = 'Giant Boring Beetle';
#	protected $psionic      = 'Nil';
#	protected $race         = 'Beetle';
#	protected $reference    = 'Monster Manual page 8';
#	protected $resistance   = 'Standard';
#	protected $saving       = array( 'fight' );
	protected $size         = "Large ( 9' Long )";
#	protected $specials     = array();
	protected $treasure     = 'C,R,S,T';
#	protected $xp_value     = array( 0, 0, 0, 0 );


	protected function determine_hit_dice() {
		$this->description = 'These beetles favor rotting wood and similar organic material upon which to feed, so they are usually found inside huge trees or in unused tunnel complexes underground. In the latter areas they will grow molds, slimes and fungi substances for food, starting such cultures on various forms of decaying vegetable and animal matter and wastes. These creatures are individually not of much greater intelligence than others of their kind, but it is rumored that groups develop a communal intelligence which generates a level of consciousness and reasoning ability approximating that of the human brain.';
	}


}

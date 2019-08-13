<?php
/* Name: Wolfwere
 * Class: DND_Monster_Lycan_Wolfwere
 * Encounter: {"CW":{"M":"R","H":"VR","F":"R","S":"R","P":"R","D":"R"},"TW":{"M":"R","H":"VR","F":"R","S":"R","P":"R","D":"R"},"TSW":{"M":"R","H":"VR","F":"R","S":"R","P":"R","D":"R"}}
 */

class DND_Monster_Lycan_Wolfwere extends DND_Monster_Monster {


	protected $alignment    = 'Chaotic Evil';
	protected $appearing    = array( 1, 3, 0 );
	protected $armor_class  = 3;
#	protected $armor_type   = 11;
	protected $attacks      = array( 'Bite' => array( 2, 6, 0 ), 'Voice' => array( 0, 0, 0 ) );
#	public    $current_hp   = 0;
#	protected $description  = '';
	protected $frequency    = 'Rare';
	protected $hit_dice     = 5;
#	protected $hd_minimum   = 1;
#	protected $hd_value     = 8;
#	protected $hit_points   = 0;
	protected $hp_extra     = 1;
	protected $in_lair      = 35;
#	public    $initiative   = 10;
	protected $intelligence = 'High to Exceptional';
#	protected $magic_user   = null;
#	protected $maximum_hp   = false;
	protected $movement     = array( 'foot' => 15 );
#	protected $name         = 'Monster';
#	protected $psionic      = 'Nil';
#	protected $race         = 'Monster';
#	protected $reference    = 'Monster Manual page';
	protected $resistance   = 10;
#	protected $saving       = array( 'fight' );
#	protected $size         = 'Medium';
#	protected $specials     = array();
	protected $treasure     = 'B';
	protected $xp_value     = array( 550, 6, 0, 0 );



	use DND_Monster_Trait_Defense_Weapons;


	public function __construct( $args = array() ) {
		$this->mtdw_iron = true;
		$this->mtdw_setup();
		parent::__construct( $args );
	}

	protected function determine_hit_dice() {
		$this->description = "Inhabiting out of the way places, the hated and feared wolfwere is the bane of humans and demihumans alike,for it is able to take the form of a human male or female of considerable charisma. In either its true shape or that of man, the wolfwere slyly hunts, slays, and devours its favored prey-men, halflings, elves, etc. A wolfwere will usually (75%) run with a pack of normal wolves (30%) or worgs (70%). When strong prey is encountered, the monster will slip away to its lair, don human garb, and approach the victims in the guise of a pilgrim, minstrel, tinker, or similar wanderer. Oftimes the wolfwere will carry a stringed instrument to play upon, so it's crooning will not arouse suspicion. The powerful jaws of this creature can deliver terrible bites. Additionally, the wolfwere can half-change, gain human-like arms and legs, and wield a human weapon. It can still bite in this form. Worst of all, however, is the monster's song.  Listeners are overcome with lethargy, just as if they had been slowed by a slow spell, unless each makes a saving throw vs. spells. The lethargy lasts for 5-8 rounds and cannot be countered once it takes effect. The monster can be hit only by cold-wrought iron weapons or those equal to +1 or better magic. It must be noted that a great enmity exists between wolfwere and werewolves. The wolfwere are disgusted by wolvesbane and shun it if possible.";
	}

	protected function determine_specials() {
		parent::determine_specials();
		$this->specials['spell_voice']      = 'Singing brings on lethargy, saving throw vs spells.';
		$this->specials['boolean_pack']     = '75% chance of being accompanied by a pack of wolves(30%) or worgs(70%)';
		$this->specials['boolean_treasure'] = '50% of also having treasure types S and T.';
	}

	public function specials_boolean_pack() {
		return $this->check_chance( 75 );
	}

	public function specials_boolean_treasure() {
		return $this->check_chance( 50 );
	}

	public function command_line_display() {
		$line = parent::command_line_display();
		$line.= $this->mtdw_command_line_display_string();
		return $line;
	}


}

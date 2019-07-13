<?php

class DND_Character_Paladin extends DND_Character_Fighter {

	private   $cleric     = null;
	protected $armr_allow = array( 'Banded', 'Bronze Plate', 'Chain', 'Elfin Chain', 'Field Plate', 'Full Plate', 'Plate Mail', 'Ring', 'Scale', 'Splint' );
	protected $has_horse  = false;
	protected $hit_die    = array( 'limit' => 9, 'size' => 10, 'step' => 3 );
	protected $non_prof   = -3;
	protected $stats      = array( 'str' => 12, 'int' => 9, 'wis' => 13, 'dex' => 3, 'con' => 9, 'chr' => 17 );
	protected $weap_init  = array( 'initial' => 3, 'step' => 3 );
	protected $xp_bonus   = array( 'str' => 16, 'wis' => 16 );
	protected $xp_step    = 350000;
	protected $xp_table   = array( 0, 2750, 5500, 12000, 24000, 45000, 95000, 175000, 350000 );


	public function initialize_character() {
		parent::initialize_character();
		if ( empty( $this->cleric ) ) {
			$this->cleric = new DND_Character_Cleric( [ 'level' => $this->level ] );
		}
	}

	protected function calculate_level( $xp ) {
		$level = parent::calculate_level( $xp );
		$this->cleric->set_level( $level );
		return $level;
	}

	protected function define_specials() {
		$this->specials = array(
			'string_detect'  => $this->special_string_detect(),
			'string_immune'  => $this->special_string_immune(),
			'integer_heal'   => sprintf( 'Lay on hands: %u hp, once daily.', $this->special_integer_heal() ),
			'integer_cure'   => sprintf( 'Cure disease: %u per week.', $this->special_integer_cure() ),
			'string_protect' => $this->special_string_protect(),
		);
		if ( ( $this->level > 3 ) && ( ! $this->has_horse ) ) {
			$this->special['boolean_warhorse'] = 'Summon Warhorse';
		}
		if ( $this->level > 2 ) {
			$this->specials = array_merge( $this->specials, $this->cleric->specials );
		}
	}

	private function special_string_detect() {
		return 'Detect evil up to 60 feet away.';
	}

	private function special_string_immune() {
		return 'Immune to disease.';
	}

	public function special_integer_heal() {
		return $this->level * 2;
	}

	public function special_integer_cure() {
		return ceil( $this->level / 5 );
	}

	private function special_string_protect() {
		return "Protection from evil 10' radius";
	}

	public function special_boolean_warhorse() {
		return $this->has_horse;
	}

	public function special_string_undead( $type, $level = 0 ) {
		return $this->cleric->special_string_undead( $type, $this->level - 2 );
	}

	public function get_undead_caps( $level = 0 ) {
		return $this->cleric->get_undead_caps( $this->level - 2 );
	}


}

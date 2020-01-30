<?php

class DND_Character_MagicUser extends DND_Character_Character {

	protected $ac_rows    = array( 0, 1, 1, 1, 2, 2, 3, 3, 3, 4, 4, 5, 5, 5, 6, 6, 7, 7, 7, 8, 8, 9 );
	protected $hit_die    = array( 'limit' => 11, 'size' => 4, 'step' => 1 );
	protected $non_prof   = -5;
	protected $stats      = array( 'str' => 3, 'int' => 9, 'wis' => 3, 'dex' => 6, 'con' => 3, 'chr' => 3 );
	protected $weap_allow = array( 'Caltrop', 'Dagger', 'Dagger,Thrown', 'Dart', 'Knife', 'Knife,Thrown', 'Sling', 'Spell', 'Staff,Quarter' );
	protected $weap_init  = array( 'initial' => 1, 'step' => 6 );
	protected $weapons    = array( 'Spell' => array( 'bonus' => 0, 'skill' => 'PF' ) );
	protected $xp_bonus   = array( 'int' => 16 );
	protected $xp_step    = 375000;
	protected $xp_table   = array( 0, 2500, 5000, 10000, 22500, 40000, 60000, 90000, 135000, 250000, 375000 );


	use DND_Character_Trait_Magic;
	use DND_Character_Trait_Spells_MagicUser;
	use DND_Character_Trait_Spells_Effects_MagicUser;


	public function __construct( $args = array() ) {
		parent::__construct( $args );
		if ( array_key_exists( 'spell_import', $args ) ) {
			$this->import_spell_list( $args['spell_import'] );
		}
		$this->calculate_manna_points();
		$this->add_replacement_filter( 'armor_type_replacement' );       // First level Armor spell
	}

	protected function define_specials() { }

	protected function get_saving_throw_table() {
		return $this->get_magic_saving_throw_table();
	}


	/**  Manna functions  **/

	protected function spells_usable_table() {
		return array(
			array(),
			array( 1 ),    // 1
			array( 2 ),    // 2
			array( 2, 1 ), // 3
			array( 3, 2 ), // 4
			array( 4, 2, 1 ),    // 5
			array( 4, 2, 2 ),    // 6
			array( 4, 3, 2, 1 ), // 7
			array( 4, 3, 3, 2 ), // 8
			array( 4, 3, 3, 2, 1 ), //  9
			array( 4, 4, 3, 2, 2 ), // 10
			array( 4, 4, 4, 3, 3 ), // 11
			array( 4, 4, 4, 4, 4, 1 ),    // 12
			array( 5, 5, 5, 4, 4, 2 ),    // 13
			array( 5, 5, 5, 4, 4, 2, 1 ), // 14
			array( 5, 5, 5, 5, 5, 2, 1 ), // 15
			array( 5, 5, 5, 5, 5, 3, 2, 1 ), // 16
			array( 5, 5, 5, 5, 5, 3, 3, 2 ), // 17
			array( 5, 5, 5, 5, 5, 3, 3, 2, 1 ), // 18
			array( 5, 5, 5, 5, 5, 3, 3, 3, 1 ), // 19
			array( 5, 5, 5, 5, 5, 4, 3, 3, 2 ), // 20
			array( 5, 5, 5, 5, 5, 4, 4, 4, 2 ), // 21
			array( 5, 5, 5, 5, 5, 5, 4, 4, 3 ), // 22
			array( 5, 5, 5, 5, 5, 5, 5, 5, 3 ), // 23
			array( 5, 5, 5, 5, 5, 5, 5, 5, 4 ), // 24
			array( 5, 5, 5, 5, 5, 5, 5, 5, 5 ), // 25
			array( 6, 6, 6, 6, 5, 5, 5, 5, 5 ), // 26
			array( 6, 6, 6, 6, 6, 6, 6, 5, 5 ), // 27
			array( 6, 6, 6, 6, 6, 6, 6, 6, 6 ), // 28
			array( 7, 7, 7, 7, 6, 6, 6, 6, 6 ), // 29
		);
	}


	/**  Spell functions  **/

	public function magicuser_first_armor( $spell, $target ) {
		# TODO: may need to test for other condition - see spell description: UA 51
		if ( $target->armor_type === 10 ) {
			$spell->add_filter( [ 'armor_type_replacement', 8, 10, 2 ] );
		} else {
			$spell->add_filter( [ 'armor_class_adjustments', 1, 10, 2 ] );
		}
	}

	public function magicuser_second_mirror_image( $spell, $num ) {
		if ( ( $spell->get_name() === 'Mirror Image' ) && empty( $this->effects ) ) {
			$spell->effects['images'] = intval( $num );
		}
echo "mirror images: {$spell->effects['images']}\n";
	}

	public function mirror_image_number( $string, $object, $spell ) {
		if ( $this === $object ) {
			if ( $spell->effects['images'] > 0 ) {
				$string .= $spell->effects['images'];
			}
		}
		return $string;
	}

	public function mirror_image_target( $damage, $target, $type, $spell ) {
		if ( $this === $target ) {
			if ( $spell->effects['images'] > 0 ) {
				$roll = mt_rand( 1, $spell->effects['images'] + 1 );
echo "mirror image target: $roll\n";
				if ( $roll > 1 ) {
					$spell->effects['images']--;
					if ( $spell->effects['images'] < 1 ) {
						$spell->remove_filter( 'dnd1e_damage_to_target' );
						$spell->remove_filter( 'dnd1e_object_status' );
					}
					return 0;
				}
			}
		}
		return $damage;
	}


}

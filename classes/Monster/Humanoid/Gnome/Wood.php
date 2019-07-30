<?php
/* Name: Wood Gnome
 * Class: DND_Monster_Humanoid_Gnome_Wood
 * Encounter: {"CW":{"M":"VR","H":"R","F":"VR"},"TW":{"M":"VR","H":"R","F":"VR"},"TSW":{"M":"VR","H":"R","F":"VR"}}
 */
class DND_Monster_Humanoid_Gnome_Wood extends DND_Monster_Humanoid_Gnome_Gnome {


	protected $name = 'Wood Gnome';

	protected function weapon_choices( $level = 1 ) {
		$max  = 100 - ( ( $level - 1 ) * 10 );
		$roll = mt_rand( 1, $max );
		if ( $roll < 11 ) {
			$carry = array( 'Bow,Short', 'Sword,Short' );
		} else if ( $roll < 31 ) {
			$carry = array( 'Sword,Short', 'Spear', 'Spear,Thrown' );
		} else if ( $roll < 46 ) {
			$carry = array( 'Club', 'Sword,Short' );
		} else if ( $roll < 86 ) {
			$carry = array( 'Club', 'Spear', 'Spear,Thrown' );
		} else {
			$carry = array( 'Club', 'Sling' );
		}
		$weapons = array();
		$single  = array( 'bonus' => 0, 'skill' => 'PF' );
		foreach( $carry as $weap ) {
			$weapons[ $weap ] = $single;
			if ( ( $level > 1 ) && ( ! in_array( $weap, [ 'Club', 'Sling' ] ) ) ) {
				if ( $this->check_chance( $level * 10 ) ) {
					$weapons[ $weap ]['bonus'] = mt_rand( 1, min( 5, ceil( $level / 4 ) ) );
				}
			}
		}
		return $weapons;
	}



}

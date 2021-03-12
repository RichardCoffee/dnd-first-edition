<?php
/*
 *
 */
class DND_DieRolls {


	public function get_crit_result( $roll, $type = 's' ) {
		$roll  = min( 100, max( 1, intval( $roll, 10 ) ) );
		$type  = ( in_array( $type, [ 's', 'b', 'p' ] ) ) ? $type : 's';
		$crits = $this->crit_table();
		foreach( $crits as $key => $types ) {
			if ( $roll > $key ) continue;
			return $types[ $type ];
		}
		return "no result found for $roll%";
	}

	public function get_fumble_result( $roll ) {
		$roll = min( 100, max( 1, intval( $roll, 10 ) ) );
		$fums = $this->fumble_table();
		foreach( $fums as $key => $fumble ) {
			if ( $roll > $key ) continue;
			return $fumble;
		}
		return "no result found for $roll%";
	}

	private function crit_table() {
		$severe = 'Damage x4, roll percentiles for additional effects';
		return array(
			40 => array(
				's' => 'Damage x2',
				'b' => 'Damage x2',
				'p' => 'Damage x2',
			),
			49 => array(
				's' => 'Damage x2, shield/armor damaged, -1 AC',
				'b' => 'Damage x2, shield/armor damaged, -1 AC',
				'p' => 'Damage x2, roll less than DEX on d20 or be knocked down',
			),
			50 => array(
				's' => '+1d100 damage',
				'b' => '+1d100 damage',
				'p' => '+1d100 damage',
			),
			70 => array(
				's' => 'Damage x3',
				'b' => 'Damage x3',
				'p' => 'Damage x3',
			),
			85 => array(
				's' => 'Damage x3, shield/armor damaged, -2 AC',
				'b' => 'Damage x3, shield/armor damaged, -2 AC',
				'p' => 'Damage x3, roll less than 2/3 DEX (rounded up) on d20 or be knocked down',
			),
			93 => array(
				's' => 'Damage x4',
				'b' => 'Damage x4',
				'p' => 'Damage x4',
			),
			94 => array(
				's' => array(
					'damage' => $severe,
					'effect' => array(
						50  => 'Hand slashed open, -1 combat',
						85  => 'Lose 1 finger, -2 combat',
						100 => 'Lose 1d4 fingers, hand incapacitated',
					),
				),
				'b' => array(
					'damage' => $severe,
					'effect' => array(
						50  => 'Hand smashed, -1 to combat, lose next attack',
						85  => '1d4 fingers broken, hand incapacitated, lose next 2 attacks',
						100 => 'Hand broken, hand incapacitated, lose next 3 attacks',
					),
				),
				'p' => array(
					'damage' => $severe,
					'effect' => array(
						50  => 'Punctured muscle in hand, -1 combat',
						85  => 'Punctured through hand, -2 combat',
						100 => 'Muscle pierced, hand incapacitated',
					),
				),
			),
			95 => array(
				's' => array(
					'damage' => $severe,
					'effect' => array(
						75  => 'Foot slashed open, 1/2 movement',
						100 => 'Lose 1d2 toes, 1/2 movement',
					),
				),
				'b' => array(
					'damage' => $severe,
					'effect' => array(
						75  => 'Toe crushed, 1/2 movement',
						100 => 'Foot smashed, 1/4 movement',
					),
				),
				'p' => array(
					'damage' => $severe,
					'effect' => array(
						75  => 'Punctured muscle in foot, 1/2 movement',
						100 => 'Foot pierced, 1/4 movement',
					),
				),
			),
			96 => array(
				's' => array(
					'damage' => $severe,
					'effect' => array(
						85  => 'Leg slashed open, 1/2 movement',
						90  => 'Leg removed at ankle, opponent falls',
						95  => 'Leg removed at knee, opponent falls',
						100 => 'Leg removed just below hip, opponent falls',
					),
				),
				'b' => array(
					'damage' => $severe,
					'effect' => array(
						85  => 'Crushed thigh, roll DEX or fall, 1/2 movement',
						90  => 'Broken shin, opponent falls, 1/4 movement',
						95  => 'Broken knee, 1/4 movement',
						100 => 'Broken hip bone, opponent falls, 1/4 movement',
					),
				),
				'p' => array(
					'damage' => $severe,
					'effect' => array(
						85  => 'Punctured thigh, roll DEX or fall, 1/2 movement',
						90  => 'Punctured thigh, roll DEX or fall, 1/4 movement',
						95  => 'Split knee, opponent falls, 1/2 movement',
						100 => 'Split knee, opponent falls, 1/4 movement',
					),
				),
			),
			97 => array(
				's' => array(
					'damage' => $severe,
					'effect' => array(
						50  => 'Wrist removed',
						75  => 'Elbow removed',
						100 => 'Arm removed',
					),
				),
				'b' => array(
					'damage' => $severe,
					'effect' => array(
						50  => 'Broken wrist, drop item',
						75  => 'Broken elbow, drop item',
						100 => 'Broken shoulder, drop item',
					),
				),
				'p' => array(
					'damage' => $severe,
					'effect' => array(
						50  => 'Pierced wrist, -1 combat',
						75  => 'Pierced elbow, -1 combat',
						100 => 'Pierced shoulder, -1 combat',
					),
				),
			),
			98 => array(
				's' => array(
					'damage' => $severe,
					'effect' => array(
					50  => 'Abdomen ripped open, guts hanging out, roll STR or fall',
					75  => 'Abdomen ripped open, guts hanging out, stunned 1d4 rounds',
					100 => 'Abdomen ripped open, death ensues',
					),
				),
				'b' => array(
					'damage' => $severe,
					'effect' => array(
						50  => 'Smashed guts, roll STR or fall',
						75  => 'Crushed guts, stunned 1d4 rounds',
						100 => 'Pulped guts, death ensues',
					),
				),
				'p' => array(
					'damage' => $severe,
					'effect' => array(
						50  => 'Punctured guts, roll STR or fall',
						75  => 'Stabbed guts, stunned 1d4 rounds',
						100 => 'Stabbed guts, death ensues',
					),
				),
			),
			99 => array(
				's' => array(
					'damage' => $severe,
					'effect' => array(
						20  => 'Lung slashed, -1 combat',
						40  => 'Rib broken, stunned 1d4 rounds',
						60  => 'Chest slashed open, -2 combat',
						80  => 'Chest slashed open, death ensues',
						100 => 'Throat cut, death ensues',
					),
				),
				'b' => array(
					'damage' => $severe,
					'effect' => array(
						20  => 'Shoulder smashed, -1 combat',
						40  => 'Ribs broken, stunned 1d4 rounds',
						60  => 'Shoulder crushed, -2 combat',
						80  => 'Chest crushed, death ensues',
						100 => 'Chest crushed, death ensues',
					),
				),
				'p' => array(
					'damage' => $severe,
					'effect' => array(
						20  => 'Lung pierced, -1 combat',
						40  => 'Lung pierced, stunned 1d4 rounds',
						60  => 'Lung pierced, -2 combat',
						80  => 'Heart pierced, death ensues',
						100 => 'Throat pierced, death ensues',
					),
				),
			),
			100 => array(
				's' => array(
					'damage' => $severe,
					'effect' => array(
						20  => 'Eye punctured, stunned 1d4 rounds',
						40  => 'Ear slashed off, stunned 1d4 rounds',
						60  => 'Nose slashed, stunned 1d4 rounds',
						80  => 'Teeth shattered, stunned 1d4 rounds',
						100 => 'Decapitated',
					),
				),
				'b' => array(
					'damage' => $severe,
					'effect' => array(
						20  => 'Nose crushed, stunned 1d4 rounds',
						40  => 'Teeth crushed, stunned 1d4 rounds',
						60  => 'Skull bashed, stunned 1d4 rounds, lose 1d4 INT',
						80  => 'Skull bashed, stunned 1d4 rounds, lose 2d4 INT',
						100 => 'Skull crushed, death ensues',
					),
				),
				'p' => array(
					'damage' => $severe,
					'effect' => array(
						20  => 'Eye pierced, stunned 1d4 rounds',
						40  => 'Throat pierced, death ensues',
						60  => 'Skull hit, stunned 1d4 rounds, lose 1d4 INT',
						80  => 'Skull hit, stunned 1d4 rounds, lose 2d4 INT',
						100 => 'Skull pierced, death ensues',
					),
				),
			),
		);
	}

	private function fumble_table() {
		return array(
			20 => 'Distracted - Trip, roll DEX or fall',
			39 => 'Clumsy - Fall, roll DEX or drop primary weapon',
			50 => 'Very clumsy - Fall, drop primary weapon, roll DEX or be stunned for 1 round',
			53 => 'Useless - Fall and stunned for 1 round',
			57 => 'Dazed - Fall, drop primary weapon, stunned for 1 round',
			59 => 'Stunned - Fall and stunned for 1d4 rounds',
			60 => 'Dazed and stunned - Fall, drop primary weapon, stunned for 1d4 rounds',
			61 => 'Unconscious - Fall, bang head on ground, knocked out for 1d6 rounds',
			64 => 'Inept - Lose grip on weapon, weapon flies 1d20 feet in random direction',
			65 => 'Very inept - Weapon breaks',
			67 => 'Klutz - Twist ankle, halve movement rate',
			69 => 'Dangerous klutz - Twist ankle, quarter movement rate',
			70 => 'Untrained - Sprain wrist, weapon arm incapacitated, drop weapon',
			71 => 'Vulnerable - Opponent steps on foot/twist ankle, go last every round',
			72 => 'Knocked silly - Helmet twists, blind till end of next round, roll again if no helmet',
			74 => "Poor judgment - Opponent's next attack is +4 to hit",
			76 => 'Blocked - -4 to hit next round',
			79 => 'Embarrassed - Armor malfunction, -2 armor class till fixed',
			80 => 'Staggered - Opponent parry hits groin, halve movement, -4 to hit next 3 rounds',
			81 => 'Numbed - Opponent parry hits funny bone, -2 damage for next 3 rounds',
			82 => 'Irritated - Dirt gets in eye, -1 to hit till cleaned',
			83 => 'Very irritated - Dirt gets in both eyes, -3 to hit till cleaned',
			85 => 'Fool - Hit self, normal damage',
			86 => 'Useless fool - Hit self, normal damage, stunned for 1 round',
			88 => 'Moron - Hit self, double damage',
			89 => 'Useless moron - Hit self, double damage, stunned for 1 round',
			90 => 'Complete moron - Hit self, roll for critical',
			92 => 'Unaware - Hit ally, normal damage',
			93 => 'Very unaware - Hit ally, normal damage, stunned for 1 round',
			95 => 'Unaware moron - Hit ally, double damage',
			96 => 'Liability - Hit ally, double damage, stunned for 1 round',
			97 => 'Big liability - Hit ally, roll for critical',
			98 => 'Bad - Roll twice on fumble table, re-roll if this is rolled',
			99 => 'Very Bad - Roll three times on fumble table, re-roll if this is rolled',
			100 => 'Disaster - Roll three times on fumble table, add two more rolls if this is rolled.',
		);
	}



}

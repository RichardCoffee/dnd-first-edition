<?php

$test = array(
	'CW' => array(
		'H' => 'VR',
		'F' => 'R',
		'SM' => 'VR',
	),
	'TW' => array(
		'H' => 'VR',
		'F' => 'R',
		'SM' => 'VR',
	),
	'TSW' => array(
		'H' => 'VR',
		'F' => 'R',
		'SM' => 'VR',
	),
);

$encoded = json_encode($test);

echo "$encoded\n";

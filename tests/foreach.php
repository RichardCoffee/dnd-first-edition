<?php


$test = array(
	'key1' => 'value1',
	'key2' => 'value2',
	'key3' => 'value3',
	'key4' => 'value4',
);

foreach( $test as $key => $value ) {
	echo "key: $key\n";
	if ( $key === 'key2' ) {
		unset( $test[ $key ] );
		continue;
	}
	echo "value: $value\n";
}

print_r($test);

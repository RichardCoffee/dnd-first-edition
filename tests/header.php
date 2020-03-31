<?php

require( 'setup.php' );


function getServiceURI( $fullPath ) {
//Look for the URI
if ( is_readable( $fullPath ) ) {
$seek = array(
'github' => 'GitHub URI',
'gitlab' => 'GitLab URI',
'bucket' => 'BitBucket URI'
);
$seek = apply_filters( 'puc_get_source_uri', $seek );
$data = get_file_data( $fullPath, $seek );
foreach( $data as $key => $uri ) {
if ( $uri ) return $uri;
}
}
return 'not found';
}

echo getServiceURI('/home/oem/work/php/first/dnd-first-edition.php');


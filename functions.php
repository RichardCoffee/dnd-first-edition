<?php

function dnd_first_edition_class_loader( $class ) {
	if ( substr( $class, 0, 4 ) === 'DND_' ) {
		$load = str_replace( '_', '/', substr( $class, ( strpos( $class, '_' ) + 1 ) ) );
		$file = DND_FIRST_EDITION_DIR . '/classes/' . $load . '.php';
		if ( is_readable( $file ) ) {
			include $file;
		}
	}
}
spl_autoload_register( 'dnd_first_edition_class_loader' ); //*/


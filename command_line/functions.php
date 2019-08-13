<?php

function get_file_data( $file, $default_headers, $context = '' ) {
    // We don't need to write to the file, so just open for reading.
    $fp = fopen( $file, 'r' );
 
    // Pull only the first 8kiB of the file in.
    $file_data = fread( $fp, 8192 );
 
    // PHP will close file handle, but we are good citizens.
    fclose( $fp );
 
    // Make sure we catch CR-only line endings.
    $file_data = str_replace( "\r", "\n", $file_data );
 
    /**
     * Filters extra file headers by context.
     *
     * The dynamic portion of the hook name, `$context`, refers to
     * the context where extra headers might be loaded.
     *
     * @since 2.9.0
     *
     * @param array $extra_context_headers Empty array by default.
     */
    if ( $context && $extra_headers = apply_filters( "extra_{$context}_headers", array() ) ) {
        $extra_headers = array_combine( $extra_headers, $extra_headers ); // keys equal values
        $all_headers   = array_merge( $extra_headers, (array) $default_headers );
    } else {
        $all_headers = $default_headers;
    }
 
    foreach ( $all_headers as $field => $regex ) {
        if ( preg_match( '/^[ \t\/*#@]*' . preg_quote( $regex, '/' ) . ':(.*)$/mi', $file_data, $match ) && $match[1] ) {
            $all_headers[ $field ] = _cleanup_header_comment( $match[1] );
        } else {
            $all_headers[ $field ] = '';
        }
    }
 
    return $all_headers;
}

function _cleanup_header_comment( $str ) {
    return trim( preg_replace( '/\s*(?:\*\/|\?>).*/', '', $str ) );
}

<?php

if ( ! isset( $themecolors ) ) {
	$themecolors = array(
		'bg'     => 'ffffff',
		'text'   => '000000',
		'link'   => '667755',
		'border' => 'cccccc',
		'url'    => '99aa88',
	);
}

function theme_slug_fonts_url() {
    $fonts_url = '';
 
    /* Translators: If there are characters in your language that are not
    * supported by Lato, translate this to 'off'. Do not translate
    * into your own language.
    */
    $lato = _x( 'on', 'Lato font: on or off', 'rowling' );
 
    /* Translators: If there are characters in your language that are not
    * supported by Merriweather, translate this to 'off'. Do not translate
    * into your own language.
    */
    $merriweather = _x( 'on', 'Open Sans font: on or off', 'rowling' );
 
    if ( 'off' !== $lato || 'off' !== $merriweather ) {
        $font_families = array();
 
        if ( 'off' !== $lato ) {
            $font_families[] = 'Lota:400,700,900,400italic,700italic';
        }
 
        if ( 'off' !== $merriweather ) {
            $font_families[] = 'Merriweather:700,900,400italic';
        }
 
        $query_args = array(
            'family' => urlencode( implode( '|', $font_families ) ),
            'subset' => urlencode( 'latin,latin-ext' ),
        );
 
        $fonts_url = add_query_arg( $query_args, '//fonts.googleapis.com/css' );
    }
 
    return $fonts_url;
}
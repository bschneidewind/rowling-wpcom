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

/*
 * De-queue Google fonts if custom fonts are being used instead
 */
function rowling_dequeue_fonts() {
	if ( class_exists( 'TypekitData' ) && class_exists( 'CustomDesign' ) && CustomDesign::is_upgrade_active() ) {
		$customfonts = TypekitData::get( 'families' );

		if ( $customfonts && $customfonts['site-title']['id'] && $customfonts['headings']['id'] && $customfonts['body-text']['id'] ) {
			wp_dequeue_style( 'rowling-fonts' );
		}
	}
}
add_action( 'wp_enqueue_scripts', 'rowling_dequeue_fonts' );
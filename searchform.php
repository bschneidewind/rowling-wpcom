<?php
/**
 * The search form template
 *
 * @package Rowling
 */
?>

<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<input type="search" class="search-field" placeholder="<?php esc_html_e( 'Search form', 'rowling' ); ?>" name="s" /> 
	<button type="submit" class="search-button"><span class="fa fw fa-search"></span></button>
</form>
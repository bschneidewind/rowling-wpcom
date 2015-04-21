<?php
/**
 * The search form template
 *
 * @package Rowling
 */
?>

<form method="get" class="search-form" id="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<input type="search" class="search-field" placeholder="<?php esc_html_e( 'Search form', 'rowling' ); ?>" name="s" id="s" /> 
	<button type="submit" class="search-button"><div class="fa fw fa-search"></div></button>
</form>
<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Rowling
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<header id="site-header">
		<div class="top-nav">
			<div class="section-inner clearfix">
				<?php wp_nav_menu( array( 'theme_location' => 'secondary', 'menu_id' => 'secondary-menu', 'menu_class' => 'secondary-menu', 'container' => 'false' ) ); ?>

				<?php wp_nav_menu( array( 'theme_location' => 'social', 'depth' => 1, 'link_before' => '<span class="screen-reader-text">', 'link_after'  => '</span>', 'container' => 'false', 'items_wrap' => '<ul class="social-menu">%3$s<li><a class="search-toggle" href="#"><span class="screen-reader-text">Search</span></a></li></ul>' ) ); ?>
			</div> <!-- /section-inner -->
		</div> <!-- /top-nav -->

		<div class="search-container">
			<div class="section-inner">
				<?php get_search_form(); ?>
			</div> <!-- /section-inner -->
		</div> <!-- /search-container -->

		<div class="header-wrapper">
			<div class="header">
				<div class="section-inner">

					<?php if ( get_theme_mod( 'rowling_logo' ) ) : ?>
						<a class="blog-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) . '&mdash;' . get_bloginfo( 'description', 'display' ) ); ?>" rel='home'>
							<img src='<?php echo esc_url( get_theme_mod( 'rowling_logo' ) ); ?>' alt='<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>'>
						</a>

					<?php else : ?>

					<h2 class="blog-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) . ' &mdash; ' . get_bloginfo( 'description', 'display' ) ); ?>" rel="home"><?php echo esc_html( get_bloginfo( 'name' ) ); ?></a></h2>
					<?php $description = get_bloginfo( 'description', 'display' );
					if ( $description || is_customize_preview() ) : ?>
						<p class="site-description"><?php echo $description; ?></p>
					<?php endif; ?>

					<?php endif; ?>

					<div class="nav-toggle">
						<div class="bars">
							<div class="bar"></div>
							<div class="bar"></div>
							<div class="bar"></div>
						</div>
					</div> <!-- /nav-toggle -->

				</div> <!-- /section-inner -->
			</div> <!-- /header -->

			<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu', 'menu_class' => 'primary-menu clearfix', 'container' => 'div', 'container_class' => 'navigation' ) ); ?>

		</div> <!-- /header-wrapper -->
	</header>

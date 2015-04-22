<?php
/**
 * The template used for displaying page the global footer
 *
 * @package Rowling
 */
?>

	<div class="credits">
		<div class="section-inner">
			<a href="#" class="to-the-top" title="<?php esc_attr_e( 'To the top', 'rowling' ); ?>"><div class="fa fw fa-arrow-up"></div></a>
			
			<div class="copyright">
				<a href="http://wordpress.org/" title="<?php esc_attr_e( 'A Semantic Personal Publishing Platform', 'rowling' ); ?>" rel="generator"><?php printf( __( 'Proudly powered by %s', 'rowling' ), 'WordPress' ); ?></a>
			</div> <!-- /copyright -->
			
			<div class="attribution">
				<?php printf( __( 'Theme: %1$s by %2$s.', 'rowling' ), 'Rowling', '<a href="http://www.andersnoren.se" rel="designer">Anders Nor&eacute;n</a>' ); ?>
			</div> <!-- /attribution -->
			
		</div>  <!-- /section inner -->
	</div> <!-- /credits -->

<?php wp_footer(); ?>

</body>
</html>
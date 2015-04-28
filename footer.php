<?php
/**
 * The template used for displaying page the global footer
 *
 * @package Rowling
 */
?>

	<footer class="site-footer">
		<div class="credits">
			<div class="section-inner">
				<a href="#site-header" class="to-the-top" title="<?php esc_attr_e( 'To the top', 'rowling' ); ?>"><span class="fa fw fa-arrow-up"></span></a>
				<div class="copyright">
					<a href="<?php echo esc_url( __( 'http://wordpress.org/', 'rowling' ) ); ?>"><?php printf( __( 'Proudly powered by %s', 'rowling' ), 'WordPress' ); ?></a>
				</div> <!-- /copyright -->
				<div class="attribution">
					<?php printf( __( 'Theme: %1$s by %2$s.', 'rowling' ), 'Rowling', '<a href="http://www.andersnoren.se" rel="designer">Anders Nor&eacute;n</a>' ); ?>
				</div> <!-- /attribution -->
			</div>  <!-- /section inner -->
		</div> <!-- /credits -->
	</footer>

<?php wp_footer(); ?>

</body>
</html>
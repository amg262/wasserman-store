<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package store
 */
?>

	</div><!-- #content -->

	<?php get_sidebar('footer'); ?>

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="site-info container">
			<div class="footer-copyright">
				<br>
				<small><?php //printf( __( 'Developed by %1$s.', 'Andrew Gunn' ), '<a href="'.esc_url("http://andrewgunn.xyz").'" target="_blank" rel="designer">Andrew Gunn</a>' ); ?></small>
				<span class="sep"></span><br>
				<?php echo ( get_theme_mod('store_footer_text') == '' ) ? ('&copy; '.date('Y').' Wasserman Medical Publishers Ltd. '.__('. All Rights Reserved. ','store')) : esc_html( get_theme_mod('store_footer_text') ); ?>
			</div>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
	
</div><!-- #page -->


<?php wp_footer(); ?>

</body>
</html>

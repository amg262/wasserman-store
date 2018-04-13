<?php
/**
 * The template part for displaying results in search pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package store
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( grid_search() ); ?>>


    <div id="featured-image">
        <a href="<?php echo esc_url( get_the_permalink() ) ?>"><?php the_post_thumbnail( 'medium' ); ?></a>
    </div>


    <h4 class="entry-title"><a rel="bookmark"
                               href="<?php echo esc_url( get_the_permalink() ) ?>"><?php relevanssi_the_title(); ?></a>
    </h4>

	<?php if ( 'post' == get_post_type() ) : ?>
        <div class="entry-meta">
			<?php //store_posted_on(); ?>
        </div><!-- .entry-meta -->
	<?php endif; ?>

	<?php if ( 'product' == get_post_type() ) : ?>
        <div class="entry-meta">
			<?php //store_posted_on();

			$terms = get_the_terms( get_the_ID(), 'product_cat' );
			echo '<span class="price"># ' . get_the_ID() . '</span>';
			the_excerpt();
			$af = site_url() . '/?add-to-cart=' . get_the_ID();

			echo '<a rel="nofollow" class="button product_type_simple add_to_cart_button ajax_add_to_cart" href=' . $af . '>Add to cart</a>';


			?>

        </div><!-- .entry-meta -->
	<?php endif; ?>


    <div class="entry-summary">


    </div><!-- .entry-summary -->


</article><!-- #post-## -->

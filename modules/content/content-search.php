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

		  $post = wc_get_product( get_the_ID() );


		  $price = $post->get_price();
		  //$id = $post->get_id();


		  //$price .= $post->get_price_suffix();

		  //$terms = get_the_terms( get_the_ID(), 'product_cat' );
		  // $price_text .= '<span>';

		  $price_text .= '<span class="price wass-price-txt">$' . $price . '   </span>';


		  echo $price_text;
		  $sku = $post->get_sku();
		  $id  = $post->get_id();

		  if ( $sku !== '' ) {

			  $sku_x .= '<p style="margin:15px 0 10px 0;">';
			  $sku_x .= '<span class="wass-sku-txt">';
			  $sku_x .= '<a href="' . $post->get_permalink() . '" ><strong style="color:#6A6A6A;">SKU:&nbsp;&nbsp;</strong>' . $sku . '</a>';
			  $sku_x .= '</span>';
			  $sku_x .= '</p>';

			  echo $sku_x;
		  }


		  //  echo $_GET['s'];

		  // relevanssi_query_vars( $_GET['s'] );

		  $q = $_GET['s'];

		  $e = get_the_excerpt( $id );

		  $ee = $post->get_short_description();


		  //$eee = relevanssi_create_excerpt( $ee, $q, $q );

		  // echo get_search_query();
		  // $h = relevanssi_highlight_terms( $e, get_search_query() );
		  // var_dump( $eee );
		  //relevanssi_the_excerpt();
		  //the_excerpt();

		  //echo $h;
		  // echo relevanssi_create_excerpt( $e, [ get_the_tag_list( '', ', ' ) ], get_search_query() );
		  //echo $h;
		  $rs = relevanssi_highlight_in_docs( $e );

		  $tags = relevanssi_create_excerpt( $e, [ get_the_category_list() ], $q );

		  $re = wp_strip_all_tags( $rs );

		  $ree = esc_html( $re );


		  relevanssi_the_excerpt();

		  if ( strlen( $tags[0] ) > 0 ) {
			  echo $tags[0];
		  } else {
			  the_excerpt();
		  }
		  if ( $rs == $sku ) {
			  // echo $e;
		  } else {
			  // echo $rs;
		  }

		  //  the_excerpt();
		  /* if ( $rs !== null ) {
			   echo $rs;
		   } else {
			   the_excerpt();
		   }*/
		  // $t = relevanssi_create_excerpt( $e, rele )
		  //var_dump( $h );
		  $af = site_url() . '/cart/?add-to-cart=' . $id;
		  $ac = $post->get_permalink();


		  echo '<p class="was-view-item"><a rel="nofollow" class="button product_type_simple add_to_cart_button ajax_add_to_cart" href=""' . $ac . '>View Item</a></p>';
		  //echo //'<a rel="nofollow" class="button product_type_simple add_to_cart_button ajax_add_to_cart" href=' . $af . '>Add to cart</a>';

		  ?>

      </div><!-- .entry-meta -->
	<?php endif; ?>


  <div class="entry-summary">


  </div><!-- .entry-summary -->


</article><!-- #post-## -->

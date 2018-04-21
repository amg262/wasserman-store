<?php
/**
 * Created by PhpStorm.
 * User: Andy
 * Date: 4/15/2018
 * Time: 1:23 PM
 */


function get_related_items() {

	global $product;
	//$product     = wc_get_product( $post_id );
	global $post;
	$prod = wc_get_product( $product->ID );


	$ri = get_field( 'related_items' );
	$ra = get_field( 'related_active' );

	$title = get_field( 'related_items_title', 'option' );
	foreach ( $ri as $cf ) {
		$upsell_display[] = $cf->ID;
	} ?>

	<section class="related products">

	<h2><?php esc_html_e( 'Related products', 'woocommerce' ); ?></h2>

	<?php woocommerce_product_loop_start(); ?>

	<?php foreach ( $ri as $r ) : ?>

		<?php
		$post_object = get_post( $r->ID );

		setup_postdata( $GLOBALS['post'] =& $post_object );

		wc_get_template_part( 'content', 'product' ); ?>

	<?php endforeach; ?>

	<?php woocommerce_product_loop_end(); ?>

	</section><?php
	//woocommerce_output_related_products();
	//return $ri;


}

/*
function sdfs(){

	global $product;
	$prod     = wc_get_product( $product->ID );
	$cross_sells = $product->get_cross_sell_ids();
	$upsells     = $product->get_upsell_ids();
	$u           = get_field( 'upsell_products' );
	$ua          = get_field( 'upsell_active' );


	if ($ua === true)

	?>
	<section class="up-sells upsells products">

		<h2><?php esc_html_e( 'You may also like&hellip;', 'woocommerce' ) ?></h2>

		<?php woocommerce_product_loop_start(); ?>

			<?php foreach ( $upsells as $upsell ) : ?>

				<?php
				 	$post_object = get_post( $upsell->ID );

					setup_postdata( $GLOBALS['post'] =& $post_object );

					wc_get_template_part( 'content', 'product' ); ?>

			<?php endforeach; ?>

		<?php woocommerce_product_loop_end(); ?>

	</section><?php
}

add_action( 'save_post', 'replay_upsells' );
/**
 *
 */
/*
function replay_upsells( $post_id ) {

	$post_type = get_post_type( $post_id );

	// If this isn't a 'book' post, don't update it.
	if ( "product" !== $post_type ) {
		return;
	}


	global $product;
	$product     = wc_get_product( $post_id );
	$cross_sells = $product->get_cross_sell_ids();
	$upsells     = $product->get_upsell_ids();
	$u           = get_field( 'upsell_products' );
	$ua          = get_field( 'upsell_active' );
	$has_upsells = false;

	$has_cf_upsells = false;
	$upsell_posts   = [];
	$upsell_ids     = [];
	$cross_ids      = [];
	$upsell_display = [];


	if ( count( $upsells ) > 0 ) {
		foreach ( $upsells as $id ) {
			$upsell_posts[] = get_post( $id );
			$upsell_ids[]   = $id;
		}
		$has_upsells = true;
	}
	if ( ( $u ) && ( count( $u ) > 0 ) ) {
		foreach ( $u as $cf ) {
			$upsell_display[] = $cf->ID;
		}
		$has_cf_upsells = true;
	}

	if ( ( $has_upsells === true ) || ( $has_cf_upsells === true ) ) {

		if ( $upsell_display === $upsells ) {
			if ( $ua !== true ) {
				update_field( 'upsell_active', true );
			}
		} else {

			if ( $ua === true ) {

				update_field( 'upsell_active', true );

				$product->set_upsell_ids( $upsell_display );
				$product->save();
			} else {
				update_field( 'upsell_active', true );
				update_field( 'upsell_products', $upsell_posts );

				$product->set_upsell_ids( $upsell_ids );
				$product->save();
			}
		}
	}


}

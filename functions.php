<?php
include_once( __DIR__ . '/functions-custom.php' );

//Your awesome code could start here.
add_action( 'wp_enqueue_scripts', 'wasserman_store_enqueue' );

/**
 *
 */
function wasserman_store_enqueue() {
	wp_enqueue_style( 'wasserman-store-partent-style', get_template_directory_uri() . '/style.css' );

	//wp_enqueue_script( 'wassjs',get_stylesheet_directory_uri().'/wass.js'  );
}


add_action( 'after_setup_theme', 'register_user_menu' );
//add_action( 'after_setup_theme', 'register_user_menu' );

/**
 *
 */
function register_user_menu() {
	register_nav_menu( 'primary-user', __( 'Logged In Menu', 'wasserman-store' ) );
	//add_image_size('popup_thumb', 250, 250, false);
}

/**
 * Adding ACF options page
 */
if ( function_exists( 'acf_add_options_page' ) ) {
	acf_add_options_page();
}
add_action( 'woocommerce_before_checkout_form', 'wsu_add_checkout_content', 12 );


remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );
//add_filter('woocommerce_after_cart_totals', 'woocommerce_cross_sell_display');
//add_action( 'widgets_init', 'wasserman_store_widgets_init' );


/**
 *
 */
function wsu_add_checkout_content() {

	//echo 'hi';
	if ( have_rows( 'checkout_notices', 'options' ) ) {

		while ( have_rows( 'checkout_notices', 'options' ) ) : the_row();
			// Your loop code
			$text   = get_sub_field( 'text' );
			$active = get_sub_field( 'active' );

			echo $text;

		endwhile;
	}
}

/**
 * Only display minimum price for WooCommerce variable products
 **/
add_filter( 'woocommerce_variable_price_html', 'display_lowest_range_prie', 10, 2 );

/**
 * @param $price
 * @param $product
 *
 * @return string
 */
function display_lowest_range_prie( $price, $product ) {

	$price = '';

	$price .= woocommerce_price( $product->get_price() );

	return $price;
}

// remove cross-sells from their normal place
add_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display', 10, 2 );

/**
 * Register new status
 * Tutorial: http://www.sellwithwp.com/woocommerce-custom-order-status-2/
 **/
function register_preorder_idle_order_status() {
	register_post_status( 'wc-awaiting-shipment', [
		'label'                     => 'Idle Pre-Order',
		'public'                    => true,
		'exclude_from_search'       => false,
		'show_in_admin_all_list'    => true,
		'show_in_admin_status_list' => true,
		'label_count'               => _n_noop( 'Idle Pre-Orders <span class="count">(%s)</span>', 'Idle Pre-Orders <span class="count">(%s)</span>' ),
	] );
}

add_action( 'init', 'register_preorder_idle_order_status' );

// Add to list of WC Order statuses
/**
 * @param $order_statuses
 *
 * @return array
 */
function add_preorder_idle_to_order_statuses( $order_statuses ) {

	$new_order_statuses = [];

	// add new order status after processing
	foreach ( $order_statuses as $key => $status ) {

		$new_order_statuses[ $key ] = $status;

		if ( 'wc-processing' === $key ) {
			$new_order_statuses['wc-idle-preorder'] = 'Idle Pre-Order';
		}
	}

	return $new_order_statuses;
}

add_filter( 'wc_order_statuses', 'add_preorder_idle_to_order_statuses' );

add_filter( 'woocommerce_cart_no_shipping_available_html', 'wm_change_noship_message' );
add_filter( 'woocommerce_no_shipping_available_html', 'wm_change_noship_message' );

/**
 *
 */
function wm_change_noship_message() {

	if ( get_field( 'shipping_notices', 'option' ) ) {
		the_field( 'shipping_notices', 'option' );
	} else {
		print "Unfortunately, we are unable to calculate a shipping price for the country you selected. Please send your address, desired products and quantities to <a target='_blank' href='mailto:support@wasserman-medical.com' />support@wasserman-medical.com</a> or call <a target='_blank' href='tel:180066933337'>(800) 669-3337</a> between <strong>10:00 AM or 4:00 PM CDT.</strong>";
	}
}

add_action( 'admin_footer', 'wm_hide_elements' );

/**
 *
 */
function wm_hide_elements() {
	$slides = [];
	$html   = '';

	if ( have_rows( 'hide_elements', 'options' ) ) {

		while ( have_rows( 'hide_elements', 'options' ) ) : the_row();

			// Your loop code
			$selector  = get_sub_field( 'selector' );
			$property  = get_sub_field( 'property' );
			$value     = get_sub_field( 'value' );
			$important = get_sub_field( 'important' );
			$active    = get_sub_field( 'active' );

			if ( $active === true ) {

				$slides[] = [
					's' => $selector,
					'p' => $property,
					'v' => $value,
					'a' => $active,
					'i' => $important,
				];
			}
		endwhile;

		foreach ( $slides as $slide ) {
			$html .= ' ' . $slide['s'] . ' { ' . $slide['p'] . ' : ' . $slide['v'] . ' ; }';
		}

		$san = sanitize_text_field( $html ); ?>
        <style type="text/css">

            <?php echo $san; ?>

        </style>
	<?php }

}

add_filter( 'woocommerce_cross_sells_columns', 'change_cross_sells_columns' );

/**
 * @param $columns
 *
 * @return int|mixed|null|void
 */
function change_cross_sells_columns( $columns ) {

	if ( get_field( 'cross_sells', 'option' ) ) {
		return get_field( 'cross_sells', 'option' );
	} else {
		return 2;
	}
}

//add_filter( 'woocommerce_output_related_products_args', 'wc_change_number_related_products' );


add_filter( 'woocommerce_upsell_display_args', 'custom_woocommerce_upsell_display_args' );
/**
 * @param $args
 *
 * @return mixed
 */
function custom_woocommerce_upsell_display_args( $args ) {

	if ( get_field( 'upsells', 'option' ) ) {
		$ups = get_field( 'upsells', 'option' );
	} else {
		$ups = 4;
	}

	if ( get_field( 'upsell_columns', 'option' ) ) {
		$upc = get_field( 'upsell_columns', 'option' );
	} else {
		$upc = 4;
	}

	$args['posts_per_page'] = $ups;
	$args['columns']        = $upc; //change number of upsells here

	return $args;
}

/**
 * @return string
 */
function grid_search() {
	if ( get_field( 'search_columns', 'option' ) ) {
		$col = get_field( 'search_columns', 'option' );
	} else {
		$col = 4;
	}

	if ( $col == 3 ) {
		$srt = 'col-md-4 col-sm-4 grid store_3_column wass-pad';
	} elseif ( $col == 4 ) {
		$srt = 'col-lg-3 col-md-3 col-sm-3 grid  wass-pad';
	} else {
		$srt = '';
	}

	return $srt;

}

/**
 *
 */
function get_prod_acfs() {

	$id = '7427';

	$args = [ 'post_type' => 'product', 'posts_per_page' => - 1 ];

	$p     = null;
	$posts = get_posts( $args );

	foreach ( $posts as $prod ) {
		if ( $prod->ID == $id ) {
			echo 'hey';
			$p = $prod;
		}
	}

	echo 'hi';
	//var_dump($p);

}

/**
 *
 */
function replay_upsells() {

	global $product;
	$upsells    = $product->get_upsells();
	$cross_args = [];
	$args       = [ 'post_type' => 'product', 'posts_per_page' => - 1 ];
	$cross      = $product->get_cross_sells();


	$related = get_field( 'related_products' );

	if ( count( $upsells ) > 0 ) {
		update_field( 'upsell_products', $upsells );
	}

	if ( count( $cross ) > 0 ) {
		//update_field( 'crosssell_products', $upsells );

		foreach ( $cross as $id ) {
			array_push( $cross_args, get_post( $id ) );
		}

		update_field( 'crosssell_products', $cross_args );
	}

	var_dump( $cross_args );
	//var_dump(get_field('crosssell_products'));
	//if (get_field())
}

//add_action( 'admin_init', 'get_prod_acfs' );

// Remove related products from after single product hook
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
// Remove up sells from after single product hook
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );

/**
 *
 */
function yourthemename_upsell_related_cross() {
	if ( is_cart() ) {
		woocommerce_cross_sell_display();
	} elseif ( ! ( is_checkout() || is_front_page() || is_shop() || is_product_category() || is_product_tag() ) ) {
		global $product;
		$upsells = $product->get_upsells();
		if ( count( $upsells ) > 0 ) {
			woocommerce_upsell_display( 4, 4 );
		} else {
			woocommerce_output_related_products();
		}
	}
}

add_action( 'woocommerce_after_single_product_summary', 'replay_upsells', 20 );


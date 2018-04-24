<?php
/**
 * Copyright (c) 2018.
 * andrewmgunn26@gmail.com
 * github.com/amg262
 */
const PERF              = 'performance';
const TEST              = 'test';


const BUILD_ENVIRONMENT = TEST;

//include_once( __DIR__ . '/custom.php' );

//Your awesome code could start here.
add_action( 'wp_enqueue_scripts', 'wasserman_store_enqueue' );

/**
 *
 */
function wasserman_store_enqueue() {
	wp_enqueue_style( 'wasserman-store-partent-style', get_template_directory_uri() . '/style.css' );

	if ( BUILD_ENVIRONMENT === PERF ) {
		wp_enqueue_script( 'wassminjs', get_theme_file_uri() . '/wasser/scripts.min.js' );
		wp_enqueue_style( 'wassmincsss', get_theme_file_uri() . '/wasser/styles.min.css' );
	} else {
		wp_enqueue_script( 'wassjs', get_theme_file_uri() . '/wasser/scripts.js' );
		wp_enqueue_style( 'wasscsss', get_theme_file_uri() . '/wasser/styles.css' );
	}
}

add_action( 'after_setup_theme', 'register_user_menu' );

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

//add_filter( 'woocommerce_cross_sells_columns', 'change_cross_sells_columns' );

/**
 * @param $columns
 *
 * @return int|mixed|null|void
 */
function change_cross_sells_columns( $columns ) {

	$cols = ( get_field( 'cross_sell_columns', 'option' ) ) ? (int) get_field( 'cross_sell_columns', 'option' ) : 4;

	return $cols;
}

//add_filter( 'woocommerce_output_related_products_args', 'wc_change_number_related_products', 15 );

function wc_change_number_related_products( $args ) {

	$net  = ( get_field( 'related_total', 'option' ) ) ? (int) get_field( 'related_total', 'option' ) : 5;
	$cols = ( get_field( 'related_columns', 'option' ) ) ? (int) get_field( 'related_columns', 'option' ) : 5;
	echo 'net-' . $net;

	$args['posts_per_page'] = $net;
	$args['columns']        = $cols;

	return $args;
}


//add_filter( 'woocommerce_upsell_display_args', 'custom_woocommerce_upsell_display_args' );
/**
 * @param $args
 *
 * @return mixed
 */
function custom_woocommerce_upsell_display_args( $args ) {

	/*if ( get_field( 'upsells', 'option' ) ) {
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

	return $args;*/
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


// Remove related products from after single product hook
// Remove up sells from after single product hook
//remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );

//remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_cross_sell_display', 20 );

//remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );

/**
 *
 */
function yourthemename_upsell_related_cross() {
	if ( get_field( 'show_upsells', 'option' ) == true ) {
		if ( is_cart() ) {
			woocommerce_cross_sell_display();
		} elseif ( ! ( is_checkout() || is_front_page() || is_shop() || is_product_category() || is_product_tag() ) ) {
			global $product;
			$upsells = $product->get_upsells();
			if ( count( $upsells ) > 0 ) {
				woocommerce_upsell_display( get_field( 'upsells', 'option' ), get_field( 'upsell_columns', 'option' ) );
				//woocommerce_cross_sell_display( 4, 4 );
			} else {
				//woocommerce_output_related_products();
			}
		}
	}
}

/**
 *
 */
function redisplay_cross() {

	if ( get_field( 'show_crosssells', 'option' ) !== true ) {
		echo 'billz';

		return;
	}
	$net  = ( get_field( 'cross_sells', 'option' ) ) ? (int) get_field( 'cross_sells', 'option' ) : 4;
	$cols = ( get_field( 'cross_sell_columns', 'option' ) ) ? (int) get_field( 'cross_sell_columns', 'option' ) : 4;

	woocommerce_cross_sell_display( $net, $cols );
}


/**
 *
 */
function redisplay_related() {

	//if ( get_field( 'show_related', 'option' ) == true ) {
	woocommerce_output_related_products();
	//}


}


//add_action( 'woocommerce_after_single_product_summary', 'replay_upsells', 15 );
//add_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 15 );
//add_action( 'woocommerce_after_single_product_summary', 'woocommerce_cross_sell_display', 15 );yourthemename_cross
//add_action( 'woocommerce_after_single_product_summary', 'redisplay_cross', 20 );
//add_action( 'woocommerce_after_single_product_summary', 'redisplay_related', 15 );
//add_action( 'woocommerce_after_single_product_summary', 'replay_upsells', 15 );

//add_action( 'woocommerce_after_single_product_summary', 'yourthemename_upsell_related_cross', 20 );
//add_action( 'woocommerce_after_single_product_summary', 'get_related_items', 20 );


function get_related_items( $post_id ) {


	//$title = get_field( $rit, 'option' ) ? get_field( $rit, 'option' ) : 'Related Products';

	//woocommerce_output_related_products();
	//return $ri;


}


add_action( 'save_post', 'replay_upsells' );


function replay_upsells( $post_id ) {

	$post_type = get_post_type( $post_id );

	// If this isn't a 'book' post, don't update it.
	if ( "product" !== $post_type ) {
		return;
	}


	global $product;
	$product = wc_get_product( $post_id );

	$related_ids = get_post_meta( $product->ID, '_related_ids' );
	//var_dump($related_ids);


	$a = [];
	$b = [];
	$r = get_field( 'related_items' );

	if ( $r ) {
		foreach ( $r as $id ) {
			$a[] = get_post( $id );
			$b[] = $id;
		}
	}

	update_post_meta( $product->ID, '_related_ids', $b );
	$cross_sells = $product->get_cross_sell_ids();
	$upsells     = $product->get_upsell_ids();
	$u           = get_field( 'upsell_products' );
	$ua          = get_field( 'upsell_active' );
	$has_upsells = false;

	$has_cf_upsells     = false;
	$upsell_posts       = [];
	$upsell_ids         = [];
	$cross_ids          = [];
	$upsell_display     = [];
	$cross_sell_display = [];
//$cross_sells = $product->get_cross_sell_ids();
	$cross_sells     = $product->get_cross_sell_ids();
	$c               = get_field( 'crosssell_products' );
	$ca              = get_field( 'crosssell_active' );
	$has_cross_sells = false;

	$has_cf_cross_sells = false;
	$cross_sell_posts   = [];
	$cross_sell_ids     = [];
	$cross_ids          = [];
	$cross_sell_display = [];
	//$cross_sell_display = [];


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


	if ( count( $cross_sells ) > 0 ) {
		foreach ( $cross_sells as $id ) {
			$cross_sell_posts[] = get_post( $id );
			$cross_ids[]        = $id;
		}
		$has_cross_sells = true;
	}
	if ( ( $c ) && ( count( $c ) > 0 ) ) {
		foreach ( $c as $cf ) {
			$cross_sell_display[] = $cf->ID;
		}
		$has_cf_cross_sells = true;
	}

	if ( ( $has_cross_sells === true ) || ( $has_cf_cross_sells === true ) ) {

		if ( $cross_sell_display === $cross_sells ) {
			if ( $ca !== true ) {
				update_field( 'crosssell_active', true );
			}
		} else {

			if ( $ca === true ) {

				update_field( 'crosssell_active', true );

				$product->set_cross_sell_ids( $cross_sell_display );
				$product->save();
			} else {
				update_field( 'crosssell_active', true );
				update_field( 'crosssell_products', $cross_sell_posts );

				$product->set_cross_sell_ids( $cross_ids );
				$product->save();
			}
		}
	}
}

//add_action('admin_init','custom_order_algorithm');
add_action( 'manage_product_posts_custom_column', 'product_column_custom', 10, 2 );

/**
 * @param $column
 * @param $postid
 */
function product_column_custom( $column, $postid ) {

	$p     = new WC_Product( $postid );
	$order = 0;

	switch ( $column ) {
		case 'menu_order':
			$order = (int) $p->menu_order;
			update_field( 'product_order', $order, $p->ID );
			break;
		case 'upsell_products':
			$ups = ( get_field( 'upsell_products', $p->ID ) ) ? count( get_field( 'upsell_products', $p->ID ) ) : '';
			echo $ups;
			break;

	}


}

add_filter( 'manage_edit-product_columns', 'product_column_register_sortable', 10, 1 );
add_filter( 'manage_edit-product_sortable_columns', 'product_column_register_sortable', 15 );

/**
 * make column sortable
 */
function product_column_register_sortable( $columns ) {

	unset( $columns['featured'] );

	$columns['menu_order']      = 'Menu Order';
	$columns['upsell_products'] = 'UpSells';


	return $columns;
}


add_filter( 'acf/fields/relationship/result', 'id_relationship_result', 10, 4 );
function id_relationship_result( $title, $post, $field, $post_id ) {
	// load a custom field from this $object and show it in the $result
	$prod = new WC_Product( $post->ID );
	$sku  = $prod->get_sku();

	// append to title
	$title .= ' [' . $sku . '] ';

	// return
	return $title;
}




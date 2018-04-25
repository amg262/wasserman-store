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
			//update_field( 'product_order', $order, $p->ID );
			echo $order;
			break;

		case 'sort':

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

	$columns['menu_order'] = 'Menu Order';
	//$columns['upsell_products'] = 'UpSells';

	$columns['sort'] = 'Sort';

	return $columns;
}
add_action( 'pre_get_posts', 'mycpt_custom_orderby' );

function mycpt_custom_orderby( $query ) {
	if ( ! is_admin() )
		return;

	$orderby = $query->get( 'orderby');

	if ( 'acf_field' == $orderby ) {
		$query->set( 'meta_key', 'sort_order' );
		$query->set( 'orderby', 'meta_value_num' );
	}
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

add_action( 'admin_footer', 'handle_product_sort' );

function handle_product_sort() {

	$args     = [ 'post_type' => 'product', 'post_status' => 'publish', 'posts_per_page' => - 1 ];
	$posts    = get_posts( $args );
	$prod_set = [];
	$opts     = '';

	if ( ! get_option( 'prod_order_set' ) ) {
		add_option( 'prod_order_set', [ 'ID' => '', 'menu_order' => '', 'product_order' => '' ] );
	} else {
		$opts = get_option( 'prod_order_set' );
	}

	$i = 0;

	foreach ( $posts as $post ) {
		$prod = wc_get_product( $post->ID );
		$prod->get_menu_order();

		$prod_set[] = [
			'menu_order' => (int) $prod->get_menu_order(),
			'IDD'        => (int) $post->ID,
			'sort'       => (int) $post->sort_order,
		];
		$i ++;
	}


	update_option( 'prod_order_set', $prod_set );


	return $prod_set;
}

function dothis() {

	$a = handle_product_sort();
	$f = 0;
	sort( $a );


	$i = 0;
	while ( $i < 5 ) {
		foreach ( $a as $k ) {
			$idd = (int) $k['IDD'];

			$post = get_post( $idd );
			$what = update_post_meta( $post->ID, '_sort_order', $i );
			$i ++;

			echo get_post_meta( $post->ID, '_sort_order', true );
		}
	}
	var_dump( $what );

	/*foreach ( $opts as $o ) {
		$post = get_post($o->ID );
		update_post_meta( $post->ID, '_sort_order', $i );

		$i ++;
	}

	echo $i . ' changed';
	/*foreach ($prods as $p) {

	    $post = get_post($p->ID);



	    if ($j === 0) {
            $j = $p->menu_order;
            $i++;
        }

        if ($p->menu_order < $j) {
	        $j=$p->menu_order;
	        $i++;
        }

	    update_post_meta($post->ID,'_sort_order', $i);


    }*/
	//print $json;
}

//add_action( 'admin_footer', 'dothis' );

//include_once(__DIR__.'/wasser/uninstall.php');

//add_action( 'admin_footer', 'dele' );

function dele() {


	$del = new WS_Uninstall();
	$i   = $del->delete_postmeta();
	$del = null;
	echo $i . ' deleted';
}


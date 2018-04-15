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
/*
	if ( function_exists( 'acf_add_local_field_group' ) ):

		acf_add_local_field_group( [
			'key'                   => 'group_5ad37ea6ad1b8',
			'title'                 => 'Product Options',
			'fields'                => [
				[
					'key'               => 'field_5ad37ec184223',
					'label'             => 'Related Products',
					'name'              => 'related_products',
					'type'              => 'post_object',
					'instructions'      => '',
					'required'          => 0,
					'conditional_logic' => 0,
					'wrapper'           => [
						'width' => '',
						'class' => '',
						'id'    => '',
					],
					'post_type'         => [
						0 => 'product',
					],
					'taxonomy'          => [
					],
					'allow_null'        => 1,
					'multiple'          => 1,
					'return_format'     => 'object',
					'ui'                => 1,
				],
				[
					'key'               => 'field_5ad37ee184224',
					'label'             => 'UpSell Products',
					'name'              => 'upsell_products',
					'type'              => 'post_object',
					'instructions'      => '',
					'required'          => 0,
					'conditional_logic' => 0,
					'wrapper'           => [
						'width' => '',
						'class' => '',
						'id'    => '',
					],
					'post_type'         => [
						0 => 'product',
					],
					'taxonomy'          => [
					],
					'allow_null'        => 1,
					'multiple'          => 1,
					'return_format'     => 'object',
					'ui'                => 1,
				],
				[
					'key'               => 'field_5ad37efe84225',
					'label'             => 'CrossSell Products',
					'name'              => 'crosssell_products',
					'type'              => 'post_object',
					'instructions'      => '',
					'required'          => 0,
					'conditional_logic' => 0,
					'wrapper'           => [
						'width' => '',
						'class' => '',
						'id'    => '',
					],
					'post_type'         => [
						0 => 'product',
					],
					'taxonomy'          => [
					],
					'allow_null'        => 1,
					'multiple'          => 1,
					'return_format'     => 'object',
					'ui'                => 1,
				],
				[
					'key'               => 'field_5ad37ff4e827c',
					'label'             => 'Product Order',
					'name'              => 'product_order',
					'type'              => 'text',
					'instructions'      => '',
					'required'          => 0,
					'conditional_logic' => 0,
					'wrapper'           => [
						'width' => '',
						'class' => '',
						'id'    => '',
					],
					'default_value'     => '',
					'placeholder'       => '',
					'prepend'           => '',
					'append'            => '',
					'maxlength'         => '',
				],
			],
			'location'              => [
				[
					[
						'param'    => 'post_type',
						'operator' => '==',
						'value'    => 'product',
					],
				],
			],
			'menu_order'            => 0,
			'position'              => 'normal',
			'style'                 => 'default',
			'label_placement'       => 'top',
			'instruction_placement' => 'label',
			'hide_on_screen'        => '',
			'active'                => 1,
			'description'           => '',
		] );

	endif;

	if ( function_exists( 'acf_add_local_field_group' ) ):

		acf_add_local_field_group( [
			'key'                   => 'group_57e597585c8d3',
			'title'                 => 'Checkout Options',
			'fields'                => [
				[
					'key'               => 'field_5acce8f15e780',
					'label'             => 'Display',
					'name'              => '',
					'type'              => 'tab',
					'instructions'      => '',
					'required'          => 0,
					'conditional_logic' => 0,
					'wrapper'           => [
						'width' => '',
						'class' => '',
						'id'    => '',
					],
					'placement'         => 'top',
					'endpoint'          => 0,
				],
				[
					'key'               => 'field_5acce830012bf',
					'label'             => 'Cross-Sells Columns',
					'name'              => 'cross_sells',
					'type'              => 'number',
					'instructions'      => 'Set number of columns to display cross-sell products on Checkout / Cart pages. (2 - 4)',
					'required'          => 0,
					'conditional_logic' => 0,
					'wrapper'           => [
						'width' => '55',
						'class' => '',
						'id'    => '',
					],
					'default_value'     => 2,
					'placeholder'       => '',
					'prepend'           => '',
					'append'            => '',
					'min'               => 2,
					'max'               => 4,
					'step'              => 1,
				],
				[
					'key'               => 'field_5accf7d0b5024',
					'label'             => 'Upsells Total',
					'name'              => 'upsells',
					'type'              => 'number',
					'instructions'      => 'Maxiumum number of upsells shown at the bottom of a products page. (1 - 24)',
					'required'          => 0,
					'conditional_logic' => 0,
					'wrapper'           => [
						'width' => '55',
						'class' => '',
						'id'    => '',
					],
					'default_value'     => 8,
					'placeholder'       => '',
					'prepend'           => '',
					'append'            => '',
					'min'               => 1,
					'max'               => 24,
					'step'              => 1,
				],
				[
					'key'               => 'field_5accf839b5025',
					'label'             => 'Upsell Columns',
					'name'              => 'upsell_columns',
					'type'              => 'number',
					'instructions'      => 'Number of columns to display upsell products (2 - 4)',
					'required'          => 0,
					'conditional_logic' => 0,
					'wrapper'           => [
						'width' => '55',
						'class' => '',
						'id'    => '',
					],
					'default_value'     => 4,
					'placeholder'       => '',
					'prepend'           => '',
					'append'            => '',
					'min'               => 1,
					'max'               => 4,
					'step'              => 1,
				],
				[
					'key'               => 'field_5acce852f8c32',
					'label'             => 'Search Columns',
					'name'              => 'search_columns',
					'type'              => 'number',
					'instructions'      => 'Number of columns used in grid layout of search results page. (2 - 4)',
					'required'          => 0,
					'conditional_logic' => 0,
					'wrapper'           => [
						'width' => '55',
						'class' => '',
						'id'    => '',
					],
					'default_value'     => 3,
					'placeholder'       => '',
					'prepend'           => '',
					'append'            => '',
					'min'               => 3,
					'max'               => 4,
					'step'              => 1,
				],
				[
					'key'               => 'field_57e583d43d478',
					'label'             => 'Checkout Notices',
					'name'              => 'checkout_notices',
					'type'              => 'repeater',
					'instructions'      => 'Enter rows you want to display as individual notice on checkout page.',
					'required'          => 0,
					'conditional_logic' => 0,
					'wrapper'           => [
						'width' => '',
						'class' => '',
						'id'    => '',
					],
					'collapsed'         => '',
					'min'               => 0,
					'max'               => 0,
					'layout'            => 'block',
					'button_label'      => 'Add Row',
					'sub_fields'        => [
						[
							'key'               => 'field_57e587f616c0c',
							'label'             => 'Text',
							'name'              => 'text',
							'type'              => 'wysiwyg',
							'instructions'      => 'Text to be displayed in notice',
							'required'          => 0,
							'conditional_logic' => 0,
							'wrapper'           => [
								'width' => '',
								'class' => '',
								'id'    => '',
							],
							'default_value'     => '',
							'tabs'              => 'all',
							'toolbar'           => 'full',
							'media_upload'      => 1,
							'delay'             => 0,
						],
					],
				],
				[
					'key'               => 'field_582e333496577',
					'label'             => 'Shipping Notices',
					'name'              => 'shipping_notices',
					'type'              => 'wysiwyg',
					'instructions'      => 'Text that will be shown regarding shipping info',
					'required'          => 0,
					'conditional_logic' => 0,
					'wrapper'           => [
						'width' => '',
						'class' => '',
						'id'    => '',
					],
					'default_value'     => '',
					'tabs'              => 'all',
					'toolbar'           => 'full',
					'media_upload'      => 1,
					'delay'             => 0,
				],
				[
					'key'               => 'field_5acce973d906a',
					'label'             => 'Admin Notices',
					'name'              => '',
					'type'              => 'tab',
					'instructions'      => '',
					'required'          => 0,
					'conditional_logic' => 0,
					'wrapper'           => [
						'width' => '',
						'class' => '',
						'id'    => '',
					],
					'placement'         => 'top',
					'endpoint'          => 0,
				],
				[
					'key'               => 'field_5a24f44d11602',
					'label'             => 'Hide Elements',
					'name'              => 'hide_elements',
					'type'              => 'repeater',
					'instructions'      => 'Field group used to select and hide bothersome dashboard notifications',
					'required'          => 0,
					'conditional_logic' => 0,
					'wrapper'           => [
						'width' => '',
						'class' => '',
						'id'    => '',
					],
					'collapsed'         => 'field_5a24f46a11603',
					'min'               => 0,
					'max'               => 0,
					'layout'            => 'block',
					'button_label'      => 'Add Element',
					'sub_fields'        => [
						[
							'key'               => 'field_5a24f46a11603',
							'label'             => 'Selector',
							'name'              => 'selector',
							'type'              => 'textarea',
							'instructions'      => '',
							'required'          => 1,
							'conditional_logic' => 0,
							'wrapper'           => [
								'width' => '',
								'class' => '',
								'id'    => '',
							],
							'default_value'     => '',
							'placeholder'       => '#id_of_element .class_of_element > .sub_select',
							'maxlength'         => '',
							'rows'              => 4,
							'new_lines'         => 'br',
						],
						[
							'key'               => 'field_5a24f72166787',
							'label'             => 'Property',
							'name'              => 'property',
							'type'              => 'text',
							'instructions'      => '',
							'required'          => 1,
							'conditional_logic' => 0,
							'wrapper'           => [
								'width' => '',
								'class' => '',
								'id'    => '',
							],
							'default_value'     => 'display',
							'placeholder'       => 'display',
							'prepend'           => '',
							'append'            => '',
							'maxlength'         => '',
						],
						[
							'key'               => 'field_5a24f6d566786',
							'label'             => 'Value',
							'name'              => 'value',
							'type'              => 'text',
							'instructions'      => '',
							'required'          => 1,
							'conditional_logic' => 0,
							'wrapper'           => [
								'width' => '',
								'class' => '',
								'id'    => '',
							],
							'default_value'     => 'none',
							'placeholder'       => 'none',
							'prepend'           => '',
							'append'            => '',
							'maxlength'         => '',
						],
						[
							'key'               => 'field_5a24f7dc6a81a',
							'label'             => 'Active',
							'name'              => 'active',
							'type'              => 'true_false',
							'instructions'      => '',
							'required'          => 0,
							'conditional_logic' => 0,
							'wrapper'           => [
								'width' => '',
								'class' => '',
								'id'    => '',
							],
							'message'           => '',
							'default_value'     => 1,
							'ui'                => 1,
							'ui_on_text'        => 'On',
							'ui_off_text'       => 'Off',
						],
					],
				],
			],
			'location'              => [
				[
					[
						'param'    => 'options_page',
						'operator' => '==',
						'value'    => 'acf-options',
					],
				],
			],
			'menu_order'            => 0,
			'position'              => 'normal',
			'style'                 => 'default',
			'label_placement'       => 'left',
			'instruction_placement' => 'field',
			'hide_on_screen'        => '',
			'active'                => 1,
			'description'           => '',
		] );

	endif;
*/
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


<?php
//upgrade
function store_customize_register_misc( $wp_customize ) {
$wp_customize->add_section(
    'store_sec_upgrade',
    array(
        'title'     => __('Store Theme - Help & Support','store'),
        'priority'  => 1,
    )
);

$wp_customize->add_setting(
    'store_upgrade',
    array( 'sanitize_callback' => 'esc_textarea' )
);

$wp_customize->add_control(
    new WP_Customize_Upgrade_Control(
        $wp_customize,
        'store_upgrade',
        array(
            'label' => __('Thank You','store'),
            'description' => __('Thank You for Choosing Store Theme by Inkhive.com. Store is a Powerful Wordpress theme which also supports WooCommerce in the best possible way. It is "as we say" the last theme you would ever need. It has all the basic and advanced features needed to run a gorgeous looking site. For any Help related to this theme, please visit  <a href="https://inkhive.com/product/store/">Store Help & Support</a>.','store'),
            'section' => 'store_sec_upgrade',
            'settings' => 'store_upgrade',
        )
    )
);

$wp_customize->add_section(
    'store_sec_pro',
    array(
        'title'     => __('Upgrade to Store PRO','store'),
        'priority'  => 15,
    )
);

$wp_customize->add_setting(
    'store_pro',
    array( 'sanitize_callback' => 'esc_textarea' )
);

$wp_customize->add_control(
    new WP_Customize_Upgrade_Control(
        $wp_customize,
        'store_pro',
        array(
            'label' => __('Upgrade to Pro','store'),
            'description' => __('<a href="https://inkhive.com/product/store-pro/"><strong>Store Pro</strong></a> has so many features that it will make you fall in love with it. <ul class="prolists">
	            <li>Better Responsiveness</li>
	            <li>650+ Google Fonts</li>
	            <li>Carousel, Flex Grid and More Featured Content</li>
	            <li>More Blog Layouts</li>
	            <li>More Page Layouts</li>
	            <li>Advanced Sidebar</li>
	            <li>Advanced Menubar</li>
	            <li>Better Customizer</li>
	            <li>Unlimited Skins, Colors & Designer</li>
	            <li>SEO Optimized</li>
	            <li>Header Layouts</li>
	            <li>Footer Layouts</li>
	            <li>Boxed Layout</li>
	            <li>Custom Widgets</li>
	            <li>More Social Icons</li>
	            <li>Easy to Remove Footer Credit Links</li>
	            <li>And so much more...</li>
	            
	            </ul> <a href="https://inkhive.com/product/store-pro/">Upgrade Now</a>.','store'),
            'section' => 'store_sec_pro',
            'settings' => 'store_pro',
        )
    )
);
}
add_action( 'customize_register', 'store_customize_register_misc' );
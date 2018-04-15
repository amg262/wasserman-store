<?php
//Logo Settings
function store_customize_register_header( $wp_customize ) {
    //Header Settings
    $wp_customize->add_panel('store_header_panel', array(
        'title' => __('Header Settings', 'store'),
        'priority' =>20,
    ));

$wp_customize->add_section( 'title_tagline' , array(
    'title'      => __( 'Title, Tagline & Logo', 'store' ),
    'priority'   => 1,
    'panel'      => 'store_header_panel'
) );

$wp_customize->add_setting( 'store_logo' , array(
    'default'     => '',
    'sanitize_callback' => 'esc_url_raw',
) );
$wp_customize->add_control(
    new WP_Customize_Image_Control(
        $wp_customize,
        'store_logo',
        array(
            'label' => 'Upload Logo',
            'section' => 'title_tagline',
            'settings' => 'store_logo',
            'priority' => 5,
        )
    )
);

$wp_customize->add_setting( 'store_logo_resize' , array(
    'default'     => 100,
    'sanitize_callback' => 'store_sanitize_positive_number',
) );
$wp_customize->add_control(
    'store_logo_resize',
    array(
        'label' => __('Resize & Adjust Logo','store'),
        'section' => 'title_tagline',
        'settings' => 'store_logo_resize',
        'priority' => 6,
        'type' => 'range',
        'active_callback' => 'store_logo_enabled',
        'input_attrs' => array(
            'min'   => 30,
            'max'   => 200,
            'step'  => 5,
        ),
    )
);

function store_logo_enabled($control) {
    $option = $control->manager->get_setting('store_logo');
    return $option->value() == true;
}

    //Settings For Logo Area

    $wp_customize->add_setting(
        'store_hide_title_tagline',
        array( 'sanitize_callback' => 'store_sanitize_checkbox' )
    );

    $wp_customize->add_control(
        'store_hide_title_tagline', array(
            'settings' => 'store_hide_title_tagline',
            'label'    => __( 'Hide Title and Tagline.', 'store' ),
            'section'  => 'title_tagline',
            'type'     => 'checkbox',
        )
    );
    function store_title_visible( $control ) {
        $option = $control->manager->get_setting('store_hide_title_tagline');
        return $option->value() == false ;
    }

//Replace Header Text Color with, separate colors for Title and Description
//Override store_site_titlecolor
$wp_customize->remove_control('display_header_text');
$wp_customize->remove_setting('header_textcolor');
$wp_customize->add_setting('store_site_titlecolor', array(
    'default'     => '#FFFFFF',
    'sanitize_callback' => 'sanitize_hex_color',
));

$wp_customize->add_control(new WP_Customize_Color_Control(
        $wp_customize,
        'store_site_titlecolor', array(
        'label' => __('Site Title Color','store'),
        'section' => 'colors',
        'settings' => 'store_site_titlecolor',
        'type' => 'color'
    ) )
);

$wp_customize->add_setting('store_header_desccolor', array(
    'default'     => '#FFFFFF',
    'sanitize_callback' => 'sanitize_hex_color',
));

$wp_customize->add_control(new WP_Customize_Color_Control(
        $wp_customize,
        'store_header_desccolor', array(
        'label' => __('Site Tagline Color','store'),
        'section' => 'colors',
        'settings' => 'store_header_desccolor',
        'type' => 'color'
    ) )
);
}
add_action( 'customize_register', 'store_customize_register_header' );
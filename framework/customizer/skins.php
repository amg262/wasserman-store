<?php
//Select the Default Theme Skin
function store_customize_register_skins( $wp_customize ) {
$wp_customize->add_setting(
    'store_skin',
    array(
        'default'=> 'default',
        'sanitize_callback' => 'store_sanitize_skin'
    )
);

$skins = array( 'default' => __('Default(blue)','store'),
    'orange' =>  __('Orange','store'),
    'brown' =>  __('Brown','store'),
    'green' => __('Green','store'),
    'grayscale' => __('GrayScale','store'),
    'radish' => __('Radish','store'));

$wp_customize->add_control(
    'store_skin',array(
        'settings' => 'store_skin',
        'section'  => 'colors',
        'type' => 'select',
        'choices' => $skins,
    )
);

function store_sanitize_skin( $input ) {
    if ( in_array($input, array('default','orange','brown','green','grayscale','radish') ) )
        return $input;
    else
        return '';
}
}
add_action( 'customize_register', 'store_customize_register_skins' );
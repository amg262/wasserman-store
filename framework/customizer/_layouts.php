<?php
// Layout and Design
function store_customize_register_layouts( $wp_customize ) {
$wp_customize->add_panel( 'store_design_panel', array(
    'priority'       => 21,
    'capability'     => 'edit_theme_options',
    'theme_supports' => '',
    'title'          => __('Design & Layout','store'),
) );

$wp_customize->add_section(
    'store_design_options',
    array(
        'title'     => __('Blog Layout','store'),
        'priority'  => 0,
        'panel'     => 'store_design_panel'
    )
);


$wp_customize->add_setting(
    'store_blog_layout',
    array( 'sanitize_callback' => 'store_sanitize_blog_layout' )
);

function store_sanitize_blog_layout( $input ) {
    if ( in_array($input, array('grid','grid_2_column','store','store_3_column','blog_mixup') ) )
        return $input;
    else
        return '';
}

$wp_customize->add_control(
    'store_blog_layout',array(
        'label' => __('Select Layout','store'),
        'settings' => 'store_blog_layout',
        'section'  => 'store_design_options',
        'type' => 'select',
        'choices' => array(
            'grid' => __('Standard Blog Layout','store'),
            'store' => __('Store Theme Layout','store'),
            'store_3_column' => __('Store Theme Layout (3 Columns)','store'),
            'grid_2_column' => __('Grid - 2 Column','store'),
            'blog_mixup'    => __('Blog Mixup','store'),
        )
    )
);

$wp_customize->add_section(
    'store_sidebar_options',
    array(
        'title'     => __('Sidebar Layout','store'),
        'priority'  => 0,
        'panel'     => 'store_design_panel'
    )
);

$wp_customize->add_setting(
    'store_disable_sidebar',
    array( 'sanitize_callback' => 'store_sanitize_checkbox' )
);

$wp_customize->add_control(
    'store_disable_sidebar', array(
        'settings' => 'store_disable_sidebar',
        'label'    => __( 'Disable Sidebar Everywhere.','store' ),
        'section'  => 'store_sidebar_options',
        'type'     => 'checkbox',
        'default'  => false
    )
);

$wp_customize->add_setting(
    'store_disable_sidebar_home',
    array( 'sanitize_callback' => 'store_sanitize_checkbox' )
);

$wp_customize->add_control(
    'store_disable_sidebar_home', array(
        'settings' => 'store_disable_sidebar_home',
        'label'    => __( 'Disable Sidebar on Home/Blog.','store' ),
        'section'  => 'store_sidebar_options',
        'type'     => 'checkbox',
        'active_callback' => 'store_show_sidebar_options',
        'default'  => false
    )
);

$wp_customize->add_setting(
    'store_disable_sidebar_front',
    array( 'sanitize_callback' => 'store_sanitize_checkbox' )
);

$wp_customize->add_control(
    'store_disable_sidebar_front', array(
        'settings' => 'store_disable_sidebar_front',
        'label'    => __( 'Disable Sidebar on Front Page.','store' ),
        'section'  => 'store_sidebar_options',
        'type'     => 'checkbox',
        'active_callback' => 'store_show_sidebar_options',
        'default'  => false
    )
);


$wp_customize->add_setting(
    'store_sidebar_width',
    array(
        'default' => 4,
        'sanitize_callback' => 'store_sanitize_positive_number' )
);

$wp_customize->add_control(
    'store_sidebar_width', array(
        'settings' => 'store_sidebar_width',
        'label'    => __( 'Sidebar Width','store' ),
        'description' => __('Min: 25%, Default: 33%, Max: 40%','store'),
        'section'  => 'store_sidebar_options',
        'type'     => 'range',
        'active_callback' => 'store_show_sidebar_options',
        'input_attrs' => array(
            'min'   => 3,
            'max'   => 5,
            'step'  => 1,
            'class' => 'sidebar-width-range',
            'style' => 'color: #0a0',
        ),
    )
);

/* Active Callback Function */
function store_show_sidebar_options($control) {

    $option = $control->manager->get_setting('store_disable_sidebar');
    return $option->value() == false ;

}

class Store_Custom_CSS_Control extends WP_Customize_Control {
    public $type = 'textarea';

    public function render_content() {
        ?>
        <label>
            <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
            <textarea rows="8" style="width:100%;" <?php $this->link(); ?>><?php echo esc_textarea( $this->value() ); ?></textarea>
        </label>
        <?php
    }
}

$wp_customize-> add_section(
    'store_custom_codes',
    array(
        'title'			=> __('Custom CSS','store'),
        'description'	=> __('Enter your Custom CSS to Modify design.','store'),
        'priority'		=> 11,
        'panel'			=> 'store_design_panel'
    )
);

$wp_customize->add_setting(
    'store_custom_css',
    array(
        'default'		=> '',
        'capability'           => 'edit_theme_options',
        'sanitize_callback'    => 'wp_filter_nohtml_kses',
        'sanitize_js_callback' => 'wp_filter_nohtml_kses'
    )
);

$wp_customize->add_control(
    new Store_Custom_CSS_Control(
        $wp_customize,
        'store_custom_css',
        array(
            'section' => 'store_custom_codes',
            'settings' => 'store_custom_css'
        )
    )
);

function store_sanitize_text( $input ) {
    return wp_kses_post( force_balance_tags( $input ) );
}

$wp_customize-> add_section(
    'store_custom_footer',
    array(
        'title'			=> __('Custom Footer Text','store'),
        'description'	=> __('Enter your Own Copyright Text.','store'),
        'priority'		=> 11,
        'panel'			=> 'store_design_panel'
    )
);

$wp_customize->add_setting(
    'store_footer_text',
    array(
        'default'		=> '',
        'sanitize_callback'	=> 'sanitize_text_field'
    )
);

$wp_customize->add_control(
    'store_footer_text',
    array(
        'section' => 'store_custom_footer',
        'settings' => 'store_footer_text',
        'type' => 'text'
    )
);
}
add_action( 'customize_register', 'store_customize_register_layouts' );
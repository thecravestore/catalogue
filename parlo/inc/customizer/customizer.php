<?php
/**
 * Parlo Theme Customizer
 *
 * @package Parlo
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function parlo_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector'        => '.site-title a',
			'render_callback' => 'parlo_customize_partial_blogname',
		) );
		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector'        => '.site-description',
			'render_callback' => 'parlo_customize_partial_blogdescription',
		) );
	}
}
add_action( 'customize_register', 'parlo_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function parlo_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function parlo_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function parlo_customize_preview_js() {
	wp_enqueue_script( 'parlo-customizer', get_template_directory_uri() . '/assets/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'parlo_customize_preview_js' );

// Parlo
function parlo_customizer_settings( $wp_customize ){

	//Add panel
	$wp_customize->add_panel( 'parlo_panel', array(
		'title'   => __('Parlo Options', 'parlo'),
		'capability' => 'edit_theme_options',
		'theme_supports' => '',
		'description' => __( 'Parlo Settings','parlo' ),
		'priority' => 220, // Mixed with top-level-section hierarchy.
	) );

	// Add Section For Footer
	$wp_customize->add_section('parlo_footer_settings',array(
		'title'     => __('Footer Optinos','parlo'),
		'panel'		=> 'parlo_panel'
	));

    // Add Section For WooCommerce
    $wp_customize->add_section('parlo_woocommerce_settings',array(
        'title'     => __('Layout','parlo'),
        'panel'     => 'woocommerce'
    ));

    // Add Section For Social Media
    $wp_customize->add_section('parlo_social_settings',array(
        'title'     => __('Social Media','parlo'),
        'panel'     => 'parlo_panel'
    ));

    // Add Section For Blog
	$wp_customize->add_section('parlo_blog_settings',array(
		'title'     => __('Blog','parlo'),
		'panel'		=> 'parlo_panel'
	));

    // Blog Fields Start
    $wp_customize->add_setting( 'parlo_blog_layout', array(
        'transport'             => 'refresh',
        'default'               => 'right',
        'sanitize_callback' => 'parlo_sanitize_select'
    ) );
    $wp_customize->add_control(
        'parlo_blog_layout',
        array(
            'label'     => __('Blog Layout','parlo'),
            'type'      => 'select',
            'section'   => 'parlo_blog_settings',
            'choices'   => array(
                'full'  => __('Full Width','parlo'),
                'left'  => __('Left Sidebar','parlo'),
                'right' => __('Right Sidebar','parlo'),
            ),
        )
    );

    // Blog Details Layout
    $wp_customize->add_setting( 'parlo_blogdetails_layout', array(
        'transport'             => 'refresh',
        'default'               => 'right',
        'sanitize_callback' => 'parlo_sanitize_select'
    ) );
    $wp_customize->add_control(
        'parlo_blogdetails_layout',
        array(
            'label'     => __('Blog Details Layout','parlo'),
            'type'      => 'select',
            'section'   => 'parlo_blog_settings',
            'choices'   => array(
                'full'  => __('Full Width','parlo'),
                'left'  => __('Left Sidebar','parlo'),
                'right' => __('Right Sidebar','parlo'),
            ),
        )
    );

    // Blog Style
    $wp_customize->add_setting( 'parlo_blog_style', array(
        'transport'             => 'refresh',
        'default'               => '1',
        'sanitize_callback' => 'parlo_sanitize_select'
    ) );
    $wp_customize->add_control(
        'parlo_blog_style',
        array(
            'label'     => __('Blog Style','parlo'),
            'type'      => 'select',
            'section'   => 'parlo_blog_settings',
            'choices'   => array(
                '1'     => __('Style One','parlo'),
                '2'     => __('Style Two','parlo'),
            ),
        )
    );

    // Blog Column
    $wp_customize->add_setting(
        'parlo_blog_column',
        array(
            'default'              => 2,
            'type'                 => 'option',
            'sanitize_callback'    => 'absint',
            'sanitize_js_callback' => 'absint',
        )
    );
    $wp_customize->add_control(
        'parlo_blog_column',
        array(
            'label'       => __( 'Column', 'parlo' ),
            'description' => __( 'How many column should be shown blog page? ( Minimum 1, Maximum 6 )', 'parlo' ),
            'section'     => 'parlo_blog_settings',
            'settings'    => 'parlo_blog_column',
            'type'        => 'number',
            'input_attrs' => array(
                'min'  => 1,
                'max'  => 6,
                'step' => 1,
            ),
        )
    );

    // Blog Title Length
    $wp_customize->add_setting(
        'parlo_blog_title_len',
        array(
            'default'              => 5,
            'type'                 => 'option',
            'sanitize_callback'    => 'absint',
            'sanitize_js_callback' => 'absint',
        )
    );
    $wp_customize->add_control(
        'parlo_blog_title_len',
        array(
            'label'       => __( 'Title Length', 'parlo' ),
            'section'     => 'parlo_blog_settings',
            'settings'    => 'parlo_blog_title_len',
            'type'        => 'number',
        )
    );

    // Blog Content Length
    $wp_customize->add_setting(
        'parlo_blog_content_len',
        array(
            'default'              => 19,
            'type'                 => 'option',
            'sanitize_callback'    => 'absint',
            'sanitize_js_callback' => 'absint',
        )
    );
    $wp_customize->add_control(
        'parlo_blog_content_len',
        array(
            'label'       => __( 'Content Length', 'parlo' ),
            'section'     => 'parlo_blog_settings',
            'settings'    => 'parlo_blog_content_len',
            'type'        => 'number',
        )
    );

    // Blog Title enable disable
    $wp_customize->add_setting('parlo_blogtitle_status',array(
        'default'     => 'on',
        'transport'   => 'refresh',
        'sanitize_callback' => 'parlo_sanitize_select'
    ));
    $wp_customize->add_control( 'parlo_blogtitle_status', array(
        'section'   => 'parlo_blog_settings',
        'label' => __('Enable / Disable Title','parlo'),
        'type'   => 'radio',
        'choices'   => array(
            'on'    => __('Enable','parlo'),
            'off'   => __('Disable','parlo'),
        )
    ) );

    // Blog Content enable disable
    $wp_customize->add_setting('parlo_blogcontent_status',array(
        'default'     => 'on',
        'transport'   => 'refresh',
        'sanitize_callback' => 'parlo_sanitize_select'
    ));
    $wp_customize->add_control( 'parlo_blogcontent_status', array(
        'section'   => 'parlo_blog_settings',
        'label' => __('Enable / Disable Content','parlo'),
        'type'   => 'radio',
        'choices'   => array(
            'on'    => __('Enable','parlo'),
            'off'   => __('Disable','parlo'),
        )
    ) );

    // Blog Meta enable disable
    $wp_customize->add_setting('parlo_blogmeta_status',array(
        'default'     => 'on',
        'transport'   => 'refresh',
        'sanitize_callback' => 'parlo_sanitize_select'
    ));
    $wp_customize->add_control( 'parlo_blogmeta_status', array(
        'section'   => 'parlo_blog_settings',
        'label' => __('Enable / Disable Meta','parlo'),
        'type'   => 'radio',
        'choices'   => array(
            'on'    => __('Enable','parlo'),
            'off'   => __('Disable','parlo'),
        )
    ) );

    // Blog Fields End

    // WooCommerce Fields Start
    if ( class_exists( 'WooCommerce' ) ) {

        $wp_customize->add_setting(
            'parlo_shop_layout',
            array(
                'default'           => 'full',
                'transport'         => 'refresh',
                'type'              => 'option',
                'sanitize_callback' => 'parlo_sanitize_select'
            )
        );
        $wp_customize->add_control(
            'parlo_shop_layout',
            array(
                'label'       => __( 'Shop page Layout', 'parlo' ),
                'description' => __( 'Choose what to display on the main shop page layout.', 'parlo' ),
                'section'     => 'parlo_woocommerce_settings',
                'settings'    => 'parlo_shop_layout',
                'type'        => 'select',
                'choices'     => array(
                    'full'          => __( 'Full Width', 'parlo' ),
                    'left'          => __( 'Left Sidebar', 'parlo' ),
                    'right'         => __( 'Right Sidebar', 'parlo' ),
                ),
            )
        );

        $wp_customize->add_setting(
            'parlo_shopdetails_layout',
            array(
                'default'           => 'full',
                'transport'         => 'refresh',
                'type'              => 'option',
                'sanitize_callback' => 'parlo_sanitize_select'
            )
        );
        $wp_customize->add_control(
            'parlo_shopdetails_layout',
            array(
                'label'       => __( 'Product details page Layout', 'parlo' ),
                'description' => __( 'Choose what to display on the main product details page layout.', 'parlo' ),
                'section'     => 'parlo_woocommerce_settings',
                'settings'    => 'parlo_shopdetails_layout',
                'type'        => 'select',
                'choices'     => array(
                    'full'          => __( 'Full Width', 'parlo' ),
                    'left'          => __( 'Left Sidebar', 'parlo' ),
                    'right'         => __( 'Right Sidebar', 'parlo' ),
                ),
            )
        );

        $wp_customize->add_setting(
            'parlo_product_per_page',
            array(
                'default'              => 12,
                'type'                 => 'option',
                'sanitize_callback'    => 'absint',
                'sanitize_js_callback' => 'absint',
            )
        );
        $wp_customize->add_control(
            'parlo_product_per_page',
            array(
                'label'       => __( 'Products per page', 'parlo' ),
                'description' => __( 'How many products should be shown per page?', 'parlo' ),
                'section'     => 'woocommerce_product_catalog',
                'settings'    => 'parlo_product_per_page',
                'type'        => 'number',
                'input_attrs' => array(
                    'min'  => wc_get_theme_support( 'product_grid::min_columns', 1 ),
                    'max'  => wc_get_theme_support( 'product_grid::max_columns', '' ),
                    'step' => 1,
                ),
            )
        );
    } 
    // WooCommerce Fields End

	// Footer Field
	$wp_customize->add_setting( 'parlo_footer_layout', array(
		'transport' 			=> 'refresh',
		'default' 				=> '1',
		'sanitize_callback'	=> 'parlo_sanitize_select'
	) );
    $wp_customize->add_control(
        'parlo_footer_layout',
        array(
            'label'     => __('Footer Layout','parlo'),
            'type'      => 'select',
            'section'   => 'parlo_footer_settings',
            'choices'   => array(
                '1'     => __('Layout One','parlo'),
                '2'     => __('Layout Two','parlo'),
            ),
        )
    );

	$wp_customize->add_setting('parlo_footer_copyright_text',array(
		'sanitize_callback'			=> 'parlo_sanitize_input',
		'transport'   				=> 'postMessage',
		'default'     				=> 'Copyright &copy; '.date('Y').' All Right Reserved.',
	));
	$wp_customize->add_control( 'parlo_footer_copyright_text', array(
		'section'	=> 'parlo_footer_settings',
	    'label' => __('Footer copyright text','parlo'),
		'type'	 => 'textarea',
	) );

	$wp_customize->add_setting( 'parlo_payment_icon_image', array(
		'transport' 			=> 'refresh',
		'default'           	=> get_template_directory_uri().'/assets/img/payment_icon_1.png',
		'sanitize_callback'		=> 'sanitize_text_field'
	) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'parlo_payment_icon_image', array(
		'label'	   				=> __('Payment Icon Image','parlo'),
		'section'  				=> 'parlo_footer_settings',
	) ) );

	// Social Media
	$wp_customize->add_setting('parlo_social_facebook', array(
        'default'        	=> __('Facebook', 'parlo'),
        'sanitize_callback'	=> 'parlo_sanitize_input',
        'capability'     	=> 'edit_theme_options',
        'transport'   		=> 'postMessage',
        'type'           	=> 'option',
 
    ));
    $wp_customize->add_control('parlo_social_facebook', array(
        'label'      => __('Facebook', 'parlo'),
        'section'    => 'parlo_social_settings',
    ));

	$wp_customize->add_setting('parlo_social_facebook_url', array(
        'default'        => __('facebook.com', 'parlo'),
        'sanitize_callback'	=> 'parlo_sanitize_input',
        'capability'     	=> 'edit_theme_options',
        'transport'   		=> 'postMessage',
        'type'           	=> 'option',
 
    ));
    $wp_customize->add_control('parlo_social_facebook_url', array(
        'label'      => __('Facebook Profile URL', 'parlo'),
        'section'    => 'parlo_social_settings',
    ));

	$wp_customize->add_setting('parlo_social_twitter', array(
        'default'        => __('Twitter', 'parlo'),
        'sanitize_callback'	=> 'parlo_sanitize_input',
        'capability'     	=> 'edit_theme_options',
        'transport'   		=> 'postMessage',
        'type'           	=> 'option',
 
    ));
    $wp_customize->add_control('parlo_social_twitter', array(
        'label'      => __('Twitter', 'parlo'),
        'section'    => 'parlo_social_settings',
    ));
	$wp_customize->add_setting('parlo_social_twitter_url', array(
        'default'        => __('twitter.com', 'parlo'),
        'sanitize_callback'	=> 'parlo_sanitize_input',
        'capability'     	=> 'edit_theme_options',
        'transport'   		=> 'postMessage',
        'type'           	=> 'option',
 
    ));
    $wp_customize->add_control('parlo_social_twitter_url', array(
        'label'      => __('Twitter Profile URL', 'parlo'),
        'section'    => 'parlo_social_settings',
    ));

	$wp_customize->add_setting('parlo_social_linkedin', array(
        'default'        => __('Linkedin', 'parlo'),
        'sanitize_callback'	=> 'parlo_sanitize_input',
        'capability'     	=> 'edit_theme_options',
        'transport'   		=> 'postMessage',
        'type'           	=> 'option',
 
    ));
    $wp_customize->add_control('parlo_social_linkedin', array(
        'label'      => __('Linkedin', 'parlo'),
        'section'    => 'parlo_social_settings',
    ));
	$wp_customize->add_setting('parlo_social_linkedin_url', array(
        'default'        => __('linkedin.com', 'parlo'),
        'sanitize_callback'	=> 'parlo_sanitize_input',
        'capability'     	=> 'edit_theme_options',
        'transport'   		=> 'postMessage',
        'type'           	=> 'option',
 
    ));
    $wp_customize->add_control('parlo_social_linkedin_url', array(
        'label'      => __('Linkedin Profile URL', 'parlo'),
        'section'    => 'parlo_social_settings',
    ));

	$wp_customize->add_setting('parlo_social_instragram', array(
        'default'        => __('Instragram', 'parlo'),
        'sanitize_callback'	=> 'parlo_sanitize_input',
        'capability'     	=> 'edit_theme_options',
        'transport'   		=> 'postMessage',
        'type'           	=> 'option',
 
    ));
    $wp_customize->add_control('parlo_social_instragram', array(
        'label'      => __('Instragram', 'parlo'),
        'section'    => 'parlo_social_settings',
    ));
	$wp_customize->add_setting('parlo_social_instragram_url', array(
        'default'        => __('instragram.com', 'parlo'),
        'sanitize_callback'	=> 'parlo_sanitize_input',
        'capability'     	=> 'edit_theme_options',
        'transport'   		=> 'postMessage',
        'type'           	=> 'option',
 
    ));
    $wp_customize->add_control('parlo_social_instragram_url', array(
        'label'      => __('Instragram Profile URL', 'parlo'),
        'section'    => 'parlo_social_settings',
    ));

}
add_action( 'customize_register', 'parlo_customizer_settings' );


<?php
    /**
     * Register widget area.
     *
     * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
     */
    function parlo_widgets_init() {

        register_sidebar( array(
            'name'          => esc_html__( 'Sidebar', 'parlo' ),
            'id'            => 'sidebar-1',
            'description'   => esc_html__( 'Add widgets here.', 'parlo' ),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        ) );

        register_sidebar( array(
            'name'          => esc_html__( 'WooCommerce Sidebar', 'parlo' ),
            'id'            => 'sidebar-2',
            'description'   => esc_html__( 'Add widgets here.', 'parlo' ),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h4 class="widget-title">',
            'after_title'   => '</h4>',
        ) );

        register_sidebar( array(
            'name'          => esc_html__( 'Header Quick Menu', 'parlo' ),
            'id'            => 'header-quickmenu',
            'description'   => esc_html__( 'Add widgets here.', 'parlo' ),
            'before_widget' => '<div id="%1$s" class="single-header-quick-menu %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h4 class="widget-title">',
            'after_title'   => '</h4>',
        ) );

        $footer_widget_column = 4;
        for( $footer = 1; $footer <= $footer_widget_column; $footer++ ){
            register_sidebar( array(
                'name'          => 'Footer ' .$footer,
                'id'            => 'parlo-footer-' .$footer,
                'description'   => esc_html__( 'Add widgets here.', 'parlo' ),
                'before_widget' => '<div id="%1$s" class="footer-widget elementor-widget-wrap elementor-element-populated %2$s"><div class="single-widget">',
                'after_widget'  => '</div></div>',
                'before_title'  => '<h4 class="footer-title">',
                'after_title'   => '</h4>',
            ) );
        }

    }

    add_action( 'widgets_init', 'parlo_widgets_init' );
    
?>
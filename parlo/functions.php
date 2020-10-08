<?php
/**
 * Parlo functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Parlo
 */

if ( ! function_exists( 'parlo_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function parlo_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Parlo, use a find and replace
		 * to change 'parlo' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'parlo', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		/**
		* Add Image Size
		*/
		add_image_size('parlo_size_550x350',550,350,true);

		/**
		* Add Editor style
		*/
		add_theme_support( 'editor-styles' );
		add_editor_style('assets/css/editor-style.css');

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'mainmenu' => esc_html__( 'Primary', 'parlo' ),
			'footermenu' => esc_html__( 'Footer Menu', 'parlo' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'parlo_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
	}
endif;
add_action( 'after_setup_theme', 'parlo_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function parlo_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'parlo_content_width', 640 );
}
add_action( 'after_setup_theme', 'parlo_content_width', 0 );

/**
 * Register custom fonts.
 */
 if ( !function_exists( 'parlo_fonts_url' ) ) :
	function parlo_fonts_url() {
		$fonts_url = '';
		$fonts     = array();
		$subsets   = 'latin,latin-ext';

		/* translators: If there are characters in your language that are not supported by Open Sans, translate this to 'off'. Do not translate into your own language. */
		if ( 'off' !== _x( 'on', 'Roboto font: on or off', 'parlo' ) ) {
			$fonts[] = 'Roboto:300,400,500,700';
		}

		/* translators: If there are characters in your language that are not supported by Open Sans, translate this to 'off'. Do not translate into your own language. */
		if ( 'off' !== _x( 'on', 'Poppins font: on or off', 'parlo' ) ) {
			$fonts[] = 'Poppins:300,400,500,600,700';
		}
		
		if ( $fonts ) {
			$fonts_url = add_query_arg( array(
				'family' => urlencode( implode( '|', $fonts ) ),
				'subset' => urlencode( $subsets ),
			), 'https://fonts.googleapis.com/css' );
		}

		return $fonts_url;
	}
endif;

/**
 * Enqueue scripts and styles.
 */
function parlo_scripts() {

	wp_enqueue_style('parlo-font', parlo_fonts_url());

	wp_enqueue_style( 'font-awesome' );
	wp_enqueue_style('htflexboxgrid', get_template_directory_uri() . '/assets/css/htflexboxgrid.css');
	wp_enqueue_style( 'parlo-style', get_stylesheet_uri() );

	wp_enqueue_script( 'slick' );
	wp_enqueue_script( 'woolentor-widgets-scripts' );
	wp_enqueue_script( 'parlo-main', get_template_directory_uri() . '/assets/js/main.js', array(), '1.0.0', true );
	wp_enqueue_script( 'parlo-navigation', get_template_directory_uri() . '/assets/js/navigation.js', array(), '20151215', true );
	wp_enqueue_script( 'parlo-skip-link-focus-fix', get_template_directory_uri() . '/assets/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'parlo_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Theme Helpers Functions.
 */
require get_template_directory() . '/inc/helpers-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer/customizer.php';
require get_template_directory() . '/inc/customizer/sanitization-callbacks.php';

/**
 * Widgets registrar.
 */
require get_template_directory() . '/inc/widgets_register.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Load WooCommerce compatibility file.
 */
if ( class_exists( 'WooCommerce' ) ) {
	require get_template_directory() . '/inc/woocommerce.php';
}

/**
 * Load TGM plugins
 */
require get_template_directory() . '/inc/libs/tgm-plugin/init.php';

/**
* Pagination 
*/
if( !function_exists('parlo_blog_pagination') ){
	function parlo_blog_pagination(){
		?>
		<div class="ht-col-xs-12"><div class="post-pagination">
			<?php
				the_posts_pagination(array(
					'prev_text'          => '<i class="fa fa-angle-left"></i>',
					'next_text'          => '<i class="fa fa-angle-right"></i>',
					'type'               => 'list'
				));
			?>
		</div></div>
		<?php
	}
}

// Footer class
function parlo_footer_class_add( $footerclass ){
	$footer_layout = parlo_get_option( 'parlo_footer_layout', 'footerlayout', '1' );
	if( $footer_layout == '2' ){
		$footerclass = 'footer_area_two';
	}
	return $footerclass;
}
add_filter( 'parlo_footer_class', 'parlo_footer_class_add', 1 );
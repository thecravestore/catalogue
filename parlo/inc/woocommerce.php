<?php
/**
 * WooCommerce Compatibility File
 *
 * @link https://woocommerce.com/
 *
 * @package Parlo
 */

/**
 * WooCommerce setup function.
 *
 * @link https://docs.woocommerce.com/document/third-party-custom-theme-compatibility/
 * @link https://github.com/woocommerce/woocommerce/wiki/Enabling-product-gallery-features-(zoom,-swipe,-lightbox)-in-3.0.0
 *
 * @return void
 */
function parlo_woocommerce_setup() {
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'parlo_woocommerce_setup' );


/**
 * Add 'woocommerce-active' class to the body tag.
 *
 * @param  array $classes CSS classes applied to the body tag.
 * @return array $classes modified to include 'woocommerce-active' class.
 */
function parlo_woocommerce_active_body_class( $classes ) {
	$classes[] = 'woocommerce-active';

	return $classes;
}
add_filter( 'body_class', 'parlo_woocommerce_active_body_class' );

/**
 * Products per page.
 *
 * @return integer number of products.
 */
function parlo_woocommerce_products_per_page() {
	$perpage = parlo_get_option( 'parlo_product_per_page', 'productlimit', '12' );
	return $perpage;
}
add_filter( 'loop_shop_per_page', 'parlo_woocommerce_products_per_page' );

/**
 * Product gallery thumnbail columns.
 *
 * @return integer number of columns.
 */
function parlo_woocommerce_thumbnail_columns() {
	return 4;
}
add_filter( 'woocommerce_product_thumbnails_columns', 'parlo_woocommerce_thumbnail_columns' );

/**
 * Related Products Args.
 *
 * @param array $args related products args.
 * @return array $args related products args.
 */
function parlo_woocommerce_related_products_args( $args ) {
	$defaults = array(
		'posts_per_page' => 3,
		'columns'        => 3,
	);

	$args = wp_parse_args( $defaults, $args );

	return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'parlo_woocommerce_related_products_args' );

/**
* Remove Action
*/
function parlo_remove_action(){
	
    // Shop page
	remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
	remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
	remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
	remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
    remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
    remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
	remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

    // Single Product page
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );

}
add_action( 'init', 'parlo_remove_action', 10 );

/**
* Add Action
*/
function parlo_add_action(){

    // Single Product page
    add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 9 );
    add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );

    add_action( 'woocommerce_after_add_to_cart_button', 'parlo_add_to_wishlist_button', 10 );
}
add_action( 'init', 'parlo_add_action', 10 );

// Shop page Header wrapper
if( ! function_exists('parlo_woocommerce_shop_wrapper') ){
	function parlo_woocommerce_shop_wrapper(){
		echo '<div class="ht-row"><div class="ht-col-md-12 ht-col-xs-12">';
	}
}
add_action( 'woocommerce_before_shop_loop', 'parlo_woocommerce_shop_wrapper', 9 );

// Shop page Header wrapper close
if( ! function_exists('parlo_woocommerce_shop_wrapper_close') ){
	function parlo_woocommerce_shop_wrapper_close(){
		echo '</div></div>';
	}
}
add_action( 'woocommerce_before_shop_loop', 'parlo_woocommerce_shop_wrapper_close', 31 );

// parlo shop header area
if( !function_exists('parlo_shop_header_content') ){
    function parlo_shop_header_content(){
        echo '<div class="shop-header-content-area">';
            echo '<ul class="parlo-cus-tab-links"><li><a class="cusactive" href="#grid"><i class="sli sli-grid"></i></a></li><li><a href="#list"><i class="sli sli-menu"></i></a></li></ul>';
            woocommerce_result_count();
            woocommerce_catalog_ordering();
        echo '</div>';
    }
}
add_action( 'woocommerce_before_shop_loop', 'parlo_shop_header_content', 20 );

// Product Columns
if ( ! function_exists( 'parlo_woocommerce_product_columns_wrapper' ) ) {
	/**
	 * Product columns wrapper.
	 *
	 * @return  void
	 */
	function parlo_woocommerce_product_columns_wrapper() {
		$columns = wc_get_loop_prop( 'columns' );
		echo '<div class="columns-' . absint( $columns ) . '">';
	}
}
add_action( 'woocommerce_before_shop_loop', 'parlo_woocommerce_product_columns_wrapper', 40 );

if ( ! function_exists( 'parlo_woocommerce_product_columns_wrapper_close' ) ) {
	/**
	 * Product columns wrapper close.
	 *
	 * @return  void
	 */
	function parlo_woocommerce_product_columns_wrapper_close() {
		echo '</div>';
	}
}
add_action( 'woocommerce_after_shop_loop', 'parlo_woocommerce_product_columns_wrapper_close', 40 );

/**
 * Remove default WooCommerce wrapper.
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

if ( ! function_exists( 'parlo_woocommerce_wrapper_before' ) ) {
	/**
	 * Before Content.
	 *
	 * Wraps all WooCommerce content in wrappers which match the theme markup.
	 *
	 * @return void
	 */
	function parlo_woocommerce_wrapper_before() {
		?>
		<div id="primary" class="shop-area parlopage-padding">
			<main id="main" class="site-main" role="main">
				<div class="ht-container">
					<div class="ht-row">
			<?php
	}
}
add_action( 'woocommerce_before_main_content', 'parlo_woocommerce_wrapper_before' );

if ( ! function_exists( 'parlo_woocommerce_wrapper_after' ) ) {
	/**
	 * After Content.
	 *
	 * Closes the wrapping divs.
	 *
	 * @return void
	 */
	function parlo_woocommerce_wrapper_after() {
			?>
					</div>
				</div>
			</main><!-- #main -->
		</div><!-- #primary -->
		<?php
	}
}
add_action( 'woocommerce_after_main_content', 'parlo_woocommerce_wrapper_after' );

/*
 * Ensure cart contents update when products are added to the cart via AJAX.
 */
function parlo_wc_add_to_cart_fragment( $fragments ) {
	ob_start();
	?>
       <span class="parlo-mini-cart">
	       <span class="minicart-counter"><?php echo sprintf ( wp_kses_post( '%d', '%d', WC()->cart->get_cart_contents_count() ), WC()->cart->get_cart_contents_count() ); ?></span>
	       <span class="minicart-price"><?php echo WC()->cart->get_cart_subtotal(); ?></span>
       </span>
	<?php
	$fragments['span.parlo-mini-cart'] = ob_get_clean();
	return $fragments;
}
add_filter( 'woocommerce_add_to_cart_fragments', 'parlo_wc_add_to_cart_fragment' );

/**
 * Shopping cart in header.
 *
 */
if ( ! function_exists( 'parlo_wc_shopping_cart' ) ) {
	function parlo_wc_shopping_cart() {
		global $woocommerce;

		$output = '';
		$output .= '<a class="parlo-dropdown-toggle" href="#">';
			$output .= '<i class="sli sli-bag"></i>';
			$output .= '<span class="parlo-mini-cart"><span class="minicart-counter">' . esc_html( $woocommerce->cart->get_cart_contents_count() ) . '</span>';
			$output .= '<span class="minicart-price">' . $woocommerce->cart->get_cart_subtotal() . '</span></span>';
		$output .= '</a>';
		$output .='<div class="minicart-page-area parlo-dropdown-menu"><h3>'.esc_html( 'Shoping Cart' ).'</h3><span class="mini-cart-close parlo-dropdown-close"><i class="sli sli-close"></i></span>';
			$output .='<div class="items-list"><div class="widget_shopping_cart_content"></div></div>';
		$output .='</div>';

		return apply_filters( 'parlo_wc_shopping_cart', $output );
	}
}

/**
 * Load mini cart on header.
 *
 */
function parlo_wc_render_mini_cart() {
	$output = '';
	ob_start();
		$args['list_class'] = '';
		wc_get_template( 'cart/mini-cart.php' );
	$output = ob_get_clean();

	$result = array(
		'message'    => WC()->session->get( 'wc_notices' ),
		'cart_total' => WC()->cart->cart_contents_count,
		'cart_html'  => $output
	);
	echo json_encode( $result );
	exit;
}
add_action( 'wp_ajax_load_mini_cart', 'parlo_wc_render_mini_cart' );
add_action( 'wp_ajax_nopriv_load_mini_cart', 'parlo_wc_render_mini_cart' );

/* Category list Forend */
function parlo_get_product_category_list( $taxonomy = 'product_cat', $limit = 1 ) { 
    $terms = get_the_terms( get_the_ID(), $taxonomy );
    $i = 0;
    if ( is_wp_error( $terms ) )
        return $terms;

    if ( empty( $terms ) )
        return false;

    foreach ( $terms as $term ) {
        $i++;
        $link = get_term_link( $term, $taxonomy );
        if ( is_wp_error( $link ) ) {
            return $link;
        }
        echo '<a href="' . esc_url( $link ) . '">' . $term->name . '</a>';
        if( $i == $limit ){
            break;
        }else{ continue; }
    }
}

if( class_exists('WooCommerce') ){

	function parlo_tooltip_scripts(){
		if( is_shop() ){
			?>
				<script type="text/javascript">
					jQuery(document).ready(function($) {
						//Tool-tips
					    function parlo_tool_tips(element, content) {
					        if (content == 'html') {
					            var tipText = element.html();
					        } else {
					            var tipText = element.attr('title');
					        }
					        element.on('mouseover', function() {
					            if ($('.woolentor-tip').length == 0) {
					                element.before('<span class="woolentor-tip">' + tipText + '</span>');
					                $('.woolentor-tip').css('transition', 'all 0.5s ease 0s');
					                $('.woolentor-tip').css('margin-left', 0);
					            }
					        });
					        element.on('mouseleave', function() {
					            $('.woolentor-tip').remove();
					        });
					    }

					    //Tooltip
					    function parlo_tool_tip(){
					        $('a.woolentor-compare').each(function() {
					            parlo_tool_tips($(this), 'title');
					        });
					        $('.woolentor-cart a.add_to_cart_button').each(function() {
					            parlo_tool_tips($(this), 'html');
					        });
					        $('.woolentor-cart a.added_to_cart').each(function() {
					            parlo_tool_tips($(this), 'html');
					        });
					    }
						parlo_tool_tip();
					});
				</script>
			<?php
		}
	}
	add_action( 'wp_footer', 'parlo_tooltip_scripts' );

    /* Custom product badge */
    function parlo_custom_product_badge( $show = 'yes' ){
        global $product;
        $custom_saleflash_text = get_post_meta( get_the_ID(), '_saleflash_text', true );
        if( $show == 'yes' ){
            if( !empty( $custom_saleflash_text ) && $product->is_in_stock() ){
                if( $product->is_featured() ){
                    echo '<span class="ht-product-label ht-product-label-left hot">' . esc_html( $custom_saleflash_text ) . '</span>';
                }else{
                    echo '<span class="ht-product-label ht-product-label-left">' . esc_html( $custom_saleflash_text ) . '</span>';
                }
            }
        }
    }

    /* Sale flash*/
    function parlo_sale_flash( $offertype = 'default' ){
        global $product;
        if( $product->is_on_sale() && $product->is_in_stock() ){
            if( $offertype !='default' && $product->get_regular_price() > 0 ){
                $_off_percent = (1 - round($product->get_price() / $product->get_regular_price(), 2))*100;
                $_off_price = round($product->get_regular_price() - $product->get_price(), 0);
                $_price_symbol = get_woocommerce_currency_symbol();
                $symbol_pos = get_option('woocommerce_currency_pos', 'left');
                $price_display = '';
                switch( $symbol_pos ){
                    case 'left':
                        $price_display = '-'.$_price_symbol.$_off_price;
                    break;
                    case 'right':
                        $price_display = '-'.$_off_price.$_price_symbol;
                    break;
                    case 'left_space':
                        $price_display = '-'.$_price_symbol.' '.$_off_price;
                    break;
                    default: /* right_space */
                        $price_display = '-'.$_off_price.' '.$_price_symbol;
                    break;
                }
                if( $offertype == 'number' ){
                    echo '<span class="ht-product-label ht-product-label-right">'.$price_display.'</span>';
                }elseif( $offertype == 'percent'){
                    echo '<span class="ht-product-label ht-product-label-right">'.$_off_percent.'%</span>';
                }else{ echo ' '; }

            }else{
                echo '<span class="ht-product-label ht-product-label-right">'.esc_html__( 'Sale!', 'parlo' ).'</span>';
            }
        }
    }
}

// customize pagination
if( !function_exists('parlo_woocommerce_pagination_args') ){
	function parlo_woocommerce_pagination_args( $content ){
		$content['prev_text'] = '<i class="fa fa-angle-left"></i>';
		$content['next_text'] = '<i class="fa fa-angle-right"></i>';
		return $content;
	}
	add_filter('woocommerce_pagination_args', 'parlo_woocommerce_pagination_args');
}

// customize rating html
add_filter( 'woocommerce_product_get_rating_html', 'parlo_wc_get_rating_html', '', 3 );
// Customize rating html
if( !function_exists('parlo_wc_get_rating_html') ){
    function parlo_wc_get_rating_html(){
        global $product;
        $rating_count = $product->get_rating_count();
        $review_count = $product->get_review_count();
        $average      = $product->get_average_rating();
        if ( $rating_count > 0 ) {
            $rating_whole = $average / 5*100;
            $wrapper_class = is_single() ? 'rating-number' : 'top-rated-rating';
            ob_start();
        ?>
        <div class="<?php echo esc_attr( $wrapper_class ); ?> parlo-ratting">
            <span class="ht-product-ratting">
                <span class="ht-product-user-ratting" style="width: <?php echo esc_attr( $rating_whole );?>%;">
                    <i class="sli sli-star"></i>
                    <i class="sli sli-star"></i>
                    <i class="sli sli-star"></i>
                    <i class="sli sli-star"></i>
                    <i class="sli sli-star"></i>
                </span>
                <i class="sli sli-star"></i>
                <i class="sli sli-star"></i>
                <i class="sli sli-star"></i>
                <i class="sli sli-star"></i>
                <i class="sli sli-star"></i>
            </span>
        </div>
        <?php
            $html = ob_get_clean();
        } else { $html  = ''; }
        return $html;
    }
}

// custom wishlist button
function parlo_add_to_wishlist_button() {
    global $product, $yith_wcwl;

    if ( ! class_exists( 'YITH_WCWL' ) || !get_option( 'yith_wcwl_wishlist_page_id' )) return;

    $url          = YITH_WCWL()->get_wishlist_url();
    $product_type = $product->get_type();
    $exists       = $yith_wcwl->is_product_in_wishlist( $product->get_id() );
    $classes      = 'class="add_to_wishlist"';
    $add          = get_option( 'yith_wcwl_add_to_wishlist_text' );
    $browse       = get_option( 'yith_wcwl_browse_wishlist_text' );
    $added        = get_option( 'yith_wcwl_product_added_text' );

    $output = '';
    $output  .= '<div class="pro-same-action pro-wishlist yith-wcwl-add-to-wishlist add-to-wishlist-' . esc_attr( $product->get_id() ) . '">';
        $output .= '<div class="yith-wcwl-add-button';
            $output .= $exists ? ' hide" style="display:none;"' : ' show"';
            $output .= '><a title="'.esc_attr__( 'Add to wishlist', 'parlo' ).'" href="' . esc_url( htmlspecialchars( YITH_WCWL()->get_wishlist_url() ) ) . '" data-product-id="' . esc_attr( $product->get_id() ) . '" data-product-type="' . esc_attr( $product_type ) . '" ' . $classes . ' ><i class="fa fa-heart-o"></i></a>';
            $output .= '<i class="fa fa-spinner fa-pulse ajax-loading" style="visibility:hidden"></i>';
        $output .= '</div>';

        $output .= '<div class="yith-wcwl-wishlistaddedbrowse hide" style="display:none;"><a title="'.esc_attr__( 'Wishlist added', 'parlo' ).'" class="" href="' . esc_url( $url ) . '"><i class="fa fa-heart"></i></a></div>';

        $output .= '<div class="yith-wcwl-wishlistexistsbrowse ' . ( $exists ? 'show' : 'hide' ) . '" style="display:' . ( $exists ? 'block' : 'none' ) . '"><a title="'.esc_attr__( 'View Wishlist', 'parlo' ).'" href="' . esc_url( $url ) . '" class=""><i class="fa fa-heart"></i></a></div>';
    
    $output .= '</div>';
    echo '<div>'.$output.'</div>';
}

// parlo yith compare button
if(class_exists('YITH_Woocompare_Frontend')){
    // add icon to compare button
    add_filter('wpml_translate_single_string', 'parlo_customize_compare_button');
    function parlo_customize_compare_button(){
        return '<i class="fa fa-refresh"></i>';
    }
    class Parlo_YITH_Compare_Extend extends YITH_Woocompare_Frontend{   
        function __construct(){
            add_action( 'woocommerce_after_add_to_cart_button', array( $this, 'parlo_compare_button_sc'), 15 );
        }
        function parlo_compare_button_sc(){
            echo '<div>'.$this->compare_button_sc( $atts = null ).'</div>';
        }
    }
    new Parlo_YITH_Compare_Extend();
}

// clear cart url
function parlo_get_woocommerce_clear_cart_url(){
    return add_query_arg( 'clear-cart', '', get_permalink( wc_get_page_id( 'cart' ) ) );
}

add_action( 'init', 'parlo_woocommerce_clear_cart' );
function parlo_woocommerce_clear_cart() {
    if ( isset( $_GET['clear-cart'] ) ) {
        global $woocommerce;
        $woocommerce->cart->empty_cart();
    }
}

// customize breadcrumb
add_filter('woocommerce_breadcrumb_defaults', 'parlo_woocommerce_breadcrumb_defaults');
function parlo_woocommerce_breadcrumb_defaults( $args ){
    $args['delimiter']   = '';
    $args['wrap_before']   = '<div class="breadcrumb-content"><ul>';
    $args['wrap_after']   = '</ul></div>';
    $args['before']   = '<li>';
    $args['after']   = '</li>';
    return $args;
}
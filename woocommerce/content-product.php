<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

// Ensure visibility.
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}

$columns = 'ht-product ht-product-action-right ht-product-action-on-hover ht-col-xs-12 ht-col-sm-6 ht-col-md-'.round( 12/wc_get_loop_prop( 'columns' ) );

?>

<div <?php wc_product_class( $columns ); ?> >
    <div class="ht-product-inner">

    	<?php
			/**
			 * Hook: woocommerce_before_shop_loop_item.
			 *
			 * @hooked woocommerce_template_loop_product_link_open - 10
			 */
			do_action( 'woocommerce_before_shop_loop_item' );
		?>

        <div class="ht-product-image-wrap">
           <?php
                if( class_exists('WooCommerce') ){ 
                    parlo_custom_product_badge(); 
                    parlo_sale_flash();
                }
            ?>

            <a href="<?php the_permalink();?>" class="ht-product-image"> 
            	<?php
					/**
					 * Hook: woocommerce_before_shop_loop_item_title.
					 *
					 * @hooked woocommerce_show_product_loop_sale_flash - 10
					 * @hooked woocommerce_template_loop_product_thumbnail - 10
					 */
					do_action( 'woocommerce_before_shop_loop_item_title' );
				?>
            </a>

            <div class="ht-product-action">
                <ul>
                    <li>
                        <a href="javascript:void(0);" class="quickview" data-toggle="modal" data-target="#ht-quick-viewmodal" data-quick-id="<?php the_ID();?>" >
                            <i class="sli sli-magnifier"></i>
                            <span class="ht-product-action-tooltip"><?php esc_html_e('Quick View','parlo'); ?></span>
                        </a>
                    </li>
                    <li>
                        <?php
                            if ( class_exists( 'YITH_WCWL' ) && function_exists('woolentor_add_to_wishlist_button')) {
                                echo woolentor_add_to_wishlist_button('<i class="sli sli-heart"></i>','<i class="sli sli-heart"></i>', 'yes');
                            }
                        ?>
                    </li>
                    <li><?php if(function_exists('woolentor_compare_button') ){ woolentor_compare_button(2); } ?></li>
                    <li class="woolentor-cart"><?php woocommerce_template_loop_add_to_cart(); ?></li>
                </ul>
            </div>

        </div>

        <div class="ht-product-content">
            <div class="ht-product-content-inner">
                <div class="ht-product-categories"><?php if( function_exists('parlo_get_product_category_list') ){ parlo_get_product_category_list(); } ?></div>
                <h4 class="ht-product-title"><a href="<?php the_permalink();?>"><?php echo get_the_title();?></a></h4>
                <div class="ht-product-price">
                    <?php woocommerce_template_loop_price(); ?>
                </div>
                <div class="ht-product-ratting-wrap"><?php if( function_exists('woolentor_wc_get_rating_html') ) { echo woolentor_wc_get_rating_html(); } ?></div>
            </div>
        </div>

        <?php
        	/**
			 * Hook: woocommerce_shop_loop_item_title.
			 *
			 * @hooked woocommerce_template_loop_product_title - 10
			 */
			//do_action( 'woocommerce_shop_loop_item_title' );

			/**
			 * Hook: woocommerce_after_shop_loop_item_title.
			 *
			 * @hooked woocommerce_template_loop_rating - 5
			 * @hooked woocommerce_template_loop_price - 10
			 */
			//do_action( 'woocommerce_after_shop_loop_item_title' );

			/**
			 * Hook: woocommerce_after_shop_loop_item.
			 *
			 * @hooked woocommerce_template_loop_product_link_close - 5
			 * @hooked woocommerce_template_loop_add_to_cart - 10
			 */
			do_action( 'woocommerce_after_shop_loop_item' );
        ?>

    </div>
</div>

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

?>
<div <?php wc_product_class('ht-col-xs-12'); ?> >
    <div class="shop-list-wrap">
        <div class="ht-row">
            <div class="ht-col-md-4 ht-col-xs-12">
                <div class="product-list-img">
                    <?php
                        if( class_exists('WooCommerce') ){ 
                            parlo_custom_product_badge(); 
                            parlo_sale_flash();
                        }
                    ?>
                    <a href="<?php the_permalink();?>"> 
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
                    <div class="product-quickview">
                        <a href="javascript:void(0);" class="quickview" data-toggle="modal" data-target="#ht-quick-viewmodal" data-quick-id="<?php the_ID();?>" >
                            <i class="sli sli-magnifier-add"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="ht-col-md-8 ht-col-xs-12">
                <div class="shop-list-content">
                    <h3><a href="<?php the_permalink();?>"><?php echo get_the_title();?></a></h3>
                    <?php  woocommerce_template_single_excerpt(); ?>
                    <?php
                        if( function_exists('parlo_get_product_category_list') ){
                            echo '<div class="parlo-category">';
                                parlo_get_product_category_list();
                            echo '</div>';
                        }
                    ?>
                    <div class="shop-list-price-action-wrap">
                        <div class="shop-list-price-ratting">
                            <div class="ht-product-list-price">
                                <?php woocommerce_template_loop_price(); ?>
                            </div>
                            <div class="ht-product-list-ratting">
                                <div class="ht-product-ratting-wrap">
                                    <?php if( function_exists('woolentor_wc_get_rating_html') ) { echo woolentor_wc_get_rating_html(); } ?>
                                </div>
                            </div>
                        </div>
                        <div class="ht-product-list-action">
                            <ul>
                                <li>
                                    <?php
                                        if ( class_exists( 'YITH_WCWL' ) && function_exists('woolentor_add_to_wishlist_button')) {
                                            echo woolentor_add_to_wishlist_button('<i class="sli sli-heart"></i>','<i class="sli sli-heart"></i>', 'no');
                                        }
                                    ?>
                                </li>
                                <li class="cart-list"><?php woocommerce_template_loop_add_to_cart(); ?></li>
                                <li><?php if(function_exists('woolentor_compare_button') ){ woolentor_compare_button(1); } ?></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
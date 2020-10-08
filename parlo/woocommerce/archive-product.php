<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );

// Layout
$sidebar = parlo_get_option( 'parlo_shop_layout', 'shoplayout', 'full' );

switch ( htmlspecialchars( $sidebar ) ) {
	case 'left':
		if( !is_active_sidebar( 'sidebar-2' ) ){
			$product_wrapper_class = 'ht-col-md-12 ht-col-xs-12';
		}else{ $product_wrapper_class = 'ht-col-md-9 ht-col-xs-12'; }
		break;

	case 'right':
		if( !is_active_sidebar( 'sidebar-2' ) ){
			$product_wrapper_class = 'ht-col-md-12 ht-col-xs-12';
		}else{ $product_wrapper_class = 'ht-col-md-9 ht-col-xs-12'; }
		break;

	default:
		$product_wrapper_class = 'ht-col-md-12 ht-col-xs-12';
		break;
}

/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */
do_action( 'woocommerce_before_main_content' );

?>
<div class="ht-col-md-12 ht-col-xs-12">
	<?php
		/**
		 * Hook: woocommerce_archive_description.
		 *
		 * @hooked woocommerce_taxonomy_archive_description - 10
		 * @hooked woocommerce_product_archive_description - 10
		 */
		do_action( 'woocommerce_archive_description' );
	?>
</div>

<?php if( $sidebar == 'left' && is_active_sidebar( 'sidebar-2' ) ): ?>
	<div class="ht-col-md-3 ht-col-xs-12">
		<?php
			/**
			 * Hook: woocommerce_sidebar.
			 *
			 * @hooked woocommerce_get_sidebar - 10
			 */
			do_action( 'woocommerce_sidebar' );
		?>
	</div>
<?php endif; ?>

<div class="<?php echo esc_attr( $product_wrapper_class ); ?>">
	<?php
		if ( woocommerce_product_loop() ) {

			/**
			 * Hook: woocommerce_before_shop_loop.
			 *
			 * @hooked woocommerce_output_all_notices - 10
			 * @hooked woocommerce_result_count - 20
			 * @hooked woocommerce_catalog_ordering - 30
			 */
			do_action( 'woocommerce_before_shop_loop' );

			if( is_shop() ):?>
				<div class="parlo-cus-tab-pane cusactive" id="grid">
				<?php endif;

					woocommerce_product_loop_start();
					if ( wc_get_loop_prop( 'total' ) ) {
						while ( have_posts() ) {
							the_post();

							/**
							 * Hook: woocommerce_shop_loop.
							 *
							 * @hooked WC_Structured_Data::generate_product_data() - 10
							 */
							do_action( 'woocommerce_shop_loop' );

							wc_get_template_part( 'content', 'product' );
						}
					}
					woocommerce_product_loop_end();

				if( is_shop() ):?>
					</div>
				<?php endif;

				if( is_shop() ):?>
					<div class="parlo-cus-tab-pane" id="list">
						<?php
							woocommerce_product_loop_start();
							if ( wc_get_loop_prop( 'total' ) ) {
								while ( have_posts() ) {
									the_post();

									/**
									 * Hook: woocommerce_shop_loop.
									 *
									 * @hooked WC_Structured_Data::generate_product_data() - 10
									 */
									do_action( 'woocommerce_shop_loop' );

									//wc_get_template_part( 'content', 'product' );
									wc_get_template_part( 'content', 'product-list' );
								}
							}
							woocommerce_product_loop_end();
						?>
					</div>
				<?php endif;

			/**
			 * Hook: woocommerce_after_shop_loop.
			 *
			 * @hooked woocommerce_pagination - 10
			 */
			do_action( 'woocommerce_after_shop_loop' );
		} else {
			/**
			 * Hook: woocommerce_no_products_found.
			 *
			 * @hooked wc_no_products_found - 10
			 */
			do_action( 'woocommerce_no_products_found' );
		}
	?>
</div>

<?php if( $sidebar == 'right' && is_active_sidebar( 'sidebar-2' ) ): ?>
	<div class="ht-col-md-3 ht-col-xs-12">
		<?php
			/**
			 * Hook: woocommerce_sidebar.
			 *
			 * @hooked woocommerce_get_sidebar - 10
			 */
			do_action( 'woocommerce_sidebar' );
		?>
	</div>
<?php endif; ?>

<?php

/**
 * Hook: woocommerce_after_main_content.
 *
 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
 */
do_action( 'woocommerce_after_main_content' );

get_footer( 'shop' );

<?php
/**
 * The Template for displaying all single products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header( 'shop' ); 

// Layout
$sidebar = parlo_get_option( 'parlo_shopdetails_layout', 'prodetaillayout', 'full' );
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

?>

	<?php
		/**
		 * woocommerce_before_main_content hook.
		 *
		 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
		 * @hooked woocommerce_breadcrumb - 20
		 */
		do_action( 'woocommerce_before_main_content' );
	?>

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
			<?php while ( have_posts() ) : the_post(); ?>

				<?php wc_get_template_part( 'content', 'single-product' ); ?>

			<?php endwhile; // end of the loop. ?>
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
		 * woocommerce_after_main_content hook.
		 *
		 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 */
		do_action( 'woocommerce_after_main_content' );
	?>

<?php get_footer( 'shop' );

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */

<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Parlo
 */

get_header();

if( function_exists('parloSetPostViews') ){ parloSetPostViews( get_the_ID() ); }

//Layout
$blogdetailslayout = parlo_get_option( 'parlo_blogdetails_layout', 'blogdetailslayout', 'right' );
switch ( htmlspecialchars( $blogdetailslayout ) ) {
	case 'left':
		if( !is_active_sidebar( 'sidebar-1' ) ){
			$blog_wrapper_class = 'ht-col-md-12 ht-col-xs-12';
		}else{ $blog_wrapper_class = 'ht-col-md-9 ht-col-xs-12'; }
		break;

	case 'right':
		if( !is_active_sidebar( 'sidebar-1' ) ){
			$blog_wrapper_class = 'ht-col-md-12 ht-col-xs-12';
		}else{ $blog_wrapper_class = 'ht-col-md-9 ht-col-xs-12'; }
		break;

	default:
		$blog_wrapper_class = 'ht-col-md-12 ht-col-xs-12';
		break;
}

?>

	<div id="primary" class="content-area parlopage-padding">
		<main id="main" class="site-main">

			<div class="ht-container">
				<div class="ht-row">

					<?php if( $blogdetailslayout == 'left' && is_active_sidebar( 'sidebar-1' ) ): ?>
						<div class="ht-col-md-3 ht-col-xs-12">
							<?php get_sidebar();?>
						</div>
					<?php endif; ?>
					
					<div class="<?php echo esc_attr( $blog_wrapper_class ); ?>">
						<div class="ht-row">
							<?php
								while ( have_posts() ) :
									the_post();

									get_template_part( 'template-parts/content', 'single' );

									// If comments are open or we have at least one comment, load up the comment template.
									if ( comments_open() || get_comments_number() ) :
										comments_template();
									endif;

								endwhile; // End of the loop.
							?>
						</div>
					</div>
					
					<?php if( $blogdetailslayout == 'right' && is_active_sidebar( 'sidebar-1' ) ): ?>
						<div class="ht-col-md-3 ht-col-xs-12">
							<?php get_sidebar();?>
						</div>
					<?php endif; ?>

				</div>
			</div>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();

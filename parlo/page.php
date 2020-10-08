<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Parlo
 */

get_header();
?>

	<div id="primary" class="content-area parlopage-padding">
		<main id="main" class="site-main">

			<?php if( did_action( 'elementor/loaded' ) && !\Elementor\Plugin::$instance->db->is_built_with_elementor( get_the_ID() ) ): ?>
			<div class="ht-container">
				<div class="ht-row">
					<div class="ht-col-xs-12">
					<?php endif;?>

						<?php
							while ( have_posts() ) :
								the_post();
								
								if( \Elementor\Plugin::$instance->db->is_built_with_elementor( get_the_ID() ) ){
									the_content();
								}else{
									get_template_part( 'template-parts/content', 'page' );
								}

								// If comments are open or we have at least one comment, load up the comment template.
								if ( comments_open() || get_comments_number() ) :
									comments_template();
								endif;

							endwhile; // End of the loop.
						?>

						<?php if( did_action( 'elementor/loaded' ) && !\Elementor\Plugin::$instance->db->is_built_with_elementor( get_the_ID() ) ): ?>
					</div>
				</div>
			</div>
		<?php endif;?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();

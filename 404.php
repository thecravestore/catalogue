<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Parlo
 */

get_header();
?>

	<div id="primary" class="content-area htpage-padding page-not-found-wrap">
		<main id="main" class="site-main">

			<div class="ht-container">
				<div class="ht-row">
					
					<div class="ht-col-md-12 ht-col-xs-12">
						<div class="pnf-inner-wrap">
			                <div class="pnf-inner">

			                	<h1><?php echo esc_html('404','parlo'); ?></h1>
			                   	<h2><?php echo esc_html('PAGE NOT FOUND','parlo'); ?></h2>
			                   	<p><?php echo esc_html('The page you are looking for does not exist or has been moved.'); ?> </p>
			                    <a href="<?php echo esc_url( home_url('/') ); ?>" class="btn">
			                    	<?php
				                    	echo esc_html('Go back to Home Page' , 'parlo');
			                    	?>
			                    </a>

			                </div>
		                </div>
					</div>

				</div>
			</div>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();

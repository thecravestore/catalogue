<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Parlo
 */

// Customizer value
$footer_copyright_text = get_theme_mod('parlo_footer_copyright_text', 'Copyright &copy; '.date('Y').' parlo All Right Reserved.' );
$payment_icon_image = get_theme_mod( 'parlo_payment_icon_image', get_template_directory_uri().'/assets/img/payment_icon_1.png' );

$social_media_list = array();
$social_media_list = [
	array(
		'title' => get_option('parlo_social_facebook','Facebook'),
		'url' => get_option('parlo_social_facebook_url','facebook.com')
	),
	array(
		'title' => get_option('parlo_social_twitter','Twitter'),
		'url' => get_option('parlo_social_twitter_url','twitter.com')
	),
	array(
		'title' => get_option('parlo_social_linkedin','Linkedin'),
		'url' => get_option('parlo_social_linkedin_url','linkedin.com')
	),
	array(
		'title' => get_option('parlo_social_instragram','Instragram'),
		'url' => get_option('parlo_social_instragram_url','instragram.com')
	)
];

$footer_layout = parlo_get_option( 'parlo_footer_layout', 'footerlayout', '1' );

?>

	</div><!-- #content -->

	<footer id="colophon" class="<?php echo apply_filters( 'parlo_footer_class', 'site-footer' ); ?>">

		<div class="footer-widgets-area">
			<div class="ht-container">
				<div class="ht-row">

					<?php if( $footer_layout == '2' ): ?>
						<div class="ht-col-xs-12">
							<div class="footer-menu-area">
								<?php
									wp_nav_menu( array(
										'theme_location'	=> 'footermenu',
										'container'     	=> false,
										'menu_id'       	=> 'primary-menu',
										'fallback_cb'    	=> 'parlo_Nav_Walker::fallback'
									) );
								?>
							</div>
						</div>

					<?php else:?>
						<?php
							$footer_widget_column = 4;
							for( $i = 1; $i<=$footer_widget_column; $i++ ):
								if ( is_active_sidebar('parlo-footer-' . $i ) ) :
						?>
						<div class="ht-col-xs-12 ht-col-sm-6 ht-col-md-<?php if( $i == 1 ){ echo '5'; }elseif( $i == 4 ){ echo '3'; }else{ echo '2';}?>">
							<?php dynamic_sidebar('parlo-footer-' . $i); ?>
						</div>
						<?php endif; endfor; endif;?>

				</div>
			</div>
		</div>

		<div class="footer-copyright-area">
			<div class="ht-container">
				<div class="ht-row ht-middle-md">

					<?php if( $footer_layout == '2' ): ?>
						<div class="ht-col-md-4 ht-col-sm-6 ht-col-xs-12 ht-d-flex ht-center-xs">
							<div class="footer-social-media">
								<ul>
									<?php
										foreach ( $social_media_list as $socialmedia ) {
											echo '<li><a href="'.esc_url( $socialmedia['url'] ).'">'.$socialmedia['title'].'</a></li>';
										}
									?>
								</ul>
							</div>
						</div>
						<div class="ht-col-md-4 ht-col-sm-6 ht-d-flex ht-center-md ht-end-sm ht-center-xs ht-col-xs-12">
							<div class="copyright-txt">
								<?php echo esc_html( $footer_copyright_text ); ?>
							</div><!-- .site-info -->
						</div>
						<div class="ht-col-md-4 ht-d-flex ht-end-md ht-center-sm ht-col-sm-12 ht-center-xs ht-col-xs-12">
							<div class="payment-icon">
								<?php 
									echo '<img src="'.esc_url( $payment_icon_image ).'" alt="'.get_bloginfo( 'name' ).'">';
								?>
							</div>
						</div>
					<?php else:?>
						<div class="ht-col-md-6 ht-col-xs-12 ht-center-xs">
							<div class="copyright-txt">
								<?php echo esc_html( $footer_copyright_text ); ?>
							</div><!-- .site-info -->
						</div>
						<div class="ht-col-md-6 ht-col-xs-12 ht-end-md ht-center-xs">
							<div class="payment-icon">
								<?php 
									echo '<img src="'.esc_url( $payment_icon_image ).'" alt="'.get_bloginfo( 'name' ).'">';
								?>
							</div>
						</div>
					<?php endif;?>

				</div>
			</div>
		</div>


	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>

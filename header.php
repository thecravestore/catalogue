<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Parlo
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'parlo' ); ?></a>

	<header id="masthead" class="site-header">
		<div class="main-header-wrap">
			<div class="ht-container">
				<div class="ht-row ht-middle-md">

					<div class="ht-col-md-2">
						<div class="site-branding">
							<?php
								$hastech_description = get_bloginfo( 'description', 'display' );
								if( has_custom_logo() ){
									the_custom_logo();
								}else{
									echo '<h2 class="site-title"><a href="'.esc_url( home_url( '/' ) ).'">'.get_bloginfo( 'name' ).'</a></h2>';
									if ( $hastech_description || is_customize_preview() ){
										echo '<p class="site-description">'.$hastech_description.'</p>';
									}
								}
							?>
						</div><!-- .site-branding -->
					</div>

					<div class="ht-col-md-7 ht-center-xs">
						<div class="main-menu-area">
							<nav id="site-navigation" class="main-navigation">
								<?php
									wp_nav_menu( array(
										'theme_location'=> 'mainmenu',
										'container'     => false,
										'menu_id'       => 'primary-menu',
										'fallback_cb'   => 'parlo_Nav_Walker::fallback',
										'walker'		=> class_exists('parlo_Nav_Walker') ? new parlo_Nav_Walker():''
									) );
								?>
							</nav><!-- #site-navigation -->
						</div>
					</div>

					<div class="ht-col-md-3 ht-d-flex ht-end-sm">
						<div class="header-right-content">
							<ul>
								<li>
									<a href="#" class="search-toggle"><i class="sli sli-magnifier"></i></a>
								</li>
								<?php if ( class_exists('WooCommerce') && function_exists('parlo_wc_shopping_cart') ){ echo '<li class="mini-cart parlo-dropdown">'.parlo_wc_shopping_cart().'</li>'; } ?>
								<?php if ( is_active_sidebar( 'header-quickmenu' ) ): ?>
									<li class="parlo-dropdown">
										<a class="parlo-dropdown-toggle" href="#"><i class="sli sli-settings"></i></a>
										<div class="header-quick-menu parlo-dropdown-menu">
											<?php dynamic_sidebar( 'header-quickmenu' ); ?>
											<span class="parlo-dropdown-close"><i class="sli sli-close"></i></span>
										</div>
									</li>
								<?php endif; ?>
							</ul>
						</div>

					</div>

				</div>
			</div>
		</div>

        <!-- main-search start -->
		<div class="main-search-active">
		    <div class="sidebar-search-icon">
		        <button class="search-close"><span class="sli sli-close"></span></button>
		    </div>
		    <div class="sidebar-search-input">
		        <form id="search" action="<?php echo esc_url(home_url( '/' )); ?>" method="GET">
		            <div class="form-search">
		                <input type="text" name="s" class="input-text" placeholder="<?php echo esc_attr_x( 'Search product Here', 'placeholder', 'parlo' ); ?>" />
		                <input type="hidden" name="post_type" value="product" />
		                <button><i class="sli sli-magnifier"></i></button>
		            </div>
		        </form>
		    </div>
		</div>
		<!-- main-search start -->

		<div class="header-small-mobile">
            <div class="ht-container">
                <div class="ht-row">
                    <div class="ht-col-md-6 ht-col-xs-6">
                        <div class="mobile-logo">
                            <?php
								if( has_custom_logo() ){
									the_custom_logo();
								}else{
									echo '<h2 class="site-title"><a href="'.esc_url( home_url( '/' ) ).'">'.get_bloginfo( 'name' ).'</a></h2>';
								}
							?>
                        </div>
                    </div>
                    <div class="ht-col-md-6 ht-col-xs-6 ht-d-flex ht-end-xs">
                        <div class="header-right-wrap">
                        	<div class="header-right-content">
								<ul>
									<?php if ( class_exists('WooCommerce') && function_exists('parlo_wc_shopping_cart') ){ echo '<li class="mini-cart parlo-dropdown">'.parlo_wc_shopping_cart().'</li>'; } ?>
									<li class="mobile-menu-li"><a id="mobile-menu-trigger" class="mobile-menu-icon" href="javascript:void(0)"><i class="sli sli-menu"></i></a></li>
								</ul>
							</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--=======  offcanvas mobile menu  =======-->
	    <div class="offcanvas-mobile-menu" id="offcanvas-mobile-menu">
	        <a href="javascript:void(0)" class="offcanvas-menu-close" id="offcanvas-menu-close-trigger">
	            <i class="sli sli-close"></i>
	        </a>

	        <div class="offcanvas-wrapper">
	            <div class="offcanvas-inner-content">
	                <div class="offcanvas-mobile-search-area">
	                    <form action="<?php echo esc_url(home_url( '/' )); ?>">
	                        <input type="text" name="s" placeholder="Search..." value="<?php echo get_search_query(); ?>">
	                        <input type="hidden" name="post_type" value="product" />
	                        <button type="submit"><i class="fa fa-search"></i></button>
	                    </form>
	                </div>
	                <nav class="offcanvas-navigation">
	                    <?php
							wp_nav_menu( array(
								'theme_location'	=> 'mainmenu',
								'container'     	=> false,
								'menu_id'       	=> 'primary-menu',
							) );
						?>
	                </nav>
	            </div>
	        </div>
	    </div>
	    <!--=======  End of offcanvas mobile menu  =======-->

	</header><!-- #masthead -->

	<div id="content" class="site-content">
		<?php get_template_part('/template-parts/page-title'); ?>
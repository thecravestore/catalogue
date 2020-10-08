<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Parlo
 */

?>

<div class="ht-col-md-12 ht-col-xs-12">
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	    <div class="blog-details-area">
	    	<?php if( has_post_thumbnail() ): ?>
		        <div class="thumb">
		            <?php parlo_post_thumbnail(); ?>
		        </div>
		    <?php endif; ?>
	        <div class="blog-content">
	            <?php the_title( '<h3 class="entry-title">', '</h3>' ); ?>
	            <ul class="mata-info">
	                <li><?php echo get_the_time( get_option('date_format') ); ?></li>
	                <?php 
	                    if( function_exists('parloGetPostViews') ){
	                        if( parloGetPostViews( get_the_ID() ) > 1 ){
	                            echo '<li><a href="#">'.parloGetPostViews( get_the_ID() ).esc_html__(' Views','parlo').'</a></li>'; 
	                        }else{
	                            echo '<li><a href="#">'.parloGetPostViews( get_the_ID() ).esc_html__(' View','parlo').'</a></li>'; 
	                        }
	                    } 
	                ?>
	                <?php
	                    if( function_exists( 'parlo_getPostLikeLink' ) ){
	                        echo '<li>'.parlo_getPostLikeLink( get_the_ID() ).'</li>';
	                    }
	                ?>
	            </ul>
	            <div class="entry-content">
					<?php
					the_content( sprintf(
						wp_kses(
							/* translators: %s: Name of current post. Only visible to screen readers */
							__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'parlo' ),
							array(
								'span' => array(
									'class' => array(),
								),
							)
						),
						get_the_title()
					) );

					wp_link_pages( array(
						'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'parlo' ),
						'after'  => '</div>',
					) );
					?>
				</div><!-- .entry-content -->

				<div class="entry-footer">
					<div class="tag-share">					
						<?php 
							if( has_tag( ) ){ parlo_posted_in_tags(); }
		                    if( function_exists('parlo_get_social_share_html') ){
		                    	echo parlo_get_social_share_html( get_the_ID() );
		                    }
	                    ?>
	                </div>
	                <?php
	                	$prev_post = get_previous_post();
            			$next_post = get_next_post();
	                if ( !empty( $prev_post ) || !empty( $next_post ) ): ?>
	                    <div class="next-previous-post">
	                    	<?php
	                    		if( !empty( $prev_post ) ){
	                    			echo '<a href="'.esc_url( get_permalink( $prev_post->ID ) ).'"><i class="sli sli-arrow-left"></i>'.esc_html__('Prev Post', 'parlo' ).'</a>';
	                    		}

	                    		if( !empty( $next_post ) ){
	                    			echo '<a href="'.esc_url( get_permalink( $next_post->ID ) ).'">'.esc_html__('Next Post', 'parlo' ).'<i class="sli sli-arrow-right"></i></a>';
	                    		}
				            ?>
	                    </div>
	                <?php endif; ?>
                </div>

	        </div>
	    </div>
	</article><!-- #post-<?php //the_ID(); ?> -->
</div>

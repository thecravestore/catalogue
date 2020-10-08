<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Parlo
 */

$collumval = 'ht-col-md-6 blog-style-'.parlo_get_option( 'parlo_blog_style', 'bloglayout', '1' );
$columns = (int)parlo_get_option( 'parlo_blog_column', 'blogcolumn', '2' );
$titlelen = (int)parlo_get_option( 'parlo_blog_title_len', 'blogtitlelen', '5' );
$contentlen = (int)parlo_get_option( 'parlo_blog_content_len', 'blogcontentlen', '19' );
if( $columns != '' ){
    $colwidth = round( 12/$columns );
    $collumval = 'ht-col-md-'.$colwidth.' blog-style-'.parlo_get_option( 'parlo_blog_style', 'bloglayout', '1' );
}

?>

<div class="<?php echo esc_attr( $collumval ); ?>">
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	    <div class="single-blog">
	        <div class="thumb">
	            <a href="<?php the_permalink(); ?>">
	                <?php the_post_thumbnail( 'parlo_size_550x350' ); ?>
	            </a>
	        </div>
	        <div class="blog-content">
	        	<?php if( parlo_get_option( 'parlo_blogtitle_status', 'blogtitle', 'on' ) == 'on' ): ?>
		            <h2><a href="<?php the_permalink(); ?>"><?php echo wp_trim_words( get_the_title(), $titlelen, ' ' ); ?></a></h2>
		        <?php endif; ?>
		        <?php if( parlo_get_option( 'parlo_blogmeta_status', 'blogmeta', 'on' ) == 'on' ): ?>
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
		        <?php endif; ?>
	            <div class="entry-content">
					<?php
						if( parlo_get_option( 'parlo_blogcontent_status', 'blogcontent', 'on' ) == 'on' ){
							parlo_post_excerpt( $contentlen );
							wp_link_pages( array(
								'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'parlo' ),
								'after'  => '</div>',
							) );
						}
					?>
				</div><!-- .entry-content -->

	        </div>
	    </div>
	</article><!-- #post-<?php //the_ID(); ?> -->
</div>
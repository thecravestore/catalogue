<?php
/**
 * Themes Helpers Functions
 *
 * @package Parlo
 */

/**
 * Get theme option value
 */
function parlo_get_option( $opt_name = '', $qstkey = '', $default = '' ){
    // check query string
    if( isset( $_REQUEST[$qstkey] ) ){
        return sanitize_text_field( $_REQUEST[$qstkey] );

    // check customizer option
    } elseif( !empty( get_theme_mod($opt_name) ) ){
        return get_theme_mod( $opt_name );
    } elseif( !empty( get_option( $opt_name ) ) ){
        return get_option( $opt_name );
    }else {
        return $default;
    }
}


/**
 * Add this to any template file by calling parlo_breadcrumbs()
 */
if( !function_exists('parlo_breadcrumbs') ){

     function parlo_breadcrumbs() {

        /* === Options === */
        $text['home'] = esc_html__('Home', 'parlo');
        $text['blog'] = esc_html__('Blog', 'parlo');
        $text['category'] = esc_html__('Archive "%s"', 'parlo');
        $text['search'] = esc_html__('Search results for "%s"', 'parlo');
        $text['tag'] = esc_html__('Posts with tag "%s"', 'parlo');
        $text['author'] = esc_html__('%s posts', 'parlo');
        $text['404'] = esc_html__('Error 404', 'parlo');
        $text['page'] = esc_html__('Page %s', 'parlo');
        $text['cpage'] = esc_html__('Comments page %s', 'parlo');
        
        $delimiter = '&nbsp;&nbsp;|&nbsp;&nbsp;';
        $delim_before = '';
        $delim_after = '';
        $show_home_link = 1;
        $show_on_home = 0;
        $show_title = 1;
        $show_current = 1;
        $before = '<li>';
        $after = '</li>';
        /* === End options === */
        
        global $post;
        $home_link = esc_url(home_url('/'));
        $link_before = '<li>';
        $link_after = '</li>';
        $link_attr = '';
        $link_in_before = '';
        $link_in_after = '';
        $link = $link_before . '<a href="%1$s"' . $link_attr . '>' . $link_in_before . '%2$s' . $link_in_after . '</a>' . $link_after;
        $frontpage_id = get_option('page_on_front');
        $parent_id = isset($post) ? $post->post_parent : '';
        $delimiter = '';
        
        if ( is_front_page() ) {

            if ( $show_on_home == 1 ) echo '<div class="breadcrumb-content">' . esc_html( $text['home']
             ) . '</div>';

        } elseif( is_home() && !is_front_page() ) {
            echo '<div class="breadcrumb-content"><ul><li>'. $text['home'] .'</li><li>'. $text['blog'] .'</li></ul></div>';
        } else {

            echo '<div class="breadcrumb-content"><ul>';
            if ($show_home_link == 1) echo sprintf($link, $home_link, $text['home']);

            if ( is_category() ) {
                 $cat = get_category(get_query_var('cat'), false);
                 if ($cat->parent != 0) {
                     $cats = get_category_parents($cat->parent, TRUE, $delimiter);
                     $cats = preg_replace("#^(.+)$delimiter$#", "$1", $cats);
                     $cats = preg_replace('#<a([^>]+)>([^<]+)<\/a>#', $link_before . '<a$1' . $link_attr .'>' . $link_in_before . '$2' . $link_in_after .'</a>' . $link_after, $cats);
                     if ($show_title == 0)
                         $cats = preg_replace('/ title="(.*?)"/', '', $cats);
                     if ($show_home_link == 1) echo wp_kses_post($delimiter);
                         echo wp_kses_post($cats);
                 }
                 if ( get_query_var('paged') ) {
                     $cat = $cat->cat_ID;
                     echo wp_kses_post($delimiter . sprintf($link,esc_url( get_category_link($cat) ), get_cat_name($cat)) . $delimiter . $before . sprintf($text['page'], get_query_var('paged')) . $after);
                 } else {
                     if ($show_current == 1) echo wp_kses_post($delimiter . $before . sprintf($text['category'], single_cat_title('', false)) . $after);
                 }

             } elseif ( is_search() ) {
                 if ($show_home_link == 1) echo wp_kses_post($delimiter);
                 echo wp_kses_post($before . sprintf($text['search'], get_search_query()) . $after);

             } elseif ( is_day() ) {
                 if ($show_home_link == 1) echo wp_kses_post($delimiter);
                 echo sprintf($link, esc_url(get_year_link(get_the_time('Y'))), get_the_time('Y')) . $delimiter;
                 echo sprintf($link, esc_url(get_month_link(get_the_time('Y')), get_the_time('m')), get_the_time('F')) . $delimiter;
                 echo wp_kses_post($before . get_the_time('d') . $after);

             } elseif ( is_month() ) {
                 if ($show_home_link == 1) echo wp_kses_post($delimiter);
                 echo sprintf($link, esc_url(get_year_link(get_the_time('Y'))), get_the_time('Y')) . $delimiter;
                 echo wp_kses_post($before . get_the_time('F') . $after);

             } elseif ( is_year() ) {
                 if ($show_home_link == 1) echo wp_kses_post($delimiter);
                 echo wp_kses_post($before . get_the_time('Y') . $after);

             } elseif ( is_single() && !is_attachment() ) {
                 if ($show_home_link == 1) echo wp_kses_post($delimiter);
                 if ( get_post_type() == 'product'  ) {
                     $cats = wp_get_object_terms($post->ID, 'product_category');
                     if ($cats){
                         $cat_href = '';
                         foreach( $cats as $cat ){
                             $cat_href .= '<a href="'.esc_url(get_term_link( $cat )).'"' . $link_attr . '>' . $link_in_before . $cat->name . $link_in_after . '</a>' . ", ";
                         }
                     }
                     echo wp_kses_post($cat_href != '' ? $link_before . substr($cat_href, 0, -2) . $link_after : '');
                     if ($show_current == 1) echo wp_kses_post($delimiter . $before . get_the_title() . $after);
                 } else {
                     $cat = get_the_category();
                     if(!empty($cat)) {
                        $cat = $cat[0];
                        $cats = get_category_parents($cat, TRUE, $delimiter);
                        if ($show_current == 0 || get_query_var('cpage')) $cats = preg_replace("#^(.+)$delimiter$#", "$1", $cats);
                        $cats = preg_replace('#<a([^>]+)>([^<]+)<\/a>#', $link_before . '<a$1' . $link_attr . '>' . $link_in_before . '$2' . $link_in_after . '</a>' . $link_after, $cats);
                        if ($show_title == 0) $cats = preg_replace('/ title="(.*?)"/', '', $cats);
                        echo wp_kses_post($cats);
                    } else {
                        echo esc_html__('No Categories', 'parlo');
                    }
                     if ( get_query_var('cpage') ) {
                         echo wp_kses_post($delimiter . sprintf($link, esc_url(get_permalink()), get_the_title()) . $delimiter . $before . sprintf($text['cpage'], get_query_var('cpage')) . $after);
                     } else {
                         if ($show_current == 1) echo wp_kses_post($before . get_the_title() . $after);
                     }
                 }

             // custom post type
             } elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
                 $post_type = get_post_type_object(get_post_type());
                 $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
                 if ( get_query_var('paged') ) {
                     echo wp_kses_post($delimiter . sprintf($link, esc_url(get_post_type_archive_link($post_type->name)), $post_type->label) . $delimiter . $before . sprintf($text['page'], get_query_var('paged')) . $after);
                 } else {
                     if ($show_current == 1 && is_object($term))
                         echo wp_kses_post($delimiter . $before . $term->name . $after);
                     else
                         echo wp_kses_post($delimiter . $before . $post_type->name . $after);
                 }

             } elseif ( is_attachment() ) {
                 if ($show_home_link == 1) echo wp_kses_post($delimiter);
                 $parent = get_post($parent_id);
                 $cat = get_the_category($parent->ID); $cat = $cat[0];
                 if ($cat) {
                     $cats = get_category_parents($cat, TRUE, $delimiter);
                     $cats = preg_replace('#<a([^>]+)>([^<]+)<\/a>#', $link_before . '<a$1' . $link_attr .'>' . $link_in_before . '$2' . $link_in_after .'</a>' . $link_after, $cats);
                     if ($show_title == 0) $cats = preg_replace('/ title="(.*?)"/', '', $cats);
                     echo wp_kses_post($cats);
                 }
                 printf($link, esc_url(get_permalink($parent)), $parent->post_title);
                 if ($show_current == 1) echo wp_kses_post($delimiter . $before . get_the_title() . $after);

             } elseif ( is_page() && !$parent_id ) {

                 if ($show_current == 1) echo wp_kses_post($delimiter . $before . get_the_title() . $after);

             } elseif ( is_page() && $parent_id ) {

                 if ($show_home_link == 1) echo wp_kses_post($delimiter);
                 if ($parent_id != $frontpage_id) {
                     $breadcrumbs = array();
                     while ($parent_id) {
                         $page = get_post($parent_id);
                         if ($parent_id != $frontpage_id) {
                             $breadcrumbs[] = sprintf($link, esc_url(get_permalink($page->ID)), get_the_title($page->ID));
                         }
                         $parent_id = $page->post_parent;
                     }
                     $breadcrumbs = array_reverse($breadcrumbs);
                     for ($i = 0; $i < count($breadcrumbs); $i++) {
                         echo wp_kses_post($breadcrumbs[$i]);
                         if ($i != count($breadcrumbs)-1) echo wp_kses_post($delimiter);
                     }
                 }
                 if ($show_current == 1) echo wp_kses_post($delimiter . $before . get_the_title() . $after);

             } elseif ( is_tag() ) {
                 if ($show_current == 1) echo wp_kses_post($delimiter . $before . sprintf($text['tag'], single_tag_title('', false)) . $after);

             } elseif ( is_author() ) {
                 if ($show_home_link == 1) echo wp_kses_post($delimiter);
                 global $author;
                 $author = get_userdata($author);
                 echo wp_kses_post($before . sprintf($text['author'], $author->display_name) . $after);

             } elseif ( is_404() ) {
                 if ($show_home_link == 1) echo wp_kses_post($delimiter);
                 echo wp_kses_post($before . $text['404'] . $after);

             } elseif ( has_post_format() && !is_singular() ) {
                 if ($show_home_link == 1) echo wp_kses_post($delimiter);
                 echo get_post_format_string( get_post_format() );
             }

            echo '</ul></div>';

        }
        
     } // end parlo_breadcrumbs()
}

/**
* Register Post Excerpt Function
*/
function parlo_post_excerpt( $length = 19 ) {
    if( has_excerpt() ){
        the_excerpt();
    } elseif ( isset ( $length ) ) {
        echo wp_kses_post( wpautop( wp_trim_words( get_the_content(), $length, '' ) ) );
    } else {
        echo wp_kses_post( wpautop( wp_trim_words( get_the_content(), 19, '' ) ) );
    }
}
<?php 
/**
 * The template for displaying Search form.
 *
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package parlo
 */

?>

<form class="pro-sidebar-search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>" method="GET">
    <input type="search" name="s" placeholder="<?php echo esc_attr_x( 'Search Here', 'placeholder', 'parlo' ); ?>">
    <button><i class="sli sli-magnifier"></i></button>
</form>
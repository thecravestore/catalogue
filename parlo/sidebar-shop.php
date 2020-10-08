<?php
/**
 * The sidebar containing the shop page widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Parlo
 */

if ( ! is_active_sidebar( 'sidebar-2' ) ) {
    return;
}
?>

<aside id="secondary" class="widget-area">
    <?php dynamic_sidebar( 'sidebar-2' ); ?>
</aside><!-- #secondary -->

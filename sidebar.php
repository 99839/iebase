<?php
/**
 * The sidebar containing the main widget area.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Ieblog
 */
?>

<div class='c-sidebar'>
  <?php if ( is_active_sidebar( 'post-sidebar' ) ) : ?>
    <?php dynamic_sidebar( 'post-sidebar' ); ?>
  <?php endif; ?>
</div>
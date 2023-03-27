<?php
/**
 * Template part for displaying results in search pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Iebase
 */

?>

<div class='e-grid'>
  <div class='e-grid__col e-grid__col--full'>
    <?php get_template_part( 'template-parts/search-header' ); ?>
  </div>
</div>

<div class='e-grid js-grid'>
  <?php
    while ( have_posts() ) : the_post();
      get_template_part( 'template-parts/post-card' );
    endwhile;
  ?>
</div>

<div class='e-grid'>
  <?php get_template_part( 'template-parts/pagination' ); ?>
</div>
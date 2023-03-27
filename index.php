<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Iebase
 */

get_header(); ?>

<div class='ie-wrapper' id='content'>

  <?php if ( is_home() && !is_paged() ) :?>
     <?php do_action( 'iebase_home_loop_start' ); ?>
  <?php endif; ?>

  <?php if ( have_posts() ) : ?>

    <div id='posts' class='e-grid js-grid'>
      <?php do_action( 'iebase_post_loop_start' ); ?>
      <?php
        while ( have_posts() ) : the_post();
          get_template_part( 'template-parts/post-card' );
        endwhile;
        if ( function_exists( 'iecore_paginator' ) ) iecore_paginator( get_pagenum_link() );
      ?>
    </div>

  <?php else: ?>

    <?php get_template_part( 'template-parts/content-none' ); ?>

  <?php endif; ?>

</div>

<?php
get_footer();
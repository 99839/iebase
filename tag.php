<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Iebase
 */

get_header(); ?>

<div class='ie-wrapper' id='content'>

  <div class='e-grid'>
    <div class='e-grid__col e-grid__col--full'>
      <?php get_template_part( 'template-parts/tag-header' ); ?>
    </div>
  </div>

  <?php if ( have_posts() ) : ?>
    
    <div id='posts' class='e-grid js-grid'>
      <?php
        while ( have_posts() ) : the_post();
          get_template_part( 'template-parts/post-card' );
        endwhile;
        if ( function_exists( 'iecore_paginator' ) ) iecore_paginator( get_pagenum_link() );
      ?>
    </div>

  <?php else: ?>

    <div class='e-grid'>
      <div class='e-grid__col e-grid__col--full'>
        <?php get_template_part( 'template-parts/no-results' ); ?>
      </div>
    </div>

  <?php endif; ?>

</div>

<?php
get_footer();
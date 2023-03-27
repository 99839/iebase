<?php
/**
 * The template for displaying search results pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package Iebase
 */

get_header(); ?>

<div class='ie-wrapper' id='content'>

  <?php if ( have_posts() ) : ?>

    <?php get_template_part( 'template-parts/content', 'search' ); ?>

  <?php else: ?>

    <?php get_template_part( 'template-parts/content', 'none' ); ?>

  <?php endif; ?>

</div>

<?php
get_footer();
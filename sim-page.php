<?php
/**
 * Template Name: Download & Demo
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Iebase
 */

get_header(); ?>

<div class='ie-wrapper'>

  <div class='e-grid'>
    <div class='e-grid__col e-grid__col--center e-grid__col--4-4-s e-grid__col--3-4-m'>
      <article id='post-<?php the_ID(); ?>' <?php post_class('ie-post sim'); ?>>

        <div class='ie-content'>
          <?php do_action( 'dd_loop_start' ); ?>
          <?php
            while ( have_posts() ) : the_post();
              the_content();

              // If comments are open or we have at least one comment, load up the comment template.
              if ( comments_open() || get_comments_number() ) :
                comments_template();
              endif;
            endwhile;
          ?>
          <?php get_template_part( 'template-parts/wp-link-pages' ); ?>
          <?php do_action( 'dd_loop_end' ); ?>
        </div>

        <div class='sim-footer'>
          <?php do_action( 'dd_footer_section' ); ?>
        </div>
      </article>
    </div>
  </div>

</div>

<?php
get_footer();
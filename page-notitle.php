<?php
/**
 * /**
 * Template Name: No title page
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Iebase
 */

get_header(); ?>

<?php //get_template_part( 'template-parts/page-hero' ); ?>

<div class='ie-wrapper'>

  <div class='e-grid'>
    <div class='e-grid__col e-grid__col--center e-grid__col--4-4-s e-grid__col--3-4-m'>
      <article id='post-<?php the_ID(); ?>' <?php post_class('ie-post entry'); ?>>

        <div class='ie-content'>
          <?php
            while ( have_posts() ) : the_post();
              the_content();
            endwhile;
          ?>
          <?php get_template_part( 'template-parts/wp-link-pages' ); ?>
        </div>

        <div class='entry-footer'>
          <?php
            edit_post_link(
              sprintf(
                /* translators: %s: Name of current post */
                esc_html__( 'Edit %s', 'iebase' ),
                the_title( '<span class="screen-reader-text ">"', '"</span>', false )
              ),
              '<span class="edit-link font-small">',
              '</span>'
            );
          ?>
        </div>
      </article>
    </div>
  </div>

</div>

<?php
get_footer();
<?php
/**
 * The template for displaying all pages.
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

<?php get_template_part( 'template-parts/page-hero' ); ?>

<div class='ie-wrapper'>

  <div class='e-grid'>
    <div class='e-grid__col e-grid__col--center e-grid__col--4-4-s e-grid__col--3-4-m'>
      <article id='post-<?php the_ID(); ?>' <?php post_class('ie-post entry'); ?>>

        <div class='ie-content'>
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
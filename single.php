<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Iebase
 */

get_header(); ?>

<?php get_template_part( 'template-parts/post-hero' ); ?>

<div class='ie-wrapper' id='content'>

  <div class='e-grid'>
    <div class='blog-post e-grid__col e-grid__col--center e-grid__col--4-4-m e-grid__col--2-3-l'>
    <?php do_action( 'iebase_single_post_start' ); ?>
      <article id='post-<?php the_ID(); ?>' <?php post_class('ie-post entry'); ?>> 

        <div class='ie-content'>
        <?php do_action( 'iebase_single_content_start' ); ?>
          <?php
            while ( have_posts() ) : the_post();
              do_action( 'iebase_post_detail_start' );
              the_content();
            endwhile;
          ?>
          <?php get_template_part( 'template-parts/wp-link-pages' ); ?>
          <?php do_action( 'iebase_single_content_end' ); ?>
        </div>

        <div class='e-grid'>
          <div class='e-grid__col e-grid__col--4-4-s e-grid__col--3-4-m'>
            <div class='c-tags'>
              <?php echo get_the_tag_list(); ?>
            </div>
          </div>
          <div class='e-grid__col e-grid__col--4-4-s e-grid__col--1-4-m'>
            <?php get_template_part( 'template-parts/share' ); ?>
          </div>
        </div>
  
        <?php
          iebase_related_posts();

          get_template_part( 'template-parts/post-navigation' );

          if ( comments_open() || get_comments_number() ) :
            comments_template();
          endif;
        ?>

      </article>
    </div>
    <div class='e-grid__col e-grid__col--center e-grid__col--4-4-m e-grid__col--1-3-l'>
      <?php get_sidebar(); ?>
    </div>
  </div>

</div>

<?php
get_footer();
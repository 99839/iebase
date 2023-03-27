<?php
/**
 * Template Name: Woocommerce
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
    <div class='woo-sim e-grid__col e-grid__col--center e-grid__col--4-4-s e-grid__col--3-4-m'>

        <div class='ie-content'>
          <?php
            while ( have_posts() ) : the_post();
              the_content();
            endwhile;
          ?>
        </div>
    </div>
  </div>

</div>

<?php
get_footer();
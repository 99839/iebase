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

<?php //get_template_part( 'template-parts/page-hero' ); ?>

<div class='ie-wrapper'>

  <div class='e-grid'>
    <div class='woo-container e-grid__col e-grid__col--center e-grid__col--4-4-s e-grid__col--3-4-m'>
          <?php
              woocommerce_content();
          ?>
    </div>
  </div>

</div>

<?php
get_footer();
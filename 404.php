<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Iebase
 */

get_header(); ?>

<div class='ie-wrapper' id='content'>

  <div class='e-grid'>
    <div class="e-grid__col e-grid__col--full">

      <h3><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'iebase' ); ?></h3>

      <?php get_template_part( 'template-parts/no-results' ); ?>

    </div>
  </div>

</div>

<?php
get_footer();
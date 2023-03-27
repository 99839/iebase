<?php
/**
 * Template part for displaying a message that posts cannot be found.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Iebase
 */

?>

<div class='e-grid'>
  <div class="e-grid__col e-grid__col--full">

  
    <?php get_template_part( 'template-parts/search-header' ); ?>

    <h3><?php esc_html_e( 'Nothing Found', 'iebase' ); ?></h3>

    <?php get_template_part( 'template-parts/no-results' ); ?>

  </div>
</div>
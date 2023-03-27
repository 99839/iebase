<?php
/**
 * Template part for displaying the archive page header info.
 *
 * @package Iebase
 */

?>

<div class='ie-archive-hero'>
  <div class='e-grid ie-post-hero__content'>
    <div class='e-grid__col e-grid__col--2-4-m e-grid__col--center'>

    <ul id="menu-blog-categories" class="blog-categories">
    <?php if ( has_nav_menu( 'blogm' ) ) : ?>
      <?php
        wp_nav_menu( array(
          'items_wrap'      => '%3$s',
          'container'       => false,
          'theme_location'  => 'blogm',
          //'link_before'     => '<span class="screen-reader-text">',
          //'link_after'      => '</span>',
          'depth'           => 1,
        ) );
      ?>
    <?php endif; ?>
    </ul>

    </div>
  </div>
</div>
<?php
/**
 * Set up the site header Navigation
 *
 * @package Iebase
 */

?>

<?php if ( has_nav_menu( 'primary' ) ) : ?>
  <h2 class='screen-reader-text'><?php esc_html_e( 'Primary Navigation', 'iebase' ); ?></h2>
  <ul class='ie-nav ie-plain-list'>
    <?php wp_nav_menu( array( 'theme_location' => 'primary', 'items_wrap' => '%3$s', 'container' => false ) ); ?>
  </ul>
<?php endif; ?>
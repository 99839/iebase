<?php
/**
 * Set up the social media links
 *
 * @package Iebase
 */

?>

  <ul class='ie-secondary-nav ie-plain-list'>

    <?php do_action('iebase_menu_action');?>

    <?php if ( get_theme_mod( 'display_search_icon' ) ) : ?>
      <li class='menu-item'>
        <div class='ie-search-toggle js-search-toggle'>
        <i class="iecon-magnifier ie-search-toggle__icon"></i>
      </li>
    <?php endif; ?>
  </ul>
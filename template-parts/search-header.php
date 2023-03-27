<?php
/**
 * Template part for displaying the search page header info.
 *
 * @package Iebase
 */

?>

<div class='ie-archive'>
  <div class='e-grid'>
    <div class='e-grid__col e-grid__col--2-4-m e-grid__col--center'>
      <h4 class='ie-archive__name'><?php printf( esc_html__( 'Search Results for: %s', 'iebase' ), '<i>' . get_search_query() . '</i>' ); ?></h4>
    </div>
  </div>
</div>
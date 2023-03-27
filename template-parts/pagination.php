<?php
/**
 * Template part for displaying the Ajax load more posts button.
 *
 * @package Iebase
 */

?>

<?php if ( get_next_posts_link() ) : ?>
  <div class='e-grid__col e-grid__col--full ie-text-center'>
    <?php if ( function_exists( 'iecore_paginator' ) ) iecore_paginator( get_pagenum_link() );?>
  </div>
<?php endif; ?>
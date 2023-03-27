<?php
/**
 * Template part for displaying the archive page header info.
 *
 * @package Iebase
 */

?>

<div class='ie-archive'>
  <div class='e-grid'>
    <div class='e-grid__col e-grid__col--2-4-m e-grid__col--center'>

      <h4 class='ie-archive__name'><?php
				/* translators: %s: Tag title. */
				printf( __( 'Tag Archives: %s', 'iebase' ), '<span>' . single_tag_title( '', false ) . '</span>' );
				?></h4>

      <?php if (tag_description()) : ?>
        <p class='ie-archive__description'>
          <?php echo tag_description(); ?>
        </p>
      <?php endif; ?>

    </div>
  </div>
</div>
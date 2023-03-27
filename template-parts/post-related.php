<?php
/**
 * Template part for displaying the post card in the loop.
 *
 * @package Iebase
 */

?>

<div <?php post_class('e-grid__col e-grid__col--4-4-s e-grid__col--2-4-m e-grid__col--1-3-l ie-post-card-wrap js-post-card-wrap'); ?>>
  <div class='ie-post-card <?php if ( ! has_post_thumbnail() ) :?> ie-post-card--no-image <?php endif; ?>'>

  <?php if ( has_post_thumbnail() ) : ?>
    <a href='<?php the_permalink(); ?>' class='js-fadein ie-post-card__image' style='background-image: url(<?php esc_url(iebase_entry_feature_image_path('ie-post-grid-thumb')); ?>)'>
      <span title='<?php esc_html_e('Featured Post', 'iebase'); ?>'>
        <span class='ie-post-card--featured__icon' data-icon='ei-star' data-size='s'></span>
      </span>
    </a>
  <?php else:?>
    <a href='<?php the_permalink(); ?>' class='js-fadein ie-post-card__image ie-no-thumb'>
      <span title='<?php esc_html_e('Featured Post', 'iebase'); ?>'>
        <span class='ie-post-card--featured__icon' data-icon='ei-star' data-size='s'></span>
      </span>
    </a>
  <?php endif; ?>

    <a href='<?php the_permalink(); ?>' class='ie-post-card__info'>
      <h4 class='ie-post-related__title'><?php the_title(); ?></h4>

      <p class='ie-post-related__excerpt'>
        <?php echo(get_the_excerpt()); ?>
      </p>
    </a>

  </div>
</div>
<?php
/**
 * Template part for displaying the post card in the loop.
 *
 * @package Iebase
 */
$ad_url = get_post_meta( get_the_ID(), 'iebase_ad_url', true );
$button_value = get_post_meta( get_the_ID(), 'iebase_ad_button_value', true );
$extra = get_post_meta( get_the_ID(), 'iebase_ad_extra_field', true );
$sponsored = get_post_meta( get_the_ID(), 'iebase_sponsored_text', true );
?>

<div <?php post_class('e-grid__col e-grid__col--4-4-s e-grid__col--2-4-m e-grid__col--1-3-l ie-post-card-wrap js-post-card-wrap'); ?>>
  <div class='ie-post-card <?php if ( ! has_post_thumbnail() ) :?> ie-post-card--no-image <?php endif; ?>'>

  <?php if ( 'link' == get_post_format() ) : ?>

  <?php if ( has_post_thumbnail() ) : ?>
    <a href='<?php the_permalink(); ?>' class='js-fadein ie-post-card__image' style='background-image: url(<?php esc_url(iebase_entry_feature_image_path('ie-post-grid-thumb')); ?>)'>
      <?php if ( $sponsored ) : ?>
        <span class='link-sponsored'><?php echo $sponsored; ?></span>
      <?php endif; ?>
    </a>
  <?php else:?>
    <a href='<?php the_permalink(); ?>' class='js-fadein ie-post-card__image ie-no-thumb'>
      <?php if ( $sponsored ) : ?>
          <span class='link-sponsored'><?php echo $sponsored; ?></span>
      <?php endif; ?>
    </a>
  <?php endif; ?>
  <div class='ie-post-card__detail'>
    <a href='<?php the_permalink(); ?>' class='ie-post-card__info post-link'>
      <h3 class='ie-post-card__title'><?php the_title(); ?></h3>
    </a>
    <div class="ie-post-card__link-warp">
      <?php if ( $extra ) : ?>
      <p class='ie-post-card__link-content'>
        <?php echo $extra; ?>
      </p>
      <?php endif; ?>
      <?php if ( $button_value ) : ?>
      <div class="ie-post-card__link-button">
      <a href='<?php the_permalink(); ?>'><?php echo $button_value; ?></a>
      </div>
      <?php endif; ?>
    </div>

  <?php else:?>

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
  <div class='ie-post-card__detail'>
    <a href='<?php the_permalink(); ?>' class='ie-post-card__info'>
      <h3 class='ie-post-card__title'><?php the_title(); ?></h3>
      <p class='ie-post-card__excerpt'>
        <?php echo(get_the_excerpt()); ?>
      </p>
    </a>

    <div class='ie-post-card__footer'>
      <div class='ie-post-card__author'>
      <i class="iecon-account ie-post-card__icon"></i>
        <?php the_author_posts_link(); ?>
      </div>

    <?php if ( function_exists('get_simple_likes_button')) {
	    echo get_simple_likes_button( get_the_ID() );
    };?>

    <?php if ( function_exists('Ie_PostViews')) {
      $post_view = Ie_PostViews(get_the_ID());
			echo '<span class="post-view"><i class="iecon-visibility ie-post-card__icon"></i>';
			echo iebase_numerical_word( $post_view );
			echo '</span>';
		};?>

      <span class='ie-post-card__date'>
      <i class="iecon-watch_later ie-post-card__icon"></i>
        <time datetime='<?php the_time( 'c' ); ?>' title='<?php the_time( 'c' ); ?>'>
          <?php echo get_the_date(get_option( 'date_format' )); ?>
        </time>
      </span>
    </div>

  <?php endif; ?>
  </div>

  </div>
</div>
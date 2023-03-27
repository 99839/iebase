<?php
/**
 * Template part for displaying ie-author info in the Post & ie-author pages.
 *
 * @package Iebase
 */
$author             = get_the_author();
$author_description = get_the_author_meta('description');
$author_url         = esc_url(get_author_posts_url(get_the_author_meta('ID')));
?>

<div class='ie-author'>

  <div class='e-grid'>
    <div class='e-grid__col e-grid__col--2-4-m e-grid__col--center'>
      <h4 class='ie-author__name'><?php
                printf(__('Author Archives: %s', 'iebase'), '<span class="vcard"><a class="url fn n" href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '" title="' . esc_attr(get_the_author()) . '" rel="me">' . get_the_author() . '</a></span>');
                ?></h4>
        <div class="author-description">
          <p><?php echo wp_kses_post($author_description); ?></p>
        </div><!-- .author-description -->
    </div>
  </div>

</div>
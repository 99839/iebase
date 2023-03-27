<?php
/**
 * Site Header
 *
 * @package Iebase
 */

?>

<header class='ie-header js-header <?php echo iebase_header_class(); ?>'>

  <div class='e-grid'>
    <div class='e-grid__col e-grid__col--full'>
      <label class='js-off-canvas-toggle ie-off-canvas-toggle' aria-label='Toggle navigation'>
        <span class='ie-off-canvas-toggle__icon'></span>
      </label>

      <?php if ( function_exists( 'the_custom_logo' ) && has_custom_logo() ) : ?>
        <?php the_custom_logo() ?>
      <?php else: ?>
        <a class='ie-logo-link' href='<?php echo esc_url( home_url( '/' ) ); ?>'><?php bloginfo( 'name' ); ?></a>
      <?php endif; ?>

      <div class='ie-off-canvas-content js-off-canvas-content'>
        <label class='js-off-canvas-toggle ie-off-canvas-toggle ie-off-canvas-toggle--close'>
          <span class='ie-off-canvas-toggle__icon'></span>
        </label>

        <?php get_template_part( 'template-parts/navigation' ); ?>

        <?php get_template_part( 'template-parts/social-nav' ); ?>
      </div>
    </div>
  </div>

</header>

<div class='header-headroom-space'></div>

<?php if ( get_theme_mod( 'display_search_icon' ) ) : ?>
  <?php get_template_part( 'template-parts/modal-search-form' ); ?>
<?php endif; ?>
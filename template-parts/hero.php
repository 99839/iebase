<?php
/**
 * Template part for displaying the Site Hero Section on Home Page.
 *
 * @package Iebase
 */
$header_title = get_theme_mod( 'hero_header_title','');
$header_desc = get_theme_mod( 'hero_header_description','');
$header_bnt = get_theme_mod( 'hero_header_text', esc_html__( 'Learn More', 'iebase' ) );
$header_url = get_theme_mod( 'hero_header_url', esc_url( 'http://' ) );
$header_animation = get_theme_mod( 'hero_animation', '1' );
$site_title = get_bloginfo('name');
$site_desc = get_bloginfo('description');
?>

<?php if ( has_header_image() ) : ?>
  <div class='ie-hero' style='background-image: url(<?php echo ( get_header_image () ); ?>)'>
    <?php if ( display_header_text() ) : ?>
      <div class='ie-hero__content'>
      <h1 class="ie-hero__title"><?php if (empty($header_title)){ echo $site_title; } else{ echo $header_title; }?></h1>
      <div class='ie-hero__description'><?php if (empty($header_desc)){ echo $site_desc; } else{ echo $header_desc; }?></div>
      <?php if (!empty($header_bnt)):?>
      <div class="ie-hero__cta"><a href="<?php echo $header_url ;?>" class="learn-more ie-btn"><?php echo $header_bnt ;?></a></div>
      <?php endif; ?>
      </div>
    <?php endif; ?>
    <?php if ( $header_animation == 1 ) : ?>
      <div class='ie-hero__animation'>
      <svg class="waves" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 24 150 28" preserveAspectRatio="none" shape-rendering="auto"><defs><path id="gentle-wave" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z"></path></defs><g class="parallax"><use xlink:href="#gentle-wave" x="48" y="0" fill="rgba(255,255,255,0.7"></use><use xlink:href="#gentle-wave" x="48" y="3" fill="rgba(255,255,255,0.5)"></use><use xlink:href="#gentle-wave" x="48" y="5" fill="rgba(255,255,255,0.3)"></use><use xlink:href="#gentle-wave" x="48" y="7" fill="#fff"></use></g></svg>
      </div>
    <?php endif; ?>
  </div>
<?php endif; ?>
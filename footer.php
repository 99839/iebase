<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Iebase
 */

?>

  <footer class='ie-footer'>
    <div class='e-grid'>

      <?php
        // If we get this far, we have widgets.
        // The next check is to see if all four widget areas have content, which will affect the CSS classes used.
        if ( is_active_sidebar( 'footer-first'  )
          && is_active_sidebar( 'footer-second' )
          && is_active_sidebar( 'footer-third'  )
          && is_active_sidebar( 'footer-fourth' )
        ) : ?>

        <div class='e-grid__col e-grid__col--full'>
          <div class='ie-footer__top'>
            <div class='e-grid'>
              <div class='e-grid__col e-grid__col--4-4-s e-grid__col--2-4-m e-grid__col--1-4-l'>
                <?php dynamic_sidebar( 'footer-first' ); ?>
              </div>

              <div class='e-grid__col e-grid__col--4-4-s e-grid__col--2-4-m e-grid__col--1-4-l'>
                <?php dynamic_sidebar( 'footer-second' ); ?>
              </div>

              <div class='e-grid__col e-grid__col--4-4-s e-grid__col--2-4-m e-grid__col--1-4-l'>
                <?php dynamic_sidebar( 'footer-third' ); ?>
              </div>

              <div class='e-grid__col e-grid__col--4-4-s e-grid__col--2-4-m e-grid__col--1-4-l'>
                <?php dynamic_sidebar( 'footer-fourth' ); ?>
              </div>
            </div>
            <?php do_action('iebase_footer_bottom_content');?>
          </div>
        </div>

      <?php
        //end of check for all four sidebars. Next we check if there are three sidebars with widgets.
        elseif ( is_active_sidebar( 'footer-first'  )
            &&   is_active_sidebar( 'footer-second' )
            &&   is_active_sidebar( 'footer-third'  )
            && ! is_active_sidebar( 'footer-fourth' )
        ) : ?>

        <div class='e-grid__col e-grid__col--full'>
          <div class='ie-footer__top'>
            <div class='e-grid'>
              <div class='e-grid__col e-grid__col--4-4-s e-grid__col--1-3-m'>
                <?php dynamic_sidebar( 'footer-first' ); ?>
              </div>

              <div class='e-grid__col e-grid__col--4-4-s e-grid__col--1-3-m'>
                <?php dynamic_sidebar( 'footer-second' ); ?>
              </div>

              <div class='e-grid__col e-grid__col--4-4-s e-grid__col--1-3-m'>
                <?php dynamic_sidebar( 'footer-third' ); ?>
              </div>
            </div>
            <?php do_action('iebase_footer_bottom_content');?>
          </div>
        </div>

      <?php
        //end of check for three sidebars. Next we check if there are two sidebars with widgets.
        elseif ( is_active_sidebar( 'footer-first'  )
            &&   is_active_sidebar( 'footer-second' )
            && ! is_active_sidebar( 'footer-third'  )
            && ! is_active_sidebar( 'footer-fourth' )
        ) : ?>

        <div class='e-grid__col e-grid__col--full'>
          <div class='ie-footer__top'>
            <div class='e-grid'>
              <div class='e-grid__col e-grid__col--4-4-s e-grid__col--2-4-m'>
                <?php dynamic_sidebar( 'footer-first' ); ?>
              </div>

              <div class='e-grid__col e-grid__col--4-4-s e-grid__col--2-4-m'>
                <?php dynamic_sidebar( 'footer-second' ); ?>
              </div>
            </div>
            <?php do_action('iebase_footer_bottom_content');?>
          </div>
        </div>

      <?php
        //end of check for two sidebars. Finally we check if there is just one sidebar with widgets.
        elseif ( is_active_sidebar( 'footer-first'  )
            && ! is_active_sidebar( 'footer-second' )
            && ! is_active_sidebar( 'footer-third'  )
            && ! is_active_sidebar( 'footer-fourth' )
        ) : ?>

        <div class='e-grid__col e-grid__col--full'>
          <div class='ie-footer__top'>
            <div class='e-grid'>
              <div class='e-grid__col e-grid__col--full'>
                <?php dynamic_sidebar( 'footer-first' ); ?>
              </div>
            </div>
            <?php do_action('iebase_footer_bottom_content');?>
          </div>
        </div>
      <?php else :?>
        <div class='e-grid__col e-grid__col--full'>
          <div class='ie-footer__top'>
          <?php do_action('iebase_footer_bottom_content');?>
          </div>
        </div>  

      <?php
      //end of all sidebar checks.
      endif;?>

      <div class='e-grid__col e-grid__col--full ie-text-center ie-font-small'>
        <?php if ( get_theme_mod( 'iebase-footer-copyright' ) ) : ?>
          <?php echo wp_kses_post( get_theme_mod( 'iebase-footer-copyright' ) ); ?>
        <?php else : ?>
          &copy; <?php echo date_i18n( __('Y', 'iebase') ); ?> <a href='<?php echo esc_url( home_url( '/' ) ); ?>'><?php bloginfo(); ?></a>
        <?php endif; ?> Made with ❤ by <a href="https://www.ietheme.com" target="_blank" rel="nofollow noopener">Ietheme&nbsp;</a>
      </div><!-- e-grid__col full -->

    </div>
  </footer>
</div>
<!-- End off-canvas-container -->

<?php 
do_action('iebase_footer_action');
wp_footer(); ?>

</body>
</html>
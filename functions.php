<?php
/**
 * iebase functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Iebase
 */

if ( ! function_exists( 'iebase_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function iebase_setup() {
  /*
   * Make theme available for translation.
   * Translations can be filed in the /languages/ directory.
   * If you're building a theme based on Real, use a find and replace
   * to change 'iebase' to the name of your theme in all the template files.
   */
  load_theme_textdomain( 'iebase', get_template_directory() . '/languages' );

  // Add default posts and comments RSS feed links to head.
  add_theme_support( 'automatic-feed-links' );

  /*
   * Add Custom Header Support
   */
  $args = array(
    'flex-width'    => true,
    'flex-height'   => true,
    'default-image' => '',
  );

  add_theme_support( 'custom-header', $args );

  /*
   * Add Custom Logo Support
   */
  add_theme_support('custom-logo', array(
    'height'     => 36,
    'width'      => 150,
    'flex-width' => true,
    'flex-height' => true,
  ));

  /*
   * Let WordPress manage the document title.
   * By adding theme support, we declare that this theme does not use a
   * hard-coded <title> tag in the document head, and expect WordPress to
   * provide it for us.
   */
  add_theme_support( 'title-tag' );

  /*
   * Enable support for Post Thumbnails on posts and pages.
   *
   * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
   */
  add_theme_support( 'post-thumbnails' );

  add_image_size( 'ie-post-grid-thumb', 380, 220, true );

  // This theme uses wp_nav_menu() in one location.
  register_nav_menus( array(
    'primary' => esc_html__( 'Primary Menu', 'iebase' ),
    'social'  => esc_html__( 'Social Menu', 'iebase' ),
    'blogm'  => esc_html__( 'Blog Menu', 'iebase' ),
  ) );

  /*
   * Switch default core markup for search form, comment form, and comments
   * to output valid HTML5.
   */
  add_theme_support( 'html5', array(
    'search-form',
    'comment-form',
    'comment-list',
    'gallery',
    'caption',
  ) );

  add_theme_support( 'post-formats', array(
    'link'
  ) );

  /**
   * Return entry full featured image path
   */
  function iebase_entry_feature_image_path() {
    $featured_image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'ie-post-grid-thumb' );
    echo $featured_image[0];
  }

  function iebase_page_feature_image_path() {
    $featured_image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'large' );
    echo $featured_image[0];
  }

  /**
   * Custom more text for the excerpt more
   */
  function iebase_custom_excerpt_more( $more ) {
    return ' ...';
  }
  add_filter( 'excerpt_more', 'iebase_custom_excerpt_more' );

  /**
   * Return entry full featured image path
   */
  function iebase_category_feature_image() {
    $category_image = '';

    if (function_exists('category_image_src')) {
      $category_image = category_image_src( array( 'size' => 'full' ) , false );
    }

    echo $category_image;
  }

  /**
   * Add CSS class to custom logo
   */
  function iebase_custom_logo_class( $html ) {
    $html = str_replace('custom-logo', 'ie-logo', $html);

    return $html;
  }
  add_filter( 'get_custom_logo', 'iebase_custom_logo_class' );

  /**
   * Remove p tags from archive description
   */
  function iebase_custom_archive_description( $description ) {
    $remove = array( '<p>', '</p>' );
    $description = str_replace( $remove, '', $description );
    return $description;
  }
  add_filter( 'get_the_archive_description', 'iebase_custom_archive_description' );

  /**
  * Remove parentheses from category list and add span class to posts count
  */
  function iebase_categories_postcount_filter( $variable ) {
    $variable = str_replace( '(', '<span class="post-count"> ', $variable );
    $variable = str_replace( ')', ' </span>', $variable );
    return $variable;
  }
  add_filter( 'wp_list_categories', 'iebase_categories_postcount_filter' );

  /**
   * Returns the title escaped, to be used in the share URLs
   */
  function iebase_get_escaped_title() {
    echo htmlspecialchars( urlencode( html_entity_decode( get_the_title() . ' - ' . get_bloginfo( 'name' )) ) );
  }

  function iebase_get_share_image() {
    echo wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ) );
  }

  /**
   * Related Posts Function.
   */
  if ( ! function_exists ( 'iebase_related_posts' ) ) {
    function iebase_related_posts() {
      global $post;
      $tags = wp_get_post_tags( $post->ID );
      $tag_arr = '';

      if( $tags ) {
        foreach( $tags as $tag ) {
          $tag_arr .= $tag->slug . ',';
        }

        $args = array(
          'tag'           => $tag_arr,
          'numberposts'   => 3,
          'post__not_in'  => array( $post->ID )
        );

        $related_posts = get_posts( $args );

        if( $related_posts ) {
          echo '<div class="ie-related">';
            echo '<div class="e-grid related">';
              echo '<div class="e-grid__col e-grid__col--full">';
                echo '<h3 class="ie-related__title">' . esc_html__( 'You Might Be Interested In', 'iebase' ) . '</h3>';
              echo '</div>';
              foreach ( $related_posts as $post ) : setup_postdata( $post ); ?>
                <?php get_template_part( 'template-parts/post-related' ); ?>
              <?php endforeach;
            echo '</div>';
          echo '</div>';
        }
      }

      wp_reset_postdata();
    }
  }
}
endif;
add_action( 'after_setup_theme', 'iebase_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function iebase_content_width() {
  $GLOBALS['content_width'] = apply_filters( 'iebase_content_width', 640 );
}
add_action( 'after_setup_theme', 'iebase_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function iebase_widgets_init() {
  register_sidebar( array(
    'name'          => esc_html__( 'Post Sidebar', 'iebase' ),
    'id'            => 'post-sidebar',
    'description'   => esc_html__( 'Add widgets here to appear in single post page sidebar.', 'iebase' ),
    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    'after_widget'  => '</aside>',
    'before_title'  => '<h2 class="widget__title">',
    'after_title'   => '</h2>',
  ) );

  register_sidebar( array(
    'name'          => esc_html__( 'Footer First', 'iebase' ),
    'id'            => 'footer-first',
    'description'   => esc_html__( 'Add widgets here to appear in site Footer First column.', 'iebase' ),
    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    'after_widget'  => '</aside>',
    'before_title'  => '<h2 class="widget__title">',
    'after_title'   => '</h2>',
  ) );

  register_sidebar( array(
    'name'          => esc_html__( 'Footer Second', 'iebase' ),
    'id'            => 'footer-second',
    'description'   => esc_html__( 'Add widgets here to appear in site Footer Second column.', 'iebase' ),
    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    'after_widget'  => '</aside>',
    'before_title'  => '<h2 class="widget__title">',
    'after_title'   => '</h2>',
  ) );

  register_sidebar( array(
    'name'          => esc_html__( 'Footer Third', 'iebase' ),
    'id'            => 'footer-third',
    'description'   => esc_html__( 'Add widgets here to appear in site Footer Third column.', 'iebase' ),
    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    'after_widget'  => '</aside>',
    'before_title'  => '<h2 class="widget__title">',
    'after_title'   => '</h2>',
  ) );

  register_sidebar( array(
    'name'          => esc_html__( 'Footer Fourth', 'iebase' ),
    'id'            => 'footer-fourth',
    'description'   => esc_html__( 'Add widgets here to appear in site Footer Fourth column.', 'iebase' ),
    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    'after_widget'  => '</aside>',
    'before_title'  => '<h2 class="widget__title">',
    'after_title'   => '</h2>',
  ) );
}
add_action( 'widgets_init', 'iebase_widgets_init' );

/**
 * Register Fonts
 */
if ( ! function_exists ( 'iebase_fonts_url' ) ) {
  function iebase_fonts_url() {
    $font_url = '';

    /**
     * Translators: If there are characters in your language that are not supported
     * by chosen font(s), translate this to 'off'. Do not translate into your own language.
     */
    if ( 'off' !== _x( 'on', 'Google font: on or off', 'iebase' ) ) {
        $font_url = add_query_arg( 'family', urlencode( 'Roboto:400,300|Libre Baskerville:400' ), '//fonts.googleapis.com/css' );
    }
    return $font_url;
  }
}

/**
 * Enqueue scripts and styles.
 */
function iebase_scripts() {
  global $wp_query;

  if ( ! is_rtl() ) {
    wp_enqueue_style( 'iebase-style', get_stylesheet_uri() );
  } else {
    wp_enqueue_style( 'iebase-style', get_template_directory_uri() . '/style-rtl.css' );
  }

  wp_enqueue_style( 'font-style', get_template_directory_uri() . '/assets/css/fonts.css' );

  wp_enqueue_script( 'iebase-vendors-script', get_template_directory_uri() . '/assets/js/vendors.min.js', array( 'jquery' ), wp_get_theme()->get( 'Version' ), true );

  wp_enqueue_script( 'iebase-main-script', get_template_directory_uri() . '/assets/js/app.js', array( 'jquery' ), wp_get_theme()->get( 'Version' ), true );

  wp_localize_script( 'iebase-main-script', 'ie_loadmore_params', array(
		'ajaxurl' => site_url() . '/wp-admin/admin-ajax.php', // WordPress AJAX
		'iecore_loading' => esc_html__('Loading', 'iebase'),
		'current_page' => $wp_query->query_vars['paged'] ? $wp_query->query_vars['paged'] : 1,
		'max_page' => $wp_query->max_num_pages,
		'first_page' => get_pagenum_link(1)
  ) );

  // ajax comments
	wp_localize_script( 'iebase-main-script', 'misha_ajax_comment_params', array(
		'ajaxurl' => site_url() . '/wp-admin/admin-ajax.php'
	) );

   wp_enqueue_script( 'ajax_comment' );

  // like system
  wp_localize_script( 'iebase-main-script', 'simpleLikes', array(
		'ajaxurl' => admin_url( 'admin-ajax.php' ),
		'like' => __( 'Like', 'iebase' ),
		'unlike' => __( 'Unlike', 'iebase' )
	) );

   wp_enqueue_script( 'iebase-main-script' );


  // Cookie notification bar
  if ( is_home() && get_theme_mod( 'cookie_notice', false ) ) {
    wp_enqueue_style( 'cookieconsent', get_template_directory_uri() . '/assets/css/cookieconsent.min.css' );
}

  if ( is_home() && get_theme_mod( 'cookie_notice', false ) ) {
  wp_enqueue_script( 'cookieconsent', get_template_directory_uri() . '/assets/js/cookieconsent.min.js', array( 'jquery' ), '3.1.0', true );

  wp_register_script( 'iebase-cookie-consent', get_template_directory_uri() . '/assets/js/cookies.js', array( 'cookieconsent' ), '1.0.0', true );
  $cookies_data = array(
      'message' => get_theme_mod( 'cookie_text', esc_html__( 'We are using cookies to personalize content and ads to make our site easier for you to use.', 'iebase' ) ),
      'dismiss' => get_theme_mod( 'cookies_button', esc_html__( 'Agree', 'iebase' ) ),
      'link' => get_theme_mod( 'cookies_learn_more_text', esc_html__( 'Learn More', 'iebase' ) ),
      'href' => get_theme_mod( 'cookies_learn_more_url', esc_url( '//cookiesandyou.com' ) ),
  );
  wp_localize_script( 'iebase-cookie-consent', 'cookies', $cookies_data );
  wp_enqueue_script( 'iebase-cookie-consent' );
}

  // Max number of pages
  $iebase_page_number_max = $wp_query->max_num_pages;

  // Next page to load
	$iebase_page_number_next = (get_query_var('paged') > 1) ? get_query_var('paged') + 1 : 2;

  // Get next page link
  $iebase_page_link_next = get_pagenum_link(9999999999);

  wp_localize_script( 'iebase-main-script', 'iebase_config', array(
    'iebase_page_number_max'  => $iebase_page_number_max,
    'iebase_page_number_next' => $iebase_page_number_next,
    'iebase_page_link_next'   => $iebase_page_link_next,
    'iebase_load_more'        => esc_html__('Load More', 'iebase'),
    'iebase_loading'          => esc_html__('Loading', 'iebase')
  ) );

  if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
    wp_enqueue_script( 'comment-reply' );
  }
}
add_action( 'wp_enqueue_scripts', 'iebase_scripts' );

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';
require get_template_directory() . '/inc/customizer-controls.php';
/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Loop Pagination
 */
require get_template_directory() . '/inc/class-pagination.php';

/**
 * Post Likes
 */
require get_template_directory() . '/inc/class-post-like.php';

/**
 * Post View
 */
require get_template_directory() . '/inc/class-post-view.php';

/**
 * Theme Template
 */
require get_template_directory() . '/inc/class-template.php';

/**
 * Breadcrumbs
 */
require get_template_directory() . '/inc/class-breadcrumbs.php';

/**
 * Widgets
 */
require get_template_directory() . '/inc/class-widgets.php';

/**
 * Ads
 */
require get_template_directory() . '/inc/class-ads.php';

/**
 * post submit from Front
 */
require get_template_directory() . '/inc/class-submit.php';

/**
 * metabox for ad post
 */
require get_template_directory() . '/inc/class-metabox.php';

/**
 * download post functions
 */
require get_template_directory() . '/inc/class-download-metabox.php';
require get_template_directory() . '/inc/class-download-function.php';

/**
 * support woocommerce
 */
require get_template_directory() . '/inc/class-woocommerce.php';

/**
 * Integrate Lazyload
 */
require get_template_directory() . '/inc/class-images.php';

/**
 * Relpace Gravatar
 */
require get_template_directory() . '/inc/class-avatar.php';

/**
 * Cunstom Comments
 */
require get_template_directory() . '/inc/class-comments.php';

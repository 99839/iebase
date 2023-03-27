<?php

/**
 *Name:  WordPress funtoion
 */
function wp_footers() {
    // the html button which will be added to wp_footer ?>
    <div class="progress-wrap">
    <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
       <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
    </svg>
    </div>
    <?php
}
add_action( 'wp_footer',  'wp_footers' , 0);

/**
 *Single Post Meta
 */
function iebase_single_post_meta() {
	global $post;
	$download_items = get_post_meta( $post->ID, 'iebase_download_items', true );
	?>
    <header class="s-post__title">
	<?php if ( has_category() && empty($download_items) ) : ?>
          <div class="ie-categories" itemprop="about">
            <?php the_category(' '); ?>
          </div>
        <?php endif; ?>
    <h1 class="ie-post__title" itemprop="headline"><?php the_title(); ?></h1>
       <?php iebase_entry_meta(); ?>
    </header>
	<?php
}
add_action( 'iebase_single_post_start', 'iebase_single_post_meta' ,10 ,3 );


/**
 *CUSTOM CSS OUTPUT
 */
  add_action( 'wp_head', 'iebase_print_css' );
  function iebase_print_css(){

	  /* Var */
	  $css = '';
	  $body_font = get_theme_mod( 'font_secondary', '-apple-system, BlinkMacSystemFont, "Noto Sans", Helvetica, Arial, sans-serif' );
	  $headings_font = get_theme_mod( 'font_primary', '-apple-system, BlinkMacSystemFont, "Microsoft YaHei", Helvetica, Arial, sans-serif' );
	  $custom_css = get_theme_mod( 'custom_css' );

	  /* Link Color: Only if it's not the default. */
	  if ( '-apple-system, BlinkMacSystemFont, "Noto Sans", Helvetica, Arial, sans-serif' != $body_font ){
		  $css .= "body{font-family:{$body_font}}";
	  }

	  /* Site Title Color */
	  if ( '-apple-system, BlinkMacSystemFont, "Microsoft YaHei", Helvetica, Arial, sans-serif' != $headings_font ){
		  $css .= "h1, h2, h3, h4, h5, h6{font-family: {$headings_font}; }";
	  }

	  /*Custom CSS*/
	  if (''!= $custom_css){
		  $css .="$custom_css";
	  }

	  /* Print it. */
	  if ( !empty( $css ) ){
		  echo "\n" . '<style type="text/css" id="custom-css">' . trim( $css ) . '</style>' . "\n";
	  }
  }


/**
 * Ajax comments
 */
add_action( 'wp_ajax_ajaxcomments', 'iebase_submit_ajax_comment' ); // wp_ajax_{action} for registered user
add_action( 'wp_ajax_nopriv_ajaxcomments', 'iebase_submit_ajax_comment' ); // wp_ajax_nopriv_{action} for not registered users

function iebase_submit_ajax_comment(){
	/*
	 * Wow, this cool function appeared in WordPress 4.4.0, before that my code was muuuuch mooore longer
	 *
	 * @since 4.4.0
	 */
	$comment = wp_handle_comment_submission( wp_unslash( $_POST ) );
	if ( is_wp_error( $comment ) ) {
		$error_data = intval( $comment->get_error_data() );
		if ( ! empty( $error_data ) ) {
			wp_die( '<p>' . $comment->get_error_message() . '</p>', __( 'Comment Submission Failure' ), array( 'response' => $error_data, 'back_link' => true ) );
		} else {
			wp_die( 'Unknown error' );
		}
	}

	/*
	 * Set Cookies
	 */
	$user = wp_get_current_user();
	do_action('set_comment_cookies', $comment, $user);

	/*
	 * If you do not like this loop, pass the comment depth from JavaScript code
	 */
	$comment_depth = 1;
	$comment_parent = $comment->comment_parent;
	while( $comment_parent ){
		$comment_depth++;
		$parent_comment = get_comment( $comment_parent );
		$comment_parent = $parent_comment->comment_parent;
	}

 	/*
 	 * Set the globals, so our comment functions below will work correctly
 	 */
	$GLOBALS['comment'] = $comment;
	$GLOBALS['comment_depth'] = $comment_depth;

	/*
	 * Here is the comment template, you can configure it for your website
	 * or you can try to find a ready function in your theme files
	 */
	$comment_html = '<li ' . comment_class('', null, null, false ) . ' id="comment-' . get_comment_ID() . '">
		<article class="comment-body" id="div-comment-' . get_comment_ID() . '">
			<footer class="comment-meta">
				<div class="comment-author vcard">
					' . get_avatar( $comment, 100 ) . '
					<b class="fn">' . get_comment_author_link() . '</b> <span class="says">says:</span>
				</div>
				<div class="comment-metadata">
					<a href="' . esc_url( get_comment_link( $comment->comment_ID ) ) . '">' . sprintf('%1$s at %2$s', get_comment_date(),  get_comment_time() ) . '</a>';

					if( $edit_link = get_edit_comment_link() )
						$comment_html .= '<span class="edit-link"><a class="comment-edit-link" href="' . $edit_link . '">Edit</a></span>';

				$comment_html .= '</div>';
				if ( $comment->comment_approved == '0' )
					$comment_html .= '<p class="comment-awaiting-moderation">Your comment is awaiting moderation.</p>';

			$comment_html .= '</footer>
			<div class="comment-content">' . apply_filters( 'comment_text', get_comment_text( $comment ), $comment ) . '</div>
		</article>
	</li>';
	echo $comment_html;

	die();

}

/**
 * comments link
 */
add_filter( 'get_comments_link', function( $link, $post_id )
{
    $hash = get_comments_number( $post_id ) ? '#comments' : '#comments';
    return get_permalink( $post_id ) . $hash;

}, 10, 2 );

/**
 * Add lighbox for content images
 */
function iebase_img_tag_add_lightbox( $filtered_image, $context, $attachment_id ) {
	$ids = 'lightbox';

	$filtered_image = str_replace( '<img ', '<img id="' . $ids . '" ', $filtered_image );

	return $filtered_image;
}
add_filter( 'wp_content_img_tag', 'iebase_img_tag_add_lightbox', 10, 3 );
/**
 * Add use center in header
 */
add_action( 'iebase_menu_action', 'user_nav' );
function user_nav(){
	if ( ! function_exists( 'IE_Users' ) ) {
		return ;
	}
	$is_logged_in = is_user_logged_in();
	$user =  wp_get_current_user();
	$link =  IE_Users()->get_profile_link( $user );
	global $wp;
	global $post;
	//$postid = $post->ID;
	//$log_out_me = wp_logout_url( get_permalink($postid) );
	//$log_out_me = wp_logout_url( get_permalink() );
    $log_out_me = wp_logout_url( home_url( $wp->request ) );

	// Check if WP_Users Plugin is actived
	if ( function_exists( 'IE_Users' ) ) {
		?>
				<li class="menu-item"><a data-is-logged="<?php echo is_user_logged_in() ? 'true' : 'false'; ?>" class="ieu-login-btn" href="<?php echo IE_Users()->get_profile_link(); ?>"><?php echo ( $is_logged_in ) ?  esc_html__( 'Dashboard', 'iebase' ) :  esc_html__( 'Login', 'iebase' ); ?></a></li>
				<?php if ( $is_logged_in ) { ?>
				<li class="menu-item"><a class="ieu-logout-btn" href="<?php echo $log_out_me; ?>"><?php esc_html_e( 'Sign Out', 'iebase' ); ?></a></li>
				<?php } ?>
		<?php
	}
}

/**
 * blogroll block
 */
if(!empty(get_theme_mod( 'enable_blogroll' )) && get_theme_mod( 'enable_blogroll' ) == "1") {
add_filter( 'pre_option_link_manager_enabled', '__return_true' );

if (!function_exists('iebase_home_link')) {
	function iebase_home_link() {
		$link = get_theme_mod( 'show_link_section', '1' );
		$more = get_theme_mod( 'add_link_page', '' );
		?>
		<?php if ( is_home() && !is_paged() && $link == 1):?>
			 <div class="e-grid c-link-block">
				 <ul class="link-home">
				   <li class="link-title"><?php esc_html_e("Site Link:", 'iebase'); ?></li>
				   <?php wp_list_bookmarks('link_before=<span>&link_after=</span>&categorize=0&title_li=0&show_images=0&limit=10&orderby=rand'); ?>
					<?php if ( $more != 0):?>
					<li><a href="<?php echo get_page_link( $more ); ?>"><span><?php esc_html_e("All Links", 'iebase'); ?></span></a></li>
					<?php endif;?>
				 </ul>
			 </div>
		<?php endif;?>
		<?php
	}
	add_action( 'iebase_footer_bottom_content', 'iebase_home_link' );
}
}

/**
 * Add bookmarks shortcode
 */
function get_the_link_items($id = null){
    $bookmarks = get_bookmarks('orderby=rand&category=' .$id );
    $output = '';
    if ( !empty($bookmarks) ) {
        $output .= '<ul class="c-link-block link-shortcode">';
        foreach ($bookmarks as $bookmark) {
            $output .=  '<li class="link-item"><a href="' . $bookmark->link_url . '" title="' . $bookmark->link_description . '" target="_blank" >'. $bookmark->link_name .'</a></li>';
        }
        $output .= '</ul>';
    }
    return $output;
}

function get_link_items(){
	$linkcats = get_terms( 'link_category' );
	$result = '';
    if ( !empty($linkcats) ) {
        foreach( $linkcats as $linkcat){
            $result .=  '<h3 class="link-title">'.$linkcat->name.'</h3>';
            if( $linkcat->description ) $result .= '<div class="link-description">' . $linkcat->description . '</div>';
            $result .=  get_the_link_items($linkcat->term_id);
        }
    } else {
        $result = get_the_link_items();
    }
    return $result;
}

function shortcode_link(){
    return get_link_items();
}
add_shortcode('link', 'shortcode_link');

/**
 * Add shortcode archive
 */
add_shortcode( 'archive', 'shortcode_archive' );
function shortcode_archive() {
	?>
    <div class="list-archive-wrapper">
            <?php
            $args = array(
                'posts_per_page' => -1,
                'post_type' => array('post'),
                'ignore_sticky_posts' => 1,
            );
            $the_query = new WP_Query( $args );
            $year=0;
            $mon=0;
            $all = array();
            $output = '';
            $i= 0;
            while ( $the_query->have_posts() ) : $the_query->the_post();
                $i++;
                $year_tmp = get_the_time('Y');
                $mon_tmp = get_the_time('n');
                $y = $year;
                $m = $mon;
                if ($mon != $mon_tmp && $mon > 0) $output .= '</ul></div>';
                if ($year != $year_tmp) {
                    $year = $year_tmp;
                    $all[$year] = array();
                }
                if ($mon != $mon_tmp) {
                    $i = 0;
                    $mon = $mon_tmp;
                    $output .= "<div class='list list__archive'><h3 class='month-title'>" . $year . ' - ' . $mon . '</h3>'  . "<ul class='archive-is-ordered'>" ;
                }
                $output .= '<li class="archive-item"><a class="archive-item-title" href="'.get_permalink() .'">' . get_the_title() . '</a></li>';
            endwhile;
            wp_reset_postdata();
            $output .= '</ul></div>';
            echo $output;      ?>
        </div>
	<?php
}

/**
 * Add shortcode tagcloud
 */
add_shortcode('tagcloud', 'shortcode_tag_cloud');
function shortcode_tag_cloud() {
	?>
    <div class="tagcloud">
      <?php wp_tag_cloud('orderby=count&order=DESC'); ?>
    </div>
	<?php
}

/**
 * Add no result page block
 */
add_action( 'iebase_no_search_below_content', 'iebase_search_related' );
function iebase_search_related() {
	?>
    <?php
      $args = array(
        'post_type'           => 'post',
		'post_status'         => 'publish',
		'orderby'             => 'rand',
        'posts_per_page'      => 6,
        'ignore_sticky_posts' => 1
       );
      $query = new WP_Query( $args );
    ?>

    <?php if ( $query->have_posts() ) : ?>

    <div class='e-grid'>
      <div class="e-grid__col e-grid__col--full">
        <hr>
        <h4><?php esc_html_e( 'You Might Be Interested In', 'iebase' ); ?></h4>
      </div>
    </div>

    <div class='e-grid'>
      <?php while ( $query->have_posts() ) : $query->the_post(); ?>

        <?php get_template_part( 'template-parts/post-card' ); ?>

      <?php endwhile; wp_reset_postdata(); ?>
    </div>

  <?php endif; ?>
  <?php
}

/**
 * Add home site features block
 */
add_action( 'iebase_home_loop_start', 'iebase_home_features', 2 );
function iebase_home_features() {
	$features         = get_theme_mod( 'enable_feature', '1' );
	$feature_title_1  = get_theme_mod( 'feature_one_title', '' );
	$feature_icon_1   = get_theme_mod( 'feature_one_icon', '' );
	$feature_desc_1   = get_theme_mod( 'feature_one_desc', '' );
	$feature_title_2  = get_theme_mod( 'feature_two_title', '' );
	$feature_icon_2   = get_theme_mod( 'feature_two_icon', '' );
	$feature_desc_2   = get_theme_mod( 'feature_two_desc', '' );
	$feature_title_3  = get_theme_mod( 'feature_three_title', '' );
	$feature_icon_3   = get_theme_mod( 'feature_three_icon', '' );
	$feature_desc_3   = get_theme_mod( 'feature_three_desc', '' );
	?>

    <?php if ( $features==1 ) : ?>
    <div id="feature" class="e-grid js-grid">
	<?php if ( !empty($feature_title_1) ): ?>
	    <div class="e-grid__col e-grid__col--4-4-s e-grid__col--2-4-m e-grid__col--1-3-l ie-post-card-wrap js-post-card-wrap ie_feature">
	        <div class="ie-post-card e-grid-feature">
	            <i class="iecon-<?php echo $feature_icon_1 ;?>"></i>
	            <h4><?php echo $feature_title_1 ;?></h4>
	            <p><?php echo $feature_desc_1 ;?></p>
	        </div>
	    </div>
	<?php endif; ?>
	<?php if ( !empty($feature_title_2) ): ?>
	    <div class="e-grid__col e-grid__col--4-4-s e-grid__col--2-4-m e-grid__col--1-3-l ie-post-card-wrap js-post-card-wrap ie_feature">
	        <div class="ie-post-card e-grid-feature">
	            <i class="iecon-<?php echo $feature_icon_2 ;?>"></i>
	            <h4><?php echo $feature_title_2 ;?></h4>
	            <p><?php echo $feature_desc_2 ;?></p>
	        </div>
	    </div>
	<?php endif; ?>
	<?php if ( !empty($feature_title_3) ): ?>
	    <div class="e-grid__col e-grid__col--4-4-s e-grid__col--2-4-m e-grid__col--1-3-l ie-post-card-wrap js-post-card-wrap ie_feature">
	        <div class="ie-post-card e-grid-feature">
	            <i class="iecon-<?php echo $feature_icon_3 ;?>"></i>
	            <h4><?php echo $feature_title_3 ;?></h4>
	            <p><?php echo $feature_desc_3 ;?></p>
	        </div>
	   </div>
	<?php endif; ?>
    </div>

    <?php endif; ?>
  <?php
}

/**
 * Add home loop title
 */
add_action( 'iebase_post_loop_start', 'iebase_loop_title', 3 );
function iebase_loop_title() {
	$loop_block         = get_theme_mod( 'main_loop_block', '1' );
	$loop_title         = get_theme_mod( 'main_loop_title', '' );
	$loop_caption       = get_theme_mod( 'main_loop_caption', '' );
	?>
    <?php if ( $loop_block==1 && is_home() && !is_paged()) : ?>
      <div class="e-grid__col e-grid__col--full">
        <h2 class='post-block maintitle'><span><?php echo $loop_title ;?></span></h2>
		<p class="post-block maindesc"><?php echo $loop_caption ;?></p>
	  </div>
	<?php endif; ?>
  <?php
}

/**
 * Add Download and Demo page section
 */
add_action( 'dd_footer_section', 'iebase_recommend_posts', 3 );
function iebase_recommend_posts() {
	$recommend         = get_theme_mod( 'recommend_posts', '1' );
    $the_query = new WP_Query( array(
	   'post_type'      => 'post',
	   'orderby'        => 'rand',
	   'posts_per_page' => 5,
    ) ); ?>
    <?php
    if ( $recommend==1 && $the_query->have_posts() ) : ?>
	<div class="recommend_posts">
		<h3><?php _e( 'Recommend', 'iebase' ); ?></h3>
		<ul>
			<?php
			while ( $the_query->have_posts() ) : $the_query->the_post();  ?>
				<li><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></li>
			<?php endwhile; ?>
			<?php wp_reset_postdata(); ?>
		</ul>
	</div>
    <?php endif; ?>
	<?php
}

add_action( 'dd_footer_section', 'iebase_sponsor_posts', 3 );
function iebase_sponsor_posts() {
	$sponsor         = get_theme_mod( 'sponsor_url', '' );
	include_once( ABSPATH . WPINC . '/feed.php' );
    $rss = fetch_feed( $sponsor );
    $maxitems = 0;
    if ( ! is_wp_error( $rss ) ) :
    $maxitems = $rss->get_item_quantity( 5 );
    $rss_items = $rss->get_items( 0, $maxitems );
    endif;
	?>
	<?php
    if ( ! empty( $sponsor ) ) : ?>
	<div class="sponsor_posts">
	<h3><?php _e( 'Sponsor', 'iebase' ); ?></h3>
	<ul>
    <?php if ( $maxitems == 0 ) : ?>
        <li><?php _e( 'No items', 'iebase' ); ?></li>
    <?php else : ?>
        <?php // Loop through each feed item and display each item as a hyperlink. ?>
        <?php foreach ( $rss_items as $item ) : ?>
            <li><a href="<?php echo esc_url( $item->get_permalink() ); ?>" title="<?php printf( __( 'Posted %s', 'iebase' ), $item->get_date('j F Y | g:i a') ); ?>"><?php echo esc_html( $item->get_title() ); ?></a>
            </li>
        <?php endforeach; ?>
    <?php endif; ?>
	<?php endif; ?>
	<?php
}

/**
 *link Post Meta
 */
function iebase_link_post_meta() {
	global $post;
	$ad_url = get_post_meta( get_the_ID(), 'iebase_ad_url', true );
    $button_value = get_post_meta( get_the_ID(), 'iebase_ad_button_value', true );
    $extra = get_post_meta( get_the_ID(), 'iebase_ad_extra_field', true );
    $sponsored = get_post_meta( get_the_ID(), 'iebase_sponsored_text', true );
	?>
	<?php if ( $ad_url && 'link' == get_post_format()) : ?>
    <div class="sponsored-box">
	<?php if ( $extra ) : ?>
        <div class="ponsored-text"><?php echo $extra; ?></div>
    <?php endif; ?>
    <?php if ( $button_value ) : ?>
        <div class="ponsored-button"><a href="<?php echo $ad_url; ?>" class="ie-buttons shortc-button blue" target="_blank"><?php echo $button_value; ?></a></div>
    <?php endif; ?>
	</div>
<?php endif; ?>
	<?php
}
add_action( 'iebase_single_content_start', 'iebase_link_post_meta' ,10 ,3 );

/**
 *Copyright
 */
/**
 *link Post Meta
 */
function iebase_post_copyright() {
	global $post;
	$post_id = get_post_meta( get_the_ID(), 'iebase_post_post_url', true );
	$post_author = esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) );
	$author_id = $post->post_author;
	$author = get_the_author_meta( 'nicename', $author_id );
	$blog_title = get_bloginfo( 'name' );
	$post_url = get_permalink($post->ID);
	?>
	<div class="cr-content"><span class="iecon-bookmark"></span>
	<div class="cr-right">
	<p><?php
	printf( __( 'This article was published on <strong>%3$s</strong> by <a href="%1$s">%2$s</a>', 'iebase'), $post_author , $author , $blog_title
    ); ?></p>
	<?php
	if( !empty( $post_id) ){
	   printf( __( '<p>Article via URL: %1$s</p>','iebase' ), $post_id); }
    else {
		printf( __( '<p>Article via URL: %1$s</p>','iebase' ), $post_url);}
	?>
	</div>
    </div>
	<?php
}
add_action( 'iebase_single_content_end', 'iebase_post_copyright' ,10 ,3 );

/**
 * Modify the "must_log_in" string of the comment form.
 */
add_filter( 'comment_form_defaults', function( $fields ) {
    $fields['must_log_in'] = sprintf(
        __( '<p class="must-log-in">
                 You must <a href="%s" class="ieu-login-btn">Register</a>or
                 <a href="%s" class="ieu-login-btn">Login</a> to post a comment</p>', 'iebase'

        ),
        wp_registration_url(),
        wp_login_url( apply_filters( 'the_permalink', get_permalink() ) )
    );
    return $fields;
});

/**
* Display navigation to next/previous comments when applicable.
*
* @since 1.0.0
*/
if ( ! function_exists( 'iepress_comment_nav' ) ) :
function iepress_comment_nav() {
	// Are there comments to navigate through?
	if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
	?>
	<nav class="navigation comment-navigation" role="navigation">
		<h2 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'iepress' ); ?></h2>
		<div class="nav-links">
			 <?php paginate_comments_links( ); ?>
		</div>
	</nav>
	<?php
	endif;
}
endif;

add_filter( 'get_the_archive_title', 'iebase_archive_title' );
/**
 * Remove archive labels.
 *
 * @param  string $title Current archive title to be displayed.
 * @return string        Modified archive title to be displayed.
 */
function iebase_archive_title( $title ) {
	if ( is_category() ) {
		$title = single_cat_title( '', false );
	} elseif ( is_tag() ) {
		$title = single_tag_title( '', false );
	} elseif ( is_author() ) {
		$title = '<span class="vcard">' . get_the_author() . '</span>';
	} elseif ( is_post_type_archive() ) {
		$title = post_type_archive_title( '', false );
	} elseif ( is_tax() ) {
		$title = single_term_title( '', false );
	} elseif ( is_home() ) {
		$title = single_post_title( '', false );
	}

	return $title;
}

/**
 * Add moderm cursor.
 *
 * @since   1.0
 * @access  public
 * @param   string $type
 */
function iebase_modern_cursor(){
    $html = '';
    $html .= '<div class="mouse-cursor cursor-outer"></div>';
    $html .= '<div class="mouse-cursor cursor-inner"></div>'. PHP_EOL;
    echo $html;
}
add_action('wp_head', 'iebase_modern_cursor');
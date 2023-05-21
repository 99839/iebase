<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Iebase
 */

/**
 * Adds `ie-header--no-cover` custom class if site cover exist
 */
function iebase_header_class() {
  $classes = '';

  if ( is_home() && !has_header_image() ) {
    $classes = 'ie-header--no-cover';
  }

  if ( is_search() ) {
    $classes = 'ie-header--no-cover';
  }

  if ( is_archive() || is_tag() || is_category() ) {
    $classes = 'ie-header--no-cover';
  }

  if ( is_paged() ) {
    $classes = 'ie-header--no-cover';
  }

  if ( is_404() ) {
    $classes = 'ie-header--no-cover';
  }

  return $classes;
}

/**
 * Calculate reaad time
 */
if(!function_exists('ie_calculate_reading_time')){
	function ie_calculate_reading_time($postID = false, $echo = false) {
		$wpm = 250;
		if(!$postID){
			$postID = get_the_ID();
		}
		$include_shortcodes = true;
		$exclude_images = false;
		$tmpContent = get_post_field('post_content', $postID);
		$number_of_images = substr_count(strtolower($tmpContent), '<img ');
		if ( ! $include_shortcodes ) {
			$tmpContent = strip_shortcodes($tmpContent);
		}
		$tmpContent = strip_tags($tmpContent);
		$wordCount = str_word_count($tmpContent);

		if ( !$exclude_images ) {

			$additional_words_for_images = ie_calculate_images( $number_of_images, $wpm );
			$wordCount += $additional_words_for_images;
		}

		$wordCount = apply_filters( 'ie_filter_wordcount', $wordCount );

		$readingTime = ceil($wordCount / $wpm);

		// If the reading time is 0 then return it as < 1 instead of 0.
		if ( $readingTime < 1 ) {
			$readingTime = esc_html__('< 1 min read', 'iebase');
		} elseif($readingTime == 1) {
			$readingTime = esc_html__('1 min read', 'iebase');
		} else {
			$readingTime = $readingTime.' '.esc_html__('mins read', 'iebase');
		}

		if($echo){ 
			echo $readingTime;
		} else {
			return $readingTime;
		}
	}
}

if(!function_exists('ie_calculate_images')){
	function ie_calculate_images( $total_images, $wpm ) {
		$additional_time = 0;
		// For the first image add 12 seconds, second image add 11, ..., for image 10+ add 3 seconds
		for ( $i = 1; $i <= $total_images; $i++ ) {
			if ( $i >= 10 ) {
				$additional_time += 3 * (int) $wpm / 60;
			} else {
				$additional_time += (12 - ($i - 1) ) * (int) $wpm / 60;
			}
		}

		return $additional_time;
	}
}

/* Excerpt Optimize
/***********************************************************************/
add_filter( 'get_the_excerpt', 'iebase_filter_chinese_excerpt' );

function iebase_filter_chinese_excerpt( $output ) {
	global $post;
	$length = 100;
	//check if its chinese character input
	$chinese_output = preg_match_all("/\p{Han}+/u", $post->post_content, $matches);
	if($chinese_output) {
	$output = mb_substr( $output, 0, $length/2 ) . '...';
	}
	else{
	$output = mb_substr( $output, 0, $length ) . '...';
	}
	return $output;
}

/** 
 * social names
 */
if ( !function_exists( 'iebase_social_names' ) ) {
	function iebase_social_names() {

		$account_names = array(
			'facebook',
			'twitter',
			'weibo',
			'qq',
			'pinterest',
			'google',
			'linkedin'
		);

		return $account_names;

	}
}
/* Social Icons */
if ( !function_exists( 'iebase_social_labels' ) ) {
	function iebase_social_labels() {

		$labels = array(
			esc_html__( 'Facebook', 'iebase' ),
			esc_html__( 'Twitter', 'iebase' ),
			esc_html__( 'Weibo', 'iebase' ),
			esc_html__( 'QQ', 'iebase' ),
			esc_html__( 'Pinterest', 'iebase' ),
			esc_html__( 'Google+', 'iebase' ),
			esc_html__( 'LinkedIn', 'iebase' )	
		);

		return $labels;

	}
}

if ( !function_exists( 'iebase_social_icons' ) ) {
	function iebase_social_icons() {

		$icons = array(
			'facebook',
			'twitter',
			'weibo',
			'qq',
			'pinterest',
			'google-plus',
			'linkedin'
		);

		return $icons;

	}
}

/**
 * Add numerical words to numbers
 */
function iebase_numerical_word( $number ) {

	if ( $number < 1000 ) {
		return $number;
	} else if ( $number <= 1000000 ) {
		$scale_to = 1000;
		$suffix = esc_html__( 'k', 'iebase' );
	} else {
		$scale_to = 1000000;
		$suffix = esc_html__( 'M', 'iebase' );
	}

	$precision = 1;
	$multiple = pow( 10, $precision );
	$number = round( ( $number / $scale_to ) * $multiple ) / $multiple;

	return sprintf( '%1$s%2$s', $number, $suffix );
}

/**
 * custom js in footer
 */
if (!function_exists('iebase_custom_script')) {
    function iebase_custom_script() {
        $custom_js = get_theme_mod('custom_js');
        if ($custom_js) {
            echo'<script type ="text/javascript">';
            echo ''.$custom_js;
            echo '</script>';
        }
    }
    add_action('wp_footer', 'iebase_custom_script' ,1);
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

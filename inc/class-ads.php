<?php
/**
 * Ad Render
 *
 */
if (!function_exists('iebase_home_banner_content')){
	function iebase_home_banner_content() {
	  $banner      = get_theme_mod( 'banner_home_display', '0' );
	  $banner_url  = get_theme_mod( 'home_banner_url', '' );
	  $banner_text = get_theme_mod( 'banner_learn_more', '' );
	  $caption     = get_theme_mod( 'banner_caption', '' );
	  $banner_img  = get_theme_mod( 'home_banner_image', '' );
	  ?>
	  <?php if ( $banner==1 ) : ?>
	  <div id="banner" class="e-grid js-grid">
	    <div class="e-grid__col e-grid__col--center e-grid__col--4-4-s ie-post-card-wrap js-post-card-wrap ie_banner">
		  <?php if ( !empty($banner_text) ): ?> 
			<div class="ie-banner js-fadein ie-post-card__image is-inview full-visible" style='background-image: url(<?php echo ($banner_img); ?>)'>
			<div class="ie-banner__content">
				<?php if ( !empty($caption) ): ?>
				  <div class="banner-caption"><?php echo $caption;?></div>
				<?php endif; ?>
			    <a href="<?php echo $banner_url;?>" class="banner ie-btn" target="_blank"><?php echo $banner_text;?></a>
		    </div>
			</div>
		  <?php endif; ?>
		</div>
	  </div>
      <?php endif; ?>
	  <?php
	}
	add_action( 'iebase_home_loop_start', 'iebase_home_banner_content', 4 );
}

/**
 * Add Ad in Download and Demo
 */
if (!function_exists('iebase_dd_top_content')){
	function iebase_dd_top_content() {
	  $dd_top_code      = get_theme_mod( 'dd_page_top_code', '' );
	  if( $dd_top_code )
		echo '<p class="bb-top ads-wrapper">'. stripslashes($dd_top_code) .'</p>';
	}
	
	add_action( 'dd_loop_start', 'iebase_dd_top_content', 1 );
}

if (!function_exists('iebase_dd_bottom_content')){
	function iebase_dd_bottom_content() {
	  $dd_bottom_code      = get_theme_mod( 'dd_page_bottom_code', '' );
	  if( $dd_bottom_code )
		echo '<p class="bb-bottom ads-wrapper">'. stripslashes($dd_bottom_code) .'</p>';
	}
	
	add_action( 'dd_loop_end', 'iebase_dd_bottom_content', 1 );
}

/**
 * Add Random Ad in homepage
 */
if(!empty(get_theme_mod( 'ads_home_select')) && get_theme_mod( 'ads_home_select') == "1") {
	add_action( 'loop_start', 'iebase_loop_start' );
}
//add_action( 'loop_start', 'iebase_loop_start' );

function iebase_loop_start( $query )
{
    if( $query->is_home() && $query->is_main_query() )
    {
        add_action( 'the_post', 'iebase_the_post' );
        add_action( 'loop_end', 'iebase_loop_end' );
    }
}

function iebase_the_post()
{
	static $nr = 0;
	
	$home_ads = get_theme_mod( 'ads_home_code');
	$if_mobile_ads = get_theme_mod( 'home_mobile_ads');

	if( wp_is_mobile() && $if_mobile_ads==1 ){ 
		if( 0 === ++$nr % 3 )
        echo '<div class="e-grid__col e-grid__col--4-4-s e-grid__col--2-4-m e-grid__col--1-3-l ie-post-card-wrap js-post-card-wrap">'. stripslashes($home_ads) .'</div>';
	}else if ($if_mobile_ads==0){

    if( 0 === ++$nr % 3 )
		echo '<div class="e-grid__col e-grid__col--4-4-s e-grid__col--2-4-m e-grid__col--1-3-l ie-post-card-wrap js-post-card-wrap">'. stripslashes($home_ads) .'</div>';
	}
}

function iebase_loop_end()
{
    remove_action( 'the_post', 'iebase_the_post' );   
} 


if (!function_exists('iebase_ads_content') ) :

	/**
	 *single ads managment
	 */
	function iebase_ads_content ($content) {
		global $post;

		$logg_in      = get_theme_mod( 'hide_ad_logg_in', '0' );
		$top_style    = get_theme_mod( 'ads_top_style', '' );
        $bottom_style = get_theme_mod( 'ads_bottom_style', '' );
        $middle_style = get_theme_mod( 'ads_middle_style', '' );
        $p1_style     = get_theme_mod( 'ads_paragraph1_style', '' );
        $p2_style     = get_theme_mod( 'ads_paragraph2_style', '' );
		$p3_style     = get_theme_mod( 'ads_paragraph3_style', '' );
		$p1_num       = get_theme_mod( 'post_paragraph1_num', '' );
        $p2_num       = get_theme_mod( 'post_paragraph2_num', '' );
        $p3_num       = get_theme_mod( 'post_paragraph3_num', '' );
		$top          = get_theme_mod( 'ads_single_post_top', '' );
		$top_code     = get_theme_mod( 'single_post_top_code', '' );
		$bottom       = get_theme_mod( 'ads_single_post_bottom', '' );
		$bottom_code  = get_theme_mod( 'single_post_bottom_code', '' );
		$middle       = get_theme_mod( 'ads_single_post_middle', '' );
		$middle_code  = get_theme_mod( 'single_post_middle_code', '' );
		$p1           = get_theme_mod( 'ads_single_post_paragraph1', '' );
		$p1_code      = get_theme_mod( 'single_post_paragraph1_code', '' );
		$p2           = get_theme_mod( 'ads_single_post_paragraph2', '' );
		$p2_code      = get_theme_mod( 'single_post_paragraph2_code', '' );
		$p3           = get_theme_mod( 'ads_single_post_paragraph3', '' );
		$p3_code      = get_theme_mod( 'single_post_paragraph3_code', '' );
		$mobile_top   = get_theme_mod('single_post_top_mobile_ads', '' );
        $mobile_bot   = get_theme_mod('single_post_bottom_mobile_ads', '' );
        $mobile_mid   = get_theme_mod('single_post_middle_mobile_ads', '' );
        $mobile_p1    = get_theme_mod('single_post_paragraph1_mobile_ads', '' );
        $mobile_p2    = get_theme_mod('single_post_paragraph2_mobile_ads', '' );
		$mobile_p3    = get_theme_mod('single_post_paragraph3_mobile_ads', '' );
		$type         = get_post_meta($post->ID, 'post_option_post-type', true);

		//global $post;
		
		if ( is_singular('post') /*|| is_page() */) {

			if ( is_user_logged_in () && $logg_in || $type==true || 'link' == get_post_format()) {
				return $content;
			}
			
			//if (  $age >= $show_ad_age ) {

            if( wp_is_mobile() && $mobile_top==1 ){  
				if ( $top && $top_code ) {
					$content = '<div class="ads top-single '. $top_style .'">' . $top_code . '</div>' . $content;
				}
			}else if ($mobile_top==0){	
				if ( $top && $top_code ) {
					$content = '<div class="ads top-single '. $top_style .'">' . $top_code . '</div>' . $content;
				}
			}

            if( wp_is_mobile() && $mobile_mid==1 ){  
				if ( $middle  && $middle_code ) {
					$insert_code = '<div class="ads middle-single '. $middle_style .'">' . $middle_code . '</div>';
					$content =  iebase_insert_after_paragraph($insert_code, $content, 0, true);
				}
			}else if ($mobile_mid==0){
				if ( $middle  && $middle_code ) {
					$insert_code = '<div class="ads middle-single '. $middle_style .'">' . $middle_code . '</div>';
					$content =  iebase_insert_after_paragraph($insert_code, $content, 0, true);
				}
			}			
			
			if( wp_is_mobile() && $mobile_bot==1 ){  
				if ( $bottom && $bottom_code ) {
					$content = $content . '<div class="ads below-single '. $bottom_style .'">' . $bottom_code . '</div>';
				}
			}else if ($mobile_bot==0){
				if ( $bottom && $bottom_code ) {
					$content = $content . '<div class="ads below-single '. $bottom_style .'">' . $bottom_code . '</div>';
				}
			}	

			// Paragaph 1
			if( wp_is_mobile() && $mobile_p1==1 ){  	
				if ( $p1 && $p1_code ) {
					$insert_code = '<div class="ads paragrap-single '. $p1_style .'">' . $p1_code . '</div>';
				    $content =  iebase_insert_after_paragraph($insert_code, $content , $p1_num/*, $theme_options[ 'ads_after_paragraph_num1' ]*/ );
				}
			}else if ($mobile_p1==0){
				if ( $p1 && $p1_code ) {
					$insert_code = '<div class="ads paragrap-single '. $p1_style .'">' . $p1_code . '</div>';
				    $content =  iebase_insert_after_paragraph($insert_code, $content , $p1_num/*, $theme_options[ 'ads_after_paragraph_num1' ]*/ );
				}
			}	

			// Paragaph 2
			if( wp_is_mobile() && $mobile_p2==1 ){  	
				if ( $p2 && $p2_code ) {
					$insert_code = '<div class="ads paragrap-single-ads '. $p2_style .'">' . $p2_code . '</div>';
				    $content =  iebase_insert_after_paragraph($insert_code, $content , $p2_num/*, $theme_options[ 'ads_after_paragraph_num2' ]*/ );
				}
			}else if ($mobile_p2==0){
				if ( $p2 && $p2_code ) {
					$insert_code = '<div class="ads paragrap-single-ads '. $p2_style .'">' . $p2_code . '</div>';
				    $content =  iebase_insert_after_paragraph($insert_code, $content , $p2_num/*, $theme_options[ 'ads_after_paragraph_num2' ]*/ );
				}	
			}

			// Paragaph 3
			if( wp_is_mobile() && $mobile_p3==1 ){  
				if ( $p3 && $p3_code ) {
					$insert_code = '<div class="ads paragrap-single '. $p2_style .'">' . $p3_code . '</div>';
					$content =  iebase_insert_after_paragraph($insert_code, $content, $p3_num );
				}
			}else if ($mobile_p3==0){
				if ( $p3 && $p3_code ) {
					$insert_code = '<div class="ads paragrap-single '. $p2_style .'">' . $p3_code . '</div>';
					$content =  iebase_insert_after_paragraph($insert_code, $content, $p3_num );
				}
			}	
				
			}

		return $content;

		//} else {

		//	return $content;

		//}

	}

	add_filter('the_content', 'iebase_ads_content');

endif;

// Parent Function that makes the magic happen
 
function iebase_insert_after_paragraph( $insertion, $content, $paragraph_id = 1, $middle = false ) {

	$closing_p = '</p>';
	$paragraphs = explode( $closing_p, $content );

	if ( $middle == true ) {
		$paragraph_id = round(count($paragraphs)/2);
	}

	if ( $paragraph_id < 1 ) {

		$content = $insertion . $content;

	} else if ( $paragraph_id >= count($paragraphs)  ) {

		$content = $content . $insertion;

	} else {
		foreach ($paragraphs as $index => $paragraph) {

			if ( trim( $paragraph ) ) {
				$paragraphs[$index] .= $closing_p;
			}

			if ( $paragraph_id == $index + 1 ) {

				$paragraphs[$index] .= $insertion;
			}
		}

		$content = implode( '', $paragraphs );

	}

	
	return $content;
}
<?php
/*
	Plugin Name: Load More Posts
*/

add_action('wp_ajax_loadmore', 'ie_loadmore_ajax_handler'); // wp_ajax_{action}
add_action('wp_ajax_nopriv_loadmore', 'ie_loadmore_ajax_handler'); // wp_ajax_nopriv_{action}

function ie_loadmore_ajax_handler(){

	// prepare our arguments for the query
	$args = json_decode( stripslashes( $_POST['query'] ), true );
	$args['paged'] = $_POST['page'] + 1; // we need next page to be loaded
	$args['post_status'] = 'publish';

	// it is always better to use WP_Query but not here
	query_posts( $args );

	if( have_posts() ) :

		// run the loop
		while( have_posts() ): the_post();

			//get_template_part( 'template-parts/post/content', get_post_format() );
	    get_template_part( 'template-parts/post-card' );

		endwhile;
		iecore_paginator( $_POST['first_page'] );
	endif;
	die; // here we exit the script and even no wp_reset_query() required!
}

function iecore_paginator( $first_page_url ){

	// the function works only with $wp_query that's why we must use query_posts() instead of WP_Query()
	global $wp_query;
	
	$pagination_loop = get_theme_mod( 'pagination_post_loop' );

	// remove the trailing slash if necessary
	$first_page_url = untrailingslashit( $first_page_url );


	// it is time to separate our URL from search query
	$first_page_url_exploded = array(); // set it to empty array
	$first_page_url_exploded = explode("/?", $first_page_url);
	// by default a search query is empty
	$search_query = '';
	// if the second array element exists
	if( isset( $first_page_url_exploded[1] ) ) {
		$search_query = "/?" . $first_page_url_exploded[1];
		$first_page_url = $first_page_url_exploded[0];
	}

	// get parameters from $wp_query object
	// how much posts to display per page (DO NOT SET CUSTOM VALUE HERE!!!)
	$posts_per_page = (int) $wp_query->query_vars['posts_per_page'];
	// current page
	$current_page = (int) $wp_query->query_vars['paged'];
	// the overall amount of pages
	$max_page = $wp_query->max_num_pages;

	// we don't have to display pagination or load more button in this case
	if( $max_page <= 1 ) return;

	// set the current page to 1 if not exists
	if( empty( $current_page ) || $current_page == 0) $current_page = 1;

	// you can play with this parameter - how much links to display in pagination
	$links_in_the_middle = 4;
	$links_in_the_middle_minus_1 = $links_in_the_middle-1;

	// the code below is required to display the pagination properly for large amount of pages
	// I mean 1 ... 10, 12, 13 .. 100
	// $first_link_in_the_middle is 10
	// $last_link_in_the_middle is 13
	$first_link_in_the_middle = $current_page - floor( $links_in_the_middle_minus_1/2 );
	$last_link_in_the_middle = $current_page + ceil( $links_in_the_middle_minus_1/2 );

	// some calculations with $first_link_in_the_middle and $last_link_in_the_middle
	if( $first_link_in_the_middle <= 0 ) $first_link_in_the_middle = 1;
	if( ( $last_link_in_the_middle - $first_link_in_the_middle ) != $links_in_the_middle_minus_1 ) { $last_link_in_the_middle = $first_link_in_the_middle + $links_in_the_middle_minus_1; }
	if( $last_link_in_the_middle > $max_page ) { $first_link_in_the_middle = $max_page - $links_in_the_middle_minus_1; $last_link_in_the_middle = (int) $max_page; }
	if( $first_link_in_the_middle <= 0 ) $first_link_in_the_middle = 1;

	
	// begin to generate HTML of the pagination
	$pagination = '<nav id="ie_pagination" class="navigation pagination e-grid__col e-grid__col--center e-grid__col--4-4-s" role="navigation"><div class="nav-links">';
	
	if ( $pagination_loop == 'numeric' ){

	// when to display "..." and the first page before it
	if ($first_link_in_the_middle >= 2 && $links_in_the_middle < $max_page) {
		$pagination.= '<a href="'. $first_page_url . $search_query . '" class="page-numbers">1</a>'; // first page

		if( $first_link_in_the_middle != 2 )
			$pagination .= '<span class="page-numbers extend">...</span>';

	}

	// arrow left (previous page)
	if ($current_page != 1)
		$pagination.= '<a href="'. $first_page_url . '/page/' . ($current_page-1) . $search_query . '" class="prev page-numbers"><i class="pagination__icon iecon-chevron-left"></i></a>';


	// loop page links in the middle between "..." and "..."
	for($i = $first_link_in_the_middle; $i <= $last_link_in_the_middle; $i++) {
		if($i == $current_page) {
			$pagination.= '<span class="page-numbers current">'.$i.'</span>';
		} else {
			$pagination .= '<a href="'. $first_page_url . '/page/' . $i . $search_query .'" class="page-numbers">'.$i.'</a>';
		}
	}

	// arrow right (next page)
	if ($current_page != $last_link_in_the_middle )
		$pagination.= '<a href="'. $first_page_url . '/page/' . ($current_page+1) . $search_query .'" class="next page-numbers"><i class="pagination__icon iecon-chevron-right"></i></a>';


	// when to display "..." and the last page after it
	if ( $last_link_in_the_middle < $max_page ) {

		if( $last_link_in_the_middle != ($max_page-1) )
			$pagination .= '<span class="page-numbers extend">...</span>';

		$pagination .= '<a href="'. $first_page_url . '/page/' . $max_page . $search_query .'" class="page-numbers">'. $max_page .'</a>';
	}

	// end HTML
	
	}
 
	if ( $pagination_loop == 'loadmore' ){
	// haha, this is our load more posts link
	if( $current_page < $max_page )
		$pagination.= '<div id="ie_loadmore" class="ie-btn js-load-posts">' . esc_html__( 'More Posts', 'iebase' ) . '</div>';
		}
        $pagination.= "</div></nav>\n";
	// replace first page before printing it
	echo str_replace(array("/page/1?", "/page/1\""), array("?", "\""), $pagination);
	
	
}
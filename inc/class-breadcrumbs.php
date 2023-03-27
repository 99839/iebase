<?php
/**
 * Breadcrumbs function
 *
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly


if( ! function_exists( 'ie_breadcrumbs' )){

	function ie_breadcrumbs(){

		// If the breadcrumbs is disabled OR is hidden on mobiles
		if( ! get_theme_mod( 'breadcrumbs' ) ){
			return;
		}

		// breadcrumbs
		$delimiter   = get_theme_mod( 'breadcrumbs_delimiter' ) ? wp_kses_post( get_theme_mod( 'breadcrumbs_delimiter' ) ) : '&raquo;';
		$delimiter   = '<span class="delimiter">'. $delimiter .'</span>';
		$home_icon   = '<span class="iecon-home" aria-hidden="true"></span>';
		$home_text   =  __( 'Home','iebase' );
		$before      = '<span class="current">';
		$after       = '</span>';
		$breadcrumbs = array();

		// bbPress breadcrumbs
		if( function_exists( 'is_bbpress' ) && is_bbpress() && ( ! function_exists( 'is_buddypress' ) || ( function_exists( 'is_buddypress' ) && ! is_buddypress() ))){

			add_filter( 'bbp_no_breadcrumb', '__return_false' );

			$args = array(
				'before'         => '<nav id="crumbs" class="bbp-breadcrumb">',
				'after'          => '</nav>',
				'sep'            => $delimiter,
				'sep_before'     => '',
				'sep_after'      => '',
				'home_text'      => $home_icon.' '.$home_text,
				'current_before' => $before,
				'current_after'  => $after,
			);

			echo bbp_get_breadcrumb( $args );
		}

		// WordPress breadcrumbs
		elseif ( ! is_home() && ! is_front_page() || is_paged() ){

			$post     = get_post();
			$home_url = esc_url(home_url( '/' ));

			// Home
			$breadcrumbs[] = array(
				'url'   => $home_url,
				'name'  => $home_text,
				'icon'  => $home_icon,
			);

			// Category
			if ( is_category() ){

				$category = get_query_var( 'cat' );
				$category = get_category( $category );

				if( $category->parent !== 0 ){

					$parent_categories = array_reverse( get_ancestors( $category->cat_ID, 'category' ) );

					foreach ( $parent_categories as $parent_category ) {
						$breadcrumbs[] = array(
							'url'  => get_category_link( $parent_category ),
							'name' => get_cat_name( $parent_category ),
						);
					}
				}

				$breadcrumbs[] = array(
					'name' => get_cat_name( $category->cat_ID ),
				);
			}

			// Day
			elseif ( is_day() ){

				$breadcrumbs[] = array(
					'url'  => get_year_link( get_the_time( 'Y' ) ),
					'name' => get_the_time( 'Y' ),
				);

				$breadcrumbs[] = array(
					'url'  => get_month_link( get_the_time( 'Y' ), get_the_time( 'm' ) ),
					'name' => get_the_time( 'F' ),
				);

				$breadcrumbs[] = array(
					'name' => get_the_time( 'd' ),
				);
			}

			// Month
			elseif ( is_month() ){

				$breadcrumbs[] = array(
					'url'  => get_year_link( get_the_time( 'Y' ) ),
					'name' => get_the_time( 'Y' ),
				);

				$breadcrumbs[] = array(
					'name' => get_the_time( 'F' ),
				);
			}

			// Year
			elseif ( is_year() ){

				$breadcrumbs[] = array(
					'name' => get_the_time( 'Y' ),
				);
			}

			// Tag
			elseif ( is_tag() ){

				$breadcrumbs[] = array(
					'name' => get_the_archive_title(),
				);
			}

			// Author
			elseif ( is_author() ){

				$author = get_queried_object();

				$breadcrumbs[] = array(
					'name' => $author->display_name,
				);
			}

			// Search
			elseif ( is_search() ){

				$breadcrumbs[] = array(
					'name' => sprintf( __ti( 'Search Results for: %s' ),  get_search_query() ),
				);
			}

			// 404
			elseif ( is_404() ){

				$breadcrumbs[] = array(
					'name' => __ti( 'No Results' ),
				);
			}

			// BuddyPress
			elseif ( function_exists('bp_current_component') && bp_current_component() ){

				$breadcrumbs[] = array(
					'name' => get_the_title(),
				);
			}

			// Pages
			elseif ( is_page() ){

				if ( $post->post_parent ){

					$parent_id   = $post->post_parent;
					$page_parents = array();

					while ( $parent_id ){
						$get_page  = get_page( $parent_id );
						$parent_id = $get_page->post_parent;

						$page_parents[] = array(
							'url'  => get_permalink( $get_page->ID ),
							'name' => get_the_title( $get_page->ID ),
						);
					}

					$page_parents = array_reverse( $page_parents );

					foreach( $page_parents as $single_page ){

						$breadcrumbs[] = array(
							'url'  => $single_page['url'],
							'name' => $single_page['name'],
						);
					}
				}

				$breadcrumbs[] = array(
					'name' => get_the_title(),
				);
			}

			// Attachment
			elseif ( is_attachment() ){

				if( ! empty( $post->post_parent ) ){
					$parent = get_post( $post->post_parent );

					$breadcrumbs[] = array(
						'url'  => get_permalink( $parent ),
						'name' => $parent->post_title,
					);
				}

				$breadcrumbs[] = array(
					'name' => get_the_title(),
				);
			}

			// Single Posts
			elseif ( is_singular() ){

				// Single Post
				if ( get_post_type() == 'post' ){

					$category = get_the_category();

					if( ! empty( $category ) ){

						$category = $category[0];

						if( $category->parent !== 0 ){
							$parent_categories = array_reverse( get_ancestors( $category->term_id, 'category' ) );

							foreach ( $parent_categories as $parent_category ) {
								$breadcrumbs[] = array(
									'url'  => get_category_link( $parent_category ),
									'name' => get_cat_name( $parent_category ),
								);
							}
						}

						$breadcrumbs[] = array(
							'url'  => get_category_link( $category->term_id ),
							'name' => get_cat_name( $category->term_id ),
						);
					}
				}

				// Custom Post Type
				else{

					// Get the main Post type archive link
					if( $archive_link = get_post_type_archive_link( get_post_type() ) ){

						$post_type = get_post_type_object( get_post_type() );

						$breadcrumbs[] = array(
							'url'  => $archive_link,
							'name' => $post_type->labels->singular_name,
						);
					}

					// Get custom Post Types taxonomies
					$taxonomies = get_object_taxonomies( $post, 'objects' );

					if( ! empty( $taxonomies ) && is_array( $taxonomies ) ){
						foreach( $taxonomies as $taxonomy ){
							if( $taxonomy->hierarchical ){
								$taxonomy_name = $taxonomy->name;
								break;
							}
						}
					}

					if( ! empty( $taxonomy_name ) ){
						$custom_terms = get_the_terms( $post, $taxonomy_name );

						if( ! empty( $custom_terms ) && ! is_wp_error( $custom_terms )){

							foreach ( $custom_terms as $term ){

								$breadcrumbs[] = array(
									'url'  => get_term_link( $term ),
									'name' => $term->name,
								);

								break;
							}
						}
					}
				}

				$breadcrumbs[] = array(
					'name' => get_the_title(),
				);
			}


			// Print the BreadCrumb
			if( ! empty( $breadcrumbs ) ){

				$counter = 0;
				$item_list_elements = array();
				$breadcrumbs_schema = array(
					'@context' => 'http://schema.org',
					'@type'    => 'BreadcrumbList',
					'@id'      => '#Breadcrumb',
				);

				echo '<nav id="crumbs">';

					foreach( $breadcrumbs as $item ) {

						$counter++;

						if( ! empty( $item['url'] )){
							$icon = ! empty( $item['icon'] ) ? $item['icon'] .' ' : '';
							echo '<a href="'. esc_url( $item['url'] ) .'">'. $icon . $item['name'] .'</a>'. $delimiter;
						}
						else{
							echo ( $before . $item['name'] . $after );

							global $wp;
							$item['url'] = esc_url(home_url(add_query_arg(array(),$wp->request)));
						}

						$item_list_elements[] = array(
							'@type'    => 'ListItem',
							'position' => $counter,
							'item'     => array(
								'name' => str_replace( '<span class="iecon-home" aria-hidden="true"></span> ', '', $item['name']),
								'@id'  => $item['url'],
							)
						);

					}

				echo '</nav>';

				if( get_theme_mod( 'structure_data' ) ){

					// To remove the latest current element
					$latest_element = array_pop( $item_list_elements );

					if( ! empty( $item_list_elements ) && is_array( $item_list_elements ) ){

						$breadcrumbs_schema['itemListElement'] = $item_list_elements;
						echo '<script type="application/ld+json">'. wp_json_encode( $breadcrumbs_schema ) .'</script>';
					}
				}
			}
		}

		wp_reset_postdata();

	}

}




// WooCommerce Breadcrumb Args
add_filter( 'woocommerce_breadcrumb_defaults', 'tie_wc_breadcrumbs_args' );
function tie_wc_breadcrumbs_args(){
	return array(
		'delimiter'   => '<span class="delimiter">'. ( tie_get_option( 'breadcrumbs_delimiter') ? wp_kses_post( tie_get_option( 'breadcrumbs_delimiter') ) : '&raquo;' ) .'</span>',
		'wrap_before' => '<nav id="crumbs" class="woocommerce-breadcrumb" itemprop="breadcrumb">',
		'wrap_after'  => '</nav>',
		'home'        => ' '. __ti( 'Home' ),
		'before'      => '',
		'after'       => '',
	);
}

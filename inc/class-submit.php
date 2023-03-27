<?php

function getTemplatePageURL( $template_name ){
    $url = null;
    $pages = get_pages(array(
        'meta_key' => '_wp_page_template',
        'meta_value' => $template_name
    ));
    if(isset($pages[0])) {
        $url = get_page_link($pages[0]->ID);
    }
    return $url;
}

function iebase_custom_post_status(){
	register_post_status( 'iebase_pending', array(
		'label'                     => _x( 'Pending', 'post' ),
		'public'                    => false,
		'exclude_from_search'       => false,
		'show_in_admin_all_list'    => false,
		'show_in_admin_status_list' => true,
		'label_count'               => _n_noop( 'Pending <span class="count">(%s)</span>', 'Pending <span class="count">(%s)</span>' ),
	) );
}
add_action( 'init', 'iebase_custom_post_status' );

function iebase_post_post_upload(){
	
	$err_status = array();
	
	$post_title = isset( $_POST['iebase_post_title'] ) ? $_POST['iebase_post_title'] : '';
	$post_content = isset( $_POST['iebase_post_content'] ) ? $_POST['iebase_post_content'] : '';
	//$post_type = isset( $_POST['iebase_post_type'] ) ? $_POST['iebase_post_type'] : '';
	$post_id = isset( $_POST['iebase_post_url'] ) ? $_POST['iebase_post_url'] : '';
	$post_poster = isset( $_FILES['iebase_post_poster'] ) ? $_FILES['iebase_post_poster'] : '';
	$post_category = isset( $_POST['iebase_post_category'] ) ? $_POST['iebase_post_category'] : '';
	$post_new_category = isset( $_POST['iebase_new_post_category'] ) ? $_POST['iebase_new_post_category'] : '';
	$post_category = !empty( $post_category ) && is_array( $post_category ) ? $post_category : array();
	
	$poster_id = '';
	
	if( empty( $post_title ) ){
		$err_status[] = esc_html__( 'title must be fill!', 'iebase' );
	}
	if( empty( $post_content ) ){
		$err_status[] = esc_html__( 'content must be fill!', 'iebase' );
	}
	if( empty( $post_id ) ){
		$err_status[] = esc_html__( 'Url must not empty!', 'iebase' );
	}
	
	if( !empty( $post_poster ) ){
		$img_result = iebase_upload_featured_img( $post_poster );
		if( isset( $img_result['msg'] ) && !empty( $img_result['msg'] ) ){
			$err_status[] = $img_result['msg'];
		}
		if( isset( $img_result['img_id'] ) && $img_result['img_id'] != '' ){
			$poster_id = $img_result['img_id'];
		}else{
			$err_status[] = esc_html__( 'Featured image missing!', 'iebase' );
		}
	}
	
	if( empty( $err_status ) && !empty( $post_new_category ) ){
		$cats = explode( ",", $post_new_category );
		foreach( $cats as $cat ){
			if( !function_exists( 'wp_create_category' ) ){
				require_once ABSPATH . 'wp-admin/includes/taxonomy.php';
			}
			$id = wp_create_category( $cat );
			$post_category[] = $id;
		}
		
	}
	
	$meta_array = array(
		//'iebase_post_post_type' => $post_type,
		'iebase_post_post_url' => $post_id
	);
	
	$post_data = array(
		'post_type'		=> 'post',
		'post_title'	=> esc_html( $post_title ),
		'post_content'	=> wp_slash( $post_content ),
		'post_status'	=> 'iebase_pending',
		'post_author'	=> 1,
		'post_category'	=> $post_category,
		'meta_input'	=> $meta_array,
	);
	
	if( empty( $err_status ) ){
		$post_id = wp_insert_post( $post_data );
		if( $poster_id ){
			
			$tag = 'post-format-post';
			$taxonomy = 'post_format';
			wp_set_post_terms( $post_id, $tag, $taxonomy );
		
			$featured_img_stat = set_post_thumbnail( $post_id, $poster_id );
		}
		$url = home_url();
		echo '<p class="alert alert-success">'. esc_html__( 'Your post added successfully. Admin will approve soon.', 'iebase' ) .'<a href='.$url.'>'. esc_html__( 'Back to Home page', 'iebase' ).'</a></p>';
		return true;
	}else{
		echo '<ul class="nav flex-column">';
		foreach( $err_status as $err ){
			echo '<li class="alert alert-warning">'. esc_html( $err ) .'</li>';
		}
		echo '</ul>';
		return false;
	}
	
}

function iebase_upload_featured_img( $image_file ){
		
	$result = $upload_message = array();
	
	$valid_formats = array("jpg", "png", "gif", "bmp", "jpeg"); // Supported file types 
	$max_file_size = 1024 * 500; // in kb
	$wp_upload_dir = wp_upload_dir();
	$path = $wp_upload_dir['path'] . '/';
	$count = 0;
	
	$attach_id = '';
	// Image upload handler

	$extension = pathinfo( $image_file['name'], PATHINFO_EXTENSION );
	// Generate a randon code for each file name
	$new_filename = $image_file['name'];
	
	if ( $image_file['error'] == 4 ) {
		$upload_message[] = "$new_filename post poster file error!.";
	}
	
	if ( $image_file['error'] == 0 ) {
		// Check if image size is larger than the allowed file size
		if ( $image_file['size'] > $max_file_size ) {
			$upload_message[] = "$new_filename is too large!.";
		
		// Check if the file being uploaded is in the allowed file types
		} elseif( ! in_array( strtolower( $extension ), $valid_formats ) ){
			$upload_message[] = "$new_filename is not a valid format";
		
		} else{ 
			// If no errors, upload the file...
			
			$t_filename = $new_filename;
			$i = 0;
			while( file_exists( $path.$t_filename ) ){
				$t_fname = preg_replace( '/\.[^.]+$/', '', basename( $t_filename ) );
				$i++;
				$last2chars = substr( $t_fname, -2 ); 
				if( $last2chars[0] == '-' && ( isset( $last2chars[1] ) && is_numeric( $last2chars[1] ) ) ){
					$num_char = $last2chars[1];
					$num_char++;
					$t_fname = substr( $t_fname, 0, -2 );
					$t_filename = $t_fname . '-' . $num_char .'.'. $extension;
				}else{
					$t_filename = $t_fname . '-' . $i .'.'. $extension;
				}
			}
			
			if( move_uploaded_file( $image_file["tmp_name"], $path.$t_filename ) ) {
				
				$count++; 

				$filename = $path.$t_filename;
				$filetype = wp_check_filetype( basename( $filename ), null );
				$wp_upload_dir = wp_upload_dir();
				$attachment = array(
					'guid'           => $wp_upload_dir['url'] . '/' . basename( $filename ), 
					'post_mime_type' => $filetype['type'],
					'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $filename ) ),
					'post_content'   => '',
					'post_status'    => 'inherit'
				);
				// Insert attachment to the database
				$attach_id = wp_insert_attachment( $attachment, $filename );

				require_once ABSPATH . 'wp-admin/includes/image.php';
				
				// Generate meta data
				$attach_data = wp_generate_attachment_metadata( $attach_id, $filename ); 
				wp_update_attachment_metadata( $attach_id, $attach_data );
				
			}
		}

	}
	
	
	// Loop through each error then output it to the screen
	if ( isset( $upload_message ) ) :
		foreach ( $upload_message as $msg ){        
			$result['msg'] = $msg;
		}
	endif;
	
	// If no error, show success message
	if( $count != 0 ){
		$result['img_id'] = $attach_id;
	}
	return $result;
	
}
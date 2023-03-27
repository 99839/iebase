<?php
/**
 * Template Name: Login and Submit Video
 */
get_header(); 
$template = 'page'; // template id
?>

<?php //get_template_part( 'template-parts/page-hero' ); ?>

<div class='ie-wrapper'>
  <div class='e-grid'>
     <div class='e-grid__col e-grid__col--center e-grid__col--4-4-s e-grid__col--3-4-m'>

	 <article id='post-<?php the_ID(); ?>' <?php post_class('ie-post submit'); ?>>
		<div class="ie-content submit-content">
			<?php 

	            $display_message = __( 'You Must be Logged in to submit post,', 'iebase' );
		        $link = wp_login_url( get_permalink() );
		        $linktext = __( 'Register or Login Here', 'iebase' );
		        if( !is_user_logged_in() ) {
				echo '<div class="post-login">' . $display_message . '<a class="ieu-login-btn" href=" '. $link . ' " title="'. $linktext . '">'. $linktext . '</a></div>';

				}else{

					$upload_stat = false;

					    if( isset( $_POST['iebase_post_submit'] ) ){

							if( function_exists( 'iebase_post_post_upload' ) ) $upload_stat = iebase_post_post_upload();

						}

						if( !$upload_stat ){

							$post_title = isset( $_POST['iebase_post_title'] ) ? $_POST['iebase_post_title'] : '';

							$post_content = isset( $_POST['iebase_post_content'] ) ? $_POST['iebase_post_content'] : '';	

							$post_id = isset( $_POST['iebase_post_url'] ) ? $_POST['iebase_post_url'] : '';

							$post_poster = isset( $_FILES['iebase_post_poster'] ) ? $_FILES['iebase_post_poster'] : '';

							$post_category = isset( $_POST['iebase_post_category'] ) ? $_POST['iebase_post_category'] : '';

							$post_new_category = isset( $_POST['iebase_new_post_category'] ) ? $_POST['iebase_new_post_category'] : '';

							$cat_list = '';					

							$categories = get_categories( array(
								'orderby'		=> 'name',
								'order'			=> 'ASC',
								'hide_empty'	=> 0,
							) );

							foreach( $categories as $category ) {
								$seleted_cat = is_array( $post_category ) && in_array( $category->term_id, $post_category ) ? $category->term_id : '';

								$cat_list .= '<option value="'. esc_attr( $category->term_id ) .'" '. selected( $seleted_cat, $category->term_id, false ) .'>'. esc_html( $category->name ) .'</option>';
							}

							$category_allowed_html = array(
								'option' => array(
									'value' => array(),
									'selected' => array()
									)
								);
			?>						

			<div class="post-page-header-wrap text-center">

				<div class="post-page-title"><h2><?php esc_html_e( 'Add New Post', 'iebase' ) ?></h2></div>

				<div class="post-page-description"><p class="lead"><?php esc_html_e( 'Note: You are not write full post but the post summary, we will edit for you.', 'iebase' ) ?></p></div>

			</div>

		    <div class="post-submit-form-wrap">

				<?php								
					echo '
                        <form id="iebase-post-form" method="post" action="'. esc_url( getTemplatePageURL( 'page-post.php' ) ) .'" enctype="multipart/form-data">
						<div class="form-group">
                            <label for="iebase-post-title">'. esc_html__( 'Title *', 'iebase' ) .'</label>
						    <input type="text" name="iebase_post_title" class="form-control" id="iebase-post-title" value="'. esc_attr( $post_title ) .'">
						    <small class="form-text text-muted">'. esc_html__( 'Use raw text for post title. Don\'t include here html.', 'iebase' ) .'</small>
                        </div>

						<div class="form-group">
							<label for="iebase-post-content">'. esc_html__( 'Content *', 'iebase' ) .'</label>
							<textarea class="form-control" name="iebase_post_content" id="iebase-post-content">'. esc_html( $post_content ) .'</textarea>
							<small class="form-text text-muted">'. esc_html__( 'Use raw text for post content. Don\'t include here html.', 'iebase' ) .'</small>
						</div>

						<div class="form-group">
							<label for="iebase-post-poster">'. esc_html__( 'Featured image *', 'iebase' ) .'</label>
							<input type="file" class="form-control-file" name="iebase_post_poster" id="iebase-post-poster">
							<small class="form-text text-muted">'. esc_html__( 'Choose and upload image for featured image. Supported file types: jpg, png, gif, bmp, jpeg', 'iebase' ) .'</small>
						</div>

						<div class="form-group">
							<label for="iebase-post-id">'. esc_html__( 'Original url *', 'iebase' ) .'</label>
							<input type="text" name="iebase_post_url" class="form-control" id="iebase-post-id" value="'. esc_attr( $post_id ) .'">
							<small class="form-text text-muted">'. esc_html__( 'Place here your post original url', 'iebase' ) .'</small>
						</div>

						<div class="form-group">

							<label for="iebase-post-category">'. esc_html__( 'Select Existing Video Category', 'iebase' ) .'</label>
							<select multiple class="form-control" id="iebase-post-category" name="iebase_post_category[]">'. wp_kses( $cat_list, $category_allowed_html ) .'</select>
							<small class="form-text text-muted">'. esc_html__( 'This is optional. You can choose post category from existing categories.', 'iebase' ) .'</small>
						</div>

						<div class="form-group">
						    <label for="iebase-new-post-category">'. esc_html__( 'New Category', 'iebase' ) .'</label>
						    <input type="text" name="iebase_new_post_category" class="form-control" id="iebase-new-post-category" value="'. esc_attr( $post_new_category ) .'">
						    <small class="form-text text-muted">'. esc_html__( 'This is optional. You can enter new post category separated by comma(,). Example Travel,Fun', 'iebase' ) .'</small>
						</div>

                        '. wp_nonce_field( 'iebase_security_post_nonce', 'iebase_post_nonce' ) .'

						<button type="submit" class="ie-btn btn btn-default iebase-post-form-submit" name="iebase_post_submit">'. esc_html__( 'Submit', 'iebase' ) .'</button>

						</form>';?>

	    </div>
		<?php } }?>
        </div>
    </article>
</div>

</div>
</div>
</div>
<?php get_footer();
<?php
/**
 * The template for displaying comments.
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Iebase
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
  return;
}
$comment_count = get_comments_number();
?>

<div id='comments' class='comments-area'>

   <div id="show-comments-button" class="button--show-comments">
   <hr>
   <?php
    $args = array(
	    'class_submit'  => 'ie-btn',
	    'title_reply' => '<span class="section-head"><span class="title">' . esc_html__('Write A Comment', 'iebase') . '</span></span>',
	    'comment_field' =>
                '<p class="comment-form-comment"><label for="comment">'.esc_attr__('Write your comment here… ', 'hakuna').'<span class="required">*</span></label><span class="focus-border"></span><textarea id="comment" name="comment" rows="3" minlength="20" data-v-message="'.esc_attr__('Please enter minimum 20 characters.', 'hakuna').'" required aria-required="true"></textarea></p>',
		//'fields' => apply_filters( 'comment_form_default_fields', $fields ),
		'format'            => 'xhtml'
    );

	  comment_form($args);
	?>
	</div>

	<div class="comments-area__wrapper">

	<?php if ( have_comments() ) : ?>

    <hr>
    <h4><?php
			if ( 1 === $comment_count ) {
				esc_html_e( 'One Comment', 'iebase' );
			} else {
				printf( // WPCS: XSS OK.
					/* translators: 1: comment count number. */
					esc_html( _nx( '%1$s Comment', '%1$s Comments', $comment_count, 'Comments title', 'iebase' ) ),
					number_format_i18n( $comment_count )
				);
			} ?></h4>

		<ol class='comment-list'>
			<?php
				wp_list_comments( array(
					'style'      => 'ol',
					'short_ping' => true,
				) );
			?>
		</ol>

    <?php
      // Are there comments to navigate through?
      if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) {
        get_template_part( 'template-parts/comments-navigation' );
      }
    ?>

	<?php endif; // have_comments() ?>

  <?php
	  // If comments are closed and there are comments, let's leave a little note, shall we?
	  if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>

		<p class='no-comments'><?php esc_html_e( 'Comments are closed.', 'iebase' ); ?></p>

	<?php endif; ?>


  </div><!-- .comments-area__wrapper -->
</div><!-- #comments -->

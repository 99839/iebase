<?php
/**
  * Replace class on reply link
  */
  function iebase_replace_reply_link_class( $class ) {
    $class = str_replace( "class='comment-reply-link", "class='ie-btn outline tiny comment-reply-link", $class );
    return $class;
  }
  add_filter( 'comment_reply_link', 'iebase_replace_reply_link_class' );

  /**
  * Replace class on cancel reply link
  */
  function iebase_replace_cancel_reply_link_class( $cancel_comment_reply_link, $post = null ) {
    $new = str_replace( '<a', '<a class="button outline tiny"', $cancel_comment_reply_link );
    return $new;
  }
  add_filter( 'cancel_comment_reply_link', 'iebase_replace_cancel_reply_link_class', 10, 2 );

  /*
   * Change the comment reply link to use 'Reply to &lt;Author First Name>'
   * https://raam.org/2013/personalizing-the-wordpress-comment-reply-link/
   */
  function iebase_add_comment_author_to_reply_link( $link, $args, $comment ) {

    $comment = get_comment( $comment );

    // If no comment author is blank, use 'Anonymous'
    if ( empty( $comment->comment_author ) ) {
      if ( !empty( $comment->user_id ) ) {
        $user=get_userdata( $comment->user_id );
        $author=$user->user_login;
      } else {
        $author = esc_html__('Anonymous', 'iebase');
      }
    } else {
      $author = $comment->comment_author;
    }

    // If the user provided more than a first name, use only first name
    if( strpos( $author, ' ' ) ) {
      $author = substr( $author, 0, strpos( $author, ' ' ) );
    }

    // Replace Reply Link with "Reply to Author First Name>"
    $reply_link_text = $args['reply_text'];
    $link = str_replace( $reply_link_text, esc_html__( 'Reply to', 'iebase' ) . ' ' . $author, $link );

    return $link;
  }
  add_filter( 'comment_reply_link', 'iebase_add_comment_author_to_reply_link', 10, 3 );

  /**
   * Add Placehoder in comment Form Field (Comment)
   */
  function iebase_comment_textarea_placeholder( $fields ) {
    $fields['comment_field'] = str_replace(
      '<textarea',
      '<textarea placeholder="' . esc_html__( 'Comment', 'iebase' ) . '" ',
      $fields['comment_field']
    );

    return $fields;
  }
  add_filter( 'comment_form_defaults', 'iebase_comment_textarea_placeholder' );

  /**
   * Custom Form Field (Comment)
   */
  function iebase_custom_comment_form_fields( $fields ) {
    $commenter = wp_get_current_commenter();
    $req = get_option( 'require_name_email' );
    $aria_req = ( $req ? " aria-required='true'" : '' );

    $fields['author'] = '<div class="e-grid"><div class="e-grid__col e-grid__col--4-4-s e-grid__col--2-4-m">'.
      '<p><input id="author" name="author" type="text" placeholder="' . esc_html__( 'Name', 'iebase' ) . ( $req ? ' *' : '' ) . '" value="' . esc_attr( $commenter['comment_author'] ) . '" size="20"' . $aria_req . ' / minlength="3" data-v-message="'.esc_attr__('Name length minimum 3 characters.', 'iebase').'" required aria-required="true"></p></div>';

    $fields['email'] = '<div class="e-grid__col e-grid__col--4-4-s e-grid__col--2-4-m">'.
      '<p><input id="email" name="email" type="text" placeholder="' . esc_html__( 'Email', 'iebase' ) . ( $req ? ' *' : '' ) . '" value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="20"' . $aria_req . ' data-v-message="'.esc_attr__('Please enter an e-mail address.', 'iebase').'" required aria-required="true" /></p></div></div>';

    return $fields;
  }
  add_filter( 'comment_form_default_fields', 'iebase_custom_comment_form_fields' );

  /**
   * Remove url Field (Comment)
   */
  add_filter('comment_form_field_url', '__return_false');

  /**
   * Remove cookies Field (Comment)
   */
  remove_action( 'set_comment_cookies', 'wp_set_comment_cookies' );
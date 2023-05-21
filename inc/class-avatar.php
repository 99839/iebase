<?php
/**
 * Lazy load media functions based on Lazy Load for Images.
 *
 * @see https://www.mozedia.com/lazy-load-images-in-wordpress/
 *
 */

 if ( !defined('ABSPATH') ) exit;


class Iebase_Letter_Avatar {

     /**
      * Instance of the object.
      *
      * @since  1.0.0
      * @static
      * @access public
      * @var null|object
      */
     public static $instance = null;

     /**
      * Access the single instance of this class.
      *
      * @since  1.0.0
      * @return Iebase_Letter_Avatar
      */
     public static function get_instance() {
         if ( null === self::$instance ) {
             self::$instance = new self();
         }
         return self::$instance;
     }

     /**
      * Constructor
      *
      * @since  1.0.0
      * @return Iebase_Letter_Avatar
      */
     private function __construct(){

        add_filter( 'get_avatar', array($this, 'replace_gravatars_with_svgs'), 10, 5 );
        add_action( 'admin_head', array($this, 'hide_avatar_admin_bar') );
        add_action( 'admin_bar_menu', array($this, 'remove_my_account'), 999 );

     }

     // Replace Gravatars with SVGs in WordPress
     public function replace_gravatars_with_svgs( $avatar, $id_or_email, $size, $default, $alt ) {

         $alt = $this->iebase_get_avatar_name($id_or_email);
         //$alt = $alt? $alt: $this->iebase_get_html_tag_attribute($avatar, 'alt', $alt);
         if(!$alt) return $avatar;

         $colors = array("#1abc9c", "#2ecc71", "#3498db", "#9b59b6", "#34495e","#16a085", "#27ae60", "#2980b9", "#8e44ad", "#2c3e50","#f1c40f", "#e67e22", "#e74c3c", "#95a5a6", "#f39c12","#d35400", "#c0392b", "#bdc3c7", "#7f8c8d");
         $random_color = $colors[array_rand($colors)];

         $svg = '<svg class="avatar" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 '.$size.' '.$size.'" width="'.$size.'" height="'.$size.'"><rect width="'.$size.'" height="'.$size.'" x="0" y="0" rx="5" ry="5" fill="'.$random_color.'"></rect><text x="50%" y="50%" alignment-baseline="central" text-anchor="middle" font-size="'.$size.'/2" fill="#ffffff" dominant-baseline="middle">' . mb_substr( $alt, 0, 1 ) . '</text></svg>';
         return $svg;
     }


     //* get the username
     public function iebase_get_avatar_name($id_or_email) {
        if(have_comments()) {
            return get_comment_author();
        }

        $user = null;
        if(empty($id_or_email)) {
            return null;
        } else if(is_object($id_or_email)) {
            if(!empty($id_or_email->comment_author)) {
                return $id_or_email->comment_author;
            } else if(!empty($id_or_email->user_id)) {
                $id = (int) $id_or_email->user_id;
                $user = get_user_by('id', $id);
            }
        } else if(is_numeric($id_or_email)) {
            $id = (int) $id_or_email;
            $user = get_user_by('id', $id);
        } else if(is_string($id_or_email)) {
            if (!filter_var($id_or_email, FILTER_VALIDATE_EMAIL)) {
                return $id_or_email;
            } else {
                $user = get_user_by('email', $id_or_email);
            }
        }

         if(!empty($user) && is_object($user)) {
             return $user->display_name;
        }
        return null;
    }

     //Fix letter avatar style in admin
     public function hide_avatar_admin_bar() {
        echo '<style>.column-author .avatar, .column-comment .comment-author .avatar, .column-username .avatar {float: left;margin-right: 10px;margin-top: 1px;}
        #wpadminbar #wp-admin-bar-my-account.with-avatar>.ab-empty-item .avatar, #wpadminbar #wp-admin-bar-my-account.with-avatar>a .avatar{width: auto;height: 16px;padding: 0;border: 1px solid #8c8f94;line-height: 1.84615384;vertical-align: middle;margin: -4px 0 0 6px;float: none;display: inline;}</style>';
    }

     // hidden user-info in admin_bar
     public function remove_my_account( $wp_admin_bar ) {
        $wp_admin_bar->remove_node( 'user-info' );
    }

 }

 // Init
 Iebase_Letter_Avatar::get_instance();
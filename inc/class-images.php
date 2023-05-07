<?php
/**
 * Lazy load media functions based on Lazy Load for Images.
 *
 * @see https://www.mozedia.com/lazy-load-images-in-wordpress/
 *
 */

 if ( !defined('ABSPATH') ) exit;


class Iebase_LazyLoad {

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
      * @return Iebase_LazyLoad
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
      * @return Iebase_LazyLoad
      */
     private function __construct(){

         if( !is_admin() ){
             add_filter('the_content',         array($this, 'iebase_lazyload_images'), PHP_INT_MAX);
             add_filter('get_avatar',          array($this, 'iebase_lazyload_images'), PHP_INT_MAX);
             add_filter('widget_text',         array($this, 'iebase_lazyload_images'), PHP_INT_MAX);
             add_filter('post_thumbnail_html', array($this, 'iebase_lazyload_images'), PHP_INT_MAX);
             //add_action('wp_enqueue_scripts',  array($this, 'enqueue_scripts'));
             //add_filter('script_loader_tag',   array($this, 'add_async_attribute'), 10, 2);

             add_action( 'wp_footer', array($this, 'iebase_lazyload_script'), PHP_INT_MAX);
         }
     }

     //* start function for lazy load images
     public function iebase_lazyload_images( $html ) {
	     // Don't LazyLoad if the thumbnail is in
	    if( is_admin() || is_feed() || is_preview() || empty( $html ) ) {
		    return $html;
	    }

	    // Stop LalyLoad process with this hook
	    if ( ! apply_filters( 'do_not_lazyload', true ) ) {
		    return $html;
	    }

	    $html = preg_replace_callback( '#<img([^>]*) src=("(?:[^"]+)"|\'(?:[^\']+)\'|(?:[^ >]+))([^>]*)>#', array($this, '__iebase_lazyload_replace_callback'), $html );

	    return $html;
     }


     //* Used to check if LazyLoad this or not
     public function __iebase_lazyload_replace_callback( $matches ) {
	    if ( strpos( $matches[1] . $matches[3], 'data-no-lazy=' ) === false && strpos( $matches[1] . $matches[3], 'data-src=' ) === false && strpos( $matches[2], '/wpcf7_captcha/' ) === false ) {
		    $html = sprintf( '<img%1$s src="data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src=%2$s%3$s><noscript><img%1$s src=%2$s%3$s></noscript>',
						$matches[1], $matches[2], $matches[3] );

		    //* Filter the LazyLoad HTML output
		    $html = apply_filters( 'iebase_lazyload_html', $html, true );

		    return $html;
	    } else {
		    return $matches[0];
	    }
     }

     // Add lazy load script in footer inline HTML
     public function iebase_lazyload_script() {
	    if ( ! apply_filters( 'do_not_lazyload', true ) ) {
		    return;
	    }

	    echo '<script type="text/javascript">(function(a,e){function f(){var d=0;if(e.body&&e.body.offsetWidth){d=e.body.offsetHeight}if(e.compatMode=="CSS1Compat"&&e.documentElement&&e.documentElement.offsetWidth){d=e.documentElement.offsetHeight}if(a.innerWidth&&a.innerHeight){d=a.innerHeight}return d}function b(g){var d=ot=0;if(g.offsetParent){do{d+=g.offsetLeft;ot+=g.offsetTop}while(g=g.offsetParent)}return{left:d,top:ot}}function c(){var l=e.querySelectorAll("[data-src]");var j=a.pageYOffset||e.documentElement.scrollTop||e.body.scrollTop;var d=f();for(var k=0;k<l.length;k++){var h=l[k];var g=b(h).top;if(g<(d+j)){h.src=h.getAttribute("data-src");h.removeAttribute("data-src")}}}if(a.addEventListener){a.addEventListener("DOMContentLoaded",c,false);a.addEventListener("scroll",c,false)}else{a.attachEvent("onload",c);a.attachEvent("onscroll",c)}})(window,document);</script>';
     }


 }

 // Init
 Iebase_LazyLoad::get_instance();
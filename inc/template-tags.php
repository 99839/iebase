<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Iebase
 */

/**
 * Flush out the transients used in iebase_categorized_blog.
 */
function iebase_category_transient_flusher()
{
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    // Like, beat it. Dig?
    delete_transient('iebase_categories');
}
add_action('edit_category', 'iebase_category_transient_flusher');
add_action('save_post', 'iebase_category_transient_flusher');

if (! function_exists('iesay_entry_meta')) :
    /**
     * Prints HTML with meta information for the current post-date/time and author.
     */
    function iebase_entry_meta()
    {
        $post_author_id   = get_post_field('post_author', get_the_ID());
        $post_author_name = get_the_author_meta('display_name', $post_author_id);
    
        echo('<div class="entry-meta">');
    
        $time_string = '<time class="entry-date published" itemprop="datePublished" datetime="%1$s">%2$s</time>';
        if (get_the_time('U') !== /*get_the_modified_time*/get_the_date('U')) {
            $time_string = '<time class="entry-date published" datetime="%3$s">%4$s</time>';
            //$time_string = '<time class="entry-date published" datetime="%3$s">%4$s</time><time class="updated" datetime="%3$s">%4$s</time>';
        }
    
        $time_string = sprintf(
            $time_string,
            esc_attr(get_the_date('c')),
            esc_html(get_the_date()),
            esc_attr(get_the_modified_date('c')),
            esc_html(get_the_modified_date())
        );
    
        $posted_on = sprintf(
            esc_html_x('%s', 'post date', 'iebase'),
            '' . $time_string . ''
        );
    
        $byline = sprintf(
            /* translators: %s: post author */
            //__( 'by %s', 'iebase' ),
            '<span class="author vcard"><a class="url fn n" href="' . esc_url(get_author_posts_url(get_the_author_meta('ID', $post_author_id))) . '">' . $post_author_name . '</a></span>'
        );
    
            
        echo '<span class="byline" itemprop="name"><i class="iecon-account"></i>' . $byline . '</span>';
            
            
        echo '<span class="posted-on"><i class="iecon-watch_later"></i>' . $posted_on . '</span>';
        //if (get_the_modified_time('U') > get_the_time('U'))
        if (get_the_modified_time('U') >= get_the_time('U') + 86400) {
            echo '<span class="post-updated-time" itemprop="dateModified">'.esc_html__('Updated:', 'iebase').' ' . get_the_modified_date().'</span>';
        }
        // WPCS: XSS OK.
            
    
        // Hide category and tag text for pages.
        if ('post' === get_post_type()) {
            /* translators: used between list items, there is a space after the comma */
                
            if (function_exists('Ie_PostViews')) {
                $post_view = Ie_PostViews(get_the_ID());
                echo '<span class="post-view"><i class="iecon-visibility"></i>';
                echo iebase_numerical_word($post_view);
                echo '</span>';
            }
            
            if (function_exists('ie_calculate_reading_time')) {
                echo'<span class="post-read"><i class="iecon-power"></i>'.ie_calculate_reading_time().'</span>';
            }
            
            if (comments_open() /*&& isset( $meta_options[ 'meta-comment' ] )*/) {
                echo '<span class="post-comment"><a href="'.get_comments_link().'"><i class="iecon-comments"></i>'.get_comments_number('0', '1', '%').'</a></span>'; // WPCS: XSS OK.
            }
            
            if (function_exists('get_simple_likes_button')) {
                echo get_simple_likes_button(get_the_ID());
            }
        }
    
        edit_post_link(
            sprintf(
                    /* translators: %s: Name of current post */
                    esc_html__('Edit %s', 'iebase'),
                    the_title('<span class="screen-reader-text">"', '"</span>', false)
                ),
            '<span class="edit-link"><i class="iecon-pencil"></i>',
            '</span>'
        );
    
        echo('</div><!-- .entry-meta -->');
    }
    endif;

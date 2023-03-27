<?php
/**
 * Template part for displaying the Previous/next post navigation..
 *
 * @package Iebase
 */

?>

<?php
  the_post_navigation( array(
    'next_text' => '<span class="meta-nav" aria-hidden="true"><span class="pagination__text">' . esc_html__( 'Next', 'iebase' ) . '</span><i class="pagination__icon iecon-chevron-right"></i></span> ' .
    '<span class="screen-reader-text">' . esc_html__( 'Next post:', 'iebase' ) . '</span>' .
    '<span class="post-title">%title</span>',
    'prev_text' => '<span class="meta-nav" aria-hidden="true"><i class="pagination__icon iecon-chevron-left"></i><span class="pagination__text">' . esc_html__( 'Previous', 'iebase' ) . '</span></span>' .
    '<span class="screen-reader-text">' . esc_html__( 'Previous post:', 'iebase' ) . '</span>' .
    '<span class="post-title">%title</span>',
  ) );
?>
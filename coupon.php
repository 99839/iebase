<?php
/*
Template Name: Coupon
*/
 ?> 
<?php
    get_header();
    
    $args = array( 
      'posts_per_page' => 10,
      //'paged'=> '.get_query_var('paged')'，
      'paged' => get_query_var( 'paged' ),
      'post_type' => array ( 'post'),
      'posts_per_page'=>get_option('posts_per_page'),
      'tax_query' => array( array(
            'taxonomy' => 'post_format',
            'field' => 'slug',
            'terms' => array('post-format-link'),
            'operator' => 'IN'
           ) )
    );
    query_posts( $args);
    //query_posts('post_type=post&post_status=publish&posts_per_page=12&paged='. get_query_var('paged'));
?>
<?php //get_template_part( 'template-parts/archive-header' ); ?>

<div class='ie-wrapper' id='content'>

<?php if ( have_posts() ) : ?>

  <div id='posts' class='e-grid js-grid'>
    <?php
      while ( have_posts() ) : the_post();
        get_template_part( 'template-parts/post-card' );
      endwhile;
      if ( function_exists( 'iecore_paginator' ) ) iecore_paginator( get_pagenum_link() );
    ?>
  </div>

<?php else: ?>

  <div class='e-grid'>
    <div class='e-grid__col e-grid__col--full'>
      <?php get_template_part( 'template-parts/no-results' ); ?>
    </div>
  </div>

<?php endif; ?>

</div>

<?php
get_footer();
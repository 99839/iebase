<?php
/**
 * Template part for displaying the modal search window
 *
 * @package Iebase
 */

?>

<div class='ie-search js-search'>

  <div class='e-grid'>
    <div class='e-grid__col e-grid__col--4-4-s e-grid__col--3-4-m e-grid__col--2-4-l e-grid__col--center'>
      <form class='modal-search' method='get' action='<?php echo esc_url( home_url( '/' ) ); ?>'>
        <i class="iecon-magnifier ie-search__icon"></i>
        <input class='ie-search__input js-search-input' placeholder='<?php esc_html_e( 'Type and hit enter', 'iebase' ); ?>' name='s'>
      </form>
    </div>
  </div>

  <?php 
  $keywords = get_theme_mod( 'hot-search-word');
  $keys = explode("\n", $keywords);
  if ( !empty($keys) ) : ?>
  <div class='e-grid'>
    <div class="e-grid__col e-grid__col--4-4-s e-grid__col--3-4-m e-grid__col--2-4-l e-grid__col--center">
      <div class="popular-search">
         <h2 class="popular-title"><?php esc_html_e( 'Popular Search ', 'iebase' );?></h2>
        <div class="search-terms-list">
         <?php foreach ( $keys as $key ) {
         echo '<a href="'.esc_url(get_search_link($key)).'">';
         echo ''. trim( $key ) .'';
         echo '</a>';
        };?>
        </div>
      </div>
    </div>
  </div>
  <?php endif;?>
  
  <?php 
    $tags = get_tags(array(
            'number'                    => 5,  
            'format'                    => 'flat',
            'separator'                 => " ",
            'orderby'                   => 'count', 
            'order'                     => 'DESC',
            'echo'                      => false
        )
    ); 
  ?>
  <div class='e-grid'>
    <div class='e-grid__col e-grid__col--4-4-s e-grid__col--3-4-m e-grid__col--2-4-l e-grid__col--center'>
      <div class="popular-tags">
        <h2 class="popular-title"><?php esc_html_e( 'Popular Tags ', 'iebase' );?></h2>
        <div class="tags-terms-list">
        <?php foreach ( $tags as $tag ) {
           $tag_link = get_tag_link( $tag->term_id );
           echo "<a href='{$tag_link}' title='{$tag->name} Tag' class='{$tag->slug}'>";
           echo"{$tag->name}</a>";
           };
        ?>
        </div>
      </div>
    </div>
  </div>

  <i class='iecon-cross ie-search__close js-search-close'></i>

</div>
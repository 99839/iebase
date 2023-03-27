<?php
/**
 * Set up the social media links to share a post for the current post.
 *
 * @package Iebase
 */

?>

<ul class='ie-share ie-plain-list'>
  <li class='ie-share__item'>
    <a class='ie-share__link' title='<?php esc_html_e( 'Share on Twitter', 'iebase' ); ?>' href='https://twitter.com/share?text=<?php iebase_get_escaped_title(); ?>&amp;url=<?php the_permalink(); ?>' onclick="window.open(this.href, 'twitter-share', 'width=550, height=235'); return false;"><i class='ie-share__icon iecon-twitter'></i></a>
  </li>
  <li class='ie-share__item'>
    <a class='ie-share__link' title='<?php esc_html_e( 'Share on Facebook', 'iebase' ); ?>' href='//www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>' onclick="window.open(this.href, 'facebook-share', 'width=580, height=296'); return false;"><i class='ie-share__icon iecon-facebook'></i></a>
  </li>
  <li class='ie-share__item'>
    <a class='ie-share__link' title='<?php esc_html_e( 'Share on Pinterest', 'iebase' ); ?>' href='//www.pinterest.com/pin/create/button/?url=<?php the_permalink(); ?>&media=<?php iebase_get_share_image(); ?>&description=<?php iebase_get_escaped_title(); ?>' onclick="window.open(this.href, 'pinterest-share', 'width=580, height=296'); return false;"><i class='ie-share__icon iecon-pinterest'></i></a>
  </li>
  <li class='ie-share__item'>
    <a class='ie-share__link' title='<?php esc_html_e( 'Share on Weibo', 'iebase' ); ?>' href='//service.weibo.com/share/share.php?title=<?php iebase_get_escaped_title(); ?>&url=<?php the_permalink(); ?>&pic=<?php iebase_get_share_image(); ?>' onclick="window.open(this.href, 'weibo-share', 'width=580, height=296'); return false;"><i class='ie-share__icon iecon-weibo'></i></a>
  </li>
  <li class='ie-share__item'>
    <a class='ie-share__link' title='<?php esc_html_e( 'Share on QQ', 'iebase' ); ?>' href='//connect.qq.com/widget/shareqq/index.html?url=<?php the_permalink(); ?>&title=<?php iebase_get_escaped_title(); ?>&pics=<?php iebase_get_share_image(); ?>' onclick="window.open(this.href, 'qq-share', 'width=750, height=629'); return false;"><i class='ie-share__icon iecon-qq'></i></a>
  </li>
  <li class='ie-share__item'>
    <a class='ie-share__link' title='<?php esc_html_e( 'Share on Linkedin', 'iebase' ); ?>' href='//www.linkedin.com/shareArticle?mini=true&url=<?php the_permalink(); ?>&title=<?php iebase_get_escaped_title(); ?>' onclick="window.open(this.href, 'linkedin-share', 'width=750, height=629'); return false;"><i class='ie-share__icon iecon-linkedin'></i></a>
  </li>
</ul>
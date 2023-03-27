<?php

/*
Plugin Name: Iebase Components
License: GNU
*/

/* */

class iebase_widget_ads extends WP_Widget {

	function __construct() {

		parent::__construct( 'iebase_widget_ads', esc_html__( '09. Widget: Ads', 'iebase' ), array( 'description' => esc_html__( "You can place your Ad code into this widget.", 'iebase' ) ) );

	}

	function form( $instance ) {

		$instance = wp_parse_args( ( array ) $instance, $this->defaults() );
		?>

		<p><textarea class="widefat" rows="16" cols="20" id="<?php echo esc_attr( $this->get_field_id('text') ); ?>" name="<?php echo esc_attr( $this->get_field_name('text') ); ?>"><?php echo esc_textarea( $instance['text'] ); ?></textarea></p>

		<?php
	}

	function update( $new_instance, $old_instance ) {

		$instance = $old_instance;
		if ( current_user_can( 'unfiltered_html' ) ) {
			$instance['text'] = $new_instance['text'];
		} else {
			$instance['text'] = stripslashes( wp_filter_post_kses( addslashes( $new_instance['text'] ) ) );
		}
		return $instance;

	}

	function widget( $args, $instance ) {
		extract( $args );
		echo wp_kses_post( $before_widget );
		$instance = wp_parse_args( ( array ) $instance, $this->defaults() );
		?>

        <div class="widget_html clearfix"><?php echo apply_filters( 'widget_text', $instance['text'] ); ?></div>

		<?php
		echo wp_kses_post( $after_widget );
	}

	function defaults() {

		$defaults = array( 'text' => '' );
		return $defaults;
	}
}

class iebase_category_posts extends WP_Widget {

	function __construct() {

		parent::__construct( 'iebase_category_posts', esc_html__( '03. Category/Tag Posts', 'iebase' ), array( 'description' => esc_html__( "Display the posts belong to a specific category or tag.", 'iebase' ), 'classname' => 'iebase_category_posts' ) );

	}

	function form( $instance ) {

		$instance = wp_parse_args( ( array ) $instance, $this->defaults() );

		?>

        <p><?php echo esc_html__( 'Title:', 'iebase' ); ?> <input name="<?php echo esc_attr( $this->get_field_name( 'name' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['name'] ); ?>" class="widefat" /></p>
        <p><?php echo esc_html__( 'Number of posts to show:', 'iebase' ); ?> <input name="<?php echo esc_attr( $this->get_field_name( 'count' ) ); ?>" type="number" value="<?php echo esc_attr( $instance['count'] ); ?>" style="width: 50px;" /></p>
        <p><?php echo esc_html__( 'Taxonomy:', 'iebase' ); ?></p>
        <p>
        <input class="radio" id="<?php echo esc_attr( $this->get_field_id( 'cat' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'list_type' ) ); ?>" type="radio" value="cat" <?php esc_attr( checked( $instance['list_type'], 'cat' ) ); ?> /><label for="<?php echo esc_attr( $this->get_field_id( 'cat' ) ); ?>"><?php echo esc_html__( 'Category Posts', 'iebase' ); ?></label>
        </p>
        <p>
        <input class="radio" id="<?php echo esc_attr( $this->get_field_id( 'tag' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'list_type' ) ); ?>" type="radio" value="tag" <?php esc_attr( checked( $instance['list_type'], 'tag' ) ); ?> /><label for="<?php echo esc_attr( $this->get_field_id( 'tag' ) ); ?>"><?php echo esc_html__( 'Tag Posts', 'iebase' ); ?></label>
        </p>
        <hr />
        <p><strong><?php echo esc_html__( 'Categories', 'iebase' ); ?></strong></p>
        <p>
        <?php
		$cat_args = array(
			'show_option_none' => esc_html__( '- Select a Category -', 'iebase' ),
			'show_count' => 1,
			'hide_empty' => 0,
			'id' => esc_attr( $this->get_field_name( 'category' ) ),
			'name' => esc_attr( $this->get_field_name( 'category' ) ),
			'selected' => esc_attr( $instance['category'] ),
			'class' => 'postform widefat',
		);
		wp_dropdown_categories( $cat_args );
		?>
		</p>
        <p><em><?php echo esc_html__( 'Only used if "Category Posts" is selected.', 'iebase' ); ?></em></p>
        <p><?php echo esc_html__( 'Excluded Categories:', 'iebase' ); ?><br />
        <input name="<?php echo esc_attr( $this->get_field_name( 'exclude_cats' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['exclude_cats'] ); ?>" /></p>
        <p><em><?php echo esc_html__( 'Useful when a post has more than one category.', 'iebase' ); ?><br />
        <?php echo esc_html__( 'Write category IDs you want to hide. Use comma (,) between them. Example: 2,5,8', 'iebase' ); ?></em></p>
        <hr />
        <p><strong><?php echo esc_html__( 'Tags', 'iebase' ); ?></strong></p>
        <p>
        <?php
		$tag_args = array(
			'show_option_none' => esc_html__( '- Select a Tag -', 'iebase' ),
			'show_count' => 1,
			'hide_empty' => 0,
			'id' => esc_attr( $this->get_field_name( 'tag' ) ),
			'name' => esc_attr( $this->get_field_name( 'tag' ) ),
			'selected' => esc_attr( $instance['tag'] ),
			'class' => 'postform widefat',
			'taxonomy' => 'post_tag',
		);
		wp_dropdown_categories( $tag_args );
		?>
		</p>
        <p><em><?php echo esc_html__( 'Only used if "Tag Posts" is selected.', 'iebase' ); ?></em></p>
        <p><?php echo esc_html__( 'Excluded Tags:', 'iebase' ); ?><br />
        <input name="<?php echo esc_attr( $this->get_field_name( 'exclude_tags' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['exclude_tags'] ); ?>" /></p>
        <p><em><?php echo esc_html__( 'Useful when a post has more than one tag.', 'iebase' ); ?><br />
        <?php echo esc_html__( 'Write tag IDs you want to hide.', 'iebase' ); ?></em></p>
        <hr />
        <p><?php echo esc_html__( 'Excluded Posts:', 'iebase' ); ?><br />
        <input name="<?php echo esc_attr( $this->get_field_name( 'exclude_posts' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['exclude_posts'] ); ?>" /></p>
        <p><em><?php echo esc_html__( 'Write post IDs you want to hide.', 'iebase' ); ?></em></p>

		<?php

	}

	function update( $new_instance, $old_instance ) {

		$instance = $old_instance;

		$instance['name'] = $new_instance['name'] ? strip_tags( $new_instance['name'] ) : esc_html__( 'Category Posts', 'iebase' );
		$instance['count'] = $new_instance['count'] ? strip_tags( $new_instance['count'] ) : 5;
		$instance['category'] = $new_instance['category'];
		$instance['tag'] = $new_instance['tag'];
		$instance['list_type'] = $new_instance['list_type'];
		$instance['exclude_cats'] = $new_instance['exclude_cats'];
		$instance['exclude_tags'] = $new_instance['exclude_tags'];
		$instance['exclude_posts'] = $new_instance['exclude_posts'];

		return $instance;

	}

	function widget( $args, $instance ) {

		extract( $args );

		$instance = wp_parse_args( ( array ) $instance, $this->defaults() );

		echo wp_kses_post( $before_widget );

		$name = apply_filters( 'widget_title', $instance['name'] );
		$count = $instance['count'];
		$category = $instance['category'];
		$tag = $instance['tag'];
		$list_type = $instance['list_type'];
		$exclude_cats = $instance['exclude_cats'];
		$exclude_tags = $instance['exclude_tags'];
		$exclude_posts = $instance['exclude_posts'];

		echo wp_kses_post( $before_title ) . esc_attr( $name ) . wp_kses_post( $after_title );

		$posts_to_exclude = explode( ',', esc_attr( $exclude_posts ) );

		if ( $list_type == 'cat' ) {

			$cats_to_exclude = explode( ',', esc_attr( $exclude_cats ) );

			$loop_args = array(

				'showposts' => esc_attr( $count ),
				'cat' => $category,
				'ignore_sticky_posts' => 1,
				'category__not_in' => $cats_to_exclude,
				'post__not_in' => $posts_to_exclude

			);

		} else {

			$tags_to_exclude = explode( ',', esc_attr( $exclude_tags ) );

			$loop_args = array(

				'showposts' => esc_attr( $count ),
				'tag_id' => $tag,
				'ignore_sticky_posts' => 1,
				'tag__not_in' => $tags_to_exclude,
				'post__not_in' => $posts_to_exclude

			);

		}

		$widget_query = new WP_Query( $loop_args );

		while ( $widget_query->have_posts() ) : $widget_query->the_post();

		?>

       <a href="<?php echo esc_url( get_the_permalink() ); ?>" class="c-teaser">
			<div class='c-teaser__media'>
			<div class='c-teaser__image js-fadein' style="background-image: url(<?php esc_url( iebase_entry_feature_image_path('ie-post-grid-thumb') ) ?>)" aria-label="<?php the_title(); ?>"></div>
            </div>
                <div class='c-teaser__content'>
                <h3 class='c-teaser__title'><?php the_title(); ?></h3>
				<span class='c-teaser__date'>
                <time datetime='<?php the_time( 'c' ); ?>' title='<?php the_time( 'c' ); ?>'>
                <?php echo get_the_date(get_option( 'date_format' )); ?>
                </time></span>
            </div>
		</a>

		<?php endwhile;

		wp_reset_postdata();

		echo wp_kses_post( $after_widget );

	}

	function defaults() {

		$defaults = array( 'name' => esc_html__( 'Category Posts', 'iebase' ), 'count' => 5, 'category' => -1, 'tag' => -1, 'list_type' => 'cat', 'exclude_cats' => '', 'exclude_tags' => '', 'exclude_posts' => '' );
		return $defaults;

	}

}

class iebase_widget_image extends WP_Widget {

	function __construct() {

		parent::__construct( 'iebase_widget_image', esc_html__( '06. Widget Image', 'iebase' ), array( 'description' => esc_html__( "Display an image with an optional title.", 'iebase' ) ) );

	}

	function form( $instance ) {

		$instance = wp_parse_args( ( array ) $instance, $this->defaults() );

		?>

        <p><?php echo esc_html__( 'Image Path:', 'iebase' ); ?> <input name="<?php echo esc_attr( $this->get_field_name( 'path' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['path'] ); ?>" class="widefat" /></p>
        <p>
        <em><?php echo esc_html__( 'To find the image path, go to "Media > Library", click the image and see the "URL" field.', 'iebase' ); ?></em>
        </p>
        <p><?php echo esc_html__( 'Title:', 'iebase' ); ?> <input name="<?php echo esc_attr( $this->get_field_name( 'name' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['name'] ); ?>" class="widefat" /></p>
        <p><?php echo esc_html__( 'Link:', 'iebase' ); ?> <input name="<?php echo esc_attr( $this->get_field_name( 'link' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['link'] ); ?>" class="widefat" /></p>
        <p>
		<input class="checkbox" type="checkbox" value="1" <?php esc_attr( checked( $instance['target'], 1 ) ); ?> id="<?php echo esc_attr( $this->get_field_id( 'target' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'target' ) ); ?>" />
		<label for="<?php echo esc_attr( $this->get_field_id( 'target' ) ); ?>"><?php echo esc_html__( 'Open in new window', 'iebase' ); ?></label>
		</p>

		<?php

	}

	function update( $new_instance, $old_instance ) {

		$instance = $old_instance;

	    $instance['name'] = $new_instance['name'];
		$instance['path'] = $new_instance['path'];
		$instance['link'] = $new_instance['link'];
		$instance['target'] = !empty( $new_instance['target'] );

		return $instance;

	}

	function widget( $args, $instance ) {

		extract( $args );

		$instance = wp_parse_args( ( array ) $instance, $this->defaults() );

		echo wp_kses_post( $before_widget );

		$name = apply_filters( 'widget_title', $instance['name'] );
		$path = $instance['path'];
		$link = $instance['link'];
		$target = $instance['target'];

		?>

        <div class="ie-post-card image-widget-wrapper"><?php if ( $link ) { echo '<a class="js-fadein ie-post-card__image" href="' . esc_attr( $link ) . '" target="'; if ( $target ) { echo '_blank'; } else { echo '_self'; } echo '"'; } ?>
            <?php if ( $path ) { ?>style='background-image: url("<?php echo esc_attr( $path ); ?>")'><?php } ?>
            <?php if ( $name ) { ?>
            <div class="image-widget-title"><span class="iwt-border"><?php echo esc_attr( $name ); ?></span></div>
            <?php } ?>
            <?php if ( $link ) { echo '</a>'; } ?>
		</div>
      

		<?php

        echo wp_kses_post( $after_widget );
	}

	function defaults() {

		$defaults = array( 'name' => esc_html__( 'Wondered who I am?', 'iebase' ), 'path' => '', 'link' => '', 'target' => 0 );
		return $defaults;

	}

}

class iebase_popular_posts extends WP_Widget {

	function __construct() {

		parent::__construct( 'iebase_popular_posts', esc_html__( '02. Popular Posts', 'iebase' ), array( 'description' => esc_html__( "Display the most popular posts.", 'iebase' ), 'classname' => 'iebase_popular_posts' ) );

	}

	function form( $instance ) {

		$instance = wp_parse_args( ( array ) $instance, $this->defaults() );

		?>

		<p><?php echo esc_html__( 'Title:', 'iebase' ); ?> <input name="<?php echo esc_attr( $this->get_field_name( 'name' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['name'] ); ?>" class="widefat" /></p>
        <p><?php echo esc_html__( 'Number of posts to show:', 'iebase' ); ?> <input name="<?php echo esc_attr( $this->get_field_name( 'count' ) ); ?>" type="number" value="<?php echo esc_attr( $instance['count'] ); ?>" style="width: 50px;" /></p>
        <p><?php echo esc_html__( 'Popularity Type:', 'iebase' ); ?></p>
        <p>
        <input class="radio" id="<?php echo esc_attr( $this->get_field_id( 'comment' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'popularity_base' ) ); ?>" type="radio" value="comment" <?php esc_attr( checked( $instance['popularity_base'], 'comment' ) ); ?> /><label for="<?php echo esc_attr( $this->get_field_id( 'comment' ) ); ?>"><?php echo esc_html__( 'Comment Based', 'iebase' ); ?></label>
        </p>
        <p>
        <input class="radio" id="<?php echo esc_attr( $this->get_field_id( 'view' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'popularity_base' ) ); ?>" type="radio" value="view" <?php esc_attr( checked( $instance['popularity_base'], 'view' ) ); ?> /><label for="<?php echo esc_attr( $this->get_field_id( 'view' ) ); ?>"><?php echo esc_html__( 'View Based', 'iebase' ); ?></label>
        </p>

		<?php

	}

	function update( $new_instance, $old_instance ) {

		$instance = $old_instance;

		$instance['name'] = $new_instance['name'] ? strip_tags( $new_instance['name'] ) : esc_html__( 'Popular Posts', 'iebase' );
		$instance['count'] = $new_instance['count'] ? strip_tags( $new_instance['count'] ) : 5;
		$instance['popularity_base'] = $new_instance['popularity_base'];

		return $instance;

	}

	function widget( $args, $instance ) {

		extract( $args );

		$instance = wp_parse_args( ( array ) $instance, $this->defaults() );

		echo wp_kses_post( $before_widget );

		$name = apply_filters( 'widget_title', $instance['name'] );
		$count = $instance['count'];
		$popularity_base = $instance['popularity_base'];

		echo wp_kses_post( $before_title ) . esc_attr( $name ) . wp_kses_post( $after_title );

		if ( $popularity_base == 'comment' ) {

			$loop_args = array(

				'posts_per_page' => esc_attr( $count ),
				'orderby' => 'comment_count',
				'ignore_sticky_posts' => 1

			);

		} else {

			$loop_args = array(

				'posts_per_page' => esc_attr( $count ),
				'orderby'   => 'meta_value_num',
				'meta_key'  => 'post_views_count',
				'ignore_sticky_posts' => 1

			);

		}

		$widget_query = new WP_Query( $loop_args );

		while( $widget_query->have_posts() ) : $widget_query->the_post();

		?>

            <a href="<?php echo esc_url( get_the_permalink() ); ?>" class="c-teaser">
			<div class='c-teaser__media'>
			<div class='c-teaser__image js-fadein' style="background-image: url(<?php esc_url( iebase_entry_feature_image_path('ie-post-grid-thumb') ) ?>)" aria-label="<?php the_title(); ?>"></div>
            </div>
                <div class='c-teaser__content'>
                <h3 class='c-teaser__title'><?php the_title(); ?></h3>
				<?php if ( $popularity_base == 'comment' ) :?>
					<span class="c-teaser__comm"><?php echo comments_number(__('No Comment','iebase'), __('One Comment','iebase'), '% '.__('Comments','iebase'));?></span>
				<?php else:?>
				<span class="c-teaser__view"><?php if ( function_exists( 'Ie_PostViews' ) ) { echo iebase_numerical_word( Ie_PostViews(get_the_ID()) ); } ?> <?php _e( 'views', 'iebase'); ?></span>
				<?php endif; ?>
            </div>
			</a>

		<?php endwhile;

		wp_reset_postdata();

		echo wp_kses_post( $after_widget );

	}

	function defaults() {

		$defaults = array( 'name' => esc_html__( 'Popular Posts', 'iebase' ), 'count' => 5, 'day_limit' => 1, 'popularity_base' => 'comment' );
		return $defaults;

	}

}

class iebase_widget_post extends WP_Widget {

	function __construct() {

		parent::__construct( 'iebase_widget_post', esc_html__( '05. Widget Post', 'iebase' ), array( 'description' => esc_html__( "Display a single post.", 'iebase' ) ) );

	}

	function form( $instance ) {

		$instance = wp_parse_args( ( array ) $instance, $this->defaults() );

		global $post;
		$posts = get_posts( array( 'numberposts' => -1 ) );

		?>

        <p><?php echo esc_html__( 'Original Post:', 'iebase' ); ?>
		<select class="widefat" id="<?php echo esc_attr( $this->get_field_name( 'post_id' ) ); ?>"  name="<?php echo esc_attr( $this->get_field_name( 'post_id' ) ); ?>">
        	<option <?php echo esc_attr( $instance['post_id'] ) == 0 ? 'selected="selected"' : '';?> value="0"><?php echo esc_html__( '- Select a Post -', 'iebase' ); ?></option>
			<?php foreach( $posts as $post ) : setup_postdata( $post ); ?>
        	<option <?php if ( $post->ID == esc_attr( $instance['post_id'] ) ) { echo 'selected="selected"'; } ?> value="<?php echo esc_attr( $post->ID ); ?>"><?php the_title(); ?></option>
			<?php endforeach; ?>
		</select>
		</p>
        <p><?php echo esc_html__( 'Alternative Post:', 'iebase' ); ?>
		<select class="widefat" id="<?php echo esc_attr( $this->get_field_name( 'post_id_alt' ) ); ?>"  name="<?php echo esc_attr( $this->get_field_name( 'post_id_alt' ) ); ?>">
        	<option <?php echo esc_attr( $instance['post_id_alt'] ) == 0 ? 'selected="selected"' : '';?> value="0"><?php echo esc_html__( '- Select an Alternative Post -', 'iebase' ); ?></option>
			<?php foreach( $posts as $post ) : setup_postdata( $post ); ?>
        	<option <?php if ( $post->ID == esc_attr( $instance['post_id_alt'] ) ) { echo 'selected="selected"'; } ?> value="<?php echo esc_attr( $post->ID ); ?>"><?php the_title(); ?></option>
			<?php endforeach; ?>
		</select>
		</p>
        <p>
        <em><?php echo esc_html__( 'To avoid duplicated posts, you can set an alternative post which will be shown instead of the original one, on the original post page. Or simply hide this widget on the original post page by checking the box below.', 'iebase' ); ?></em>
        </p>
        <p>
		<input class="checkbox" type="checkbox" value="1" <?php esc_attr( checked( $instance['hide_widget'], 1 ) ); ?> id="<?php echo esc_attr( $this->get_field_id( 'hide_widget' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'hide_widget' ) ); ?>" />
		<label for="<?php echo esc_attr( $this->get_field_id( 'hide_widget' ) ); ?>"><?php echo esc_html__( 'Hide this widget on the original post page', 'iebase' ); ?></label>
		</p>
        <p>
		<input class="checkbox" type="checkbox" value="1" <?php esc_attr( checked( $instance['target'], 1 ) ); ?> id="<?php echo esc_attr( $this->get_field_id( 'target' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'target' ) ); ?>" />
		<label for="<?php echo esc_attr( $this->get_field_id( 'target' ) ); ?>"><?php echo esc_html__( 'Open in new window', 'iebase' ); ?></label>
		</p>

		<?php

	}

	function update( $new_instance, $old_instance ) {

		$instance = $old_instance;

		//$instance['date'] = !empty( $new_instance['date'] );
		$instance['post_id'] = $new_instance['post_id'];
		$instance['post_id_alt'] = $new_instance['post_id_alt'];
		$instance['hide_widget'] = !empty( $new_instance['hide_widget'] );
		$instance['target'] = !empty( $new_instance['target'] );

		return $instance;

	}

	function widget( $args, $instance ) {

		extract( $args );

		$instance = wp_parse_args( ( array ) $instance, $this->defaults() );

		echo wp_kses_post( $before_widget );

		//$date = $instance['date'];
		$post_id = $instance['post_id'];
		$post_id_alt = $instance['post_id_alt'];
		$hide_widget = $instance['hide_widget'];
		$target = $instance['target'];

		$pw_rand = rand( 1, 9999999 );

		//echo wp_kses_post( $before_title ) . esc_attr( $name ) . wp_kses_post( $after_title );

		if ( $post_id != 0 && ( get_the_ID() != $post_id || ( get_the_ID() == $post_id && !$hide_widget ) ) ) {

			if ( get_the_ID() == $post_id && $post_id_alt != 0 ) { $post_id = $post_id_alt; }

			$widget_query = new WP_Query( array( 'p' => $post_id ) );

			while ( $widget_query->have_posts() ) : $widget_query->the_post(); ?>

                <div class='ie-post-card <?php if ( ! has_post_thumbnail() ) :?> ie-post-card--no-image <?php endif; ?>'>
					
		        <?php if ( has_post_thumbnail() ) : ?>
                <a href='<?php the_permalink(); ?>' class='js-fadein ie-post-card__image' style='background-image: url(<?php esc_url(iebase_entry_feature_image_path('ie-post-grid-thumb')); ?>)' <?php echo 'target="'; if ( $target ) { echo '_blank'; } else { echo '_self'; } echo '"'; ?> >
                   <span title='<?php esc_html_e('Featured Post', 'iebase'); ?>'>
                  <span class='ie-post-card--featured__icon' data-icon='ei-star' data-size='s'></span>
                 </span>
                 </a>
                 <?php else:?>
                 <a href='<?php the_permalink(); ?>' class='js-fadein ie-post-card__image ie-no-thumb'>
                 <span title='<?php esc_html_e('Featured Post', 'iebase'); ?>'>
                 <span class='ie-post-card--featured__icon' data-icon='ei-star' data-size='s'></span>
                </span>
                <?php endif; ?>
                <h3 class='ie-post-post__title'><?php the_title(); ?></h3>
                    </a>
                </div>

			<?php endwhile;

			wp_reset_postdata();

			echo wp_kses_post( $after_widget );

		}

	}

	function defaults() {

		$defaults = array( 'date' => 1, 'post_id' => 0, 'post_id_alt' => 0, 'hide_widget' => 0, 'target' => 0 );
		return $defaults;

	}

}

class iebase_recent_posts extends WP_Widget {

	function __construct() {

		parent::__construct( 'iebase_recent_posts', esc_html__( '01. Recent/Random Posts', 'iebase' ), array( 'description' => esc_html__( "Display the most recent or random posts.", 'iebase' ), 'classname' => 'iebase_recent_posts' ) );

	}

	function form( $instance ) {

		$instance = wp_parse_args( ( array ) $instance, $this->defaults() );

		?>

		<p><?php echo esc_html__( 'Title:', 'iebase' ); ?> <input name="<?php echo esc_attr( $this->get_field_name( 'name' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['name'] ); ?>" class="widefat" /></p>
        <p><?php echo esc_html__( 'Number of posts to show:', 'iebase' ); ?> <input name="<?php echo esc_attr( $this->get_field_name( 'count' ) ); ?>" type="number" value="<?php echo esc_attr( $instance['count'] ); ?>" style="width: 50px;" /></p>
        <p><?php echo esc_html__( 'Display Options:', 'iebase' ); ?></p>
        <p>
        <input class="radio" id="<?php echo esc_attr( $this->get_field_id( 'recent' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'list_type' ) ); ?>" type="radio" value="recent" <?php esc_attr( checked( $instance['list_type'], 'recent' ) ); ?> /><label for="<?php echo esc_attr( $this->get_field_id( 'recent' ) ); ?>"><?php echo esc_html__( 'Show Recent Posts', 'iebase' ); ?></label>
        </p>
        <p><input class="radio" id="<?php echo esc_attr( $this->get_field_id( 'random' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'list_type' ) ); ?>" type="radio" value="random" <?php esc_attr( checked( $instance['list_type'], 'random' ) ); ?> /><label for="<?php echo esc_attr( $this->get_field_id( 'random' ) ); ?>"><?php echo esc_html__( 'Show Random Posts', 'iebase' ); ?></label>
        </p>

		<?php

	}

	function update( $new_instance, $old_instance ) {

		$instance = $old_instance;

		$instance['name'] = $new_instance['name'] ? strip_tags( $new_instance['name'] ) : esc_html__( 'Recent Posts', 'iebase' );
		$instance['count'] = $new_instance['count'] ? strip_tags( $new_instance['count'] ) : 5;
		$instance['list_type'] = $new_instance['list_type'];

		return $instance;

	}

	function widget( $args, $instance ) {

		extract( $args );

		$instance = wp_parse_args( ( array ) $instance, $this->defaults() );

		echo wp_kses_post( $before_widget );

		$name = apply_filters( 'widget_title', $instance['name'] );
		$count = $instance['count'];
		$list_type = $instance['list_type'];

		echo wp_kses_post( $before_title ) . esc_attr( $name ) . wp_kses_post( $after_title );

		if ( $list_type == 'recent' ) {

			$loop_args = array(

				'showposts' => esc_attr( $count ),
				'ignore_sticky_posts' => 1

			);

		} else {

			$loop_args = array(

				'showposts' => esc_attr( $count ),
				'orderby' => 'rand',
				'ignore_sticky_posts' => 1

			);

		}

		$widget_query = new WP_Query( $loop_args );

		while ( $widget_query->have_posts() ) : $widget_query->the_post();

		?>

            <a href="<?php echo esc_url( get_the_permalink() ); ?>" class='c-teaser'>
			<div class='c-teaser__media'>
			<div class='c-teaser__image js-fadein' style="background-image: url(<?php esc_url( iebase_entry_feature_image_path('ie-post-grid-thumb') ) ?>)" aria-label="<?php the_title(); ?>"></div>
            </div>
            <div class='c-teaser__content'>
                <h3 class='c-teaser__title'><?php the_title(); ?></h3>
				<span class='c-teaser__date'>
                <time datetime='<?php the_time( 'c' ); ?>' title='<?php the_time( 'c' ); ?>'>
                <?php echo get_the_date(get_option( 'date_format' )); ?>
                </time></span>
            </div>  
			</a>

		<?php endwhile;

		wp_reset_postdata();

		echo wp_kses_post( $after_widget );

	}

	function defaults() {

		$defaults = array( 'name' => esc_html__( 'Recent Posts', 'iebase' ), 'count' => 5, 'list_type' => 'recent' );
		return $defaults;

	}

}

class iebase_widget_search extends WP_Widget {

	function __construct() {

		parent::__construct( 'iebase_widget_search', esc_html__( '10.  Widget Search', 'iebase' ), array( 'description' => esc_html__( "A search form for your site.", 'iebase' ) ) );

	}

	function form( $instance ) {

		$instance = wp_parse_args( ( array ) $instance, $this->defaults() );

		?>

		<p><?php echo esc_html__( 'This widget do not have options.', 'iebase' ); ?></p>

		<?php

	}

	function update( $new_instance, $old_instance ) {

		$instance = $old_instance;

		return $instance;

	}

	function widget( $args, $instance ) {

		extract( $args );

		$instance = wp_parse_args( ( array ) $instance, $this->defaults() );

		echo wp_kses_post( $before_widget );

		?>

            <form class="search-widget-form" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
			    <i class="iecon-magnifier ie-search__icon"></i>
                <input class="search-widget-input" type="text" placeholder="<?php esc_html_e( 'Keyword to search', 'iebase' ); ?>" name="s" />
				<input type="submit" class="search-submit" value="<?php esc_html_e( 'Search', 'iebase' ); ?>">
            </form>

        <?php

        echo wp_kses_post( $after_widget );

	}

	function defaults() {

		$defaults = array();
		return $defaults;

	}

}

class iebase_selected_posts extends WP_Widget {

	function __construct() {

		parent::__construct( 'iebase_selected_posts', esc_html__( '04. Selected Posts', 'iebase' ), array( 'description' => esc_html__( "Display the posts you've selected.", 'iebase' ), 'classname' => 'iebase_selected_posts' ) );

	}

	function form( $instance ) {

		$instance = wp_parse_args( ( array ) $instance, $this->defaults() );

		global $post;
		$posts = get_posts( array( 'numberposts' => -1 ) );
		$first_selector = esc_html__( '- Select a Post -', 'iebase' );

		?>

        <p><?php echo esc_html__( 'Title:', 'iebase' ); ?> <input name="<?php echo esc_attr( $this->get_field_name( 'name' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['name'] ); ?>" class="widefat" /></p>

        <?php

		for ( $x = 0; $x < 5; $x++ ) {

			echo '<p>' . esc_html__( 'Post', 'iebase' ) . ' ' . ( $x + 1 ) . ':';
			echo '<select class="widefat" id="' . esc_attr( $this->get_field_name( 'post_id_' . $x ) ) . '"  name="' . esc_attr( $this->get_field_name( 'post_id_' . $x ) ) . '">';
			echo '<option ';
			echo esc_attr( $instance['post_id_' . $x ] ) == 0 ? 'selected="selected"' : '';
			echo ' value="0">' . esc_html( $first_selector ) . '</option>';
			foreach( $posts as $post ) : setup_postdata( $post );
				echo '<option ';
				if ( $post->ID == esc_attr( $instance['post_id_' . $x ] ) ) { echo 'selected="selected"'; }
				echo ' value="' . esc_attr( $post->ID ) . '">' . get_the_title() . '</option>';
			endforeach;
			echo '</select></p>';

		}

	}

	function update( $new_instance, $old_instance ) {

		$instance = $old_instance;

		$instance['name'] = $new_instance['name'] ? strip_tags( $new_instance['name'] ) : esc_html__( 'Selected Posts', 'iebase' );
		$instance['post_id_0'] = $new_instance['post_id_0'];
		$instance['post_id_1'] = $new_instance['post_id_1'];
		$instance['post_id_2'] = $new_instance['post_id_2'];
		$instance['post_id_3'] = $new_instance['post_id_3'];
		$instance['post_id_4'] = $new_instance['post_id_4'];

		return $instance;

	}

	function widget( $args, $instance ) {

		extract( $args );

		$instance = wp_parse_args( ( array ) $instance, $this->defaults() );

		echo wp_kses_post( $before_widget );

		$name = apply_filters( 'widget_title', $instance['name'] );
		$post_id_0 = $instance['post_id_0'];
		$post_id_1 = $instance['post_id_1'];
		$post_id_2 = $instance['post_id_2'];
		$post_id_3 = $instance['post_id_3'];
		$post_id_4 = $instance['post_id_4'];

		$spw_rand = rand( 1, 9999999 );

		echo wp_kses_post( $before_title ) . esc_attr( $name ) . wp_kses_post( $after_title );

		$loop_args = array(

			'post_type' => 'post',
			'post__in' => array( $post_id_0, $post_id_1, $post_id_2, $post_id_3, $post_id_4 ),
			'ignore_sticky_posts' => 1,
			'orderby' => 'post__in'

		);

		$widget_query = new WP_Query( $loop_args );

		while ( $widget_query->have_posts() ) : $widget_query->the_post();

		?>

			<a href="<?php echo esc_url( get_the_permalink() ); ?>" class="c-teaser-selected">
			<div class='c-teaser__number'><?php echo esc_attr( $widget_query->current_post + 1 ); ?></div>
            <div class='c-teaser__content'>
            <h3 class='c-teaser__title'><?php the_title(); ?></h3>
			<span class='c-teaser__date'>
            <time datetime='<?php the_time( 'c' ); ?>' title='<?php the_time( 'c' ); ?>'>
            <?php echo get_the_date(get_option( 'date_format' )); ?>
            </time></span>
            </div>
			</a>

		<?php endwhile;

		wp_reset_postdata();

		echo wp_kses_post( $after_widget );

	}

	function defaults() {

		$defaults = array( 'name' => esc_html__( 'Selected Posts', 'iebase' ), 'post_id_0' => 0, 'post_id_1' => 0, 'post_id_2' => 0, 'post_id_3' => 0, 'post_id_4' => 0 );
		return $defaults;

	}

}

class iebase_social extends WP_Widget {

	function __construct() {

		parent::__construct( 'iebase_social', esc_html__( '08. Social', 'iebase' ), array( 'description' => esc_html__( "Show your social account icons.", 'iebase' ), 'classname' => 'iebase_social' ) );

	}

	function form( $instance ) {

    if ( function_exists( 'iebase_social_names' ) ) {

  		$account_names = iebase_social_names();
  		$defaults = array( 'name' => esc_html__( 'Social Network', 'iebase' ) );
  		foreach ( $account_names as $key ) { $defaults[ $key ] = 'http://'; }
  		$instance = wp_parse_args( ( array ) $instance, $defaults );

  		?>

  		<p><?php echo esc_html__( 'Title:', 'iebase' ); ?> <input name="<?php echo esc_attr( $this->get_field_name( 'name' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['name'] ); ?>" class="widefat" /></p>
          <p><em><?php echo esc_html__( 'Write the entire URL addresses. Leave blank if not preferred.', 'iebase' ); ?></em></p>

          <?php

  		foreach ( iebase_social_labels() as $key => $lbl ) {

  			echo '<p>' . esc_html( $lbl ) . ': <input name="' . esc_attr( $this->get_field_name( $account_names[ $key ] ) ) . '" type="text" value="' . esc_attr( $instance[ $account_names[ $key ] ] ) . '" class="widefat" /></p>';

  		}

    }

	}

	function update( $new_instance, $old_instance ) {

    if ( function_exists( 'iebase_social_names' ) ) {

  		$instance = $old_instance;

  		$instance['name'] = $new_instance['name'] ? strip_tags( $new_instance['name'] ) : esc_html__( 'Social Network', 'iebase' );

  		foreach ( iebase_social_names() as $key ) {

  			$instance[ $key ] = $new_instance[ $key ] ? strip_tags( $new_instance[ $key ] ) : 'http://';

  		}

  		return $instance;

    }

	}

	function widget( $args, $instance ) {

    if ( function_exists( 'iebase_social_names' ) ) {

  		extract( $args );

  		$defaults = array( 'name' => esc_html__( 'Social Network', 'iebase' ) );
  		foreach ( iebase_social_names() as $key ) { $defaults[ $key ] = 'http://'; }
  		$instance = wp_parse_args( ( array ) $instance, $defaults );

  		echo wp_kses_post( $before_widget );

  		$icons = iebase_social_icons();
  		$social_accounts = array();

  		$name = apply_filters( 'widget_title', $instance['name'] );

  		foreach ( iebase_social_names() as $key ) {

  			$$key = $instance[ $key ];
  			array_push( $social_accounts, $$key );

  		}

  	    ?>

        <?php

  		echo wp_kses_post( $before_title ) . esc_attr( $name ) . wp_kses_post( $after_title );

  		echo '<ul class="social__li">';

  		foreach ( $social_accounts as $key => $sa ) {

  			if ( $sa != 'http://' && $sa != '' ) {

  				echo '<li><a href="' . esc_url( $sa ) . '" target="_blank"><i class="iecon-' . esc_attr( $icons[ $key ] ) . '"></i></a></li>';

  			}

  		}

  		echo '</ul>';

  		echo wp_kses_post( $after_widget );

    }

	}

}

class iebase_tabs_posts extends WP_Widget {

	function __construct() {
		$widget_ops = array( 'classname' => 'iebase_tabs_posts', 'description' => __('A widget to display Popular posts, latest posts and latest comments.', 'iebase') );

		parent::__construct( 'iebase-tabs-posts', __('07. Tabs Posts', 'iebase'), $widget_ops);
	}
	
	function widget( $args, $instance ) {
		extract( $args );

		//Our variables from the widget settings.
		$limit = ($instance['limit']) ? $instance['limit'] : 5;

		$hi_com_post = new WP_Query( apply_filters( 'widget_posts_args', array( 'posts_per_page' => $limit, 'no_found_rows' => true, 'post_status' => 'publish',  'orderby' =>'comment_count', 'ignore_sticky_posts' => true ) ) ); 
		$recent = new WP_Query( apply_filters( 'widget_posts_args', array( 'posts_per_page' => $limit, 'no_found_rows' => true, 'post_status' => 'publish', 'ignore_sticky_posts' => true ) ) ); 

		if ($hi_com_post->have_posts()) :
		echo $before_widget;
		?>
		   <div class="tab-slider--nav" id="widget-tabs">
				<ul class="tab-slider--tabs">
					<li class="tab-slider--trigger active" rel="tab1"><?php esc_html_e( 'Popular', 'iebase' ); ?></li>
					<li class="tab-slider--trigger" rel="tab2"><?php esc_html_e( 'Recent', 'iebase' ); ?></li>
					<li class="tab-slider--trigger" rel="tab3"><?php esc_html_e( 'Comments', 'iebase' ); ?></li>
				</ul>
			</div>
			<div class="tab-slider--container">
			   <div class="tab-slider--body" id="tab1">
					<?php 
						while( $hi_com_post->have_posts() ) : $hi_com_post->the_post(); ?>
						   <a href="<?php echo esc_url( get_the_permalink() ); ?>" class='c-teaser-simple'>
			               <span class="c-teaser__number"><?php echo esc_attr( $hi_com_post->current_post + 1 ); ?></span><span class="c-teaser__content"><?php the_title(); ?></span>
			               </a>
							<?php endwhile; ?>
							<?php endif;
							wp_reset_query(); ?>
						
				</div><!-- end of tab1 -->
					
				<div class="tab-slider--body" id="tab2">
						<?php if ($recent->have_posts()) : ?>
							<?php  while ( $recent->have_posts() ) : $recent->the_post(); ?>
							<a href="<?php echo esc_url( get_the_permalink() ); ?>" class='c-teaser-simple'>
							<span class="c-teaser__number"><?php echo esc_attr( $recent->current_post + 1 ); ?></span><span class="c-teaser__content"><?php the_title(); ?></span>
			                </a>
							<?php endwhile; wp_reset_query(); ?>
				</div>		<!-- end of tab2 -->
					
				<div class="tab-slider--body" id="tab3">
				<?php 
	                            $args = array(
									'status' => 'approve',
									'number' => '5'
								);
								$comments = get_comments($args);
								foreach($comments as $comment) : ?>
	                                    <a class='c-teaser-simple' href="<?php echo get_permalink($comment->comment_post_ID); ?>#comment-<?php echo $comment->comment_ID; ?>"><?php $str = $comment->comment_content; 
												$len_count = strlen($str);
											if ( $len_count >=51){
													echo '<span class="c-teaser__author">'.($comment->comment_author . '</span><span class="c-teaser__content"> ' .substr($str,0,50).'...' ) ;
													echo '</span>';
											} else {
												echo '<span class="c-teaser__author">'.($comment->comment_author . '</span><span class="c-teaser__content"> ' .$str ) ; 
												echo '</span>';
											} ?>
										</a>
	                            <?php endforeach; ?>
						
				</div>	
		</div>
		<?php
		echo $after_widget;
		wp_reset_postdata();
	 endif;
	}


	//Update the widget 
	 
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		//$instance['title'] 			= strip_tags( $new_instance['title'] );
		$instance['limit'] 			= strip_tags( $new_instance['limit'] );
		return $instance;
	}

	function form($instance) {
	  //if(!isset($instance['title'])) $instance['title'] = __('Latest Tab' , 'dsf');
	  if(!isset($instance['limit'])) $instance['limit'] = 5;
		?>
	  <b><label style="width:100px;" for="<?php echo $this->get_field_id('limit'); ?>">
	  <?php _e('Limit Posts Number ','iebase') ?></label></b>
	  <br />
	  <input type="text" style="float:left; clear: both; width: 100%; padding: 3px;" value="<?php echo esc_attr($instance['limit']); ?>" name="<?php echo $this->get_field_name('limit'); ?>" id="<?php $this->get_field_id('limit'); ?>" />
	  <br />
		<?php
	}
}


class iebase_category_titles extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function __construct() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'iebase_category_titles', 'description' => esc_html__('Displays Category Titles.', 'iebase') );

		/* Create the widget. */
		parent::__construct( 'iebase_category_titles', esc_html__('12. Widget Category Tiles', 'iebase'), $widget_ops);
	}
    
	/**
	 *display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );
        
        $widget_opts = array();
        $title       = $instance['title'];
        $instance['tile_description'] = strip_tags($instance['tile_description']);
        $category_ids =  explode( ',', $instance['category_ids'] );
		
		echo $before_widget;
		if ( $title ) { echo $before_title . $title . $after_title; }

        ?>
        
            <ul class="category-tile list-unstyled">
                <?php
                    echo get_category_tiles($category_ids, $instance['tile_description']);
                ?>
            </ul>
        
        <?php
        /* After widget (defined by themes). */
		echo ($after_widget);
	}
	
	/**
	 * update widget settings
	 */
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
        $instance['title']          = $new_instance['title'];
        $instance['tile_description']  = strip_tags($new_instance['tile_description']);
        $instance['category_ids']   = $new_instance['category_ids'];
		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form( $instance ) {
		$defaults = array('title' => 'Categories', 'tile_description' => '', 'category_ids' => '');
		$instance = wp_parse_args((array) $instance, $defaults);
	?>
        <p>
			<label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><strong><?php esc_html_e('[Optional] Title:', 'iebase'); ?></strong></label>
			<input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" value="<?php if( !empty($instance['title']) ) echo esc_attr($instance['title']); ?>" />
		</p>
        
        <p>
		    <label for="<?php echo esc_attr($this->get_field_id( 'tile_description' )); ?>"><?php esc_attr_e('Tile Description :', 'iebase'); ?></label>
		    <select class="widefat" id="<?php echo esc_attr($this->get_field_id( 'tile_description' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'tile_description' )); ?>" >
			    <option value="description" <?php if( !empty($instance['tile_description']) && $instance['tile_description'] == 'description' ) echo 'selected="selected"'; else echo ""; ?>><?php esc_attr_e('Category description', 'iebase'); ?></option>
			    <option value="post-count" <?php if( !empty($instance['tile_description']) && $instance['tile_description'] == 'post-count' ) echo 'selected="selected"'; else echo ""; ?>><?php esc_attr_e('Post Count', 'iebase'); ?></option>
			    <option value="disable" <?php if( !empty($instance['tile_description']) && $instance['tile_description'] == 'disable' ) echo 'selected="selected"'; else echo ""; ?>><?php esc_attr_e('Disable', 'iebase'); ?></option>
			 </select>
	    </p>
        
        <p>
		    <label for="<?php echo esc_attr($this->get_field_id( 'category_ids' )); ?>"><?php esc_attr_e('Categories: (Separate category ids by the comma. e.g. 1,2):','iebase') ?></label>
		    <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id( 'category_ids' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'category_ids' )); ?>" value="<?php if( !empty($instance['category_ids']) ) echo esc_attr($instance['category_ids']); ?>" />
	    </p>
<?php
	}
}

class iebase_toptags extends WP_Widget {
	function __construct() {
	 $widget_ops = array('description' => esc_html__('Display your most used Tags.', 'iebase'));
	 parent::__construct(false, $name = ''. esc_html__('13. Most used Tags', 'iebase') .'',$widget_ops); 
   }

  function widget($args, $instance) {  
	   extract( $args );
	   $title = $instance['title'];
	   $number = $instance['number'];
?>		

<?php echo $before_widget; ?>	
<?php if ( $title ) echo $before_title . esc_attr($title) . $after_title; ?>

 <div class="tagcloud">
  <?php wp_tag_cloud('orderby=count&order=RAND&number='.esc_attr($number).''); ?>
  <div class="clear"></div>
 </div>

 <?php echo $after_widget; ?>
 
<?php
   }

	function update($new_instance, $old_instance) {				
		   $instance = $old_instance;
		   $instance['title'] = strip_tags($new_instance['title']);
		   $instance['number'] = strip_tags($new_instance['number']);
	return $instance;
   }

	function form( $instance ) {
	   //$instance = wp_parse_args( (array) $instance );
	   $instance = wp_parse_args( ( array ) $instance, $this->defaults() );
?>


		<p>
		 <label for="<?php echo $this->get_field_id('title'); ?>"><?php esc_html_e( 'Title:', 'iebase' ); ?></label> 
		 <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php if( isset($instance['title']) ) echo esc_attr($instance['title']); ?>" />
	   </p>
	 

		<p>
		 <label for="<?php echo $this->get_field_id('number'); ?>"><?php esc_html_e( 'Number of Posts:', 'iebase' ); ?></label> 
		 <input class="widefat" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php if( isset($instance['number']) ) echo esc_attr($instance['number']); ?>" />
	   </p>

<?php  
	} 
	function defaults() {

		$defaults = array( 'title' => esc_html__( 'Most used Tags', 'iebase' ), 'number' => 20 );
		return $defaults;

	}
}

class iebase_about_widget extends WP_Widget {

    // setup the widget name, description etc.
    function __construct() {

        parent::__construct( 'iebase_about', esc_html__( '14. Widget:About', 'iebase' ), array( 'description' => esc_html__( "You can place your site info here.", 'iebase' ) ) );
    }

    // front-end display of widget
    function widget( $args, $instance ) {

        extract( $args );
        echo $args['before_widget'];

        if ( ! empty( $instance['title'] ) ) {
            echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
        }

        if ( ! empty( $instance['logo_url'] ) ) {
            $alt = get_post_meta( attachment_url_to_postid($instance['logo_url']), '_wp_attachment_image_alt', true );
            ?>
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
                    <img class="logo__img" src="<?php echo esc_url( $instance['logo_url'] ); ?>" alt="<?php echo esc_attr( $alt ); ?>">
                </a>
            <?php
        }

        if ( ! empty( $instance['description'] ) ) {
            printf('<p class="description">%s</p>', $instance['description'] );
        }

        echo $args['after_widget'];
    }


    // back-end display of widget
    function form( $instance ) {

        $instance = wp_parse_args(
            (array) $instance,
            array(
                'title' => 'About',
                'description' => ''
            )
        );

        $title = ( ! empty( $instance['title'] ) ? $instance['title'] : '' );
        $description = ( ! empty( $instance['description'] ) ? $instance['description'] : '' );
        $logo = ( ! empty( $instance['logo_url'] ) ? $instance['logo_url'] : '' );

        ?>

            <!-- Title -->
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id('title') ); ?>"><?php esc_attr_e( 'Title', 'neotech' ); ?></label>
                <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
            </p>

            <!-- Image -->
            <h4><?php esc_attr_e( "Choose your logo", 'neotech' ); ?></h4>
            <p>
                <img class="ie-logo-media" src="<?php if (isset($instance['logo_url']) && $instance['logo_url'] != '' ) :
                        echo esc_url( $instance['logo_url'] );
                    endif; ?>" style="display: block; max-width: 100%"
                />
            </p>
            <p>
                <input type="hidden" class="ie-logo-hidden-input widefat" name="<?php echo $this->get_field_name( 'logo_url' ); ?>" id="<?php echo $this->get_field_id( 'logo_url' ); ?>" value="<?php
                    if (isset($instance['logo_url']) && $instance['logo_url'] != '' ) :
                        echo esc_url( $instance['logo_url'] );
                     endif;
                ?>" />
                <input type="button" class="ie-logo-upload-button button button-primary" value="<?php esc_attr_e('Choose logo','neotech')?>">
                <input type="button" class="ie-logo-delete-button button" value="<?php esc_attr_e('Remove logo', 'neotech') ?>">
            </p>

            <!-- Description -->
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id('description') ); ?>"><?php esc_attr_e( 'Description', 'neotech' ); ?></label>
                <textarea id="<?php echo esc_attr( $this->get_field_id('description') ); ?>" name="<?php echo esc_attr( $this->get_field_name('description') ); ?>"  class="widefat" rows="5"><?php echo esc_textarea( $description ); ?></textarea>
            </p>

        <?php
    }


    // update of the widget
    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['description'] = wp_kses_post( $new_instance['description'] );
        $instance['logo_url'] = ( ! empty( $new_instance['logo_url'] ) ) ? strip_tags( $new_instance['logo_url'] ) : '';
        $instance['socials'] = (bool)$new_instance['socials'];
        return $instance;
    }
}


if ( !function_exists( 'iebase_widgets_register' ) ) {
	function iebase_widgets_register() {

		// Register Widgets
		if ( class_exists( 'iebase_widget_ads' ) ) { register_widget( 'iebase_widget_ads' ); }
		if ( class_exists( 'iebase_widget_search' ) ) { register_widget( 'iebase_widget_search' ); }
		if ( class_exists( 'iebase_social' ) ) { register_widget( 'iebase_social' ); }
		if ( class_exists( 'iebase_widget_image' ) ) { register_widget( 'iebase_widget_image' ); }
		if ( class_exists( 'iebase_widget_post' ) ) { register_widget( 'iebase_widget_post' ); }
		if ( class_exists( 'iebase_recent_posts' ) ) { register_widget( 'iebase_recent_posts' ); }
		if ( class_exists( 'iebase_popular_posts' ) ) { register_widget( 'iebase_popular_posts' ); }
		if ( class_exists( 'iebase_selected_posts' ) ) { register_widget( 'iebase_selected_posts' ); }
		if ( class_exists( 'iebase_category_posts' ) ) { register_widget( 'iebase_category_posts' ); }
		if ( class_exists( 'iebase_tabs_posts' ) ) { register_widget( 'iebase_tabs_posts' ); }
		if ( class_exists( 'iebase_category_titles' ) ) { register_widget( 'iebase_category_titles' ); }
		if ( class_exists( 'iebase_toptags' ) ) { register_widget( 'iebase_toptags' ); }
		if ( class_exists( 'iebase_about_widget' ) ) { register_widget( 'iebase_about_widget' ); }

		unregister_widget('WP_Widget_Pages');
        unregister_widget('WP_Widget_Calendar');
        unregister_widget('WP_Widget_Archives');
        unregister_widget('WP_Widget_Links');
        unregister_widget('WP_Widget_Meta');
        unregister_widget('WP_Widget_Search');
        unregister_widget('WP_Widget_Text');
        unregister_widget('WP_Widget_Categories');
        unregister_widget('WP_Widget_Recent_Posts');
        unregister_widget('WP_Widget_Recent_Comments');
        unregister_widget('WP_Widget_RSS');
        unregister_widget('WP_Widget_Tag_Cloud');
		unregister_widget('WP_Nav_Menu_Widget');
		unregister_widget('WP_Widget_Media_Audio');
        unregister_widget('WP_Widget_Media_Image');
		unregister_widget('WP_Widget_Media_Video');
		unregister_widget('WP_Widget_Media_Gallery');
        unregister_widget('WP_Widget_Custom_HTML');

	}
}
add_action( 'widgets_init', 'iebase_widgets_register' );

/* */

function get_category_tiles($category_ids, $catDescription = 'disable'){
	$categoryTiles = '';
	$moduleHTML = new iebase_category_tile;
	foreach ($category_ids as $catID ) {
		$categoryAttr = array(
			//'additionalClass' => 'category-tile--sm',
			//'thumbSize'     => 'suga-xs-2_1',
			'catID'         => $catID,
			'description'   => '',
		);
		if($catDescription == 'description') {
			$categoryAttr['description'] = category_description( $catID ); 
		}else if($catDescription == 'post-count') {
			$categoryInfo = get_category($catID); 
			$categoryAttr['description'] = $categoryInfo->category_count . esc_html__(' Articles', 'iebase');
		}else {
			$categoryAttr['description'] = '';
		}
		$categoryTiles .= '<li class="category-tile__li cat-'.trim($catID).'">';
		$categoryTiles .= $moduleHTML->render($categoryAttr);
		$categoryTiles .= '</li>';
	}
	return $categoryTiles;
}

if (!class_exists('iebase_category_tile')) {
    class iebase_category_tile {
        
        function render($postAttr) {
            ob_start();
            if(isset($postAttr['catID'])) {
                $catID = intval($postAttr['catID']);
            }else {
                return ob_get_clean();
            }
            ?>
                <div class="category-tile__wrap">
						<div class="category-tile__text">
							<div class="category-tile__name"><?php echo get_cat_name($catID);?></div>
							<?php if((isset($postAttr['description'])) && (isset($postAttr['description']) != '')) echo '<div class="category-tile__description">'. $postAttr['description'] .'</div>';?>
						</div>
					<a href="<?php echo get_category_link( $catID )?>" class="link-overlay" title="<?php echo esc_html__( 'View all World', 'iebase' ); ?>"></a>
                </div>
            <?php return ob_get_clean();
        }
        
    }
}

if ( ! function_exists('tag_cloud_count')) {
	function tag_cloud_count($content, $tags, $args)
	{ 
	  $count=0;
	  $output=preg_replace_callback('(</a\s*>)', 
	  function($match) use ($tags, &$count) {
		  return "<span class=\"tagcount\"> ".$tags[$count++]->count."</span></a>";  
	  }
	  , $content);
	  
	  return $output;
	}
	//add_filter('wp_generate_tag_cloud','tag_cloud_count', 10, 3); 
	}

// Enqueue additional admin scripts
add_action('admin_enqueue_scripts', 'iebase_wdscript');
function iebase_wdscript() {
    wp_enqueue_media();
    wp_enqueue_script('ads_script', get_template_directory_uri() . '/assets/js/widgets.js', false, '1.0.0', true);
}


?>

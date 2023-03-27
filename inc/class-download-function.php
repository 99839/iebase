<?php

add_action('wp_enqueue_scripts','iebase_demo_template_script');
function iebase_demo_template_script(){
    global $post;
    $get_down = get_query_var( 'down' );
    $get_demo = get_query_var( 'demo' );
    if ( is_page_template('page-dl-demo.php') ) {
        //$down_slug = $_GET["down"];
        //$down_id = iebase_get_post_id_by_slug($down_slug);
        //$ie_download = get_post_meta($down_id , 'iebase_download_links', true);
        if ( $get_down ) {
            $down_slug = $_GET["down"];
            $down_id = iebase_get_post_id_by_slug($down_slug);
            $ie_download = get_post_meta($down_id , 'iebase_download_links', true);
            wp_enqueue_script( 'iebase-down-script', get_template_directory_uri() . '/assets/js/download.js', array(), '1.0.4', true );
            wp_localize_script( 'iebase-down-script', 'ie_down_vars', array(
                'dlbutton' => __( 'Download Now', 'iebase' ),
                'admessage' => __( 'Please disable your Ad-Block! Otherwise download button will not be displayed', 'iebase' ),
                'dllink' => iebase_download_link($ie_download),
            ) );
        }
        if ( $get_demo ) {
            wp_enqueue_style( 'demo-style', get_template_directory_uri() . '/assets/css/demo.min.css' );
            wp_enqueue_script( 'iebase-demo-script', get_template_directory_uri() . '/assets/js/demo.min.js', array(), '1.0.4', false );

        }
    }
}

//add_filter( 'pre_get_document_title', 'iebase_change_items_title', 1 );
function iebase_change_items_title( $title ) {
    global $post;
    $get_down = get_query_var( 'down' );
    $get_demo = get_query_var( 'demo' );
    $demo_slug = $_GET["demo"];
    $down_slug = $_GET["down"];
    $down_id = iebase_get_post_id_by_slug($down_slug);
    $demo_id = iebase_get_post_id_by_slug($demo_slug);
    $down_prefix = __( 'Download', 'iebase' );
    $demo_prefix = __( 'demo', 'iebase' );
    $down_title = get_the_title($down_id);
    $demo_title = get_the_title($demo_id);
    if ( is_page_template('page-dl-demo.php') ) {
        if ( $get_down ) {
            $title = $down_prefix . $down_title .' - '. get_bloginfo('name');
        }
        if ( $get_demo ) {
            $title = $demo_prefix . $demo_title .' - '. get_bloginfo('name');
        }
        return $title;
    }
    return $title;
}

function iebase_get_post_id_by_slug($post_slug, $slug_post_type = 'post') {
	$post = get_page_by_path($post_slug, OBJECT, $slug_post_type);
        if ($post) {
		return $post->ID;
	} else {
		return null;
	}
}

function iebase_encrypt_decrypt($action, $string) {
    $output = false;
    $encrypt_method = "AES-256-CBC";
    $secret_key = 'SecretKey'.get_bloginfo('url');
    $secret_iv = 'SecretKeyIV'.get_bloginfo('url');
    $key = hash('sha256', $secret_key);

    $iv = substr(hash('sha256', $secret_iv), 0, 16);
    if ( $action == 'encrypt' ) {
        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
    } else if( $action == 'decrypt' ) {
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }
    return $output;
}

function iebase_download_link($url) {

	return add_query_arg( 'download_link', iebase_encrypt_decrypt( 'encrypt', $url ), get_bloginfo('url')  );

	return $url;
}

add_action( 'wp', 'redirect_download_link' );
function redirect_download_link() {
	$dl = get_query_var( 'download_link' );
	if( $dl ) {
		$dl = iebase_encrypt_decrypt( 'decrypt', $dl );
		wp_redirect($dl);
		exit;
	}
}

function add_query_vars_filter( $vars ){
	$vars[] = "down";
    $vars[] = "demo";
    $vars[] = "download_link";
	return $vars;
}
add_filter( 'query_vars', 'add_query_vars_filter' );

add_filter( 'wp_head', 'iebase_noindex_downloadpage', 1 );
function iebase_noindex_downloadpage() {
    $noindex = '';

    if ( is_page_template('page-dl-demo.php') ) {
        $noindex = '<meta name="robots" content="follow,noindex,noodp,noydir"/>';
    }
    echo $noindex . "\n";
}

function iebase_single_item_images() {
    ?>
    <?php if ( has_post_thumbnail() ) : ?>
    <div class='dl-thumbnail js-fadein ie-post-card__image' style='background-image: url(<?php esc_url(iebase_entry_feature_image_path('ie-post-grid-thumb')); ?>)'>
    </div>
    <?php else:?>
    <div class='js-fadein ie-post-card__image ie-no-thumb'>
    </div>
    <?php endif; ?>
    <?php
}
add_action( 'iebase_post_detail_start', 'idp_single_infoapp' , 12, 3  );
function idp_single_infoapp() {
    global $post;
    $post_slug=$post->post_name;
    $download_items = get_post_meta( $post->ID, 'iebase_download_items', true );
    $download_author = get_post_meta( $post->ID, 'iebase_download_author', true );
    $download_official = get_post_meta( $post->ID, 'iebase_download_official', true );
    $download_license = get_post_meta( $post->ID, 'iebase_download_license', true );
    $base_link = get_permalink( get_page_by_path( 'items' ) );
    $ie_download = get_post_meta($post->ID, 'iebase_download_links', true);
    $get_download = get_query_var( 'down' );
    if( empty($download_items)  ){
        return;
    }
    ?>
    <div class="ie-download__box">
    <div class="info-left__block">
        <?php echo iebase_single_item_images(); ?>
        </div>
        <div class="info-right__block">
            <div class="info-meta">
            <ul class="info-meta__item">
            <?php if ( has_category() ) : ?>
                <li class="info_categories">
                    <span class="meta__name"><?php echo __( 'Categories', 'iebase' ); ?></span>
                    <span class="meta__value"><?php the_category(' '); ?></span>
                </li>
            <?php endif; ?>
            </li>
            <?php echo (!empty($download_author)) ? '<li class="info_size"><span class="meta__name">'.__( 'Author', 'iebase' ).'</span><span class="meta__value">'.$download_author.'</span></li>' : '--'; ?>
            <?php echo (!empty($download_license)) ? '<li class="info_license"><span class="meta__name">'.__( 'License', 'iebase' ).'</span><span class="meta__value">'.$download_license.'</span></li>' : 'GPGL'; ?>
            <?php echo (!empty($download_official)) ? '<li class="info_official"><span class="meta__name">'.__( 'Official Website', 'iebase' ).'</span><span class="meta__value"><a href="'.$download_official.'" target="_blank" rel="nofollow">'.__( 'Go to website', 'iebase' ).'</a></span></li>' : 'ietheme'; ?>
            </ul>
            <?php
            if( !empty($download_items) ) {
            ?>
            <div class="dd-button-stack">
            <a href="<?php echo add_query_arg('down', $post_slug , $base_link) ; ?>" class="dd-btn dd-download" target="_blank" rel="nofollow" title="<?php echo __( 'down', 'iebase' ); ?>"><span class="dd-icon iecon-download"></span><span class="text"><?php echo __( 'Download Now', 'iebase' ); ?></span></a>
            <a href="<?php echo add_query_arg('demo', $post_slug , $base_link) ; ?>" class="dd-btn dd-demo" target="_blank" rel="nofollow" title="<?php echo __( 'demo', 'iebase' ); ?>"><span class="dd-icon iecon-screen"></span><span class="text"><?php echo __( 'Live Preview', 'iebase' ); ?></span></a>
            <?php } ?>
            </div>
        </div>
    </div>
    </div>
    <?php
}
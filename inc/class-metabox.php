<?php
/**
 * Description: A sample meta box for post
 */
require get_template_directory() . '/inc/class-meta-box.php';

add_action( 'admin_init', 'iebase_meta_fields' );


function iebase_meta_fields() {
    $args = array(
        'meta_box_id'   =>  'iebase_post_link',
        'label'         =>  __( 'AD Post' , 'iebase'),
        'post_type'     =>  array( 'post'),
        'context'       =>  'normal', // side|normal|advanced
        'priority'      =>  'high', // high|low
        'hook_priority'  =>  10,
        'fields'        =>  array(
            array(
                'name'      =>  'iebase_ad_url',
                'label'     =>  __( 'Ad URL', 'iebase' ),
                'type'      =>  'url',
                'desc'      =>  __( 'This is a sponsor url.', 'iebase' ),
                'default'   =>  'https://ietheme.com',
            ),
            array(
                'name'      =>  'iebase_ad_button_value',
                'label'     =>  __( 'Ad Button Value', 'iebase'),
                'type'      =>  'text',
                'desc'      =>  __( 'Ad Button Value text.', 'iebase' ),
                'default'   =>  __( 'Buy Now !', 'iebase' ),
            ),
            array(
                'name'      =>  'iebase_ad_extra_field',
                'label'     =>  __( 'Ad Extra Field', 'iebase'),
                'type'      =>  'text',
                'desc'      =>  __( 'You can add extra information about ad , etc. price, name,.', 'iebase' ),
                'default'   =>  __( 'was $300 now only $250', 'iebase' ),
            ),
            array(
                'name'      =>  'iebase_sponsored_text',
                'label'     =>  __( 'Sponsored Text', 'iebase'),
                'type'      =>  'text',
                'desc'      =>  __( 'This is a sponsored text.', 'iebase' ),
                'default'   =>  __( 'Ad Post', 'iebase' ),
            ),
        )
    );

    iebase_meta_box( $args );
}
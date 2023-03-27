<?php
// Meta Box Class: DownloadInformationMetaBox
/**
 * Description: A sample meta box for post
 */
require get_template_directory() . '/inc/class-meta-box.php';

add_action( 'admin_init', 'iebase_download_meta_fields' );


function iebase_download_meta_fields() {
    $args = array(
        'meta_box_id'   =>  'iebase_download_link',
        'label'         =>  __( 'Download Information' , 'iebase'),
        'post_type'     =>  array( 'post'),
        'context'       =>  'normal', // side|normal|advanced
        'priority'      =>  'high', // high|low
        'hook_priority'  =>  9,
        'fields'        =>  array(
            array(
                'name'      =>  'iebase_download_items',
                'label'     =>  __( 'Enable Download Function', 'iebase' ),
                'type'      =>  'checkbox',
                'default'   =>  0,
            ),
            array(
                'name'      =>  'iebase_download_links',
                'label'     =>  __( 'Download Links', 'iebase' ),
                'type'      =>  'file',
                'default'   =>  'https://ietheme.com',
            ),
            array(
                'name'      =>  'iebase_demo_links',
                'label'     =>  __( 'Demo Links', 'iebase'),
                'type'      =>  'url',
                'default'   =>  'https://ietheme.com',
            ),
            array(
                'name'      =>  'iebase_download_author',
                'label'     =>  __( 'Author', 'iebase'),
                'type'      =>  'text',
                'default'   =>  __( 'ietheme', 'iebase'),
            ),
            array(
                'name'      =>  'iebase_download_official',
                'label'     =>  __( 'Official Website', 'iebase'),
                'type'      =>  'url',
                'default'   =>  'https://ietheme.com',
            ),
            array(
                'name'      =>  'iebase_download_license',
                'label'     =>  __( 'License', 'iebase'),
                'type'      =>  'text',
                'default'   =>  __( 'MIT', 'iebase'),
            ),
        )
    );

    iebase_meta_box( $args );
}
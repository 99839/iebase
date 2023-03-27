<?php
/**
 * Iebase Theme Customizer.
 *
 * @package Iebase
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function iebase_customize_register( $wp_customize ) {
  // Remove Colors option from theme customizer
  $wp_customize->remove_section('colors');
  $wp_customize->remove_section('custom_css');
  $wp_customize->remove_section('static_front_page');

  // Display Search Icon
/*  $wp_customize->add_setting( 'display_search_icon' , array(
    'sanitize_callback'	=> 'wp_kses_post'
  ) );*/

  // hero header
  $wp_customize->add_setting( 'hero_header_title' , array(
    'sanitize_callback'	=> 'wp_kses_post'
  ) );

  $wp_customize->add_control ( 'hero_header_title', array(
    'label'       => __( 'Hero Header Title', 'iebase' ),
    'description'	=> esc_html__( 'Customize the header hero title', 'iebase' ),
		'type'        => 'text',
    'section'     => 'header_image',
    'settings'    => 'hero_header_title'
  ) );

  $wp_customize->add_setting( 'hero_header_description' , array(
    'sanitize_callback'	=> 'wp_kses_post'
  ) );

  $wp_customize->add_control ( 'hero_header_description', array(
    'label'       => __( 'Hero Header', 'iebase' ),
    'description'	=> esc_html__( 'Customize the header hero text. (HTML is allowed)', 'iebase' ),
		'type'        => 'textarea',
    'section'     => 'header_image',
    'settings'    => 'hero_header_description'
  ) );

  $wp_customize->add_setting( 'hero_header_text' , array(
	  'default'     => esc_html__( 'Learn More', 'blod' ),
	  'sanitize_callback'	=> 'wp_kses_post'
    ) );

  $wp_customize->add_control ( 'hero_header_text', array(
	  'description' => __( 'Hero Header Text', 'iebase' ),
	  'type'        => 'text',
    'section'     => 'header_image',
    'settings'    => 'hero_header_text',
  ) );

  $wp_customize->add_setting( 'hero_header_url', array(
    'default'     => esc_url( 'https://' ),
    'sanitize_callback' => 'esc_url',
  ) );

  $wp_customize->add_control( 'hero_header_url', array(
    'description'   => esc_html__( 'Hero Header URL', 'iebase' ),
    'type' => 'url',
    'section' => 'header_image',
    'settings'    => 'hero_header_url',
  ) );

  //hero animation
  $wp_customize->add_setting( 'hero_animation', array(
		'default' => 1,
		'sanitize_callback' => 'iebase_checkbox_sanitize',
	) );

	$wp_customize->add_control( 'hero_animation', array(
		'label'     => __( 'Enable Animation?', 'iebase' ),
		'section'   => 'header_image',
		'type'      => 'checkbox'
  ) );

  // General
  $wp_customize->add_section( 'general_section' , array(
    'title'      => __( 'General', 'iebase' ),
    'priority'   => 81,
  ) );

  // pagination
  $wp_customize->add_setting( 'pagination_post_loop', array(
    'default' => 'loadmore',
    'sanitize_callback' => 'iebase_radio_select_sanitize',
  ) );

  $wp_customize->add_control( 'pagination_post_loop', array(
    'type' => 'radio',
    'label'	=> esc_html__( 'Pagination In Main Loop', 'iebase' ),
    'description' => esc_html__('Check on Which Pagination you want to use','iebase'),
    'section' => 'general_section',
    'choices' => array(
        'loadmore' =>__('Load More Pagination', 'iebase'),
        'numeric' => __('Numeric Pagination', 'iebase'),
      ),
  ) );

  //breadcrumbs notice
  $wp_customize->add_setting( 'breadcrumbs_notice', array(
		'default' => '',
		'transport' => 'postMessage',
		'sanitize_callback' => 'iebase_text_sanitization'
  ) );

  $wp_customize->add_control( new Simple_Notice_Custom_control( $wp_customize, 'breadcrumbs_notice',
	array(
		'label' => __( 'Breadcrumbs Control' , 'iebase' ),
		'description' => __('Control the breadcrumbs option.' , 'iebase' ),
		'section' => 'general_section'
	  )
  ) );

  //breadcrumbs
  $wp_customize->add_setting( 'breadcrumbs', array(
		'default' => 1,
		'sanitize_callback' => 'iebase_checkbox_sanitize',
	) );

	$wp_customize->add_control( 'breadcrumbs', array(
		'label'     => __( 'Enable Breadcrumbs?', 'iebase' ),
		'section'   => 'general_section',
		'type'      => 'checkbox'
  ) );

  //breadcrumbs delimiter
  $wp_customize->add_setting( 'breadcrumbs_delimiter', array(
		'default'     => esc_html__( '/', 'iebase' ),
	  'sanitize_callback'	=> 'wp_kses_post'
	) );

	$wp_customize->add_control( 'breadcrumbs_delimiter', array(
		'description' => __( 'Breadcrumbs Delimiter', 'iebase' ),
	  'type'        => 'text',
    'section'     => 'general_section',
  ) );

  //breadcrumb structure data
  $wp_customize->add_setting( 'structure_data', array(
		'default' => 1,
		'sanitize_callback' => 'iebase_checkbox_sanitize',
	) );

	$wp_customize->add_control( 'structure_data', array(
		'label'     => __( 'Enable Structure data of the Breadcrumb?', 'iebase' ),
		'section'   => 'general_section',
		'type'      => 'checkbox'
  ) );

  //search notice
  $wp_customize->add_setting( 'search_notice', array(
		'default' => '',
		'transport' => 'postMessage',
		'sanitize_callback' => 'iebase_text_sanitization'
  ) );

  $wp_customize->add_control( new Simple_Notice_Custom_control( $wp_customize, 'search_notice',
	array(
		'label' => __( 'Search Control' , 'iebase' ),
		'description' => __('Control the Search option.' , 'iebase' ),
		'section' => 'general_section'
	  )
  ) );

  $wp_customize->add_setting( 'display_search_icon' , array(
    'sanitize_callback'	=> 'wp_kses_post'
  ) );

  $wp_customize->add_control( 'display_search_icon', array(
    'label'       => __( 'Display Search Icon', 'iebase' ),
    'description'	=> esc_html__( '', 'iebase' ),
		'type'        => 'checkbox',
    'section'     => 'general_section',
    'settings'    => 'display_search_icon',
  ) );

  // Hot search words
    $wp_customize->add_setting( 'hot-search-word' , array(
      'sanitize_callback'	=> 'wp_kses_post'
    ) );

    $wp_customize->add_control ( 'hot-search-word', array(
      'label'       => __( 'Hot search words', 'iebase' ),
      'description'	=> esc_html__( 'Hot search words. (each line is a word)', 'iebase' ),
      'type'        => 'textarea',
      'section'     => 'general_section',
      'settings'    => 'hot-search-word',
    ) );

   //home page
  $wp_customize->add_panel( 'home_panel',
    array(
     'title' => __( 'Home Page', 'iebase' ),
     'description' => esc_html__( 'Setting of the homepage.', 'iebase'  ),
     'priority' => 82,
    )
  );
  //hero features
  $wp_customize->add_section( 'feature_section',
    array(
     'title' => __( 'Features', 'iebase' ),
     'description' => esc_html__( 'Features Block - add some features about this site.', 'iebase' ),
     'panel' => 'home_panel',
     'priority' => 107,
    )
  );

  //feature notice
  $wp_customize->add_setting( 'feature_notice', array(
		'default' => '',
		'transport' => 'postMessage',
		'sanitize_callback' => 'iebase_text_sanitization'
  ) );

  $wp_customize->add_control( new Simple_Notice_Custom_control( $wp_customize, 'feature_notice',
	array(
		'label' => __( 'Feature Control' , 'iebase' ),
		'description' => __('Control the feature block in home page.' , 'iebase' ),
		'section' => 'feature_section'
	  )
  ) );

  $wp_customize->add_setting( 'enable_feature', array(
		'default' => 1,
		'sanitize_callback' => 'iebase_checkbox_sanitize',
	) );

	$wp_customize->add_control( 'enable_feature', array(
    'label'     => __( 'Enable Features Block', 'iebase' ),
		'section'   => 'feature_section',
		'type'      => 'checkbox'
  ) );

  $wp_customize->add_setting( 'feature_one_title' , array(
	  'default'     => esc_html__( 'Feature work one', 'iebase' ),
	  'sanitize_callback'	=> 'wp_kses_post'
    ) );

  $wp_customize->add_control ( 'feature_one_title', array(
    'label' => esc_html__( 'Feature One Title', 'iebase' ),
	  'description' => __( 'the title of feature one', 'iebase' ),
	  'type'        => 'text',
    'section'     => 'feature_section',
    'settings'    => 'feature_one_title',
  ) );

  $wp_customize->add_setting( 'feature_one_icon' , array(
	  'default'     => 'portfolio',
	  'sanitize_callback'	=> 'wp_kses_post'
    ) );

  $wp_customize->add_control ( 'feature_one_icon', array(
	  'description' => __( 'the icon of feature one', 'iebase' ),
	  'type'        => 'text',
    'section'     => 'feature_section',
    'settings'    => 'feature_one_icon',
  ) );

  $wp_customize->add_setting( 'feature_one_desc' , array(
	  'default' => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'iebase' ),
	  'sanitize_callback'	=> 'wp_kses_post'
    ) );

  $wp_customize->add_control ( 'feature_one_desc', array(
	  'description' => __( 'the description of feature one', 'iebase' ),
	  'type'        => 'textarea',
    'section'     => 'feature_section',
    'settings'    => 'feature_one_desc',
  ) );

  $wp_customize->add_setting( 'feature_two_title' , array(
	  'default'     => esc_html__( 'Feature work two', 'iebase' ),
	  'sanitize_callback'	=> 'wp_kses_post'
    ) );

  $wp_customize->add_control ( 'feature_two_title', array(
    'label' => esc_html__( 'Feature Two Title', 'iebase' ),
	  'description' => __( 'the title of feature two', 'iebase' ),
	  'type'        => 'text',
    'section'     => 'feature_section',
    'settings'    => 'feature_two_title',
  ) );

  $wp_customize->add_setting( 'feature_two_icon' , array(
	  'default'     => 'translate',
	  'sanitize_callback'	=> 'wp_kses_post'
    ) );

  $wp_customize->add_control ( 'feature_two_icon', array(
	  'description' => __( 'the icon of feature two', 'iebase' ),
	  'type'        => 'text',
    'section'     => 'feature_section',
    'settings'    => 'feature_two_icon',
  ) );

  $wp_customize->add_setting( 'feature_two_desc' , array(
	  'default' => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'iebase' ),
	  'sanitize_callback'	=> 'wp_kses_post'
    ) );

  $wp_customize->add_control ( 'feature_two_desc', array(
	  'description' => __( 'the description of feature two', 'iebase' ),
	  'type'        => 'textarea',
    'section'     => 'feature_section',
    'settings'    => 'feature_two_desc',
  ) );

  $wp_customize->add_setting( 'feature_three_title' , array(
	  'default'     => esc_html__( 'Feature work three', 'iebase' ),
	  'sanitize_callback'	=> 'wp_kses_post'
    ) );

  $wp_customize->add_control ( 'feature_three_title', array(
    'label' => esc_html__( 'Feature Three Title', 'iebase' ),
	  'description' => __( 'the title of feature three', 'iebase' ),
	  'type'        => 'text',
    'section'     => 'feature_section',
    'settings'    => 'feature_three_title',
  ) );

  $wp_customize->add_setting( 'feature_three_icon' , array(
	  'default'     => 'support',
	  'sanitize_callback'	=> 'wp_kses_post'
    ) );

  $wp_customize->add_control ( 'feature_three_icon', array(
	  'description' => __( 'the icon of feature three', 'iebase' ),
	  'type'        => 'text',
    'section'     => 'feature_section',
    'settings'    => 'feature_three_icon',
  ) );

  $wp_customize->add_setting( 'feature_three_desc' , array(
	  'default' => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'iebase' ),
	  'sanitize_callback'	=> 'wp_kses_post'
    ) );

  $wp_customize->add_control ( 'feature_three_desc', array(
	  'description' => __( 'the description of feature three', 'iebase' ),
	  'type'        => 'textarea',
    'section'     => 'feature_section',
    'settings'    => 'feature_three_desc',
  ) );
  /***** Portfolio */
  include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
  if ( is_plugin_active('iebase-portfolio/iebase-portfolio.php') ) {

  $wp_customize->add_section( 'portfolio_section',
    array(
     'title' => __( 'Portfolio', 'iebase' ),
     'description' => esc_html__( 'Portfolio Block - only for actived our portfolio plugin.', 'iebase' ),
     'panel' => 'home_panel',
     'priority' => 108,
    )
  );

  $wp_customize->add_setting( 'portfolio_notice', array(
		'default' => '',
		'transport' => 'postMessage',
		'sanitize_callback' => 'iebase_text_sanitization'
  ) );

  $wp_customize->add_control( new Simple_Notice_Custom_control( $wp_customize, 'portfolio_notice',
	array(
		'label' => __( 'Portfolio Control' , 'iebase' ),
		'description' => __('Control the portfolio block in home page.' , 'iebase' ),
		'section' => 'portfolio_section'
	  )
  ) );

  $wp_customize->add_setting( 'enable_portfolio', array(
		'default' => 1,
		'sanitize_callback' => 'iebase_checkbox_sanitize',
	) );

	$wp_customize->add_control( 'enable_portfolio', array(
		'label'     => __( 'Enable Portfolio Block', 'iebase' ),
		'section'   => 'portfolio_section',
		'type'      => 'checkbox'
  ) );

  $wp_customize->add_setting( 'portfolio_title' , array(
	  'default'     => esc_html__( 'Our work', 'iebase' ),
	  'sanitize_callback'	=> 'wp_kses_post'
    ) );

  $wp_customize->add_control ( 'portfolio_title', array(
    'label' => esc_html__( 'Title', 'iebase' ),
	  'description' => __( 'Portfolio block title', 'iebase' ),
	  'type'        => 'text',
    'section'     => 'portfolio_section',
    'settings'    => 'portfolio_title',
  ) );

  $wp_customize->add_setting( 'portfolio_desc' , array(
	  'default' => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'iebase' ),
	  'sanitize_callback'	=> 'wp_kses_post'
    ) );

  $wp_customize->add_control ( 'portfolio_desc', array(
    'label' => esc_html__( 'Description', 'iebase' ),
	  'description' => __( 'Portfolio block description', 'iebase' ),
	  'type'        => 'textarea',
    'section'     => 'portfolio_section',
    'settings'    => 'portfolio_desc',
  ) );

  $wp_customize->add_setting( 'portfolio_post_count' , array(
	  'default'     => esc_html__( '6', 'iebase' ),
    //'sanitize_callback'	=> 'wp_kses_post'
    'sanitize_callback' => 'absint'
    ) );

  $wp_customize->add_control ( 'portfolio_post_count', array(
    'label' => esc_html__( 'Portfolio Post Count', 'iebase' ),
	  'description' => __( 'Setting how many post will show in this block, for perfect display, count is 3x, E.g 3,6,9 etc.', 'iebase' ),
	  'type' => 'number',
    'section'     => 'portfolio_section',
    'settings'    => 'portfolio_post_count',
  ) );

  $wp_customize->add_setting( 'enable_portfolio_more_button', array(
		'default' => 1,
		'sanitize_callback' => 'iebase_checkbox_sanitize',
	) );

	$wp_customize->add_control( 'enable_portfolio_more_button', array(
		'label'     => __( 'Show a load more button', 'iebase' ),
		'section'   => 'portfolio_section',
		'type'      => 'checkbox'
  ) );

  $wp_customize->add_setting( 'portfolio_more_button_url',array(
    'default'    => '0',
    'transport' => 'refresh',
    'sanitize_callback' => 'absint'
  ) );

  $wp_customize->add_control( 'portfolio_more_button_url',
  array(
    'label' => __( 'Button link Page', 'iebase' ),
    'section' => 'portfolio_section',
    'type' => 'dropdown-pages'
  ) );

  }

  /***** Main Loop */
  $wp_customize->add_section( 'loop_section',
    array(
     'title' => __( 'Main Loop', 'iebase' ),
     'description' => esc_html__( 'Main Loop - Some option about the home loop.', 'iebase' ),
     'panel' => 'home_panel',
     'priority' => 109,
    )
  );

  $wp_customize->add_setting( 'main_loop_notice', array(
		'default' => '',
		'transport' => 'postMessage',
		'sanitize_callback' => 'iebase_text_sanitization'
  ) );

  $wp_customize->add_control( new Simple_Notice_Custom_control( $wp_customize, 'main_loop_notice',
	array(
		'label' => __( 'Main Loop Control', 'iebase' ),
		'description' => __('Control the main loop block in home page.', 'iebase' ),
		'section' => 'loop_section'
	  )
  ) );

  $wp_customize->add_setting( 'main_loop_block',
	  array(
		  'default' => 1,
		  'transport' => 'refresh',
		  'sanitize_callback' => 'iebase_switch_sanitization'
	  )
  );

  $wp_customize->add_control( new Toggle_Switch_Custom_control( $wp_customize, 'main_loop_block',
	  array(
		  'label' => esc_html__( 'Display Main Loop Title' ),
      'section' => 'loop_section',
	  )
  ) );

  $wp_customize->add_setting( 'main_loop_title' , array(
	  'default'     => esc_html__( 'Recent Posts', 'blod' ),
	  'sanitize_callback'	=> 'wp_kses_post'
    ) );

  $wp_customize->add_control ( 'main_loop_title', array(
    'label' => __( 'Main Loop Block Title text', 'iebase' ),
	  'type'        => 'text',
    'section'     => 'loop_section',
    'settings'    => 'main_loop_title',
  ) );

  $wp_customize->add_setting( 'main_loop_caption',
    array(
      'default' => '',
      'transport' => 'refresh',
      'sanitize_callback' => 'wp_kses_post'
    )
  );

  $wp_customize->add_control( 'main_loop_caption',
    array(
      'label' => __( 'Main Loop Block Caption', 'iebase' ),
      'section' => 'loop_section',
      //'priority' => 12,
      'type' => 'textarea'
    )
  );

  /***** blogroll */
  $wp_customize->add_section( 'blogroll_section',
    array(
     'title' => __( 'Blogroll', 'iebase' ),
     'description' => esc_html__( 'Blogroll - links manager. Note: if don\'t enable this options,the link manager can\'t use.', 'iebase' ),
     'panel' => 'home_panel',
     'priority' => 110,
    )
  );

  $wp_customize->add_setting( 'blogroll_notice', array(
		'default' => '',
		'transport' => 'postMessage',
		'sanitize_callback' => 'iebase_text_sanitization'
  ) );

  $wp_customize->add_control( new Simple_Notice_Custom_control( $wp_customize, 'blogroll_notice',
	array(
		'label' => __( 'Blogroll Control', 'iebase' ),
		'description' => __('Control the blogroll block in home page.', 'iebase' ),
		'section' => 'blogroll_section'
	  )
  ) );

  $wp_customize->add_setting( 'enable_blogroll', array(
		'default' => 1,
		'sanitize_callback' => 'iebase_checkbox_sanitize',
	) );

	$wp_customize->add_control( 'enable_blogroll', array(
		'label'     => __( 'Enable Blogroll?', 'iebase' ),
		'section'   => 'blogroll_section',
		'type'      => 'checkbox'
  ) );

  $wp_customize->add_setting( 'show_link_section' , array(
    'default' => 1,
    'sanitize_callback' => 'iebase_checkbox_sanitize',
  ) );

  $wp_customize->add_control ( 'show_link_section', array(
    'label'       => __( 'Links Section', 'iebase' ),
    'description'	=> esc_html__( 'Show a links section in end of homepage.', 'iebase' ),
    'type'        => 'checkbox',
    'section'     => 'blogroll_section',
    'settings'    => 'show_link_section',
  ) );

  $wp_customize->add_setting( 'add_link_page', array(
    'default' => '0',
    'sanitize_callback'	=> 'wp_kses_post'
  ) );

  $wp_customize->add_control( 'add_link_page', array(
     'label' => 'Link Page',
     'description'	=> esc_html__( 'Select which page for Link page.', 'iebase' ),
     'section' => 'blogroll_section',
     'type' => 'dropdown-pages',
     'settings' => 'add_link_page'
  ) );

  // Footer
  $wp_customize->add_section( 'footer_section' , array(
		'title'      => __( 'Footer', 'iebase' ),
		'priority'   => 84,
  ) );

  $wp_customize->add_setting( 'iebase-footer-copyright' , array(
    'sanitize_callback'	=> 'wp_kses_post'
  ) );

  $wp_customize->add_control ( 'iebase-footer-copyright', array(
    'label'       => __( 'Footer Copyright', 'iebase' ),
    'description'	=> esc_html__( 'Customize the footer copyright text. (HTML is allowed)', 'iebase' ),
		'type'        => 'textarea',
    'section'     => 'footer_section',
    'settings'    => 'iebase-footer-copyright',
  ) );

  // Typography
  $wp_customize->add_section( 'typography_section' , array(
		'title'      => __( 'Typography', 'iebase' ),
		'priority'   => 85,
	) );
	$font_choices = array(
		'Georgia,Times,"Times New Roman",serif' => 'Serif',
		'-apple-system, BlinkMacSystemFont, "Segoe UI", Ubuntu, "Helvetica Neue", sans-serif' => 'Sans Serif',
		'-apple-system, BlinkMacSystemFont, "Microsoft YaHei", Helvetica, Arial, sans-serif' => 'Microsoft YaHei',
		'Helvetica, Arial, sans-serif' => 'Helvetica',
    '-apple-system, BlinkMacSystemFont, "Noto Sans", Helvetica, Arial, sans-serif' => 'Noto Sans',
    '"Helvetica Neue", Helvetica, Roboto, Arial, sans-serif'=> 'Roboto',
    'Arial, sans-serif' => 'Arial',
    'Trebuchet MS, Helvetica, sans-serif' => 'Trebuchet MS',
    'MS Sans Serif, Geneva, sans-serif' => 'MS Sans Serif',
		'"Avant Garde", sans-serif' => 'Avant Garde',
    'Cambria, Georgia, serif' => 'Cambria',
		'tahoma,arial,\5b8b\4f53,sans-serif' =>'SimSun',
		'-apple-system, BlinkMacSystemFont, "Lato", Helvetica, Arial, sans-serif' => 'Lato',
		);

  $wp_customize->add_setting( 'font_primary', array(
	  'default' => '-apple-system, BlinkMacSystemFont, "Microsoft YaHei", Helvetica, Arial, sans-serif',
	  'sanitize_callback' => 'iebase_sanitize_fonts',
	) );

  $wp_customize->add_control( 'font_primary', array(
	  'type' => 'select',
	  'label'       => __( 'Primary Font', 'iebase' ),
	  'description' => __( 'Select your desired font for Menu items, titles etc.', 'iebase'),
	  'section' => 'typography_section',
	  'choices' => $font_choices
    ) );

  $wp_customize->add_setting( 'font_secondary', array(
    'default' => '-apple-system, BlinkMacSystemFont, "Noto Sans", Helvetica, Arial, sans-serif',
    'sanitize_callback' => 'iebase_sanitize_fonts'
  ) );

  $wp_customize->add_control( 'font_secondary', array(
    'type' => 'select',
    'label'       => __( 'Secondary Font', 'iebase' ),
    'description' => __( 'Select your desired font for Content, dates, miscellaneous.', 'iebase' ),
    'section' => 'typography_section',
    'choices' => $font_choices
  ) );

  // GDPR
  $wp_customize->add_section( 'gdpr_section' , array(
      'title'      => __( 'GDPR', 'iebase' ),
      'description' => esc_html__( 'Settings for GDPR compliance.', 'iebase' ),
      'priority'   => 90,
  ) );

  $wp_customize->add_setting( 'cookie_notice', array(
		'default' => 1,
		'sanitize_callback' => 'iebase_checkbox_sanitize',
	) );

	$wp_customize->add_control( 'cookie_notice', array(
		'label'     => __( 'Show cookies consent notification bar?', 'iebase' ),
		'section'   => 'gdpr_section',
		'type'      => 'checkbox'
  ) );

  $wp_customize->add_setting( 'cookie_text' , array(
	  'default' => __( 'We are using cookies to personalize content and ads to make our site easier for you to use.', 'blod' ),
	  'sanitize_callback'	=> 'wp_kses_post'
    ) );

  $wp_customize->add_control ( 'cookie_text', array(
	  'description' => __( 'Cookies message text', 'iebase' ),
	  'type'        => 'textarea',
    'section'     => 'gdpr_section',
    'settings'    => 'cookie_text',
  ) );

  $wp_customize->add_setting( 'cookies_button' , array(
	  'default'     => esc_html__( 'Agree', 'iebase' ),
	  'sanitize_callback'	=> 'wp_kses_post'
    ) );

  $wp_customize->add_control ( 'cookies_button', array(
	  'description' => __( 'Cookies button text', 'iebase' ),
	  'type'        => 'text',
    'section'     => 'gdpr_section',
    'settings'    => 'cookies_button',
  ) );

  $wp_customize->add_setting( 'cookies_learn_more_text' , array(
	  'default'     => esc_html__( 'Learn More', 'blod' ),
	  'sanitize_callback'	=> 'wp_kses_post'
    ) );

  $wp_customize->add_control ( 'cookies_learn_more_text', array(
	  'description' => __( 'Cookies learn more text', 'iebase' ),
	  'type'        => 'text',
    'section'     => 'gdpr_section',
    'settings'    => 'cookies_learn_more_text',
  ) );

  $wp_customize->add_setting( 'cookies_learn_more_url', array(
    'default'     => esc_url( 'http://cookiesandyou.com' ),
    'sanitize_callback' => 'esc_url',
  ) );

  $wp_customize->add_control( 'cookies_learn_more_url', array(
    'description'   => esc_html__( 'Cookies learn more URL', 'iebase' ),
    'type' => 'url',
    'section' => 'gdpr_section',
    'settings'    => 'cookies_learn_more_url',
  ) );

  // Download
  $wp_customize->add_section( 'dl_section' , array(
    'title'      => __( 'Demo & Download', 'iebase' ),
    'description' => esc_html__( 'Addition demo and download.', 'iebase' ),
    'priority'   => 84,
  ) );

  // adblock detector
  $wp_customize->add_setting( 'unadblock_notice', array(
		'default' => '',
		'transport' => 'postMessage',
		'sanitize_callback' => 'iebase_text_sanitization'
  ) );

  $wp_customize->add_control( new Simple_Notice_Custom_control( $wp_customize, 'unadblock_notice',
	array(
		'label' => __( 'Ad Blocker Detector' , 'iebase'),
		'description' => __('Block the adblockers from browsing the site, till they turnoff the Ad Blocker.' , 'iebase'),
		'section' => 'dl_section'
	  )
  ) );

  $wp_customize->add_setting( 'ad_blocker_detector', array(
		'default' => 0,
		'sanitize_callback' => 'iebase_checkbox_sanitize',
	) );

	$wp_customize->add_control( 'ad_blocker_detector', array(
		'label'     => __( 'Ad Blocker Detector', 'iebase' ),
		'section'   => 'dl_section',
		'type'      => 'checkbox'
  ) );

  $wp_customize->add_setting( 'adblock_message',
    array(
    'default' => '',
    'transport' => 'refresh',
    'sanitize_callback' => 'wp_kses_post'
    )
  );

  $wp_customize->add_control( 'adblock_message',
    array(
      'label' => __( 'Message', 'iebase' ),
      'section' => 'dl_section',
      'type' => 'textarea'
    )
  );

  //item download
  $wp_customize->add_setting( 'item_download_notice', array(
		'default' => '',
		'transport' => 'postMessage',
		'sanitize_callback' => 'iebase_text_sanitization'
  ) );

  $wp_customize->add_control( new Simple_Notice_Custom_control( $wp_customize, 'item_download_notice',
	array(
		'label' => __( 'Downloand and Demo' , 'iebase'),
		'description' => __('You must setting this options below.' , 'iebase'),
		'section' => 'dl_section'
	  )
  ) );

  /***** Download Page ID */
  $wp_customize->add_setting( 'extras_download_page_id',
  array(
    'default'    => '0',
    'transport' => 'refresh',
    'sanitize_callback' => 'absint'
  ) );

  $wp_customize->add_control( 'extras_download_page_id',
  array(
    'label' => __( 'Download Page', 'iebase' ),
    'section' => 'dl_section',
    'type' => 'dropdown-pages'
  ) );

  /***** Demo Page ID */
  $wp_customize->add_setting( 'extras_demo_page_id',
  array(
    'default'    => '0',
    'transport' => 'refresh',
    'sanitize_callback' => 'absint'
  ) );

  $wp_customize->add_control( 'extras_demo_page_id',
  array(
    'label' => __( 'Demo Page', 'iebase' ),
    'section' => 'dl_section',
    'type' => 'dropdown-pages'
  ) );

  /***** Delay before download */
  $wp_customize->add_setting( 'extras_download_delay' , array(
	  'default'     => '5',
    //'sanitize_callback'	=> 'wp_kses_post'
    'sanitize_callback' => 'absint'
    ) );

  $wp_customize->add_control ( 'extras_download_delay', array(
	  'description' => __( 'Delay before download (in seconds)', 'iebase' ),
    //'type'        => 'text',
    'type' => 'number',
    'section'     => 'dl_section',
    'settings'    => 'extras_download_delay',
  ) );

  /***** Download Count Style */
  $wp_customize->add_setting( 'extras_download_download_count_style', array(
    'default' => 'full',
    'sanitize_callback' => 'iebase_radio_select_sanitize',
  ) );

  $wp_customize->add_control( 'extras_download_download_count_style', array(
    'type' => 'radio',
    'label'	=> esc_html__( 'Download Count Style', 'iebase' ),
    'section' => 'dl_section',
    'choices' => array(
      'rounded' => __( 'Rounded', 'iebase' ),
      'full'  => __( 'Full', 'iebase' ),
      ),
  ) );

  /***** Counter */
  $wp_customize->add_setting( 'extras_download_render_counter', array(
    'default' => 'on',
    'sanitize_callback' => 'iebase_radio_select_sanitize',
  ) );

  $wp_customize->add_control( 'extras_download_render_counter', array(
    'type' => 'radio',
    'label'	=> esc_html__( 'Counter', 'iebase' ),
    'section' => 'dl_section',
    'choices' => array(
        'on'  => esc_attr__( 'On', 'iebase' ),
				'off' => esc_attr__( 'Off', 'iebase' )
      ),
  ) );

  /***** Fake Download Count */
  $wp_customize->add_setting( 'extras_download_fake_count' , array(
	  'default'     => '0',
    //'sanitize_callback'	=> 'wp_kses_post'
    'sanitize_callback' => 'absint'
    ) );

  $wp_customize->add_control ( 'extras_download_fake_count', array(
    'label'	=> esc_html__( 'Fake Download Count', 'iebase' ),
	  'description' => __( 'Leave 0 to show real count', 'iebase' ),
    //'type'        => 'text',
    'type' => 'number',
    'section'     => 'dl_section',
    'settings'    => 'extras_download_fake_count',
  ) );

  //recommend
  $wp_customize->add_setting( 'dd_notice', array(
		'default' => '',
		'transport' => 'postMessage',
		'sanitize_callback' => 'iebase_text_sanitization'
  ) );

  $wp_customize->add_control( new Simple_Notice_Custom_control( $wp_customize, 'dd_notice',
	array(
		'label' => __( 'Download & Demo Page Setting', 'iebase' ),
		'description' => __('Control download and demo page content.', 'iebase' ),
		'section' => 'dl_section'
	  )
  ) );

  $wp_customize->add_setting( 'recommend_posts', array(
		'default' => 1,
		'sanitize_callback' => 'iebase_checkbox_sanitize',
	) );

	$wp_customize->add_control( 'recommend_posts', array(
		'label'     => __( 'Enable Recommend Posts', 'iebase' ),
		'section'   => 'dl_section',
		'type'      => 'checkbox'
  ) );

  $wp_customize->add_setting( 'sponsor_url', array(
    'default'     => esc_url( 'https://' ),
    'sanitize_callback' => 'esc_url',
  ) );

  $wp_customize->add_control( 'sponsor_url', array(
    'description'   => esc_html__( 'Sponsor Url, Must end for /feed', 'iebase' ),
    'type' => 'url',
    'section' => 'dl_section',
    'settings'    => 'sponsor_url',
  ) );
  /**
  * Add our Advertisement system
  */
  $wp_customize->add_panel( 'adv_panel',
    array(
      'title' => __( 'Advertisement', 'iebase' ),
      'description' => esc_html__( 'Advertising management.', 'iebase'  ),
      'priority' => 89,
    )
  );
  /***** Advertisement Home Page */
  $wp_customize->add_section( 'display_ads_home',
   array(
     'title' => __( 'Ads on Home Page', 'iebase' ),
     'description' => esc_html__( 'Advertisement - on Home page.', 'iebase' ),
     'panel' => 'adv_panel',
     'priority' => 100,
    )
  );

  /***** Display Ads on homepage */
  $wp_customize->add_setting( 'ads_home_notice', array(
		'default' => '',
		'transport' => 'postMessage',
		'sanitize_callback' => 'iebase_text_sanitization'
  ) );

  $wp_customize->add_control( new Simple_Notice_Custom_control( $wp_customize, 'ads_home_notice',
	array(
		'label' => __( 'Home Ads Control' , 'iebase'),
		'description' => __('Control advertisement in home page.' , 'iebase'),
		'section' => 'display_ads_home'
	  )
  ) );

  $wp_customize->add_setting( 'ads_home_select',
	  array(
		  'default' => 1,
		  'transport' => 'refresh',
		  'sanitize_callback' => 'iebase_switch_sanitization'
	  )
  );

  $wp_customize->add_control( new Toggle_Switch_Custom_control( $wp_customize, 'ads_home_select',
	  array(
		  'label' => esc_html__( 'Display Home Ads' ),
      'section' => 'display_ads_home',
	  )
  ) );

  $wp_customize->add_setting('home_mobile_ads',
    array(
        'default' => 0,
        'transport' => 'refresh',
        'sanitize_callback' => 'iebase_switch_sanitization'
      )
  );

  $wp_customize->add_control(new Toggle_Switch_Custom_control( $wp_customize, 'home_mobile_ads',
    array(
      'label' => esc_html__('Only Show Ad In Mobile'),
      'section' => 'display_ads_home',
    )
  ));

  $wp_customize->add_setting( 'ads_home_code',
    array(
      'default' => '',
      'transport' => 'refresh',
      'sanitize_callback' => 'wp_kses_post'
    )
  );

  $wp_customize->add_control( 'ads_home_code',
    array(
      'label' => __( 'Home Ads Code', 'iebase' ),
      'section' => 'display_ads_home',
      //'priority' => 12,
      'type' => 'textarea'
    )
  );

  /***** Display banner on homepage */
  $wp_customize->add_setting( 'banner_home_notice', array(
		'default' => '',
		'transport' => 'postMessage',
		'sanitize_callback' => 'iebase_text_sanitization'
  ) );

  $wp_customize->add_control( new Simple_Notice_Custom_control( $wp_customize, 'banner_home_notice',
	array(
		'label' => __( 'Home Banner Control' , 'iebase'),
		'description' => __('Control a banner in home page.' , 'iebase'),
		'section' => 'display_ads_home'
	  )
  ) );

  $wp_customize->add_setting( 'banner_home_display',
	  array(
		  'default' => 1,
		  'transport' => 'refresh',
		  'sanitize_callback' => 'iebase_switch_sanitization'
	  )
  );

  $wp_customize->add_control( new Toggle_Switch_Custom_control( $wp_customize, 'banner_home_display',
	  array(
		  'label' => esc_html__( 'Display Home Banner' ),
      'section' => 'display_ads_home',
	  )
  ) );

	// Banner of URL
	$wp_customize->add_setting( 'home_banner_url',
		array(
			'default' => '',
			'transport' => 'refresh',
			'sanitize_callback' => 'esc_url_raw'
		)
	);
	$wp_customize->add_control( 'home_banner_url',
		array(
			'label' => __( 'Banner URL', 'iebase' ),
			'section' => 'display_ads_home',
			'type' => 'url'
		)
  );

  $wp_customize->add_setting( 'banner_learn_more' , array(
	  'default'     => esc_html__( 'Learn More', 'blod' ),
	  'sanitize_callback'	=> 'wp_kses_post'
    ) );

  $wp_customize->add_control ( 'banner_learn_more', array(
    'label' => __( 'Banner button text', 'iebase' ),
	  'description' => __( 'Leave blank to not display button', 'iebase' ),
	  'type'        => 'text',
    'section'     => 'display_ads_home',
    'settings'    => 'banner_learn_more',
  ) );

  $wp_customize->add_setting( 'banner_caption',
    array(
      'default' => '',
      'transport' => 'refresh',
      'sanitize_callback' => 'wp_kses_post'
    )
  );

  $wp_customize->add_control( 'banner_caption',
    array(
      'label' => __( 'Banner Caption', 'iebase' ),
      'section' => 'display_ads_home',
      //'priority' => 12,
      'type' => 'textarea'
    )
  );

	// Banner of Image
	$wp_customize->add_setting( 'home_banner_image',
		array(
			'default' => '',
			'transport' => 'refresh',
			'sanitize_callback' => 'esc_url_raw'
		)
  );

	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'home_banner_image',
		array(
			'label' => __( 'Banner Image', 'iebase' ),
			'section' => 'display_ads_home',
			'button_labels' => array(
				'select' => __( 'Select Image', 'iebase' ),
				'change' => __( 'Change Image', 'iebase' ),
				'remove' => __( 'Remove', 'iebase' ),
				'default' => __( 'Default', 'iebase' ),
				'placeholder' => __( 'No image selected', 'iebase' ),
				'frame_title' => __( 'Select Image', 'iebase' ),
				'frame_button' => __( 'Choose Image', 'iebase' ),
			)
		)
	) );

  /***** Advertisement Single Post Page */
  $wp_customize->add_section( 'display_single_post',
   array(
     'title' => __( 'Ads on Single Posts', 'iebase' ),
     'description' => esc_html__( 'Advertisement - on Single Posts.', 'iebase' ),
     'panel' => 'adv_panel',
     'priority' => 100,
    )
  );

  /***** Display Ads on Single Post Page */
  $wp_customize->add_setting( 'ads_single_notice', array(
		'default' => '',
		'transport' => 'postMessage',
		'sanitize_callback' => 'iebase_text_sanitization'
  ) );

  $wp_customize->add_control( new Simple_Notice_Custom_control( $wp_customize, 'ads_single_notice',
	array(
		'label' => __( 'Single Posts Ads Control' , 'iebase'),
		'description' => __('Control advertisement in single posts page.' , 'iebase'),
		'section' => 'display_single_post'
	  )
  ) );

  $wp_customize->add_setting( 'hide_ad_logg_in', array(
		'default' => 0,
		'sanitize_callback' => 'iebase_checkbox_sanitize',
	) );

	$wp_customize->add_control( 'hide_ad_logg_in', array(
    'label'     => __( 'Only Show Ads for no\'t login user?', 'iebase' ),
    'description' => __('If enable all the option below this will not work.' , 'iebase'),
		'section'   => 'display_single_post',
		'type'      => 'checkbox'
  ) );

  $wp_customize->add_setting( 'ads_position_notice', array(
		'default' => '',
		'transport' => 'postMessage',
		'sanitize_callback' => 'iebase_text_sanitization'
  ) );

  $wp_customize->add_control( new Simple_Notice_Custom_control( $wp_customize, 'ads_position_notice',
	array(
		'label' => __( 'Single Posts Ads position' , 'iebase'),
		'description' => __('Control advertisement position.' , 'iebase'),
		'section' => 'display_single_post'
	  )
  ) );

  $wp_customize->add_setting( 'ads_single_post_top',
	  array(
		  'default' => 0,
		  'transport' => 'refresh',
		  'sanitize_callback' => 'iebase_switch_sanitization'
	  )
  );

  $wp_customize->add_control( new Toggle_Switch_Custom_control( $wp_customize, 'ads_single_post_top',
	  array(
		  'label' => esc_html__( 'Single post top ads' ),
      'section' => 'display_single_post',
	  )
  ) );

  $wp_customize->add_setting('single_post_top_mobile_ads',
    array(
        'default' => 0,
        'transport' => 'refresh',
        'sanitize_callback' => 'iebase_switch_sanitization'
      )
  );

  $wp_customize->add_control(new Toggle_Switch_Custom_control( $wp_customize, 'single_post_top_mobile_ads',
    array(
      'label' => esc_html__('Only Show Ad In Mobile'),
      'section' => 'display_single_post',
    )
  ));

  $wp_customize->add_setting( 'ads_top_style',
    array(
      'default' => 'ali-center',
      'transport' => 'refresh',
      'sanitize_callback' => 'iebase_radio_sanitization'
    )
  );

  $wp_customize->add_control( 'ads_top_style',
    array(
      'label' => __( 'Display Top Ads alignment', 'iebase'),
      'section' => 'display_single_post',
      'priority' => 10,
      'type' => 'select',
      'choices' => array(
         'ali-left'   => __( 'Left', 'iebase' ),
         'ali-right'  => __( 'Right', 'iebase' ),
         'ali-right_sur'  => __( 'Right Surround', 'iebase' ),
         'ali-center' => __( 'Center', 'iebase' )
        )
    )
  );

  $wp_customize->add_setting( 'single_post_top_code',
    array(
      'default' => '',
      'transport' => 'refresh',
      'sanitize_callback' => 'wp_kses_post'
    )
  );

  $wp_customize->add_control( 'single_post_top_code',
    array(
      'label' => __( 'Single post top ad html', 'iebase' ),
      'section' => 'display_single_post',
      'type' => 'textarea'
    )
  );

  $wp_customize->add_setting( 'ads_single_post_bottom',
	  array(
		  'default' => 0,
		  'transport' => 'refresh',
		  'sanitize_callback' => 'iebase_switch_sanitization'
	  )
  );

  $wp_customize->add_control( new Toggle_Switch_Custom_control( $wp_customize, 'ads_single_post_bottom',
	  array(
		  'label' => esc_html__( 'Single post bottom ads' ),
      'section' => 'display_single_post',
	  )
  ) );

  $wp_customize->add_setting('single_post_bottom_mobile_ads',
    array(
        'default' => 0,
        'transport' => 'refresh',
        'sanitize_callback' => 'iebase_switch_sanitization'
      )
  );

  $wp_customize->add_control(new Toggle_Switch_Custom_control( $wp_customize, 'single_post_bottom_mobile_ads',
    array(
      'label' => esc_html__('Only Show Ad In Mobile'),
      'section' => 'display_single_post',
    )
  ));

  $wp_customize->add_setting( 'ads_bottom_style',
    array(
      'default' => 'ali-center',
      'transport' => 'refresh',
      'sanitize_callback' => 'iebase_radio_sanitization'
    )
  );

  $wp_customize->add_control( 'ads_bottom_style',
    array(
      'label' => __( 'Display Bottom Ads alignment', 'iebase'),
      'section' => 'display_single_post',
      'priority' => 10,
      'type' => 'select',
      'choices' => array(
         'ali-left'   => __( 'Left', 'iebase' ),
         'ali-right'  => __( 'Right', 'iebase' ),
         'ali-center' => __( 'Center', 'iebase' )
        )
    )
  );

  $wp_customize->add_setting( 'single_post_bottom_code',
    array(
      'default' => '',
      'transport' => 'refresh',
      'sanitize_callback' => 'wp_kses_post'
    )
  );

  $wp_customize->add_control( 'single_post_bottom_code',
    array(
      'label' => __( 'Single post bottom ad html', 'iebase' ),
      'section' => 'display_single_post',
      'type' => 'textarea'
    )
  );

  $wp_customize->add_setting( 'ads_single_post_middle',
	  array(
		  'default' => 0,
		  'transport' => 'refresh',
		  'sanitize_callback' => 'iebase_switch_sanitization'
	  )
  );

  $wp_customize->add_control( new Toggle_Switch_Custom_control( $wp_customize, 'ads_single_post_middle',
	  array(
		  'label' => esc_html__( 'Single post middle ads' ),
      'section' => 'display_single_post',
	  )
  ) );

  $wp_customize->add_setting('single_post_middle_mobile_ads',
    array(
        'default' => 0,
        'transport' => 'refresh',
        'sanitize_callback' => 'iebase_switch_sanitization'
      )
  );

  $wp_customize->add_control(new Toggle_Switch_Custom_control( $wp_customize, 'single_post_middle_mobile_ads',
    array(
      'label' => esc_html__('Only Show Ad In Mobile'),
      'section' => 'display_single_post',
    )
  ));

  $wp_customize->add_setting( 'ads_middle_style',
    array(
      'default' => 'ali-center',
      'transport' => 'refresh',
      'sanitize_callback' => 'iebase_radio_sanitization'
    )
  );

  $wp_customize->add_control( 'ads_middle_style',
    array(
      'label' => __( 'Display Middle Ads alignment', 'iebase'),
      'section' => 'display_single_post',
      'priority' => 10,
      'type' => 'select',
      'choices' => array(
         'ali-left'   => __( 'Left', 'iebase' ),
         'ali-right'  => __( 'Right', 'iebase' ),
         'ali-center' => __( 'Center', 'iebase' )
        )
    )
  );

  $wp_customize->add_setting( 'single_post_middle_code',
    array(
      'default' => '',
      'transport' => 'refresh',
      'sanitize_callback' => 'wp_kses_post'
    )
  );

  $wp_customize->add_control( 'single_post_middle_code',
    array(
      'label' => __( 'Single post middle ad html', 'iebase' ),
      'section' => 'display_single_post',
      'type' => 'textarea'
    )
  );

  $wp_customize->add_setting( 'ads_single_post_paragraph1',
	  array(
		  'default' => 0,
		  'transport' => 'refresh',
		  'sanitize_callback' => 'iebase_switch_sanitization'
	  )
  );

  $wp_customize->add_control( new Toggle_Switch_Custom_control( $wp_customize, 'ads_single_post_paragraph1',
	  array(
		  'label' => esc_html__( 'Single post Paragaph ads 1' ),
      'section' => 'display_single_post',
	  )
  ) );

  $wp_customize->add_setting('single_post_paragraph1_mobile_ads',
    array(
        'default' => 0,
        'transport' => 'refresh',
        'sanitize_callback' => 'iebase_switch_sanitization'
      )
  );

  $wp_customize->add_control(new Toggle_Switch_Custom_control( $wp_customize, 'single_post_paragraph1_mobile_ads',
    array(
      'label' => esc_html__('Only Show Ad In Mobile'),
      'section' => 'display_single_post',
    )
  ));

  $wp_customize->add_setting( 'ads_paragraph1_style',
    array(
      'default' => 'ali-center',
      'transport' => 'refresh',
      'sanitize_callback' => 'iebase_radio_sanitization'
    )
  );

  $wp_customize->add_control( 'ads_paragraph1_style',
    array(
      'label' => __( 'Display Paragraph1 Ads alignment', 'iebase'),
      'section' => 'display_single_post',
      'priority' => 10,
      'type' => 'select',
      'choices' => array(
         'ali-left'   => __( 'Left', 'iebase' ),
         'ali-right'  => __( 'Right', 'iebase' ),
         'ali-center' => __( 'Center', 'iebase' )
        )
    )
  );

  $wp_customize->add_setting( 'post_paragraph1_num' , array(
	  'default'     => '1',
    'sanitize_callback' => 'absint'
    ) );

  $wp_customize->add_control ( 'post_paragraph1_num', array(
	  'description' => __( 'Show ads in which paragraph(p)', 'iebase' ),
    'type' => 'number',
    'section'     => 'display_single_post',
    'settings'    => 'post_paragraph1_num',
  ) );

  $wp_customize->add_setting( 'single_post_paragraph1_code',
    array(
      'default' => '',
      'transport' => 'refresh',
      'sanitize_callback' => 'wp_kses_post'
    )
  );

  $wp_customize->add_control( 'single_post_paragraph1_code',
    array(
      'label' => __( 'Single post paragaph ad 1 html', 'iebase' ),
      'section' => 'display_single_post',
      'type' => 'textarea'
    )
  );

  $wp_customize->add_setting( 'ads_single_post_paragraph2',
	  array(
		  'default' => 0,
		  'transport' => 'refresh',
		  'sanitize_callback' => 'iebase_switch_sanitization'
	  )
  );

  $wp_customize->add_control( new Toggle_Switch_Custom_control( $wp_customize, 'ads_single_post_paragraph2',
	  array(
		  'label' => esc_html__( 'Single post Paragaph 2 ads' ),
      'section' => 'display_single_post',
	  )
  ) );

  $wp_customize->add_setting('single_post_paragraph2_mobile_ads',
    array(
        'default' => 0,
        'transport' => 'refresh',
        'sanitize_callback' => 'iebase_switch_sanitization'
      )
  );

  $wp_customize->add_control(new Toggle_Switch_Custom_control( $wp_customize, 'single_post_paragraph2_mobile_ads',
    array(
      'label' => esc_html__('Only Show Ad In Mobile'),
      'section' => 'display_single_post',
    )
  ));

  $wp_customize->add_setting( 'ads_paragraph2_style',
    array(
      'default' => 'ali-center',
      'transport' => 'refresh',
      'sanitize_callback' => 'iebase_radio_sanitization'
    )
  );

  $wp_customize->add_control( 'ads_paragraph2_style',
    array(
      'label' => __( 'Display Paragraph2 Ads alignment', 'iebase'),
      'section' => 'display_single_post',
      'priority' => 10,
      'type' => 'select',
      'choices' => array(
         'ali-left'   => __( 'Left', 'iebase' ),
         'ali-right'  => __( 'Right', 'iebase' ),
         'ali-center' => __( 'Center', 'iebase' )
        )
    )
  );

  $wp_customize->add_setting( 'post_paragraph2_num' , array(
	  'default'     => '2',
    'sanitize_callback' => 'absint'
    ) );

  $wp_customize->add_control ( 'post_paragraph2_num', array(
	  'description' => __( 'Show ads in which paragraph(p)', 'iebase' ),
    'type' => 'number',
    'section'     => 'display_single_post',
    'settings'    => 'post_paragraph2_num',
  ) );

  $wp_customize->add_setting( 'single_post_paragraph2_code',
    array(
      'default' => '',
      'transport' => 'refresh',
      'sanitize_callback' => 'wp_kses_post'
    )
  );

  $wp_customize->add_control( 'single_post_paragraph2_code',
    array(
      'label' => __( 'Single post paragaph ad 2 html', 'iebase' ),
      'section' => 'display_single_post',
      'type' => 'textarea'
    )
  );

  $wp_customize->add_setting( 'ads_single_post_paragraph3',
	  array(
		  'default' => 0,
		  'transport' => 'refresh',
		  'sanitize_callback' => 'iebase_switch_sanitization'
	  )
  );

  $wp_customize->add_control( new Toggle_Switch_Custom_control( $wp_customize, 'ads_single_post_paragraph3',
	  array(
		  'label' => esc_html__( 'Single post Paragaph 3 ads' ),
      'section' => 'display_single_post',
	  )
  ) );

  $wp_customize->add_setting('single_post_paragraph3_mobile_ads',
    array(
        'default' => 0,
        'transport' => 'refresh',
        'sanitize_callback' => 'iebase_switch_sanitization'
      )
  );

  $wp_customize->add_control(new Toggle_Switch_Custom_control( $wp_customize, 'single_post_paragraph3_mobile_ads',
    array(
      'label' => esc_html__('Only Show Ad In Mobile'),
      'section' => 'display_single_post',
    )
  ));

  $wp_customize->add_setting( 'ads_paragraph3_style',
    array(
      'default' => 'ali-center',
      'transport' => 'refresh',
      'sanitize_callback' => 'iebase_radio_sanitization'
    )
  );

  $wp_customize->add_control( 'ads_paragraph3_style',
    array(
      'label' => __( 'Display Paragraph3 Ads alignment', 'iebase'),
      'section' => 'display_single_post',
      'priority' => 10,
      'type' => 'select',
      'choices' => array(
         'ali-left'   => __( 'Left', 'iebase' ),
         'ali-right'  => __( 'Right', 'iebase' ),
         'ali-center' => __( 'Center', 'iebase' )
        )
    )
  );

  $wp_customize->add_setting( 'post_paragraph3_num' , array(
	  'default'     => '3',
    'sanitize_callback' => 'absint'
    ) );

  $wp_customize->add_control ( 'post_paragraph3_num', array(
	  'description' => __( 'Show ads in which paragraph(p)', 'iebase' ),
    'type' => 'number',
    'section'     => 'display_single_post',
    'settings'    => 'post_paragraph3_num',
  ) );

  $wp_customize->add_setting( 'single_post_paragraph3_code',
    array(
      'default' => '',
      'transport' => 'refresh',
      'sanitize_callback' => 'wp_kses_post'
    )
  );

  $wp_customize->add_control( 'single_post_paragraph3_code',
    array(
      'label' => __( 'Single post paragaph ad 3 html', 'iebase' ),
      'section' => 'display_single_post',
      'type' => 'textarea'
    )
  );

  /***** Advertisement Download & Demo Page */
  $wp_customize->add_section( 'display_dd_page',
   array(
     'title' => __( 'Ads on Download & Demo', 'iebase' ),
     'description' => esc_html__( 'Advertisement - on Download & Demo Page.', 'iebase' ),
     'panel' => 'adv_panel',
     'priority' => 100,
    )
  );

  /***** Display Ads on Download & Demo Page */
  $wp_customize->add_setting( 'dd_page_notice', array(
		'default' => '',
		'transport' => 'postMessage',
		'sanitize_callback' => 'iebase_text_sanitization'
  ) );

  $wp_customize->add_control( new Simple_Notice_Custom_control( $wp_customize, 'dd_page_notice',
	array(
		'label' => __( 'Download & Demo Ads Control' , 'iebase'),
		'description' => __('Control advertisement in download & demo Page.' , 'iebase'),
		'section' => 'display_dd_page'
	  )
  ) );

  $wp_customize->add_setting( 'dd_page_top_code',
    array(
      'default' => '',
      'transport' => 'refresh',
      //'sanitize_callback' => 'wp_kses_post'
    )
  );

  $wp_customize->add_control( 'dd_page_top_code',
    array(
      'label' => __( 'Download & Demo top ad html', 'iebase' ),
      'section' => 'display_dd_page',
      'type' => 'textarea'
    )
  );

  $wp_customize->add_setting( 'dd_page_bottom_code',
    array(
      'default' => '',
      'transport' => 'refresh',
      'sanitize_callback' => 'wp_kses_post'
    )
  );

  $wp_customize->add_control( 'dd_page_bottom_code',
    array(
      'label' => __( 'Download & Demo bottom ad html', 'iebase' ),
      'section' => 'display_dd_page',
      'type' => 'textarea'
    )
  );

  // Custom	js&css
   $wp_customize->add_section( 'custom_section' , array(
		'title'      => __( 'Custom	js&css', 'iebase' ),
		'priority'   => 91,
	) );

   $wp_customize->add_setting("custom_js", array(
		"default" => "",
		"transport" => "postMessage",
	   'sanitize_callback'	=> 'wp_kses_post'
	));

   $wp_customize->add_control('custom_js', array(
		"label" => __("Custom JS", "iebase"),
		'description'	=> esc_html__( 'Customize js in header.', 'iebase' ),
		"section" => "custom_section",
		"settings" => "custom_js",
		"type" => "textarea",
	));

	   $wp_customize->add_setting("custom_css", array(
		"default" => "",
		"transport" => "postMessage",
		'sanitize_callback'	=> 'wp_kses_post'
	));

   $wp_customize->add_control('custom_css', array(
		"label" => __("Custom CSS", "iebase"),
		'description'	=> esc_html__( 'Customize css in header.', 'iebase' ),
		"section" => "custom_section",
		"settings" => "custom_css",
		"type" => "textarea",
	));


}
add_action( 'customize_register', 'iebase_customize_register' );
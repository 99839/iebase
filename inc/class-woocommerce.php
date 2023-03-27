<?php

remove_action( 'woocommerce_before_shop_loop' , 'woocommerce_result_count', 20 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 20 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
remove_action( 'woocommerce_after_single_product_summary', 'shop_isle_upsell_display', 15 );
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash' , 10 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart');
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
/* Remove SKU WooCommerce from store */
add_action('woocommerce_before_single_product_summary', function() {
    add_filter('wc_product_sku_enabled', '__return_false');
});
// Remove the additional information tab
function woo_remove_product_tabs( $tabs ) {
    unset( $tabs['additional_information'] );
    unset( $tabs['reviews'] ); 
    return $tabs;
}
add_filter( 'woocommerce_product_tabs', 'woo_remove_product_tabs', 98 );
function tijarah_woocommerce_setup() {
    add_theme_support( 'woocommerce' );
    add_filter('woocommerce_show_page_title', '__return_false');
}
add_action( 'after_setup_theme', 'tijarah_woocommerce_setup' );

/**
 * Enqueue scripts and styles.
 */
function wp_enqueue_woocommerce_style(){
	wp_register_style( 'bloggersprout-woocommerce', get_template_directory_uri() . '/assets/css/woocommerce.css', array());
	
	if ( class_exists( 'woocommerce' ) ) {
		wp_enqueue_style( 'bloggersprout-woocommerce' );
	}
}
add_action( 'wp_enqueue_scripts', 'wp_enqueue_woocommerce_style' );
/**
 * Disable the default WooCommerce stylesheet.
 *
 * Removing the default WooCommerce stylesheet and enqueing your own will
 * protect you during WooCommerce core updates.
 *
 * @link https://docs.woocommerce.com/document/disable-the-default-stylesheet/
 */
//add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

/**
 * Removes coupon form, order notes, and several billing fields if the checkout doesn't require payment.
 *
 * REQUIRES PHP 5.3+
 *
 * Tutorial: http://skyver.ge/c
 */
function js_remove_checkout_fields( $fields ) {

    // Billing fields
    unset( $fields['billing']['billing_company'] );
    //unset( $fields['billing']['billing_email'] );
    unset( $fields['billing']['billing_phone'] );
    unset( $fields['billing']['billing_state'] );
    //unset( $fields['billing']['billing_first_name'] );
    //unset( $fields['billing']['billing_last_name'] );
    unset( $fields['billing']['billing_address_1'] );
    unset( $fields['billing']['billing_address_2'] );
    unset( $fields['billing']['billing_city'] );
	unset( $fields['billing']['billing_postcode'] );
	unset( $fields['billing']['billing_country'] );

    // Order fields
    //unset( $fields['order']['order_comments'] );

    return $fields;
}
add_filter( 'woocommerce_checkout_fields', 'js_remove_checkout_fields' );

/**
* @snippet       Display &quot;FREE&quot; if WooCommerce Product Price is Zero or Empty - WooCommerce
* @how-to        Watch tutorial @ https://businessbloomer.com/?p=19055
* @sourcecode    https://businessbloomer.com/?p=73147
* @author        Rodolfo Melogli
* @testedwith    WooCommerce 3.5.3
* @donate $9     https://businessbloomer.com/bloomer-armada/
*/
 
  
function tijarah_price_free_zero_empty( $price, $product ){
 
if ( '' === $product->get_price() || 0 == $product->get_price() ) {
    $price = '<span class="woocommerce-Price-amount amount">'.esc_html__( 'Free', 'tijarah' ).'</span>';
}
	return $price;
}
add_filter( 'woocommerce_get_price_html', 'tijarah_price_free_zero_empty', 100, 2 );

/**
 * Remove "Description" Title @ WooCommerce Single Product Tabs
 */
 
add_filter( 'woocommerce_product_description_heading', '__return_null' );
add_filter( 'woocommerce_product_reviews_heading', '__return_null' );

// Add AJAX Shortcode when cart contents update
function tijarah_cart_button_count( $fragments ) {
 
    ob_start();
    
    $cart_count = WC()->cart->cart_contents_count;
    $cart_url = wc_get_cart_url();

    ?>
    <a class="cart-contents menu-item" href="<?php echo esc_url( $cart_url ); ?>" title="<?php echo esc_attr__( 'View your shopping cart','tijarah' ); ?>">
        <span class="cart-contents-count"><i class="fa fa-shopping-cart"></i> 
        	<?php echo sprintf(
			/* translators: number of items in the mini cart. */
			_n( '%d item', '%d items', WC()->cart->get_cart_contents_count(), 'tijarah' ), $cart_count ); ?>
		</span>
	</a>
    <?php
 
    $fragments['a.cart-contents'] = ob_get_clean();
     
    return $fragments;
}

add_filter( 'woocommerce_add_to_cart_fragments', 'tijarah_cart_button_count' );

// WooCommerce Variations as Radio Buttons
function tijarah_variation_radio_buttons($html, $args) {
  	$args = wp_parse_args(apply_filters('woocommerce_dropdown_variation_attribute_options_args', $args), array(
	    'options'          => false,
	    'attribute'        => false,
	    'product'          => false,
	    'selected'         => false,
	    'name'             => '',
	    'id'               => '',
	    'class'            => '',
	    'show_option_none' => __('Choose an option', 'tijarah'),
	));

	if(false === $args['selected'] && $args['attribute'] && $args['product'] instanceof WC_Product) {
	$selected_key     = 'attribute_'.sanitize_title($args['attribute']);
	$args['selected'] = isset($_REQUEST[$selected_key]) ? wc_clean(wp_unslash($_REQUEST[$selected_key])) : $args['product']->get_variation_default_attribute($args['attribute']);
	}

	$options               = $args['options'];
	$product               = $args['product'];
	$attribute             = $args['attribute'];
	$name                  = $args['name'] ? $args['name'] : 'attribute_'.sanitize_title($attribute);
	$id                    = $args['id'] ? $args['id'] : sanitize_title($attribute);
	$class                 = $args['class'];
	$show_option_none      = (bool)$args['show_option_none'];
	$show_option_none_text = $args['show_option_none'] ? $args['show_option_none'] : __('Choose an option', 'tijarah');

	if(empty($options) && !empty($product) && !empty($attribute)) {
		$attributes = $product->get_variation_attributes();
		$options    = $attributes[$attribute];
	}

	$radios = '<div class="variation-radios">';

	if(!empty($options)) {
		if($product && taxonomy_exists($attribute)) {
		$terms = wc_get_product_terms($product->get_id(), $attribute, array(
			'fields' => 'all',
		));

		foreach($terms as $term) {
			if(in_array($term->slug, $options, true)) {
			  $radios .= '<input type="radio" name="'.esc_attr($name).'" value="'.esc_attr($term->slug).'" id="'.esc_attr($term->slug).'" '.checked(sanitize_title($args['selected']), $term->slug, false).'><label for="'.esc_attr($term->slug).'">'.esc_html(apply_filters('woocommerce_variation_option_name', $term->name)).'</label>';
			}
		}
		} else {
		foreach($options as $option) {
			$checked    = sanitize_title($args['selected']) === $args['selected'] ? checked($args['selected'], sanitize_title($option), false) : checked($args['selected'], $option, false);
			$radios    .= '
			<input type="radio" name="'.esc_attr($name).'" value="'.esc_attr($option).'" id="'.sanitize_title($option).'" '.$checked.'>
			<label for="'.sanitize_title($option).'">'.esc_html(apply_filters('woocommerce_variation_option_name', $option)).'</label>';
			}
		}
	}

	$radios .= '</div>';

	return $html.$radios;
}
add_filter('woocommerce_dropdown_variation_attribute_options_html', 'tijarah_variation_radio_buttons', 20, 2);

remove_theme_support( 'wc-product-gallery-zoom' );
remove_theme_support( 'wc-product-gallery-lightbox' );
remove_theme_support( 'wc-product-gallery-slider' );

add_filter( 'woocommerce_output_related_products_args', 'jk_related_products_args', 20 );
  function jk_related_products_args( $args ) {
	$args['posts_per_page'] = 5; // 4 related products
	$args['columns'] = 1; // arranged in 2 columns
	return $args;
}

add_action( 'woocommerce_account_content', 'remove_dashboard_account_default', 5 );
function remove_dashboard_account_default() {
    remove_action( 'woocommerce_account_content', 'woocommerce_account_content', 10 );
    add_action( 'woocommerce_account_content', 'custom_account_orders', 10 );
}


function custom_account_orders( $current_page ) {
    global $wp;

    if ( ! empty( $wp->query_vars ) ) {
        foreach ( $wp->query_vars as $key => $value ) {
            // Ignore pagename param.
            if ( 'pagename' === $key ) {
                continue;
            }

            if ( has_action( 'woocommerce_account_' . $key . '_endpoint' ) ) {
                do_action( 'woocommerce_account_' . $key . '_endpoint', $value );
                return;
            }
        }
    }

    $current_page    = empty( $current_page ) ? 1 : absint( $current_page );
    $customer_orders = wc_get_orders( apply_filters( 'woocommerce_my_account_my_orders_query', array(
        'customer' => get_current_user_id(),
        'page'     => $current_page,
        'paginate' => true,
    ) ) );

    wc_get_template(
        'myaccount/orders.php',
        array(
            'current_page'    => absint( $current_page ),
            'customer_orders' => $customer_orders,
            'has_orders'      => 0 < $customer_orders->total,
        )
    );
}

add_filter ( 'woocommerce_account_menu_items', 'misha_remove_my_account_links' );
function misha_remove_my_account_links( $menu_links ){
 
	unset( $menu_links['edit-address'] ); // Addresses
 
    unset( $menu_links['dashboard'] ); // Remove Dashboard
	unset( $menu_links['payment-methods'] ); // Remove Payment Methods
	unset( $menu_links['orders'] ); // Remove Orders
	unset( $menu_links['downloads'] ); // Disable Downloads
	unset( $menu_links['edit-account'] ); // Remove Account details tab
	unset( $menu_links['customer-logout'] ); // Remove Logout link
 
	return $menu_links;
 
}
<?php
/**
* Class that used to add different filters to theme
*
* @package theme/helpers
*/

class theme_filter_class{

  public function __construct(){
    /* removes and unregisters theme scripts*/
    add_filter('allow_theme_scripts', array($this, 'allow_theme_scripts'));

    /* removes and unregisters theme styles*/
    add_filter('allow_theme_styles', array($this, 'allow_theme_styles'));

    /*hides page title in woocommerce pages*/
    add_filter('woocommerce_show_page_title', '__return_false');

    /*hides settings row nubmer and column number in woocommerce customizer settings*/
    add_filter('loop_shop_columns', '__return_false');


    /*sets product thumbnail sizes for gallery in product loop*/
    // add_filter('single_product_archive_thumbnail_size', array($this, 'single_product_archive_thumbnail_size'));

    /*sets product thumbnail sizes*/
    // add_filter('woocommerce_gallery_thumbnail_size', array($this, 'woocommerce_gallery_thumbnail_size'));


    /*changes related products' params */
    add_filter('woocommerce_output_related_products_args', array($this, 'woocommerce_output_related_products_args'));

    /*adds styles and params to form fields*/
    add_filter('woocommerce_form_field_args', array($this,'woocommerce_form_field_args'), 10 ,3 );

    add_filter('woocommerce_form_field', array($this,'woocommerce_form_field'), 99999 ,4 );

    /*removes comment in order*/
    add_filter('woocommerce_enable_order_notes_field', '__return_false');

    /*removes not ruqiured fields in checkout form*/
    add_filter('woocommerce_checkout_fields', array($this, 'woocommerce_checkout_fields') );

    /*modifies payment gateway's icon*/
    add_filter('woocommerce_gateway_icon', array($this, 'woocommerce_gateway_icon'), 10 , 2);


    /*adds styles to woocommerce field with credit card data. Stripe pay method */
    add_filter( 'wc_stripe_elements_styling', array($this, 'wc_stripe_elements_styling' ));

    /*overides check is_attribute_in_product_name in woocommerce*/
    add_filter( 'woocommerce_is_attribute_in_product_name', '__return_false');

    /*modifies output text for variation value in checkout*/
    // add_filter('filter_theme_variation_value',array($this,'filter_theme_variation_value'),10, 2);

    /*stores additional meta to an order*/
    add_filter('woocommerce_checkout_order_processed',array($this,'woocommerce_checkout_order_processed'),10, 3);

    /*removes add to cart message*/
    add_filter( 'wc_add_to_cart_message_html', '__return_false' );

    /*adds an html fragment to array of fragments in AJAX request */
    add_filter('woocommerce_update_order_review_fragments', array($this,'woocommerce_update_order_review_fragments'));

    /*renames menu items in my account page*/
    add_filter('woocommerce_account_menu_items', array($this, 'woocommerce_account_menu_items'));


    /* Removes fields, that do not present in allowed list*/
    add_filter('woocommerce_address_to_edit', array($this, 'woocommerce_address_to_edit'), 10, 2);

    /* Removes fields, that do not present in allowed list*/
    add_filter('woocommerce_billing_fields', array($this, 'woocommerce_billing_fields'), 999999, 2);

    /*redirects to my account billing instead of view subscription*/
    add_filter('ywsbs_get_subscription_url', array($this, 'ywsbs_get_subscription_url'), 9999, 3);


    add_filter( 'woocommerce_my_account_my_orders_query', array($this, 'woocommerce_my_account_my_orders_query') );

   /* adds additional class to main content wrapper*/
    add_filter( 'theme_site_container_styles', array($this, 'theme_site_container_styles') );

    /* Adds mark to page on pages' list in admin section*/
    add_filter('display_post_states', array($this, 'show_contact_page_state'), 10, 2);

   /*Overides url on add_to_cart_redirect*/
    add_filter('woocommerce_add_to_cart_redirect', array($this, 'add_to_cart_redirect'), 99999);

    /* Overides url on woocommerce_registration_redirect*/
    add_filter('woocommerce_registration_redirect', array($this, 'registration_redirect'), 99999);

    /* adds lazy load data to product image*/
    add_filter('woocommerce_product_get_image', array($this, 'woocommerce_product_get_image'), 99999, 5);

    /*adds args for multicurrency support*/
    add_filter('wc_price_args', array($this, 'wc_price_args'), 9999);

    /*changes price value, depending on currency*/
    add_filter('formatted_woocommerce_price', array($this, 'formatted_woocommerce_price'), 9999,5);

    /*changes text for buy button*/
    add_filter('woocommerce_product_single_add_to_cart_text',  array($this, 'add_to_cart_text'), 9999);


    add_filter('pre_get_posts', array($this, 'exclude_products_incategories'), 9999);

    /*removing srcset*/
      add_filter('wp_calculate_image_srcset_meta', '__return_null' );
      add_filter('wp_calculate_image_sizes', '__return_false',  99 );

      remove_filter('the_content', 'wp_make_content_images_responsive' );
      add_filter('wp_get_attachment_image_attributes', array($this, 'unset_attach_srcset_attr'), 99 ,3 );


    /*Removes  <a> tags and it's content from woocomemerce message*/
    add_filter( 'woocommerce_add_error', array( $this, 'remove_links' ), 999 );
    add_filter( 'woocommerce_add_success', array( $this, 'remove_links' ), 999 );
    add_filter( 'woocommerce_add_notice', array( $this, 'remove_links' ), 999 );

    /*adds data description to variable options of product */
    add_filter('woocommerce_dropdown_variation_attribute_options_html',array( $this, 'dropdown_variation_attribute_options_html' ), 999, 2);

     add_filter('woocommerce_account_settings',array($this,'woocommerce_account_settings'));



     add_filter('woocommerce_new_customer_data',array($this,'woocommerce_new_customer_data'), 10);

    add_filter('woocommerce_get_item_data', array($this, 'woocommerce_get_item_data'), 999, 2 );
     // add_filter('the_title', array($this, 'add_price_to_title'), 100, 2);

    add_filter('pre_get_posts', array($this, 'exlude_some_products'));

    add_filter( 'woocommerce_is_purchasable', array($this,'price_0_is_purchasable') , 10, 2 );


    add_filter( 'nav_menu_item_args', array($this,'nav_menu_item_args') , 10, 3 );

    /*checks if a stay a week chekbox is turned on and return cookie expire value*/
    add_filter( 'auth_cookie_expiration', array($this,'auth_cookie_expiration') , 10);
  }

  /*checks if a stay a week chekbox is turned on and return cookie expire value*/
  public static function auth_cookie_expiration($value){

    if(isset($_POST['_stay_signed_week']) && 'yes' == $_POST['_stay_signed_week']){
     print_theme_log('wow');
      return 604800;// week in seconds
    }
    return $value;
  }

  public static function nav_menu_item_args(   $args, $item, $depth ){

    $image_id   = get_post_meta($item->ID, '_custom-image-url', true);
    $image_data = wp_get_attachment_image_src($image_id, 'full', true);

    if($image_id  && (int)$image_id != '-1' && !$args->theme_location){
      $args->link_before  = sprintf('<i class="icon"><img src="%s" alt="icon"></i>', $image_data[0]);
    }else{
      $args->link_before  =  '';
    }


    return $args;
  }


   /**
    * makes product with 0 price purchaseable
    *
    * @param $purchasable - bool
    * @param $product - WC_Product obj
    *
    * @return $purchasable - bool
    */
   public static function price_0_is_purchasable( $purchasable, $product ){
        if( $product->get_price() >= 0 )
            $purchasable = true;
        return $purchasable;
    }


    public function exlude_some_products( $query ){
      if(!is_admin()){
        $exclude = array(
          get_option('wfp_single_product_id'),
          get_option('wfp_priority_delivery_product_id'),
          get_option('wfp_return_product_id'),
        );
        set_query_var('post__not_in', $exclude);
      }

    }

    /**
    * adds metadata on get meta callback
    *
    * @param $item_data - array
    * @param $cart_item - integer
    * @param $variation_id - integer
    *
    * @return $item_data - array
    */
    public function woocommerce_get_item_data($item_data, $cart_item = null) {
      $item_data = is_array($item_data) ? $item_data : array();

      $item_data[] = array(
        'key' => $cart_item['extra_data']['name']['label'],
        'value' => $cart_item['extra_data']['name']['value'],
      );


      return $item_data;
    }

  /**
  * add a price to a products title on single product's page
  *
  * @param $title string
  * @param $id int
  *
  * @return string
  */
  public static function add_price_to_title($title, $id){
    return $title;
  }


  /**
  * sets firts and last name for new user on regisetr
  *
  * @param $field string
  * @param $key string
  * @param $key array
  * @param $value string
  *
  * @return array
  */
  public static function woocommerce_form_field($field, $key, $args, $value){
    $reg ='/<span class="optional">\(([\s\S]*?)\)<\/span>/';
    $field_new = preg_replace($reg, '',$field);
    return $field_new;
  }

  /**
  * sets firts and last name for new user on regisetr
  *
  * @param array
  *
  * @return array
  */
  public static function woocommerce_new_customer_data($args){
    if(isset($_POST['customer_first_name'])){
      $args['first_name'] = $_POST['customer_first_name'];
    }
    if(isset($_POST['customer_last_name'])){
      $args['last_name'] = $_POST['customer_last_name'];
    }

    return $args;
  }


  /**
  * add additional setting to woocommerce account setting
  *
  * @param array
  */
  public static function woocommerce_account_settings($args){
    $position = -1;

    $new_args = array();

    $new_setting = array(
      'desc'          => __( 'When creating an account, allow user to input first name and last name', 'theme-translations' ),
      'id'            => 'woocommerce_registration_first_last_name',
      'default'       => 'yes',
      'type'          => 'checkbox',
      'checkboxgroup' => '',
      'autoload'      => false,
    );

    foreach($args as $key => $arg){
      $new_args[] = $arg;
      if( 'woocommerce_registration_generate_username' === $arg['id']){
      $new_args[] = $new_setting;
      }
    }

    return $new_args;
  }

  /**
  *adds data description to variable options of product
  *
  * @param $html - string
  * @param $args - array
  *
  * @return string
  */
  public static function dropdown_variation_attribute_options_html($html, $args){

    foreach ($args['term_data'] as $key => $term) {
      $old_string = sprintf('value="%s"', $key);
      $new_string = sprintf('value="%s" data-description="%s"', $key, $term);
      $html       = str_replace($old_string, $new_string, $html);
    }



    return $html;
  }


  /**
  * Removes  <a> tags and it's content from woocomemerce message
  *
  * @param $message - string
  *
  * @return - $message
  */
  public static function remove_links($message){
    $regexp = '/<(a[\s\S]*?)>([\s\S]*?)<\/([\s\S]*?)>/';
    preg_match_all($regexp, $message, $matches);
    foreach ($matches[0] as $key => $m) {
      $message = str_replace($m, '', $message);
    }
    $message = str_replace(':', '', $message);
    return $message ;
  }

 /**
 * removes src set params
 *
 * @param $attr - array
 * @param $post - WP_Post obj
 * @param $size - string
 *
 * @return $attr - array
 */
  public static   function unset_attach_srcset_attr( $attr, $post, $size){
      foreach( array('sizes','srcset') as $key ){
        if( isset($attr[ $key ]) )    unset($attr[ $key ]);
      }
      return $attr;
    }


 /**
 * Changes query object.
 * Remove from search query products with meta field _is_theme_featured
 * Fires only on shop category pages for main query
 *
 * @param $query - query object
 *
 * @return $query - query object
 */
  public static function exclude_products_incategories($query){

    $is_shop = function_exists('is_shop')? is_shop() : false;
    $is_product_category = function_exists('is_shop')? is_shop() : false;


    if(!is_admin() &&  ($is_shop || theme_construct_page::is_page_type( 'woo-shop-category')) &&  $query->is_main_query()){
      $query->query_vars['posts_per_page']  = -1;
    }

    if(!is_admin() &&( theme_construct_page::is_page_type( 'woo-shop-category') )&& isset($query->query_vars['wc_query']) && 'product_query' === $query->query_vars['wc_query']){

      $query->query_vars['meta_query'] = array(
        'relationship' => 'AND',
        array(
          'key'     => '_is_theme_featured',
          'compare' => 'NOT EXISTS'
        ),
        array(
          'key'     => '_is_free_sample',
          'compare' => 'NOT EXISTS'
        ),
      );
    }

    return $query;
  }

  /**
  * changes text for buy button
  *
  * @param $button_text - string
  *
  * @return $button_text - string
  */
  public static function add_to_cart_text($button_text){
    $button_text = __('Create Images', 'theme-translations');
    return $button_text;
  }


  /**
  * changes price value, depending on currency
  *
  * @param $format - string
  * @param $price - integer
  * @param $decimals - integer
  * @param $decimal_separator - string
  * @param $thousand_separator - string
  *
  * @return $price
  */
  public static function formatted_woocommerce_price($format, $price, $decimals, $decimal_separator, $thousand_separator){
    $o = get_option('woo_theme_currency');
    $currency = isset($_COOKIE['theme-currency'])? $_COOKIE['theme-currency'] : '';

    if(isset($o['items'][$currency])){
      $rate = str_replace(',','.', $o['items'][$currency]['rate']);
      $price = $price * $rate;
      $price = round( $price, 2);
    }
    return $price;
  }


  public static function wc_price_args($args){
    $args['currency'] = isset($_COOKIE['theme-currency'])? $_COOKIE['theme-currency'] :$args['currency'];
    return $args;
  }

  /**
  * adds lazy load data to product image
  *
  * @param $html - string
  * @param $post_thumbnail_id - integer
  *
  * @return string -  html
  */
  public static function woocommerce_product_get_image($html, $instanse, $size, $attr, $placeholder ){
    switch ($size){
      case 'product_thumb_md':
        $lazy_preview_size = 'product_thumb_md_lazy_preview';
        break;
      case 'product_thumb_sm':
        $lazy_preview_size = 'product_thumb_sm_lazy_preview';
        break;
      default :
        return $html;
        break;
    }

    $image_id      = $instanse->get_image_id();

    $image_url_lazy = wp_get_attachment_image_url($image_id ,$lazy_preview_size );

    $replace        = sprintf('src="%s" data-src', $image_url_lazy);

    $html           = str_replace('src', $replace  , $html);

    $html           = str_replace('class="', 'class="lazy-load ' , $html);

    return $html;
  }

  /**
  * Overides url on woocommerce_registration_redirect
  *
  * @param $url - string
  *
  * @return string -  url
  */
  public static function registration_redirect($url){
    return $url;
  }


  /**
  * Overides url on add_to_cart_redirect
  *
  * @param $url - string
  *
  * @return string - checkout url
  */
  public static function add_to_cart_redirect($url){
    global $woocommerce;
    $checkout_url = wc_get_checkout_url();

    $checkout_url = (isset($_GET['fast_order_id']))? $checkout_url .'?fast_order_id='.$_GET['fast_order_id'] : $checkout_url;
    return $checkout_url;
  }


  /**
  * Adds mark to page on pages' list in admin section
  *
  * @param $states - array
  * @param $post - WP_Post object
  *
  * @return array
  */
  public static function show_contact_page_state( $states, $post ) {
      if ( 'page' == get_post_type( $post->ID )){
        switch ($post->ID) {
          case get_option('theme_page_pricing'):
              $states[] = __('Theme Pricing Page');
            break;

          case get_option('theme_page_showcase'):
              $states[] = __('Theme Showcase Page');
            break;

          case get_option('theme_page_support'):
              $states[] = __('Theme Support Page');
            break;

          case get_option('theme_page_customers'):
              $states[] = __('Theme Customers\' Page');
            break;

          case get_option('theme_page_constructor'):
              $states[] = __('Shooting Constructor Page');
            break;
          case get_option('theme_page_product_guid'):
              $states[] = __('Product Guidelines');
            break;
          case get_option('theme_page_redo_policy'):
              $states[] = __('Redo Policy');
            break;
        }
      }
      return $states;
    }

  /**
  * adds additional class to main content wrapper
  *
  * @param $data - WP_Post object
  *
  * @return string
  */
  public static function theme_site_container_styles($data){
    $pricing_id  = (int)get_option('theme_page_pricing');
    $classes     = '';

    if($pricing_id == $data->ID){
      $classes .= ' lines';
    }

    if((is_checkout() && !isset($_GET['no_reload'])) && empty( is_wc_endpoint_url('order-received') )) {
     $classes .= " contrast ";
    }

    if(is_checkout()){
     $classes .= " checkout-bg ";
    }


    if(  is_account_page()   ){
     $classes .= " discard-column-inner ";
    }
    if( is_product() || is_shop() || is_product_category() || (is_checkout() && !empty( is_wc_endpoint_url('order-received') )) ){
      $classes .= " dark-mode ";
    }

    return $classes;
  }

  /**
  * removes pagination on my account orders list
  *
  * @param $args - array
  *
  * @return $args -array;
  */
  public static function woocommerce_my_account_my_orders_query($args){
    $args['limit'] = -1;
    return $args;
  }


  /**
  * changes subscription url
  *
  * @param $view_subscription_url - string
  * @param $id - integer
  * @param $id - string
  *
  * @return $view_subscription_url - string
  */
  public static function ywsbs_get_subscription_url($view_subscription_url, $id, $admin ){
    if(isset($_GET['redirect'])){
      return esc_url(wc_get_account_endpoint_url('edit-address/'.$_GET['redirect']));
    }
      return $view_subscription_url;
  }


  /**
  * Removes fields, that do not present in allowed list
  *
  * @param $address_fields - array of fields
  * @param $country       - string country label
  *
  * @return $address_fields
  */
  public static function woocommerce_billing_fields( $address_fields, $country ){
    $fields_allowed  = array(
      // 'billing_company',
      // 'billing_address_1',
      // 'billing_address_2',
      // 'billing_city',
      // 'billing_state',
      // 'billing_postcode',
      // 'billing_country',
      // 'billing_first_name',
      // 'billing_last_name',
    );

    foreach ($address_fields as $key => $value) {
      if(!in_array($key,$fields_allowed )){
        unset($address_fields[$key]);
      }
    }

    return $address_fields;
  }


  /**
  * Removes fields, that don not present in allowed list
  *
  * @param $address - array of fields
  * @param $load_addres - string billing or shipping
  *
  * @return $address
  */
  public static function woocommerce_address_to_edit( $address, $load_address ){

    $fields_allowed  = array(
      'billing_company',
      'billing_address_1',
      'billing_address_2',
      'billing_city',
      'billing_state',
      'billing_postcode',
      'billing_country',
      'shipping_address_1',
      'shipping_address_2',
      'shipping_city',
      'shipping_state',
      'shipping_postcode',
      'shipping_country',
    );

    foreach ($address as $key => $value) {
      if(!in_array($key,$fields_allowed )){
        unset($address[$key]);
      }
    }

    return $address;
  }


  public static function woocommerce_login_redirect( $redirect, $user){
    return $redirect;
  }


  /**
  * renames menu items in my account page
  *
  * @param $items - items of menu in my account
  *
  * @return $items - items of menu in my account
  */
  public static function woocommerce_account_menu_items($items){
    $items['orders'] = __('My Orders', 'theme-translations');
    $items['my-gallery'] = __('Gallery', 'theme-translations');
    $items['edit-account'] = __('Edit Profile', 'theme-translations');
    $items['edit-address/billing'] = __('Billing', 'theme-translations');
    return $items;
  }


  /**
  * adds an html fragment to array of fragments in AJAX request
  *
  * @param $fragments - array of html strings
  *
  * @return $fragments - array of html strings
  */
  public static function woocommerce_update_order_review_fragments($fragments){

    if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) :

       ob_start();
       wc_cart_totals_shipping_html();

    endif;

    $fragments['.woocommerce-shipping-totals'] = ob_get_clean();

    if(isset($fragments['form.woocommerce-checkout'])){

      $image = sprintf('<div class="spacer-h-50"></div><div class="clearfix"><img width="113" height="122" alt="%s" src="%s"></div><div class="spacer-h-30"></div>',__('Empty Cart', 'theme-translations'), THEME_URL.'/images/empty.png');

      $line_secure = sprintf('<span class="page-title__comment empty-cart-comment"><svg class="icon svg-icon-lock"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-lock"></use> </svg> <span>%s</span></span>',__('Secure Checkout', 'theme-translations') );

      $text = sprintf('<h3 class="cart-title">%s</h3><span class="cart-comment">%s<br>%s</span> <div class="spacer-h-30"></div>', __('Your cart is empty', 'theme-translations'), __('Let’s load up on the sauce, it’s feeling a little lonely', 'theme-translations'),__('this side of the kitchen', 'theme-translations').'!');

      $button = '';
      if(function_exists('wc_get_page_id')){

        $button = sprintf('<a href="%s" class="checkout__submit regular-checkout-submit " >%s<i class="icon-arrow"></i></a>',  get_permalink( wc_get_page_id( 'shop' ) ), __('Create Images','theme-translations'));
      }

      $fragments['form.woocommerce-checkout'] = sprintf('<div class="textcenter cart-empty-block">%s %s %s %s</div>',  $image, $line_secure ,$text  , $button);
    }

    return $fragments;
  }


  /**
  * Add additional parameters to an order
  *
  * @param $order_id - integer
  * @param $posted_data - obj
  * @param $order -  WC_Order object
  *
  * @appliedto woocommerce_checkout_order_processed - 10
  *
  * @return $order -  WC_Order object
  */
  public static function woocommerce_checkout_order_processed(  $order_id, $posted_data, $order ){

    if(isset($_POST['self_shipping_date'])){
      $order->update_meta_data( '_self_shipping_date', $_POST['self_shipping_date'] );
    }

    if(isset($_POST['free_collection_date'])){
      $order->update_meta_data( '_free_collection_date', $_POST['free_collection_date'] );
    }

    if(isset($_POST['free_collection_date'])){
      $order->update_meta_data( '_free_collection_date', $_POST['free_collection_date'] );
    }

    $order->save();


    return $order;
  }


  /**
  * modifies attribute_name
  * Removes from attribute_name all words that are present in taxonomy_name
  * Remove price from attribute_name
  *
  * @param string $attribute_name - string to modify
  * @param string $taxonomy_name - string to get words to be removed from attribute_name
  *
  * @appliedto filter_theme_variation_value -10
  *
  * @return $attribute_name - string
  */
  public static function filter_theme_variation_value($attribute_name, $taxonomy_name){
    $taxonomy_name = strtolower($taxonomy_name);
    $attribute_name = strtolower($attribute_name);

    $searchs = explode(' ', $taxonomy_name);

    foreach ($searchs as $key => $s) {
      $regexp = '/\\b'.$s.'\\b/';

      $attribute_name = (stripos($attribute_name, $s))? preg_replace($regexp, '',$attribute_name) : $attribute_name;
    }

    $filter_attribute_name = get_price_in_text($attribute_name);
    $attribute_name        = ($filter_attribute_name)? $filter_attribute_name['no-price'] : $attribute_name;

    return $attribute_name;
  }


  /**
  * changes styling of a stripe form on checkout page
  *
  * @param array
  *
  * @appliedto wc_stripe_elements_styling - 10
  *
  * @return array
  */
  public static function wc_stripe_elements_styling($options){
    $options = array(

      'base' => array(
        'color'   => '#1f2933',
        'fontFamily'  => 'Helvetica,sans-serif',
        'fontSize'  => '16px',
        'lineHeight'  =>'28px',
        'backgroundColor'  =>'#fff'
      ),
      'invalid' => array(
        'color'   => '#ff0000',
      ),

      'complete' => array(
        'color'   => '#009a00'
      )
    );
    return $options;
  }


  /**
  * changes args for display of crosselling products
  *
  * @param $args - array of args
  *
  * @appliedto allow_theme_styles - 10
  *
  * @return $args - filtered array of styles
  */
  public static function woocommerce_output_related_products_args($args){
    $args['posts_per_page'] =  3;
    $args['columns'] =  3;
    return $args;
  }


  /**
  * filter function to detect allowed styles
  *
  * @param $styles - array of registered styles
  *
  * @appliedto allow_theme_styles - 10
  *
  * @return $style - filtered array of styles
  */
  public static function allow_theme_styles($styles){

    $allowed_names = array(
      'elementor-animations',
      'elementor-frontend',
      'elementor-common',
      'admin-bar',
      'dashicons',
    );

    $forbidden_names =array(
      'wp-block-library',
      'yith_ywsbs_frontend',
      "woocommerce-layout",
      "woocommerce-smallscreen",
      "woocommerce-general",
      "woocommerce-inline",
      "yith-wcmbs-frontent-styles",
      "yith-wcmbs-membership-statuses",
      "yith_wcmbs_frontend_opensans",
      "yith_ywsbs_frontend",
      "ywccp-front-style",
      "megamenu",
    );

    return $forbidden_names;
  }


  /**
  * filter function to detect allowed scripts
  *
  * @param $scripts - array of registered scripts
  *
  * @appliedto allow_theme_scripts - 10
  *
  * @return $scripts - filtered array of scripts
  */
  public static function allow_theme_scripts($scripts){

    $script_names = array(
      'yith_ywsbs_frontend',
      'yith_wcmbs_frontend_js',
      'woocommerce-general',
      'woocommerce-general',
      "woocommerce",
      "wc-single-product"
    );

    $scripts_to_remove = array();

    $scripts_data = wp_scripts();

    foreach ($scripts as $id => $s) {
      if(in_array($s, $script_names)){
        $scripts_to_remove[] = $s;
      }
    }

    return array();
  }


  // /**
  // * sets image size for a product in a loop
  // *
  // * @appliedto single_product_archive_thumbnail_size - 10
  // *
  // * @return string 'product_thumb_md' or 'product_thumb_sm'
  // */
  // public static function single_product_archive_thumbnail_size(){
  //   global $theme_product_widget_size;
  //   return ($theme_product_widget_size === 'large')? 'product_thumb_md': 'product_thumb_sm';
  // }


  /**
  * sets image size for a product in a single product's gallery
  *
  * @appliedto woocommerce_gallery_thumbnail_size - 10
  *
  * @return string 'product__gallery'
  */
  public static function woocommerce_gallery_thumbnail_size(){
    return 'product__gallery';
  }


  /**
  * changes form field args
  *
  * @param string $key Key.
  * @param mixed  $args Arguments.
  * @param string $value (default: null).
  *
  * @appliedto woocommerce_form_field_args
  *
  * @return array
  */
  public static function woocommerce_form_field_args( $args, $key, $value ){

    $args['input_class']   = (isset($args['input_class']))? $args['input_class']: array();
    $args['input_class'][] = 'form-field';
    $args['input_class'][] = 'white';
    $args['label']         = (empty($args['label'])) ? $args['placeholder'] : $args['label'];
    $args['placeholder']   = '';
    $args['class']         = (isset($args['class']))? $args['class']: array();
    $args['class'][]       =' label-checkout-holder';

    if('country' === $args['type'] || 'state' === $args['type']){
        $args['class'][] = 'white-bg';
    }


   $args['class'][] = ($value)? 'selected' : '';
   $args['label_class'] = array();

   switch ($key){
    case 'billing_first_name':
      $args['class'][] ='col-12';

      if(isset($args['position']) && 'checkout' == $args['position']){
        $args['class'][] ='col-md-4';
      }
      break;
    case 'billing_last_name':
      $args['class'][] ='col-12';

      if(isset($args['position']) && 'checkout' == $args['position']){
        $args['class'][] ='col-md-4';
      }
      break;
    case 'billing_company':
      $args['class'][] ='col-12';

      if(isset($args['position']) && 'checkout' == $args['position']){
        $args['class'][] ='col-md-4';
      }
      break;
    case 'billing_address_1':
      $args['class'][] ='col-12';
      $args['class'][] ='col-md-6';
      break;
    case 'billing_address_2':
      $args['class'][] ='col-12';
      $args['class'][] ='col-md-6';
      break;
    case 'billing_city':
      $args['class'][] ='col-12';
      $args['class'][] ='col-md-6';
      break;
    case 'billing_state':
      $args['class'][] ='col-12';
      $args['class'][] ='col-md-6';
      break;
    case 'billing_postcode':
      $args['class'][] ='col-12';
      $args['class'][] ='col-md-6';
      break;
    case 'billing_country':
      $args['class'][] ='col-12';
      $args['class'][] ='col-md-6';
      break;
    case 'shipping_address_1':
      $args['class'][] ='col-12';
      $args['class'][] ='col-md-6';
      break;
    case 'shipping_address_2':
      $args['class'][] ='col-12';
      $args['class'][] ='col-md-6';
      break;
    case 'shipping_city':
      $args['class'][] ='col-12';
      $args['class'][] ='col-md-6';
      break;
    case 'shipping_state':
      $args['class'][] ='col-12';
      $args['class'][] ='col-md-6';
      break;
    case 'shipping_postcode':
      $args['class'][] ='col-12';
      $args['class'][] ='col-md-6';
      break;
    case 'shipping_country':
      $args['class'][] ='col-12';
      $args['class'][] ='col-md-6';
      break;
    default:
      $args['class'][] ='col-12';
      break;

    }
    return $args;
  }


  /**
  * Removes not required fields
  *
  * @param array of fields
  *
  * @appliedto woocommerce_checkout_fields -10
  *
  * @return array
  */
  public static function woocommerce_checkout_fields($fields){

    $fields_allowed_billing  = array(
      'billing_company',
      'billing_address_1',
      'billing_address_2',
      'billing_city',
      'billing_state',
      'billing_postcode',
      'billing_country',
      'billing_first_name',
      'billing_last_name',
    );

    $fields_allowed_shipping  = array(
      'shipping_address_1',
      'shipping_address_2',
      'shipping_city',
      'shipping_state',
      'shipping_postcode',
      // 'shipping_country',
    );

    foreach ($fields['billing'] as $key => $f) {
      if(!in_array($key, $fields_allowed_billing )){
        unset($fields['billing'][$key]);
      }
    }

    foreach ($fields['shipping'] as $key => $f) {
      if(!in_array($key, $fields_allowed_shipping )){
        unset($fields['shipping'][$key]);
      }
    }

    return $fields;
  }


  /**
  *
  * @param $icon
  * @param $id
  *
  * @appliedto woocommerce_gateway_icon - 10
  *
  * @return $icon
  */
  public static function woocommerce_gateway_icon($icon, $id){
    if($icon){
      $style_new = 'icon-pay';

      $search  = '/class=([^=]*)\"/';

      preg_match($search, $icon, $matches);

      $old_class = $matches[0];

      $new_styles  = $matches[1].' icon-pay';

      $icon = str_replace($matches[1],  $new_styles, $icon);
    }

    return $icon;
  }


  /**
  * debug function prints in a console passed value;
  *
  * @param $value - mixed
  *
  * @return $value
  */
  public static function debug($value){
    clog($value);
    return 'test';
  }
}

new theme_filter_class();

add_filter('woocommerce_checkout_create_order_line_item_object', 'test_line_item_object', 10, 4);

function test_line_item_object($obj, $key, $values, $order){
  // print_theme_log($values);

  if(isset($values['apply_currency_index']) && 'yes' == $values['apply_currency_index']){
    $currency_code  = strtolower($values['currency_code']);
    $currency_index = isset($currency_settings[$currency_code])? (float)$currency_settings[$currency_code] :  1;

    $subtotal = round($values['line_subtotal'] * $currency_index);
    $obj->set_subtotal( $subtotal );

    $total = round($values['line_total'] * $currency_index);
    $obj->set_total( $total );
  }
  return $obj;
}



add_action('woocommerce_checkout_create_order_line_item', 'theme_save_additional_item_data', 10, 4);

function theme_save_additional_item_data($item, $cart_item_key, $values, $order ){

  $order_id = $order->get_id();
  $user_id = get_current_user_id();

  $currency_settings = get_option('theme_currency_settings');
  if(isset($values['currency_code']) && $values['currency_code'] != "GBP"){
    $order->set_currency($values['currency_code']);
  }

  if(isset($values['custom_price'])){
    $item->set_subtotal((int)$values['custom_price']);
    $item->set_total((int)$values['custom_price']);
  }

  if(isset($values['theme_prices'])){
    $item['theme_prices'] = $values['theme_prices'];
  }

  if(isset($values['shoot_data'])){
    $item['shoot_data'] = $values['shoot_data'];
  }

  if(isset($values['extra_data'])){
    $item['extra_data'] = $values['extra_data'];
  }

  if(isset($values['group_id'])){
    $item['group_id'] = array( $values['group_id'] );
  }

  if(isset($_POST['fast_order_id'])){
    $item['fast_order_id'] = array( $_POST['fast_order_id'] );

    if(!update_post_meta((int)$_POST['fast_order_id'], 'is_fasttracked', 'yes' )){
      add_post_meta((int)$_POST['fast_order_id'], 'is_fasttracked', 'yes', true );
    }
  }

  if(isset($_POST['contact'])){
    if(!update_post_meta($order_id , '_contact_number', $_POST['contact'] )){
      add_post_meta($order_id , '_contact_number', $_POST['contact'], true );
    }
  }


  // save free collection address
  if(isset($_POST['free_collection_address'])){

    // saves addresses to order
    $order->update_meta_data('collect-products', 1);
    $order->update_meta_data('_collect_address', $_POST['free_collection_address']);

    // add posted address to user addresses
    $addresses = get_user_meta($user_id, '_free_collection_address', true);
    $addresses =$addresses?: array();
    array_push($addresses,  str_replace('\\', '',$_POST['free_collection_address']));

    $addresses = array_unique($addresses);

    if(!update_user_meta($user_id, '_free_collection_address',  $addresses )){
      add_user_meta($user_id, '_free_collection_address',  $addresses );
    }
  }
}

add_action('woocommerce_order_item_line_item_html', 'print_additional_data_line', 10, 3);

function print_additional_data_line( $item_id, $item, $order ){
  $meta = $item->get_meta('extra_data');
  $meta2 = $item->get_meta('fast_order_id');

  if($meta2){
    ?>
  <tr>
    <td></td>
    <td>
      <div class="view">
        <table cellspacing="0" class="display_meta">
          <tbody>
          <?php
          ?>
          <tr>
            <th>Fasttrack for&nbsp;order:</th>
            <td>
              <p>
                <?php
                echo $meta2[0];
                ?>
              </p>
            </td>
          </tr>
        <?php
         ?>
        </tbody></table>
      </div>
    </td>
    <td colspan="4"> </td>
  </tr>
  <?php
  }

  if(!$meta){return;}
  ?>

  <tr>
    <td></td>
    <td>
      <div class="view">
        <table cellspacing="0" class="display_meta">
          <tbody>
          <?php
          foreach ($meta as $key => $_m):
          ?>
          <tr>
            <th><?php echo $_m['label'] ?>: &nbsp;&nbsp;&nbsp;&nbsp;</th>
            <td> <?php if ($key == 'order_id' ) : ?>
                <a href="<?php echo admin_url(sprintf('post.php?post=%s&action=edit', trim($_m['value'] ))); ?>"><?php echo trim($_m['value']);?></a>
              <?php else: ?>
              <p> <?php
                if(is_array($_m['value'] )){
                  echo(implode(',', $_m['value']));
                }else{
                 echo trim($_m['value']);
                }
                ?> </p>
              <?php endif; ?> </td>
          </tr>
        <?php
         endforeach;
         ?>
        </tbody></table>
      </div>
    </td>
    <td colspan="4"> </td>
  </tr>
  <?php
}




add_action( 'woocommerce_before_calculate_totals', 'set_cart_item_calculated_price', 10, 1 );

function set_cart_item_calculated_price( $cart ) {
    if ( is_admin() && ! defined( 'DOING_AJAX' ) )
        return;

    // Required since Woocommerce version 3.2 for cart items properties changes
    if ( did_action( 'woocommerce_before_calculate_totals' ) >= 2 )
        return;

    // Loop through cart items
    foreach ( $cart->get_cart() as $cart_item ) {
        // Set the new calculated price based on lenght
        if( isset($cart_item['custom_price']) ) {
            $cart_item['data']->set_price( $cart_item['custom_price']);
        }
    }
}


add_action( 'init', 'gallery_add_endpoint' );
function gallery_add_endpoint() {
  add_rewrite_endpoint( 'my-gallery', EP_PAGES );
}

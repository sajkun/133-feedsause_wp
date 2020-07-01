<?php
//***
/**
  * Page Construct Class
  *
  * Constructs page
  *
  * @package theme/helper
  *
  * @since v1.0
  */
class theme_construct_page{

  /**
  * Adds hooks for different pages
  */
  public static function init(){
    add_filter('print_header_class', array(__CLASS__, 'detect_header_classes'));
    add_action('do_theme_header', array('theme_content_output','print_header'));
    add_action('do_theme_footer', array('theme_content_output','print_footer'));

    if(self::is_page_type( 'fronted-page' )){
      add_action('do_fly_basket', array('theme_content_output','print_fly_basket'), 10);
      self::hook_frontend_page_functions();
    }

    elseif(self::is_page_type( 'blog' )){
      add_action('do_fly_basket', array('theme_content_output','print_fly_basket'), 10);
       self::hook_blog_functions();
    }

    elseif(self::is_page_type( 'blog-category' )){
      add_action('do_fly_basket', array('theme_content_output','print_fly_basket'), 10);
       self::hook_blog_category_functions();
    }

    elseif(self::is_page_type( 'blog-post' )){
      add_action('do_fly_basket', array('theme_content_output','print_fly_basket'), 10);

       self::hook_blog_post_functions();
    }

    elseif(self::is_page_type( 'post-tag' )){
      add_action('do_fly_basket', array('theme_content_output','print_fly_basket'), 10);
       self::hook_post_tag_functions();
    }

    elseif(self::is_page_type( 'woocommerce' )){



      remove_action( 'woocommerce_cart_is_empty', 'wc_empty_cart_message', 10 );

      remove_action( 'woocommerce_thankyou', 'woocommerce_order_details_table', 10 );

      add_action('do_theme_content', array('theme_content_output','print_woo_content'), 10);

      add_action('print_thank_you_estimates', array('theme_content_output','print_checkout_estimates'), 10);


      if(self::is_page_type( 'woo-shop' ) || self::is_page_type( 'woo-shop-category' )){
        self::hook_woo_shop_functions();

        add_action('do_fly_basket', array('theme_content_output','print_fly_basket'), 10);
      }

      elseif(self::is_page_type( 'woo-product' ) || self::is_page_type( 'woo-shop-category' )){
        add_action('do_theme_after_content', array('theme_content_output','print_pre_footer_cta'), 90);
        add_action('do_fly_basket', array('theme_content_output','print_fly_basket'), 10);
      }

      else if(self::is_page_type('woo-checkout')){
        self::hook_woo_checkout();

      }
      else if(self::is_page_type('woo-cart')){
        self::hook_woo_cart();
        $helper = new theme_formatted_cart();
        if(count($helper->get_items()) <=0){
          wc()->cart->empty_cart();
        }
        remove_action('do_theme_footer', array('theme_content_output','print_footer'));
      }
    }

    else if(self::is_page_type('woo-login')){

       self::hook_my_account_login_page();
    }

    else if(self::is_page_type('woo-my-account')){
      self::hook_my_account_page();
    }

    else if(self::is_page_type('showcase')){
      self::hook_my_showcase_page();
    }

    else if(self::is_page_type('customer')){
      self::hook_my_customer_page();
    }

    else{
      add_action('do_theme_after_content', array('theme_content_output','print_page_content'), 90);
    }

    if(self::is_page_type('custom-pages')){
      self::hook_custom_page();
    }

    self::hook_woo_common_shop();
    self::hook_woo_single_product();
    add_action('print_theme_order_summary', array('theme_content_output','print_order_items_data'), 10, 2);
  }


  /**
  * Detects what page is currently loaded
  *
  * @return bool
  */
  public static function is_page_type( $type ){
    switch ($type){
      case 'blog':
        return is_home();
        break;
      case 'fronted-page':
        return is_front_page();
        break;
      case 'blog-category':
        return is_category();
        break;
      case 'blog-post':
        $obj = get_queried_object();
        return (is_single() && ('post' === $obj->post_type));
        break;
      case 'post-tag':
        return is_tag();
        break;
      case 'woocommerce':
        if(!function_exists('is_woocommerce')) return false;
        return (is_woocommerce() || is_cart() || is_checkout());
        break;
      case 'woo-shop':
       if(!function_exists('is_shop')) return false;
         return is_shop();
       break;
      case 'woo-shop-category':
       if(!function_exists('is_product_category')) return false;
         return is_product_category();
       break;
      case 'woo-product':
       if(!function_exists('is_product')) return false;
         return is_product();
       break;
      case 'woo-checkout':
       if(!function_exists('is_checkout')) return false;
         return is_checkout();
       break;
      case 'woo-login':
       if(!function_exists('is_account_page')) return false;
         return (is_account_page() && !is_user_logged_in());
       break;
      case 'woo-my-account':
       if(!function_exists('is_account_page')) return false;
         return (is_account_page() && is_user_logged_in());
       break;
      case 'woo-cart':
        if(!function_exists('is_cart')) return false;
          return is_cart();
       break;
       case 'custom-pages':
        $pages = array(
          (int)get_option('theme_page_pricing'),
          (int)get_option('theme_page_support'),
          (int)get_option('theme_page_showcase'),
          (int)get_option('theme_page_customers'),
        );
        $queried = get_queried_object();

        if(!$queried || empty($queried) || !is_object($queried))
          return false;
        return  isset($queried->ID) && in_array($queried->ID, $pages);
        break;

      case 'showcase':
       $queried = get_queried_object();
       return (velesh_theme_posts::$showcase_name === $queried->post_type)? true : false;
       break;
      case 'customer':
       $queried = get_queried_object();
       return (velesh_theme_posts::$customer_name === $queried->post_type)? true : false;
       break;
    }
  }


  /**
  * adds hooks for my account pages
  */
  public static function hook_my_customer_page(){
    add_action('do_theme_content', array('theme_content_output','print_page_content'), 90);
    add_action('do_theme_before_content', array('theme_content_output','print_customer_before_content'), 80);
    add_action('do_theme_after_content', array('theme_content_output','print_pre_footer_cta'), 90);
  }


  /**
  * adds hooks for custom showcase page
  */
  public static function hook_my_showcase_page(){
    add_action('do_theme_content', array('theme_content_output','print_page_content'), 90);
    add_action('do_theme_after_content', array('theme_content_output','print_showcase_after_content'), 80);
    add_action('do_theme_after_content', array('theme_content_output','print_pre_footer_cta'), 90);
  }


  /**
  * adds hooks for cart page
  */
  public static function hook_woo_cart(){
    add_action('do_theme_content', array('theme_content_output','print_regular_content'));

    add_action('finish_page', array('theme_content_output','print_cart_edit_slide'));
  }


  /**
  * adds hooks to pricing page
  */
  public static function hook_custom_page(){
    add_action('pricing_page_moto', array('theme_content_output','print_home_page_static_html'));
    add_action('page_faq_section', array('theme_content_output','print_faq'));
    add_action('pricing_page_content', array('theme_content_output','print_pricing'));
    add_action('support_page_content', array('theme_content_output','print_support'));
    add_action('customers_page_content', array('theme_content_output','print_customers'));
    add_action('showcase_archive_page_content', array('theme_content_output','print_showcase_archive'));
    add_action('do_theme_after_content', array('theme_content_output','print_pre_footer_cta'), 90);
  }


  public static function hook_my_account_page(){
    add_action('do_theme_after_content', array('theme_content_output','print_page_content'), 90);
    add_action('do_myaccount_header', array('theme_content_output','print_myaccount_header'));


    if(function_exists('YWSBS_Subscription_My_Account')){
      $manager = YWSBS_Subscription_My_Account();
      remove_action('woocommerce_after_edit_address_form_billing', array( $manager , 'my_account_edit_address'));
      remove_action('woocommerce_after_edit_address_form_shipping', array( $manager , 'my_account_edit_address'));

      // billing fields
      remove_filter( 'woocommerce_billing_fields', 'ywccp_load_custom_billing_fields', 50, 1 );
    }
  }

  /**
  * adds hooks to my account
  */
  public static function hook_my_account_login_page(){

    remove_action('woocommerce_before_customer_login_form', 'woocommerce_output_all_notices');
    remove_action('woocommerce_before_lost_password_form', 'woocommerce_output_all_notices');

    add_action('theme_custom_before_login','woocommerce_output_all_notices');

    remove_action('do_theme_header', array('theme_content_output','print_header'));

    remove_action('do_theme_footer', array('theme_content_output','print_footer'));

    add_action('do_theme_after_content', array('theme_content_output','print_page_content'), 90);
  }

  /**
  * adds hooks for static home page
  */
  public static function hook_frontend_page_functions(){
      define('THEME_HERO_SECTION', true);
      add_action('do_theme_after_content', array('theme_content_output','print_home_page_static_html'), 10);
      add_action('do_theme_after_content', array('theme_content_output','print_home_page_static_widgets'), 20);
      add_action('do_theme_after_content', array('theme_content_output','print_pre_footer_cta'), 130);
      add_action('do_theme_content', array('theme_content_output','print_page_content'));
      add_action('do_theme_after_content', array('theme_content_output','print_why_block'),5);
      add_action('do_theme_after_content', array('theme_content_output','print_home_social_about'),105);
      add_action('do_theme_after_content', array('theme_content_output','print_home_customer_story'),115);
      add_action('do_theme_after_content', array('theme_content_output','print_showcase_on_home'),125);
  }



  /**
  * adds hooks for static blog page
  */
  public static function hook_blog_functions(){
      add_action('do_theme_before_content', array('theme_content_output','print_blog_latest_article'), 10);
      add_action('do_theme_before_content', array('theme_content_output','print_blog_widgets'), 20);
      add_action('do_theme_before_content', array('theme_content_output','print_blog_latest'), 30);
  }


  /**
  * adds hooks for blog's category page
  */
  public static function hook_blog_category_functions(){
    add_action('do_theme_before_content', array('theme_content_output','print_blog_latest_article'), 10);
    add_action('do_theme_before_content', array('theme_content_output','print_blog_widgets'), 20);
    add_action('do_theme_before_content', array('theme_content_output','print_blog_latest'), 30);
  }



  /**
  * adds hooks for blog's tag page
  */
  public static function hook_post_tag_functions(){
    add_action('do_theme_before_content', array('theme_content_output','print_blog_latest_article'), 10);
    add_action('do_theme_before_content', array('theme_content_output','print_blog_widgets'), 20);
    add_action('do_theme_before_content', array('theme_content_output','print_blog_latest'), 30);
  }


  /**
  * adds hooks for blog's post page
  */
  public static function hook_blog_post_functions(){
    add_action('do_theme_content', array('theme_content_output','print_blog_post_content'), 10);

    add_action('do_theme_after_content', array('theme_content_output','print_blog_post_after'), 20);
  }


  /**
  * adds hooks for woocommerce shop page
  */
  public static function hook_woo_shop_functions(){
   /* common blocks of page template*/

    add_action('do_theme_before_content', array('theme_content_output','print_woo_shop_header'), 10);

    add_action('do_theme_before_content', array('theme_content_output','print_woo_shop_after_header'), 20);

    add_action('do_theme_after_content', array('theme_content_output','print_pre_footer_cta'), 90);
  }


  /**
  * adds and removes actions for woocommerce loops
  * used on shop page, shop's category page, in theme product widget
  */
  public static function hook_woo_common_shop(){

    /*customizing woocommerce*/

    /*product view in a loop*/

    remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
    remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

    remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );

    remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 10 );


    remove_action('woocommerce_shop_loop_item_title','woocommerce_template_loop_product_title' );

    remove_action('woocommerce_after_shop_loop_item_title','woocommerce_template_loop_price');

    remove_action('woocommerce_after_shop_loop_item','woocommerce_template_loop_add_to_cart');


    /* prints opening tag for product image div*/
    add_action('woocommerce_before_shop_loop_item', array('theme_content_output', 'print_product_loop_open_image'));

    /* prints opening tag for product image link*/
    add_action('woocommerce_before_shop_loop_item', array('theme_content_output', 'print_product_open_link'), 20);

    /* prints closing tag for product image link*/
    add_action('woocommerce_before_shop_loop_item_title','woocommerce_template_loop_product_link_close', 11);

    /* prints closing tag for product image div*/
    add_action('woocommerce_before_shop_loop_item_title',array('theme_content_output', 'print_product_loop_close_div'), 12);

    /* prints premium/regular tag for large item*/
    add_action('woocommerce_before_shop_loop_item_title', array('theme_content_output', 'theme_print_product_loop_gallery_abs'), 10);

    /* prints premium/regular tag for large item*/
    add_action('woocommerce_before_shop_loop_item_title', array('theme_content_output', 'theme_print_product_loop_tag_ing_thumb'), 10);

    /* prints premium/regular tag*/
    add_action('woocommerce_before_shop_loop_item_title', array('theme_content_output', 'theme_print_product_loop_tag'), 15);


    /* prints opening tag for product content div*/
    add_action('woocommerce_before_shop_loop_item_title', array('theme_content_output', 'print_product_loop_open_row'), 9999);

    /* prints product's category'*/
    add_action('woocommerce_shop_loop_item_title', array('theme_content_output', 'theme_print_product_loop_category'), 9);

    add_action('woocommerce_shop_loop_item_title', array('theme_content_output', 'theme_print_product_loop_title'), 10);

    /* prints product's description'*/
    add_action('woocommerce_shop_loop_item_title', array('theme_content_output', 'theme_print_product_loop_description'), 15);

    /* prints product's gallery'*/
    add_action('woocommerce_shop_loop_item_title', array('theme_content_output', 'theme_print_product_loop_gallery'), 20);


    /* prints closing tag for product content div*/
    add_action('woocommerce_after_shop_loop_item_title', array('theme_content_output', 'print_product_loop_close_div'), 1);
  }


  /**
  * adds and removes actions for woocommerce single product's page
  */
  public static function hook_woo_single_product(){
    /* removes standard woocommerce functions on a single product's page*/
    remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating');
    remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price');

    remove_action('woocommerce_single_variation', 'woocommerce_single_variation', 10);

    remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);

    remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);

    remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50);

    remove_action('woocommerce_single_product_summary', array('WC_Structured_Data', 'generate_product_data'), 60);


    remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10);

    remove_action('woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15);

    remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);

    /*prints text block with approximate deadlines for an order*/
    add_action('woocommerce_single_product_summary',array('theme_content_output','print_single_product_estimates'), 25);

    /*replaces output of a product notifications*/
    remove_action('woocommerce_before_single_product', 'woocommerce_output_all_notices', 10);

    add_action('theme_before_add_to_cart_form', 'woocommerce_output_all_notices', 28);


    /*prints product's title in case if user is not premium one*/
    add_action('woocommerce_single_product_summary_prem','woocommerce_template_single_title', 5);

    /*prints product's short description in case if user is not premium one*/
    add_action('woocommerce_single_product_summary_prem','woocommerce_template_single_excerpt', 20);

    /*prints text block with approximate deadlines for an order in case if user is not premium one*/
    add_action('woocommerce_single_product_summary_prem',array('theme_content_output','print_single_product_estimates'), 25);

    /*prints text block with buy premium button*/
    add_action('woocommerce_single_product_summary_prem',array('theme_content_output','print_woo_single_product_unlock_premium'), 35);

   /*prints unlock premium button in a premium product*/
    add_action('do_theme_purchase_premium', 'woocommerce_template_single_add_to_cart');

    /*prints upsells*/
    add_action('woocommerce_after_single_product', 'woocommerce_upsell_display', 15);

    /*prints crosselss*/
    add_action('woocommerce_after_single_product', 'woocommerce_output_related_products', 20);

    add_action('wp_footer', array('theme_content_output','print_product_attributes_sidebar'), 20);

    add_action('woocommerce_after_single_product', array('theme_content_output','print_ingredients'), 11);

    add_action('woocommerce_before_single_product_summary', array('theme_content_output', 'print_single_product_images_after'),30);

    add_action('finish_page', array('theme_content_output','print_single_product_guidlines'));
  }


  /**
  * adds and removes actions for woocommerce checkout page
  */
  public static function hook_woo_checkout(){
    /*prints page content*/
    add_action('do_theme_content', array('theme_content_output','print_page_content'));

    /*prints sidebar for buying subscription*/
    add_action('do_checkout_sidebar_premium', array('theme_content_output','print_checkout_sidebar_premium'));

    /*prints pay methods for buying subscription*/
    add_action('do_checkout_pay_premium', array('theme_content_output','print_checkout_pay_premium'));

    add_action('do_checkout_sidebar_regular', array('theme_content_output','print_checkout_sidebar_regular'));

    add_action('custom_action', array('theme_content_output','print_checkout_estimates'), 11);

    add_action('custom_action', array('theme_content_output','print_checkout_totals'), 12);

    add_action('woocommerce_review_order_before_submit', array('theme_content_output','print_coupon_form_in_checkout'), 11);

    add_action('woocommerce_before_checkout_form', array('theme_content_output','check_prem_before_checkout_form'));

        remove_action('woocommerce_before_customer_login_form', 'woocommerce_output_all_notices');
        remove_action('woocommerce_before_shop_loop', 'woocommerce_output_all_notices');
        remove_action('woocommerce_before_single_product', 'woocommerce_output_all_notices');
        remove_action('woocommerce_before_cart', 'woocommerce_output_all_notices');
        remove_action('woocommerce_before_checkout_form_cart_notices', 'woocommerce_output_all_notices');

        add_action('theme_custom_before_login','woocommerce_output_all_notices');

    if (wc()->checkout->is_registration_required() && ! is_user_logged_in() && ('yes' === get_option('woocommerce_enable_checkout_login_reminder'))) {

      remove_action('do_theme_header', array('theme_content_output','print_header'));
      remove_action('do_theme_footer', array('theme_content_output','print_footer'));
    }
  }


  /**
  * Detects what kind of page classes should be
  *
  * @return string
  */
  public static function detect_header_classes($header_class){
    $queried = get_queried_object();

    if( is_front_page() && defined( 'THEME_HERO_SECTION' ) ){
      // $header_class = array('site-header_contrast');

       $o = get_post_meta($queried->ID, '_header_style', true);
       if ('contrast' === $o) {
          $header_class = array('site-header_contrast');
       }
    }

    if( !$header_class ){
      $header_class = array('site-header_regular');
    }

    if(self::is_page_type('woo-my-account') && !is_wc_endpoint_url( 'orders' ) ){
      $header_class = array('site-header_regular', 'white ');
    }

     if(self::is_page_type('showcase')){
      $header_class = array('site-header_contrast');
     }

     if(self::is_page_type('custom-pages')){
      if(  $queried->ID === (int)get_option('theme_page_customers')){
        $header_class = array('site-header_contrast');
      }
     }

     if($queried->ID ===  (int)get_option('theme_page_showcase')){
      $header_class = array('site-header_contrast');
     }

     if($queried->post_type ===  velesh_theme_posts::$customer_name || self::is_page_type('woo-product')){
         $header_class = array('site-header_regular', 'white ');
     }

     if(is_page() && !self::is_page_type('custom-pages') && !is_front_page()){
         $o = get_post_meta($queried->ID, '_header_style', true);
         if ('contrast' === $o) {
            $header_class = array('site-header_contrast');
         }
     }

    $return = implode(' ', $header_class);

    return $return;
  }
}
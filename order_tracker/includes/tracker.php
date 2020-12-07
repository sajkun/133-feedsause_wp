<?php
if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}

if(!class_exists('theme_order_tracker')){
  class theme_order_tracker{

    public $slug_options = 'duh_tracker_options';

    public function __construct(){
      add_action('admin_menu', array($this, 'settings_page'));
      add_action('before_scripts', array($this, 'prepare_javascript_data'));
      add_filter('template_include', array($this, 'change_template'), 500);
    }

    public function get_options(){
      return get_option($this->slug_options);
    }

    /**
    * prints inline javascript variables
    * pass data from database to script
    */
    public function prepare_javascript_data(){
      $start = microtime(true);

      $options = get_option($this->slug_options);

      /**
      * column data for frontdesk
      */
      $frondtdesk_columns_data = array_filter($options['orders'], function($el){
        return $el['is_frontdesk'] == 'yes';
      });
      if( $frondtdesk_columns_data ){
        usort($frondtdesk_columns_data, 'sort_by_order');
      }



      /**
      * column data for studio
      */
      $studio_columns_data = array_filter($options['orders'], function($el){
        return $el['is_studio'] == 'yes';
      });

      if( $studio_columns_data ){
        usort($studio_columns_data, 'sort_by_order');
      }

      /**
      * order statuses for frondesk
      */
      $keys = array_map(function($el){
        return $el['slug'];
      },$frondtdesk_columns_data);

      $order_statuses_frontdesk = array_map(function($el){
        return array(
        'color' => $el['text_color'],
        'title' => $el['name'],
        'slug'  => $el['slug'],
        );
      },$frondtdesk_columns_data);

      $order_statuses_frontdesk = array_combine($keys, $order_statuses_frontdesk);

      /**
      * different wordpress endpoints and urls
      */
      $urls  = array(
        'ajax'      => admin_url('admin-ajax.php'),
        'theme_url' => THEME_URL,
        'site_url'  => HOME_URL,
      );

      /**
      * all campaigns for lists
      */
      $campaigns = isset($options['campaigns'])? array_map(function($el){ return trim($el);}, explode(PHP_EOL, $options['campaigns'])) : false;

      /**
      * all sources for lists
      */
      $sources = isset($options['sources'])? array_map(function($el){ return trim($el);}, explode(PHP_EOL, $options['sources'])): false;

      /**
      * data about user for lists of personal
      */
      $args_users = array(
        'limit'          => -1,
        'posts_per_page' => -1,
      );

      if(isset($options['user_roles_to_use'])){
        $args_users['role__in'] = $options['user_roles_to_use'];
      }

      $users = array_map(function($el){
        return array(
          'name'     => $el->data->display_name,
          'gravatar' => get_avatar_url($el),
        );
      }, get_users($args_users));

      /**
      * get all creators
      */
      $args_users = array(
        'limit'          => -1,
        'posts_per_page' => -1,
      );

      if(isset($options['user_roles_to_use_creative'])){
        $args_users['role__in'] = $options['user_roles_to_use_creative'];
      }

      $creators = array_map(function($el){
        return array(
          'name'     => $el->data->display_name,
          'gravatar' => get_avatar_url($el),
        );
      }, get_users($args_users));

      /**
      * get customer's data
      */
        global $wp_roles;
        $args_customers = array(
          'limit'          => -1,
          'posts_per_page' => -1,
          // 'role__in'       =>array('customer'),
        );

        $all_customers = array_map(function($el){
          $customer = new WC_Customer($el->ID);
          return array(
            'name'    => $el->display_name,
            'user_id' => $el->ID,
            'brand'   => $customer->get_billing_company(),
            'billing' => $customer->get_billing(),
            'email'   => $customer->get_email(),
            'user_registered' => $el->data->user_registered,
          );
        },get_users($args_customers));

      /**
      * products addons
      */
      $priority_delivery = wc_get_product((int)get_option('wfp_priority_delivery_product_id'));

      $return_product = wc_get_product((int)get_option('wfp_return_product_id'));

      $order_addons = array(
        'turnaround' => array(
          'fasttrack'=> array(
            'name'=> 'Fast Track',
            'price'=> $priority_delivery->get_regular_price(),
            'product_id' => (int)get_option('wfp_priority_delivery_product_id'),
          ),
          'regular'=> array(
            'name'=> 'Standart',
            'price'=> 0,
            'product_id' => -1,
          ),
        ),

        'handling'   => array(
          'return' => array(
            'name'=> 'Return Products',
            'price'=> $return_product->get_regular_price(),
            'product_id' => (int)get_option('wfp_return_product_id'),
          ),
          'regular'=> array(
            'name'=> 'Hold Product',
            'price'=> 0,
            'product_id' => -1,
          ),
        ),

        'sendvia'    => array(
          'free'=> array(
            'name'=> 'Free Collection',
            'price'=> 0,
            'product_id' => -1,
          ),
          'self' => array(
            'name'=> 'Self Shipping',
            'price'=> 0,
            'product_id' => -1,
          ),
        ),
      );

      /**
      * Get products
      */

      $args = array(
        'limit'   => -1,
        'exclude' => array(
          (int)get_option('wfp_priority_delivery_product_id'),
          (int)get_option('wfp_return_product_id'),
          (int)get_option('wfp_single_product_id'),
        ),
      );

      $products = wc_get_products($args);

      $available_products = array_filter($products, function($p){
        return "variable" == $p->get_type();
      });

      /**
      * get keys for product array
      */
      $available_products_keys = array_values(array_map(function($product){
        return strtolower($product->get_title());
      }, $available_products ));


      /**
      * format data about variations
      */
      $available_products = array_map(function($product){
        $variation_obj = $product->get_available_variations('objects');
        $variations = array_map( function($var){
          $images = $var->get_meta('_items_count');
          $image_count = 1;

          if(isset($images[$var->get_id()])){
            $image_count = $images[$var->get_id()];
          }else{
            $image_count = get_count_from_name($var->get_name());
          }
          return array(
            'price'   => $var->get_regular_price(),
            'images'  => $image_count,
            'variation_id' => $var->get_id(),
          );
        } , $variation_obj );

        $variation_ids = array_values(array_map( function($var){
          return $var->get_id();
        }, $variation_obj ));

        return array(
          'name'            => $product->get_title(),
          'variations'      => array_combine($variation_ids,$variations ),
          'free_product_id' => $product->get_meta('free_sample'),
        );
      }, $available_products );


      /**
      * get date settings
      */
       $data = isset($_COOKIE['date_range_frontdesk'])? json_decode(str_replace('\\','', $_COOKIE['date_range_frontdesk'])): false;

       if(!$data){
         $start_date = new DateTime();
         $end_date   = new DateTime();
         $start_date->modify('-1 month');
       }else{
         $start_date = new DateTime($data->start_his);
         $end_date   = new DateTime($data->end_his);
       }

       /**
       * get order data
       */
       switch (get_queried_object_id()) {
         case (int)$options['tracker_page']:
           $type = 'frontdesk';
           break;

         case (int)$options['studio_page']:
           $type = 'studio';
           break;
       }

       $orders = get_items_for_tracker($type, $start_date->format('Y-m-d H:i:s'), $end_date->format('Y-m-d 23:59:59') );


       /**
       * get elements filtered
       */

       $filter_values = get_filter_data($orders);

       /**
       * get all available coupons
       */
       $args = array(
            'posts_per_page'   => -1,
            'orderby'          => 'title',
            'order'            => 'asc',
            'post_type'        => 'shop_coupon',
            'post_status'      => 'publish',
        );

       $coupons = array_map(function($item){
         $coupon = new WC_Coupon($item->ID);

         return array(
           'name'          => $item->post_title,
           'coupon_id'     => $item->ID,
           'price'         => $coupon->get_amount(),
           'discount_type' => $coupon->get_discount_type(),
         );
       },get_posts($args));

       /**/
       $user = get_user_by('ID',get_current_user_id());

       /**
       * create array of all data to print
       */
      $data = array(
        'tracker_url'             => array(THEME_URL. '/order_tracker/'),
        'theme_debug'             => THEME_DEBUG? 1: 0,
        'all_users'               => $users,
        'all_creators'            => $creators,
        'dropbox'                 => $options['dropbox'],
        'all_customers'           => $all_customers,
        'available_products'      => array_combine($available_products_keys, $available_products),
        'filter_values'           => $filter_values,
        'order_campaigns'         => $campaigns,
        'order_sources'           => $sources,
        'all_coupons'             => $coupons,
        'order_addons'            => $order_addons,
        'frondtdesk_columns_data' => $frondtdesk_columns_data,
        'studio_columns_data'     => $studio_columns_data,
        'order_statuses'          => $order_statuses_frontdesk,
        'frondtdesk_items'        => $orders,
        'studio_items'            => $orders,
        'WP_URLS'                 => $urls,
        'tracker_options'         => $options,
        'logged_in_user'          => array('name'=>$user->display_name, 'user_id'=> $user->ID),
      );

      clog($data);

      foreach ($data as $name => $value) {
        print_javascript_data($name, $value);
      }

      clog('prepare javascript data: '.round(microtime(true) - $start, 4).' сек.', 'red');
    }

    /**
    * adds all admin area tracker pages
    */
    public function settings_page(){
      add_options_page( 'Tracker-Settings', 'Tracker Settings', 'manage_options', 'duh_tracker_settings', array($this, 'settings_page_cb'));
    }

      /**
      * adds form of tracker settings page
      */
      public function settings_page_cb(){
        wp_enqueue_style( 'wp-color-picker' );
        wp_enqueue_script( 'wp-color-picker' );

        wp_enqueue_style('jquery-ui', '//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css' );

        wp_enqueue_script('jquery-ui', 'https://code.jquery.com/ui/1.12.1/jquery-ui.js', array('jquery'), THEME_VERSION, true);


        if(isset($_POST['do_save']) && 'yes' === $_POST['do_save']){
          update_option($this->slug_options, $_POST[$this->slug_options]);
        }

        $o = get_option($this->slug_options);

        $pages = get_posts(array(
          'post_type' => 'page',
          'posts_per_page' => -1,
        ));

        $tabs = array(
          'general'    => 'General',
          'orders'     => 'Order Settings',
          'roles'      => 'Roles Settings',
          'extra_data' => 'Sources, Campaigns',
          'dropbox'    => 'Dropbox',
        );

        $order_statuses = isset($o['orders'])? $o['orders'] : wc_get_order_statuses();

        foreach (wc_get_order_statuses() as $key => $order_name) {
          if(!array_key_exists( $key, $order_statuses )){
            $order_statuses[$key] = array(
              'name' => $order_name,
              'slug' => $key,
            );
          }
        }

        if ($order_statuses) {
           usort($order_statuses, 'sort_by_order');
        }

       global $wp_roles;

        $args = array(
          'slug'  => $this->slug_options,
          'pages' => $pages,
          'roles' => $wp_roles->roles,
          'tabs'  => $tabs,
          'options' => $o,
          'order_statuses' => $order_statuses ,
        );

        clog($o);

        print_duh_template_part('settings', 'order_tracker/templates/admin', $args);
      }


    /**
    * changes template if current page is a tracker page
    */
    public function change_template($template){

      $o = get_option($this->slug_options);
      $obj = get_queried_object_id();

      if ($o['tracker_page'] == get_queried_object_id() || $o['studio_page'] == get_queried_object_id() ) {
        return THEME_PATH . '/order_tracker/template.php';
      }

      return $template;
    }
  }

  global $theme_order_tracker;
  $theme_order_tracker = new theme_order_tracker();

}
if(!function_exists('duh')){
  function duh(){
    global $theme_order_tracker;
    return $theme_order_tracker;
  }
}
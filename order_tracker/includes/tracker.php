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
      usort($frondtdesk_columns_data, 'sort_by_order');

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
      * all brands for lists
      */
      $brands = isset($options['brands'])? array_map(function($el){ return trim($el);}, explode(PHP_EOL, $options['brands'])) : false;


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
      * Get date range for initial order load
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
      * get products for product array
      */

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

       $orders = get_items_for_tracker('frontdesk',  $start_date->format('Y-m-d H:i:s'), $end_date->format('Y-m-d H:i:s') );

       /**
       * get elements filtered
       */

       $filter_values = array(
         'campaign' => array(),
         'source'   => array(),
         'team'      => array(),
       );

       $grab_filter = array(
         'campaign' => ['customer.campaigns'],
         'source'   => ['customer.source'],
         'team'      => ['customer.assigned', 'studio.creator'],
       );

       foreach ($grab_filter as $filter_key => $filter_sources) {
         $filter_values[$filter_key] = array();

         foreach ($filter_sources as $key => $source) {
           $path = array_fill(0, count($orders), $source);
           $temp = array_map(function($el,  $data){
              $path = explode('.',$data);
              return isset($el['data'][$path[0]][$path[1]]) ? $el['data'][$path[0]][$path[1]] : '';
            },$orders, $path);

            $temp = array_unique($temp);
            $filter_values[$filter_key] = array_merge($filter_values[$filter_key], $temp);
         }

          $filter_values[$filter_key] = array_filter($filter_values[$filter_key], function($el){
            return !empty($el);
          } );

          $filter_values[$filter_key] = $filter_values[$filter_key]?: array();
          array_unshift($filter_values[$filter_key], 'All '.$filter_key);
       }


       /**/
       $user = get_user_by('ID',get_current_user_id());

       /**
       * create array of all data to print
       */
      $data = array(
        'theme_debug'             => THEME_DEBUG? 1: 0,
        'all_users'               => $users,
        'available_products'      => array_combine($available_products_keys, $available_products),
        'filter_values'           => $filter_values,
        'order_campaigns'         => $campaigns,
        'order_brands'            => $brands,
        'order_sources'           => $sources,
        'frondtdesk_columns_data' => $frondtdesk_columns_data,
        'order_statuses'          => $order_statuses_frontdesk,
        'frondtdesk_items'        => $orders,
        'WP_URLS'                 => $urls,
        'logged_in_user'          => array('name'=>$user->display_name, 'user_id'=> $user->ID),
      );

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
          'general'   => 'General',
          'orders'    => 'Order Settings',
          'extra_data' => 'Extra Data',
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

       usort($order_statuses, 'sort_by_order');

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

      if ($o['tracker_page'] == get_queried_object_id()) {
        return THEME_PATH . '/order_tracker/template.php';
      }

      return $template;
    }
  }

  global $theme_order_tracker;
  $theme_order_tracker = new theme_order_tracker();

  function duh(){
    global $theme_order_tracker;
    return $theme_order_tracker;
  }
}
<?php
if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}


if(!class_exists('tracker_content_output')){
  class tracker_content_output{
    /**
    * prints header of page
    */
    public static function print_header(){

      global $wpdb;

      $options = get_option(duh()->slug_options);
      $user    = wp_get_current_user();

      $can_see_frontdesk = count(array_intersect($options['user_roles_to_use'],$user->roles)) > 0;


      $orders = wc_get_orders(array(
        'limit' => -1,
        '_wfp_image' => 'request',
        'return' => 'ids',
      ));

      $orders = join("','",$orders);

      //review
      /****************************************/
      /****************************************/
      /****************************************/



      //review
      /****************************************/
      /****************************************/
      /****************************************/

      $querystr = "
        SELECT *
        FROM   $wpdb->postmeta
        WHERE $wpdb->postmeta.meta_key = '_wfp_image'
        AND  $wpdb->postmeta.post_id IN  ('$orders')
      ";

      $request = $wpdb->get_results($querystr, OBJECT);

      $wfp_image = array_map(function($el){
        return unserialize($el);
      },array_column($request, 'meta_value'));

      $ids = array_column($request, 'post_id');

      $result = array_combine($ids,  $wfp_image);

      array_walk($result, function(&$el, $ind){
        $el = array(
          'items' => array_filter($el, function($el){
              return isset($el['request']) && isset($el['files_uploaded']);
            }),
          'order_id' => $ind,
        );
      });

      $result = array_map(function($el){
        $items = array_values($el['items']);
        foreach($items as $key => $i){
          $items[$key]['order_id'] = $el['order_id'];
        }
        return $items;
      },$result);

      $result = array_filter($result, function($el){
        return count($el) > 0;
      });

      $result = array_values($result);

      $images = array_reduce( $result, 'array_merge', array());

      $images = array_filter($images, function($el){
        return( ($el['is_active'] == '0') && !isset($el['request_decision']));
      });
        /*******to be done*****/
      /*****************************/


      $args = array(
        'home_url'   => (isset($options['tracker_page']))? get_permalink($options['tracker_page']) : false,
        'studio_url' => (isset($options['studio_page']))? get_permalink($options['studio_page']) : false,
        'review_url' => (isset($options['review_page']))? get_permalink($options['review_page']) : false,
        'name'       => $user->display_name,
        'is_studio'     => get_queried_object_id() === (int)$options['studio_page'],
        'is_frontdesk'  => get_queried_object_id() === (int)$options['tracker_page'],
        'is_review'     => get_queried_object_id() === (int)$options['review_page'],
        'avatar_url' => get_avatar_url($user),
        'can_see_frontdesk' => $can_see_frontdesk,
        'number' => count($images),
      );

      print_duh_template_part( 'header' ,'order_tracker/templates/global', $args);
    }


    /**
    * prints frontdesk list
    */
    public static function print_front_desk(){
      $args = array();
      print_duh_template_part( 'frontdesk' ,'order_tracker/templates/global', $args);

      $args = array();
      print_duh_template_part( 'frontdesk-single-new' ,'order_tracker/templates/global', $args);

      $args = array();
      print_duh_template_part( 'frontdesk-single' ,'order_tracker/templates/global', $args);
    }


    public static function print_studio(){
      $args = array();
      print_duh_template_part( 'studio' ,'order_tracker/templates/global', $args);

      $args = array();
      print_duh_template_part( 'studio-content' ,'order_tracker/templates/global', $args);

    }


    /**
    * prints block screen
    */
    public static function print_block_screen(){
      print_duh_template_part( 'block-screen' ,'order_tracker/templates/global', array());
    }


    /**
    * prints block screen
    */
    public static function print_popups(){
      print_duh_template_part( 'popup-address' ,'order_tracker/templates/global', array());

      print_duh_template_part( 'popup-address-billing' ,'order_tracker/templates/global', array());

      print_duh_template_part( 'popup-product' ,'order_tracker/templates/global', array());

      print_duh_template_part( 'popup-fee' ,'order_tracker/templates/global', array());
    }

    public static function print_reviews(){
       global $wpdb;

      $orders = wc_get_orders(array(
        'limit' => -1,
        '_wfp_image' => 'request',
        'return' => 'ids',
      ));

      $orders = join("','",$orders);

      $querystr = "
        SELECT *
        FROM   $wpdb->postmeta
        WHERE $wpdb->postmeta.meta_key = '_wfp_thumbnails'
        AND  $wpdb->postmeta.post_id IN  ('$orders')
      ";

      $request_th = $wpdb->get_results($querystr, OBJECT);

      $thumbnails = array_map(function($el){
        return unserialize($el);
      },array_column($request_th, 'meta_value'));

      $thumb_ids = array_column($request_th, 'post_id');

      $thumbs_data = array_combine($thumb_ids, $thumbnails);

      array_walk($thumbs_data, function(&$el, $ind){
        $el = array(
          'items' => $el,
          'order_id' => $ind,
        );
      });

      $thumbs_data = array_values($thumbs_data);

      //review
      /****************************************/
      /****************************************/
      /****************************************/

      $querystr = "
        SELECT *
        FROM   $wpdb->posts
        WHERE  $wpdb->posts.ID IN  ('$orders')
      ";

       $order_dates = $wpdb->get_results($querystr, OBJECT);

       $order_dates = array_map(function($el){
         return array(
           'order_id'   => $el->ID,
           'post_date' => $el->post_date,
         );
       }, $order_dates);

      //review
      /****************************************/
      /****************************************/
      /****************************************/

      $querystr = "
        SELECT *
        FROM   $wpdb->postmeta
        WHERE $wpdb->postmeta.meta_key = '_wfp_image'
        AND  $wpdb->postmeta.post_id IN  ('$orders')
      ";

      $request = $wpdb->get_results($querystr, OBJECT);

      $wfp_image = array_map(function($el){
        return unserialize($el);
      },array_column($request, 'meta_value'));

      $ids = array_column($request, 'post_id');

      $result = array_combine($ids,  $wfp_image);

      array_walk($result, function(&$el, $ind){
        $el = array(
          'items' => array_filter($el, function($el){
              return isset($el['request']) && isset($el['files_uploaded']);
            }),
          'order_id' => $ind,
        );
      });

      $result = array_map(function($el){
        $items = array_values($el['items']);
        foreach($items as $key => $i){
          $items[$key]['order_id'] = $el['order_id'];
        }
        return $items;
      },$result);

      $result = array_filter($result, function($el){
        return count($el) > 0;
      });

      $result = array_values($result);

      $images = array_reduce( $result, 'array_merge', array());

      print_javascript_data('thumbs_data', $thumbs_data);
      print_javascript_data('review_images', $images);
      print_javascript_data('order_dates', $order_dates);
      // clog(  $thumbs_data );
      // clog(  $images );

      print_duh_template_part( 'review-page' ,'order_tracker/templates/global', array());
    }
    /**
    * prints block screen
    */
    public static function print_popups_studio(){
      $options = get_option(duh()->slug_options);
      print_duh_template_part( 'popup-shoot' ,'order_tracker/templates/global', array());
      print_duh_template_part( 'popup-studio-errors' ,'order_tracker/templates/global', array());

      $url = isset($options['standarts'])? get_permalink($options['standarts']) : false;

      print_duh_template_part( 'popup-quality' ,'order_tracker/templates/global', array('url' => $url));
    }
  }
}


function handle_custom_query_var( $query, $query_vars ) {
  if ( ! empty( $query_vars['_wfp_image'] ) ) {
    $query['meta_query'][] = array(
      'key' => '_wfp_image',
      'value' => esc_attr( $query_vars['_wfp_image'] ),
      'compare_key' => 'LIKE',
      'compare'     => 'LIKE',
    );
  }

  return $query;
}
add_filter( 'woocommerce_order_data_store_cpt_get_orders_query', 'handle_custom_query_var', 10, 2 );
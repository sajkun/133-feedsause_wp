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

      $options = get_option(duh()->slug_options);
      $user    = wp_get_current_user();

      $can_see_frontdesk = count(array_intersect($options['user_roles_to_use'],$user->roles)) > 0;

      $end_date = new DateTime();
      $start_date   = new DateTime('1999-01-01T00:00:00');
      $type = 'studio';

      $orders = get_items_for_tracker($type, $start_date->format('Y-m-d H:i:s'), $end_date->format('Y-m-d 23:59:59') );


      /*****************************/
      /*******to be done*****/
      /*****************************/
      /*****************************/

      $data = array_filter($orders, function($el){

        if(!isset($el['data']['wfp_images']) || !$el['data']['wfp_images']){
            return false;
        }

        if(!$el['date_completed']){
          return false;
        }

        $today = new DateTime();

        $order_date = new  DateTime($el['date_completed']->date('Y-m-d'));

        date_diff($order_date, $today);

        $images = array_map(function($e){
           return array(
            'request' => $e['request'],
            'is_active' => $e['is_active'],
            'was_downloaded' => $e['was_downloaded'],
          );
        },

        array_filter($el['data']['wfp_images'], function($e){
            return isset($e['request']);
        }));

         return count($images) > 0;
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
        'number' => count(array_values($data)),
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
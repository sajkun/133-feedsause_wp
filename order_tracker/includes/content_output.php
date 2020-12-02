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

      $args = array(
        'home_url'   => (isset($options['tracker_page']))? get_permalink($options['tracker_page']) : false,

        'studio_url' => (isset($options['studio_page']))? get_permalink($options['studio_page']) : false,
        'name'       => $user->display_name,
        'is_studio'  => get_queried_object_id() === (int)$options['studio_page'],
        'avatar_url' => get_avatar_url($user),
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
  }
}
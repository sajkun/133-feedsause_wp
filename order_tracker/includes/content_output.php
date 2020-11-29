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
        'home_url' => get_permalink($options['tracker_page']),
        'name'     => $user->display_name,
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
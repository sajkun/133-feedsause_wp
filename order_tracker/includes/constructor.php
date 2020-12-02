<?php
if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}


if(!class_exists('tracker_content_constructor')){
  class tracker_content_constructor{
    public static function init(){
      // $options['user_roles_to_use'];


      $o = get_option(duh()->slug_options);

      add_action('do_tracker_header', array('tracker_content_output', 'print_header'));

      if($o['tracker_page'] == get_queried_object_id() ){
          tracker_content_constructor::validate();
          add_action('do_tracker_content', array('tracker_content_output', 'print_front_desk'));
          add_action('do_tracker_after_footer', array('tracker_content_output', 'print_popups'));
      }

      if($o['studio_page'] == get_queried_object_id() ){
         tracker_content_constructor::validate();
         add_action('do_tracker_content', array('tracker_content_output', 'print_studio'));
      }

     add_action('do_tracker_after_footer', array('tracker_content_output', 'print_block_screen'));
    }

  public static function validate(){
      if(!is_user_logged_in()){
        wp_safe_redirect( HOME_URL, 302, 'WordPress' );
        exit;
      }

      $o = get_option(duh()->slug_options);
      $user = get_user_by('ID', get_current_user_id());

      $validated = false;

      if(!isset($o['user_roles_to_use'])){
        wp_safe_redirect( HOME_URL, 302, 'WordPress' );
        exit;
      }

      foreach ($user->roles as $key => $role) {
        $validated = in_array($role, $o['user_roles_to_use'])? true : $validated;
      }

      if(!$validated){
        wp_safe_redirect( HOME_URL, 302, 'WordPress' );
        exit;
      }
    }
  }
}
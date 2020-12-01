<?php
if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}


if(!class_exists('tracker_content_constructor')){
  class tracker_content_constructor{
    public static function init(){
      $o = get_option(duh()->slug_options);

      add_action('do_tracker_header', array('tracker_content_output', 'print_header'));

      if($o['tracker_page'] == get_queried_object_id() ){
          add_action('do_tracker_content', array('tracker_content_output', 'print_front_desk'));
          add_action('do_tracker_after_footer', array('tracker_content_output', 'print_popups'));
      }

      if($o['studio_page'] == get_queried_object_id() ){
         add_action('do_tracker_content', array('tracker_content_output', 'print_studio'));
      }

     add_action('do_tracker_after_footer', array('tracker_content_output', 'print_block_screen'));
    }
  }
}
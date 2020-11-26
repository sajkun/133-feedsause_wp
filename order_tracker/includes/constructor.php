<?php
if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}


if(!class_exists('tracker_content_constructor')){
  class tracker_content_constructor{
    public function __construct(){
      add_action('do_tracker_header', array('tracker_content_output', 'print_header'));

      add_action('do_tracker_header', array('tracker_content_output', 'print_block_screen'));

      add_action('do_tracker_content', array('tracker_content_output', 'print_front_desk'));
    }
  }

  new tracker_content_constructor();
}
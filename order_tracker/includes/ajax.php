<?php

if(!class_exists('tracker_ajax')){
  class tracker_ajax{

    public function __construct(){
      // changes order status
      add_action('wp_ajax_save_order_status', array($this, 'save_order_status_cb'));

      // get orders within passed dates
      add_action('wp_ajax_get_orders_by_dates', array($this, 'get_orders_by_dates_cb'));

      //updates order custom meta
      add_action('wp_ajax_update_order_meta', array($this, 'update_order_meta_cb'));
    }

    /**
    * updates order status
    */
    public static function save_order_status_cb(){
      $order = wc_get_order($_POST['order_id']);
      $order_status = str_replace('wc-', '', $_POST['order_status']);
      $order->set_status($order_status);
      $order->save();
      wp_send_json($_POST);
    }

    /**
    * get orders within passed dates
    */
    public static function get_orders_by_dates_cb(){
      $start_date = new DateTime($_POST['data']['_from']);
      $end_date   = new DateTime($_POST['data']['_to']);
      $orders     = get_items_for_tracker('frontdesk',  $start_date->format('Y-m-d H:i:s'), $end_date->format('Y-m-d H:i:s') );
      wp_send_json(array(
        'orders' => $orders,
        '_POST' => $_POST,
      ));
    }

    /**
    * updates order custom meta
    */
    public static function update_order_meta_cb(){

      wp_send_json(array(
        'POST' => $_POST,
      ));
    }
  }

  new tracker_ajax();
}
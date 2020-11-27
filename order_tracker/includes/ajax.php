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

      add_action('wp_ajax_create_new_order', array($this, 'create_new_order_cb'));
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
      $order = wc_get_order($_POST['data']['order_id']);
      $order->set_status($_POST['data']['order_status']);
      $order_id = $order->get_id();


      $customer_id = $order->get_customer_id();
      $customer = new WC_Customer( $customer_id );
      $customer->set_billing_phone($_POST['data']['customer']['phone']);

      $save = array(
        '_message_count'    => $_POST['data']['message_count'],
        '_phone_count'      => $_POST['data']['phone_count'],

        '_source'           => $_POST['data']['customer']['source'],
        '_brand'            => $_POST['data']['customer']['brand'],
        '_campaign'          => $_POST['data']['customer']['campaign'],

        '_assigned_person'  => $_POST['data']['customer']['assigned'],
        '_assigned_creator' => $_POST['data']['studio']['creator'],

        'location'          => $_POST['data']['location']['unit'],
        'studio-notes'      => $_POST['data']['location']['comment'],

        'collect-products'  => $_POST['data']['product_collection']['do_collect'] == 'false'? 0 : 1,

        '_notes_equery' => isset($_POST['data']['messages']['enquery'])? $_POST['data']['messages']['enquery']:array(),
        '_notes_studio' => isset($_POST['data']['messages']['studio'])? $_POST['data']['messages']['studio']:array(),


        '_collection_address'      => $_POST['data']['product_collection']['address'],
        'collection-date'      => $_POST['data']['product_collection']['requested'],
      );

      // $do_save = $order->set_meta_data($save);

      $test = array();

      foreach($save as $meta_key => $meta_value){
        if($order->meta_exists($meta_key)){
          $test[$meta_key] = $order->update_meta_data($meta_key, $meta_value);
        }else{
          $test[$meta_key] = $order->add_meta_data($meta_key, $meta_value);
        }
      }

      $customer->save();
      $order->save_meta_data();
      $order->save();

      wp_send_json(array(
        'POST'   => $_POST,
        'order'  => $order,
        'do_save'  => $test,
      ));
    }


    public static function create_new_order_cb(){

      $order = wc_create_order();

      wp_send_json(array(
        'POST'   => $_POST,
        'order_id' => $order->get_id(),
      ));
    }
  }

  new tracker_ajax();
}
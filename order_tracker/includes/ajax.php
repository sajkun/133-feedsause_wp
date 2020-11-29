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
      $orders     = get_items_for_tracker('frontdesk',  $start_date->format('Y-m-d H:i:s'), $end_date->format('Y-m-d 23:59:59') );
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

      $test = save_order_meta($order);

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

      $order       = wc_create_order();
      $user_id = (int)$_POST['data']['customer']['user_id'];
      $billing = isset($_POST['data']['customer']['billing'])? $_POST['data']['customer']['billing'] : array();


      // if a new user insert it
      if($user_id < 0){}

      // assign customer
      $order->set_customer_id($user_id);

      //set billing address
      if($billing){
        foreach ($billing as $key => $value) {
          if(method_exists($order, 'set_billing_'.$key) && $value ){
            $order->{'set_billing_'.$key}($value);
          }
        }
      }

      // set order status
      if ($_POST['data']['order_status']) {
        $order->set_status($_POST['data']['order_status']);
      }

      $total = 0;
      // add products to order
      if(isset($_POST['data']['order']['items'])){
        foreach ($_POST['data']['order']['items'] as $data) {
          $product = wc_get_product((int)$data['product_id']);
          $total += $product->get_regular_price();

          $item = new WC_Order_Item_Product();
          $item->set_props(array(
            'name'         => $product->get_name(),
            'tax_class'    => $product->get_tax_class(),
            'product_id'   => $product->is_type( 'variation' ) ? $product->get_parent_id() : $product->get_id(),
            'variation_id' => $product->is_type( 'variation' ) ? $product->get_id() : 0,
            'variation'    => $product->is_type( 'variation' ) ? $product->get_attributes() : array(),
            'subtotal'     => wc_get_price_excluding_tax( $product, array( 'qty' => 1 ) ),
            'total'        => wc_get_price_excluding_tax( $product, array( 'qty' => 1 ) ),
            'quantity'     => 1,
          ));
          $item->set_backorder_meta();
          $item->set_order_id( $order->get_id() );
          $item->add_meta_data('extra_data', array(
            'comment' => array(
              'value' =>  $data['notes'],
              'label' => 'Comment',
              'name' => 'comment',
            ),
            'name' => array(
              'value' => $data['title'],
              'label' => 'Name',
              'name' => 'name',
            ),
            'sizes' => array(
              'value' => $data['sizes'],
              'label' => 'Sizes',
              'name' => 'sizes',
            ),
          ));
          $item->save_meta_data();
          $item->save();
          $order->add_item( $item );
        }
      }

      //add fees to order
      if(isset($_POST['data']['order']['fee'])){
        foreach ($_POST['data']['order']['fee'] as $fee) {
          $item = new WC_Order_Item_Fee();
          $item->set_props( array(
            'name'      => $fee['fee_name'],
            'tax_class' =>  0,
            'total'     => $fee['price'],
            'total_tax' => 0,
            'taxes'     => array(
              'total' => 0,
            ),
            'order_id'  => $order->get_id(),
          ) );
          $item->save();
          $order->add_item( $item );
          $total += (float)$fee['price'];
        }
      }

      // add additional service
      if($_POST['data']['order']['addons']){
        foreach ($_POST['data']['order']['addons'] as $addon) {
          if(!isset($addon['product_id'])){continue;}
          $product_id = (int)$addon['product_id'];
          if($product_id < 0){continue;}
          $product = wc_get_product($product_id);
          $total += $product->get_regular_price();
          $order->add_product($product);
        }
      }

      if(isset($_POST['data']['order']['addons']['discount']['coupon_id'])){
        $coupon_id = $_POST['data']['order']['addons']['discount']['coupon_id'];
        $coupon = new WC_Coupon($coupon_id);
        if($coupon ){
          $order->apply_coupon($coupon);
          $total -= $coupon->get_discount_amount($total);
        }
      }

      $order->legacy_set_total($total);

      save_order_meta($order);
      $order->save_meta_data();
      $order->save();


      $data = get_item_for_tracker($order->get_id());

      wp_send_json(array(
        'order_data' => $data['data'],
        'user_id'    => $user_id,
        'order_id'   => $order->get_id(),
      ));
    }
  }

  new tracker_ajax();
}
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

      //create new order
      add_action('wp_ajax_create_new_order', array($this, 'create_new_order_cb'));

      //upload pdf and changes order attachment
      add_action('wp_ajax_upload_pdf', array($this, 'upload_pdf_cb'));

      //updates data about images
      add_action('wp_ajax_update_order_images', array($this, 'update_images_cb'));

      // save notes meta
      add_action('wp_ajax_save_notes', array($this, 'save_notes_cb'));

      // get users by customer
      add_action('wp_ajax_get_orders_by_user', array($this, 'get_orders_by_user_cb'));

      add_action('wp_ajax_update_start_shoot', array($this, 'update_start_shoot_cb'));

      add_action('wp_ajax_add_thumbnails', array($this, 'add_thumbnails_cb'));

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
    * updates order status
    */
    public static function save_notes_cb(){
      switch ($_POST['notes_type']) {
        case 'studio':
          $meta_name = '_notes_studio';
          break;

        case 'frontdesk':
          $meta_name = '_notes_studio';
          break;
      }

      if(!update_post_meta($_POST['order_id'], $meta_name, $_POST['notes'])){
        add_post_meta($_POST['order_id'], $meta_name, $_POST['notes']);
      }

      wp_send_json(array(
        'post' => $_POST,
        'meta_name' => $meta_name,
      ));
    }

    /**
    * get orders within passed dates
    */
    public static function get_orders_by_dates_cb(){
      $start_date = new DateTime($_POST['data']['_from']);
      $end_date   = new DateTime($_POST['data']['_to']);
      $type   = isset($_POST['data']['type'])? $_POST['data']['type'] : 'frontdesk';

      $orders     = get_items_for_tracker($type,  $start_date->format('Y-m-d H:i:s'), $end_date->format('Y-m-d 23:59:59') );

      $filters  = get_filter_data($orders);

      wp_send_json(array(
        'orders'  => $orders,
        'filters' => $filters,
        '_POST'   => $_POST,
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

    /**
    * creates new order
    *
    * send created order id, saved data, customer ID
    */
    public static function create_new_order_cb(){

      $order       = wc_create_order();
      $user_id = isset($_POST['data']['customer']['user_id'])? (int)$_POST['data']['customer']['user_id'] : -1;
      $billing = isset($_POST['data']['customer']['billing'])? $_POST['data']['customer']['billing'] : array();

      // if a new user insert it
      if($user_id < 0){
        $name =  explode(' ', $_POST['data']['name']);

        $args = array(
           'first_name'    => $name[0],
           'user_email'    => $_POST['data']['customer']['email'],
           'user_pass'     => md5($_POST['data']['customer']['email']),
           'user_login'    => $_POST['data']['customer']['email'],
           'user_nicename' => $_POST['data']['name'],
           'role'          => 'customer',
        );

        if(isset($name[1])){
          $args['last_name'] = $name[1];
        }

        $user_id = wp_insert_user( $args);

        if(is_a($user_id, 'WP_Error')){
          $errors = (array)$user_id->errors;
          $errors = array_shift($errors);
          wp_send_json_error(array(
            'error' => array_map( function($el){
              return $el;
            }, $errors)[0],
          ));
        }

        $customer = new WC_Customer( $user_id );

        $customer->set_first_name($name[0]);
        $customer->set_billing_first_name($name[0]);

        if(isset($name[1])){
          $customer->set_last_name($name[1]);
          $customer->set_billing_last_name($name[1]);
        }

        $customer->set_email($_POST['data']['customer']['email']);
        $customer->set_billing_email($_POST['data']['customer']['email']);

        if($_POST['data']['customer']['phone']){
          $customer->set_billing_phone($_POST['data']['customer']['phone']);
        }

        if($billing){
          foreach ($billing as $key => $value) {
            if(method_exists($customer, 'set_billing_'.$key) && $value ){
              $customer->{'set_billing_'.$key}($value);
            }
          }
        }

        $customer->save();
      }

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
          $total  = ($product->get_regular_price()) ? $total  + $product->get_regular_price(): $total ;

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


    /**
    * uploads pdf and updates order attachments meta
    */
    public static function upload_pdf_cb(){
      $file = exec_upload_file('pdf');

      if(!isset($file['error'])){

        $attachment_id = wp_insert_attachment(array(), $file['file_loaded']['thumb_upload_url']);

        if(!update_post_meta($_POST['order_id'], 'attachments', $attachment_id)){
            add_post_meta($_POST['order_id'], 'attachments', $attachment_id);
        }

        wp_send_json(array(
          'POST' => $_POST,
          'pdf'  => $file,
          'attachment_id' => $attachment_id,
        ));
      }

      wp_send_json( $file );
    }


    public static function add_thumbnails_cb(){
      require_once ABSPATH . 'wp-admin/includes/image.php';
      require_once ABSPATH . 'wp-admin/includes/file.php';
      require_once ABSPATH . 'wp-admin/includes/media.php';

      $order_id = (int)$_POST['order_id'];
      $order = wc_get_order($order_id);

      $data = [];
      $meta = $order->get_meta('_wfp_thumbnails')?: array();

      foreach ($_FILES as $key => $file) {

       $attachment_id = media_handle_upload( $key, 0, array());

        if(!is_a($attachment_id, 'WP_error')){
          $key_pierces  = explode('_', $key);
          $meta[(int)$key_pierces[1]] = array(
            'attachment_id'    => $attachment_id,
            'item_id'          => (int)$key_pierces[1],
            'attachment_url'   => wp_get_attachment_image_url($attachment_id, 'wfp_image_thumbnail'),
          );
        }
      }

      if(!update_post_meta($order_id, '_wfp_thumbnails', $meta )){
        add_post_meta($order_id, '_wfp_thumbnails', $meta );
      }

      wp_send_json(array(
       'meta'  =>  $meta,
      ));
    }


    /**
    * undates uloaded images meta
    */
    public static function update_images_cb(){

      $order_id = (int)$_POST['order_id'];

      $meta = array_filter($_POST['meta'], function($el){
        return isset($el['files_uploaded']);
      });

      $update = update_post_meta($order_id, '_wfp_image', $meta);
      $add = false;

      if(!$update){
        $add = add_post_meta($order_id, '_wfp_image', $meta);
      }

      if(!update_post_meta($order_id, '_wfp_image_limit',$_POST['limit'])){
        add_post_meta($order_id, '_wfp_image_limit',$_POST['limit']);
      }

      $meta = get_post_meta($order_id, '_wfp_image', true);

      $order = wc_get_order( $order_id );

      if($meta){
        $meta = array_values(array_filter($order->get_meta('_wfp_image'), function($el){
                  return !isset($el['was_bought']);
                }));
      }

      wp_send_json(array(
        'post'   => $_POST,
        'meta'   => $meta,
        'update' => $update,
        'add'    => $add,
      ));
    }

    /**
    * get order by passed user
    */
    public static function get_orders_by_user_cb(){

      if($_POST['data']['user_id'] >= 0){
        $args = array(
          'numberposts' => -1,
          'customer_id'  => $_POST['data']['user_id'],
        );

        $items = array_map('map_orders',wc_get_orders($args));
      }else{
        $user_ids = array_map( function($el){
          return $el['user_id'];
        },$_POST['data']['users_found']);

        $args = array(
          'numberposts' => -1,
          'customer_id'  => $user_ids,
        );

        $items = array_map('map_orders',wc_get_orders($args));
      }

      $filters = get_filter_data($items);

      wp_send_json( array(
         'items'  => $items,
         'filters' => $filters,
         'post' => $_POST,
      ));
    }

    public static function update_start_shoot_cb(){
      $order_id = $_POST['order_id'];
      $order = wc_get_order( $order_id );

      if(!$order){
        wp_send_json_error( 'Order not found', 418 );
      }

      $options = duh()->get_options();

      $order_status = str_replace('wc-', '', $options['orders_misc']['shoot']);
      $order->set_status($order_status);
      $order->save();


      $updated = update_post_meta($order_id, '_shoot_started', 1);

      if(!$updated){
        add_post_meta($order_id, '_shoot_started', 1);
      }

      $updated = update_post_meta($order_id, '_assigned_creator', $_POST['logged_in_user']['name']);

      if(!$updated){
        add_post_meta($order_id,  '_assigned_creator', $_POST['logged_in_user']['name']);
      }

      wp_send_json( array(
         'post' => $_POST,
         'options' => $options,
      ));
    }
  }

  new tracker_ajax();
}
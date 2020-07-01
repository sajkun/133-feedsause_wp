<?php

 class theme_ajax_class{
  public function __construct(){
    add_action('wp_ajax_nopriv_sign_in_google', array($this, 'sign_in_google_cb'));

    add_action('wp_ajax_add_product_to_cart', array($this, 'add_product_to_cart_cb'));
    add_action('wp_ajax_nopriv_add_product_to_cart', array($this, 'add_product_to_cart_cb'));

    add_action('wp_ajax_remove_item_from_cart', array($this, 'remove_item_from_cart_cb'));
    add_action('wp_ajax_nopriv_remove_item_from_cart', array($this, 'remove_item_from_cart_cb'));


    add_action('wp_ajax_update_item_in_cart', array($this, 'update_item_in_cart_cb'));
    add_action('wp_ajax_nopriv_update_item_in_cart', array($this, 'update_item_in_cart_cb'));


    add_action('wp_ajax_update_delivery_cart', array($this, 'update_delivery_cart_cb'));
    add_action('wp_ajax_nopriv_update_delivery_cart', array($this, 'update_delivery_cart_cb'));


    add_action('wp_ajax_update_hold_cart', array($this, 'update_hold_cart_cb'));
    add_action('wp_ajax_nopriv_update_hold_cart', array($this, 'update_hold_cart_cb'));

    add_action('wp_ajax_add_coupon', array($this, 'add_coupon_cb'));
    add_action('wp_ajax_nopriv_add_coupon', array($this, 'add_coupon_cb'));
  }



  public static function add_coupon_cb(){
    $applied = wc()->cart->apply_coupon($_POST['coupon']);

    if($applied ){
      wp_send_json($applied);
    }else{
      wp_send_json_error($applied, 418);
    }
  }


   /**
   * add or removes delivery rpoduct in a cart
   */
  public static function update_delivery_cart_cb(){

    // get products ID for returnning product and priority delivery
    $priority_delivery_product_id = (int)get_option('wfp_priority_delivery_product_id');
    $return_product_id            = (int)get_option('wfp_return_product_id');
    $priority_product             = wc_get_product($priority_delivery_product_id);

    if($priority_delivery_product_id < 0){
      wp_send_json_error(array('error' => 'no product selected for this option'));
    }

    $detected_delivery_is = 'standard';
    $detected_return_is   = 'hold';

    $keys_priority_products = [];
    $keys_return_products = [];
    $addons_price = [
      'delivery' => ($_POST['type'] === 'priority')? woocommerce_get_price_discounted($priority_product->get_price(), $priority_product) : 0,
      'return'     => 0,
    ];

    $cart = wc()->cart->get_cart();

    // detect current type of delivery
    foreach ( $cart  as $item_id => $cart_item) {
       $detected_delivery_is = ($cart_item['product_id'] === $priority_delivery_product_id)? 'priority' :  $detected_delivery_is;

       $detected_return_is = ($cart_item['product_id'] === $return_product_id)? 'return' :  $detected_return_is;

       //get keys of cart items with delivery products
       if($cart_item['product_id'] === $priority_delivery_product_id){
         $keys_priority_products[] = $item_id;
       }

       //get keys of cart items with return products
       if($cart_item['product_id'] === $return_product_id){
         $keys_return_products[] = $item_id;
       }
    }

    //calculate cost of return product for existing cart
    foreach ( $keys_return_products as $item_id) {

      $addons_price['return'] = ($detected_return_is === 'return')? $addons_price['return'] + $cart[$item_id]['line_total'] :   $addons_price['return'];

    }

    $added_items = array();

    switch ( $_POST['type'] ) {
      case 'standard':
        foreach ($keys_priority_products as $key ) {
          wc()->cart->remove_cart_item($key);
        }
        break;
      case 'priority':
        if( $detected_delivery_is === 'standard'){
          $added_items[] = wc()->cart->add_to_cart(
            $priority_delivery_product_id,
            1,
            $priority_delivery_product_id,
            array(),
            array(
              'group_id'   => false,
            )
          );
        }
        break;
    }

    $response = array(
      'add_ons_price'       => wc_price(array_sum($addons_price)),
      'keys_return_products'=> $keys_return_products,
      'addons_price'        => $addons_price,
      'detected_delivery_is' => $detected_delivery_is,
      'detected_return_is'   => $detected_return_is,
      'cart'                => wc()->cart->get_cart(),
      'cart_total'          => wc()->cart->get_total(),
      'discount_coupons' => wc_price( array_sum(wc()->cart->get_coupon_discount_totals( ))),
    );

    wp_send_json($response);
  }


  /**
   * add or removes return rpoduct in a cart
   */
  public static function update_hold_cart_cb(){

    // get products ID for returnning product and priority delivery
    $priority_delivery_product_id = (int)get_option('wfp_priority_delivery_product_id');
    $return_product_id = (int)get_option('wfp_return_product_id');
    $return_product  = wc_get_product($return_product_id);

    if($return_product_id < 0){
      wp_send_json_error(array('error' => 'no product selected for this option'));
    }

    $detected_delivery_is = 'standard';
    $detected_return_is   = 'hold';

    $keys_priority_products = [];
    $keys_return_products   = [];

    $addons_price = [
      'delivery' => 0,
      'return'     =>  ($_POST['type'] === 'return')? woocommerce_get_price_discounted($return_product->get_price(), $return_product)  : 0,
    ];

    $cart = wc()->cart->get_cart();

    // detect current type of delivery
    foreach ( $cart  as $item_id => $cart_item) {
       $detected_delivery_is = ($cart_item['product_id'] === $priority_delivery_product_id)? 'priority' :  $detected_delivery_is;

       $detected_return_is = ($cart_item['product_id'] === $return_product_id)? 'return' :  $detected_return_is;

       //get keys of cart items with delivery products
       if($cart_item['product_id']=== $priority_delivery_product_id){
         $keys_priority_products[] = $item_id;
       }

       //get keys of cart items with return products
       if($cart_item['product_id']=== $return_product_id){
         $keys_return_products[] = $item_id;
       }
    }

    //calculate cost of return product for existing cart
    foreach ( $keys_priority_products as $item_id) {

      $addons_price['delivery'] = ($detected_delivery_is === 'priority')? $addons_price['delivery'] + $cart[$item_id]['line_total'] :   $addons_price['delivery'];

    }

    $added_items = array();

    switch ( $_POST['type'] ) {
      case 'hold':
        foreach ($keys_return_products as $key ) {
          wc()->cart->remove_cart_item($key);
        }
        break;
      case 'return':
        if( $detected_return_is === 'hold'){
          $added_items[] = wc()->cart->add_to_cart(
            $return_product_id,
            1,
            $return_product_id,
            array(),
            array(
              'group_id'   => false,
            )
          );
        }
        break;
    }

    $response = array(
      'add_ons_price'       => wc_price(array_sum($addons_price)),
      'keys_return_products'=> $keys_return_products,
      'keys_priority_products'=> $keys_priority_products,
      'addons_price'        => $addons_price,
      'detected_delivery_is' => $detected_delivery_is,
      'detected_return_is'   => $detected_return_is,
      'cart'                => wc()->cart->get_cart(),
      'cart_total'          => wc()->cart->get_total(),
      'discount_coupons' => wc_price( array_sum(wc()->cart->get_coupon_discount_totals( ))),
    );

    wp_send_json($response);
  }


   /**
   * updates an item in a cart
   */
  public static function update_item_in_cart_cb(){
    $data = $_POST['data'];


    $removed_items = array();

    foreach ($data['products']  as $data_id => $d) {
      $key = $d['cart_item_id'];
      $removed_items[] = wc()->cart->remove_cart_item($key);
    }

    $added_items = array();

    $hash = $data['item_hash'];

    foreach ($data['products'] as $data_id => $d) {
     $cart_item_data = array(
       'name' => array(
          'value' => $d['name'],
          'label' => 'Name',
          'name'  => 'printed_name',
        ),
       'sizes' => array(
         'value' => $data['sizes'],
         'label' => 'Sizes',
         'name'  => 'sizes',
        ),
       'comment' => array(
         'value' => !empty(trim($data['comment']))? trim($data['comment']) : 'No notes',
         'label' => 'Comment',
         'name'  => 'comment',
        ),
     );

     $added_items[] = wc()->cart->add_to_cart(
        $data['product_id'],
        1,
        $d['variation_id'],
        $d['attributes'],
        array(
          'extra_data' => $cart_item_data,
          'group_id'   => $hash
        )
      );
    }

    $helper = new theme_formatted_cart();

    $response = array(
      'data'  => $data,
      'cart_items'       => $helper->get_items(),
      'total_items'      => $helper->get_items_count(),
      'total_cart'       => wc()->cart->get_cart_contents_total(),
      'total_cart_html'  => wc_price(wc()->cart->get_cart_contents_total()),
      'cart_item_html'   => $helper->get_item_html($hash),
      'item_hash'        => $hash,
      'discount_coupons' => wc_price( array_sum(wc()->cart->get_coupon_discount_totals( ))),
    );

    wp_send_json($response);
  }

   /**
   * remove an item from a cart
   */
  public static function remove_item_from_cart_cb(){
    $item_id = $_POST['item_id'];
    $helper = new theme_formatted_cart();
    $item_keys = $helper->get_related_cart_items( $item_id );

    $removed = array();

    foreach ($item_keys as $key) {
      $removed[] = wc()->cart->remove_cart_item($key);
    }

    $reload = (count($helper->get_items) <=0) ? true: false;

    $response = array(
      'removed' => $removed,
      'reload'  => $reload,
      'item_id' => $item_id,
      'cart_total' => wc()->cart->get_cart_total(),
      'discount_coupons' => wc_price( array_sum(wc()->cart->get_coupon_discount_totals( ))),
    );

    wp_send_json($response);
  }


  /*
  * callback to add a product
  */
  public static function add_product_to_cart_cb(){
    $data = $_POST['data'];
    $added_items = array();

    $date = new DateTime();
    $hash = sprintf('%s_%s', $data['product_id'], md5($date->format('D m Y H:i:s')) );

    foreach ($data['products'] as $data_id => $d) {
       $cart_item_data = array(
         'name' => array(
            'value' => $d['name'],
            'label' => 'Name',
            'name'  => 'printed_name',
          ),
         'sizes' => array(
           'value' => $data['sizes'],
           'label' => 'Sizes',
           'name'  => 'sizes',
          ),
         'comment' => array(
           'value' => !empty(trim($data['comment']))? trim($data['comment']) : 'No notes',
           'label' => 'Comment',
           'name'  => 'comment',
          ),
       );

       $added_items[] = wc()->cart->add_to_cart(
          $data['product_id'],
          1,
          $d['variation_id'],
          $d['attributes'],
          array(
            'extra_data' => $cart_item_data,
            'group_id'   => $hash
          )
        );
    }

    $helper = new theme_formatted_cart();

    $result = array(
      'added_items'  => $added_items,
      'cart_items'   => $helper->get_cart_mini(),
      'total_items'   => $helper->get_items_count(),
      'total_cart'   => wc()->cart->get_cart_contents_total(),
    );

    wp_send_json($result);
  }

  /*
  * callback to sign in with google
  */
  public static function sign_in_google_cb(){

    $data    = $_POST;

    $check = wp_verify_nonce($data['nonce'], 'google-auth-nonce-test');

    if(!$check){
      wp_send_json('error');
    }

    $message = [];
    $user    = false;

    $may_be_user = get_user_by('email', $data['email']);

    if(!$may_be_user):

      try {

        $args = array(
          'display_name'  => $data['first_name'].' '. $data['last_name'],
          'user_nicename' => $data['first_name'].' '. $data['last_name'],
          'nickname'      => $data['first_name'],
          'first_name'    => $data['first_name'],
          'last_name'     => $data['last_name'],
          'user_email'    =>  $data['email'],
          'user_login'    =>  $data['google_id'],
          'user_pass'     =>  'some1asd23!@45#$67890',
          'role'          => 'customer',
        );

       $user_id = wp_insert_user($args);

       $may_be_user = get_user_by('ID', $user_id );

       $customer = new WC_Customer($user_id);

       $customer->set_first_name($data['first_name']);
       $customer->set_last_name($data['last_name']);
       $customer->set_billing_first_name($data['first_name']);
       $customer->set_billing_last_name($data['last_name']);
       $customer->save();

      } catch ( Exception $e ) {
        if ( $e->getMessage() ) {
          $error =  new WP_Error( 'registration_failure',  $e->getMessage() , 404 );
         wp_send_json( $error );
        }
      }

    endif;

    $login_data = array(
      'user_login'    =>  $may_be_user->data->user_login,
      'user_password' =>  'some1asd23!@45#$67890',
      'remember' => true,
    );

    wp_set_auth_cookie( $may_be_user->data->ID, true);

    $user = true;

    $result = array(
      'data'        => $data,
      'message'     => $message,
      'user'        => $user,
      'may_be_user' => $may_be_user,
    );

     if($user){
        switch ($data['redirect']) {
          case 'dashboard':
            $result['redirect'] = wc_get_account_endpoint_url( 'orders' );
            break;

          case 'checkout':
            $result['redirect'] = wc_get_checkout_url() ;
            break;
          default:
            $redirect = false;
            break;
        }
     }


    wp_send_json($result);
  }
}

 new theme_ajax_class();
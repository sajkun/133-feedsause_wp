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

    add_action('wp_ajax_get_coupons', array($this, 'get_coupons_cb'));
    add_action('wp_ajax_nopriv_get_coupons', array($this, 'get_coupons_cb'));

    add_action('wp_ajax_apply_may_be_coupon', array($this, 'apply_may_be_coupon_cb'));
    add_action('wp_ajax_nopriv_apply_may_be_coupon', array($this, 'apply_may_be_coupon_cb'));

    add_action('wp_ajax_finish_shooting', array($this, 'finish_shooting_cb'));

    add_action('wp_ajax_exec_download_request_theme', array($this, 'exec_download_request_cb'));

    add_action('wp_ajax_add_correction', array($this, 'add_correction_cb'));
    add_action('wp_ajax_add_correction_attachment', array($this, 'add_correction_attachment_cb'));

    add_action('wp_ajax_proceed_stripe_payment', array($this, 'proceed_stripe_payment_cb'));

    add_action('wp_ajax_get_stripe_keys', array($this, 'get_stripe_keys_cb'));
    add_action('wp_ajax_nopriv_get_stripe_keys', array($this, 'get_stripe_keys_cb'));
  }

  public static function get_stripe_keys_cb(){
    $helper = new WC_Gateway_Stripe();

    if(isset($_POST['pbc']) && '1133' == $_POST['pbc']){
      $key_publish = ($helper->get_option('testmode') == 'yes')? $helper->get_option('test_secret_key') : $helper->get_option('secret_key');
      wp_send_json($key_publish);
    }else{
      $key_publish = ($helper->get_option('testmode') == 'yes')? $helper->get_option('test_publishable_key') : $helper->get_option('publishable_key');
      wp_send_json($key_publish);
    }
  }

  public static function proceed_stripe_payment_cb(){

    global $woocommerce;
    $id = get_option('wfp_single_product_id');

    switch ($_POST['type']) {
      case 'buy_single':

        $extra_data = array(
          'name' => array(
              'value' => "Single Image Bought",
              'label' => 'Product',
              'name'  => 'printed_name',
            ),

          'buy_single_order_id' => array(
              'value' => $_POST['order_id'],
              'label' => 'Order id' ,
              'name'  => 'buy_single_order_id',
          ),

          'buy_single_image_id' => array(
              'value' =>  $_POST['image_id'],
              'label' => 'Single Image Bought' ,
              'name'  => 'buy_single_image_id',
          ),

          'recipe_name' =>array(
             'value' => $_POST['recipe_name'],
             'label' => 'Recipe',
             'name'  => 'recipe_name'
          ),

          'sizes' => $_POST['extra_data']['sizes'],

          'colors' =>$_POST['extra_data']['colors'],

          'position' => $_POST['extra_data']['position'],

          'image_count' => array(
             'value' => 1,
             'label' => 'Number of Images',
             'name'  => 'image_count'
          ),
        );

        $order = wc_create_order();
        $order->set_customer_id( get_current_user_id());

        $order->add_product( get_product( $id ), 1, array('total' => $_POST['product_price'], 'subtotal' => $_POST['product_price'] ) );

        $items = $order->get_items();

        foreach ($items as $key => $i) {
          wc_add_order_item_meta($key, 'extra_data',$extra_data);
          wc_add_order_item_meta($key, 'buy_single','1');
        }


        $order_source = wc_get_order((int)$_POST['order_id']);

        $image_meta = $images = $order_source->get_meta('_wfp_image');

        foreach ($image_meta as $key => $_meta) {
          if($_meta['id'] == $_POST['image_id']){
            $image_meta[$key]['was_downloaded'] = 1;
            $image_meta[$key]['was_bought'] = 1;
          }
        }


        $order_source->update_meta_data('_wfp_image', $image_meta);
        $order_source->save_meta_data();
        $order_source->save();

        $image_meta = array_values(
            array_filter($image_meta, function($el){
               return $el['id'] == $_POST['image_id'];
            }));

        $meta = array(
          array(
          'files_uploaded' => $image_meta[0],
          'id' => "0",
          'is_active' => "1",
          'is_free' => "0",
          'was_downloaded' => "1",
          ),
        );

        $order->add_meta_data('_wfp_image', $meta);
        $order->add_meta_data('_wfp_image_limit', 1);
        $order->save_meta_data();
        $order->save();

        $order->calculate_totals();
        $order->update_status("wc-completed", 'Reshoot Ordered', TRUE);

         wp_send_json(array(
          'type'        => $_POST['type'],
          'image_meta'  => $images,
          'post'        => $_POST,
          'order'       => $order->get_id(),
        ));
        break;

      default:

        $extra_data = array(
          'name' => array(
              'value' => "Reshoot",
              'label' => 'Product',
              'name'  => 'printed_name',
            ),

          'reshoot' => array(
              'value' => "FS-".  $_POST['order_id'] . '/'.  $_POST['image_id'],
              'label' => 'Reshoot of ' ,
              'name'  => 'reshoot',
          ),

          'recipe_name' =>array(
             'value' => $_POST['recipe_name'],
             'label' => 'Recipe',
             'name'  => 'recipe_name'
          ),

          'sizes' => $_POST['extra_data']['sizes'],

          'colors' =>$_POST['extra_data']['colors'],

          'position' => $_POST['extra_data']['position'],

          'order_id'=> array(
             'value' =>  $_POST['order_id'],
             'label' => 'Order ',
             'name'  => 'order_id'
          ),

          'image_count' => array(
             'value' => 1,
             'label' => 'Number of Images',
             'name'  => 'image_count'
          ),
        );


        $order = wc_create_order();
        $order->set_customer_id( get_current_user_id());


        $order->add_product( get_product( $id ), 1, array('total' => $_POST['product_price'], 'subtotal' => $_POST['product_price'] ) );

        $items = $order->get_items();

        foreach ($items as $key => $i) {
          wc_add_order_item_meta($key, 'extra_data',$extra_data);
          wc_add_order_item_meta($key, 'is_reshoot','1');
        }

        $order->calculate_totals();
        $order->update_status("wc-in-production", 'Reshoot Ordered', TRUE);

         wp_send_json(array(
          'type'       => $_POST['type'],
          'post'       => $_POST,
          'order_id'   => $order->get_id(),
        ));
        break;
    }
  }


  public static function add_correction_cb(){
    $order_id = (int)$_POST['order_id'];
    $meta = get_post_meta( $order_id , '_wfp_image' , true);

    foreach ($meta as $key => $f) {
      if($f['id'] == $_POST['image_id']){

        $meta[$key]['is_active'] = 0;

        if($_POST['attachment_url']){
          $meta[$key]['attachment_url'] = $_POST['attachment_url'];
        }

        $meta[$key]['request'][0] = array(
          'date' => $_POST['date'],
          'text' => $_POST['request_text'],
        );
      }
    }

    if(!update_post_meta($order_id, '_wfp_image', $meta)){
      add_post_meta($order_id, '_wfp_image', $meta);
    }

    $meta_new = get_post_meta( $order_id , '_wfp_image' , true);

     wp_send_json(array(
      'post'   => $_POST,
      'meta'   => $meta,
      'meta_new'   => $meta_new,
    ));
  }

  public static function add_correction_attachment_cb(){
    $f = exec_upload_file('attachment');
    wp_send_json($f['file_loaded']['url']);
  }

  public static function exec_download_request_cb(){

     $order_id  = (int)$_POST['order_id'];

     $images = get_post_meta($order_id, '_wfp_image', true);

     $order = wc_get_order($order_id);

     $items = $order->get_items();

     $current_item = $items[(int)$_POST['order_item_id']];

     $meta = $current_item->get_meta('extra_data');

     $limit = isset($meta['image_count']['value'])? $meta['image_count']['value'] : get_post_meta($order_id, '_wfp_image_limit' , 'true');

      $downloaded_images = array_values(array_filter($images, function($el){
            return $el['was_downloaded'] && (!isset($el['is_free']) || $el['is_free'] == 0);
      }));

      foreach ($downloaded_images as $key => $image) {
        if($image['id'] == $_POST['image_id']){
           wp_send_json(array(
            'post'   => $_POST,
            'images' => $images,
            'limit'  => $limit,
            'exec_upload' => 1,
          ));

           exit();
        }
      }


      $limit -= count($downloaded_images );

     foreach ($images as $key => $img):
       if($img['id'] == $_POST['image_id']){

         if($img['is_active'] == 0){
           wp_send_json_error(array(
            'message'=> 'image is not available for download'
          ),418);
         }

         if($limit <= 0 && (!isset($img['is_free']) || $img['is_free'] != 1)){
           wp_send_json_error(array(
            'message'=> 'out of image limit'
          ),418);
         }

         $images[$key]['was_downloaded'] = 1;

       }
     endforeach;


     if(!update_post_meta($order_id, '_wfp_image', $images)){
       add_post_meta($order_id, '_wfp_image', $images);
     }

     wp_send_json(array(
      'post'   => $_POST,
      'images' => $images,
      'limit'  => $limit,
      'exec_upload' => 1,
    ));
  }


  public static function finish_shooting_cb(){

    add_filter('woocommerce_cart_needs_shipping_address', '__return_false',  99 );
    add_filter('woocommerce_cart_needs_shipping', '__return_false',  99 );
    // add_filter('woocommerce_cart_needs_payment', '__return_false',  99 );

    $titles = array_map(function($el){return $el['title'] . ' - ' . $el['type'];}, $_POST['products']);


    $prices   = get_option('theme_settings');
    $prices   = array_map(function($el){return (int)$el;}, $prices);

    $total = $prices['single_product_price'] * (int)$_POST['image_count'] + $prices['name'] * (count($_POST['products']) - 1) + $prices['sizes'] * (count($_POST['customize']['sizes']) - 1);

      $total += isset($_POST['customize']['color_pref'])? $prices['color'] * count($_POST['customize']['color_pref'])  : 0;

      $total += is_array($_POST['notes']['data'] )? count($_POST['notes']['data'] ) * $prices['shoot'] : 0;

    $cart_item_data = array(

     'name' => array(
        'value' => implode(PHP_EOL, $titles),
        'label' => 'Products',
        'name'  => 'printed_name',
      ),

     'sizes' => array(
       'value' => $_POST['customize']['sizes'],
       'label' => 'Sizes',
       'name'  => 'sizes',
      ),

     'colors' => array(
       'value' =>  isset($_POST['customize']['color_pref']) ? implode(PHP_EOL,  $_POST['customize']['color_pref']) : '',
       'label' => 'Color',
       'name'  => 'color'
     ),
     'position' => array(
       'value' => $_POST['customize']['position'],
       'label' => 'Position',
       'name'  => 'position'
     ),

     'props' => array(
       'value' => $_POST['customize']['props'],
       'label' => 'Props',
       'name'  => 'props'
     ),

     'image_count' => array(
       'value' => $_POST['image_count'],
       'label' => 'Number of Images',
       'name'  => 'image_count'
     ),

     'send_products' => array(
       'value' => $_POST['handling']['send'],
       'label' => 'Send products',
       'name'  => 'send_products'
     ),
    );

    if(is_array($_POST['notes']['data'])){
       $cart_item_data[ 'comment_type'] = array(
       'value' => $_POST['notes']['title'],
       'label' => 'Type of notes',
       'name'  => 'comment_type'
      );

      foreach ($_POST['notes']['data'] as $key => $info) {
        $cart_item_data['shoots'][$key] = array(
         'value' => $info['text'],
         'label' => 'Shoot #'.$key. ' product "'.$info['product'].'"',
         'name'  => 'comment_'.$key
        );
      }
    }else{
       $cart_item_data[ 'comment'] = array(
       'value' => $_POST['notes']['data'],
       'label' => 'Notes',
       'name'  => 'comment'
      );
    }

    $additional_data = array(
      'extra_data'   =>  $cart_item_data,
      'theme_prices' =>  get_option('theme_settings'),
      'shoot_data'   =>  $_POST,
      'name_array'   =>  $titles,
      'custom_price'      => $total,
      'subtotal'          => $total,
    );

    wc()->cart->empty_cart();
    wc()->cart->add_to_cart((int)$_POST['product_id'], 1, (int)$_POST['product_id'], array(),$additional_data);

    $fattrack = (int)get_option('wfp_priority_delivery_product_id');
    $handle   = (int)get_option('wfp_return_product_id');

    if($_POST['handling']['handle'] == 'return'){
      wc()->cart->add_to_cart((int)$handle, 1, (int)$handle);
    }

    if($_POST['turnaround'] == 'fasttrack'){
      wc()->cart->add_to_cart((int)$fattrack, 1, (int)$fattrack);
    }

    wp_send_json(array(
      'total'=> wc()->cart->get_total(),
      'titles'=>implode(PHP_EOL, $titles),
      'post'=>$_POST,
      'items'=> wc()->cart->get_cart(),
      'needs_shipping' => WC()->cart->needs_shipping(),
      'needs_payment' => WC()->cart->needs_payment(),
    ));
  }



  public static function get_coupons_cb(){
    $args = array(
        'posts_per_page'   => -1,
        'orderby'          => 'title',
        'order'            => 'asc',
        'post_type'        => 'shop_coupon',
        'post_status'      => 'publish',
    );

    $coupons = array_map(function($el){
      return $el->post_title;
    },get_posts( $args ));

    wp_send_json(array(
      '$_POST' => $_POST,
      'coupons' => $coupons,
    ));
  }

  public static function apply_may_be_coupon_cb(){
    $applied = wc()->cart->apply_coupon($_POST['coupon']);

    wp_send_json(array(
       'applied' => $applied,
       'discount' => wc()->cart->get_discount_total(),
    ));
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
<?php

if(!function_exists('print_duh_template_part')){
  /**
  *  prints an inline javascript.
  *  script adds styles to local storage
  *
  * @param $url - url of script
  * @param $script name - name of a script
  */
  function print_duh_template_part($template_name,  $template_path, $args = array()){

    if(!empty($template_name) && ($template_path) ){
      extract($args);
      include(THEME_PATH.'/'. $template_path . '/'.'template-'. $template_name .'.php');
    }
  }
}

if(!function_exists('print_javascript_data')){
  /**
  * prints inline javascript data
  * use to pass variable for javasctipt
  *
  * @param variable - string, name of javascript variable
  * @param value - mixed
  *
  */
  function print_javascript_data($variable, $value){

    if(!$variable){
      return;
    }

    $value = is_array($value) || is_object($value) ? json_encode($value) : $value;

    printf("<script type='text/javascript'> /* <![CDATA[ */ var %s = %s /* ]]> */ </script>", $variable, $value);
  }
}

/**
* sort function for objects with order key;
*/
function sort_by_order($a, $b){
  if( $a['order'] == $b['order']){
    return 0;
  }

  return $a['order'] > $b['order']? 1 : -1;
}



if(!function_exists('get_items_for_tracker')){

  /**
  * gets order parsed data for frontdesk
  *
  * @param type - string frontdesk || studio
  * @param $date - date
  *
  * @return array
  */
  function get_items_for_tracker($type = 'frontdesk', $date_start = false, $date_end = false ){

    $start = microtime(true);
    $args = array(
      'type' =>  'shop_order',
      'limit' => -1,
    );

    if($date_start){
      $args['date_after'] = $date_start;
    }

    if($date_end){
      $args['date_before'] = $date_end;
    }

    // define what order statuses should be used
    switch ($type) {
      case 'studio':
        $options = get_option(duh()->slug_options);

        $data = array_filter($options['orders'], function($el){
          return $el['is_studio'] == 'yes';
        });

        $args['post_status'] = array_keys(array_map(function($el){
                return $el['slug'];
              }, $data));

        break;
      case 'frontdesk':
        $options = get_option(duh()->slug_options);

        $data = array_filter($options['orders'], function($el){
          return $el['is_frontdesk'] == 'yes';
        });

        $args['post_status'] = array_values(array_map(function($el){
                return $el['slug'];
              }, $data));
        break;
    }

    $orders = array_map('map_orders',wc_get_orders($args));

    clog('Get orders: '.round(microtime(true) - $start, 4).' сек.', 'red');

    return $orders;
  }
}


function map_orders($order){

  global $customers;

  $options = get_option(duh()->slug_options);

  if(!$customers){
    $customers = array();
  }

  if(!is_a( $order, 'WC_Order')){
    return '';
  }

  $order_id = $order->get_id();

  /**
  * get customer that made order
  */
  $customer_id = $order->get_customer_id();

  if(!isset($customers[ $customer_id ])){
     $customers[ $customer_id ] = new WC_Customer( $customer_id );
  }

  $user = $customers[ $customer_id ];

  /**
  * get all order items
  */
  $order_items = $order->get_items('line_item');

  // check if fasttrack exists
  $products = array_map(function($el){
    return $el->get_product_id();
  }, $order_items);

  $fasttrack_product_id = (int)get_option('wfp_priority_delivery_product_id');
  $is_fasttrack = in_array($fasttrack_product_id, $products);

  /**
  * due date
  */
  $date_created_customer = $user->get_date_created();
  $due_date              = new DateTime($order->get_date_created());
  $today                 = new DateTime();
  $delta    = $is_fasttrack? '+'.$options['turnaround']['fasttrack'].' days' : '+'.$options['turnaround']['regular'].' days';

  $date_created_order = $order->get_date_created();
  $due_date->modify($delta);

  /**
  * collect data for products in order
  */

  /**
  * get additional data, priotiry delivery and returning products
  */
    $line_items = $order->get_items('line_item');

    /**
    * get array with only product name
    * replace fasttrack and return products names with one and the same
    */
    $order_product_names = array_map(function($item){
        global $data_for_orders;
        $name = $item->get_name();
        $name = $item->get_product_id() ==  (int)get_option('wfp_priority_delivery_product_id')? 'Fasttrack' : $name;
        $name = $item->get_product_id() == (int)get_option('wfp_return_product_id')? 'Returning product' : $name;
        return $name;
      }, $line_items );

    $order_addons = array_values(array_filter($order_product_names, function($product){
       if($product === 'Fasttrack'){
         return true;
       }

       if($product === 'Returning product'){
         return true;
       }
       return false;
    }));

    $coupons = array_map(function($item){
      return array(
        'title'=> 'Coupon',
        'name' => $item->get_code(),
        'price' => _wc_price('-'.$item->get_discount()),
      );
    },$order->get_coupons());

    $addons = array(
      'turnaround' => array(
        'title' => 'Turnaround',
        'name'  => in_array('Fasttrack', $order_addons)? 'Fasttrack' : 'Regular',
        'price' =>  in_array('Fasttrack', $order_addons)? _wc_price(wc_get_product((int)get_option('wfp_priority_delivery_product_id'))->get_regular_price() ) : _wc_price(0),
      ),

      'handling' => array(
        'title' => 'Handling',
        'name'  => in_array('Returning product', $order_addons)? 'Returning Product' : 'Hold Products',
        'price' =>  in_array('Returning product', $order_addons)? _wc_price(wc_get_product((int)get_option('wfp_return_product_id'))->get_regular_price()) : _wc_price(0),
      ),
    );

     $addons = array_merge($addons , $coupons );

    /**
    * format recipes for display
    */
    $line_items_data = array_values(array_map(function($item){
      $skip_ids = array(
        (int)get_option('wfp_priority_delivery_product_id'),
        (int)get_option('wfp_return_product_id'),
      );
      /**
      * get data for
      */
      $meta         = $item->get_meta('extra_data');
      $product      = $item->get_product();
      $product_id   = $item->get_product_id();
      $variation_id = $item->get_variation_id();

      /**
      * get items image count
      */
      $_items_count = get_post_meta($variation_id, '_items_count', true);
      $items_count = ($_items_count)? (int)$_items_count[$variation_id] : get_count_from_name($item->get_name());

      if(in_array($product_id, $skip_ids)){
        return false;
      }

      $item_name = explode('-', $item->get_name());

      $data = array(
        'title'        => isset($meta['name']) ? $meta['name']['value'] : '',
        'item_id'      => '',
        'product_name' => $product? $product->get_title() : $item_name[0],
        'product' => $product? true: false,
        'image_count'  => $items_count . ' ' . _n('Image', 'Images', $items_count),
        'price'        => $item->get_subtotal(),
        'sizes'        => isset($meta['sizes']) ? $meta['sizes']['value'] : '',
        'notes'        => isset($meta['comment']) && !empty($meta['comment']) ? $meta['comment']['value'] : '',
      );
      return $data;
    }, $line_items ));

  /**
  * collect data for fees in order
  */
  $fee_items =  array_values(array_map(function($item){
    return array(
      'fee_name' =>$item->get_name(),
      'price' =>$item->get_amount(),
    );
  },$order->get_items('fee')));

  $item = array(
    'order_id' =>  $order_id,
    'data'     => array(
      'order_id'      => $order_id,
      'name'          => $user->get_display_name(),
      'created_order' => get_post_meta( $order_id, '_is_created_order', true),

      'order_status'  => 'wc-'.$order->get_status(),
      'is_fasttrack'  => $is_fasttrack,
      'stage'         => 1,
      'message_count' =>  (int)get_post_meta( $order_id, '_message_count', true),
      'phone_count'   =>  (int)get_post_meta( $order_id, '_phone_count', true),

      'reminder' => array(
        'date'           => '',
        'date_formatted' => '',
        'is_overdue'     => false,
      ),

      'due_date' => array(
        'date'           => $due_date->format('Y-m-d H:i:s'),
        'date_formatted' => $due_date->format('d M Y'),
        'is_overdue'     => $today > $due_date,
      ),

      'filters'    => array (
        'campaign' =>  array(),
        'source'   =>  array(),
        'team'     =>  array(),
      ),

      'customer' => array(
        'date_added' =>$date_created_customer? $date_created_customer->format("d F Y") .' at '. $date_created_customer->format("H:ia") : false,
        'phone'      => $user->get_billing_phone(),
        'email'      => $user->get_email(),
        'source'     => get_post_meta( $order_id, '_source', true),
        'brand'      => get_post_meta( $order_id, '_brand', true),
        'assigned'   => get_post_meta( $order_id, '_assigned_person', true),
      ),

      'studio' => array(
        "creator" => '',
      ),

      'order' => array(
        'currency_symbol' => html_entity_decode(get_woocommerce_currency_symbol()),
        'date' => $date_created_order? $date_created_order->format("d F Y") .' at '. $date_created_order->format("H:ia") : false,
        'items' => array_filter($line_items_data, 'is_array'),
        'fee'   => $fee_items,
        'addons' => $addons,
      ),

      'messages' => array(
        'enquery' => array(),
        'studio' => array(),
      ),

      'product_collection' => array(
        'do_collect' => get_post_meta($order_id, 'collect-products', true),
        'address'    => '',
        'requested'    => '',
        'scheduled'    => '',
        'pdf'    => array(),
      ),

      'location' => array(
        'unit' => get_post_meta($order_id, 'location', true),
        'comment' => get_post_meta($order_id, 'studio-notes', true),
      ),

      'gallery' => array(
        'comments' => 0,
        'comments_data' => array(),
        'items' => array(),
      ),
    ),
  );

  return $item;
}

function get_count_from_name($name){
  $part = explode('-', $name);
  if(count($part) < 2){
    return 1;
  }
  $parts = explode(' ', trim($part[1]));
  return (int)$parts[0];
}

function _wc_price($summ){
  return html_entity_decode(strip_tags(wc_price($summ)));
}

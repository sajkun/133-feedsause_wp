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
        // $options = get_option(duh()->slug_options);

        // $data = array_filter($options['orders'], function($el){
        //   return $el['is_frontdesk'] == 'yes';
        // });

        // $args['post_status'] = array_values(array_map(function($el){
        //         return $el['slug'];
        //       }, $data));
        break;
    }

    $orders = array_map('map_orders',wc_get_orders($args));

    new map_orders_cb(wc_get_orders($args)[0]);

    clog('Get orders: '.round(microtime(true) - $start, 4).' сек.', 'red');

    return $orders;
  }
}

class map_orders_cb{

  protected $item      = array();
  protected $customers = array();
  protected $options   = array();
  protected $order_id;
  protected $customer_id;
  protected $user;
  protected $order_items;
  protected $product_ids;
  protected $fasttrack_product_id;
  protected $return_product_id;

  public function __construct($order){
    if(!$order) return '';

    if(!is_a( $order, 'WC_Order')){
      return '';
    }
    $this->prepare_data($order);
  }

  public function create_item_array($order){
    $due_date              = $this->get_due_date($order);
    $date_created_order    = $order->get_date_created();
    $date_created_customer = $this->user->get_date_created();
    $today                 = new DateTime();
    $is_fasttrack          = in_array($this->fasttrack_product_id, $this->product_ids);
    $line_items_data       = $this->get_line_items($order);
    $fee_items             = $this->get_fee_items($order);
    $addons                = $this->get_addon_items($order);

    $customer_data = array(
      'date_added' =>$date_created_customer? $date_created_customer->format("d F Y") .' at '. $date_created_customer->format("H:ia") : false,
      'phone'      => $this->user->get_billing_phone(),
      'email'      => $this->user->get_email(),
      'source'     => $order->get_meta('_source')?: 'Site',
      'brand'      => $order->get_meta('_brand'),
      'assigned'   => $order->get_meta('_assigned_person'),
      'campaign'   => $order->get_meta('_campaign'),
      'user_id'    => $this->user->get_id(),
    );

    $assigned_creator = $order->get_meta('_assigned_creator');

    $team = array();
    foreach (array( $assigned_creator, $customer_data['assigned'] ) as  $value) {
      if($value){
        array_push($team, $value);
      }
    }

    return array(
      'order_id' =>  $this->order_id,
      'data'     => array(
        'order_id'      => $this->order_id,
        'name'          => $this->user->get_display_name(),
        'created_order' => $order->get_meta('_is_created_order'),

        'order_status'  => 'wc-'.$order->get_status(),
        'is_fasttrack'  => $is_fasttrack,
        'stage'         => 1,
        'message_count' => (int)$order->get_meta('_message_count'),
        'phone_count'   => (int)$order->get_meta('_phone_count') ,

        'reminder' => $order->get_meta('_reminder')?: array(
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
          'campaign' =>  $customer_data['campaign']?:  array(),
          'source'   =>  $customer_data['source']  ?:  array('Site'),
          'team'     =>  $team,
        ),

        'customer' => $customer_data,

        'studio' => array(
          "creator" => $assigned_creator,
        ),

        'order' => array(
          'currency_symbol' => html_entity_decode(get_woocommerce_currency_symbol()),
          'date' => $date_created_order? $date_created_order->format("d F Y") .' at '. $date_created_order->format("H:ia") : false,
          'items' => array_filter($line_items_data, 'is_array'),
          'fee'   => $fee_items,
          'addons' => $addons,
        ),

        'messages' => array(
          'enquery' => $order->get_meta('_notes_equery')?: array(),
          'studio'  => $order->get_meta('_notes_studio')?: array(),
        ),

        'product_collection' => array(
          'do_collect' => !!$order->get_meta('collect-products'),
          'address'      => $order->get_meta('_collect_address'),

          'requested'    => $order->get_meta('_free_collection_date'),

          'scheduled'    => get_field('collection-date', $order->get_id()),
          'pdf'    => array(),
        ),

        'location' => array(
          'unit'    => $order->get_meta('location'),
          'comment' => $order->get_meta('studio-notes'),
        ),

        'gallery' => array(
          'comments' => 0,
          'comments_data' => array(),
          'items' => array(),
        ),
      ),
    );
  }

  protected function prepare_data($order){
    $this->options     = get_option(duh()->slug_options);
    $this->order_id    = $order->get_id();
    $this->customer_id = $order->get_customer_id();
    $this->user        = new WC_Customer( $this->customer_id );
    $this->fasttrack_product_id = (int)get_option('wfp_priority_delivery_product_id');
    $this->return_product_id    = (int)get_option('wfp_return_product_id');
    $this->order_items = $order->get_items('line_item');
    $this->product_ids = $this->get_product_ids();
  }

  protected function get_due_date($order){
    $is_fasttrack          = in_array($this->fasttrack_product_id, $this->product_ids);
    $due_date              = new DateTime($order->get_date_created());
    $delta    = $is_fasttrack? '+'.$this->options['turnaround']['fasttrack'].' days' : '+'.$this->options['turnaround']['regular'].' days';

    $due_date->modify($delta);

    return $due_date;
  }

  protected function get_product_ids(){
    if(! $this->order_items){
      return array();
    }

    return array_map(function($el){
      return $el->get_product_id();
    }, $this->order_items);
  }

  protected function get_line_items(){
    $data =  array_filter(
               array_values(
                  array_map(function($item){
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
                  }, $this->order_items )),
              function($el){
                return !!$el;
              });

    usort($data, function($a, $b){
      $data = strcmp($a['product_name'], $b['product_name']);
      if($data == 0){
        return 0;
      }
      return  $data > 0 ? 1 : -1;
    });
    return $data;
  }

  /**
  * collect data for fees in order
  */
  protected function get_fee_items($order){
    return array_values(array_map(function($item){
      return array(
        'fee_name' =>$item->get_name(),
        'price' =>$item->get_amount(),
      );
    },$order->get_items('fee')));
  }

  protected function get_addon_items($order){
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
      }, $this->order_items );

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
        'price' =>  in_array('Fasttrack', $order_addons)? _wc_price(wc_get_product((int)$this->fasttrack_product_id)->get_regular_price() ) : _wc_price(0),
      ),

      'handling' => array(
        'title' => 'Handling',
        'name'  => in_array('Returning product', $order_addons)? 'Returning Product' : 'Hold Products',
        'price' =>  in_array('Returning product', $order_addons)? _wc_price(wc_get_product($this->return_product_id)->get_regular_price()) : _wc_price(0),
      ),
    );

    $addons = array_merge($addons , $coupons );

    usort($addons, function($a, $b){
      if($a['title'] === 'Coupon'){
        return 1;
      }
      if($b['title'] === 'Coupon'){
        return -1;
      }
      return 0;
    });

    return $addons;
  }
};

function map_orders($order){
  $helper = new map_orders_cb($order);
  return $helper->create_item_array($order);
}

function old_map_orders($order){

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
  $is_fasttrack         = in_array($fasttrack_product_id, $products);

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
      }, $order_items );

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

      usort($addons, function($a, $b){
        if($a['title'] === 'Coupon'){
          return 1;
        }
        if($b['title'] === 'Coupon'){
          return -1;
        }
        return 0;
      });

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
    }, $order_items ));

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
        'studio'  => array(),
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

/**
* splits passed string by '-' symbol
*
* @param $name - string
*
* @return string - arr[0]
*/
function get_count_from_name($name){
  if(strpos(strtolower($name), 'image')!== false){
    $part = explode('-', $name);
    if(count($part) < 2){
      return 1;
    }
    $parts = explode(' ', trim($part[1]));
    return (int)$parts[0];
  }else{
    return 1;
  }
}

/**
* returns html decode price with currency
* removes html tags
*
* @param $summ - string
*
* @return string
*/
function _wc_price($summ){
  return html_entity_decode(strip_tags(wc_price($summ)));
}



function save_order_meta($order){
  if(!$order){
    return;
  }
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

    '_reminder' => isset($_POST['data']['reminder'])? $_POST['data']['reminder']:array(
      'date' => '',
      'date_formatted' => '',
      'is_overdue' => 0,
    ),

    '_collection_address'      => $_POST['data']['product_collection']['address'],
    '_free_collection_date'      => $_POST['data']['product_collection']['requested'],
    'collection-date'          => $_POST['data']['product_collection']['scheduled'],
  );

  $test = array();

  foreach($save as $meta_key => $meta_value){
    if($order->meta_exists($meta_key)){
      $test[$meta_key] = $order->update_meta_data($meta_key, $meta_value);
    }else{
      $test[$meta_key] = $order->add_meta_data($meta_key, $meta_value);
    }
  }

  return $test;
}
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
}else{
  clog('print_duh_template_part already declared');
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
}else{
  clog('print_javascript_data already declared');
}


if(!function_exists('sort_by_order')){
  /**
  * sort function for objects with order key;
  */
  function sort_by_order($a, $b){
    if( $a['order'] == $b['order']){
      return 0;
    }

    return $a['order'] > $b['order']? 1 : -1;
  }
}else{
  clog('sort_by_order already declared');
}



if(!function_exists('get_items_for_tracker')){

  /**
  * gets order parsed data for frontdesk
  *
  * @param type - string frontdesk || studio
  * @param $date_start - date
  * @param $date_end - date
  * @param $include_ids -  array of ids order ids to include
  *
  * @return array
  */
  function get_items_for_tracker($type = 'frontdesk', $date_start = false, $date_end = false , $include_ids = false){

    $start = microtime(true);
    $args = array(
      'type' =>  'shop_order',
      'limit' => -1,
    );

    if($include_ids){
      $args['post__in'] = $include_ids;
      $args['include']  = $include_ids;
    }

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
}else{
  clog('get_items_for_tracker already declared');
}

if(!function_exists('get_item_for_tracker')){
  /**
  * gets formatted data about 1 order
  *
  * @param #order_id - integer single order id
  *
  * @return array of data about order
  */
  function get_item_for_tracker($order_id){
    $orders = array_map('map_orders',array(wc_get_order($order_id)));
    return $orders[0];
  }
}else{
  clog('get_item_for_tracker already declared');
}


if(!class_exists('map_orders_cb')){
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
        'brand'      => $order->get_billing_company(),
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

      $attachment_id = get_post_meta($this->order_id, 'attachments', true);

      // $pdf = !!$attachment_id?  array(wp_get_attachment_url((int)$attachment_id)) : array();

      $pdf = array();
      $wfp_images = $order->get_meta('_wfp_image');

      if($wfp_images){
        $wfp_images = array_filter($order->get_meta('_wfp_image'), function($el){
          return !isset($el['was_bought']);
        });
      }

      return array(
        'order_id' =>  $this->order_id,
        'data'     => array(
          'order_id'      => $this->order_id,
          'name'          => $this->user->get_display_name(),
          'created_order' => $order->get_meta('_is_created_order'),
          'wfp_images'      =>  $wfp_images,
          'wfp_image_single' => $order->get_meta('_wfp_image_single'),

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
            'source'   =>  $customer_data['source']  ? array( $customer_data['source'] ):  array('Site'),
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
            'pdf'    =>  $pdf,
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
  }
}else{
  clog('map_orders_cb already declared');
}


if(!function_exists('map_orders')){
  /**
  * calbac for array map function
  * uses map_orders_cb object to create inital data about orders
  *
  * @param  WC_Order object
  *
  * @return array;
  */
  function map_orders($order){
    $helper = new map_orders_cb($order);
    return $helper->create_item_array($order);
  }
}else{
  clog('map_orders already declared');
}

if(!function_exists('old_map_orders')){
  /**
  * @deprecated
  */
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
}else{
  clog('old_map_orders already declared');
}


if(!function_exists('get_count_from_name')){
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
}else{
  clog('get_count_from_name already declared');
}


if(!function_exists('_wc_price')){
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
}else{
  clog('_wc_price already declared');
}


if(!function_exists('save_order_meta')){
  /**
  * saves metada for order
  * saves meta data from $_POST
  *
  * @param $order - WC_Order object
  *
  * @return array of pairs meta_name - status (boolean)
  */
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
}else{
  clog('save_order_meta already declared');
}


if(!function_exists('get_filter_data')){
  /**
  * gets filter data by passed orders
  *
  * @param $orders - array of formattd order data
  *
  * @return array of filters
  */
  function get_filter_data($orders = array()){

     $filter_values = array(
       'campaign' => array(),
       'source'   => array(),
       'team'      => array(),
     );

     $grab_filter = array(
       'campaign' => ['customer.campaigns'],
       'source'   => ['customer.source'],
       'team'     => ['customer.assigned', 'studio.creator'],
     );

     foreach ($grab_filter as $filter_key => $filter_sources) {
       $filter_values[$filter_key] = array();

       foreach ($filter_sources as $key => $source) {
         $path = array_fill(0, count($orders), $source);
         $temp = array_map(function($el,  $data){
            $path = explode('.',$data);
            return isset($el['data'][$path[0]][$path[1]]) ? $el['data'][$path[0]][$path[1]] : '';
          },$orders, $path);

          $filter_values[$filter_key] = array_merge($filter_values[$filter_key], $temp);
          $filter_values[$filter_key] = array_unique($filter_values[$filter_key]);
       }

        $filter_values[$filter_key] = array_filter($filter_values[$filter_key], function($el){
          return !empty($el);
        } );

        $filter_values[$filter_key] = $filter_values[$filter_key]?: array();
        array_unshift($filter_values[$filter_key], 'All '.$filter_key);
     }

     return $filter_values;
  }
}else{
    clog('get_filter_data already declared');
}

if(!function_exists('exec_upload_file')){
  /**
  * Process an uploading of a file
  *
  * @param $nonce_post - string, name of posted nonce field
  * @param $nonce - string name of a nonce field to check fo wp_verify_nonce()
  * @param $file_name - string name of posted  file field input
  *
  * @return Array || false
  */
  function exec_upload_file($file_name , $nonce_post ='', $nonce =''  ){


    if ( ! function_exists( 'wp_handle_upload' ) )
      include_once( ABSPATH . 'wp-admin/includes/file.php' );

    // global $upload_exeptions;

    $upload_exeptions = array(
      'error' => array(),
      'success' => array(),
      'info' => array(),
    );

    try {
      $file      = & $_FILES[$file_name];
      $dir       = wp_upload_dir();
      $overrides = [ 'test_form' => false ];

     /**
     * check for errors on uploading file
     *
     */
     switch($file['error']){
        case 8:
          throw new Exception('UPLOAD_ERR_EXTENSION');
         break;
        case 7:
          throw new Exception('Failed to load file, error 7, UPLOAD_ERR_CANT_WRITE');
          break;
        case 6:
          throw new Exception('Destination folder was not found, error 6, UPLOAD_ERR_NO_TMP_DIR ');
          break;
        case 4:
          return;
          throw new Exception('No file was loaded, error 4, UPLOAD_ERR_NO_FILE');
          break;
        case 3:
          throw new Exception('Files was recived partially, error 3, "UPLOAD_ERR_PARTIAL"');
          break;
        case 2:
          throw new Exception('Files size exceedes form limit, error 2, "UPLOAD_ERR_FORM_SIZE"' );
          break;
        case 1:
          throw new Exception('Files size exceedes max file size, error 1, "UPLOAD_ERR_INI_SIZE"');
          break;
     }

     // if((int)$file['size'] > $limit){
     //    throw new Exception('Files size exceedes max file size, error 1, "UPLOAD_ERR_INI_SIZE"');
     //  }

      $allowed  = ['image/jpg', 'image/jpeg', 'image/png', 'application/pdf'];

      if(!in_array($file['type'],  $allowed )){
        throw new Exception('Wrong file extension. Tried to upload <b>' . $file['type'] . '</b> file. Only jpg, jpeg, png, pdf are allowed');
      }

      add_filter('upload_dir', 'my_upload_dir');

      $file_loaded = wp_handle_upload( $file, $overrides );

      if( isset($file_loaded['error'])){
         throw new Exception('Failed to load. '. $file_loaded['error']);
      }


      $p = explode('/', $file_loaded['file']);
      $file_name = end($p);
      $file_name_parts = explode('.', $file_name);
      $file_resolution = end($file_name_parts);
      $file_resolution_check = strtolower($file_resolution);

      if($file['type'] === 'image/png' || $file['type'] === 'image/jpg' || $file['type'] === 'image/jpeg'  ){
        $search     = '.'.$file_resolution;
        $replace    = '_thumb.'.$file_resolution;
        $thumb_name = str_replace($search, $replace, $file_name);
        $upload_file_path = str_replace($file_name, $thumb_name, $file_loaded['file']);

        // create_thmb( $file_loaded ['file'], $upload_file_path );
        $file_loaded['thumb_upload_url'] = str_replace($dir['basedir'], '', $upload_file_path);
      } else {
        $file_loaded['thumb_upload_url'] = THEME_URL. '/images/'. $file_resolution .'-icon.png';
      }

      remove_filter('upload_dir', 'my_upload_dir');

      $upload_exeptions['success'][] = 'Upload of the file ' . $file['name'] . ' was completed successfully';


      return array(
        'file' => $file,
        'file_loaded' => $file_loaded,
      ) ;
    } catch(Exception $ex){
      $upload_exeptions['error'][] = $ex->getMessage();
    }

    return $upload_exeptions;
  }
}


if(!function_exists('my_upload_dir')){

  /**
  * modifies upload url and path
  *
  * @param $upload - array
  */
  function my_upload_dir($upload) {

    $upload['subdir'] = '/documents' . $upload['subdir'];

    $upload['path']   = $upload['basedir'] . $upload['subdir'];

    $upload['url']    = $upload['baseurl'] . $upload['subdir'];

    return $upload;
  }
}

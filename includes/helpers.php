<?php
/**
* Theme helper functions
*
* @package theme/helpers
*/


if(!function_exists('clog')){

  /**
 * prints an inline script with output in console
 *
 * @param mixed $content - obj|array|string
 */
  function clog($content, $color = false){
    // if(!$content) return;

    global $clog_data;
    $clog_data = (!$clog_data)? array() : $clog_data;

    $color = (is_object($content) || is_array($content))? false : $color;

    $clog_data[] = array(
       'content' => $content,
       'color'   => $color,
       'type'    => 'regular'
    );
  }
}

if(!function_exists('exec_clog')){
  function exec_clog(){
    global $clog_data;

    if(!$clog_data) return;

    foreach ($clog_data as $key => $data) {
      switch ($data['color']){
         case 'red':
            $script_open =  '<script> console.log("\x1b[0m\x1b[31m %s \x1b[0m",';
          break;
         case 'green':
            $script_open =  '<script> console.log("\x1b[0m\x1b[32m %s \x1b[0m",';
          break;
         case 'blue':
            $script_open =  '<script> console.log("\x1b[0m\x1b[34m %s \x1b[0m",';
          break;
         case 'purple':
            $script_open =  '<script> console.log("\x1b[0m\x1b[35m %s \x1b[0m",';
          break;
         case 'cyan':
            $script_open =  '<script> console.log("\x1b[0m\x1b[36m %s \x1b[0m",';
          break;
         case 'grey':
            $script_open =  '<script> console.log("\x1b[0m\x1b[37m %s \x1b[0m",';
          break;
        default:
            $script_open = '<script> console.log(';
          break;
      }

      switch ($data['type']) {
        case 'end':
          echo '<script> console.groupEnd()</script>';
          break;
        case 'start':
          printf( '<script> console.groupCollapsed("%s")</script>', $data['content']);
          break;
        case 'start:expanded':
          printf( '<script> console.group("%s")</script>', $data['content']);
          break;

        default:
          echo $script_open;
          echo json_encode($data['content']);
          echo ')</script>';
          break;
      }
    }
}


if(!function_exists('glog')){
  /**
 * prints an inline script with output in console
 *
 * @param mixed $content - obj|array|string
 */
  function glog($content = 'group log', $expand = false){
      global $clog_data;
      $clog_data = (!$clog_data)? array() : $clog_data;
      if ($content) {

            $clog_data[] = array(
               'content' => $content,
               'color'   => false,
               'type'    => (!$expand)?'start' : 'start:expanded'
            );

      }
      else{
        $clog_data[] = array(
           'content' => $content,
           'color'   => false,
           'type'    => 'end'
        );
      }
    }
  }
}
if(!function_exists('dlog')){

  /**
 * prints an inline script with output in console
 *
 * @param mixed $content - obj|array|string
 */
  function dlog($content, $start=false, $end=false){
    if( 'THEME_DEBUG' === true && (!defined('DOING_AJAX'))){

      if ($start) {
        printf( '<script> console.groupCollapsed("%s")</script>', $content);
      }
      else{
        echo '<script> console.log(';
        echo json_encode($content);
        echo ')</script>';
      }

      if ($end) {
        echo '<script> console.groupEnd()</script>';
      }
    }
  }
}


if(!function_exists('print_theme_template_part')){
  /**
  *  prints an inline javascript.
  *  script adds styles to local storage
  *
  * @param $url - url of script
  * @param $script name - name of a script
  */
  function print_theme_template_part($template_name,  $template_path, $args = array()){

    if(!empty($template_name) && ($template_path) ){
      extract($args);
      include(THEME_PATH.'/theme_templates/'. $template_path . '/'.'template-'. $template_name .'.php');
    }
  }
}


if(!function_exists('add_svg_sprite')){
  /**
   * prints an inline script that writes html with svg data to local storage
   *
   * @param $name - string, name of a file to inline
   */
  function add_svg_sprite($name, $url){
    $name_symbol = $name;
    $name_data = $name.'_rev';
    printf('<script> ( function( window, document ) {var file =\'%s\', revision = 1; if( !document.createElementNS || !document.createElementNS( \'http://www.w3.org/2000/svg\', \'svg\' ).createSVGRect ){return true; }; var isLocalStorage = \'localStorage\' in window && window[ \'localStorage\' ] !== null, request, data, insertIT = function() {document.body.insertAdjacentHTML( \'afterbegin\', data ); }, insert = function() {if( document.body ) insertIT(); else document.addEventListener( \'DOMContentLoaded\', insertIT )}; if( isLocalStorage && localStorage.getItem( \'%2$s\' ) == revision ) {data = localStorage.getItem( \'%3$s\' ); if( data ) {insert(); return true; } }; try {request = new XMLHttpRequest(); request.open( \'GET\', file, true ); request.onload = function(){if( request.status >= 200 && request.status < 400 ) {data = request.responseText; insert(); if( isLocalStorage ) {localStorage.setItem( \'%3$s\',  data ); localStorage.setItem( \'%2$s\', revision ); } } }; request.send(); }catch( e ){}; }( window, document ) ); </script>',  $url, $name_symbol, $name_data);
  }
}


if(!function_exists('str_replace_once')){
  /**
   * replaces 1st found example of a substrings
   *
   * @param str $search - strings that should be searched
   * @param str $replace - strings that should be replace
   * @param str $text - stringg where should be found and searched
   *
   * @return str $text - result text
   */
  function str_replace_once($search, $replace, $text){
     $pos = strpos($text, $search);
     return $pos!==false ? substr_replace($text, $replace, $pos, strlen($search)) : $text;
  }
}


if(!function_exists('print_inline_style')){
  /**
  *  prints an inline javascript.
  *  script adds styles to local storage
  *
  * @param $url - url of script
  * @param $script name - name of a script
  */
  function print_inline_style($url, $script_name){
    $script_name = str_replace('-', '_', $script_name);
    $script = sprintf(' (function(){function add_inline_%1$s() {var style = document.createElement(\'style\'); style.rel = \'stylesheet\'; document.head.appendChild(style); style.textContent = localStorage.%1$s; };
      var image_url = "%3$s"; var exp  = new RegExp("..\/images", "gi"); try {if (localStorage.%1$s) {add_inline_%1$s(); } else {var request = new XMLHttpRequest(); request.open(\'GET\', \'%2$s\', true); request.onload = function() {if (request.status >= 200 && request.status < 400) {var text =  request.responseText; text = text.replace(exp, image_url); localStorage.%1$s = text; add_inline_%1$s(); } }; request.send(); } } catch(ex) {} }());', $script_name, $url, THEME_URL.'/images/');

    printf('<script>%s</script>',$script);
  }
}


if(!function_exists('unregister_scripts_n_styles')){
  /**
  * removes styles and scripts
  */
  function unregister_scripts_n_styles(){

    $styles = apply_filters('allow_theme_styles', wp_styles()->queue);

    $scripts = apply_filters('allow_theme_scripts', wp_scripts()->queue);


    foreach ($styles  as $id => $_s) {
      wp_deregister_style($_s);
      wp_dequeue_style($_s);
    }

    foreach ($scripts  as $id => $_s) {
      wp_deregister_script($_s);
      wp_dequeue_script($_s);
    }
  }
}


if(!function_exists('get_time_passed_text')){
  /**
  * returns text thats says how much time passed, since a comparing date
  *
  * @param $compare_date - string date
  * @param $format - string date format, that accepts function date()
  *
  * @return $text - string
  */
  function get_time_passed_text($compare_date, $format){
    $text = '';
    $now  = new DateTime();
    $date = DateTime::createFromFormat($format, $compare_date);
    $interval = $now->diff($date);

     if ($interval->y > 0):
       $text .= $interval->y;
       $text .=_n(' year', ' years', $interval->y);
       $text .= ' ';
       $text .= __('ago', 'theme-translations');
     elseif (($interval->d > 30)) :
       $text .= Floor($interval->d/30);
       $text .= _n(' month', ' months', Floor($interval->d/30));
       $text .= ' ';
       $text .= __('ago', 'theme-translations');
     elseif (($interval->d > 0)) :
       $text .= $interval->d;
       $text .= _n(' day', ' days', $interval->d);
       $text .= ' ';
       $text .= __('ago', 'theme-translations');
     elseif ($interval->h > 0) :
       $text .= $interval->h;
       $text .= _n(' hour', ' hours', $interval->h);
       $text .= ' ';
       $text .= __('ago', 'theme-translations');
     elseif ($interval->i >0) :
       $text .= $interval->i;
       $text .= _n(' minute', ' minutes', $interval->i);
       $text .= ' ';
       $text .= __('ago', 'theme-translations');
     else:
      $text .= 'Just published';
     endif;

     return $text;
  }
}


if(!function_exists('is_premium')){
  /**
  * detects if a product is premium.
  * designed to work with the plugins YITH WooCommerce Membership Premium and YITH WooCommerce Subscription Premium
  *
  * @param $product - mixed, integer or WC_Product object
  *
  * @return bool;
  */
  function is_premium($product){
    if(!function_exists('wc'))
      return false;
    $p          = (is_object($product))? $product : wc_get_product($product);
    if (!$p)
      return false;

    if(!function_exists('YITH_WCMBS_Products_Manager'))
      return false;

    $manager = YITH_WCMBS_Products_Manager();
    $plans   =  $manager->product_is_in_plans($p->get_id());
    $is_premium = ( $plans )? true : false;
    return $is_premium;
  }
}


if(!function_exists('user_can_order_this_product')){

  /**
  * detects if a user is allowed to order a product
  * designed to work with the plugins YITH WooCommerce Membership Premium and YITH WooCommerce Subscription Premium
  *
  * @param $product - mixed, integer or WC_Product object
  * @param $user - mixed, integer or WP_User object
  *
  * @return bool;
  */
  function user_can_order_this_product($product, $user){
    if(!function_exists('YITH_WCMBS_Products_Manager'))
      return true;

    $manager = YITH_WCMBS_Products_Manager();

    $product_id = (is_object($product))? $product->get_id() : $product;
    $user_id    = (is_object($user))?  $user->ID : $user;

    $user_is_premium = user_is_premium( $user_id );


    return  ($manager->user_has_access_to_product($user_id, $product_id) &&  $user_is_premium );
  }
}


if(!function_exists('product_is_subscription')){
  /**
  * detects if a product is a subscription.
  * designed to work with the plugins YITH WooCommerce Membership Premium and YITH WooCommerce Subscription Premium
  *
  * @param $product - mixed, integer or WC_Product object
  *
  * @return bool;
  */
  function product_is_subscription($product){
    if(!$product)
      return;

    if(!function_exists('wc'))
      return false;

    $product_id = (is_object($product))? $product->get_id() : $product;

    if(!function_exists('YITH_WCMBS_Products_Manager'))
      return false;

    $is_subscription = ('yes' === get_post_meta( $product_id, '_ywsbs_subscription', true ))? true : false;

    return $is_subscription;
  }
}


if(!function_exists('user_is_premium')){
  /**
  * detects if a user has active subscriptions
  *
  * @param $user - mixed, integer or WP_User object
  *
  * @return bool;
  */
  function user_is_premium($user = null){
    if(!$user)
      $user = wp_get_current_user();

    if(!$user)
      return false;

    $user_id  = (is_object($user))?  $user->ID : $user;

    if(!class_exists('YITH_WCMBS_Member_Premium'))
      return true;

    $membership = new YITH_WCMBS_Member_Premium( $user_id );

    return $membership->is_member();
  }
}


if(!function_exists('get_theme_checkout_content')){
  /**
  * fixes the cart content if order has subscription or single product
  *
  * @return array
  */
  function get_theme_checkout_content(){
    if(!theme_construct_page::is_page_type('woo-checkout'))
      return;

    global $theme_checkout_content;

    if($theme_checkout_content)
      return $theme_checkout_content;

    $cart = wc()->cart;
    $content = $cart->get_cart_contents( );

    $response = array(
      'type'       => 'regular',
      'premium_id' => -1,
      'single_id'  => -1,
      'buying_premium' => false,
    );

    $premium_id =  -1;

    foreach ($content as $key => $item) {
      $premium_id = (product_is_subscription($item['product_id']))?$item['product_id'] : $premium_id;

      if(product_is_subscription($item['product_id'])){
        wc()->cart->set_quantity($key, 1);
      }
    }

    $response['premium_id']      = $premium_id;
    $response['buying_premium']  = ($premium_id >=0)? TRUE : FALSE;

    if(($premium_id > 0) && (1 === count($content)) ){

      // if(wc()->cart->get_cart_contents_count() === 1){
      //   $cart->empty_cart();
      //   $cart->add_to_cart($premium_id, 1, $premium_id);
      // }

       $response['type'] = 'premium';
    }

    $theme_checkout_content = $response;

    return  $response;
  }
}


if(!function_exists('get_price_in_text')){

  /**
  * search for price in text.
  * only stored in woocommerce currencies are used to search
  *
  * @param string to search
  *
  * @return array or false
  */
  function get_price_in_text($string){
    if(!function_exists('wc'))
      return false;
    $symbol = get_woocommerce_currency_symbol();
    $symbol = html_entity_decode ($symbol);

    $search = '/\\d{0,}'.$symbol.'\\d{0,}/i';

    preg_match($search, $string, $matches);

    $result = array(
      'price' => '',
      'string-wo-price' => ''
    );

    if($matches){
      $result = array(
        'price' => $matches[0],
        'no-price' => str_ireplace($matches[0],'', $string),
      );

      return $result;
    }

    return false;
  }
}


if(!function_exists('get_all_subscriptions')){
  /**
  * gets all available subscriptions
  * designed to work with the plugins YITH WooCommerce Membership Premium and YITH WooCommerce Subscription Premium
  *
  * @return array || FALSE
  */
  function get_all_subscriptions(){
    if(!function_exists('YITH_WCMBS_Products_Manager'))
      return false;

    $args = array(
      'post_type' => 'product',
      'meta_query' => array(
           array(
               'key' => '_ywsbs_subscription',
               'value' => 'yes',
               'compare' => '=',
           )
       )
    );

    $subscriptions = get_posts($args);

    return ($subscriptions)? $subscriptions : false;
  }
}


if(!function_exists('is_a_single_image_product')){

  /**
  * checks if a product is a single image
  *
  * @param $product - mixed WP_Product or integer
  *
  * @return bool
  */
  function is_a_single_image_product($product){
    if(!$product)
      return;

    $product_id =(is_a($product, 'WP_Product'))? $product->get_id() : $product;

    $option = get_option('wfp_single_product_id');

    if(!$option || (int)$option < 0)
      return false;

    return ((int)$product_id === (int)$option )? true : false;
  }
}


if(!function_exists('get_cart_totals')){

  /**
  * gets cart total
  *
  * @return string
  */
  function get_cart_totals(){
   $value =  WC()->cart->get_total();

    // If prices are tax inclusive, show taxes here.
    if ( wc_tax_enabled() && WC()->cart->display_prices_including_tax() ) {
        $tax_string_array = array();
        $cart_tax_totals  = WC()->cart->get_tax_totals();

        if ( get_option( 'woocommerce_tax_total_display' ) == 'itemized' ) {
            foreach ( $cart_tax_totals as $code => $tax ) {
                $tax_string_array[] = sprintf( '%s %s', $tax->formatted_amount, $tax->label );
            }
        } elseif ( ! empty( $cart_tax_totals ) ) {
            $tax_string_array[] = sprintf( '%s %s', wc_price( WC()->cart->get_taxes_total( true, true ) ), WC()->countries->tax_or_vat() );
        }

        if ( ! empty( $tax_string_array ) ) {
            $taxable_address = WC()->customer->get_taxable_address();
            $estimated_text  = WC()->customer->is_customer_outside_base() && ! WC()->customer->has_calculated_shipping()
                ? sprintf( ' ' . __( 'estimated for %s', 'woocommerce' ), WC()->countries->estimated_for_prefix( $taxable_address[0] ) . WC()->countries->countries[ $taxable_address[0] ] )
                : '';
            $value .= '<small class="includes_tax">' . sprintf( __( '(includes %s)', 'woocommerce' ), implode( ', ', $tax_string_array ) . $estimated_text ) . '</small>';
        }
    }

    return apply_filters( 'woocommerce_cart_totals_order_total_html', $value );
  }
}


if(!function_exists('recursive_sanitize_text_field')){
  /**
   * Recursive sanitation for an array
   *
   * @param $array
   *
   * @return mixed
   */
  function recursive_sanitize_text_field($array) {
      foreach ( $array as $key => &$value ) {
          if ( is_array( $value ) ) {
              $value = recursive_sanitize_text_field($value);
          }
          else {
              $value = implode( "\n", array_map( 'sanitize_text_field', explode( "\n", $value) ) );
          }
      }

      return $array;
  }
}


if(!function_exists('get_latest_subscription_billing_date')){

   /**
   *returns the latest among all starting dates among subscriptions posts
   *
   * @param $subscriptions array of WP_Post , post_type == subscriptions
   *
   * @return string - formatted date
   */
  function get_latest_subscription_billing_date($subscriptions){
    if(!function_exists('ywsbs_get_subscription'))
      return false;
    $o                    = get_option('theme_settings');
    $dates                = array();
    $subscription_product = get_post($o['subscription']);

    foreach ($subscriptions as $key => $subscription_post) {
      if('ywsbs_subscription' !==$subscription_post->post_type) continue;

      $subscription = ywsbs_get_subscription( $subscription_post->ID );

      if((int)$subscription_product->ID === (int)get_post_meta($subscription_post->ID, 'product_id', true) )
        $dates[] = ( $subscription->start_date) ? date_i18n( wc_date_format(), $subscription->start_date ) : '';
    }

    $mostRecent = 0;

    foreach($dates as $date){
      $curDate = strtotime($date);
      if ( $curDate  && $curDate > $mostRecent) {
         $mostRecent = $curDate;
      }
    }

    return ($mostRecent > 0) ?(date_i18n( wc_date_format(), $mostRecent ) ) : false;
  }
}



if(!function_exists('get_ready_date_offset')){
  /**
  * Gets ready date offset for current order;
  *
  * @param $user_is_premium - bool for what type of user do action
  * @param $for - string 'php'|'js'|'text' for what type data do
  *
  * @return string
  */
  function get_ready_date_offset($user_is_premium = null, $for = 'php'){
    $before = ('php' === $for)? '+' : '';
    $after  = ('php' === $for)? ' days' : '';
    $show_for_premium = (is_bool($user_is_premium ))? $user_is_premium : user_is_premium();
    $value  = ($show_for_premium)? '5' : '10';
    return $before.$value.$after;
  }
}



if(!function_exists('theme_minify_js')){

  /**
  * JavaScript Minifier
  *
  * @param string of javascript
  *
  * @return $string
  */
  function theme_minify_js($input) {
      if(trim($input) === "") return $input;
      return preg_replace(
          array(
              // Remove comment(s)
              '#\s*("(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\')\s*|\s*\/\*(?!\!|@cc_on)(?>[\s\S]*?\*\/)\s*|\s*(?<![\:\=])\/\/.*(?=[\n\r]|$)|^\s*|\s*$#',
              // Remove white-space(s) outside the string and regex
              '#("(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\'|\/\*(?>.*?\*\/)|\/(?!\/)[^\n\r]*?\/(?=[\s.,;]|[gimuy]|$))|\s*([!%&*\(\)\-=+\[\]\{\}|;:,.<>?\/])\s*#s',
              // Remove the last semicolon
              '#;+\}#',
              // Minify object attribute(s) except JSON attribute(s). From `{'foo':'bar'}` to `{foo:'bar'}`
              '#([\{,])([\'])(\d+|[a-z_][a-z0-9_]*)\2(?=\:)#i',
              // --ibid. From `foo['bar']` to `foo.bar`
              '#([a-z0-9_\)\]])\[([\'"])([a-z_][a-z0-9_]*)\2\]#i'
          ),
          array(
              '$1',
              '$1$2',
              '}',
              '$1$3',
              '$1.$3'
          ),
      $input);
  }
}


if(!function_exists('minify_css')){

  /**
  * CSS Minifier
  *
  * @param string of javascript
  *
  * @return $string
  */
  function minify_css($input) {
      if(trim($input) === "") return $input;
      return preg_replace(
          array(
              // Remove comment(s)
              '#("(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\')|\/\*(?!\!)(?>.*?\*\/)|^\s*|\s*$#s',
              // Remove unused white-space(s)
              '#("(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\'|\/\*(?>.*?\*\/))|\s*+;\s*+(})\s*+|\s*+([*$~^|]?+=|[{};,>~+]|\s*+-(?![0-9\.])|!important\b)\s*+|([[(:])\s++|\s++([])])|\s++(:)\s*+(?!(?>[^{}"\']++|"(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\')*+{)|^\s++|\s++\z|(\s)\s+#si',
              // Replace `0(cm|em|ex|in|mm|pc|pt|px|vh|vw|%)` with `0`
              '#(?<=[\s:])(0)(cm|em|ex|in|mm|pc|pt|px|vh|vw|%)#si',
              // Replace `:0 0 0 0` with `:0`
              '#:(0\s+0|0\s+0\s+0\s+0)(?=[;\}]|\!important)#i',
              // Replace `background-position:0` with `background-position:0 0`
              '#(background-position):0(?=[;\}])#si',
              // Replace `0.6` with `.6`, but only when preceded by `:`, `,`, `-` or a white-space
              '#(?<=[\s:,\-])0+\.(\d+)#s',
              // Minify string value
              '#(\/\*(?>.*?\*\/))|(?<!content\:)([\'"])([a-z_][a-z0-9\-_]*?)\2(?=[\s\{\}\];,])#si',
              '#(\/\*(?>.*?\*\/))|(\burl\()([\'"])([^\s]+?)\3(\))#si',
              // Minify HEX color code
              '#(?<=[\s:,\-]\#)([a-f0-6]+)\1([a-f0-6]+)\2([a-f0-6]+)\3#i',
              // Replace `(border|outline):none` with `(border|outline):0`
              '#(?<=[\{;])(border|outline):none(?=[;\}\!])#',
              // Remove empty selector(s)
              '#(\/\*(?>.*?\*\/))|(^|[\{\}])(?:[^\s\{\}]+)\{\}#s'
          ),
          array(
              '$1',
              '$1$2$3$4$5$6$7',
              '$1',
              ':0',
              '$1:0 0',
              '.$1',
              '$1$3',
              '$1$2$4$5',
              '$1$2$3',
              '$1:0',
              '$1$2'
          ),
      $input);
  }
}



if ( ! function_exists( 'get_currency_countries' ) ) {
  /**
   * get_currency_countries.
   *
   * 158 currencies.
   * Three-letter currency code (ISO 4217) => Two-letter countries codes (ISO 3166-1 alpha-2).
   */
  function get_currency_countries() {
    return array(
      'AFN' => array( 'AF' ),
      'ALL' => array( 'AL' ),
      'DZD' => array( 'DZ' ),
      // 'USD' => array( 'AS', 'IO', 'GU', 'MH', 'FM', 'MP', 'PW', 'PR', 'TC', 'US', 'UM', 'VI' ),
      'USD' => 'US',
      'EUR' => array( 'AD', 'AT', 'BE', 'CY', 'EE', 'FI', 'FR', 'GF', 'TF', 'DE', 'GR', 'GP', 'IE', 'IT', 'LV', 'LT', 'LU', 'MT', 'MQ', 'YT', 'MC', 'ME', 'NL', 'PT', 'RE', 'PM', 'SM', 'SK', 'SI', 'ES' ),
      'AOA' => array( 'AO' ),
      'XCD' => array( 'AI', 'AQ', 'AG', 'DM', 'GD', 'MS', 'KN', 'LC', 'VC' ),
      'ARS' => array( 'AR' ),
      'AMD' => array( 'AM' ),
      'AWG' => array( 'AW' ),
      'AUD' => array( 'AU', 'CX', 'CC', 'HM', 'KI', 'NR', 'NF', 'TV' ),
      'AZN' => array( 'AZ' ),
      'BSD' => array( 'BS' ),
      'BHD' => array( 'BH' ),
      'BDT' => array( 'BD' ),
      'BBD' => array( 'BB' ),
      'BYR' => array( 'BY' ),
      'BZD' => array( 'BZ' ),
      'XOF' => array( 'BJ', 'BF', 'ML', 'NE', 'SN', 'TG' ),
      'BMD' => array( 'BM' ),
      'BTN' => array( 'BT' ),
      'BOB' => array( 'BO' ),
      'BAM' => array( 'BA' ),
      'BWP' => array( 'BW' ),
      'NOK' => array( 'BV', 'NO', 'SJ' ),
      'BRL' => array( 'BR' ),
      'BND' => array( 'BN' ),
      'BGN' => array( 'BG' ),
      'BIF' => array( 'BI' ),
      'KHR' => array( 'KH' ),
      'XAF' => array( 'CM', 'CF', 'TD', 'CG', 'GQ', 'GA' ),
      'CAD' => array( 'CA' ),
      'CVE' => array( 'CV' ),
      'KYD' => array( 'KY' ),
      'CLP' => array( 'CL' ),
      'CNY' => array( 'CN' ),
      'HKD' => array( 'HK' ),
      'COP' => array( 'CO' ),
      'KMF' => array( 'KM' ),
      'CDF' => array( 'CD' ),
      'NZD' => array( 'CK', 'NZ', 'NU', 'PN', 'TK' ),
      'CRC' => array( 'CR' ),
      'HRK' => array( 'HR' ),
      'CUP' => array( 'CU' ),
      'CZK' => array( 'CZ' ),
      'DKK' => array( 'DK', 'FO', 'GL' ),
      'DJF' => array( 'DJ' ),
      'DOP' => array( 'DO' ),
      'ECS' => array( 'EC' ),
      'EGP' => array( 'EG' ),
      'SVC' => array( 'SV' ),
      'ERN' => array( 'ER' ),
      'ETB' => array( 'ET' ),
      'FKP' => array( 'FK' ),
      'FJD' => array( 'FJ' ),
      'GMD' => array( 'GM' ),
      'GEL' => array( 'GE' ),
      'GHS' => array( 'GH' ),
      'GIP' => array( 'GI' ),
      'QTQ' => array( 'GT' ),
      'GGP' => array( 'GG' ),
      'GNF' => array( 'GN' ),
      'GWP' => array( 'GW' ),
      'GYD' => array( 'GY' ),
      'HTG' => array( 'HT' ),
      'HNL' => array( 'HN' ),
      'HUF' => array( 'HU' ),
      'ISK' => array( 'IS' ),
      'INR' => array( 'IN' ),
      'IDR' => array( 'ID' ),
      'IRR' => array( 'IR' ),
      'IQD' => array( 'IQ' ),
      'GBP' => array( 'IM', 'JE', 'GS', 'GB' ),
      'ILS' => array( 'IL' ),
      'JMD' => array( 'JM' ),
      'JPY' => array( 'JP' ),
      'JOD' => array( 'JO' ),
      'KZT' => array( 'KZ' ),
      'KES' => array( 'KE' ),
      'KPW' => array( 'KP' ),
      'KRW' => array( 'KR' ),
      'KWD' => array( 'KW' ),
      'KGS' => array( 'KG' ),
      'LAK' => array( 'LA' ),
      'LBP' => array( 'LB' ),
      'LSL' => array( 'LS' ),
      'LRD' => array( 'LR' ),
      'LYD' => array( 'LY' ),
      'CHF' => array( 'LI', 'CH' ),
      'MKD' => array( 'MK' ),
      'MGF' => array( 'MG' ),
      'MWK' => array( 'MW' ),
      'MYR' => array( 'MY' ),
      'MVR' => array( 'MV' ),
      'MRO' => array( 'MR' ),
      'MUR' => array( 'MU' ),
      'MXN' => array( 'MX' ),
      'MDL' => array( 'MD' ),
      'MNT' => array( 'MN' ),
      'MAD' => array( 'MA', 'EH' ),
      'MZN' => array( 'MZ' ),
      'MMK' => array( 'MM' ),
      'NAD' => array( 'NA' ),
      'NPR' => array( 'NP' ),
      'ANG' => array( 'AN' ),
      'XPF' => array( 'NC', 'WF' ),
      'NIO' => array( 'NI' ),
      'NGN' => array( 'NG' ),
      'OMR' => array( 'OM' ),
      'PKR' => array( 'PK' ),
      'PAB' => array( 'PA' ),
      'PGK' => array( 'PG' ),
      'PYG' => array( 'PY' ),
      'PEN' => array( 'PE' ),
      'PHP' => array( 'PH' ),
      'PLN' => array( 'PL' ),
      'QAR' => array( 'QA' ),
      'RON' => array( 'RO' ),
      'RUB' => array( 'RU' ),
      'RWF' => array( 'RW' ),
      'SHP' => array( 'SH' ),
      'WST' => array( 'WS' ),
      'STD' => array( 'ST' ),
      'SAR' => array( 'SA' ),
      'RSD' => array( 'RS' ),
      'SCR' => array( 'SC' ),
      'SLL' => array( 'SL' ),
      'SGD' => array( 'SG' ),
      'SBD' => array( 'SB' ),
      'SOS' => array( 'SO' ),
      'ZAR' => array( 'ZA' ),
      'SSP' => array( 'SS' ),
      'LKR' => array( 'LK' ),
      'SDG' => array( 'SD' ),
      'SRD' => array( 'SR' ),
      'SZL' => array( 'SZ' ),
      'SEK' => array( 'SE' ),
      'SYP' => array( 'SY' ),
      'TWD' => array( 'TW' ),
      'TJS' => array( 'TJ' ),
      'TZS' => array( 'TZ' ),
      'THB' => array( 'TH' ),
      'TOP' => array( 'TO' ),
      'TTD' => array( 'TT' ),
      'TND' => array( 'TN' ),
      'TRY' => array( 'TR' ),
      'TMT' => array( 'TM' ),
      'UGX' => array( 'UG' ),
      'UAH' => array( 'UA' ),
      'AED' => array( 'AE' ),
      'UYU' => array( 'UY' ),
      'UZS' => array( 'UZ' ),
      'VUV' => array( 'VU' ),
      'VEF' => array( 'VE' ),
      'VND' => array( 'VN' ),
      'YER' => array( 'YE' ),
      'ZMW' => array( 'ZM' ),
      'ZWD' => array( 'ZW' ),
    );
  }
}


if ( ! function_exists( 'get_country_flag_url_by_currency' ) ) {

  /**
  * gets country flag url data by currency
  *
  * @param $cur - string
  *
  * @return  array
  */
  function get_country_flag_url_by_currency($cur){
    if(!function_exists('wc')){
       return array(
          'url' => '',
          'path' => ''
       );
    }
    $countries_obj = new WC_Countries();
    $countries = $countries_obj->get_countries();

    $currency_countries = get_currency_countries();

    $country_id = $currency_countries[$cur];
    $country_name = '';
    $regexp = '/\([\s\S]*\)/';


    if(is_array($country_id)){
      foreach ($country_id as $key => $id) {
        $country_name = isset($countries[ $id ])? $countries[ $id ]: $country_name ;
      }

    }else{
      $country_name = $countries[ $country_id ];
    }


    $country_name = preg_replace($regexp, '', $country_name);


    $country_flag_url = str_replace(' ', '_', trim($country_name)).'.png';

    return array(
      'url' => THEME_URL.'/images/flags/'.$country_flag_url,
      'path' => THEME_PATH.'/images/flags/'.$country_flag_url
    );
  }
}


if(!function_exists('is_international_delivery')){
  /**
  * detects if delivery is international
  *
  * @param $c - destination country, string
  *
  * @return  bool
  */
  function is_international_delivery($c){
    if(!function_exists('wc')) return true;

    $default = get_option('woocommerce_default_country');

    if(!$default) return true;

    return ($c['country'] !== $default);
  }
}

if(!function_exists('insert_value_at_position')){
  /**
  * inserts array into position
  *
  * @param $arr - array -
  * @param $insertedArray - array
  * @param $position - integer
  *
  * @return  array
  */

  function insert_value_at_position($arr, $insertedArray, $position) {
      $i = 0;
      $new_array=[];
      foreach ($arr as $key => $value) {
          if ($i == $position) {
              foreach ($insertedArray as $ikey => $ivalue) {
                  $new_array[$ikey] = $ivalue;
              }
          }
          $new_array[$key] = $value;
          $i++;
      }
      return $new_array;
  }
}


class theme_formatted_cart{

  private $items;

  /**
  * Main construct class
  */
  public function __construct($from = 'cart'){
    $formatted = array();

    if('cart' == $from){
      foreach (wc()->cart->get_cart() as $item_id => $cart_item) {
        $group_id = isset($cart_item['group_id']) ? $cart_item['group_id'] : $item_id;

        if(!$group_id) {continue;}

        $product = wc_get_product($cart_item['product_id']);
        if(!$product) {continue;}

        $avoid = [
          (int)get_option('wfp_priority_delivery_product_id'),
          (int)get_option('wfp_return_product_id'),
        ];

        if(in_array($cart_item['product_id'], $avoid)){
          continue;
        }

        if(!isset($formatted[$group_id])){
          $formatted[$group_id] = array(
            'recipe_name' => $product->get_title(),
            'product_id' => $cart_item['product_id'],
            'items'      => array(),
          );
        }

        // if product is variable add data about variations
        if($product->get_type() === 'variable'){

          $formatted[$group_id]['available_variations'] = $product->get_available_variations();

          // get all variations
          $attrubutes =  array();
          $attributes_product = $product->get_variation_attributes();

          foreach ($attributes_product as $attribute_name => $attr) {

            //for each variation get terms
            $terms = wc_get_product_terms(
              $product->get_id(),
              $attribute_name,
              array('fields' => 'all', )
            );


            // add empty item if it does not exists;
            if(!isset($attrubutes[$attribute_name])){
              $attrubutes[$attribute_name] = array(
                'items' => array(),
              );
            }

            // add title for each attribute if it's count > 1
           if (count($attributes_product) > 1):
            $attribute_labels = get_option('theme_attributes_images');

            switch ($attribute_labels['attribute_'.$attribute_name ]['type']) {
              case 'icon':
                $icon  =  sprintf('<i class="icon-%s"></i>', $attribute_labels['attribute_'.$attribute_name ]['icon'] );
                break;
              case 'image':
                $image_id  = (int)$attribute_labels['attribute_'.$attribute_name ]['icon_id'];
                $image_url = wp_get_attachment_image_url($image_id, 'thumbnail');
                $icon      = sprintf('<img class="image-icon" src="%s" height="18" width="18" alt="">', $image_url );
                break;
              default:
                $icon = '';
                break;
            }
            $attrubutes[$attribute_name]['name'] = $icon .' <b>'. wc_attribute_label( $attribute_name ).'</b>';
            endif;

            // add term data
            foreach ($terms as $key => $t) {
              if(in_array($t->slug, $attributes_product[$attribute_name])){
                $attrubutes[$attribute_name]['items'][] = array(
                  'name' => $t->name,
                  'slug' => $t->slug,
                );
              }
            }
          }

          $formatted[$group_id]['attributes'] =  $attrubutes ;
        }

        $formatted[$group_id]['items'][$item_id]  = $cart_item;
      }
    }

    $this->items = $formatted;
  }


  /**
  * returns formatted data
  */
  public function get_items(){
    return $this->items;
  }


  public function get_item($item_id){
    return $this->items[$item_id];
  }


  public function get_related_cart_items($item_id){
    $item = $this->items[$item_id];
    return array_keys($item['items']);
  }


  public function get_items_count(){
    return count($this->items);
  }


  public function get_cart_mini(){
    return $this->get_cart_mini_data();
  }


  public function get_cart(){
    return $this->get_cart_data();
  }


  public function has_discount(){

  }

  public function get_addons(){
    $priority_delivery_product_id = (int)get_option('wfp_priority_delivery_product_id');
    $return_product_id = (int)get_option('wfp_return_product_id');

    $addons = [
      'return' => [],
      'delivery' => [],
      'all'      =>[],
    ];

    $keys_return_products = [];

    $cart = wc()->cart->get_cart();

    // detect current type of delivery
    foreach ( $cart  as $item_id => $cart_item) {
       //get keys of cart items with delivery products
       if($cart_item['product_id']=== $priority_delivery_product_id){
         $addons['delivery'][] = $cart_item;
         $addons['all'][] = $cart_item;
       }

       //get keys of cart items with return products
       if($cart_item['product_id']=== $return_product_id){
         $addons['return'][] = $cart_item;
         $addons['all'][] = $cart_item;
       }
    }

   return $addons;

  }

  public function get_addons_total(){
    $total = 0;
    $addons = $this->get_addons();

    foreach ($addons['all'] as $key => $item) {
      $total += $item['line_total'];
    }

    return $total;
  }

  /**
  * formats data for cart mini
  */
  protected function get_cart_mini_data(){
    $return = array();

    foreach ($this->items as $item_id => $item) {
      $product = wc_get_product($item['product_id']);
      $return[$item_id] = array(
        'name'  => $product->get_title(),
        'price' => $this->get_item_price( $item ),
        'count_items' => count($item['items']),
        'count_images' => $this->get_image_count( $item , $product ),
      );
    }

    return $return;
  }

  public function get_item_html($item_id){
    $helper = $this->get_cart();
    $item = $helper[$item_id];

    $html = sprintf('<div class="order-summary__item" id="%1$s"> <div class="row"> <div class="col-7"> <span class="order-summary__item-title">%2$s</span> </div> <div class="col-5 textright"><span class="order-summary__item-price">%3$s</span></div> </div><div class="row"> <div class="col-9"> <span class="order-summary__item-detail"> <svg class="icon svg-icon-box"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-box"></use> </svg> %4$s %5$s </span> <span class="order-summary__item-detail"> <svg class="icon svg-icon-items"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-items"></use> </svg> %6$s %7$s </span> </div> <div class="col-3 textright"> <a href="javascript:void(0)" class="order-summary__item-edit" onclick="edit_cart_product(\'%1$s\')">Edit</a> <a href="javascript:void(0)" onclick="remove_product_from_cart(\'%1$s\', this)" class="order-summary__item-remove">×</a> </div> </div> <div class="clearfix"> <svg class="icon svg-icon-size"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-size"></use> </svg> <span class="order-summary__item-detail"> %8$s </span> </div> <div class="clearfix"> <svg class="icon svg-icon-pen"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-pen"></use> </svg> <span class="order-summary__item-detail"> %9$s </span> </div> </div>',
      $item_id,
      $item['name'],
      wc_price($item['price']['line_total']),
      $item['count_items'],
      $item['count_items'] === 1? 'Product': 'Products',
      $item['count_images'],
      $item['count_images'] === 1? 'Photo': 'Photos',
      implode(', ',$item['sizes']),
      $item['comment']
    );

    return $html;
  }


  protected function get_cart_data(){
    $return = array();

    foreach ($this->items as $item_id => $item) {
      $product = wc_get_product($item['product_id']);
      $return[$item_id] = array(
        'name'         => $product->get_title(),
        'price'        => $this->get_item_price( $item ),
        'count_items'  => count($item['items']),
        'count_images' => $this->get_image_count( $item , $product ),
        'sizes'        => $this->get_sizes( $item , $product ),
        'comment'      => $this->get_get_comment( $item , $product ),
      );
    }

    return $return;
  }

  /**
  * get selected sizes of an item
  */
  protected function get_get_comment($item , $product ){
    $sizes = array();

    foreach ($item['items'] as $_i) {
      if(isset($_i['extra_data'])){
        $comment = trim($_i['extra_data']['comment']['value']);
        return $comment;
      }else{
        return '';
      }
    }
  }
  /**
  * get selected sizes of an item
  */
  protected function get_sizes($item , $product ){
    $sizes = array();

    foreach ($item['items'] as $_i) {
      if(isset($_i['extra_data'])){
        return $_i['extra_data']['sizes']['value'];
      }else{
        return '';
      }
    }
  }

   /**
   * get line total subtotal and tax
   */
  protected function get_item_price($item){
    $return = array(
      'line_subtotal_tax' => 0,
      'line_subtotal' => 0,
      'line_total' => 0,
      'line_tax' => 0,
    );

    foreach ($item['items'] as $_i) {
      $return['line_subtotal_tax'] +=  $_i['line_subtotal_tax'];
      $return['line_subtotal']     +=  $_i['line_subtotal'];
      $return['line_total']        +=  $_i['line_total'];
      $return['line_tax']          +=  $_i['line_tax'];
    }
    return $return;
  }


  protected function get_image_count($item, $product){
    $count = 1;
    $meta = get_post_meta($item['product_id'], '_items_count', true);
    if($meta){
      $count = 0;
      foreach ($item['items'] as $key => $_item) {
        $count += (int)$meta[$_item['variation_id']];
      }
    }
    return $count;
  }
}


if(!function_exists('print_estimates')){
  /**
  * prints html block with count down of estimated delivery.
  *
  * @param $is_priority - bool, defines a type of delivery priority or regular
  *
  * @return void
  */
  function print_estimates($is_priority = false){
    $days_offset = get_ready_date_offset($is_priority);
    $ready_date  = date('d F Y', strtotime($days_offset));

    $ready_date_full  = date('Y-m-d 00:00:00', strtotime($days_offset));

    $right_now       = new DateTime();
    $current_hours   = (int)$right_now->format('H');
    $current_minutes = (int)$right_now->format('i');
    $left_hours      = ($current_hours < 16 )? 16 - $current_hours : 40 - $current_hours;
    $left_hours      = ($current_minutes > 0) ? $left_hours - 1 : $left_hours;
    $left_minutes    = ($current_minutes == 0 )? 0 : 60 - $current_minutes;

    $args = array(
      'days_offset' => get_ready_date_offset($is_priority, 'js'),
      'ready_date'      => date('d F Y', strtotime($days_offset)),
      'ready_date_full' => date('Y-m-d 00:00:00', strtotime($days_offset)),
      'current_hours'   => (int)$right_now->format('H'),
      'current_minutes' => (int)$right_now->format('i'),
      'left_hours'      => ($current_hours < 16 )? 16 - $current_hours : 40 - $current_hours,
      'left_hours'      => ($current_minutes > 0) ? $left_hours - 1 : $left_hours,
      'left_minutes'    => ($current_minutes == 0 )? 0 : 60 - $current_minutes,
    );

    print_theme_template_part('delivery-estimates', 'woocommerce', $args);
  }
}


if(!function_exists('get_estimates')){

  /**
  * Return a strig with date of estimated delivery
  *
  * @param $is_priority - bool, defines a type of delivery priority or regular
  * @param $format - string, date format  *
  *
  * @return string
  */
  function get_estimates($is_priority = false, $format = 'd F Y'){
    $days_offset = get_ready_date_offset($is_priority);
    $ready_date  = date($format, strtotime($days_offset));
    return $ready_date;
  }
}

function woocommerce_get_price_discounted( $price, $product ) {

  $_price = $product->get_price();

  if ( WC()->cart->has_discount() ) {

    $values = array (
      'data'    => $product,
      'quantity'  => 1
    );

    $coupons = WC()->cart->get_coupons();

    $undiscounted_price = $_price;

    if ( ! empty( $coupons ) ) {

      foreach ( $coupons as $code => $coupon ) {

        if ( $coupon->is_valid() && ( $coupon->is_valid_for_product( $product, $values ) || $coupon->is_valid_for_cart() ) ) {
          $discount_amount = $coupon->get_discount_amount( 'yes' === get_option( 'woocommerce_calc_discounts_sequentially', 'no' ) ? $_price : $undiscounted_price, $values, true );
          $discount_amount = min( $_price, $discount_amount );
          $_price          = max( $_price - $discount_amount, 0 );
        }

        if ( 0 >= $_price ) {
          break;
        }
      }
      if ( ( $product->get_price() > 0 ) && ( $undiscounted_price !== $_price ) )
        $price = wc_format_sale_price( wc_get_price_to_display( $product, array( 'price' => $undiscounted_price ) ), $_price ) . $product->get_price_suffix();
    }

  }

  return $_price;
}

function get_formatted_order_items($order_items){
  /*
    prepare formatted items variable
  */

  $formatted = array();

  foreach ( $order_items as $item_id => $item ):

    $extra_data      = $item->get_meta('extra_data');
    $group_id_may_be = $item->get_meta('group_id');

    $group_id = (is_array($group_id_may_be))? $group_id_may_be[0] : $group_id_may_be;

    $meta    = $item->get_formatted_meta_data();


    if($group_id){

      if (!isset( $formatted[ $group_id ])){
        $formatted[ $group_id ] = array(
          'items' => array(),
        );
      }

     $formatted[ $group_id ]['images'] = isset($formatted[ $group_id ]['images'])? $formatted[ $group_id ]['images']: 0;

     $product = wc_get_product($item->get_product_id());

     if($product){
       $formatted[ $group_id ]['name'] =  $product->get_title();

        $formatted[ $group_id ]['product_id'] = $product->get_id();
     }


      if($extra_data){
        $formatted[ $group_id ]['items'][$item_id]['extra_data'] = $extra_data;

        $formatted[ $group_id ]['comment'] = $extra_data['comment']['value'];
        $formatted[ $group_id ]['sizes'] = $extra_data['sizes']['value'];
      }

      if($meta){
        $formatted[ $group_id ]['items'][$item_id]['meta'] = $meta;

        foreach ($meta as $m) {
          if($m->key == 'pa_number-of-images'){
            $formatted[ $group_id ]['images'] += (int)$m->value;
          }
        }
      }

    }else{
      $group_id = $item_id;

      if (!isset( $formatted[$group_id ])){
        $formatted[ $group_id ] = array(
          'items' => false,
        );
      }

      $product = wc_get_product($item->get_product_id());

      if($product){
       $formatted[ $group_id ]['name'] =  $product->get_title();

        $formatted[ $group_id ]['product_id'] = $product->get_id();
      }
    }

  endforeach;
  return $formatted;
}



function is_only_fasttrack_checkout($return = false){

  $response = false;

  $cart_items = wc()->cart->get_cart();

  $product_fast_id = (int)get_option('wfp_priority_delivery_product_id');

  $key_fast = -1;

  if(count($cart_items ) === 1){
    foreach ($cart_items as $key => $item) {
      $key_fast  = $item['product_id'] === $product_fast_id? $key  :  $key_fast;
    }
  }


  if($return){
    $response = $key_fast != -1 ? true : false;
    return  $response ;
  }
}


function fix_fasstrack_product($checkout){
  $cart_items = wc()->cart->get_cart();
  $product_fast_id = (int)get_option('wfp_priority_delivery_product_id');

  foreach ($cart_items as $key => $item) {
    if($item['product_id'] === $product_fast_id){
      $cart_items = wc()->cart->set_quantity($key , 1);
    }else{
      continue;
    }
  }
}

function is_sample_already_ordered($product_id_check){
  if(!is_user_logged_in()){
    return false;
  }

  $user_id = get_current_user_id();

  $customer_orders = get_posts( array(
    'numberposts' => -1,
    'meta_key'    => '_customer_user',
    'meta_value'  => get_current_user_id(),
    'post_type'   => wc_get_order_types(),
    'post_status' => array_keys( wc_get_order_statuses() ),
    'fields'  => 'ids'
  ) );

  foreach ($customer_orders as $key => $order_id) {
    $order = wc_get_order( $order_id );
    $items = $order->get_items();
    foreach ( $items as $item_id => $item ) {
       $product_id = $item->get_variation_id() ? $item->get_variation_id() : $item->get_product_id();
       if ( $product_id === $product_id_check ) {
           return true;
       }
    }
  }

  return false;
}

if(!function_exists('include_php_from_dir')){

  /**
  * Includes all php files from specified directory
  *
  * @param $path - string
  */
  function include_php_from_dir($path){
    if(is_dir($path)){
      foreach (glob($path.'/*') as $child_name){
        if(is_dir($child_name)){
          include_php_from_dir($child_name);
        }else{
         if(file_exists( $child_name )){
           $ext = pathinfo($child_name, PATHINFO_EXTENSION);
           if($ext === 'php'){
             include_once($child_name);
           }
         }
        }
      }
    }else{
      $ext = pathinfo($path, PATHINFO_EXTENSION);
      if($ext === 'php'){
        include_once($path);
      }
    }
  }
}

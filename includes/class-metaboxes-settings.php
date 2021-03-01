<?php

/**
* Class that adds additional metaboxes and settings to theme
*
* @package theme/settings
*/

class velesh_theme_meta{

  /**
  * default callback
  */
  public function __construct(){
    /* woocommerce product's category*/
    add_action( 'product_cat_edit_form_fields', array($this, 'woo_product_category_meta'), 1);

    add_action( 'category_edit_form_fields', array($this, 'category_meta_image') );

    /* save cutom term actions*/
    add_action( 'edited_product_cat', array($this,'save_taxonomy_custom_fields'));

    /*adds additional settings page to woocommerce*/
    add_action('admin_menu', array($this, 'add_woo_attributes_images'));

    /*adds additional settings page in menu*/
    add_action('admin_menu', array($this,'add_settings_for_theme'));


    add_action('admin_init', array($this,'add_reading_settings'));

    add_action('admin_menu', array($this,'add_option_pricing'));

    add_action('admin_menu', array($this, 'print_metaboxes'));

    /*adds tab to a product custom post*/
    add_action( 'woocommerce_product_write_panel_tabs',  array($this, 'print_product_tab'), 99 );
    add_action( 'woocommerce_product_data_panels', array($this, 'print_product_tab_content'), 99 );

    add_action( 'save_post', array($this, 'save_custom_postdata' ), 98 );

    add_action( 'save_post_product', array($this, 'save_custom_postdata' ), 98 );



    add_action( 'edited_category', array($this, 'save_tax_meta'), 97);

    add_action('woocommerce_variation_options_dimensions', array($this, 'product_options_dimensions_variation'),3 , 3);

  }


    /**
    * adds a volume parametere to a product
    */
    public static function product_options_dimensions_variation($loop, $variation_data, $variation ){
       global $post;
       $item_count = get_post_meta($post->ID, '_items_count', true );

       $item_count = ($item_count)? $item_count : '';
       ?>
       <input type="hidden" name="do_theme_save" value="yes">
       <p class="form-field _weight_field ">
       <label for="_items_count[<?php echo $variation->ID ?>]">Number of photo per item</label>
       <input type="number" class="short regular-text wc_input_decimal" name="_items_count[<?php echo $variation->ID ?>]" id="_items_count[<?php echo $variation->ID ?>]" value="<?php echo isset($item_count[$variation->ID])? $item_count[$variation->ID] : ''; ?>" placeholder="0"> </p>
      <?php
    }


  /**
  * Save additional term meta
  *
  * @param #term_id - integer
  */
  public static function save_tax_meta( $term_id ){
    $data     = array(
      ['name' =>'_thumbnail', 'unique' => true],
    );

    foreach ($data as $_id => $_d) {
      if(isset($_POST[$_d['name']]) && !empty($_POST[$_d['name']])){
        $new_data = $_POST[$_d['name']];

        if(!update_term_meta($term_id, $_d['name'] , $new_data)){
          add_term_meta( $term_id, $_d['name'] , $new_data, $_d['unique'] );
        }
      }else{
        delete_term_meta( $term_id, $_d['name']);
      }
    }
  }


  /**
  * Save additional post meta
  *
  * @param #post_id - integer
  */
  public static function save_custom_postdata($post_id){

    $data     = array(
      ['name' =>'_is_theme_featured', 'unique' => true],
      ['name' =>'_is_free_sample', 'unique' => true],
      ['name' =>'custom_product_ingredients', 'unique' => true],
      ['name' =>'_header_style', 'unique' => true],
      ['name' => '_items_count',  'unique' => true],

    );

    //   echo "<pre>";
    // print_r($_POST);
    //   echo "</pre>";

    // exit();

    foreach ($data as $_id => $_d) {
      if(isset($_POST[$_d['name']]) && !empty($_POST[$_d['name']])){
        $new_data = $_POST[$_d['name']];

        if(!update_post_meta($post_id, $_d['name'] , $new_data)){
          add_post_meta( $post_id, $_d['name'] , $new_data, $_d['unique'] );
        }
      }else{
        delete_post_meta( $post_id, $_d['name']);
      }
    }
  }


  /**
  * adds meta data to post category
  *
  * @param $catecory - WP_Term object
  */
  public static function category_meta_image($category){
      $image_id = get_term_meta($category->term_id, '_thumbnail', true);
      $image = wp_get_attachment_image_src($image_id , 'thumbnail');
    ?>
    <style>
      img{
        max-width: 100%;
      }
    </style>
    <tr class="form-field term-parent-wrap">
      <th scope="row"><label for="parent"><?php _e("Thumbnail", 'theme-translations') ?></label></th>
      <td>
        <div class="image-download" >
          <input type="hidden" class="image-id" name="_thumbnail" value="<?php echo $image_id ?>">
          <div class="image-placeholder" <?php echo 'style="max-width:64px"' ?>onclick="load_image(this)">
            <img src="<?php echo $image[0] ?>" alt="" <?php echo 'style="width: 64px; height: auto"' ?>>
          </div>
          <div class="button-holder">
            <a href="javascript:void(0)" class="button submit-add-to-menu left" onclick="load_image(this)">set image</a> &nbsp;
            <a href="javascript:void(0)" onclick="clear_image(this)">clear image</a>
          </div>
        </div>
        </td>
    </tr>
    <?php
  }


  /**
  * adds content of custom product tab
  */
  public static function print_product_tab_content(){
    global $post;

    $o = get_post_meta($post->ID, 'custom_product_ingredients', true);
    ?>
    <div id="ingredients_feature" class="panel woocommerce_options_panel  wc-metaboxes-wrapper">
      <h4>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Setting for showing ingredients section on single products page</h4>
      <div class="options_group">
        <p class="form-field">

          <label>Section title:</label>
          <input type="text" class="large-text" style=<?php echo'"width:100%" ' ?> name="custom_product_ingredients[title]" value="<?php echo isset($o['title'])? $o['title'] : ''; ?>">
        </p>
        <p class="form-field">

          <label>Section comment:</label>
          <textarea type="text" rows="6" cols="20" class="large-text<?php echo'" style="width:100%; height: 75px"'; ?> name="custom_product_ingredients[comment]"><?php echo isset($o['comment'])? $o['comment'] : ''; ?></textarea>
          <i>Wrap marked text into </i><?php echo esc_html('<b>text</b>'); ?> tag</i>
        </p>
      </div>

      <div class="options_group">
         <p class="form-field">
          <label><span>Ingredients:</span></label>
         </p>
        <div class="ingredients-wrap">
          <?php if (isset($o['items'])): ?>
          <?php foreach ($o['items'] as $key => $item):
            $image = wp_get_attachment_image_src($item['image_id'], 'thumbnail');

            if(!$item['image_id'] || (int)$item['image_id'] < 0){
              continue;
            }
            ?>
         <div class="article-block options_group">
          <div class="article-table2" <?php echo'style="padding:10px"'; ?>'>
            <div class="article-table__image image-download">
              <div class="image-download">
                <input type="hidden" class="image-id" name="custom_product_ingredients[items][<?php echo $key; ?>][image_id]" value="<?php echo $item['image_id'] ?>">
                <div class="image-placeholder" onclick="load_image(this)">
                  <img src="<?php echo $image[0] ?>" alt="">
                </div>
                <div class="button-holder">
                  <a href="javascript:void(0)" class="button submit-add-to-menu left" onclick="load_image(this)">set image</a> &nbsp;
                  <a href="javascript:void(0)" onclick="clear_image(this)">clear image</a>
                </div>
              </div>
            </div>

            <div class="options_group">
              <p class="form-field">
                <label>Title</label>
                <input class="fullwidth" type="text" <?php echo'style="width:100%"'; ?> name="custom_product_ingredients[items][<?php echo $key; ?>][title]" value="<?php echo isset($item['title'])? $item['title']: ''; ?>">
              </p>
              <p class="form-field">
                <label>Comment</label>
                <input class="fullwidth" type="text" <?php echo' style="width:100%"';?>name="custom_product_ingredients[items][<?php echo $key; ?>][comment]" value="<?php echo isset($item['comment'])? $item['comment']: ''; ?>">
              </p>
              <p class="form-field">
               <a href="javascript:void(0)" onclick="remove_banner_block(this)">delete block</a>
              </p>
            </div>

          </div>
        </div>
          <?php endforeach ?>
          <?php endif ?>
        </div>
        <p class="form-field">
          <input type="hidden" id="ingredients-counter" name="custom_product_ingredients[count]" value="<?php echo isset($o['items'])? count($o['items']) : 0; ?>">
          <a href="javascript:void(0)" class="button button-primary" onclick="add_ingreduents(this);">Add Ingredient</a>
        </p>
      </div>

      </div>

    <?php
  }

  /**
  * adds tab to a product custom post
  */
  public static function print_product_tab(){
        ?>
        <li class="ingredients_feature inventory_tab show_if_simple show_if_variable show_if_grouped show_if_external "> <a href="#ingredients_feature"><?php _e('Ingredients', 'theme-translations');
           ?></a></li>
        <?php
  }


  /**
  * Adds metaboxes to posts
  */
  public function print_metaboxes(){

    add_meta_box( 'order_additional_date', __( 'Requested delivery date', 'theme-translations' ), array($this, 'ex_order_additional'), 'shop_order', 'side', 'high' );

    add_meta_box( 'header_style_meta', __( 'Header style', 'theme-translations' ), array($this, 'ex_header_style_meta'), 'page', 'side', 'high' );
  }


  public static function ex_header_style_meta($post){
    $o = get_post_meta($post->ID, '_header_style', true);
    $o = (empty($o))? 'regular' : $o;
    ?>
  <ul>
    <li>
      <input type="radio" name="_header_style" value="contrast" <?php echo ('contrast' === $o)? 'checked="checked"': '' ?>  id="contrast">
      <label for="contrast">Header has absolute position above content, links are white</label>
    </li>
    <li>
      <input type="radio" name="_header_style" value="regular" <?php echo ('regular' === $o)? 'checked="checked"': '' ?> id="regular">
      <label for="regular">Header has relative position above content, links are dark grey</label>
    </li>
  </ul>

    <?php
  }

  /*
  * callback for add meta moc func
  *
  * show order data
  */
  public static function ex_order_additional($post){
    $date1 = get_post_meta($post->ID, '_free_collection_date', true);
    $date2 = get_post_meta($post->ID, '_self_shipping_date', true);

    $active_methods   = array();
    $shipping_methods = WC()->shipping()->get_shipping_methods();
    foreach ( $shipping_methods as $id => $shipping_method ) {
      if ( isset( $shipping_method->enabled ) && 'yes' === $shipping_method->enabled ) {
        $active_methods[ $id ] = array(
          'title'      => $shipping_method->get_method_title(),
          'instance_id' => $shipping_method->get_instance_id() ,
        );
      }
    }
    $order = wc_get_order($post->ID);

    $date = false;

    if($date1 && is_array($date1)){
      foreach ($date1 as $key => $d) {
        $date = (!empty($d))? $d : $date;
      }

      $date1 = $date;
    }

    $date = (!empty($date1))? $date1 : $date2;

    if($date){
      echo date('d F Y', strtotime($date));
    } else{
      _e('Not set', 'theme-translations');
    }
  }


  /**
  * add settings section for a plugin
  *
  * @hooked_to admin_menu 10;
  */
  public function add_settings_for_theme(){
    add_options_page('Theme settings', 'Theme settings', 'manage_options', 'velesh_theme_settings', array($this,'velesh_theme_settings_callback'));

    add_submenu_page( 'woocommerce', __('Currency settings', 'theme-translations'),  __('Currency settings', 'theme-translations'), 'manage_options', 'theme-woo-currency', array($this, 'do_theme_woo_currency'));
  }

  /**
  * adds page to woocommerce for currency settings
  */
  public static function do_theme_woo_currency($option){
    $slug              = 'woo_theme_currency';
    $currencies        = get_woocommerce_currencies();
    $currency_default  = get_woocommerce_currency();

    if(isset($_POST['do_save']) && 'yes' === $_POST['do_save']){
      $o = array(
        'number' => (isset($_POST['number']))? sanitize_text_field($_POST['number']) : 0,
        'items'  => array()
      );

      $items = recursive_sanitize_text_field($_POST['items']);

      foreach ($items as $key => $item) {
        $o['items'][$item['name']] =  array(
          'rate' =>  $item['rate'],
          'symbol' => html_entity_decode(get_woocommerce_currency_symbol($item['name'])),
        );
      }

      if(!update_option( $slug, $o )){
        add_option( $slug, $o);
      }
    }

    $o    = get_option($slug);

    $currencies_array = array();

    foreach ($currencies as $key => $name) {
      $currencies_array[$key] = array(
        'name'  => $name,
        'symbol' =>html_entity_decode(get_woocommerce_currency_symbol($key)),
      );
    }
    ?>
     <h3>Currency Setttings.</h3>
     <br>
     <?php _e("Main currency is "); ?>
     <b> <?php echo  $currencies[$currency_default] ?> </b> (<?php echo   get_woocommerce_currency_symbol() ?>)

   <br>
   <br>
     <div>
      <h4>Additional currencies:</h4>
      <form action="" method="POST">
       <div class="currency-list">
        <table class="cur-tab"><tbody>
          <tr><td><b>Currency Name</b></td><td><b>Cross Rate</b></td><td></td></tr>
         <?php
          $number = 0;
          foreach ($o['items'] as $key => $item):  ?>
          <tr>
            <td>
              <select name="items[<?php echo $number ?>][name]">
              <option value="-1">Select Currency</option>
              <?php foreach ($currencies_array as $id => $c):?>
                <option value="<?php echo $id ?>" <?php echo ($key == $id)? 'selected="selected"': ''; ?>> <?php echo esc_attr($c['name']) ?> (<?php echo $c['symbol'] ?>)</option>
              <?php endforeach ?>
              </select>
            </td>
            <td><input type="text" class="medium-text" value="<?php echo !empty($item['rate'])? $item['rate'] : ''; ?>" name="items[<?php echo $number ?>][rate]"></td>
            <td><a href="javascript:void(0)" onclick="delete_block(this, 'tr')">Delete </a></td>
          </tr>
         <?php
         $number++;
          endforeach ?>
        </tbody></table>
       </div>
       <br><br>
       <a href="javascript:void(0)" class="button" onclick='add_currency()'>Add Currency</a>
       <input type="hidden" id="cur_count" value="<?php echo (isset($o['number']))? esc_attr($o['number']) : 0; ?>" name="number">
       <br><br>
        <input type="submit" value="Save" class="button button-primary">
        <input type="hidden" name="do_save" value="yes">
      </form>
     </div>


    <script>
    jQuery(document).ready(function(){
      jQuery('.currency-list').find('select').select2();
    })

      function add_currency(){
        var number = jQuery('#cur_count').val() || 0;
        var currencies = JSON.parse('<?php echo json_encode($currencies_array)?>');
        var settings = '<option value="{value}">{name} ({symbol})</option>';
        var select   = '<option value="-1">Select Currency</option>';
        var search = {};
        var rate;
        var html;

        for(id in currencies){
          search = {
            value: id,
            name: currencies[id].name,
            symbol: currencies[id].symbol
          };
          select += str_replace(search, settings);
        }

        select = '<select name="items['+number+'][name]" class="medium-text">'+select+'</select>';

        rate  = '<input type="text" class="medium-text" name="items['+number+'][rate]"/>'

        html = '<tr><td>{currency}</td><td>{rate}</td><td><a href="javascript:void(0)" onclick="delete_block(this, \'tr\')">Delete </a></td></tr>';

        search = {
          currency: select,
          rate: rate,
        }

        html = str_replace(search, html);
        number++;
        jQuery('#cur_count').val(number);

        jQuery('.currency-list tbody').append(html);

        jQuery('.currency-list').find('select').select2();
      }
    </script>
    <?php
  }


  /**
   * callback to display settings form
   * @see $this->add_settings_for_theme()
   */
  public function velesh_theme_settings_callback(){
    $slug = 'theme_settings';
    if (isset($_POST['do-save']) && $_POST['do-save'] === 'yes' ) {
      if(isset($_POST[$slug])){
        $test = update_option($slug, ($_POST[$slug]) );
      }else{
        delete_option($slug);
      }

      $slug_opt = 'wfp_priority_delivery_product_id';

      if(isset($_POST[$slug_opt])){
        $test = update_option($slug_opt, ($_POST[$slug_opt]) );
      }else{
        delete_option($slug_opt);
      }

      $slug_opt = 'wfp_return_product_id';

      if(isset($_POST[$slug_opt])){
        $test = update_option($slug_opt, ($_POST[$slug_opt]) );
      }else{
        delete_option($slug_opt);
      }


     echo '<div id="setting-error-settings_updated" class="updated settings-error notice is-dismissible">
      <p><strong>Settings saved.</strong></p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>';
    }
    $o = get_option($slug);

    ?>
    <h3>Theme Settings</h3>
       <form action="" method="post">

        <button class="button button-primary"> Save</button>
        <div class="spacer-h-10"></div>
        <input type="radio" id="prices" checked="checked" name="options" class="duh-hide-check">
        <input type="radio" id="product_types" name="options" class="duh-hide-check">

        <ul class="duh-tabs clearfix">
          <li><label for="prices">Prices</label></li>
          <li><label for="product_types">Product</label></li>
          <li>
          </li>
        </ul>

        <div class="product_types duh-page-settings-content">
          <h4>Product Types Published</h4>
          <textarea name="<?php echo $slug; ?>[product_types][published]" id="" class="fullwidth" rows="10"><?php echo isset($o['product_types']['published'])? $o['product_types']['published'] : '' ?></textarea>
          <div class="clearfix"></div>
          <h4>Product Types Comming Soon</h4>
          <textarea name="<?php echo $slug; ?>[product_types][soon]" id="" class="fullwidth" rows="10"><?php echo isset($o['product_types']['soon'])? $o['product_types']['soon'] : '' ?></textarea>
          <div class="clearfix"></div>
          <i>Place Every product Type on new row</i>
          <div class="spacer-h-10"></div>
          <button class="button button-primary"> Save</button>
        </div>

        <div class="prices duh-page-settings-content">
          <table class="form-table">
            <tbody>
              <tr>
                <th>

                  <label for="<?php echo $slug; ?>[single_product_price]">Single Image Price</label> <br>
                </th>
                <td>
                   <input type="text" class="medium-text" id="<?php echo $slug; ?>[single_product_price]" name="<?php echo $slug; ?>[single_product_price]" value="<?php echo (isset($o['single_product_price']))? esc_attr($o['single_product_price']):''; ?>"> <br>

                    <span class="description">Type only price without currency symbol</span ><br>
                   <br>
                </td>
              </tr>
              <tr>
                <th>

                  <label for="<?php echo $slug; ?>[name]">Single Product Name Price</label> <br>
                </th>
                <td>
                   <input type="text" class="medium-text" id="<?php echo $slug; ?>[name]" name="<?php echo $slug; ?>[name]" value="<?php echo (isset($o['name']))? esc_attr($o['name']):''; ?>"> <br>

                    <span class="description">Type only price without currency symbol</span ><br>
                   <br>
                </td>
              </tr>
              <tr>
                <th>

                  <label for="<?php echo $slug; ?>[sizes]">Size Price</label> <br>
                </th>
                <td>
                   <input type="text" class="medium-text" id="<?php echo $slug; ?>[sizes]" name="<?php echo $slug; ?>[sizes]" value="<?php echo (isset($o['sizes']))? esc_attr($o['sizes']):''; ?>"> <br>

                    <span class="description">Type only price without currency symbol</span ><br>
                   <br>
                </td>
              </tr>
              <tr>
                <th>

                  <label for="<?php echo $slug; ?>[color]">Color Price</label> <br>
                </th>
                <td>
                   <input type="text" class="medium-text" id="<?php echo $slug; ?>[color]" name="<?php echo $slug; ?>[color]" value="<?php echo (isset($o['color']))? esc_attr($o['color']):''; ?>"> <br>

                    <span class="description">Type only price without currency symbol</span ><br>
                   <br>
                </td>
              </tr>
              <tr>
                <th>

                  <label for="<?php echo $slug; ?>[color]">Custom Shoot Price</label> <br>
                </th>
                <td>
                   <input type="text" class="medium-text" id="<?php echo $slug; ?>[shoot]" name="<?php echo $slug; ?>[shoot]" value="<?php echo (isset($o['shoot']))? esc_attr($o['shoot']):''; ?>"> <br>
                    <span class="description">Type only price without currency symbol</span ><br>
                   <br>
                </td>
              </tr>
              <?php if (class_exists('YWSBS_Subscription')): ?>
              <tr>
                <th>
                  Use this subscription as main for site
                </th>
                <td>
                  <select name="<?php echo $slug; ?>[subscription]" id="<?php echo $slug; ?>[subsciption]">

                    <option value="-1">---Select a subscription ---</option>
                  <?php
                    $subscriptions = get_all_subscriptions();
                    foreach ($subscriptions as $key => $s) {
                      printf('<option value="%1$s" %2$s>%3$s</option>', $s->ID, ( $o['subscription'] == $s->ID)? 'selected="selected"' : '' , $s->post_title);
                    }
                   ?>
                  </select>
                </td>
              </tr>

              <tr>
                <th>
                  Url for details about premium plan
                </th>
                <td>
                  <input type="text" class="large-text" id="<?php echo $slug; ?>[about_subscription]" name="<?php echo $slug; ?>[about_subscription]" value="<?php echo (isset($o['about_subscription']))? esc_url($o['about_subscription']):''; ?>">
                </td>
              </tr>
              <?php endif ?>
              <tr>
                <th>A product for a priority delivery</th>
                <td>
                  <select name="wfp_priority_delivery_product_id">
                    <option value="-1">--- select a product ---</option>
                    <?php
                      $product_id = (int)get_option('wfp_priority_delivery_product_id');
                      foreach (wc_get_products(array('limit'=>-1, 'posts_per_page'=>-1)) as $key => $p) {
                        printf('<option value="%s" %s >%s</option>', $p->get_id(), ( $p->get_id()===$product_id )? 'selected="selected"': '', esc_attr($p->get_title()));
                      }
                     ?>
                  </select> <br><br>

                  <i>Will not be displayed in products' list, <br>used to add a priority delivery to a cart</i>
                </td>
              </tr>

              <tr>
                <th>Select a product for "Return products"</th>
                <td>
                  <select name="wfp_return_product_id">
                    <option value="-1">--- select a product ---</option>
                    <?php
                      $product_id = (int)get_option('wfp_return_product_id');
                      foreach (wc_get_products(array('limit'=>-1, 'posts_per_page'=>-1)) as $key => $p) {
                        printf('<option value="%s" %s >%s</option>', $p->get_id(), ( $p->get_id()===$product_id )? 'selected="selected"': '', esc_attr($p->get_title()));
                      }
                     ?>
                  </select> <br><br>
                  <i>Will not be displayed in products' list,<br> used to add an option for returning products</i>
                </td>
              </tr>

              <tr>
                <th></th>
                <td>
                  <button class="button button-primary"> Save</button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <input type="hidden" name="do-save" value="yes">
       </form>

    <?php
  }


  /**
  * Adds additional setting to woocommerce product's category
   *
   * @hookedto product_cat_edit_form_fields 10
   *
   * @param $category - WP_term object
   */
  public static function woo_product_category_meta($category){
    $display_title        = get_term_meta($category->term_id, '_display_title', true);
    $display_title_marked = get_term_meta($category->term_id, '_display_title_marked', true);
    ?>
    <tr class="form-field">
      <th scope="row" valign="top">
        <?php _e('Display title for product category page', 'theme-translations') ?>
      </th>
      <td>
        <input type="text" name="_display_title" id="_display_title" value="<?php echo esc_attr($display_title) ?>">
        <i class="description">
          <?php _e('Leave this field blank to use category name instead', 'theme-translations'); ?>
        </i>
      </td>
    </tr>
    <tr class="form-field">
      <th scope="row" valign="top">
        <?php _e('Marked part of display title', 'theme-translations') ?>
      </th>
      <td>
        <input type="text" name="_display_title_marked" id="_display_title_marked" value="<?php echo esc_attr($display_title_marked) ?>">
        <i class="description">
          <?php _e('This text should be exactly the same as a part from a display title you want to mark, including letter capitalization. Previous field should contain some text', 'theme-translations'); ?>
        </i>
      </td>
    </tr>
    <?php
  }


  /**
   * Saves custom taxonomies' data
   *
   * @hookedto edited_product_cat 10
   *
   * @param $term_id - integer
   */
  public static function save_taxonomy_custom_fields( $term_id ) {
    $settings = array(
      '_display_title'         => 'text',
      '_display_title_marked'  => 'text',
    );

    foreach ($settings as $s => $type):
      if ( isset( $_POST[$s] ) ) :
        $value = $_POST[$s];
        switch ($type) {
          case 'url':
            # code...
            break;

          default:
           $value = sanitize_text_field($value);
            break;
        }
        update_term_meta( $term_id ,$s, $value);
      else:
        delete_term_meta($term_id ,$s);
      endif;
    endforeach;
  }


  /**
   * adds a seetings sub page to a woocommerce admin page.
   *
   * @hookedto admin_menu -10
   */
  public static function add_woo_attributes_images(){
    // add_submenu_page( 'edit.php?post_type=product',  __('Attributes data', 'theme-translations'), __('Attributes data', 'theme-translations'), 'manage_options', 'theme_attributes_images', array('velesh_theme_meta', 'print_woo_attributes_images_form'));

    add_submenu_page( 'edit.php?post_type=product',  __('Global Features', 'theme-translations'), __('Global Features', 'theme-translations'), 'manage_options', 'product_global_features', array('velesh_theme_meta', 'print_product_global_features'));
  }

  public static function print_product_global_features(){
    $slug="product_global_blocks";
    if(isset($_POST['do_save'])){
      update_option($slug, $_POST[$slug]);
    }
    $option = get_option($slug);

    ?>

    <form action="<?php echo admin_url('edit.php?post_type=product&page=product_global_features')?>" method="POST">

      <input type="radio" id="customize_and_create" name="option" checked class="duh-hide-check">
      <input type="radio" id="good_2_know" name="option" class="duh-hide-check">
      <input type="radio" id="show_bespoke" name="option" class="duh-hide-check">

      <ul class="duh-tabs">
        <li>
        <label for="customize_and_create">Customize and Create</label></li>
        <li> <label for="good_2_know">Good to Know</label></li>
         <li><label for="show_bespoke">100% BESPOKE</label></li>
      </ul>

      <div class="duh-page-settings-content customize_and_create">
        <h3>Customize and Create items</h3>

        <div class="spacer-h-20"></div>

        <?php
          for ($i=0; $i < 4; $i++) {

            printf('<h4>Item #%s</h4>', $i);

            echo "<h4>Title</h4>";

            printf('<input name="%s[customize_and_create][%s][title]" value="%s" class="fullwidth">', $slug, $i, isset($option['customize_and_create'][$i]['title'])? $option['customize_and_create'][$i]['title'] : '' );

            echo "<h4>Text</h4>";

             printf('<textarea name="%s[customize_and_create][%s][text]" rows="6" class="fullwidth">%s</textarea>', $slug, $i, isset($option['customize_and_create'][$i]['text'])? stripslashes($option['customize_and_create'][$i]['text'] ): '' );

          }

          ?>
      </div>

      <div class="duh-page-settings-content good_2_know">
        <h3>Good to Know</h3>

        <div class="spacer-h-20"></div>

        <?php
          for ($i=0; $i < 4; $i++) {

            printf('<h4>Item #%s</h4>', $i);

            echo "<h4>Title</h4>";

            printf('<input name="%s[good_2_know][%s][title]" value="%s" class="fullwidth">', $slug, $i, isset($option['good_2_know'][$i]['title'])? $option['good_2_know'][$i]['title'] : '' );

            echo "<h4>Text</h4>";

             printf('<textarea name="%s[good_2_know][%s][text]" rows="6" class="fullwidth">%s</textarea>', $slug, $i, isset($option['good_2_know'][$i]['text'])?stripslashes($option['good_2_know'][$i]['text']) : '' );
          }

          ?>
      </div>

      <div class="duh-page-settings-content show_bespoke">
        <h3>100% BESPOKE</h3>
        <h4>Title</h4>

        <input type="text" class="fullwidth" name="<?php echo $slug?>[bespoke][title]" value="<?php echo isset( $option['bespoke']['title'])? $option['bespoke']['title'] : ''; ?>">

        <h4>Text</h4>

        <textarea name="<?php echo $slug?>[bespoke][text]" id="" class="fullwidth" rows="6"><?php echo isset( $option['bespoke']['text'])? $option['bespoke']['title'] : ''; ?></textarea>

      </div>


      <input type="hidden" name="do_save" value="yes">
      <input type="submit" value="save" class="button">
    </form>

    <?php
  }


  /**
   * callback to display settings form
   * @see $this->add_woo_attributes_images()
   */
  public static function print_woo_attributes_images_form(){
    $option_name = 'theme_attributes_images';

    if (isset($_POST['do-save'])) {
      if(isset($_POST[$option_name])){
        $test = update_option($option_name, recursive_sanitize_text_field($_POST[$option_name]) );
      }else{
        delete_option($option_name);
      }
     echo '<div id="setting-error-settings_updated" class="updated settings-error notice is-dismissible">
      <p><strong>Settings saved.</strong></p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>';
    }
    printf('<h3>%s</h3>', __('Attributes Data', 'theme-translations'));
    $o           = get_option($option_name);
    $attributes  = wc_get_attribute_taxonomies();
    ?>
    <form action="" method="POST">
      <style>
      .image-placeholder{
        width: 64px;
        height: 64px;
        overflow: hidden;
      }
      .image-placeholder img{
        width: 100%;
        height: auto;
      }
      .trigger-show{
        display: none;
      }

      .rad-img:checked ~ .rad-img,
      .rad-icon:checked ~ .rad-icon{
        display: block;
      }
      </style>

      <ol>
      <?php foreach ($attributes as $key => $attr):
        $name = 'attribute_pa_'.$attr->attribute_name;
        $image_id  = (int)$o[$name]['icon_id'];
        $image_url = wp_get_attachment_image_url($image_id, 'thumbnail');
        $image_url = ($image_url)? $image_url: DUMMY_URL;
        ?>
         <li>
          <h3><?php _e('Attribute', 'theme-translation') ?>: <b><?php echo $attr->attribute_name; ?></b> <br></h3>
          <b><?php _e('Icon type', 'theme-translation') ?>:</b> <br>

          <input type="radio" name="theme_attributes_images[attribute_pa_<?php echo $attr->attribute_name ?>][type]" id="theme_attributes_images[attribute_pa_<?php echo $attr->attribute_name ?>][type_img]" value="image" class="rad-img" <?php echo (isset($o[$name]['type']) && $o[$name]['type'] === 'image')? 'checked="checked"' : ''; ?>>

          <label for="theme_attributes_images[attribute_pa_<?php echo $attr->attribute_name ?>][type_img]"><?php _e('Image', 'theme-translation') ?></label>


          <input type="radio" name="theme_attributes_images[attribute_pa_<?php echo $attr->attribute_name ?>][type]" id="theme_attributes_images[attribute_pa_<?php echo $attr->attribute_name ?>]['type_icon']" value="icon" class="rad-icon" <?php echo (isset($o[$name]['type']) && $o[$name]['type'] === 'icon')? 'checked="checked"' : ''; ?>>

          <label for="theme_attributes_images[attribute_pa_<?php echo $attr->attribute_name ?>]['type_icon']"><?php _e('Icon', 'theme-translation') ?></label> <br>

          <div class="image-download rad-img trigger-show">
            <div class="image-placeholder">
              <img src="<?php echo $image_url ?>" alt="">
            </div>
            <input type="hidden" class="image-id" name="theme_attributes_images[attribute_pa_<?php echo $attr->attribute_name ?>][icon_id]" value="<?php echo (isset($o[$name]['icon_id']))? $o[$name]['icon_id'] : ''; ?>"><br>
            <a href="javascript:void(0)" class="button" onclick="load_image(jQuery(this))">Load Image</a>
          </div>

          <div class="rad-icon trigger-show">
            <br>
            <label><input type="radio" <?php echo 'style="vertical-align: -2px"'; ?> name="theme_attributes_images[attribute_pa_<?php echo $attr->attribute_name ?>][icon]" value="layout" <?php echo (isset($o[$name]['icon']) && $o[$name]['icon'] === 'layout')? 'checked="checked"' : ''; ?>><img src="<?php echo THEME_URL.'/images/admin/layout.svg'?>" alt=""></label><br>

            <label><input type="radio" <?php echo 'style="vertical-align: -2px"';?>  name="theme_attributes_images[attribute_pa_<?php echo $attr->attribute_name ?>][icon]" value="items" <?php echo (isset($o[$name]['icon']) && $o[$name]['icon'] === 'items')? 'checked="checked"' : ''; ?>><img src="<?php echo THEME_URL.'/images/admin/items.svg'?>" alt=""></label>

          </div>

          <div class="clearfix">
            <h4>Attribute Additional data</h4>
            <label><input type="checkbox" name="theme_attributes_images[attribute_pa_<?php echo $attr->attribute_name ?>][show_additional_data]" value="yes" <?php echo (isset($o[$name]['show_additional_data']) && $o[$name]['show_additional_data'] === 'yes')? 'checked="checked"': ''; ?> > Show attribute comment</label>

            <h4>Label:</h4>
            <input type="text" class="large-text" value="<?php echo (isset($o[$name]['additional_data_label']))? $o[$name]['additional_data_label'] : ''; ?>" name="theme_attributes_images[attribute_pa_<?php echo $attr->attribute_name ?>][additional_data_label]">
            <h4>Text</h4>

            <?php
              $editor_options = array(
                'wpautop'       => 1,
                'media_buttons' => 1,
                'textarea_name' =>  sprintf('theme_attributes_images[attribute_pa_%s][additional_data]',$attr->attribute_name ),
                'textarea_rows' => 7,
                'tabindex'      => null,
                'editor_css'    => '',
                'editor_class'  => 'fullwidth',
                'teeny'         => 0,
                'dfw'           => 1,
                'tinymce'       => 1,
                'quicktags'     => 1,
              );
              $text = (isset($o[$name]['additional_data']))? $o[$name]['additional_data'] : '';

              wp_editor($text, sprintf('attribute_pa_%s_additional_data',$attr->attribute_name ), $editor_options );

              $taxonomy_name = (stripos('pa_', $attr->attribute_name) !== false) ? $attr->attribute_name : sprintf('pa_%s',$attr->attribute_name );

              $terms = get_terms(  $taxonomy_name,  array(
                'hide_empty' => false,
              ) );

              echo ('<h4>Attributes values:</h4>');


              echo '<div style="padding: 0 30px">';

              foreach ($terms as $key => $term) {
                printf('<h4>%s</h4>', $term->name);
                printf('<label><input type="checkbox" name="theme_attributes_images[attribute_pa_%s][terms][%s][is_popular]" value="yes" %s>Is popular</label><br><br>', $attr->attribute_name, $term->slug, (isset($o[$name]['terms'][$term->slug]['is_popular']) && 'yes' === $o[$name]['terms'][$term->slug]['is_popular'])? 'checked="checked"' : '');
                echo  'comment: <br>';
                printf('<input type="text" class="medium-text" style="width: 400px" name="theme_attributes_images[attribute_pa_%s][terms][%s][comment]" value="%s"> ',$attr->attribute_name, $term->slug, isset($o[$name]['terms'][$term->slug]['comment'])? $o[$name]['terms'][$term->slug]['comment']: '');

                echo  '<br><br>image:';
                ?>
                <br><br>
                  <div class="image-download">
                    <div class="image-download">
                      <input type="hidden" class="image-id" name="<?php printf('theme_attributes_images[attribute_pa_%s][terms][%s][image_id]', $attr->attribute_name, $term->slug);?>" value="<?php echo isset($o[$name]['terms'][$term->slug]['image_id'])? $o[$name]['terms'][$term->slug]['image_id']: -1 ?>">

                      <?php
                      $image =(isset($o[$name]['terms'][$term->slug]['image_id']))?  wp_get_attachment_image_src($o[$name]['terms'][$term->slug]['image_id'] ,'thumbnail'): DUMMY;

                      $image = (DUMMY === $image)? $image: $image[0];
                      ?>
                      <div class="image-placeholder" onclick="load_image(this)">
                        <img src="<?php echo $image ?>" alt="">
                      </div>
                      <div class="button-holder">
                        <a href="javascript:void(0)" class="button submit-add-to-menu left" onclick="load_image(this)">set image</a> &nbsp;
                        <a href="javascript:void(0)" onclick="clear_image(this)">clear image</a>
                      </div>
                    </div>
                  </div>
                  <br>
                  <br>
                  <br>
                <?php
              }
              echo '</div>';

            ?>
          </div>
         </li>
      <?php endforeach ?>
      </ol>

      <input type="hidden" value="y" name="do-save">
      <input type="submit" value="Save Options" class="button-primary">
    </form>

    <?php
  }


  /**
  * adds options to reading sections
  * allow admin to define special pages
  */
  public static function add_option_pricing(){
    $options = array(
      'pricing' => __('Pricing', 'theme-translations'),
      'showcase' => __('Showcase', 'theme-translations'),
      'support'  => __('Support', 'theme-translations'),
      'customers'  => __('Customers', 'theme-translations'),
      'constructor'  => __('Constructor', 'theme-translations'),
      'product_guid'  => __('Product Guidelines', 'theme-translations'),
      'redo_policy'  => __('Redo Policy', 'theme-translations'),
    );

    foreach ($options as $key => $name) {
      $option_name = 'theme_page_'.$key;
      register_setting( 'reading', $option_name );

      add_settings_field(
       'theme_setting_'.$key,
        $name,
        array('velesh_theme_meta', 'page_select_callback'),
        'reading',
        'theme-pages-section',

        array(
          'id' => 'theme_setting_'.$key,
          'option_name' => $option_name,
        )
      );
    }
  }


  /**
  * adds additional settings section
  */
  public function add_reading_settings(){
    add_settings_section('theme-pages-section', __('Theme page settings', 'theme-translations '), array($this, 'add_additional_page_settings'), 'reading');
  }


  /**
  * callback for settings section
  *
  * @data - array;
  *
  * @see $this->add_reading_settings()
  */
  public function add_additional_page_settings($data){
    // echo '<h3>Theme settings</h3>';
  }

  /**
   * callback to display a select option for page select
   *
   * @param $val - arrray
   *
   * @see $this->add_reading_settings()
   */
  static function page_select_callback( $val ){
    $id = $val['id'];
    $option_name = $val['option_name'];
    $args = array(
      'posts_per_page' => -1,
      'limit'          => -1,
    );
    $pages = get_pages($args);
    echo ' <select name="'.$option_name .'">';
    echo '<option value="-1">— Select —</option>';

    foreach ($pages  as $id => $page) {
      $selected = (esc_attr( get_option($option_name) ) == $page->ID )? 'selected = "selected"' : '';
      ?>
        <option <?php echo $selected; ?> value="<?php echo $page->ID ?>"> <?php echo $page->post_title; ?></option>
      <?php
    }
    echo '</select>';
  }
}


new velesh_theme_meta();





add_action( 'woocommerce_product_options_general_product_data', 'product_valid_period_field', 99 );


function product_valid_period_field($post){
  ?>
  <div class="options_group">

    <?php
      global $post;
      $meta   = get_post_meta($post->ID, '_is_theme_featured', true);
      $meta2   = get_post_meta($post->ID, '_is_free_sample', true);
     ?>
     <p class="form-field _show_zoom">
      <label for="_is_theme_featured">
          Product is Featured
      </label>

       <input type="checkbox" name="_is_theme_featured" id="_is_theme_featured" <?php echo ($meta == 'yes')? 'checked="checked"' : '' ; ?> value="yes" placeholder="">
      &nbsp;
     </p>
     <p class="form-field _show_zoom">
      <label for="_is_free_sample">
          Product is a Free Sample
      </label>

       <input type="checkbox" name="_is_free_sample" id="_is_free_sample" <?php echo ($meta2 == 'yes')? 'checked="checked"' : '' ; ?> value="yes" placeholder="">
      &nbsp;
     </p>
  </div>
  <?php
}




<?php
/**
  * Main theme class
  *
  * Inits all hooks, defines theme parameters
  *
  * @author: Kuleshov Vyacheslav
  *
  * @autho-URI: https://www.upwork.com/fl/viacheslavkuleshov
  *
  * @package theme
  *
  * @since v1.0
  */
class velesh_init_theme{

  /* main style location  */
  public $main_style = '/css/main.min.css';

  public $font = '/fonts/font.dev10.css';

  public $main_style_slug = 'theme-main-style-dev40';


  /* main script location  */
  public $main_script= '/script/main.js';

  public $main_script_slug = 'theme-main-script-dev11';


  /**
   * theme init defauls action
   */
  public function __construct(){

    $this->define_theme_globals();
    $this->define_theme_supports();
    $this->define_image_sizes();
    $this->replace_3rd_party_pugins_hooks();
    $this->remove_actions();
    $this->init_hooks();
    $this->include_global();
    $this->ajax();

    if( $this->is_request( 'frontend' )){
      $this->include_frontend();
      add_action('wp_head', array('theme_construct_page', 'init'));
      add_action('template_redirect', array('tracker_content_constructor', 'init'));
    }

    if( $this->is_request( 'admin' )){
      $this->include_admin();
    }

    if('no' !== get_option( 'woocommerce_cart_redirect_after_add' ) ){
      update_option('woocommerce_cart_redirect_after_add', 'no');
    }
  }


  /**
   * defines theme globals
   */
  public function define_theme_globals(){
    define('THEME_PATH', get_stylesheet_directory());
    define('THEME_URL', get_template_directory_uri());
    define('HOME_URL', get_home_url());
    define('THEME_VERSION', '2.0');
    define('DUMMY_ADMIN', THEME_URL.'/images/admin/blank.png');
    define('PROGRESS', THEME_URL.'/images/admin/progress.gif');
    define('DUMMY', THEME_URL.'/images/admin/blank.png');
    define('DUMMY_S', THEME_URL.'/images/admin/blank_s.png');
    define('THEME_DEBUG', true);
  }


  /**
   * defines theme supports
   */
  public function define_theme_supports(){
    add_theme_support( 'woocommerce' );
    add_theme_support( 'duh' );

    add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'caption' ) );

    add_theme_support( 'post-thumbnails' );

    add_theme_support( 'custom-logo', array(
      'height'      => 70,
      'width'       => 221,
      'flex-height' => true,
      'flex-width'  => true,
      'header-text' => array( 'site-title', 'site-description' ),
    ));
  }


  /**
   * defines image sizes for attachments
   */
  public function define_image_sizes(){
    add_image_size('icon', 96, 96, true);
    add_image_size('icon_md', 112, 112, true);
    add_image_size('product__gallery', 172, 172, true);
    add_image_size('product_thumb_md', 928, 624, true);
    add_image_size('product_thumb_md_lazy_preview', 154, 104, true);
    add_image_size('product_thumb_sm', 596, 396, true);
    add_image_size('product_thumb_sm_lazy_preview', 99, 66, true);
    add_image_size('blog_lg', 970, 420, true);
    add_image_size('blog_lg_lazy_preview', 242, 105, true);
    add_image_size('blog_feed', 470, 284, true);
    add_image_size('blog_feed_lazy', 156, 94, true);
    add_image_size('showcase_thumb', 596, 862, true);
    add_image_size('gallery_1', 518, 688, true);
    add_image_size('gallery_2', 518, 357, true);
    add_image_size('gallery_3', 518, 518, true);
  }



  /**
   * enqueues javascripts and css for the frontend
   *
   * @hookedto - wp_enqueue_scripts 999
   */
  public function enqueue_scripts_styles_front(){

    wp_enqueue_style('select2-style', THEME_URL.'/assets/select2/select2.css' );


    if(theme_construct_page::is_page_type( 'new-styles' )){

      wp_enqueue_style('theme-fancybox', THEME_URL.'/assets/fancybox2/jquery.fancybox.css' );

      wp_enqueue_script('theme-fancybox', THEME_URL.'/assets/fancybox2/jquery.fancybox.js', array('jquery'), THEME_VERSION, true);

      wp_enqueue_style('theme-fancybox-thumbs', THEME_URL.'/assets/fancybox2/helpers/jquery.fancybox-thumbs.css' );

      wp_enqueue_script('theme-fancybox-thumbs', THEME_URL.'/assets/fancybox2/helpers/jquery.fancybox-thumbs.js', array('jquery'), THEME_VERSION, true);

      if(wp_is_mobile()){
        wp_enqueue_style('theme-style-desktop', THEME_URL.'/css/mobile.main.min.css' );


      }else{
        wp_enqueue_style('theme-style-desktop', THEME_URL.'/css/desktop.main.min.css' );
      }

      wp_enqueue_script('velocity-min', THEME_URL.'/assets/velocity/velocity.min.js', array('jquery'), THEME_VERSION, true);

      wp_enqueue_script('masonry-min', THEME_URL.'/assets/masonry/masonry.js', array('jquery'), THEME_VERSION, true);
      wp_enqueue_script('vuejs', THEME_URL.'/assets/vuejs/prod.js', array(), THEME_VERSION, true);

      if(wp_is_mobile()){
        wp_enqueue_script($this->main_script_slug, THEME_URL.'/script/new/mobile.main.min.js', array('jquery'), THEME_VERSION, true);
      }else{
        wp_enqueue_script($this->main_script_slug, THEME_URL.'/script/new/main.min.js', array('jquery'), THEME_VERSION, true);
      }


    }else{

      /*********************************/
      /********* OLD PAGES *************/
      /*********************************/

      wp_enqueue_script('jquery-ui-core');

      wp_enqueue_script('jquery-ui-datepicker');

      wp_enqueue_script('theme-script-fancybox', THEME_URL.'/assets/fancybox/dist/jquery.fancybox.min.js', array('jquery'), THEME_VERSION, true);


      wp_enqueue_script('theme-script-owl', THEME_URL.'/assets/owlcarousel/js/owl.carousel.min.js', array('jquery'), THEME_VERSION, true);

      wp_enqueue_script('theme-script-lazy', THEME_URL.'/assets/lazy/lazy.js', array('jquery'), THEME_VERSION, true);


      wp_enqueue_script('select2-script', THEME_URL.'/assets/select2/select2.js' , array('jquery') );


      wp_enqueue_script($this->main_script_slug, THEME_URL.$this->main_script, array('jquery', 'theme-script-fancybox', 'select2-script'), THEME_VERSION, true);
    }


    unregister_scripts_n_styles();
  }


  /**
   * enqueues javascripts and css for the frontend
   *
   * @hookedto - wp_enqueue_scripts 9999
   */
  public function print_theme_inline_styles(){

    if(theme_construct_page::is_page_type( 'new-styles' )){
      $inline_styles_4_script = array(
        'theme_style_owl'   => THEME_URL.'/assets/owlcarousel/css/owl.carousel.min.css',
        'theme_font_style_4'  => THEME_URL.$this->font,
      );
    }else{
      $inline_styles_4_script = array(
        $this->main_style_slug  => THEME_URL.$this->main_style,
        'theme_style_fancy' => THEME_URL.'/assets/fancybox/dist/jquery.fancybox.min.css',
        'theme_style_owl'   => THEME_URL.'/assets/owlcarousel/css/owl.carousel.min.css',
        'theme_font_style_4'  => THEME_URL.$this->font,
      );
    }

    foreach ($inline_styles_4_script as $name => $url) {
       print_inline_style($url, $name);
    }


  }


  /**
   * enqueues javascripts and css for admin dashboard
   *
   * @hookedto - to admin_enqueue_scripts 5
   */
  public function enqueue_scripts_styles_admin(){

    wp_enqueue_style('select2-style', THEME_URL.'/assets/select2/select2.css' );

    wp_enqueue_script('select2-script', THEME_URL.'/assets/select2/select2.js' , array('jquery') );

     wp_enqueue_style( 'wp-color-picker' );

     wp_enqueue_script( 'wp-color-picker' );

    wp_enqueue_script('theme-script', THEME_URL.'/script/admin.js', array('jquery'), THEME_VERSION, true);

    wp_enqueue_style( 'theme-admin-style', THEME_URL.'/css/admin3.css', THEME_VERSION );

    $settings_pages = array(

    );

    if(isset($_GET['page'])){
      if(in_array($_GET['page'], $settings_pages)){
        wp_enqueue_media();
      }
    }
  }


  public static function ajax(){

  }



  /**
   * adds additional theme files on frontend
   */
  public function include_frontend(){
    global $pagenow;
    include_once(THEME_PATH.'/includes/class-content-output.php');
    include_once(THEME_PATH.'/includes/class-page-constractor.php');
  }



  /**
   * adds additional theme files on admin
   */
  public function include_admin(){
    include_once(THEME_PATH.'/includes/class-metaboxes-settings.php');
    include_once(THEME_PATH.'/includes/class-tiny-mce.php');
  }



  /**
   * adds additional theme files on both sides
   */
  public function include_global(){
    global $pagenow;

    include_once(THEME_PATH.'/includes/helpers.php');

    if($pagenow == 'nav-menus.php'){
      include_once(THEME_PATH.'/includes/class-menu-edit.php');
      $menu_image = new custom_edit_menu_image();
    }
    include_php_from_dir(THEME_PATH.'/includes/');
    include_once(THEME_PATH.'/order_tracker/includes/tracker.php');
    include_php_from_dir(THEME_PATH.'/order_tracker/includes/');
  }



  /**
   * Hooks theme actions
   */
  public function init_hooks(){


    add_action('plugins_loaded', array($this, 'exec_on_plugins_load'));

    // /* js and css hooks for the frontend*/

    add_action('wp_enqueue_scripts',  array($this,'enqueue_scripts_styles_front') , 9991);

    add_action('wp_enqueue_scripts', array($this,'prepare_template_data'),9992);

    add_action('wp_enqueue_scripts', array($this,'inline_custom_data'), 9990);

    add_action('do_theme_after_head', array($this,'print_theme_inline_styles'), 9999);


    add_filter( 'script_loader_tag', array($this,'add_async_attribute'), 10, 2 );

    /* js and css hooks for the admin dashboard*/

    add_action( 'admin_enqueue_scripts', array($this,'enqueue_scripts_styles_admin'), 5 );

    add_action( 'admin_enqueue_scripts', array($this,'inline_custom_data'), 13 );

    /* theme setup actions */

    add_action( 'after_setup_theme', array($this, 'setup_theme') );
    add_filter('upload_mimes', array($this, 'cc_mime_types'), 10);

    add_action( 'widgets_init', array($this, 'register_sidebars' ));


    add_action('finish_page',array($this,'print_inline_data_body'));

    add_action('woocommerce_customer_save_address', array($this, 'woocommerce_customer_save_address'), 9999, 2);

    add_action('woocommerce_save_account_details', array($this, 'woocommerce_save_account_details'), 9999, 2);

    add_action('init',array($this,'add_cors_http_header'));

    add_action('wp_footer',array($this,'print_styles_in_footer'));

    add_action('admin_menu', array($this,'add_settings_for_google_auth'));

    if(THEME_DEBUG){
      add_action('wp_footer', 'exec_clog', PHP_INT_MAX);
      add_action('admin_footer', 'exec_clog', PHP_INT_MAX);
      add_action('end_page', 'exec_clog', PHP_INT_MAX);
    }
  }


    public  function add_settings_for_google_auth(){
      add_options_page('Google-auth-settings', 'Google Authification settings', 'manage_options', 'wfp_settings_google_auth', array($this, 'wfp_settings_google_auth_cb'));

    }


    public function wfp_settings_google_auth_cb(){

      if (isset($_POST['google_auth_user_id'])) {
        update_option('google_auth_user_id' , $_POST['google_auth_user_id']);
      }

      $google_auth_user_id = (get_option('google_auth_user_id'))? get_option('google_auth_user_id'): '';

      ?>
      <form action="" method="post">
        <table class="form-table">
          <tr>
            <th>
              Google client ID
            </th>
            <td>
              <input type="text" class="large-text" name="google_auth_user_id" value="<?php echo $google_auth_user_id ?>">
            </td>
          </tr>

          <tr>
            <th></th>
            <td>
              <button class="button button-primary"> Save</button>
            </td>
          </tr>
        </table>
      </form>
      <?php
    }



  /**
   * puts styles and fonts to local storage
   *
   * @hookedto - wp_enqueue_scripts 9997
   */
  public function inline_custom_data(){}


  /**
   * prepares and prints variable data for javascripts
   *
   * @prints-for-js $wc_urls - {WP_URLS}
   * @prints-for-js $user_data - {USER_DATA}
   */
  public function prepare_template_data(){
    $wc_urls = array(
      'home_url'    => HOME_URL,
      'theme_url'   => THEME_URL,
      'wp_ajax_url' => admin_url('admin-ajax.php'),
      'wc_ajax_url' => HOME_URL. '/?wc-ajax=%%endpoint%%',
    );

    if(get_option('woocommerce_default_country')){

      wp_localize_script($this->main_script_slug,'theme_default_country', get_option('woocommerce_default_country'));
    }else{
      wp_localize_script($this->main_script_slug,'theme_default_country', -1);
    }

    wp_localize_script($this->main_script_slug,'WP_URLS', $wc_urls);

    $user_data = array(
      'user_id' => (get_current_user_id() > 0)? get_current_user_id() : 'visitor',
    );

    wp_localize_script($this->main_script_slug,'USER_DATA', $user_data);


    $currencies = get_woocommerce_currencies();

    $res = array();

    foreach ($currencies as $key => $c) {
      $symbol = get_woocommerce_currency_symbol($key);
      $res[] = html_entity_decode ($symbol);
    }

    $res = array_unique($res);

    wp_localize_script($this->main_script_slug,'theme_currency', $res);

    $o = get_option('woo_theme_currency');

    if(!$o){
      $o['current_currency'] = get_woocommerce_currency();
    }

    if(!isset($o['items'])){
      $o['items'] = array();
    }

    wp_localize_script($this->main_script_slug,'theme_currency_options', $o['items']);
  }


  /**
   * prints inline data in body
   */
  public function print_inline_data_body(){
    if(theme_construct_page::is_page_type( 'new-styles' )){
      add_svg_sprite('theme_sprite_svg_133_new',THEME_URL.'/svg_sprite/new/symbol_sprite.html');
    }else{
      add_svg_sprite('theme_sprite_svg_133',THEME_URL.'/svg_sprite/symbol_sprite.html');
    }
  }


  /**
   * prepares and prints variable data for javascripts
   *
   * @prints-for-js $wc_urls - {WP_URLS}
   * @prints-for-js $user_data - {USER_DATA}
   */
  public function register_sidebars(){

    register_sidebar( array(
      'name'          => __('Home page after content', 'theme-translations'),
      'id'            => 'home_page_after_content',
      'before_widget' => '',
      'after_widget'  => '',
      'before_title'  => '<h3 class="hidden">',
      'after_title'   => '</h3>',
    ));

    register_sidebar( array(
      'name'          => __('Blog before articles list', 'theme-translations'),
      'id'            => 'theme_blog_featured',
      'before_widget' => '',
      'after_widget'  => '',
      'before_title'  => '<h3 class="hidden">',
      'after_title'   => '</h3>',
    ));

    register_sidebar( array(
      'name'          => __('Customers Page Widget', 'theme-translations'),
      'id'            => 'theme_customers_page',
      'before_widget' => '',
      'after_widget'  => '',
      'before_title'  => '<h3 class="hidden">',
      'after_title'   => '</h3>',
    ));

    register_sidebar( array(
      'name'          => __('WooCommerce Shop before loop', 'theme-translations'),
      'id'            => 'theme_woo_shop_before_loop',
      'before_widget' => '',
      'after_widget'  => '',
      'before_title'  => '<h3 class="hidden">',
      'after_title'   => '</h3>',
    ));

    register_sidebar( array(
      'name'          => __('Footer widget column 1', 'theme-translations'),
      'id'            => 'footer_1',
      'before_widget' => '',
      'after_widget'  => '',
      'before_title'  => ' <h3 class="menu-title">',
      'after_title'   => '</h3>',
    ));

    register_sidebar( array(
      'name'          => __('Footer widget column 2', 'theme-translations'),
      'id'            => 'footer_2',
      'before_widget' => '',
      'after_widget'  => '',
      'before_title'  => ' <h3 class="menu-title">',
      'after_title'   => '</h3>',
    ));

    register_sidebar( array(
      'name'          => __('Footer widget column 3', 'theme-translations'),
      'id'            => 'footer_3',
      'before_widget' => '',
      'after_widget'  => '',
      'before_title'  => '<h3 class="menu-title">',
      'after_title'   => '</h3>',
    ));

  }



  /**
   * replaces 3rd party pugins to theme designed positions
   *
   */
  public function replace_3rd_party_pugins_hooks(){

    if(function_exists('YITH_WCMBS_Frontend')){

    $manager = YITH_WCMBS_Frontend();

    remove_action( 'pre_get_posts', array(  $manager, 'hide_not_allowed_posts' ) );

    remove_action( 'woocommerce_archive_description', 'woocommerce_taxonomy_archive_description', 10 );

    remove_filter( 'the_posts', array(  $manager, 'filter_posts' ) );

    remove_action( 'get_pages', array(  $manager, 'filter_posts' ) );

    remove_action( 'wp_nav_menu_objects', array(  $manager, 'filter_nav_menu_pages' ) );

    remove_action( 'get_next_post_where', array(  $manager, 'filter_adiacent_post_where' ) );

    remove_action( 'get_previous_post_where', array(  $manager, 'filter_adiacent_post_where' ) );

    remove_action( 'wp_enqueue_scripts', array( $manager, 'enqueue_scripts' ) );

    remove_action('woocommerce_checkout_terms_and_conditions', 'wc_terms_and_conditions_page_content' , 30);

    add_action('woocommerce_checkout_terms_and_conditions',  array( $this, 'wc_terms_and_conditions_page_content' ),30 );
    }

    remove_action('woocommerce_cart_collaterals', 'woocommerce_cross_sell_display');
    remove_action('woocommerce_cart_collaterals', 'woocommerce_cart_totals');
  }

  public static function wc_terms_and_conditions_page_content(){
   $terms_page_id = wc_terms_and_conditions_page_id();

    if ( ! $terms_page_id ) {
        return;
    }

    $page = get_post( $terms_page_id );

    $content = strip_shortcodes($page->post_content);

    $content = preg_replace( '~\[[^\]]+\]~', '', $content );

    if ( $page && 'publish' === $page->post_status && $page->post_content && ! has_shortcode( $page->post_content, 'woocommerce_checkout' ) ) {
        echo '<div class="woocommerce-terms-and-conditions" style="display: none; max-height: 200px; overflow: auto;">' . (wp_kses_post ( wc_format_content ($content) ) ) . '</div>';
    }
  }



  /**
   * unhooks unused functions
   */
  public function remove_actions(){
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
    remove_action( 'wp_head', 'wp_oembed_add_host_js' );
  }



  /**
   * function runs on theme setup
   *
   * @hookedto - after_setup_theme
   */
  public function setup_theme(){
    $myaccount_page = get_option( 'woocommerce_myaccount_page_id' );
    $wishlist_id    = get_option('theme_custom_wishlist');
    $wishlist_page  = get_page($wishlist_id);

    /*Theme translations*/
    load_theme_textdomain( 'theme-translations', THEME_PATH . '/languages' );

    /*Menu registrations*/

    $locations = array(
      'main_menu'     => __('Menu in header', 'theme-translations'),
      'main_menu_mobile'     => __('Main menu for mobiles', 'theme-translations'),
    );

    register_nav_menus($locations);
  }



  /**
   * adds async attribute to a <script> tag
   *
   * @hookedto - script_loader_tag 10
   *
   * @param string - $tag
   * @param string - $handle
   */
  public function add_async_attribute( $tag, $handle ) {
    if(is_admin() || is_customize_preview()) return $tag;

    do_action('before_add_async_attribute', $tag ,$handle);

    if(isset($_GET['action'])) return $tag;

    if('jquery' === $handle || 'jquery-core' === $handle){
      return $tag;
    }

    if(function_exists('wc') && (is_woocommerce())){return $tag;}

    if(function_exists('is_checkout') &&  is_checkout()){
       return $tag;
    }
      return str_replace( ' src', ' defer src', $tag );
  }



  /**
   * adds additional mime types for attachments
   *
   * @hookedto - upload_mimes 10
   */
  public function cc_mime_types($mimes) {
    $mimes['avi'] = 'video/avi';
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
  }



  /**
   * What type of request is this?
   *
   * @param  string $type admin, ajax, cron or frontend.
   * @return bool
   */
  private function is_request( $type ) {
    switch ( $type ) {
      case 'admin':
        return is_admin();
      case 'ajax':
        return defined( 'DOING_AJAX' );
      case 'cron':
        return defined( 'DOING_CRON' );
      case 'frontend':
        return ( ! is_admin() );
    }
  }



  /**
   * removes version for styles and scripts urls in tags <script> <style>
   *
   * @hookedto - script_loader_src 9998
   * @hookedto - style_loader_src 9998
   */
  public function remove_script_version( $src ){
    $parts = explode( '?', $src );
    return $parts[0];
  }


  /**
   * overrides redirects after user edits shipping or billing form
   *
   * @hookedto - woocommerce_customer_save_address 10
   */
  public static function woocommerce_customer_save_address($user_id, $load_address ){
    wp_safe_redirect( wc_get_endpoint_url( 'edit-address/'.$load_address, '', wc_get_page_permalink( 'myaccount' ) ) );
    exit;
  }


  /**
   * overrides redirects after user edits profile details
   *
   * @hookedto - woocommerce_save_account_details 10
   */
  public static function woocommerce_save_account_details($user_id){
    wp_safe_redirect( wc_get_endpoint_url( 'edit-account', '', wc_get_page_permalink( 'myaccount' ) ) );
    exit;
  }


  public function print_styles_in_footer(){
    global $footer_inline_style;
    printf('<style>%s</style>', $footer_inline_style );
  }


  public static function add_cors_http_header(){
    header("Access-Control-Allow-Origin: *");
  }
}


global $theme_init ;

/* init theme*/
$theme_init = new velesh_init_theme();





if ( ! function_exists ( 'yith_pdf_invoice_show_order_barcode' ) ) {
  /**
   * @param YITH_Document $document
   */
  function yith_pdf_invoice_show_order_barcode( $document ) {
    $order    = $document->order;
    $order_id = yit_get_prop ( $order, 'id' );
    echo do_shortcode ( '<p></p><p></p>[yith_render_barcode id="' . $order_id . '"]' );
  }

  add_action ( 'yith_ywpi_template_notes', 'yith_pdf_invoice_show_order_barcode', 20 );
}





add_action('woocommerce_checkout_process', 'if_date_is_selected');

function if_date_is_selected() {
    // $validated = false;

    // $is_single_product_order = false;
    // $single_product_id = (int)get_option('wfp_single_product_id');

    // foreach(wc()->cart->get_cart() as $item){
    //   $is_single_product_order  = $single_product_id === $item['product_id'] ? true :  $is_single_product_order;
    // }

    // if(isset($_POST['free_collection_date'] )){
    //   foreach ($_POST['free_collection_date'] as $key => $d) {
    //     $validated = (!empty($d))? true : $validated;
    //   }
    // }

    // if(!$validated && (!$is_single_product_order || count(wc()->cart->get_cart())>1) && !is_only_fasttrack_checkout(true)){
    //   wc_add_notice( 'Please select Self Ship or Free Collection date.' , 'error' );
    // }
}


function add_menu_attributes( $atts, $item, $args ) {
  $atts['itemprop'] = 'url';
  return $atts;
}
add_filter( 'nav_menu_link_attributes', 'add_menu_attributes', 10, 3 );



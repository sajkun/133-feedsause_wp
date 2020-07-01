<?php
/**
 * Post Types
 *
 * Registers post types and taxonomies.
 *
 */

defined( 'ABSPATH' ) || exit;

/**
 * Post types Class.
 */
class velesh_theme_posts {


  public static $showcase_name  = 'showcase';

  public static $customer_name  = 'theme_customer';

  public static $customer_taxonomy_name  = 'theme_customer_taxonomy';

  public static $faq_name  = 'theme_faq';

  /**
   * Hook in methods.
   */
  public static function init() {
    add_action( 'init', array( __CLASS__, 'register_taxonomies' ), 5 );
    add_action( 'init', array( __CLASS__, 'register_post_types' ), 5 );
    add_action( 'init', array( __CLASS__, 'support_jetpack_omnisearch' ) );
    add_filter( 'rest_api_allowed_post_types', array( __CLASS__, 'rest_api_allowed_post_types' ) );
    add_action( 'velesh_theme_after_register_post_type', array( __CLASS__, 'maybe_flush_rewrite_rules' ) );

    add_filter( 'gutenberg_can_edit_post_type', array( __CLASS__, 'gutenberg_can_edit_post_type' ), 10, 2 );
    add_filter( 'use_block_editor_for_post_type', array( __CLASS__, 'gutenberg_can_edit_post_type' ), 10, 2 );

    add_action( 'admin_menu', array( __CLASS__, 'add_metaboxes' ) );

    add_action( 'save_post',array( __CLASS__, 'save_meta' ) );
  }

  public static function register_taxonomies(){
    if ( ! is_blog_installed() ) {
      return;
    }

    if ( taxonomy_exists( self::$customer_taxonomy_name ) ) {
      return;
    }

    register_taxonomy(
        self::$customer_taxonomy_name,
        array(  self::$customer_name ),
        array(
          'hierarchical'          => true,
          'label'                 => __( 'Categories', 'woocommerce' ),
          'labels'                => array(
            'name'              => __( 'Categories', 'woocommerce' ),
            'singular_name'     => __( 'Category', 'woocommerce' ),
            'menu_name'         => _x( 'Categories', 'Admin menu name', 'woocommerce' ),
            'search_items'      => __( 'Search categories', 'woocommerce' ),
            'all_items'         => __( 'All categories', 'woocommerce' ),
            'parent_item'       => __( 'Parent category', 'woocommerce' ),
            'parent_item_colon' => __( 'Parent category:', 'woocommerce' ),
            'edit_item'         => __( 'Edit category', 'woocommerce' ),
            'update_item'       => __( 'Update category', 'woocommerce' ),
            'add_new_item'      => __( 'Add new category', 'woocommerce' ),
            'new_item_name'     => __( 'New category name', 'woocommerce' ),
            'not_found'         => __( 'No categories found', 'woocommerce' ),
          ),
          'show_ui'               => true,
          'query_var'             => true,
          'capabilities'          => array(
            'manage_terms' => 'manage_categories',
            'edit_terms'   => 'manage_categories',
            'delete_terms' => 'manage_categories',
            'assign_terms' => 'edit_posts',
          ),
          'rewrite'               => array(
            'slug'         => 'story_category',
            'with_front'   => true,
          ),
      )
    );
  }


  /**
   * Register core post types.
   */
  public static function register_post_types() {
    if ( ! is_blog_installed()) {
      return;
    }

   $faq_name = self::$faq_name ;

   $showcase_name = self::$showcase_name;

   $customer_name = self::$customer_name;

    if(!post_type_exists( $faq_name  )):
      register_post_type(
        $faq_name ,
          array(
            'labels'              => array(
              'name'                  => __( 'F.A.Q.', 'theme-translation' ),
              'singular_name'         => __( 'F.A.Q.', 'theme-translation' ),
              'all_items'             => __( 'All questions', 'theme-translation' ),
              'menu_name'             => _x( 'F.A.Q.', 'Admin menu name', 'theme-translation' ),
              'add_new'               => __( 'Add New', 'theme-translation' ),
              'add_new_item'          => __( 'Add new', 'theme-translation' ),
              'edit'                  => __( 'Edit', 'theme-translation' ),
              'edit_item'             => __( 'Edit question', 'theme-translation' ),
              'new_item'              => __( 'New question', 'theme-translation' ),
              'view_item'             => __( 'View question', 'theme-translation' ),
              'view_items'            => __( 'View question', 'theme-translation' ),
              'search_items'          => __( 'Search question', 'theme-translation' ),
              'not_found'             => __( 'No questions found', 'theme-translation' ),
              'not_found_in_trash'    => __( 'No questions found in trash', 'theme-translation' ),
              'parent'                => __( 'Parent F.A.Q.', 'theme-translation' ),
              'featured_image'        => __( 'F.A.Q. image', 'theme-translation' ),
              'set_featured_image'    => __( 'Set question\'s image', 'theme-translation' ),
              'remove_featured_image' => __( 'Remove image', 'theme-translation' ),
              'use_featured_image'    => __( 'Use as image', 'theme-translation' ),
              'insert_into_item'      => __( 'Insert into question', 'theme-translation' ),
              'uploaded_to_this_item' => __( 'Uploaded to this question', 'theme-translation' ),
              'filter_items_list'     => __( 'Filter quesiton', 'theme-translation' ),
              'items_list_navigation' => __( 'Question\'s navigation', 'theme-translation' ),
              'items_list'            => __( 'F.A.Q. list', 'theme-translation' ),
            ),
            'description'         => __( 'This is where you can add new question and answers to your site.', 'theme-translation' ),
            'public'              => true,
            'show_ui'             => true,
            'capability_type'     => 'post',
            'map_meta_cap'        => true,
            'publicly_queryable'  => true,
            'exclude_from_search' => false,
            'hierarchical'        => false, // Hierarchical causes memory issues - WP loads all records!
            'rewrite'             => 'faq',
            'query_var'           => true,
            'supports'            => array('title'),
            'has_archive'         => false,
            'show_in_nav_menus'   => true,
            'show_in_rest'        => false,
          )
      );

    endif;

    if(!post_type_exists( $showcase_name  )):
    register_post_type(
       $showcase_name ,
        array(
          'labels'              => array(
            'name'                  => __( 'Showcase', 'theme-translation' ),
            'singular_name'         => __( 'showcase', 'theme-translation' ),
            'all_items'             => __( 'All showcases', 'theme-translation' ),
            'menu_name'             => _x( 'Showcase', 'Admin menu name', 'theme-translation' ),
            'add_new'               => __( 'Add New', 'theme-translation' ),
            'add_new_item'          => __( 'Add new showcase', 'theme-translation' ),
            'edit'                  => __( 'Edit', 'theme-translation' ),
            'edit_item'             => __( 'Edit showcase', 'theme-translation' ),
            'new_item'              => __( 'New showcase', 'theme-translation' ),
            'view_item'             => __( 'View showcase', 'theme-translation' ),
            'view_items'            => __( 'View showcase', 'theme-translation' ),
            'search_items'          => __( 'Search showcase', 'theme-translation' ),
            'not_found'             => __( 'No showcase found', 'theme-translation' ),
            'not_found_in_trash'    => __( 'No showcase found in trash', 'theme-translation' ),
            'parent'                => __( 'Parent showcase', 'theme-translation' ),
            'featured_image'        => __( 'showcase image', 'theme-translation' ),
            'set_featured_image'    => __( 'Set showcase image', 'theme-translation' ),
            'remove_featured_image' => __( 'Remove showcase image', 'theme-translation' ),
            'use_featured_image'    => __( 'Use as showcase image', 'theme-translation' ),
            'insert_into_item'      => __( 'Insert into showcase', 'theme-translation' ),
            'uploaded_to_this_item' => __( 'Uploaded to this showcase', 'theme-translation' ),
            'filter_items_list'     => __( 'Filter showcase', 'theme-translation' ),
            'items_list_navigation' => __( 'showcase navigation', 'theme-translation' ),
            'items_list'            => __( 'showcase list', 'theme-translation' ),
          ),
          'description'         => __( 'This is where you can add new showcase to your site.', 'theme-translation' ),
          'public'              => true,
          'show_ui'             => true,
          'capability_type'     => 'post',
          'map_meta_cap'        => true,
          'publicly_queryable'  => true,
          'exclude_from_search' => false,
          'hierarchical'        => false, // Hierarchical causes memory issues - WP loads all records!
          'rewrite'             => 'showcase',
          'query_var'           => true,
          'supports'            => array( 'title', 'editor', 'thumbnail'),
          'has_archive'         => false,
          'show_in_nav_menus'   => true,
          'show_in_rest'        => false,
        )
      );
    endif;

    if(!post_type_exists( $customer_name  )):
    register_post_type(
       $customer_name ,
        array(
          'labels'              => array(
            'name'                  => __( 'Customers\' Stories', 'theme-translation' ),
            'singular_name'         => __( 'Customer\'s story', 'theme-translation' ),
            'all_items'             => __( 'All stories', 'theme-translation' ),
            'menu_name'             => _x( 'Customers\' Stories', 'Admin menu name', 'theme-translation' ),
            'add_new'               => __( 'Add New Story', 'theme-translation' ),
            'add_new_item'          => __( 'Add new Story', 'theme-translation' ),
            'edit'                  => __( 'Edit Story', 'theme-translation' ),
            'edit_item'             => __( 'Edit Story', 'theme-translation' ),
            'new_item'              => __( 'New Story', 'theme-translation' ),
            'view_item'             => __( 'View Story', 'theme-translation' ),
            'view_items'            => __( 'View Stories', 'theme-translation' ),
            'search_items'          => __( 'Search for Stories', 'theme-translation' ),
            'not_found'             => __( 'No stories found', 'theme-translation' ),
            'not_found_in_trash'    => __( 'No stories found in trash', 'theme-translation' ),
            'parent'                => __( 'Parent story', 'theme-translation' ),
            'featured_image'        => __( 'Story image', 'theme-translation' ),
            'set_featured_image'    => __( 'Set story image', 'theme-translation' ),
            'remove_featured_image' => __( 'Remove story image', 'theme-translation' ),
            'use_featured_image'    => __( 'Use as story image', 'theme-translation' ),
            'insert_into_item'      => __( 'Insert into story', 'theme-translation' ),
            'uploaded_to_this_item' => __( 'Uploaded to this story', 'theme-translation' ),
            'filter_items_list'     => __( 'Filter stories', 'theme-translation' ),
            'items_list_navigation' => __( 'Stories navigation', 'theme-translation' ),
            'items_list'            => __( 'Stories list', 'theme-translation' ),
          ),
          'description'         => __( 'This is where you can add new customer stories to your site.', 'theme-translation' ),
          'public'              => true,
          'show_ui'             => true,
          'capability_type'     => 'post',
          'map_meta_cap'        => true,
          'publicly_queryable'  => true,
          'exclude_from_search' => false,
          'hierarchical'        => false, // Hierarchical causes memory issues - WP loads all records!
          'rewrite'               => array(
            'slug'         => 'story',
            'with_front'   => false,
            'hierarchical' => true,
          ),
          'query_var'           => true,
          'supports'            => array( 'title', 'editor', 'thumbnail'),
          'has_archive'         => false,
          'show_in_nav_menus'   => true,
          'show_in_rest'        => false,
        )
      );
    endif;

    do_action( 'velesh_theme_after_register_post_type' );
  }


  /**
   * Flush rules if the event is queued.
   *
   * @since 3.3.0
   */
  public static function maybe_flush_rewrite_rules() {
    if ( 'yes' === get_option( 'theme_posts_queue_flush_rewrite_rules2' ) ) {
      update_option( 'theme_posts_queue_flush_rewrite_rules2', 'no' );
      self::flush_rewrite_rules();
    }
  }

  /**
   * Flush rewrite rules.
   */
  public static function flush_rewrite_rules() {
    flush_rewrite_rules();
  }

  /**
   * Disable Gutenberg for showcase.
   *
   * @param bool   $can_edit Whether the post type can be edited or not.
   * @param string $post_type The post type being checked.
   * @return bool
   */
  public static function gutenberg_can_edit_post_type( $can_edit, $post_type ) {
    return 'showcase' === $post_type ? false : $can_edit;
  }

  /**
   * Add showcase Support to Jetpack Omnisearch.
   */
  public static function support_jetpack_omnisearch() {
    if ( class_exists( 'Jetpack_Omnisearch_Posts' ) ) {
      new Jetpack_Omnisearch_Posts( 'showcase' );
    }
  }

  /**
   * Added showcase for Jetpack related posts.
   *
   * @param  array $post_types Post types.
   * @return array
   */
  public static function rest_api_allowed_post_types( $post_types ) {
    $post_types[] = 'showcase';

    return $post_types;
  }


  /**
   * adds metaboxes
   */
  public static function add_metaboxes(){
     add_meta_box( 'theme_faq_meta', __( 'Question and answer', 'theme-translations' ),  array(__CLASS__, 'theme_faq_meta_cb'),  self::$faq_name, 'normal', 'high' );

     add_meta_box( 'marked_text', __( 'Marked Text', 'theme-translations' ),  array(__CLASS__, 'marked_text_cb'),  self::$showcase_name, 'normal', 'high' );

     add_meta_box( 'row_3_text', __( 'Three text blocks', 'theme-translations' ),  array(__CLASS__, 'row_3_text_cb'),  self::$showcase_name, 'normal', 'high' );

     add_meta_box( 'instagram_customer', __( 'Customer Quote', 'theme-translations' ),  array(__CLASS__, 'instagram_customer_cb'),  self::$customer_name, 'normal', 'high' );

     add_meta_box( 'block_image_n_text', __( 'Images With text', 'theme-translations' ),  array(__CLASS__, 'block_image_n_text_cb'),  array(self::$showcase_name, self::$customer_name), 'normal', 'high' );

     add_meta_box( 'showcase_gallery', __( 'Gallery', 'theme-translations' ),  array(__CLASS__, 'showcase_gallery_cb'),  array(self::$showcase_name, self::$customer_name), 'normal', 'high' );

     add_meta_box( 'showcase_story', __( 'User story', 'theme-translations' ),  array(__CLASS__, 'story_cb'),   array(self::$showcase_name, self::$customer_name), 'normal', 'high' );

     add_meta_box( 'print_crosssels', __( 'Show products on page', 'theme-translations' ),  array(__CLASS__, 'print_crosssels_cb'),  self::$showcase_name, 'normal', 'high' );

     add_meta_box( 'short_description', __( 'Short description for previews', 'theme-translations' ),  array(__CLASS__, 'short_description_cb'),  array(self::$showcase_name, self::$customer_name), 'side', 'low' );

     add_meta_box( 'color_settings', __( 'Color settings for page', 'theme-translations' ),  array(__CLASS__, 'color_settings_cb'),  self::$showcase_name, 'side', 'low' );

     add_meta_box( 'author_name', __( 'Author name', 'theme-translations' ),  array(__CLASS__, 'author_name_cb'),  self::$customer_name, 'side', 'low' );
  }

  /**
   * callback for add_meta_box()
   * Prints author name
   *
   * @param $post - WP_Post object
   */
  public static function author_name_cb($post){
    $o = get_post_meta($post->ID, '_author_name', true);
    ?>
     <input type="hidden" name="save_theme_meta" value="yes">
     <input type="text" class="large-text"  name="_author_name" value="<?php echo isset($o)? esc_attr($o): '';?>">
    <?php
  }


  /**
   * callback for add_meta_box()
   * Prints user's quote and its instagram link
   *
   * @param $post - WP_Post object
   */
  public static function instagram_customer_cb($post){
    $o = get_post_meta($post->ID, '_instagram_customer', true);
    $image =(isset($o['icon_id']))? wp_get_attachment_image_url($o['icon_id'], 'medium') : DUMMY;
    ?>
    <style>
      .icon img{
        width: 32px !important;
        height: 32px !important;
      }
    </style>
     <input type="hidden" name="save_theme_meta" value="yes">
     <h4>Icon</h4>
       <div class="image-download icon">
        <div class="image-placeholder">
          <img src="<?php echo esc_url($image)?>" alt="" width="48" height="48">
        </div>
        <input type="hidden" name="_instagram_customer[icon_id]" class="image-id" value="<?php echo esc_attr($o['icon_id']) ?>">
        <a href="javascript:void(0)" class="button" onclick="load_image(this)">Set icon</a>
      </div>

      <h4>Title</h4>
      <textarea name="_instagram_customer[title]" id="_instagram_customer[title]" class="large-text" cols="30" rows="2"><?php echo isset($o['title'])? esc_attr($o['title']): '';?></textarea>
      <h4>Text</h4>
      <textarea name="_instagram_customer[text]" id="_instagram_customer[text]" class="large-text" cols="30" rows="6"><?php echo isset($o['text'])?esc_attr( $o['text']): '';?></textarea>
      <h4>Instagramm Title</h4>
      <input type="text" class="large-text"  name="_instagram_customer[ins_title]" class="image-id" value="<?php echo isset($o['ins_title'])? esc_attr($o['ins_title']): '';?>">
      <h4>Instagramm Url</h4>
      <input type="text"  class="large-text" name="_instagram_customer[ins_url]" class="image-id" value="<?php echo isset($o['ins_url'])? esc_url($o['ins_url']): '';?>">
    <?php
  }

  /**
   * callback for add_meta_box()
   * Prints color settings for showcase
   *
   * @param $post - WP_Post object
   */
  public static function color_settings_cb($post){
    $o = get_post_meta($post->ID, '_colors', true);
    ?>
      <h4>Background color of marked text</h4>

      <input type="text" class="colorpicker" name="_marked_bg" value="<?php echo esc_attr( get_post_meta($post->ID, '_marked_bg', true)) ?>">

      <h4>Font color of marked text</h4>
      <input type="text" class="colorpicker" name="_marked_font_color" value="<?php echo esc_attr( get_post_meta($post->ID, '_marked_font_color', true)) ?>">



      <script>
      jQuery(document).ready(function(){
        jQuery('.colorpicker').wpColorPicker();
      })
    </script>
    <?php
  }

  /**
   * callback for add_meta_box()
   * Prints fields for question and answer
   *
   * @param $post - WP_Post object
   */
  public static function theme_faq_meta_cb($post){
    $q = esc_attr(get_post_meta($post->ID, '_question', true));
    $a = esc_attr(get_post_meta($post->ID, '_answer', true));
    ?>
      <h4>Question</h4>
      <textarea name="_question" id="_question" class="large-text" cols="30" rows="6"><?php echo $q? $q: '';?></textarea>
      <h4>Anwer</h4>
      <textarea name="_answer" id="_answer" class="large-text" cols="30" rows="10"><?php echo $a? $a: '';?></textarea>
      <input type="hidden" name="save_theme_meta" value="yes">
    <?php
  }


  /**
   * callback for add_meta_box()
   * Prints
   *
   * @param $post - WP_Post object
   */
  public static function short_description_cb($post){
    $o = get_post_meta($post->ID, '_showcase_description', true);
    ?>
    <textarea class="large-text" name="_showcase_description" cols="30" rows="6"><?php echo (!empty($o))? esc_attr($o) : ''; ?></textarea>
    <input type="hidden" name="save_theme_meta" value="yes">
    <?php
  }


  /**
   * callback for add_meta_box()
   * Prints gallery of showcase custom post
   *
   * @param $post - WP_Post object
   */
  public static function marked_text_cb($post){
    $moto        = esc_attr( get_post_meta($post->ID, '_showcase_moto', true) );
    $moto_marked = esc_attr( get_post_meta($post->ID, '_showcase_moto_marked', true) );
    ?>


    <h4>Text with marked part</h4>
    <textarea name="_showcase_moto" id="_showcase_moto" class="large-text" cols="30" rows="3"><?php echo $moto? $moto: '';?></textarea>

    <h4>Marked part of a text</h4>
    <textarea name="_showcase_moto_marked" id="_showcase_moto_marked" class="large-text" cols="30" rows="3"><?php echo $moto_marked? $moto_marked: '';?></textarea>

    <?php
  }


  /**
   * callback for add_meta_box()
   * Prints fields for 3 text blocks of showcase custom post
   *
   * @param $post - WP_Post object
   */
  public static function row_3_text_cb($post){
    $o = get_post_meta($post->ID, '_3_row', true);
    ?>
  <input type="hidden" name="save_theme_meta" value="yes">
  <?php
    for ($i=1; $i < 4; $i++) {
      echo '<h3>Block #'.$i.'</h3>';

      echo '<h4>Title</h4>';

      printf('<input type="text" name="_3_row[%s][title]" class="large-text" value="%s">', $i, isset($o[$i]['title'])? $o[$i]['title'] : '');

      echo '<h4>Text</h4>';

      printf('<textarea name="_3_row[%s][text]" class="large-text" cols="30" rows="4">%s</textarea>', $i, isset($o[$i]['text'])? $o[$i]['text'] : '');
    }
  }


  /**
   * callback for add_meta_box()
   * Prints fields for blocks with text and images in showcase custom post
   *
   * @param $post - WP_Post object
   */
  public static function block_image_n_text_cb($post){
    $img_text = get_post_meta($post->ID, '_img_text', true);
    $slug    = '_img_text[items]';
    ?>
    <div class="image-text-wrapper">
      <?php if (isset($img_text['items'])):
       ?>
      <?php foreach ($img_text['items'] as $key => $item):
        switch ($item['type']) {
          case 'quote':
            if ( !$item['text']) {
              break;
            }
            ?>
             <div class="image-text-wrapper__item">
              <input type="hidden" name="_img_text[items][<?php echo $key ?>][type]" value="quote" />
                <h4>Text</h4>
                <textarea name="_img_text[items][<?php echo $key ?>][text]" class="large-text" cols="30" rows="5"><?php echo isset($item['text'])?  esc_attr($item['text']): ''; ?></textarea><br>
                <h4>Author</h4>
                <textarea name="_img_text[items][<?php echo $key ?>][author]" class="large-text" cols="30" rows="2"><?php echo isset($item['author'])? esc_attr($item['author']) : ''; ?></textarea>

                <a href="javascript:void(0)" onclick="delete_block(this, '.image-text-wrapper__item')">Delete block</a>
            </div>
            <?php
            break;

          default:
            $image = wp_get_attachment_image_url($item['image_id'], 'medium');

            if (!$image && (!$item['title'] || !$item['text'])) {
              break;
            }
            ?>
             <div class="image-text-wrapper__item">
              <input type="hidden" name="_img_text[items][<?php echo $key ?>][type]" value="image" />
               <div class="image-download">
                <div class="image-placeholder">
                  <img src="<?php echo esc_url($image)?>" alt="">
                </div>
                <input type="hidden" name="_img_text[items][<?php echo $key ?>][image_id]" class="image-id" value="<?php echo esc_attr($item['image_id']) ?>">
                <a href="javascript:void(0)" class="button" onclick="load_image(this)">Set image</a>
              </div>
                <h4>Before title</h4>
                <input type="text" name="_img_text[items][<?php echo $key ?>][before_title]" class="large-text" value="<?php echo isset($item['before_title'])? esc_attr($item['before_title']) :''; ?>">
                <h4>Title</h4>
                <textarea name="_img_text[items][<?php echo $key ?>][title]" class="large-text" cols="30" rows="5"><?php echo isset($item['title'])? esc_attr($item['title']) : ''; ?></textarea>
                <h4>Text</h4>
                <textarea name="_img_text[items][<?php echo $key ?>][text]" class="large-text" cols="30" rows="5"><?php echo isset($item['text'])?  esc_attr($item['text']): ''; ?></textarea><br>

                <a href="javascript:void(0)" onclick="delete_block(this, '.image-text-wrapper__item')">Delete block</a>
            </div>

            <?php
            break;
        }
        ?>

      <?php endforeach ?>
      <?php endif ?>

    </div>

    <input type="hidden" id="image-text-counter" value="<?php echo isset($img_text['count'])? $img_text['count'] : 0; ?>" name="_img_text[count]">

    <a href="javascript:void(0)" onclick="add_image_text_item('.image-text-wrapper', '<?php echo $slug?>', '#image-text-counter')" class="button button-primary button-large"><?php _e('Add Item With Image', 'theme-translations');?></a>

    <a href="javascript:void(0)" onclick="add_quote('.image-text-wrapper', '<?php echo $slug?>', '#image-text-counter')" class="button button-primary button-large"><?php _e('Add Quote', 'theme-translations');?></a>
    <input type="hidden" name="save_theme_meta" value="yes">
    <?php
  }


  /**
   * callback for add_meta_box()
   * Prints gallery of showcase custom post
   *
   * @param $post - WP_Post object
   */
  public static function showcase_gallery_cb($post){
    $gallery = get_post_meta($post->ID, '_gallery', true);
    $slug    = '_gallery[items]';
    ?>
    <input type="hidden" name="save_theme_meta" value="yes">
    <div class="gallery-wrapper">
      <?php if (isset($gallery['items'])): ?>

      <?php foreach ($gallery['items'] as $key => $item):
        $image = wp_get_attachment_image_url($item['image_id'], 'gallery_thumb');
        if(!$image) continue;
        ?>
        <div class="gallery-wrapper__item"><div class="image-download">
          <img src="<?php echo esc_url($image)?>" alt="">
          <div class="image-placeholder"></div><input type="hidden" name="_gallery[items][<?php echo $key ?>][image_id]" class="image-id" value="<?php echo esc_attr($item['image_id']) ?>"><a href="javascript:void(0)" class="button" onclick="load_image(this)">Set image</a></div> <h4>Slide Url</h4> <input type="text" class="large-text" name="_gallery[items][<?php echo $key ?>][url]" value="<?php echo (isset($item['url']))? esc_url($item['url']): '';?>"><br /><a href="javascript:void(0)" onclick="delete_block(this, '.gallery-wrapper__item')">Delete Slide</a></div>
      <?php endforeach ?>
      <?php endif ?>
    </div>
    <input type="hidden" id="gallery-counter" value="<?php echo isset($gallery['count'])? $gallery['count'] : 0; ?>" name="_gallery[count]">

    <a href="javascript:void(0)" onclick="add_gallery_item('.gallery-wrapper', '<?php echo $slug?>', '#gallery-counter')" class="button button-primary button-large"><?php _e('Add Item', 'theme-translations');?></a>
    <?php
  }


  /**
   * callback for add_meta_box()
   * Prints a story in custom
   *
   * @param $post - WP_Post object
   */
  public static function story_cb($post){
    $o = get_post_meta($post->ID, '_showcase_story', true);
    $image = (isset($o['image_id']))? wp_get_attachment_image_url($o['image_id'], 'medium'): DUMMY;
    $icon = (isset($o['icon_id']))?wp_get_attachment_image_url($o['icon_id'], 'icon') : DUMMY;
    ?>
    <style>
      .icon img{
        width: 32px !important;
        height: 32px !important;
      }

      .settings-table{
        width: 100%;
      }

      .settings-table td{
        vertical-align: top;
        padding: 10px;
      }
    </style>
    <label >
      <input type="checkbox" name="_showcase_story[show]" <?php echo (isset( $o['show']) && 'yes' === $o['show'])? 'checked="checked"':''; ?> value="yes">
      show this block
    </label>
      <input type="hidden" name="save_theme_meta" value="yes">

      <h4>Category title</h4>
      <input type="text" class="large-text" value="<?php echo isset($o['category'])? esc_attr($o['category']): ''; ?>" name="_showcase_story[category]">
      <?php if (self::$customer_name !== $post->post_type): ?>
        <table class="settings-table">
          <tr>
            <td style="width: 200px">
              <h4>Subcategory's icon</h4>

               <div class="image-download">
                <div class="image-placeholder icon">
                  <img src="<?php echo esc_url($icon)?>" alt="">
                </div>
                <br><br>
                <input type="hidden" name="_showcase_story[icon_id]" class="image-id" value="<?php echo esc_attr($o['icon_id']) ?>">
                <a href="javascript:void(0)" class="button" onclick="load_image(this)">Set icon</a>
              </div>

            </td>
            <td>
              <h4>Subcategory</h4>
              <input type="text" class="large-text" value="<?php echo isset($o['subcategory'])? esc_attr($o['subcategory']): ''; ?>" name="_showcase_story[subcategory]">
            </td>
          </tr>
        </table>
      <?php endif ?>


      <h4>Title</h4>

      <textarea name="_showcase_story[title]" class="large-text"  cols="30" rows="4"><?php echo isset($o['title'])? esc_attr($o['title']): ''; ?></textarea>

      <h4>Video</h4>

      <table class="settings-table">
        <tr>
          <td>
            <h4>Url</h4>
             <input type="text" class="large-text" value="<?php echo isset($o['url'])? esc_url($o['url']): ''; ?>" name="_showcase_story[url]">

          </td>
          <td>
            <h4>Link text</h4>

             <input type="text" class="large-text" value="<?php echo isset($o['url_text'])? esc_attr($o['url_text']): ''; ?>" name="_showcase_story[url_text]">
          </td>
          <td>
            <h4>Video Sourse</h4>

            <label><input type="radio" value="youtube" <?php echo (isset($o['url_type']) && 'youtube' === $o['url_type'])? 'checked="checked"': ''; ?> name="_showcase_story[url_type]"> Youtube</label><br>
            <label><input type="radio" value="plain" <?php echo (isset($o['url_type']) && 'plain' === $o['url_type'])? 'checked="checked"': ''; ?> name="_showcase_story[url_type]">Video file on current site</label>
          </td>
        </tr>
      </table>



      <h4>Image</h4>

       <div class="image-download">
        <div class="image-placeholder">
          <img src="<?php echo esc_url($image)?>" alt="">
        </div>
        <input type="hidden" name="_showcase_story[image_id]" class="image-id" value="<?php echo esc_attr($o['image_id']) ?>">
        <a href="javascript:void(0)" class="button" onclick="load_image(this)">Set image</a>
      </div>


    <?php
  }


  /**
   * callback for add_meta_box()
   * Prints a story in custom
   *
   * @param $post - WP_Post object
   */
  public static function print_crosssels_cb($post){
    $o = get_post_meta($post->ID,'_showcase_product', true);
    $args = array(
      'limit' => -1,
      'posts_per_page' => -1,
    );
    $products = wc_get_products($args);
    ?>

    <h4>Section title</h4>
    <input class="large-text" type="text" name="_showcase_product[title]" value="<?php echo isset($o['title']) ? esc_attr($o['title']) : '' ;?>">
    <h4>Section comment</h4>
    <textarea class="large-text" rows="4" cols="30" name="_showcase_product[comment]" ><?php echo isset($o['comment']) ? esc_attr($o['comment']) : '' ;?></textarea>

    <h4>Products to be shown</h4>
    <?php

    foreach ($products as $key => $p) {
      if(product_is_subscription($p->get_id()) || (int)get_option('wfp_single_product_id') === $p->get_id()) continue;
      $checked = (isset($o['item']) && in_array($p->get_id(),$o['item']))? 'checked="checked"': '' ;
      printf('<label><input type="checkbox" name="_showcase_product[item][%s]" value="%s" %s>%s</label><br>', $key,
        esc_attr($p->get_id()),$checked, esc_attr($p->get_title()));
    }
  }


  /**
   * Saves  post's metadata
   *
   * @param $post_id - integer
   */
  public static function save_meta($post_id){
    if(!isset($_POST['save_theme_meta']) || 'yes' !== $_POST['save_theme_meta'] ) return;

    $data     = array(
      ['name' =>'_question', 'unique' => true, 'type' =>'text', 'meta_type'=>self::$faq_name],
      ['name' =>'_author_name', 'unique' => true, 'type' =>'text', 'meta_type'=>self::$faq_name],
      ['name' =>'_answer', 'unique' => true, 'type' =>'text', 'meta_type'=>self::$faq_name],
      ['name' =>'_gallery', 'unique' => true, 'type' =>'array', 'meta_type'=>self::$showcase_name],
      ['name' =>'_showcase_moto', 'unique' => true, 'type' =>'multiline', 'meta_type'=>self::$showcase_name],
      ['name' =>'_showcase_moto_marked', 'unique' => true, 'type' =>'multiline', 'meta_type'=>self::$showcase_name],
      ['name' =>'_showcase_description', 'unique' => true, 'type' =>'multiline', 'meta_type'=>self::$showcase_name],
      ['name' =>'_gallery', 'unique' => true, 'type' =>'array', 'meta_type'=>self::$showcase_name],
      ['name' =>'_3_row', 'unique' => true, 'type' =>'array', 'meta_type'=>self::$showcase_name],
      ['name' =>'_img_text', 'unique' => true, 'type' =>'none', 'meta_type'=>self::$showcase_name],
      ['name' =>'_instagram_customer', 'unique' => true, 'type' =>'none', 'meta_type'=>self::$showcase_name],
      ['name' =>'_showcase_story', 'unique' => true, 'type' =>'array', 'meta_type'=>self::$showcase_name],
      ['name' =>'_showcase_product', 'unique' => true, 'type' =>'array', 'meta_type'=>self::$showcase_name],
      ['name' =>'_marked_bg', 'unique' => true, 'type' =>'color', 'meta_type'=>self::$showcase_name],
      ['name' =>'_marked_font_color', 'unique' => true, 'type' =>'color', 'meta_type'=>self::$showcase_name],
    );

    foreach ($data as $_id => $_d) {
      if(isset($_POST[$_d['name']]) && !empty($_POST[$_d['name']])){
        switch ($_d['type']) {

          case 'array':
            $new_data = recursive_sanitize_text_field($_POST[$_d['name']]);
            break;

          case 'multiline':
            $new_data = implode( "\n", array_map( 'sanitize_text_field', explode( "\n", $_POST[$_d['name']] ) ) );
            break;

          case 'color':
            $new_data = sanitize_hex_color($_POST[$_d['name']]);
            break;

          case 'text':
            $new_data = sanitize_text_field( $_POST[$_d['name']]);
            break;

          default:
            $new_data =  $_POST[$_d['name']];
            break;
        }

        if(!update_post_meta($post_id, $_d['name'] , $new_data)){
          add_post_meta( $post_id, $_d['name'] , $new_data, $_d['unique'] );
        }
      }
      else{
        delete_post_meta( $post_id, $_d['name'] );
      }
    }
  }

}

velesh_theme_posts::init();

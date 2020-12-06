<?php
/* * * * * * * * * * * * * * * * * * * * * **
* * * * * * * * * * * * * * * * * * * * * * *
* * * * * * * * * * * * * * * * * * * * * * *
* * * ADD CUSTOM IMAGE TO A MENU ITEM * * * *
* * * * * * * * * * * * * * * * * * * * * * *
* * * * * * * * * * * * * * * * * * * * * * *
* * * * * * * * * * * * * * * * * * * * * * */

class custom_edit_menu_image{

  public function __construct() {
    add_action( 'admin_init', array( $this, 'admin_init' ), 99 );
    add_filter( 'manage_nav-menus_columns', array( $this, 'screen_setting_menu_image' ), 11 );
    add_action( 'save_post_nav_menu_item', array( $this, 'save_data' ), 12, 2 );
  }


  public function admin_init() {
    if ( !has_action( 'wp_nav_menu_item_custom_fields' ) ) {
      add_filter( 'wp_edit_nav_menu_walker', array( $this, 'menu_edit_walker_filter') );
    }

    add_action( 'wp_nav_menu_item_custom_fields', array( $this, 'add_menu_setup_fields'), 10, 4 );
  }

  public function screen_setting_menu_image($columns ){

    $result = $columns + array( 'custom_image' => __( 'Custom Image', 'theme-translations' ) ) + array( 'custom_description' => __( 'Custom_description', 'theme-translations' ) );

    return $result;
  }

  public function add_menu_setup_fields($item_id, $item, $depth, $args ){
      if (!$item_id && isset($item->ID)) {
        $item_id = $item->ID;
      }
      ?>

       <?php
         $description   = get_post_meta($item_id, '_descr', true);
       ?>
      <div class="field-custom_image custom_image custom_image-wide">
        <div class="menu-item-custom_image">
          <p class="target-column-hidden"><i>
            <?php
              _e('Add custom icon. Regular state','theme-translations').'. ';
             ?>
          </i></p>

          <?php
            $image_id   = get_post_meta($item_id, '_custom-image-url', true);
            $image_data = wp_get_attachment_image_src($image_id, 'thumbnail', true);
            $image_url  = ( $image_data  && isset($image_data[0]) )? $image_data[0] : '';
           ?>

          <div class="image-download target-column-hidden">
            <input type="hidden" id="custom-image-url[<?php echo $item_id;?>]" name="custom-image-url[<?php echo $item_id;?>]" class="image-id" value="<?php echo (!empty($image_id) && isset($image_id))? $image_id: -1; ?>">
            <div class="image-placeholder" onclick="load_image(this)">
              <img src=" <?php echo $image_url; ?>" width="64" height="64" style="width:32px; height: auto" alt="">
            </div>
            <br>

            <div class="button-holder">
              <a href="javascript:void(0)" class="button submit-add-to-menu left" onclick="load_image(this)">
                <?php
                _e('Set Image','theme-translations');
                 ?>
              </a>
              &nbsp;
              <a href="javascript:void(0)" onclick="clear_image(this)">
                <?php
                _e('Clear Image','theme-translations');
                 ?>
              </a>
            </div>

            <br>
          </div>

          <p class="target-column-hidden"><i>
            <?php
              _e('Add custom image, hover state','theme-translations').'. ';
             ?>
          </i></p>

          <?php
            $image_id   = get_post_meta($item_id, '_custom-image-url-hover', true);
            $image_data = wp_get_attachment_image_src($image_id, 'thumbnail', true);
            $image_url  = ( $image_data  && isset($image_data[0]) )? $image_data[0] : '';
           ?>
          <div class="image-download target-column-hidden">
            <input type="hidden" id="custom-image-url-hover[<?php echo $item_id;?>]" name="custom-image-url-hover[<?php echo $item_id;?>]" class="image-id" value="<?php echo (!empty($image_id) && isset($image_id))? $image_id: -1; ?>">
            <div class="image-placeholder" onclick="load_image(this)">
              <img src=" <?php echo $image_url; ?>" width="64" height="64" style="width:32px; height: auto" alt="">
            </div>
            <br>

            <div class="button-holder">
              <a href="javascript:void(0)" class="button submit-add-to-menu left" onclick="load_image(this)">
                <?php
                _e('Set Image','theme-translations');
                 ?>
              </a>
              &nbsp;
              <a href="javascript:void(0)" onclick="clear_image(this)">
                <?php
                _e('Clear Image','theme-translations');
                 ?>
              </a>
            </div>

            <br>
          </div>
        </div>
      </div>
      <div class="field-custom_description custom_description custom_image-wide">

        <div class="menu-item-set_columns">
          <label for="descr_<?php echo $item_id;?>">
            <?php _e('Description', 'theme-translations') ?>.
          </label>
          <input type="text" class="large-text" id="descr_<?php echo $item_id;?>" name="descr[<?php echo $item_id;?>]" value='<?php echo $description ?>'  >

        </div>
      </div>
      <?php
  }

  public function save_data( $post_id, $post ){

    $menu_data = array(
      'custom-image-url',
      'custom-image-url-hover',
      'descr',
    );

    foreach ( $menu_data as $setting_name ):
      if ( isset( $_POST[ $setting_name ][ $post_id ] ) ){

        if ( $post->{"_$setting_name"} != $_POST[ $setting_name ][ $post_id ] ) {
          update_post_meta( $post_id, "_$setting_name", esc_sql( $_POST[ $setting_name ][ $post_id ] ) );
        }
      }else{
        delete_post_meta($post_id, "_$setting_name");
      }

    endforeach;

  }

  public function menu_edit_walker_filter(){
    return 'custom_menu_edit_walker_velesh';
  }
}
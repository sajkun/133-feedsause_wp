<?php
add_action('admin_init', 'ex_add_my_tc_button', 99);


function ex_add_my_tc_button() {
    // проверяем права доступа
    if ( !current_user_can('edit_posts') && !current_user_can('edit_pages') ) {
      return;
    }

    if ( get_user_option('rich_editing') == 'true') {
        add_filter("mce_external_plugins", "ex_add_tinymce_plugin", 11);
        add_filter('mce_buttons', 'ex_register_button', 11 ,2);
    }

}


function ex_add_tinymce_plugin($plugin_array) {
    $plugin_array['theme_marked_button'] = get_stylesheet_directory_uri()."/script/tiny2.js";
    $plugin_array['video_link'] = get_stylesheet_directory_uri()."/script/tiny2.js";
    return $plugin_array;
}

function ex_register_button($buttons, $editor_id) {

   array_push($buttons, "theme_marked_button");
   array_push($buttons, "video_link");
   if($editor_id == '_sidebar'){
    $buttons = array();
   }
   return $buttons;
}

add_filter( 'teeny_mce_buttons', 'my_editor_buttons', 10, 2 );

function my_editor_buttons( $buttons, $editor_id ) {
  $buttons[] = "wdm_mce_button";
  $buttons[] = "theme_marked_button";

  return $buttons;
}

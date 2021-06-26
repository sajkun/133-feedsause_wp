<?php
/**
* construct and output class for woocommerce shop
*/

if (function_exists('wc') && !class_exists('woocommerce_theme_contructor')) {
  class woocommerce_theme_contructor{

    public function __construct(){
      $this->remove_actions();

      add_action('do_theme_before_content', array($this, 'start_shop'));
      add_action('do_theme_content', array($this, 'start_shop_main_column_html'));
      add_action('do_theme_content', array($this, 'print_shop_title'), 20);
      add_action('do_theme_content', array($this, 'print_mobile_categories'), 25);
      add_action('do_theme_content', array($this, 'print_shop_trending'), 30);
      add_action('do_theme_content', array($this, 'print_shop_featuring_categories'), 40);
      add_action('do_theme_content', array($this, 'print_shop_banner'), 50);
      add_action('do_theme_content', array($this, 'woocommerce_content'), 50);
      add_action('do_theme_content', array($this, 'close_div'), 100);
      add_action('do_theme_after_content', array($this,  'end_shop'));
      add_action('do_theme_after_content', array($this, 'print_cta_after_shop'), 120);
    }


    public function remove_actions(){

    }


    /**
    * prints open tags of a shop content
    * prints left sidebar
    *
    * @hooked to do_theme_before_content 10
    */
    public static function start_shop(){
      print_theme_template_part('open-html', 'woocommerce/shop');
      print_theme_template_part('sidebar', 'woocommerce/shop');
    }


    /**
    * prints open tags of shop center column
    *
    * @hooked to do_theme_content 10
    */
    public static function start_shop_main_column_html(){
      echo '<div class="shop-content">';
    }


    /**
    * prints shop title
    *
    * @hooked to do_theme_content 20
    */
    public static function print_shop_title(){
      $args = array(
        'title' => 'Discover your <span class="marked">style</span>',
        'text'  => 'Get inspiration for your next product photography shoot by exploring our tailored made styles.',
      );
      print_theme_template_part('title', 'woocommerce/shop', $args);
    }


    /**
    * prints shop title
    *
    * @hooked to do_theme_content 25
    */
    public static function print_mobile_categories(){
      print_theme_template_part('mobile-categories', 'woocommerce/shop');
    }


    /**
    * prints shop trending product
    *
    * @hooked to do_theme_content 30
    */
    public static function print_shop_trending(){

      /**
      * get settings for the category
      * check if setting exists and if category is active
      */

      $shop_categories = get_option('shop_categories');
      if(!$shop_categories['first']){
        return '';
      }

      $category = get_term($shop_categories['first']);

      if(!$category){
        return '';
      }

      /**
      * get query for all products of the selected category
      */
      $products_args = array(
       'limit'     => -1,
       'category'  => array($category->slug),
      );

      $products = wc_get_products($products_args);

      if(count($products) == 0){
        return '';
      }

      unset($products_args);

      $args = array(
       'category'  => $category,
       'products'  => $products,
      );

      print_theme_template_part('category-first', 'woocommerce/shop', $args);

    }


    /**
    * prints shop's featuring categories  categories product
    *
    * @hooked to do_theme_content 40
    */
    public static function print_shop_featuring_categories(){
      /**
      * get settings for the category
      * check if setting exists and if category is active
      */

      $shop_categories = get_option('shop_categories');

      unset($shop_categories['first']);

      $_shop_categories = array_filter(array_values($shop_categories), function($el){
        return (int)$el > 0;
      });

      if(count($_shop_categories) == 0){
        return '';
      }

      /**
      * get category objects by settings
      */

      $_shop_categories = array_map(function($el){ return (int)$el;}, $_shop_categories);

      $categories = get_terms( [
        'taxonomy'   => 'product_cat',
        'hide_empty' => true,
        'include'    => $_shop_categories,
      ]);

      if(!$categories){
        return '';
      }

      // $categories = array_map(function($el){ return $el->slug;}, $categories);

      /**
      * get query for all products of the selected category
      */
      $products = array();
      $_categories = array();

      foreach ($categories as $key => $category) {
        $products_args = array(
         'limit'     => -1,
         'category'  => $category->slug,
        );

        $products[$category->slug] = wc_get_products($products_args);
        $_categories[$category->term_id] = $category;
      }

      $args = array(
       'categories'      => $_categories,
       'shop_categories' => $shop_categories,
       'products'        => $products,
      );

      print_theme_template_part('categories', 'woocommerce/shop', $args);
    }


    /**
    * prints shop banner
    *
    * @hooked to do_theme_content 50
    */
    public static function print_shop_banner(){
      print_theme_template_part('shop-banner', 'woocommerce/shop');
    }



    /**
    *  calls woocommerce_content()
    *
    * @hooked to do_theme_content 50
    */
    public static function woocommerce_content(){


      if(is_shop()){
        $products = wc_get_products(['limit'=> -1]);

        $args = array(
         'products'        => $products,
         'icon'   => '🍯',
         'title'   => 'All products',
        );
      }

      if(is_product_category()){
        global $term;
        $products = wc_get_products([
          'limit'=> -1,
          'category' => $term,
        ]);

        $term = get_term_by('slug', $term, 'product_cat');

        $thumbnail_id = (int)get_term_meta($term->term_id, 'thumbnail_id', true );
        $icon =  wp_get_attachment_image_url($thumbnail_id, 'full');

        $args = array(
         'products'        => $products,
         'icon'   => sprintf('<img src="%s" alt="">', $icon),
         'title'   => $term->name,
        );
      }


      print_theme_template_part('all-products', 'woocommerce/shop', $args);

      // woocommerce_content();
    }


    /**
    * prints after shop call to action
    *
    * @hooked to do_theme_content 110
    */
    public static function print_cta_after_shop(){
      print_theme_template_part('cta', 'woocommerce/shop');
    }


    /**
    * prints close tags of a shop content
    *
    * @hooked to do_theme_after_content 10
    */
    public static function end_shop(){
      print_theme_template_part('close-html', 'woocommerce/shop');
    }

    /**
    * prints closing tag for image info row in a products' loop
    */
    public static function close_div(){
      echo '</div>';
    }
  }
}
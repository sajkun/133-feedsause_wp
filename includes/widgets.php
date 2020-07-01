<?php

class theme_product_widget extends WP_Widget {

  /**
   * Default callback
   */
  function __construct() {
    parent::__construct(
       'theme-products-widget',
      __('Theme Product Widgets', 'theme-translations'),
      array( 'description' => 'Displays preview of selected products' )
    );
  }

  /**
   * prints widget html on frontend
   *
   * @param $args     - array with widget settings
   * @param $data - array of widget's save data
   */
  public function widget( $args, $data ) {
    if(!function_exists('wc_get_products')) return;
    $style = (isset($data['style']))? $data['style'] : '';
    if(!$data || !($data['product'])) return false;

    global $theme_product_widget_size;

    switch ($style ) {
      case 'large':
      $theme_product_widget_size = 'large';

      $args = array(
        'include' => $data['product'],
        'limit' => -1,
        'posts_per_page' => -1
      );

      $products = wc_get_products($args);
      ?>
      <section class="section-products">
        <div class="container container_sm">
          <div class="row products-large no-gutters">
            <?php
            global $product;
            foreach ($products as $key => $p):
              $product = $p;
              wc_get_template_part( 'content', 'product' );
            endforeach ?>
          </div><!-- row -->
          <?php if (isset($data['button']) && 'yes' === $data['button']): ?>
           <div style="text-align: center">
             <a href="<?php echo get_permalink( wc_get_page_id( 'shop' ) );?>" class="button button_lg">Browse All Recipes</a>
           </div>
           <div class="spacer-h-25"></div>
           <div class="spacer-h-10"></div>
          <?php endif ?>
        </div><!-- container -->
      </section><!-- products -->
      <?php
        $theme_product_widget_size = '';
        break;

      default:
      $theme_product_widget_size = 'small';

      $args = array(
        'include' => $data['product'],
        'limit' => -1,
        'posts_per_page' => -1
      );

      $products = wc_get_products($args);
       ?>
      <section class="section-products">
        <div class="container container_sm">
          <div class="row products-md no-gutters">
            <?php
            global $product;
            foreach ($products as $key => $p):
              $product = $p;
              wc_get_template_part( 'content', 'product' );
            endforeach;
            $theme_product_widget_size = '';
             ?>
          </div><!-- row -->
          <?php if (isset($data['button']) && 'yes' === $data['button']): ?>
           <div style="text-align: center">
             <a href="<?php echo get_permalink( wc_get_page_id( 'shop' ) );?>" class="button button_lg">Browse All Recipes</a>
           </div>
           <div class="spacer-h-25"></div>
          <?php endif ?>
        </div><!-- container -->
      </section><!-- products -->
        <?php
        break;
    }
  }


  /**
   * prints widget form on WordPress widget area
   *
   * @param $data - array of widget's save data
   */
  public function form( $data ) {
   if(!function_exists('wc_get_products')) {
    echo 'you need to install WooCommerce';
    return;}
    $args = array(
      'limit'          => -1,
      'posts_per_page' => 0,
    );

    $products = wc_get_products($args);

    echo '<h4>Select products you want to display</h4>';

    foreach ($products as $id => $p) {
      $is_subsciption = get_post_meta($p->get_id(), '_ywsbs_subscription', true);

      if(('yes' !== $is_subsciption) && ((int)get_option('wfp_single_product_id') !== $p->get_id())){
        printf('<div><label for=""><input type="checkbox" id="%1$s" name="%2$s" value="%3$s" %5$s> %4$s</label></div>',
          $this->get_field_id( 'product['.$id.']' ),
          $this->get_field_name( 'product['.$id.']' ),
          $p->get_id(),
          $p->get_title(),
          (isset($data['product']) && in_array($p->get_id(), $data['product']))? 'checked="checked"' : ''
        );
      }
    }
    ?>
    <br><br>

    <div>
      <h4>Widget style:</h4>
      <lable>
      <input type="radio" id="<?php echo $this->get_field_id( 'style' ); ?>" name="<?php echo $this->get_field_name(  'style' ); ?>" value="large" <?php echo (isset($data['style']) && 'large' === $data['style'])? 'checked="checked"' : '';  ?>>
      <span>Large Items (2 in a row)</span>
      </lable> <br><br>

      <lable>
      <input type="radio" id="<?php echo $this->get_field_id( 'style' ); ?>" name="<?php echo $this->get_field_name(  'style' ); ?>" value="small" <?php echo (isset($data['style']) && 'small' === $data['style'])? 'checked="checked"' : '';  ?>>
      <span>Small Items (3 in a row)</span></lable>
    </div>

      <br><br>
    <div>
      <h4> "Browse All Recipes" button</h4>

      <label>
        <input type="checkbox" id="<?php echo $this->get_field_id( 'button' ); ?>" name="<?php echo $this->get_field_name(  'button' ); ?>" value="yes" <?php echo (isset($data['button']) && 'yes' === $data['button'])? 'checked="checked"' : '';  ?>>
        <span>Mark this to display "Browse All Recipes" button</span>
      </label>
    </div>
      <br><br>
    <?php
  }

  /**
   * saves widget data
   *
   * @param $new_instance - array of widget's save data
   * @param $old_instance - array of widget's save data
   *
   * @return $instance - array
   */
  public function update( $new_instance, $old_instance ) {
    return $new_instance;
  }
}


class theme_product_category_widget extends WP_Widget {
  /**
   * Default callback
   */
  function __construct() {
    parent::__construct(
       'theme-products-category-widget',
      __('Theme Product\'s Category Widgets', 'theme-translations'),
      array( 'description' => 'Displays list of styled links to product categories' )
    );
  }

  /**
   * prints widget html on frontend
   *
   * @param $args     - array with widget settings
   * @param $data - array of widget's save data
   */
  public function widget( $args, $data ) {
    if(!function_exists('wc_get_products')) return;
    $args = array(
      'limit' => -1,
      'post_per_page' => -1,
      'taxonomy'   => 'product_cat',
      'include'    => $data['category'],
      'hide_empty' => false,
    );

    $categories = get_terms($args);

    if($categories):
      echo  '<section class="categories"> <div class="container container_sm2"> <div class="row">';

      $num = 1;
      foreach ($categories as $id => $cat) {
        $image_id = get_term_meta($cat->term_id, 'thumbnail_id', true);
        $image_url = wp_get_attachment_image_url($image_id, 'icon');
        $prefix    = ($num < 10)? '0' : '';
        $image_url = ($image_id && (int)$image_id > 0)? $image_url :sprintf('%s/images/icons/c%s%s.png', THEME_URL, $prefix, $num);
        printf('<a href="%1$s" class="categories__item"><span class="categories__item-image"><img width="48" height="48" src="%2$s" alt="%3$s"></span><span class="categories__item-title"><span>%3$s</span></span></a>',
          esc_url(get_term_link($cat)),
          $image_url,
          esc_attr($cat->name)
        );

        $num++;
        $num = ($num>12)? 1 : $num;
      }

      echo '</div> </div> </section><div class="spacer-h-25"></div>';
    endif;
  }

  /**
   * prints widget form on WordPress widget area
   *
   * @param $data - array of widget's save data
   */
  public function form( $data ) {
   if(!function_exists('wc_get_products')) {
    echo 'you need to install WooCommerce';
    return;
  }
    $args = array(
      'limit' => -1,
      'post_per_page' => -1,
      'taxonomy'   => 'product_cat',
      'hide_empty' => false,
    );

    $categories = get_terms($args);

    echo "<h4>Select products' catefories to display<h4>";

    foreach ($categories as $id => $cat) {
        printf('<div><label for=""><input type="checkbox" id="%1$s" name="%2$s" value="%3$s" %5$s> %4$s</label></div>',
          $this->get_field_id( 'category['.$id.']' ),
          $this->get_field_name( 'category['.$id.']' ),
          $cat->term_id,
          $cat->name,
          (isset($data['category']) && in_array($cat->term_id, $data['category']))? 'checked="checked"' : ''
        );
    }

  }
  /**
   * saves widget data
   *
   * @param $new_instance - array of widget's save data
   * @param $old_instance - array of widget's save data
   *
   * @return $instance - array
   */
  public function update( $new_instance, $old_instance ) {
    return $new_instance;
  }
}


class theme_featured_articles_widget extends WP_Widget {
  /**
   * Default callback
   */
  function __construct() {
    parent::__construct(
       'theme-featured-articles-widget',
      __('Theme featured articles in blog', 'theme-translations'),
      array( 'description' => 'Displays preview of selected articles in blog list' )
    );
  }

  /**
   * prints widget html on frontend
   *
   * @param $args     - array with widget settings
   * @param $data - array of widget's save data
   */
  public function widget( $args, $data ) {
    $args = array(
      'limit' => -1,
      'post_per_page' => -1,
      'post_type'   => 'post',
      'include'   => $data['post'],
    );
     $posts = get_posts($args);
    ?>
      <section class="featured">
        <div class="container container_sm">

          <?php echo ($data['title'])? sprintf('<h2 class="blog-title">%s</h2>', esc_attr($data['title'])): '' ?>

          <?php echo ($data['comment'])? sprintf('<span class="blog-comment">%s</span>', esc_attr($data['comment'])): '' ?>

          <div class="row">
            <?php foreach ($posts as $key => $p):
              $date = DateTime::createFromFormat("Y-m-d H:i:s", $p->post_date_gmt);
              $args = array(
                'taxonomy' => 'category',
                'include'  => wp_get_post_categories($p->ID)
              );
              $categories  = get_terms($args);

              $category_html = array();

              foreach ($categories as $key => $c) {
                $category_html[] = sprintf('<a href="%s" class="article-preview__category">%s</a>', esc_url(get_term_link($c)), esc_attr($c->name));
              }

              $image      = get_the_post_thumbnail_url($p, 'blog_feed');
             ?>

            <div class="col-12 col-md-6">
              <div class="article-preview">
                <?php if ($image): ?>
                <div class="article-preview__image">
                  <a href="<?php echo esc_url(get_permalink($p)) ?>"><img src="<?php echo esc_url($image) ?>" alt="<?php echo esc_attr($p->post_title); ?>"></a>
                </div>
                <?php endif ?>
                <div class="cleafix"><?php echo implode( ', ',$category_html );?></div>
                <a href="<?php echo esc_url(get_permalink($p)) ?>" class="article-preview__title"><?php echo esc_attr($p->post_title) ?></a>
                <span class="article-preview__date"><?php echo $date->format('d F Y')?></span>
              </div>
            </div>
            <?php endforeach ?>

            <div class="col-12 col-md-6"></div>
          </div>
        </div>
      </section>


    <?php
  }

  /**
   * prints widget form on WordPress widget area
   *
   * @param $data - array of widget's save data
   */
  public function form( $data ) {

    echo '<h4>Title</h4>';

    printf('<input type="text" id="%s" name="%s" value="%s">',
         $this->get_field_id( 'title' ),
         $this->get_field_name( 'title' ),
         (isset($data['title']))? esc_attr($data['title']): ''
       );

    echo '<h4>Comment</h4>';
    printf('<input type="text" id="%s" name="%s" value="%s">',
         $this->get_field_id( 'comment' ),
         $this->get_field_name( 'comment' ),
         (isset($data['comment']))? esc_attr($data['comment']): ''
       );
    echo '<h4>Articles to show</h4>';
    $args = array(
      'limit' => -1,
      'post_per_page' => -1,
      'post_type'   => 'post',
    );

    $posts = get_posts($args);

    foreach ($posts as $id => $p) {
        printf('<div><label for=""><input type="checkbox" id="%1$s" name="%2$s" value="%3$s" %5$s> %4$s</label></div>',
          $this->get_field_id( 'post['.$id.']' ),
          $this->get_field_name( 'post['.$id.']' ),
          $p->ID,
          $p->post_title,
          (isset($data['post']) && in_array($p->ID, $data['post']))? 'checked="checked"' : ''
        );
    }
  }
  /**
   * saves widget data
   *
   * @param $new_instance - array of widget's save data
   * @param $old_instance - array of widget's save data
   *
   * @return $instance - array
   */
  public function update( $new_instance, $old_instance ) {
    return $new_instance;
  }
}

class theme_showcase_widget extends WP_Widget {
  /**
   * Default callback
   */
  function __construct() {
    parent::__construct(
       'theme-showcase-widget',
      __('Theme showcase row', 'theme-translations'),
      array( 'description' => 'Displays previews of selected showcases' )
    );
  }

  /**
   * prints widget html on frontend
   *
   * @param $args     - array with widget settings
   * @param $data - array of widget's save data
   */
  public function widget( $args, $data ) {
    ?>
      <section>
        <div class="container container_sm">
        <?php if (isset($data['title'])): ?>
        <h2 class="blog-title blog-title_md"><?php echo esc_attr($data['title']) ?></h2>
        <?php endif ?>
        <?php if (isset($data['comment'])): ?>
        <span class="blog-comment"><?php echo esc_attr($data['comment']) ?></span>
        <?php endif ?>
          <div class="row no-gutters products-md">
            <?php foreach ($data['post'] as $key => $post_id):
              $showcase = get_post($post_id);
              $image = get_the_post_thumbnail_url($showcase, 'showcase_thumb');
              ?>

              <a href="<?php echo esc_url(get_permalink($showcase)); ?>" class="showcase">
                <img data-src="<?php echo esc_url( $image ) ?>" class="showcase__image lazy-load" alt="" width="298" height="431"  style="width: 298px; height:431px">
                <span class="showcase__label">SHOWCASE</span>

                <span class="showcase__about">

                  <span class="showcase__title"><?php echo esc_attr($showcase->post_title); ?></span>
                    <span class="showcase__description">
                      <?php echo esc_attr(get_post_meta($post_id, '_showcase_description', true)) ?>
                      <br>
                      <i class="icon-arrow"></i>
                  </span>
                </span>
              </a>
            <?php endforeach ?>
          </div><!-- row -->
        </div><!-- container -->
      </section>
    <div class="spacer-h-120"></div>
    <?php
  }

  /**
   * prints widget form on WordPress widget area
   *
   * @param $data - array of widget's save data
   */
  public function form( $data ) {
    ?>
    <h4>Block title</h4>
    <textarea class="large-text" name="<?php echo $this->get_field_name( 'title' );?>" id="<?php echo $this->get_field_id( 'title' );?>" cols="30" rows="3"><?php echo (isset($data['title']))? esc_attr($data['title']) :'' ?></textarea>
    <h4>Block comment</h4>
    <textarea class="large-text" name="<?php echo $this->get_field_name( 'comment' );?>" id="<?php echo $this->get_field_id( 'comment' );?>" cols="30" rows="3"><?php echo (isset($data['comment']))? esc_attr($data['comment']) :'' ?></textarea>

    <?php

    echo '<h4>Showcases to show</h4>';
    $args = array(
      'limit' => -1,
      'post_per_page' => -1,
      'post_type'   => velesh_theme_posts::$showcase_name,
    );

    $posts = get_posts($args);

    foreach ($posts as $id => $p) {
        printf('<div><label for=""><input type="checkbox" id="%1$s" name="%2$s" value="%3$s" %5$s> %4$s</label></div>',
          $this->get_field_id( 'post['.$id.']' ),
          $this->get_field_name( 'post['.$id.']' ),
          $p->ID,
          $p->post_title,
          (isset($data['post']) && in_array($p->ID, $data['post']))? 'checked="checked"' : ''
        );
    }

    echo "<br><br>";
  }
  /**
   * saves widget data
   *
   * @param $new_instance - array of widget's save data
   * @param $old_instance - array of widget's save data
   *
   * @return $instance - array
   */
  public function update( $new_instance, $old_instance ) {
    return $new_instance;
  }
}


class theme_story extends WP_Widget {
  /**
   * Default callback
   */
  function __construct() {
    parent::__construct(
       'theme-featured-story-widget',
      __('Theme Customer story', 'theme-translations'),
      array( 'description' => 'Displays a customer story' )
    );
  }

  /**
   * prints widget html on frontend
   *
   * @param $args     - array with widget settings
   * @param $data - array of widget's save data
   */
  public function widget( $args, $o ) {
    $image = (isset($o['image_id']))? wp_get_attachment_image_url($o['image_id'], 'full'): DUMMY;
    $image1 = (isset($o['image_id_ad1']))? wp_get_attachment_image_url($o['image_id_ad1'], 'medium'): '';
    $image2 = (isset($o['image_id_ad2']))? wp_get_attachment_image_url($o['image_id_ad2'], 'medium'): '';
    $icon = (isset($o['icon_id']))?wp_get_attachment_image_url($o['icon_id'], 'icon') : '';
    ?>
    <div class="spacer-h-10"></div>
    <div class="spacer-h-10"></div>
      <section class="story">
        <div class="container container_sm">
          <div class="row">
            <div class="col-12 col-md-5">
              <?php if (isset($o['category'])): ?>
                <p class="story__label"><?php echo esc_attr($o['category']); ?>S</p>
              <?php endif ?>
              <span class="story__category">
                <span class="story__category-icon">
                  <img src="<?php echo esc_url($icon)?>" width="32" height="32" alt="">
                </span>
                <?php if (isset($o['subcategory'])): ?>
                  <span class="story__category-text"><?php echo esc_attr($o['subcategory']); ?></span>
                <?php endif ?>
              </span>
              <?php if (isset($o['subcategory'])): ?>
                <p class="story__description">
                  <?php echo isset($o['title'])? esc_attr($o['title']): ''; ?>
                </p>
              <?php endif ?>
              <?php if (isset($o['url'])): ?>
              <a href="<?php echo isset($o['url'])? esc_url($o['url']): ''; ?>" class="<?php echo isset($o['url'])?'trigger-video ': '' ?> story__cta"><?php echo isset($o['url_text'])? esc_attr($o['url_text']): $o['url']; ?></a>
              <?php endif ?>
            </div>
            <div class="col-12 col-md-6 offset-md-1">
              <div class="story__thumbnail">
                <div class="story__thumbnail-inner">
                  <img data-src="<?php echo esc_url($image)?>" class="story__image lazy-load" alt="<?php echo isset($o['title'])? esc_attr($o['title']): ''; ?>" width="470" >
                </div>
                <?php if ($image1): ?>
                <div class="story__thumbnail-abs pos1">
                  <img data-src="<?php echo esc_url($image1)?>" class="lazy-load" alt="<?php echo isset($o['title'])? esc_attr($o['title']): ''; ?>">
                </div>
                <?php endif ?>
                <?php if ($image2): ?>
                <div class="story__thumbnail-abs pos2">
                  <img data-src="<?php echo esc_url($image2)?>" class="lazy-load" alt="<?php echo isset($o['title'])? esc_attr($o['title']): ''; ?>">
                </div>
                <?php endif ?>
              </div>
            </div>
          </div><!-- row -->
        </div><!-- container -->
      </section>
    <div class="spacer-h-50"></div>
    <?php
  }

  /**
   * prints widget form on WordPress widget area
   *
   * @param $data - array of widget's save data
   */
  public function form( $data ) {
    $image = (isset($data['image_id']))? wp_get_attachment_image_url($data['image_id'], 'medium'): DUMMY;
    $image1 = (isset($data['image_id_ad1']))? wp_get_attachment_image_url($data['image_id_ad1'], 'medium'): DUMMY;
    $image2 = (isset($data['image_id_ad2']))? wp_get_attachment_image_url($data['image_id_ad2'], 'medium'): DUMMY;
    $icon = (isset($data['icon_id']))?wp_get_attachment_image_url($data['icon_id'], 'icon') : DUMMY;
    ?>
      <h4>Category title</h4>
      <input type="text" class="large-text" value="<?php echo (isset($data['category']))? esc_attr($data['category']): ''; ?>" name="<?php echo $this->get_field_name( 'category' ); ?>" id="<?php echo $this->get_field_id( 'category' ) ?>">

      <h4>Subcategory</h4>
      <input type="text" class="large-text" value="<?php echo (isset($data['subcategory']))? esc_attr($data['subcategory']): ''; ?>" name="<?php echo $this->get_field_name( 'subcategory' ); ?>" id="<?php echo $this->get_field_id( 'subcategory' ) ?>">

      <h4>Subcategory's icon</h4>

       <div class="image-download">
        <div class="image-placeholder icon">
          <img src="<?php echo esc_url($icon)?>" alt="">
        </div>
        <br><br>
        <input type="hidden"  name="<?php echo $this->get_field_name( 'icon_id' ); ?>" id="<?php echo $this->get_field_id( 'icon_id' ) ?>" class="image-id" value="<?php echo esc_attr($data['icon_id']) ?>">
        <a href="javascript:void(0)" class="button" onclick="load_image(this)">Set icon</a>
      </div>

      <h4>Title</h4>

      <textarea  name="<?php echo $this->get_field_name( 'title' ); ?>" id="<?php echo $this->get_field_id( 'title' ) ?>" class="large-text"  cols="30" rows="4"><?php echo isset($data['title'])? esc_attr($data['title']): ''; ?></textarea>

      <h4>Url for video</h4>
       <input type="text" class="large-text" value="<?php echo isset($data['url'])? esc_url($data['url']): ''; ?>"  name="<?php echo $this->get_field_name( 'url' ); ?>" id="<?php echo $this->get_field_id( 'url' ) ?>">

      <h4>Title for video</h4>
        <input type="text" class="large-text" value="<?php echo isset($data['url_text'])? esc_attr($data['url_text']): ''; ?>"  name="<?php echo $this->get_field_name( 'url_text' ); ?>" id="<?php echo $this->get_field_id( 'url_text' ) ?>">

        <h4>Video Sourse</h4>

        <label><input type="radio" value="youtube" <?php echo (isset($data['url_type']) && 'youtube' === $data['url_type'])? 'checked="checked"': ''; ?> name="<?php echo $this->get_field_name( 'url_type' ); ?>" id="<?php echo $this->get_field_id( 'url_type' ) ?>"> Youtube</label><br>
        <label><input type="radio" value="plain" <?php echo (isset($data['url_type']) && 'plain' === $data['url_type'])? 'checked="checked"': ''; ?> name="<?php echo $this->get_field_name( 'url_type' ); ?>" id="<?php echo $this->get_field_id( 'url_type' ) ?>">Video file on this site</label>

      <h4>Image</h4>

       <div class="image-download">
        <div class="image-placeholder">
          <img src="<?php echo esc_url($image)?>" alt="">
        </div>
        <input type="hidden"  name="<?php echo $this->get_field_name( 'image_id' ); ?>" id="<?php echo $this->get_field_id( 'image_id' ) ?>" class="image-id" value="<?php echo esc_attr($data['image_id']) ?>">
        <a href="javascript:void(0)" class="button" onclick="load_image(this)">Set image</a>
      </div>

      <h4>Additional image #1</h4>

       <div class="image-download">
        <div class="image-placeholder">
          <img src="<?php echo esc_url($image1)?>" alt="">
        </div>
        <input type="hidden"  name="<?php echo $this->get_field_name( 'image_id_ad1' ); ?>" id="<?php echo $this->get_field_id( 'image_id_ad1' ) ?>" class="image-id" value="<?php echo esc_attr($data['image_id_ad1']) ?>">
        <a href="javascript:void(0)" class="button" onclick="load_image(this)">Set image</a>
      </div>

      <h4>Additional image #2</h4>

       <div class="image-download">
        <div class="image-placeholder">
          <img src="<?php echo esc_url($image2)?>" alt="">
        </div>
        <input type="hidden"  name="<?php echo $this->get_field_name( 'image_id_ad2' ); ?>" id="<?php echo $this->get_field_id( 'image_id_ad2' ) ?>" class="image-id" value="<?php echo esc_attr($data['image_id_ad2']) ?>">
        <a href="javascript:void(0)" class="button" onclick="load_image(this)">Set image</a>
      </div>
    <?php
  }


  /**
   * saves widget data
   *
   * @param $new_instance - array of widget's save data
   * @param $old_instance - array of widget's save data
   *
   * @return $instance - array
   */
  public function update( $new_instance, $old_instance ) {
    return $new_instance;
  }
}





/**
 * registeres widgets
 *
 * @hookedto widgets_init 10
 */
function register_theme_widgets() {
  if(function_exists('wc')){
    register_widget( 'theme_product_category_widget' );
    register_widget( 'theme_product_widget' );
  }
  register_widget( 'theme_featured_articles_widget' );
  register_widget( 'theme_story' );
  register_widget( 'theme_showcase_widget' );
}

add_action( 'widgets_init', 'register_theme_widgets' );
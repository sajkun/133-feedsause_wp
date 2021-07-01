<?php
/**
 * The main output class
 *
 * @package theme/output
 *
 * @since v1.0
 */
class theme_content_output{

  /**
  * prints header
  *
  * @hookedto do_theme_header on home page 10
  */
  public static function print_header(){


    $main_menu = wp_nav_menu( array(
      'theme_location'  => 'main_menu',
      'menu'            => '',
      'container'       => '',
      'container_class' => '',
      'container_id'    => '',
      'menu_class'      => 'menu',
      'menu_id'         => '',
      'echo'            => false,
      // 'fallback_cb'     => '',
      'before'          => '',
      'after'           => '',
      'link_before'     => '',
      'link_after'      => '',
      'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
      'depth'           => 2,
      'walker'          => new main_menu_walker(),
    ) );
    $user_id = get_current_user_id();

    if(theme_construct_page::is_page_type('woo-cart')){
      $main_menu = '';
    }

    $header_class = '';
    $user_name  = '';

    if(function_exists('wc_get_account_endpoint_url')){
      $orders_url = wc_get_account_endpoint_url('orders');
      $customer   = new WC_Customer($user_id);
      $user_name  = $customer->get_first_name();
    }

    $my_account_id = get_option('woocommerce_myaccount_page_id');

    self::detect_header_classes();

    $style = (theme_construct_page::is_page_type('woo-my-account'))? 'background-color: #fff' : '';
    ?>
    <?php if (!theme_construct_page::is_page_type('woo-checkout') && !theme_construct_page::is_page_type('woo-cart')): ?>
      <style>
        .elementor-editor-active  .site-header{
          position: relative !important;
        }
      </style>
      <nav class="mobile-menu">
        <div class="mobile-menu__container"  <?php echo 'style="'.$style.'"'; ?> >
          <div class="mobile-menu__scroll">
            <?php
              if (!theme_construct_page::is_page_type('woo-my-account')) {
                $first_item    =  sprintf('<li class="menu-item starting-item"> <a href="%s">%s</a> </li>', HOME_URL, __('Home', 'theme-translations'));

                if(function_exists('wc_get_account_endpoint_url')){


                $last_item     = ((int)$my_account_id > 0 &&  $user_id <= 0)?
                 sprintf('<li class="menu-item last-item"> <a href="%s">%s</a> </li>', get_permalink($my_account_id), __('Log In', 'theme-translations'))
                 :
                sprintf('<li class="menu-item last-item"> <a href="%s">%s</a> </li>',  $orders_url, 'Hi, '.$user_name);
                ;
              }else{
                $last_item     = '';
              }

                $mobile_menu = wp_nav_menu( array(
                  'theme_location'  => 'main_menu',
                  'menu'            => '',
                  'container'       => '',
                  'container_class' => '',
                  'container_id'    => '',
                  'menu_class'      => 'mobile-menu__list',
                  'menu_id'         => '',
                  'echo'            => false,
                  // 'fallback_cb'     => '',
                  'before'          => '',
                  'after'           => '',
                  'link_before'     => '',
                  'link_after'      => '',
                  'items_wrap'      => '<ul id="%1$s" class="%2$s">'.$first_item.'%3$s'.$last_item .'</ul>',
                  'depth'           => 2,
                  'walker'          => new main_menu_walker(),
                ) );
                echo $mobile_menu;
              }else{
                echo "<div class='mobile-menu__list menu'>";
                  do_action( 'woocommerce_account_navigation' );
                echo "</div>";
              }
             ?>

            <div class="auth">

            <?php
              theme_content_output::print_header_button();
             ?>
            </div><!-- auth -->

          </div>
        </div>
      </nav>
   <?php endif; ?>

    <header class="site-header <?php echo apply_filters('print_header_class', $header_class); ?>">
      <div class="container container_sm">
        <a href="<?php echo HOME_URL; ?>" class="logo">
          <?php
            $custom_logo_id = get_theme_mod( 'custom_logo' );
            $custom_logo_url = wp_get_attachment_image_url( $custom_logo_id , 'full' );

            echo (empty(get_option('theme_header_logo_mob'))) ? sprintf('<span class="logo__icon logo__icon_b"><img src="%s" alt="" style="margin-top:8px"></span>', esc_url(THEME_URL.'/images/fs-logo-dark.svg')) : sprintf('<span class="logo__icon logo__icon_b"><img src="%s" alt=""></span>', esc_url(get_option('theme_header_logo_mob')));

            echo (empty(get_option('theme_header_logo_contrast_mob'))) ? '<span class="logo__icon logo__icon_w"><svg class="icon svg-icon-logo"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-logo"></use> </svg></span>': sprintf('<span class="logo__icon logo__icon_w"><img src="%s" alt=""></span>', esc_url(get_option('theme_header_logo_contrast_mob')));

            echo (empty(get_option('theme_header_logo_contrast'))) ? sprintf('<span class="logo__full logo__icon_w"><img src="%s/images/fs-logo-white.svg" alt=""></span>',THEME_URL): sprintf('<span class="logo__full logo__icon_w"><img src="%s" alt=""></span>', esc_url(get_option('theme_header_logo_contrast')));

            echo (empty(get_theme_mod( 'custom_logo' ))) ?
              sprintf('<span class="logo__full logo__icon_b"><img src="%s/images/fs-logo-dark.svg" alt=""></span>',THEME_URL):
              sprintf('<span class="logo__full logo__icon_b"><img src="%s" alt=""></span>', esc_url( $custom_logo_url ));
           ?>
        </a>

        <div class="mobile-menu-toggle"><span></span></div>
       <?php if (!theme_construct_page::is_page_type('woo-checkout')): ?>
        <nav  itemscope="itemscope" itemtype="http://schema.org/SiteNavigationElement" role="navigation" class="main-menu">

          <?php
            if (!theme_construct_page::is_page_type('woo-my-account')):
             echo $main_menu;
             else:
             do_action( 'woocommerce_account_navigation' );
            endif; ?>
        </nav>
        <?php endif; ?>

        <?php do_action('do_fly_basket'); ?>

        <div class="auth">
          <?php

            if(((int)$my_account_id  > 0) && ( $user_id <= 0)):  ?>
             <a href="<?php echo esc_url(get_permalink( $my_account_id ))?>" class="auth__link">Log In</a>
           <?php else: ?>
            <?php if (function_exists('wc_get_account_endpoint_url') && !theme_construct_page::is_page_type('woo-my-account')): ?>
             <a href="<?php echo $orders_url;?>" class="auth__link" title="<?php _e("See your orders", 'theme-translations') ?>">Hi, <?php echo $user_name; ?></a>
            <?php endif ?>

          <?php endif; ?>

          <?php
            theme_content_output::print_header_button();
           ?>
        </div><!-- auth -->
      </div><!-- container -->
    </header><!-- site-header -->
    <?php
  }

  public static function print_new_header(){

    if(is_account_page() && !is_user_logged_in()){
      return;
    }

    global $wp;
    $page = get_queried_object();

    $header_class = is_checkout() && !empty( is_wc_endpoint_url('order-received') ) ? 'contrast' : '';

    $custom_logo_id = get_theme_mod( 'custom_logo' );

    $custom_logo_url =  wp_get_attachment_image_url( $custom_logo_id , 'full' );

    $logo = (empty(get_theme_mod( 'custom_logo' ))) ?
              sprintf('<a href="%s"  class="logo"><img src="%s/images/logo-new.svg" alt=""></a>',get_home_url(), THEME_URL):
              sprintf('<a  href="%s" class="logo"><img src="%s" alt=""></a>',get_home_url(),  esc_url( $custom_logo_url ));

    $logo =  $header_class == 'contrast'  || isset($wp->query_vars['my-gallery'])? sprintf('<a href="%s"  class="logo"><img src="%s/images/logo_contrast.png" alt=""></a>', get_home_url(), THEME_URL): $logo;

    $user_id = get_current_user_id();

    if(theme_construct_page::is_page_type('woo-cart')){
      $main_menu = '';
    }

    $header_class = '';
    $user_name  = '';

    if(function_exists('wc_get_account_endpoint_url')){
      $orders_url = wc_get_account_endpoint_url('orders');
      $customer   = new WC_Customer($user_id);
      $user_name  = $customer->get_first_name();
    }

    $my_account_id = get_option('woocommerce_myaccount_page_id');

    if(wp_is_mobile()):
        $login_url =  $my_account_id? get_permalink( $my_account_id) : false;
        $login_text =  $user_id == 0 ? "Log In" : 'My Account';
        $addon = $login_url? sprintf('<li class="menu-item last-item"> <a href="%s">%s</a> </li>', $login_url,  $login_text) : '';

        if( is_account_page()){
          global $wp;

          $url_shoots = wc_get_account_endpoint_url('orders');
          $url_shoots_active = is_account_page() && is_wc_endpoint_url('orders') || is_wc_endpoint_url('view-order')? 'active' : '';
          $url_gallery = wc_get_account_endpoint_url('my-gallery');
          $url_gallery_active = isset($wp->query_vars['my-gallery']) ? 'active' : '';

          $main_menu = sprintf('<nav class="main-menu centered"><ul class="mobile-menu__list"> <li class="%s"><a href="%s"><svg class=" svg-icon-dots-2"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-dots-2"></use> </svg> Shoots</a></li> <li class="%s"><a href="%s"><svg class=" svg-icon-gallery"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-gallery"></use> </svg> Gallery</a></li> </ul></nav>',
            $url_shoots_active,
            $url_shoots,
            $url_gallery_active,
            $url_gallery
         );
        }else{
          $main_menu = wp_nav_menu( array(
            'theme_location'  => 'main_menu',
            'menu'            => '',
            'container'       => '',
            'container_class' => '',
            'container_id'    => '',
            'menu_class'      => 'mobile-menu__list',
            'menu_id'         => '',
            'echo'            => false,
            // 'fallback_cb'     => '',
            'before'          => '',
            'after'           => '',
            'link_before'     => '',
            'link_after'      => '',
            'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s'. $addon .'</ul>',
            'depth'           => 2,
            'walker'          => new main_menu_walker(),
          ) );
        }

      $header_class = is_checkout() && !empty( is_wc_endpoint_url('order-received') ) ? ' contrast ' : '';
      $hide_menu = is_checkout() && !empty( is_wc_endpoint_url('order-received') ) ? true : false;

      $args = array(
        'header_class'   => $header_class,
        'logo'   => $logo,
        'hide_menu'   => $hide_menu,
        'main_menu'   => $main_menu,
        'avatar_url'     => $user_id >0 ? get_avatar_url($user_id) : '',
        'is_account_page' => is_account_page() && is_wc_endpoint_url('orders') ||  is_wc_endpoint_url('view-order') ||  isset($wp->query_vars['my-gallery']) ,
      );

      print_theme_template_part('header-mobile-new', 'globals', $args);

    else:
     if( is_account_page()){

      global $wp;

      $url_shoots = wc_get_account_endpoint_url('orders');
      $url_shoots_active = is_account_page() && is_wc_endpoint_url('orders') ||  is_wc_endpoint_url('view-order') ? 'active' : '';
      $url_gallery = wc_get_account_endpoint_url('my-gallery');
      $url_gallery_active = isset($wp->query_vars['my-gallery']) ? 'active' : '';

      $main_menu = sprintf('<nav class="main-menu"><ul class="menu"> <li class="%s"><a href="%s"><svg class="icon svg-icon-dots-2"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-dots-2"></use> </svg> Shoots</a></li> <li class="%s"><a href="%s"><svg class="icon svg-icon-gallery"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-gallery"></use> </svg>Gallery</a></li> </ul></nav>',
        $url_shoots_active,
        $url_shoots,
        $url_gallery_active,
        $url_gallery
     );

     }else{
        $main_menu = wp_nav_menu( array(
          'theme_location'  => 'main_menu',
          'menu'            => '',
          'container'       => 'nav',
          'container_class' => 'main-menu',
          'container_id'    => '',
          'menu_class'      => 'menu',
          'menu_id'         => '',
          'echo'            => false,
          // 'fallback_cb'     => '',
          'before'          => '',
          'after'           => '',
          'link_before'     => '',
          'link_after'      => '',
          'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
          'depth'           => 2,
          'walker'          => new main_menu_walker(),
        ) );
     }


      $header_class = is_checkout() && !empty( is_wc_endpoint_url('order-received') ) ? ' contrast ' : '';

      $header_class .=  is_account_page() || is_checkout()?  ' underline ' : '';

      $main_menu = is_checkout()? '<nav class="main-menu"><ul class="menu"><li class="menu-item active"><a href="#">Create</a></li></ul></nav>' : $main_menu ;
      $shop_url = function_exists('woocommerce_get_page_id')? get_permalink( woocommerce_get_page_id( 'shop' ) ) : false;

      $args = array(
        'logo'           => $logo,
        'shop_url'       => $shop_url,
        'header_class'   => $header_class,
        'main_menu'      => $main_menu,
        'user_id'        => $user_id,
        'user_name'      => $user_name,
        'avatar_url'     => $user_id >0 ? get_avatar_url($user_id) : '',
        'account_url'      => $my_account_id? wc_get_account_endpoint_url('orders') : false,
      );

      print_theme_template_part('header-desktop-new', 'globals', $args);
    endif;
  }

  public static function print_new_header_dark(){

    if(is_account_page() && !is_user_logged_in()){
      return;
    }

    global $wp;
    $page = get_queried_object();

    $right_menu = wp_nav_menu( array(
      'theme_location'  => 'main_menu_right',
      'menu'            => '',
      'container'       => '',
      'container_class' => '',
      'container_id'    => '',
      'menu_class'      => 'right-menu',
      'menu_id'         => '',
      'echo'            => false,
      // 'fallback_cb'     => '',
      'before'          => '',
      'after'           => '',
      'link_before'     => '',
      'link_after'      => '',
      'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
      'depth'           => 2,
    ));

    $custom_logo_id = get_theme_mod( 'custom_logo' );
    $custom_logo_url = wp_get_attachment_image_url( $custom_logo_id , 'full' );
    $custom_logo_url = THEME_URL.'/images/logo_contrast.png';
    global $wp_registered_sidebars, $wp_registered_widgets;

    $sidebars_widgets = wp_get_sidebars_widgets();

    $myaccount_page_id = get_option( 'woocommerce_myaccount_page_id' );

    if ( $myaccount_page_id ) {

      $logout_url = wp_logout_url( get_permalink( $myaccount_page_id ) );

      if ( get_option( 'woocommerce_force_ssl_checkout' ) == 'yes' )
        $logout_url = str_replace( 'http:', 'https:', $logout_url );
    }

    $url_shoots = wc_get_account_endpoint_url('orders');
    $url_gallery = wc_get_account_endpoint_url('my-gallery');

    $user_id = get_current_user_id();

    $myaccount_page_id = get_option( 'woocommerce_myaccount_page_id' );
    if ( $myaccount_page_id ) {
      $myaccount_page_url = get_permalink( $myaccount_page_id );
    }

    $username = get_user_meta( $user_id, 'first_name', true );



    $shop_url = function_exists('woocommerce_get_page_id')? get_permalink( woocommerce_get_page_id( 'shop' ) ) : false;

    if(is_product()){
     global $product;
     $product_id = $product->get_id();
     $shop_url = get_permalink(get_option('theme_page_constructor'));
     $myaccount_page = get_option( 'woocommerce_myaccount_page_id' );
     $myaccount_page_url = get_permalink( $myaccount_page );
     $shop_url = is_user_logged_in() ? $shop_url.'?product_id='.$product_id.'?add_to_cart='.$product_id : $myaccount_page_url.'?product_id='.$product_id ;
    }



    $args = array(
      'username'            => $username,
      'custom_logo_url'     => $custom_logo_url,
      'myaccount_page_url'  => $myaccount_page_url,
      'url_shoots'          => $url_shoots,
      'url_gallery'         => $url_gallery,
      'user_id'             => $user_id,
      'logout_url'          => $logout_url,
      'right_menu'          => $right_menu,
      'avatar_url'          => $user_id > 0 ? get_avatar_url($user_id) : '',
      'shop_url'            => $shop_url,
    );

    print_theme_template_part('header-new', 'globals', $args);
    print_theme_template_part('header-mobile-new2', 'globals', $args);
  }

  public static function print_footer_new_dark(){
    $custom_logo_id = get_theme_mod( 'custom_logo' );
    $custom_logo_url = wp_get_attachment_image_url( $custom_logo_id , 'full' );
    $custom_logo_url = THEME_URL.'/images/logo_contrast.png';

    $copyrights =  get_option('theme_footer_copyrights');
    $today = new DateTime();
    $year = $today->format('Y');
    $copyrights = str_replace('{year}', $year, $copyrights );


    $args = array(
      'custom_logo_url'      => $custom_logo_url,
      'copyrights'      => $copyrights,
    );
    print_theme_template_part('footer-new', 'globals', $args);
  }


  /*
  * prints header button
  */
  public static function print_header_button(){
    $active_plugins = get_option('active_plugins');

     $button_intercom = (in_array('intercom/bootstrap.php', $active_plugins))? '<a href="javascript:void(0)" class="button button_chat" onclick="Intercom(\'show\')"> <span class="item item1"></span> <span class="item item2"></span> <span class="item item3"></span> Live Support </a>' : "";

    if (theme_construct_page::is_page_type('woo-shop') || theme_construct_page::is_page_type('woo-shop-category') ||  theme_construct_page::is_page_type('woo-product') || theme_construct_page::is_page_type('woo-checkout') || theme_construct_page::is_page_type('woo-cart') ) {
       echo $button_intercom;
    } else if(theme_construct_page::is_page_type('woo-my-account') ){
       echo $button_intercom;
       ?>
       <a href="<?php echo get_permalink( wc_get_page_id( 'shop' ) );?>" class="button button_header"><span class="plus"></span> <span>Book Now</span></a>
      <?php
    } else{
      if (function_exists('wc_get_page_id') && (wc_get_page_id( 'shop' ) >=0 )): ?>
       <a href="<?php echo get_permalink( wc_get_page_id( 'shop' ) );?>" class="button button_header"><span class="plus"></span> <span>Book Now</span></a>
    <?php
      endif;
    }
  }


  /*
  * prints header
  *
  * defines constat for header class detections
  */
  public static function detect_header_classes(){
    global $pagenow;

    $hero_image = wp_get_attachment_image($pagenow) ;

    if( $hero_image ){
      define('THEME_HERO_SECTION', true);
    }
  }


  /**
  * Prints page content
  */
  public static function print_page_content(){
    $post = get_queried_object();


    switch ($post->ID) {
      case (int)get_option('theme_page_customers'):
        do_action('customers_page_content');
        break;
      case (int)get_option('theme_page_showcase'):
        do_action('showcase_archive_page_content');
        break;

      case (int)get_option('theme_page_pricing'):

      ?>
      <div class="spacer-h-70"></div>
      <div class="container">
        <?php do_action('pricing_page_content'); ?>
      </div><!-- container -->
      <div class="spacer-h-50"></div>

      <?php do_action('pricing_page_moto'); ?>

      <div class="textcenter">
      <?php
      $active_plugins = get_option('active_plugins');

       $button_intercom = (in_array('intercom/bootstrap.php', $active_plugins))? sprintf('<a href="javascript:void(0)" class="button button_chat" onclick="Intercom(\'show\')"> <span class="item item1"></span> <span class="item item2"></span> <span class="item item3"></span>%s </a>' , __(' Got a Question? Chat Live','theme-translations')) :'';

       echo $button_intercom;
      ?>
      <div class="spacer-h-80"></div>
      <?php
        $args = array(
          'posts_per_page' => -1,
          'limit' => -1,
          'post_type' => 'theme_faq',
          'orderby'        => 'date',
          'order'          => 'DESC'
        );
        $faq = get_posts($args);
        if (!$faq) {
          echo '<div class="divider-blue"></div>';
          break;
        }
        ?>
        <div class="white">
         <?php do_action('page_faq_section', $faq ); ?>
        </div>
      <div class="divider-blue"></div>
      <?php
        break;
      case (int)get_option('theme_page_support'):
        ?>
        <div class="spacer-h-50"></div>
        <?php do_action('support_page_content') ?>
        <div class="spacer-h-30"></div>
        <?php do_action('page_faq_section') ?>
        <?php
        break;

      default:
      $queried = get_queried_object();
      $o = get_post_meta($queried->ID, '_header_style', true);

        if(!is_home() && ('contrast' !== $o)  && !is_front_page() &&
         (is_account_page() && is_user_logged_in()) &&
         !theme_construct_page::is_page_type('woo-my-account') && !theme_construct_page::is_page_type('showcase') && !theme_construct_page::is_page_type('customer') && ! ( is_checkout() && !empty( is_wc_endpoint_url('order-received') ) )){
          echo '<div class="spacer-h-40"></div>';
        }

        // $do_wrap = !is_page() && !is_home() && !is_front_page() && !theme_construct_page::is_page_type('woo-my-account') ;

        $do_wrap = false;

        if( $do_wrap){
          echo '<div class="container container_sm">';
        }

        echo apply_filters('the_content', $post->post_content);

        if ($do_wrap){
          echo '</div>';
        }

        if(!is_home() && !is_front_page() && !theme_construct_page::is_page_type('woo-my-account') && !theme_construct_page::is_page_type('showcase') && !theme_construct_page::is_page_type('customer')  && ! ( is_checkout() && !empty( is_wc_endpoint_url('order-received') ) )){
            // echo '<div class="spacer-h-50"></div>';
        }
        break;
    }
  }


  /**
  * prints showcase archive
  */
  public static function print_showcase_archive(){
    $title = esc_attr(get_option('showcase_title'));
    $search = esc_attr(get_option('showcase_title_marked'));
    $replace = sprintf('<span class="marked">%s</span>',$search );
    $title   = str_replace($search, $replace, $title);
    $args = array(
      'limit' => -1,
      'post_per_page' => -1,
      'post_type'   => velesh_theme_posts::$showcase_name,
    );

    $showcases = get_posts($args);
    ?>
      <div class="showcase-hero">
        <div class="spacer-h-100"></div>
        <div class="container container_sm">
          <h2 class="showcase-hero__title">
            <i class="icon-heart"></i>
            <i class="icon-cool"></i>
            <i class="icon-vote"></i>
            <i class="icon-smile"></i>
           <?php echo $title; ?>
          </h2>

          <p class="showcase-hero__comment"><?php echo esc_attr(get_option('showcase_comment')); ?></p>
        </div><!-- container -->

        <div class="clearfix"></div>
          <div class="<?php echo (count($showcases)> 2)? 'slider-images owl-slider' : 'container container_sm' ; ?>">
            <?php foreach ($showcases as $key => $showcase):
              $image = get_the_post_thumbnail_url($showcase, 'showcase_thumb');
              ?>
              <a href="<?php echo esc_url(get_permalink($showcase)); ?>" class="showcase">
                <img src="<?php echo esc_url( $image ) ?>" class="showcase__image" alt="">
                <span class="showcase__label">SHOWCASE</span>

                <span class="showcase__about">

                  <span class="showcase__title"><?php echo esc_attr($showcase->post_title); ?></span>
                    <span class="showcase__description">
                      <?php echo esc_attr(get_post_meta($showcase->ID, '_showcase_description', true)) ?>
                      <br>
                      <i class="icon-arrow"></i>
                  </span>
                </span>
              </a>
            <?php endforeach ?>
        </div>
        <div class="spacer-h-80"></div>
      </div>
    <?php
  }


  /**
  * prints support
  */
  public static function print_support(){
    $title = esc_attr(get_option('support_title'));
    $search = esc_attr(get_option('support_title_marked'));
    $replace = sprintf('<span class="marked marked_blue">%s</span>',$search );
    $title   = str_replace($search, $replace, $title);
    $shortcode = '';

    $plugins = [
      'contact-form-7/wp-contact-form-7.php','wpforms/wpforms.php',
    ];
    $active_plugins = get_option('active_plugins');

    $multiple_plugins = false;
    $count_plugins    = 0;
    foreach ($plugins as $p) {
      if(in_array($p, $active_plugins)){
        $count_plugins++;
      }
    }


    if(get_option('theme_page_support_form_type') && $count_plugins > 1){
      switch (get_option('theme_page_support_form_type')) {
        case 'cf7':
          $form = get_post((int)get_option('theme_page_support_form'));
          $shortcode = sprintf('[contact-form-7 id="%s" title="%s"]', $form->ID, $form->post_title);
          break;
        case 'wpf':
          $form = (int)get_option('theme_page_support_form_wpf');
          $shortcode = sprintf('[wpforms id="%s"]', $form);
          break;
      }
    }else{


      if(in_array('contact-form-7/wp-contact-form-7.php', $active_plugins)){
        $form = get_post((int)get_option('theme_page_support_form'));
        $shortcode = sprintf('[contact-form-7 id="%s" title="%s"]', $form->ID, $form->post_title);
      }elseif(in_array('wpforms/wpforms.php', $active_plugins)){
        $form = (int)get_option('theme_page_support_form_wpf');
        $shortcode = sprintf('[wpforms id="%s"]', $form);
      }
    }
    ?>
    <div class="container container_sm support-section">
      <h2 class="page-title page-title_xl textcenter">
        <?php echo $title ?>
      </h2>
      <div class="textcenter">
        <p class="page-title__comment  page-title__comment_xl">
          <?php echo esc_attr(get_option('support_comment')); ?>
        </p>
      </div>
    </div>
      <?php if ($shortcode): ?>
    <div class="spacer-h-90"></div>
    <div class="container container_sm contact-form">
      <div class="row">
        <div class="col-12 col-md-11 offset-md-1">
            <h2 class="contact-form__title">
              How can we help you?
            </h2>

            <p class="contact-form__comment">
              Please provide some information to help us handle your request
            </p>
        </div>
      </div>

      <div class="row">
        <div class="col-12 col-md-7 offset-md-1">
          <div class="fix-width-2 form-wrapper">
            <?php echo do_shortcode( $shortcode ); ?>
          </div>
        </div>
        <div class="col-12 col-md-4">
          <div class="footer-info shift-lg-2 shift-top-xs-30">
              <?php $hidden = empty(get_option('theme_footer_schedule'))? 'hidden': ''; ?>
              <div class="schedule <?php echo $hidden; ?>">
                <i class="schedule__icon"></i>
                <?php
                 $schedule = esc_attr(get_option('theme_footer_schedule'));
                 if ( $schedule ):
                  $dots = ':</span> <span class="schedule__hours">';
                  $schedule = (strpos( $schedule, ':' ))? str_replace(':', $dots, $schedule) : $schedule;
                 endif;
                 printf('<span class="schedule__days">%s</span>', $schedule);
                  ?>
              </div><!-- schedule -->


              <div>
                <?php
                 $phone = esc_attr(get_option('theme_footer_phone'));
                 $hidden = ($phone)? '': 'hidden';
                 $replace = '</span> ';
                 $phone_html = ((strpos( $phone, '+' )>=0) && strpos( $phone, ' ' ))? str_replace_once(' ', $replace, $phone): $phone ;

                $phone_url = str_replace( array(' ', '(', ')', '[',']','.',':'), '', $phone);

                echo((strpos( $phone, '+' )>=0) && strpos( $phone, ' ' ))? sprintf('<a href="tel:%s" class="phone %s">%s%s</a>', $phone_url, $hidden, '<span class="code">', $phone_html) : sprintf('<a href="tel:%s" class="phone">%s</a>', $phone_url,  $phone_html);
                ?>
              </div>

              <div>
                <?php
                 $email = esc_attr(get_option('theme_footer_email'));
                 if ($email):
                  printf('<a href="mailto:%1$s" class="email">%1$s</a>',$email);
                 endif ?>
              </div>
              <?php
               $address = esc_attr(get_option('theme_footer_address'));
               if ($address):
                printf('<address class="address"><pre>%1$s</pre></address>',$address);
               endif ?>

            <div class="clearfix">
              <div class="socials textleft left-pos">
                <?php $socials = array(
                  'instagram' => 'instagram',
                  'facebook'  => 'fb',
                  'twitter'   => 'twitter'
                ); ?>
              </div>
                  <?php foreach ($socials as $channel => $icon):
                    $name = 'theme_footer_'.$channel;
                     if((get_option($name))):
                       printf('<a href="%2$s" target="_blank" class="socials__icons"><svg class="icon svg-icon-%1$s"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-%1$s"></use> </svg></a>',
                         $icon,
                         esc_url(get_option($name))
                       );
                     endif;
                   endforeach ?>
              </div>
            </div>

          </div>
      </div>
      </div>
      <?php endif ?>
    <?php
  }


  /**
  * prints pricing
  */
  public static function print_pricing() {
    $o = get_option('theme_settings');
    // if(function_exists('wc_get_product') && $o){
    //   $subscription = wc_get_product((int)$o['subscription']);
    //   if($subscription){
    //     $price_per = get_post_meta( $subscription->get_id(), '_ywsbs_price_is_per', '1' );
    //   $price_per_period_name = get_post_meta( $subscription->get_id(), '_ywsbs_price_time_option', 'days' );
    //   }
    // } else{
    //   $subscription = false;
    // }
    $subscription = false;
    $title   = esc_attr(get_option('pricing_title'));
    $search  = esc_attr(get_option('pricing_title_marked'));
    $replace = sprintf('<span class="marked marked_blue">%s</span>',$search );
    $title   = str_replace($search, $replace, $title);


    ?>
    <h2 class="pricing__moto textcenter">
      <?php echo $title ?>
    </h2>
    <p class="pricing__comment textcenter"><?php echo esc_attr(get_option('pricing_comment')) ?></p>
    <div class="textcenter">
      <img src="<?php echo THEME_URL ?>/images/c/banners.png" alt="">
    </div>
    <div class="decoration2">
      <i class="icon-cool"></i>
      <i class="icon-heart"></i>
      <i class="icon-smile"></i>
      <i class="icon-vote"></i>
    </div>

    <div class="row justify-content-center">
      <div class="pricing-item pricing-item_free hidden">
        <div class="pricing-item-inner">
          <div class="pricing-item-free">
            <div class="textcenter">
               <span class="pricing-item-tag free"><?php _e('READY IN', 'theme-translations'); ?> <?php echo get_ready_date_offset(false, 'text') ?>  <?php  _e('DAYS','theme-translations'); ?></span>
            </div>
            <p class="pricing-item-free-title textcenter">
              <span><?php _e('Click & Create','theme-translations'); ?></span>
            </p>
            <p class="pricing-item-comment textcenter"><?php _e('1 product per order','theme-translations'); ?>, <?php _e('pay as you go','theme-translations'); ?></p>
            <?php if($o && isset($o['single_product_price'])):?>
            <p class="textcenter free-price">
              <span class="value"><?php echo wc_price($o['single_product_price']) ?></span>/<?php _e('image','theme-translations'); ?>
            </p>
            <?php endif; ?>
          </div>

          <span class="pricing-item__spacer"></span>

          <div class="pricing-item-tags">
            <p class="pricing-item-title2"><?php _e('Image Sizes','theme-translations'); ?></p>
            <div class="tag-cloud">
              <span class="tag-cloud__item active">
                <svg class="icon svg-icon-instagram"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-instagram"></use> </svg>
                <span class="text">
                  Instagram
                </span>
                <i class="icon-status"></i>
              </span>
              <span class="tag-cloud__item not-active">
                <svg class="icon svg-icon-fb"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-fb"></use> </svg>
                <span class="text">
                  Facebook
                </span>
                <i class="icon-status"></i>
              </span>
              <span class="tag-cloud__item not-active">
                <svg class="icon svg-icon-snap"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-snap"></use> </svg>
                <span class="text">
                  Stories
                </span>
                <i class="icon-status"></i>
              </span>
              <span class="tag-cloud__item not-active">
                <svg class="icon svg-icon-hd"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-hd"></use> </svg>
                <span class="text">
                  Full HD
                </span>
                <i class="icon-status"></i>
              </span>
            </div><!-- tag-cloud -->

            <p class="pricing-item-title2"><?php _e('License','theme-translations'); ?></p>

            <div class="tag-cloud">
              <span class="tag-cloud__item active">
                <span class="text">
                  Social &amp; Web
                </span>
                <i class="icon-status"></i>
              </span>
              <span class="tag-cloud__item not-active">
                <span class="text">
                  Advertising
                </span>
                <i class="icon-status"></i>
              </span>
            </div><!-- tag-cloud -->
           <?php if (function_exists('wc_get_page_id') && wc_get_page_id( 'shop' ) >=0):?>
            <a href="<?php echo get_permalink( wc_get_page_id( 'shop' ) );?>" class="pricing-item__submit free">
              <span class="plus"></span>
              <?php _e('Create My Images','theme-translations'); ?>
            </a>
           <?php endif ?>

          </div><!-- pricing-item-tags -->
        </div><!-- pricing-item-inner -->
      </div><!-- pricing-item -->

      <div class="pricing-item pricing-item_prem">
        <div class="pricing-item-inner">
          <div class="pricing-item-premium">
            <div class="textcenter">
               <span class="pricing-item-tag"><?php _e('READY IN','theme-translations'); ?> <?php echo get_ready_date_offset(true, 'text') ?> <?php _e('DAYS','theme-translations'); ?></span>
            </div>
            <p class="pricing-item-premium-title textcenter">
              <span><?php _e('Click & Create','theme-translations'); ?></span>
            </p>
            <p class="pricing-item-comment textcenter white"><?php _e('Pay as you go custom photos','theme-translations'); ?>.</p>

            <p class="textcenter white premium-price">
              <span class="value"><?php
              $theme_options = get_option('theme_settings');

              $price = ($theme_options && isset($theme_options['single_product_price']))? $theme_options['single_product_price'] : 30;
              echo wc_price($price );
               ?></span>/<?php
              echo 'per image';
              ?>
            </p>

          </div>

          <div class="pricing-item-tags">
            <p class="pricing-item-title2"><?php _e('Image Sizes','theme-translations'); ?></p>
            <div class="tag-cloud">
              <span class="tag-cloud__item active">
                <svg class="icon svg-icon-instagram"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-instagram"></use> </svg>
                <span class="text">
                  Instagram
                </span>
                <i class="icon-status"></i>
              </span>
              <span class="tag-cloud__item active">
                <svg class="icon svg-icon-fb"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-fb"></use> </svg>
                <span class="text">
                  Facebook
                </span>
                <i class="icon-status"></i>
              </span>
              <span class="tag-cloud__item active">
                <svg class="icon svg-icon-snap"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-snap"></use> </svg>
                <span class="text">
                  Stories
                </span>
                <i class="icon-status"></i>
              </span>
              <span class="tag-cloud__item active">
                <svg class="icon svg-icon-hd"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-hd"></use> </svg>
                <span class="text">
                  Full HD
                </span>
                <i class="icon-status"></i>
              </span>
            </div><!-- tag-cloud -->

            <p class="pricing-item-title2"><?php _e('License','theme-translations'); ?></p>

            <div class="tag-cloud">
              <span class="tag-cloud__item active">
                <span class="text">
                  Social &amp; Web
                </span>
                <i class="icon-status"></i>
              </span>
              <span class="tag-cloud__item active">
                <span class="text">
                  Advertising
                </span>
                <i class="icon-status"></i>
              </span>
            </div><!-- tag-cloud -->

            <p class="pricing-item-text textcenter"><?php _e('Plus access to','theme-translations'); ?> <b><?php _e('All Premium Recipes','theme-translations'); ?></b></p>
            <div class="spacer-h-10"></div>

              <a href="<?php echo get_permalink( woocommerce_get_page_id( 'shop' ) ); ?>" class="pricing-item__submit free">
                 <svg class="icon svg-icon-unlock"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-unlock"></use> </svg>
                <span><?php _e('Start Creating','theme-translations'); ?></span>
              </a>
              <br><br>
          </div><!-- pricing-item-tags -->
        </div><!-- pricing-item-inner -->
      </div><!-- pricing-item -->
    </div>
    <?php
  }


  /**
  * Prints F.A.Q.
  *
  * @param $faq - array of WP_Post objects
  */
  public static function print_faq($faq = false){
    if(!$faq){
      $args = array(
        'posts_per_page' => -1,
        'limit' => -1,
        'post_type' => 'theme_faq',
        'orderby'        => 'date',
        'order'          => 'DESC'
      );
      $faq = get_posts($args);
    }

    if(!$faq ) return;
    ?>
    <section class="faq">
      <div class="spacer-h-60"></div>
      <div class="container container_sm">
        <h2 class="faq__block-title textcenter"><?php _e('Frequently Asked Questions', 'theme-translations');?></h2>
        <div class="row">
          <?php foreach ($faq as $key => $post):
            $q = get_post_meta($post->ID, '_question', true);
            $a = get_post_meta($post->ID, '_answer', true);
            if(!$a) continue;
            ?>

          <div class="col-12 col-md-6">
            <p class="faq__title"><?php echo (!empty($q))? esc_attr($q): esc_attr($post->title); ?></p>
            <p class="faq__text"><?php echo  esc_attr($a); ?></p>
          </div>
          <?php endforeach ?>
        </div>
      </div>
      <div class="spacer-h-45"></div>
    </section>
    <?php
  }

  /**
  * Prints page footer
  */
  public static function print_footer(){
    $class = (theme_construct_page::is_page_type('woo-checkout') || theme_construct_page::is_page_type('woo-my-account') || theme_construct_page::is_page_type('woo-cart') )? 'site-footer_minified' : '';
    $class_copy = (theme_construct_page::is_page_type('woo-checkout') || theme_construct_page::is_page_type('woo-my-account') || theme_construct_page::is_page_type('woo-cart') )? 'col-12 col-md-6  order-1 order-sm-0' : 'col-12 col-md-5 offset-lg-1 order-1 order-sm-0 fix-gaps-1';
    ?>
    <footer class="site-footer <?php echo $class ?>">
      <?php if (!theme_construct_page::is_page_type('woo-checkout')): ?>
      <div class="spacer-prefooter"></div>
      <?php endif ?>
      <div class="container container_sm">
        <?php if (!theme_construct_page::is_page_type('woo-checkout') && !theme_construct_page::is_page_type('woo-my-account') && !theme_construct_page::is_page_type('woo-cart') ): ?>
        <div class="row">
          <div class="col-12 col-md-6 col-lg-2 order-1 order-lg-0 offset-lg-1 fix-gaps-1">
            <div class="footer-info">

            <?php if (is_front_page()): ?>
            <span class="logo"><img src="<?php echo THEME_URL.'/images/fs-new.svg';?>" alt="feedsause"></span>
            <?php else: ?>
            <a href="<?php echo HOME_URL; ?>" class="logo"><img src="<?php echo THEME_URL.'/images/fs-new.svg';?>" alt="feedsause"></a>
            <?php endif ?>

            <?php if (function_exists('wc')): ?>
            <div class="select-imitation">
              <input type="hidden" value="gbp" class="select-imitation__data">
              <?php
              $currencies         = get_woocommerce_currencies();
              $selected_currency  = isset($_COOKIE['theme-currency'])? $_COOKIE['theme-currency'] : get_woocommerce_currency();
              $default_currency = get_woocommerce_currency();
              $o    = get_option('woo_theme_currency');
              $countries_obj = new WC_Countries();
              $countries = $countries_obj->get_countries();
              $currency_countries = get_currency_countries();

              ?>
              <?php if (isset($o['items'])):
                $items = $o['items'];
              ?>
              <div class="select-imitation__value" >
                <?php
                $src = get_country_flag_url_by_currency($selected_currency);
                 if (file_exists($src['path'])): ?>
                <img width="20" height="13" src="<?php echo $src['url']; ?>" alt="<?php echo $selected_currency ?>" <?php  echo 'style="display:inline-block; vertical-align: middle"' ?> >
                <?php endif ?>
                <span><?php echo get_woocommerce_currency_symbol($selected_currency) ?> <?php echo $selected_currency ?></span>
              </div>
              <div class="select-imitation__dropdown">
                <ul class="select-imitation__list">
                  <li data-currency="<?php echo $default_currency ?>" onclick="set_currency('<?php echo $default_currency ?>');">
                    <?php
                    $src = get_country_flag_url_by_currency($default_currency);
                    if (file_exists($src['path'])): ?>
                     <img width="20" height="13" src="<?php echo $src['url']; ?>" alt="<?php echo $default_currency ?>" <?php  echo 'style="display:inline-block; vertical-align: middle" ' ?> >
                    <?php endif ?>
                    <span><?php echo get_woocommerce_currency_symbol() ?> <?php echo $default_currency ?></span></li>

                 <?php foreach ($items as $key => $item): ?>
                  <li data-currency="<?php echo $key ?>" onclick="set_currency('<?php echo $key ?>');">
                    <?php
                    $src = get_country_flag_url_by_currency($key);
                    if (file_exists($src['path'])): ?>
                    <img width="20" height="13" src="<?php echo $src['url']; ?>" alt="<?php echo $key ?>" <?php  echo 'style="display:inline-block; vertical-align: middle" ' ?>>
                     <?php endif ?>
                    <span><?php echo get_woocommerce_currency_symbol($key) ?> <?php echo $key ?></span></li>
                  <?php endforeach ?>
                </ul>
              </div>
              <?php endif ?>
            </div>
            <?php endif ?>
            </div>
          </div><!-- col-12 col-md-2 -->
          <div class="col-12 col-md-8 col-lg-6">
            <div class="row">
              <?php
                 $footer_count = 0;
                 for ($i=1; $i <=3 ; $i++) {
                   if(is_active_sidebar('footer_'.$i)){
                     $footer_count++;
                   }
                 }
                for ($i=1; $i <=3 ; $i++) {
                 if(is_active_sidebar('footer_'.$i)){
                   printf('<nav class="col-12 col-md-%s">', 12/(int)$footer_count);
                      dynamic_sidebar('footer_'.$i);
                   echo "</nav>";
                  }
                }
               ?>
            </div><!-- row -->
          </div><!-- col-12 col-md-8 -->
          <div class="col-12 col-md-4 col-lg-3 fix-gaps-2">
            <div class="footer-info">
              <?php $hidden = empty(get_option('theme_footer_schedule'))? 'hidden': ''; ?>
              <div class="schedule <?php echo $hidden; ?>">
                <i class="schedule__icon"></i>
                <?php
                 $schedule = esc_attr(get_option('theme_footer_schedule'));
                 if ( $schedule ):
                  $dots = ':</span> <span class="schedule__hours">';
                  $schedule = (strpos( $schedule, ':' ))? str_replace(':', $dots, $schedule) : $schedule;
                 endif;
                 printf('<span class="schedule__days">%s</span>', $schedule);
                  ?>
              </div><!-- schedule -->


              <div>
                <?php
                 $phone = esc_attr(get_option('theme_footer_phone'));
                 $hidden = ($phone)? '': 'hidden';
                 $replace = '</span> ';
                 $phone_html = ((strpos( $phone, '+' )>=0) && strpos( $phone, ' ' ))? str_replace_once(' ', $replace, $phone): $phone ;

                $phone_url = str_replace( array(' ', '(', ')', '[',']','.',':'), '', $phone);

                echo((strpos( $phone, '+' )>=0) && strpos( $phone, ' ' ))? sprintf('<a href="tel:%s" class="phone %s">%s%s</a>', $phone_url, $hidden, '<span class="code">', $phone_html) : sprintf('<a href="tel:%s" class="phone">%s</a>', $phone_url,  $phone_html);
                ?>
              </div>

              <div>
                <?php
                 $email = esc_attr(get_option('theme_footer_email'));
                 if ($email):
                  printf('<a href="mailto:%1$s" class="email">%1$s</a>',$email);
                 endif ?>
              </div>
              <?php
               $address = esc_attr(get_option('theme_footer_address'));
               if ($address):
                printf('<address class="address"><pre>%1$s</pre></address>',$address);
               endif ?>
            </div>
          </div><!-- col-12 col-md-2 -->
        </div><!-- row -->
        <div class="footer-spacer"></div>
        <?php endif ?>
        <div class="row">
          <div class="<?php echo  $class_copy ?>">

            <div class="copyrights">
              <?php
                 if(get_option('theme_footer_copyrights')){
                    echo esc_attr(get_option('theme_footer_copyrights'));
                  }
               ?>
            </div>
          </div>
          <div class="col-12 col-md-6 alignleft">
            <?php $socials = array(
              'instagram' => 'instagram',
              'facebook'  => 'fb',
              'twitter'   => 'twitter'
            ); ?>
            <div class="socials">
              <?php foreach ($socials as $channel => $icon):
                $name = 'theme_footer_'.$channel;
                 if((get_option($name))):
                   printf('<a href="%2$s" class="socials__icons"><svg class="icon svg-icon-%1$s"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-%1$s"></use> </svg></a>',
                     $icon,
                     esc_url(get_option($name))
                   );
                 endif;
               endforeach ?>
            </div>
          </div>
        </div><!-- row -->
        <div class="spacer-h-50"></div>
      </div><!-- container -->
    </footer><!-- site-footer -->
    <?php
  }


  /**
  * Prints home page static text blocks after content
  *
  * @hookedto do_theme_after_content - home page , 10
  */
  public static function print_home_page_static_html(){
    $moto_before = get_option('home_moto_before');
    $moto_marked = get_option('home_moto_marked');
    $moto_marked_new = sprintf('<span class="marked marked_blue">%s</span>', $moto_marked );
    $moto        = get_option('home_moto');
    $moto        = str_replace($moto_marked, $moto_marked_new, $moto  );
    ?>

    <?php if ($moto_before ||  $moto): ?>
      <div class="spacer-h-50"></div>
      <section class="promo-text clearfix">
        <div class="container container_sm">
          <div class="textcenter">
            <?php if ($moto_before): ?>
              <h2 class="moto"><?php echo esc_attr($moto_before); ?></h2>
            <?php endif ?>
            <?php if ($moto): ?>
              <p class="text"><?php echo ($moto); ?></p>
            <?php endif ?>
          </div>
        </div>
      </section>
    <?php endif ?>

      <div class="spacer-h-50"></div>
      <?php
      $count = 0;
      $advantages = get_option('theme_advantages_block');
      for ($i=1; $i < 4; $i++) {
        if($advantages[$i]['title'] || $advantages[$i]['text']){
          $count++;
        }
      }
      ?>
    <?php if ($count > 0): ?>
      <section class="section-info">
        <div class="container container_sm container-lg-gap-20">
          <div class="row">
            <?php
              for ($i=1; $i < 4; $i++) {
                if($advantages[$i]['title'] || $advantages[$i]['text']){
                  printf('<div class="col-12 col-md-%1$s information inf-%2$s"> <div class="information__icon"> <img src="%3$s" alt="%4$s"> </div> <h3 class="information__title">%4$s</h3> <p class="information__text">%5$s</p> </div>',
                        12/$count,
                        $i,
                        $advantages[$i]['icon'],
                        $advantages[$i]['title'],
                        $advantages[$i]['text']
                      );
                }
              }
             ?>
          </div><!-- row -->
        </div><!-- container -->
      </section>

      <div class="spacer-h-50"></div>
    <?php endif ?>
    <?php
  }


  /**
  * Prints staic home page's widget areas
  *
  * @hookedto do_theme_after_content - home page , 20
  */
  public static function print_home_page_static_widgets(){
    if(is_active_sidebar('home_page_after_content')){
      dynamic_sidebar('home_page_after_content');
    }
  }


  /**
  * prints the latest published article in blog
  */
  public static function print_blog_latest_article(){
    $args = array(
      'limit'          => 1,
      'posts_per_page' => 1,
      'post_type'      => 'post',
      'orderby'        => 'date',
      'order'          => 'DESC'
    );

    if(theme_construct_page::is_page_type('blog-category')){
      $category =get_queried_object();
      $args['category_name'] = $category->name;
    }elseif(theme_construct_page::is_page_type('post-tag')){
      $category =get_queried_object();
      $args['tag'] = $category->name;
    }

    $posts = get_posts($args);

    $post  = $posts[0];
    $image = get_the_post_thumbnail_url($post, 'blog_lg');
    $image_lazy_preview = get_the_post_thumbnail_url($post, 'blog_lg_lazy_preview');
    $args = array(
      'taxonomy' => 'category',
      'include'  => wp_get_post_categories($post->ID)
    );

    $categories  = get_terms($args);

    $category_html = array();

    foreach ($categories as $key => $c) {
      $category_html[] = sprintf('<a href="%s" class="category">%s</a>', esc_url(get_term_link($c)), esc_attr($c->name));
    }
    ?>
      <div class="spacer-h-40"></div>
      <div class="container container_sm">
        <div class="row">
          <div class="col-12">
            <div class="blog__hero">
              <a href="<?php echo get_permalink($post) ?>" class="blog__hero-image">
                <img src="<?php echo esc_url($image_lazy_preview) ?>" data-src="<?php echo esc_url($image) ?>" alt="" class="lazy-load">
              </a>
              <div class="blog__hero-text">
                <div class="clearfix"><?php echo implode(', ', $category_html); ?></div>
                <a href="<?php echo get_permalink($post) ?>" class="title"><?php echo esc_attr($post->post_title) ?></a>
                <span class="time">
                  <?php echo get_time_passed_text($post->post_date_gmt, "Y-m-d H:i:s" );?>
                </span>
              </div>
            </div>
          </div>
        </div><!-- row -->

       <div class="spacer-h-40"></div>
       <div class="categories-blog">

        <?php
          $args = array(
            'taxonomy' => 'category',
            'hide_empty' => true,
            'posts_per_page' => -1,
            'limit' => -1,
          );

          if(theme_construct_page::is_page_type('post-tag')){
            $args['taxonomy'] = 'post_tag';
          }

          if(theme_construct_page::is_page_type('blog-category')){
            $category =get_queried_object();
            $args['exclude'] = $category->term_id;
          }

          $categories = get_terms($args) ?>
           <div class="row no-gutters">
            <a href="<?php echo esc_url(get_permalink(get_option('page_for_posts'))) ?>" class="categories__item_blog categories__item"><span class="categories__item-image"><img src="<?php echo THEME_URL ?>/images/icons/c11.png" alt="Blog"></span><span class="categories__item-title"><span>All</span></span></a>
          <?php
          $num = 1;
          foreach ($categories as $id => $c):
            $image_id  = get_term_meta($c->term_id, '_thumbnail', true);
            $image_url = wp_get_attachment_image_url($image_id, 'icon');
            $prefix    = ($num < 10)? '0' : '';
            $image_url = ($image_id && (int)$image_id > 0)?$image_url : sprintf('%s/images/icons/c%s%s.png', THEME_URL, $prefix, $num);
            ?>
            <a href="<?php echo esc_url(get_term_link($c)) ?>" class="categories__item_blog categories__item"><span class="categories__item-image"><img width="48" height="48" src="<?php echo  $image_url; ?>" alt=""></span><span class="categories__item-title"><span><?php echo $c->name ?></span></span></a>
          <?php
          $num++;
          $num = ($num>6)? 1 : $num;
        endforeach; ?>
        </div>
        </div>
      </div><!-- container -->
    <?php
  }


  /**
  * prints widgets in a blog home page
  */
  public static function print_blog_widgets(){
    if(is_active_sidebar('theme_blog_featured')){
      dynamic_sidebar('theme_blog_featured');
      echo '<div class="spacer-h-40"></div>';
    }
  }


  /**
  * prints latest articles preview for a blog, or all articles for article's category
  */
  public static function print_blog_latest(){

    $args = array(
      'limit'          => 4,
      'posts_per_page' => 4,
      'post_type'      => 'post',
      'orderby'        => 'date',
      'order'          => 'DESC'
    );

    if(theme_construct_page::is_page_type('blog-category')){
      $category = get_queried_object();
      $args['category_name']  = $category->name;
      $args['limit']          = -1;
      $args['posts_per_page'] = -1;

      $title   = sprintf('<h2 class="blog-title blog-title_md">%s</h2>', esc_attr($category->name));
      $comment = sprintf('<span class="blog-comment">%s</span>', esc_attr($category->description));

    }elseif(theme_construct_page::is_page_type('post-tag')){
      $category = get_queried_object();

      $args['tag']            = $category->name;
      $args['limit']          = -1;
      $args['posts_per_page'] = -1;

      $title   = sprintf('<h2 class="blog-title blog-title_md">%s</h2>', esc_attr($category->name));
      $comment = sprintf('<span class="blog-comment">%s</span>', esc_attr($category->description));
    }else{
     $title   = sprintf('<h2 class="blog-title blog-title-feed blog-title_md">%s</h2>', esc_attr(get_option('theme_blog_articles_title')));


      $comment = sprintf('<span class="blog-comment-feed blog-comment">%s</span>',  esc_attr(get_option('blog_articles_comment')));
    }

    $posts = get_posts($args);

    if(theme_construct_page::is_page_type('blog-category')){
      $posts = array_slice($posts, 1);
    }else{
      $posts = array_slice($posts, 1 ,3);
    }
    if(!$posts) return false;
    ?>
      <section class="new-articles">
        <div class="container container_sm">
          <?php
          echo $title;
          echo $comment;
            $spacer ='';
           foreach ($posts as $key => $p):
            echo $spacer;
            $spacer     = '<div class="spacer-h-50"></div>';
            $image      = get_the_post_thumbnail_url($p, 'blog_feed');
            $image_lazy      = get_the_post_thumbnail_url($p, 'blog_feed_lazy');
            $description = apply_filters('the_content', $p->post_content);
            $description = strip_tags($description);

            $description = (strlen($description) > 140)? substr($description, 0 , 140).'...' : $description;

            $args = array(
              'taxonomy' => 'category',
              'include'  => wp_get_post_categories($p->ID)
            );
            $categories  = get_terms($args);

            $category_html = array();

            foreach ($categories as $key => $c) {
              $category_html[] = sprintf('<a href="%s" class="article-preview__category">%s</a>', esc_url(get_term_link($c)), esc_attr($c->name));
            }

            $date = DateTime::createFromFormat("Y-m-d H:i:s", $p->post_date_gmt);
            ?>
            <div class="row">
              <?php if ($image): ?>
              <div class="col-12 col-md-6">
                <div class="article-preview__image">
                  <a href="<?php echo esc_url(get_permalink($p)) ?>"><img src="<?php echo esc_url($image_lazy) ?>" data-src="<?php echo esc_url($image) ?>" alt="<?php echo esc_attr($p->post_title); ?>" class="lazy-load"></a>
                </div>
              </div>
              <?php endif ?>
              <div class="col-12 col-md-6">
                <div class="article-preview__data">
                  <?php echo implode( ', ',$category_html );?>
                  <a href="<?php echo esc_url(get_permalink($p)) ?>" class="article-preview__title"><?php echo esc_attr($p->post_title); ?></a>

                  <span class="article-preview__date">
                  <?php echo $date->format('d F Y')?></span>

                  <span class="article-preview__description">
                    <?php echo $description; ?>
                  </span>

                  <a href="<?php echo esc_url(get_permalink($p)) ?>" class="article-preview__readmore">Read more</a>
                </div>
              </div><!-- col-12 col-md-6 -->
            </div><!-- row -->
          <?php endforeach ?>
        </div><!-- container -->

      </section>
      <div class="spacer-h-80"></div>
    <?php
  }


  /**
  * prints content of a single post in blog
  */
  public static function print_blog_post_content(){
    $post = get_queried_object();

    $args = array(
      'taxonomy' => 'category',
      'include'  => wp_get_post_categories($post->ID)
    );
    $categories    = get_terms($args);

    $category_html = array();

    foreach ($categories as $key => $c) {
      $category_html[] = sprintf('<a href="%s" class="single-blog__category">%s</a>', esc_url(get_term_link($c)), esc_attr($c->name));
    }
    $user     = get_user_by( 'ID', $post->post_author );

    $tags  = wp_get_post_tags($post->id);

    $tags_html = array();

    foreach ($tags as $key => $t) {
       $tags_html[] = sprintf('<a href="%s" class="single-blog__tag">%s</a>', esc_url(get_term_link($t)), esc_attr($t->name));
    }


    $image      = get_the_post_thumbnail_url($post, 'blog_lg');
    ?>
    <div class="spacer-h-40"></div>
    <div class="container">
      <div class="single-blog__thumb">
          <a href="javascript:void(0)" onclick="goBack()" class="back-link back-link_contrast">
            <svg class="icon svg-icon-arrob"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-arrob"></use> </svg>
          <span>Back to Blog</span></a>
          <img src="<?php echo esc_url($image) ?>" alt="" class="single-blog__thumb-image">
       </div>
    </div>

      <section class="single-blog__body">
        <div class="container">
           <div class="clearfix">
             <?php echo implode( ', ',$category_html );?>
           </div>
           <h2 class="single-blog__title">
             <?php echo esc_attr($post->post_title); ?>
           </h2>

           <div class="single-blog__author">
             <div class="photo"><img src="<?php echo esc_url(get_avatar_url($user->ID, array('size' => 30))) ?>" alt=""></div>
             <span><?php echo esc_attr($user->data->display_name) ?> -  <?php echo get_time_passed_text($post->post_date_gmt, "Y-m-d H:i:s" );?></span>
           </div>

           <div class="single-blog__text">
            <div class="single-blog__row">
              <?php echo apply_filters('the_content', $post->post_content); ?>
            </div>

             <div class="single-blog__row tags">
               <?php echo implode( ' ',$tags_html );?>
             </div>
            <script>
              function open_window(href, title){
               var w = 640, h = 480,
                  left = Number((screen.width/2)-(w/2)), tops = Number((screen.height/2)-(h/2));

              popupWindow = window.open(href, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=1, copyhistory=no, width='+w+', height='+h+', top='+tops+', left='+left);
              popupWindow.focus(); return false;
              }
            </script>
             <div class="single-blog__row">
              <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo esc_html(get_permalink($post))?>" class="share-link  fb" title="<?php _e('Share in Facebook'); ?>" target="_parent" onclick="open_window(this.href, this.title); return false">
                <i class="icon-fb_w"></i>
                <span>share on facebook)</span>
              </a>

              <?php
                $text = esc_attr(substr($post->post_title, 0 , 140));
               ?>

              <a href="http://twitter.com/share?text=<?php echo $text ?>&url=<?php echo esc_url( get_permalink($post) ) ?>" class="share-link tw" itle="<?php _e('Share in Twitter'); ?>" onclick="open_window(this.href, this.title); return false" target="_parent">
                <svg class="icon svg-icon-twitter"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-twitter"></use> </svg>
                <span>share on twitter</span>
              </a>
             </div>
           </div>
        </div>
      </section>
    <?php
  }


  /**
  * prints carousel of articles in post after post's content
  */
  public static function print_blog_post_after(){
    $post = get_queried_object();
    $args = array(
      'taxonomy' => 'category',
      'include'  => wp_get_post_categories($post->ID)
    );
    $categories  = get_terms($args);

    $category    = array_shift( $categories );

    $args = array(
      'limit'          => 4,
      'posts_per_page' => 4,
      'post_type'      => 'post',
      'orderby'        => 'date',
      'order'          => 'DESC',
      'category_name'  => $category->name
    );

    $posts = get_posts($args);
    ?>
      <div class="spacer-h-10"></div>

      <section class="single-blog__after">
        <div class="container container_sm">
          <p class="blog-title">Also in <?php echo esc_attr($category->name) ?></p>
          <p class="blog-comment"><?php echo esc_attr($category->description) ?></p>
        </div>

        <div class="article-gallery owl-carousel">
          <?php foreach ($posts as $key => $p):
            $image      = get_the_post_thumbnail_url($p, 'blog_feed');
            $image_lazy      = get_the_post_thumbnail_url($p, 'blog_feed_lazy');

            $args = array(
              'taxonomy' => 'category',
              'include'  => wp_get_post_categories($p->ID)
            );
            $categories  = get_terms($args);

            $category_html = array();

            foreach ($categories as $key => $c) {
              $category_html[] = sprintf('<a href="%s" class="article-preview__category">%s</a>', esc_url(get_term_link($c)), esc_attr($c->name));
            }

            $date = DateTime::createFromFormat("Y-m-d H:i:s", $p->post_date_gmt);
            ?>

          <div class="article-gallery__item article-preview">
              <?php if ($image): ?>
                <div class="article-preview__image">
                  <a href="<?php echo esc_url(get_permalink($p)) ?>"><img data-src="<?php echo esc_url($image) ?>" class="owl-lazy" alt="<?php echo esc_attr($p->post_title); ?>"></a>
                </div>
              <?php endif ?>
                  <div class="clearfix"><?php echo implode( ', ',$category_html );?></div>
                  <a href="<?php echo esc_url(get_permalink($p)) ?>" class="article-preview__title"><?php echo esc_attr($p->post_title); ?></a>
            <span class="article-preview__date"><?php echo $date->format('d F Y')?></span></span>
          </div>
          <?php endforeach ?>
        </div>
      </section>

      <div class="spacer-h-60"></div>
    <?php
  }


  /**
  * prints wocommerce content
  */
  public static function print_woo_content(){
    $class = (theme_construct_page::is_page_type('woo-product'))? 'white' : '';

    printf('<section class="section-products %s"><div class="container container_sm">', $class);
      woocommerce_content();
    echo('</div></section>');
  }


  /**
  * prints opening tag for image link in a products' loop
  public static function print_product_open_link(){
    global $product;

    if ( ! $product ) {
      return;
    }
    $link = apply_filters( 'woocommerce_loop_product_link', get_permalink($product->get_id()), $product );

    echo '<a href="' . esc_url( $link ) . '" class="product__image-link">';
  }
  */


  /**
  * prints opening tag for product info row in a products' loop
  public static function print_product_loop_open_row(){

    echo '<div class="product__row">';
  }

  */

  /**
  * prints opening tag for image block info row in a products' loop
  */
  public static function print_product_loop_open_image(){
    echo '<div class="product__image product__image_sm">';
  }



  /**
  * prints closing tag for image info row in a products' loop
  */
  public static function print_product_loop_close_div(){
    echo '</div>';
  }


  /**
  * prints product's premium/regular tag in a loop for large product preview
  public static function theme_print_product_loop_tag_ing_thumb(){
    global $product;

    if ( ! $product ) {
      return;
    }

    global $theme_product_widget_size;
    $product_id = $product->get_id();
    if('large' !== $theme_product_widget_size) return false;
    if (is_premium($product)): ?>
    <span class="product__type">
      <?php _e('A','theme-translations');?>
      <b>FEEDSAUCE</b>
      <?php _e('PREMIUM RECIPE','theme-translations');?>
    </span>
    <?php endif;
  }
  */


  /**
  * prints product premium/regular tag in a loop for small product preview
  public static function theme_print_product_loop_tag(){
    global $product;

    if ( ! $product ) {
      return;
    }

    global $theme_product_widget_size;
    $product_id = $product->get_id();

    if('large' == $theme_product_widget_size) return false;
      ?>
        <div class="product__row">
          <?php if (is_premium($product)): ?>
            <span class="product__tag product__tag_prem"><i class="icon-flash"></i> <span><?php _e('PREMIUM RECIPE','theme-translations');?></span></span>
          <?php else: ?>
            <span class="product__tag product__tag_original"><span><?php _e('ORIGINAL RECIPE','theme-translations');?></span></span>
          <?php endif; ?>
        </div>
      <?php
  }
  */


  /**
  * prints product's title in a loop
  public static function theme_print_product_loop_title(){
    global $product;

    if ( ! $product ) {
      return;
    }

    $link = esc_url(get_permalink($product->get_id()));

    echo '<a href="'.esc_url($link).'" class="product__title">' . $product->get_title() . '</a>';
  }
  */


  /**
  * prints product's short description in a loop
  public static function theme_print_product_loop_description(){
    global $product;

    if ( ! $product ) {
      return;
    }
    global $theme_product_widget_size;
    $limit = ('large' === $theme_product_widget_size)? 145 : 80;
    $description_full = strip_tags($product->get_short_description());
    $description = strlen( $description_full ) > $limit ? substr($description_full ,0,$limit).'...' : $description_full ;

    printf('<span class="product__description" title="" >%s</span>', $description );
  }
  */


  /**
  * prints product's gallery in a loop for small product
  public static function theme_print_product_loop_gallery(){
    global $product;

    if ( ! $product ) {
      return;
    }

    global $theme_product_widget_size;

    $gallery  = array_slice($product->get_gallery_image_ids(), 0 ,4);
     if ($gallery && (empty($theme_product_widget_size)|| 'small' === $theme_product_widget_size)): ?>
      <div class="product__gallery">
        <?php foreach ($gallery as $num => $image_id):
          $image_large = wp_get_attachment_image_url($image_id , 'fullsize');
          $image_icon  = wp_get_attachment_image_url($image_id , 'icon_md');
          $image_alt   = get_post_meta( $image_id, '_wp_attachment_image_alt', true);
          $image_alt   = (empty($image_alt ))? $product->get_title(): $image_alt;
          printf('<a href="%1$s" class="product__gallery-item"><img src="%2$s" alt="%3$s" width="56" height="56"></a>',
                   esc_url( $image_large ),
                   esc_url($image_icon),
                   esc_attr($image_alt)
                );
          ?>
        <?php endforeach; ?>
      </div><!-- product__gallery -->
    <?php endif;
  }
  */


  /**
  * prints product's gallery in a loop in an image thumb
  public static function theme_print_product_loop_gallery_abs(){
    global $product;

    if ( ! $product ) {
      return;
    }

    global $theme_product_widget_size;

    $gallery  = array_slice($product->get_gallery_image_ids(), 0 ,4);
     if ($gallery && ('large' === $theme_product_widget_size)): ?>
      <div class="product__gallery">
        <?php foreach ($gallery as $num => $image_id):
          $image_large = wp_get_attachment_image_url($image_id , 'fullsize');
          $image_icon  = wp_get_attachment_image_url($image_id , 'icon_md');
          $image_alt   = get_post_meta( $image_id, '_wp_attachment_image_alt', true);
          $image_alt   = (empty($image_alt ))? $product->get_title(): $image_alt;
          printf('<a href="%1$s" class="product__gallery-item"><img src="%2$s" width="56" height="56" alt="%3$s"></a>',
                   esc_url( $image_large ),
                   esc_url($image_icon),
                   esc_attr($image_alt)
                );
          ?>
        <?php endforeach; ?>
      </div><!-- product__gallery -->
    <?php endif;
  }
  */


  /**
  * prints product's category in a loop
  public static function theme_print_product_loop_category(){
    global $product;

    if ( ! $product ) {
      return;
    }

    global $theme_product_widget_size;
    $categories = get_terms(array(
      'include' => $product->get_category_ids(),
    ));
    $category = array_shift($categories);

    if('large' === $theme_product_widget_size):
    ?>
    <p class="product__category"><i class="icon-flame"></i> <span><?php echo esc_attr($category->name) ?></span></p>
    <?php
    endif;
  }
  */


  /**
  * prints time when product will be ready on a single product's page
  */
  public static function print_single_product_estimates(){
    global $product;

    if ( ! $product ) {
      return;
    }

    ?>
    <p class="single-recipe__detailes">
      <span class="tag-blue">
        <i class="icon-flash"></i>
        <span class="text">
          next day
        </span>
      </span>

      <b>Free</b> Product Pick-Up <a href="javascript:void(0)" class="trigger-popup">Details
        <span class="popup">
          Available in selected cities. Enter your product location at Checkout to see if you’re elegible. Otherwise, you can choose to <b>‘Self-Ship’</b> your product to us.
        </span>
      </a>
    </p>
      <?php print_estimates();?>
      <div class="single-recipe__hr"></div>
    <?php
  }


  /**
  * prints section with unlocking premium button on a single product's page
  */
 /* public static function print_woo_single_product_unlock_premium(){
    global $product;

    if ( ! $product ) {
      return;
    }

    $old_product            = $product;
    $subsciption_data       = get_post_meta($product->get_id(), '_yith_wcmbs_restrict_access_plan', true);
    $subsciption_id         = (int)$subsciption_data[0];
    $subsciption_product_id = get_post_meta($subsciption_id, '_membership-product', true);
    $subsciption_product    = wc_get_product($subsciption_product_id[0]);
    $product                =  $subsciption_product;
    ?>
    <div class="textcenter">
      <svg class="icon svg-icon-lock"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-lock"></use> </svg>
      <br>
      <div class="single-recipe__tag">
        <i class="icon-flash"></i>
        <span><?php _e('PREMIUM RECIPE','theme-translations');?></span>
      </div>
      <p class="single-recipe__subtitle"><?php _e('Upgrade to Purchase','theme-translations');?></p>

      <p class="single-recipe__text">
        <?php _e('You can purchase this recipe with a','theme-translations');?>
        <br>
        <?php _e('Premium Membership','theme-translations');?>
        .
      </p>

      <?php do_action('do_theme_purchase_premium');
       $product = $old_product;
       ?>
    </div>
    <?php
  }*/


  /**
  * prints sidebar for buying premium subscription on checkout page
  *
  * @param  integer - id of premium product
  */
  public static function print_checkout_sidebar_premium($product_id){
    $product = wc_get_product($product_id);
    $price   = wc_price($product->get_price());
    $price_per = get_post_meta( $product->get_id(), '_ywsbs_price_is_per', '1' );
    $price_per_period_name = get_post_meta( $product->get_id(), '_ywsbs_price_time_option', 'days' );
    ?>
    <div class="checkout__aside-inner">
      <div class="checkout__aside-premium">
        <div class="textcenter">
           <span class="checkout__aside-tag"><?php _e('YOUR ORDER', 'theme-translations'); ?></span>
        </div>
        <p class="checkout__aside-premium-title textcenter">
          <span><?php _e('Premium', 'theme-translations'); ?></span>
          <span class="tag"><i class="icon-flash"></i> ADD-on</span>
        </p>
        <p class="checkout__aside-comment textcenter white"><?php _e('Premium Membership for additional benefits', 'theme-translations'); ?>. <br> <?php _e('No images included', 'theme-translations'); ?>.</p>

        <p class="textcenter white premium-price">
          <span class="value"><?php echo $price ?></span>/
          <?php
            $per = sprintf('%s %s', $price_per, $price_per_period_name);
            echo str_replace(array('30 days', '31 days'), 'per month', $per);
          ?>
        </p>
      </div>

      <div class="checkout__aside-tags">
        <p class="checkout__aside-title2"><?php _e('Image Sizes', 'theme-translations'); ?></p>
        <div class="tag-cloud">
          <span class="tag-cloud__item active">
            <svg class="icon svg-icon-instagram"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-instagram"></use> </svg>
            <span class="text">
              <?php _e('Instagram', 'theme-translations'); ?>
            </span>
            <i class="icon-status"></i>
          </span>
          <span class="tag-cloud__item active">
            <svg class="icon svg-icon-fb"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-fb"></use> </svg>
            <span class="text">
              <?php _e('Facebook', 'theme-translations'); ?>
            </span>
            <i class="icon-status"></i>
          </span>
          <span class="tag-cloud__item active">
            <svg class="icon svg-icon-snap"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-snap"></use> </svg>
            <span class="text">
              <?php _e('Snapchat', 'theme-translations'); ?>
            </span>
            <i class="icon-status"></i>
          </span>
          <span class="tag-cloud__item active">
            <svg class="icon svg-icon-hd"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-hd"></use> </svg>
            <span class="text">
              <?php _e('Full HD', 'theme-translations'); ?>
            </span>
            <i class="icon-status"></i>
          </span>
        </div><!-- tag-cloud -->

        <p class="checkout__aside-title2"><?php _e('License', 'theme-translations'); ?></p>

        <div class="tag-cloud">
          <span class="tag-cloud__item active">
            <span class="text">
              Social &amp; Web
            </span>
            <i class="icon-status"></i>
          </span>
          <span class="tag-cloud__item active">
            <span class="text">
              <?php _e('Advertising', 'theme-translations'); ?>
            </span>
            <i class="icon-status"></i>
          </span>
        </div><!-- tag-cloud -->

        <p class="checkout__aside-text textcenter"> <?php _e('Plus access to', 'theme-translations'); ?> <b><?php _e('All Premium Recipes', 'theme-translations'); ?></b></p>
        <div class="spacer-h-10"></div>
        <p class="checkout__aside-comment textcenter"><?php _e('No minimum term', 'theme-translations'); ?>. <?php _e('Cancel anytime', 'theme-translations'); ?>.</p>


      </div><!-- checkout__aside-tags -->
    </div>
    <?php
  }


  /**
  * do woocommerce hooks for column on checkout page.
  * do when buying only subscription
  */
  public static function print_checkout_pay_premium(){

    ?>
    <?php do_action( 'woocommerce_checkout_before_order_review' ); ?>

    <?php do_action( 'woocommerce_checkout_order_review' ); ?>

    <?php do_action( 'woocommerce_checkout_after_order_review' ); ?>
    <?php
  }


  /**
  * do woocommerce hooks for column on checkout page.
  * do when buying recipes or multiple items
  */
  public static function print_checkout_sidebar_regular(){
    ?>
    <?php  do_action( 'woocommerce_checkout_before_order_review' ); ?>

    <?php  do_action( 'woocommerce_checkout_order_review' ); ?>

    <?php  do_action( 'woocommerce_checkout_after_order_review' ); ?>
    <?php
  }

  public static function print_checkout_totals(){
      $helper = new theme_formatted_cart();
      ?>
        <div class="checkout__aside-block">
          <table  class="order-summary__total-table">
            <tr>
              <th>Add-Ons</th>
              <td><span id="add-ons"><?php echo wc_price($helper->get_addons_total()); ?></span></td>
            </tr>
            <tr>
              <th>Discount</th>
              <td>
                <span id="discount-totals">
                <?php
                  echo wc_price( array_sum(wc()->cart->get_coupon_discount_totals( )));
                 ?>
                </span>
              </td>
            </tr>
            <tr>
              <th><b>Total (<?php echo get_woocommerce_currency()?>)</b></th>
              <td><b id="cart_total"><?php echo wc()->cart->get_cart_total()?></b></td>
            </tr>
          </table>
        </div>
      <?php
  }
  /**
  * prints estimates on checkout page
  *
  * @hooked to print_thank_you_estimates - 10
  * @hooked to woocommerce_checkout_order_review - 10
  */
    public static function print_checkout_estimates($order = false){


      $options         = get_theme_checkout_content();
      $helper          = new theme_formatted_cart();

      $has_prem = count($helper->get_addons()['delivery']) > 0 ? true : false;

      $priority_delivery_product_id = (int)get_option('wfp_priority_delivery_product_id');

      $priority_delivery_product = wc_get_product($priority_delivery_product_id);

      $days_offset     = ($has_prem)? get_ready_date_offset(true) : get_ready_date_offset(false) ;

      $days_offset_js  = ($has_prem)? get_ready_date_offset(true, 'js') :  get_ready_date_offset(false, 'js');

      $ready_date      = date('d F Y', strtotime($days_offset));
      $subscriptions   = get_all_subscriptions();


      $class = (('regular' === $options['type'] ) && (theme_construct_page::is_page_type('woo-checkout')))? 'checkout__aside-block' : 'order-summary-info__block no-border';

       $class =(is_wc_endpoint_url('order-received'))? 'order-summary-info__block no-border' : $class;


       if($order){
           $date_info = $order->get_date_created();
           $date_str = $date_info->date("d-m-Y H:i:s");
           $ready_date_ = new DateTime( $date_str );

           $days_offset = get_ready_date_offset(false);

         foreach ($order->get_items() as $key => $item) {
          $days_offset = ($item->get_product_id() == (int)$priority_delivery_product_id)? get_ready_date_offset(true) : $days_offset;

         }
         $ready_date_->modify($days_offset);

         $ready_date = $ready_date_->format('d F Y');
       }
      ?>

      <div class="<?php echo $class ?>">
        <p class="checkout__aside-subtitle"><?php _e('Estimated Download Date', 'theme-translation');?></p>
        <p class="checkout__aside-date"><?php echo $ready_date ?></p>
        <?php if (!$has_prem):
          $ready_date      = date('d F', strtotime('+5 days'));
          ?>
          <?php /*if ($priority_delivery_product): ?>

          <p class="checkout__aside-text"><?php _e('Get your images as soon as', 'theme-translation');?> <b><?php echo $ready_date ?></b></p>

          <a href="<?php echo $priority_delivery_product->add_to_cart_url() ?>" name="add-to-cart"  class="link-prem">Upgrade to Premium </a>
          <?php endif */?>
        <?php endif ?>
      </div>
      <?php

      wp_localize_script('theme-script','days_offset', $days_offset_js);
    }


  /**
  * prints form for entering coupon in checkout
  */
 /* public static function print_coupon_form_in_checkout(){
    $options         = get_theme_checkout_content();
    if('regular' !== $options['type'])
      return;
    if (empty(wc()->cart->applied_coupons)):
    ?>
    <div class="checkout__aside-coupon">
      <a href="javascript:void(0)" onclick="show_slide_down('coupon_code')" class="coupon-trigger"><?php _e('Redeem a Coupon', 'theme-translations'); ?></a>
        <input type="text" oninput="theme_apply_coupon()" placeholder="Coupon Code" class="form-field form-field_hidden coupon_code">
    </div>
    <?php
    else:
    ?>
    <div class="checkout__aside-coupon">
      <p class="checkout__aside-subtitle"><?php _e('Applied coupon','theme-translations');?>:</p>
      <p class="checkout__aside-date">
        <?php echo wc()->cart->applied_coupons[0]; ?>
      </p>

       <a href="javascript:void(0)" onclick="clear_coupon_code_checkout('<?php echo wc()->cart->applied_coupons[0]?>')" class="coupon-trigger"><?php _e('Clear Coupon', 'theme-translations'); ?></a>
    </div>
    <?php
    endif;
  }*/


  /**
  * prints header section of my account;
  */
  public static function print_myaccount_header(){
    global $wp;
    $user = wp_get_current_user();
    if (is_wc_endpoint_url('orders')):
      $user_id = get_current_user_id();

      if(function_exists('wc_get_account_endpoint_url')){
        $orders_url = wc_get_account_endpoint_url('orders');
        $customer   = new WC_Customer($user_id);
        $user_name  = $customer->get_first_name();
      }

      $today = new DateTime();
      ?>
      <div class="my-order__header my-order__header-transparent ">
        <div class="container container_sm">

          <?php if (user_is_premium($user)): ?>
            <span class="my-order__tag prem">
              <i class="icon-flash"></i>
              <?php _e('Premium Account','theme-translations');?>
            </span>
          <?php endif ?>
          <div class="spacer-h-25"></div>

          <div class="row no-gutters">
            <div class="col-12 col-md-4">
              <h2 class="my-order__title">
                <span class="my-order__title-text">Shoots
                </span>
              </h2>
              <div class="spacer-h-10"></div>
            </div>

            <div class="col-12 col-md-8 text-right-md">
              <div class="my-order__date-range-picker">
                <svg class="icon svg-icon-calendar"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-calendar"></use> </svg>

                <span class="label">All Time</span>

                <span class="dates"> Jan 01 1999 → <?php echo $today->format('M d Y') ?></span>

                <svg class="icon svg-icon-arrows"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-arrows"></use> </svg>
              </div>

              <?php if (!wp_is_mobile()): ?>
              <a href="<?php echo esc_url(get_permalink(wc_get_page_id( 'shop' ) )); ?>" class="my-order__button-add">+ New Shoot</a>
              <?php else: ?>
              <a href="<?php echo esc_url(get_permalink(wc_get_page_id( 'shop' ) )); ?>" class="my-order__button-add">+</a>
              <?php endif ?>
            </div>
            <div class="spacer-h-10"></div>
          </div>

          <div class="spacer-h-20"></div>

          <?php
            $customer_orders = get_posts( array(
                'numberposts' => -1,
                'meta_key'    => '_customer_user',
                'meta_value'  => get_current_user_id(),
                'post_type'   => wc_get_order_types(),
                'post_status' => array_keys( wc_get_order_statuses() ),
            ) );

            $customer_orders_completed = array_filter( $customer_orders, function($el){
              return in_array($el->post_status, array('wc-completed', 'wc-failed'));
            });

            $customer_orders_active = array_filter( $customer_orders, function($el){
              return !in_array($el->post_status, array('wc-completed', 'wc-failed'));
            });
          ?>

          <div class="clearfix"></div>

            <div class="my-order__filter">
              <div class="decoration"></div>
              <div class="decoration pre"></div>
              <a href="#processing" class="my-order__filter-item active"><?php _e('Active','theme-translations');?> <span class="count"><?php echo count($customer_orders_active);?></span></a>

              <a href="#completed" class="my-order__filter-item"><?php _e('Completed','theme-translations');?> <span class="count"><?php echo count($customer_orders_completed);?></span></a>
            </div>
          <div class="clearfix"></div>
        </div><!-- container -->
      </div>
    <?php
      elseif(is_wc_endpoint_url('edit-account')):
        ?>
        <div class="my-order__header">
          <div class="spacer-h-50"></div>
          <div class="container container_sm">
            <h2 class="my-order__title">
              <span class="my-order__title-text"><?php _e('Edit Profile','theme-translations'); ?></span>
            </h2>
           <p class="my-order__comments"><?php _e('Change your personal information and manage account access','theme-translations'); ?></p>
            <div class="clearfix"></div>

          </div><!-- container -->
        </div>
      <?php
     elseif(isset($wp->query_vars['edit-address']) && 'billing' === $wp->query_vars['edit-address']):
      ?>
      <div class="my-order__header">
        <div class="spacer-h-50"></div>
        <div class="container container_sm">
          <h2 class="my-order__title">
            <span class="my-order__title-text"><?php _e('Billing','theme-translations'); ?></span>
          </h2>

          <p class="my-order__comments"><?php _e('Change your personal information and manage account access','theme-translations'); ?></p>

          <div class="clearfix"></div>
        </div><!-- container -->
      </div>
      <?php
     elseif(isset($wp->query_vars['edit-address']) && 'shipping' === $wp->query_vars['edit-address']):
      ?>
      <div class="my-order__header">
        <div class="spacer-h-50"></div>
        <div class="container container_sm">
          <h2 class="my-order__title">
            <span class="my-order__title-text"><?php _e('Shilling','theme-translations'); ?></span>
          </h2>

          <p class="my-order__comments"><?php _e('Change your personal information and manage account access','theme-translations'); ?></p>

          <div class="clearfix"></div>
        </div><!-- container -->
      </div>
      <?php
     endif;
  }


  /**
  * prints data about order items;
  *
  * @param $order - WC_Order object | integer
  */
  public static function print_order_items_data($order = null, $print_full_data_single = false){
    if(!$order) return false;

    $order = (is_a($order, 'WC_Order'))?  $order : wc_get_order( $order );

    if(!$order) return false;

    $order_items           = $order->get_items( apply_filters( 'woocommerce_purchase_order_item_types', 'line_item' ) );

    $info = get_formatted_order_items( $order_items );


    foreach ( $info as $item_id => $item ):
     ?>
    <?php if ($item['items'] && (count($item['items'] )>=1)|| $print_full_data_single ): ?>

    <div class="row">
      <div class="col-7">
        <span class="order-summary__item-title"> <?php echo $item['name'] ?></span>
      </div>
      <div class="col-5 textright"></div>
    </div><!-- row -->
    <div class="row">
      <div class="col-12">
        <span class="order-summary__item-detail">
          <svg class="icon svg-icon-box"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-box"></use> </svg>
        <?php printf(_n('%s Product', '%s Products', count($item['items'])), count($item['items']));?></span>
        <span class="order-summary__item-detail">
          <svg class="icon svg-icon-items"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-items"></use> </svg>
          <?php printf(_n('%s Photo', '%s Photos', $item['images']), $item['images']);?> </span>
      </div>
    </div>


    <div class="clearfix">
      <svg class="icon svg-icon-size"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-size"></use> </svg>
      <span class="order-summary__item-detail">
        <?php echo implode(', ', $item['sizes']); ?>
      </span>
    </div>

    <div class="clearfix">
      <svg class="icon svg-icon-pen"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-pen"></use> </svg>
      <span class="order-summary__item-detail">
        <?php echo $item['comment'] ?></span>
    </div>


    <?php else: ?>
    <div class="row">

      <?php if (function_exists('is_single_product_order_wfp') && is_single_product_order_wfp($order)): ?>
        <div class="col-6">
          <p class="checkout__aside-subtitle"><?php _e('No. of Images','theme-translations');?></p>
          <p class="checkout-item__text">
            <i class="icon-items"></i>
            1
          </p>
        </div>
      <?php else:
       ?>
      <?php if (isset($meta)): ?>
        <?php foreach ($meta as $key => $m): ?>
          <div class="col-6">
            <p class="checkout__aside-subtitle"><?php echo esc_attr($m->display_key); ?></p>
            <p class="checkout-item__text">
              <i class="icon-items"></i>
              <?php echo apply_filters('filter_theme_variation_value', strip_tags($m->display_value), $m->display_key ) ?>
            </p>
          </div>
        <?php endforeach; ?>
      <?php endif ?>
        <?php endif; ?>

      <?php if (count($order_items )===1): ?>

      <div class="col-6">
        <p class="checkout__aside-subtitle"><?php _e('Total','theme-translations');?></p>
        <p class="checkout-item__text">
          <b><?php echo $order->get_formatted_order_total(); ?></b>
        </p>
      </div>
      <?php endif; ?>
    </div><!-- row -->
     <?php endif; ?>
    <?php endforeach; ?>

    <?php if (count($order_items )>1 || $print_full_data_single ): ?>
      <?php _e('Total','theme-translations');?>
       <b <?php echo 'style="float:right" ' ?> ><?php echo $order->get_formatted_order_total(); ?></b>
     <?php endif;
  }


  /**
  * prints showcase single post after content meta
  */
  public static function print_showcase_after_content(){
    $post = get_queried_object();
    $moto        = esc_attr( get_post_meta($post->ID, '_showcase_moto', true) );
    $moto_marked = esc_attr( get_post_meta($post->ID, '_showcase_moto_marked', true) );
    $texts       = get_post_meta($post->ID, '_3_row', true);
    ?>

    <style>
      .marked_page{
        color:  <?php echo esc_attr( get_post_meta($post->ID, '_marked_font_color', true)) ?>!important;
        background-color:  <?php echo esc_attr( get_post_meta($post->ID, '_marked_bg', true)) ?>!important;
      }
    </style>

     <section class="white">
      <?php if (!empty($moto)):
        $replace = sprintf('<span class="marked marked_blue marked_page">%s</span>', $moto_marked);
        $moto = str_replace($moto_marked, $replace, $moto);
        ?>

        <div class="spacer-h-60"></div>
        <div class="promo-text textcenter">
          <span class="title"><?php echo ($moto); ?></span>
        </div>

        <div class="spacer-h-90"></div>
      <?php endif ?>
      <?php if ( $texts ):
        ?>

        <div class="container container_sm">
          <div class="row">
            <?php foreach ($texts as $key => $t): ?>

            <div class="col-12 col-md-4 information">
              <p class="information__title"><?php echo esc_attr($t['title']); ?></p>
              <p class="information__text"><?php echo esc_attr($t['text']); ?></p>
            </div>
            <?php endforeach ?>
          </div>
        </div>
        <div class="spacer-h-90"></div>
      <?php endif ?>
      </section>
    <?php
      $img_text = get_post_meta($post->ID, '_img_text', true);
    ?>
    <?php
     if ($img_text):
        $type = 'odd';
     ?>
      <div class="container container_sm">
        <div class="spacer-h-90"></div>
          <?php foreach ($img_text['items'] as $key => $item):
            switch ($item['type']) {
              case 'quote':
                 if (!$item['text']) {
                    break;
                  }
                ?>
                <div class="textcenter blockquote">
                  <p class="blockquote__text">“<?php echo  esc_attr($item['text']); ?>”</p>
                  <p class="blockquote__author"><?php echo  esc_attr($item['author']); ?></p>
                </div>
                 <?php if ($key+1 != count($img_text['items'])): ?>
                    <div class="spacer-h-60"></div>
                  <?php endif ?>
                <?php
                break;

              default:

                  $image = wp_get_attachment_image_url($item['image_id'], 'full');

                  if (!$image && (!$item['title'] || !$item['text'])) {
                    break;
                  }
                switch ($type ) {
                  case 'odd':
                  ?>
                  <div class="row">
                    <div class="col-12 col-md-7 order-sm-2">
                      <div class="showcase-preview__image">
                        <img src="<?php echo esc_url($image)?>" alt="<?php echo isset($item['title'])? esc_attr($item['title']) : ''; ?>">
                      </div>
                    </div>
                    <div class="col-12 col-md-5">
                      <div class="showcase-preview__data">
                        <div class="showcase-preview__data-inner">
                          <span  class="showcase-preview__category"><?php echo isset($item['before_title'])? esc_attr($item['before_title']) :''; ?></span>
                          <span class="showcase-preview__title"><?php echo isset($item['title'])? esc_attr($item['title']) : ''; ?></span>

                          <span class="showcase-preview__description"><?php echo isset($item['text'])?  esc_attr($item['text']): ''; ?></span>

                        </div>
                      </div>
                    </div><!-- col-12 col-md-6 -->
                  </div><!-- row -->
                  <?php if ($key+1 != count($img_text['items'])): ?>
                    <div class="spacer-h-100"></div>
                  <?php endif ?>

                  <?php
                    break;
                  case 'even':
                   ?>
                  <div class="row">
                    <div class="col-12 col-md-7">
                      <div class="showcase-preview__image">
                         <img src="<?php echo esc_url($image)?>" alt="<?php echo isset($item['title'])? esc_attr($item['title']) : ''; ?>">
                      </div>
                    </div>
                    <div class="col-12 col-md-5">
                      <div class="showcase-preview__data">
                        <span class="showcase-preview__category"><?php echo isset($item['before_title'])? esc_attr($item['before_title']) :''; ?></span>
                        <span class="showcase-preview__title"><?php echo isset($item['title'])? esc_attr($item['title']) : ''; ?></span>

                        <span class="showcase-preview__description"><?php echo isset($item['text'])?  esc_attr($item['text']): ''; ?></span>

                      </div>
                    </div><!-- col-12 col-md-6 -->
                  </div><!-- row -->
                  <?php if ($key+1 != count($img_text['items'])): ?>
                    <div class="spacer-h-100"></div>
                  <?php endif ?>

                   <?php
                    break;
                }
                 $type = ('odd' === $type)? 'even': 'odd';

                break;
            }
          endforeach; ?>
        </div>
    <div class="spacer-h-90"></div>
    <?php endif;
    $gallery = get_post_meta($post->ID, '_gallery', true);
    ?>
    <?php if ($gallery['items']): ?>
    <div class="slider-images owl-slider">
      <?php foreach ($gallery['items'] as $key => $item):
        $image = wp_get_attachment_image_url($item['image_id'], 'medium_large');
        if(!$image) continue;
        ?>
      <a href="<?php echo (isset($item['url']))? esc_url($item['url']): '';?>" class="slider-images__item"><img class="owl-lazy" data-src="<?php echo esc_url($image)?>" alt="showcase"></a>
      <?php endforeach ?>
    </div>
    <div class="spacer-h-90"></div>
    <?php endif;
    $o = get_post_meta($post->ID, '_showcase_story', true);
     ?>
    <?php if (isset($o['show']) && 'yes' === $o['show']):
      $image = (isset($o['image_id']))? wp_get_attachment_image_url($o['image_id'], 'full'): DUMMY;
      $icon = (isset($o['icon_id']))?wp_get_attachment_image_url($o['icon_id'], 'icon') : '';
        ?>
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
              <a href="<?php echo isset($o['url'])? esc_url($o['url']): ''; ?>" data-type="<?php echo $o['url_type']; ?>" class="<?php echo isset($o['url_type'])?'trigger-video ': '' ?>  story__cta"><?php echo isset($o['url_text'])? esc_attr($o['url_text']): $o['url']; ?></a>
              <?php endif ?>
            </div>
            <div class="col-12 col-md-6 offset-md-1">
              <div class="story__thumbnail">
                <div class="story__thumbnail-inner">
                  <?php if ($image): ?>
                   <img src="<?php echo esc_url($image)?>" class="story__image" alt="">
                  <?php endif ?>
                </div>
              </div>
            </div>
          </div><!-- row -->
        </div><!-- container -->
      </section>
      <div class="spacer-h-80"></div>
    <?php endif;
     $o = get_post_meta($post->ID,'_showcase_product', true);
     ?>
    <?php if (isset($o['item']) && function_exists('wc_get_product')): ?>
    <section class="section-products">
      <div class="container container_sm">
        <h2 class="section-title_sm section-title textleft"><?php echo isset($o['title']) ? esc_attr($o['title']) : '' ;?></h2>
        <p class="section-comment section-comment_sm textleft"><?php echo isset($o['comment']) ? esc_attr($o['comment']) : '' ;?></p>
        <div class="spacer-h-10"></div>
        <div class="spacer-h-10"></div>
        <div class="row products-md no-gutters">
          <?php
            global $product;
            foreach ($o['item'] as $key => $product_id):
              $product = wc_get_product($product_id);
              wc_get_template_part( 'content', 'product' );
            ?>
          <?php endforeach ?>
        </div><!-- row -->
      </div><!-- container -->
    </section>
    <div class="spacer-h-90"></div>
    <?php endif ?>
    <?php
  }

  /**
  * prints customer pages archive
  */
  public static function print_customers(){
    $post = get_queried_object();
    $args = array(
      'posts_per_page' => 3,
      'sort'          => 'DESC',
      'sortby'        => 'date',
      'post_type'     => velesh_theme_posts::$customer_name,
    );

    $customers = get_posts($args);

    echo apply_filters('the_content', $post->post_content);

    echo '<div class="spacer-h-50"></div>';
    if( $customers):
      ?>
      <div class="container container_sm">
      <?php
      foreach ($customers as $key => $post) :
        $instagram_customer = get_post_meta($post->id, '_instagram_customer', true);
        $terms = wp_get_post_terms( $post->ID, velesh_theme_posts::$customer_taxonomy_name, array() );
        $image = get_the_post_thumbnail_url($post, 'product_thumb_md');
        $url = esc_url(get_permalink($post));
        $title = esc_attr($post->post_title);
        ?>
        <div class="row">
          <div class="col-12 col-md-6">
            <div class="showcase-articles__image">
              <a href="<?php echo $url; ?>"><img src="<?php echo esc_url($image) ?>" alt="<?php echo $title; ?>"></a>
            </div>
          </div>
          <div class="col-12 col-md-6">
            <div class="showcase-articles__data">
              <span class="showcase-articles__category">
                <svg class="icon svg-icon-star"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-star"></use> </svg>
                <?php foreach ($terms as $key => $t): ?>
                <span><?php echo esc_attr($t->name) ?></span>
                <?php endforeach ?>
              </span>

              <a href="<?php echo $url; ?>" class="showcase-articles__title"><?php echo $title; ?></a>

               <?php if (isset($instagram_customer['ins_url'])): ?>

              <a href="<?php echo esc_url($instagram_customer['ins_url']) ?>" class="showcase-articles__social"><svg class="icon svg-icon-instagram"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-instagram"></use> </svg> <span><?php echo (isset($instagram_customer['ins_title']))? esc_attr($instagram_customer['ins_title']) :esc_url($instagram_customer['ins_url']) ?></span></a>
               <?php endif ?>

              <span class="showcase-articles__description"><?php echo esc_attr(get_post_meta($post->ID, '_showcase_description', true)) ?></span>

              <a href="<?php echo $url; ?>" class="showcase-articles__readmore">
                <?php if(get_post_meta($post->ID, '_author_name', true)): echo esc_attr(get_post_meta($post->ID, '_author_name', true)) ?>’s <?php endif; ?><?php _e('Story', 'theme-translations' ); ?> <svg class="icon svg-icon-arrowr"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-arrowr"></use> </svg></a>
            </div>
          </div><!-- col-12 col-md-6 -->
        </div>
        <?php
      endforeach;
      ?>
    </div>
    <div class="spacer-h-60"></div>
      <?php
    endif;
    if(is_active_sidebar('theme_customers_page')){
      dynamic_sidebar('theme_customers_page');
    }
  }
  /**
  * prints customer single post before content meta
  */
  public static function print_customer_before_content(){
    $post = get_queried_object  ();
    ?>
    <?php
    $o = get_post_meta($post->ID, '_showcase_story', true);
     ?>
      <section class="story white">
        <div class="spacer-h-90"></div>
        <div class="container container_sm">
          <?php if (isset($o['show']) && 'yes' === $o['show']):
            $image = (isset($o['image_id']))? wp_get_attachment_image_url($o['image_id'], 'full'): DUMMY; ?>
            <div class="row">
              <div class="col-12 col-md-8 z10">
                <div class="vertical-center">
                  <div class="vertical-center__inner">
                    <?php if (isset($o['category'])): ?>
                      <p class="story__label"><?php echo  esc_attr($o['category']) ?></p>
                    <?php endif ?>
                    <?php if (isset($o['title'])): ?>
                    <p class="story__title">
                     <?php echo  esc_attr($o['title']) ?>
                    </p>
                    <?php endif ?>
                    <?php if (isset($o['url'])): ?>
                    <a href="<?php echo  esc_url($o['url']) ?>" data-type="<?php echo (isset($o['url_type']))? esc_url($o['url_type']): '' ?>" class="story__cta trigger-video"><?php echo (isset($o['url_text']))? esc_attr($o['url_text']):esc_url($o['url']) ?>></a>
                    <?php endif ?>
                  </div>
                </div>
              </div>
              <div class="col-12 col-md-6 pull-md-2 z5">
                <div class="story__thumbnail v2">
                  <div class="story__thumbnail-inner">
                    <img src="<?php echo  esc_url($image) ?>" class="story__image" alt="">
                  </div>
                </div>
              </div>
            </div><!-- row -->
          <div class="spacer-h-70"></div>
        <?php endif;?>

        <?php
        $o = get_post_meta($post->ID, '_instagram_customer', true);
        $icon = (isset($o['icon_id']))? wp_get_attachment_image_url($o['icon_id'], 'icon'): '';
         ?>
         <?php if (isset($o['text'])): ?>
          <div class="clearfix">
            <div class="textcenter">
              <?php if (isset($o['title'])): ?>
               <p class="story__subtitle lg">
                <img src="<?php echo esc_url($icon) ?>" alt="<?php echo esc_attr($o['title']); ?>">
                <?php echo esc_attr($o['title']); ?>
              </p>
              <?php endif ?>
              <p class="story__text">
                <?php echo esc_attr($o['text']); ?>
              </p>

              <a href="<?php echo esc_url($o['ins_url']) ?>" class="story__social">
                <svg class="icon svg-icon-instagram"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-instagram"></use> </svg>
                <span><?php echo($o['ins_title'])? esc_attr($o['ins_title']): esc_url($o['ins_url']); ?></span>
              </a>
            </div>
          </div>
          <div class="spacer-h-40"></div>
        <?php endif ?>
        </div><!-- container -->
      </section>
    <?php
      $img_text = get_post_meta($post->ID, '_img_text', true);
    ?>
    <?php
     if ($img_text):
        $type = 'odd';
     ?>
      <div class="container container_sm">
        <div class="spacer-h-90"></div>
          <?php foreach ($img_text['items'] as $key => $item):
            switch ($item['type']) {
              case 'quote':
                 if (!$item['text']) {
                    break;
                  }
                ?>
                <div class="textcenter blockquote">
                  <p class="blockquote__text">“<?php echo  esc_attr($item['text']); ?>”</p>
                  <p class="blockquote__author"><?php echo  esc_attr($item['author']); ?></p>
                </div>
                 <?php if ($key+1 != count($img_text['items'])): ?>
                    <div class="spacer-h-60"></div>
                  <?php endif ?>
                <?php
                break;

              default:

                  $image = wp_get_attachment_image_url($item['image_id'], 'full');

                  if (!$image && (!$item['title'] || !$item['text'])) {
                    break;
                  }
                switch ($type ) {
                  case 'odd':
                  ?>
                  <div class="row">
                    <div class="col-12 col-md-7 order-sm-2">
                      <div class="showcase-preview__image">
                        <img src="<?php echo esc_url($image)?>" alt="<?php echo isset($item['title'])? esc_attr($item['title']) : ''; ?>">
                      </div>
                    </div>
                    <div class="col-12 col-md-5">
                      <div class="showcase-preview__data">
                        <div class="showcase-preview__data-inner">
                          <span  class="showcase-preview__category"><?php echo isset($item['before_title'])? esc_attr($item['before_title']) :''; ?></span>
                          <span class="showcase-preview__title"><?php echo isset($item['title'])? esc_attr($item['title']) : ''; ?></span>

                          <span class="showcase-preview__description"><?php echo isset($item['text'])?  esc_attr($item['text']): ''; ?></span>

                        </div>
                      </div>
                    </div><!-- col-12 col-md-6 -->
                  </div><!-- row -->
                  <?php if ($key+1 != count($img_text['items'])): ?>
                    <div class="spacer-h-100"></div>
                  <?php endif ?>

                  <?php
                    break;
                  case 'even':
                   ?>
                  <div class="row">
                    <div class="col-12 col-md-7">
                      <div class="showcase-preview__image">
                         <img src="<?php echo esc_url($image)?>" alt="<?php echo isset($item['title'])? esc_attr($item['title']) : ''; ?>">
                      </div>
                    </div>
                    <div class="col-12 col-md-5">
                      <div class="showcase-preview__data">
                        <span class="showcase-preview__category"><?php echo isset($item['before_title'])? esc_attr($item['before_title']) :''; ?></span>
                        <span class="showcase-preview__title"><?php echo isset($item['title'])? esc_attr($item['title']) : ''; ?></span>

                        <span class="showcase-preview__description"><?php echo isset($item['text'])?  esc_attr($item['text']): ''; ?></span>

                      </div>
                    </div><!-- col-12 col-md-6 -->
                  </div><!-- row -->
                  <?php if ($key+1 != count($img_text['items'])): ?>
                    <div class="spacer-h-100"></div>
                  <?php endif ?>

                   <?php
                    break;
                }
                 $type = ('odd' === $type)? 'even': 'odd';

                break;
            }
          endforeach; ?>
        </div>
    <div class="spacer-h-90"></div>
    <?php endif;
    $gallery = get_post_meta($post->ID, '_gallery', true);
    ?>
    <?php if ($gallery['items']): ?>
    <div class="slider-images owl-slider">
      <?php foreach ($gallery['items'] as $key => $item):
        $image = wp_get_attachment_image_url($item['image_id'], 'gallery_thumb');
        if(!$image) continue;
        ?>
      <a href="<?php echo (isset($item['url']))? esc_url($item['url']): '';?>" class="slider-images__item"><img src="<?php echo esc_url($image)?>" alt="showcase"></a>
      <?php endforeach ?>
    </div>
    <div class="spacer-h-90"></div>
    <?php endif;
  }


  public static function check_prem_before_checkout_form($checkout){
    global $continued_checkout;

    if(user_is_premium()){
      $continued_checkout = true;
    }else if(isset($_POST['continued']) && 'yes' === $_POST['continued']){
      $continued_checkout = true;
    }else{
      foreach ( WC()->cart->get_cart() as $cart_item ) {
        $continued_checkout  = (product_is_subscription($cart_item['data']))? true : $continued_checkout;
      }
    }

    // remove this row to get back selection of a plan

    $continued_checkout = true;


    if($continued_checkout || !is_user_logged_in()) return;

    $days_offset = get_ready_date_offset(false);
    $days_offset_prem = get_ready_date_offset(true);
    $ready_date  = date('d F Y', strtotime($days_offset));
    $ready_date_prem  = date('d F Y', strtotime($days_offset_prem));

    $o = get_option('theme_settings');
    if(function_exists('wc_get_product')){
      $subscription = wc_get_product((int)$o['subscription']);
      $price_per = get_post_meta( $subscription->get_id(), '_ywsbs_price_is_per', '1' );
      $price_per_period_name = get_post_meta( $subscription->get_id(), '_ywsbs_price_time_option', 'days' );
    } else{
      $subscription = false;
    }

    ?>
      <div class="container">
        <div class="page-title textcenter"><?php _e('Choose a plan', 'theme-translations' ); ?></div>
      <div class="spacer-h-25"></div>
        <div class="row justify-content-center">
          <div class="billing-plan">
            <p class="billing-plan__title"><?php _e('Click & Create', 'theme-translations' ); ?></p>
            <p class="billing-plan__comment"><?php _e('Custom images on-demand, pay as you go', 'theme-translations' ); ?></p>

            <p class="billing-plan__time">
              <i class="icon-time"></i>
              <span class="title"><?php _e('Estimated Download Date', 'theme-translations' ); ?></span>
              <span class="date"><?php echo $ready_date ?></span>
            </p>

            <div class="separator"></div>

            <p class="billing-plan__subtitle"><?php _e('Image Sizes', 'theme-translations' ); ?></p>
            <div class="tag-cloud">
              <span class="tag-cloud__item active">
                <svg class="icon svg-icon-instagram"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-instagram"></use> </svg>
                <span class="text">
                  Instagram
                </span>
                <i class="icon-status"></i>
              </span>
              <span class="tag-cloud__item not-active">
                <svg class="icon svg-icon-fb"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-fb"></use> </svg>
                <span class="text">
                  Facebook
                </span>
                <i class="icon-status"></i>
              </span>
              <span class="tag-cloud__item not-active">
                <svg class="icon svg-icon-snap"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-snap"></use> </svg>
                <span class="text">
                  Snapchat
                </span>
                <i class="icon-status"></i>
              </span>
              <span class="tag-cloud__item not-active">
                <svg class="icon svg-icon-hd"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-hd"></use> </svg>
                <span class="text">
                  Full HD
                </span>
                <i class="icon-status"></i>
              </span>
            </div><!-- tag-cloud -->

            <p class="billing-plan__subtitle"><?php _e('License', 'theme-translations' ); ?></p>

            <div class="tag-cloud">
              <span class="tag-cloud__item active">
                <span class="text">
                  Social &amp; Web
                </span>
                <i class="icon-status"></i>
              </span>
              <span class="tag-cloud__item not-active">
                <span class="text">
                  Advertising
                </span>
                <i class="icon-status"></i>
              </span>
            </div><!-- tag-cloud -->
            <form action="" method="POST">
              <input type="hidden" name="continued" value='yes'>
              <button class="button-basic" <?php echo 'style="border:0;"'; ?>><?php _e('Continue with Basic', 'theme-translations' ); ?></button>
            </form>
          </div>

          <?php if ($subscription ): ?>
          <div class="billing-plan active">
            <p class="billing-plan__title"><?php _e('Premium', 'theme-translations' ); ?> <span class="tag"><i class="icon-flash"></i> FASTTRACK</span></p>
            <p class="billing-plan__comment"><?php _e('Become a Member for', 'theme-translations' ); ?>  <b> <?php echo wc_price($subscription->get_price()) ?> <?php _e('per', 'theme-translations' ); ?>
              <?php
                $per = sprintf('%s %s', $price_per, $price_per_period_name);
                echo str_replace(array('30 days', '31 days'), __('month', 'theme-translations'), $per);
              ?>
            </b></p>

            <p class="billing-plan__time">
              <i class="icon-flash"></i>
              <span class="title"><b>Fasttrack</b> <?php _e('Download Date', 'theme-translations' ); ?></span>
              <span class="date green"><?php echo $ready_date_prem ?></span>
            </p>
            <div class="separator"></div>

            <p class="billing-plan__subtitle"><?php _e('Image Sizes', 'theme-translations' ); ?></p>
            <div class="tag-cloud">
              <span class="tag-cloud__item active">
                <svg class="icon svg-icon-instagram"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-instagram"></use> </svg>
                <span class="text">
                  Instagram
                </span>
                <i class="icon-status"></i>
              </span>
              <span class="tag-cloud__item active">
                <svg class="icon svg-icon-fb"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-fb"></use> </svg>
                <span class="text">
                  Facebook
                </span>
                <i class="icon-status"></i>
              </span>
              <span class="tag-cloud__item active">
                <svg class="icon svg-icon-snap"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-snap"></use> </svg>
                <span class="text">
                  Snapchat
                </span>
                <i class="icon-status"></i>
              </span>
              <span class="tag-cloud__item active">
                <svg class="icon svg-icon-hd"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-hd"></use> </svg>
                <span class="text">
                  Full HD
                </span>
                <i class="icon-status"></i>
              </span>
            </div><!-- tag-cloud -->

            <p class="billing-plan__subtitle"><?php _e('License', 'theme-translations' ); ?></p>

            <div class="tag-cloud">
              <span class="tag-cloud__item active">
                <span class="text">
                  Social &amp; Web
                </span>
                <i class="icon-status"></i>
              </span>
              <span class="tag-cloud__item active">
                <span class="text">
                  Advertising
                </span>
                <i class="icon-status"></i>
              </span>
            </div><!-- tag-cloud -->

            <a href="<?php echo esc_url($subscription->add_to_cart_url() )?>" class="button-prem"><svg class="icon svg-icon-unlock"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-unlock"></use> </svg> <?php _e('Continue with Premium', 'theme-translations' ); ?></a>

            <span class="after-item"><?php _e('No minimum term', 'theme-translations' ); ?>. <?php _e('Cancel anytime', 'theme-translations' ); ?>.</span>
          </div>
          <?php endif ?>
        </div>
      </div>
    <?php
  }

  /**
  *
  */
  public static function print_ingredients($post_id){

    $post = get_queried_object();
    $o = get_post_meta($post->ID, 'custom_product_ingredients', true);

    ?>
    <?php if (isset($o['items']) && is_array($o['items']) && count($o['items']) > 0): ?>
    <?php if (isset($o['title'])): ?>
    <h2 class="upsells__title"><i class="icon-ingredients-lg"></i><?php echo $o['title']?></h2>
    <?php endif ?>
    <?php if (isset($o['comment'])): ?>
    <p class="upsells__comment"><?php echo $o['comment']?></p>
    <?php endif ?>


    <div class="row products-md">

      <?php foreach ($o['items'] as $key => $item):
        $image = wp_get_attachment_image_src($item['image_id'], 'showcase_thumb');

        if(!$item['image_id'] || (int)$item['image_id'] < 0){
          continue;
        } ?>
      <div class="col-md-3 col-12">
        <div class="ingredient-image">
          <img src="<?php echo $image[0] ?>" alt="">
        </div>

        <p class="ingredient-title"><?php echo $item['title'] ?></p>
        <p class="ingredient-comment"><?php echo $item['comment'] ?></p>
      </div>
      <?php endforeach ?>
      <div class="col-md-3 col-12"></div>
      <div class="col-md-3 col-12"></div>
    </div>
    <div class="spacer-h-50"></div>
      <?php endif ?>
    <?php
  }


  /**
  *
  */
  public static function print_product_attributes_sidebar(){
    $post        = get_queried_object();
    $o           = get_option('theme_attributes_images');
    $attributes  = wc_get_attribute_taxonomies();

    foreach ($attributes as $key => $attr) {
      $taxonomy_name = (stripos('pa_', $attr->attribute_name) !== false) ? $attr->attribute_name : sprintf('pa_%s',$attr->attribute_name );

      if(isset($o['attribute_'.$taxonomy_name ]['show_additional_data']) && 'yes' === $o['attribute_'.$taxonomy_name ]['show_additional_data']){

        switch ($o[ 'attribute_'.$taxonomy_name ]['type']) {
          case 'icon':
            $icon  =  sprintf('<i class="icon-%s"></i>', $o[ 'attribute_'.$taxonomy_name ]['icon'] );
            break;
          case 'image':
            $image_id  = (int)$o[ 'attribute_'.$taxonomy_name ]['icon_id'];
            $image_url = wp_get_attachment_image_url($image_id, 'thumbnail');
            $icon      = sprintf('<img class="image-icon" src="%s" height="18" width="18" alt="">', $image_url );
            break;

          default:
            $icon = '';
            break;
          }


        $terms = get_terms(  $taxonomy_name,  array(
          'hide_empty' => false,
        ) );
        ?>

        <div class="product-attribute-sidebar <?php echo $taxonomy_name ?>">
          <div class="inner">
            <div class="inner__header">
              <a href="#" class="return-link hide_product-attribute-sidebar"><svg class="icon svg-icon-arrowr"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-arrowr"></use> </svg>Order Images</a>
              <h3 class="product-attribute-sidebar__title">
                <?php echo $icon ?>
                <?php echo wc_attribute_label(  $attr->attribute_name ) ?>
              </h3>

              <div class="product-attribute-sidebar__comment">
                <?php   echo apply_filters('the_content', $o[ 'attribute_'.$taxonomy_name ]['additional_data']) ?>
              </div>
            </div>
            <div class="inner__body">
              <?php foreach ($terms as $key => $term):
                $option = $o[ 'attribute_'.$taxonomy_name ]['terms'][$term->slug];
                $image_id  = (int)$option['image_id'];
                $image_url = wp_get_attachment_image_url($image_id, 'product_thumb_md');
                if(!$image_url) continue;
                ?>
                <div class="product-attribute-sidebar__term">
                  <div class="title-block">
                    <?php if (isset($option['is_popular']) && 'yes' === $option['is_popular']): ?>
                    <span class="product-attribute-sidebar__tag">
                      <i class="icon-popular"></i>POPULAR
                    </span>
                    <?php endif ?>
                    <p class="title-block__title"><?php echo $term->name ?></p>
                    <p class="title-block__comment"><?php echo (isset($option['comment']))?$option['comment'] : '' ?></p>
                  </div>
                  <div class="image-block">
                      <img src="<?php echo $image_url ?>" alt="<?php echo $taxonomy_name ?>">
                  </div>
                </div>
              <?php endforeach ?>
            </div>
            <div class="inner__footer">
              <div class="row">
                <div class="col-6">
                  <b> Need help choosing?</b>
                  <p>Speak to our team of experts</p>
                </div>
                <div class="col-6">
                  <?php
                   $active_plugins = get_option('active_plugins');
                   $button_intercom = (in_array('intercom/bootstrap.php', $active_plugins))? '<a href="javascript:void(0)" class="button button_chat" onclick="Intercom(\'show\')"> <span class="item item1"></span> <span class="item item2"></span> <span class="item item3"></span> Live Support </a>' : "";

                   echo $button_intercom;
                  ?>
                </div>
              </div>
            </div>
          </div>
        </div>
        <?php
      }
    }
  }

  public static function print_why_block(){
    $text1 = get_option('static_home_page_features_item1');
    $text2 = get_option('static_home_page_features_item2');
    $text3 = get_option('static_home_page_features_item3');

    if(empty($text1) && empty($text2)  && empty($text3) ) return;
    ?>
        <div class="why-block">
          <div class="container container_sm">
            <?php if (!empty($text1)): ?>
            <div class="why-block__item">
              <div class="why-block__item-inner">
                <span class="why-block__item-icon live"></span>
                <span class="why-block__item-text"><?php echo $text1 ?></span>
              </div>
            </div>
            <?php endif ?>
            <?php if ( !empty($text2) ): ?>
            <div class="why-block__item">
              <div class="why-block__item-inner">
                <span class="why-block__item-icon approval"></span>
                <span class="why-block__item-text"><?php echo $text2 ?></span>
              </div>
            </div>
            <?php endif ?>
             <?php if ( !empty($text3) ): ?>
            <div class="why-block__item">
              <div class="why-block__item-inner">
                <span class="why-block__item-icon clock"></span>
                <span class="why-block__item-text"><?php echo $text3 ?></span>
              </div>
            </div>
            <?php endif ?>

            <div class="why-block__item fullsize-sm to-right-md">
              <div class="why-block__item-inner">
                <img src="<?php echo THEME_URL ?>/images/product_hunt.png" class="product-hunt-text" alt="">
                <span class="stars-orange">
                  <i class="icon-star-orange"></i>
                  <i class="icon-star-orange"></i>
                  <i class="icon-star-orange"></i>
                  <i class="icon-star-orange"></i>
                  <i class="icon-star-orange"></i>
                </span>

                <span class="star-rate">
                  5/5
                </span>
              </div>
            </div>
          </div>
        </div><!-- why-block -->
        <div class="spacer-h-50"></div>
    <?php
  }

  public static function print_home_customer_story(){
    $subtitle  = get_option('static_home_page_story_subtitle');
    $title     = get_option('static_home_page_story_title');
    $text      = get_option('static_home_page_story_text');
    $link_text = get_option('static_home_page_story_link_text');
    $link_url  = get_option('static_home_page_story_link_url');
    $image     = get_option('static_home_page_story_image');

    if(empty($subtitle) && empty($title) && empty($text) && (empty($link_url) || empty($link_text)) ) return;
    ?>
    <section class="shift-stories">
      <div class="container container_sm ">
        <div class="stories-block colored">
          <div class="stories-block__info">
            <?php if (!empty($subtitle)): ?>
              <span class="stories-block__category"><?php echo $subtitle; ?></span>
            <?php endif ?>
            <?php if (!empty($title) ): ?>
            <h4 class="stories-block__title"><?php echo $title; ?></h4>
            <?php endif ?>
            <?php if (!empty($text)): ?>
            <p class="stories-block__text"><?php echo $text; ?></p>
            <?php endif ?>
            <?php if ((!empty($link_url) && !empty($link_text))): ?>
            <a href="<?php echo $link_url; ?>" class="video-link trigger-video"><span><?php echo $link_text; ?></span></a>
            <?php endif ?>
          </div>
            <?php if ($image): ?>
          <div class="stories-block__image">
            <img src="<?php echo $image ?>" alt="">
          </div>
            <?php endif ?>
        </div>
        <div class="spacer-h-50"></div>
      </div>
    </section>
    <?php
  }


  public static function print_home_social_about(){
    $subtitle = get_option('static_home_page_social_media_subtitle');
    $title    = get_option('static_home_page_social_media_title');
    $text     = get_option('static_home_page_social_media_text');

    $days_offset = get_ready_date_offset(false);
    $days_offset_prem = get_ready_date_offset(true);
    $ready_date  = date('d F Y', strtotime($days_offset));
    $ready_date_prem  = date('d F Y', strtotime($days_offset_prem));

    $o = get_option('theme_settings');
    if(function_exists('wc_get_product')){
      $subscription = wc_get_product((int)$o['subscription']);
      if($subscription){
        $price_per = get_post_meta( $subscription->get_id(), '_ywsbs_price_is_per', '1' );
        $price_per_period_name = get_post_meta( $subscription->get_id(), '_ywsbs_price_time_option', 'days' );
      }
    } else{
      $subscription = false;
    }

    ?>
    <section class="vc_section vc_custom_1576165770692 vc_section-has-fill"><div class="vc_row wpb_row vc_row-fluid container container_sm"><div class="wpb_column vc_column_container vc_col-sm-12"><div class="vc_column-inner"><div class="wpb_wrapper"><div class="vc_row wpb_row vc_inner vc_row-fluid vc_column-gap-15 vc_row-o-equal-height vc_row-flex"><div class="wpb_column vc_column_container vc_col-sm-8 vc_col-has-fill"><div class="smartstudio__box vc_column-inner vc_custom_1576077396675"><div class="wpb_wrapper"><div class="vc_empty_space" <?php echo 'style="height: 55px"' ?>><span class="vc_empty_space_inner"></span></div>
      <div class="wpb_single_image wpb_content_element vc_align_center">

        <figure class="wpb_wrapper vc_figure">
          <div class="vc_single_image-wrapper   vc_box_border_grey"><img src="https://feedsauce.com/wp-content/uploads/2019/12/smartstudio_logo.svg" class="vc_single_image-img attachment-full" alt=""></div>
        </figure>
      </div>

      <div class="wpb_text_column wpb_content_element  vc_custom_1576076257838">
        <div class="wpb_wrapper">
          <p <?php echo 'style="text-align: center;padding-left: 35px;padding-right: 35px;"' ?>><span <?php echo 'style="color: #e0e8f9;"' ?>>Our innovative studio technology designed to deliver custom photos in 72 hours, ready to use on your online store or social media.</span></p>

        </div>
      </div>

      <div class="wpb_raw_code wpb_content_element wpb_raw_html">
        <div class="wpb_wrapper">
          <center><a href="https://feedsauce.com/recipes/" class="button cta__button"><span class="plus"></span> <span> &nbsp; &nbsp;Start Creating &nbsp; &nbsp;</span></a></center>
        </div>
      </div>
    <div class="vc_empty_space" <?php echo 'style="height: 55px"' ?>><span class="vc_empty_space_inner"></span></div></div></div></div><div class="wpb_column vc_column_container vc_col-sm-4 vc_col-has-fill"><div class="fasttrack__box vc_column-inner vc_custom_1576077964190"><div class="wpb_wrapper">
      <div class="wpb_single_image wpb_content_element vc_align_center">

        <figure class="wpb_wrapper vc_figure">
          <div class="vc_single_image-wrapper   vc_box_border_grey"><img src="https://feedsauce.com/wp-content/uploads/2019/12/fs.svg" class="vc_single_image-img attachment-full" alt=""></div>
        </figure>
      </div>

      <div class="wpb_single_image wpb_content_element vc_align_center">

        <figure class="wpb_wrapper vc_figure">
          <div class="vc_single_image-wrapper   vc_box_border_grey"><img src="https://feedsauce.com/wp-content/uploads/2019/12/fast.svg" class="vc_single_image-img attachment-full" alt=""></div>
        </figure>
      </div>

      <div class="wpb_text_column wpb_content_element  vc_custom_1576083633692 killMargin">
        <div class="wpb_wrapper">
          <p <?php echo 'style="font-family: PoppinsFont,Poppins,sans-serif !important; color: #fff; text-align: center; font-size: 28px; font-weight: 500; line-height: 1.2em; margin-top: -20px !important;"' ?> >Supercharge your brand</p>

        </div>
      </div>

      <div class="wpb_text_column wpb_content_element  vc_custom_1576083696003">
        <div class="wpb_wrapper">
          <p class="p1" <?php echo 'style="text-align: center;"><span class="s1" style="color: #e0e8f9; font-size: 14px !important;" '; ?>>

            Have your product picked up tomorrow and photos ready by <span class="date green" <?php echo 'style="color: #3CBF8A; font-weight: bold;" '; ?> ><?php echo $ready_date_prem ?></span>


          </span></p>

        </div>
      </div>
    </div></div></div></div></div></div></div></div></section>



    <section class="vc_section vc_custom_1576161916481 vc_section-has-fill"><div class="vc_row wpb_row vc_row-fluid container container_sm vc_custom_1576164834145 vc_row-has-fill"><div class="wpb_column vc_column_container vc_col-sm-12"><div class="vc_column-inner"><div class="wpb_wrapper"><div class="vc_row wpb_row vc_inner vc_row-fluid vc_custom_1576164837515 vc_row-has-fill"><div class="wpb_column vc_column_container vc_col-sm-12"><div class="tour__box vc_column-inner"><div class="wpb_wrapper"><div class="vc_empty_space" <?php echo 'style="height: 20px"'; ?>><span class="vc_empty_space_inner"></span></div>
  <div class="wpb_raw_code wpb_content_element wpb_raw_html vc_custom_1576163464660">
    <div class="wpb_wrapper">
      <div class="vc_col-sm-2">

</div>
<div class="vc_col-sm-8">
<p <?php echo 'style="font-family: PoppinsFont,Poppins,sans-serif !important; color: #fff; text-align: center; font-size: 40px; font-weight: 500; line-height: 1.2em;"'; ?>'>Stay in full creative control at every stage.</p>
</div>
<div class="vc_col-sm-2">

</div>


    </div>
  </div>

  <div class="wpb_single_image wpb_content_element vc_align_center  vc_custom_1576164697393">

    <figure class="wpb_wrapper vc_figure">
      <div class="vc_single_image-wrapper   vc_box_border_grey"><img src="https://feedsauce.com/wp-content/uploads/2019/12/ccontrol.svg" class="vc_single_image-img attachment-full" alt=""></div>
    </figure>
  </div>

  <div class="wpb_raw_code wpb_content_element wpb_raw_html">
    <div class="wpb_wrapper">
      <center><a href="https://feedsauce.com/tour/" class="button cta__button"><span class="plus"></span> <span> &nbsp; &nbsp;<i class="fas fa-bullseye"></i>&nbsp;&nbsp;Take The Tour &nbsp; &nbsp;</span></a></center>
    </div>
  </div>

  <div class="tour__img wpb_single_image wpb_content_element vc_align_center  vc_custom_1576163834109">

    <figure class="wpb_wrapper vc_figure">
      <div class="vc_single_image-wrapper   vc_box_border_grey"><img width="1790" height="694" src="https://feedsauce.com/wp-content/uploads/2019/12/feedsauce-tour-1.png" class="vc_single_image-img attachment-full" alt=""></div>
    </figure>
  </div>
</div></div></div></div></div></div></div></div></section>
       <section class="white media-details-wrapper">
          <div class="container container_sm">
            <div class="media-details" <?php echo 'style="background-image:url('. THEME_URL.'/images/bg_orbit_s.jpg);"';?>>
              <p class="media-details__category"><?php echo $subtitle; ?></p>
              <h3 class="media-details__title"><?php echo $title; ?></h3>
              <p class="media-details__text"><?php echo $text; ?></p>
            </div><!-- media-details -->
          </div><!-- container container_sm -->
        </section>
    <?php
  }


  public static function print_showcase_on_home(){
    $subtitle  = get_option('static_home_page_showcases_subtitle');
    $title     = get_option('static_home_page_showcases_title');
    $text      = get_option('static_home_page_showcases_text');

    $validate_content = false;

    $items = array();

    for ($i=1; $i <4 ; $i++) {
      $option_name_title = 'static_home_page_showcases_item'.$i.'_title';
      $option_name_text = 'static_home_page_showcases_item'.$i.'_text';
      $option_name_url = 'static_home_page_showcases_item'.$i.'_url';
      $_title = get_option($option_name_title);
      $_text = get_option($option_name_text);
      $_url = get_option($option_name_url);
      if ($_title || $_text || $_url) {
        $validate_content = true;
        $items[$i] = array(
          'title' => $_title,
          'text' => $_text,
          'url' => $_url,
        );
      }
    }

    if(!$subtitle && !$title && !$text && !$validate_content ) return;
    ?>

    <?php
  }


  /**
  * Prints a comment text and a button on single product's page
  *
  * @return void
  */
 /*public static function print_single_product_images_after(){
    $args = array();
    print_theme_template_part('after-image', 'single-product', $args);
  }*/


  // public static function print_single_product_guidlines(){
  //   $args = array();
  //   print_theme_template_part('guidlines', 'single-product', $args);
  // }

  public static function print_fly_basket(){
    global $theme_init;
    $helper  = new theme_formatted_cart();

    $args = array(
      'url' => wc_get_cart_url(),
      'content' => $helper->get_cart_mini(),
      'total_items' => $helper->get_items_count(),
      'total_cart'  => wc()->cart->get_total(),
      'add_ons'     => ($helper->get_addons_total() > 0) ? wc_price($helper->get_addons_total()) : false,
    );

    if(is_product()){
      print_theme_template_part('fly-basket', 'single-product', $args);
    }else{
      print_theme_template_part('fly-basket', 'woocommerce', $args);
    }
  }

  public static function print_cart_edit_slide(){
    $args = array();
    print_theme_template_part('edit-slide', 'cart', $args);
  }

  public static function print_regular_content(){
    echo '<div class="container container_sm">';
    the_content();
    echo '</div>';
  }

  /**
  * @deprecated
  */
  // public static function print_product_content(){
  //   if(!function_exists('get_field')){
  //     echo 'Install ACF PLUGIN';
  //     return;
  //   }

  //   global $product;
  //   global $theme_init;

  //   $img_url = wp_get_attachment_image_url($product->get_image_id(), wp_is_mobile()? 'full' : 'full');

  //   $constructor_url = get_permalink(get_option('theme_page_constructor'));

  //   $gallery_ids = $product->get_gallery_image_ids();


  //   $counter = 1;

  //   $gallery = array();

  //   foreach ($gallery_ids as $id) {
  //     $size = wp_is_mobile() ? 'gallery_'.$counter : 'full';
  //     $gallery[] = wp_get_attachment_image_url($id, $size);
  //     $counter++;
  //     $counter = $counter > 3? 0 : $counter;
  //   }

  //   $product_id = $product->get_id();

  //   wc()->cart->empty_cart();
  //   wc()->cart->add_to_cart((int)$product_id , 1, (int)$product_id);

  //   $myaccount_page = get_option( 'woocommerce_myaccount_page_id' );
  //   $myaccount_page_url = get_permalink( $myaccount_page );
  //   $constructor_url = is_user_logged_in() ? $constructor_url.'?product_id='.$product_id.'?add_to_cart='.$product_id : $myaccount_page_url.'?product_id='.$product_id ;

  //   $args = array(
  //     'img_url' => $img_url,

  //     'gallery' => $gallery,

  //     'constructor_url' => $constructor_url,

  //     'title'   => $product->get_name(),

  //     'description_short'   => $product->get_short_description(),

  //     'bg_color'  => get_post_meta($product->get_id(), 'bg_color', true)? : '#000',

  //     'cta_text'  => get_post_meta($product->get_id(), 'cta_text', true)? : '<b> Customise Blocks to match your brand.</b>Order now and download your photos in <span class="green">72 hours</span>',

  //     'photo_price' => strip_tags(wc_price(30)),

  //     'rate' => array(
  //       'value' => get_post_meta($product->get_id(), 'rate_value', true)? :  4.5,
  //       'title' => get_post_meta($product->get_id(), 'rate_title', true)? :'Excellent',
  //     ),

  //     'expect' => array(
  //       'display'         => get_field('expect_display', $product_id),
  //       'expect_for'      => get_field('expect_for', $product_id),
  //       'elements' => get_field('expect_elements', $product_id),
  //     ),

  //     'for' => array(
  //       'display' => get_field('for_display', $product_id),
  //       'title'   => get_field('for_title', $product_id),
  //       'text'    => get_field('for_text', $product_id),
  //     ),

  //     'show_blocks' => array(
  //       'show_customize_and_create' => get_field('show_customize_and_create', $product_id),
  //       'show_good_2_know' => get_field('show_good_2_know', $product_id),
  //       'show_bespoke' => get_field('show_bespoke', $product_id),
  //     ),

  //     'pgb' => get_option('product_global_blocks'),

  //   );

  //   wp_localize_script($theme_init->main_script_slug, 'gallery_items', $gallery);

  //   if(wp_is_mobile()):
  //     // print_theme_template_part('product-mobile', 'woocommerce', $args);
  //   else:
  //     // print_theme_template_part('product-desktop', 'woocommerce', $args);
  //   endif;
  // }


  public static function print_product_content_new(){
    if(!function_exists('get_field')){
      echo 'Install ACF PLUGIN';
      return;
    }

    global $product;

    /*get category*/

    $_ids = $product->get_category_ids();
    $terms = array();

    foreach ($_ids as $key => $_term_id) {
      $term = get_term($_term_id, 'product_cat');
      $thumbnail_id = (int)get_term_meta($_term_id, 'thumbnail_id', true );
      $term->icon =  wp_get_attachment_image_url($thumbnail_id, 'full');
      $terms[] = $term;
    }

    if(function_exists('yoast_get_primary_term_id')){
      $term_id = yoast_get_primary_term_id('product_cat');
    }else{
      $term_id = $_ids[0];
    }

    $term = get_term($term_id, 'product_cat');

    $term_tree = get_term_tree($term);

    /** get gallery urls*/

    $gallery_ids = $product->get_gallery_image_ids();

    foreach ($gallery_ids as $id) {
      $size = 'gallery_3';
      $gallery[] = wp_get_attachment_image_url($id, $size);
    }



    /** add product to cart to initiate shoot builder **/
    $product_id = $product->get_id();

    wc()->cart->empty_cart();

    if($product->get_type() == 'variable'){
      $variations = $product->get_available_variations();
      $variation_id = $variations[0]['variation_id'];
    }else{
      $variation_id = 0;
    }

    wc()->cart->add_to_cart((int)$product_id , 1, $variation_id);


    /** GET CONSTRUCTOR URL**/
    $constructor_url = get_permalink(get_option('theme_page_constructor'));
    $myaccount_page = get_option( 'woocommerce_myaccount_page_id' );
    $myaccount_page_url = get_permalink( $myaccount_page );
    $constructor_url = is_user_logged_in() ? $constructor_url.'?product_id='.$product_id: $myaccount_page_url.'?product_id='.$product_id ;

    /**bottom image data**/

    $bottom_image_id = get_field('bottom_image', $product_id);
    $bottom_image_regular   = wp_get_attachment_image_url($bottom_image_id, 'image_1920');
    $bottom_image_retina   = wp_get_attachment_image_url($bottom_image_id, 'full');

    $args = array(
      'constructor_url'   => $constructor_url,
      'gallery'   => $gallery,
      'product'   => $product,
      'term_tree' => $term_tree ,
      'product_id' => $product_id ,
      'terms'     => $terms,
      'bottom_image'     => array(
        'show'    =>(int)$bottom_image_id  >  0? true : false,
        'regular' =>  $bottom_image_regular ,
        'retina'  => $bottom_image_retina ,
      ),
      'what_to_expect'     => get_field( 'what_to_expect' ,$product_id),
      'faq'     => get_field( '_faq' ,$product_id),
      'shop_url' => function_exists('woocommerce_get_page_id')? get_permalink( woocommerce_get_page_id( 'shop' ) ) : false,
      'customer_reviews'     => get_field( 'customer_reviews' ,$product_id),
    );

    print_theme_template_part('product-new', 'woocommerce', $args);
  }

  public static function print_product_mobile_bar(){
    if(!function_exists('get_field')){
      echo 'Install ACF PLUGIN';
      return;
    }

    global $product;
    $product_id = $product->get_id();

    /** GET CONSTRUCTOR URL**/
    $constructor_url = get_permalink(get_option('theme_page_constructor'));
    $myaccount_page = get_option( 'woocommerce_myaccount_page_id' );
    $myaccount_page_url = get_permalink( $myaccount_page );
    $constructor_url = is_user_logged_in() ? $constructor_url.'?product_id='.$product_id.'?add_to_cart='.$product_id : $myaccount_page_url.'?product_id='.$product_id ;

    $args = array(
      'constructor_url'   => $constructor_url,
      'faq'     => get_field( '_faq' ,$product_id),
    );
    print_theme_template_part('product-mobile-bar', 'woocommerce', $args);

   }


  /**
  * Shoot Builder
  * placed on WooCommerce checkout page
  *
  */
  public static function print_product_contructor(){
    // an instance of velesh_init_theme class. Used here to get a script slug
    global $theme_init;

    // get product ID from passed parameters and pass this data to a script
    $product_id = (int)$_GET['product_id'];
    wp_localize_script($theme_init->main_script_slug, 'product_id', array($product_id));

    $product = wc_get_product($product_id);

    // gets products ids data for fasttrack and returning products
    $fattrack = wc_get_product(get_option('wfp_priority_delivery_product_id'));
    $handle   = wc_get_product(get_option('wfp_return_product_id'));

    // get and pass to javascript currency rates USD to GBP and EUR to GBP
    $currency_settings = get_option('theme_currency_settings');
    wp_localize_script($theme_init->main_script_slug, 'currency_settings', $currency_settings);

    // prepare price data for javascript
    $options = get_option('theme_settings');
    $options['image'] = $options['single_product_price'] ;
    $options['fasttrack'] = $fattrack->get_price() ;
    $options['handle']    = $handle->get_price()  ;
    $prices = array_map(function($el){return (int)$el;}, $options);
    wp_localize_script($theme_init->main_script_slug, 'theme_prices', $prices);

    // get a product type option
    // products types used for a dropdown in shoot builder to be define the type of product
    // can be countered as a category for a product
    if(isset($options['product_types'])){
      $product_types_published = isset($options['product_types']['published'])?  explode(PHP_EOL, $options['product_types']['published']): array();

      $product_types_published = array_map(function($el){return array('name'=>$el, 'published' => 1);}, $product_types_published);

      $product_types_soon = isset($options['product_types']['soon'])?  explode(PHP_EOL, $options['product_types']['soon']): array();
      $product_types_soon = array_map(function($el){return array('name'=>$el, 'published' => 0);}, $product_types_soon);
      $product_types = array_merge( $product_types_published, $product_types_soon);
      wp_localize_script($theme_init->main_script_slug, 'product_types', $product_types);
    }else{
      wp_localize_script($theme_init->main_script_slug, 'product_types', array());
    }

    // get available colors that can be used for this product
    $colors = get_field('constructor_color',  $product_id)? : array();
    $colors = array_map(function($el){
      $el['bg'] = $el['bg_img']?'url('.$el['bg_img'].')': $el['bg'];
      return $el;
    }, $colors);
    wp_localize_script($theme_init->main_script_slug, 'theme_colors', $colors);

    // get countries data and flags from WooCOmmerce settings
    $countries = new WC_Countries();
    $col = array_map(function($el){
      $country_name = '';
      $regexp = '/\([\s\S]*\)/';

      $country_name = $el;

      $country_name = preg_replace($regexp, '', $country_name);

      $country_flag_url = str_replace(' ', '_', trim($country_name)).'.png';

       return array(
        'name' => trim($el),
        'published' =>  $el =="United Kingdom (UK)"? 1 : 0,
        'flag' => THEME_URL.'/images/flags/'.$country_flag_url,

    ); }, $countries->get_countries());
    wp_localize_script($theme_init->main_script_slug, 'all_countries_flags', $col);
    wp_localize_script($theme_init->main_script_slug, 'all_countries', $countries->get_countries());


    // parameters passed to Shoot Builder template
    $args = array(
      'product_guid_url' =>get_option('theme_page_product_guid')? get_permalink( get_option('theme_page_product_guid')) : false,
      'redo_policy_url' => get_option('theme_page_redo_policy')? get_permalink( get_option('theme_page_redo_policy')) : '',
      'terms_page_url' => get_option('woocommerce_terms_page_id')? get_permalink( get_option('woocommerce_terms_page_id')) : '',
      'img_url' => wp_get_attachment_image_url($product->get_image_id(), wp_is_mobile()? 'full' : 'full'),
      'gateways' => WC()->payment_gateways->get_available_payment_gateways(),
      'title'    => $product->get_title(),
      'bg_color'  => get_post_meta( $product_id, 'bg_color', true)? : '#000',
    );

    print_theme_template_part('main', 'constructor', $args);
  }


  /**
  * prints adress popup component on shoot builder page
  */
  public static function print_popup_address(){
    $args = array();
    print_theme_template_part('popup-address', 'constructor', $args);
  }

  public static function print_footer_new(){
    $main_menu = wp_nav_menu( array(
      'theme_location'  => 'main_menu',
      'menu'            => '',
      'container'       => 'nav',
      'container_class' => 'footer-nav',
      'container_id'    => '',
      'menu_class'      => 'menu',
      'menu_id'         => '',
      'echo'            => false,
      'before'          => '',
      'after'           => '',
      'link_before'     => '',
      'link_after'      => '',
      'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
      'depth'           => 2,
      'walker'          => new main_menu_walker(),
    ) );

    $args = array(
      'main_menu' => $main_menu,
    );
    if(wp_is_mobile()):
      // print_theme_template_part('mobile', 'constructor', $args);
    else:
      print_theme_template_part('footer-desktop-new', 'globals', $args);
    endif;
  }



  public static function print_gallery(){

    global $theme_init;

    $user_id = get_current_user_id();

    $customer_orders = get_posts( array(
        'numberposts' => -1,
        'meta_key'    => '_customer_user',
        'meta_value'  => get_current_user_id(),
        'post_type'   => wc_get_order_types(),
        'post_status' => array_keys( wc_get_order_statuses() ),
    ) );

    $shoots = array_filter( $customer_orders, function($order_item){
      $images          = get_post_meta($order_item->ID , '_wfp_image', true);
      return !!$images;
    } );

    $shoots = array_map(function($order_item){
      $handle_id       = (int)get_option('wfp_return_product_id');
      $product_fast_id = (int)get_option('wfp_priority_delivery_product_id');
      $images          = get_post_meta($order_item->ID , '_wfp_image', true);
      $order = wc_get_order($order_item->ID);

      $items = array();

      $has_fasttrack = 0;
      $has_handle    = 0;

      $fasttrack_price = 0;
      $handle_price = 0;

      foreach ($order->get_items() as $key => $item) {

        if($item->get_product_id() == $handle_id ){
          $has_handle  = 1;
          $p = $item->get_product();
          $handle_price = $p->get_price();
        }

        if($item->get_product_id() == $product_fast_id ){
          $has_fasttrack = 1;
          $p = $item->get_product();
          $fasttrack_price = $p->get_price();
        }

        if($item->get_product_id() == $handle_id   || $item->get_product_id() == $product_fast_id ){
          continue;
        }

        $meta = $extra_data = $item->get_meta('extra_data');
        $product_name = isset($meta['name']['value'])? explode(PHP_EOL, $meta['name']['value']) : '';
        $product_count = isset($meta['name']['value'])? count($product_name) : '';
        $product = $item->get_product();


        $items[] = array(
          'order_item_id'=> $item->get_id(),
          'extra_data'   => $extra_data,
          'prices'       => $item->get_meta('theme_prices') && !is_null($item->get_meta('theme_prices'))?$item->get_meta('theme_prices'): get_option('theme_settings'),
          'product_name' => $product->get_title(),
          'item_name'    => $product_name,
          'item_count'   => $product_count,
        );
      }

      $current_status = new WC_Order_Status_Manager_Order_Status($order->get_status());

      $current_status_meta = get_post_meta($current_status->get_id(), 'custom_order_data', true);

      $current_status_order = isset(  $current_status_meta['order'] ) ? (int)$current_status_meta['order']   :0;

      $images =  get_post_meta($order->ID , '_wfp_image', true)?
              array_filter(get_post_meta($order->ID , '_wfp_image', true),function($el){
                return isset($el['files_uploaded']);
              }) :
              array();

      $today = new DateTime();
      $order_date = new DateTime($order_item->post_date);

      $diff = date_diff($today ,  $order_date );

      $actions   = wc_get_account_orders_actions( $order );

      return array(
        'order'  => (array)$order,
        'date'   => str_replace(' ','T', $order_item->post_date),
        'order_id' => $order->get_id(),
        'status'   => wc_get_order_status_name($order->get_status()),
        'coupons' => $order->get_used_coupons(),
        'current_status' =>  isset($current_status_meta['title'])? $current_status_meta['title']: wc_get_order_status_name($order->get_status()),
        'current_status_meta' => get_post_meta($current_status->get_id(), 'custom_order_data', true),
        'current_status_order' => isset(  $current_status_meta['order'] ) ? (int)$current_status_meta['order']   : -1,
        'item'  =>  $items[0],
        'has_fasttrack'    =>  $has_fasttrack,
        'has_handle'       =>  $has_handle,
        'fasttrack_price'  =>  $fasttrack_price,
        'handle_price'     =>  $handle_price,
        'images'     => $images,
        'thumbnails' => get_post_meta($order_item->ID, '_wfp_thumbnails', true),
        'total'    =>html_entity_decode( strip_tags(wc_price($order->get_total()))),
        'discount' =>html_entity_decode( strip_tags( wc_price($order->get_total_discount()))),
        'photo_limit' => get_post_meta($order->ID , '_wfp_image_limit', true),
        'diff' => $diff->format('%d') < 3 && $diff->format('%m') < 1 && $diff->format('%y') < 1 ?  3 - $diff->format('%d') : 0,
        'download_pdf' =>  isset($actions['print-invoice']['url'])? html_entity_decode($actions['print-invoice']['url']) : false,
      );
    },$shoots);

    $shoots = array_values($shoots);

    $args = array(
      'shoot_url' =>  esc_url(get_permalink(wc_get_page_id( 'shop' ) )),
      'gateways' => WC()->payment_gateways->get_available_payment_gateways(),
      'product_guid_url' =>get_option('theme_page_product_guid')? get_permalink( get_option('theme_page_product_guid')) : false,
      'redo_policy_url' => get_option('theme_page_redo_policy')? get_permalink( get_option('theme_page_redo_policy')) : '',
      'terms_page_url' => get_option('woocommerce_terms_page_id')? get_permalink( get_option('woocommerce_terms_page_id')) : '',
    );

    $orders = [];
    $number_of_active = 0;

    foreach (wc_get_order_statuses() as $key => $status):
      $st = new WC_Order_Status_Manager_Order_Status($key);
      $meta = get_post_meta($st->get_id(), 'custom_order_data', true);

      if(isset($meta['use']) && $meta['use'] == 'yes'){
        $num = (int)$meta['order'];
        $orders[$num]['name'] = $status;
        $orders[$num]['obj']  = $st;
        $orders[$num]['meta'] = $meta;
      }
    endforeach;

    $duh_tracker_options = get_option('duh_tracker_options');

    $theme_prices = get_option('theme_settings');


    wp_localize_script($theme_init->main_script_slug, '_dropbox', $duh_tracker_options['dropbox']);
    wp_localize_script($theme_init->main_script_slug, 'order_statuses', $orders);
    wp_localize_script($theme_init->main_script_slug, 'theme_prices', $theme_prices);
    wp_localize_script($theme_init->main_script_slug, 'my_shoots', $shoots);
    wp_localize_script($theme_init->main_script_slug, 'DUMMY_S', DUMMY_DARK);
    wp_localize_script($theme_init->main_script_slug, 'currency_symbol', html_entity_decode(get_woocommerce_currency_symbol()));

    if (wp_is_mobile()) {
      # code...
      print_theme_template_part('gallery-mobile', 'woocommerce', $args);
      print_theme_template_part('order-details-mobile', 'woocommerce', $args);
      print_theme_template_part('order-popup-mobile', 'woocommerce', $args);
    }else{
      print_theme_template_part('gallery', 'woocommerce', $args);
      print_theme_template_part('order-details', 'woocommerce', $args);
      print_theme_template_part('order-popup', 'woocommerce', $args);
    }
  }
}
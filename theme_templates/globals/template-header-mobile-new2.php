<?php
  defined( 'ABSPATH' ) || exit;

  /**
  * Template to dipslay mobile header
  */
?>

<div class="site-header-mob-spacer"></div>

<div class="site-header-mob-holder">
  <header class="site-header-mob">
    <div class="mobile-menu-switcher equis">
      <span></span>
    </div>
    <a href="#" class="logo">
     <img src="<?php echo $custom_logo_url; ?>" class="logo__img" alt="">
    </a>
               <?php if($user_id>0): ?>
                <div class="my-menu__gravatar gravatar"><img src="<?php echo $avatar_url; ?>" alt=""></div>
               <?php else: ?>
                <a href="<?php echo $myaccount_page_url; ?>" >
                  <svg class="icon svg-icon-login"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-login"></use> </svg>
                </a>
                <?php endif ?>
  </header>
</div>

<nav class="mobile-menu-holder">
  <div class="mobile-menu-holder__header">

    <svg class="mobile-menu-holder__close" width="16" height="16" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:avocode="https://avocode.com/" viewBox="0 0 16 16"><defs></defs><desc>Generated with Avocode.</desc><g><g><title>Path</title><path d="M14.8152,3.01982l-4.64596,4.64593v0l4.64596,4.64572c0.69107,0.69125 0.69107,1.81098 0,2.50224c-0.34529,0.34525 -0.79798,0.51801 -1.25046,0.51801c-0.45323,0 -0.90597,-0.1725 -1.251,-0.51801l-4.64697,-4.64625v0l-4.64662,4.6462c-0.34524,0.34525 -0.79799,0.51801 -1.25086,0.51801c-0.45274,0 -0.90517,-0.17249 -1.25073,-0.51801c-0.69106,-0.69094 -0.69106,-1.81072 0,-2.50224l4.64583,-4.64571v0l-4.64609,-4.64589c-0.69107,-0.69099 -0.69107,-1.81099 0,-2.50198c0.69093,-0.69045 1.81039,-0.69045 2.50159,0l4.64684,4.64594v0l4.64649,-4.64594c0.69132,-0.69045 1.81092,-0.69045 2.50172,0c0.69133,0.69099 0.69133,1.81099 0.00026,2.50198z" fill="#8d95ad" fill-opacity="1"></path></g></g></svg>

    <img src="<?php echo THEME_URL?>/images/logo-mark.svg" alt="">
  </div>

  <div class="spacer-h-50"></div>

  <div class="main-menu-new mobile">
    <ul class="menu">
      <?php if (is_active_sidebar('main_menu_create2')): ?>
      <li class="menu-item menu-item-mobile new dropdwon">
        <a href="#" class="mobile-menu-link">Create <span class="new">New</span></a>
        <div class="main-menu-new__expand">
          <div class="main-menu-new__expand-inner">
            <div class="spacer-h-20"></div>
            <div class="clearfix">
              <h2 class="main-menu-new__expand-moto"><span>Find your style.<img src="<?php echo THEME_URL?>/images/zig.png" alt=""> </span> </h2>
              <p class="main-menu-new__expand-text">Browse 200+ photo inspirations and start building your perfect product shoot today.</p>
              <div class="spacer-h-20"></div>
            </div><!-- clearfix -->
            <?php dynamic_sidebar('main_menu_create2'); ?>
          </div><!-- main-menu-new__dropdown-inner -->
        </div><!-- main-menu-new__dropdown -->
      </li>
       <?php endif ?>
      <?php if (is_active_sidebar('main_menu_publish')): ?>
      <li class="menu-item menu-item-mobile new dropdwon">
        <a href="#" class="mobile-menu-link">Publish</a>
        <div class="main-menu-new__expand">
          <div class="main-menu-new__expand-inner">
            <div class="spacer-h-20"></div>
            <div class="clearfix">
              <h2 class="main-menu-new__expand-moto"><span>Find your style.<img src="<?php echo THEME_URL?>/images/zig.png" alt=""> </span> </h2>
              <p class="main-menu-new__expand-text">Browse 200+ photo inspirations and start building your perfect product shoot today.</p>

              <div class="spacer-h-20"></div>

            </div><!-- clearfix -->
            <?php dynamic_sidebar('main_menu_publish'); ?>
          </div><!-- main-menu-new__dropdown-inner -->
        </div><!-- main-menu-new__dropdown -->
      </li>
       <?php endif ?>
      <?php if (is_active_sidebar('main_menu_grow')): ?>
      <li class="menu-item menu-item-mobile new dropdwon">
        <a href="#" class="mobile-menu-link">Grow</a>
        <div class="main-menu-new__expand">
          <div class="main-menu-new__expand-inner">
            <div class="spacer-h-20"></div>
            <div class="clearfix">
              <h2 class="main-menu-new__expand-moto"><span>Find your style.<img src="<?php echo THEME_URL?>/images/zig.png" alt=""> </span> </h2>
              <p class="main-menu-new__expand-text">Browse 200+ photo inspirations and start building your perfect product shoot today.</p>

              <div class="spacer-h-20"></div>

            </div><!-- clearfix -->
            <?php dynamic_sidebar('main_menu_grow'); ?>
          </div><!-- main-menu-new__dropdown-inner -->
        </div><!-- main-menu-new__dropdown -->
      </li>
       <?php endif ?>
    </ul>
  </div>

  <div class="spacer-h-20"></div>

  <?php echo $right_menu; ?>


  <div class="spacer-h-20"></div>

  <a href="http://localhost/feedsauce/recipes/" class="site-header__new-shoot">Get Started</a>

  <a href="javasctipt:void(0)" class="live-chat">
    <i class="chat-icon online" onclick="Intercom('show')">
      <svg class="icon svg-icon-chat"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-chat"></use> </svg>
      <i class="status"></i>
    </i>
    <span>Live Chat</span>
  </a>


  <div class="spacer-h-20"></div>

  <div class="separator"></div>

  <div class="spacer-h-20"></div>

  <?php dynamic_sidebar('dots_menu'); ?>

</nav>


<nav class="user-menu">
  <div class="user-menu__header">
    <svg class="user-menu__close" width="16" height="16" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:avocode="https://avocode.com/" viewBox="0 0 16 16"><defs></defs><desc>Generated with Avocode.</desc><g><g><title>Path</title><path d="M14.8152,3.01982l-4.64596,4.64593v0l4.64596,4.64572c0.69107,0.69125 0.69107,1.81098 0,2.50224c-0.34529,0.34525 -0.79798,0.51801 -1.25046,0.51801c-0.45323,0 -0.90597,-0.1725 -1.251,-0.51801l-4.64697,-4.64625v0l-4.64662,4.6462c-0.34524,0.34525 -0.79799,0.51801 -1.25086,0.51801c-0.45274,0 -0.90517,-0.17249 -1.25073,-0.51801c-0.69106,-0.69094 -0.69106,-1.81072 0,-2.50224l4.64583,-4.64571v0l-4.64609,-4.64589c-0.69107,-0.69099 -0.69107,-1.81099 0,-2.50198c0.69093,-0.69045 1.81039,-0.69045 2.50159,0l4.64684,4.64594v0l4.64649,-4.64594c0.69132,-0.69045 1.81092,-0.69045 2.50172,0c0.69133,0.69099 0.69133,1.81099 0.00026,2.50198z" fill="#8d95ad" fill-opacity="1"></path></g></g></svg>

    <img src="<?php echo THEME_URL?>/images/logo-mark.svg" alt="">
  </div>

  <div class="spacer-h-50"></div>

  <span class="user-menu__welcome">
    <span>Hi, <?php echo $username; ?>
    <img src="<?php echo THEME_URL?>/images/zig2.svg" alt="">
    </span>
  </span>

  <div class="spacer-h-30"></div>

  <div class="mobile-my-menu">

    <p class="mobile-my-menu__title">Brandhub</p>
    <div class="spacer-h-10"></div>
    <a href="<?php echo $url_shoots ?>" class="mobile-my-menu__link">
      <i class="mobile-my-menu__icon"><svg class="icon svg-icon-dots-2"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-dots-2"></use> </svg></i>
      <span>Shoots</span>
    </a>
    <a href="<?php echo $url_gallery ?>" class="mobile-my-menu__link">
     <i class="mobile-my-menu__icon"> <svg class="icon svg-icon-gallery"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-gallery"></use> </svg></i>
      <span>Gallery</span>
    </a>
    <div class="spacer-h-10"></div>
    <div class="my-menu__dropdown-divider"></div>
    <p class="mobile-my-menu__title">Account</p>
    <div class="spacer-h-10"></div>
    <a href="<?php echo $edit;?>" class="mobile-my-menu__link">
      <i class="mobile-my-menu__icon"><svg class="icon svg-icon-human"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-human"></use> </svg></i>
      <span>Edit Profile</span>
    </a>
    <a href="#" class="mobile-my-menu__link hidden">
      <i class="mobile-my-menu__icon"><svg class="icon svg-icon-billing"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-billing"></use> </svg></i>
      <span>Billing</span>
    </a>
    <a href="<?php echo $logout_url;?>" class="mobile-my-menu__link">
      <i class="mobile-my-menu__icon"><img src="<?php echo THEME_URL?>/images/icons/sign-out.png" alt=""></i>
      <span>Sign out</span>
    </a>
  </div>

</nav>
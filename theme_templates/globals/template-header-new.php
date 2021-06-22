<?php
  defined( 'ABSPATH' ) || exit;

  /**
  * Template to dipslay desktop header
  */
?>

<div class="header-spacer desktop"></div>
<header class="site-header underline fixed desktop logo-border">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-5 discard-position valign-center">
           <a href="<?php echo HOME_URL; ?>" class="logo">
             <img src="<?php echo $custom_logo_url; ?>" class="logo__img" alt="">
          </a>

          <nav class="main-menu-new">
            <ul class="menu">
              <?php if (is_active_sidebar('main_menu_create2')): ?>
              <li class="menu-item new dropdwon"><a href="#">Create</a><span class="new">New</span>
                <div class="main-menu-new__dropdown">
                  <div class="main-menu-new__dropdown-inner">
                    <div class="container">
                      <div class="row">
                        <div class="col-md-3">
                          <div class="clearfix">
                            <p class="main-menu-new__dropdown-category">
                              <svg class="icon svg-icon-flash"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-flash"></use> </svg>
                              photo ready in <span class="marked">72 hours</span>
                            </p>
                            <h2 class="main-menu-new__dropdown-moto">Find your style. <img src="<?php echo THEME_URL?>/images/zig.png" alt=""> </h2>
                            <p class="main-menu-new__dropdown-text">Browse 200+ photo inspirations and start building your perfect product shoot today.</p>

                            <?php if ($shop_url): ?>
                            <a href="<?php echo $shop_url; ?>" class="main-menu-new__dropdown-create">+ &nbsp;&nbsp;&nbsp;Create</a>
                            <?php endif ?>
                          </div><!-- clearfix -->
                        </div><!-- col-md-3 -->

                        <div class="col-md-9">
                          <div class="row">
                            <?php dynamic_sidebar('main_menu_create2'); ?>
                          </div><!-- row -->
                        </div><!-- col-md-9 -->
                      </div><!-- row -->
                    </div><!-- container -->
                  </div><!-- main-menu-new__dropdown-inner -->
                </div><!-- main-menu-new__dropdown -->
              </li>
               <?php endif ?>

              <?php if (is_active_sidebar('main_menu_publish')): ?>
              <li class="menu-item dropdwon"><a href="#">Publish</a>
                <div class="main-menu-new__dropdown">
                  <div class="main-menu-new__dropdown-inner">
                    <div class="container">
                      <div class="row">
                        <div class="col-md-3">
                          <div class="clearfix">
                            <p class="main-menu-new__dropdown-category">
                              <svg class="icon svg-icon-flash"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-flash"></use> </svg>
                              photo ready in <span class="marked">72 hours</span>
                            </p>
                            <h2 class="main-menu-new__dropdown-moto">Find your style. <img src="<?php echo THEME_URL?>/images/zig.png" alt=""> </h2>
                            <p class="main-menu-new__dropdown-text">Browse 200+ photo inspirations and start building your perfect product shoot today.</p>

                            <?php if ($shop_url): ?>
                            <a href="<?php echo $shop_url; ?>" class="main-menu-new__dropdown-create">+ &nbsp;&nbsp;&nbsp;Create</a>
                            <?php endif ?>
                          </div><!-- clearfix -->
                        </div><!-- col-md-3 -->

                        <div class="col-md-9">
                          <div class="row">
                            <?php dynamic_sidebar('main_menu_publish'); ?>
                          </div><!-- row -->
                        </div><!-- col-md-9 -->
                      </div><!-- row -->
                    </div><!-- container -->
                  </div><!-- main-menu-new__dropdown-inner -->
                </div><!-- main-menu-new__dropdown -->
              </li>
               <?php endif ?>

               <?php if (is_active_sidebar('main_menu_grow')): ?>
              <li class="menu-item dropdwon"><a href="#">Grow</a>
                <div class="main-menu-new__dropdown">
                  <div class="main-menu-new__dropdown-inner">
                    <div class="container">
                      <div class="row">
                        <div class="col-md-3">
                          <div class="clearfix">
                            <p class="main-menu-new__dropdown-category">
                              <svg class="icon svg-icon-flash"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-flash"></use> </svg>
                              photo ready in <span class="marked">72 hours</span>
                            </p>
                            <h2 class="main-menu-new__dropdown-moto">Find your style. <img src="<?php echo THEME_URL?>/images/zig.png" alt=""> </h2>
                            <p class="main-menu-new__dropdown-text">Browse 200+ photo inspirations and start building your perfect product shoot today.</p>

                            <?php if ($shop_url): ?>
                            <a href="<?php echo $shop_url; ?>" class="main-menu-new__dropdown-create">+ &nbsp;&nbsp;&nbsp;Create</a>
                            <?php endif ?>
                          </div><!-- clearfix -->
                        </div><!-- col-md-3 -->

                        <div class="col-md-9">
                          <div class="row">
                            <?php dynamic_sidebar('main_menu_grow'); ?>
                          </div><!-- row -->
                        </div><!-- col-md-9 -->
                      </div><!-- row -->
                    </div><!-- container -->
                  </div><!-- main-menu-new__dropdown-inner -->
                </div><!-- main-menu-new__dropdown -->
              </li>
              <?php endif ?>
            </ul>
          </nav>
        </div><!-- col-md-7 -->
        <div class="col-md-7 align-right valign-center">
          <?php echo $right_menu; ?>

          <div href="#" class="dots-link">

            <div class="my-menu__icon">
              <svg class="icon svg-icon-dots-in-row"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-dots-in-row"></use> </svg>
            </div>

            <div class="my-menu__dropdown">
              <div class="my-menu__dropdown-inner">
                <?php dynamic_sidebar('dots_menu'); ?>
              </div>
            </div>
          </div>

          <ul class="login-menu">
            <li>
              <?php if ($user_id > 0): ?>
              <div class="my-menu">
                <div class="my-menu__gravatar gravatar">
                  <img src="<?php echo $avatar_url; ?>" alt="">
                </div>
                <span class="my-menu__text">Me</span>

                <div class="my-menu__dropdown">
                  <div class="my-menu__dropdown-inner">
                    <p class="my-menu__dropdown-title">Brandhub</p>
                    <a href="<?php echo $url_shoots ?>" class="my-menu__dropdown-link">
                      <i class="my-menu__dropdown-icon"><svg class="icon svg-icon-dots-2"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-dots-2"></use> </svg></i>
                      <span>Shoots</span>
                    </a>
                    <a href="<?php echo $url_gallery ?>" class="my-menu__dropdown-link">
                     <i class="my-menu__dropdown-icon"> <svg class="icon svg-icon-gallery"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-gallery"></use> </svg></i>
                      <span>Gallery</span>
                    </a>
                    <div class="spacer-h-20"></div>
                    <div class="my-menu__dropdown-divider"></div>
                    <div class="spacer-h-20"></div>
                    <p class="my-menu__dropdown-title">Account</p>
                    <a href="#" class="my-menu__dropdown-link">
                      <i class="my-menu__dropdown-icon"><svg class="icon svg-icon-human"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-human"></use> </svg></i>
                      <span>Edit Profile</span>
                    </a>
                    <a href="#" class="my-menu__dropdown-link">
                      <i class="my-menu__dropdown-icon"><svg class="icon svg-icon-billing"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-billing"></use> </svg></i>
                      <span>Billing</span>
                    </a>
                    <a href="<?php echo $logout_url;?>" class="my-menu__dropdown-link">
                      <i class="my-menu__dropdown-icon"><img src="<?php echo THEME_URL?>/images/icons/sign-out.png" alt=""></i>
                      <span>Sign out</span>
                    </a>
                  </div>
                </div>
              </div>
              <?php else: ?>
              <a href="<?php echo $myaccount_page_url; ?>" >
                <svg class="icon svg-icon-login"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-login"></use> </svg>
               <span> Log In</span>
              </a>
              <?php endif ?>
            </li>
            <li class="online"><a href="javasctipt:void(0)">
              <i class="chat-icon online" onclick="Intercom('show')">
                <svg class="icon svg-icon-chat"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-chat"></use> </svg>
                <i class="status"></i>
              </i>
              <span>Live Chat</span>
            </a></li>
          </ul>

          <?php if ($shop_url): ?>
          <a href="<?php echo $shop_url; ?>" class="site-header__new-shoot">+ Create</a>
          <?php endif ?>
        </div><!-- col-md-5  -->
      </div><!-- row -->
    </div><!-- container-lg -->
</header>

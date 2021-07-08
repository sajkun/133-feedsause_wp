<header class="site-header desktop-header-style-1
<?php if (get_queried_object_id() == (int)get_option('theme_page_constructor') && !isset($_GET['no_reload']) && empty( is_wc_endpoint_url('order-received') ) ): ?>
  visuallyhidden
<?php endif ?>

<?php echo $header_class; ?>
" >
  <div class="container-fluid">
    <div class="row justify-content-between">
      <div class="col-6 col-md-4 col-lg-4 valign-center">
          <?php echo $logo ?>
        <?php if (is_checkout()): ?>
          <?php echo $main_menu; ?>
        <?php endif ?>
      </div><!-- col-md-7 -->

      <div class="col text-center order-1 order-md-0">
        <div class="spacer-h-15 spacer-h-md-0"></div>
        <?php if (!is_checkout()): ?>
          <?php echo $main_menu; ?>
        <?php endif ?>
      </div>

      <div class="col-6 col-md-4 col-lg-4 order-0 order-md-1 valign-center childs-right">
        <?php if (!is_checkout()): ?>
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
        <?php endif ?>
        <ul class="login-menu">
          <?php if ($account_url): ?>
          <li>
            <div class="my-menu">
            <?php if ($user_id > 0): ?>
              <div class="my-menu__gravatar gravatar">
                  <a href="<?php echo $account_url; ?>">
                    <img src="<?php echo $avatar_url; ?>" alt="">
                  </a>
              </div>
              <a href="<?php echo $account_url; ?>">
                <span class="my-menu__text">Me</span>
              </a>

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
                  <a href="<?php echo $edit;?>" class="my-menu__dropdown-link">
                    <i class="my-menu__dropdown-icon"><svg class="icon svg-icon-human"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-human"></use> </svg></i>
                    <span>Edit Profile</span>
                  </a>
                  <a href="#" class="my-menu__dropdown-link hidden">
                    <i class="my-menu__dropdown-icon"><svg class="icon svg-icon-billing"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-billing"></use> </svg></i>
                    <span>Billing</span>
                  </a>
                  <a href="<?php echo $logout_url;?>" class="my-menu__dropdown-link">
                    <i class="my-menu__dropdown-icon"><img src="<?php echo THEME_URL?>/images/icons/sign-out.png" alt=""></i>
                    <span>Sign out</span>
                  </a>
                </div>
              </div>
            <?php else: ?>
              <a href="<?php echo $account_url; ?>">
                <svg class="icon svg-icon-login"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-login"></use> </svg>
               <span> Log In</span>
              </a>
            <?php endif ?>
            </div>
          </li>
          <?php endif ?>

          <?php if (is_checkout()): ?>
          <li>
            <a href="<?php echo $shop_url; ?>" class="close-checkout"><svg class="icon svg-icon-close-bold"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-close-bold"></use> </svg><span>Close</span></a>
          </li>
          <?php endif ?>
          <?php if (!is_checkout()): ?>
          <li class="online"><a href="javascript:void(0)" onclick="Intercom('show')">
            <i class="chat-icon online">
              <svg class="icon svg-icon-chat"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-chat"></use> </svg>
              <i class="status"></i>
            </i>
            <span>Live Chat</span>
          </a></li>
          <?php endif ?>
        </ul>
      </div><!-- col-md-5  -->
    </div><!-- row -->
  </div><!-- container-lg -->
</header>
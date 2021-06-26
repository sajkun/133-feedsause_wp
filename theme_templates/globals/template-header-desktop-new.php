<header class="site-header
<?php if (get_queried_object_id() == (int)get_option('theme_page_constructor') && !isset($_GET['no_reload']) && empty( is_wc_endpoint_url('order-received') ) ): ?>
  visuallyhidden
<?php endif ?>

<?php echo $header_class; ?>
" >
  <div class="container-fluid">
    <div class="row justify-content-between">
      <div class="col-6 col-md-3 valign-center">
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

      <div class="col-6 col-md-3 order-0 order-md-1 text-right valign-center">
        <ul class="login-menu">

          <?php if (!is_checkout()): ?>
          <li>
            <svg class="icon svg-icon-dots-in-row"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-dots-in-row"></use> </svg>
          </li>
          <?php endif ?>
          <?php if ($account_url): ?>
          <li><a href="<?php echo $account_url; ?>">

            <?php if ($user_id > 0): ?>
              <div class="gravatar">
                <img src="<?php echo $avatar_url; ?>" alt="">
              </div>
              <span> Me <?php // echo $user_name; ?></span>
            <?php else: ?>
              <svg class="icon svg-icon-login"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-login"></use> </svg>
             <span> Log In</span>
            <?php endif ?>

          </a></li>
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
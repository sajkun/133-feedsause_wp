<header class="site-header
<?php if (get_queried_object_id() == (int)get_option('theme_page_constructor') && !isset($_GET['no_reload']) && empty( is_wc_endpoint_url('order-received') ) ): ?>
  visuallyhidden
<?php endif ?>
" >
  <div class="container-lg">
    <div class="row">
      <div class="col-md-9 valign-center">
          <?php echo $logo ?>
          <?php echo $main_menu; ?>
      </div><!-- col-md-7 -->

      <div class="col-md-3 text-right valign-center">
        <ul class="login-menu">
          <?php if ($account_url): ?>
          <li><a href="<?php echo $account_url; ?>">

            <?php if ($user_id > 0): ?>
              <div class="gravatar">
                <img src="<?php echo $avatar_url; ?>" alt="">
              </div>
              <span> Hi, <?php echo $user_name; ?></span>
            <?php else: ?>
              <svg class="icon svg-icon-login"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-login"></use> </svg>
             <span> Log In</span>
            <?php endif ?>

          </a></li>
          <?php endif ?>

          <li class="online"><a href="javascript:void(0)" onclick="Intercom('show')">
            <i class="chat-icon online">
              <svg class="icon svg-icon-chat"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-chat"></use> </svg>
              <i class="status"></i>
            </i>
            <span>Live Chat</span>
          </a></li>
        </ul>
      </div><!-- col-md-5  -->
    </div><!-- row -->
  </div><!-- container-lg -->
</header>
<?php
if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}
?>
<header class="site-header">
  <div class="container-lg">
    <div class="row">
      <div class="col-md-6 header-separator-margin">
        <div class="row row-h-80">
          <a href="<?php echo $home_url; ?>" class="logo beta">
            <img src="<?php echo THEME_URL ?>/order_tracker/assets/images/logo.png" alt="">
            <img src="<?php echo THEME_URL ?>/order_tracker/assets/images/beta.png" alt="">
          </a>
          <nav class="navigation">
            <?php if ($home_url): ?>
            <a href="<?php echo $home_url; ?>" class="navigation__item frontdesk-link">
              <svg class="icon svg-icon-frdk"> <use xmlns:xlink="ttp://www.w3.org/1999/xlink" xlink:href="#svg-icon-frdk"></use> </svg>
              <span>Frontdesk</span>
            </a>
            <?php endif ?>
            <?php if ($studio_url): ?>
            <a href="<?php echo $studio_url; ?>#studio" class="navigation__item studio-link">
              <svg class="icon svg-icon-frdk"> <use xmlns:xlink="ttp://www.w3.org/1999/xlink" xlink:href="#svg-icon-frdk"></use> </svg>
              <span>Studio</span>
            </a>
            <?php endif ?>
          </nav>
        </div>
      </div><!-- col-md-6 -->

      <div class="col-md-6">
        <div class="row row-h-80 justify-content-between">
          <div class="search">
            <form action="#" method="POST">
              <button>
                <svg class="icon svg-icon-search"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-search"></use> </svg>
              </button>
              <input type="text" placeholder="Search Hub...">
            </form>
          </div><!-- search -->
          <div class="clearfix valign-center">
            <div class="row no-gutters">
              <?php if (!$is_studio): ?>
              <a href="javascript:create_new_order()" class="new-user">
                <span>+</span> New
              </a>
              <?php endif ?>
              <div class="curent-user">
                <div class="curent-user__gravatar">
                  <?php if ($avatar_url): ?>
                    <img src="<?php echo $avatar_url; ?>" alt="">
                  <?php endif ?>
                </div>
                <span class="curent-user__name">Hi, <span><?php echo $name; ?></span></span>
              </div>
            </div><!-- row -->
          </div><!-- clearfix valign-center -->
        </div><!-- row -->
      </div><!-- col-md-6 -->
    </div><!-- row -->
  </div><!-- container-lg -->
</header>
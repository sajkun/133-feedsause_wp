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
            <img src="<?php echo THEME_URL ?>/order_tracker/assets/images/hub-logo.svg" alt="">
          </a>
          <nav class="navigation">
            <?php if ($home_url && $can_see_frontdesk): ?>
            <a href="<?php echo $home_url; ?>" class="navigation__item
              <?php echo $is_frontdesk? 'active': ''; ?> ">
              <svg class="icon svg-icon-frontdesk"> <use xmlns:xlink="ttp://www.w3.org/1999/xlink" xlink:href="#svg-icon-frontdesk"></use> </svg>
              <span>Frontdesk</span>
            </a>
            <?php endif ?>
            <?php if ($studio_url): ?>
            <a href="<?php echo $studio_url; ?>" class="navigation__item <?php echo $is_studio ? 'active': ''; ?> ">
              <svg class="icon svg-icon-frdk"> <use xmlns:xlink="ttp://www.w3.org/1999/xlink" xlink:href="#svg-icon-frdk"></use> </svg>
              <span>Studio</span>
            </a>
            <?php endif ?>
          </nav>
        </div>
      </div><!-- col-md-6 -->

      <div class="col-md-6">
        <div class="row row-h-80 justify-content-between">
          <div class="search col" id="search-field">
            <form action="#" method="POST" v-on:submit.prevent="exec_search">
              <div class="input-holder">

                <div class="inner">
                  <input type="text" placeholder="Search Hub..."
                   v-model="value"
                   autocomplete="off"
                   >
                  <i class="icon-clear" v-if="value" v-on:click="value=''">×</i>
                  <button>
                    <svg class="icon svg-icon-search"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-search"></use> </svg>
                  </button>
                </div>

                <div class="input-holder__dropdown visuallyhidden" ref="dropdown" v-show="users_found.length > 0">
                  <ul class="input-holder__list">
                    <li
                      v-for="(user , key) in users_found"
                      :key="key"
                      v-on:click="update_customer(user)"
                    >
                    {{user.name}} <span class="brand">{{user.brand}}</span></li>
                  </ul>
                </div>
              </div>
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

                <div class="input-holder__dropdown">
                   <ul class="input-holder__list">
                    <?php if ($is_frontdesk): ?>
                    <li><a target="_blank" href="<?php echo admin_url('edit.php?post_type=shop_order');?>">WooCommerce Orders</a></li>
                    <?php endif ?>

                    <li><a href="<?php echo admin_url('options-general.php?page=duh_tracker_settings');?>" target="_blank">Settings</a></li>
                    <li><a href="<?php echo wp_logout_url(HOME_URL); ?>">Logout</a></li>
                  </ul>
                </div>
              </div>
            </div><!-- row -->
          </div><!-- clearfix valign-center -->
        </div><!-- row -->
      </div><!-- col-md-6 -->
    </div><!-- row -->
  </div><!-- container-lg -->
</header>
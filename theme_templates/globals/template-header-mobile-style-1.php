<header class="site-header mobile-header-style-1
<?php echo $header_class; ?>
<?php if (get_queried_object_id() == (int)get_option('theme_page_constructor') && !isset($_GET['no_reload']) && empty( is_wc_endpoint_url('order-received') ) ): ?>
  visuallyhidden
<?php endif ?>
" >
<?php if (!$hide_menu): ?>

  <div class="menu-switcher visuallyhidden">
    <span></span>
  </div>
<?php endif ?>

  <?php echo $logo; ?>

  <?php if ($is_account_page): ?>
  <div class="gravatar my-menu__gravatar">
    <img src="<?php echo $avatar_url; ?>" alt="">
  </div>
  <?php else: ?>
  <i class="chat-icon online" onclick="Intercom('show')">
    <svg class="icon svg-icon-safe"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-safe"></use> </svg>
  </i>
  <?php endif ?>
</header>
<?php if (!$hide_menu): ?>
<nav class="mobile-menu">
  <div class="mobile-menu__container">
    <div class="mobile-menu__scroll">
      <?php echo $main_menu ?>
    </div>
  </div>
</nav>
<?php endif ?>
<div class="site-header-place"></div>
<?php
global $wp;
if(!isset($wp->query_vars[ 'gallery'])){
  $class = 'light';
}
?>
<nav class="user-menu <?php echo $class; ?>">
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
<header class="site-header
<?php echo $header_class; ?>
<?php if (get_queried_object_id() == (int)get_option('theme_page_constructor') && !isset($_GET['no_reload']) && empty( is_wc_endpoint_url('order-received') ) ): ?>
  visuallyhidden
<?php endif ?>
" >
<?php if (!$hide_menu): ?>

  <div class="menu-switcher">
    <span></span>
  </div>
<?php endif ?>

  <?php echo $logo; ?>

  <i class="chat-icon online" onclick="Intercom('show')">
    <svg class="icon svg-icon-safe"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-safe"></use> </svg>
  </i>
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
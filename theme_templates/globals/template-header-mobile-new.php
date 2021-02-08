<header class="site-header
<?php if (get_queried_object_id() == (int)get_option('theme_page_constructor') && !isset($_GET['no_reload'])): ?>
  visuallyhidden
<?php endif ?>
" >

  <div class="menu-switcher">
    <span></span>
  </div>

  <?php echo $logo; ?>

  <i class="chat-icon online" onclick="Intercom('show')">
    <svg class="icon svg-icon-safe"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-safe"></use> </svg>
  </i>
</header>
<nav class="mobile-menu">
  <div class="mobile-menu__container">
    <div class="mobile-menu__scroll">

      <?php echo $main_menu ?>
      <ul class="mobile-menu__list"><li class="menu-item starting-item"> <a href="https://feedsauce.com">Home</a> </li><li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-6625 shift"><a href="https://feedsauce.com/tour/" itemprop="url">Tour</a></li>

      <li class="menu-item menu-item-type-post_type menu-item-object-page current_page_parent menu-item-3328 shift"><a href="https://feedsauce.com/recipes/" itemprop="url">Recipes</a></li>
      <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3329 shift"><a href="https://feedsauce.com/pricing/" itemprop="url">Pricing</a></li>
      <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3327 shift"><a href="https://feedsauce.com/support/" itemprop="url">Support</a></li>
      <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-9796 shift"><a href="https://feedsauce.com/resources/" itemprop="url">Resources</a></li>

      <li class="menu-item last-item"> <a href="https://feedsauce.com/dashboard/">Log In</a> </li></ul>
    </div>
  </div>
</nav>
<div class="site-header-place"></div>
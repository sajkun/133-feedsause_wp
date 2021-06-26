<?php
defined( 'ABSPATH' ) || exit;
/**
* Template mobile categories
*/
?>
<div class="mobile-shop-search">
  <div class="row no-gutters justify-content-between">
    <div class="side-search">
      <form action="javascript:void(0)" method="POST">
        <button type="submit" class="side-search__submit">
          <svg class="icon svg-icon-search"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-search"></use> </svg>
        </button>
        <input type="search" class="side-search__input" placeholder="Try “Beauty”">
      <span class="side-search__progress">
        <img src="<?php echo THEME_URL;?>/images/svg/oval-progress.png" alt="">
      </span>
      </form>
    </div><!-- side-search -->

    <div class="category-trigger">
      <svg class="icon svg-icon-switcher"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-switcher"></use> </svg>

      <span class="close">×</span>
    </div>
  </div><!-- row -->
 <div class="spacer-h-20 spacer-h-lg-0"></div>
</div><!-- mobile-shop-search -->

<div class="mobile-categories">
  <?php if (is_active_sidebar('shop_sidebar')): ?>
    <?php dynamic_sidebar('shop_sidebar'); ?>
  <?php endif ?>
</div>
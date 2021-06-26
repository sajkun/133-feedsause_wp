<?php
defined( 'ABSPATH' ) || exit;
/**
* Template for search block and category column on a shop page and category page
*/
?>

<div class="shop-side-column">
  <div class="col-12">
    <div class="row no-gutters justify-content-between search-container">
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
    </div><!-- row -->
    <div class="spacer-h-20 spacer-h-lg-45"></div>
    <?php if (is_active_sidebar('shop_sidebar')): ?>
      <?php dynamic_sidebar('shop_sidebar'); ?>
    <?php endif ?>
  </div><!-- col-12 -->
</div><!-- side-column -->
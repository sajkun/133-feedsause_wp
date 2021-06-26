<?php
defined( 'ABSPATH' ) || exit;
/**
* Template of a product preview. Wide version
*/
?>

<div class="shop-content__row" id="all_products_block">
  <div class="row">
    <div class="col-6">
      <h2 class="shop-content__title">
        <span class="icon"><?php echo $icon; ?></span>
        <span class="text"><?php echo $title; ?></span>
      </h2>
    </div>
    <div class="col-6 text-right">
      <span class="shop-content__row-prev visuallyhidden"><svg class="icon svg-icon-next-2"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-next-bracket"></use> </svg></span>

      <span class="shop-content__row-next visuallyhidden"><svg class="icon svg-icon-prev-2"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-next-bracket"></use> </svg></span>
    </div>
  </div><!-- row -->
  <div class="spacer-h-20"></div>

  <div class="shop-content__row-inner">
    <?php foreach ($products as $key => $product):
      $args = array(
        'product'=> $product,
      );
      ?>
       <?php echo print_theme_template_part('product-preview-regular', 'woocommerce/product', $args);?>
    <?php endforeach ?>
    <div class="flex-spacer"></div>
  </div><!-- row -->

</div><!-- shop-content__row -->

<div class="spacer-h-40"></div>

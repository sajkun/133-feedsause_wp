<?php
defined( 'ABSPATH' ) || exit;
/**
* Template of a product preview. Wide version
*/
?>

<?php foreach ($shop_categories as $key => $id):
  $category = $categories[$id];
  $thumbnail_id = (int)get_term_meta($category->term_id, 'thumbnail_id', true );
  $icon =  wp_get_attachment_image_url($thumbnail_id, 'full');
?>
<div class="shop-content__row">
  <div class="row">
    <div class="col-6">
      <h2 class="shop-content__title">
        <span class="icon"><img data-src="<?php echo $icon; ?>" class="lazy-load" alt=""></span>
        <span class="text"><?php echo $category->name; ?></span>
      </h2>
    </div>
    <div class="col-6 text-right">
      <span class="shop-content__row-prev visuallyhidden"><svg class="icon svg-icon-next-2"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-next-bracket"></use> </svg></span>

      <span class="shop-content__row-next visuallyhidden"><svg class="icon svg-icon-prev-2"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-next-bracket"></use> </svg></span>
    </div>
  </div><!-- row -->
  <div class="spacer-h-20"></div>

  <div class="shop-content__row-inner <?php if (count($products[$category->slug] ) >=2): ?> owl-carousel <?php endif ?>">
    <?php foreach ($products[$category->slug] as $key => $product):
      $args = array(
        'product'=> $product,
      );
      ?>
       <?php echo print_theme_template_part('product-preview-regular', 'woocommerce/product', $args);?>
    <?php endforeach ?>
    <?php if (count($products[$category->slug] ) < 2): ?>
    <div class="flex"></div>
    <?php endif ?>
  </div><!-- row -->
</div><!-- shop-content__row -->

<div class="spacer-h-40"></div>
<?php endforeach ?>
<?php
defined( 'ABSPATH' ) || exit;
/**
* Template of a first category on shop page
*/

$thumbnail_id = (int)get_term_meta($category->term_id, 'thumbnail_id', true );
$icon =  wp_get_attachment_image_url($thumbnail_id, 'full');

$id = random_int(1, count($products)) - 1;

$args = array(
  'product' => $products[$id],
);
?>

<div class="shop-content__row">
  <h2 class="shop-content__title">
    <?php if ($icon): ?>
    <span class="icon"><img class="lazy-load" data-src="<?php echo $icon; ?>" alt="<?php echo $category->name; ?>"></span>
    <?php endif ?>
    <span class="text"><?php echo $category->name; ?></span>
  </h2>
  <div class="spacer-h-15"></div>

  <?php echo  print_theme_template_part('product-preview-wide', 'woocommerce/product', $args);?>

</div><!-- shop-content__row -->

<div class="spacer-h-30"></div>
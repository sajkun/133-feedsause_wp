<?php
defined( 'ABSPATH' ) || exit;
/**
* Template of a product preview. Wide version
*/

$product_id        = $product->get_id();
$description_short = strip_tags($product->get_short_description());
$video_url = get_field('video_url', $product_id);

/** get gallery urls*/
$gallery = array();
$gallery_ids = $product->get_gallery_image_ids();

foreach ($gallery_ids as $id) {
  $size = 'gallery_3';
  $gallery[] = wp_get_attachment_image_url($id, $size);
}

?>
<div class="shop-product-item wide">
  <div class="shop-product-item__content">
    <div class="shop-product-item__new">
      <span class="shop-product-item__tag">NEW</span>
      <span class="text">Download your photos in <span class="marked">24 hours</span></span>
    </div><!-- shop-product-item__new -->

    <div class="spacer-h-40"></div>

    <h3 class="shop-product-item__title lg"> <a href="<?php echo get_permalink($product->get_id());?>"><?php echo $product->get_title(); ?></a></h3>
    <?php if ($description_short): ?>
      <p class="shop-product-item__text lg"><?php echo $description_short; ?></p>
    <?php endif ?>

    <div class="spacer-h-25"></div>

    <a href="<?php echo get_permalink($product->get_id());?>" class="shop-product-item__link">Create</a>

    <a href="javascript:void(0)" class="shop-product-item__video borders <?php if (!$video_url): ?> not-active <?php endif ?>"
    <?php if ($video_url): ?>
      onclick='play_video("<?php echo $video_url; ?>", event)'
    <?php endif ?>
    ><svg class="icon svg-icon-play"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-play"></use> </svg>Preview</a>
  </div><!-- shop-product-item__content -->

  <div class="shop-product-item__image">
    <?php if (count($gallery) > 2): ?>
    <div class="shop-product-item__gallery-trigger">
      <svg class="icon svg-icon-gallery"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-gallery"></use> </svg>
      <span class="count"><?php echo count($gallery) - 2; ?>+</span>
    </div>
    <?php endif ?>

    <div class="shop-product-item__image-1">
      <?php if ($gallery[1]): ?>
        <img class="lazy-load fix-height" data-src="<?php echo $gallery[1]?>" alt="<?php echo $product->get_title(); ?>">
      <?php endif ?>
    </div>
    <div class="shop-product-item__image-2">
      <?php if ($gallery[2]): ?>
      <img class="lazy-load fix-height" data-src="<?php echo $gallery[2]?>" alt="<?php echo $product->get_title(); ?>">
      <?php endif ?>
    </div>
  </div><!-- shop-product-item__image -->
</div><!-- shop-product-item -->
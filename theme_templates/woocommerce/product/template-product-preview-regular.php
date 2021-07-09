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

/* get terms */
$_ids = $product->get_category_ids();
$terms = array();

foreach ($_ids as $key => $_term_id) {
  $term = get_term($_term_id, 'product_cat');
  $thumbnail_id = (int)get_term_meta($_term_id, 'thumbnail_id', true );
  $term->icon =  wp_get_attachment_image_url($thumbnail_id, 'full');
  $terms[] = $term;
}

if (get_field('key_words',$product_id)) {
  $key_words = get_field('key_words',$product_id);
}else{
  $key_words = '';
}
?>

<div class="shop-product-item" data-keywords="<?php echo $key_words; ?>">
  <div class="shop-product-item__image">
    <div class="shop-product-item__image-1">
      <?php if (isset($gallery[1]) && $gallery[1]): ?>
        <img class="lazy-load fix-height" data-src="<?php echo $gallery[1]?>" alt="<?php echo $product->get_title(); ?>">
      <?php endif ?>
    </div>
    <div class="shop-product-item__image-2">
      <?php if (isset($gallery[2]) && $gallery[2]): ?>
      <img class="lazy-load fix-height" data-src="<?php echo $gallery[2]?>" alt="<?php echo $product->get_title(); ?>">
      <?php endif ?>
    </div>
    <?php if (count($gallery) > 2): ?>
    <div class="shop-product-item__gallery-trigger">
      <svg class="icon svg-icon-gallery"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-gallery"></use> </svg>
      <span class="count"><?php echo count($gallery) - 2; ?>+</span>
    </div>
    <?php endif ?>
  </div><!-- shop-product-item__image -->

  <div class="shop-product-item__content">
    <div class="spacer-h-15"></div>


    <div class="product-data__tag-holder">
      <?php foreach ($terms as $t): ?>
        <a href="<?php get_term_link($t);?>" class="product-data__tag">
          <span class="icon"><img data-src="<?php echo $t->icon ?>" class="lazy-load" alt=""></span>
          <span class="text"><?php echo $t->name ?></span>
        </a>
      <?php endforeach ?>
    </div>

    <div class="spacer-h-15"></div>

    <h3 class="shop-product-item__title"> <a href="<?php echo get_permalink($product->get_id());?>"><?php echo $product->get_title(); ?></a></h3>
    <?php if ($description_short): ?>
      <p class="shop-product-item__text"><?php echo $description_short; ?></p>
    <?php endif ?>

    <div class="spacer-h-25"></div>

    <div class="shop-product-item__buttons">
      <a href="<?php echo get_permalink($product->get_id());?>" class="shop-product-item__link">Create</a>

      <a href="javascript:void(0)" class="shop-product-item__video <?php if (!$video_url): ?> not-active <?php endif ?>"
      <?php if ($video_url): ?>
        onclick='play_video("<?php echo $video_url; ?>", event)'
      <?php endif ?>
      ><svg class="icon svg-icon-play"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-play"></use> </svg>Preview</a>
    </div><!-- shop-product-item__buttons -->
  </div><!-- shop-product-item__content -->
</div><!-- shop-product-item -->
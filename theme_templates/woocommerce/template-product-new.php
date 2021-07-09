<div class="spacer-h-0 spacer-h-md-40"></div>
<div class="container-md">
  <div class="pagination">
    <ul class="pagination__list">
      <li><a href="<?php echo HOME_URL; ?>">Home</a></li>
      <li><a href="<?php echo $shop_url; ?>">Recipes</a></li>
      <?php foreach ($term_tree as $key => $term): ?>
      <li>
        <?php echo ($key + 1 == count($term_tree))? sprintf('<span>%s</span>', $term->name) : sprintf('<a href="%s">%s</a>',get_term_link($term), $term->name); ?>
      </li>
      <?php endforeach ?>
    </ul>
    <div class="spacer-h-35"></div>
  </div><!-- pagination -->
</div><!-- container-md -->


<div class="container-md no-padding relative">
  <div class="carousel-product scroll-container">
    <div class="carousel-product__inner">
      <div class="carousel-product__image-holder squre"><img class="lazy-load" data-src="<?php echo $gallery[0]?>" alt=""></div>
      <div class="carousel-product__image-holder thin"><img class="lazy-load" data-src="<?php echo $gallery[1]?>" alt=""></div>
      <div class="carousel-product__image-wrapper">
        <div class="carousel-product__image-holder"><img class="lazy-load" data-src="<?php echo $gallery[2]?>" alt=""></div>
        <div class="carousel-product__image-holder"><img class="lazy-load" data-src="<?php echo $gallery[3]?>" alt=""></div>
      </div>
      <div class="carousel-product__image-holder medium"><img class="lazy-load" data-src="<?php echo $gallery[4]?>" alt=""></div>
    </div><!-- carousel-product__inner -->

  </div><!-- carousel-product -->
  <?php
   $count = count($gallery);
   $count = Max($count, 0);
  ?>

  <?php if ($count > 0): ?>
  <div class="carousel-product__gallery-trigger">
    <svg class="icon svg-icon-gallery"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-gallery"></use> </svg>
    <span class="count"><?php echo $count ?>+</span>
  </div><!-- carousel-product__gallery-trigger -->
  <?php endif ?>
</div><!-- container-md  -->

<div class="container-md">
<div class="spacer-h-25"></div>

<div class="product-data">
  <div class="product-data__information">
    <div class="clearfix">
      <?php foreach ($terms as $key => $t): ?>
      <span class="product-data__tag">
        <span class="icon"><img src="<?php echo $t->icon; ?>" alt=""></span>
        <span class="text"><?php echo $t->name; ?></span>
      </span>
      <?php endforeach ?>
    </div><!-- clearfix -->

    <div class="spacer-h-20"></div>

    <h2 class="product-data__title"><?php echo $product->get_title();?></h2>

    <div class="spacer-h-20 spacer-h-lg-35"></div>

    <p class="product-data__description">
      <?php echo $product->get_description();?>
    </p>

    <div class="spacer-h-20"></div>

    <?php if ($what_to_expect): ?>

    <div class="hr-line"></div>
    <div class="spacer-h-20"></div>

    <h3 class="product-data__subtitle has-icon">
      <svg class="icon svg-icon-levels"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-levels"></use> </svg>
      <span>
        What you can expect
      </span>
    </h3>
    <div class="spacer-h-10"></div>

    <p class="product-data__small-text ">
      <span>Elements commonly used in photos shot using Hero. You can customise these using</span>

      <span class="constructor-tag">
        <svg class="icon svg-icon-notes"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-notes"></use> </svg>
        Studio Notes
      </span>
    </p>
    <div class="spacer-h-20"></div>

    <div class="expect-item-holder scroll-container">
      <div class="row no-gutters">

        <?php foreach ($what_to_expect as $key => $item): ?>
        <div class="col-4">
          <div class="expect-item">
            <img data-src="<?php echo $item['image'];?>"  class="lazy-load" alt="">
            <span class="expect-item__title"><?php echo $item['title'];?></span>
          </div>
        </div>
        <?php endforeach ?>
      </div>
    </div>
    <?php endif ?>
  </div><!-- product-data__information -->

  <div class="product-data__adv">
    <div class="product-data__tabs">
      <ul class="product-data__tabs-list">
        <li class="active" data-target="#data-build"><span>Build Shoot</span></li>
        <li data-target="#faq"><span>FAQs</span></li>
      </ul>

      <div class="to-right">
        <div class="currency-switcher sm">
          <div class="currency-switcher__value">
            <img src="<?php echo THEME_URL;?>/images/svg/gb.svg" alt="">
            GBP
          </div>

          <div class="currency-switcher__dropdown">
            <ul>
              <li data-currency="gbp"  class="active"> <img src="<?php echo THEME_URL;?>/images/svg/gb.svg" alt=""> GBP</li>
              <li data-currency="usd"> <img src="<?php echo THEME_URL;?>/images/svg/us.svg" alt="usd"> USD</li>
              <li data-currency="eur"> <img src="<?php echo THEME_URL;?>/images/svg/eu.svg" alt=""> EUR</li>
            </ul>
          </div>
        </div><!-- currency-switcher -->
      </div><!-- to-right -->
    </div><!-- product-data__tabs -->

    <div class="spacer-h-30"></div>

    <div class="product-data__page" id="data-build">

      <div class="product-data__adv-cont">
        <div class="text-center">
          <span class="price-info__value" id="price-value">
           £<?php echo $theme_settings['single_product_price'] ?>
          </span>
          <span class="price-info__comment">
            /photo
          </span>
        </div>

        <div class="spacer-h-15"> </div>

        <div class="text-center">
        <p class="product-data__small-text text-center"> <img src="<?php echo THEME_URL;?>/images/strust-star-green.jpg" alt=""> 4.6 Excellent</p>
        </div>

        <div class="spacer-h-30"></div>

        <div class="property sm">
          <i class="property__icon">
            <img src="<?php echo THEME_URL; ?>/images/svg/color-wheel.svg" alt="">
          </i>
          <h3 class="property__title">50+ Customisations</h3>
          <p class="property__text">Brand match with unique colours & textures</p>
        </div>
        <div class="property sm">
          <i class="property__icon"> <img src="<?php echo THEME_URL; ?>/images/svg/glasses.svg" alt=""></i>
          <h3 class="property__title">Props</h3>
          <p class="property__text">Use our studio props or send your own</p>
        </div>
        <div class="property sm">
          <i class="property__icon"><img src="<?php echo THEME_URL; ?>/images/svg/stud.svg" alt=""></i>
          <h3 class="property__title">Studio Notes</h3>
          <p class="property__text">Send custom requests to the studio</p>
        </div>
        <div class="property sm">
          <i class="property__icon"><img src="<?php echo THEME_URL; ?>/images/svg/flash.svg" alt=""></i>
          <h3 class="property__title">Fasttrack</h3>
          <p class="property__text">Have your photos ready in 72 hours</p>
        </div>
      </div>

      <div class="spacer-h-20"></div>

      <div class="product-data__adv-separator text-center">
        <img src="<?php echo THEME_URL; ?>/images/paint-brush.png" alt="">
      </div>

      <div class="spacer-h-20"></div>

      <div class="text-center">
        <p class="product-data__adv-text"><b>Customise Hero to match your brand.</b> <br> Order now & we’ll collect your product <span class="marked">Tomorrow</span></p>
      </div>


      <div class="spacer-h-20"></div>

      <div class="product-data__adv-cont">
        <a href="<?php echo $constructor_url; ?>" class="product-data__adv-button">Create</a>
        <div class="spacer-h-20"></div>

        <a href="#" class="contact-link">
          <i class="chat-icon online" onclick="Intercom('show')">
          <svg class="icon svg-icon-chat"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-chat"></use> </svg>
          <i class="status"></i>
        </i>
        <span>Got a Question? Live chat with an expert</span></a>
      </div>

      <div class="spacer-h-30"></div>
    </div><!-- product-data__page -->

    <div class="product-data__page" <?php echo 'style="display:none;"'?> id="faq">
      <div class="product-data__page-inner">
      <?php foreach ($faq as $key => $f):
        $q = get_post_meta($f->ID, '_question', true);
        $a = get_post_meta($f->ID, '_answer', true);
        ?>

        <div class="faq-item">
          <h3 class="faq-item__title">
            <?php echo $q ?>
            <div class="faq-item__switcher"></div>
          </h3>

          <p class="faq-item__text">
            <?php echo $a ?>
          </p>
        </div>

      <?php endforeach ?>
      </div>
    </div>
  </div><!-- product-data__adv -->
</div><!-- product-data -->

<div class="spacer-h-30"></div>


<?php if (get_field('show_video_section', $product_id)): ?>

<div class="product-more-information">
  <div class="row">
    <div class="col-12 col-lg-6 text-center text-left-lg">
    <div class="spacer-h-50"></div>
      <span class="product-more-information__tag">New</span>
      <span class="product-more-information__tag-text"><?php echo get_field('video_comment', $product_id); ?></span>

      <div class="spacer-h-30"></div>

      <h3 class="product-more-information__title">
        <span><?php echo get_field('video_title', $product_id); ?></span>
      </h3>

      <div class="spacer-h-15"></div>


      <p class="product-more-information__text"><span><?php echo get_field('video_text', $product_id); ?></span></p>

       <div class="spacer-h-10"></div>

      <a href="<?php echo get_field('video_url', $product_id); ?>" onclick='play_video("<?php echo get_field('video_url', $product_id); ?>", event)' class="product-more-information__button js-show-video">
        <svg class="icon svg-icon-play"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-play"></use> </svg>
        Watch Video
      </a>
      <div class="spacer-h-50"></div>
    </div>

    <div class="col-12 col-lg-6">
      <img class="lazy-load product-more-information__image" data-src="<?php echo get_field('video_image', $product_id); ?>" alt="" >
    </div>
  </div>
</div>

<?php endif ?>
<div class="spacer-h-35"></div>



<div class="product-video row no-gutters">
  <div class="col-12 col-lg-4">
    <div class="product-video__item">
      <div class="product-video__item-video">
        <div class="product-video__item-progress"></div>
      </div><!-- product-video__item-video -->

      <div class="product-video__item-data">
        <span class="product-video__counter first">
          1
        </span>
        <h4 class="product-video__title"><span>Customise your recipe</span></h4>
        <p class="product-video__text">Varied sizes of blocks, using the accent colours in your product as the foundation for this recipe.</p>
      </div>
    </div><!-- product-video__item -->
  </div>

  <div class="col-12 col-lg-4">
    <div class="product-video__item">
      <div class="product-video__item-video">
        <div class="product-video__item-progress"></div>
      </div><!-- product-video__item-video -->

      <div class="product-video__item-data">
        <span class="product-video__counter second">
          2
        </span>
        <h4 class="product-video__title"><span>We’ll pick up your product</span></h4>
        <p class="product-video__text">Varied sizes of blocks, using the accent colours in your product as the foundation for this recipe.</p>
      </div>
    </div><!-- product-video__item -->
  </div>

  <div class="col-12 col-lg-4">
    <div class="product-video__item last">
      <div class="product-video__item-video">
        <div class="product-video__item-progress"></div>
      </div><!-- product-video__item-video -->

      <div class="product-video__item-data">
        <span class="product-video__counter third">
          3
        </span>
        <h4 class="product-video__title"><span>Download your photos</span></h4>
        <p class="product-video__text">Varied sizes of blocks, using the accent colours in your product as the foundation for this recipe.</p>
      </div>
    </div><!-- product-video__item -->
  </div>
</div><!-- product-video -->

</div><!-- container -->
<div class="spacer-h-20"></div>

<?php if ($customer_reviews): ?>

<h2 class="product-section-title text-center">

<div class="inner">
  <img src="<?php echo THEME_URL; ?>/images/svg/crown.svg" alt="" class="crown">
  <img src="<?php echo THEME_URL; ?>/images/svg/marker_1.svg" alt="" class="marker_1">
  <img src="<?php echo THEME_URL; ?>/images/svg/marker_2.svg" alt="" class="marker_2">
  <img src="<?php echo THEME_URL; ?>/images/svg/shtrich.svg" alt="" class="shtrich">
  <span>Our customers have <br> rated us <span class="marked">Excellent</span></span>
  <img src="<?php echo THEME_URL; ?>/images/svg/marker_3.svg" alt="" class="marker_3">
</div>
</h2>

<div class="spacer-h-30"></div>

<div class="product-testi-holder owl-carousel">

<?php foreach ($customer_reviews as $key => $r):

  $rating = get_field( 'rating',$r->ID);
  $rating_text = get_field( 'rating_text',$r->ID);
  $title = get_field( 'title',$r->ID);
  $text = get_field( 'text',$r->ID);
  $author = get_field( 'author',$r->ID);
  ?>
<div class="product-testi-holder__item">
  <div class="product-testi-holder__item-header">
    <div class="stars">
      <?php for ($i=0; $i < ceil((float)$rating); $i++) {?>
        <img src="<?php echo THEME_URL; ?>/images/strust-star-green.jpg" alt="">
      <?php } ?>
    </div>

    <span class="stars-text">
      <?php echo $rating ?> <span class="text"><?php echo $rating_text ?></span>
    </span>

    <img src="<?php echo THEME_URL;?>/images/trust_logo.png" class="trust-logo" alt="">
  </div>

  <h3 class="product-testi-holder__item-title"><?php echo $title; ?></h3>

  <p class="product-testi-holder__item-text"><?php echo $text; ?></p>
  <p class="product-testi-holder__item-author">— <?php echo $author; ?></p>
</div>
<?php endforeach ?>
</div>

<div class="spacer-h-80"></div>
<?php endif ?>


<?php if ($bottom_image['show']): ?>

<div class="large-decoration lazy-bg" data-src="<?php echo $bottom_image['regular']; ?>" data-retina="<?php echo $bottom_image['retina']; ?>/images/bg/large-deco-retina.jpg" >

<span class="large-decoration__tag">
  <img src="<?php echo THEME_URL; ?>/images/svg/color-wheel.svg" alt="">
  <span class="count">50+</span>
  <span class="text">Unique colour themes & textures</span>
</span>

<div class="spacer-h-20"></div>

<h3 class="large-decoration__title"><span>Build your shoot in
        minutes, transform your
        brand instantly.</span></h3>

<div class="spacer-h-20"></div>

<a href="<?php echo $constructor_url; ?>" class="large-decoration__new-shoot">Get Started</a>

<a href="javascript:void(0)" class="large-decoration__chat">
  <i class="chat-icon online" onclick="Intercom('show')">
    <svg class="icon svg-icon-chat"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-chat"></use> </svg>
    <i class="status"></i>
  </i>
  <span>Live Chat</span>
</a>
</div>
<?php endif ?>


<div class="product-image-popup">
  <div class="container-lg">
    <div class="spacer-h-85 spacer-h-xl2-45 "></div>

    <div class="row mobile-hidden-flex">
      <div class="col-6">
        <div class="product-image-popup__back">
          <svg class="icon svg-icon-bracket"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-bracket"></use> </svg>
        </div>
      </div>
      <div class="col-6 text-right">
        <a href="<?php echo $constructor_url; ?>" class="product-image-popup__build">
          Build Shoot <svg class="icon svg-icon-bracket"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-bracket"></use> </svg>
        </a>
      </div>
    </div>

    <span class="product-image-popup__mobile-close">
      <svg class="icon svg-icon-close"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-close"></use> </svg>
      Close
    </span>

    <div class="spacer-h-40 mobile-hidden"></div>


    <?php
     $length = ceil(count($gallery)/7);
     // clog($length);
     // clog(count($gallery));
     for ($i = 0; $i <$length ; $i++) { ?>

    <div class="product-image-popup__holder">
      <?php if (isset($gallery[$i*7])): ?>
      <div class="product-image-popup__item item-1"><img class="lazy-load-2" data-src="<?php echo $gallery[($i*7)]?>" alt=""></div>
      <?php endif ?>
      <?php if (isset($gallery[($i*7)+1])): ?>
      <div class="product-image-popup__item item-2"><img class="lazy-load-2" data-src="<?php echo $gallery[($i*7)+1]?>" alt=""></div>
      <?php endif ?>
      <?php if (isset($gallery[($i*7)+2])): ?>
      <div class="product-image-popup__item item-3"><img class="lazy-load-2" data-src="<?php echo $gallery[($i*7)+2]?>" alt=""></div>
      <?php endif ?>
      <?php if (isset($gallery[($i*7)+3])): ?>
      <div class="product-image-popup__item item-4"><img class="lazy-load-2" data-src="<?php echo $gallery[($i*7)+3]?>" alt=""></div>
      <?php endif ?>

      <?php if ( isset($gallery[($i*7)+4]) && isset($gallery[($i*7)+5]) ): ?>
      <div class="product-image-popup__sub-holder">
        <?php if (isset($gallery[($i*7)+4])): ?>
          <div class="product-image-popup__item item-5"><img class="lazy-load-2" data-src="<?php echo $gallery[($i*7)+4]?>" alt=""></div>
        <?php endif ?>
        <?php if (isset($gallery[($i*7)+5])): ?>
        <div class="product-image-popup__item item-5"><img class="lazy-load-2" data-src="<?php echo $gallery[($i*7)+5]?>" alt=""></div>
        <?php endif ?>
      </div>
      <?php endif ?>

      <?php if (isset($gallery[($i*7)+6])): ?>
      <div class="product-image-popup__item item-6"><img class="lazy-load-2" data-src="<?php echo $gallery[($i*7)+6]?>" alt=""></div>
        <?php endif ?>
    </div><!-- product-image-popup__holder -->
  <?php } ?>
    <div class="spacer-h-100"></div>
  </div><!-- container -->
</div><!-- product-image-popup -->

<div class="product-mobile-bar">
  <div class="product-mobile-bar__inner">
    <div class="product-mobile-bar__trigger">
      <div class="inner"></div>
    </div>

    <div class="product-mobile-bar__header">
      <div class="row no-gutters">
        <div class="col-8">
          <div class="text-left">
            <span class="product-mobile-bar__price-value" id="price-value4">£30</span>
            <span class="product-mobile-bar__price-comment">
              /photo
            </span>
          </div>
          <span class="product-mobile-bar__product-ready">
             <svg class="icon svg-icon-flash"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-flash"></use> </svg>
            Ready in <span class="marked">24 hours</span></span>
        </div>
        <div class="col-4">
          <a href="<?php echo $constructor_url; ?>" class="product-data__adv-button">Create</a>
        </div>
      </div>
      <div class="spacer-h-20"></div>
    </div><!-- product-mobile-bar__header -->

    <div class="product-mobile-bar__content">

      <div class="product-data__tabs">
        <ul class="product-data__tabs-list">
          <li class="active" data-target="#data-build2"><span>Build Shoot</span></li>
          <li data-target="#faq2"><span>FAQs</span></li>
        </ul>

        <div class="to-right">
          <div class="currency-switcher sm">
            <div class="currency-switcher__value">
              <img src="<?php echo THEME_URL;?>/images/svg/us.svg" alt="">
              USD
            </div>

            <div class="currency-switcher__dropdown">
              <ul>
                <li data-currency="gpb"> <img src="<?php echo THEME_URL;?>/images/svg/gb.svg" alt=""> GPB</li>
                <li data-currency="usd" class="active"> <img src="<?php echo THEME_URL;?>/images/svg/us.svg" alt="usd"> USD</li>
                <li data-currency="eur"> <img src="<?php echo THEME_URL;?>/images/svg/eu.svg" alt=""> EUR</li>
              </ul>
            </div>
          </div><!-- currency-switcher -->
        </div><!-- to-right -->
      </div><!-- product-data__tabs -->

      <div class="spacer-h-20"></div>

      <div class="product-data__page" id="data-build2">

        <div class="product-data__adv-cont">
          <div class="text-center">
            <span class="price-info__value" id="price-value3">
              $49
            </span>
            <span class="price-info__comment">
              /photo
            </span>
          </div>

          <div class="text-center">
          <p class="product-data__small-text text-center"> <img src="<?php echo THEME_URL;?>/images/strust-star-green.jpg" alt=""> 4.6 Excellent</p>
          </div>

          <div class="spacer-h-20"></div>

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

        <div class="spacer-h-10"></div>

        <div class="product-data__adv-separator text-center">
          <img src="<?php echo THEME_URL; ?>/images/paint-brush.png" alt="">
        </div>

        <div class="spacer-h-10"></div>

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
          Got a Question? Live chat with an expert</a>
        </div>

        <div class="spacer-h-30"></div>
      </div><!-- product-data__page -->

      <div class="product-data__page" <?php echo 'style="display:none;"'?> id="faq2">
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
    </div><!-- product-mobile-bar__content -->
  </div><!-- product-mobile-bar__inner -->
</div><!-- product-mobile-bar -->

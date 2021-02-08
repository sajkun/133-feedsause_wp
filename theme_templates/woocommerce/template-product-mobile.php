<div class="single-product">
  <div class="single-product__welcome" <?php echo 'style="background-color: '.$bg_color.' ;"'; ?>>
    <div class="text-center">
      <div class="fasttrack contrast">
        <svg class="icon svg-icon-flash"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-flash"></use> </svg>
        next day
      </div><!-- fasttrack -->

      <span class="free-product">Free Product Pick-Up</span>

      <div class="spacer-h-20"></div>

      <h1 class="single-product__title"><?php echo $title; ?></h1>
      <div class="spacer-h-20"></div>
      <p class="single-product__text"><?php echo $description_short; ?></p>
      <div class="spacer-h-20"></div>

      <div  class="single-product__image">
        <img src="<?php echo $img_url; ?>" alt="">

        <a href="#" class="single-product__btn-gallery show-gallery-product">
          <svg class="icon svg-icon-gallery"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-gallery"></use> </svg>
          Gallery
        </a>
      </div>
    </div><!-- text-center -->
  </div>

  <div class="single-product__features">
    <table><tr>
      <td>
        <svg class="icon svg-icon-minimal"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-minimal"></use> </svg>
        <p>Minimal</p>
      </td>
      <td>
        <svg class="icon svg-icon-custom"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-custom"></use> </svg>
        <p>Customisable</p>
      </td>

      </tr>
      <tr>
      <td>
        <svg class="icon svg-icon-ready"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-ready"></use> </svg>
        <p>Social Ready</p></td>
      <td>
        <svg class="icon svg-icon-full"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-full"></use> </svg>
        <p>Full&nbsp;Resolution</p></td>
    </tr>
  </table>
  </div><!-- single-product__features -->

  <div class="spacer-h-20"></div>

  <?php if ($expect['display']): ?>
    <h2 class="single-product__subtitle">
      What to expect with <?php echo $title; ?>
    </h2>
    <div class="spacer-h-10"></div>

    <p class="single-product__regular-text">
      <?php echo $expect['expect_for'] ?>
    </p>
    <div class="spacer-h-10"></div>

    <?php if ($expect['elements']): ?>
      <div class="flex single-product__expect-block">
        <?php foreach ($expect['elements'] as $key => $el):
          $img_url = wp_get_attachment_image_url($el['image'], 'medium');
          ?>
        <div class="col-1-2">
          <img src="<?php echo $img_url ?>" alt="<?php echo $el['title'] ?>">
          <div class="spacer-h-10"></div>
          <b class="single-product__expect"><?php echo $el['title'] ?></b>
          <div class="spacer-h-20"></div>
        </div><!-- col-1-2 -->
        <?php endforeach ?>
      </div><!-- flex -->
    <?php endif ?>

    <div class="spacer-h-10"></div>
  <?php endif ?>

  <?php if ($for['display']): ?>
    <h2 class="single-product__subtitle">
      <?php echo $for['title'] ?>
    </h2>
    <div class="spacer-h-10"></div>

    <p class="single-product__regular-text">
      <?php echo $for['text'] ?>
    </p>
   <div class="spacer-h-20"></div>
  <?php endif ?>

  <?php if ($show_blocks['show_customize_and_create'] && isset($pgb['customize_and_create'])):
    $icons = array(
      'custom',
      'position',
      'glasess',
      'resize',
    );
    ?>
  <div class="single-product__new">
    <div class="clearfix">
      <img src="<?php echo THEME_URL; ?>/images/paint.svg" alt="" class="title-img">
      <span class="single-product__new-tag">new</span>
    </div>
    <div class="spacer-h-10"></div>
    <h2 class="single-product__new-title">Customise & Create</h2>
    <p class="single-product__new-text">Make each shot your own with our all new customisations.</p>
    <div class="spacer-h-10"></div>
    <table>
      <?php foreach ($pgb['customize_and_create'] as $key => $p) : ?>
      <tr>
        <td>
           <svg class="icon svg-icon-<?php echo $icons[$key];?>"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-<?php echo $icons[$key];?>"></use> </svg>
        </td>
        <td>
          <b class="single-product__new-subtitle"><?php echo $p['title'] ?></b>
          <p class="single-product__new-text"><?php echo $p['text'] ?></p>
        </td>
      </tr>
    <?php endforeach; ?>
    </table>
  </div><!-- single-product__new -->
  <div class="spacer-h-30"></div>
  <?php endif ?>

  <?php if ($show_blocks['show_good_2_know'] && isset($pgb['good_2_know'])): ?>
    <h2 class="single-product__subtitle">
      Good to know
    </h2>
    <div class="spacer-h-10"></div>

    <div class="single-product__table-content">
      <table class="single-product__table">
       <?php foreach ($pgb['good_2_know'] as $key => $p) :
          $icons = array(
            'flash',
            'close',
            'redo',
            'product',
          );
          ?>
        <tr>
          <td>
             <svg class="icon svg-icon-<?php echo $icons[$key];?>"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-<?php echo $icons[$key];?>"></use> </svg>
          </td>
          <td>
            <b class="single-product__table-subtitle"><?php echo $p['title'] ?></b>
            <p class="single-product__table-text"><?php echo $p['text'] ?></p>
          </td>
        </tr>
        <?php endforeach ?>
      </table>
    </div>

    <div class="spacer-h-30"></div>
  <?php endif ?>

  <?php if ($show_blocks['show_bespoke'] &&isset($pgb['bespoke'])): ?>
    <div class="single-product__bespoke">
      <img src="<?php echo THEME_URL; ?>/images/bespoke.png" alt="">
      <span class="single-product__bespoke-tag">100% BESPOKE</span>
      <div class="spacer-h-30"></div>
      <h2 class="single-product__bespoke-title"><?php echo $pgb['bespoke']['title'] ?></h2>
      <p class="single-product__bespoke-text"><?php echo $pgb['bespoke']['text'] ?></p>
      <div class="spacer-h-100"></div>
    </div>
  <?php endif ?>

  <div class="spacer-h-150"></div>

  <div class="single-product__cta">
    <div class="single-product__cta-row">
      <div class="single-product__cta-row-icon">
        <img src="<?php echo THEME_URL; ?>/images/paint.svg" alt="">
      </div>
      <div class="single-product__cta-row-text">
        <p>
          <?php echo $cta_text ?>
        </p>
      </div>
    </div><!-- top-row -->
    <div class="single-product__cta-row">
      <div class="col-1-2 valign-center">
        <p class="single-product__cta-row-price"><?php echo $photo_price; ?> <span>/ photo</span></p>
        <div class="spacer-h-10"></div>
        <img src="<?php echo THEME_URL; ?>/images/star.png" alt="" class="star">
        <?php echo $rate['value']; ?><span class="green"> <?php echo $rate['title']; ?></span>
      </div>
      <div class="col-1-2 valign-center">
        <a href="<?php echo $constructor_url; ?>" class="single-product__cta-row-button">Start Shoot</a>
      </div>
    </div>
  </div><!-- single-product__cta -->

  <div class="single-product__gallery-overlay ">
    <div class="single-product__gallery-overlay-head">
      <p class="single-product__gallery-overlay-title">
        <?php echo $title;?>
      </p>

     <svg class="icon svg-icon-close gallery-close"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-close"></use> </svg>
    </div><!-- single-product__gallery-overla -->

    <div class="single-product__gallery-overlay-body">

      <?php foreach ($gallery as $img_url): ?>
      <div class="single-product__gallery-item"><img src="<?php echo $img_url;?>" alt=""></div>
      <?php endforeach ?>
    </div><!-- single-product__gallery-overlay-body -->
  </div>
</div>
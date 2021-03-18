<div class="single-product-holder">
  <div class="container-lg">
    <div class="single-product__head" <?php echo 'style="background-color: '.$bg_color.';"' ?>>
      <div class="main-row row">
        <div class="text-left col-md-5 offset-md-1 valign-center" <?php echo 'style="z-index: 10;"'; ?>>
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

        </div><!-- text-center -->
        <div class="single-product__image col-md-6">
          <img src="<?php echo $img_url; ?>" alt="">
        </div>

      </div>

      <div class="bottom-row">
        <div class="valign-center">
          <img src="<?php echo THEME_URL; ?>/images/star.png" alt="" class="star">
          <?php echo $rate['value']; ?><span class="green"> <?php echo $rate['title']; ?></span>
        </div>

        <div class="spacer"></div>

        <div class="bottom-row__cta-row valign-center">
          <div class="bottom-row__icon">
            <img src="<?php echo THEME_URL; ?>/images/paint.svg" alt="">
          </div>
          <div class="bottom-row__cta-row-text">
            <p>
             <?php echo $cta_text ?>
            </p>
          </div>
        </div><!-- bottom-row__cta-row-icon -->

        <div class="spacer"></div>

        <div class="valign-center text-center text-right-lg">
          <span class="price"><?php echo $photo_price; ?><span>/ photo</span></span>

          <a href="<?php echo $constructor_url ?>" class="button">Start Shoot</a>

          <a href="javascript:void(0)"  onclick="show_gallery()" class="gallery">
            <svg class="icon svg-icon-gallery"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-gallery"></use> </svg>
            <span class="gallery">Gallery</span>
          </a>
        </div>


      </div><!-- bottom-row -->
    </div><!-- single-product__head -->
  </div><!-- container-lg -->

  <div class="single-product__features">
    <div class="container-lg">
      <table class="single-product__props">
        <tbody><tr>
          <td>
            <svg class="icon svg-icon-minimal"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-minimal"></use> </svg>
            <p>Minimal</p>
          </td>
          <td>
            <svg class="icon svg-icon-custom"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-custom"></use> </svg>
            <p>Customisable</p>
          </td>
          <td>
            <svg class="icon svg-icon-ready"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-ready"></use> </svg>
            <p>Social Ready</p></td>
          <td>
            <svg class="icon svg-icon-full"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-full"></use> </svg>
            <p>Full Resolution</p></td>
        </tr>
      </tbody></table>
    </div><!-- container-lg -->
  </div><!-- single-product__features -->
</div>
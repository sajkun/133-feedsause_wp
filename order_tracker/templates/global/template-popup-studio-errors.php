<?php
if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}
?>
<transition name="fade" id="popup_studio_errors" >
<div class="popup-wrapper"  v-if="visible">
  <div class="popup-inner">
    <div class="spacer-h-40"></div>
    <div class="text-center">
      <img src="<?php echo THEME_URL?>/order_tracker/assets/images/oops.svg" class="head-icon" alt="">
      <div class="spacer-h-30"></div>
      <p class="popup-inner__title2">Oops!</p>
      <p class="popup-inner__text2">You’ll need to double check a few things before <br> submitting the photos. Please see below.</p>
    </div>
     <div class="spacer-h-20"></div>
    <div class="hr"></div>

    <div class="clearfix" v-if="image_error">
     <div class="spacer-h-20"></div>
      <div class="row">
        <div class="col-1">
        </div>
        <div class="col-1">
          <img src="<?php echo THEME_URL; ?>/order_tracker/assets/images/alert.svg" alt="">
        </div>
        <div class="col-9">
          <div class="popup-inner__label2">You have only uploaded <span class="marked">{{images_uploaded}}</span> out of the {{images_to_show}} photos on the order.</div>
        </div>
      </div>
     <div class="spacer-h-20"></div>
     <div class="hr"></div>
    </div>

    <div class="clearfix" v-for="error , key in errors" :key="'error_text_'+ key">
     <div class="spacer-h-20"></div>
      <div class="row">
        <div class="col-1">
        </div>
        <div class="col-1">
          <img src="<?php echo THEME_URL; ?>/order_tracker/assets/images/alert.svg" alt="">
        </div>
        <div class="col-9">
          <div class="popup-inner__label2">{{error}}</div>
        </div>
      </div>
     <div class="spacer-h-20"></div>
     <div class="hr"></div>
    </div>

     <div class="spacer-h-20"></div>
    <div class="clearfix">
      <a href="#" class="popup-inner__submit green"  v-on:click.prevent="visible=false">Ok</a>
    </div>

    <div class="spacer-h-30"></div>
  </div>
</div>
</transition>
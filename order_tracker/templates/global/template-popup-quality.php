<?php
if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}
?>
<transition name="fade" id="popup_quality" >
<div class="popup-wrapper"  v-if="visible">
  <div class="popup-inner">
    <div class="spacer-h-40"></div>
    <div class="text-center">
      <img src="<?php echo THEME_URL?>/order_tracker/assets/images/quality.svg" class="head-icon" alt="">
      <div class="spacer-h-30"></div>
      <p class="popup-inner__title2">Quality Control</p>
      <p class="popup-inner__text2">By marking your shoot as completed,you confirm  <br> that you have met <a href="" target="_blank">Feedsauce’s Shoot Standards.</a></p>
    </div>
     <div class="spacer-h-20"></div>
    <div class="hr"></div>

    <div class="clearfix" ref="check_notes">
      <div class="spacer-h-10"></div>
      <div class="row no-gutters">
        <div class="col-2 valign-center">
          <label class="checkbox-imitation-blue">
            <input type="checkbox" v-model="check_notes" id="check_notes">
            <span class="view"></span>
            <div class="spacer-h-10"></div>
          </label>
        </div>
        <div class="col-10">
          <label for="check_notes">
            <span class="popup-inner__title3">Notes</span>
            <span class="popup-inner__text3">I’ve read and adhered to the shoot notes.</span>
          </label>
        </div>
      </div><!-- row -->
      <div class="spacer-h-10"></div>
    </div><!-- clearfix -->

    <div class="hr"></div>

    <div class="clearfix" ref="check_sizes">
      <div class="spacer-h-10"></div>
      <div class="row no-gutters">
        <div class="col-2  valign-center">
          <label class="checkbox-imitation-blue">
            <input type="checkbox" v-model="check_sizes" id="check_sizes">
            <span class="view"></span>
            <div class="spacer-h-10"></div>
          </label>
        </div>
        <div class="col-10">
          <label for="check_sizes">
            <span class="popup-inner__title3">Sizes </span>
            <span class="popup-inner__text3">I’ve provided the relevant photo sizes</span>
          </label>
        </div>
      </div><!-- row -->
      <div class="spacer-h-10"></div>
    </div><!-- clearfix -->

    <div class="hr"></div>

    <div class="clearfix" ref="check_product">
      <div class="spacer-h-10"></div>
      <div class="row no-gutters">
        <div class="col-2 valign-center">
          <label class="checkbox-imitation-blue">
            <input type="checkbox" v-model="check_product" id="check_product">
            <span class="view"></span>
            <div class="spacer-h-10"></div>
          </label>
        </div>
        <div class="col-10">
          <label for="check_product">
            <span class="popup-inner__title3">Product</span>
            <span class="popup-inner__text3">I’ve shot the correct product</span>
          </label>
        </div>
      </div><!-- row -->
      <div class="spacer-h-10"></div>
    </div><!-- clearfix -->
    <div class="spacer-h-20"></div>

    <div class="clearfix">
      <a href="#" class="popup-inner__submit green" v-on:click.prevent="submit">Submit Photos</a>
      <div class="spacer-h-10"></div>
      <a href="#" class="popup-inner__submit white" v-on:click.prevent="visible=false">Cancel</a>
    </div>
    <div class="spacer-h-30"></div>
   </div><!-- popup-inner -->
</div><!-- popup-wrapper -->
</transition>
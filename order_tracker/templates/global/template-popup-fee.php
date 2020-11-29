<?php
if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}
?>
<transition name="fade" id="add-fee" >
  <div class="popup-wrapper" v-show="visible" >
    <div class="popup-inner" v-on:click.stop>
      <div class="popup-inner__head">
        <svg class="icon  svg-icon-lock"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-lock"></use> </svg>
        <span class="title">Add Fee</span>
        <i class="icon-close" v-on:click="visible=false">×</i>
      </div>

      <div class="spacer-h-20"></div>

      <div class="clearfix">
        <label>Item</label>
        <input type="text" id="fee-name" class="popup-inner__field" placeholder="Enter item name" v-model="fee_title" ref="fee_title">
      </div>

      <div class="spacer-h-20"></div>

      <div class="clearfix">
        <label>Amount</label>
        <input type="text" id="fee-ammount" class="popup-inner__field" placeholder="£0.00" v-model="fee_ammount" ref="fee_ammount">
      </div>
      <div class="spacer-h-20"></div>

      <div class="clearfix">
        <a href="#" v-on:click.prevent="submit" class="popup-inner__submit">Add fee</a>
      </div>

      <div class="spacer-h-20"></div>
    </div>
  </div>
</transition>
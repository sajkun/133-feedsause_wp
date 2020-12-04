<?php
if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}
?>
<transition name="fade" id="popup_shoot" >
<div class="popup-wrapper"  v-if="visible">
  <div class="popup-inner">
    <div class="spacer-h-40"></div>
    <i class="icon-close" v-on:click="visible=false">×</i>
    <div class="text-center">
      <img src="<?php echo THEME_URL?>/order_tracker/assets/images/camera.svg" class="head-icon" alt="">
      <div class="spacer-h-30"></div>
      <p class="popup-inner__title2">It’s Showtime!</p>
      <p class="popup-inner__text2">Once the shoot begins, you must complete the <br> order before the due date.</p>
    </div>
     <div class="spacer-h-20"></div>
    <div class="hr"></div>
    <div class="clearfix ">
      <div class="spacer-h-20"></div>
      <div class="row">
        <div class="span order-status">
          <i class="icon" v-bind:style="{backgroundColor: color}"></i>
          <span class="popup-inner__label2">{{status}}</span>
        </div>
      </div>
      <div class="spacer-h-20"></div>
    </div>
    <div class="hr"></div>

    <div class="clearfix">
      <div class="spacer-h-20"></div>
      <span class="popup-inner__label2">
        Due
      </span>

      <div class="row no-gutters">
        <span class="col popup-inner__text2"> {{due_date}}</span>

        <span>
          <span class="mark-tag">{{number_of_dates_left.diff}} {{number_of_dates_left.label}}</span>
        </span>
      </div>
      <div class="spacer-h-20"></div>
    </div>

    <div class="clearfix">
      <a href="#" class="popup-inner__submit green" v-on:click.prevent="submit">Start</a>
    </div>

    <div class="spacer-h-30"></div>
  </div>
</div>
</transition>
<?php
if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}
?>
<transition name="fade" id="add-address-billing" >
  <div class="popup-wrapper" v-show="visible" >
    <div class="popup-inner">
      <div class="popup-inner__head">
        <svg class="icon  svg-icon-geo"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-geo"></use> </svg>
        <span class="title">Add address</span>
        <i class="icon-close" v-on:click="visible=false">×</i>
      </div>

      <div class="spacer-h-20"></div>

      <div class="clearfix">
        <label>Billing address</label>

        <div class="spacer-h-20"></div>

        <select-imitation
          ref="country"
          v-bind:class="'fullwidth'"
          v-bind:_select_name="'country'"
          v-bind:_options="countries"
          v-bind:_selected="'United Kingdom'"
          v-on:update_list="update_data($event)"
        ></select-imitation>

      </div>

      <div class="spacer-h-20"></div>

        <div class="clearfix">
          <input type="text" class="popup-inner__field" placeholder="Company" v-model="company" ref="company">
        </div>
      <div class="spacer-h-20"></div>

      <div class="clearfix">
        <input type="text" class="popup-inner__field" placeholder="Address line 1" v-model="address_1" ref="address_1">
      </div>
      <div class="spacer-h-20"></div>

      <div class="clearfix">
        <input type="text" class="popup-inner__field" placeholder="Address line 2" v-model="address_2" ref="address_2">
      </div>
      <div class="spacer-h-20"></div>

      <div class="clearfix">
        <input type="text" class="popup-inner__field" placeholder="Town or City" v-model="city" ref="city">
      </div>
      <div class="spacer-h-20"></div>

      <div class="clearfix">
        <input type="text" class="popup-inner__field" placeholder="Postal code" v-model="postcode" ref="postcode">
      </div>
      <div class="spacer-h-20"></div>

      <div class="clearfix">
        <a href="#" v-on:click.prevent="submit" class="popup-inner__submit">Add address</a>
      </div>

      <div class="spacer-h-20"></div>
    </div>
  </div>
</transition>
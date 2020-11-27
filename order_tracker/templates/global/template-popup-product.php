<?php
if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}
?>
<transition name="fade" id="add-product" >
  <div class="popup-wrapper" v-show="visible" >
    <div class="popup-inner" v-on:click.stop>
      <div class="popup-inner__head">
        <svg class="icon  svg-icon-lock"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-lock"></use> </svg>
        <span class="title">Add product</span>
        <i class="icon-close" v-on:click="visible=false">×</i>
      </div>

      <div class="spacer-h-20"></div>
      <div class="clearfix">
        <label for="product-name">Recipe</label>
        <input-text-search-product
        ref = "recipe"
        v-bind:_name = "'recipe'"
        v-bind:_img_url="'assets/images/spinner.gif'"
        v-bind:_placeholder="'Enter recipe name'"
        v-on:product_found="set_product_data($event)"
        ></input-text-search-product>
      </div>
      <div class="spacer-h-20"></div>

      <transition
        v-on:before-enter="animation_beforeEnter"
        v-on:animation-after="animation_enterAfter"
        v-on:enter="animation_enter"
        v-on:leave="animation_leave"
        v-bind:css="false"
      >
        <div class="clearfix" v-if="is_product_selected">
          <label>No. of Photos</label>
          <div class="row no-gutters" ref="selected_product_id">
            <span class="number"  v-for="(variation, var_id) in variations"
              v-on:click="selected_product_id = variation.variation_id"
              v-bind:class="{'selected' : selected_product_id === variation.variation_id}">{{variation.images}}</span>

            <span class="number free"
              v-if="free_product_id"
              v-on:click="selected_product_id=free_product_id"
              v-bind:class="{'selected' : selected_product_id === free_product_id}"
               >Free Sample</span>
          </div>
          <div class="spacer-h-20"></div>
        </div>
      </transition>

      <div class="clearfix">
        <label>Sizes</label>
        <div class="row gutters-5 tile-items" ref="sizes">
          <span class="number"
          v-bind:class="{'selected': has_size('Square')}"
          v-on:click="update_sizes('Square')">Square</span>

          <span class="number"
          v-bind:class="{'selected': has_size('Story')}"
          v-on:click="update_sizes('Story')">Story</span>

          <span class="number"
          v-bind:class="{'selected': has_size('Wide')}"
          v-on:click="update_sizes('Wide')">Wide</span>

          <span class="number"
          v-bind:class="{'selected': has_size('Full HD')}"
          v-on:click="update_sizes('Full HD')">Full HD</span>
        </div>
      </div>

      <div class="spacer-h-20"></div>

      <div class="clearfix">
        <label>Product Name</label>
        <input type="text" class="popup-inner__field" placeholder="Enter product name" v-model="product_title" ref="product_title">
      </div>

      <div class="spacer-h-20"></div>

      <div class="clearfix">
        <label>Notes</label>
        <input type="text"  class="popup-inner__field" placeholder="Add Notes"  v-model="notes">
      </div>
      <div class="spacer-h-20"></div>

      <div class="clearfix">
        <a href="#" v-on:click.prevent="submit" class="popup-inner__submit">Add product</a>
      </div>

      <div class="spacer-h-20"></div>
    </div>
  </div>
</transition>
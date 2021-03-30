<div class="container-lg fixed visuallyhidden" id="my_gallery">

  <div v-show="show_list">
    <div class="spacer-h-25"></div>
    <div class="row">
      <div class="col-12 col-md-4">
        <h2 class="my-order__title">
          <span class="my-order__title-text">Gallery </span>
        </h2>
        <div class="spacer-h-20"></div>
      </div>

      <div class="col-12 col-md-8 text-right-md">
        <my-date-range
        :class="'fit-size'"
         v-on:change_dates = 'change_dates_cb'
        ></my-date-range>

        <a href="<?php echo $shoot_url; ?>" class="my-order__button-add">+</a>
      </div>
    </div><!--   -->

    <div class="spacer-h-20"></div>


    <div class="clearfix"></div>

    <div class="my-order__filter">
      <div class="my-order__filter-scroll">
        <a href="#processing" class="my-order__filter-item-2"
        :class="{active: (filter=='all')}"
        v-on:click="filter='all'"
        >All Photos <span class="count">{{images_count.all}}</span></a>

        <a href="#completed" class="my-order__filter-item-2"
         :class="{active: (filter=='downloaded')}"
         v-on:click="filter='downloaded'"
         >Downloaded <span class="count">{{images_count.downloaded}}</span></a>

        <a href="#completed" class="my-order__filter-item-2"
        :class="{active: (filter=='available')}"
        v-on:click="filter='available'"
        >Available <span class="count">{{images_count.available}}</span></a>

        <a href="#completed" class="my-order__filter-item-2"
        :class="{active: (filter=='inreview')}"
        v-on:click="filter='inreview'"
        >In Review <span class="count">{{images_count.inreview}}</span></a>
      </div>
    </div>

    <div class="spacer-h-30"></div>

    <div class="images-row">
      <div class="images-row-scroll" ref="images_scroll">
        <div class="images-item"
           v-for="g_thumb, id in gallery_thumbs_filtered"
           :key="'g_thumb_'+id"
           v-on:click = "open_order(g_thumb.order_id)"
          >
          <img :src="g_thumb.url" alt="">
        </div>

        <div class="spacer" key="spacer_1"></div>
        <div class="spacer" key="spacer_2"></div>
        <div class="spacer" key="spacer_3"></div>
        <div class="spacer" key="spacer_4"></div>
      </div>
    </div>

    <div class="spacer-h-40"></div>

    <div class="my-cta">
      <span class="my-cta__tag">
        NEW
      </span>
      <span class="my-cta__category">START SHOOT</span>

      <div class="spacer-h-10"></div>

      <h4 class="my-cta__title">More photos, shall we?</h4>
      <p class="my-cta__text">Top up your gallery with beautiful new photos, fresh from the Feedsauce kitchen</p>

      <div class="text-center">
        <a href="<?php echo get_permalink( woocommerce_get_page_id( 'shop' ) );?>" class="my-cta__button">Explore Recipes</a>
      </div>
    </div>
  </div>


  <my-order-details
    ref="order_details"
    v-on:images_update = "images_update_cb"
    v-on:review_submited = "review_submited_cb"
  ></my-order-details>
</div>

<script src="https://js.stripe.com/v3/"></script>

<div class="spacer-h-150"></div>
<div class="spacer-h-150"></div>


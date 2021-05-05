<div class="container">
  <div id="review_page">
    <div class="spacer-h-30"></div>

    <div class="row">
      <div class="col-7"></div>
      <div class="col-5 text-right">
        <my-date-range
         v-on:change_dates = 'change_dates_cb'
        ></my-date-range>
      </div>
    </div>

    <div class="spacer-h-20"></div>

    <div class="my-order__filter">
      <div class="decoration" ></div>
      <div class="decoration pre" ></div>

      <a href="#all" class="my-order__filter-item-2"
        v-on:click="filter='all'"
        :class="{active: filter=='all'}"
        >All Photos <span class="count">{{filtered_items.all.length}}</span></a>

      <a href="#all" class="my-order__filter-item-2"
        v-on:click="filter='awaiting'"
        :class="{active: filter=='awaiting'}"
      >Awaiting Decision <span class="count">{{filtered_items.awating.length}}</span></a>

      <a href="#all" class="my-order__filter-item-2"
        v-on:click="filter='review'"
        :class="{active: filter=='review'}"
      >In Review <span class="count">{{filtered_items.review.length}}</span></a>
    </div>

    <div class="spacer-h-20"></div>

    <div class="images-row">
      <div class="images-item"
        v-on:click = show_comments_window_cb(item)
        v-for="item, key in _items"
        :key="'img'+key">
        <img :src="item.thumbnail.attachment_url" alt="">
      </div>

      <div class="images-item-blank" key="blank1"></div>
      <div class="images-item-blank" key="blank2"></div>
      <div class="images-item-blank" key="blank3"></div>
      <div class="images-item-blank" key="blank4"></div>
    </div>

    <review-item-popup
      ref="popup_review"
    ></review-item-popup>

    <download-popup-comment
      ref="comment_data"
      v-on:update_decision="update_decision_cb"
    ></download-popup-comment>

  </div>
</div>
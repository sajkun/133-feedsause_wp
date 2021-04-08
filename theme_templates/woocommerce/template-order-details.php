<?php echo '<script type="text/x-template" id="my-order-details">'; ?>
<transition
  v-bind:css="false"
  v-on:before-enter="beforeEnter"
  v-on:enter="enter_width"
  v-on:leave="leave_width"
  v-on:after-enter="enterAfter_width"
  v-on:after-leave="leaveAfter"
>
  <div class="row no-gutters my-order" v-if="show">
    <div class="col-md-5 col-lg-5 clearfix padding-right-20">
      <div class="shoot-steps dark-bg">
        <div class="shoot-steps__header">
          <a class="comment back" v-on:click = 'go_back'><svg class="icon svg-icon-bracket"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-bracket"></use> </svg> Back</a>
          <div class="spacer-h-20"></div>
          <h2 class="title">
             {{product_name}}
          </h2>
          <span class="comment">#FS-{{meta.order_id}}</span>
          <div class="spacer-h-30"></div>

          <div class="my-order__filter" ref="filter_side">
            <div class="decoration"></div>
            <div class="decoration pre"></div>
            <a href="#photos" class="my-order__filter-item-2"
              v-on:click.prevent = "mode='photos'"
              v-on:mouseover="move_deco('#photos')"
              v-on:mouseout="move_deco('filter_side')"
              :class="{active: (mode == 'photos')}">Your Photos</a>

            <a href="#details" class="my-order__filter-item-2"
            v-on:click.prevent = "mode='details'"
            :class="{active: (mode == 'details')}"
            v-on:mouseover="move_deco('#details')"
            v-on:mouseout="move_deco('filter_side')"
            >Order Details</a>
          </div>
        </div><!-- shoot-steps__header -->

        <transition
          class="studio-content"
          name="studio-content"
          tag="div"
          v-bind:css="false"
          v-on:before-enter="beforeEnter"
          v-on:enter="enter"
          v-on:leave="leave"
          v-on:after-enter="enterAfter"
          v-on:after-leave="leaveAfter"
        >
          <div class="my-order-data order-details" v-if="mode == 'details'">
            <div class="my-summary">
              <div class="my-summary__body">
                <div class="spacer-h-10"></div>
                <table class="my-summary__content">
                  <tbody>
                    <tr>
                      <td> <div class="step-label">
                          <svg class="icon svg-icon-product">
                            <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-product"></use>
                          </svg>
                          <span class="step-label__text">Products</span>
                        </div> </td>


                      <td> <p class="my-summary__content-text">{{item.name}} <span v-if="item.count" class="addon"> + {{item.count}}</span> </p> </td>

                      <td class="active"> <p class="my-summary__content-price">{{item.price}}</p> </td>
                    </tr>

                    <tr>
                      <td> <div class="step-label">
                          <svg class="icon svg-icon-images-3">
                            <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href=" #svg-icon-images-3"></use>
                          </svg>
                          <span class="step-label__text">Photos</span>
                        </div> </td>

                      <td class="active"> <p class="my-summary__content-text">{{photos.count}}</p> </td>
                      <td class="active"> <p class="my-summary__content-price">{{photos.price}}</p> </td>
                    </tr>

                    <tr>
                      <td> <div class="step-label"> <svg class="icon svg-icon-custom">
                            <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-custom"></use>
                          </svg>
                          <span class="step-label__text">Customise</span>
                        </div> </td>
                      <td class="active"> <p class="my-summary__content-text">{{customisations.count}} Customisations </p> </td>
                      <td class="active"> <p class="my-summary__content-price">{{customisations.price}}</p> </td>
                    </tr>
                    <tr>
                      <td> <div class="step-label">
                          <svg class="icon svg-icon-notes">
                            <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-notes"></use>
                          </svg>
                          <span class="step-label__text">Studio Notes</span>
                        </div> </td>

                      <td class="active"> <p class="my-summary__content-text">{{notes.text}} </p> </td>

                      <td class="active"> <p class="my-summary__content-price">{{notes.price}}</p> </td>
                    </tr>

                    <tr>
                      <td> <div class="step-label">
                          <svg class="icon svg-icon-flash">
                            <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-flash"></use>
                          </svg>
                          <span class="step-label__text">Turnaround</span>
                        </div> </td>

                      <td class="active"> <p class="my-summary__content-text">{{fasttrack.text}}</p> </td>

                      <td class="active"> <p class="my-summary__content-price">{{fasttrack.price}}</p> </td>
                    </tr>

                    <tr>
                      <td> <div class="step-label">
                          <svg class="icon svg-icon-handling">
                            <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-handling"></use>
                          </svg>
                          <span class="step-label__text">Handling</span>
                        </div> </td>

                      <td class="active"> <p class="my-summary__content-text">{{handle.text}}</p> </td>

                      <td class="active"> <p class="my-summary__content-price">{{handle.price}}</p> </td>
                    </tr>
                  </tbody>
                </table>

                <div class="spacer-h-20"></div>
                <div class="my-hr-grey"></div>
                <div class="spacer-h-10"></div>

                <table class="my-summary__content">
                  <tfoot>
                    <tr>
                      <td colspan="3"><span class="my-summary__label">Total Cost</span> <div class="spacer-h-10"></div></td>
                    </tr>
                    <tr>
                      <td colspan="2">Subtotal</td>
                      <td colspan="1" class="text-right text-white">{{total.images}}</td>
                    </tr>
                    <tr>
                      <td colspan="2">Add-Ons</td>
                      <td colspan="1" class="text-right text-white">{{total.addons}}</td>
                    </tr>
                    <tr>
                      <td colspan="2">Discount  <span v-if="meta.coupons.length>0" class="coupon_code">{{meta.coupons.join(',')}}</span></td>
                      <td colspan="1" class="text-right text-white">{{meta.discount}}</td>
                    </tr>
                    <tr>
                      <td colspan="2"></td>
                      <td colspan="1" class="text-right"><span class="my-summary__total">{{meta.total}}</span></td>
                    </tr>

                  </tfoot>
                </table>
                <div class="spacer-h-15"></div>

                <div class="text-center" :class="{visuallyhidden: (!meta.download_pdf)}"><a :href="meta.download_pdf" download class="invoice-link"><svg class="icon svg-icon-download"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-download"></use></svg>Download Invoice </a></div>
                <div class="spacer-h-20"></div>
              </div>
            </div><!-- my-summary -->
            <div class="spacer-h-25"></div>
          </div><!-- my-order-data -->
        </transition>

        <transition
          class="studio-content"
          name="studio-content"
          tag="div"
          v-bind:css="false"
          v-on:before-enter="beforeEnter"
          v-on:enter="enter"
          v-on:leave="leave"
          v-on:after-enter="enterAfter"
          v-on:after-leave="leaveAfter"
        >
          <div class="my-order-data my-order-shoots"  v-if="mode == 'photos'">
            <div class="my-order-data__header">
              <div class="cell">
                <span class="label">Photos ordered</span>
                <span class="value">{{photos.count}}</span>
              </div>
              <div class="cell">
                <span class="label">Photos created</span>
                <span class="value">{{photo_limits.total}}</span>
              </div>
              <div class="cell">
                <span class="label">Downloads remaining</span>
                <span class="value">{{photo_limits.limit}}</span>
              </div>
            </div>

            <div class="spacer-h-10" v-if="photo_limits.total > photos.count"></div>
            <div class="my-hr-grey" v-if="photo_limits.total > photos.count"></div>
            <div class="spacer-h-25" v-if="photo_limits.total > photos.count"></div>

            <div class="my-order-data__row" v-if="photo_limits.total > photos.count">
              <div class="valign-top image-holder">
                <img src="<?php echo THEME_URL?>/images/cherry.png" alt="" class="image-holder__image-cherry">
              </div>
              <div class="clearfix">
                <h2 class="my-order-data__row-title" v-on:click="show_explain = !show_explain">Why are there extra photos? <span class="trigger" :class="{active: show_explain}"></span></h2>

                <transition
                  v-bind:css="false"
                  v-on:before-enter="beforeEnter"
                  v-on:enter="enter"
                  v-on:leave="leave"
                  v-on:after-enter="enterAfter"
                  v-on:after-leave="leaveAfter"
                >
                 <p class="text" v-if="show_explain">
                   We shot a few extra photos so that you can pick your favourite ones. But hey, if you like all the photos below, you can instantly buy and download those shots too. How about that for a cherry on the cake?
                </p>
              </transition>
              </div>
            </div><!-- my-order-data__row -->

            <div class="spacer-h-15" v-if="meta.diff > 0"></div>
            <div class="my-hr-grey" v-if="meta.diff > 0"></div>
            <div class="spacer-h-25" v-if="meta.diff > 0"></div>

            <div class="my-order-data__row" v-if="meta.diff > 0">
              <div class="valign-top image-holder">
                <img src="<?php echo THEME_URL?>/images/warn.png" alt="" class="image-holder__image-warning">
              </div>
              <div class="warning">
               You have <span class="yellow">3 <span v-if="meta.diff != 1">days</span> left </span>to review your photos. After 3 days, your order will be marked as complete.
                <div class="spacer-h-5"></div>
              </div>
              <div class="spacer-h-5"></div>
            </div><!-- my-order-data__footer -->

            <div class="spacer-h-15"></div>
            <div class="my-hr-grey"></div>
            <div class="spacer-h-25"></div>

            <div class="my-cta">
              <span class="my-cta__tag">
                <span class="my-cta__tag-inner">NEW</span>
              </span>
               <div class="spacer-h-10"></div>

               <h4 class="my-cta__title">More photos, faster.</h4>
               <p class="my-cta__text">Did you know that since we already have your products <br> you can get new photos faster. </p>
               <div class="spacer-h-0"></div>
               <div class="text-center">
                <a href="<?php echo $shoot_url; ?>" class="my-cta__button">Explore Recipes</a>
                <div class="spacer-h-30"></div>
              </div>
            </div><!-- my-cta -->
          </div>
        </transition>
      </div><!-- shoot-steps -->

      <div class="spacer-h-40 spacer-h-md-0"></div>
    </div>

    <div class="col-12 col-md-7">
      <div class="progress-wrapper">
        <ul class="progress-order progress">

          <li class="progress__item"
            v-for="st, key in order_statuses"
            :key="'status_+'+key"
            :class="{active: (meta.current_status_order > 0  && parseInt(st.meta.order) <= meta.current_status_order )}"
            >
           <span class="progress__item-dots"></span>
           <span class="progress__item-name">{{st.name}}</span>
          </li>

        </ul>
      </div><!-- progress-wrapper -->

      <div class="spacer-h-45"></div>
      <h2 class="my-shoots__title">Gallery</h2>

      <p class="my-shoots__text">
        <svg class="icon svg-icon-notes"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-notes"></use> </svg>
        Click on any photo to enlarge and manage your photo
      </p>

      <div class="my-order__filter modify" ref="gallery">
        <div class="decoration"></div>
        <div class="decoration pre"></div>

        <a href="#processing" class="my-order__filter-item-2"
        v-on:click="filter='all'"
        v-on:mouseover="move_deco('#processing')"
        v-on:mouseout="move_deco('gallery')"
        :class="{active: (filter=='all')}">All Photos <span class="count">{{images_count.all}}</span></a>

        <a href="#downloaded" class="my-order__filter-item-2"
        v-on:click="filter='downloaded'"
        v-on:mouseover="move_deco('#downloaded')"
        v-on:mouseout="move_deco('gallery')"
        :class="{active: (filter=='downloaded')}">Downloaded <span class="count">{{images_count.downloaded}}</span></a>

        <a href="#available" class="my-order__filter-item-2"
        v-on:click="filter='available'"
        v-on:mouseover="move_deco('#available')"
        v-on:mouseout="move_deco('gallery')"
        :class="{active: (filter=='available')}">Not Downloaded <span class="count">{{images_count.available}}</span></a>

        <a href="#completed" class="my-order__filter-item-2"
        v-on:click="filter='inreview'"
        v-on:mouseover="move_deco('#completed')"
        v-on:mouseout="move_deco('gallery')"
        :class="{active: (filter=='inreview')}">In Review <span class="count">{{images_count.inreview}}</span></a>
      </div>

      <div class="spacer-h-25"></div>

        <transition-group
          class="my-shoots"
          name="my-shoots"
          tag="div"
          v-bind:css="false"
          v-on:before-enter="beforeEnter"
          v-on:enter="enter_width"
          v-on:leave="leave_width"
          v-on:after-enter="enterAfter_width"
          v-on:after-leave="leaveAfter"
        >
        <div class="my-shoots__item"
          v-for="thumb, key in gallery_thumbs"
          :key = "'inner_thumb_'+ key"
          v-on:click="show_popup(thumb)"
        >
          <img :src="thumb.url" alt="">
        </div>

        <div class="my-shoots__item-blank"></div>
        <div class="my-shoots__item-blank"></div>
      </transition-group>
      <div class="spacer-h-25"></div>
    </div>
    <my-order-popup
     ref="my_order_popup"
     v-on:update_images = "update_images_cb"
     v-on:review_submited = "review_submited_cb"
    ></my-order-popup>
  </div>
</transition>

<?php echo '</script>';  ?>
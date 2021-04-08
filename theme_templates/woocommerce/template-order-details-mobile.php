<?php echo '<script type="text/x-template" id="my-order-details">'; ?>

  <transition
    v-bind:css="false"
    v-on:before-enter="beforeEnter"
    v-on:enter="enter_width"
    v-on:leave="leave_width"
    v-on:after-enter="enterAfter_width"
  >
    <div class="row no-gutters my-order" v-if="show">
      <div class="col-12">
        <div class="shoot-steps">
          <div class="shoot-steps__header">
            <a class="comment" v-on:click = 'go_back'><svg class="icon svg-icon-bracket"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-bracket"></use> </svg> Back</a>
            <div class="spacer-h-20"></div>
            <h2 class="title">
               {{product_name}}
            </h2>

          <div class="row no-gutters">
            <div class="col-7">
              <span class="comment"> #FS-{{meta.order_id}} on {{order_date}} </span>
            </div>

            <div class="col-5 text-right">
              <span class="comment white-text"> <span class="status-marker"></span> {{meta.status}} </span>
            </div>
          </div>
          <div class="spacer-h-30"></div>

          </div><!-- shoot-steps__header -->
        </div>

        <div class="my-order__filter" ref="filter_side">
            <div class="decoration"></div>
            <a href="#photos" class="my-order__filter-item-2" :class="{active: (mode=='photos')}"  v-on:click="mode = 'photos'">All Photos</a>
            <a href="#details" class="my-order__filter-item-2" :class="{active: (mode=='details')}" v-on:click="mode = 'details'">Order Details</a>
        </div>

        <div class="spacer-h-20"></div>
      </div>
      <div class="col-12 col-md-5 col-lg-5 clearfix padding-right-20">

      <transition
        v-bind:css="false"
        v-on:before-enter="beforeEnter"
        v-on:enter="enter"
        v-on:leave="leave"
        v-on:after-enter="enterAfter"
      >
        <div class="shoot-steps" v-if="mode=='details'">
          <div class="summary not-fixed">
            <div class="summary__body">
              <table class="summary__content">
                <tbody>
                  <tr>
                    <td> <div class="step-label">
                        <svg class="icon svg-icon-product">
                          <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-product"></use>
                        </svg>
                        <span class="step-label__text">Products</span>
                      </div> </td>


                    <td> <p class="summary__content-text">{{item.name}} <span v-if="item.count" class="addon"> + {{item.count}}</span> </p> </td>

                    <td class="active"> <p class="summary__content-price">{{item.price}}</p> </td>
                  </tr>

                  <tr>
                    <td> <div class="step-label">
                        <svg class="icon svg-icon-images-3">
                          <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href=" #svg-icon-images-3"></use>
                        </svg>
                        <span class="step-label__text">Photos</span>
                      </div> </td>

                    <td class="active"> <p class="summary__content-text">{{photos.count}}</p> </td>
                    <td class="active"> <p class="summary__content-price">{{photos.price}}</p> </td>
                  </tr>

                  <tr>
                    <td> <div class="step-label"> <svg class="icon svg-icon-custom">
                          <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-custom"></use>
                        </svg>
                        <span class="step-label__text">Customise</span>
                      </div> </td>
                    <td class="active"> <p class="summary__content-text">{{customisations.count}} Customisations </p> </td>
                    <td class="active"> <p class="summary__content-price">{{customisations.price}}</p> </td>
                  </tr>
                  <tr>
                    <td> <div class="step-label">
                        <svg class="icon svg-icon-notes">
                          <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-notes"></use>
                        </svg>
                        <span class="step-label__text">Studio Notes</span>
                      </div> </td>

                    <td class="active"> <p class="summary__content-text">{{notes.text}} </p> </td>

                    <td class="active"> <p class="summary__content-price">{{notes.price}}</p> </td>
                  </tr>

                  <tr>
                    <td> <div class="step-label">
                        <svg class="icon svg-icon-flash">
                          <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-flash"></use>
                        </svg>
                        <span class="step-label__text">Turnaround</span>
                      </div> </td>

                    <td class="active"> <p class="summary__content-text">{{fasttrack.text}}</p> </td>

                    <td class="active"> <p class="summary__content-price">{{fasttrack.price}}</p> </td>
                  </tr>

                  <tr>
                    <td> <div class="step-label">
                        <svg class="icon svg-icon-handling">
                          <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-handling"></use>
                        </svg>
                        <span class="step-label__text">Handling</span>
                      </div> </td>

                    <td class="active"> <p class="summary__content-text">{{handle.text}}</p> </td>

                    <td class="active"> <p class="summary__content-price">{{handle.price}}</p> </td>
                  </tr>
                </tbody>
                <tfoot>
                  <tr>
                    <td colspan="3"><span class="summary__label">Total Cost</span> <div class="spacer-h-10"></div></td>
                  </tr>
                  <tr>
                    <td colspan="2">Subtotal</td>
                    <td colspan="1" class="white-text">{{total.images}}</td>
                  </tr>
                  <tr>
                    <td colspan="2">Add-Ons</td>
                    <td colspan="1" class="white-text">{{total.addons}}</td>
                  </tr>
                  <tr>
                    <td colspan="2">Discount  <span v-if="meta.coupons.length>0" class="coupon_code">{{meta.coupons.join(',')}}</span></td>
                    <td colspan="1" class="white-text">{{meta.discount}}</td>
                  </tr>
                  <tr>
                    <td colspan="1" class="white-text"></td>
                    <td colspan="2" class="white-text text-right"><span class="summary__total">{{meta.total}}</span></td>
                  </tr>

                </tfoot>
              </table>

              <div class="text-center"><a :href="meta.download_pdf" download class="invoice-link"><svg class="icon svg-icon-download"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-download"></use> </svg>Download Invoice </a></div>
            </div>
          </div><!-- summary -->
          <div class="spacer-h-25"></div>
        </div><!-- shoot-steps -->
      </transition>
      </div>
      <transition
        v-bind:css="false"
        v-on:before-enter="beforeEnter"
        v-on:enter="enter"
        v-on:leave="leave"
        v-on:after-enter="enterAfter"
      >
        <div class="col-12 col-md-7"  v-if="mode=='photos'">
          <div class="spacer-h-15"></div>
          <div class="my-order-data">
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
          <!-- v-if="photo_limits.total > photos.count" -->
           <div v-if="photo_limits.total > photos.count">
             <div class="spacer-h-15"></div>
             <div class="my-hr"></div>
             <div class="spacer-h-15"></div>
           </div>

           <div class="my-order-data__row" v-if="photo_limits.total > photos.count">
            <div class="valign-top image-holder">
              <img src="<?php echo THEME_URL?>/images/cherry.png" alt="">
            </div>

           <div>
             <div class="text" v-on:click="show_explain=!show_explain">
              <span class="white-text">Why are there extra photos?
              </span>
              <span class="text-2-right" v-if="!show_explain">+</span>
              <span class="text-2-right" v-if="show_explain">-</span>
             </div>

              <transition
                name="show_explain"
                tag="div"
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
           </div>

           <div v-if="meta.diff > 0" >
             <div class="spacer-h-15"></div>
             <div class="my-hr"></div>
             <div class="spacer-h-15"></div>
           </div>

            <div class="warning" v-if="meta.diff > 0" >
              <div class="spacer-h-10"></div>
               You have <span class="yellow">{{meta.diff}} <span v-if="meta.diff == 1">day</span>  <span  v-if="meta.diff != 1">days</span> left </span>to review your photos. After 3 days, your order will be marked as complete.
              <div class="spacer-h-5"></div>
             </div>
             <div class="spacer-h-5"></div>

           <div>
             <div class="spacer-h-15"></div>
             <div class="my-hr"></div>
             <div class="spacer-h-15"></div>
           </div>
          </div><!-- my-order-data -->

          <div class="spacer-h-25"></div>
          <div class="my-order__filter"  ref="gallery">
            <div class="my-order__filter-scroll">
              <div class="decoration"></div>
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
          <div class="spacer-h-25"></div>

          <div class="my-shoots">
            <div class="my-shoots-scroll" ref="shoots_container">

                <div class="my-shoots__item"
                  v-for="thumb, key in gallery_thumbs"
                  :key = "'inner_thumb_'+ key"
                  v-on:click="show_popup(thumb)"
                >
                  <img :src="thumb.url" alt="">
                </div>

                <div class="my-shoots__item-blank"></div>
                <div class="my-shoots__item-blank"></div>

            </div>
          </div>
          <div class="spacer-h-25"></div>
        </div>
      </transition>
    <my-order-popup
     ref="my_order_popup"
     v-on:update_images = "update_images_cb"
     v-on:review_submited = "review_submited_cb"
    ></my-order-popup>
    </div>
  </transition>


<?php echo '</script>';  ?>
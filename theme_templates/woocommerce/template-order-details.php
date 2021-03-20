<?php echo '<script type="text/x-template" id="my-order-details">'; ?>
  <div class="row no-gutters my-order" v-if="show">
      <div class="col-md-5 col-lg-5 clearfix">
      <div class="shoot-steps">
        <div class="shoot-steps__header">
          <a class="comment" v-on:click = 'go_back'>← BACK</a>
          <div class="spacer-h-20"></div>
          <h2 class="title">
             {{product_name}}
             <svg class="icon svg-icon-dots"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-dots"></use> </svg>
          </h2>
        <span class="comment">#FS-{{meta.order_id}}</span>

        </div><!-- shoot-steps__header -->
        <div class="summary">
          <div class="summary__body">
            <h3 class="summary__title">Shoot Summary</h3>
            <p class="summary__text">Order placed on {{order_date}}</p>
            <div class="spacer-h-10"></div>
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
                  <td colspan="1">{{total.images}}</td>
                </tr>
                <tr>
                  <td colspan="2">Add-Ons</td>
                  <td colspan="1">{{total.addons}}</td>
                </tr>
                <tr>
                  <td colspan="2">Discount  <span v-if="meta.coupons.length>0" class="coupon_code">{{meta.coupons.join(',')}}</span></td>
                  <td colspan="1">{{meta.discount}}</td>
                </tr>
                <tr>
                  <td colspan="2"></td>
                  <td colspan="1"><span class="summary__total">{{meta.total}}</td>
                </tr>

              </tfoot>
            </table>
          </div>
        </div><!-- summary -->
        <div class="spacer-h-25"></div>
      </div><!-- shoot-steps -->
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

    <div class="my-order-data">
     <div class="my-order-data__header">
        <div class="cell">
          <span class="value">{{photos.count}}</span>
          <span class="label">PHOTOS ORDERED</span>
        </div>
        <div class="cell">
          <span class="value">{{photo_limits.total}}</span>
          <span class="label">PHOTOS CREATED</span>
        </div>
        <div class="cell">
          <span class="value">{{photo_limits.limit}}</span>
          <span class="label">DOWNLOADS REMAINING</span>
        </div>
     </div>

     <div class="my-order-data__row" v-if="photo_limits.total > photos.count">
      <div class="valign-center image-holder">
        <img src="assets/images/cherry.png" alt="">
      </div>
       <p class="text">
         We shot a few extra photos so that you can pick your favourite ones. But hey, if you like all the photos below, you can instantly buy and download those shots too. How about that for a cherry on the cake?
       </p>
     </div>

     <div class="my-order-data__footer" v-if="meta.diff > 0">
      <div class="warning">
        <div class="spacer-h-10"></div>
         You have <span class="yellow">{{meta.diff}} <span v-if="meta.diff == 1">day</span>  <span  v-if="meta.diff != 1">days</span> left </span>to review your photos. After 3 days, your order will be marked as complete.
        <div class="spacer-h-5"></div>
       </div>
       <div class="spacer-h-5"></div>
     </div>
    </div><!-- my-order-data -->

    <div class="spacer-h-25"></div>

    <div class="my-shoots">
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
    <div class="spacer-h-25"></div>
  </div>

  <my-order-popup
   ref="my_order_popup"
   v-on:update_images = "update_images_cb"
  ></my-order-popup>
<?php echo '</script>';  ?>
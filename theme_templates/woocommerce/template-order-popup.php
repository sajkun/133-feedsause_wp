<?php echo '<script type="text/x-template" id="my-order-popup">'; ?>
  <div class="download-popup" v-if="show">
    <div class="download-popup__window">
      <div class="download-popup__inner">

        <div class="download-popup__image">
          <img :src="image.url_lg" alt="">
        </div><!-- download-popup__images -->

        <div class="download-popup__content" ref="step_1" v-show="position == 'step_1'">
          <div class="download-popup__row">
            <span class="number">#FS-{{meta.order_id}}/{{(parseInt(image.meta.id) + 1) }}</span>
            <span class="close" v-on:click="show=false"><svg class="icon svg-icon-close"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-close"></use> </svg>Close</span>
          </div><!-- download-popup__row -->
          <div class="spacer-h-10"></div>
          <div class="download-popup__row">
            <span class="download-popup__title">Download</span>

            <span class="download-popup__text" v-if="image.meta.is_active == 1">Your photo is ready to be downloaded.</span>
            <span class="download-popup__text" v-if="image.meta.is_active != 1">Your photo is not ready or under review</span>

            <div class="spacer-h-20"></div>
          </div><!-- download-popup__row -->

          <div class="download-popup__row divider  fl">
            <div class="spacer-h-20"></div>
            <div class="clearfix">
              <span class="download-popup__label">
               <svg class="icon svg-icon-resize"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-resize"></use> </svg>
                Photo Sizes Included</span>
            </div>
            <div class="spacer-h-20"></div>

            <div class="studio-content__numbers flex">
              <div class="radio-imitation studio-content__number" v-show="image.sizes.value.indexOf('squre') >=0 ">
                <span class="radio-imitation__view text-center">
                  <span class="radio-imitation__longtext">
                    <span class="radio-imitation__size squre"></span>
                    <b>Square</b> 1:1
                  </span>
                </span>
              </div>

              <label class="radio-imitation studio-content__number"  v-show="image.sizes.value.indexOf('story') >=0 ">
                <span class="radio-imitation__view text-center">
                  <span class="radio-imitation__longtext">
                    <span class="radio-imitation__size story"></span>
                    <b>Story </b> 9:16
                  </span>
                </span>
              </label>

              <label class="radio-imitation studio-content__number" v-show="image.sizes.value.indexOf('wide') >=0">
                <span class="radio-imitation__view text-center">
                  <span class="radio-imitation__longtext">
                    <span class="radio-imitation__size wide"></span>
                    <b>Wide</b> 3:2
                  </span>
                </span>
              </label>

              <label class="radio-imitation studio-content__number" v-show="image.sizes.value.indexOf('hd') >=0">
                <span class="radio-imitation__view text-center">
                  <span class="radio-imitation__longtext">
                    <span class="radio-imitation__size hd">
                      <svg class="icon svg-icon-hd"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-hd"></use></svg>
                    </span>
                    <b>Full HD</b>Max Size
                  </span>
                </span>
              </label>
            </div>

            <div class="spacer-h-20"></div>
            <span class="warning" v-if="image.meta.was_downloaded == 0">Please note, once this photo is approved and downloaded, it will no longer be elegible for edit requests.</span>
            <span class="warning" v-if="image.meta.was_downloaded == 1">This photo was approved and downloaded, it is no longer elegible for edit requests.</span>
            <div class="spacer-h-20"></div>

            <a href="#" class="button-green" :class="{'not-active' : (image.meta.is_active != 1)}" v-on:click="exec_download">
              <span v-if="image.meta.was_downloaded == 0"> Approve & Download </span>
              <span v-if="image.meta.was_downloaded == 1"> Download </span>
              <span class="spacer"></span>
               <svg class="icon svg-icon-tick"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-tick"></use> </svg>
            </a>
            <div class="spacer-h-20"></div>
          </div><!-- download-popup__row -->

          <div class="download-popup__row divider" v-if="image.meta.was_downloaded == 0">
            <div class="spacer-h-20"></div>
            <div class="clearfix">
              <span class="download-popup__label">Something not right?</span>
              <div class="clearfix"></div>
              <div class="spacer-h-5"></div>
              <span class="download-popup__text">
                <i class="icon-right text-right"><svg class="icon svg-icon-next-bracket"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-next-bracket"></use> </svg></i>
                Request a free edit if we’ve missed something from your notes or you can pay for a re-shoot
              </span>
            </div>
          </div>
        </div><!-- download-popup__content -->

        <div class="download-popup__content" ref="step_2" v-show="position == 'step_2'">
          <div class="download-popup__row">
            <span class="close" v-on:click="show=false"><svg class="icon svg-icon-close"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-close"></use> </svg>Close</span>
            <div class="spacer-h-30"></div>
            <span class="download-popup__title">Review Photo</span>
            <span class="download-popup__text">Please select which type of review you require</span>

            <div class="spacer-h-20"></div>

            <label class="radio-imitation props-options">
              <input type="radio" name="notes" value="simple">
              <span class="radio-imitation__view flex text-left">
                <span class="radio-imitation__longtext valign-center">
                  <b>Correction | <span class="marked">3 Business Days</span></b>
                   Photo doesn’t match my order notes or there’s a blemish that needs to be fixed.
                </span>
                <span class="radio-imitation__icon valign-center">
                  <span class="price-marker">Free</span>
                </span>
              </span>
            </label>

            <div class="spacer-h-20"></div>

            <textarea  class="download-popup__textarea" placeholder="Enter request (max 500 characters)"></textarea>

            <div class="spacer-h-15"></div>

            <label  class="download-popup__file-imitation">
              <span class="text">Attach Screenshot (optional)</span>
              <input type="file">
              <svg class="icon svg-icon-file"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-file"></use> </svg>
            </label>

            <div class="spacer-h-15"></div>

            <label class="radio-imitation props-options">
              <input type="radio" name="notes" value="simple">
              <span class="radio-imitation__view flex text-left">
                <span class="radio-imitation__longtext valign-center">
                  <b>Re-shoot Photo  | <span class="marked">5 Business Days</span></b>
                   I’d like this photo to be re-shot with a new requirement (e.g. colour or arrangement)
                </span>
                <span class="radio-imitation__icon valign-center">
                  <span class="price-marker">Free</span>
                </span>
              </span>
            </label>
          </div><!-- download-popup__row -->
          <div class="download-popup__row">
            <div class="warning">Once you review is submitted, this photo will be locked and you’ll be unable to download until review is complete.</div>
            <div class="spacer-h-20"> </div>
            <div class="download-popup__button-holder">
              <a href="#" class="prev-step"></a>
              <a href="javascript:void(0)" class="download-popup__button not-active">
                <span>
                  <span class="">Submit Review</span>
                </span>
                <span class="arrow"></span>
                <span class="spacer"></span>
              </a>
            </div>
          </div><!-- download-popup__row -->
        </div>

        <div class="download-popup__content" ref="step_3" v-show="position == 'step_3'">
          <div class="download-popup__row">
            <span class="close" v-on:click="show=false"><svg class="icon svg-icon-close"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-close"></use> </svg>Close</span>
          </div>

          <div class="download-popup__row text-center">
            <img src="assets/images/okay.svg" alt="">
            <div class="spacer-h-10"></div>
            <span class="download-popup__subtitle">Request Recieved</span>
            <div class="spacer-h-15"></div>
            <span class="download-popup__text">Thank you for submitting your review. Please allow up to 24 hours for us to approve your request.</span>
          </div>

          <div class="download-popup__row">
            <div class="spacer-h-50"></div>
          </div>
        </div>
      </div>
    </div><!-- download-popup__window -->
  </div><!-- download-popup -->

<?php echo '</script>';  ?>
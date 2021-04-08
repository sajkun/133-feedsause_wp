<?php echo '<script type="text/x-template" id="my-order-popup">'; ?>
  <transition
    v-bind:css="false"
    v-on:before-enter="beforeEnter"
    v-on:enter="enter_width"
    v-on:leave="leave_width"
    v-on:after-enter="enterAfter_width"
  >
    <div class="download-popup" v-if="show">
      <div class="download-popup__window">
        <div class="download-popup__inner">

          <div class="download-popup__image">
            <div class="download-popup__row mobile-order">
              <span class="number">#FS-{{meta.order_id}}/{{(parseInt(image.meta.id) + 1) }}</span>
              <span class="close" v-on:click="show=false">Close<svg class="icon svg-icon-close"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-close"></use>
              </svg></span>
            </div><!-- download-popup__row -->
            <img :src="image.url_lg" alt="">
          </div><!-- download-popup__images -->
          <div class="download-popup__content">
            <transition
              v-bind:css="false"
              v-on:before-enter="beforeEnter"
              v-on:enter="enter_width"
              v-on:leave="leave_width"
              v-on:after-enter="enterAfter_width"
            >
            <div class="download-popup__content-inner" ref="step_0" v-show="position == 'step_0'">
              <div class="blocker" :class="{'shown': show_blocker}">
                <img src="<?php echo THEME_URL?>/images/spinner2.gif" alt="">
              </div>
              <div class="download-popup__row">
                <span class="download-popup__title">Buy & Download</span>

                <span class="download-popup__text">You downloaded {{images_count.downloaded}} photos from <b>Order #FS-{{meta.order_id}}</b>. This is an additional photo we created which you can purchase.</span>


                <div class="spacer-h-25"></div>
              </div><!-- download-popup__row -->

              <div class="download-popup__row divider  fl">
                <div class="spacer-h-20"></div>
                <div class="clearfix">
                  <span class="download-popup__label">
                   <svg class="icon svg-icon-resize"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-resize"></use> </svg>
                    Photo Sizes Included</span>

                    <div class="expand-size" :class="{rotated: show_sizes}" v-on:click="show_sizes=!show_sizes">+</div>
                </div>
                <transition
                  name="show_sizes"
                  tag="div"
                  v-bind:css="false"
                  v-on:before-enter="beforeEnter"
                  v-on:enter="enter"
                  v-on:leave="leave"
                  v-on:after-enter="enterAfter"
                  v-on:after-leave="leaveAfter"
                >
                  <div  v-if="show_sizes">
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
                  </div>
                </transition>
                <div class="spacer-h-10"></div>
                <div class="my-hr-grey"></div>
                <div class="spacer-h-10"></div>

                <div class="clearfix stripe-card-block">
                  <div class="spacer-h-10"></div>
                  <label class="studio-content__label"><svg class="icon svg-icon-card"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-card"></use></svg>
                    Pay via Card

                  <img src="<?php echo THEME_URL; ?>/images/card.png" alt="" class="card-img"></label>
                  <div class="stripe-wrapper"></div>

                  <form id="payment-form-single" ref="payment_form_single">
                    <div id="card-element-single">
                      <img src="<?php echo THEME_URL?>/images/spinner2.gif" alt="">
                      <!--Stripe.js injects the Card Element--></div>
                    <p id="card-error-single" class="download-popup__text" role="alert"></p>

                    <div class="result-message"><a href="#"></a></div>
                    <input type="submit" value="submit" class="hidden" id="submit-btn-single">
                  </form>
                </div><!-- stripe-card-block -->

                <div class="spacer-h-20"></div>
                <?php if ($product_guid_url || $redo_policy_url || $terms_page_url): ?>

                  <span class="warning warning_xs" >By placing an order with Feedsauce, you agree to
                  <?php if ($terms_page_url): ?>
                  the website <a href="<?php echo $terms_page_url; ?>" target="_blank">Terms & Conditions</a>,
                  <?php endif ?>
                  <?php if ($terms_page_url): ?>
                  our <a href="<?php echo $redo_policy_url; ?>" target="_blank">Redo Policy</a>
                  <?php endif ?>
                  <?php if ($product_guid_url): ?>
                  and verify that your product meets Feedsauce’s <a href="<?php echo $product_guid_url; ?>">Product Guidelines</a>.</span>
                  <?php endif ?>
                <?php endif ?>

                <div class="spacer-h-20"></div>

                <a href="#" class="button-green"  v-on:click="exec_buy_single_image"
                  :class="{'not-active': (!card_inserted) }"
                >
                  <span> £{{theme_prices.buy_single}} Pay & Download</span>
                  <span class="spacer"></span>
                   <svg class="icon svg-icon-tick"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-tick"></use> </svg>
                </a>
                <div class="spacer-h-20"></div>
              </div><!-- download-popup__row -->
            </div><!-- download-popup__content -->
          </transition>

            <transition
              v-bind:css="false"
              v-on:before-enter="beforeEnter"
              v-on:enter="enter_width"
              v-on:leave="leave_width"
              v-on:after-enter="enterAfter_width"
            >
              <div class="download-popup__content-inner" ref="step_1" v-show="position == 'step_1'">
                <div class="blocker" :class="{'shown': show_blocker}">
                  <img src="<?php echo THEME_URL?>/images/spinner2.gif" alt="">
                </div>


                <div class="download-popup__row  fl">
                  <div class="clearfix">
                    <span class="download-popup__label">
                     <svg class="icon svg-icon-resize"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-resize"></use> </svg>
                      Photo Sizes Included</span>

                      <div class="expand-size" :class="{rotated: show_sizes}" v-on:click="show_sizes=!show_sizes">+</div>
                  </div>
                  <transition
                    name="show_sizes"
                    tag="div"
                    v-bind:css="false"
                    v-on:before-enter="beforeEnter"
                    v-on:enter="enter"
                    v-on:leave="leave"
                    v-on:after-enter="enterAfter"
                    v-on:after-leave="leaveAfter"
                  >
                    <div  v-if="show_sizes">
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
                    </div>
                  </transition>

                  <div class="spacer-h-10"></div>
                  <div class="my-hr-grey"></div>
                  <div class="spacer-h-10"></div>

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




                <div class="download-popup__row divider" v-if="image.meta.was_downloaded == 0 && image.meta.is_active !=0">
                  <div class="spacer-h-20"></div>
                  <div class="clearfix">
                    <span class="download-popup__label">Something not right?</span>
                    <div class="clearfix"></div>
                    <div class="spacer-h-5"></div>
                    <span class="download-popup__text" v-on:click="position='step_2'">
                      <i class="icon-right text-right"><svg class="icon svg-icon-next-bracket"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-next-bracket"></use> </svg></i>
                      Request a free edit if we’ve missed something from your notes or you can pay for a re-shoot
                    </span>
                  </div>
                </div>
              </div><!-- download-popup__content -->
            </transition>

            <transition
              v-bind:css="false"
              v-on:before-enter="beforeEnter"
              v-on:enter="enter_width"
              v-on:leave="leave_width"
              v-on:after-enter="enterAfter_width"
            >
              <div class="download-popup__content-inner" ref="step_2" v-show="position == 'step_2'">

                <div class="blocker" :class="{'shown': show_blocker}">
                  <img src="<?php echo THEME_URL?>/images/spinner2.gif" alt="">
                </div>

                <div class="download-popup__row">
                  <span class="download-popup__title">Review Photo</span>
                  <span class="download-popup__text">Please select which type of review you require</span>

                  <div class="spacer-h-20"></div>

                  <label class="radio-imitation props-options" v-if="!image.meta.request">
                    <input type="radio" name="review" value="correction" v-model="request_type" >
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
                    <div class="clearfix" v-if="request_type == 'correction'">
                      <div class="spacer-h-20"></div>
                      <textarea
                        class="download-popup__textarea"
                        placeholder="Enter request (max 500 characters)"
                        v-model = "request_text"
                        ref="request_text"
                        ></textarea>
                      <div class="spacer-h-15"></div>

                      <form action="javascript:void(0)">
                        <label  class="download-popup__file-imitation">
                          <span class="text">{{request_attachment_title}}</span>
                          <input type="file" @change="get_file">
                          <svg class="icon svg-icon-file"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-file"></use> </svg>
                        </label>
                      </form>
                    </div>
                  </transition>

                  <div class="spacer-h-15"></div>

                  <label class="radio-imitation props-options">
                    <input type="radio" name="review" value="reshoot" v-model="request_type">
                    <span class="radio-imitation__view flex text-left">
                      <span class="radio-imitation__longtext valign-center">
                        <b>Re-shoot Photo  | <span class="marked">5 Business Days</span></b>
                         I’d like this photo to be re-shot with a new requirement (e.g. colour or arrangement)
                      </span>
                      <span class="radio-imitation__icon valign-center">
                        <span class="price-marker">{{currency_symbol}}{{theme_prices.reshoot}}</span>
                      </span>
                    </span>
                  </label>
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
                  <div class="clearfix stripe-card-block" v-show="request_type == 'reshoot'">
                    <div class="spacer-h-30"></div>
                    <label class="studio-content__label"><svg class="icon svg-icon-card"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-card"></use></svg>
                      Pay via Card
                    <img src="<?php echo THEME_URL; ?>/images/card.png" alt="" class="card-img"></label>
                    <div class="stripe-wrapper"></div>

                    <form id="payment-form" ref="payment_form">
                      <div id="card-element"><!--Stripe.js injects the Card Element--></div>
                      <p id="card-error" class="download-popup__text" role="alert"></p>

                      <div class="result-message"><a href="#"></a></div>
                      <input type="submit" value="submit" class="hidden" id="submit-btn">
                    </form>
                  </div><!-- stripe-card-block -->
                </transition>

                </div><!-- download-popup__row -->

                <div class="download-popup__row">
                  <div class="spacer-h-30"></div>
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
                    <div class="warning" v-if="request_type == 'correction'">Once you review is submitted, this photo will be locked and you’ll be unable to download until review is complete.</div>
                 </transition>
                  <div class="spacer-h-20"> </div>
                  <div class="download-popup__button-holder">
                    <a href="#" class="prev-step" v-on:click.prevent="position='step_1'"></a>


                    <a href="javascript:void(0)" class="download-popup__button not-active" v-show="!request_type">
                      <span>
                        <span class="">Submit</span>
                      </span>
                      <span class="arrow"></span>
                      <span class="spacer"></span>
                    </a>

                    <a href="javascript:void(0)" class="download-popup__button"
                      v-show="request_type == 'correction'"
                      :class="{'not-active': ( request_text.length == 0) }"
                      v-on:click="submit_review"
                    >
                      <span>
                        <span class="">Submit Review</span>
                      </span>
                      <span class="arrow"></span>
                      <span class="spacer"></span>
                    </a>

                    <a href="javascript:void(0)" class="download-popup__button"
                      v-show="request_type == 'reshoot'"
                      :class="{'not-active': (!card_inserted) }"
                      v-on:click="exec_stripe"
                    >
                      <span>
                        <span class="">Submit Payment</span>
                      </span>
                      <span class="arrow"></span>
                      <span class="spacer"></span>
                    </a>

                  </div>
                </div><!-- download-popup__row -->
              </div><!-- download-popup__content -->
            </transition>

            <transition
              v-bind:css="false"
              v-on:before-enter="beforeEnter"
              v-on:enter="enter_width"
              v-on:leave="leave_width"
              v-on:after-enter="enterAfter_width"
            >
              <div class="download-popup__content-inner" ref="step_3" v-show="position == 'step_3'">
                <div class="download-popup__row">
                  <span class="close" v-on:click="show=false"><svg class="icon svg-icon-close"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-close"></use> </svg>Close</span>
                </div>

                <div class="download-popup__row text-center">
                  <img src="<?php echo  THEME_URL; ?>/images/okay.svg" alt="">
                  <div class="spacer-h-10"></div>
                  <span class="download-popup__subtitle">Request Recieved</span>
                  <div class="spacer-h-15"></div>
                  <span class="download-popup__text">Thank you for submitting your review. Please allow up to 24 hours for us to approve your request.</span>
                </div>

                <div class="download-popup__row">
                  <div class="spacer-h-50"></div>
                </div>
              </div><!-- download-popup__content -->
            </transition>

            <transition
              v-bind:css="false"
              v-on:before-enter="beforeEnter"
              v-on:enter="enter_width"
              v-on:leave="leave_width"
              v-on:after-enter="enterAfter_width"
            >
              <div class="download-popup__content-inner" ref="step_4" v-show="position == 'step_4'">
                <div class="download-popup__row">
                  <span class="close" v-on:click="show=false"><svg class="icon svg-icon-close"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-close"></use> </svg>Close</span>
                </div>

                <div class="download-popup__row text-center">
                  <img src="<?php echo  THEME_URL; ?>/images/okay.svg" alt="">
                  <div class="spacer-h-10"></div>
                  <span class="download-popup__subtitle">Re-shoot Requested</span>
                  <div class="spacer-h-15"></div>
                  <span class="download-popup__text">Thank you for submitting your request.
                    You’ll find a new shoot for Order #FS-{{reshoot_order}} in your Brandhub.</span>
                </div>

                <div class="download-popup__row">
                  <div class="spacer-h-50"></div>
                </div>
              </div><!-- download-popup__content -->
            </transition>
          </div>
        </div>
      </div><!-- download-popup__window -->
    </div><!-- download-popup -->
  </transition>

<?php echo '</script>';  ?>
<style>
  #studio-content{
    transition: all .6s;
  }
</style>


<?php if (!isset($_GET['no_reload'])): ?>
<div class="content-fullheight load-page">
  <div class="load-page__content">
    <div class="spacer-h-20"></div>

    <img src="<?php echo THEME_URL; ?>/images/load.svg" class="load" alt="">
    <div class="spacer-h-40"></div>

    <div class="clearfix text-center">
      <span class="logo">
          <img src="<?php echo THEME_URL; ?>/images/logo.svg" class="logo__img" alt="">
          <span class="logo__studi">studi</span>
          <img src="<?php echo THEME_URL; ?>/images/circles.svg" class="logo__circles" alt="">
      </span>
    </div>

    <div class="load-progress progress" id="progress_div">
      <div class="inner" id="bar1"></div>
    </div>
    <input type="hidden" id="progress_width" value="0">

    <div class="load-comment"> If Studio doesn’t launch in 5 seconds, <br> please <a href="?product_id=<?php echo $_GET['product_id']?>&no_reload=yes">click here</a> to be redirected </div>

    <div class="spacer-h-60"></div>
  </div>
</div>
<?php endif ?>

<div class="visuallyhidden" id="studio-content">
  <div class="spacer-h-40"></div>
  <div class="container-lg">

  <div class="row">
    <div class="col-md-7 col-lg-5">
      <a href="#" v-if="step > 1" v-on:click.prevent="change_step('prev')" class="go-back"><svg class="icon svg-icon-back"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-back"></use> </svg> <span>Back</span></a>
      <div class="spacer-h-70"></div>
      <transition-group
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
        <!-- **************
               STEP 1
          *****************-->
        <div class="studio-content__page" v-show="step == 1" :key="'step-1'">
          <div class="spacer-h-20"></div>

          <?php if ($product_guid_url): ?>
          <div class="notification">
            <div class="notification__icon">
              <img src="<?php echo THEME_URL; ?>/images/hand.png" alt="">
            </div>
            <p class="notification__text">
              <b>Product Guidelines.</b> Please ensure your order meets <br> our <a href="<?php echo $product_guid_url ?>">Product Guidelines</a> to avoid any delays.
            </p>
          </div>
          <?php endif ?>
          <div class="spacer-h-20"></div>
          <h2 class="block-title">Build your shoot <br> with <?php echo $title; ?></h2>
          <div class="spacer-h-20"></div>
          <p class="regular-text">Get started by telling us which products you’d like to include in this shoot.</p>
          <div class="spacer-h-30"></div>

          <div class="studio-content__body">
            <label class="studio-content__label">
              <svg class="icon svg-icon-product"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-product"></use> </svg> Add your products
            </label>

            <transition-group
              name="product-name"
              tag="div"
              v-bind:css="false"
              v-on:before-enter="beforeEnter"
              v-on:enter="enter"
              v-on:leave="leave"
              v-on:after-enter="enterAfter"
              v-on:after-leave="leaveAfter"
            >
              <div v-for="product, key in products" :key="'product-name'+key" class="product-name-holder">
                <input type="text" class="input-field" placeholder="Your product name"
                 v-on:change="check_product_name(key, product.title)"
                 v-on:input="check_product_name(key, product.title)"
                 v-model="product.title" :ref="'product-name'">
                 <a href="#" class="remove" v-if="key > 0" v-on:click="remove_product(key)">×</a>
                <div class="spacer-h-20"></div>
              </div>
            </transition-group>
            <div class="text-left">
              <span class="studio-content__add" v-on:click.prevent="add_product_name()">Add another product</span>
              <span class="price-marker">+ £{{prices.name}}</span>
            </div>
          </div><!-- studio-content__page -->
        </div><!-- studio-content__page -->

        <!-- **************
             STEP 1 END
        *****************-->

        <!-- **************
             STEP 2
        *****************-->
        <div class="studio-content__page"   v-show="step == 2"  :key="'step-2'">
          <div class="spacer-h-20"></div>

          <div class="spacer-h-20"></div>
          <h2 class="block-title">How many photos would you like?</h2>
            <div class="spacer-h-20"></div>
          <p class="regular-text">You can choose any number of photos you’d like, with a minimum order of 3 photos.</p>
          <div class="spacer-h-30"></div>

          <div class="studio-content__body">
            <label class="studio-content__label">
              <svg class="icon svg-icon-number"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-number"></use> </svg> Select number of photos
              <span class="price-marker">£30 /photo</span>
            </label>

            <div class="spacer-h-20"></div>

            <div class="flex studio-content__numbers">
              <label class="radio-imitation studio-content__number">
                <input type="radio" name="count" v-model="image_count" value="3">
                <span class="radio-imitation__view">
                  <span class="radio-imitation__text">3</span>
                </span>
              </label>
              <label class="radio-imitation studio-content__number">
                <input type="radio" name="count" v-model="image_count" value="6">
                <span class="radio-imitation__view">
                  <span class="radio-imitation__text">6</span>
                </span>
              </label>
              <label class="radio-imitation studio-content__number">
                <input type="radio" name="count" v-model="image_count" value="9">
                <span class="radio-imitation__view">
                  <span class="radio-imitation__text">9</span>
                </span>
              </label>
              <div class="photo_count">
               <input type="text"  v-model="image_count" ref="image_count_input" v-on:click="image_count = 1"  >
              </div>
            </div>
          </div><!-- studio-content__page -->
        </div><!-- studio-content__page -->
        <!-- **************
             STEP 2 END
        *****************-->

      <!-- **************
             STEP 3
        *****************-->
        <div class="studio-content__page" v-show="step == 3"  :key="'step-3'">
          <div class="spacer-h-20"></div>
          <h2 class="block-title">Customise your shoot</h2>
          <div class="spacer-h-20"></div>

          <div class="studio-content__tabs">

            <span class="studio-content__tabs-item"
                  v-bind:class="{active:( customize_step == 1)}"
                  v-on:click.prevent="customize_step = 1"
                  >
              <svg class="icon svg-icon-custom"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-custom"></use> </svg>

              <span>color</span>
            </span>
            <span class="studio-content__tabs-item"
                  v-bind:class="{active:( customize_step == 2)}"
                  v-on:click.prevent="customize_step = 2"
                  >
             <svg class="icon svg-icon-position"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-position"></use> </svg>

              <span>position</span>
            </span>
            <span class="studio-content__tabs-item"
                  v-bind:class="{active:( customize_step == 3)}"
                  v-on:click.prevent="customize_step = 3"
                  >
             <svg class="icon svg-icon-glasess"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-glasess"></use> </svg>

              <span>props</span>
            </span>
            <span class="studio-content__tabs-item"
                  v-bind:class="{active:( customize_step == 4)}"
                  v-on:click.prevent="customize_step = 4"
                  >
             <svg class="icon svg-icon-resize"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-resize"></use> </svg>

              <span>Sizes</span>
            </span>
          </div>

          <div class="spacer-h-30"></div>

          <transition-group
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

            <div :key="'tab-3'" class="studio-content__body" v-show="customize_step == 3">
              <label class="studio-content__label">
                Would you like props?
                <span class="price-marker">Free</span>
              </label>
              <div class="spacer-h-20"></div>
              <label class="radio-imitation props-options">
                <input type="radio" name="props" value="none" v-model="customize.props">
                <span class="radio-imitation__view flex text-left">
                  <span class="radio-imitation__icon valign-center">
                    <svg class="icon svg-icon-mind"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-mind">
                  </span>

                  <span class="radio-imitation__longtext valign-center">
                    <b>I Don’t Mind (Recommended)</b> Keep it simple and let the photographer decide how your shot should be styled.
                  </span>
                </span>
              </label>

              <div class="spacer-h-20"></div>

              <label class="radio-imitation props-options">
                <input type="radio" name="props" value="Custom Props" v-model="customize.props">

                <span class="radio-imitation__view flex text-left">
                  <span class="radio-imitation__icon valign-center">
                    <svg class="icon svg-icon-product"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-product">
                  </span>

                  <span class="radio-imitation__longtext valign-center">
                    <b>I’ll Send Props</b>
                      Send your own preferred props in along with your products.
                  </span>
                </span>
              </label>
              <div class="spacer-h-30"></div>
              <div class="warning">
                Please check you’ve made all your customisations before continuing as you can’t make changes later.
              </div>
            </div><!-- studio-content__body -->

            <div :key="'tab-4'" class="studio-content__body"  v-show="customize_step == 4">
              <label class="studio-content__label">
                Additional photo sizes
                <span class="price-marker">£2/size</span>
              </label>
              <p class="regular-text">Default square size is free and included in your recipe.</p>

              <div class="spacer-h-20"></div>

              <div class="flex studio-content__numbers">
                <div class="radio-imitation studio-content__number">
                  <input type="checkbox" name="size" v-model="customize.sizes" value="squre" readonly>
                  <span class="radio-imitation__view text-center">
                    <span class="radio-imitation__longtext">
                      <span class="radio-imitation__size squre"></span>
                      <b>Square</b> 1:1
                    </span>
                  </span>
                </div>
                <label class="radio-imitation studio-content__number">
                  <input type="checkbox" name="size" v-model="customize.sizes" value="story">
                  <span class="radio-imitation__view text-center">
                    <span class="radio-imitation__longtext">
                      <span class="radio-imitation__size story"></span>
                      <b>Story </b> 9:16
                    </span>
                  </span>
                </label>
                <label class="radio-imitation studio-content__number">
                  <input type="checkbox" name="size" v-model="customize.sizes" value="wide">
                  <span class="radio-imitation__view text-center">
                    <span class="radio-imitation__longtext">
                      <span class="radio-imitation__size wide"></span>
                      <b>Wide</b> 3:2
                    </span>
                  </span>
                </label>
                <label class="radio-imitation studio-content__number">
                  <input type="checkbox" name="size" v-model="customize.sizes" value="full-hd">
                  <span class="radio-imitation__view text-center">
                    <span class="radio-imitation__longtext">
                      <span class="radio-imitation__size hd">
                        <svg class="icon svg-icon-hd"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-hd"></use> </svg>
                      </span>
                      <b>Full HD</b>Max Size
                    </span>
                  </span>
                </label>
              </div>

              <div class="spacer-h-30"></div>
              <div class="warning">
                Please check you’ve made all your customisations before continuing as you can’t make changes later.
              </div>
            </div><!-- studio-content__body -->


            <div :key="'tab-1'" class="studio-content__body" v-show="customize_step == 1">
              <label class="studio-content__label">
                Any colour preference?
                <span class="price-marker">+£5</span>
              </label>
              <p class="regular-text">The colours below are all the colours we have available and we’re unable to accept custom colour requests.</p>

              <div class="spacer-h-20"></div>

              <div class="horisontal-slider">
                <div class="color-switcher" <?php echo 'style="width:560px"';?>>
                  <label class="color-item">
                    <input type="radio" name="color" value="none" v-model="customize.color_pref">
                    <span class="color-item__border">
                      <span class="color-item__color">
                         <svg class="icon svg-icon-mind"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-mind">
                      </span>
                      <span class="color-item__title">I Don’t Mind</span>
                    </span>
                  </label><!-- color-item -->

                  <label class="color-item" v-for="color, key in colors" :key="'color-'+key">
                    <input type="radio" name="color"
                     :value="color.name"
                     v-model="customize.color_pref">
                    <span class="color-item__border">
                      <span class="color-item__color" :style="'background:'+ color.bg">
                      </span>
                      <span class="color-item__title">{{color.name}}</span>
                    </span>
                  </label><!-- color-item -->
                </div><!-- color-switcher -->
              </div>

              <div class="spacer-h-30"></div>

              <div class="warning">
                Please check you’ve made all your customisations before continuing as you can’t make changes later.
              </div>
            </div><!-- studio-content__body -->

            <div :key="'tab-2'" class="studio-content__body" v-show="customize_step == 2">
              <label class="studio-content__label">
                How shall we frame your shots?
                <span class="price-marker">Free</span>
              </label>
              <div class="spacer-h-20"></div>

              <div class="color-switcher">
                <label class="color-item sm">
                  <input type="radio" name="position" value="none" v-model="customize.position">
                  <span class="color-item__border">
                    <span class="color-item__color">
                       <svg class="icon svg-icon-mind"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-mind">
                    </span>
                    <span class="color-item__title">I Don’t Mind</span>
                  </span>
                </label><!-- color-item -->

                <label class="color-item sm">
                  <input type="radio" name="position" value="front on" v-model="customize.position">
                  <span class="color-item__border">
                    <span class="color-item__color" >
                    </span>
                    <span class="color-item__title">Front On</span>
                  </span>
                </label><!-- color-item -->

                <label class="color-item sm">
                  <input type="radio" name="position" value="cornered" v-model="customize.position">
                  <span class="color-item__border">
                    <span class="color-item__color" >
                    </span>
                    <span class="color-item__title">Cornered</span>
                  </span>
                </label><!-- color-item -->
              </div><!-- color-switcher -->

              <div class="spacer-h-30"></div>
              <div class="warning">
                Please check you’ve made all your customisations before continuing as you can’t make changes later.
              </div>
            </div><!-- studio-content__body -->

          </transition-group>
        </div>
        <!-- **************
             STEP 3 END
        *****************-->

        <!-- **************
             STEP 4
        *****************-->
        <div class="studio-content__page" :key="'step-4'" v-show="step==4">
          <div class="spacer-h-20"></div>
          <h2 class="block-title">Studio Notes</h2>
          <div class="spacer-h-20"></div>

           <p class="regular-text">Notes are a great way to communicate your vision with the photographer.</p>
          <div class="spacer-h-30"></div>

          <div class="studio-content__body">
            <label class="radio-imitation props-options">
              <input type="radio" name="notes" v-on:click="set_notes('simple')">
              <span class="radio-imitation__view flex text-left">

                <span class="radio-imitation__longtext valign-center">
                  <b> Quick Note</b>
                  Is there anything we should consider?
                </span>

                <span class="radio-imitation__icon valign-center">
                  <span class="price-marker">Free</span>
                </span>
                <span class="text-editor">
                  <textarea type="text" ref="simple_note" placeholder="E.g. Shoot product from the front" v-model="simple_note"></textarea>
                  <span class="counter">{{simple_note.length}}/140</span>
                </span>
              </span>
            </label>

            <div class="spacer-h-20"></div>

            <label class="radio-imitation props-options">
              <input type="radio" name="notes"  v-on:click="set_notes('custom')">

              <span class="radio-imitation__view flex text-left">

                <span class="radio-imitation__longtext valign-center">
                  <b>Custom Shot List</b> Specify which products should be shot together and how.
                </span>
                <span class="radio-imitation__icon valign-center">
                  <span class="price-marker">+ £9 /photo</span>
                </span>
              </span>
            </label>
          </div><!-- studio-content__body -->
        </div><!-- studio-content__page -->
        <!-- **************
             STEP 4 END
        *****************-->

        <!-- **************
             STEP 4 - 1
        *****************-->
        <div class="studio-content__page" :key="'step-custom'" v-show="step==5">
          <div class="spacer-h-20"></div>
          <h2 class="block-title">Custom Shot List</h2>
          <div class="spacer-h-20"></div>

           <p class="regular-text">Personalise your requirements for each shot.</p>

          <div class="studio-content__body">

          <transition-group
            name="notes-content"
            tag="div"
            v-bind:css="false"
            v-on:before-enter="beforeEnter"
            v-on:enter="enter"
            v-on:leave="leave"
            v-on:after-enter="enterAfter"
            v-on:after-leave="leaveAfter"
          >

            <div class="clearfix" v-for="notes, key in notes.data" :key="'note-blok'+key">
              <div class="spacer-h-30"></div>
              <label class="studio-content__label">
                <svg class="icon svg-icon-notes"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-notes"></use> </svg> Shot {{key + 1}}

                <a href="#" class="remove" v-if="key > 0" v-on:click="remove_note(key)">×</a>
              </label>
              <div class="spacer-h-10"></div>

              <product-select
                :_products = "products"
                :ref = "'notes-product'"
                v-on:change_value = 'change_value_cb($event, key)'
              ></product-select>

              <div class="spacer-h-20"></div>

              <input type="text" :ref = "'notes-text'" v-on:input="remove_error('notes-text', key, notes.text)" class="input-field" placeholder="Direction (max 140 characters)" v-model="notes.text">
            </div><!-- clearfix -->
          </transition-group>

            <div class="spacer-h-20"></div>
            <div class="text-center" v-if="notes.data.length < image_count">
              <span class="studio-content__add" v-on:click.prevent="add_note_custom" >Add another shot</span>
              <span class="price-marker">+ £9</span>
            </div>

            <div class="spacer-h-20"></div>
            <div class="warning">
              You have personalised {{notes.data.length}} of {{total_images}} photos. <span v-if="total_images > notes.data.length">The remaining {{total_images - notes.data.length}} photos will be left to the photographer’s creativity.</span>
            </div>

          </div><!-- studio-content__body -->
        </div><!-- studio-content__page -->
        <!-- **************
             STEP 4 - 1END
        *****************-->


        <!-- **************
             STEP 5
        *****************-->
        <div class="studio-content__page" :key="'step-6'"  v-show="step==6">
          <div class="spacer-h-20"></div>
          <h2 class="block-title">Turnaround time</h2>
          <div class="spacer-h-20"></div>
          <label class="studio-content__label">
            <svg class="icon svg-icon-flash"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-flash"></use> </svg> How fast do you want your photos?
          </label>
          <div class="spacer-h-10"></div>

          <div class="studio-content__body">
            <label class="radio-imitation props-options">
              <input type="radio" name="turnaround" value="regular" v-model="turnaround">
              <span class="radio-imitation__view flex text-left">

                <span class="radio-imitation__longtext valign-center">
                  <b>10 Business Days</b> From when we receive your products
                </span>

                <span class="radio-imitation__icon valign-center">
                  <span class="price-marker">Free</span>
                </span>
              </span>
            </label>

            <div class="spacer-h-20"></div>

            <label class="radio-imitation props-options">
              <input type="radio" name="turnaround" value="fasttrack" v-model="turnaround">
              <span class="radio-imitation__view flex text-left">
                <span class="radio-imitation__longtext valign-center">
                  <span class="fasttrack">
                    <svg class="icon svg-icon-flash"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-flash"></use> </svg>
                    FAST TRACK
                  </span>
                  <b class="spacer-h-20"></b>
                  <b>3 Business Days</b>From when we receive your products
                </span>
                <span class="radio-imitation__icon valign-center">
                  <span class="price-marker">+ £{{prices.fasttrack}}</span>
                </span>
              </span>
            </label>
          </div><!-- studio-content__body -->
        </div><!-- studio-content__page -->

        <!-- **************
             STEP 5 END
        *****************-->

        <!-- **************
             STEP 6
        *****************-->
        <div class="studio-content__page" :key="'step-7'" v-show="step==7">
          <div class="spacer-h-20"></div>
          <h2 class="block-title">Finalise your shoot</h2>
          <div class="spacer-h-20"></div>
          <label class="studio-content__label">
            <svg class="icon svg-icon-handling"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-handling"></use> </svg> How should we handle your product?
          </label>
          <div class="spacer-h-10"></div>

          <div class="studio-content__body">
            <label class="radio-imitation props-options">
              <input type="radio" name="handling"  value="discard" v-model="handling.handle">
              <span class="radio-imitation__view flex text-left">

                <span class="radio-imitation__longtext valign-center">
                  <b>Discard Products </b>Once shoot is completeds
                </span>

                <span class="radio-imitation__icon valign-center">
                  <span class="price-marker">Free</span>
                </span>
              </span>
            </label>

            <div class="spacer-h-20"></div>

            <label class="radio-imitation props-options">
              <input type="radio" name="handling" value="return" v-model="handling.handle">
              <span class="radio-imitation__view flex text-left">
                <span class="radio-imitation__longtext valign-center">
                  <b>Return Products</b> Once shoot is completeducts
                </span>
                <span class="radio-imitation__icon valign-center">
                  <span class="price-marker">+ £{{prices.handle}}</span>
                </span>
              </span>
            </label>
          </div><!-- studio-content__body -->

          <div class="spacer-h-20"></div>

          <label class="studio-content__label">
            <svg class="icon svg-icon-helm"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-helm"></use> </svg> Send Products Via
          </label>

          <div class="spacer-h-10"></div>

          <div class="flex-row">
            <label class="radio-imitation props-options col-1-2">
              <input type="radio" name="sendvia" value="self" v-model="handling.send">
              <span class="radio-imitation__view flex text-center">
                <span class="radio-imitation__longtext">
                  <b>Self Ship</b>WorldWide
                </span>
              </span>
            </label>
            <label class="radio-imitation props-options col-1-2 not-act">
           <?php /*   <input type="radio" name="sendvia" value="free" v-model="handling.send"> */?>
              <span class="radio-imitation__view flex text-center">
                <span class="radio-imitation__longtext">
                  <b>Free Collection * </b>Not available in city
                </span>
              </span>
            </label>
          </div>

          <div class="spacer-h-20"></div>

          <p class="regular-text">* Free Collection requires access to a printer so you can print the postage label we provide you with.</p>
        </div><!-- studio-content__page -->
        <!-- **************
             STEP 6 END
        *****************-->


        <!-- **************
             STEP 7
        *****************-->
        <div class="studio-content__page" :key="'step-8'"  v-show="step==8">
          <div class="secure-checkout"><svg class="icon svg-icon-lock"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-lock"></use> </svg> Secure Checkout</div>
          <div class="spacer-h-20"></div>
          <h2 class="block-title">Review & pay</h2>
          <div class="spacer-h-20"></div>
          <p class="regular-text">Everything looks good! Check your Shoot Summary and place your order below.</p>
          <div class="spacer-h-30"></div>

          <div class="spacer-h-20"></div>

          <?php /*

          <div class="card-selector">
            <div class="card-data">
              <span class="card-data__value">
                <img src="assets/images/visa.png" alt=""> •••• 3648
              </span>
              <span class="card-data__comment">Acme, Brook Business Centre</span>

              <svg class="icon svg-icon-corner-down"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-corner-down"></use> </svg>
            </div>

          </div><!-- card-selector -->
        */?>

         <form enctype="multipart/form-data" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" method="POST" id="checkout_form"  name="checkout" method="post" class="checkout woocommerce-checkout" >



          <?php

            foreach ( $gateways as $gateway ) {
              wc_get_template( 'checkout/payment-method.php', array( 'gateway' => $gateway, 'count' => count( $gateways ) ) );
            }
          ?>
          <?php  wp_nonce_field( 'woocommerce-process_checkout', 'woocommerce-process-checkout-nonce' ); ?>

          <div class="spacer-h-10"></div>
          <input type="text" class="input-field" placeholder="Contact Number" name="contact">
          <div class="spacer-h-10"></div>
          <input type="text" class="input-field" placeholder="Coupon Code" name="coupon">
        </form>

          <div class="spacer-h-30"></div>


          <div class="warning">
            <b>Photo Re-do’s</b>
            We allow free re-do’s of photos if we either misread your requirements or if any blemish needs editing. If you require anything else changed, it will be paid.
          </div>

          <div class="spacer-h-30"></div>

          <div class="regular-text sm">By placing an order with Feedsauce, you agree to the website <a href="<?php echo $terms_page_url ?>">Terms & Conditions</a>

          <?php if ($redo_policy_url): ?>
            , our <a  href="<?php echo $redo_policy_url ?>"> Redo Policy</a>
          <?php endif ?>
          <?php if ($product_guid_url): ?>
           and verify that your product meets <a href="<?php echo $product_guid_url ?>">Feedsauce’s Product Guidelines</a>
          <?php endif ?>
          </div>
          <div class="spacer-h-20"></div>
        </div><!-- studio-content__page -->
        <!-- **************
             STEP 5 END
        *****************-->
      </transition-group>
      <div class="studio-content__button-holder">
        <transition
          v-bind:css="false"
          v-on:before-enter="beforeEnter"
          v-on:enter="enter"
          v-on:leave="leave"
          v-on:after-enter="enterAfter"
          v-on:after-leave="leaveAfter"
        >
        <a href="javascript:void(0)" class="studio-content__button" v-if="step != 8"  v-on:click.prevent="change_step('next')">{{button_text}}</a>
        </transition>

        <transition
          v-bind:css="false"
          v-on:before-enter="beforeEnter"
          v-on:enter="enter"
          v-on:leave="leave"
          v-on:after-enter="enterAfter"
          v-on:after-leave="leaveAfter"
        >
        <a href="javascript:void(0)" class="studio-content__button green" v-if="step == 8"  v-on:click.prevent="place_order">£{{order_total.total}} - Place Order</a>

        </transition>
        <transition
          v-bind:css="false"
          v-on:before-enter="beforeEnter"
          v-on:enter="enter"
          v-on:leave="leave"
          v-on:after-enter="enterAfter"
          v-on:after-leave="leaveAfter"
        >
        <a href="#" class="studio-content__cancel" v-if="step == 4 && !!notes.data" v-on:click.prevent="change_step(6)">Skip Notes</a>
        </transition>
      </div>
      <div class="spacer-h-150"></div>
    </div><!-- col-md-7 valign-center -->

    <div class="col-md-5 col-lg-5 offset-lg-2 col-xl-4 offset-xl-3">
      <div class="shoot-steps">
        <div class="shoot-steps__header" <?php echo 'style="background-color: '.$bg_color.'"'; ?> >
          <div class="row no-gutters">
            <div class="col-6 valign-center"  <?php echo 'style="z-index: 10"'; ?>>
              <h2 class="title"><?php echo $title; ?></h2>
              <p class="text">Shoot Summary</p>
            </div>
            <div class="col-6">
              <img src="<?php echo $img_url ?>" class="shoot-steps__img" alt="">
            </div>
          </div>
        </div><!-- shoot-steps__header -->

        <div class="summary">
          <div class="summary__body">
            <table class="summary__content">
              <tbody>
                <tr :class="{active: (step == 1)}" v-on:click="change_step(1)">
                  <td><svg class="icon svg-icon-product"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-product"></use> </svg></td>
                  <td>
                    <p class="summary__content-label">Products</p>
                    <p class="summary__content-text">{{names_str}}</p>
                  </td>
                  <td>
                  </td>
                  <td>
                     <p class="summary__content-price">£{{order_total.product_names}}</p>
                  </td>
                </tr>
                <tr  :class="{active: (step == 2)}"  v-on:click="change_step(2)">
                  <td><svg class="icon svg-icon-number"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-number"></use> </svg></td>
                  <td>
                    <p class="summary__content-label">Number of Photos</p>
                    <p class="summary__content-text">{{total_images}}</p>
                  </td>
                  <td>
                  </td>
                  <td>
                     <p class="summary__content-price">£{{order_total.image_count}}</p>
                  </td>
                </tr>
                <tr  :class="{active: (step == 3)}"  v-on:click="change_step(3)">
                  <td><svg class="icon svg-icon-custom"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-custom"></use> </svg></td>
                  <td>
                    <p class="summary__content-label">Customise</p>
                    <p class="summary__content-text">{{customize_text}}</p>
                  </td>
                  <td>
                  </td>
                  <td>
                     <p class="summary__content-price">£{{order_total.customize}}</p>
                  </td>
                </tr>
                <tr  :class="{active: (step == 4 || step == 5  )}"   v-on:click="change_step(4)">
                  <td><svg class="icon svg-icon-notes"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-notes"></use> </svg></td>
                  <td>
                    <p class="summary__content-label">Studio Notes</p>
                    <p class="summary__content-text">{{this.notes.title}}</p>
                  </td>
                  <td>
                  </td>
                  <td>
                     <p class="summary__content-price">£{{order_total.shoots}}</p>
                  </td>
                </tr>
                <tr  :class="{active: (step == 6)}"   v-on:click="change_step(6)">
                  <td><svg class="icon svg-icon-flash"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-flash"></use> </svg></td>
                  <td>
                    <p class="summary__content-label">Turnaround Time</p>
                    <p class="summary__content-text">{{turnaround_text}}</p>
                  </td>
                  <td>
                  </td>
                  <td>
                     <p class="summary__content-price">£{{order_total.turnaround}}</p>
                  </td>
                </tr>
                <tr  :class="{active: (step == 7)}"   v-on:click="change_step(7)">
                  <td><svg class="icon svg-icon-handling"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-handling"></use> </svg></td>
                  <td>
                    <p class="summary__content-label">Handling</p>
                    <p class="summary__content-text">{{handling_text}}</p>
                  </td>
                  <td>
                  </td>
                  <td>
                     <p class="summary__content-price">£{{order_total.handling}}</p>
                  </td>
                </tr>
              </tbody>
              <tfoot>
                <tr>
                  <td colspan="4"><span class="summary__label">Summary</span></td>
                </tr>
                <tr>
                  <td colspan="2">Subtotal</td>
                  <td colspan="2">£{{order_total.subtotal}}</td>
                </tr>
                <tr>
                  <td colspan="2">Add-Ons</td>
                  <td colspan="2">£{{order_total.addons}}</td>
                </tr>
                <tr>
                  <td colspan="2">Discount</td>
                  <td colspan="2">£0</td>
                </tr>
                <tr>
                  <td colspan="2"><span class="summary__label">Order total</span></td>
                  <td colspan="2"><span class="summary__total">£{{order_total.total}}</span></td>
                </tr>

              </tfoot>
            </table>
          </div>
        </div><!-- summary -->

        <p class="terms">By placing an order with Feedsauce, you agree to the website <a href="<?php echo $terms_page_url ?>">Terms & Conditions</a>

          <?php if ($redo_policy_url): ?>
            , our <a  href="<?php echo $redo_policy_url ?>"> Redo Policy</a>
          <?php endif ?>
          <?php if ($product_guid_url): ?>
           and verify that your product meets <a href="<?php echo $product_guid_url ?>">Feedsauce’s Product Guidelines</a>
          <?php endif ?>
        </p>
      </div>
    </div>
  </div><!-- row -->
  </div>
</div>

<div class="spacer-h-30"></div>

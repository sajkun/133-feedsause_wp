
<?php $helper = new theme_formatted_cart(); ?>

<div class="product-attribute-sidebar edit-item" id="edit-cart-item">
  <input type="hidden" value="<?php echo get_woocommerce_currency_symbol() ?>" ref="currency_symbol">

  <input type="hidden" value='<?php echo json_encode($helper->get_items())?>' ref="cart_initial_data">

  <div class="inner">
    <div class="inner__body">
      <a href="#" class="return-link hide_product-attribute-sidebar"><svg class="icon svg-icon-arrowr"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-arrowr"></use> </svg>Review Order</a>

      <h3 class="product-attribute-sidebar__title">{{recipe_name}}</h3>

        <form action="javascript:void(0)" method="POST" @submit.prevent v-on:submit="update_cart_item">
          <p class="single-recipe__label">
            <svg class="icon svg-icon-box"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-box"></use> </svg>
            <b>Add Your Products</b>
          </p>

          <transition-group
            name="product-instance-options"
            tag="div"
            v-bind:css="false"
            v-on:before-enter="beforeEnter"
            v-on:enter="enter"
            v-on:leave="leave"
            v-on:after-enter="enterAfter"
            v-on:after-leave="leaveAfter"
          >
            <div class="product-instance-options"  v-for="(product, index) in found_products" :key="index" :ref="'instance'">

              <div class="clearfix">
                <text-input v-bind:_id="index" v-on:product_name_changed="update_product_name($event, index)" v-bind:class="'single-recipe__item-name'" v-model="product.name" :ref="'name'"></text-input>
              </div>

              <div v-for="(attribute, attribute_name) in attributes_data" :key="attribute_name">
                <p class="single-recipe__label" v-if="attribute.name">
                  <span v-html="attribute.name"></span>
                </p>

                <div class="row gutters-10 justify-content-between" :ref="'attribute_'+attribute_name">

                  <product-option
                  v-for="(option, option_id) in attribute.items"
                  :key="option_id"
                  :_is_checked="get_checked(option.slug, product.attributes['attribute_'+attribute_name])"
                  v-bind:_id ="index"
                  :_option_text="option.name"
                  v-model="product.attributes['attribute_'+attribute_name]"
                  :_option_value="option.slug"
                  :_option_name="'attribute_'+attribute_name"
                  v-on:update_input_value="update_product($event, index, 'attribute_'+ attribute_name)"></product-option>


                </div><!-- row -->
                <div class="spacer-h-10"></div>
                <div class="spacer-h-10"></div>
              </div>
              <transition
                v-bind:css="false"
                v-on:before-enter="beforeEnter"
                v-on:enter="enter"
                v-on:leave="leave"
                v-on:after-enter="enterAfter"
                v-on:after-leave="leaveAfter"
               >
                <div class="woocommerce-notices-wrapper" v-if="product.alert_variations_no_select || product.alert_name || product.alert_variations_not_found || product.alert_name_duplicate">
                  <transition-group
                    name="errors-list"
                    tag="ul"
                    class="woocommerce-error-alt"
                    role="alert"
                    v-bind:css="false"
                    v-on:before-enter="beforeEnter"
                    v-on:enter="enter"
                    v-on:leave="leave"
                    v-on:after-enter="enterAfter"
                    v-on:after-leave="leaveAfter"
                  >
                      <li v-for="(error, error_index) in errors" v-if="product[error_index]" :key="error_index">{{error}}</li>
                  </transition-group>
                </div>
              </transition>
            </div><!-- product-instance-options -->
          </transition-group>

          <div class="clearfix">
            <a href="javascript:void(0)" v-on:click="add_new_product" class="trigger-add">[+]  Add Another Product</a>
          </div>
          <div class="spacer-h-10"></div>
          <div class="spacer-h-10"></div>
          <div class="single-recipe__hr"></div>

          <p class="single-recipe__label">
            <svg class="icon svg-icon-size"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-size"></use> </svg>
            <b>Sizes</b>
          </p>

          <div class="row gutters-10 justify-content-between" id="row-sizes">
            <div class="col-6 col-md-3">
              <label class="single-recipe__option">
                <input type="checkbox" name="sizes" :value="'Square'" v-model="sizes" :checked="sizes">
                <span class="single-recipe__option-view">
                  <span class="size-view-icon"><span class="inner-view view-square"></span></span>
                  <span class="title">Square</span>
                  <span class="price">1:1</span>
                </span>
              </label>
            </div><!-- col -->

            <div class="col-6 col-md-3">
              <label class="single-recipe__option">
                <input type="checkbox" name="sizes" :value="'Story'" v-model="sizes" :checked="sizes">
                <span class="single-recipe__option-view">
                  <span class="size-view-icon"><span class="inner-view view-story"></span></span>
                  <span class="title">Story</span>
                  <span class="price">9:16</span>
                </span>
              </label>
            </div><!-- col -->

            <div class="col-6 col-md-3">
              <label class="single-recipe__option">
                <input type="checkbox" name="sizes" :value="'Wide'" v-model="sizes" :checked="sizes">
                <span class="single-recipe__option-view">
                  <span class="size-view-icon "><span class="inner-view view-wide"></span></span>
                  <span class="title">Wide</span>
                  <span class="price">3:2</span>
                </span>
              </label>
            </div><!-- col -->

            <div class="col-6 col-md-3">
              <label class="single-recipe__option">
                <input type="checkbox" name="sizes" v-model="sizes" :value="'Full HD'" :checked="sizes">
                <span class="single-recipe__option-view">
                  <span class="size-view-icon "><span class="inner-view view-full-hd"></span></span>
                  <span class="title">Full HD</span>
                  <span class="price">Max Size</span>
                </span>
              </label>
            </div><!-- col -->
          </div>
          <div class="spacer-h-10"></div>
          <div class="spacer-h-10"></div>
          <transition
            v-bind:css="false"
            v-on:before-enter="beforeEnter"
            v-on:enter="enter"
            v-on:leave="leave"
            v-on:after-enter="enterAfter"
            v-on:after-leave="leaveAfter"
           >
          <div class="woocommerce-notices-wrapper" v-if="sizes_alert">
            <ul class="woocommerce-error-alt">
              <li> Please select at least 1 size. </li>
            </ul>
          </div>
          </transition>
          <div class="single-recipe__hr"></div>

          <p class="single-recipe__label">
            <svg class="icon svg-icon-pen"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-pen"></use> </svg>
            <b>Anything else we should know?</b>
          </p>

          <textarea name="comment" v-model="comment" class="single-recipe__comment" placeholder="e.g. Only shoot the product from front angle"></textarea>


        <button type="submit" class="my-cart__button">{{total_summ}} Update Order</button>
      </form>
    </div><!-- inner__body -->

  </div><!-- inner -->
</div><!-- product-attribute-sidebar -->

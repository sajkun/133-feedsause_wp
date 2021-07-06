<?php
if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}
echo '<script type="text/x-template" id="studio-single-content">';
?>

  <div class="container-fluid" v-if="visible">
    <div class="row full-height">
      <div class="col-4 col-12 col-lg-4 limited-width-400">
        <!-- ******************************
        ********** ORDER DATA ***********
        *********************************-->

          <div class="spacer-h-40"></div>

          <!--************************
          ******** order details* old*****-->

          <div class="leads-block" v-if="!shoot_data_set">
            <div class="row no-gutters">
              <div class="col-5">
                <h2 class="leads-block__title">
                  <svg class="icon svg-icon-order"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-order"></use> </svg>
                  Order
                </h2>
              </div>
              <div class="col-7 text-right">
                <div class="span order-status">
                  <i class="icon" v-bind:style="{backgroundColor: column_data.color}"></i>
                  <span class="order-status__text">{{column_data.status}}</span>
                </div>
              </div>
            </div>
            <div class="hr"></div>
             <div class="leads-block__row">
              <div class="leads-block__name">
                <h1 class="block-title">Order #{{order_data.order_id}}</h1>
                <span class="leads-block__comment" v-if="order_data.order.date">Paid on {{order_data.order.date}}</span>
              </div>
            </div><!-- leads-block__row -->

            <div class="hr"></div>

            <div class="products-block">
              <div class="products-block__item" v-for="(item, key) in order_data.order.items" :key="'items_'+key">
                <div class="products-block__item-head row">
                  <div class="col-4">
                   <span class="products-block__item-title"> {{item.product_name}}</span>
                  </div>

                  <div class="col">
                    {{item.image_count}}
                  </div>

                  <div class="col-1 text-right">
                    <span class="trigger " v-on:click="expand_product(key)">[ <span class="trigger__symbol" v-bind:class="{expanded: item.expanded}"></span> ]</span>
                  </div>
                </div>
                <transition
                  v-on:before-enter="animation_beforeEnter"
                  v-on:animation-after="animation_enterAfter"
                  v-on:enter="animation_enter"
                  v-on:leave="animation_leave"
                  v-bind:css="false"
                >
                  <div class="products-block__item-body" v-if="item.expanded">
                    <div class="row">
                      <div class="col-4">Product</div>
                      <div class="col-8">{{item.title}}</div>
                    </div>
                    <div class="row" v-if="item.sizes">
                      <div class="col-4">Sizes</div>
                      <div class="col-8">{{item.sizes.join(', ')}}</div>
                    </div>
                    <div class="row">
                      <div class="col-4">Note</div>
                      <div class="col-8"> {{item.notes}}</div>
                    </div>
                  </div>
                </transition>
              </div>

              <div class="products-block__item" v-for="(item, key) in order_data.order.fee" :key="key">
                <div class="products-block__item-head row">
                  <div class="col-4">
                   <span class="products-block__item-title"> {{item.fee_name}}</span>
                  </div>
                  <div class="col-1 text-right">
                  </div>
                </div>
              </div>
            </div>

            <div class="leads-block__row">
              <table class="leads-block__data">
                <tbody>
                  <tr>
                    <td><p class="leads-block__label no-margin">Brand</p></td>
                    <td  class="width-150">
                      <span class="leads-block__text no-margin"> {{order_data.customer.brand}} </span>
                    </td>
                    <td>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <p class="leads-block__label no-margin">Turnaround</p>
                    </td>
                    <td class="width-150">
                      <p class="leads-block__text no-margin" v-if="turnaround !='Fast Track' && turnaround !='Fasttrack'">{{turnaround}}</p>
                      <div class="tag-fasttrack" v-if="turnaround =='Fast Track' || turnaround =='Fasttrack'">
                        <svg class="icon svg-icon-fastrack2"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-fastrack2"></use> </svg>
                        <span>fast track</span>
                      </div>
                    </td>
                    <td>
                    </td>
                  </tr>
                  </tr>
                </tbody>
              </table>
            </div><!-- leads-block__row -->
          </div><!-- leads-block -->

          <!--*****end order details old******
          **************************-->

          <div class="leads-block" v-if="shoot_data_set">
            <div class="shoot-steps">
              <div class="spacer-h-10"></div>
              <h2 class="leads-block__title"> Order Details</h2>
              <div class="shoot-steps__header">
                <h2 class="title"  v-if="order_data.order_items_data.is_reshoot != '1'">
                    {{order_data.order_items_data.product_name}}
                </h2>
                <h2 class="title"  v-if="order_data.order_items_data.is_reshoot === '1'">
                  Re-shoot
                </h2>
              <span class="comment">#FS-{{order_data.order_id}} on  {{order_data.order.date}}</span>

              <div class="spacer-h-30"></div>
              <span class="warning-due"><img src="<?php echo THEME_URL?>/order_tracker/assets/images/warn.png" alt="">Please ensure you have read all of the order requirements.
                  </span>
              </div><!-- shoot-steps__header -->
              <div class="summary">
                <div class="summary__body">
                  <table class="summary__content">
                    <tbody v-if="order_data.order_items_data.shoot_data">
                      <tr :class="{'expanded-tr': show_product_details.names}">
                        <td> <div class="step-label  trigger-expand" v-on:click=" show_product_details.names = !show_product_details.names">
                            <svg class="icon svg-icon-product">
                              <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-product"></use>
                            </svg>
                            <span class="step-label__text">Products</span>
                          </div> </td>

                        <td> <p class="summary__content-text"> {{product_names.name}}  <span class="addon" v-if="(product_names.items.length - 1) > 0"> + {{product_names.items.length - 1}}</span> </p> </td>

                        <td class="price-td no-shift">
                          <i class="trigger-expand" v-on:click=" show_product_details.names = !show_product_details.names" :class="{'expanded': show_product_details.names}">
                            <svg  width="46" height="46" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:avocode="https://avocode.com/" viewBox="0 0 46 46"><defs></defs><desc>Generated with Avocode.</desc><g><g clip-path="url(#clip-F41AE82F-F655-4B7A-8911-124D6B464325)"><title>Path</title><path d="M28.88972,20.11213c-0.14705,-0.14951 -0.38562,-0.14951 -0.53267,0l-3.85685,4.28085v0l-3.85724,-4.28085c-0.14705,-0.14951 -0.38563,-0.14951 -0.53268,0c-0.14704,0.1495 -0.14704,0.39197 0,0.54145l4.10445,4.55554c0.0784,0.07969 0.18268,0.11383 0.28509,0.10853c0.10277,0.0053 0.20669,-0.02884 0.28509,-0.10853l4.10482,-4.55594c0.14703,-0.14947 0.14703,-0.39155 -0.00001,-0.54105z" fill="#6f7894" fill-opacity="1"></path><path d="M28.88972,20.11213c-0.14705,-0.14951 -0.38562,-0.14951 -0.53267,0l-3.85685,4.28085v0l-3.85724,-4.28085c-0.14705,-0.14951 -0.38563,-0.14951 -0.53268,0c-0.14704,0.1495 -0.14704,0.39197 0,0.54145l4.10445,4.55554c0.0784,0.07969 0.18268,0.11383 0.28509,0.10853c0.10277,0.0053 0.20669,-0.02884 0.28509,-0.10853l4.10482,-4.55594c0.14703,-0.14947 0.14703,-0.39155 -0.00001,-0.54105z" fill-opacity="0" fill="#ffffff" stroke-linejoin="miter" stroke-linecap="butt" stroke-opacity="1" stroke="#6d7797" stroke-miterlimit="20" stroke-width="2"></path></g></g></svg>
                          </i>
                        </td>
                      </tr>
                      <tr class="resert-cells">
                        <td colspan="3" class="text-left">

                         <transition
                            v-on:before-enter="animation_beforeEnter"
                            v-on:animation-after="animation_enterAfter"
                            v-on:enter="animation_enter"
                            v-on:leave="animation_leave"
                            v-bind:css="false"
                          >
                          <div class="details" data-parent="products" v-show="show_product_details.names">
                            <table>
                              <tbody><tr v-for="item, key in product_names.items" :key="'product_name_'+key">
                                <td class="limit-width"><svg class="icon svg-icon-product">
                                    <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-product"></use>
                                    </svg><span class="item-title">{{item.category}}</span></td>
                                <td><span class="item-details">{{item.name}}</span>

                                </td>
                              </tr>
                            </tbody></table>
                          </div>
                        </transition>
                        </td>
                      </tr>

                      <tr>
                        <td> <div class="step-label no-hover">
                            <svg class="icon svg-icon-images-3">
                              <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href=" #svg-icon-images-3"></use>
                            </svg>
                            <span class="step-label__text">Photos</span>
                          </div> </td>

                        <td > <p class="summary__content-text">{{count_photos}}</p> </td>
                        <td class="price-td"></td>
                      </tr>

                      <tr :class="{'expanded-tr': show_product_details.custom}">
                        <td> <div class="step-label trigger-expand"  v-on:click="show_product_details.custom = !show_product_details.custom"> <svg class="icon svg-icon-custom">
                              <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-custom"></use>
                            </svg>
                            <span class="step-label__text">Customise</span>
                          </div> </td>
                       <td class="active"> <p class="summary__content-text">{{count_customisations}}</p> </td>

                       <td class="price-td no-shift">
                          <i class="trigger-expand" v-on:click="show_product_details.custom = !show_product_details.custom" :class="{'expanded': show_product_details.custom}">
                            <svg  width="46" height="46" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:avocode="https://avocode.com/" viewBox="0 0 46 46"><defs></defs><desc>Generated with Avocode.</desc><g><g clip-path="url(#clip-F41AE82F-F655-4B7A-8911-124D6B464325)"><title>Path</title><path d="M28.88972,20.11213c-0.14705,-0.14951 -0.38562,-0.14951 -0.53267,0l-3.85685,4.28085v0l-3.85724,-4.28085c-0.14705,-0.14951 -0.38563,-0.14951 -0.53268,0c-0.14704,0.1495 -0.14704,0.39197 0,0.54145l4.10445,4.55554c0.0784,0.07969 0.18268,0.11383 0.28509,0.10853c0.10277,0.0053 0.20669,-0.02884 0.28509,-0.10853l4.10482,-4.55594c0.14703,-0.14947 0.14703,-0.39155 -0.00001,-0.54105z" fill="#6f7894" fill-opacity="1"></path><path d="M28.88972,20.11213c-0.14705,-0.14951 -0.38562,-0.14951 -0.53267,0l-3.85685,4.28085v0l-3.85724,-4.28085c-0.14705,-0.14951 -0.38563,-0.14951 -0.53268,0c-0.14704,0.1495 -0.14704,0.39197 0,0.54145l4.10445,4.55554c0.0784,0.07969 0.18268,0.11383 0.28509,0.10853c0.10277,0.0053 0.20669,-0.02884 0.28509,-0.10853l4.10482,-4.55594c0.14703,-0.14947 0.14703,-0.39155 -0.00001,-0.54105z" fill-opacity="0" fill="#ffffff" stroke-linejoin="miter" stroke-linecap="butt" stroke-opacity="1" stroke="#6d7797" stroke-miterlimit="20" stroke-width="2"></path></g></g></svg>
                          </i>
                         </td>
                      </tr>

                      <tr class="resert-cells">
                        <td colspan="3" class="text-left">
                         <transition
                            v-on:before-enter="animation_beforeEnter"
                            v-on:animation-after="animation_enterAfter"
                            v-on:enter="animation_enter"
                            v-on:leave="animation_leave"
                            v-bind:css="false"
                          >
                            <div class="details" v-if="show_product_details.custom">
                              <table>
                                <tbody><tr>
                                  <td class="limit-width"><svg class="icon svg-icon-custom">
                                      <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-custom"></use>
                                      </svg><span class="item-title">Theme</span></td>
                                  <td>
                                    <span class="item-details">{{customisation_data.theme}}</span>
                                </td>
                                </tr>
                                <tr>
                                  <td class="limit-width"><svg class="icon svg-icon-position">
                                      <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-position"></use>
                                      </svg><span class="item-title">Position</span></td>
                                  <td> <span class="item-details">{{customisation_data.position}}</span> </td>
                                </tr>
                                <tr>
                                  <td class="limit-width"><svg class="icon svg-icon-glasess">
                                      <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-glasess"></use>
                                      </svg><span class="item-title">Props</span></td>
                                  <td><span class="item-details">{{customisation_data.props}}</span></td>
                                </tr>
                                <tr>
                                  <td class="limit-width"><svg class="icon svg-icon-resize">
                                      <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-resize"></use>
                                      </svg><span class="item-title">Sizes</span></td>
                                  <td><span class="item-details">{{customisation_data.sizes}}</span></td>
                                </tr>
                              </tbody></table>
                            </div>
                          </transition>
                        </td>
                      </tr>

                      <tr  :class="{'expanded-tr': show_product_details.notes}">
                        <td> <div class="step-label"  v-on:click="show_product_details.notes = !show_product_details.notes" :class="{'trigger-expand' : notes_label == 'Quick Notes'}" >
                            <svg class="icon svg-icon-notes">
                              <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-notes"></use>
                            </svg>
                            <span class="step-label__text">Studio Notes</span>
                          </div> </td>

                        <td> <p class="summary__content-text"> {{notes_label}} </p> </td>

                        <td class="price-td no-shift">
                          <i class="trigger-expand" v-if="notes_label !='-'" v-on:click="show_product_details.notes = !show_product_details.notes" :class="{'rotated': show_product_details.notes}">
                            <svg  width="46" height="46" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:avocode="https://avocode.com/" viewBox="0 0 46 46"><defs></defs><desc>Generated with Avocode.</desc><g><g clip-path="url(#clip-F41AE82F-F655-4B7A-8911-124D6B464325)"><title>Path</title><path d="M28.88972,20.11213c-0.14705,-0.14951 -0.38562,-0.14951 -0.53267,0l-3.85685,4.28085v0l-3.85724,-4.28085c-0.14705,-0.14951 -0.38563,-0.14951 -0.53268,0c-0.14704,0.1495 -0.14704,0.39197 0,0.54145l4.10445,4.55554c0.0784,0.07969 0.18268,0.11383 0.28509,0.10853c0.10277,0.0053 0.20669,-0.02884 0.28509,-0.10853l4.10482,-4.55594c0.14703,-0.14947 0.14703,-0.39155 -0.00001,-0.54105z" fill="#6f7894" fill-opacity="1"></path><path d="M28.88972,20.11213c-0.14705,-0.14951 -0.38562,-0.14951 -0.53267,0l-3.85685,4.28085v0l-3.85724,-4.28085c-0.14705,-0.14951 -0.38563,-0.14951 -0.53268,0c-0.14704,0.1495 -0.14704,0.39197 0,0.54145l4.10445,4.55554c0.0784,0.07969 0.18268,0.11383 0.28509,0.10853c0.10277,0.0053 0.20669,-0.02884 0.28509,-0.10853l4.10482,-4.55594c0.14703,-0.14947 0.14703,-0.39155 -0.00001,-0.54105z" fill-opacity="0" fill="#ffffff" stroke-linejoin="miter" stroke-linecap="butt" stroke-opacity="1" stroke="#6d7797" stroke-miterlimit="20" stroke-width="2"></path></g></g></svg>
                          </i>
                        </td>
                      </tr>

                      <tr class="resert-cells">
                        <td colspan="3" class="text-left">
                       <transition
                            v-on:before-enter="animation_beforeEnter"
                            v-on:animation-after="animation_enterAfter"
                            v-on:enter="animation_enter"
                            v-on:leave="animation_leave"
                            v-bind:css="false"
                          >

                          <div class="notes-parent" v-if="show_product_details.notes">
                            <div class="details" v-if="notes_label == 'Quick Notes'">
                               <span class="summary__content-text">{{this.order_data.order_items_data.extra_data.comment.value}}</span>
                            </div>
                            <div class="details" v-if="notes_label == 'Custom Shot List'">
                              <table>
                                <tbody  v-for="shoot, key in custom_shoots">
                                  <tr>
                                    <td class="limit-width"><svg class="icon svg-icon-notes">
                                      <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-notes"></use>
                                      </svg><span class="item-title">Shoot {{key}}</span></td>
                                  <td>
                                  </td>
                                  <td> <span class="item-details expandable" :data-shoot-products="'shoot'+key"> {{shoot.product.replace(',', '\n')}} </span> </td>

                                  <td></td>
                                  <td class="text-right"> <span class="item-details trigger-details" :data-shoot-target="'shoot'+key">[ <span class="trigger"></span> ]</span> </td>
                                  </tr>
                                  <tr> <td colspan="4"><div class="detail-notes" :data-shoot-parent="'shoot'+key"><span class="item-details"> {{shoot.text}}</span></div></td> </tr>
                                </tbody>
                              </table>
                            </div>
                          </div>

                        </transition>
                        </td>
                      </tr>

                      <tr>
                        <td> <div class="step-label no-hover">
                            <svg class="icon svg-icon-flash">
                              <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-flash"></use>
                            </svg>
                            <span class="step-label__text">Turnaround</span>
                          </div> </td>
                        <td> <p class="summary__content-text"><span v-if="order_data.is_fasttrack != 1">{{tracker_options.turnaround.regular}}</span><span v-if="order_data.is_fasttrack == 1">{{tracker_options.turnaround.fasttrack}}</span> Business Days</p> </td>
                        <td class="price-td"> </td>
                      </tr>

                      <tr>
                        <td class="no-borders"> <div class="step-label no-hover">
                            <svg class="icon svg-icon-handling">
                              <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-handling"></use>
                            </svg>
                            <span class="step-label__text">Handling</span>
                          </div> </td>
                        <td class="no-borders"> <p class="summary__content-text" v-if="order_data.is_return != 1">Discard Products</p> <p class="summary__content-text" v-if="order_data.is_return == 1">Return Products</p> </td>
                        <td class="price-td no-borders"> </td>
                      </tr>
                    </tbody>

                    <tbody v-if="order_data.order_items_data.is_reshoot === '1'">
                      <tr>
                        <td  class="no-borders"> <div class="step-label no-hover">
                            <svg class="icon svg-icon-images-3">
                              <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href=" #svg-icon-images-3"></use>
                            </svg>
                            <span class="step-label__text">Photos</span>
                          </div> </td>

                        <td  class="no-borders"> <p class="summary__content-text">{{count_photos}}</p> </td>
                        <td class="price-td no-borders"></td>
                      </tr>


                      <tr>
                        <td> <div class="step-label trigger-expand"  v-on:click="show_product_details.notes = !show_product_details.notes" >
                            <svg class="icon svg-icon-notes">
                              <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-notes"></use>
                            </svg>
                            <span class="step-label__text">Studio Notes</span>
                          </div> <div class="spacer-h-10"></div></td>

                        <td></td>

                        <td class="price-td no-shift">
                          <i class="trigger-expand" v-on:click="show_product_details.notes = !show_product_details.notes" :class="{'rotated': show_product_details.notes}">
                            <svg  width="46" height="46" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:avocode="https://avocode.com/" viewBox="0 0 46 46"><g><g clip-path="url(#clip-F41AE82F-F655-4B7A-8911-124D6B464325)"><title>Path</title><path d="M28.88972,20.11213c-0.14705,-0.14951 -0.38562,-0.14951 -0.53267,0l-3.85685,4.28085v0l-3.85724,-4.28085c-0.14705,-0.14951 -0.38563,-0.14951 -0.53268,0c-0.14704,0.1495 -0.14704,0.39197 0,0.54145l4.10445,4.55554c0.0784,0.07969 0.18268,0.11383 0.28509,0.10853c0.10277,0.0053 0.20669,-0.02884 0.28509,-0.10853l4.10482,-4.55594c0.14703,-0.14947 0.14703,-0.39155 -0.00001,-0.54105z" fill="#6f7894" fill-opacity="1"></path><path d="M28.88972,20.11213c-0.14705,-0.14951 -0.38562,-0.14951 -0.53267,0l-3.85685,4.28085v0l-3.85724,-4.28085c-0.14705,-0.14951 -0.38563,-0.14951 -0.53268,0c-0.14704,0.1495 -0.14704,0.39197 0,0.54145l4.10445,4.55554c0.0784,0.07969 0.18268,0.11383 0.28509,0.10853c0.10277,0.0053 0.20669,-0.02884 0.28509,-0.10853l4.10482,-4.55594c0.14703,-0.14947 0.14703,-0.39155 -0.00001,-0.54105z" fill-opacity="0" fill="#ffffff" stroke-linejoin="miter" stroke-linecap="butt" stroke-opacity="1" stroke="#6d7797" stroke-miterlimit="20" stroke-width="2"></path></g></g></svg>
                          </i>
                        </td>
                      </tr>

                      <tr class="resert-cells">
                        <td colspan="3" class="text-left no-borders">
                         <transition
                            v-on:before-enter="animation_beforeEnter"
                            v-on:animation-after="animation_enterAfter"
                            v-on:enter="animation_enter"
                            v-on:leave="animation_leave"
                            v-bind:css="false"
                          >
                            <div class="notes-parent" v-if="show_product_details.notes">
                              <div class="details">
                                <table>
                                  <tbody >
                                    <tr>
                                      <td class="limit-width"><svg class="icon svg-icon-notes">
                                        <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-notes"></use>
                                        </svg><span class="item-title">Original Photo</span></td>
                                      <td colspan="2">
                                        <a href="#" v-on:click.prevent="view_initial_photo">View</a>
                                      </td>
                                      <td></td>
                                      <td class="text-right"> </td>
                                    </tr>
                                    <tr>
                                      <td colspan="3" class="limit-width"><svg class="icon svg-icon-notes">
                                        <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-notes"></use>
                                        </svg><span class="item-title">Correction Request</span></td>
                                      <td></td>
                                      <td class="text-right"> </td>
                                    </tr>
                                    <tr>
                                      <td colspan="5">
                                        <span class="summary__content-text">{{order_data.reshoot_request_text}}</span>
                                      </td>
                                    </tr>

                                    <tr v-if="order_data.reshoot_attachment_url">
                                      <td class="limit-width"><svg class="icon svg-icon-file">
                                        <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-file"></use>
                                        </svg><span class="item-title">Screenshot</span></td>
                                      <td colspan="2">
                                        <a :href="order_data.reshoot_attachment_url" target="_blank">View</a>
                                      </td>
                                      <td></td>
                                      <td class="text-right"> </td>
                                    </tr>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                          </transition>
                        </td>
                      </tr>
                    </tbody>

                  </table>


                  <?php /*

                  <div v-if="order_data.order_items_data.buy_single_data">
                    <div class="hr-2" ></div>
                    <div class="spacer-h-15"></div>

                    <span class="related-shoot-comment">Related Shoot</span>
                    <div class="related-shoot" v-on:click="open_related_shoot">
                      <span class="related-shoot__name">
                        {{order_data.order_items_data.buy_single_data.name}}

                      </span>
                      <span class="related-shoot__date">
                        #FS-{{order_data.order_items_data.buy_single_data.order_id}}
                         on {{order_data.order_items_data.buy_single_data.date_formatted}}
                      </span>

                      <svg class="icon svg-icon-bracket"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-back-bracket"></use></svg>
                    </div>
                  </div>
                  */ ?>
                </div>
              </div><!-- summary -->
            </div>
          </div>

          <!--************************
          *******studio notes**********-->

           <div class="leads-block">
             <div class="spacer-h-20"></div>
             <h2 class="leads-block__title">Internal Notes</h2>

              <div class="spacer-h-20"></div>
              <div class="leads-block__row">
                <p class="no-notes leads-block__comment" v-if="computed_studio_notes.length === 0">No notes there yet</p>
                <div v-for="note,key in computed_studio_notes" class="note-block">
                  <div class="note-block__header clearfix">
                    <span class="name">{{note.user_name}}</span>
                    <span class="date">{{note.date}}</span>

                    <i class="remove-note-icon"  v-on:click="delete_note('studio', note.text, note.date)">
                      <svg class="icon svg-icon-trash"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-trash"></use></svg>
                    </i>
                  </div>

                  <div class="note-block__body" v-bind:class="{'manager-note': note.is_manager == 'yes'}">
                   <span class="inner">{{note.text}}</span>
                   <i class="icon-manager-done" v-on:click="mark_note_done(note.key, 'no')" v-if="note.is_manager == 'yes' && note.done =='yes'"></i>

                    <i class="icon-manager-done not" v-on:click="mark_note_done(note.key, 'yes')" v-if="note.is_manager == 'yes' && note.done !='yes'"></i>
                  </div>
                </div>

                <span class="note-block__show-more" v-on:click="studio_notes_count = order_data.messages.studio.length + 9999" v-if="studio_notes_count < computed_studio_notes_count"> <i class="icon"></i> Show {{computed_studio_notes_count - 1}} more</span>
                <div class="spacer-h-20"></div>
              </div>

              <form id="message-form-reception" v-on:submit.prevent  v-on:submit="add_note('studio')" >
                <div class="leads-block__form">

                <textarea name="text" placeholder="Enter new note…" ref="note_textarea_studio" v-model="studio_note_text" @keyup.alt.enter="add_note('studio')" @keyup.ctrl.enter="add_note('studio')" title="use Enter for line breaks, use Alt+Enter to add note"></textarea>

                <button type="submit" class="button-submit">
                  <svg class="icon svg-icon-send"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-send"></use> </svg>
                </button>

                </div>
              </form>
            </div><!-- leads-block -->

          <!--*****end studio notes*******
          **************************-->

        <!-- ******************************
        *******END ORDER DATA ***********
        *********************************-->
          <div class="spacer-h-60"></div>
      </div>

      <div class="col calc-width">
        <div class="spacer-h-40"></div>

        <div class="single-order__top row">
          <div class="col-12">
            <a href="#" class="go-back"  v-on:click.prevent="back_to_list"><svg class="icon svg-icon-back-bracket"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-back-bracket"></use></svg> <span>Back</span></a>
          </div>
        </div>

        <div class="spacer-h-25"></div>

        <div class="progress-wrapper text-center">
          <ul class="progress-order progress">
            <li class="progress__item"
              v-for="inf, key in orders_in_details"
              :class="{active: (parseInt(inf.meta.order) >= 0  && order_status_number > parseInt(inf.meta.order) )}"
              >
              <span class="progress__item-dots"></span> <span class="progress__item-name">{{inf.name}}</span> <br><span class="progress__item-date">{{inf.date}}</span>
            </li>
          </ul>
        </div>

        <div class="data-no-items text-center" v-if="!shoot_started" >
          <div class="spacer-h-40"></div>
          <p class="data-no-items__category">IT’S SHOWTIME</p>
          <h2 class="data-no-items__title">Cameras on standby</h2>

          <p class="data-no-items__text">You have a minimum of   <span class="marked blue">{{count_photos}} </span>  {{count_photo_label}} to upload <span v-if="day_label"> by  <span class="marked green"> Friday. </span></span>   <br>

            <span v-if="due_days_left > 0 ">
            {{due_days_left_label.before}}  <span class="marked yellow"> {{due_days_left}} {{due_days_left_label.after}} left </span>   before this shoot will be  <span class="marked red">Overdue</span>
            </span>

            <span v-if="due_days_left == 0">
              Shoot is <span class="marked red">Overdue</span>
            </span>

            <span v-if="due_days_left < 0">
              Products are <span class="marked yellow">not in studio yet</span>
            </span>
          </p>
          <div class="spacer-h-30"></div>
          <a href="#" v-on:click.prevent="exec_start_shoot" class="button-save-shoot width200 active"> <img v-if="start_shoot" src="<?php echo THEME_URL ?>/order_tracker/assets/images/spinner_white.gif" alt=""> Start Shoot</a>
        </div>

        <div class="upload-area__body">
          <div class="row" v-if="shoot_started || is_old_order">

           <upload-item-exists
              v-for="(file, i) in files_uploaded"
              :_order_id = "order_data.order_id"
              :_number = "i + 1"
              :_item_id = "i"
              :key     = "'upload_item_'+i"
              :_comments = "get_comments_for_image(i)"
              :_files_uploaded = "file"
              :_is_old_order = "is_old_order"
              :_is_single_order = "0"
              v-on:show_image = 'show_image_popup'
              v-on:show_review_window = 'show_review_window_cb'
              v-on:file_changed = "update_files"
              v-on:change_thumbnail = "change_thumbnail"
              v-on:delete_path_update = "delete_path_update"
              v-on:toggle_free_paid = "toggle_free_paid_cb"
            ></upload-item-exists>

           <upload-item-exists
               v-if= "is_single_order"
               :_number = "1"
               :_order_id = "order_data.order_id"
              :_item_id = "0"
              :_comments = "[]"
              :_files_uploaded = "single_order_files"
              :_is_old_order = "1"
              :_is_single_order = "1"
              v-on:show_image = 'show_image_popup'
              v-on:file_changed = "update_files"
              v-on:change_thumbnail = "change_thumbnail"
              v-on:delete_path_update = "delete_path_update"
            ></upload-item-exists>

            <upload-item
              v-for="(file, i) in watch_files_prepared"
              :_order_id        = "order_data.order_id"
              :_number          = "get_index_prepared(i) + 1"
              :_item_id         = "get_index_prepared(i)"
              :key              = "'upload_item_prepared_'+get_index_prepared(i)"
              :_comments        = "[]"
              :_files           = "file"
              :_files_uploaded  = "files_uploaded[get_index_prepared(i)]"
              v-on:show_image   = "show_image_popup"
              v-on:file_changed = "update_files"
              v-on:change_thumbnail = "change_thumbnail"
              v-on:toggle_free_paid = "toggle_free_paid_cb"
            ></upload-item>

            <upload-item-blank
               v-if = "!is_old_order && !is_single_order"
              :_blank_number = "blank_item_id  + 1"
              :_order_id = "order_data.order_id"
              :_blank_item_id = "blank_item_id"
              v-on:file_changed_blank = "update_files_blank"
            ></upload-item-blank>

          </div><!-- row -->
        </div><!-- upload-area__body -->
      </div><!-- upload-area -->

      <div class="col-12 col-lg-4 limited-width-400">

        <div class="spacer-h-40"></div>


      <!-- ************************************
      ******** START STUDIO DATA ***** -->
        <div class="leads-block bg2">
          <h2 class="leads-block__title">
              Deliverables
          </h2>
          <div class="hr hr-bottom-0"></div>

          <div class="leads-block__row">
            <table class="leads-block__data">
              <tr>
                <td><p class="leads-block__label no-margin">Photos Ordered</p></td>
                <td class="text-right"><p class="leads-block__info">{{number_of_photos_bought}}</p></td>
              </tr>
              <tr>
                <td><p class="leads-block__label no-margin">Photos Uploaded</p></td>
                <td class="text-right"><p class="leads-block__info">{{image_data.total}}</p></td>
              </tr>
              <tr>
                <td><p class="leads-block__label no-margin">Awaiting Review</p></td>
                <td class="text-right"><p class="leads-block__info">{{image_data.review}}</p></td>
              </tr>
              <tr v-if="due_days_left >= 0">
                <td class="no-borders"><p class="leads-block__label no-margin">Due</p></td>
                <td class="no-borders">
                  <div class="text-right">
                    <span class="leads-block__due-date" >{{due_date.value}}</span>
                    <div class="tag-fasttrack" v-if="order_data.is_fasttrack == 1">
                      <svg class="icon svg-icon-fastrack2"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-fastrack2"></use> </svg>
                      <span>fasttrack</span>
                    </div>
                  </div>
                </td>
              </tr>

              <tr v-if="due_days_left >=0">
                <td class="no-borders" colspan="2">
                  <div class="spacer-h-10"></div>
                  <span class="warning-due">
                     <img src="<?php echo THEME_URL?>/order_tracker/assets/images/warn.png" alt=""> You have<span class="yellow"> {{due_days_left}} {{due_days_left_label.after}} left</span> to submit photos for this order. <br> Late uploads will incur fee deductions.
                  </span>
                  <div class="spacer-h-20"></div>
                </td>
              </tr>
            </table>

            <a href="#"
              v-on:click.prevent="do_upload" v-if="show_submit_button"
              v-bind:class="{active: files_to_load_exist, 'not-active': !files_to_load_exist}"
              class="button-save-shoot">Submit Photos <svg class="icon svg-icon-tick" v-if="!files_to_load_exist"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-tick"></use></svg></a>
              <div class="spacer-h-20"></div>
          </div>

        </div><!-- leads-block -->

      <!--******** END STUDIO    DATA *****
       ************************************ -->

        <!-- ************************************
        ******** PRODUCT LOCATION START **** -->
          <div class="leads-block">
            <h2 class="leads-block__title">
              Product Location
            </h2>
            <div class="hr  hr-bottom-0"></div>

            <div class="leads-block__row">
              <table class="leads-block__data">
                <tr>
                  <td><p class="leads-block__label no-margin">Unit</p></td>
                  <td class="text-right width-150">
                    <span class="leads-block__text"> {{order_data.location.unit}} </span>
                  </td>
                </tr>
                <tr>
                  <td></td>
                  <td class="text-right width-150">
                    <span class="leads-block__text"> {{order_data.location.box}} </span>
                  </td>
                </tr>
              </table>
            </div>
          </div><!-- leads-block -->
        <!--****** PRODUCT LOCATION END *****
        ************************************ -->
      </div>
    </div><!-- row -->

    <?php /*
    <div class="image-preview-popup"
     v-bind:class="{shown: show_popup_preview}"
     v-on:click="show_popup_preview = !show_popup_preview">
      <div class="image-preview-popup__inner" v-on:click.stop>
        <i class="icon-close" v-on:click="show_popup_preview = !show_popup_preview">×</i>
      </div>
    </div> */ ?>

    <preview-popup
      ref="preview_popup"
    >
    </preview-popup>

    <review-item-popup
      ref="review_item_popup"
      v-on:submit_revision = 'submit_revision_cb'
    >

    </review-item-popup>
  </div><!-- container-lg -->

<?php echo'</script>'; ?>
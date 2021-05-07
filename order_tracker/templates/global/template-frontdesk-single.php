<?php
if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}
?>
<div class="container-fluid single-order" id="single-frontdesk-order" v-if="visible">
  <div class="spacer-h-40"></div>


  <div class="spacer-h-40"></div>

  <!-- ********************************
  ******** START COLUMNS       *******
  **********************************-->

  <div class="single-order__columns row">
    <div class="col-12 col-lg-4 limited-width-400">
      <!-- ********************************
      ******** START CUSTOMER DATA  **** -->
        <div class="leads-block">
          <form action="">
            <!-- block title
            ************************* -->
            <h2 class="leads-block__title">
              Customer Details
              <span class="icons hidden">
                <span class="phones">
                  <i class="phone-ok icon" v-on:click="change_order_data_value ('phone_count', order_data.phone_count-1)" v-for="n in order_data.phone_count"></i><i class="phone-na icon" v-for="n in phone_left" v-on:click="change_order_data_value ('phone_count', order_data.phone_count+1)"></i>
                </span>
                <span class="messages">
                  <i class="message-ok icon"  v-for="n in order_data.message_count" v-on:click="change_order_data_value ('message_count', order_data.message_count-1)"></i><i class="message-na icon"  v-for="n in messages_left" v-on:click="change_order_data_value ('message_count', order_data.message_count +1)"></i>
                </span>
              </span>
            </h2>

            <div class="spacer-h-15"></div>

             <!-- ASSIGNED SPECIALIST
              ************************* -->
              <div class="row no-gutters">
                <div class="col-5 valign-center">
                  <span class="leads-block__sub-title">
                     Frontdesk
                  </span>
                </div>
                <div class="col-6">
                  <user-select
                  v-bind:_select_name="'assigned'"
                  v-bind:_current_user="order_data.customer.assigned"
                  v-on:user_select_change="update_order($event, 'customer')"></user-select>
                </div>
              </div>
            <div class="spacer-h-10"></div>
            <div class="hr no-margin"></div>
            <div class="spacer-h-10"></div>

            <!-- CUSTOMER DATA
            ************************* -->
            <div class="leads-block__row">
              <div class="leads-block__name">

                <h1 class="block-title">{{order_data.name}}</h1>
                <span class="leads-block__comment">Added {{order_data.customer.date_added}}</span>
              </div>

              <div class="spacer-h-5"></div>

              <table class="leads-block__data">
                <tr>
                  <td>
                    <svg class="icon svg-icon-phone"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-phone"></use> </svg>
                  </td>
                  <td><p class="leads-block__label">Phone</p></td>
                  <td class="text-right">
                    <input-field _name="phone" v-bind:_value="order_data.customer.phone" v-on:input_value_changed="update_order($event, 'customer')"></input-field>
                  </td>
                </tr>
                <tr>
                  <td>
                    <svg class="icon svg-icon-email"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-email"></use> </svg>
                  </td>
                  <td><p class="leads-block__label">E-mail</p></td>
                  <td class="text-right">
                      <span class="leads-block__text no-margin" v-bind:title="order_data.customer.email">{{order_data.customer.email}}</span>
                  </td>
                </tr>
                <tr>
                  <td>
                    <svg class="icon svg-icon-sourses"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-sourses"></use> </svg>
                  </td>
                  <td><p class="leads-block__label">Source</p></td>
                  <td class="text-right">
                    <select-imitation
                     v-bind:class="'fullwidth style-less'"
                      _select_name="source"
                      v-bind:_options="order_sources"
                      v-bind:_selected="order_data.customer.source"
                      v-on:update_list="update_order($event, 'customer')"
                      ></select-imitation>
                  </td>
                </tr>
                <tr>
                  <td class="no-borders">
                    <svg class="icon svg-icon-diamond"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-diamond"></use> </svg>
                  </td>
                  <td class="no-borders"><p class="leads-block__label">Brand</p></td>
                  <td class="no-borders text-right">
                    <input-field
                      _name="brand"
                      v-model="order_data.customer.brand"
                      v-bind:class="{'styled' : new_order}"
                      v-bind:_value="order_data.customer.brand"
                      v-on:input_value_changed="update_order($event, 'customer')"></input-field>
                  </td>
                </tr>
              </table>
              <div class="clearfix"></div>
            </div><!-- leads-block__row -->
          </form>


           <?php /*
           <div class="spacer-h-30"></div>

           <!-- NOTES BLOCK
            ************************* -->
           <h2 class="leads-block__title">Enquiry Notes</h2>

           <div class="spacer-h-20"></div>

            <div class="leads-block__row">
              <p class="no-notes leads-block__comment" v-if="computed_enquery_notes.length === 0">No notes there yet</p>
              <div v-for="note, key in computed_enquery_notes" class="note-block">
                <div class="note-block__header clearfix">
                  <span class="name">{{note.user_name}}</span>
                  <span class="date">{{note.date}}</span>

                  <i class="remove-note-icon"  v-on:click="delete_note('enquery', note.text, note.date)">
                    <svg class="icon svg-icon-trash"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-trash"></use></svg>
                  </i>
                </div>

                <div class="note-block__body" v-bind:class="{'manager-note': note.is_manager == 'yes'}">
                 <span class="inner">{{note.text}}</span>
                 <i class="icon-manager-done" v-on:click="mark_note_done(note.key, 'no')" v-if="note.is_manager == 'yes' && note.done =='yes'"></i>

                  <i class="icon-manager-done not" v-on:click="mark_note_done(note.key, 'yes')" v-if="note.is_manager == 'yes' && note.done !='yes'"></i>
                </div>
              </div>

              <span class="note-block__show-more" v-on:click="enquery_notes_count = order_data.messages.enquery.length + 999" v-if="enquery_notes_count < computed_enquery_notes_count"> <i class="icon">
                <svg  width="25" height="23" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:avocode="https://avocode.com/" viewBox="0 0 25 23"><defs></defs><desc>Generated with Avocode.</desc><g><g clip-path="url(#clip-DE13DCBF-88C9-45C8-BBB9-358E473B1E2D)"><title>Path Copy</title><path d="M14.94831,10.53082l-2.33405,2.33389c-0.03335,0.03338 -0.07171,0.0501 -0.11511,0.0501c-0.0434,0 -0.08183,-0.01672 -0.1152,-0.0501l-2.33385,-2.33389c-0.03344,-0.03343 -0.0501,-0.0718 -0.0501,-0.11521c0,-0.0434 0.01672,-0.08182 0.0501,-0.11519l0.25036,-0.25034c0.03338,-0.03338 0.0718,-0.05006 0.1152,-0.05006c0.0434,0 0.08182,0.01668 0.1152,0.05006l1.96829,1.96826v0l1.96836,-1.96838c0.03337,-0.03338 0.0718,-0.04996 0.11513,-0.04996c0.04347,0 0.08189,0.01668 0.11525,0.04996l0.2504,0.25045c0.03336,0.03336 0.04994,0.0718 0.04994,0.11518c0.00002,0.04343 -0.01656,0.08185 -0.04992,0.11523z" fill="#ffffff" fill-opacity="1"></path><path d="M14.94831,10.53082l-2.33405,2.33389c-0.03335,0.03338 -0.07171,0.0501 -0.11511,0.0501c-0.0434,0 -0.08183,-0.01672 -0.1152,-0.0501l-2.33385,-2.33389c-0.03344,-0.03343 -0.0501,-0.0718 -0.0501,-0.11521c0,-0.0434 0.01672,-0.08182 0.0501,-0.11519l0.25036,-0.25034c0.03338,-0.03338 0.0718,-0.05006 0.1152,-0.05006c0.0434,0 0.08182,0.01668 0.1152,0.05006l1.96829,1.96826v0l1.96836,-1.96838c0.03337,-0.03338 0.0718,-0.04996 0.11513,-0.04996c0.04347,0 0.08189,0.01668 0.11525,0.04996l0.2504,0.25045c0.03336,0.03336 0.04994,0.0718 0.04994,0.11518c0.00002,0.04343 -0.01656,0.08185 -0.04992,0.11523z" fill-opacity="0" fill="#ffffff" stroke-linejoin="miter" stroke-linecap="butt" stroke-opacity="1" stroke="#ffffff" stroke-miterlimit="20" stroke-width="1"></path></g></g></svg></i> Show {{computed_enquery_notes_count - 1}} more</span>
              <div class="spacer-h-20"></div>
            </div>

            <form id="message-form-reception-new" v-on:submit.prevent  v-on:submit="add_note('enquery')" >
              <div class="leads-block__form">

              <textarea name="text" placeholder="Enter new note…" ref="note_textarea_enquery" v-model="enquery_note_text" @keyup.alt.enter="add_note('enquery')" @keyup.ctrl.enter="add_note('enquery')" title="use Enter for line breaks, use Alt+Enter to add note"></textarea>

              <button type="submit" class="button-submit">
                <svg class="icon svg-icon-send"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-send"></use> </svg>
              </button>

              </div>
            </form> */ ?>
        </div><!-- leads-block -->

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
            </div><!-- shoot-steps__header -->
            <div class="summary">
              <div class="summary__body">
                <table class="summary__content">
                  <tbody v-if="order_data.order_items_data.shoot_data">
                    <tr>
                      <td> <div class="step-label  trigger-expand" v-on:click=" show_product_details.names = !show_product_details.names">
                          <svg class="icon svg-icon-product">
                            <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-product"></use>
                          </svg>
                          <span class="step-label__text">Products</span>
                        </div> </td>

                      <td> <p class="summary__content-text"> {{product_names.name}}  <span class="addon" v-if="(product_names.items.length - 1) > 0"> + {{product_names.items.length - 1}}</span> </p> </td>

                      <td class="price-td"> <p class="summary__content-price" v-if="order_sum_details.product_names == 0">Free</p><p class="summary__content-price"  v-if="order_sum_details.product_names > 0"> {{order_data.order.currency_symbol}}{{order_sum_details.product_names}} </span></p>
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
                      <td class="price-td"> <span class="summary__content-price">{{order_data.order.currency_symbol}}{{order_sum_details.photos}}</span> </td>
                    </tr>

                    <tr>
                      <td> <div class="step-label trigger-expand"  v-on:click="show_product_details.custom = !show_product_details.custom"> <svg class="icon svg-icon-custom">
                            <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-custom"></use>
                          </svg>
                          <span class="step-label__text">Customise</span>
                        </div> </td>
                     <td class="active"> <p class="summary__content-text">{{count_customisations}}</p> </td>

                     <td class="price-td"> <p class="summary__content-price" v-if="order_sum_details.customize == 0">Free</p><p class="summary__content-price"  v-if="order_sum_details.customize > 0">{{order_data.order.currency_symbol}}{{order_sum_details.customize}}</p>
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

                    <tr>
                      <td> <div class="step-label"  v-on:click="show_product_details.notes = !show_product_details.notes" :class="{'trigger-expand' : notes_label == 'Quick Notes'}" >
                          <svg class="icon svg-icon-notes">
                            <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-notes"></use>
                          </svg>
                          <span class="step-label__text">Studio Notes</span>
                        </div> </td>

                      <td> <p class="summary__content-text"> {{notes_label}} </p> </td>

                      <td class="price-td"> <p class="summary__content-price" v-if="order_sum_details.shoots == 0">Free</p><p class="summary__content-price"  v-if="order_sum_details.shoots > 0">{{order_data.order.currency_symbol}}{{order_sum_details.shoots}}</p>
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
                          <div class="details" v-if="notes_label == 'Custom Shoot List'">
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
                      <td class="price-td"> <p class="summary__content-price" v-if="order_data.is_fasttrack != 1">Free</p><p class="summary__content-price"  v-if="order_data.is_fasttrack == 1">{{order_data.order.currency_symbol}}{{order_data.fasttrack_price}}</p></td>
                    </tr>

                    <tr>
                      <td> <div class="step-label no-hover">
                          <svg class="icon svg-icon-handling">
                            <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-handling"></use>
                          </svg>
                          <span class="step-label__text">Handling</span>
                        </div> </td>
                      <td> <p class="summary__content-text" v-if="order_data.is_return != 1">Discard Products</p> <p class="summary__content-text" v-if="order_data.is_return == 1">Return Products</p> </td>
                      <td class="price-td"> <p class="summary__content-price" v-if="order_data.is_return != 1">Free</p><p class="summary__content-price"  v-if="order_data.is_return == 1">{{order_data.order.currency_symbol}}{{order_data.return_price}}</p> </td>
                    </tr>
                  </tbody>
                  <tbody v-if="order_data.order_items_data.buy_single === '1'">
                    <tr>
                      <td> <div class="step-label no-hover">
                          <svg class="icon svg-icon-images-3">
                            <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href=" #svg-icon-images-3"></use>
                          </svg>
                          <span class="step-label__text">Photos</span>
                        </div> </td>

                      <td > <p class="summary__content-text">{{count_photos}}</p> </td>
                      <td class="price-td"> <span class="summary__content-price">{{order_data.order.currency_symbol}}{{order_sum_details.photos}}</span> </td>
                    </tr>
                  </tbody>

                  <tbody v-if="order_data.order_items_data.is_reshoot === '1'">
                    <tr>
                      <td> <div class="step-label no-hover">
                          <svg class="icon svg-icon-images-3">
                            <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href=" #svg-icon-images-3"></use>
                          </svg>
                          <span class="step-label__text">Photos</span>
                        </div> </td>

                      <td > <p class="summary__content-text">{{count_photos}}</p> </td>
                      <td class="price-td"> <span class="summary__content-price">{{order_data.order.currency_symbol}}{{order_sum_details.photos}}</span> </td>
                    </tr>


                    <tr>
                      <td> <div class="step-label trigger-expand"  v-on:click="show_product_details.notes = !show_product_details.notes" >
                          <svg class="icon svg-icon-notes">
                            <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-notes"></use>
                          </svg>
                          <span class="step-label__text">Studio Notes</span>
                        </div> <div class="spacer-h-10"></div></td>

                      <td></td>

                      <td class="price-td">
                        <i class="trigger-expand" v-on:click="show_product_details.notes = !show_product_details.notes" :class="{'rotated': show_product_details.notes}">
                          <svg  width="46" height="46" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:avocode="https://avocode.com/" viewBox="0 0 46 46"><defs></defs><desc>Generated with Avocode.</desc><g><g clip-path="url(#clip-F41AE82F-F655-4B7A-8911-124D6B464325)"><title>Path</title><path d="M28.88972,20.11213c-0.14705,-0.14951 -0.38562,-0.14951 -0.53267,0l-3.85685,4.28085v0l-3.85724,-4.28085c-0.14705,-0.14951 -0.38563,-0.14951 -0.53268,0c-0.14704,0.1495 -0.14704,0.39197 0,0.54145l4.10445,4.55554c0.0784,0.07969 0.18268,0.11383 0.28509,0.10853c0.10277,0.0053 0.20669,-0.02884 0.28509,-0.10853l4.10482,-4.55594c0.14703,-0.14947 0.14703,-0.39155 -0.00001,-0.54105z" fill="#6f7894" fill-opacity="1"></path><path d="M28.88972,20.11213c-0.14705,-0.14951 -0.38562,-0.14951 -0.53267,0l-3.85685,4.28085v0l-3.85724,-4.28085c-0.14705,-0.14951 -0.38563,-0.14951 -0.53268,0c-0.14704,0.1495 -0.14704,0.39197 0,0.54145l4.10445,4.55554c0.0784,0.07969 0.18268,0.11383 0.28509,0.10853c0.10277,0.0053 0.20669,-0.02884 0.28509,-0.10853l4.10482,-4.55594c0.14703,-0.14947 0.14703,-0.39155 -0.00001,-0.54105z" fill-opacity="0" fill="#ffffff" stroke-linejoin="miter" stroke-linecap="butt" stroke-opacity="1" stroke="#6d7797" stroke-miterlimit="20" stroke-width="2"></path></g></g></svg>
                        </i>
                      </td>
                    </tr>

                    <tr class="resert-cells no-borders">
                      <td colspan="3" class="text-left">
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

                <table class="summary__content">
                  <tfoot>
                    <tr>
                      <td colspan="3"><span class="summary__label">Total Cost</span> <div class="spacer-h-10"></div></td>
                    </tr>
                    <tr>
                      <td colspan="2">Subtotal</td>
                      <td colspan="1"><span class="woocommerce-Price-amount amount">{{order_data.order.currency_symbol}}{{order_sum_details.photos}}</span></td>
                    </tr>
                    <tr>
                      <td colspan="2">Add-Ons</td>
                      <td colspan="1"><span class="woocommerce-Price-amount amount">{{order_data.order.currency_symbol}}{{order_sum_details.addons}}</span></td>
                    </tr>
                    <tr>
                      <td colspan="2">Discount <span class="coupon_code" v-if="order_data.coupon_codes.length > 0">{{order_data.coupon_codes[0]}}</span>
                      </td>
                      <td colspan="1"><span v-if="order_data.discount != 0">-</span>{{order_data.order.currency_symbol}}{{order_data.discount}}</td>
                    </tr>
                    <tr>
                      <td colspan="2"></td>
                      <td colspan="1"><span class="summary__total">{{order_data.order.currency_symbol}}{{order_total}}</span></td>
                    </tr>

                  </tfoot>
                </table>

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
              </div>
            </div><!-- summary -->
            <div class="spacer-h-25"></div>
          </div>
        </div>


      <!-- ********************************
      ******** START ORDER DATA   ***** -->
        <div class="leads-block" v-if="!shoot_data_set">
          <h2 class="leads-block__title">
            <svg class="icon svg-icon-order"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-order"></use> </svg>
            Order
          </h2>
          <div class="hr"></div>
           <div class="leads-block__row">
            <div class="leads-block__name">

              <h1 class="block-title">Order #{{order_data.order_id}}</h1>

              <span class="leads-block__comment"><span v-if="order_data.order.date">Paid on</span> {{order_data.order.date}}</span>
            </div>
          </div><!-- leads-block__row -->
          <div class="hr"></div>

          <div class="products-block">
            <div class="products-block__item" v-for="(item, key) in order_data.order.items" :key="'product_'+key">
              <div class="products-block__item-head row">
                <div class="col-5">
                 <span class="products-block__item-title"> {{item.product_name}} </span>
                </div>

                <div class="col-120">
                  {{item.image_count}}
                </div>

                <div class="col text-left">
                  <span class="products-block__item-title"> {{order_data.order.currency_symbol}}{{item.price}}</span>
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
                  <div class="row no-gutters">
                    <div class="col-5">Product</div>
                    <div class="col-7">{{item.title}}</div>
                  </div>
                  <div class="row no-gutters" v-if="item.sizes">
                    <div class="col-5">Sizes</div>
                    <div class="col-7">{{item.sizes.join(', ')}}</div>
                  </div>
                  <div class="row no-gutters">
                    <div class="col-5">Note</div>
                    <div class="col-7"> {{item.notes}}</div>
                  </div>
                </div>
              </transition>
            </div>

            <div class="products-block__item" v-for="(item, key) in order_data.order.fee" :key="key">
              <div class="products-block__item-head row">
                <div class="col-5">
                 <span class="products-block__item-title"> {{item.fee_name}}</span>
                </div>

                <div class="col-120">
                </div>

                <div class="col text-left">
                  <span class="products-block__item-title"> {{order_data.order.currency_symbol}}{{item.price}}</span>
                </div>

                <div class="col-1 text-right">
                </div>
              </div>
            </div>
          </div>

          <div class="leads-block__row">
            <table class="leads-block__data">
              <tbody>
                <tr v-for="(addon, addon_key) in order_data.order.addons" :key="'addon_'+addon_key">
                  <td class="td-5">
                    <p class="leads-block__label no-margin">{{addon.title}}</p>
                  </td>
                  <td class="width-100">
                    <p class="leads-block__text no-margin" v-if="addon.name!='Fasttrack'">{{addon.name}}</p>
                    <div class="tag-fasttrack" v-if="addon.name =='Fasttrack'">
                      <svg class="icon svg-icon-fastrack2"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-fastrack2"></use> </svg>
                      <span>fast track</span>
                    </div>
                  </td>
                  <td>
                    <p class="leads-block__label">{{addon.price}}</p>
                  </td>
                </tr>
              </tbody>
            </table>

            <table class="leads-block__data">
              <tbody>
                <tr>
                  <td>
                    <i class="icon-holder">
                      <svg class="icon svg-icon-card"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-card"></use> </svg>
                    </i>
                  </td>
                  <td class="width-120">
                    <p class="leads-block__label no-margin">Order Total </p>
                  </td>
                  <td class="text-right">
                   <span class="leads-block__total"><span class="currency">{{order_data.order.currency_symbol}}</span> {{order_total}}</span>
                  </td>
                </tr>
              </tbody>
            </table>
          </div><!-- leads-block__row -->
        </div><!-- leads-block -->
      <!--      END ORDER DATA   *******
      **********************************-->
      <!-- *** END CUSTOMER DATA  *******
      **********************************-->
    </div><!-- col-12 col-lg-4 col-xl-3 -->

    <div class="col calc-width">

      <!-- ********************************
      ******** START HEADER BUTTONS *******
      **********************************-->
      <div class="single-order__top row">
        <div class="col-2">
          <a href="#" class="go-back" v-on:click.preventdefault="return_to_list">
             <svg class="icon svg-icon-back-bracket"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-back-bracket"></use> </svg>
            <span>Back</span>
          </a>
            <reminder
            v-on:input_value_changed="update_reminder($event)"
            v-bind:placeholder="'MM dd YYYY hh:mm'"
            v-model="order_data.reminder.date"
            _name="reminder"
            :class="'hidden'"
            v-bind:_value="order_data.reminder.date"
            v-bind:_value_formatted="order_data.reminder.date_formatted"
            v-bind:_overdue="order_data.reminder.is_overdue"></reminder>
            <div class="spacer-h-30"></div>
        </div>

        <div class="col text-right">
          <order-status-select ref="order_status"
             _select_name="order_status"
             v-bind:_options='order_statuses'
             v-bind:_current_status='order_data.order_status'
             v-bind:class="'text-left text-left'"
             v-on:update_list="update_order_status"></order-status-select>

          <a href="#"  v-on:click.prevent="exec_save" class="button-save-order" v-bind:class="{gray: !_order_was_changed}">
             <svg  v-if="!is_run_saving" class="icon svg-icon-ok-marker"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-ok-marker"></use> </svg>

            <span v-if="!is_run_saving">Save Changes</span>

            <img v-if="is_run_saving" src="<?php  echo THEME_URL; ?>/order_tracker/assets/images/spinner_white.gif" alt="" class="spinner-white">
            <span v-if="is_run_saving">Saving... </span>
          </a>
          <div class="spacer-h-30"></div>
        </div>
      </div><!-- single-order__top -->

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

      <div class="spacer-h-25" v-if="review_notifications"></div>

      <div class="review-notifications" v-if="review_notifications.dates && review_notifications.dates.length > 0">

       <p class="data-no-items__text">You have <span class="marked blue">{{review_notifications.dates.length}}</span> {{review_notifications.label}} <span class="marked"><span class="marked gradient">Awaiting Decision.</span></span> <br>

        <transition-group
          v-on:before-enter="animation_beforeEnter"
          v-on:animation-after="animation_enterAfter"
          v-on:enter="animation_enter"
          v-on:leave="animation_leave"
          v-bind:css="false"
        >
          <span  v-for="data, key in review_notifications.dates" :key="'review_notifications'+key">
            You have <span class="marked blue" :class="{'blue': (data.delta > 0), 'red': (data.delta == 0)}" >{{data.delta}} {{data.label}}</span> to submit a decision for image <span class="marked yellow">#FS-{{order_data.order_id}}/{{data.image_id}}</span><br>
          </span>
        </transition-group>
       </p>

      </div>

      <div class="spacer-h-25"></div>

      <div class="my-order__filter"  v-if="order_data.wfp_images">
        <div class="decoration" ref="deco"></div>
        <div class="decoration pre" ref="deco_pre"></div>
        <a href="#processing"
          class="my-order__filter-item-2"
          v-on:click="filter='all'"
          :class="{active: (filter== 'all')}">All Photos <span class="count">{{files_uploaded_counts.all.length}}</span></a>

        <a href="#downloaded"
        class="my-order__filter-item-2"
        v-on:click="filter='downloaded'"
        :class="{active: (filter== 'downloaded')}">Downloaded <span class="count">{{files_uploaded_counts.downloaded.length}}</span></a>

        <a href="#not_downloaded"
        class="my-order__filter-item-2"
        v-on:click="filter='not_downloaded'"
        :class="{active: (filter== 'not_downloaded')}">Not Downloaded <span class="count">{{files_uploaded_counts.not_downloaded.length}}</span></a>

        <a href="#in_review"
        class="my-order__filter-item-2"
        v-on:click="filter='in_review'"
        :class="{active: (filter== 'in_review')}">In Review <span class="count">{{files_uploaded_counts.in_review.length}}</span></a>
      </div>

      <div class="spacer-h-25" v-if="order_data.wfp_images"></div>
      <div class="spacer-h-25" v-if="order_data.wfp_images"></div>


      <div class="row">

        <frontdesk-upload-exists
          v-for="(file, i) in files_uploaded"
          :_number = "file[0].image_id  + 1"
          :_item_id = "i"
          :_image_id = "file[0].image_id"
          :key     = "'upload_item_'+i"
          :_comments = "get_comments_for_image(file[0].image_id)"
          :_files_uploaded = "file"
          :_is_old_order = "is_old_order"
          :_is_single_order = "0"
          :_order_id = "order_data.order_id"
          :_thumbnail = "get_thumbnail( file[0].image_id )"

          v-on:show_comments_window ="show_comments_window_cb"
          v-on:show_image = 'show_image_popup'
          v-on:file_changed = "update_files"
          v-on:change_thumbnail = "change_thumbnail"
          v-on:delete_path_update = "delete_path_update"
          v-on:toggle_free_paid = "toggle_free_paid_cb"
        ></frontdesk-upload-exists>

      </div>
      <!-- ********************************
      ******** END HEADER BUTTONS *******
      **********************************-->

      <div class="spacer-h-30"></div>

      <div class="data-no-items text-center" v-if="!order_data.wfp_images && !order_data.wfp_image_single">
        <p class="data-no-items__category">GALLERY</p>
        <h2 class="data-no-items__title">No photos yet</h2>

        <p class="data-no-items__text">You have a minimum of   <span class="marked blue">{{count_photos}} </span>  {{count_photo_label}} to upload <span v-if="day_label"> by  <span class="marked green"> Friday. </span></span>   <br>

          <span v-if="due_days_left > 0 ">
          {{due_days_left_label.before}}  <span class="marked yellow"> {{due_days_left}} {{due_days_left_label.after}} left </span>   before this shoot will be  <span class="marked red">Overdue</span>.
          </span>

          <span v-if="due_days_left == 0">
            Shoot is <span class="marked red">Overdue</span>
          </span>

          <span v-if="due_days_left < 0">
            Products are <span class="marked yellow">not in studio yet</span>
          </span>
        </p>
      </div>
    </div><!-- col-12 col-lg-4 -->

    <div class="col-12 col-lg-4 limited-width-400">

      <!-- ************************************
      ******** START STUDIO DATA ***** -->
        <div class="leads-block bg">
          <h2 class="leads-block__title">
              Studio
          </h2>
          <div class="hr hr-bottom-0"></div>

          <div class="leads-block__row">
            <table class="leads-block__data">
              <tr>
                <td><p class="leads-block__label no-margin">Creator</p></td>
                <td>
                  <user-select
                  v-bind:_select_name="'creator'"
                  v-bind:_current_user="order_data.studio.creator"
                  v-on:user_select_change="update_order($event, 'studio')"></user-select>
                </td>
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
                    <span class="leads-block__info" >{{due_date.value}}</span>
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
                     <img src="<?php echo THEME_URL?>/order_tracker/assets/images/warn.png" alt=""><span class="yellow"> {{due_days_left}} {{due_days_left_label.after}} left</span> to submit photos for this order.
                  </span>
                  <div class="spacer-h-20"></div>
                </td>
              </tr>
            </table>
          </div>

        </div><!-- leads-block -->

      <!--******** END STUDIO    DATA *****
       ************************************ -->

       <div class="leads-block">

         <!-- NOTES BLOCK
          ************************* -->
         <h2 class="leads-block__title">Studio Notes</h2>

          <div class="spacer-h-20"></div>
          <div class="leads-block__row">
            <p class="no-notes no-notes leads-block__comment" v-if="computed_studio_notes.length === 0">No notes there yet</p>
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
       </div>

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
                <input type="text" class="leads-block__input_xs leads-block__input to-right" v-model="order_data.location.unit" placeholder="Add">
              </td>
            </tr>
            <tr>
              <td></td>
              <td class="text-right">
                <input type="text" class="leads-block__input_xs leads-block__input to-right" v-model="order_data.location.box" placeholder="Add">
              </td>
            </tr>
          </table>
        </div>
      </div><!-- leads-block -->
      <!--****** PRODUCT LOCATION END *****
      ************************************ -->

      <?php /*
      <!-- ************************************
           ******** GALLERY START ********* -->
      <div class="leads-block">
        <h2 class="leads-block__title">
          <svg class="icon svg-icon-gallery"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-gallery"></use> </svg>
          Gallery
          <span class="float-right">{{get_count_reviews}} Reviews</span>
        </h2>
        <div class="hr"></div>

        <div class="leads-block__row">
          <div class="row gutters-20-15 justify-between" v-if="order_data.wfp_thumbnails">
            <div class="col-4" v-for="(image, key) in order_data.wfp_thumbnails" :key="'image_preview_'+key">
              <div class="gallery-item">
                <img :src="image.attachment_url" alt="">
              </div>
              <div class="spacer-h-20"></div>
            </div><!-- col-4 -->
          </div><!-- row gutters-20-15 justify-between -->

          <div class="row gutters-20-15 justify-between" v-else>
            <div class="col-4" v-for="(image, key) in order_data.wfp_images" :key="'image_preview_'+key">
              <div class="gallery-item">
                <img :src="get_image_url(image)" alt="">
              </div>
              <div class="spacer-h-20"></div>
            </div><!-- col-4 -->
          </div><!-- row gutters-20-15 justify-between -->
        </div><!-- leads-block__row -->
      </div><!-- leads-block -->

      <!--****** GALLERY END **************
       ************************************ -->

       */ ?>


      <!-- ************************************
      ******** START COLLECTIONS DATA ***** -->

      <div class="leads-block">
        <h2 class="leads-block__title">
          Product Collection

          <div class="toggler" v-bind:class="{active:order_data.product_collection.do_collect}" v-on:click="do_toggler">
            <div class="toggler__inner"></div>
            <div class="toggler__trigger"></div>
          </div>
        </h2>

        <div class="spacer-h-20"></div>

        <transition
          v-on:before-enter="animation_beforeEnter"
          v-on:animation-after="animation_enterAfter"
          v-on:enter="animation_enter"
          v-on:leave="animation_leave"
          v-bind:css="false"
        >
          <div class="leads-block__row" v-if="order_data.product_collection.do_collect">
            <table class="leads-block__data">
              <tbody>
                <tr v-if="order_data.product_collection.address_billing">
                  <td class="width-150">
                    <span class="leads-block__label lh-18 no-margin">Billing <br> Address</span>
                  </td>
                  <td class="width-">
                    <span class="leads-block__text">{{order_data.product_collection.address_billing}} </span>
                  </td>
                </tr>
                <tr>
                <tr v-if="order_data.product_collection.address_shipping">
                  <td class="width-150">
                    <span class="leads-block__label lh-18 no-margin">Shipping <br> Address</span>
                  </td>
                  <td class="width-">
                    <span class="leads-block__text">{{order_data.product_collection.address_shipping}} </span>
                  </td>
                </tr>
                <tr>
                  <td class="width-150">
                    <span class="leads-block__label no-margin">Address</span>
                  </td>
                  <td class="width-150">
                    <a href="#" class="add-button" v-on:click.prevent="shop_popup('address')" v-if="!order_data.product_collection.address">+ New Address</a>
                    <span class="leads-block__text">{{order_data.product_collection.address}} </span>
                  </td>
                </tr>
                <tr>
                  <td class="width-150">
                    <span class="leads-block__label no-margin">Requested</span>
                  </td>
                  <td class="width-250">
                    <span class="leads-block__text" v-if=" order_data.product_collection.requested">{{order_data.product_collection.requested}} </span>

                    <datepicker-styled
                      v-if="!order_data.product_collection.requested"
                      v-bind:_name="'requested'"
                      v-bind:_value="order_data.product_collection.requested"
                      v-on:input_value_changed="update_order($event, 'product_collection')"
                       ></datepicker-styled>
                  </td>
                </tr>
                <tr>
                  <td class="width-150">
                    <span class="leads-block__label no-margin">Scheduled</span>
                  </td>
                  <td class="width-250">
                    <datepicker-styled
                      v-bind:_name="'scheduled'"
                      v-bind:_value="order_data.product_collection.scheduled"
                      v-on:input_value_changed="update_order($event, 'product_collection')"
                       ></datepicker-styled>
                  </td>
                </tr>
                <tr v-for="url, key in order_data.product_collection.pdf" :key ="'pdf_'+key">
                  <td colspan="2">
                    <a :href="url" class="pdf-link" target="_blank">
                      <img src="<?php echo THEME_URL ?>/order_tracker/assets/images/pdf.png" alt="">
                    </a>
                    <div class="spacer-h-10"></div>
                  </td>
                </tr>
                <tr v-if="order_data.product_collection.pdf.length == 0">
                  <td class="width-150">
                     <p class="leads-block__text no-margin">{{file_name}}</p>
                  </td>
                  <td class="width-250 text-right">
                    <label class="add-button-upload"><svg class="icon svg-icon-upload"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-upload"></use> </svg> Upload PDF
                      <input type="file" v-on:change="update_pdf" ref="upload_pdf_input">
                      <svg class="icon svg-icon-upload2"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-upload2"></use> </svg>
                    </label>
                  </td>
                </tr>
              </tbody>
            </table>
          </div><!-- leads-block__row -->
        </transition>
      </div><!-- leads-block -->

      <!--******** END COLLECTIONS DATA *****
       ************************************ -->
    </div><!-- col-12 col-lg-4 col-xl-3 -->
  </div>

  <!-- ********************************
  ************* END COLUMNS ***********
  **********************************-->
  <div class="spacer-h-30"></div>
  <div class="image-preview-popup"
   v-bind:class="{shown: show_popup_preview}"
   v-on:click="show_popup_preview = !show_popup_preview">
    <div class="image-preview-popup__inner" v-on:click.stop>
      <i class="icon-close" v-on:click="show_popup_preview = !show_popup_preview">×</i>
    </div>
  </div>

  <download-popup-comment
    ref="comment_data"
    v-on:update_decision="update_decision_cb"
  ></download-popup-comment>

  <preview-popup
    ref="preview_popup"
  >
  </preview-popup>

</div>
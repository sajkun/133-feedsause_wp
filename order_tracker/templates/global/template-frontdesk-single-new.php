<?php
if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}
?>
<div class="container-lg single-order" id="new-frontdesk-order" v-if="visible">
  <div class="spacer-h-40"></div>

    <!-- ********************************
    ******** START HEADER BUTTONS *******
    **********************************-->
    <div class="single-order__top row">
      <div class="col-6">
        <a href="#" class="go-back" v-on:click.preventdefault="return_to_list">
           <svg class="icon svg-icon-arrow-left"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-arrow-left"></use> </svg>
          <span>Back to Hub</span>
        </a>
          <reminder v-on:input_value_changed="update_reminder($event)" v-bind:placeholder="'MM dd YYYY hh:mm'" _name="reminder"></reminder>
      </div>

      <div class="col-6 text-right">

            <order-status-select ref="order_status"
               _select_name="order_status"
               v-bind:_options='order_statuses'
               v-bind:_current_status='order_data.order_status'
               v-bind:class="'text-left'"
               v-on:update_list="update_order_status"></order-status-select>

        <a href="#"  v-on:click.prevent="save_order" class="button-save-order">
           <svg class="icon svg-icon-ok-marker"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-ok-marker"></use> </svg>
          Create
        </a>
      </div>
    </div><!-- single-order__top -->

    <!-- ********************************
    ******** END HEADER BUTTONS *******
    **********************************-->

    <div class="spacer-h-40"></div>

    <!-- ********************************
    ******** START COLUMNS       *******
    **********************************-->

    <div class="single-order__columns row">
      <div class="col-12 col-lg-4">
        <!-- ********************************
        ******** START CUSTOMER DATA  **** -->
          <div class="leads-block">
            <form action="">
              <!-- block title
              ************************* -->
              <h2 class="leads-block__title">
                <svg class="icon svg-icon-customer"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-customer"></use> </svg>
                Customer
                <span class="icons">
                  <span class="phones">
                    <i class="phone-ok icon" v-on:click="change_order_data_value ('phone_count', order_data.phone_count-1)" v-for="n in order_data.phone_count"></i><i class="phone-na icon" v-for="n in phone_left" v-on:click="change_order_data_value ('phone_count', order_data.phone_count+1)"></i>
                  </span>
                  <span class="messages">
                    <i class="message-ok icon"  v-for="n in order_data.message_count" v-on:click="change_order_data_value ('message_count', order_data.message_count-1)"></i><i class="message-na icon"  v-for="n in messages_left" v-on:click="change_order_data_value ('message_count', order_data.message_count +1)"></i>
                  </span>
                </span>
              </h2>

              <div class="hr"></div>

               <!-- ASSIGNED SPECIALIST
                ************************* -->

                <div class="row no-gutters">
                  <div class="col-5 valign-center">
                    <span class="leads-block__title">
                       <svg class="icon  svg-icon-human grey"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-human"></use> </svg>
                       Assigned<span class="mark">*</span>
                    </span>
                  </div>
                  <div class="col-6">
                    <user-select
                    v-bind:_select_name="'assigned'"
                    v-bind:_current_user="order_data.customer.assigned"
                    v-on:user_select_change="update_order($event, 'customer')"></user-select>
                  </div>
                </div>

              <div class="hr"></div>

              <div class="spacer-h-10"></div>

              <!-- CUSTOMER DATA
              ************************* -->
              <div class="leads-block__row">
                <div class="leads-block__name">

                  <customer_name
                    v-bind:_name="'cusomer_data'"
                    v-bind:_value="order_data.name"
                    v-on:input_value_changed="update_customer($event)"></customer_name>
                    <div class="spacer-h-20"></div>

                  <span class="leads-block__comment">Added {{order_data.customer.date_added}}</span>
                </div>

                <div class="spacer-h-10"></div>

                <table class="leads-block__data">
                  <tr>
                    <td>
                      <svg class="icon svg-icon-phone"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-phone"></use> </svg>
                    </td>
                    <td><p class="leads-block__label">Phone</p></td>
                    <td>
                      <input-field
                        _name="phone"
                        v-model="order_data.customer.phone"
                         v-bind:class="{'styled' : new_order}"
                        v-bind:_value="order_data.customer.phone"
                        v-on:input_value_changed="update_order($event, 'customer')"></input-field>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <svg class="icon svg-icon-email"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-email"></use> </svg>
                    </td>
                    <td><p class="leads-block__label">E-mail</p></td>
                    <td>
                      <input-field
                        _name="email"
                        v-bind:class="{'styled' : new_order}"
                        v-model="order_data.customer.email"
                        v-bind:_value="order_data.customer.email"
                        v-on:input_value_changed="update_order($event, 'customer')"></input-field>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <svg class="icon svg-icon-sourses"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-sourses"></use> </svg>
                    </td>
                    <td><p class="leads-block__label">Source</p></td>
                    <td>

                      <select-imitation
                       v-bind:class="'fullwidth'"
                        _select_name="source"
                        v-bind:_options="order_sources"
                        v-bind:_selected="order_data.customer.source"
                        v-on:update_list="update_order($event, 'customer')"
                        ></select-imitation>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <svg class="icon svg-icon-diamond"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-diamond"></use> </svg>
                    </td>
                    <td><p class="leads-block__label">Brand</p></td>
                    <td>
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

             <div class="spacer-h-30"></div>

             <!-- NOTES BLOCK
              ************************* -->
             <h2 class="leads-block__title">Enquiry Notes</h2>

             <div class="spacer-h-20"></div>

              <div class="leads-block__row">
                <p class="no-notes" v-if="computed_enquery_notes.length === 0">No notes there yet</p>
                <div v-for="note,key in computed_enquery_notes" class="note-block">
                  <div class="note-block__header clearfix">
                    <span class="name">{{note.user_name}}</span>
                    <span class="date">{{note.date}}</span>

                    <i class="remove-note-icon"  v-on:click="delete_note(note.key, 'enquery')">
                      <svg class="icon svg-icon-trash"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-trash"></use></svg>
                    </i>
                  </div>

                  <div class="note-block__body" v-bind:class="{'manager-note': note.is_manager == 'yes'}">
                   <span class="inner">{{note.text}}</span>
                   <i class="icon-manager-done" v-on:click="mark_note_done(note.key, 'no')" v-if="note.is_manager == 'yes' && note.done =='yes'"></i>

                    <i class="icon-manager-done not" v-on:click="mark_note_done(note.key, 'yes')" v-if="note.is_manager == 'yes' && note.done !='yes'"></i>
                  </div>
                </div>

                <span class="note-block__show-more" v-on:click="enquery_notes_count = 9999" v-if="enquery_notes_count < computed_enquery_notes_count"> <i class="icon"></i> Show {{computed_enquery_notes_count - 1}} more</span>
                <div class="spacer-h-20"></div>
              </div>

              <form id="message-form-reception-new" v-on:submit.prevent  v-on:submit="add_note('enquery')" >
                <div class="leads-block__form">

                <textarea name="text" placeholder="Enter new note…" ref="note_textarea_enquery" v-model="enquery_note_text" @keyup.alt.enter="add_note('enquery')" @keyup.ctrl.enter="add_note('enquery')" title="use Enter for line breaks, use Alt+Enter to add note"></textarea>

                <button type="submit" class="button-submit">
                  <svg class="icon svg-icon-send"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-send"></use> </svg>
                </button>

                </div>
              </form>
          </div><!-- leads-block -->

        <!-- *** END CUSTOMER DATA  *******
        **********************************-->
      </div><!-- col-12 col-lg-4 -->

      <div class="col-12 col-lg-4">

        <!-- ********************************
        ******** START ORDER DATA   ***** -->
          <div class="leads-block">
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

            <div class="leads-block__row" v-if="order_data.address_billing">
            <table class="leads-block__data">
              <tbody>
                <tr>
                  <td class="width-100">
                    <span class="leads-block__label no-margin">Billing Address: &nbsp;</span>
                  </td>
                  <td class="width-250">
                    <span class="leads-block__text">{{order_data.address_billing}} </span>
                  </td>
                </tr>
                </tbody>
              </table>
            </div>
            <div class="hr" v-if="order_data.address_billing"></div>

            <div class="leads-block__row">
              <a href="#" class="add-button new-order-item" v-on:click.prevent="shop_popup('product')">
                + Product
              </a>
              <a href="#" class="add-button" v-on:click.prevent="shop_popup('fee')">
                + Fee
              </a>
              <a href="#" class="add-button add-address-btn" v-on:click.prevent="shop_popup('billing_address')">
                + Address
              </a>
            </div><!-- leads-block__row -->
            <div class="hr"></div>

            <div class="products-block">
              <div class="products-block__item" v-for="(item, key) in order_data.order.items" :key="'product_'+key">
                <div class="products-block__item-head row">
                  <div class="col-4">
                   <span class="products-block__item-title"> {{item.product_name}}</span>
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

                  <div class="col-1">
                    <span class="remove-btn" v-on:click="remove_product(key)">-</span>
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
                      <div class="col-5">Product</div>
                      <div class="col-7">{{item.title}}</div>
                    </div>
                    <div class="row">
                      <div class="col-5">Sizes</div>
                      <div class="col-7">{{item.sizes.join(', ')}}</div>
                    </div>
                    <div class="row">
                      <div class="col-5">Note</div>
                      <div class="col-7"> {{item.notes}}</div>
                    </div>
                  </div>
                </transition>
              </div>

              <div class="products-block__item" v-for="(item, key) in order_data.order.fee" :key="'fee_'+key">
                <div class="products-block__item-head row">
                  <div class="col-4">
                   <span class="products-block__item-title"> {{item.fee_name}}</span>
                  </div>

                  <div class="col-120">
                  </div>

                  <div class="col text-left">
                    <span class="products-block__item-title"> {{order_data.order.currency_symbol}}{{item.price}}</span>
                  </div>

                  <div class="col-1 text-right">
                  </div>

                  <div class="col-1">
                    <span class="remove-btn" v-on:click="remove_fee(key)">-</span>
                  </div>
                </div>
              </div>
            </div>

            <div class="leads-block__row">
              <table class="leads-block__data">
                <tbody>
                  <tr  v-for="(addon, addon_key) in order_data.order.addons" >
                    <td  class="width-110">
                      <p class="leads-block__label no-margin">{{addon.title}}</p>
                    </td>
                    <td class="width-150">
                       <select-imitation-obj
                         :ref="addon_key"
                         v-if="addon_key != 'discount'"
                         v-bind:class="'fullwidth'"
                         v-bind:_select_name="addon_key"
                         v-bind:_options="order_addons[addon_key]"
                         v-on:update_list="update_order_addon($event, addon_key);"
                         ></select-imitation-obj>

                       <coupon-field
                        v-if="addon_key == 'discount'"
                        :_name="'discount'"
                        :_value="''"
                        :_currency="order_data.order.currency_symbol"
                        :_placeholder="'Enter coupon code'"
                        v-model="order_data.order.addons.discount.name"
                        v-on:input_value_changed = 'update_coupon'
                        v-bind:style="{zIndex: 1}"
                       ></coupon-field>
                    </td>
                    <td>
                      <p class="leads-block__label"  v-if="addon_key != 'discount'">{{order_data.order.currency_symbol}}{{addon.price}}</p>
                      <p class="leads-block__label"  v-if="addon_key == 'discount'">{{order_data.order.addons.discount.price}}</p>
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
                    <td class="width-150">
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


        <!-- ************************************
        ******** START COLLECTIONS DATA ***** -->

        <div class="leads-block">
          <h2 class="leads-block__title">
            Product Collection

            <div class="toggler" v-bind:class="{active:order_data.product_collection.do_collect}" v-on:click="order_data.product_collection.do_collect =! order_data.product_collection.do_collect">
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
                      <span class="leads-block__text" v-if="!new_order && order_data.product_collection.requested">{{order_data.product_collection.requested}} </span>

                      <datepicker-styled
                        v-if="new_order || !order_data.product_collection.requested"
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
                  <tr v-for="pdf, key in order_data.product_collection.pdf" :key ="'pdf_'+key">
                    <td colspan="2">
                      <a href="" class="pdf-link">
                        <img src="<?php echo THEME_URL ?>/order_tracker/assets/images/pdf.png" alt="">
                      </a>
                    </td>
                  </tr>
                  <tr>
                    <td class="width-150">
                      <p class="leads-block__text no-margin">{{file_name}}</p>
                    </td>
                      <td class="width-250 text-right">
                        <label class="add-button"><svg class="icon svg-icon-upload"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-upload"></use> </svg> Upload PDF
                          <input type="file" v-on:change="update_pdf" ref="upload_pdf_input">
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
      </div><!-- col-12 col-lg-4 -->

      <div class="col-12 col-lg-4">

        <!-- ************************************
        ******** START STUDIO DATA ***** -->
          <div class="leads-block">
            <h2 class="leads-block__title">
              <svg class="icon svg-icon-frdk"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-frdk"></use> </svg>
              Studio
            </h2>
            <div class="hr hr-bottom-0"></div>

            <div class="leads-block__row">
              <table class="leads-block__data">
                <tr>
                  <td>
                    <svg class="icon svg-icon-team"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-team"></use> </svg>
                  </td>
                  <td><p class="leads-block__label no-margin">Creator</p></td>
                  <td>
                    <user-select
                    v-bind:_select_name="'creator'"
                    v-bind:_current_user="order_data.studio.creator"
                    v-on:user_select_change="update_order($event, 'studio')"></user-select>
                  </td>
                </tr>
              </table>
              <div class="clearfix"></div>
            </div>


           <!-- NOTES BLOCK
            ************************* -->
           <div class="spacer-h-20"></div>

           <h2 class="leads-block__title">Studio Notes</h2>

           <div class="spacer-h-20"></div>
              <div class="leads-block__row">
                <p class="no-notes" v-if="computed_studio_notes.length === 0">No notes there yet</p>
                <div v-for="note,key in computed_studio_notes" class="note-block">
                  <div class="note-block__header clearfix">
                    <span class="name">{{note.user_name}}</span>
                    <span class="date">{{note.date}}</span>

                    <i class="remove-note-icon"  v-on:click="delete_note(note.key, 'studio')">
                      <svg class="icon svg-icon-trash"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-trash"></use></svg>
                    </i>
                  </div>

                  <div class="note-block__body" v-bind:class="{'manager-note': note.is_manager == 'yes'}">
                   <span class="inner">{{note.text}}</span>
                   <i class="icon-manager-done" v-on:click="mark_note_done(note.key, 'no')" v-if="note.is_manager == 'yes' && note.done =='yes'"></i>

                    <i class="icon-manager-done not" v-on:click="mark_note_done(note.key, 'yes')" v-if="note.is_manager == 'yes' && note.done !='yes'"></i>
                  </div>
                </div>

                <span class="note-block__show-more" v-on:click="studio_notes_count = order_data.messages.studio.length + 9999" v-if="studio_notes_count < computed_studio_notes_count"> <i class="icon"></i> Show {{this.order_data.messages.studio.length - 1}} more</span>
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

        <!-- ************************************
             ******** GALLERY START ********* -->
        <div class="leads-block">
          <h2 class="leads-block__title">
            <svg class="icon svg-icon-gallery"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-gallery"></use> </svg>
            Gallery
            <span class="float-right">{{order_data.gallery.comments}} Reviews</span>
          </h2>
          <div class="hr"></div>

          <div class="leads-block__row">
            <div class="row gutters-20-15 justify-between">
              <div class="col-4" v-for="(url, key) in order_data.gallery.items" :key="key">
                <div class="gallery-item">
                  <img :src="url" alt="">
                </div>
                <div class="spacer-h-20"></div>
              </div><!-- col-4 -->
            </div><!-- row gutters-20-15 justify-between -->
          </div><!-- leads-block__row -->
        </div><!-- leads-block -->

        <!--****** GALLERY END **************
         ************************************ -->
      </div><!-- col-12 col-lg-4 -->
    </div>

    <!-- ********************************
    ************* END COLUMNS ***********
    **********************************-->
    <div class="spacer-h-30"></div>
</div>
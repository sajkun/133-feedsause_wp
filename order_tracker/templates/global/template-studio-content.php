<?php
if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}
?>

<script type="text/x-template" id="studio-single-content">
  <div class="container-lg" v-if="visible">
    <div class="row full-height">


      <div class="col-4">
        <!-- ******************************
        ********** ORDER DATA ***********
        *********************************-->
          <div class="spacer-h-50"></div>
          <a href="#" class="go-back" v-on:click.prevent="back_to_list">
             <svg class="icon svg-icon-arrow-left"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-arrow-left"></use> </svg>
            <span>Back to Hub</span>
          </a>

          <div class="spacer-h-40"></div>

          <!--************************
          ******** order details******-->

          <div class="leads-block">
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
              <div class="products-block__item" v-for="(item, key) in order_data.order.items" :key="key">
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
                    <div class="row">
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

                  <div class="col-150">
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

          <!--*****end order details******
          **************************-->

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
                      <p class="products-block__item-title">
                        {{order_data.location.unit}}
                      </p>
                    </td>
                  </tr>
                  <tr>
                    <td></td>
                    <td class="text-right width-150">
                      <p class="products-block__item-title">
                        {{order_data.location.comment}}
                      </p>
                    </td>
                  </tr>
                </table>
              </div>
            </div><!-- leads-block -->
          <!--****** PRODUCT LOCATION END *****
          ************************************ -->

          <!--************************
          *******studio notes**********-->

           <div class="leads-block">
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

          <!--*****end studio notes*******
          **************************-->

        <!-- ******************************
        *******END ORDER DATA ***********
        *********************************-->
          <div class="spacer-h-60"></div>
      </div>

      <div class="col upload-area ">
        <div class="spacer-h-40"></div>

        <div class="upload-area__header row">
          <div class="col">
            <p class="upload-area__header-label">Due</p>
            <p class="upload-area__header-value">{{due_date}}</p>
            <p class="upload-area__header-comment" v-if="due_date != '-' && number_of_dates_left">
              <svg class="icon svg-icon-due"><use xmlns:xlink="ttp://www.w3.org/1999/xlink" xlink:href="#svg-icon-due"></use></svg>

              <span v-if="number_of_dates_left.diff > 0">
                You have <span class="marked">{{number_of_dates_left.diff}} {{number_of_dates_left.label}} left</span> <br>
                to submit photos
              </span>

              <span v-if="number_of_dates_left.diff <= 0">
                <span class="marked">You are <b>{{Math.abs(number_of_dates_left.diff)}} {{number_of_dates_left.label}} late</b> <br>
                to submit photos</span>
              </span>
            </p>
          </div>
          <div class="col">
            <p class="upload-area__header-label">Photos</p>
            <p class="upload-area__header-value">{{number_of_photos}}</p>
          </div>
          <div class="col">
            <p class="upload-area__header-label">Reviews</p>
            <p class="upload-area__header-value">{{number_of_comments}}</p>
          </div>
          <div class="col text-right">
            <a href="#" v-on:click.prevent="exec_upload" class="upload-area__submit">Submit Photos</a>
          </div>
        </div><!-- upload-area__header -->


        <div class="upload-area__body">
          <div class="row">
            <upload-item
              v-for="(n, i) in number_of_photos"
              :_number = "n"
              :_item_id = "i"
              :key     = "'upload_item_'+i"
              :_comments = get_comments_for_image(i)
              :_files_uploaded = files_uploaded[i]
              v-on:show_image = 'show_image_popup'
              v-on:file_changed = "update_files"

            ></upload-item>
          </div><!-- row -->
        </div><!-- upload-area__body -->
      </div><!-- upload-area -->
    </div><!-- row -->
    <div class="image-preview-popup"
     v-bind:class="{shown: show_popup_preview}"
     v-on:click="show_popup_preview = !show_popup_preview">
      <div class="image-preview-popup__inner" v-on:click.stop>
        <i class="icon-close" v-on:click="show_popup_preview = !show_popup_preview">×</i>
      </div>
    </div>
  </div><!-- container-lg -->
</script>
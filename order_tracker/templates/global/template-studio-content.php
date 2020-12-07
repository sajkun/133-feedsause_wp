<?php
if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}
echo '<script type="text/x-template" id="studio-single-content">';
?>

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

            <a href="#"  v-if="show_start_shoot_btn" v-on:click.prevent="show_shoot_popup" class="upload-area__shoot">Start Shooting</a>

            <a href="#"  v-if="show_submit_button"
              v-on:click.prevent="do_upload"
              v-bind:class="{grey: !files_to_load_exist}"
              class="upload-area__submit">Submit Photos</a>
          </div>
        </div><!-- upload-area__header -->
        <div class="upload-area__body">
          <div class="row" v-if="shoot_started || is_old_order">
           <upload-item-exists
              v-for="(file, i) in files_uploaded"
              :_number = "i + 1"
              :_item_id = "i"
              :thumbs_file     = "get_thumb_from_file()"
              :key     = "'upload_item_'+i"
              :_comments = "get_comments_for_image(i)"
              :_files_uploaded = "file"
              :_is_old_order = "is_old_order"
              v-on:show_image = 'show_image_popup'
              v-on:file_changed = "update_files"
              v-on:change_thumbnail = "change_thumbnail"
            ></upload-item-exists>

           <upload-item-exists
               v-if= "is_single_order"
               :_number = "1"
               :thumbs_file     = "get_thumb_from_file()"
              :_item_id = "0"
              :_comments = "[]"
              :_files_uploaded = "single_order_files"
              :_is_old_order = "1"
              v-on:show_image = 'show_image_popup'
              v-on:file_changed = "update_files"
              v-on:change_thumbnail = "change_thumbnail"
            ></upload-item-exists>

            <upload-item
              v-for="(file, i) in watch_files_prepared"
              :_number         = "get_index_prepared(i) + 1"
              :thumbs_file     = "get_thumb_from_file()"
              :_item_id        = "get_index_prepared(i)"
              :key             = "'upload_item_prepared_'+get_index_prepared(i)"
              :_comments       = "[]"
              :_files = "file"
              :_files_uploaded = "files_uploaded[get_index_prepared(i)]"
              v-on:show_image = "show_image_popup"
              v-on:file_changed = "update_files"
              v-on:change_thumbnail = "change_thumbnail"
            ></upload-item>

            <upload-item-blank
               v-if = "!is_old_order && !is_single_order"
              :_blank_number = "blank_item_id  + 1"
              :_blank_item_id = "blank_item_id"
              v-on:file_changed_blank = "update_files_blank"
            ></upload-item-blank>
          </div><!-- row -->

          <div class="upload-item" v-if="!shoot_started && !is_old_order">
            <div class="upload-item__header">
              <div class="upload-item__state">
              </div>
              <div class="upload-item__comments">
              </div>
            </div><!-- upload-item__header -->

            <div class="upload-item__body">
              <div class="upload-item__drop-area">
                <img src="<?php echo THEME_URL; ?>/order_tracker/assets/images/start-shoot.png" alt="">
              </div>
            </div>
          </div><!-- upload-item -->
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

<?php echo'</script>'; ?>
<?php
if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}
?>
<div id="studio-vue-app">
  <!-- **********************************
  ************ STARTS FILTERS ***********
  ***********************************-->
  <div class="container-lg switchers" v-show="visible.filters">
    <div class="spacer-h-40"></div>
    <div class="row  justify-content-start item-margins">
      <div class="alert">
        <div class="checkbox-imitation inline">
          <label>
             <input type="checkbox" name="show_overdue_only" v-model="only_with_messages">
             <span class="checkbox-imitation__view"></span>
          </label>
        </div>

        <svg class="icon svg-icon-review-mode"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-review-mode"></use> </svg>
        <span class="alert__count">{{comment_count}}</span>
      </div>

      <div class="alert">
        <div class="checkbox-imitation inline">
          <label>
             <input type="checkbox" name="fastrack" v-model="fasttrack">
             <span class="checkbox-imitation__view"></span>
             <span class="checkbox-imitation__text">
               <svg class="icon svg-icon-fastrack2"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-fastrack2"></use> </svg>
               Fast Track
             </span>
          </label>
        </div>
      </div>

        <div class="range-datepicker">
        <svg class="icon svg-icon-calendar"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-calendar"></use> </svg>

        <input type="hidden" id="page_type" value="studio">

        <span class="range-datepicker__label">Custom Range</span>
        <span class="range-datepicker__text">Apr 01 2020 → Nov 27 2020</span>

        <span class="range-datepicker__arrow"></span>

      </div><!-- range-datepicker -->

      <select-imitation-icon v-for="filter_val, filter_name in filters" :_select_name="filter_name" :_selected="filter_val" :_options="filter_values[filter_name]" :_icon="icons_selects[filter_name]" :ref="filter_name" :key="filter_name" v-on:update_list="run_filter_list($event)">
       </select-imitation-icon>
    </div><!-- row -->
    <div class="spacer-h-30"></div>
  </div><!-- container-fluid -->

  <!-- **********************************
  ************ END FILTERS **************
  ***********************************-->
  <div id="studio_list">
    <div class="horizontal-scroll" v-show="visible.columns">
      <div class="row no-gutters justify-content-start">
        <studio-column
         v-for="(column, index) in columns"
         v-bind:key="'studio_col_'+ column.slug"
         v-bind:_info="column"
         v-bind:_items="column.items"
         v-bind:ref="column.slug"
         v-bind:_count="shifts[column.slug].count"
         v-on:update_order_status_on_drag="update_order_status_on_drag_cb"
         v-on:open_order_col_cb="open_order"
         v-on:trigger_scroll="scroll_items">
        </studio-column>
      </div>
    </div>
  </div>

  <single-studio-content ref="detailed_view" v-on:update_data="update_item_data"></single-studio-content>
</div>
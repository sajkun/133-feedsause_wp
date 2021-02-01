<?php
if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}
?>
<div class="container-xxl switchers" id="filters-frontdesk" v-if="visible">
  <div class="spacer-h-40"></div>
  <div class="row  justify-content-start ">
    <div class="alert">
      <svg class="icon svg-icon-bell green"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-bell"></use> </svg>
      <span class="alert__count">{{due_count}}</span>
      <label>
        <input type="checkbox" class="hidden" v-model="overdue_only">
        <span class="alert__tag overdue">{{overdue_count}} Ovderdue</span>
      </label>
      <div class="checkbox-imitation inline">
        <label>
           <input type="checkbox" name="show_overdue_only" v-model="due_date_only">
           <span class="checkbox-imitation__view"></span>
        </label>
      </div>
    </div>

      <div class="range-datepicker">
      <svg class="icon svg-icon-calendar"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-calendar"></use> </svg>

      <input type="hidden" id="page_type" value="frontdesk">

      <span class="range-datepicker__label">Past 30 Days</span>
      <span class="range-datepicker__text"> Oct 1 2019 → Nov 1 2019</span>

      <span class="range-datepicker__arrow"></span>
    </div><!-- range-datepicker -->

    <select-imitation-icon v-for="filter_val, filter_name in filters" :_select_name='filter_name' :_selected='filter_val' :ref="filter_name" :key="filter_name"  v-on:update_list="run_filter_list($event)"></select-imitation-icon>

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
  </div><!-- row -->
  <div class="spacer-h-30"></div>
</div><!-- container-fluid -->

<div id="frontdesk_list">
  <div class="horizontal-scroll" ref="scroll" v-show="visible">
    <div class="row no-gutters justify-content-center" ref="column_container">
      <frontdesk-column
        v-for="(column, index) in columns"
        v-bind:key    ="column.slug"
        v-bind:_info = "column"
        v-bind:_items ="column.items"
        v-bind:ref     ="column.slug"
        v-bind:_count    ="shifts[column.slug].count"
        v-on:update_order_status_on_drag = "update_order_status_on_drag_cb"
        v-on:open_order_col_cb   = "open_order"
        v-on:trigger_scroll = "scroll_items"
      >
      </frontdesk-column>
    </div>
  </div>
</div>
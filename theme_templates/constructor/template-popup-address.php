
<div class="popup-wrapper visuallyhidden"  id="popup_address" v-show="visible">
  <div class="popup-inner">
    <div class="popup-inner__head">
      <svg width="13" height="14" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:avocode="https://avocode.com/" viewBox="0 0 13 14"><defs></defs><desc>Generated with Avocode.</desc><g><g><title>Path</title><path d="M13.06517,7.20227c-0.07179,0.17476 -0.24161,0.28921 -0.43054,0.29015h-1.40394v0v4.6798c0,0.77538 -0.62856,1.40394 -1.40394,1.40394h-1.87192c-0.25846,0 -0.46798,-0.20952 -0.46798,-0.46798v-2.80788c0,-0.25846 -0.20952,-0.46798 -0.46798,-0.46798h-0.93596c-0.25846,0 -0.46798,0.20952 -0.46798,0.46798v2.80788c0,0.25846 -0.20952,0.46798 -0.46798,0.46798h-1.87192c-0.77538,0 -1.40394,-0.62856 -1.40394,-1.40394v-4.6798v0h-1.40395c-0.18892,-0.00094 -0.35875,-0.11539 -0.43054,-0.29015c-0.07328,-0.17427 -0.03451,-0.37553 0.09828,-0.5101l6.08374,-6.08374c0.08787,-0.0886 0.20749,-0.13843 0.33227,-0.13843c0.12478,0 0.24439,0.04983 0.33226,0.13843l6.08375,6.08374c0.13279,0.13457 0.17156,0.33583 0.09827,0.5101z" fill="#6f7894" fill-opacity="1"></path></g><g><title>home</title><g><title>Path</title><path d="M13.06517,7.20227c-0.07179,0.17476 -0.24161,0.28921 -0.43054,0.29015h-1.40394v0v4.6798c0,0.77538 -0.62856,1.40394 -1.40394,1.40394h-1.87192c-0.25846,0 -0.46798,-0.20952 -0.46798,-0.46798v-2.80788c0,-0.25846 -0.20952,-0.46798 -0.46798,-0.46798h-0.93596c-0.25846,0 -0.46798,0.20952 -0.46798,0.46798v2.80788c0,0.25846 -0.20952,0.46798 -0.46798,0.46798h-1.87192c-0.77538,0 -1.40394,-0.62856 -1.40394,-1.40394v-4.6798v0h-1.40395c-0.18892,-0.00094 -0.35875,-0.11539 -0.43054,-0.29015c-0.07328,-0.17427 -0.03451,-0.37553 0.09828,-0.5101l6.08374,-6.08374c0.08787,-0.0886 0.20749,-0.13843 0.33227,-0.13843c0.12478,0 0.24439,0.04983 0.33226,0.13843l6.08375,6.08374c0.13279,0.13457 0.17156,0.33583 0.09827,0.5101z" fill="#6f7894" fill-opacity="1"></path></g></g></g></svg>

      <span class="title">Add address</span>
      <i class="icon-close" v-on:click="visible=false">×</i>
    </div>

    <div class="spacer-h-20"></div>
<?php /*

    <div class="clearfix" v-if="!country">
      <label>Collection address</label>

      <select-imitation-country
        ref="country"
        v-bind:class="'fullwidth'"
        v-bind:_select_name="'country'"
        v-bind:_options="countries"
        v-bind:_selected="'United Kingdom'"
        v-on:update_list="update_data($event)"
      ></select-imitation-country>
      <div class="spacer-h-20"></div>
    </div> */ ?>


    <div class="clearfix">
      <input type="text" class="popup-inner__field" placeholder="Address line 1" v-model="line_1" ref="line_1">
    </div>
    <div class="spacer-h-20"></div>

    <div class="clearfix">
      <input type="text" class="popup-inner__field" placeholder="Address line 2" v-model="line_2" ref="line_2">
    </div>
    <div class="spacer-h-20"></div>

    <div class="clearfix">
      <input type="text" class="popup-inner__field" placeholder="Town or City" v-model="city" ref="city">
    </div>
    <div class="spacer-h-20"></div>

    <div class="clearfix">
      <input type="text" class="popup-inner__field" placeholder="Postal code" v-model="zip" ref="zip">
    </div>
    <div class="spacer-h-20"></div>


    <div class="clearfix">
      <a href="#" v-on:click.prevent="submit" class="popup-inner__submit">Add address</a>
    </div>

    <div class="spacer-h-20"></div>
  </div>
</div>
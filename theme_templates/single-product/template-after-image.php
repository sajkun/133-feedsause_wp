<?php
  defined( 'ABSPATH' ) || exit;

  /**
  * Template to dipslay a button and text on single product's page after gallery
  */
?>

<div class="spacer-h-30"></div>
<div class="single-recipe__about hidden-xs">
  <b class="single-recipe__about-text">Got a question about ordering your photos?</b>
  <span class="single-recipe__about-text">Chat live with a Creative Expert from our team</span>

  <div class="clearfix"></div>

  <a href="javascript:void(0)" class="button button_chat" onclick="Intercom('show')">
    <span class="item item1"></span>
    <span class="item item2"></span>
    <span class="item item3"></span>
    Live Support
  </a>

</div>
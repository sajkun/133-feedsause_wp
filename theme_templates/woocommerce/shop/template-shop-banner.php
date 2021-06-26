<?php
defined( 'ABSPATH' ) || exit;
/**
* Shop banner template
*/
?>
<div class="decoration-shop text-center lazy-bg" data-src="<?php echo THEME_URL; ?>/images/bg/shop-deco.jpg">
  <div class="spacer-h-55"></div>
  <span class="decoration-shop__cat">EENIE MEENIE MINEY MO</span>
  <div class="spacer-h-15"></div>
  <h2 class="decoration-shop__title"> Need a hand?
    Ask an expert. </h2>

  <div class="spacer-h-30"></div>

  <a href="" class="large-decoration__chat">
    <i class="chat-icon online" onclick="Intercom('show')">
      <svg class="icon svg-icon-chat"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-chat"></use> </svg>
      <i class="status"></i>
    </i>
    <span>Live Chat</span>
  </a>
</div>
<div class="spacer-h-30"></div>
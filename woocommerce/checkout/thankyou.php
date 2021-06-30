<?php
/**
 * Thankyou page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/thankyou.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see       https://docs.woocommerce.com/document/template-structure/
 * @author    WooThemes
 * @package   WooCommerce/Templates
 * @version     3.2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

$first_name = get_user_meta(get_current_user_id(), 'first_name', true);
?>

  <div class="thank-you">
    <div class="thank-you__inner container-lg">
      <div class="spacer-h-50"></div>

      <span class="large-decoration__tag">
        <img src="<?php echo THEME_URL; ?>/images/svg/oval-green.svg" alt="">
        <span class="text">Thank you for your order</span>
      </span>

      <div class="spacer-h-30"></div>

      <h2 class="thank-you__title">
        Now, <?php echo $first_name ?> <br>
        <span class="marked">the fun begins</span>
      </h2>

      <p class="thank-you__text">We’re getting the cameras ready now so start preparing your
      products! We’ll notify you once your shoot has been accepted by
       one of our photographers.</p>

      <div class="spacer-h-40"></div>

      <div class="thank-you__holder text-left">
        <a href="<?php echo (wc_get_account_endpoint_url( 'orders' ))  ?>" class="thank-you__button">Track Shoot</a>
        <a href="<?php echo get_permalink(woocommerce_get_page_id( 'shop' ))  ?>" class="thank-you__link">  <img src="<?php echo THEME_URL; ?>/images/svg/glasses.svg" alt=""> Get Inspired
        </a>
      </div>
      <div class="spacer-h-50"></div>
    </div><!-- thank-you__inner -->
  </div><!-- thank-you -->


<script>
  jQuery(document).ready(function(){
    var height = jQuery('.site-header').height() + parseInt( jQuery('.site-header').css('padding-top')) + parseInt( jQuery('.site-header').css('padding-bottom')) + jQuery('.site-footer').height() + parseInt( jQuery('.site-footer').css('padding-top')) + parseInt( jQuery('.site-footer').css('padding-bottom'))+80;
    console.log(height);
    jQuery('.thank-you').css({'min-height': 'calc(100vh - '+height+'px'})
  })
</script>
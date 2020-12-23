<?php
/**
 * Empty cart page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart-empty.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.0
 */

defined( 'ABSPATH' ) || exit;

/*
 * @hooked wc_empty_cart_message - 10
 */
do_action( 'woocommerce_cart_is_empty' );

if ( wc_get_page_id( 'shop' ) > 0 ) : ?>

<div class="container container_sm">
  <div class="woocommerce-notices-wrapper"></div>   <div class="textcenter cart-empty-block"><div class="spacer-h-50"></div><div class="clearfix"><img width="113" height="122" alt="Empty Cart" src="https://feedsauce.com/wp-content/themes/velesh_theme/images/empty.png"></div><div class="spacer-h-30"></div> <span class="page-title__comment empty-cart-comment"><svg class="icon svg-icon-lock"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-lock"></use> </svg> <span>Secure Checkout</span></span> <h3 class="cart-title">Your cart is empty</h3><span class="cart-comment">Let’s load up on the sauce, it’s feeling a little lonely<br>this side of the kitchen!</span> <div class="spacer-h-30"></div> <a href="<?php echo get_permalink( wc_get_page_id( 'shop' ) )?>" class="checkout__submit regular-checkout-submit ">Create Images<i class="icon-arrow"></i><i class="icon-arrow"></i></a></div>

</div>
<?php endif; ?>

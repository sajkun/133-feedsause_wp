<?php
/**
 * Review order table
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/review-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$options = get_theme_checkout_content();


?>
<div class="shop_table woocommerce-checkout-review-order-table">

		<span class="checkout__aside-tag">YOUR ORDER</span>
		<?php
			do_action( 'woocommerce_review_order_before_cart_contents' );
			$helper = new theme_formatted_cart();
			foreach ( $helper->get_cart()  as $cart_item_key => $cart_item ) {
			?>
			<div class="checkout__aside-block checkout-item">
        <span class="checkout-item__price"><?php echo wc_price($cart_item['price']['line_total']); ?></span>
        <span class="checkout-item__title"><?php echo $cart_item['name']; ?></span>

          <div class="clearfix expand-details">
            <div class="clearfix">
                <span class="checkout-item-new-detail">
                  <svg class="icon svg-icon-box"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-box"></use> </svg>
                  <?php echo $cart_item['count_items']; ?>
                  <?php
                  	echo _n('Product', 'Products', $cart_item['count_items']);
                   ?>
                </span>
                <?php
                if ($cart_item['count_images'] > 0): ?>

                <span class="checkout-item-new-detail">
                  <svg class="icon svg-icon-items"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-items"></use> </svg>
                  <?php echo $cart_item['count_images']; ?>
                  <?php
                  	echo _n('Photo', 'Photos', $cart_item['count_images']);
                   ?>
                </span>
                <?php endif ?>
             </div>


            <?php

            if(in_array( gettype($cart_item['sizes']), array('array', 'object') ) && count( $cart_item['sizes']) > 0){ ?>

            <div class="clearfix">
              <svg class="icon svg-icon-size"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-size"></use> </svg>
              <span class="checkout-item-new-detail">
                <?php echo implode(', ', $cart_item['sizes']); ?>
              </span>
            </div>
            <?php } ?>

            <?php if($cart_item['comment']){ ?>
            <div class="clearfix">
              <svg class="icon svg-icon-pen"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-pen"></use> </svg>
              <span class="checkout-item-new-detail">
                <?php echo $cart_item['comment']; ?>
              </span>
            </div>
            <?php } ?>
          </div>
          <a href="javascript:void(0)"  class="trigger-expand-details">[<span class="state">+</span>] Details</a>
      </div>
			<?php

			}
			theme_content_output::print_checkout_estimates();
			theme_content_output::print_checkout_totals();


			do_action( 'woocommerce_review_order_after_cart_contents' );
		?>

		<?php do_action( 'woocommerce_review_order_before_order_total' ); ?>

		<?php do_action( 'woocommerce_review_order_after_order_total' ); ?>
</div>
<?php

?>
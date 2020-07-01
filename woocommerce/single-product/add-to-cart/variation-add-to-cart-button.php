<?php
/**
 * Single variation cart button
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

global $product;
?>
<div class="woocommerce-variation-add-to-cart variations_button">
	<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

	<?php
	do_action( 'woocommerce_before_add_to_cart_quantity' );
  echo '<div class="hidden">';
	woocommerce_quantity_input( array(
		'min_value'   => apply_filters( 'woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product ),
		'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product ),
		'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( wp_unslash( $_POST['quantity'] ) ) : $product->get_min_purchase_quantity(), // WPCS: CSRF ok, input var ok.
	) );

	echo '</div>';


  $days_offset = get_ready_date_offset(true);

  $ready_date  = date('d F Y', strtotime($days_offset));

	do_action( 'woocommerce_after_add_to_cart_quantity' );
	?>
<div class="single-recipe__total">
  <p class="single-recipe__total-label">Total</p>
  <p class="single-recipe__total-price">{{total_summ}}</p>
  <p class="single-recipe__total-text">Expected Delivery: 10 Working Days</p>

  <div class="single-recipe__total-hr"></div>
  <p class="single-recipe__total-label">Want your photos sooner?</p>
  <p class="single-recipe__total-text">Choose  <i class="icon-flash"></i>  <b>Fasttrack</b> at Checkout and get your photos 5 days earlier, expected by <span class="marked"><?php echo $ready_date	 ?></span></p>

  <div class="spacer-h-10"></div>
  <div class="spacer-h-10"></div>

	<button type="submit" class="single-recipe__submit single_add_to_cart_button button alt">{{button_text}}</button>
</div>

	<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>

	<input type="hidden" name="add-to-cart" value="<?php echo absint( $product->get_id() ); ?>" />
	<input type="hidden" name="product_id" ref="product_id" value="<?php echo absint( $product->get_id() ); ?>" />
	<input type="hidden" name="variation_id" class="variation_id" value="0" />
</div>

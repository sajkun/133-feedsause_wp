<?php
/**
 * Checkout Payment Section
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/payment.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.3
 */

defined( 'ABSPATH' ) || exit;

if ( ! is_ajax() ) {
	do_action( 'woocommerce_review_order_before_payment' );
}
$options = get_theme_checkout_content();
?>
<style>
	#stripe-card-element {
    background: #fff !important;
    padding: 10px 5px !important;
    margin: 5px 0px !important;
    width: 100%;
    margin: 0 0 12px;
    border-radius: 5px;
    border: 2px solid #e0e8f9;
    background-color: #fff;
    -webkit-box-sizing: border-box;
    box-sizing: border-box;
    height: 52px!important;
    line-height: 48px!important;
    vertical-align: middle;
    outline: 0;
    color: #1f2933;
    font-size: 14px;
    font-family: Helvetica,sans-serif;
	}

	.StripeElement--invalid{
		border-color: #f00!important;
	}
}

</style>

<div id="payment" class="woocommerce-checkout-payment">
	<?php if ( WC()->cart->needs_payment() ) : ?>
		<div class="wc_payment_methods payment_methods methods unstyled-list">
			<?php
			if ( ! empty( $available_gateways ) ) {
				foreach ( $available_gateways as $gateway ) {
					wc_get_template( 'checkout/payment-method.php', array( 'gateway' => $gateway ) );
				}
			} else {
				echo '<li class="woocommerce-notice woocommerce-notice--info woocommerce-info"><div class=" checkout-block">' . apply_filters( 'woocommerce_no_available_payment_methods_message', WC()->customer->get_billing_country() ? esc_html__( 'Sorry, it seems that there are no available payment methods for your state. Please contact us if you require assistance or wish to make alternate arrangements.', 'woocommerce' ) : esc_html__( 'Please fill in your details above to see available payment methods.', 'woocommerce' ) ) . '</div></li>'; // @codingStandardsIgnoreLine
			}
			?>
		</div>
	<?php endif; ?>
	<?php echo ('regular' === $options['type'])? '<div class="checkout__aside-block no-margin">':'' ?>
	<div class="form-row place-order checkout-block">
		<noscript>
			<?php
			/* translators: $1 and $2 opening and closing emphasis tags respectively */
			printf( esc_html__( 'Since your browser does not support JavaScript, or it is disabled, please ensure you click the %1$sUpdate Totals%2$s button before placing your order. You may be charged more than the amount stated above if you fail to do so.', 'woocommerce' ), '<em>', '</em>' );
			?>
			<br/><button type="submit" class="button alt" name="woocommerce_checkout_update_totals" value="<?php esc_attr_e( 'Update totals', 'woocommerce' ); ?>"><?php esc_html_e( 'Update totals', 'woocommerce' ); ?></button>
		</noscript>


    <?php theme_content_output::print_coupon_form_in_checkout(); ?>

		<?php wc_get_template( 'checkout/terms.php' ); ?>

		<?php do_action( 'woocommerce_review_order_before_submit' ); ?>


		<?php
		switch ($options['type']) {
			case 'premium':
				echo apply_filters( 'woocommerce_order_button_html', '<button type="submit" class="checkout__submit" name="woocommerce_checkout_place_order" id="place_order" value="' . esc_attr( __('Unlock Premium', 'theme-translations') ) . '" >' . '<svg class="icon svg-icon-unlock"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-unlock"></use> </svg>' .__('Unlock Premium', 'theme-translations') . '</button>' ); // @codingStandardsIgnoreLine
				break;
			case 'value':
				# code...
				break;
			default:
			echo apply_filters( 'woocommerce_order_button_html', '<button type="submit" class="checkout__submit regular-checkout-submit" name="woocommerce_checkout_place_order" id="place_order" value="' . esc_attr( $order_button_text ) . '" data-value=\'' . ( strip_tags(get_cart_totals()). ' '. $order_button_text ) . '\'>' .get_cart_totals(). ' '. ( $order_button_text ) . '<i class="icon-arrow"></i></button>' ); // @codingStandardsIgnoreLine
				break;

		}
 ?>

		<?php do_action( 'woocommerce_review_order_after_submit' ); ?>

		<?php wp_nonce_field( 'woocommerce-process_checkout', 'woocommerce-process-checkout-nonce' ); ?>
	</div>
<?php echo ('regular' === $options['type'])? '</div>':'' ?>
</div>
<div class="spacer-h-20"></div>
<?php
if ( ! is_ajax() ) {
	do_action( 'woocommerce_review_order_after_payment' );
}

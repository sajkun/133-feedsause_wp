<?php
/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$options = get_theme_checkout_content();

add_action('woocommerce_before_checkout_form', 'fix_fasstrack_product');

switch ($options['type']) {
	case 'premium':
		remove_action('woocommerce_before_checkout_form','woocommerce_checkout_coupon_form');
		remove_action('woocommerce_checkout_order_review','woocommerce_order_review');
		break;

	case 'regular' :
		remove_action('woocommerce_before_checkout_form','woocommerce_checkout_coupon_form');
	  break;
}

  global $continued_checkout;
  $continued_checkout = false;

	do_action( 'woocommerce_before_checkout_form', $checkout );

?>
<div class="checkout">
	<div class="container container_sm">
	<?php



		// If checkout registration is disabled and not logged in, the user cannot checkout.

		if ( ($checkout->is_registration_required() && ! is_user_logged_in() ) || !$continued_checkout ) {

			if('yes' !== get_option('woocommerce_enable_checkout_login_reminder')){
				echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) ) );

				$my_account_id = get_option('woocommerce_myaccount_page_id');

				printf('<a href="%s" >%s </a>', get_permalink($my_account_id), __('Register', 'theme-translations'));
			}


			return;
		}
			?>
		<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">

			<?php
				if (isset($_GET['fast_order_id'])){
					printf('<input type="hidden" name="fast_order_id" value="%s">', $_GET['fast_order_id']);
				}
			?>

			<div class="row">

				<div class="checkout__body col-12 col-md-7">
					<?php
					 if  ('premium' === $options['type'] ) {
						printf('<h2 class="page-title"> <span class="page-title__text">%s</span> <span class="page-title__comment"><svg class="icon svg-icon-lock"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-lock"></use> </svg> <span>Secure Checkout</span></span> </h2>', __('Join Premium','theme-translations'));}

					 if  ('premium' !== $options['type'] ) {
						printf('<h2 class="page-title"> <span class="page-title__text">%s</span> <span class="page-title__comment"><svg class="icon svg-icon-lock"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-lock"></use> </svg> <span>Secure Checkout</span></span> </h2>', __('Confirm & Pay','theme-translations'));}

					 if ( $checkout->get_checkout_fields() ) : ?>
						<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

  						<?php do_action( 'woocommerce_checkout_billing' ); ?>

							<?php do_action( 'woocommerce_checkout_shipping' ); ?>

						<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>

					<?php endif; ?>

					<?php if ('premium' === $options['type'] ): ?>
					<?php
					  /**
					  * @hook print_theme_checkout_action_sidebar_premium
					  *
					  * @hooked theme_construct_page::print_checkout_sidebar_premium - 10
					  */
					  do_action( 'do_checkout_pay_premium'); ?>
					<?php endif ?>
				</div>

				<aside class="checkout__aside col-12 col-md-5">

					<?php if ('premium' === $options['type'] ): ?>
						<?php
						  /**
						  * @hook print_theme_checkout_action_sidebar_premium
						  *
						  * @hooked theme_construct_page::print_checkout_sidebar_premium - 10
						  */
						  do_action( 'do_checkout_sidebar_premium', $options['premium_id'] ); ?>
					<?php endif ?>

					<?php if ('regular' === $options['type'] ): ?>
						<div class="checkout__aside-inner">
						<?php
						  /**
						  * @hook print_theme_checkout_action_sidebar_premium
						  *
						  * @hooked theme_construct_page::print_checkout_sidebar_premium - 10
						  */
						  do_action( 'do_checkout_sidebar_regular' ); ?>
					  </div>
					<?php endif ?>

					<?php if ('single' === $options['type'] ): ?>
						<?php
						  /**
						  * @hook print_theme_checkout_action_sidebar_premium
						  *
						  * @hooked theme_construct_page::print_checkout_sidebar_premium - 10
						  */
						  do_action( 'do_checkout_sidebar_single' ); ?>
					<?php endif ?>
				</aside>
			</div>

</form>

</div>
</div>

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>

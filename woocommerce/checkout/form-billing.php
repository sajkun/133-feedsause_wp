<?php
/**
 * Checkout billing information form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-billing.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.0.9
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/** @global WC_Checkout $checkout */

?>
<div class="woocommerce-billing-fields checkout-block" style="z-index: 100; position: relative;">
	<p class="checkout-block__title"><?php _e('Billing Details','theme-translations');?></p>
	<p class="checkout-block__comment"><?php _e('Please provide some information about you and your brand','theme-translations');?></p>

	<?php do_action( 'woocommerce_before_checkout_billing_form', $checkout ); ?>

	<div class="woocommerce-billing-fields__field-wrapper">
		<?php
			$fields = $checkout->get_checkout_fields( 'billing' );

			$fields_order  = array(
				'billing_company'   => array('open' => '<div class="row gutters-10">', 'close' =>''),
				'billing_first_name'   => array('open' => '', 'close' =>''),
				'billing_last_name'   => array('open' => '<div class="row gutters-10">', 'close' =>'</div>'),
				'billing_company'   => array('open' => '<div class="row gutters-10">', 'close' =>'</div>'),
				'billing_address_1' => array('open' => '<div class="row gutters-10">', 'close' =>''),
				'billing_address_2' => array('open' => '', 'close' =>'</div>'),
				'billing_city'      => array('open' => '<div class="row gutters-10">', 'close' =>''),
				'billing_state'     => array('open' => '', 'close' =>'</div>'),
				'billing_postcode'  => array('open' => '<div class="row gutters-10">', 'close' =>''),
				'billing_country'   => array('open' => '', 'close' =>'</div>'),
			);


			foreach ( $fields_order as $key => $wrapper) {

				$field = $fields[$key];
					if ( isset( $field['country_field'], $fields[ $field['country_field'] ] ) ) {
						$field['country'] = $checkout->get_value( $field['country_field'] );
					}
				$field['position'] = 'checkout';
				echo $wrapper['open'];
				woocommerce_form_field( $key, $field, $checkout->get_value( $key ));
				echo $wrapper['close'];
			}
		?>
	</div>

	<?php do_action( 'woocommerce_after_checkout_billing_form', $checkout ); ?>
</div>

<?php /*if ( ! is_user_logged_in() && $checkout->is_registration_enabled() ) : ?>
	<div class="woocommerce-account-fields">
		<?php if ( ! $checkout->is_registration_required() ) : ?>

			<p class="form-row form-row-wide create-account">
				<label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox">
					<input class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" id="createaccount" <?php checked( ( true === $checkout->get_value( 'createaccount' ) || ( true === apply_filters( 'woocommerce_create_account_default_checked', false ) ) ), true ) ?> type="checkbox" name="createaccount" value="1" /> <span><?php _e( 'Create an account?', 'woocommerce' ); ?></span>
				</label>
			</p>

		<?php endif; ?>

		<?php do_action( 'woocommerce_before_checkout_registration_form', $checkout ); ?>

		<?php if ( $checkout->get_checkout_fields( 'account' ) ) : ?>

			<div class="create-account">
				<?php foreach ( $checkout->get_checkout_fields( 'account' ) as $key => $field ) : ?>
					<?php woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); ?>
				<?php endforeach; ?>
				<div class="clear"></div>
			</div>

		<?php endif; ?>

		<?php do_action( 'woocommerce_after_checkout_registration_form', $checkout ); ?>
	</div>
<?php endif; */ ?>

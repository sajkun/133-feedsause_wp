<?php
/**
 * Checkout shipping information form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-shipping.php.
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
$options = get_theme_checkout_content();


$cart_items = wc()->cart->get_cart();

 if(!is_only_fasttrack_checkout(true)):

?>
<div class="woocommerce-shipping-fields checkout-block"  style="z-index: 1; position: relative">
	<?php if ( true === WC()->cart->needs_shipping_address() ) :
		$shipping =  apply_filters( 'woocommerce_ship_to_different_address_checked', 'shipping' === get_option( 'woocommerce_ship_to_destination' ) ? 1 : 0 );

	?>

		<p class="checkout-block__title"><?php _e('Send Product Via','theme-translations');?></p>

		<p class="checkout-block__comment"><?php _e('Choose an option for sending in your product to us','theme-translations');?></p>

    <div class="checkout-shipping-methods">
      <?php if ('premium' !== $options['type']): ?>


      <?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>

        <?php do_action( 'woocommerce_review_order_before_shipping' ); ?>

        <?php wc_cart_totals_shipping_html(); ?>

        <?php do_action( 'woocommerce_review_order_after_shipping' ); ?>

      <?php endif; ?>
      <?php endif ?>
    </div>

    <?php /*global $custom_enable_shipping_check;
    if('yes'!== $custom_enable_shipping_check):
    ?>

        <div class="clearfix">
        <label class="checkbox-imitation" id="ship-to-different-address">

          <input id="" class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" <?php checked( apply_filters( 'woocommerce_ship_to_different_address_checked', 'shipping' === get_option( 'woocommerce_ship_to_destination' ) ? 1 : 0 ), 1 ); ?> type="checkbox" name="ship_to_different_address" value="1" />

          <span class="checkbox-imitation__view"><span class="checkbox-imitation__mark"></span></span>
          <span class="checkbox-imitation__text">
            <b><?php _e('Collect products from a different address','theme-translations');?>?</b>
          </span>
        </label>
      </div>
      <?php endif; */ ?>

		<div class="shipping_address">

			<?php do_action( 'woocommerce_before_checkout_shipping_form', $checkout ); ?>

			<div class="woocommerce-shipping-fields__field-wrapper">
				<?php
          $countries = new WC_Countries();
          $countries = $countries->get_countries();
          $default_country = get_option('woocommerce_default_country');
					$fields = $checkout->get_checkout_fields( 'shipping' );
					$fields_order  = array(
						'shipping_address_1' => array('open' => '<div class="row gutters-10">', 'close' =>''),
						'shipping_address_2' => array('open' => '', 'close' =>'</div>'),
						'shipping_city'      => array('open' => '<div class="row gutters-10">', 'close' =>''),
						'shipping_state'     => array('open' => '', 'close' =>'</div>'),
						'shipping_postcode'  => array('open' => '<div class="row gutters-10">', 'close' =>'</div>'),
						// 'shipping_country'   => array('open' => '', 'close' =>'</div>'),
					);

					foreach ( $fields_order as $key => $wrapper) {
              $field = $fields[$key];
                if ( isset( $field['country_field'], $fields[ $field['country_field'] ] ) ) {
                  $field['country'] = $checkout->get_value( $field['country_field'] );
                }
              echo $wrapper['open'];
            // if($key === 'shipping_country' && $default_country):
            //   printf('<input type="hidden" value="%s" name="shipping_country">', $default_country );
            //   printf('<p class="form-row form-row-wide label-checkout-holder selected col-12 col-md-6"><label for="billing_address_1" class="">Country</label>
            //     <span class="woocommerce-input-wrapper">
            //     <input type="text" class="input-text form-field" disabled value="%s" ></span></p>', $countries[$default_country] );
            // else:
  						woocommerce_form_field( $key, $field, $checkout->get_value( $key ));
            // endif;
              echo $wrapper['close'];
					}
				?>
			</div>

			<?php do_action( 'woocommerce_after_checkout_shipping_form', $checkout ); ?>

		</div>

	<?php endif; ?>
</div>

<div class="woocommerce-additional-fields">
	<?php do_action( 'woocommerce_before_order_notes', $checkout ); ?>

	<?php if ( apply_filters( 'woocommerce_enable_order_notes_field', 'yes' === get_option( 'woocommerce_enable_order_comments', 'yes' ) ) ) : ?>

		<?php if ( ! WC()->cart->needs_shipping() || wc_ship_to_billing_address_only() ) : ?>

			<h3><?php _e( 'Additional information', 'woocommerce' ); ?></h3>

		<?php endif; ?>

		<div class="woocommerce-additional-fields__field-wrapper">
			<?php foreach ( $checkout->get_checkout_fields( 'order' ) as $key => $field ) : ?>
        <div class="row gutters-10">

  				<?php woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); ?>
        </div>
			<?php endforeach; ?>
		</div>

	<?php endif; ?>

	<?php do_action( 'woocommerce_after_order_notes', $checkout ); ?>
</div>
<?php
endif;
<?php
/**
 * Shipping Methods Display
 *
 * In 2.1 we show methods per package. This allows for multiple methods per order if so desired.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart-shipping.php.
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

defined( 'ABSPATH' ) || exit;

$formatted_destination    = isset( $formatted_destination ) ? $formatted_destination : WC()->countries->get_formatted_address( $package['destination'], ', ' );
$has_calculated_shipping  = ! empty( $has_calculated_shipping );
$show_shipping_calculator = ! empty( $show_shipping_calculator );
$calculator_text          = '';

global $custom_enable_shipping_check;

?>
<div class="woocommerce-shipping-totals shipping">

	<?php

	$international_delivery   = is_international_delivery($package['destination']);
	$ship_to_different = 1;

	if (isset($_POST['post_data'])){
		$temp = $_POST['post_data'];
		parse_str($temp, $_data);
		$ship_to_different = isset($_data['ship_to_different_address'])? 0 : 1;
  }
		$ship_to_different = $international_delivery ? 1 : $ship_to_different;

	?>
	<?php
?>
	<div data-title="<?php echo esc_attr( $package_name ); ?>">
		<?php if ( $available_methods ) : ?>
			<div id="shipping_method" class="woocommerce-shipping-methods">
				<?php

				foreach ( $available_methods as $method_id => $method ) :

							if(1 === count( $available_methods )){
								$class = 'active';
							}else{
								$checked =
								$class = (($_POST) && ($method->id === $_POST['shipping_method'][0]))? 'active' : 'not-active';
							}
					?>
					<div class="shipping-item <?php echo $class; ?>">
						<?php
						if ( 1 < count( $available_methods ) ) {
							printf( '<input type="radio" name="shipping_method[%1$d]" data-index="%1$d" id="shipping_method_%1$d_%2$s" value="%3$s" class="shipping_method shipping_type" %4$s />', $index, esc_attr( sanitize_title( $method->id ) ), esc_attr( $method->id ), checked( $method->id, $chosen_method, false ) ); // WPCS: XSS ok.
						} else {
							printf('<input type="radio" class="shipping_type" %s>', (isset($_POST['shipping_method']) && ($method->id === $_POST['shipping_method'][0]))? 'checked="checked"': '') ;
							printf( '<input type="hidden" name="shipping_method[%1$d]" data-index="%1$d" id="shipping_method_%1$d_%2$s" value="%3$s" class="shipping_method" />', $index, esc_attr( sanitize_title( $method->id ) ), esc_attr( $method->id ) ); // WPCS: XSS ok.
						}
						?>
					  <div class="shipping-item__view">
	           <svg class="icon svg-icon-teleg"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-teleg"></use></svg>

	           <?php
	             $use_date  = 'no';

							 printf( '<span class="shipping-item__title" for="shipping_method_%1$s_%2$s">%3$s', $index, esc_attr( sanitize_title( $method->id ) ), wc_cart_totals_shipping_method_label( $method ) ); // WPCS: XSS ok.

							 if( 'shipping_method_with_date' === $method->get_method_id( )){

			           $m = new WC_Request_shipping_with_date($method->get_instance_id());

			           $use_date = $m->get_instance_option('enable_datepicker');
			           // if('yes' === $use_date){

			           $comment = $m->get_instance_option('datepicker_comment');

			           $date = new DateTime();
			           $check = $date->format('Y-m-d') . ' 17:00:00';
			           $date_check =  new DateTime( $check );
			           $date_ready =  new DateTime( $check );

			           if($date_check > $date){
			           	$date_ready->modify('+1 day');
			           }else{
			           	$date_ready->modify('+2 day');
			           }

			           $text = sprintf('<span class="green">%s</span>', $date_ready->format('l d F Y'));

			           $comment = str_replace('{date}', $text ,  $comment);

			           printf('<span class="shipping-item__comment">%s</span>', $comment);

			           // }
							 }

							 echo '</span>';
							  if( 'yes' ===  $use_date ){
							?>

							<?php /*
			        <span class="shipping-item__date">
			          <span class="shipping-item__date-input mob">
			            <input type="date" name="free_collection_date[<?php echo  $method_id  ?>]">
			          </span>
			          <span class="shipping-item__date-input dt">
			            <input type="text" class="datepicker">
			          </span>
			          <svg class="icon svg-icon-calendar"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-calendar"></use></svg>
			        </span> */ ?>
			        <?php if ('yes' ===  $m->get_instance_option('enable_shipping_check')):
							 $custom_enable_shipping_check = 'yes';
			         ?>


		        <div class="clearfix <?php echo $international_delivery? 'hidden': '' ; ?>">
		          <label class="checkbox-imitation" id="ship-to-different-address">
								<input id="" class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" <?php checked( apply_filters( 'woocommerce_ship_to_different_address_checked', 'shipping' === get_option( 'woocommerce_ship_to_destination' ) ? 1 : 0 ), $ship_to_different ); ?> type="checkbox" name="ship_to_different_address" value="1" />
		            <span class="checkbox-imitation__view"><span class="checkbox-imitation__mark"></span></span>
		            <span class="checkbox-imitation__text">
		              <b><?php _e('Collect products from a different address','theme-translations');?>?</b>
		            </span>
							</label>
						</div>
			        <?php endif ?>
							<?php
							  }
							do_action( 'woocommerce_after_shipping_rate', $method, $index );
							?>
						</div>
					</div>
				<?php endforeach; ?>

				<?php if ($international_delivery): ?>
					<div class="shipping-item not-active disabled">
						<input type="radio" name="shipping_method[0]" data-index="0" id="shipping_method_0_shipping_method_with_date7" value="shipping_method_with_date:7" class="shipping_method shipping_type">					  <div class="shipping-item__view">
	           <svg class="icon svg-icon-teleg"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-teleg"></use></svg>

	           <span class="shipping-item__title" for="shipping_method_0_shipping_method_with_date7">Free Collection<span class="shipping-item__comment">Not available in your city yet</span></span>
			        													</div>
					</div>
				<?php endif ?>
			</div>
			<?php if ( is_cart() ) : ?>
				<p class="woocommerce-shipping-destination">
					<?php
					if ( $formatted_destination ) {
						// Translators: $s shipping destination.
						printf( esc_html__(
						 'Estimate for %s.', 'woocommerce' ) . ' ', '<strong>' . esc_html( $formatted_destination ) . '</strong>' );
						$calculator_text = __( 'Change address', 'woocommerce' );
					} else {
						echo esc_html__( 'This is only an estimate. Prices will be updated during checkout.', 'woocommerce' );
					}
					?>
				</p>
			<?php endif; ?>
		<?php
		elseif ( ! $has_calculated_shipping || ! $formatted_destination ) :
			esc_html_e( 'Enter your address to view shipping options.', 'woocommerce' );
		elseif ( ! is_cart() ) :
			echo wp_kses_post( apply_filters( 'woocommerce_no_shipping_available_html', __( 'There are no shipping methods available. Please ensure that your address has been entered correctly, or contact us if you need any help.', 'woocommerce' ) ) );
		else :
			// Translators: $s shipping destination.
			echo wp_kses_post( apply_filters( 'woocommerce_cart_no_shipping_available_html', sprintf( esc_html__( 'No shipping options were found for %s.', 'woocommerce' ) . ' ', '<strong>' . esc_html( $formatted_destination ) . '</strong>' ) ) );
			$calculator_text = __( 'Enter a different address', 'woocommerce' );
		endif;
		?>

		<?php if ( $show_package_details ) : ?>
			<?php echo '<p class="woocommerce-shipping-contents"><small>' . esc_html( $package_details ) . '</small></p>'; ?>
		<?php endif; ?>

		<?php if ( $show_shipping_calculator ) : ?>
			<?php woocommerce_shipping_calculator( $calculator_text ); ?>
		<?php endif; ?>
	</div>
	<?php if('yes'!== $custom_enable_shipping_check): ?>
	  <div class="clearfix <?php echo $international_delivery? 'hidden': '' ; ?>">
	  <label class="checkbox-imitation" id="ship-to-different-address">

	    <input id="" class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" <?php checked( apply_filters( 'woocommerce_ship_to_different_address_checked', 'shipping' === get_option( 'woocommerce_ship_to_destination' ) ? 1 : 0 ), $ship_to_different  ); ?> type="checkbox" name="ship_to_different_address" value="1" />

	    <span class="checkbox-imitation__view"><span class="checkbox-imitation__mark"></span></span>
	    <span class="checkbox-imitation__text">
	      <b><?php _e('Collect products from a different address','theme-translations');?>?</b>
	    </span>
	  </label>
	</div>
		<div class="spacer-h-30"></div>
	<?php endif; ?>
</div>

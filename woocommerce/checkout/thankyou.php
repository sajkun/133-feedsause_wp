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
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<div class="checkout thank-you">
	<div class="container container_sm">

	<?php if ( $order ) : ?>

		<?php if ( $order->has_status( 'failed' ) ) : ?>

			<p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed"><?php _e( 'Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.', 'woocommerce' ); ?></p>

			<p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed-actions">
				<a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" class="button pay"><?php _e( 'Pay', 'woocommerce' ) ?></a>
				<?php if ( is_user_logged_in() ) : ?>
					<a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="button pay"><?php _e( 'My account', 'woocommerce' ); ?></a>
				<?php endif; ?>
			</p>

		<?php else : ?>

			<div class="thank-you__decoration">
        <i class="icon-cool"></i>
        <i class="icon-ok"></i>
        <i class="icon-smile"></i>
        <i class="icon-vote"></i>
      </div>
      <div class="textcenter text-secure">
        <svg class="icon svg-icon-lock"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-lock"></use> </svg>

        <span>
          <?php _e('Secure Checkout', 'theme-translations'); ?>
        </span>
      </div>
      <?php $user_data = get_userdata($order->get_customer_id()); ?>

			<h2 class="thank-you__page-title textcenter">
        <span>
          <?php _e('Thank you for your order','theme-translations'); ?><?php if ($user_data->data->display_name): ?>, <?php echo $user_data->data->display_name; ?>
          <?php endif ?>
          <i class="icon-heart"></i>
        </span>
        <p class="page-comment texcenter">
          <?php _e('We’re excited to get your product to our studio','theme-translations'); ?>
        </p>
      </h2>
			<div class="order-summary-info">
        <div class="order-summary-info__block">
            <?php $status = $order->get_status();
	            $hex_color ='#333';
	            $color     ='#000';
						if(class_exists('WC_Order_Status_Manager_Order_Status') && function_exists('adjustBrightness')){
	            $status_post = new WC_Order_Status_Manager_Order_Status($status);
	            $hex_color = $status_post->get_color();
	            $color = adjustBrightness($hex_color, -100);
	          }
             ?>
          <div class="order-status" style="background-color: <?php echo $hex_color ?>; color: <?php echo $color ?>">
          	<?php echo $status; ?>
          </div>
          <?php if (class_exists('WC_pdf_functions')): ?>
          <a href="<?php echo add_query_arg( 'pdfid', $order->get_id() );?>" class="invoice" download><svg class="icon svg-icon-print"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-print" ></use> </svg><?php _e('Invoice','theme-translations');?></a>
          <?php endif ?>

          <p class="order-summary-info__title"><?php _e( 'Order', 'woocommerce' ); ?>: #<?php echo $order->get_order_number(); ?> </p>
          <p class="order-summary-info__comment">
            <?php echo wc_format_datetime( $order->get_date_created() ); ?>
          </p>
        </div>

        <?php
          $my_account_id = get_option('woocommerce_myaccount_page_id');
					$order_items           = $order->get_items( apply_filters( 'woocommerce_purchase_order_item_types', 'line_item' ) );
         ?>
        <div class="order-summary-info__block">

          <?php do_action('print_theme_order_summary', $order, false); ?>

        </div><!-- order-summary-info__block -->

        <?php do_action('print_thank_you_estimates'); ?>

				<?php if ($my_account_id >=0): ?>

        <div class="order-summary-info__block no-border">
          <a href="<?php echo esc_url(wc_get_account_endpoint_url( 'orders') );?>" class="checkout__submit"><?php _e('Go to Dashboard','theme-translations');?> <i class="icon-arrow"></i></a>
        </div>
				<?php endif ?>
      </div>
		<?php endif; ?>
		<?php do_action( 'woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id() ); ?>
		<?php do_action( 'woocommerce_thankyou', $order->get_id() ); ?>
	<?php else : ?>
			<div class="thank-you__decoration">
        <i class="icon-cool"></i>
        <i class="icon-ok"></i>
        <i class="icon-smile"></i>
        <i class="icon-vote"></i>
      </div>
      <div class="textcenter text-secure">
        <svg class="icon svg-icon-lock"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-lock"></use> </svg>

        <span>
          <?php _e('Secure Checkout', 'theme-translations'); ?>
        </span>
		<h2 class="thank-you__page-title textcenter woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received"><?php echo apply_filters( 'woocommerce_thankyou_order_received_text', __( 'Thank you. Your order has been received.', 'woocommerce' ), null ); ?></h2>
	<?php endif; ?>

	</div>
</div>
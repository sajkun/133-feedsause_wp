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

$order_statuses = wc_get_order_statuses();
$hex_color = '#333';

if(class_exists('WC_Order_Status_Manager_Order_Status') && function_exists('adjustBrightness')){
  $status_post = new WC_Order_Status_Manager_Order_Status($order->get_status());
  $hex_color = $status_post->get_color();
  $color = adjustBrightness($hex_color, -100);
}

$items = $order->get_items();

$fattrack = wc_get_product(get_option('wfp_priority_delivery_product_id'));
$handle   = wc_get_product(get_option('wfp_return_product_id'));

$product_name= '';

$fasttrack = false;

foreach ($order->get_items() as $key => $item) {

  if($item->get_product_id() == $fattrack ){
    $fasttrack = true;
  }

  if($item->get_product_id() == $fattrack || $item->get_product_id() == $handle ){
    continue;
  }

  $meta = $item->get_meta('extra_data');
  $product      = wc_get_product($item->get_product_id());
  $customer_id  = $order->get_user_id();
  $customer     = new WC_Customer( $customer_id );
  $product_name = explode(PHP_EOL, $meta['name']['value']);
  $product_count = count($product_name);
}

$date = $order->get_date_created();
?>

  <div class="thank-you">
    <div class="thank-you__inner container-lg">
      <div class="spacer-h-md-100 spacer-h-50"></div>

      <h2 class="thank-you__title">All <span class="styled">done!</span></h2>
      <p class="thank-you__text">We’re getting the cameras ready now so start preparing <br> your products! We’ll notify you once your shoot has<br> been accepted by one of our photographers.</p>

      <div class="spacer-h-40"></div>

      <div class="thank-you__holder text-center">
        <a href="<?php echo (wc_get_account_endpoint_url( 'orders' ))  ?>" class="thank-you__button">My Shoots</a>
        <a href="<?php echo get_permalink(woocommerce_get_page_id( 'shop' ))  ?>" class="thank-you__button contrast">Get Inspired
          <span class="spacer"></span>
          <span class="arrow"></span>
        </a>
      </div>
      <div class="spacer-h-50 spacer-h-lg-80"></div>

      <div class="thank-you__order">
        <div class="thank-you__order-header">
          <span class="thank-you__order-number">#FS-<?php echo $order->get_order_number();?></span>
          <span class="thank-you__order-number text-right"> <?php echo $date->date_i18n('d M y'); ?> </span>
          <div class="clearfix"></div>
          <div class="spacer-h-10"></div>
          <span class="thank-you__order-title"><?php echo $product->get_title(); ?></span>
          <span class="thank-you__order-name"><?php echo $product_name[0] ?>  <?php if (count($product_name) - 1  > 0): ?> <span class="count">
          + <?php echo count($product_name) - 1; ?></span>
          <?php endif ?></span>
        </div><!-- thank-you__order-header -->

        <div class="thank-you__order-line clearfix">
          <div class="thank-you__order-status" <?php printf('style="background-color:%s"', $hex_color); ?>></div><?php echo $order_statuses['wc-'.$order->get_status()];?>

        </div>

        <div class="thank-you__order-body">
          <div class="row no-gutters">
            <div class="col-4">
              <span class="thank-you__order-label">Products</span>
              <span class="thank-you__order-value"><?php echo $product_count; ?></span>
            </div>
            <div class="col-4">
              <span class="thank-you__order-label">Photos</span>
              <span class="thank-you__order-value"><?php echo  $meta['image_count']['value'] ; ?></span>
            </div>
            <div class="col-4">
              <span class="thank-you__order-label">Delivery</span>
              <span class="thank-you__order-value"><?php echo $fasttrack? '3 Days' : '10 Days' ?></span>
            </div>
          </div><!-- row -->
          <div class="spacer-h-15"></div>
          <div class="row no-gutters">
            <div class="col-12">
              <span class="thank-you__order-label">Sizes</span>
              <span class="thank-you__order-value"><?php echo implode(', ',$meta['sizes']['value']); ?></span>
            </div>
          </div><!-- row -->
          <div class="spacer-h-15"></div>
          <div class="thank-you__order-hr">
            <div class="left-dark"></div>
            <div class="right-dark"></div>
          </div>
          <div class="spacer-h-15"></div>
          <div class="text-center">
            <span class="thank-you__order-label">Paid</span>
            <span class="thank-you__order-price"><?php echo wc_price($order->get_total());?></span>
          </div>
          <div class="spacer-h-25"></div>

          <?php
            $actions = wc_get_account_orders_actions( $order );
          ?>

          <a href="<?php echo $actions['view']['url'] ?>" class="thank-you__order-track">View</a>
        </div><!-- thank-you__order-body -->
      </div><!-- thank-you__order -->

      <div class="spacer-h-100"></div>
    </div><!-- thank-you__inner -->
  </div><!-- thank-you -->


<?php /*

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

        <div class="order-summary__item order-summary-info" style="padding-left:0; padding-right:0">
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
          </div><!-- order-summary-info__block -->

          <div class="order-summary-info__block">
            <?php do_action('print_theme_order_summary', $order, false); ?>
          </div>

          <?php do_action('print_thank_you_estimates', $order); ?>

          <div class="order-summary-info__block no-border">
            <a href="<?php echo esc_url(wc_get_account_endpoint_url( 'orders') );?>" class="checkout__submit"><?php _e('Go to Dashboard','theme-translations');?> <i class="icon-arrow"></i></a>
          </div>
        </div><!-- order-summary-info -->

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

*/?>
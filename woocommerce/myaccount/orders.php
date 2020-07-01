<?php
/**
 * Orders
 *
 * Shows orders on the account page.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/orders.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

do_action( 'woocommerce_before_account_orders', $has_orders ); ?>

<?php if ( $has_orders ) : ?>
  <div class="container_sm container">
  <div class="spacer-h-50"></div>
	<div class="row">
		<?php foreach ( $customer_orders->orders as $customer_order ) :
			$order      = wc_get_order( $customer_order );
			$item_count = $order->get_item_count();
			$order_items           = $order->get_items( apply_filters( 'woocommerce_purchase_order_item_types', 'line_item' ) );
			?>
			<div class="col-12 col-md-6 col-lg-4 filtering-item woocommerce-orders-table__row woocommerce-orders-table__row--status-<?php echo esc_attr( $order->get_status() ); ?> order" data-type="<?php echo esc_attr( $order->get_status() ); ?>">
				<div class="order-preview">
            <?php $status = $order->get_status();
	            $hex_color ='#333';
	            $color     ='#000';
						if(class_exists('WC_Order_Status_Manager_Order_Status') && function_exists('adjustBrightness')){
	            $status_post = new WC_Order_Status_Manager_Order_Status($status);
	            $hex_color = $status_post->get_color();
	            $color = adjustBrightness($hex_color, -100);
	          }
             ?>
          <span class="order-preview__tag in-production" style="background-color: <?php echo $hex_color ?>; color: <?php echo $color ?>"><?php echo esc_html( wc_get_order_status_name( $order->get_status() ) ) ?></span>

          <p class="order-preview__title"><?php echo _x( '#', 'hash before order number', 'woocommerce' ) . $order->get_order_number(); ?></p>
          <p class="order-preview__comment"><?php echo esc_html( wc_format_datetime( $order->get_date_created() ) ); ?></p>

          <div class="spacer"></div>

          <?php do_action('print_theme_order_summary', $order) ?>

          <div class="spacer"></div>

          <p class="order-preview__subtitle"><?php _e('Billed to','theme-translations');?></p>
          <?php
              $address = $order->get_address('billing');
              unset($address['first_name']);
              unset($address['last_name']);
              unset($address['company']);
              unset($address['phone']);
              unset($address['email']);
            ?>
          <p class="order-preview__comment">
           <?php foreach ($address as $key => $value):
              if($key!= 'country'){
                echo $value.' ';
              }
            endforeach;
              echo WC()->countries->countries[ $order->get_billing_country() ];
             ?>
					</p>

          <div class="clearfix order-preview__actions">
          	<?php
							$actions = wc_get_account_orders_actions( $order );
							if ( ! empty( $actions ) ) {
								foreach ( $actions as $key => $action ) {
									switch ($key ) {
										case 'view':
										?>
					            <a href="<?php echo esc_url( $action['url'] ); ?>" class="order-preview__readmore">
					              <span><?php _e('View Order','theme-translations');?></span>
					              <svg class="icon svg-icon-arrowr"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-arrowr"></use> </svg>
					            </a>
										<?php
											break;
										case 'pdf':
										?>
						            <a href="<?php echo esc_url( $action['url'] ); ?>" class="invoice"><svg class="icon svg-icon-print"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-print"></use> </svg><?php _e('Invoice','theme-translations');?></a>
						         <?php
											break;

										default:
											echo '<a href="' . esc_url( $action['url'] ) . '" class="woocommerce-button button ' . sanitize_html_class( $key ) . '">' . esc_html( $action['name'] ) . '</a>';
											break;
									}
								}
							}
          	?>
          </div>
				</div>
			</div>
		<?php endforeach; ?>
</div>
	<?php do_action( 'woocommerce_before_account_orders_pagination' ); ?>

	<?php if ( 1 < $customer_orders->max_num_pages ) : ?>
		<div class="woocommerce-pagination woocommerce-pagination--without-numbers woocommerce-Pagination">
			<?php if ( 1 !== $current_page ) : ?>
				<a class="woocommerce-button woocommerce-button--previous woocommerce-Button woocommerce-Button--previous button" href="<?php echo esc_url( wc_get_endpoint_url( 'orders', $current_page - 1 ) ); ?>"><?php _e( 'Previous', 'woocommerce' ); ?></a>
			<?php endif; ?>

			<?php if ( intval( $customer_orders->max_num_pages ) !== $current_page ) : ?>
				<a class="woocommerce-button woocommerce-button--next woocommerce-Button woocommerce-Button--next button" href="<?php echo esc_url( wc_get_endpoint_url( 'orders', $current_page + 1 ) ); ?>"><?php _e( 'Next', 'woocommerce' ); ?></a>
			<?php endif; ?>
		</div>
	<?php endif; ?>

<?php else :
    $user_id = get_current_user_id();
    $customer   = new WC_Customer($user_id);
    $user_name  = $customer->get_first_name();
    ?>
  <div class="container_sm container">
    <div class="spacer-h-50"></div>
    <div class="row">
      <div class="col-12 col-md-6 col-lg-4 filtering-item woocommerce-orders-table__row woocommerce-orders-table__row--status-processing order" data-type="processing">
        <div class="order-preview">
            <span class="order-preview__tag blank"></span>

          <p class="order-preview__title blank"></p>
          <p class="order-preview__comment blank"></p>

          <div class="spacer"></div>
          <div class="row">
              <div class="col-6">
                <p class="order-preview__subtitle blank"></p>
                <p class="checkout-item__text">
                  <i class="icon-items"></i>
                  XXX
                </p>
              </div>

           <div class="col-6">
              <p class="order-preview__subtitle blank"></p>
              <p class="checkout-item__text">
                £ -
              </p>
            </div>
          </div>
          <div class="spacer"></div>

          <p class="order-preview__subtitle">No Orders</p>
          <p class="order-preview__comment">
            You don’t have any orders yet, <?php echo $user_name  ?>. <br>
            Get started in less than 1 minute.</p>

          <div class="clearfix order-preview__actions">
            <a href="<?php echo get_permalink( wc_get_page_id( 'shop' ) );?>" class="order-preview__readmore">
              <b>Create First Order</b>
              <svg class="icon svg-icon-arrowr"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-arrowr"></use> </svg>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php endif; ?>

<?php do_action( 'woocommerce_after_account_orders', $has_orders ); ?>
</div>
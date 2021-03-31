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

$fasttrack = wc_get_product((int)get_option('wfp_priority_delivery_product_id'));
$handle   = wc_get_product((int)get_option('wfp_return_product_id'));
$product_fast_id = (int)get_option('wfp_priority_delivery_product_id');
$order_statuses = wc_get_order_statuses();
$hex_color = '#333';
$title = '';
$product_name = '';
$product_count = '';
do_action( 'woocommerce_before_account_orders', $has_orders ); ?>
<?php if ( $has_orders ) : ?>
  <div class="container_sm container">
  <div class="spacer-h-30 spacer-h-md-50"></div>
    <div class="order-scroll" id="scroll-orders">
      <?php if (wp_is_mobile()): ?>
        <div class="row" <?php echo 'style="width: '.(count($customer_orders->orders)*280).'px; margin:0"' ?>>
      <?php else: ?>
       	<div class="row">
      <?php endif ?>
  		<?php foreach ( $customer_orders->orders as $customer_order ) :
  			$order      = wc_get_order( $customer_order );
  			$item_count = $order->get_item_count();
  			$order_items  = $order->get_items( apply_filters( 'woocommerce_purchase_order_item_types', 'line_item' ) );
        $product_name= '';
        $fasttrack = false;

        foreach ($order_items as $key => $item) {

          if($item->get_product_id() == (int)get_option('wfp_priority_delivery_product_id') ){
            $fasttrack = true;
          }

          if($item->get_product_id() == (int)get_option('wfp_priority_delivery_product_id') || $item->get_product_id() == (int)get_option('wfp_return_product_id')){
            continue;
          }

          $meta = $item->get_meta('extra_data');
          $customer_id  = $order->get_user_id();

          $product = $item->get_product();

          $title = $product->get_title();

          $customer     = new WC_Customer( $customer_id );
          $product_name = isset($meta['name']['value'])? explode(PHP_EOL, $meta['name']['value']) : '';
          $product_count = isset($meta['name']['value'])? count($product_name) : '';
        }

        if(class_exists('WC_Order_Status_Manager_Order_Status') && function_exists('adjustBrightness')){
          $status_post = new WC_Order_Status_Manager_Order_Status($order->get_status());
          $hex_color = $status_post->get_color();
          $color = adjustBrightness($hex_color, -100);
        }

          $date = $order->get_date_created();
        ?>

        <div class="col-md-6 col-lg-4 order-previews col-xl-3 <?php echo in_array($order->get_status(), array('completed', 'failed'))? 'completed hidden' : 'processing';?>" data-time="<?php echo $date->date_i18n('Y-m-d').'T'.$date->date_i18n('H:i:s'); ?>">

        <div class="thank-you__order">
          <div class="thank-you__order-header">
            <span class="thank-you__order-number">#FS-<?php echo $order->get_order_number();?></span>
            <span class="thank-you__order-number text-right"> <?php echo $date->date_i18n('d M y'); ?> </span>
            <div class="clearfix"></div>
            <div class="spacer-h-10"></div>
            <span class="thank-you__order-title"><?php echo $title; ?></span>
            <span class="thank-you__order-name"><?php echo is_array( $product_name)? $product_name[0] : 'No name'  ?>  <?php if ($product_name  && count($product_name) - 1  > 0): ?> <span class="count">
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
                <span class="thank-you__order-value"><?php echo $product_count?:'na'; ?></span>
              </div>
              <div class="col-4">
                <span class="thank-you__order-label">Photos</span>
                <span class="thank-you__order-value"><?php echo isset( $meta['image_count']['value'] )? $meta['image_count']['value'] : 'na'; ?></span>
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
                <span class="thank-you__order-value"><?php echo isset($meta['sizes']['value']) ? implode(', ',$meta['sizes']['value']) : 'na'; ?></span>
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

            <a href="<?php echo $actions['view']['url'] ?>" class="thank-you__order-track">Track</a>
          </div><!-- thank-you__order-body -->
        </div><!-- thank-you__order -->

        <div class="spacer-h-md-40"></div>
      </div>

     	<?php endforeach; ?>
    </div>
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
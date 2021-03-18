<?php
/**
 * View Order
 *
 * Shows the details of a particular order on the account page.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/view-order.php.
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
 * @version 3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

clog($order->get_items());

$handle_id       = (int)get_option('wfp_return_product_id');
$fasttrack_id = (int)get_option('wfp_priority_delivery_product_id');


$_fasttrack = wc_get_product($fasttrack_id );
$_handle = wc_get_product($handle_id );

$handle    = false;
$fasttrack = false;

$o = get_option('theme_settings');

clog($o);

foreach ($order->get_items() as $key => $item) {
	$handle    = $handle_id == $item->get_product_id()? true : $handle;
	$fasttrack = $fasttrack_id == $item->get_product_id()? true : $fasttrack;

	if($handle_id == $item->get_product_id()){
		$_handle    =  $item->get_product();
	}

	if($fasttrack_id == $item->get_product_id()){
		$_fasttrack  =  $item->get_product();
	}

	if($handle_id == $item->get_product_id() ||  $fasttrack_id == $item->get_product_id()){
		continue;
	}

  $meta = $item->get_meta('extra_data');
  $theme_prices = $item->get_meta('theme_prices')?: $o;

}
  clog($meta);
  clog($theme_prices);
?>

<div class="spacer-h-50"></div>
<div class="row">
	<div class="col-md-5 col-lg-5 clearfix">
    <div class="shoot-steps">
      <div class="shoot-steps__header">
        <h2 class="title">
           Blocks
           <svg class="icon svg-icon-dots"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-dots"></use> </svg>
        </h2>
      <span class="comment">#FS-<?php echo $order->get_order_number(); ?></span >

      </div><!-- shoot-steps__header -->
      <div class="summary">
        <div class="summary__body">
          <h3 class="summary__title">Shoot Summary</h3>
          <p class="summary__text">Order placed on <?php  wc_format_datetime( $order->get_date_created() ) ?></p>
          <div class="spacer-h-10"></div>
          <table class="summary__content">
            <tbody>
              <tr>
                <td> <div class="step-label" >
                    <svg class="icon svg-icon-product">
                      <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-product"></use>
                    </svg>
                    <span class="step-label__text">Products</span>
                  </div> </td>

                 <?php
                  $product_name = isset($meta['name']['value'])? explode(PHP_EOL, $meta['name']['value']) : '';
					        $product_count = isset($meta['name']['value'])? count($product_name) : '';

                 ?>

                <td> <p class="summary__content-text"><?php echo is_array( $product_name)? $product_name[0] : 'No name'  ?>  <?php if ($product_name  && count($product_name) - 1  > 0): ?> <span class="addon"> + <?php echo count($product_name) - 1; ?></span> <?php endif ?></p> </td>

                <?php $total_product =$product_count ? ((int)$product_count - 1) * (int)$theme_prices['name']  : 0; ?>
                <td class="active"> <p class="summary__content-price"><?php echo $product_count? wc_price( $total_product) : 'Free' ?></p> </td>
              </tr>

              <tr>
                <td> <div class="step-label">
                    <svg class="icon svg-icon-images-3" >
                      <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href=" #svg-icon-images-3"></use>
                    </svg>
                    <span class="step-label__text">Photos</span>
                  </div> </td>

                <td class="active"> <p class="summary__content-text"><?php echo $meta['image_count']['value']; ?></p> </td>
                <?php $total_images = (int)$meta['image_count']['value'] * (int)$theme_prices['single_product_price']; ?>
                <td class="active"> <p class="summary__content-price"><?php echo wc_price($total_images); ?></p> </td>
              </tr>

              <tr>
                <td> <div class="step-label" > <svg class="icon svg-icon-custom">
                      <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-custom"></use>
                    </svg>
                    <span class="step-label__text">Customise</span>
                  </div> </td>

                <td class="active"> <p class="summary__content-text"><?php
                    $colors = ($meta['colors']['value'])? count(explode(PHP_EOL, $meta['colors']['value'])) : 0;
                    $props  = ($meta['props']['value'] !='none')? 1: 0;
                    $sizes  = count($meta['sizes']['value']) - 1;

                    $total = $colors + $props + $sizes ;

                    echo $total . _n(' Customisation ', ' Customisations ', $total);
                  ?></p> </td>
                 <?php
                   $total_customisations = $colors * (int)$theme_prices['color'] + $sizes * (int)$theme_prices['sizes'];
                 ?>
                <td class="<?php echo $total_customisations > 0 ? 'active' : ''; ?>"> <p class="summary__content-price"><?php

                	echo $total_customisations? wc_price($total_customisations) : '-';
                ?></p> </td>
              </tr>
              <tr  :class="{active: (max_step >= 4  )}"   v-on:click="change_step(4)">
                <td> <div class="step-label"   :class="{active: (step == 4|| step == 5)}">
                    <svg class="icon svg-icon-notes">
                      <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-notes"></use>
                    </svg>
                    <span class="step-label__text">Studio Notes</span>
                  </div> </td>

                <td class="active"> <p class="summary__content-text"> <?php if (isset($meta['comment_type']['value']) ||(isset($meta['comment']['value']) && $meta['comment']['value']!='false')): echo isset($meta['comment_type']['value'])? $meta['comment_type']['value'] : 'Quick Note'; ?>
                  	<?php else: ?> - <?php endif ?> </p> </td>

                <td class="active"> <p class="summary__content-price"><?php
                	$shoot_number = isset($meta['comment_type']['value'])? count($meta['shoots']) : 0;

                	echo $shoot_number? wc_price($shoot_number * (int)$theme_prices['shoot']) : 'Free';

                ?></p> </td>
              </tr>

              <tr >
                <td> <div class="step-label">
                    <svg class="icon svg-icon-flash">
                      <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-flash"></use>
                    </svg>
                    <span class="step-label__text">Turnaround</span>
                  </div> </td>

                <td class="active"> <p class="summary__content-text"><?php echo $fasttrack? '3 Business Days' : '10 Business Days'?></p> </td>

                <td class="active"> <p class="summary__content-price"><?php echo $fasttrack? wc_price($_fasttrack->get_price()) : 'Free'?></p> </td>
              </tr>

              <tr >
                <td> <div class="step-label">
                    <svg class="icon svg-icon-handling">
                      <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-handling"></use>
                    </svg>
                    <span class="step-label__text">Handling</span>
                  </div> </td>

                <td class="active"> <p class="summary__content-text"><?php echo $handle? 'Return Product' : 'Discard Products'?></p> </td>

                <td class="active"> <p class="summary__content-price"><?php echo $handle? wc_price($_handle->get_price()) : 'Free'?></p> </td>
              </tr>
            </tbody>
            <tfoot>
              <tr>
                <td colspan="4"><span class="summary__label">Total Cost</span> <div class="spacer-h-10"></div></td>
              </tr>
              <tr>
                <td colspan="2">Subtotal</td>
                <td colspan="2">£{{order_total.subtotal}}</td>
              </tr>
              <tr>
                <td colspan="2">Add-Ons</td>
                <td colspan="2">£{{order_total.addons}}</td>
              </tr>
              <tr>
                <td colspan="2">Discount <span class="coupon_code" v-show="applied_coupon">{{applied_coupon}}</span></td>
                <td colspan="2">£{{order_total_discount}}</td>
              </tr>
              <tr>
                <td colspan="2"></td>
                <td colspan="2"><span class="summary__total">£{{order_total.total}}</span></td>
              </tr>

            </tfoot>
          </table>
        </div>
      </div><!-- summary -->


      <p class="terms">By placing an order with Feedsauce, you agree to the website <a href="<?php echo $terms_page_url ?>">Terms & Conditions</a>

        <?php if ($redo_policy_url): ?>
          , our <a  href="<?php echo $redo_policy_url ?>"> Redo Policy</a>
        <?php endif ?>
        <?php if ($product_guid_url): ?>
         and verify that your product meets <a href="<?php echo $product_guid_url ?>">Feedsauce’s Product Guidelines</a>
        <?php endif ?>
      </p>
    </div>
	</div>
	<div class="col-md-7"></div>
</div><!-- row -->
<p><?php
	/* translators: 1: order number 2: order date 3: order status */
	printf(
		__( 'Order #%1$s was placed on %2$s and is currently %3$s.', 'woocommerce' ),
		'<mark class="order-number">' . $order->get_order_number() . '</mark>',
		'<mark class="order-date">' . wc_format_datetime( $order->get_date_created() ) . '</mark>',
		'<mark class="order-status">' . wc_get_order_status_name( $order->get_status() ) . '</mark>'
	);
?></p>

<?php if ( $notes = $order->get_customer_order_notes() ) : ?>
	<h2><?php _e( 'Order updates', 'woocommerce' ); ?></h2>
	<ol class="woocommerce-OrderUpdates commentlist notes">
		<?php foreach ( $notes as $note ) : ?>
		<li class="woocommerce-OrderUpdate comment note">
			<div class="woocommerce-OrderUpdate-inner comment_container">
				<div class="woocommerce-OrderUpdate-text comment-text">
					<p class="woocommerce-OrderUpdate-meta meta"><?php echo date_i18n( __( 'l jS \o\f F Y, h:ia', 'woocommerce' ), strtotime( $note->comment_date ) ); ?></p>
					<div class="woocommerce-OrderUpdate-description description">
						<?php echo wpautop( wptexturize( $note->comment_content ) ); ?>
					</div>
	  				<div class="clear"></div>
	  			</div>
				<div class="clear"></div>
			</div>
		</li>
		<?php endforeach; ?>
	</ol>
<?php endif; ?>

<?php do_action( 'woocommerce_view_order', $order_id ); ?>

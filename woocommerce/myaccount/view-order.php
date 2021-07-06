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

$handle_id    = (int)get_option('wfp_return_product_id');
$fasttrack_id = (int)get_option('wfp_priority_delivery_product_id');


$_fasttrack = wc_get_product($fasttrack_id );
$_handle    = wc_get_product($handle_id );

$handle    = false;
$fasttrack = false;

$o = get_option('theme_settings');

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

  $product = $item->get_product();

  $meta         = $item->get_meta('extra_data');
  $shoot_data   = $item->get_meta('shoot_data');
  $theme_prices = $item->get_meta('theme_prices')?: $o;

}

  $actions   = wc_get_account_orders_actions( $order );

	$current_status       = new WC_Order_Status_Manager_Order_Status($order->get_status());
	$current_status_meta  = get_post_meta($current_status->get_id(), 'custom_order_data', true);
	$current_status_order = isset(	$current_status_meta['order'] ) ? (int)$current_status_meta['order']   : 0;
?>
<div class="container-lg fixed" id="my_order">
  <div class="spacer-h-0 spacer-h-md-30 spacer-h-lg-50"></div>
  <div class="row no-gutters">
    <?php
      if (!wp_is_mobile()):
        ?>
      	<div class="col-md-5 col-lg-5 clearfix">
          <div class="shoot-steps">
            <div class="shoot-steps__header">
              <a href="javascript:history.go(-1)" class="comment"><svg class="icon svg-icon-bracket"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-bracket"></use></svg> Back</a>
              <div class="spacer-h-20"></div>
              <h2 class="title">
                  <?php echo $product->get_name();?>
              </h2>
            <span class="comment">#FS-<?php echo $order->get_order_number(); ?></span >

            </div><!-- shoot-steps__header -->
            <div class="shoot-steps-hr"></div>
            <div class="spacer-h-20"></div>
            <div class="summary">
              <div class="summary__body">
                <h3 class="summary__title">Shoot Summary</h3>
                <p class="summary__text">Order placed on <?php echo wc_format_datetime( $order->get_date_created() ) ?></p>
                <div class="spacer-h-10"></div>
                <table class="summary__content">
                  <tbody>
                    <tr>
                      <td> <div class="step-label  trigger-expand"  data-target="products">
                          <svg class="icon svg-icon-product">
                            <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-product"></use>
                          </svg>
                          <span class="step-label__text">Products</span>
                        </div> </td>

                       <?php
                        $product_name = isset($meta['name']['value'])? explode(PHP_EOL, $meta['name']['value']) : '';
      					        $product_count = isset($meta['name']['value'])? count($product_name) : '';

                       ?>

                      <td> <p class="summary__content-text"> <?php echo is_array( $product_name)? trim(explode('-', $product_name[0])[0]) : 'No name'  ?> <?php if ($product_name  && count($product_name) - 1  > 0): ?> <span class="addon"> + <?php echo count($product_name) - 1; ?></span> <?php endif ?></p> </td>

                      <?php $total_product = $product_count ? ((int)$product_count - 1) * (int)$theme_prices['name']  : 0; ?>
                      <td class="active"> <p class="summary__content-price"><?php echo $product_count? wc_price( $total_product) : 'Free' ?></p> </td>
                    </tr>

                    <?php if (isset($shoot_data['products'])): ?>
                    <tr  class="resert-cells">
                      <td colspan="3" class="text-left">
                        <div class="details" data-parent="products">
                          <table>
                          <?php foreach ($shoot_data['products'] as $key => $product): ?>
                            <tr>
                              <td class="limit-width"><svg class="icon svg-icon-product">
                                  <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-product"></use>
                                  </svg><span class="item-title"><?php echo $product['type'] ?></span></td>
                              <td><span class="item-details"><?php echo $product['title'] ?></span></td>
                            </tr>
                          <?php endforeach ?>
                          </table>
                        </div>
                      </td>
                    </tr>
                    <?php endif ?>

                    <tr>
                      <td> <div class="step-label no-hover">
                          <svg class="icon svg-icon-images-3" >
                            <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href=" #svg-icon-images-3"></use>
                          </svg>
                          <span class="step-label__text">Photos</span>
                        </div> </td>

                      <?php if (isset($meta['image_count']['value'])): ?>
                      <td class="active"> <p class="summary__content-text"><?php echo $meta['image_count']['value']; ?></p> </td>


                      <?php $total_images = (int)$meta['image_count']['value'] * (int)$theme_prices['single_product_price']; ?>

                      <td class="active"> <p class="summary__content-price"><?php echo wc_price($total_images); ?></p> </td>

                      <?php else:
                       $total_images = 0;
                       ?>
                      	<td class="active"> <p class="summary__content-text">na</p> </td>

      	                <td> <p class="summary__content-price">-</p> </td>
                      <?php endif ?>
                    </tr>

                    <tr>
                      <td > <div class="step-label trigger-expand"  data-target="customize"> <svg class="icon svg-icon-custom">
                            <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-custom"></use>
                          </svg>
                          <span class="step-label__text">Customise</span>
                        </div> </td>
      								<?php if (isset($meta['colors']['value'])): ?>
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

                      <?php else:
                       $total_customisations = 0;
                       ?>
                      	<td class="active"> <p class="summary__content-text">na</p> </td>

      	                <td> <p class="summary__content-price">-</p> </td>
                      <?php endif ?>
                    </tr>

                    <tr  class="resert-cells">
                      <td colspan="3" class="text-left">
                        <div class="details" data-parent="customize">
                          <table>
                            <tr>
                              <td class="limit-width"><svg class="icon svg-icon-custom">
                                  <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-custom"></use>
                                  </svg><span class="item-title">Theme</span><div class="spacer-h-5"></div></td>
                              <td>
                                <?php if ($meta['colors']['value']): ?>
                                  <span class="item-details"><?php echo str_replace(PHP_EOL, '<br>' ,$meta['colors']['value']); ?></span>
                                <?php else: ?>
                                  <span class="item-details">Don't care</span>
                                <?php endif ?>
                                <div class="spacer-h-5"></div>
                              </td>
                            </tr>
                            <tr>
                              <td class="limit-width"><svg class="icon svg-icon-position">
                                  <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-position"></use>
                                  </svg><span class="item-title">Position</span><div class="spacer-h-5"></div></td>
                              <td><?php if ($meta['position']['value'] && $meta['position']['value']!='none'): ?>
                                 <span class="item-details"><?php echo $meta['position']['value'] ?></span>
                                <?php else: ?>
                                  <span class="item-details">Don't care</span>
                                <?php endif ?>
                                <div class="spacer-h-5"></div></td>
                            </tr>
                            <tr>
                              <td class="limit-width"><svg class="icon svg-icon-glasess">
                                  <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-glasess"></use>
                                  </svg><span class="item-title">Props</span><div class="spacer-h-5"></div></td>
                              <td><?php if ($meta['props']['value'] && $meta['props']['value']!='none'): ?>
                                 <span class="item-details"><?php echo $meta['props']['value'] ?></span>
                                <?php else: ?>
                                  <span class="item-details">Don't care</span></td>
                                <?php endif ?><div class="spacer-h-5"></div></td>
                            </tr>
                            <tr>
                              <td class="limit-width"><svg class="icon svg-icon-resize">
                                  <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-resize"></use>
                                  </svg><span class="item-title">Sizes</span><div class="spacer-h-5"></div></td>
                              <td><span class="item-details"><?php echo implode('<br>', $meta['sizes']['value']); ?></span><div class="spacer-h-5"></div></td>
                            </tr>
                          </table>
                        </div>
                      </td>
                    </tr>

                    <tr >
                      <td> <div class="step-label trigger-expand" data-target="notes">
                          <svg class="icon svg-icon-notes">
                            <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-notes"></use>
                          </svg>
                          <span class="step-label__text">Studio Notes</span>
                        </div> </td>

      								<?php if (isset($meta['comment']) || isset($meta['comment_type'])): ?>
                      <td class="active"> <p class="summary__content-text"> <?php if (isset($meta['comment_type']['value']) ||(isset($meta['comment']['value']) && $meta['comment']['value']!='false')): echo isset($meta['comment_type']['value'])? $meta['comment_type']['value'] : 'Quick Note'; ?>
                        	<?php else: ?> - <?php endif ?> </p> </td>

                      <td class="active"> <p class="summary__content-price"><?php
                      	$shoot_number = isset($meta['comment_type']['value'])? count($meta['shoots']) : 0;

                      	$total_shoot = $shoot_number * (int)$theme_prices['shoot'];

                      	echo $shoot_number? wc_price($total_shoot ) : 'Free';

                      ?></p> </td>

                      <?php else:
                       $total_shoot = 0;
                       ?>
                      	<td class="active"> <p class="summary__content-text">na</p> </td>

      	                <td> <p class="summary__content-price">-</p> </td>
                      <?php endif ?>
                    </tr>

                    <tr  class="resert-cells">
                      <td colspan="3" class="text-left">
                        <div class="details" data-parent="notes">
                          <?php
                          switch ($shoot_data['notes']['type']) {
                            case "simple": ?>
                              <span class="item-details"><?php echo $shoot['comment']['value']; ?></span>
                              <?php
                              break;
                            case "custom": ?>
                              <table>
                                <?php foreach ($shoot_data['notes']['data'] as $key => $shoot): ?>
                                <tr>
                                  <td class="limit-width"><svg class="icon svg-icon-notes">
                                      <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-notes"></use>
                                      </svg><span class="item-title">Shot <?php echo $key + 1; ?></span></td>
                                  <td>
                                  </td>
                                  <td>
                                    <span class="item-details" data-shoot-products="shoot<?php echo $key + 1; ?>">
                                      <?php echo str_replace(',', '<br>' , $shoot['product']); ?>
                                    </span>
                                  </td>
                                  <td></td>
                                  <td class="text-right">
                                     <span class="item-details trigger-details" data-shoot-target="shoot<?php echo $key + 1; ?>">[ <span class="trigger"></span> ]</span>
                                  </td>
                                  <tr>
                                    <td colspan="4"><div class="detail-notes" data-shoot-parent="shoot<?php echo $key + 1; ?>"><span class="item-details"><?php echo $shoot['text']; ?></span></div></td>
                                  </tr>
                                <?php endforeach ?>
                              </table>
                              <?php
                              break;
                            default: ?>
                              <span class="item-details">Notes Skipped</span>
                              <?php
                              break;
                            }
                          ?>
                        </div>
                      </td>
                    </tr>

                    <tr >
                      <td> <div class="step-label no-hover">
                          <svg class="icon svg-icon-flash">
                            <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-flash"></use>
                          </svg>
                          <span class="step-label__text">Turnaround</span>
                        </div> </td>

                      <td class="active"> <p class="summary__content-text"><?php echo $fasttrack? '3 Business Days' : '10 Business Days'?></p> </td>


                      <?php $total_fasttrack = $fasttrack? $_fasttrack->get_price() :0; ?>

                      <td class="active"> <p class="summary__content-price"><?php echo $fasttrack? wc_price($total_fasttrack) : 'Free'?></p> </td>
                    </tr>

                    <tr >
                      <td> <div class="step-label no-hover">
                          <svg class="icon svg-icon-handling">
                            <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-handling"></use>
                          </svg>
                          <span class="step-label__text">Handling</span>
                        </div> </td>

                      <?php $total_handle = $handle? $_handle->get_price() :0; ?>
                      <td class="active"> <p class="summary__content-text"><?php echo $handle? 'Return Product' : 'Discard Products'?></p> </td>

                      <td class="active"> <p class="summary__content-price"><?php echo $handle? wc_price($total_handle) : 'Free'?></p> </td>
                    </tr>
                  </tbody>
                  <tfoot>
                    <tr>
                      <td colspan="3"><span class="summary__label">Total Cost</span> <div class="spacer-h-10"></div></td>
                    </tr>
                    <tr>
                      <td colspan="2">Subtotal</td>
                      <td colspan="1"><?php echo wc_price($total_images);?></td>
                    </tr>
                    <tr>
                      <td colspan="2">Add-Ons</td>
                      <td colspan="1"><?php echo wc_price($total_product  + $total_shoot + $total_customisations + $total_fasttrack + $total_handle);?></td>
                    </tr>
                    <tr>
                      <td colspan="2">Discount <?php if($order->get_coupon_codes() ):  clog($order->get_coupon_codes());?> <span class="coupon_code" ><?php echo implode(' ,', $order->get_coupon_codes());?></span><?php endif;?></td>
                      <td colspan="1"><?php echo wc_price($order->get_total_discount()) ?></td>
                    </tr>
                    <tr>
                      <td colspan="2"></td>
                      <td colspan="1"><span class="summary__total"><?php echo wc_price($order->get_total()) ?></span></td>
                    </tr>

                  </tfoot>
                </table>
              </div>
            </div><!-- summary -->
            <?php
            if (isset($actions['print-invoice'])): ?>

            <div class="spacer-h-25"></div>
            <div class="text-right"><a href="<?php echo $actions['print-invoice']['url'];?>" download class="invoice-link"><svg class="icon svg-icon-download"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-download"></use> </svg>Invoice </a></div>
            <?php endif ?>
            <div class="spacer-h-25"></div>
          </div>
      	</div>
     <?php endif ?>
  	<div class="col-12 col-lg-7">

  		<?php

  			$orders = [];
        $number_of_active = 0;

  		  foreach (wc_get_order_statuses() as $key => $status):
  				$st = new WC_Order_Status_Manager_Order_Status($key);
  				$_meta = get_post_meta($st->get_id(), 'custom_order_data', true);

  				if(isset($_meta['use']) && $_meta['use'] == 'yes'){
  					$num = (int)$_meta['order'];
  					$orders[$num]['name'] = $status;
  					$orders[$num]['obj']  = $st;
  					$orders[$num]['meta'] = $_meta;
  				}
  		 ?>
  		 <?php endforeach;

       foreach ($orders as $key => $o) {
        $number_of_active  += $current_status_order >= (int)$key? 1 : 0;
       }
        ?>
      <?php if (wp_is_mobile()): ?>
      <div class="shoot-steps">
        <div class="shoot-steps__header no-paddings">
          <div class="spacer-h-30"></div>
          <a href="javascript:history.go(-1)" class="comment"><svg class="icon svg-icon-bracket"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-bracket"></use></svg> BACK</a>
          <div class="spacer-h-20"> </div>
          <h2 class="title">  <?php echo $product->get_name();?>  </h2>

          <div class="spacer-h-10"> </div>

          <div class="row no-gutters">
            <div class="col-7">
              <span class="comment"> #FS-<?php echo $order->get_order_number(); ?> on <?php echo wc_format_datetime( $order->get_date_created() ) ?> </span>
            </div>
            <div class="col-5 text-right">
              <span class="comment"><span class="status-marker"></span> <?php echo wc_get_order_status_name($order->get_status()); ?></span>
            </div>
          </div>
          <div class="spacer-h-30"></div>
        </div>
      </div>

      <div class="my-order__filter">
        <div class="decoration"></div>
        <div class="decoration pre"></div>
        <a href="#status" class="my-order__filter-item-2 js-trigger-order-tab active">Order Status</a>
        <a href="#details" class="my-order__filter-item-2 js-trigger-order-tab">Order Details</a>
      </div>
      <?php endif ?>

      <?php if (wp_is_mobile()): ?>
        <div class="order-subpage hidden" id="details" <?php // echo 'style="display:none"'?>>
          <div class="shoot-steps">
            <div class="summary not-fixed">
              <div class="summary__body">
                <div class="shoot-steps">
                  <div class="shoot-steps__header">
                    <h2 class="title"> <?php echo $product->get_name();?> </h2>
                    <div class="spacer-h-5"></div>
                    <span class="comment">#FS-<?php echo $order->get_order_number(); ?> placed on <?php echo wc_format_datetime( $order->get_date_created() ) ?></span >
                  </div><!-- shoot-steps__header -->
                  <div class="spacer-h-20"></div>
                  <table class="summary__content">
                    <tbody>
                      <tr>
                        <td> <div class="step-label trigger-expand" data-target="products">
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

                        <?php $total_product = $product_count ? ((int)$product_count - 1) * (int)$theme_prices['name']  : 0; ?>
                        <td class="active"> <p class="summary__content-price"><?php echo $product_count? wc_price( $total_product) : 'Free' ?></p> </td>
                      </tr>

                      <?php if (isset($shoot_data['products'])): ?>
                      <tr  class="resert-cells">
                        <td colspan="3" class="text-left">
                          <div class="details" data-parent="products">
                            <table>
                            <?php foreach ($shoot_data['products'] as $key => $product): ?>
                              <tr>
                                <td class="limit-width"><svg class="icon svg-icon-product">
                                    <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-product"></use>
                                    </svg><span class="item-title"><?php echo $product['type'] ?></span></td>
                                <td><span class="item-details"><?php echo $product['title'] ?></span></td>
                              </tr>
                            <?php endforeach ?>
                            </table>
                          </div>
                        </td>
                      </tr>
                      <?php endif ?>

                      <tr>
                        <td> <div class="step-label">
                            <svg class="icon svg-icon-images-3" >
                              <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href=" #svg-icon-images-3"></use>
                            </svg>
                            <span class="step-label__text">Photos</span>
                          </div> </td>

                        <?php if (isset($meta['image_count']['value'])): ?>
                        <td class="active"> <p class="summary__content-text"><?php echo $meta['image_count']['value']; ?></p> </td>


                        <?php $total_images = (int)$meta['image_count']['value'] * (int)$theme_prices['single_product_price']; ?>

                        <td class="active"> <p class="summary__content-price"><?php echo wc_price($total_images); ?></p> </td>

                        <?php else:
                         $total_images = 0;
                         ?>
                          <td class="active"> <p class="summary__content-text">na</p> </td>

                          <td> <p class="summary__content-price">-</p> </td>
                        <?php endif ?>
                      </tr>

                      <tr>
                        <td> <div class="step-label trigger-expand" data-target="customize"> <svg class="icon svg-icon-custom">
                              <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-custom"></use>
                            </svg>
                            <span class="step-label__text">Customise</span>
                          </div> </td>
                        <?php if (isset($meta['colors']['value'])): ?>
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

                        <?php else:
                         $total_customisations = 0;
                         ?>
                          <td class="active"> <p class="summary__content-text">na</p> </td>

                          <td> <p class="summary__content-price">-</p> </td>
                        <?php endif ?>
                      </tr>

                      <tr  class="resert-cells">
                        <td colspan="3" class="text-left">
                          <div class="details" data-parent="customize">
                            <table>
                              <tr>
                                <td class="limit-width"><svg class="icon svg-icon-custom">
                                    <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-custom"></use>
                                    </svg><span class="item-title">Theme</span></td>
                                <td>
                                  <?php if (($meta['colors']['value'])): ?>
                                    <span class="item-details"><?php echo str_replace(PHP_EOL, '<br>' ,$meta['colors']['value']); ?></span>
                                  <?php else: ?>
                                    <span class="item-details">Don't care</span>
                                  <?php endif ?>
                                </td>
                              </tr>
                              <tr>
                                <td class="limit-width"><svg class="icon svg-icon-position">
                                    <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-position"></use>
                                    </svg><span class="item-title">Position</span></td>
                                <td><?php if ($meta['position']['value'] && $meta['position']['value']!='none'): ?>
                                   <span class="item-details"><?php echo $meta['position']['value'] ?></span>
                                  <?php else: ?>
                                    <span class="item-details">Don't care</span>
                                  <?php endif ?></td>
                              </tr>
                              <tr>
                                <td class="limit-width"><svg class="icon svg-icon-glasess">
                                    <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-glasess"></use>
                                    </svg><span class="item-title">Props</span></td>
                                <td><?php if ($meta['props']['value'] && $meta['props']['value']!='none'): ?>
                                   <span class="item-details"><?php echo $meta['props']['value'] ?></span>
                                  <?php else: ?>
                                    <span class="item-details">Don't care</span></td>
                                  <?php endif ?></td>
                              </tr>
                              <tr>
                                <td class="limit-width"><svg class="icon svg-icon-resize">
                                    <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-resize"></use>
                                    </svg><span class="item-title">Sizes</span></td>
                                <td><span class="item-details"><?php echo implode('<br>', $meta['sizes']['value']); ?></span></td>
                              </tr>
                            </table>
                          </div>
                        </td>
                      </tr>

                    <tr >
                      <td> <div class="step-label trigger-expand" data-target="notes">
                          <svg class="icon svg-icon-notes">
                            <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-notes"></use>
                          </svg>
                          <span class="step-label__text">Studio Notes</span>
                        </div> </td>

                      <?php if (isset($meta['comment']) || isset($meta['comment_type'])): ?>
                      <td class="active"> <p class="summary__content-text"> <?php if (isset($meta['comment_type']['value']) ||(isset($meta['comment']['value']) && $meta['comment']['value']!='false')): echo isset($meta['comment_type']['value'])? $meta['comment_type']['value'] : 'Quick Note'; ?>
                          <?php else: ?> - <?php endif ?> </p> </td>

                      <td class="active"> <p class="summary__content-price"><?php
                        $shoot_number = isset($meta['comment_type']['value'])? count($meta['shoots']) : 0;

                        $total_shoot = $shoot_number * (int)$theme_prices['shoot'];

                        echo $shoot_number? wc_price($total_shoot ) : 'Free';

                      ?></p> </td>

                      <?php else:
                       $total_shoot = 0;
                       ?>
                        <td class="active"> <p class="summary__content-text">na</p> </td>

                        <td> <p class="summary__content-price">-</p> </td>
                      <?php endif ?>
                    </tr>

                    <tr  class="resert-cells">
                      <td colspan="3" class="text-left">
                        <div class="details" data-parent="notes">
                          <?php
                          switch ($shoot_data['notes']['type']) {
                            case "simple": ?>
                              <span class="item-details"><?php echo $shoot['comment']['value']; ?></span>
                              <?php
                              break;
                            case "custom": ?>
                              <table>
                                <?php foreach ($shoot_data['notes']['data'] as $key => $shoot): ?>
                                <tr>
                                  <td class="limit-width"><svg class="icon svg-icon-notes">
                                      <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-notes"></use>
                                      </svg><span class="item-title">Shoot <?php echo $key + 1; ?></span></td>
                                  <td>
                                  </td>
                                  <td>
                                    <span class="item-details" data-shoot-products="shoot<?php echo $key + 1; ?>">
                                      <?php echo str_replace(',', '<br>' , $shoot['product']); ?>
                                    </span>
                                  </td>
                                  <td></td>
                                  <td class="text-right">
                                     <span class="item-details trigger-details" data-shoot-target="shoot<?php echo $key + 1; ?>">[ <span class="trigger"></span> ]</span>
                                  </td>
                                  <tr>
                                    <td colspan="4"><div class="detail-notes" data-shoot-parent="shoot<?php echo $key + 1; ?>"><span class="item-details"><?php echo $shoot['text']; ?></span></div></td>
                                  </tr>
                                <?php endforeach ?>
                              </table>
                              <?php
                              break;
                            default: ?>
                              <span class="item-details">Notes Skipped</span>
                              <?php
                              break;
                          }
                          ?>
                        </div>
                      </td>
                    </tr>

                      <tr >
                        <td> <div class="step-label">
                            <svg class="icon svg-icon-flash">
                              <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-flash"></use>
                            </svg>
                            <span class="step-label__text">Turnaround</span>
                          </div> </td>

                        <td class="active"> <p class="summary__content-text"><?php echo $fasttrack? '3 Business Days' : '10 Business Days'?></p> </td>


                        <?php $total_fasttrack = $fasttrack? $_fasttrack->get_price() :0; ?>

                        <td class="active"> <p class="summary__content-price"><?php echo $fasttrack? wc_price($total_fasttrack) : 'Free'?></p> </td>
                      </tr>

                      <tr >
                        <td> <div class="step-label">
                            <svg class="icon svg-icon-handling">
                              <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-handling"></use>
                            </svg>
                            <span class="step-label__text">Handling</span>
                          </div> </td>

                        <?php $total_handle = $handle? $_handle->get_price() :0; ?>
                        <td class="active"> <p class="summary__content-text"><?php echo $handle? 'Return Product' : 'Discard Products'?></p> </td>

                        <td class="active"> <p class="summary__content-price"><?php echo $handle? wc_price($total_handle) : 'Free'?></p> </td>
                      </tr>
                    </tbody>
                    <tfoot>
                      <tr>
                        <td colspan="3"><span class="summary__label">Total Cost</span> <div class="spacer-h-10"></div></td>
                      </tr>
                      <tr>
                        <td colspan="2">Subtotal</td>
                        <td colspan="1"><?php echo wc_price($total_images);?></td>
                      </tr>
                      <tr>
                        <td colspan="2">Add-Ons</td>
                        <td colspan="1"><?php echo wc_price($total_product  + $total_shoot + $total_customisations + $total_fasttrack + $total_handle);?></td>
                      </tr>
                      <tr>
                        <td colspan="2">Discount <?php if($order->get_coupon_codes() ):  clog($order->get_coupon_codes());?> <span class="coupon_code" ><?php echo implode(' ,', $order->get_coupon_codes());?></span><?php endif;?></td>
                        <td colspan="1"><?php echo wc_price($order->get_total_discount()) ?></td>
                      </tr>
                      <tr>
                        <td colspan="2"></td>
                        <td colspan="1"><span class="summary__total"><?php echo wc_price($order->get_total()) ?></span></td>
                      </tr>

                    </tfoot>
                  </table>

                    <?php
                  if (isset($actions['print-invoice'])): ?>

                  <div class="spacer-h-15"></div>
                  <div class="text-right"><a href="<?php echo $actions['print-invoice']['url'];?>" download class="invoice-link"><svg class="icon svg-icon-download"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-download"></use> </svg>Invoice </a></div>
                  <?php endif ?>
                  <div class="spacer-h-75"></div>
                </div><!-- shoot-steps -->
              </div><!-- summary__body -->
            </div><!-- summary -->
          </div><!-- shoot-steps -->
        </div><!-- order-subpage -->
      <?php endif ?>
      <?php if (wp_is_mobile()): ?>
        <div class="order-subpage" id="status">
      <?php endif ?>

      <div class="spacer-h-20"></div>

       <ul class="progress-order progress">
        <?php foreach ($orders as $key => $_order):
          $active = $key <= $current_status_order? 'active' : '';
          ?>
          <li class="progress__item <?php echo $active ?>">
            <span class="progress__item-dots"></span> <span class="progress__item-name"><?php echo $_order['name']; ?></span></li>
        <?php endforeach ?>
       </ul>
       <div class="spacer-h-60"></div>

  		 <div class="text-center">

    		 	<?php if ((int)$current_status->get_icon() > 0):

    		 	  $url = wp_get_attachment_image_url((int)$current_status->get_icon(), 'small');

    		 	  printf('<img src="%s" alt="" class="image-order-status">', $url);
    		 	 ?>

    		 	<?php else: ?>
    		 		<i class="icon-order-status <?php echo $current_status->get_icon()  ?>"  <?php echo 'style="color: '.$current_status->get_color().'"' ?>></i>
    		 	<?php endif;

           ?>
  		 </div><!-- text-center -->

  		 <div class="spacer-h-20"></div>

  		 <h2 class="order-title text-center"> <?php echo isset($current_status_meta['title'])? $current_status_meta['title']: wc_get_order_status_name($order->get_status()); ?> </h2>

  		 <div class="spacer-h-10"></div>

       <?php if (isset( $current_status_meta['descr'] )): ?>

  		 <p class="order-description text-center"> <?php
  		 		 $descr = $current_status_meta['descr'] ? $current_status_meta['descr'] : $current_status->get_description();
  		 		 $date = get_field('collection-date', $order->get_id());

           if($date){
             $date = new DateTime($date);
    		 		 $date_marked = sprintf('on <span class="green">%s</span>', $date->format('d F Y'));
             $descr = str_replace('[on_date]', $date_marked, $descr );
           }else{

    		 		 $descr = str_replace('[on_date]', '', $descr );
           }

  		 		 $guid = sprintf('<a href="%s">Packaging Guidelines</a>', '#');
  		 		 $descr = str_replace('[guid_package]', $guid, $descr );
  		 	 ?> <?php echo $descr; ?> </p>
       <?php endif ?>


       <?php if (isset($current_status_meta['custom_action']) && $current_status_meta['custom_action']!='none' ): ?>

         <div class="spacer-h-30"></div>
         <div class="text-center">

          <?php switch ($current_status_meta['custom_action']) {
            case 'download':
              $attachments = get_field( 'attachments', $order->get_id());
              if(!$attachments){
                break;
              }
                ?>
                  <a href="<?php echo $attachments['url']?>" class="download-link-pdf" donwload>
                    <span class="text">Download Postage Label</span>
                    <span class="spacer"></span>
                    <svg class="icon svg-icon-download"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-download"></use> </svg>
                  </a>
                <?php
              break;

            default:
              # code...
              break;
            }
          ?>

         </div><!-- text-center -->
       <?php endif ?>

  			<?php if ( isset($current_status_meta['what_next']) &&  !empty($current_status_meta['what_next'])): ?>
  	 	  	<div class="spacer-h-40 spacer-h-lg-50"></div>
          <div class="my-hr-grey mobile-show"></div>
          <div class="spacer-h-30 spacer-h-lg-0"></div>
  	   	  <div class="text-center">
  			 	  <a href="javascript:void(0)" class="what-next">What happens next?</a>
  		 	  </div>
  		 	  <div class="spacer-h-15"></div>
  		 	  <p class="order-description text-center"> <?php echo $current_status_meta['what_next'] ?></p>
  			<?php endif ?>


      <?php if (wp_is_mobile()): ?>
        </div><!-- #details" -->
      <?php endif ?>
  	</div><!-- col-12 -->
  </div><!-- row -->

  <div class="spacer-h-50"></div>
</div>
<?php do_action( 'woocommerce_view_order', $order_id ); ?>

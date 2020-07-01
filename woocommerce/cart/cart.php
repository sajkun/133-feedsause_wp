<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.0
 */

defined( 'ABSPATH' ) || exit;
$priority_delivery_product_id = (int)get_option('wfp_priority_delivery_product_id');
$return_product_id            = (int)get_option('wfp_return_product_id');


$helper = new theme_formatted_cart();
if(count($helper->get_items()) <=0){
	wc()->cart->empty_cart();
}


do_action( 'woocommerce_before_cart' ); ?>

<div class="spacer-h-30"></div>
<div class="row my-cart">
  <div class="col-12 col-md-6">
    <h3 class="my-cart__title"> Review Your Order</h3>

    <div class="my-cart__notice cart-notice my-cart__notice-has-icon">
      <div class="my-cart__notice-icon">
        <svg class="icon svg-icon-ok-rounded"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-ok-rounded"></use> </svg>
      </div>

      <div class="my-cart__notice-text">
        <b class="important">Final checks</b>. Please ensure your order meets our <a href="javascript:void(0)" onclick="show_product_sidebar('guidline')">Product Guidelines</a> to avoid any delays.
      </div>
    </div><!-- my-cart__notice  -->

    <h4 class="my-cart__subtitle">
      <svg class="icon svg-icon-size"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-size"></use></svg>
      <span>Delivery Speed</span>
    </h4>

    <div id="cart-options">
    	<input type="hidden" value="<?php echo ($priority_delivery_product_id <= 0)? 'standard' : 'priority' ?>" ref="delivery_start">
	    <div class="my-cart__option">

	      <input type="radio" name="delivery-speed"  v-model="delivery" id="delivery-speed-1" value="standard"

	      <?php if($priority_delivery_product_id <= 0){ echo 'checked="checked"'; } ?>>

	      <label class="my-cart__option-text" for="delivery-speed-1">

	        <span class="price">
	          Free
	        </span>
	        <span class="text">
	         <b class="name"> Standard - 10 Working Days</b>
	          Download your photos by  <?php echo get_estimates()?>
	        </span>
	      </label>
	    </div><!-- my-cart__option -->

	    <?php if ($priority_delivery_product_id > 0):
				$priority_delivery_product = wc_get_product($priority_delivery_product_id);
	    ?>
	    <div class="my-cart__option">
	      <input type="radio" v-model="delivery" value="priority" name="delivery-speed" id="delivery-speed-2" <?php if($priority_delivery_product_id > 0){ echo 'checked'; } ?>>
	      <label class="my-cart__option-text" for="delivery-speed-2">
	        <span class="price">
						<?php echo wc_price(woocommerce_get_price_discounted($priority_delivery_product->get_price(), $priority_delivery_product)); ?>
	        </span>
	        <span class="text">
	          <span class="tag"><i class="icon-flash"></i> Fast Track</span>
	          <b class="name"> Priority - 5 Working Days</b>
	        </span>

	        <div class="hr"></div>
	         <?php print_estimates(true) ?>
	      </label>
	    </div><!-- my-cart__option -->
	     <?php endif ?>
    </div>

    <div class="spacer-h-10"></div>
		<div class="spacer-h-10"></div>

    <h4 class="my-cart__subtitle">
      <svg class="icon svg-icon-size"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-size"></use> </svg>
      <span>Returning Your Product</span>
    </h4>


    <p class="my-cart__text">
      By selecting Hold Product, we will keep your product in our studio for 30 days incase you wish to re-order. After 30 days, your product will be discarded.
    </p>
		<?php if ($return_product_id > 0):
			$return_product = wc_get_product($return_product_id);
			?>
	    <div class="row" id="returning-products">
	    	<input type="hidden" ref="start_value" value="hold">
	      <div class="col-6">
	        <div class="my-cart__option equalheight">
	          <input type="radio" name="hold-type" id="hold-type-1" v-model="type" value="hold">

	          <label class="my-cart__option-text" for="hold-type-1">
	            <span class="price">
	              Free
	            </span>
	            <span class="text">
	             <b class="name">Hold Product</b>
	              30 Days
	            </span>
	          </label>
	        </div><!-- my-cart__option -->
	      </div><!-- col-6 -->

	      <div class="col-6">
	        <div class="my-cart__option equalheight">
	          <input type="radio" name="hold-type" id="hold-type-2" v-model="type" value="return">
	          <label class="my-cart__option-text" for="hold-type-2">
	            <span class="price">
	              <?php echo wc_price(woocommerce_get_price_discounted($return_product->get_price(), $return_product)); ?>
	            </span>
	            <span class="text">
	             <b class="name"> Return Products</b>
	              Immediate
	            </span>
	          </label>
	        </div><!-- my-cart__option -->
	      </div><!-- col-6 -->
	    </div><!-- row -->
		<?php endif ?>
    <div class="spacer-h-25"></div>

    <a href="<?php echo wc_get_checkout_url(); ?>" class="my-cart__button">Continue to Payment</a>

    <div class="spacer-h-10"></div>
    <div class="spacer-h-10"></div>

    <p class="my-cart__attention">
      * Download dates are calculated on the basis that your products are dispatched to our studio the next working day and received the following day to begin production.
    </p>
  </div><!-- col-12 col-lg-6 -->

  <div class="col-12 col-md-6 col-lg-5 offset-lg-1">
  	<form class="woocommerce-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
  		<?php do_action( 'woocommerce_before_cart_table' ); ?>
	    <div class="order-summary">

	      <div class="order-summary__tag">YOUR ORDER</div>

	      <?php do_action( 'woocommerce_before_cart_contents' ); ?>

	      <?php
	       $helper = new theme_formatted_cart();
	       foreach ($helper->get_cart() as $item_id => $item):

	        ?>
		      <div class="order-summary__item" id="<?php echo $item_id?>">
		        <div class="row">
		          <div class="col-7">
		            <span class="order-summary__item-title"><?php echo $item['name'] ?></span>
		          </div>
		          <div class="col-5 textright"><span class="order-summary__item-price"><?php echo wc_price($item['price']['line_total']) ?></span></div>
		        </div><!-- row -->

		        <div class="row">
		          <div class="col-9">
		            <span class="order-summary__item-detail">
		              <svg class="icon svg-icon-box"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-box"></use> </svg>
		              <?php echo $item['count_items'] ?>
		              <?php echo $item['count_items'] === 1? 'Product': 'Products'; ?>
		            </span>
		            <span class="order-summary__item-detail">
		              <svg class="icon svg-icon-items"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-items"></use> </svg>
									<?php echo $item['count_images'] ?>
		              <?php echo $item['count_images'] === 1? 'Photo': 'Photos'; ?>
		            </span>
		          </div>

		          <div class="col-3 textright">
		            <a href="javascript:void(0)" class="order-summary__item-edit" onclick="edit_cart_product('<?php echo $item_id?>')">Edit</a>

		            <a href="javascript:void(0)" onclick="remove_product_from_cart('<?php echo $item_id?>', this)" class="order-summary__item-remove">×</a>
		          </div>
		        </div>

		        <?php if ($item['sizes']): ?>

		        <div class="clearfix">
		          <svg class="icon svg-icon-size"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-size"></use> </svg>
		          <span class="order-summary__item-detail">
		             <?php echo implode(', ',$item['sizes']); ?>
		          </span>
		        </div>
		        <?php endif ?>

		        <?php if ($item['comment']): ?>
		        <div class="clearfix">
		          <svg class="icon svg-icon-pen"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-pen"></use> </svg>
		          <span class="order-summary__item-detail">
		             <?php echo $item['comment']; ?>
		          </span>
		        </div>
		        <?php endif ?>
		      </div><!-- order-summary__item -->
	      <?php endforeach ?>
				<?php do_action( 'woocommerce_cart_contents' ); ?>

	      <div class="order-summary__total">
	      	<div class="coupon-form" id="coupon-form">
		        <a href="javascript:void(0)" class="order-summary__coupon" v-on:click="do_show_form">Apply a Coupon</a>
            <transition
                v-bind:css="false"
                v-on:before-enter="beforeEnter"
                v-on:enter="enter"
                v-on:leave="leave"
                v-on:after-enter="enterAfter"
                v-on:after-leave="leaveAfter"
               >
		        <div class="coupon-code-holder" v-if="show_form">
			        <input type="text" v-model="coupon_code">
			        <a href="javascript:void(0)" v-on:click="apply_coupon">Apply a coupon code</a>
		        </div>
		      </transition>
	      	</div>
	        <table  class="order-summary__total-table">
	          <tr>
	            <th>Add-Ons</th>
	            <td><span id="add-ons"><?php echo wc_price($helper->get_addons_total()); ?></span></td>
	          </tr>
	          <tr>
	            <th>Discount</th>
	            <td>
	            	<span id="discount-totals">
	            	<?php
	            		echo wc_price( array_sum(wc()->cart->get_coupon_discount_totals( )));
	            	 ?>
	            	</span>
	            </td>
	          </tr>
	          <tr>
	            <th><b>Total (<?php echo get_woocommerce_currency()?>)</b></th>
	            <td><b id="cart_total"><?php echo wc()->cart->get_cart_total()?></b></td>
	          </tr>
	        </table>
	      </div>
	    </div><!-- order-summary -->
			<?php do_action( 'woocommerce_after_cart_table' ); ?>
	  </form>
  </div><!-- col-12 col-lg-4 offset-lg-2 -->
</div><!-- row my-cart -->

<div class="spacer-h-70"></div>

<div class="cart-collaterals">
	<?php
		/**
		 * Cart collaterals hook.
		 *
		 */
		do_action( 'woocommerce_cart_collaterals' );
	?>
</div>

<?php do_action( 'woocommerce_after_cart' ); ?>

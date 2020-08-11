<?php
/**
 * Variable product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/variable.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.1
 */

defined( 'ABSPATH' ) || exit;

global $product;
$product_id = $product->get_id();


$attribute_keys = array_keys( $attributes );

$image_counts = get_post_meta($product_id, '_items_count', true);

if($image_counts ){
  $image_counts = array_unique( $image_counts );
  $image_counts = array_values($image_counts);
  sort( $image_counts , SORT_NUMERIC   );
  $image_counts[count($image_counts) - 1] = 'or '. $image_counts[count($image_counts) - 1];
}

$min_price = 999999;

foreach($product->get_available_variations() as $_product){
  $min_price = min($min_price, (int)$_product['display_price']);
}

$free_product_id = get_field('free_sample', $product_id);
$free_product    = wc_get_product($free_product_id);


do_action( 'woocommerce_before_add_to_cart_form' ); ?>

<div class="fix-width-1">
	<p class="single-recipe__label">
    <svg class="icon svg-icon-box"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-box"></use> </svg>
    <b>Add Your Products</b>

    <a href="javascript:void(0)" class="trigger-rules" onclick="show_product_sidebar('guidline')">Product Guidelines</a>
  </p>

	<form class="variations_form cart" @submit.prevent v-on:submit="add_product_to_cart('<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>')" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>" method="post" enctype='multipart/form-data' data-product_id="<?php echo absint( $product->get_id() ); ?>" data-product_variations="<?php echo htmlspecialchars( wp_json_encode( $available_variations ) ); // WPCS: XSS ok. ?>" id="single-product-variations">
		<?php do_action( 'woocommerce_before_variations_form' ); ?>

		<input type="hidden" value="<?php echo get_woocommerce_currency_symbol() ?>" ref="currency_symbol">

		<input type="hidden" value="<?php echo $product->get_id() ?>"    ref="product_id">

    <input type="hidden" value="<?php echo $free_product_id?: -1; ?>"    ref="product_id_free">

		<input type="hidden" value="<?php echo $product->get_title() ?>" ref="recipe_name">

    <input type="hidden" value="<?php echo $free_product_id? $free_product->get_title() : ''; ?>" ref="recipe_name_free">

		<input type="hidden" value='<?php echo json_encode($attribute_keys); ?>' ref="attributes">

		<?php if ( empty( $available_variations ) && false !== $available_variations ) : ?>
			<p class="stock out-of-stock"><?php esc_html_e( 'This product is currently out of stock and unavailable.', 'woocommerce' ); ?></p>
				<?php else :
				$attribute_labels = get_option('theme_attributes_images');
				?>
				<?php foreach ( $attributes as $attribute_name => $options ) :?>
   				<div class="variations hidden" id="block-variations">
			        <?php
			        $terms = get_terms(  $attribute_name,  array(
			          'hide_empty' => false,
			        ));

			        $term_data = array();

			        foreach ($terms as $key => $t) {
			        	$description = strip_tags(term_description($t, $attribute_name ));
			        	if($description){
			        		$term_data[$t->slug] =  str_replace(array("\r","\n"),"", $description);
			        	}
			        }

							$terms = wc_get_product_terms(
				          $product->get_id(),
				          $attribute_name,
				          array(
				              'fields' => 'all',
				          )
			        );

							wc_dropdown_variation_attribute_options( array(
								'options'   => $options,
								'attribute' => $attribute_name,
								'product'   => $product,
								'term_data' => $term_data
							) );

						?>
					</div>
				<?php endforeach; ?>
      <transition-group
        name="product-instance-options"
        tag="div"
        v-bind:css="false"
        v-on:before-enter="beforeEnter"
        v-on:enter="enter"
        v-on:leave="leave"
        v-on:after-enter="enterAfter"
        v-on:after-leave="leaveAfter"
      >

			<div class="product-instance-options"  v-for="(product, index) in products" :key="index" :ref="'instance_' + index" >
				<div class="clearfix">
					<text-input  v-bind:_id="index" v-on:product_name_changed="update_product_name($event, index)"  v-bind:class="'single-recipe__item-name'" :ref="'name'" v-model="product.name"></text-input>
			  </div>

        <?php if ($free_product_id && !is_sample_already_ordered( $free_product_id )): ?>
        <div class="row gutters-10">

          <div class="col-6">
            <div class="product-switcher" v-on:click=" order_product = 'regular' "  v-bind:class="{active : order_product === 'regular'}">
              <span class="product-switcher__option-view text-left">
                 <span class="row no-gutters">
                  <span class="col-8">
                    <span class="title">Multiple Photos </span>
                    <?php if ($image_counts): ?>
                    <span class="price"> <?php echo implode(' ', $image_counts); ?></span>
                    <?php endif ?>
                  </span>
                  <span class="col-4 valign-center text-right">
                    <span class="marked">from</span>
                    <span class="marked"><?php echo wc_price($min_price) ?></span>
                  </span>
                </span>
              </span>
            </div>
          </div><!-- col-6 -->

          <div class="col-6" >

            <transition
              v-bind:css="false"
              v-on:before-enter="beforeEnter"
              v-on:enter="enter"
              v-on:leave="leave"
              v-on:after-enter="enterAfter"
              v-on:after-leave="leaveAfter"
             >
              <div class="product-switcher" v-if="products.length <= 1" v-on:click=" update_selection_data(index, 'free') " v-bind:class="{active : order_product === 'free'}">
                <span class="product-switcher__option-view text-left">
                   <span class="row">
                    <span class="col-7">
                      <span class="title">Free Sample </span>
                      <span class="price"> 1 Photo</span>
                    </span>
                    <span class="col-5 valign-center">
                      <span class="free">Free</span>
                    </span>
                  </span>
                </span>
              </div>
            </transition>
          </div><!-- col-6 -->

        </div><!-- row -->
        <?php endif ?>


        <div class="spacer-h-10"> </div>
        <transition
          v-bind:css="false"
          v-on:before-enter="beforeEnter"
          v-on:enter="enter"
          v-on:leave="leave"
          v-on:after-enter="enterAfter"
          v-on:after-leave="leaveAfter"
         >
        <div class=""  v-if="order_product == 'regular'">
  				<?php
           foreach ( $attributes as $attribute_name => $options ): ?>
    					<?php if (count($attributes) > 1):
    						switch ($attribute_labels['attribute_'.$attribute_name ]['type']) {
    							case 'icon':
    								$icon  =  sprintf('<i class="icon-%s"></i>', $attribute_labels['attribute_'.$attribute_name ]['icon'] );
    								break;
    							case 'image':
    								$image_id  = (int)$attribute_labels['attribute_'.$attribute_name ]['icon_id'];
    				        $image_url = wp_get_attachment_image_url($image_id, 'thumbnail');
    				        $icon      = sprintf('<img class="image-icon" src="%s" height="18" width="18" alt="">', $image_url );
    								break;
    							default:
    								$icon = '';
    								break;
    						}
    						?>
    						<span class="single-recipe__label">
    							<?php echo $icon ?>
    							<b><?php echo wc_attribute_label( $attribute_name ); // WPCS: XSS ok. ?> </b>
    						</span>
    					<?php endif ?>
    	      	<div class="row gutters-10 justify-content-between" :ref="'attribute_<?php echo $attribute_name; ?>'">
    						<?php
    						   $terms = wc_get_product_terms(
                    $product->get_id(),
                    $attribute_name,
                    array(
                        'fields' => 'all',
                    )
                  );
    						foreach ($terms as $num => $term) {
    							?>
                    <product-option
                    v-bind:_id ="index"
                    _option_text="<?php echo $term->name ?>"
                    v-model="product.attributes['attribute_<?php echo $attribute_name ?>']"
                    _option_value="<?php echo $term->slug ?>"
                    _option_name="attribute_<?php echo $attribute_name ?>"
                    v-on:update_input_value="update_product($event, index, 'attribute_<?php echo $attribute_name; ?>')"></product-option>
    							<?php
    							} ?>
              </div><!-- row -->
      		    <div class="spacer-h-10"></div>
      		    <div class="spacer-h-10"></div>
  		  		<?php endforeach; ?>
          </div>
        </transition>
        <transition
          v-bind:css="false"
          v-on:before-enter="beforeEnter"
          v-on:enter="enter"
          v-on:leave="leave"
          v-on:after-enter="enterAfter"
          v-on:after-leave="leaveAfter"
         >
          <div class="woocommerce-notices-wrapper" v-if="product.alert_variations_no_select || product.alert_name || product.alert_variations_not_found || product.alert_name_duplicate">
            <transition-group
              name="errors-list"
              tag="ul"
              class="woocommerce-error-alt"
              role="alert"
              v-bind:css="false"
              v-on:before-enter="beforeEnter"
              v-on:enter="enter"
              v-on:leave="leave"
              v-on:after-enter="enterAfter"
              v-on:after-leave="leaveAfter"
            >
                <li v-for="(error, error_index) in errors" v-if="product[error_index]" :key="error_index">{{error}}</li>
            </transition-group>
          </div>
        </transition>
			</div><!-- product-instance-options -->
      </transition-group>

      <transition
        v-bind:css="false"
        v-on:before-enter="beforeEnter"
        v-on:enter="enter"
        v-on:leave="leave"
        v-on:after-enter="enterAfter"
        v-on:after-leave="leaveAfter"
       >
  			<div class="clearfix" v-if="order_product === 'regular'" >
  		    <a href="javascript:void(0)" v-on:click="add_new_product" class="trigger-add">[+]  Add Another Product</a>
  		  </div>
      </transition>

			<div class="spacer-h-10"></div>
			<div class="spacer-h-10"></div>
		  <div class="single-recipe__hr"></div>

			<p class="single-recipe__label">
        <svg class="icon svg-icon-size"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-size"></use> </svg>
        <b>Sizes</b>
      </p>

			<div class="row gutters-10 justify-content-between" id="row-sizes">
        <div class="col-6 col-md-3">
          <label class="single-recipe__option">
            <input type="checkbox" name="sizes" value="Square" v-model="sizes">
            <span class="single-recipe__option-view">
              <span class="size-view-icon"><span class="inner-view view-square"></span></span>
              <span class="title">Square</span>
              <span class="price">1:1</span>
            </span>
          </label>
        </div><!-- col -->

        <div class="col-6 col-md-3">
          <label class="single-recipe__option">
            <input type="checkbox" name="sizes" value="Story" v-model="sizes">
            <span class="single-recipe__option-view">
              <span class="size-view-icon"><span class="inner-view view-story"></span></span>
              <span class="title">Story</span>
              <span class="price">9:16</span>
            </span>
          </label>
        </div><!-- col -->

        <div class="col-6 col-md-3">
          <label class="single-recipe__option">
            <input type="checkbox" name="sizes" value="Wide" v-model="sizes">
            <span class="single-recipe__option-view">
              <span class="size-view-icon "><span class="inner-view view-wide"></span></span>
              <span class="title">Wide</span>
              <span class="price">3:2</span>
            </span>
          </label>
        </div><!-- col -->

        <div class="col-6 col-md-3">
          <label class="single-recipe__option">
            <input type="checkbox" name="sizes" v-model="sizes" value="Full HD">
            <span class="single-recipe__option-view">
              <span class="size-view-icon "><span class="inner-view view-full-hd"></span></span>
              <span class="title">Full HD</span>
              <span class="price">Max Size</span>
            </span>
          </label>
        </div><!-- col -->
      </div>
			<div class="spacer-h-10"></div>
			<div class="spacer-h-10"></div>

      <transition
        v-bind:css="false"
        v-on:before-enter="beforeEnter"
        v-on:enter="enter"
        v-on:leave="leave"
        v-on:after-enter="enterAfter"
        v-on:after-leave="leaveAfter"
       >
	  	<div class="woocommerce-notices-wrapper" v-if="sizes_alert">
	  		<ul class="woocommerce-error-alt">
			  	<li> Please select at least 1 size.	</li>
			  </ul>
		  </div>
      </transition>
		  <div class="single-recipe__hr"></div>

		  <p class="single-recipe__label">
        <svg class="icon svg-icon-pen"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-pen"></use> </svg>
        <b>Anything else we should know?</b>
      </p>

			<textarea name="comment"  v-model="comment" class="single-recipe__comment" placeholder="e.g. Only shoot the product from front angle"></textarea>

			<div class="single_variation_wrap">
				<?php
					/**
					 * Hook: woocommerce_before_single_variation.
					 */
					do_action( 'woocommerce_before_single_variation' );

					/**
					 * Hook: woocommerce_single_variation. Used to output the cart button and placeholder for variation data.
					 *
					 * @since 2.4.0
					 * @hooked woocommerce_single_variation - 10 Empty div for variation data.
					 * @hooked woocommerce_single_variation_add_to_cart_button - 20 Qty and cart button.
					 */
					do_action( 'theme_before_add_to_cart_form' );

					do_action( 'woocommerce_single_variation' );

					/**
					 * Hook: woocommerce_after_single_variation.
					 */
					do_action( 'woocommerce_after_single_variation' );
				?>
			</div>
		<?php endif; ?>

		<?php do_action( 'woocommerce_after_variations_form' ); ?>

	</form>
</div>
<?php
do_action( 'woocommerce_after_add_to_cart_form' );

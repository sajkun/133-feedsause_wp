<?php
/**
 * Edit address form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-edit-address.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;
global $wp;
$user = wp_get_current_user();

$page_title = ( 'billing' === $load_address ) ? __( 'Billing address', 'woocommerce' ) : __( 'Shipping address', 'woocommerce' );

do_action( 'woocommerce_before_edit_account_address_form' );
add_filter('woocommerce_form_field_args', function($args){
	$args['input_class'][] = 'white';
	return $args;
}, 9999);
?>

<?php if ( ! $load_address ) : ?>
	<?php wc_get_template( 'myaccount/my-address.php' ); ?>
<?php else : ?>
	<div class="container container_sm">
		<div class="spacer-h-50"></div>
<div class="woocommerce-MyAccount-content">
  	<?php if ('billing' === $load_address): ?>
    <?php if (class_exists('YWSBS_Subscription') && class_exists('YITH_WCMBS')):?>

		<div class="row">
    <div class="col-12 col-md-4 col-lg-3">
      <h4 class="my-order__column-title"><?php _e('Active Plan', 'theme-translations'); ?></h4>
      <p class="my-order__column-text"><?php _e('Your chosen plan for Feedsauce', 'theme-translations'); ?></p>
      <div class="spacer-h-25"></div>
    </div>

    <?php
    	$o = get_option('theme_settings');
  		global $product;
  		global $subscribe_single_type;

     ?>

	    <div class="col-12 col-md-8 col-lg-7">
	      <div class="fix-pixel-1">
	      	<?php
	      	if (user_is_premium()):
	      		$subscriptions = YWSBS_Subscription_Helper()->get_subscriptions_by_user( get_current_user_id() );
	      		$statuses      = ywsbs_get_status();
	      		$manager = new YITH_WCMBS_Member_Premium( get_current_user_id() );

	      		foreach ($subscriptions as $key => $subscription_post):
	      			$class = 'selected';
	      			$subscription = ywsbs_get_subscription( $subscription_post->ID );
	      			$start_date = ( $subscription->start_date ) ? date_i18n( wc_date_format(), $subscription->start_date ) : '';
	      			$product    = $subscription->get_product();
					    $price   = wc_price($product->get_price());
					    $price_per = get_post_meta( $product->get_id(), '_ywsbs_price_is_per', '1' );
					    $price_per_period_name = get_post_meta( $product->get_id(), '_ywsbs_price_time_option', 'days' );
					    $membership = $manager->get_memberships_by_subscription($subscription_post->ID);

					    if(in_array($membership[0]->status, array('paused','cancelled','suspended', 'expired')))
					    	  continue;
	      		?>
              <div class="plan-item <?php echo $class; ?>">
                <div class="plan-item__body">
                  <h4 class="plan-item__title"><?php echo esc_attr( $subscription->product_name );  ?> <span class="plan-item__tag addon"> <i class="icon-flash"></i> ADD-ON</span>
  		            <span class="plan-item__price">
		              <span class="value"><?php echo $price ?></span>/<?php echo $price_per ?> <?php echo $price_per_period_name ?>
		            </span>

                  </h4>
                  <p class="plan-item__comment"><?php _e('Premium Membership for additional benefits','theme-translations');?>.</p>

                  <?php if ('cancelled' !== $subscription->status): ?>
	                  <?php if ( $start_date): ?>
		                  <p class="plan-item__info"><?php _e('Last billing date', 'theme-translations'); ?> <b><?php echo $start_date ?></b></p>
	                  <?php endif ?>
                  <?php else: ?>
                  	<p style="font-size: 12px;"><?php _e('Membership was', 'theme-translations'); ?> <?php echo $statuses[$subscription->status] ?></p>
                  	<?php if ($membership[0]->end_date ): ?>
	                  	<p style="font-size: 12px;"><?php _e('Expire date', 'theme-translations'); ?>: <?php echo date_i18n( wc_date_format(), $membership[0]->end_date ) ?></p>
                  	<?php endif ?>
                  <?php endif ?>

                  <?php if(  $subscription->can_be_cancelled() && ('cancelled' !== $subscription->status)): ?>
                  <div class="plan-item__row">
                    <a href="<?php echo esc_url( $subscription->get_change_status_link( 'cancelled' ) ) ?>&redirect=billing" class="link-prem"><?php _e('Cancel Membership', 'theme-translations'); ?></a>
                  </div>
                  <?php endif ?>
                  <?php if(  $subscription->can_be_resumed()): ?>
                    <a href="<?php echo esc_url( $subscription->get_change_status_link( 'resumed' ) ) ?>&redirect=billing" class="link-prem"><?php _e('Resume Membership', 'theme-translations'); ?></a>
                  <?php endif ?>
                </div>
              </div><!-- plan-item -->
		        <?php endforeach; ?>
		        <div class="plan-item">

		          <div class="plan-item__body">
		            <h4 class="plan-item__title">Feedsauce <span class="plan-item__tag basic"><?php _e('BASIC','theme-translations');?></span>
		            	<?php if (isset($o['single_product_price'])): ?>
				            <span class="plan-item__price">
				                <span class="value"><?php echo wc_price($o['single_product_price']); ?></span>/<?php _e('image','theme-translations');?>
				            </span>
		            	<?php endif ?>
		            </h4>
		            <p class="plan-item__comment"><?php _e('Custom images on-demand, pay as you go','theme-translations');?></p>
		          </div>
		        </div><!-- plan-item -->

	      	<?php else:
			  		$old_product  = $product;
			  		$subscription = get_post($o['subscription']);
			  		$product      = wc_get_product( $subscription );
			  		$subscribe_single_type = 'link';
				    $price   = wc_price($product->get_price());
				    $price_per = get_post_meta( $product->get_id(), '_ywsbs_price_is_per', '1' );
				    $price_per_period_name = get_post_meta( $product->get_id(), '_ywsbs_price_time_option', 'days' );
	      		?>
		        <div class="plan-item  selected">

		          <div class="plan-item__body">
		            <h4 class="plan-item__title">Feedsauce <span class="plan-item__tag basic"><?php _e('BASIC','theme-translations');?></span>
		            	<?php if (isset($o['single_product_price'])): ?>
				            <span class="plan-item__price">
				                <span class="value"><?php echo wc_price($o['single_product_price']); ?></span>/<?php _e('image','theme-translations');?>
				            </span>
		            	<?php endif ?>
		            </h4>
		            <p class="plan-item__comment"><?php _e('Custom images on-demand, pay as you go','theme-translations');?></p>
		          </div>
		        </div><!-- plan-item -->
		        <?php
		         ?>
		         <?php if (isset($o['subscription']) && (int)$o['subscription']>=0): ?>

		        <div class="plan-item ">
		          <div class="plan-item__body">
		            <h4 class="plan-item__title"><?php echo esc_attr($subscription->post_title);  ?> <span class="plan-item__tag addon"> <i class="icon-flash"></i> ADD-ON</span>
		            <span class="plan-item__price">
		              <span class="value"><?php echo $price ?></span>/<?php
		               $per = sprintf('%s %s %s', __('per', 'theme-translations'), $price_per , $price_per_period_name);

		               echo str_replace(array('30 days', '31 days'), 'month', $per);
		               ?>
		            </span>

		            </h4>
		            <p class="plan-item__comment"><?php _e('Premium Membership for additional benefits','theme-translations');?>.</p>
		            <div class="plan-item__row">
		            	<?php do_action('do_theme_purchase_premium');?>
		              <?php if (isset($o['about_subscription'])): ?>
		              <a href="<?php echo esc_url($o['about_subscription']) ?>" class="link-learn"><?php _e('Learn More','theme-translations');?></a>
		              <?php endif ?>
		            </div>
		          </div>
		        </div><!-- plan-item -->
		         <?php endif ?>
	         <?php endif ?>
	      </div>
	    </div><!-- col-12 col-md-6 -->
	  </div>
	<div class="spacer-h-45"></div>
	<?php endif ?>
  <?php endif ?>
	<form method="post" class="billing-my-form">
		<div class="row">
			<div class="col-12 col-md-4 col-lg-3">
				<h4 class="my-order__column-title"><?php echo apply_filters( 'woocommerce_my_account_edit_address_title', $page_title, $load_address ); ?></h4><?php // @codingStandardsIgnoreLine ?>
				<?php if('billing' === $wp->query_vars['edit-address']):?>
				<p class="my-order__column-text"><?php _e('Edit your billing details','theme-translations');?></p>
				<?php elseif('shipping' === $wp->query_vars['edit-address']):?>
				<p class="my-order__column-text"><?php _e('Edit your shipping details','theme-translations');?></p>
				<?php endif; ?>
			</div>

			<div class="woocommerce-billing-fields col-12 col-md-8 col-lg-7">
				<div class="fix-pixel-1">
					<?php do_action( "woocommerce_before_edit_address_form_{$load_address}" ); ?>

					<div class="woocommerce-billing-fields__field-wrapper">
						<?php

						$fields_order  = ('billing' === $load_address)?
							array(
								'billing_company'   =>  array('open' => '<div class="row gutters-10">', 'close' =>'</div>'),
								'billing_address_1' => array('open' => '<div class="row gutters-10">', 'close' =>''),
								'billing_address_2' => array('open' => '', 'close' =>'</div>'),
								'billing_city'      => array('open' => '<div class="row gutters-10">', 'close' =>''),
								'billing_state'     => array('open' => '', 'close' =>'</div>'),
								'billing_postcode'  => array('open' => '<div class="row gutters-10">', 'close' =>''),
								'billing_country'   => array('open' => '', 'close' =>'</div>'),
							)
							:
							array(
								'shipping_address_1' => array('open' => '<div class="row gutters-10">', 'close' =>''),
								'shipping_address_2' => array('open' => '', 'close' =>'</div>'),
								'shipping_city'      => array('open' => '<div class="row gutters-10">', 'close' =>''),
								'shipping_state'     => array('open' => '', 'close' =>'</div>'),
								'shipping_postcode'  => array('open' => '<div class="row gutters-10">', 'close' =>''),
								'shipping_country'   => array('open' => '', 'close' =>'</div>'),
							)
							;

						foreach (  $fields_order as $key => $wrapper ) {
							$field = $address[$key];
							if ( isset( $field['country_field'], $address[ $field['country_field'] ] ) ) {
								$field['country'] = wc_get_post_data_by_key( $field['country_field'], $address[ $field['country_field'] ]['value'] );
							}
							echo $wrapper['open'];
							woocommerce_form_field( $key, $field, wc_get_post_data_by_key( $key, $field['value'] ) );
							echo $wrapper['close'];
						}
						?>
					</div>

					<?php do_action( "woocommerce_after_edit_address_form_{$load_address}" ); ?>

					<div class="row gutters-10">
						<div class="col-12">
							<input type="submit"  name="save_address" value="<?php esc_attr_e( 'Save address', 'woocommerce' ); ?>">
							<?php wp_nonce_field( 'woocommerce-edit_address', 'woocommerce-edit-address-nonce' ); ?>
							<input type="hidden" name="action" value="edit_address" />
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>

<?php endif; ?>

<?php do_action( 'woocommerce_after_edit_account_address_form' ); ?>
</div>
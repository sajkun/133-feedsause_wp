<?php
/**
 * Cart item data (when outputting non-flat)
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart-item-data.php.
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
 * @version 	2.4.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="variation row">
	<?php
    $class = (count($item_data) > 1) ? 'col-6' : 'col-12';
    foreach ( $item_data as $data ) :
    $display = apply_filters('filter_theme_variation_value', $data['display'], $data['key'] );
    if(!$display) continue;
    ?>
    <div class="<?php echo $class ?>">
    <p class="checkout__aside-subtitle <?php echo sanitize_html_class( 'variation-' . $data['key'] ); ?>"><?php echo wp_kses_post( $data['key'] ); ?></p>

      <div class="checkout-item__text <?php echo sanitize_html_class( 'variation-' . $data['key'] ); ?>">
        <?php
        ?>
       <i class="icon-items"></i> <?php echo wp_kses_post( ( $display ) ); ?>
      </div>
    </div>
  <?php endforeach; ?>
</div>

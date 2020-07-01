<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

global $product;



// Ensure visibility.
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}

$return_product_id = (int)get_option('wfp_return_product_id');
$priority_delivery_product_id  = (int)get_option('wfp_priority_delivery_product_id');
$single_product_id  = (int)get_option('wfp_single_product_id');

// Ensure that single product or subscription are invisble in product's list

$is_subsciption    = get_post_meta($product->get_id(), '_ywsbs_subscription', true);

if ( ( 'yes' === $is_subsciption ) || ((int)$single_product_id  === $product->get_id())  || ((int)$priority_delivery_product_id  === $product->get_id())  || ((int)$return_product_id  === $product->get_id()) ) {
	return;
}

global $theme_product_widget_size;
$class = ('large' == $theme_product_widget_size)? array('product','product_lg'): array('product','product_contrast','product_md');

?>
<div <?php wc_product_class($class, $product->get_id()); ?>>
	<?php
	/**
	 * Hook: woocommerce_before_shop_loop_item.
	 *
	 * @hooked theme_content_output::print_product_loop_open_image - 10

	 * @hooked theme_content_output::print_product_open_link - 20
	 */
	do_action( 'woocommerce_before_shop_loop_item' );

	/**
	 * Hook: woocommerce_before_shop_loop_item_title.
	 *
	 * @hooked woocommerce_show_product_loop_sale_flash - 10
	 * @hooked woocommerce_template_loop_product_thumbnail - 10
	 * @hooked woocommerce_template_loop_product_link_close - 11
	 * @hooked theme_content_output::print_product_loop_close_div - 12
	 * @hooked theme_content_output::theme_print_product_loop_tag - 15
	 * @hooked theme_content_output::print_product_loop_open_row - 9999
	 */
	do_action( 'woocommerce_before_shop_loop_item_title' );

	/**
	 * Hook: woocommerce_shop_loop_item_title.
	 *
	 * @hooked theme_content_output::theme_print_product_loop_title - 10
	 * @hooked theme_content_output::theme_print_product_loop_description - 15
	 * @hooked theme_content_output::theme_print_product_loop_gallery - 20
	 */
	do_action( 'woocommerce_shop_loop_item_title' );

	/**
	 * Hook: woocommerce_after_shop_loop_item_title.
	 *
	 * @hooked woocommerce_template_loop_rating - 5
	 */
	do_action( 'woocommerce_after_shop_loop_item_title' );

	/**
	 * Hook: woocommerce_after_shop_loop_item.
	 *
	 * @hooked woocommerce_template_loop_add_to_cart - 10
	 */
	do_action( 'woocommerce_after_shop_loop_item' );
	?>
</div>

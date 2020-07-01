<?php
/**
 * Custom code shortcode
 *
 * This template can be overridden by copying it to yourtheme/plugin-folder-name/woo_mail/custom_code.php.
 * @var $order WooCommerce order
 * @var $email_id WooCommerce email id (new_order, cancelled_order)
 * @var $sent_to_admin WooCommerce email send to admin
 * @var $plain_text WooCommerce email format
 * @var $email WooCommerce email object
 * @var $attr array custom code attributes
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Example for the short code [woo_mb_custom_code type="pre-order-link"]
//if(isset($attr['type']) && $attr['type'] == 'pre-order-link'){
//    printf( __( "Your pre-order is now available, but requires payment. %sPlease pay for your pre-order now.%s", 'wc-pre-orders' ), '<a href="' . $order->get_checkout_payment_url() . '">', '</a>' );
//}




if(isset($attr['type']) && $attr['type'] == 'collection-date'){  

$date = the_field( "collection-date" , $order->id );


}




if(isset($attr['type']) && $attr['type'] == 'postage-label'){  


$file = get_field('postage-label' , $order->id );

printf( '<a style="background:#5156EA; color:#fff; margin-top:15px; padding:10px; border-radius:5px; text-decoration:none !important;" href="%1$s">Print Postage Label</a>', $file );


}
    
    
    










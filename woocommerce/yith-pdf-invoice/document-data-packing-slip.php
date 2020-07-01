<?php
/**
 * Override this template by copying it to [your theme folder]/woocommerce/yith-pdf-invoice
 *
 * @author        Yithemes
 * @package       yith-woocommerce-pdf-invoice-premium/Templates
 * @version       1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

/* @var YITH_Shipping $document */

$current_order   = $document->order;
$invoice_details = new YITH_Invoice_Details( $document );
?>


<p style="margin-top:0px !important; font-size:28px; text-align:right;">Studio Check-In</p>


<div class="invoice-data-content">
	<table>
		<?php do_action( 'yith_ywpi_show_packing_slip_data_start', $document ); ?>

		<tr class="ywpi-order-number">
			<td class="left-content">
				<?php _e( "Order No.", 'yith-woocommerce-pdf-invoice' ); ?>
			</td>
			<td class="right-content">
				<?php echo $document->order->get_order_number(); ?>
				<?php do_action( 'yith_ywpi_template_order_number', $document ); ?>
			</td>
		</tr>

		<?php do_action( 'yith_ywpi_show_packing_slip_data_after_order_number', $document ); ?>

		<tr class="ywpi-invoice-date">
			<td class="left-content">
				<?php _e( "Order date", 'yith-woocommerce-pdf-invoice' ); ?>
			</td>
			<td class="right-content">
				<?php echo $document->get_formatted_order_date(  ); ?>
			</td>
		</tr>

		<?php do_action( 'yith_ywpi_show_packing_slip_data_after_order_date', $document ); ?>

			<tr class="ywpi-invoice-date">
			<td class="left-content">
				<?php _e( "Product Location", 'yith-woocommerce-pdf-invoice' ); ?>
			</td>
			<td class="right-content">
			
				
							<?php the_field( 'location' , $current_order->get_id() ); ?>	
				
			</td>
		</tr>

	

		<?php do_action( 'yith_ywpi_show_packing_slip_data_end', $document ); ?>
	</table>
	
	<p>Studio Notes:</p></br>
	
	<?php the_field( 'studio-notes' , $current_order->get_id() ); ?>


</div>
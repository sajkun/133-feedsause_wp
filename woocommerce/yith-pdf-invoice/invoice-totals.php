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

/** @var WC_Order $current_order */
/** @var YITH_Document $document */

$current_order   = $document->order;
$invoice_details = new YITH_Invoice_Details( $document );

$total_section_color = get_option('ywpi_total_section_color');

?>

<?php if ( ywpi_is_visible_order_totals( $document ) ) : ?>
	<div class="document-totals">
		<table class="invoice-totals">
			<tr class="invoice-details-subtotal">
				<td class="left-content column-product"><?php _e( "Subtotal", 'yith-woocommerce-pdf-invoice' ); ?>
					<?php
					if( ywpi_is_visible_order_discount( $document ) ):
						if( YITH_PDF_Invoice()->subtotal_incl_discount ):
							_e('Discount inc.','yith-woocommerce-pdf-invoice');
						else:
							_e('Discount exc.','yith-woocommerce-pdf-invoice');
						endif;
					endif;
					?>
				</td>
				<td class="right-content column-total"><?php echo $invoice_details->get_order_currency_new( $invoice_details->get_order_subtotal( YITH_PDF_Invoice()->subtotal_incl_discount ) ); ?>
                </td>
			</tr>

			<?php if ( ywpi_is_visible_order_discount( $document ) ): ?>
				<tr>
					<td class="left-content column-product"><?php _e( "Discount", 'yith-woocommerce-pdf-invoice' ); ?></td>
					<td class="right-content column-total"><?php echo apply_filters( 'yith_ywpi_invoice_totals_discount_symbol', '- ') . $invoice_details->get_order_currency_new( $invoice_details->get_order_discount() ); ?></td>
				</tr>
			<?php endif; ?>

			<?php if ( 'yes' == get_option( 'woocommerce_calc_taxes' ) ) :
				foreach ( $invoice_details->get_order_taxes() as $code => $tax ) :

                    if ( $tax['total'] <= 0 ){
                        continue;
                    }
                    ?>
					<tr class="invoice-details-vat">
						<td class="left-content column-product"><?php echo $tax['label']; ?>:</td>
						<td class="right-content column-total"><?php echo $invoice_details->get_order_currency_new($tax['total_tax']); ?></td>
					</tr>
				<?php endforeach; ?>
			<?php endif; ?>

			<?php do_action( 'yith_pdf_invoice_before_total', $current_order ); ?>

			<tr class="invoice-details-total">
				<td class="left-content column-product" style="background-color: <?php echo $total_section_color;?>"><?php _e( "Total", 'yith-woocommerce-pdf-invoice' ); ?></td>
				<td class="right-content column-total" style="background-color: <?php echo $total_section_color;?>"><?php echo $invoice_details->get_order_currency_new( $invoice_details->get_order_total() ); ?></td>
			</tr>
		</table>
	</div>
<?php endif; ?>
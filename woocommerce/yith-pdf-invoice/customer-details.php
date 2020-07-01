<?php
/**
 * The Template for invoice
 *
 * Override this template by copying it to [your theme]/woocommerce/invoice/ywpi-invoice-template.php
 *
 * @author        Yithemes
 * @package       yith-woocommerce-pdf-invoice-premium/Templates
 * @version       1.0.0
 */

if ( ! defined ( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly
?>



<div class="ywpi-customer-details">



	<div class="ywpi-customer-content">
	
<div style="margin-bottom:30px;"><img class="alignnone size-full wp-image-3222" src="https://feedsauce.com/wp-content/uploads/2019/09/fs-invoice-1.png" alt="" width="180" height="auto" /></div>

		
	


		<?php echo $content; ?>
		<?php do_action ( 'yith_pdf_invoice_after_customer_content', $document, $order_id ); ?>
	</div>
</div>
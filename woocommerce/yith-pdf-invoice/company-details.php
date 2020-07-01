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

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

?>

<div class="company-header">

	<div class="ywpi-company-details">
	
	

		<div class="ywpi-company-content">


			<?php if ( isset ( $company_details ) ): ?>
				<div>
					<span class="company-details">

					<?php echo $company_details; ?></span>
				</div>
			<?php endif; ?>
		</div>
	</div>

</div>


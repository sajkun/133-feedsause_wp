<?php
/**
 * Edit account form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-edit-account.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_edit_account_form' ); ?>
<div class="container container_sm">
  <div class="spacer-h-50"></div>
<form class="woocommerce-EditAccountForm edit-account" action="" method="post" <?php do_action( 'woocommerce_edit_account_form_tag' ); ?> >

	<?php do_action( 'woocommerce_edit_account_form_start' ); ?>

	<div class="row">
		<div class="col-12 col-md-4 col-lg-3">
      <p class="my-order__column-title"><?php _e('Personal Information','theme-translations'); ?></p>
      <p class="my-order__column-text"><?php _e('Edit your name, e-mail and','theme-translations'); ?> <br> <?php _e('contact details','theme-translations'); ?></p>
      <div class="spacer-h-25"></div>
    </div>

    <div class="col-12 col-md-8 col-lg-7">
    	<div class="fix-pixel-1">
    		<div class="row gutters-10">
					<div class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first col-12 col-md-6  label-checkout-holder <?php echo( $user->first_name )? 'selected':'';?>">
						<label for="account_first_name"><?php esc_html_e( 'First name', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
						<input type="text" class="white woocommerce-Input woocommerce-Input--text input-text form-field" name="account_first_name" id="account_first_name" autocomplete="given-name" value="<?php echo esc_attr( $user->first_name ); ?>" />
					</div>
					<div class="woocommerce-form-row woocommerce-form-row--last form-row form-row-last col-12 col-md-6  label-checkout-holder <?php echo( $user->last_name )? 'selected':'';?>">
						<label for="account_last_name"><?php esc_html_e( 'Last name', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
						<input type="text" class="white woocommerce-Input woocommerce-Input--text input-text form-field" name="account_last_name" id="account_last_name" autocomplete="family-name" value="<?php echo esc_attr( $user->last_name ); ?>" />
					</div>
				</div>

				<div class="row gutters-10">
					<div class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide col-12 label-checkout-holder <?php echo( $user->first_name )? 'selected':'';?>">
						<label title="<?php esc_html_e( 'This will be how your name will be displayed in the account section and in reviews', 'woocommerce' ); ?>" for="account_display_name"><?php esc_html_e( 'Display name', 'woocommerce' ); ?></label>
						<input type="text" class="white woocommerce-Input woocommerce-Input--text input-text form-field" name="account_display_name" id="account_display_name" value="<?php echo esc_attr( $user->display_name ); ?>" />
					</div>
				</div>

				<div class="row gutters-10">
					<div class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide col-12 label-checkout-holder <?php echo( $user->user_email )? 'selected':'';?>">
						<label for="account_email"><?php esc_html_e( 'Email address', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
						<input type="email" class="white woocommerce-Input woocommerce-Input--email input-text form-field" name="account_email" id="account_email" autocomplete="email" value="<?php echo esc_attr( $user->user_email ); ?>" />
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="spacer-h-45"></div>

	<div class="row">
		<div class="col-12 col-md-4  col-lg-3">
      <p class="my-order__column-title"><?php _e('Authentication','theme-translations'); ?></p>
      <p class="my-order__column-text"><?php _e('Change your password','theme-translations'); ?></p>
      <div class="spacer-h-25"></div>
    </div>
    <div class="col-12 col-md-8 col-lg-7">
    	<div class="fix-pixel-1">
  			<div class="clearfix label-checkout-holder label-checkout-holder__icon">
    			<div class="input-with-icon ">
							<svg class="icon svg-icon-key"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-key"></use> </svg>

							<label for="password_current"><?php esc_html_e( 'Current password (leave blank to leave unchanged)', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>

							<input type="password" class="white woocommerce-Input woocommerce-Input--password input-text form-field" name="password_current" id="password_current" autocomplete="off" placeholder="<?php esc_html_e( 'Current password (leave blank to leave unchanged)', 'woocommerce' ); ?>"/>
					</div>
    		</div>
    		<div class="row">
					<div class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide col-12 label-checkout-holder">
						<label for="password_1"><?php esc_html_e( 'Current password (leave blank to leave unchanged)', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>

						<input type="password" class="white woocommerce-Input woocommerce-Input--password input-text form-field" name="password_1" id="password_1" autocomplete="off" />
					</div>
    		</div>
    		<div class="row">
					<div class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide col-12 label-checkout-holder">
						<label for="password_2"><?php esc_html_e( 'Confirm new password', 'woocommerce' ); ?></label>

						<input type="password" class="white woocommerce-Input woocommerce-Input--password input-text form-field" name="password_2" id="password_2" autocomplete="off"/>
					</div>
    		</div>

				<?php do_action( 'woocommerce_edit_account_form' ); ?>

				<div class="row gutters-10">
					<div class="col-12">

						<?php wp_nonce_field( 'save_account_details', 'save-account-details-nonce' ); ?>
						<button type="submit" class="woocommerce-Button button form-submit" name="save_account_details" value="<?php esc_attr_e( 'Save changes', 'woocommerce' ); ?>"><?php esc_html_e( 'Save changes', 'woocommerce' ); ?></button>
						<input type="hidden" name="action" value="save_account_details" />
					</div>
				</div>

				<?php do_action( 'woocommerce_edit_account_form_end' ); ?>
			</div>
		</div>
	</div>
</form>

<?php do_action( 'woocommerce_after_edit_account_form' ); ?>
</div>
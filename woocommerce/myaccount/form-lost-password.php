<?php
/**
 * Lost password form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-lost-password.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.2
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_lost_password_form' );
?>
<div class="spacer-h-50 hidden-xs"></div>
<div class="spacer-h-50 hidden-xs"></div>
<div class="container" id="customer_login">

	<div class="row justify-content-center">
	<div class="auth-block">
	<?php
	$custom_logo_id = get_theme_mod( 'custom_logo' );
  $custom_logo_url = wp_get_attachment_image_url( $custom_logo_id , 'full' );
	?>
		<a href="<?php echo HOME_URL; ?>" class="logo">
      <?php
			echo (empty(get_theme_mod( 'custom_logo' ))) ?
              sprintf('<span class="logo__full logo__icon_b"><img src="%s/images/fs-logo-dark.svg" alt=""></span>',THEME_URL):
              sprintf('<span class="logo__full logo__icon_b"><img src="%s" alt=""></span>', esc_url( $custom_logo_url ));
      ?>
    </a>
<form method="post" class="woocommerce-ResetPassword lost_reset_password">
	<p class="auth-block__title">
		<?php esc_html_e( 'Forgot Password?', 'woocommerce' ); ?>
	</p>
  <?php do_action( 'theme_custom_before_login' ); ?>
	<p><?php echo apply_filters( 'woocommerce_lost_password_message', esc_html__( ' Please enter your username or email address. You will receive a link to create a new password via email.', 'woocommerce' ) ); ?></p><?php // @codingStandardsIgnoreLine ?>
	<div class="clearfix">

	<p class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first  input-with-icon">
		<svg class="icon svg-icon-email"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-email"></use> </svg>
		<input class="woocommerce-Input woocommerce-Input--text input-text" type="text" name="user_login" id="user_login" autocomplete="username" placeholder="<?php esc_html_e( 'Username or email', 'woocommerce' ); ?>" />
	</p>
	</div>

	<div class="clear"></div>

	<?php do_action( 'woocommerce_lostpassword_form' ); ?>

	<p class="woocommerce-form-row form-row">
		<input type="hidden" name="wc_reset_password" value="true" />
		<button type="submit" class="woocommerce-Button button auth-block__submit" value="<?php esc_attr_e( 'Reset password', 'woocommerce' ); ?>"><?php esc_html_e( 'Reset password', 'woocommerce' ); ?></button>
	</p>
	<?php $my_account_id = get_option('woocommerce_myaccount_page_id'); ?>
  <p class="auth-block__text lg">
     <?php _e('Remember Password','theme-translations');?>? <a href="<?php echo esc_url(get_permalink( $my_account_id ))?>" class="link-blue"> Log In</a>.
  </p>
	<?php wp_nonce_field( 'lost_password', 'woocommerce-lost-password-nonce' ); ?>

</form>
</div>
</div>
<?php
do_action( 'woocommerce_after_lost_password_form' );
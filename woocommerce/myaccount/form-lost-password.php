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
  <div class="site-container">
    <div class="container-fluid">
      <div class="row height-100vh white-bg no-gutters">
        <div class="col-435">
          <div class="column-justify">

            <div class="clearfix">
              <div class="spacer-h-45"></div>
              <a href="<?php echo HOME_URL; ?>" class="logo"><img src="<?php echo THEME_URL?>/images/logo_sign.svg" alt=""></a>
            </div>

            <div class="clearfix text-left cta-sign-text">
              Your product, <br> shot <span class="marked">1 million</span> <br> ways.
            </div>

            <div class="clearfix">
              <img src="<?php echo THEME_URL?>/images/logos.png" alt="">
              <div class="spacer-h-75"></div>
            </div>
          </div>
        </div>

        <div class="col">
          <div class="login-form-holder">
            <div class="spacer-h-45"></div>

            <div class="row">
              <div class="col-8">
                <a href="javascript:history.go(-1)" class="back-button">
                <svg class="icon svg-icon-bracket"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-bracket"></use></svg> Back</a>
              </div>
              <div class="col-4 text-right show-mobile">
                <a href="<?php echo HOME_URL; ?>">
                  <img src="<?php echo THEME_URL?>/images/logo-single.svg" alt="">
                </a>
              </div>
            </div>

            <div class="spacer-h-40 spacer-h-md-90"></div>

            <h2 class="login-title">Reset Password</h2>

            <div class="spacer-h-10"></div>

            <p class="auth-text"><?php echo apply_filters( 'woocommerce_lost_password_message', esc_html__( ' Please enter your username or email address. You will receive a link to create a new password via email.', 'woocommerce' ) ); ?></p><?php // @codingStandardsIgnoreLine ?>

            <div class="spacer-h-25"></div>


            <div class="row">
              <div class="col-12">
                <label for="" class="login-label">E-mail</label>
                <input class="login-field" autocomplete="username" placeholder="<?php esc_html_e( 'Username or email', 'woocommerce' ); ?>" />
                <div class="spacer-h-20"></div>
              </div>
            </div><!-- row -->

            <button class="login-button">
              <span class="login-button__text"><?php esc_html_e( 'Reset password', 'woocommerce' ); ?></span>
              <span class="login-button__icon">

              </span>
            </button>

            <div class="spacer-h-20"></div>

            <?php $my_account_id = get_option('woocommerce_myaccount_page_id'); ?>
            <p class="login-label">
               <?php _e('Remember Password','theme-translations');?>? <a class="auth-link" href="<?php echo esc_url(get_permalink( $my_account_id ))?>" class="link-blue"> Log In</a>.
            </p>
            <?php wp_nonce_field( 'lost_password', 'woocommerce-lost-password-nonce' ); ?>

          </div>
          <div class="spacer-h-90"></div>
          <nav class="sign-in-menu-holder">
            <ul class="sign-in-menu">
              <li>
                © Feedsauce 2021
              </li>
              <li><a>Support</a></li>
              <li><a>Terms of Use</a></li>
              <li><a>Privacy</a></li>
            </ul>
          </nav>
        </div>


      </div><!-- row -->
    </div><!-- container-fluid -->
  </div><!-- site-container -->


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
<?php
/**
 * Login Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

do_action( 'woocommerce_before_customer_login_form' ); ?>

<style>
  .woocommerce-password-strength{
    display: none!important;
    visibility: hidden;
    opacity: 0;
  }
</style>
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
<?php if (empty($_GET['create_account']) || ($_GET['create_account'] != 'do')): ?>
    <p class="auth-block__title">
      <?php esc_html_e( 'Login', 'woocommerce' ); ?>
      <a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( 'Forgot Password?', 'woocommerce' ); ?></a>
    </p>
    <?php do_action('theme_custom_before_login'); ?>
    <form class="woocommerce-form woocommerce-form-login login" method="post">

      <?php do_action( 'woocommerce_login_form_start' ); ?>
      <div class="clearfix">
        <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide input-with-icon">
          <svg class="icon svg-icon-email"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-email"></use> </svg>
          <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" placeholder="<?php esc_html_e( 'Username or email address', 'woocommerce' ); ?>" /><?php // @codingStandardsIgnoreLine ?>
        </p>
      </div>
      <div class="clearfix">
        <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide input-with-icon">
          <svg class="icon svg-icon-key"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-key"></use> </svg>
          <input class="woocommerce-Input woocommerce-Input--text input-text" type="password" name="password" id="password" autocomplete="current-password" placeholder="<?php esc_html_e( 'Password', 'woocommerce' ); ?>*"/>
        </p>
      </div>

      <?php do_action( 'woocommerce_login_form' ); ?>

      <p class="form-row">
        <?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
        <button type="submit" class="woocommerce-Button button auth-block__submit" name="login" value="<?php esc_attr_e( 'Log in', 'woocommerce' ); ?>"><?php esc_html_e( 'Login', 'theme-translations' ); ?></button>

        <?php /*<label class="woocommerce-form__label woocommerce-form__label-for-checkbox inline">
          <input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" /> <span><?php esc_html_e( 'Remember me', 'woocommerce' ); ?></span>
        </label> */?>
      </p>
      <div class="clearfix">
        <?php wp_nonce_field('google-auth-nonce-test', 'google_auth_nonce', true, true); ?>
        <div class="g-signin22" id="google-sign-in"></div>

        <script>

          function renderButton() {
            gapi.signin2.render('google-sign-in', {
              'text' : 'Login with google',
              'scope': 'profile email',
              'width': 320,
              'height': 45,
              'longtitle': true,
              'theme': 'Light',
              'onsuccess': onSignInDashboard,
              'onfailure': onFailure
            });
          }
        </script>

        <script src="https://apis.google.com/js/platform.js?onload=renderButton" async defer></script>

      </div>
      <div class="spacer-h-10"></div>
      <div class="spacer-h-10"></div>
      <?php if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ): ?>
      <p class="auth-block__text lg">
	       <?php _e('Don’t have an account','theme-translations');?>?  <a href="?create_account=do" class="link-blue"> <?php _e('Sign up for free','theme-translations');?></a>.
      </p>
      <?php endif; ?>

      <?php
        if(isset($_GET['product_id'])){
          $constructor_url = get_permalink(get_option('theme_page_constructor'));
          $product_url = $constructor_url.'?product_id='.$_GET['product_id'].'&add_to_cart='.$_GET['product_id'];
        }
        $redirect = !isset($_GET['product_id'])? esc_url(wc_get_account_endpoint_url( 'orders' )) : $product_url;
      ?>
      <input type="hidden" name="redirect" value="<?php echo $redirect;  ?>">

			<?php do_action( 'woocommerce_login_form_end' ); ?>

		</form>
<?php endif; ?>

<?php if ( (get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) && !empty($_GET['create_account']) && ($_GET['create_account'] === 'do')) : ?>

		<h2><?php esc_html_e( 'Create Account', 'theme-translations' ); ?></h2>
    <?php do_action( 'woocommerce_login_form_start' ); ?>
		<form method="post" class="woocommerce-form woocommerce-form-register register"  >
      <?php do_action( 'theme_custom_before_login' ); ?>
			<?php do_action( 'woocommerce_register_form_start' ); ?>

      <?php if ( 'yes' === get_option( 'woocommerce_registration_first_last_name' ) ) : ?>
        <div class="row gutters-10">
          <div class="col-6">
            <input type="text" placeholder="First Name" class="form-field" name="customer_first_name" id="customer_first_name" >
          </div>
          <div class="col-6">
            <input type="text" placeholder="Last Name" class="form-field" placeholder="Last Name" name="customer_last_name" id="customer_last_name">
          </div>
        </div>

      <?php endif; ?>

      <?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>
      <div class="clearfix">
        <div class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
          <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="reg_username" autocomplete="username" placeholder="<?php esc_html_e( 'Username', 'woocommerce' ); ?>" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
        </div>
      </div>
      <?php endif; ?>
			<div class="clearfix">
				<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide input-with-icon">
					<svg class="icon svg-icon-email"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-email"></use> </svg>
					<input type="email" placeholder="<?php esc_html_e( 'Email address', 'woocommerce' ); ?>" class="woocommerce-Input woocommerce-Input--text input-text" name="email" id="reg_email" autocomplete="email" value="<?php echo ( ! empty( $_POST['email'] ) ) ? esc_attr( wp_unslash( $_POST['email'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
				</p>
			</div>

			<?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>
			<div class="clearfix">
				<div class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide ">
					<p class="input-with-icon password-input">

					<svg class="icon svg-icon-key"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-key"></use> </svg>
					<input type="password" class="woocommerce-Input woocommerce-Input--text input-text" name="password" id="reg_password" autocomplete="new-password" placeholder="<?php esc_html_e( 'Password', 'woocommerce' ); ?>"/>
            <span class="show-password-input"></span>
					</p>
				</div>
			</div>

			<?php endif; ?>

			<?php do_action( 'woocommerce_register_form' ); ?>
			<?php if((int)get_option( 'woocommerce_terms_page_id' ) > 0):?>
				<p class="auth-block__text">
	        <?php esc_attr_e( 'By creating an account, you agree to the', 'theme-translations' ); ?> <a href="<?php echo esc_url(get_permalink((int)get_option( 'woocommerce_terms_page_id' )))?>" class="link-grey"> <?php esc_html_e( 'Terms of Service', 'theme-translations' ); ?></a>.
	      </p>
	    <?php endif; ?>

      <p class="woocommerce-FormRow form-row">
        <?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
        <button type="submit" class="woocommerce-Button button auth-block__submit" name="register" value="<?php esc_attr_e( 'Register', 'woocommerce' ); ?>"><?php esc_html_e( 'Create Free Account', 'theme-translations' ); ?></button>
      </p>
      <div class="clearfix">
        <?php wp_nonce_field('google-auth-nonce-test', 'google_auth_nonce', true, true); ?>
        <div class="g-signin22" id="google-sign-in"></div>

        <script>

          function renderButton() {
            gapi.signin2.render('google-sign-in', {
              'text' : 'Sign in with google',
              'scope': 'profile email',
              'width': 320,
              'height': 45,
              'longtitle': true,
              'theme': 'Light',
              'onsuccess': onSignInDashboard,
              'onfailure': onFailure
            });
          }
        </script>

        <script src="https://apis.google.com/js/platform.js?onload=renderButton" async defer></script>
      </div>

      <?php $my_account_id = get_option('woocommerce_myaccount_page_id'); ?>
      <br>
			<p class="auth-block__text lg">
         Already have an account? <a href="<?php echo esc_url(get_permalink( $my_account_id ))?>" class="link-blue"> Log In</a>.
      </p>
			<?php do_action( 'woocommerce_register_form_end' ); ?>


       <?php if (isset($_GET['redirect']) && 'checkout' === $_GET['redirect']):
          global $woocommerce;
          $checkout_url = wc_get_checkout_url();
        ?>
        <input type="hidden" name="redirect" value="<?php echo esc_attr( $checkout_url ) ?>">
        <?php else:
           $redirect_url = wc_get_account_endpoint_url( 'orders' );
         ?>
        <input type="hidden" name="redirect" value="<?php echo esc_attr( $redirect_url ) ?>">
       <?php endif ?>
		</form>

<?php endif; ?>
		</div>
	</div>

</div>

<?php do_action( 'woocommerce_after_customer_login_form' ); ?>


<script>

    function onSignInDashboard(googleUser) {

    var profile = googleUser.getBasicProfile();

    var data = {
      action     : 'sign_in_google',
      first_name : profile.getGivenName(),
      last_name  : profile.getFamilyName(),
      email      : profile.getEmail(),
      google_id  : profile.getId(),
      redirect   : '<?php echo isset($_GET['redirect'])? $_GET['redirect'] : 'dashboard' ?>',
      nonce      : jQuery('[name=google_auth_nonce]').val(),
    }



    jQuery.ajax({
      url: '<?php echo admin_url('admin-ajax.php')?>',
      type: 'POST',
      dataType: 'json',
      data: data,
    })

    .done(function(e) {

      if('undefined' !== e.redirect){
        location.href = e.redirect;
      }
    })

    .fail(function() {
    })

    .always(function(e) {
      console.log(e);
    });
  }

  function onFailure(error){
    console.log(error)
  }
</script>


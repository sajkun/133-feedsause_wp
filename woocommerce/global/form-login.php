<?php
/**
 * Login form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( is_user_logged_in() ) {
	return;
}
$my_account_id = get_option('woocommerce_myaccount_page_id');
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
		<p class="auth-block__title">
			<?php esc_html_e( 'Login', 'woocommerce' ); ?>
			<a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( 'Forgot Password?', 'woocommerce' ); ?></a>
		</p>
    <?php do_action('theme_custom_before_login'); ?>
    <form class="woocommerce-form woocommerce-form-login login" method="post" >

    	<?php do_action( 'woocommerce_login_form_start' ); ?>
      <p>
      	<?php if(!is_checkout()): ?>
      	<?php echo ( $message ) ? wpautop( wptexturize( $message ) ) : ''; // @codingStandardsIgnoreLine ?>
      	<?php else: ?>
      		<?php echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) ) );?>
      	<?php endif; ?>
      </p>



    	<div class="clearfix">
    		<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide input-with-icon">
    			<svg class="icon svg-icon-email"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-email"></use> </svg>
     		  <input type="text" class="input-text" name="username" id="username" placeholder="<?php esc_html_e( 'Username or email', 'woocommerce' ); ?>" autocomplete="username" />
    	  </p>
      </div>
    	<div class="clearfix">
    		<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide input-with-icon">
    			<svg class="icon svg-icon-key"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-key"></use> </svg>
    		<input class="input-text" type="password" name="password" id="password" autocomplete="current-password" placeholder="<?php esc_html_e( 'Password', 'woocommerce' ); ?>"/>
    		</p>
    	</div>
    	<div class="clear"></div>

    	<?php do_action( 'woocommerce_login_form' ); ?>

    	<p class="form-row">
    		<?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
    		<button type="submit" class="button auth-block__submit" name="login" value="<?php esc_attr_e( 'Login', 'woocommerce' ); ?>"><?php esc_html_e( 'Login', 'woocommerce' ); ?></button>
    		<input type="hidden" name="redirect" value="<?php echo esc_url( $redirect ) ?>" />

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
      <div class="spacer-h-10"></div>
      <div class="spacer-h-10"></div>
      <?php if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ): ?>
      <p class="auth-block__text lg">
         <?php _e('Don’t have an account','theme-translations');?>?  <a href="<?php echo esc_url(get_permalink($my_account_id))?>?create_account=do<?php if (is_checkout()){ echo '&redirect=checkout';} ?>" class="link-blue"> <?php _e('Sign up for free','theme-translations');?></a>.
      </p>
    	<?php endif; ?>
    	<?php do_action( 'woocommerce_register_form_end' ); ?>
    	<div class="clear"></div>

    	<?php do_action( 'woocommerce_login_form_end' ); ?>

    </form>
  </div>
</div>
</div>
</div>

<script>
    function onSignInDashboard(googleUser) {

    var profile = googleUser.getBasicProfile();

    var data = {
      action     : 'sign_in_google',
      first_name : profile.getGivenName(),
      last_name  : profile.getFamilyName(),
      email      : profile.getEmail(),
      google_id  : profile.getId(),
      redirect   : 'checkout',
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
    });
  }

  function onFailure(error){
    console.log(error)
  }
</script>
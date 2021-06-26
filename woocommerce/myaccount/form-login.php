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

$today = new DateTime();
$addon = '<li>© Feedsauce '.$today->format('Y').'</li>';

$menu = wp_nav_menu( array(
  'theme_location'  => 'menu_login',
  'menu'            => '',
  'container'       => 'nav',
  'container_class' => 'sign-in-menu-holder',
  'container_id'    => '',
  'menu_class'      => 'sign-in-menu',
  'menu_id'         => '',
  'echo'            => false,
  'fallback_cb'     => '__return_empty_string',
  'before'          => '',
  'after'           => '',
  'link_before'     => '',
  'link_after'      => '',
  'items_wrap'      => '<ul id="%1$s" class="%2$s">'.$addon.'%3$s</ul>',
  'depth'           => 1,
) );

if(!$menu){
  $menu = '<nav class="sign-in-menu-holder"> <ul class="sign-in-menu"> '.$addon.'</ul> </nav>';
}
?>
<?php if (empty($_GET['create_account']) || ($_GET['create_account'] != 'do')): ?>
  <div class="container-fluid">
    <div class="row height-100vh white-bg">
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
        <div class="row height-100vh ">
          <div class="valign-center-lg  width-100p">

            <form class="woocommerce-form woocommerce-form-login login" method="post">
              <div class="login-form-holder">
                <div class="spacer-h-40"></div>


                <div class="row back-button-holder">
                  <div class="col-8 valign-center">
                    <div class="spacer-h-lg-45"></div>
                    <a href="javascript:history.go(-1)" class="back-button">
                    <svg class="icon svg-icon-bracket"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-bracket"></use></svg> Back</a>
                  </div>
                  <div class="col-4 valign-center text-right show-mobile">
                    <a href="<?php echo HOME_URL; ?>" class="logo-login-mobile">
                      <img  src="<?php echo THEME_URL?>/images/logo-single.svg" alt="">
                    </a>
                  </div>
                </div>

                <?php do_action('theme_custom_before_login'); ?>
                <?php do_action( 'woocommerce_login_form_start' ); ?>
                <div class="spacer-h-90 spacer-h-lg-70"></div>

                <h2 class="login-title">Sign in</h2>
                <div class="spacer-h-25 spacer-h-lg-60"></div>

                <div class="row">
                  <div class="col-12">
                    <label for="" class="login-label">E-mail</label>
                    <input type="text" class="login-field" name="username" id="username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" placeholder="<?php esc_html_e( 'Username or email address', 'woocommerce' ); ?>" />
                    <div class="spacer-h-20 spacer-h-lg-10"></div>
                  </div>
                </div><!-- row -->

                <div class="row">
                  <div class="col-12">
                    <div class="row">
                      <div class="col-6">
                        <label class="login-label">Password</label>
                      </div>
                      <div class="col-6 text-right">
                        <a class="auth-link" href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( 'Forgot Password?', 'woocommerce' ); ?></a>
                      </div>
                    </div>
                    <input class="login-field" type="password" name="password" id="password" autocomplete="current-password" placeholder="<?php esc_html_e( 'Password', 'woocommerce' ); ?>*"/>
                    <div class="spacer-h-10"></div>
                  </div>
                </div><!-- row -->

                <div class="row">
                  <div class="col-12">
                    <div class="spacer-h-8"></div>
                    <label class="check-holder">
                      <input type="checkbox" name="_stay_signed_week" value="yes">
                      <span class="check-holder__view"></span>
                      Stay signed in for a week
                    </label>
                    <div class="spacer-h-10"></div>
                  </div>
                </div>

                <p class="form-row">
                  <?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
                  <button class="login-button" type="submit" name="login" >
                    <span class="login-button__text">Continue</span>
                    <span class="login-button__icon">
                      <svg class="icon svg-icon-bracket"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-bracket"></use>
                    </span>
                  </button>
                </p>

                <?php wp_nonce_field('google-auth-nonce-test', 'google_auth_nonce', true, true); ?>
                <div class="g-signin2" id="google-sign-in"></div>

                <script>

                  function renderButton() {
                    gapi.signin2.render('google-sign-in', {
                      'text' : 'Login with google',
                      'scope': 'profile email',
                      'width': 320,
                      'height': 53,
                      'longtitle': true,
                      'theme': 'Light',
                      'onsuccess': onSignInDashboard,
                      'onfailure': onFailure
                    });
                  }
                </script>

                <script src="https://apis.google.com/js/platform.js?onload=renderButton" async defer></script>

                <?php if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ): ?>
                <div class="spacer-h-20"></div>
                <p class="login-label text-center text-left-lg">
                   <?php _e('New to Feedsauce','theme-translations');?>?  <a href="?create_account=do" class="auth-link"> <?php _e('Create a free account','theme-translations');?></a>.
                </p>
                <?php endif; ?>

              </div>
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


             <div class="spacer-h-110"></div>
             <div class="spacer-h-xl-90"></div>
          </div>
       </div>
        <?php echo $menu; ?>
      </div>
    </div>
  </div>
<?php endif; ?>

<?php  if ( (get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) && !empty($_GET['create_account']) && ($_GET['create_account'] === 'do')) : ?>
  <?php
    do_action( 'woocommerce_before_customer_login_form' ); ?>
    <div class="container-fluid">


      <div class="row height-100vh white-bg">
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
            <div class="spacer-h-40"></div>

            <div class="row">
              <div class="col-8 valign-center">
                <a href="javascript:history.go(-1)" class="back-button">
                <svg class="icon svg-icon-bracket"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-bracket"></use></svg> Back</a>
              </div>
              <div class="col-4 text-right show-mobile">
                <a href="<?php echo HOME_URL; ?>" class="logo-login-mobile">
                  <img src="<?php echo THEME_URL?>/images/logo-single.svg" alt="">
                </a>
              </div>
            </div>


            <div class="spacer-h-30"></div>

            <h2 class="login-title">Create account</h2>

            <div class="spacer-h-20"></div>
            <?php do_action('theme_custom_before_login'); ?>
            <form class="woocommerce-form woocommerce-form-login login" method="post">
              <?php do_action( 'woocommerce_login_form_start' ); ?>

              <div class="row">
                <div class="col-6">
                  <label for="" class="login-label">First name</label>
                  <input type="text" placeholder="First Name" class="login-field" name="customer_first_name" id="customer_first_name" >
                  <div class="spacer-h-10"></div>
                </div><!-- col-6 -->

                <div class="col-6">
                  <label for="" class="login-label">Last name</label>
                  <input type="text" placeholder="Last Name" class="login-field" placeholder="Last Name" name="customer_last_name" id="customer_last_name">
                  <div class="spacer-h-10"></div>
                </div><!-- col-6 -->
              </div><!-- row -->

              <div class="row">
                <div class="col-12">
                  <label for="" class="login-label">Your Brand</label>
                  <input type="text" class="login-field" name="customer_brand" placeholder="Acme Inc">
                  <div class="spacer-h-10"></div>
                </div>
              </div><!-- row -->

              <div class="row">
                <div class="col-12">
                  <label for="" class="login-label">E-mail</label>

                  <input type="email" placeholder="<?php esc_html_e( 'Email address', 'woocommerce' ); ?>" class="login-field" name="email" id="reg_email" autocomplete="email" value="<?php echo ( ! empty( $_POST['email'] ) ) ? esc_attr( wp_unslash( $_POST['email'] ) ) : ''; ?>"  placeholder="joe.bloggs@acme.com" />
                  <div class="spacer-h-10"></div>
                </div>
              </div><!-- row -->

              <?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>
                <div class="row">
                  <div class="col-12">
                    <label for="" class="login-label">Password</label>
                    <input type="password" class="login-field" name="password" id="reg_password" autocomplete="new-password" placeholder="<?php esc_html_e( 'Password', 'woocommerce' ); ?>"/>
                    <div class="spacer-h-15"></div>
                  </div>
                </div><!-- row -->
              <?php endif; ?>

              <?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>

              <button class="login-button" type="submit" name="register" >
                <span class="login-button__text">Create Account</span>
                <span class="login-button__icon">
                  <svg class="icon svg-icon-bracket"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-bracket"></use>
                </span>
              </button>

              <div class="spacer-h-15"></div>
              <?php
                if(isset($_GET['product_id'])){
                  $constructor_url = get_permalink(get_option('theme_page_constructor'));
                  $product_url = $constructor_url.'?product_id='.$_GET['product_id'].'&add_to_cart='.$_GET['product_id'];
                }
                $redirect = !isset($_GET['product_id'])? esc_url(wc_get_account_endpoint_url( 'orders' )) : $product_url;
              ?>
              <input type="hidden" name="redirect" value="<?php echo $redirect;  ?>">

            </form>

            <?php wp_nonce_field('google-auth-nonce-test', 'google_auth_nonce', true, true); ?>
            <div class="g-signin2" id="google-sign-in"></div>

            <?php $my_account_id = get_option('woocommerce_myaccount_page_id'); ?>
            <div class="spacer-h-20"></div>
            <div class="spacer-h-4"></div>
            <p class="login-label text-center text-left-lg">
               Already have an account? <a href="<?php echo esc_url(get_permalink( $my_account_id ))?>" class="link-blue"> Sign In</a>.
            </p>
            <?php do_action( 'woocommerce_register_form_end' ); ?>

            <script>

              function renderButton2() {
                gapi.signin2.render('google-sign-in', {
                  'text' : 'Sign in with google',
                  'scope': 'profile email',
                  'width': 320,
                  'height': 52,
                  'longtitle': true,
                  'theme': 'Light',
                  'onsuccess': onSignInDashboard,
                  'onfailure': onFailure
                });
              }

            </script>

            <script src="https://apis.google.com/js/platform.js?onload=renderButton2" async defer></script>
          </div>
          <div class="spacer-h-90"></div>
          <?php echo $menu; ?>
        </div>

      </div><!-- row -->
    </div><!-- container-fluid -->
<?php endif; ?>

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


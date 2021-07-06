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

do_action( 'woocommerce_before_edit_account_form' );

$user_id = get_current_user_id();
$gravatar = get_avatar_url($user_id)?: THEME_URL.'/images/svg/men.svg';
$first_name = get_user_meta($user_id, 'first_name', true);
$last_name = get_user_meta($user_id, 'last_name', true);
$customer_brand = get_user_meta($user_id, '_customer_brand', true);
$user = get_user_by('ID',$user_id);

clog($user);

$addresses = get_user_meta($user_id, '_free_collection_address', true);
$addresses = $addresses?: array();
$addresses = array_unique($addresses);

 ?>

<div class="container">
  <div class="spacer-h-40"></div>

  <div class="my-order__filter">
    <div class="decoration"></div>
    <div class="decoration pre" ></div>
    <a data-href="#details" href="#details"  class="my-order__filter-item-2 active trigger-show">My Details</a>
    <a data-href="#password" href="#password"  class="my-order__filter-item-2  trigger-show">Change Password</a>
    <a data-href="#address"  href="#address" class="my-order__filter-item-2  trigger-show">Saved Addresses</a>
  </div>
  <?php do_action( 'woocommerce_edit_account_form_start' ); ?>

  <div class="edit-profile-page" id="details" <?php echo 'style="display: block;"';?>>
    <div class="spacer-h-45"></div>
    <div class="gravatar-lg"><img src="<?php echo $gravatar; ?>" alt=""></div>
    <div class="spacer-h-25"></div>

    <form action="javascript:void(0)" id="my-details" class="edit-profile-form">
      <div class="row gutters-5">
        <div class="col-6">
          <label for="first_name" class="input-field-label">First name</label>
          <input type="text" class="input-field" name="first_name" id="first_name" value="<?php echo $first_name?: '';?>">
          <div class="spacer-h-10"></div>
        </div>
        <div class="col-6">
          <label for="last_name" class="input-field-label">Last name</label>
          <input type="text" class="input-field" name="last_name" id="last_name" value="<?php echo $last_name?: '';?>">
          <div class="spacer-h-10"></div>
        </div>
      </div>

      <div class="row">
        <div class="col-12">
          <label for="customer_brand" class="input-field-label">Your Brand</label>
          <input type="text" class="input-field" name="_customer_brand" id="customer_brand" value="<?php echo $customer_brand?:'';?>">
          <div class="spacer-h-10"></div>
        </div>
      </div>

      <div class="row">
        <div class="col-12">
          <label class="input-field-label">E-mail</label>
          <input type="email" class="input-field" readonly value="<?php echo $user->data->user_email;?>">
          <div class="spacer-h-25"></div>
        </div>
      </div>

      <div class="row">
        <div class="col-12">
          <button type="submit" class="edit-profile-page__submit not-active">
            Save Changes

            <span class="svg-holder">
              <img src="<?php echo THEME_URL; ?>/images/spinner_white.gif" alt="">
              <svg class="icon svg-icon-tick"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-tick"></use> </svg>
            </span>
          </button>
        </div>
      </div>
    </form>

  </div>
  <div class="edit-profile-page" id="password">
       <div class="spacer-h-25"></div>

    <form action="javascript:void(0)" id="my-password" class="edit-profile-form">
      <div class="row">
        <div class="col-12">
          <label for="password_current" class="input-field-label">Current Password</label>
          <input type="password" class="input-field" name="password_current" id="password_current">
          <div class="spacer-h-10"></div>
        </div>
      </div>

      <div class="row">
        <div class="col-12">
          <label for="password_new"class="input-field-label">New Password</label>
          <input type="password" class="input-field" name="password_new" id="password_new">
          <div class="spacer-h-25"></div>
        </div>
      </div>

      <div class="row">
        <div class="col-12">
          <button type="submit" class="edit-profile-page__submit not-active">
            Save Changes
            <span class="svg-holder">
              <img src="<?php echo THEME_URL; ?>/images/spinner_white.gif" alt="">
              <svg class="icon svg-icon-tick"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-tick"></use> </svg>
            </span>
          </button>
        </div>
      </div>
    </form>

  </div>
  <div class="edit-profile-page" id="address">
    <div class="spacer-h-25"></div>
    <form action="javascript:void(0)" id="my-adresses" class="edit-profile-form">

      <?php
      $countries = array(
        'United Kingdom',
      );
       foreach ($addresses as $key => $addr):
          $addr = json_decode($addr);
        ?>
        <span class="studio-content__label">
          Collection Address #<?php echo $key + 1?>
        </span>
        <div class="row gutters-5">
          <div class="col-6">
            <label for="first_name[<?php echo $key?>]" class="input-field-label">First name</label>
            <input type="text" class="input-field" name="first_name[<?php echo $key?>]" value="<?php echo isset($addr->first_name)? $addr->first_name : ''  ?>">
            <div class="spacer-h-10"></div>
          </div>
          <div class="col-6">
            <label for="last_name[<?php echo $key?>]" class="input-field-label">Last name</label>
            <input type="text" class="input-field" name="last_name[<?php echo $key?>]" value="<?php echo isset($addr->last_name)? $addr->last_name : ''  ?>">
            <div class="spacer-h-10"></div>
          </div>
        </div>

        <div class="row">
          <div class="col-12">
            <label for="country[<?php echo $key?>]" class="input-field-label">Country</label>

            <div class="select-imitation fullwidth">
              <select class="hidden" name="country[<?php echo $key?>]">
                <?php foreach ($countries as $c): ?>
                  <option value="<?php echo $c; ?>" <?php echo isset($addr->country) && $addr->country == $c? 'selected="selected"' : '';  ?> ><?php echo $c; ?></option>
                <?php endforeach ?>
              </select>
              <span class="select-imitation__view no-arrow" onclick="imitate_select_expand(this)" ><?php echo $addr->country; ?></span>
              <span onclick="imitate_select_expand(this)" class="select-imitation__arrow ">
                <svg class="icon svg-icon-bracket"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-bracket"></use></svg>
              </span>
              <div class="select-imitation__dropdown">
                <ul class="select-imitation__list">
                  <?php foreach ($countries as $c): ?>
                  <li class="" onclick="imitate_select_option(this, '<?php echo $c; ?>', '<?php echo $c; ?>' )"><span class="element"><?php echo $c; ?> </span></li>
                  <?php endforeach ?>
                </ul>
              </div>
            </div>
            <div class="spacer-h-10"></div>
          </div>
        </div>

        <div class="row">
          <div class="col-12">
            <label for="line_1[<?php echo $key?>]" class="input-field-label">Address line 1</label>
            <input type="text" class="input-field" name="line_1[<?php echo $key?>]" id="line_1[<?php echo $key?>]" value="<?php echo isset($addr->line_1)? $addr->line_1 : ''  ?>">
            <div class="spacer-h-10"></div>
          </div>
        </div>

        <div class="row">
          <div class="col-12">
            <label for="line_2[<?php echo $key?>]" class="input-field-label">Address line 2</label>
            <input type="text" class="input-field" name="line_2[<?php echo $key?>]" id="line_2[<?php echo $key?>]" value="<?php echo isset($addr->line_2)? $addr->line_2 : ''  ?>">
            <div class="spacer-h-10"></div>
          </div>
        </div>

        <div class="row gutters-5">
          <div class="col-6">
            <label for="city[<?php echo $key?>]" class="input-field-label">Town or City</label>
            <input type="text" class="input-field" name="city[<?php echo $key?>]" id="city[<?php echo $key?>]" value="<?php echo isset($addr->city)? $addr->city : ''  ?>">
            <div class="spacer-h-25"></div>
          </div>
          <div class="col-6">
            <label for="zip[<?php echo $key?>]" class="input-field-label">Postal Code</label>
            <input type="text" class="input-field" name="zip[<?php echo $key?>]" id="zip[<?php echo $key?>]" value="<?php echo isset($addr->zip)? $addr->zip : ''  ?>">
            <div class="spacer-h-25"></div>
          </div>
        </div>
      <?php endforeach ?>

        <div class="row">
          <div class="col-12">
            <button type="submit" class="edit-profile-page__submit not-active">
              Save Changes

              <span class="svg-holder">
                <img src="<?php echo THEME_URL; ?>/images/spinner_white.gif" alt="">
                <svg class="icon svg-icon-tick"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-tick"></use> </svg>
              </span>
            </button>
          </div>
        </div>
    </form>

  </div>

  <?php do_action( 'woocommerce_edit_account_form' ); ?>


  <?php wp_nonce_field( 'save_account_details', 'save-account-details-nonce' ); ?>
  <?php do_action( 'woocommerce_edit_account_form_end' ); ?>

  <?php do_action( 'woocommerce_after_edit_account_form' ); ?>

</div><!-- container -->
<?php
/**
 * My Account navigation
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/navigation.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

do_action( 'woocommerce_before_account_navigation' );

$myaccount_menu = wc_get_account_menu_items();

$menu_items     = array(
  'orders',
  'edit-account',
  'edit-address/billing',
  'customer-logout',
);
?>
	<ul class="">
		<?php foreach ( $menu_items as $endpoint ) : ?>
			<li class="menu-item <?php echo wc_get_account_menu_item_classes( $endpoint ); ?>">
				<a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>"  <?php echo $endpoint === 'customer-logout' ? 'onclick="signOut(event, this)"' : ''; ?>><?php echo esc_html( $myaccount_menu[ $endpoint ]  ); ?></a>
			</li>
		<?php endforeach; ?>
	</ul>


<?php do_action( 'woocommerce_after_account_navigation' ); ?>

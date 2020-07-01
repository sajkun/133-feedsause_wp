<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "site-content" div.
 */

do_action('start_page');
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <?php   wp_head(); ?>
  <title><?php wp_title(' | ', 'echo', 'right'); ?></title>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5, user-scalable=yes">
  <meta name="google-signin-client_id" content="<?php echo get_google_client_id(); ?>">

  <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
  <link rel="dns-prefetch" href="//ajax.googleapis.com">
  <link rel="dns-prefetch" href="//fonts.googleapis.com">
  <link rel="dns-prefetch" href="//www.google-analytics.com">

  <?php
    global $wp;
   ?>

  <link rel="alternate" media="handheld" href="<?php echo home_url( $wp->request ); ?>" />


  <?php
   do_action('do_theme_after_head'); ?>
</head>

<?php
add_filter( 'body_class', function( $classes ) {
  return array_merge( $classes, array( 'page' ) );
} );

if (theme_construct_page::is_page_type('woo-checkout')) {
  $options = get_theme_checkout_content();

  if('regular' === $options['type']){
    add_filter( 'body_class', function( $classes ) {
      return array_merge( $classes, array( 'white' ) );
    } );
  }
}

if(function_exists('is_cart') && is_cart()){
    add_filter( 'body_class', function( $classes ) {
      return array_merge( $classes, array( 'white' ) );
    } );
}
?>
<body  <?php body_class(); ?>>




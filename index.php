<?php
/**
 * The main template file
 *
 * @package theme/templates
 *
 * @since v1.0
 */

get_header();
$data = get_queried_object();

?>

<div class="site-container <?php echo apply_filters('theme_site_container_styles', $data); ?>" id="site-body">
  <?php
    do_action('do_theme_before_header');
    do_action('do_theme_header');
    do_action('do_theme_after_header');
    $class = theme_construct_page::is_page_type( 'new-styles' )? 'site-content' : 'site-inner';
    $class = ( is_checkout() && !empty( is_wc_endpoint_url('order-received') ) )? '' : $class;
  ?>
    <main class="<?php echo $class; ?>">
  <?php
    do_action('do_theme_before_content');
    do_action('do_theme_content');
    do_action('do_theme_after_content');
  ?>
  </main>
 <?php
    do_action('do_theme_before_footer');
    do_action('do_theme_footer');
    do_action('do_theme_after_footer');
  ?>
</div>

<?php
 ?>

<?php get_footer(); ?>

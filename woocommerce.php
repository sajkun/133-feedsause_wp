<?php
/**
 * The woocommerce template file
 *
 * @package theme/templates
 *
 * @since v1.0
 */

get_header();
$data = get_queried_object();
?>
<div class="site-container <?php echo apply_filters('theme_site_container_styles', $data ); ?>" id="site-body">
  <?php
    do_action('do_theme_before_header');
    do_action('do_theme_header');
    do_action('do_theme_after_header');
    $class = (theme_construct_page::is_page_type('woo-product'))? 'white' : '';
    printf('<div class="spacer-h-40 %s"></div>' , $class);
?>
    <main class="site-inner">
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
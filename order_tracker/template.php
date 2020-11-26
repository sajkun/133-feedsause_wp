<?php
if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}

/**
 * The main tracker template file
 *
 * @package theme/templates
 *
 * @since v5.0
 */

get_header('tracker');

$data = get_queried_object();

?>
<div class="site-container <?php echo apply_filters('theme_site_container_styles', $data); ?>" id="site-body">
  <?php
    do_action('do_tracker_before_header');
    do_action('do_tracker_header');
    do_action('do_tracker_after_header');
  ?>
    <main class="site-inner">
 <?php
    do_action('do_tracker_before_content');
    do_action('do_tracker_content');
    do_action('do_tracker_after_content');
  ?>
  </main>
 <?php
    do_action('do_tracker_before_footer');
    do_action('do_tracker_footer');
    do_action('do_tracker_after_footer');
  ?>
</div>

<?php
 ?>

<?php get_footer('tracker'); ?>
<footer class="site-footer
<?php if (get_queried_object_id() == (int)get_option('theme_page_constructor') && !isset($_GET['no_reload']) && empty( is_wc_endpoint_url('order-received') ) ): ?>
  visuallyhidden
<?php endif ?>
" >
<div class="container">
  <img src="<?php echo THEME_URL; ?>/images/feed-black.png" alt="">
  <span class="copyrights">© 2021</span>
  <?php echo $main_menu; ?>
</div>

<div class="spacer-h-40"></div>
</footer>
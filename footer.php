<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the "site-content" div and all content after.
 *
 */
?>

<?php if (get_current_user_id() >0): ?>

<script>
var auth2; // The Sign-In object.

  function signOut(event, obj) {
    var instance = gapi.auth2.getAuthInstance();
    instance.signOut();
  }

  var initGapi = function(){
    gapi.load('auth2', initSigninV2);
  }

  var initSigninV2 = function() {
   auth2 = gapi.auth2.init({
      client_id: '<?php echo get_google_client_id()?>',
      scope: 'profile'
  });
}
</script>
<script src="https://apis.google.com/js/platform.js?onload=initGapi" async defer></script>
<?php endif ?>
<style><?php
   global $footer_inline_style;
   echo $footer_inline_style;
   ?></style>
<?php wp_footer(); ?>
<?php
  do_action('finish_page');
 ?>
 <div class="video-popup-wrapper">
   <div class="inner">
      <i class="icon-close">×</i>
     <div class="video-block"></div>
   </div>
 </div>
</body>
</html>


<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the "site-content" div and all content after.
 *
 */
?>

<?php if (get_current_user_id() >0 && function_exists('get_google_client_id')): ?>

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
 <?php if(!theme_construct_page::is_page_type( 'new-styles' )): ?>
   <div class="video-popup-wrapper">
     <div class="inner">
        <i class="icon-close">×</i>
       <div class="video-block"></div>
     </div>
   </div>
 <?php endif ?>
</body>
<?php if (get_queried_object_id() == (int)get_option('theme_page_constructor') && !isset($_GET['no_reload'])):?>
<script>
document.onreadystatechange = function(e) {
  if(document.readyState=="interactive")
  {
    var all = document.getElementsByTagName("*");
    for (var i=0, max=all.length; i < max; i++)
    {
      set_ele(all[i]);
    }
  }
}

function check_element(ele)
{
  var all = document.getElementsByTagName("div");
  var totalele=all.length;
  var per_inc=100/all.length;

  if(jQuery(ele).on('load'))
  {
    var prog_width= per_inc + Number(document.getElementById("progress_width").value);

    document.getElementById("progress_width").value=prog_width;


    jQuery("#bar1").animate({width:prog_width+"%"},1,function(){
      document.getElementById("load-statuses").classList.add('width-'+parseInt(prog_width.toFixed(0)))
      if(document.getElementById("bar1").style.width=="100%")
      {
        //trigger action

        jQuery('.load-page').addClass('hidden');
        jQuery('.site-header').removeClass('visuallyhidden');
        jQuery('.site-container').removeClass('contrast');
        jQuery('.site-footer').removeClass('visuallyhidden');
        jQuery('#studio-content').removeClass('hidden');
        jQuery('#studio-content').removeClass('visuallyhidden');
      }
    });
  }

  else
  {
    set_ele(ele);
  }
}

function set_ele(set_element)
{
  check_element(set_element);
}
  </script>
<?php endif ?>
</html>


<?php
 global $wp;
?>

<div class="spacer-h-md-80 spacer-h-30"></div>
<footer class="site-footer <?php if(is_account_page() && is_user_logged_in() && !isset($wp->query_vars[ 'gallery']) ): echo 'light'; endif;?> ">
     <div class="container-lg">
       <div class="row">
         <div class="col-lg-10 offset-lg-1">
           <div class="row">
             <div class="col-md-3">
               <div class="footer-menu-holder">
                 <a href="<?php echo HOME_URL; ?>" class="footer-logo"><img src="<?php echo $custom_logo_url; ?>" alt=""></a>
                 <div class="spacer-h-20"></div>
                 <a href="tel:+44 (0)20 8187 5677" class="site-phone"><span class="code">+44</span> (0)20 8187 5677</a>

                 <div class="working-hours">
                   <span class="working-hours__marker"></span>
                   <span class="working-hours__text">Mon-Fri: 9am-5pm</span>
                 </div>
                 <div class="spacer-h-20"></div>
                 <ul class="footer-menu visible">
                   <li class="menu-item"><a href=""><i class="icon"> <svg class="icon svg-icon-instagram"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-instagram"></use> </svg></i>Instagram </a></li>
                   <li class="menu-item"><a href=""><i class="icon"> <svg class="icon svg-icon-twitter"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-twitter"></use> </svg></i>Twitter</a></li>
                   <li class="menu-item"><a href=""><i class="icon"> <img src="<?php echo THEME_URL; ?>/images/trust-star.png" alt=""></i>Trustpilot</a></li>
                 </ul>

                 <div class="spacer-h-30 spacer-h-md-0"></div>
               </div>
             </div><!-- col-md-3 -->

              <?php if (is_active_sidebar('new_footer_1')): ?>
             <div class="col-md-3">
               <div class="footer-menu-holder">
                 <?php dynamic_sidebar('new_footer_1'); ?>
               </div>
             </div><!-- col-md-3 -->
           <?php endif;?>
              <?php if (is_active_sidebar('new_footer_2')): ?>
             <div class="col-md-3">
               <div class="footer-menu-holder">
                 <?php dynamic_sidebar('new_footer_2'); ?>
               </div>
             </div><!-- col-md-3 -->
           <?php endif;?>
              <?php if (is_active_sidebar('new_footer_3')): ?>
             <div class="col-md-3">
               <div class="footer-menu-holder">
                 <?php dynamic_sidebar('new_footer_3'); ?>
               </div>
             </div><!-- col-md-3 -->
           <?php endif;?>
           </div>


           <div class="spacer-h-20 spacer-h-lg-80"></div>
           <div class="copyrights"><?php echo $copyrights; ?></div>
           <div class="spacer-h-20 spacer-h-lg-80"></div>
         </div>
       </div>
     </div>
   </footer>
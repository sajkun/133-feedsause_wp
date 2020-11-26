<!DOCTYPE html>
<html lang="en">
 <head>
   <title>DUH tracker</title>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=1200, user-scalable=yes">

   <link rel="stylesheet" href="<?php echo THEME_URL ?>/order_tracker/assets/libs/datepicker/daterangepicker.css">
   <link rel="stylesheet" href="<?php echo THEME_URL ?>/order_tracker/assets/libs/datetimepicker/build/jquery.datetimepicker.min.css">
   <link rel="stylesheet" href="<?php echo THEME_URL ?>/order_tracker/assets/css/main.min.css">
   <script>
     (function(){
       function addFont() {
           var style = document.createElement('style');
           style.rel = 'stylesheet';
           document.head.appendChild(style);
           style.textContent = localStorage.fonts_174_1;
       }

       try {
           if (localStorage.fonts_174_1) {
               // The font is in localStorage, we can load it directly
               addFont();
           } else {
               // We have to first load the font file asynchronously
               var request = new XMLHttpRequest();
               request.open('GET', '<?php echo THEME_URL ?>/order_tracker/assets/fonts/fonts.css', true);

               request.onload = function() {
                   if (request.status >= 200 && request.status < 400) {
                       // We save the file in localStorage
                       text = request.responseText;

                       localStorage.fonts_174_1 = text;

                       // ... and load the font
                       addFont();
                   }
               }

               request.send();
           }
       } catch(ex) {
       }
     }());
   </script>

   <script>
         ( function( window, document )
       {
         'use strict';

         var file     = '<?php echo THEME_URL ?>/order_tracker/assets/svg_sprite/symbol_sprite.html',
           revision = 1;

         if( !document.createElementNS || !document.createElementNS( 'http://www.w3.org/2000/svg', 'svg' ).createSVGRect )
           return true;

         var isLocalStorage = 'localStorage' in window && window[ 'localStorage' ] !== null,
           request,
           data,
           insertIT = function()
           {
             document.body.insertAdjacentHTML( 'afterbegin', data );
           },
           insert = function()
           {
             if( document.body ) insertIT();
             else document.addEventListener( 'DOMContentLoaded', insertIT );
           };

         if( isLocalStorage && localStorage.getItem( 'inlineSVGrev_project_151_2' ) == revision )
         {
           data = localStorage.getItem( 'inlineSVGdata_project_151_2' );
           if( data )
           {
             insert();
             return true;
           }
         }

         try
         {
           request = new XMLHttpRequest();
           request.open( 'GET', file, true );
           request.onload = function()
           {
             if( request.status >= 200 && request.status < 400 )
             {
               data = request.responseText;
               insert();
               if( isLocalStorage )
               {
                 localStorage.setItem( 'inlineSVGdata_project_174_1',  data );
                 localStorage.setItem( 'inlineSVGrev_project_174_1',   revision );
               }
             }
           }
           request.send();
         }
         catch( e ){}

       }( window, document ) );
   </script>

   <?php do_action('before_scripts'); ?>

   <script
   src="https://code.jquery.com/jquery-3.5.1.min.js"
   integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
   crossorigin="anonymous"></script>
   <script src="<?php echo THEME_URL ?>/order_tracker/assets/libs/datepicker/moment.min.js"></script>
   <script src="<?php echo THEME_URL ?>/order_tracker/assets/libs/datepicker/daterangepicker.js"></script>
   <script src="<?php echo THEME_URL ?>/order_tracker/assets/libs/datetimepicker/build/jquery.datetimepicker.full.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>

    <script src="//cdn.jsdelivr.net/npm/sortablejs@1.8.4/Sortable.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/Vue.Draggable/2.20.0/vuedraggable.umd.min.js"></script>

   <script defer src="<?php echo THEME_URL ?>/order_tracker/assets/script/main.js"></script>
 </head>
 <body  id="site-body" class="not-ready">
  <div class="site-container">
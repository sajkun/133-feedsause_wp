console.log('cusotmizer script loaded v4');
jQuery( document ).ready( function( $ ) {


  wp.customize( 'theme_footer_facebook', function( setting ) {
    setting.bind( function( value ) {
      if(value.length > 0){
        html = '<a href="#" class="socials__icons"><svg class="icon svg-icon-fb"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-fb"></use> </svg></a>';
        if(!jQuery('.site-footer .socials').find('.svg-icon-fb').length){
          jQuery('.site-footer .socials').append(html);
        }

      }else{
        jQuery('.site-footer .socials').find('.svg-icon-fb').closest('.socials__icons').remove();
      }
    })
  })

  wp.customize( 'theme_footer_twitter', function( setting ) {
    setting.bind( function( value ) {
      if(value.length > 0){
        html = '<a href="#" class="socials__icons"><svg class="icon svg-icon-twitter"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-twitter"></use> </svg></a>';

        if(!jQuery('.site-footer .socials').find('.svg-icon-twitter').length){
          jQuery('.site-footer .socials').append(html);
        }

      }else{
        jQuery('.site-footer .socials').find('.svg-icon-twitter').closest('.socials__icons').remove();
      }
    })
  })

  wp.customize( 'theme_footer_instagram', function( setting ) {
    setting.bind( function( value ) {
      if(value.length > 0){
        html = '<a href="#" class="socials__icons"><svg class="icon svg-icon-instagram"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-instagram"></use> </svg></a>'
        ;
        if(!jQuery('.site-footer .socials').find('.svg-icon-instagram').length){
          jQuery('.site-footer .socials').prepend(html);
        }
      }else{
        jQuery('.site-footer .socials').find('.svg-icon-instagram').closest('.socials__icons').remove();
      }
    })
  })

  wp.customize('home_moto_marked', function (setting){
    setting.bind( function( value ) {
      var stockpile = wp.customize( 'home_moto' ).get();
      var needle    = value;
      var replace   = '<span class="marked marked_blue">'+needle+'</span>';

      var new_text = stockpile.replace(needle, replace);


      jQuery('.promo-text .text').html(new_text);
    })
  })

  wp.customize('cta_moto_marked', function (setting){
    setting.bind( function( value ) {
      var stockpile = wp.customize( 'cta_title' ).get();
      var needle    = value;
      var replace   = '<span class="marked marked_blue">'+needle+'</span>';

      var new_text = stockpile.replace(needle, replace);


      jQuery('.cta-recipe .section-title').html(new_text);
    })
  })

  wp.customize('pricing_title_marked', function (setting){
    setting.bind( function( value ) {
      var stockpile = wp.customize( 'pricing_title' ).get();
      var needle    = value;
      var replace   = '<span class="marked marked_blue">'+needle+'</span>';

      var new_text = stockpile.replace(needle, replace);


      jQuery('.pricing__moto').html(new_text);
    })
  })

  wp.customize('support_title_marked', function (setting){
    setting.bind( function( value ) {
      var stockpile = wp.customize( 'pricing_title' ).get();
      var needle    = value;
      var replace   = '<span class="marked marked_blue">'+needle+'</span>';

      var new_text = stockpile.replace(needle, replace);


      jQuery('.support-section .page-title').html(new_text);
    })
  })

  wp.customize('theme_woo_shop_title_marked', function (setting){
    setting.bind( function( value ) {
      var stockpile = wp.customize( 'theme_woo_shop_title' ).get();
      var needle    = value;
      var replace   = '<span class="marked marked_blue">'+needle+'</span>';

      var new_text = stockpile.replace(needle, replace);


      jQuery('.theme-shop-header .page-title').html(new_text);
    })
  })


});

( function( $ ) {
  wp.customize.bind('ready', function(){
    var $form_type =  wp.customize('theme_page_support_form_type').get();

      wp.customize( 'theme_page_support_form_wpf', function( setting ) {
        wp.customize.control( 'theme_page_support_form_wpf', function( control ) {
          var visibility = function() {
            if('wpf' === wp.customize('theme_page_support_form_type').get()){
              control.container.slideDown( 180 );
            }else{
              control.container.slideUp( 180 );
            }
          };
          visibility();
          // setting.bind( visibility );
        });
      })

      wp.customize( 'theme_page_support_form', function( setting ) {
        wp.customize.control( 'theme_page_support_form', function( control ) {
          var visibility = function() {
            if('cf7' === wp.customize('theme_page_support_form_type').get()){
              control.container.slideDown( 180 );
            }else{
              control.container.slideUp( 180 );
            }
          };
          visibility();
          // setting.bind( visibility );
        });
      })


    wp.customize.control('theme_page_support_form_type', function (control) {
      /**
       * Run function on setting change of control.
       */
      control.setting.bind(function (value) {
        switch (value) {
          /**
           * The select was switched to the hide option.
           */
          case 'wpf':
            /**
             * Deactivate the conditional control.
             */
            wp.customize.control('theme_page_support_form', function( control ) {
              control.container.slideUp( 180 );
            })
            wp.customize.control('theme_page_support_form_wpf', function( control ) {
              control.container.slideDown( 180 );
            })
            break;
          /**
           * The select was switched to »show«.
           */
          case 'cf7':
            /**
             * Activate the conditional control.
             */
            wp.customize.control('theme_page_support_form', function( control ) {
              control.container.slideDown( 180 );
            })
            wp.customize.control('theme_page_support_form_wpf', function( control ) {
              control.container.slideUp( 180 );
            })
            break;
        }
      });
    });
  });
} )( jQuery );


function str_replace_s(needle, highstack){
  var template = highstack;
    for(key in needle){
    var exp = new RegExp("\\{" + key + "\\}", "gi");
      template = template.replace(exp, function(str){
        value = needle[key];
        return value;
      });
    }
    return template;
}



